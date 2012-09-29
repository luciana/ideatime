<?php 

Class Idea_model extends CI_Model {
	
	function get_ideas()
	{
		$query = $this->db
						->order_by('id')
						->get('ideas');
		return $query->result();
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

	function post_idea($postArray)
	{
		$this->db->insert('ideas', $postArray);
	}

	function get_idea_by_group($id)
	{
		$query = $this->db->where('groups_id', $id)							
							->get('ideas');
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
		//return $this->db->last_query();
		return $query->result();
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