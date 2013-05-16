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
	protected $section = 'categories';

	/**
	 * Array that contains the validation rules
	 *
	 * @var array
	 */
	 
	//~ CURRENT FIELDS FOR CATEGORY (3): cat_name, description, stocktype, category code
	protected $validation_rules = array(
		array(
			'field' => 'cat_name',
			'label' => 'lang:category:cat_name_label',
			'rules' => 'trim|required|htmlspecialchars|max_length[50]'
		),
		array(
			'field' => 'description',
			'label' => 'lang:category:cat_desc_label',
			'rules' => 'trim|required|htmlspecialchars|max_length[100]'
			//~ 'rules' => 'trim|required|alpha_dot_dash|max_length[100]|callback__check_slug'
		),
		array(
			'field' => 'is_stocking',
			'label' => 'lang:category:cat_stock_type_label',
			'rules' => 'trim|htmlspecialchars'
		),
		array(
			'field' => 'category_code',
			'label' => 'lang:category:cat_code_label',
			'rules' => 'trim|required|alpha|max_length[6]|min_length[3]'
		)
	);

	/**
	 * The constructor
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('category_m', 'blog_categories_m'));
		$this->lang->load('category');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);

	}

	/**
	 * Index method, lists all categories
	 * 
	 * @return void
	 */
	public function index()
	{
		$this->pyrocache->delete_all('modules_m');
		
		// Create pagination links
		$total_rows = $this->category_m->count_all();  // count_all() directly count rows of db declared in model
		$pagination = create_pagination('admin/categories/index', $total_rows, NULL, 4);
			
		// Using this data, get the relevant results
		$categories = $this->category_m->limit($pagination['limit'])->get_all(); //get_all() directly get all rows od db declared in model
		$accounting_categories = $this->category_m->get_accounting_categories();	
		$this->template
			->title($this->module_details['name'], lang('cat_list_title'))
			->set('categories', $categories)
			->set('accounting_categories', $accounting_categories)
			->set('pagination', $pagination)
			->set('category_m', $this->category_m)
			->build('admin/categories/index');

		
	}

	/**
	 * Create new category
	 *
	 * @return void
	 */
		public function create()
		{
		
		$this->form_validation->set_rules('category_code', 'lang:category:cat_code_label', 'trim|alpha|max_length[6]|min_length[3]|callback__check_code['.$this->input->post('category_code').']');

			
			// Validate the data
		if ($this->form_validation->run())
		{
			if ($id = $this->category_m->insert($_POST))
			{
				
				// Fire an event. A new blog category has been created.
				//	Events::trigger('blog_category_created', $id);

				$this->session->set_flashdata('success', sprintf( lang('category:cat_add_success'), $this->input->post('id')) );
			}
			else
			{
				$this->session->set_flashdata('error', lang('category:cat_add_error'));
			}
			
			redirect('admin/categories');
		}

		$category = new stdClass();
		$accounting_categories = $this->category_m->get_accounting_categories();
				
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$category->{$rule['field']} = set_value($rule['field']);
		}
		
		$this->template
			->title($this->module_details['name'], lang('cat_create_title'))
			->set('category', $category)
			->set('accounting_categories', $accounting_categories)
			->build('admin/categories/form');	
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
		$id OR redirect('admin/categories');

		// Get the category
		$category = $this->category_m->get($id);
		
		// ID specified?
		$category or redirect('admin/blog/categories/index');

		$this->form_validation->set_rules('cat_name', 'lang:category:cat_name_label', 'trim|htmlspecialchars|required|max_length[50]');
	
		// Validate the results
		if ($this->form_validation->run())
		{		
			
			$INPUT = array(
				'description' 			=> $this->input->post('description'),
				'is_stocking' 			=> $this->input->post('is_stocking'),
				'cat_name' 					=> $this->input->post('cat_name')
			);
			
			$this->category_m->update($id, $INPUT)
				? $this->session->set_flashdata('success', sprintf( lang('category:cat_edit_success'), $this->input->post('cat_name')) )
				: $this->session->set_flashdata('error', lang('cat_edit_error'));
			
			// Fire an event. A blog category is being updated.
			Events::trigger('blog_category_updated', $id);
			
			redirect('admin/categories/index');
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
		$accounting_categories = $this->category_m->get_accounting_categories();	
		$this->template
			->title($this->module_details['name'], sprintf(lang('cat_edit_title'), $category->id))
			->set('accounting_categories', $accounting_categories)
			->set('category', $category)
			->build('admin/categories/form');
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
		//Check if at least 1 item is under this category
		//echo ($this->category_m->check_if_has_items($id)) ? 'di pde' : 'pede';
		//die();
		
		if($this->category_m->check_if_has_items($id))
		{
			$this->session->set_flashdata('error', sprintf(lang('category:cat_delete_error_has_item')));
		}
		else
		{
			if($this->category_m->delete($id))
			{
				$this->session->set_flashdata('success', sprintf(lang('category:cat_delete_success')));
			}
			else
			{
				$this->session->set_flashdata('error', sprintf(lang('category:cat_delete_error')));
			}
		}
			
		
		
		$id_array = (!empty($id)) ? array($id) : $this->input->post('action_to');
		
		// Delete multiple
		//~ if (!empty($id_array))
		//~ {
			//~ $deleted = 0;
			//~ $to_delete = 0;
			//~ $deleted_ids = array();
			//~ foreach ($id_array as $id)
			//~ {
				//~ if ($this->category_m->delete($id))
				//~ {
					//~ $deleted++;
					//~ $deleted_ids[] = $id;
				//~ }
				//~ else
				//~ {
					//~ $this->session->set_flashdata('error', sprintf(lang('category:cat_mass_delete_error'), $id));
				//~ }
				//~ $to_delete++;
			//~ }
			//~ 
			//~ if ( $deleted > 0 )
			//~ {
				//~ $this->session->set_flashdata('success', sprintf(lang('category:cat_mass_delete_success'), $deleted, $to_delete));
			//~ }
			//~ 
			//~ // Fire an event. One or more categories have been deleted.
			//~ Events::trigger('blog_category_deleted', $deleted_ids);
		//~ }		
		//~ else
		//~ {
			//~ $this->session->set_flashdata('error', lang('cat_no_select_error'));
		//~ }
		
		redirect('admin/categories/index');
	}

	/**
	 * Callback method that checks the category code of a category
	 * 
	 * @param string title The Title to check
	 * @return bool
	 */
	public function _check_code($code, $id = null)
	{
		$this->form_validation->set_message('_check_code', sprintf(lang('category:already_exist_error'), lang('global:title')));
		return $this->category_m->check_exists('category_code', $code);			
	}
	
	/**
	 * Callback method that checks the title of the category
	 * 
	 * @param string title The title to check
	 * @return bool
	 */
	//~ public function _check_code($code = '',$id = null)
	//~ {
		//~ //$id = $this->input->post('id');
		//~ $method = $this->input->post('method');
		//~ 
		//~ if ($this->category_m->check_exists('id', $code, $id))
		//~ {
			//~ if($method == 'create'){
				//~ $this->form_validation->set_message('_check_code', sprintf(lang('category:already_exist_error'), $code));
				//~ return FALSE;
				//~ }
			//~ if($method == 'edit'){
				//~ return TRUE;
				//~ }
			//~ 
		//~ }
//~ 
		//~ return TRUE;
	//~ }
	
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
