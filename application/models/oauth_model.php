<?php

class Oauth_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_UserTwitterInfo($username)
	{
		$query = $this->db->where('username', $username)
							->limit('1')
							->get('oauth_users');
		return $query->row();
	}

	function get_AllUsers()
	{
		$query = $this->db->get('oauth_users');
		return $query->result();
	}

	function update_UserTwitter($data, $id)
	{
		$this->db->where('users_id', $id);		
		$this->db->update('oauth_users', $data);

	}

	function insert_UserTwitter($data)
	{		
		$this->db->insert('oauth_users', $data);

	}

}
