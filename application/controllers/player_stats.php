<?php
include_once('maincontroller.php');
class Player_Stats extends MainController {
	
    public function __construct ( ) {
        parent::__construct ( );
    }

    public function index ( ) {
      	parent::setupMaster();
      	
      	// Find out who the logged in player is
    	$this->load->model('Team_model');
    	$teamWhere = array (
			'players' => array(parent::getCurrentPlayerId()),
			'isSingle' => 1
    	);
      	$currTeams = $this->Team_model->get_teams($teamWhere);
      	$currTeam = $currTeams[0];
      	
      	$this->load->model('Game_model');
    	$games = $this->Game_model->get_games(array('teams' => array($currTeam->idTeam)));
    	
    	$gamesWon = 0;
    	$gamesLost = 0;
      	foreach ($games as $game) {
      		if ($game->points[0]->idTeam == $currTeam->idTeam) {
      			if (intval($game->points[0]->points) > intval($game->points[1]->points)) {
      				$gamesWon++;
      			}
      			else {
      				$gamesLost++;	
      			}
      		}
      		else {
      			if (intval($game->points[0]->points) > intval($game->points[1]->points)) {
      				$gamesLost++;
      			}
      			else {
      				$gamesWon++;	
      			}
      		}
      	}
      	
      	$this->load->model('Match_model');
      	$matches = $this->Match_model->get_match_details(array('teams' => array($currTeam->idTeam)));
      	
    	// Setup the current setId for where the game will be added.
    	$matchesWon = 0;
    	$matchesLost = 0;
    	$matchesIncomplete = 0;
    	foreach ($matches as $match) {
    		$matchOngoing = false;
    		$setsWon = 0;
	    	foreach ($match->sets as $set) {
				$set_score = $this->get_set_score($set, $match->teams);
				
				// Is this set ongoing?
				if (!$this->is_set_complete($set_score, $match->numberOfGames)) {
					$matchOngoing = true;
					break;
				}
				// Did the player win this completed set?
				else {
					if ($match->teams[0]->idTeam = $currTeam->idTeam) {
						if ($set_score[0] > $set_score[1]) {
							$setsWon++;
						}
					}
					else {
						if ($set_score[1] > $set_score[0]) {
							$setsWon++;
						}
					}
				}
			}
			
			// We found an ongoing set so the match is obviously not completed. Check the next one
			if ($matchOngoing) {
				$matchesIncomplete++;
			}
			// See who won this match
    	    elseif (($match->numberOfSets == count($match->sets)) && ($setsWon = $match->numberOfSets)) {
    			$matchesWon++;
    	    }
    	    else {
    	    	$matchesLost++;
    		}
    	}
    	
    	$data = array('gamesWon' => $gamesWon, 
    				  'gamesLost' => $gamesLost,
    				  'matchesWon' => $matchesWon,
    				  'matchesLost' => $matchesLost,
    				  'matchesIncomplete' => $matchesIncomplete);
      	
      	$this->masterpage->addContentPage ( 'stats/player_stats_view', 'content', $data );
			
	    // Show the masterpage to the world!
	    $this->masterpage->show ( );
    }
    
    /*
     * Gets the team scores for a set.
     * 
     * Returns
     * scores (array)
     *   idTeam
     *   points
     */
    private function get_set_score($set, $teams) {
		
		if (!$set->games) return false;
		
		$team1Games = 0;
		$team2Games = 0;
		foreach ($set->games as $game) {
			if ($game->points[0]->points > $game->points[1]->points) {
				if ($game->points[0]->idTeam == $teams[0]->idTeam) {
					$team1Games++;
				}
				else {
					$team2Games++;	
				}
			}
			else {
				if ($game->points[1]->idTeam == $teams[1]->idTeam) {
					$team2Games++;	
				}
				else {
					$team1Games++;	
				}
			}
		}
		return array($team1Games,$team2Games);
    }
    
	private function is_set_complete($score, $numOfGames) {
		if (($score[0] == $numOfGames) || ($score[1] == $numOfGames)) {
			return true;
		}
		return false;
    }
}
?>
