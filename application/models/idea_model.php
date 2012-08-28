<?php 

Class Idea_model extends CI_Model {
	
	function getIdeas()
	{
		$query = $this->db->get('ideas');
		return $query->result();
	}





	
}