<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdmSeatInsert extends CI_Controller {
    
	public function __construct() {
       	parent::__construct();
		
        
        if($this->session->userdata('member')['mbId'] != 'deu-admin'){
            header("Location: /");
            exit;
        }
        
		$this->load->config('common');        
        $this->load->model('AdmSeatInsertModel');
    }
	
    // 좌석관리 뷰 호출
	public function SeatManagement()
	{
        $headerData = array('title' => "좌석관리");
        $viewData = array();
        
        $AdmSeatInsertModel = new AdmSeatInsertModel();
        
        $AdmSeatInsertModel->SetSeatList();   
        $seatList = $AdmSeatInsertModel->GetSeatList();   
        
        $viewData['seatList'] = $seatList;
        
		$this->load->view('/common/adminHeader', $headerData);
		$this->load->view('/SeatManagement', $viewData);
		$this->load->view('/common/adminFooter');
	}
    
    // 시트저장(등록)
    public function SaveSeat()
    {
        $result = array("result" => true, "msg" => "시트가 정상적으로 등록되었습니다.");
        
        $coordX = $_POST['coordX'];
        $coordY = $_POST['coordY'];
        $seatNumber = $_POST['seatNumber'];
        $isActive = $_POST['isActive'];
        
        $AdmSeatInsertModel = new AdmSeatInsertModel();
        
        $AdmSeatInsertModel->SetSeatNumber($seatNumber);
        $isSameSeat = $AdmSeatInsertModel->CheckSameSeatNumber();
        
        if($isSameSeat){
            $result['result'] = false;
            $result['msg'] = "이미 등록되어 있는 좌석번호입니다.";
            echo json_encode($result);
            exit;
        }
        
        $AdmSeatInsertModel->SetCoordX($coordX);
        $AdmSeatInsertModel->SetCoordY($coordY);
        $AdmSeatInsertModel->SetIsActive($isActive);
            
        $SaveSeatResult = $AdmSeatInsertModel->SaveSeat();
        
        if(!$SaveSeatResult){
            $result['result'] = false;
            $result['msg'] = "시트 등록 중 문제가 발생하였습니다.";
        }
        
        echo json_encode($result);
    }
}