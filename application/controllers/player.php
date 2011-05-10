<?php
include_once('maincontroller.php');
class Player extends MainController {
	
    public function __construct ( ) {
        parent::__construct ( );
    }

    public function index ( ) {
      parent::setupMaster();
      	$this->load->model('Player');
      	$playerId = array(
      	'idPlayer' => $this->uri->segment(2));
      	
		$players = $this->Player->get_players($playerId);
            
      	$data = array(
      		'name' => $players[0]->name,
      		'email' => $players[0]->email
      	);
		$this->masterpage->addContentPage ( 'player/profile', 'content', $data );
	   
        // Show the masterpage to the world!
        $this->masterpage->show ( );
    }
}
?>