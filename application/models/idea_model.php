<?php 

Class Idea_model extends CI_Model {
	
	var $max_rows = 5;
	var $page_active = 1;
	
	function get_ideas()
	{
		$query = $this->db						
						->order_by('id')	
						->get('ideas');
						
		return $query->result();
	}

	function set_page_active($value)
	{
		$page_active = $value;
	}

	function get_ideas_votes()
	{
		$query = $this->db
						->group_by('ideas.id')
						->select('ideas.*, SUM(votes.good) as vGood, SUM(votes.bad) as vBad')
						->from('ideas')
						->join('votes', 'ideas.id = votes.ideas_id', 'left')
						->get();
		return $query->result();
	}

	function updated_on($id)
	{
		$data = array('updated_on' => date("Y-m-d H:i:s"));
		$this->db->where('id', $id);
		$this->db->update('ideas', $data); 
		return $this->db->last_query();
	}	

	function post_idea($postArray)
	{
		$this->db->insert('ideas', $postArray);
		return $this->db->insert_id();
	}

	function get_idea_by_group($id)
	{		
		$query = $this->db
						->select('ideas.*, SUM(votes.good) as vGood, SUM(votes.bad) as vBad')
						->from('ideas')		
						->join('comments', 'ideas.id = comments.ideas_id', 'left')	
						->join('votes', 'ideas.id = votes.ideas_id', 'left')														
						->where('ideas.groups_id', $id)	
						->where('ideas.archive_id is null')	
						->group_by('ideas.id')
						->order_by('ideas.updated_on', 'desc')
						->order_by("ideas.created_on", "desc")
						->order_by("comments.date", "desc")
						->order_by("ideas.updated_on", "desc")
						->get();			
		return $query->result();
	}

	function get_archive_idea_by_group($id)
	{
		$query = $this->db
						->select('ideas.*, SUM(votes.good) as vGood, SUM(votes.bad) as vBad')
						->from('ideas')		
						->join('comments', 'ideas.id = comments.ideas_id', 'left')	
						->join('votes', 'ideas.id = votes.ideas_id', 'left')														
						->where('ideas.groups_id', $id)	
						->where('archive_id', '1')	
						->group_by('ideas.id')
						->order_by('ideas.updated_on', 'desc')
						->order_by("ideas.created_on", "desc")
						->order_by("comments.date", "desc")
						->order_by("ideas.updated_on", "desc")
						->get();			
		return $query->result();

	}

	function get_last_idea()
	{
		$query = $this->db
						->group_by('ideas.id')
						->order_by('ideas.id', 'desc')						
						->limit(1)
						->select('ideas.*, SUM(votes.good) as vGood, SUM(votes.bad) as vBad')
						->from('ideas')
						->join('votes', 'ideas.id = votes.ideas_id', 'left')
						->get();		
		return $query->result();
	}

	function get_total_ideas($group)
	{
		$query = $this->db
						->where('groups_id', $group)		
						->where('ideas.archive_id is null')			
						->get('ideas');
		return $query->num_rows();
	}

	function get_total_pages($group)
	{
		return ceil($this->get_total_ideas($group)/$this->max_rows);
	}

	function update_vote($voteData)
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

	function get_idea($id)
	{
		$query = $this->db->where('id', $id)
							->limit(1)
							->get('ideas');
		return $query->row_array();
	}
	
}