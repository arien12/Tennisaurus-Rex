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

      	$this->load->model('Player_model');
		$data = array('players' => $this->Player_model->get_players());
		
		$this->masterpage->addContentPage ( 'matches/adhoc_match_insert_view', 'content', $data );
		
        // Show the masterpage to the world!
        $this->masterpage->show();
    }
    
	public function adhoc_match_insert ( ) {
      	
		redirect('adhoc_matches');
    }
	
}
?>