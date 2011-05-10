<?php
class Match_model extends CI_Model{

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	/** get_match_details returns an array of detailed match objects
	 *
	 * Option: Values
	 * --------------
	 * idMatch
	 * numberOfSets
	 * numberOfGames
	 * completedDate
	 * scheduledDate
	 * idPlayer
	 * idTeam
	 * idGame
	 * idSet
	 * idRound
	 * idTournament
	 * limit                limits the number of returned records
	 * offset                how many records to bypass before returning a record (limit required)
	 * sortBy                determines which column the sort takes place
	 * sortDirection        (asc, desc) sort ascending or descending (sortBy required)
	 *
	 * Returns (array of objects)
	 * --------------------------
	 * idMatch
	 * numberOfSets
	 * numberOfGames
	 * completedDate
	 * scheduledDate
	 * idRound
	 *
	 * teams (array)
	 * 	name
	 * 	tag
	 * 	isSingle
	 * 	players (array)
	 * 		idPlayer
	 * 		name
	 *
	 * tournament (array)
	 * 	idTournament
	 * 	name
	 *
	 * sets (array)
	 * 	idSet
	 * 	completedDate
	 * 	games (array)
	 * 		idGame
	 * 		idServingTeam
	 * 		idReceivingTeam
	 * 		pointsServingTeam
	 * 		pointsReceivingTeam
	 * 		server (array)
	 * 			idPlayer
	 * 			name
	 *
	 * @param array $data
	 * @return array result()
	 */
	
	/* NOT READY YET!
	function get_match_details($data = array())
	{
		// default values
		$data = $this->_default(array('sortDirection' => 'asc'), $data);

		// Add where clauses to query
		$qualificationArray = array('idTeam', 'name', 'isSingle', 'tag');
		foreach($qualificationArray as $qualifier)
		{
			if(isset($data[$qualifier])) $this->db->where($qualifier, $data[$qualifier]);
		}

		//join to PlayerTeam is idPlayer specified
		if(isset($data['idPlayer'])){
			$this->db->join('playerteam', 'idPlayer = ' . $data['idPlayer'] . ' AND playerteam.idTeam = team.idTeam');
		}

		// If limit / offset are declared (usually for pagination) then we need to take them into account
		if(isset($data['limit']) && isset($data['offset'])) $this->db->limit($data['limit'], $data['offset']);
		else if(isset($data['limit'])) $this->db->limit($data['limit']);

		// sort
		if(isset($data['sortBy'])) $this->db->order_by($data['sortBy'], $data['sortDirection']);

		$query = $this->db->get('team');
		if($query->num_rows() == 0) return false;

		// returns an array of objects
		return $query->result();
	}
	*/


	/**
	 * insert_player method creates a record in the users table.
	 *
	 * Option: Values
	 * --------------
	 * teams (array)	(required)
	 * 	idTeam
	 * numberOfSets
	 * numberOfGames
	 * completedDate
	 * scheduledDate
	 * idRound
	 *
	 * @param array $data
	 */
	function insert_match($data = array())
	{
		// required values
		if(!$this->_required(array('teams'), $data)) return false;

		//requires 2 teams
		if(!(count($data['teams']) == 2)) return false;

		// default values
		//$data = $this->_default(array('userStatus' => 'active'), $data);

		// qualification (make sure that we're not allowing the site to insert data that it shouldn't)
		$qualificationArray = array('numberOfSets', 'numberOfGames', 'completedDate', 'scheduledDate');
		foreach($qualificationArray as $qualifier)
		{
			if(isset($data[$qualifier])) $this->db->set($qualifier, $data[$qualifier]);
		}

		// Execute the query
		$this->db->insert('match');
		$new_match_id = $this->db->insert_id();
		foreach($data['teams'] as $idTeam ){
			$this->db->set('idTeam', $idTeam);
			$this->db->set('idMatch', $new_match_id);
			$this->db->insert('teammatch');
		}
		if (isset($data['idRound'])){
			$this->db->set('idRound', $data['idRound']);
			$this->db->set('idMatch', $new_match_id);
			$this->db->insert('roundmatch');
		}
		// Return the ID of the inserted row, or false if the row could not be inserted
		return $new_match_id;
	}



	/**
	 * update_match method alters a record in the users table.
	 *
	 * Option: Values
	 * --------------
	 * idMatch		(required)
	 * numberOfSets
	 * numberOfGames
	 * completedDate
	 * scheduledDate
	 * idRound
	 * teams (array)
	 * 	idTeam
	 *
	 * @param array $data
	 * @return int affected_rows()
	 */
	function update_team($data = array())
	{
		// required values
		if(!$this->_required(array('idMatch'), $data)) return false;

		// qualification (make sure that we're not allowing the site to update data that it shouldn't)
		$qualificationArray = array('numberOfSets', 'numberOfGames', 'completedDate', 'scheduledDate');
		foreach($qualificationArray as $qualifier)
		{
			if(isset($data[$qualifier])) $this->db->set($qualifier, $data[$qualifier]);
		}

		$this->db->where('idMatch', $data['idMatch']);

		// Execute the query
		$this->db->update('match');
		$affectedCount = 0;
		if($this->db->affected_rows() == false) return false;
		$affectedCount += $this->db->affected_rows();

		if(isset($data['idRound'])){

			$this->db->where('idMatch', $data['idMatch']);
			$this->db->set('idRound', $data['idRound']);
			$this->db->update('roundmatch');
			if($this->db->affected_rows() == false) return false;
			$affectedCount += $this->db->affected_rows();
		}
		if(isset($data['teams']) && count($data['teams'] == 2)){

			$this->db->where('idMatch', $data['idMatch']);
			$this->db->delete('teammatch');
			if($this->db->affected_rows() == false) return false;
			$affectedCount += $this->db->affected_rows();
			foreach($data['teams'] as $idTeam ){
				$this->db->set('idTeam', $idTeam);
				$this->db->set('idMatch', $data['idMatch']);
				$this->db->insert('teammatch');
				if($this->db->affected_rows() == false) return false;
				$affectedCount += $this->db->affected_rows();
			}
		}

		// Return the number of rows updated, or false if the row could not be inserted
		return affectedCount;
	}

	/**
	 *
	 * NOT YET AVAILABLE (data integrity calls need to be implemented)
	 *
	 * delete_team method removes a record from the team table
	 *
	 * @param array $data
	 */
	/*
	 function delete_team($data = array())
	 {
		// required values
		if(!$this->_required(array('idTeam'), $data)) return false;

		$this->db->where('idTeam', $data['idTeam']);
		$this->db->delete('team');
		}
		*/


	//utility methods

	/**
	 * _required method returns false if the $data array does not contain all of the keys assigned by the $required array.
	 *
	 * @param array $required
	 * @param array $data
	 * @return bool
	 */
	function _required($required, $data)
	{
		foreach($required as $field) if(!isset($data[$field])) return false;
		return true;
	}

	/**
	 * _default method combines the options array with a set of defaults giving the values in the options array priority.
	 *
	 * @param array $defaults
	 * @param array $data
	 * @return array
	 */
	function _default($defaults, $data)
	{
		return array_merge($defaults, $data);
	}

}