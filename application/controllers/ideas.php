<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ideas extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	//public $response;
	var $dataArray;
	public $params = array('key'=>'0sd51MbJuom5csE6xeYfw', 'secret'=>'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs');
	public $key = '0sd51MbJuom5csE6xeYfw';
	public $secret = 'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs';

	function __construct(){
		session_start();
		parent::__construct();
		$params = array('key'=>'0sd51MbJuom5csE6xeYfw', 'secret'=>'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs');
		$this->load->library('twitter_oauth', $params);
		$this->load->model('user_model');	
		$this->load->model('idea_model');
	}	

	function index()
	{
		$this->load->view('login_view');
	}

	function login()
	{
		if ( !empty($_SESSION['token_secret']))
			redirect('ideas/home');
		else
			$this->request_token();
	}

	function home()
	{
		$params = array('key'=>'0sd51MbJuom5csE6xeYfw', 'secret'=>'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs');
	    $this->load->library('twitter_oauth', $params);
	    $array = $this->user_model->getUserTwitterInfo($_SESSION['username']);
	    $userId = $array->oauth_uid;
		$response = $this->twitter_oauth->get_account_credentials($userId);
	//	$data['twitter'] = $response;
		//echo var_dump($response->profile_image_url_https);
		$_SESSION['avatar'] = $response->profile_image_url_https;
		$data['ideas'] = $this->idea_model->get_ideas();
		$data['session'] = $_SESSION;//$this->session->userdata('token_secret');
		$this->load->view('home_view', $data);

	}

	function submit()
	{
		$array = array('name' => $this->input->post('idea'),'author' => $this->input->post('author'));
		$this->idea_model->post_idea($array);
		
		if ($this->input->post('ajax'))
		{
			$data['idea'] = $this->idea_model->get_last_idea();
			$this->load->view('ideas/new_idea_view', $data);
		}
		else
			redirect('ideas/home');
	}

	function logout()
	{
		session_destroy();
		redirect('ideas/index');
	}

	function request_token()
	{
	    $params = array('key'=>'0sd51MbJuom5csE6xeYfw', 'secret'=>'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs');
	    $this->load->library('twitter_oauth', $params);
	    $response = $this->twitter_oauth->get_request_token(site_url("ideas/access_token"));
	    $_SESSION['token_secret'] = $response['token_secret'];
	    redirect($response['redirect']);
	}

    
	function access_token()
	{
	    $params = array('key'=>'0sd51MbJuom5csE6xeYfw', 'secret'=>'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs');
	    $this->load->library('twitter_oauth', $params);
	    $response = $this->twitter_oauth->get_access_token(false,  $_SESSION['token_secret']);
	    $_SESSION['username'] = $response['screen_name'];
	    redirect('ideas/home');
	}
}
