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
		$data = array();
		$data['name'] = $_POST['fname'].' '.$_POST['lname'];
		$data['email'] = $_POST['email'];
		$this->load->helper('Security');
		$data['password'] = do_hash($_POST['password'], 'md5');
		$data['idPlayerType'] = 3;
		
		//TODO::add a captcha, validation, send an email, update db
		$this->load->model('Player');
		if($this->Player->insert_player($data) == False)
		{
			redirect('tenniscontroller/register', 'refresh');
		
		}
		else{		
			parent::addSessionInfo($data['name'], $data['email']);
			redirect('tenniscontroller/index', 'refresh');
		}

	}
	
	public function login() {
		$this->load->model('Security');
		$data['email'] = $_POST['emailInput'];
		$password = do_hash($_POST['passwordInput'], 'md5');
		
		$this->load->model('Player');
		$players = $this->Player->get_players(@data);
		if($players->num_rows() != 1 || $players->first_row('password') != $password)
		{
			redirect('tenniscontroller/index', 'refresh');
		}
		else{
			parent::addSessionInfo($data['usernameInput'], $data['passwordInput']);
			redirect('tenniscontroller/index', 'refresh');
		}
	}
	
	public function logout(){
		parent::sessionlogout();
		redirect('tenniscontroller/index', 'refresh');
	}
}
?>