<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SignIn extends CI_Controller {

	public function __construct(){
       	parent::__construct();
        
        if(!empty($this->session->userdata('member'))){
            header("Location: /");
            exit;
        }
        
		$this->load->config('common');
        $this->load->model('SignInModel');
    }
	
	public function SignInView()
	{
        $headerData = array('title' => "로그인", 'isHeader' => false, 'isShowTitle' => false);
        $viewData = array();
        
		$this->load->view('/common/header', $headerData);
		$this->load->view('/SignInView', $viewData);
		$this->load->view('/common/footer');
	}
    
    public function CallSignIn()
    {
        $result = array("result" => true, "msg" => "");
        
        $mbId = $_POST['mbId'];
        $mbPassword = $_POST['mbPassword'];
        
        $SignInModel = new SignInModel();
        $SignInModel->SetMbId($mbId);
        $SignInModel->SetMbPassword($mbPassword);
        
        $userInfo = $SignInModel->CallSignIn();
        
        /* 유저 정보가 비어있으면 */
        if(empty($userInfo)){
            $result['result'] = false;
            $result['msg'] = "아이디 또는 비밀번호가 일치하지 않습니다.";
        }
        
        // 세션 데이터 가져오기
        $this->session->set_userdata('member', $userInfo);
                
        echo json_encode($result);
    }
}
