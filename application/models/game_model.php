<?php
class Game_model extends CI_Model{

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	/** get_game_details returns an array of detailed game objects
	 *
	 * Option: Values
	 * --------------
	 * idGame
	 * server			id of a player
	 * completedDate	associative array for the date range (inclusive)
	 * 	min
	 * 	max
	 * teams			(array of ints - ONE or TWO team ids)
	 * idCourt
	 * idSet
	 * gameType			eg: GameType::SEQ GameType::NONSEQ GameType::MIN
	 * limit			limits the number of returned records
	 * offset			how many records to bypass before returning a record (limit required)
	 * sortBy			determines which column the sort takes place
	 * sortDirection	(asc, desc) sort ascending or descending (sortBy required)
	 *
	 * Returns (array of objects)
	 * --------------------------
	 * idGame
	 * server
	 * points (array of objects)
	 * 	idTeam
	 * 	points
	 * idSet
	 * idCourt
	 * completedDate
	 *
	 *
	 * @param array $data
	 * @return array qualified game models
	 */

	function get_games($data = array())
	{
		// default values
		$data = $this->_default(array('sortDirection' => 'asc'), $data);

		//select one game by it's id
		if(isset($data['idGame'])){
			$this->db->where('idGame', $data['idGame']);
			$query = $this->db->get('game');
			if($query->num_rows() == 0) return false;

			// returns an array of objects
			return $query->result();

		}

		//restrict by teams can also be "single teams"
		if(isset($data['teams'])){
			if(count($data['teams']) > 1){
				$this->db->where('idTeam', $data['teams'][0]);
				$query = $this->db->get('teamgame');
				$TeamOneGameIds = "";
				foreach($query->result() as $teamgame){
					$TeamOneGameIds .= $teamgame->idTeam . ',';
				}
				$TeamOneGameIds = rtrim($playerOneTeamIds, ',');
				$this->db->join('teamgame', 'teamgame.idGame = game.idGame AND teamgame.idGame in ('.$TeamOneGameIds.') AND idTeam = ' . $data['teams'][1]);
			}
			elseif(count($data['teams']) == 1){
				$this->db->join('teamgame', 'teamgame.idGame = game.idGame AND idTeam = ' . $data['teams'][0]);
			}
		}


		//prevent duplicates from the joins
		$this->db->distinct('idGame, server, idSet, idCourt, completedDate');

		// Add ranged where clauses to query (inclusive)
		$qualificationRangeArray = array('completedDate');
		foreach($qualificationRangeArray as $qualifier)
		{
			if(isset($data[$qualifier])){
				$this->db->where($qualifier . ' >=',$data[$qualifier]['min'] );
				$this->db->where($qualifier . ' <=',$data[$qualifier]['max'] );
			}
		}

		// Add where clauses to query
		$qualificationArray = array('idSet', 'idCourt', 'server', 'gameType');
		foreach($qualificationArray as $qualifier)
		{
			if(isset($data[$qualifier])) $this->db->where($qualifier, $data[$qualifier]);
		}

		// If limit / offset are declared (usually for pagination) then we need to take them into account
		if(isset($data['limit']) && isset($data['offset'])) $this->db->limit($data['limit'], $data['offset']);
		else if(isset($data['limit'])) $this->db->limit($data['limit']);

		// sort
		if(isset($data['sortBy'])) $this->db->order_by($data['sortBy'], $data['sortDirection']);

		$query = $this->db->get('game');
		if($query->num_rows() == 0) return false;

		$result = $query->result();
		
		foreach($result as $aGame){
			$this->db->select('idTeam, points');
			$this->db->where('idGame', $aGame->idGame);
			$newQuery = $this->db->get('teamgame');
			$aGame->points = $newQuery->result(); 
		}
		
		// returns an array of objects
		return $result;
	}



