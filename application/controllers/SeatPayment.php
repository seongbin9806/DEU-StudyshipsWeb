<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SeatPayment extends CI_Controller {

	public function __construct(){
       	parent::__construct();
        
        if(empty($this->session->userdata('member'))){
            header("Location: /SignIn/SignInView");
            exit;
        }
		
		$this->load->config('common');
        $this->load->model('SeatPaymentModel');
    }
	
    /* 좌석결제 뷰 호출 */
	public function ReservPayment()
	{
        $headerData = array('title' => "좌석결제", 'isHeader' => true, 'isShowTitle' => true);
        $viewData = array();                
        
		$this->load->view('/common/header', $headerData);
		$this->load->view('/ReservPayment', $viewData);
		$this->load->view('/common/footer');
	}
    
    /* 결제하기 */
    public function Payment()
    {
        $result = array("result" => true, "msg" => "");
        
        $seatIdx = $_POST['seatIdx'];
        $hour = $_POST['hour'];
        $amount = $_POST['amount'];
        $startDateTime = $_POST['startDateTime'];
        $endDateTime = $_POST['endDateTime'];
        $payType = $_POST['payType'];                
            
        $seatPaymentInfo = array(
            'seatIdx' => $seatIdx,
            'hour' => $hour,
            'amount' => $amount,
            'startDateTime' => $startDateTime,
            'endDateTime' => $endDateTime,
            'payType' => $payType
        );
        
        $SeatPaymentModel = new SeatPaymentModel();
        $SeatPaymentModel->SetMbId($this->session->userdata('member')['mbId']);
        $SeatPaymentModel->SetSeatPaymentInfo($seatPaymentInfo);
        
        /* 결제하는 과정에서 다른 사람이 해당 좌석을 결제했을 경우 */
        $isUseSeat = $SeatPaymentModel->CheckIsUseSeat();
         if($isUseSeat){
            $result['result'] = false;
            $result['msg'] = "이미 사용중인 좌석입니다.";
            echo json_encode($result);
            exit;
        }
                
        $saveSeatPaymentResult = $SeatPaymentModel->SaveSeatPayment();
        
        if(!$saveSeatPaymentResult){
            $result['result'] = false;
            $result['msg'] = "결제정보 저장 중 문제가 발생하였습니다.";
        }
        
        echo json_encode($result);
    }
}
