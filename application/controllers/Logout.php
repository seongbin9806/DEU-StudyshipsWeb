<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
    
	public function __construct() {
       	parent::__construct();
		
		$this->load->config('common');
    }
	
    public function index(){
        session_start();
        session_destroy();
          
        header("Location: /SignIn/SignInView");
        exit;
    }
}
