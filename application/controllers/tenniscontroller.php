<?php
include_once('maincontroller.php');
class TennisController extends MainController {
	
    public function __construct ( ) {
        parent::__construct ( );
    }

    public function index ( ) {
      parent::setupMaster();
		$this->masterpage->addContentPage ( 'common/content', 'content' );
	   
        // Show the masterpage to the world!
        $this->masterpage->show ( );
    }
	
	public function register( ) {
		parent::setupMaster();
		$this->masterpage->addContentPage ( 'common/register', 'content' );
	   
        // Show the masterpage to the world!
        $this->masterpage->show ( );
	}
	
	public function processregistration(){

		//TODO::add a captcha, validation, send an email
	$this->load->library("form_validation");
		
		$fields['name'] = 'name';
		$fields['password'] = 'password';
		$fields['passwordvalidation'] = 'passwordvalidation';
		$fields['email'] = 'email';
		$this->form_validation->set_fields($fields);

		$rules['name'] = 'trim|required';
		$rules['password'] = 'trim|required|matches[passwordvalidation]';
		$rules['passwordvalidation'] = 'trim|required';
		$rules['email'] = 'trim|required|valid_email';
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE) {
			$data = array(
			'name' => $this->form_validation->name_error, 
			'password' => $this->form_validation->password_error, 
			'email' => $this->form_validation->email_error
			);
			echo json_encode($data);
		} else {
			$this->load->model('Player_model');
			$nameCheckArray = array('name'=>$_POST['name']);
			$nameCheck = $this->Player_model->get_players($nameCheckArray);
			$emailCheckArray = array('email'=>$_POST['email']);
			$emailCheck = $this->Player_model->get_players($emailCheckArray);
			if($nameCheck == FALSE && $emailCheck == false){
				$data = array();
				$data['name'] = $_POST['name'];
				$data['email'] = $_POST['email'];
				$this->load->helper('Security');
				$data['password'] = do_hash($_POST['password'], 'md5');
				$data['idPlayerType'] = 1;

				$playerId = array('idPlayer' => $this->Player_model->insert_player($data));
				if($playerId['idPlayer']== False)
				{
					redirect('tenniscontroller/register', 'refresh');
				}
				else{
					$players = $this->Player_model->get_players($playerId);
					if(count($players) != 1)
					{
						//@TODO::add an error page
						redirect('tenniscontroller/register', 'refresh');
					}
					else{
						$this->load->model('Team_model');
						$insertTeamData = array(
				'name'=>$players[0]->name,
				'tag'=> NULL,
				'desc'=>'',
				'isSingle'=>TRUE,
				'idPlayer1'=>$players[0]->idPlayer
						);
						$this->Team_model->insert_team($insertTeamData);
						parent::addSessionInfo($players[0]->name, $players[0]->idPlayer, $players[0]->idPlayerType);
						redirect('tenniscontroller/index', 'refresh');
					}
				}

			}else{
				$data = array(
			'name' => $this->validation->already_exists, 
			'email' => $this->validation->already_exists
			);
			echo json_encode($data);
			}
		} 
		
	}
	
	public function login() {
		$this->load->helper('Security');
		$data['email'] = $_POST['emailInput'];
		$password = do_hash($_POST['passwordInput'], 'md5');
		
		$this->load->model('Player_model');
		$players = $this->Player_model->get_players($data);
		if(count($players) != 1 || $players[0]->password != $password)
		{
			redirect('tenniscontroller/index', 'refresh');
		}
		else{
			parent::addSessionInfo($players[0]->name, $players[0]->idPlayer, $players[0]->idPlayerType);
			redirect('tenniscontroller/index', 'refresh');
		}
	}
	
	public function logout(){
		parent::sessionlogout();
		redirect('tenniscontroller/index', 'refresh');
	}
}
?>