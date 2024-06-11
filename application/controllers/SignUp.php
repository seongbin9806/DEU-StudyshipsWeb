<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SignUp extends CI_Controller {
    
	public function __construct() {
       	parent::__construct();
		
        if(!empty($this->session->userdata('member'))){
            header("Location: /");
            exit;
        }
        
		$this->load->config('common');
        $this->load->model('SignUpModel');
    }
	
    /* 회원가입 뷰 호출 */
	public function SignUpView(): void 
	{
        $headerData = array('title' => "회원가입", 'isHeader' => true, 'isShowTitle' => false);
        
		$this->load->view('/common/header', $headerData);
		$this->load->view('/SignUpView');
		$this->load->view('/common/footer');
	}
    
    /* 중복 아이디 체크 */
    public function CheckSameId() 
    {
        $result = array("result" => true, "msg" => "");
        
        $mbId = $_POST['mbId'];
        
        $SignUpModel = new SignUpModel();
        $SignUpModel->SetMbId($mbId);
        
        $isCheckSameId = $SignUpModel->CheckSameId();
        
        /* 같은 아이디가 존재한다면 */        
        if($isCheckSameId){
            $result['result'] = false;
            $result['msg'] = "이미 사용중인 아이디입니다.";
        }
        
        echo json_encode($result);
    }
    
    /* 회원가입 요청 */
    public function CallSignUp() 
    {
        $result = array("result" => true, "msg" => "");
        
        $mbId = $_POST['mbId'];
        $mbPassword = $_POST['mbPassword'];
        $mbName = $_POST['mbName'];
        
        $SignUpModel = new SignUpModel();
        $SignUpModel->SetMbId($mbId);
        $SignUpModel->SetMbPassword($mbPassword);
        $SignUpModel->SetMbName($mbName);
        
        $signupResult = $SignUpModel->CallSignUp();
        
        if(!$signupResult){
            $result['result'] = false;
            $result['msg'] = "회원가입 중 문제가 발생하였습니다.";
        }
        
        echo json_encode($result);
    }
}
