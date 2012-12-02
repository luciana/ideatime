<?php 

Class Vote_model extends CI_Model {



	function update_vote($voteData)
	{
		$ideaId = $voteData['ideas_id'];
		//field is good or bad
		$voteField = $voteData['field'];

		$data = array(
				'ideas_id' => $voteData['ideas_id'],
				$voteData['field'] => 1,
				'users_id' => $voteData['users_id'],
				);

		$this->db->insert('votes', $data);
		$this->idea_model->updated_on($ideaId);
		return 'success';
	}
	function get_idea_votes($ideaId)
	{
		$query = $this->db
						->select('SUM(good) as good, SUM(bad) as bad')
						->where('ideas_id', $ideaId)
						->get('votes');
		return $query->row_array();				
	}

	function get_ideas_votes()
	{
		$query = $this->db
						->order_by('ideas.id')
						->select('ideas.*, SUM(votes.good), SUM(votes.bad)')
						->from('ideas')
						->join('votes', 'ideas.id = votes.ideas_id')
						->get();
		return $this->db->last_query();
	}

	function is_duplicate_vote($ideaId, $userId)
	{
		$query = $this->db
						->where('ideas_id', $ideaId)
						->where('users_id', $userId)
						->get('votes');
						
		if ($query->num_rows() > 0)
			return true;
		else
			return false;				
	}

}