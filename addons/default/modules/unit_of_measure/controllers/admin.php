<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Blog\Controllers
 */
class Admin extends Admin_Controller
{
	/**
	 * The current active section
	 *
	 * @var string
	 */
	protected $section = 'unit_of_measure';

	/**
	 * Array that contains the validation rules
	 *
	 * @var array
	 */
	 
	//~ CURRENT FIELDS FOR CATEGORY (3): cat_name, description, stocktype, category code
	protected $validation_rules = array(
		array(
			'field' => 'unit_name',
			'label' => 'lang:category:cat_name_label',
			'rules' => 'trim|required|htmlspecialchars|max_length[50]'
		)
		
	);

	/**
	 * The constructor
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('unit_of_measure_m', 'blog_unit_of_measure_m'));
		$this->lang->load('unit_of_measure');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);

	}

	/**
	 * Index method, lists all unit_of_measure
	 * 
	 * @return void
	 */
	public function index()
	{
		$this->pyrocache->delete_all('modules_m');
		
		// Create pagination links
		$total_rows = $this->unit_of_measure_m->count_all();  // count_all() directly count rows of db declared in model
		$pagination = create_pagination('admin/unit_of_measure/index', $total_rows, NULL, 4);
			
		// Using this data, get the relevant results
		$unit_of_measure = $this->unit_of_measure_m->limit($pagination['limit'])->get_all(); //get_all() directly get all rows od db declared in model
		$this->template
			->title($this->module_details['name'], lang('cat_list_title'))
			->set('unit_of_measure', $unit_of_measure)
			->set('pagination', $pagination)
			->set('unit_of_measure_m', $this->unit_of_measure_m)
			->build('admin/unit_of_measure/index');

		
	}

	/**
	 * Create new category
	 *
	 * @return void
	 */
		public function create()
		{
		$this->form_validation->set_rules('unit_name', 'lang:category:cat_name_label', 'trim|required|htmlspecialchars|max_length[50]|callback__check_desc['.$this->input->post('unit_name').']');
			
		// Validate the data
		if ($this->form_validation->run())
		{
			if ($id = $this->unit_of_measure_m->insert($_POST))
			{
				
				// Fire an event. A new blog category has been created.
				//	Events::trigger('blog_category_created', $id);

				$this->session->set_flashdata('success', sprintf( lang('category:cat_add_success'), $this->input->post('id')) );
			}
			else
			{
				$this->session->set_flashdata('error', lang('category:cat_add_error'));
			}
			
			redirect('admin/unit_of_measure');
		}

		$category = new stdClass();
				
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$category->{$rule['field']} = set_value($rule['field']);
		}
		
