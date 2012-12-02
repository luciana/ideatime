<?php 

Class Comment_model extends CI_Model
{
	
	function get_comments($ideaID)
	{
		$query = $this->db
						->where('ideas_id', $ideaID)
						->get('comments');
		return $query->result();
	}

	function insert_comment($data)
	{
		$this->db->insert('comments', $data);
		return $this->db->insert_id();
	}

	function last_comment($commentID)
	{
		$query = $this->get_comment_by_id($commentID);
		return $query->result();
	}

	function get_comment_by_id($id)
	{
		$query = $this->db
						->where('id', $id)
						->limit(1)
						->get('comments');
		return $query;
	}


}