<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ideas extends CI_Controller {

	public $params = array('key'=>'0sd51MbJuom5csE6xeYfw', 'secret'=>'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs');
	public $key = '0sd51MbJuom5csE6xeYfw';
	public $secret = 'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs';

	function __construct() 
	{
		if (!isset($_SESSION))
			session_start();
		parent::__construct();
		$params = array('key'=>'0sd51MbJuom5csE6xeYfw', 'secret'=>'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs');
		$this->load->library('twitter_oauth', $params);				
	}	

	function index()
	{
		if (isset($_SESSION['username'])){
              redirect('ideas/home');
         }else{
              $this->load->view('login_view');
         }
	}

	function login()
	{
		if ( !empty($_SESSION['username']))
			redirect('ideas/home');
		else			
			redirect('twitter/request_token');
	}

	function home()
	{
	   
	    $userData = $this->oauth_model->get_user($_SESSION['user_id']);
	    //print_r($userData);
		$response = $this->twitter_oauth->get_account_credentials($userData->oauth_uid);
		//print_r($response);
		$_SESSION['name'] = $response->name;
		$_SESSION['avatar'] = $response->profile_image_url;
		$_SESSION['active_group_id'] = null;
		$groups = $this->group_model->get_user_groups($_SESSION['user_id']);
		
		if(empty($groups)){
			$data['groups'] = null;  
           	$this->load->view('groups/home_view', $data);
		}else
		if(count($groups)>1){
			$data['groups'] = $groups;             
            $this->load->view('groups/home_view', $data);
		}else 
		if (count($groups)==1){			
			redirect('ideas/single/'.$groups[0]->groups_id);
		} 
	}

	function single($group_id){

		$page = $this->input->post('pageNum');
		$group = $_SESSION['groups'][0];
		

		if($this->group_model->is_user_in_group($group_id, $_SESSION['user_id'])){
			$_SESSION['active_group_id'] = $group_id;
			if ($page > $this->idea_model->get_total_pages($group_id))
				$page = 1;

			$data = array(
		              'ideas' => $this->idea_model->get_idea_by_group($_SESSION['active_group_id']),
		               'groups' =>$this->group_model->get_group($group_id)
		          );	
			$this->load->view('ideas/single_idea_view', $data);
		}else{
			show_404();
		}
	}

	function submit()
	{
		$array = array(
					'name' => $this->input->post('idea'),
					'author' => $this->input->post('author'),
					'groups_id' => $this->input->post('group'),
					'users_id' => $_SESSION['user_id']
				);
		$this->idea_model->post_idea($array);
		
		if ($this->input->post('ajax'))
		{				
			$data = array(
				'ideas' => $this->idea_model->get_idea_by_group($_SESSION['active_group_id']),
				'start' => 0,
				'start_active' => 0,
				'end'=> $this->idea_model->max_rows -1,
				'perpage' => $this->idea_model->max_rows
				);
			
			$this->load->view('ideas/idea_view', $data);
		}
		else
			redirect('ideas/home');
	}

	function post_vote()
	{
		$array = array(
					'field' => $this->input->post('field'),
					'ideas_id' => $this->input->post('id'),
					'users_id' => $_SESSION['user_id']
				);

		//is_duplicate will return true if you have already voted for the idea.
		if ($this->vote_model->is_duplicate_vote($array['ideas_id'], $array['users_id']))
			echo 'You have already voted for this idea!';
		else
		{	
			$this->vote_model->update_vote($array);

			if ($this->input->post('ajax'))
			{
				$response = $this->vote_model->get_idea_votes($array['ideas_id']);
				$vote['vote_count'] = $response[$array['field']];
				echo $vote['vote_count'];
			}
			else
				redirect('ideas/home');
		}
	}

	function logout()
	{
		session_destroy();
		redirect('ideas/index');
	}

	//another debugging function
	function idea()
	{
		$response = $this->idea_model->get_idea('15');
		var_dump($response);
	}

	//useful for debugging purposes
	function session()
	{
		var_dump($_SESSION);
	}

}

