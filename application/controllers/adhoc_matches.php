<?php
include_once('maincontroller.php');
class Adhoc_Matches extends MainController {
	
    public function __construct ( ) {
        parent::__construct ( );
    }

    public function index ( ) {
      	parent::setupMaster();
      	
      	$this->load->model('Match_model');
      	
      	$idMatch = $this->uri->segment(2);
      	if ($idMatch) {
      		$this->view_match($idMatch);
      	}
      	else {
			$this->view_matches();
      	}
    }
    
	private function view_matches() {
		$matches = $this->Match_model->get_matches();
			
		$this->load->model('Team_model');
		$matchList = array();
		if ($matches) {
			foreach ($matches as $match){
				$teams = $this->Team_model->get_teams(array('idMatch' => $match->idMatch));
				array_push($matchList, array('match'=>$match, 'teams'=>$teams));
			}
		}
			
		$data = array('matchList' => $matchList);
			
		$this->masterpage->addContentPage ( 'matches/adhoc_matches_view', 'content', $data );
			
	    // Show the masterpage to the world!
	    $this->masterpage->show ( );
    }
    
    private function view_match($idMatch) {
    	$matches = $this->Match_model->get_match_details(array('matches' => array($idMatch)));
    	$match = $matches[0];
    	
    	$this->load->model('Team_model');
    	$teams = $this->Team_model->get_teams(array('idMatch' => $matches[0]->idMatch));
    	
    	// Make a summary of the games for the sets of this match
    	$sets = array();
    	$team1Total = 0;
    	$team2Total = 0;
    	foreach ($match->sets as $set) {
    		$set_score = $this->get_set_score($set, $teams);
    		if ($set_score) {
				array_push($sets, $set_score);
				if ($this->is_set_complete($set_score, $match->numberOfGames)) {
					if ($set_score[0] > $set_score[1]) {
	    				$team1Total++;
	    			}
		    		else {
		    			$team2Total++;
		    		}
				}
    		}
    	}
    	$total = array($team1Total, $team2Total);
    	
    	// Check if the match is completed
    	$isMatchCompleted = false;
    	$winner = NULL;
    	if ($team1Total == $match->numberOfSets) {
    		$isMatchCompleted = true;
    		$winner = $teams[0];
    	}
   		 if ($team2Total == $match->numberOfSets) {
    		$isMatchCompleted = true;
    		$winner = $teams[1];
    	}
    	
    	$data = array('match' => $match, 
    				  'teams' => $teams, 
    				  'sets' => $sets, 
    				  'total' => $total,
    				  'isMatchCompleted' => $isMatchCompleted,
    				  'winner' => $winner);
    	
    	$this->masterpage->addContentPage ( 'matches/adhoc_match_view', 'content', $data );
			
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
    
    public function add_game_view() {
    	parent::setupMaster();
    	
    	$idMatch = $this->uri->segment(3);
    	
    	$this->load->model('Match_model');
    	$matches = $this->Match_model->get_matches(array('matches' => array($idMatch)));
    	
    	$this->load->model('Team_model');
    	$teams = $this->Team_model->get_teams(array('idMatch' => $idMatch));
    	
    	$this->load->model('Player_model');
    	$teamIds = array($teams[0]->idTeam,$teams[1]->idTeam);
    	$players = $this->Player_model->get_players(array('idTeam' => $teamIds));
    	
    	$data = array('currSetId' => '101', 'match' => $matches[0], 'teams' => $teams, 'players' => $players);
    	
    	$this->masterpage->addContentPage ( 'games/adhoc_match_add_game_view', 'content', $data );
			
	    // Show the masterpage to the world!
	    $this->masterpage->show ( );
    }
    
    public function add_game() {
    	
    	// Grab form values for adding a new game
    	$matchId = $_POST['matchId'];
    	$team1Score = $_POST['team1Score'];
		$team2Score = $_POST['team2Score'];
		$server = $_POST['server'];
		$completedDate = $_POST['completedDate'];
		
		// Grab the match details for the match we want to add a game for
		$this->load->model('Match_model');
		$matches = $this->Match_model->get_match_details(array('matches' => array($matchId)));
		$match = $matches[0];
		
		// Setup the current setId for where the game will be added.
		$currSetId = -1;
		foreach ($match->sets as $set) {
			$set_score = $this->get_set_score($set, $match->teams);
			if (!$this->is_set_complete($set_score, $match->numberOfGames)) {
				$currSetId = $set->idSet;
			}
		}
		if ($currSetId < 0) {
			$currSetId = $this->Match_model->insert_set($matchId);
		}
		
		// Load the game model so we can add a game
		$this->load->model('Game_model');
		
		// Set up team scores to be passed to insert_game method
		$teams = array($match->teams[0]->idTeam => $team1Score,
					   $match->teams[1]->idTeam => $team2Score );

		// Set up game data to be passed to add insert_game method
		$gamedata = array(
			'idSet'=>$currSetId,
			'idCourt'=>"1",
			'server'=>$server,
			'gameType' => GameType::MIN,
			'teams' => $teams,
			'completedDate'=> $completedDate
		);
		
		// Add the new game to the current set.
		$matchID = $this->Game_model->insert_game($gamedata);
		
		// If adding this game completes the set we can make the set completed
		if ($match->numberOfGames)
		
		
		redirect('adhoc_matches/'.$matchId);
    }
    
	public function adhoc_match_insert_view ( ) {
      	parent::setupMaster();

      	$this->load->model('Team_model');
      	
      	// Load singles teams
      	$teamsWhere = array('isSingle' => 1 );
      	$players = $this->Team_model->get_teams($teamsWhere);
      	
      	// Load doubles teams
      	$teamsWhere = array('isSingle' => 0 );
      	$teams = $this->Team_model->get_teams($teamsWhere);
      	
      	// Find out who the logged in player is
      	$currTeam = $this->Team_model->get_teams(array('idTeam' => parent::getCurrentUserId()));
      	$currTeamId = '';
      	if ($currTeam){
      		$currTeamId = $currTeam[0]->idTeam;
      	}
      	
      	
      	// Set up info for view
		$data = array('players' => $players, 
					  'teams' => $teams,
					  'currTeamId' => $currTeamId);
		
		$this->masterpage->addContentPage ( 'matches/adhoc_match_insert_view', 'content', $data );
		
        // Show the masterpage to the world!
        $this->masterpage->show();
    }
	
	public function insert_match() {

		$teamOne = $_POST['team1'];
		$teamTwo = $_POST['team2'];
		$numOfSets = $_POST['numOfSets'];
		$numOfGames = $_POST['numOfGames'];
		$court = $_POST['court'];
		
		$this->load->model('Match_model');
		
		$matchdata = array(
			'teams'=>array($teamOne,$teamTwo),
			'numberOfSets'=>$numOfSets,
			'numberOfGames'=>$numOfGames,
			'completedDate'=>date("y-m-d h:i a"),
			'scheduledDate'=>date("y-m-d h:i a")
		);
		
		$matchID = $this->Match_model->insert_match($matchdata);
		
		redirect('adhoc_matches');
	}
}
?>
