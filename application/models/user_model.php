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

	function get_user_by_username($username)
	{
		$query = $this->db
						->where('username', $username)
						->limit(1)
						->get('users');
		return $query->row();	
	}

	function is_user_admin($user_id)
	{															
		$this->db->where('users_id', $user_id);	
		$this->db->where('admin', '1');	
		$this->db->from('group_access');
		return $this->db->count_all_results();
	}
	
	function is_user_group_admin($group_id, $user_id)
	{
		$this->db->where('groups_id', $group_id);							
		$this->db->where('users_id', $user_id);	
		$this->db->where('admin', '1');	
		$this->db->from('group_access');
		return $this->db->count_all_results();
	}



}