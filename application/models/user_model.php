<?php

Class User_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_user($id)
	{
		$query = $this->db
						->where('id', $id)
						->get('users');
		return $query->result();				
	}

	function get_valid_user($username)
	{
		$query = $this->db
						->where('username', $username)
						->limit(1)
						->get('users');
		return $query->row();	
	}


}