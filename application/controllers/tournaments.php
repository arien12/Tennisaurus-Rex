<?php
include_once('maincontroller.php');
class Tournaments extends MainController {
	
    public function __construct ( ) {
        parent::__construct ( );
    }

    public function index ( ) {
      	parent::setupMaster();
		$this->masterpage->addContentPage ( 'tournament/tournament_view', 'content' );
	   
        // Show the masterpage to the world!
        $this->masterpage->show ( );
    }
    
	public function tournament_insert ( ) {
      	parent::setupMaster();
      	
		$data['query'] = $this->db->get("tournamenttype");
		
		$this->masterpage->addContentPage ( 'tournament/tournament_insert_view', 'content', $data );
		
        // Show the masterpage to the world!
        $this->masterpage->show();
    }
	
}
?>