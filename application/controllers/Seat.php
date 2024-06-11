<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seat extends CI_Controller {

	public function __construct(){
       	parent::__construct();
        
        if(empty($this->session->userdata('member'))){
            header("Location: /SignIn/SignInView");
            exit;
        }
		
		$this->load->config('common');
        $this->load->model('SeatModel');
    }
	
    // 좌석 선택 뷰 호출
	public function Reserv()
	{
        $headerData = array('title' => "좌석선택", 'isHeader' => true, 'isShowTitle' => true);
        $viewData = array();
        
        $SeatModel = new SeatModel();
        $SeatModel->SetMbId($this->session->userdata('member')['mbId']);
        
        /* 좌석예약이 되어있으면 홈화면으로 리다이렉션 */
        $isReserv = $SeatModel->IsReserv();
        if($isReserv){
            header("Location: /");
            exit;
        }
        
        $SeatModel->SetSeatList();
        $seatList = $SeatModel->GetSeatList();
        
        $viewData['seatList'] = $seatList;
        
		$this->load->view('/common/header', $headerData);
		$this->load->view('/Reserv', $viewData);
		$this->load->view('/common/footer');
	}
    
    // 사용가능한 좌석 체크
    public function CheckIsUseSeat()
    {
        $result = array("result" => true, "msg" => "사용가능한 좌석입니다.");
        
        $seatIdx = $_POST['seatIdx'];
        
        $SeatModel = new SeatModel();        
        $SeatModel->SetSeatIdx($seatIdx);
        
        /* 좌석예약이 되어있으면 */
        $isUseSeat = $SeatModel->CheckIsUseSeat();
        if($isUseSeat){
            $result['result'] = false;
            $result['msg'] = "이미 사용중인 좌석입니다.";
        }
        
        echo json_encode($result);
    }
}