		$this->template
			->title($this->module_details['name'], lang('cat_create_title'))
			->set('category', $category)
			->build('admin/unit_of_measure/form');	
		}
	/**
	 * Edit blog post
	 *
	 * 
	 * @param int $id the ID of the blog post to edit
	 * @return void
	 */
	public function edit($id = 0)
	{
		$id OR redirect('admin/unit_of_measure');

		// Get the unit
		$category = $this->unit_of_measure_m->get($id);
		
		// ID specified?
		$category or redirect('admin/blog/unit_of_measure/index');

		$this->form_validation->set_rules('unit_name', 'lang:category:cat_name_label', 'trim|required|htmlspecialchars|max_length[50]|callback__check_otherdesc['.$this->input->post('unit_name').','.$id.']');
	
		// Validate the results
		if ($this->form_validation->run())
		{		
			
			$INPUT = array(
				'unit_name' 			=> $this->input->post('unit_name')
			);
			
			$this->unit_of_measure_m->update($id, $INPUT)
				? $this->session->set_flashdata('success', sprintf( lang('category:cat_edit_success'), $this->input->post('cat_name')) )
				: $this->session->set_flashdata('error', lang('cat_edit_error'));
			
			// Fire an event. A blog category is being updated.
			Events::trigger('blog_category_updated', $id);
			
			redirect('admin/unit_of_measure/index');
		}
		//~ print_r($this->validation_rules);
		//~ die();
		// Loop through each rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== FALSE)
			{
				$category->{$rule['field']} = $this->input->post($rule['field']);
			}
		}
		$this->template
			->title($this->module_details['name'], sprintf(lang('cat_edit_title'), $category->id))
			->set('category', $category)
			->build('admin/unit_of_measure/form');
	}

	/**
	 * Preview blog post
	 * 
	 * @param int $id the ID of the blog post to preview
	 * @return void
	 */
	public function preview($id = 0)
	{
		$post = $this->blog_m->get($id);

		$this->template
				->set_layout('modal', 'admin')
				->set('post', $post)
				->build('admin/preview');
	}
	
	public function submit_requisition($id = 0)
	{
	
	}

	/**
	 * Helper method to determine what to do with selected items from form post
	 * 
	 * @return void
	 */
	public function action()
	{
		switch ($this->input->post('btnAction'))
		{
			case 'publish':
				$this->publish();
			break;
			
			case 'delete':
				$this->delete();
			break;
			
			default:
				redirect('admin/blog');
			break;
		}
	}

	/**
	 * Publish blog post
	 * 
	 * @param int $id the ID of the blog post to make public
	 * @return void
	 */
	public function publish($id = 0)
	{
		role_or_die('blog', 'put_live');

		// Publish one
		$ids = ($id) ? array($id) : $this->input->post('action_to');

		if ( ! empty($ids))
		{
			// Go through the array of slugs to publish
			$post_titles = array();
			foreach ($ids as $id)
			{
				// Get the current page so we can grab the id too
				if ($post = $this->blog_m->get($id))
				{
					$this->blog_m->publish($id);

					// Wipe cache for this model, the content has changed
					$this->pyrocache->delete('blog_m');
					$post_titles[] = $post->title;
				}
			}
		}

		// Some posts have been published
		if ( ! empty($post_titles))
		{
			// Only publishing one post
			if (count($post_titles) == 1)
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('blog:publish_success'), $post_titles[0]));
			}
			// Publishing multiple posts
			else
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('blog:mass_publish_success'), implode('", "', $post_titles)));
			}
		}
		// For some reason, none of them were published
		else
		{
			$this->session->set_flashdata('notice', $this->lang->line('blog:publish_error'));
		}

		redirect('admin/blog');
	}

	/**
	 * Delete blog post
	 * 
	 * @param int $id the ID of the blog post to delete
	 * @return void
	 */
	public function delete($id = 0)
	{	
		$INPUT = array(
				'deleted' 			=> 1
			);
			
			$this->unit_of_measure_m->update($id, $INPUT)
				? $this->session->set_flashdata('success', sprintf(lang('category:cat_delete_success')))
				: 	$this->session->set_flashdata('error', sprintf(lang('category:cat_delete_error')));
			
	
		redirect('admin/unit_of_measure/index');
	} 
	public function permanent_delete($id = 0)
	{	
		
		{
			if($this->unit_of_measure_m->tempdelete($id))
			{
				$this->session->set_flashdata('success', sprintf(lang('category:cat_delete_success')));
			}
			else
			{
				$this->session->set_flashdata('error', sprintf(lang('category:cat_delete_error')));
			}
		}
			
		
		
		$id_array = (!empty($id)) ? array($id) : $this->input->post('action_to');
		
		
		
		redirect('admin/unit_of_measure/index');
	}

	/**
	 * Callback method that checks the category code of a category
	 * 
	 * @param string title The Title to check
	 * @return bool
	 */
	public function _check_desc($code, $id = null)
	{
		$this->form_validation->set_message('_check_desc', sprintf(lang('category:already_exist_error'), lang('global:title')));
		return $this->unit_of_measure_m->check_exists('unit_name', $code);			
	}
	public function _check_otherdesc($code, $id)
	{
		$this->form_validation->set_message('_check_otherdesc', sprintf(lang('category:already_exist_error'), lang('global:title')));
		return $this->unit_of_measure_m->check_exists_other('unit_name', $code,$id);			
	}
	/**
	 * Callback method that checks the title of an post
	 * 
	 * @param string title The Title to check
	 * @return bool
	 */
	public function _check_title($title, $id = null)
	{
		$this->form_validation->set_message('_check_title', sprintf(lang('blog:already_exist_error'), lang('global:title')));
		return $this->blog_m->check_exists('title', $title, $id);			
	}
	
	/**
	 * Callback method that checks the slug of an post
	 * 
	 * @param string slug The Slug to check
	 * @return bool
	 */
	public function _check_slug($slug, $id = null)
	{
		$this->form_validation->set_message('_check_slug', sprintf(lang('blog:already_exist_error'), lang('global:slug')));
		return $this->blog_m->check_exists('slug', $slug, $id);
	}

    private function _preview_hash()
    {

        return md5(microtime() + mt_rand(0,1000));

    }
}
