<?php
include_once('maincontroller.php');
class Player extends MainController {

	public function __construct ( ) {
		parent::__construct ( );
	}

	public function index ( ) {
		parent::setupMaster();
		$this->load->model('Player_model');
		$playerId = array(
      	'idPlayer' => $this->uri->segment(2));
			
		$players = $this->Player_model->get_players($playerId);

		$data = array(
      		'name' => $players[0]->name,
      		'email' => $players[0]->email,
			'idPlayerType' => $this->session->userdata('idPlayerType')
		);
		$this->masterpage->addContentPage ( 'player/profile', 'content', $data );

		// Show the masterpage to the world!
		$this->masterpage->show ( );
	}

	public function playerlist(){
		parent::setupMaster();
		$this->load->model('Player_model');
		$players = $this->Player_model->get_players();
		$data = array(
			'players' => $players
		);
		$this->masterpage->addContentPage ( 'player/player_list', 'content', $data );
		$this->masterpage->show ( );
	}
}
?>