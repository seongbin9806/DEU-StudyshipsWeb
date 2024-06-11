<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MypageModel extends CI_Model {

    private string $mbId;     
    private ?array $seatInfo; 
        
    public function __construct() {
        parent::__construct();
    }
        
    function SetMbId(string $mbId): void
    {
        $this->mbId = $mbId;
    }    

    /* 예약정보 내역 저장 */
    function SetMySeatInfo(): void
    {
        
        $sql = "
            SELECT
                S.seatNumber,
                SP.startDateTime,
                SP.endDateTime
            FROM
                seatPayment AS SP JOIN
                seat AS S ON S.seatIdx = SP.seatIdx
            WHERE
                SP.mbId = ? AND                
                SP.endDateTime >= ?
        ";
        
        $nowDateTime = date("Y-m-d H:i:s");
                
        $data = array(
            $this->mbId,            
            $nowDateTime
        );
        $query = $this->db->query($sql, $data);
        $seatInfo = $query->row_array();           
        
        if(!empty($seatInfo)){
            $seatInfo['startDateTime'] =  substr($seatInfo['startDateTime'], 2, 14);
            $seatInfo['endDateTime'] =  substr($seatInfo['endDateTime'], 2, 14);
        }
        
        $this->seatInfo = $seatInfo;
    }
    
    /* 예약정보 내역 불러오기 */
    function GetMySeatInfo(): ?array
    {
        return $this->seatInfo;
    }
}