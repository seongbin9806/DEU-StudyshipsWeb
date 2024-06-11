<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mypage extends CI_Controller {

	public function __construct(){
       	parent::__construct();
        
        if(empty($this->session->userdata('member'))){
            header("Location: /SignIn/SignInView");
            exit;
        }
		
		$this->load->config('common');
        $this->load->model('MypageModel');
    }
	
	public function Information()
	{
        $headerData = array('title' => "내 정보", 'isHeader' => true, 'isShowTitle' => true);
        $viewData = array();
        
        $MypageModel = new MypageModel();
        $MypageModel->SetMbId($this->session->userdata('member')['mbId']);
        $MypageModel->SetMySeatInfo();        
        $seatInfo = $MypageModel->GetMySeatInfo();
        
        $viewData['seatInfo'] = $seatInfo;
        
		$this->load->view('/common/header', $headerData);
		$this->load->view('/Information', $viewData);
		$this->load->view('/common/footer');
	}
}
