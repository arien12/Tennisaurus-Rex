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
      		view_match($idMatch);
      	}
      	else {
	      	$matches = $this->Match_model->get_matches();
			
			$this->load->model('Team_model');
			$matchList = array();
			foreach ($matches as $match){
				$teams = $this->Team_model->get_teams(array('idMatch' => $match->idMatch));
				array_push($matchList, array('match'=>$match, 'teams'=>$teams));
			}
			
			$data = array('matchList' => $matchList);
			
			$this->masterpage->addContentPage ( 'matches/adhoc_matches_view', 'content', $data );
			
	        // Show the masterpage to the world!
	        $this->masterpage->show ( );
      	}
    }
    
    protected function view_match($idMatch) {
    	$matches = $this->Match_model->get_matches(array('idMatch' => $idMatch));
    	
    	$this->load->model('Team_model');
    	$teams = $this->Team_model->get_teams(array('idMatch' => $matches[1]->idMatch));
    	
    	$data = array('match' => $matches[1], 'teams' => $teams);
    	
    	$this->masterpage->addContentPage ( 'matches/adhoc_match_view', 'content', $data );
			
	    // Show the masterpage to the world!
	    $this->masterpage->show ( );
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
      	$currPlayerId = parent::getCurrentUserId();
      	
      	// Set up info for view
		$data = array('players' => $players, 
					  'teams' => $teams,
					  'currPlayerId' => $currPlayerId);
		
		$this->masterpage->addContentPage ( 'matches/adhoc_match_insert_view', 'content', $data );
		
        // Show the masterpage to the world!
        $this->masterpage->show();
    }
    
	public function insert_player_match ( ) {
		redirect('adhoc_matches');
    }
	
	public function insert_team_match () {
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