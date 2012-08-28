<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
			redirect('welcome/work');
		else
			$this->request_token();
	}

	function work()
	{
		$data['session'] = $_SESSION;//$this->session->userdata('token_secret');
		$this->load->view('link', $data);

	}

	
	function twit_response()
	{

		redirect('welcome/work');
	}

	function logout()
	{
		session_destroy();
		redirect('welcome/index');
	}

	function request_token()
	{
	    $params = array('key'=>'0sd51MbJuom5csE6xeYfw', 'secret'=>'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs');
	    $this->load->library('twitter_oauth', $params);
	    $response = $this->twitter_oauth->get_request_token(site_url("welcome/access_token"));
	    $_SESSION['token_secret'] = $response['token_secret'];
	    redirect($response['redirect']);
	}

    
	function access_token()
	{
	    $params = array('key'=>'0sd51MbJuom5csE6xeYfw', 'secret'=>'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs');
	    $this->load->library('twitter_oauth', $params);
	    $response = $this->twitter_oauth->get_access_token(false,  $_SESSION['token_secret']);
	    $_SESSION['username'] = $response['screen_name'];
	    redirect('welcome/work');
	}
}

/*
access token: response

array(4) { ["oauth_token"]=> string(50) "434626592-R4bRlzXUN4gcr03yb3fD2w4PeKmuwOg6AfrvNit5" 
["oauth_token_secret"]=> string(42) "L4j9GWakPnUIdGT8q0maSaw62LEiVqFrPpQXOqmL0g" 
["user_id"]=> string(9) "434626592" ["screen_name"]=> string(12) "getSabotaged" }

*/

/*
$params = array('key'=>'0sd51MbJuom5csE6xeYfw', 'secret'=>'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs');
$this->load->library('twitter_oauth', $params);

$response = $this->twitter_oauth->get_request_token('http://localhost:8888/idea/index.php/welcome/work');

*/
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */