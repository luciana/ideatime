<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller {

	
	function __construct() 
	{
		if (!isset($_SESSION))
			session_start();
		parent::__construct();
					
	}	


	/**
     * Load New User View
     *
     * @return null
     */
	function home()
	{						
		$data = array(
		'user'=> $_SESSION['username'],			
		'groups' => $this->group_model->get_groups()
		);
		$this->load->view('new_user_view',$data);			
	}

	/**
     * Create new group
     * Add group name to the group table
     * Add user information to group access table
     *
     * @return null
     */
	function submit()
	{
		$array = array(
					'name' => $this->input->post('group')					
				);
		$group_id = $this->group_model->insert_group($array);

		$array = array(
					'username' => $_SESSION['username'],
					'users_id' => $_SESSION['user_id'],
					'groups_id' => $group_id,
					'admin' => 1					
				);
		$this->group_model->post_group_access($array);
		$_SESSION['groups'] = array($group_id);
		redirect('ideas/home');
	}
}

