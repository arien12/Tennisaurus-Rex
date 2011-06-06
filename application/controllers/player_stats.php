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
    	
    	$data = array('gamesWon' => $gamesWon, 
    				  'gamesLost' => $gamesLost);
      	
      	$this->masterpage->addContentPage ( 'stats/player_stats_view', 'content', $data );
			
	    // Show the masterpage to the world!
	    $this->masterpage->show ( );
    }
}
?>
