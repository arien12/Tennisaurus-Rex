<?php
class MainController extends CI_Controller {
    public function __construct ( ) {
        parent::__construct ( );
        $this->load->library ( 'masterpage' );
		$this->load->helper('url');
		$this->load->library('session');
    }
	

    public function setupMaster ( ) {
        $this->masterpage->setMasterPage ( 'tennis_master' );
        // content_index is the view file to use.
        // content is the tag in the masterpage file we want to replace.
       // $this->masterpage->addContentPage ( 'content_index', 'content' );
		
		if($this->session->userdata('loggedin')==true){
			$data = array(
				'name'=>$this->session->userdata['name']
			);		
			$this->masterpage->addContentPage ( 'common/top', 'top' );
			$this->masterpage->addContentPage ( 'common/bar', 'bar',  $data );
			$this->masterpage->addContentPage ( 'common/mainnav', 'mainnav' );
			$this->masterpage->addContentPage ( 'common/teamchoice', 'teamchoice' );
			$this->masterpage->addContentPage ( 'common/footer', 'footer' );
		}else{
			$this->masterpage->addContentPage ( 'common/top_unlogged', 'top' );
			$this->masterpage->addContentPage ( 'common/bar_unlogged', 'bar' );
			$this->masterpage->addContentPage ( 'common/mainnav', 'mainnav' );
			$this->masterpage->addContentPage ( 'common/teamchoice', 'teamchoice' );
			$this->masterpage->addContentPage ( 'common/footer', 'footer' );
			}
		}
	   
	   protected function addSessionInfo($name, $email) {
		$userdata = array(
			'name'=>$name,
			'email'=>$email,
			'loggedin'=>TRUE
		);
		$this->session->set_userdata($userdata);
		}
		
		protected function sessionlogout(){
		$userdata = array(
			'loggedin'=>FALSE
		);
			$this->session->set_userdata($userdata);
		}
    }
?>