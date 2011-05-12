<?php
include_once('maincontroller.php');
class Team extends MainController {

	public function __construct ( ) {
		parent::__construct ( );
	}

	public function index ( ) {
		parent::setupMaster();
		$this->load->model('Team_model');
		$teamId = array(
      	'idTeam' => $this->uri->segment(2));
			
		$team = $this->Team_model->get_teams($teamId);

		$data = array(
			'name'=>$team[0]->name
		);

		$this->masterpage->addContentPage ( 'team/profile', 'content', $data );

		// Show the masterpage to the world!
		$this->masterpage->show ( );
	}

	public function teamlist(){
		parent::setupMaster();
		$this->load->model('Team_model');
		$teams = $this->Team_model->get_teams();
		$data = array(
			'teams' => $teams
		);
		$this->masterpage->addContentPage ( 'team/list_team', 'content', $data );
		$this->masterpage->show ( );
		
	}
	
	public function createteam(){
		
	}
	
}
?>