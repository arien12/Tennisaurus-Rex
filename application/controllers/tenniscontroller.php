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
		$data['password'] = $_POST['password'];
		//TODO::add a captcha, validation, send an email, update db
		
		parent::addSessionInfo($data['name'], $data['email']);
		redirect('tenniscontroller/index', 'refresh');
	    

	}
	
	public function login() {
	$data['usernameInput'] = $_POST['usernameInput'];
	$data['passwordInput'] = $_POST['passwordInput'];
	
		parent::addSessionInfo($data['usernameInput'], $data['passwordInput']);
		redirect('tenniscontroller/index', 'refresh');
	}
	
	public function logout(){
		parent::sessionlogout();
		redirect('tenniscontroller/index', 'refresh');
	}
}
?>