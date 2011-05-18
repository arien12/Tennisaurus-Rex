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
    	$matches = $this->Match_model->get_matches(array('matches' => array($idMatch)));
    	
    	$this->load->model('Team_model');
    	$teams = $this->Team_model->get_teams(array('idMatch' => $matches[0]->idMatch));
    	
    	$data = array('match' => $matches[0], 'teams' => $teams);
    	
    	$this->masterpage->addContentPage ( 'matches/adhoc_match_view', 'content', $data );
			
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
    	
    	$data = array('currSetId' => '101', 'match' => $matches[0], 'teams' => $teams, 'players' => $players);
    	
    	$this->masterpage->addContentPage ( 'games/adhoc_match_add_game_view', 'content', $data );
			
	    // Show the masterpage to the world!
	    $this->masterpage->show ( );
    }
    
    public function add_game() {
    	$matchId = $_POST['matchId'];
    	$team1Score = $_POST['team1Score'];
		$team2Score = $_POST['team2Score'];
		$server = $_POST('server');
		$completedDate = $_POST['completedDate'];
		
		// First we check if we need to create a new set for the game being added.
		$this->load->model('Match_model');
		$matches = $this->Match_model->get_matches(array('idMatch' => $matchId));
		$match = $matches[0];
		
		// Setup the current setId for where the game will be added.
		//$currSetId = $this->Match_model->insert_set($matchId);
		
		// Add the new game to the current set.
		$this->load->model('Game_model');
		
		// Set up team scores to be passed to insert_game method
		$teams = array($match->teams[0]->idTeam => team1Score,
					   $match->teams[0]->idTeam => team2Score );

		// Set up game data to be passed to add insert_game method
		$gamedata = array(
			'idSet'=>$currSetId,
			'idCourt'=>"101",
			'server'=>$server,
			'gameType' => GameType::MIN,
			'teams' => $teams,
			'completedDate'=> $completedDate
		);
		
		$matchID = $this->Match_model->insert_match($matchdata);
		
		redirect('adhoc_matches');
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
      	$currTeamId =  $currTeam[0]->idTeam;
      	
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
			'numOfSets'=>$numOfSets,
			'numOfGames'=>$numOfGames,
			'completedDate'=>date("Y-m-d"),
			'scheduledDate'=>date("Y-m-d")
		);
		
		$matchID = $this->Match_model->insert_match($matchdata);
		
		redirect('adhoc_matches');
	}
}
?>
