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
    
    public function edit_game_view() {
    	parent::setupMaster();
    	
    	$idMatch = $this->uri->segment(3);
    	$idGame = $this->uri->segment(4);
    	$idSet = $this->uri->segment(5);
    	
    	$this->load->model('Game_model');
    	$games = $this->Game_model->get_games(array('idGame' => $idGame));
    	$game = $games[0];
    	
    	$this->load->model('Team_model');
    	$teams = $this->Team_model->get_teams(array('idMatch' => $idMatch));
    	
    	//Modify game to simply have scores for team1 and team2 in the order we want them
    	$team1Score = 0;
		$team2Score = 0;
		if ($game){
			if ($teams[0]->idTeam == $game->points[0]->idTeam){
				$team1Score = $game->points[0]->points;
				$team2Score = $game->points[1]->points;
			}
			else {
				$team1Score = $game->points[1]->points;
				$team2Score = $game->points[0]->points;
			}
		}
		$game->points = array($team1Score, $team2Score);
    	
    	$this->load->model('Team_model');
    	$teams = $this->Team_model->get_teams(array('idMatch' => $idMatch));
    	
    	$this->load->model('Player_model');
    	$teamIds = array($teams[0]->idTeam,$teams[1]->idTeam);
    	$players = $this->Player_model->get_players(array('idTeam' => $teamIds));
    	
    	$data = array('idMatch' => $idMatch, 
    				  'idSet' => $idSet,
    				  'teams' => $teams, 
    				  'players' => $players,
    				  'game' => $game);
    	
    	$this->masterpage->addContentPage ( 'games/adhoc_match_add_game_view', 'content', $data );
			
	    // Show the masterpage to the world!
	    $this->masterpage->show ( );
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
    	
    	$data = array('idMatch' => $matches[0]->idMatch, 
    				  'teams' => $teams, 
    				  'players' => $players,
    				  'game' => false);
    	
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
      	$teamsWhere['isSingle'] = 1;
      	$teamsWhere['players'] = array(parent::getCurrentPlayerId());
      	$currTeam = $this->Team_model->get_teams($teamsWhere);
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
	
	public function insert_singles_match() {
		
		// Load form validation library
    	$this->load->library("form_validation");
    	
    	// Set up form validation rules
    	$this->form_validation->set_message('is_natural', '%s must be selected.');
    	$this->form_validation->set_rules('player1', 'Player 1', 'is_natural|required');
    	$this->form_validation->set_rules('player2', 'Player 2', 'is_natural|required');
    	$this->form_validation->set_rules('numOfSets', 'Number of Sets', 'is_natural_no_zero|less_than[4]|required');
    	$this->form_validation->set_rules('numOfGames', 'Number of Games', 'is_natural_no_zero|less_than[7]|required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$this->adhoc_match_insert_view();
			
		} else {
			
			$playerOne = $_POST['player1'];
			$playerTwo = $_POST['player2'];
			$numOfSets = $_POST['numOfSets'];
			$numOfGames = $_POST['numOfGames'];
			$court = $_POST['court'];
			
			$matchdata = array(
				'teams'=>array($playerOne,$playerTwo),
				'numberOfSets'=>$numOfSets,
				'numberOfGames'=>$numOfGames,
				'completedDate'=>date("y-m-d h:i a"),
				'scheduledDate'=>date("y-m-d h:i a")
			);
			
			$this->insert_match($matchdata);
			
		}
	}
	
	public function insert_team_match() {
		
		// Load form validation library
    	$this->load->library("form_validation");
    	
    	// Set up form validation rules
    	$this->form_validation->set_message('is_natural', '%s must be selected.');
    	$this->form_validation->set_rules('team1', 'Team 1', 'is_natural|required');
    	$this->form_validation->set_rules('team2', 'Team 2', 'is_natural|required');
    	$this->form_validation->set_rules('numOfSets', 'Number of Sets', 'is_natural_no_zero|less_than[4]|required');
    	$this->form_validation->set_rules('numOfGames', 'Number of Games', 'is_natural_no_zero|less_than[7]|required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$this->adhoc_match_insert_view();
			
		} else {
			
			$teamOne = $_POST['team1'];
			$teamTwo = $_POST['team2'];
			$numOfSets = $_POST['numOfSets'];
			$numOfGames = $_POST['numOfGames'];
			$court = $_POST['court'];
			
			$matchdata = array(
				'teams'=>array($teamOne,$teamTwo),
				'numberOfSets'=>$numOfSets,
				'numberOfGames'=>$numOfGames,
				'completedDate'=>date("y-m-d h:i a"),
				'scheduledDate'=>date("y-m-d h:i a")
			);
			
			$this->insert_match($matchdata);
			
		}
	}
	
	private function insert_match($matchdata) {
		$this->load->model('Match_model');
		$matchID = $this->Match_model->insert_match($matchdata);
		redirect('adhoc_matches');
	}
	
	public function sets() {
		parent::setupMaster();
		
		$idMatch = $this->uri->segment(3);
		$idSet = $this->uri->segment(4);
		
		// Get the match for the set we are looking at
		$this->load->model('Match_model');
		$matches = $this->Match_model->get_match_details(array('matches' => array($idMatch)));
		$match = $matches[0];
		
		$teams = $match->teams;
		$sets = array();
		$setCount = 0;
		foreach ($match->sets as $set) {
			$setCount++;
			$currSet = NULL;
			if (!$idSet || ($idSet && ($set->idSet == $idSet))) {
				$game_scores = array();
				foreach ($set->games as $game) {
					$team1Score = 0;
					$team2Score = 0;
					if ($game->points[0]->idTeam == $teams[0]->idTeam) {
						$team1Score = $game->points[0]->points;
						$team2Score = $game->points[1]->points;
					}
					else {
						$team1Score = $game->points[1]->points;
						$team2Score = $game->points[0]->points;
					}
					$myGame->idGame = $game->idGame;
					$myGame->scores = array($team1Score, $team2Score);
					$game_scores[] = clone $myGame;
				}
				$currSet->idSet = $idSet;
				$currSet->games = $game_scores;
				$currSet->setNum = $setCount;
				
				$sets[] = clone $currSet;
				
				// If we are just looking for an individual set and we found it
				// then no need to look at the rest of the sets
				if ($idSet && ($set->idSet == $idSet)) {
					break;
				}
			}
		}
		
		// Set up info for view
		$data = array('match' => $match, 
					  'teams' => $match->teams,
					  'sets' => $sets);
		
		$this->masterpage->addContentPage ( 'sets/adhoc_set_view', 'content', $data );
		
		// Show the masterpage to the world!
        $this->masterpage->show();
	}
}
?>
