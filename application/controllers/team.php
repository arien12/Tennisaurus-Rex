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
			'name'=>$team[0]->name,
			'tag'=>$team[0]->tag,
			'tagline'=>$team[0]->description
		);

		$this->masterpage->addContentPage ( 'team/profile', 'content', $data );

		// Show the masterpage to the world!
		$this->masterpage->show ( );
	}

	public function teamlist(){
		parent::setupMaster();
		$this->load->model('Team_model');
		$teams = $this->Team_model->get_teams();
		if($teams != false){
			$data = array(
			'teams' => $teams
			);
			$this->masterpage->addContentPage ( 'team/list_team', 'content', $data );
			$this->masterpage->show ( );
		}else {
			echo 'fuck';
		}
	}


public function createteam(){
	parent::setupMaster();
	$this->load->model('Player_model');
	
	$data = array(
		'idPlayer'=>$this->session->userdata('idPlayer'),
		'name'=>$this->session->userdata('name'),
		'players'=>$this->Player_model->get_players(),
		'idPlayerType' => $this->session->userdata('idPlayerType')
	);
	$this->masterpage->addContentPage ( 'team/create_team', 'content', $data );
	$this->masterpage->show ( );
}

public function processtc(){
	$playerOne = $_POST['player1'];
	$playerTwo = $_POST['player2'];
	$teamTag = $_POST['teamtag'];
	$tagline = $_POST['tagline'];
	$teamName = $_POST['teamName'];
	$this->load->model('Team_model');
	$players = array($playerOne,$playerTwo);
	if($this->Team_model->get_teams($players) != false){
		$teamdata = array(
		'name'=>$teamName,
		'tag'=>$teamTag,
		'description'=>$tagline,
		'isSingle'=>FALSE,
		'idPlayer1'=>$playerOne,
		'idPlayer2'=>$playerTwo
		);
		$teamID = $this->Team_model->insert_team($teamdata);
		redirect('team/'.$teamID, 'refresh');
	}
}

}
?>