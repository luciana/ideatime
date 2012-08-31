<?php 

Class Idea_model extends CI_Model {
	
	function get_ideas()
	{
		$query = $this->db->get('ideas');
		return $query->result();
	}

	function post_idea($postArray)
	{
		$this->db->insert('ideas', $postArray);
	}

	function get_last_idea()
	{
		$query = $this->db
						->limit('1')
					    ->order_by('id', 'desc')
						->get('ideas');
		return $query;				
	}




	
}