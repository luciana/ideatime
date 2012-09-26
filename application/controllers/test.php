<?php 

Class Test extends CI_Controller
{
	function __construct(){
		if (!isset($_SESSION))
			session_start();
		parent::__construct();
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

	function votes()
	{
		$response = $this->idea_model->get_ideas_page(1);
		echo $response->num_rows();

		echo ' ';
		var_dump($response->result_array());

		
	}

	function query()
	{
		var_dump($this->idea_model->get_last_idea());
	}
}
