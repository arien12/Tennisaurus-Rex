<?php
include_once('maincontroller.php');
class TournamentController extends MainController {
	
    public function __construct ( ) {
        parent::__construct ( );
    }

    public function index ( ) {
      	parent::setupMaster();
		$this->masterpage->addContentPage ( 'tournament/tournament_view', 'content' );
	   
        // Show the masterpage to the world!
        $this->masterpage->show ( );
    }
	
}
?>