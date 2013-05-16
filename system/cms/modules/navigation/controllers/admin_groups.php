<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin_groups controller
 *
 * @author		PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Navigation\Controllers
 */
class Admin_groups extends Admin_Controller
{

	/**
	 * The current active section.
	 *
	 * @var int
	 */
	protected $section = 'groups';

	/**
	 * The array containing the rules for the navigation groups.
	 *
	 * @var array
	 */
	private $validation_rules = array(
		array(
			'field' => 'title', //warehouse name
			'label' => 'lang:nav_group_label',
			'rules' => 'trim|required|max_length[30]'
		),
		array(
			'field' => 'del_add1',
			'label' => 'lang:nav_del_add_1_label',
			'rules' => 'trim|required|max_length[100]'
		),
		array(
			'field' => 'tel',
			'label' => 'lang:nav_tel_label',
			'rules' => 'trim|required|numeric|max_length[30]'
		),
		array(
			'field' => 'contact',
			'label' => 'lang:nav_contact_label',
			'rules' => 'trim|required|max_length[30]'
		),
		array(
			'field' => 'inventory_manager',
			'label' => 'lang:nav_manager_label',
			'rules' => 'trim|required|max_length[30]'
		)
	);

	/**
	 * Constructor method
	 */
	function __construct()
	{
		// Call the parent's contstructor
		parent::__construct();

		// Load the required classes
		$this->load->model('navigation_m');
		$this->load->library('form_validation');
		$this->lang->load('navigation');

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
	}

	/**
	 * Index method, redirects back to navigation/index.
	 */
	public function index()
	{
		redirect('admin/navigation');
	}

	/**
	 * Create a new navigation group.
	 */
	public function create()
	{
		// Validate
		if ($this->form_validation->run())
		{
			// Insert the new group/warehouse
			if ($id = $this->navigation_m->insert_group($_POST) > 0)
			{
				$this->session->set_flashdata('success', $this->lang->line('nav_group_add_success'));
				// Fire an event. A new navigation group has been created.
				Events::trigger('navigation_group_created', $id);
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('nav_group_add_error'));
			}

			// Redirect the user
			redirect('admin/navigation/index');
		}

		// Loop through each rule
		foreach ($this->validation_rules as $rule)
		{
			$navigation_group->{$rule['field']} = $this->input->post($rule['field']);
		}
	
		$inventory_managers = $this->navigation_m->get_inventory_managers();
			
		//~ print_r($inventory_managers);
		//~ die();
		
		// Render the view
		$this->template
			->title($this->module_details['name'], lang('nav_group_label'), lang('nav_group_create_title'))
			->set('inventory_managers', $inventory_managers)
			->set('navigation_group', $navigation_group)
			->build('admin/groups/create');
	}
	
	
	public function edit($id = 0)
	{
		$id OR redirect('admin/navigation');
		
		// Get the group/warehouse
		$navigation_group = $this->navigation_m->get_group($id);
		
		// ID specified?
		$navigation_group or redirect('admin/navigation');
		
		// Validate the results
		if ($this->form_validation->run())
		{		
			$INPUT = array(
				'title' 				=> $this->input->post('title'),
				'del_add1' 				=> $this->input->post('del_add_1'),
				'tel' 					=> $this->input->post('tel'),
				'contact' 				=> $this->input->post('contact'),
				'inventory_manager' 	=> $this->input->post('inventory_manager')
			);
			
			$this->navigation_m->update_group($id, $INPUT)
				? $this->session->set_flashdata('success', sprintf( lang('nav_group_edit_success'), $this->input->post('title')) )
				: $this->session->set_flashdata('error', sprintf( lang('nav_group_edit_error'), $this->input->post('title')));
			
			redirect('admin/navigation');
		}
		
		// Loop through each rule
		//~ foreach ($this->validation_rules as $rule)
		//~ {
			//~ if ($this->input->post($rule['field']) !== FALSE)
			//~ {
				//~ $category->{$rule['field']} = $this->input->post($rule['field']);
			//~ }
		//~ }
		
		// Loop through each rule
		
		//~ print_r($this->validation_rules);
		//~ die();
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== FALSE)
			{
				$navigation_group->{$rule['field']} = $this->input->post($rule['field']);
			}
		}
		$inventory_managers = $this->navigation_m->get_inventory_managers();
		// Render the view
		$this->template
			->title($this->module_details['name'], lang('nav_group_label'), lang('nav_group_create_title'))
			->set('inventory_managers', $inventory_managers)
			->set('navigation_group', $navigation_group)
			->build('admin/groups/create');
		
	}

	/**
	 * Delete a navigation group (or delete multiple ones).
	 *
	 * @param int $id The id of the group.
	 */
	public function delete($id = 0)
	{
		$deleted_ids = FALSE;
		
		//check if group/warehouse has defined storage inside it
		if($this->navigation_m->get_group_links($id))
		{
			$this->session->set_flashdata('error', $this->lang->line('nav_group_mass_delete_error'));
		}
		else 
		{
			if ($this->navigation_m->delete_group($id))
			{
				$deleted_ids[] = $id;
				$this->session->set_flashdata('success', $this->lang->line('nav_group_mass_delete_success'));
			}
		}
		
		// Delete one
		//~ if ($id)
		//~ {
			//~ if ($this->navigation_m->delete_group($id))
			//~ {
				//~ $deleted_ids[] = $id;
				//~ $this->navigation_m->delete_link(array('navigation_group_id' => $id));
			//~ }
		//~ }

		// Delete multiple
		//~ else
		//~ {
			//~ foreach (array_keys($this->input->post('delete')) as $id)
			//~ {
				//~ if ($this->navigation_m->delete_group($id))
				//~ {
					//~ $deleted_ids[] = $id;
					//~ $this->navigation_m->delete_link(array('navigation_group_id' => $id));
				//~ }
			//~ }
		//~ }

		// Fire an event. One or more navigation groups have been deleted.
		if ( ! empty($deleted_ids))
		{
			Events::trigger('navigation_group_deleted', $deleted_ids);
		}

		// Set the message and redirect
		//$this->session->set_flashdata('success', $this->lang->line('nav_group_mass_delete_success'));
		redirect('admin/navigation/index');
	}
}
