<?php 

Class Idea_model extends CI_Model {
	
	function get_Ideas()
	{
		$query = $this->db->get('ideas');
		return $query->result();
	}

	function post_Idea($postArray)
	{
		$this->db->insert('ideas', $postArray);
	}




	
}