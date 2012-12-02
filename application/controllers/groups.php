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
		'groups' => $this->group_model->get_user_groups($_SESSION['user_id'])
		);
		$this->load->view('groups/home_view',$data);			
	}

	function admin(){
		 $data['group_id'] = $_SESSION['active_group_id'];
	     $this->load->view('groups/admin_view', $data);	 
	}

	function request_access(){
		
		$group_id = $this->input->post('groups');
		$username = $this->input->post('twitter_name');
		
		//post it the access table, so I can track it
		$data = array(
			   'requester' => $username  ,
			   'groups_id' => $group_id ,
			  
			);
		$this->group_model->post_group_access_request($data);

		//give them access
		$array = array(
					'username' => $username,
					'users_id' => $_SESSION['user_id'],
					'groups_id' => $group_id,
					'admin' => 0					
				);
		$this->group_model->post_group_access($array);


		redirect('ideas/home');
	}

	function grant_access(){
		$data = array(
			   'username' => $this->input->post('username') ,
			   'groups_id' => $this->input->post('groups_id') ,
			   'users_id' =>$this->input->post('users_id'),
			   'admin'	=> 0
			  
			);
		print_r($data);
		//$this->group_model->post_group_access($data);
		
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

