<?php

class Group_model extends CI_Model {
	

	function get_groups()
	{
		$query = $this->db->get('groups');
		return $query;
	}


}