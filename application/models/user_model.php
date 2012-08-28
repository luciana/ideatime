<?php

class User_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function getUserTwitterInfo($username)
	{
		$query = $this->db->where('username', $username)
							->limit('1')
							->get('users');
		return $query->row();
	}

	function getAllUsers()
	{
		$query = $this->db->get('users');
		return $query->result();
	}


}
