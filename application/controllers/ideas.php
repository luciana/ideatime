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
		if (isset($_SESSION['username']))
			redirect('ideas/home');
		else	
			$this->load->view('login_view');
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
	    $array = $this->oauth_model->get_UserTwitterInfo($_SESSION['username']);
	    $userId = $array->users_id;
	    $userArray = $this->user_model->get_user($userId);
		$response = $this->twitter_oauth->get_account_credentials($userId);
		$_SESSION['avatar'] = $response->profile_image_url_https;
		$data['ideas'] = $this->idea_model->get_ideas_page(); 
		$this->load->view('home_view', $data);

	}

	function submit()
	{
		$array = array(
					'name' => $this->input->post('idea'),
					'author' => $this->input->post('author'),
					'groups_id' => '1',
					'users_id' => $_SESSION['user_id']
				);
		$this->idea_model->post_idea($array);
		
		if ($this->input->post('ajax'))
		{
			$data['ideas'] = $this->idea_model->get_last_idea();
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

