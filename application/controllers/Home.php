<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
       	parent::__construct();
        
        if(empty($this->session->userdata('member'))){
            header("Location: /SignIn/SignInView");
            exit;
        }
		
		$this->load->config('common');
    }
	
	public function index()
	{
        $headerData = array('title' => "", 'isHeader' => false, 'isShowTitle' => false);
        $viewData = array();
        
		$this->load->view('/common/header', $headerData);
		$this->load->view('/home', $viewData);
		$this->load->view('/common/footer');
	}
}
