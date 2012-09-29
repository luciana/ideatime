<?php

class Oauth_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_user_twitter_info($username)
	{
		$query = $this->db->where('username', $username)
							->limit('1')
							->get('oauth_users');
		return $query->row();
	}

	function get_user($id)
	{
		$query = $this->db->where('users_id', $id)
							->limit('1')
							->get('oauth_users');
		return $query->row();
	}

	function get_AllUsers()
	{
		$query = $this->db->get('oauth_users');
		return $query->result();
	}

	function get_user_groups($id)
	{
		$query = $this->db->where('users_id', $id)
						  ->get('group_access');
		return $query->result();
	}

	function update_user_twitter($data, $id)
	{
		$this->db->where('users_id', $id);		
		$this->db->update('oauth_users', $data);

	}

	function insert_user_twitter($data)
	{		
		$this->db->insert('oauth_users', $data);

	}
	function insert_user($data)
	{		
		$this->db->insert('users', $data);
		return $this->db->insert_id();
	}

}
