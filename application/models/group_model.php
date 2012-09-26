<?php

class Group_model extends CI_Model {
	

	function get_groups()
	{
		$query = $this->db->get('groups');
		return $query->result();
	}

	function get_group($id)
	{
		$query = $this->db->where('id', $id)
							->limit(1)
							->get('groups');
		return $query->row_array();
	}

	function get_user_groups($id)
	{	
		$this->db->select('*');
		$this->db->from('groups');
		$this->db->join('group_access', 'groups.id = group_access.groups_id and group_access.users_id='.$id);		

		$query = $this->db->get();
		return $query->result();
	}

	function is_user_in_group($id)
	{
		$query = $this->db->where('users_id', $id)
							->limit(1)
							->get('group_access');
		return $query->row_array();
	}

	function insert_group($data)
	{
		$this->db->insert('groups', $data);
		return $this->db->insert_id();
	}

	function post_group_access($data)
	{
		$this->db->insert('group_access', $data);
	}

	function update_group_access()
	{
		$ideaId = $voteData['id'];
		$voteField = $voteData['field'];
		$ideaArray = $this->get_idea($ideaId);
		$voteValue = $ideaArray[$voteField];
		$voteValue++;
		$data = array($voteField => $voteValue);
		$this->db->where('id', $ideaId);		
		$this->db->update('ideas', $data);
		return 'success';
	}

}