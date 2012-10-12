<?php 

Class Test extends CI_Controller
{
	function __construct(){
		if (!isset($_SESSION))
			session_start();
		parent::__construct();
		$params = array('key'=>'0sd51MbJuom5csE6xeYfw', 'secret'=>'suL2lwFTggjBMWRSev1uZDIutYy7vhhHo44DIOYs');
		$this->load->library('twitter_oauth', $params);
	}

	function index()
	{
		echo 'index page';
	}

	function testVoteInsert()
	{
		$array = array(
					'field' => 'good',
					'ideas_id' => 7,
					'users_id' => 1
				);
		$response = $this->vote_model->update_vote($array);
		echo $response;

	}

	function twitter()
	{
		  $userArray = $this->user_model->get_user('2');
		$response = $this->twitter_oauth->get_account_credentials(39792346);
		var_dump($response);

		
	}

	function query()
	{
		var_dump($this->idea_model->updated_on(19));
	}
}
