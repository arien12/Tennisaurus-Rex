<?php
class Team extends CI_Model{

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	/** returns an array of qualified user record objects
	 *
	 * Option: Values
	 * --------------
	 * idTeam
	 * name
	 * tag
	 * isSingle
	 * idPlayer
	 * limit                limits the number of returned records
	 * offset                how many records to bypass before returning a record (limit required)
	 * sortBy                determines which column the sort takes place
	 * sortDirection        (asc, desc) sort ascending or descending (sortBy required)
	 *
	 * Returns (array of objects)
	 * --------------------------
	 * idTeam
	 * name
	 * description
	 * tag
	 * isSingle
	 *
	 * @param array $data
	 * @return array result()
	 */
	function get_teams($data = array())
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


	/**
	 * insert_player method creates a record in the users table.
	 *
	 * Option: Values
	 * --------------
	 * name			(required)
	 * tag			(required)
	 * description	(required)
	 * isSingle		(required)
	 * idPlayer1	(required)
	 * idPlayer2	(only required if isSingle is false)
	 *
	 * @param array $data
	 */
	function insert_team($data = array())
	{
		// required values
		$req_array = array('name', 'tag', 'description', 'isSingle', 'idPlayer1');
		if (!$data['isSingle']) $req_array[] = 'idPlayer2';
		if(!$this->_required($req_array, $data)) return false;

		// default values
		//$data = $this->_default(array('userStatus' => 'active'), $data);

		// qualification (make sure that we're not allowing the site to insert data that it shouldn't)
		$qualificationArray = array('name', 'tag', 'description', 'isSingle');
		foreach($qualificationArray as $qualifier)
		{
			if(isset($data[$qualifier])) $this->db->set($qualifier, $data[$qualifier]);
		}

		// Execute the query
		$this->db->insert('team');
		$new_team_id = $this->db->insert_id();
		$this->db->set('idPlayer', $data['idPlayer1']);
		$this->db->set('idTeam', $new_team_id);
		$this->db->insert('playerteam');
		if(!$data['isSingle']){
			$this->db->set('idPlayer', $data['idPlayer2']);
			$this->db->set('idTeam', $new_team_id);
			$this->db->insert('playerteam');
		}
		// Return the ID of the inserted row, or false if the row could not be inserted
		return $new_team_id;
	}



	/**
	 * update_team method alters a record in the users table.
	 *
	 * Option: Values
	 * --------------
	 * idTeam		(required)
	 * name
	 * tag
	 * description
	 *
	 * @param array $data
	 * @return int affected_rows()
	 */
	function update_team($data = array())
	{
		// required values
		if(!$this->_required(array('idTeam'), $data)) return false;

		// qualification (make sure that we're not allowing the site to update data that it shouldn't)
		$qualificationArray = array('name', 'tag', 'description');
		foreach($qualificationArray as $qualifier)
		{
			if(isset($data[$qualifier])) $this->db->set($qualifier, $data[$qualifier]);
		}

		$this->db->where('idTeam', $data['idTeam']);

		// Execute the query
		$this->db->update('team');

		// Return the number of rows updated, or false if the row could not be inserted
		return $this->db->affected_rows();
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