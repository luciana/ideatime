<?php


Class Comments extends CI_Controller
{
	
	function __construct()
	{
		session_start();
		parent::__construct();
	}

	function get_for_idea()
	{
		$ideaID =$this->input->post('idea');

		$data['comments'] = $this->comment_model->get_comments($ideaID);

		echo $this->load->view('comments/comment_display_view', $data);

	}

	function insert()
	{
		$ideaId = $this->input->post('id');
		$data = array(
				'body' => $this->input->post('body'),
				'ideas_id' => $ideaId,
				'users_id' => $this->input->post('userID')
			);
		$commentID = $this->comment_model->insert_comment($data);
		$this->idea_model->updated_on($ideaId);
		$data['comments'] = $this->comment_model->last_comment($commentID);
		echo $this->load->view('comments/comment_display_view', $data);

	}

}