<?php
include_once('maincontroller.php');
class Adhoc_Matches extends MainController {
	
    public function __construct ( ) {
        parent::__construct ( );
    }

    public function index ( ) {
      	parent::setupMaster();
		$this->masterpage->addContentPage ( 'matches/adhoc_matches_view', 'content' );
	   
        // Show the masterpage to the world!
        $this->masterpage->show ( );
    }
    
	public function adhoc_match_insert_view ( ) {
      	parent::setupMaster();

      	// Load players
      	$this->load->model('Player_model');
      	$players = $this->Player_model->get_players();
      	
      	// Load teams
      	$this->load->model('Team_model');
      	$teamsWhere = array('isSingle' => 0 );
      	$teams = $this->Team_model->get_teams($teamsWhere);
      	
      	// Find out who the logged in player is
      	$currPlayerId = parent::getCurrentUserId();
      	
      	// Set up infor for view
		$data = array('players' => $players, 
					  'teams' => $teams,
					  'currPlayerId' => $currPlayerId);
		
		$this->masterpage->addContentPage ( 'matches/adhoc_match_insert_view', 'content', $data );
		
        // Show the masterpage to the world!
        $this->masterpage->show();
    }
    
	public function adhoc_match_insert ( ) {
      	
		redirect('adhoc_matches');
    }
	
}
?>