<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SeatPaymentModel extends CI_Model {

    private string $mbId;
    private array $seatPaymentInfo; /* 좌석 결제정보 */    
        
    public function __construct() {
        parent::__construct();        
    }
         
    function SetMbId(string $mbId): void
    {
        $this->mbId = $mbId;
    }
        
    function SetSeatPaymentInfo(array $seatPaymentInfo): void
    {
        $this->seatPaymentInfo = $seatPaymentInfo;
    }        
    
    /* 가능한 좌석인지 체크 */
    function CheckIsUseSeat(): bool
    {
          $sql = "
            SELECT
                seatPayIdx
            FROM
                seatPayment
            WHERE
                seatIdx = ? AND
                endDateTime >= ?            
        ";
        
        $nowDateTime = date("Y-m-d H:i:s");
                
        $data = array(
            $this->seatPaymentInfo['seatIdx'],
            $nowDateTime
        );
        $query = $this->db->query($sql, $data);
        $seatPayIdxInfo = $query->row_array();
        
        $isUseSeat = true;
        
        /* 좌석예약이 되어 있지 않으면 */
        if(empty($seatPayIdxInfo)){
            $isUseSeat = false;
        }
        
        return $isUseSeat;
    }
    
    /* 좌석결제 정보저장 */
    function SaveSeatPayment(): bool
    {
        $sql = "
            INSERT INTO
                seatPayment
            SET
                mbId = ?,
                seatIdx = ?,
                hour = ?,
                amount = ?,
                startDateTime = ?,
                endDateTime = ?,
                payType = ?
        ";
        
        $data = array(
            $this->mbId,
            $this->seatPaymentInfo['seatIdx'],
            $this->seatPaymentInfo['hour'],
            $this->seatPaymentInfo['amount'],
            $this->seatPaymentInfo['startDateTime'],
            $this->seatPaymentInfo['endDateTime'],
            $this->seatPaymentInfo['payType']
        );
        
        $saveSeatPaymentResult = $this->db->query($sql, $data);
        
        return $saveSeatPaymentResult;
    }    
}