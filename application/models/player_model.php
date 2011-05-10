<?php
class Player_model extends CI_Model{

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	/** returns an array of qualified user record objects
	 *
	 * Option: Values
	 * --------------
	 * idPlayer
	 * email
	 * name
	 * password				in MD5 hash
	 * idPlayerType
	 * limit                limits the number of returned records
	 * offset                how many records to bypass before returning a record (limit required)
	 * sortBy                determines which column the sort takes place
	 * sortDirection        (asc, desc) sort ascending or descending (sortBy required)
	 *
	 * Returns (array of objects)
	 * --------------------------
	 * idPlayer
	 * name
	 * email
	 * password
	 * idPlayerType
	 *
	 * @param array $data
	 * @return array result()
	 */
	function get_players($data = array())
	{
		// default values
		$data = $this->_default(array('sortDirection' => 'asc'), $data);

		// Add where clauses to query
		$qualificationArray = array('idPlayer', 'email', 'idPlayerType', 'email');
		foreach($qualificationArray as $qualifier)
		{
			if(isset($data[$qualifier])) $this->db->where($qualifier, $data[$qualifier]);
		}

		// If limit / offset are declared (usually for pagination) then we need to take them into account
		if(isset($data['limit']) && isset($data['offset'])) $this->db->limit($data['limit'], $data['offset']);
		else if(isset($data['limit'])) $this->db->limit($data['limit']);

		// sort
		if(isset($data['sortBy'])) $this->db->order_by($data['sortBy'], $data['sortDirection']);

		$query = $this->db->get('player');
		if($query->num_rows() == 0) return false;

		// returns an array of objects
		return $query->result();
	}


	/**
	 * insert_player method creates a record in the users table.
	 *
	 * Option: Values
	 * --------------
	 * email				(required)
	 * password			(required) in MD5 hash
	 * name				(required)
	 * idPlayerType		(required)
	 *
	 * @param array $data
	 */
	function insert_player($data = array())
	{
		// required values
		if(!$this->_required(array('email', 'name', 'password', 'idPlayerType'), $data)) return false;

		// default values
		//$data = $this->_default(array('userStatus' => 'active'), $data);

		// qualification (make sure that we're not allowing the site to insert data that it shouldn't)
		$qualificationArray = array('email', 'name', 'password', 'idPlayerType');
		foreach($qualificationArray as $qualifier)
		{
			if(isset($data[$qualifier])) $this->db->set($qualifier, $data[$qualifier]);
		}

		// Execute the query
		$this->db->insert('player');

		// Return the ID of the inserted row, or false if the row could not be inserted
		return $this->db->insert_id();
	}



	/**
	 * update_player method alters a record in the users table.
	 *
	 * Option: Values
	 * --------------
	 * idPlayer			(required) the ID of the user record that will be updated
	 * email
	 * password			must be MD5 hash
	 * name
	 * idPlayerType
	 *
	 * @param array $data
	 * @return int affected_rows()
	 */
	function update_player($data = array())
	{
		// required values
		if(!$this->_required(array('idPlayer'), $data)) return false;

		// qualification (make sure that we're not allowing the site to update data that it shouldn't)
		$qualificationArray = array('email', 'name', 'password', 'idPlayerType');
		foreach($qualificationArray as $qualifier)
		{
			if(isset($data[$qualifier])) $this->db->set($qualifier, $data[$qualifier]);
		}

		$this->db->where('idPlayer', $data['idPlayer']);

		// Execute the query
		$this->db->update('player');

		// Return the number of rows updated, or false if the row could not be inserted
		return $this->db->affected_rows();
	}

	/**
	 * NOT YET AVAILABLE (data integrity calls need to be implemented)
	 *
	 * delete_player method removes a record from the users table
	 *
	 * @param array $data
	 */
	/*
	 function delete_player($data = array())
	 {
		// required values
		if(!$this->_required(array('idPlayer'), $data)) return false;

		$this->db->where('idPlayer', $data['idPlayer']);
		$this->db->delete('player');
		}
		*/

	/**
	 * get_types returns an array with data from the playertype table
	 * 
	 * Option: Values
	 * --------------
	 * idPlayerType
	 *
	 * @param array $data
	 * @return array result()
	 */
	function get_types($data = array())
	{
		if (isset($data['idPlayerType'])){
			$this->db->where('idPlayerType', $data('idPlayerType'));
		}
		$query = $this->db->get('playertype');
		// returns an array of objects
		return $query->result();
	}

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