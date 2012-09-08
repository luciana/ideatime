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
		var_dump($this->vote_model->is_duplicate_vote(7, 2));

		
	}

	function query()
	{
		var_dump($this->idea_model->get_last_idea());
	}
}