	/**
	 * insert_game method creates a record in the users table.
	 *
	 * Option: Values
	 * --------------
	 * idSet									(required)
	 *
	 * idCourt									(required
	 *
	 * server									(required)
	 *
	 * gameType									(required)
	 *
	 * teams (assoc array)						(required)
	 * 	idTeam => points (int)
	 *
	 * events (assoc array)						(required if gameType != MIN)
	 * 	idTeam => eventList (array)
	 * 				event (assoc array)
	 * 					idEventType (int)
	 * 					value (int)
	 * 					sequenceNumber (int)
	 *
	 * completedDate
	 *
	 * @param array $data
	 */
	function insert_game($data = array())
	{
		// required values
		if(!$this->_required(array('idSet','idCourt','server','teams','gameType'), $data)) return false;

		//requires 2 teams
		if(count($data['teams']) != 2) return false;
		if($data['gameType'] != GameType::MIN && !isset($data['events'])) return false;

		// default values
		$data = $this->_default(array('completedDate' => date('y-m-d h:i:s')), $data);
		$data['completedDate'] = convert_to_utc($data['completedDate']);

		// qualification (make sure that we're not allowing the site to insert data that it shouldn't)
		$qualificationArray = array('idSet', 'idCourt', 'server', 'completedDate', 'gameType');
		foreach($qualificationArray as $qualifier)
		{
			if(isset($data[$qualifier])) $this->db->set($qualifier, $data[$qualifier]);
		}

		// Execute the query
		$this->db->insert('game');
		$new_game_id = $this->db->insert_id();

		if($new_game_id != false){
			foreach($data['teams'] as $idTeam => $points ){
				$this->db->set('idTeam', $idTeam);
				$this->db->set('idGame', $new_game_id);
				$this->db->set('points', $points);
				$this->db->insert('teamgame');
			}

			if($data['gameType'] != GameType::MIN){
				if (isset($data['events'])){
					foreach($data['events'] as $idTeam => $eventList){
						foreach($eventList as $event){
							$this->db->set('idGame', $new_game_id);
							$this->db->set('idTeam', $idTeam);
							$this->db->set('idEventType', $event->idEventType);
							if(isset($event->sequenceNumber)) $this->db->set('sequenceNumber', $event->sequenceNumber);
							if(isset($event->value)) $this->db->set('value', $event->value);
							$this->db->insert('gameevent');
						}
					}
				}
			}
		}

		// Return the ID of the inserted row, or false if the row could not be inserted
		return $new_game_id;
	}
	
	

	/**
	 * update_game method alters a record in the users table.
	 *
	 * Option: Values
	 * --------------
	 * idGame		(required)
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
	/* Not implemented yet

	 function update_game($data = array())
	 {
		// required values
		if(!$this->_required(array('idGame'), $data)) return false;

		// qualification (make sure that we're not allowing the site to update data that it shouldn't)
		$qualificationArray = array('numberOfSets', 'numberOfGames', 'completedDate', 'scheduledDate');
		foreach($qualificationArray as $qualifier)
		{
		if(isset($data[$qualifier])) $this->db->set($qualifier, $data[$qualifier]);
		}

		$this->db->where('idGame', $data['idGame']);

		// Execute the query
		$this->db->update('game');
		$affectedCount = 0;
		if($this->db->affected_rows() == false) return false;
		$affectedCount += $this->db->affected_rows();

		if(isset($data['idRound'])){

		$this->db->where('idGame', $data['idGame']);
		$this->db->set('idRound', $data['idRound']);
		$this->db->update('roundgame');
		if($this->db->affected_rows() == false) return false;
		$affectedCount += $this->db->affected_rows();
		}
		if(isset($data['teams']) && count($data['teams'] == 2)){

		$this->db->where('idGame', $data['idGame']);
		$this->db->delete('teamgame');
		if($this->db->affected_rows() == false) return false;
		$affectedCount += $this->db->affected_rows();
		foreach($data['teams'] as $idTeam ){
		$this->db->set('idTeam', $idTeam);
		$this->db->set('idGame', $data['idGame']);
		$this->db->insert('teamgame');
		if($this->db->affected_rows() == false) return false;
		$affectedCount += $this->db->affected_rows();
		}
		}

		// Return the number of rows updated, or false if the row could not be inserted
		return affectedCount;
		}
		*/
	
	
	/**
	 *
	 * NOT YET AVAILABLE (data integrity calls need to be implemented)
	 *
	 * delete_team method removes a record from the team table
	 *
	 * @param array $data
	 */
	/*@TODO: Finish Game_model->delete_game
	 function delete_game($data = array())
	 {
		// required values
		if(!$this->_required(array('idGame'), $data)) return false;

		$this->db->where('idGame', $data['idGame']);
		$this->db->delete('game');
		}
		*/


	/**
	 * get_courts returns an array of court information
	 * 
	 * Returns (array of objects)
	 * --------------------------
	 * idCourt
	 * name
	 * description
	 * alias 
	 * 
	 *  @param idCourt
	 *  @return array of court objects or false if no results
	 */
	function get_courts($idCourt = -1){
		if ($idCourt > -1) $this->db->where('idCourt', $idCourt);
		$query = $this->db->get('court');
		if($query->num_rows() == 0) return false;
		return $query->result();
	}
	
	function update_court($data = Array()){
		// required values
		if(!$this->_required(array('idCourt'), $data)) return false;

		// qualification (make sure that we're not allowing the site to update data that it shouldn't)
		$qualificationArray = array('name', 'description', 'alias');
		foreach($qualificationArray as $qualifier)
		{
		if(isset($data[$qualifier])) $this->db->set($qualifier, $data[$qualifier]);
		}

		$this->db->where('idCourt', $data['idCourt']);

		// Execute the query
		$this->db->update('court');
		return $this->db->affected_rows();		
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

class GameType {
	const SEQ = 1;
	const NONSEQ = 2;
	const MIN = 3;
}

//end of game_model.php
