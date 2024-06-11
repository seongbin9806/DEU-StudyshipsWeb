<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SeatModel extends CI_Model {

    private string $mbId; 
    private ?array $seatList; 
    private int $seatIdx;
        
    public function __construct() {
        parent::__construct();
    }
         
    function SetMbId(string $mbId): void
    {
        $this->mbId = $mbId;
    }
        
    function SetSeatIdx(int $seatIdx): void
    {
        $this->seatIdx = $seatIdx;
    }
    
    /* 내가 좌석예약 했는지 여부 */
    function IsReserv(): bool
    {
          $sql = "
            SELECT
                seatPayIdx
            FROM
                seatPayment
            WHERE
                mbId = ? AND
                endDateTime >= ?
        ";
        
        $nowDateTime = date("Y-m-d H:i:s");
                
        $data = array(
            $this->mbId,
            $nowDateTime
        );
        $query = $this->db->query($sql, $data);
        $seatPayIdxInfo = $query->row_array();
        
        $isReserv = true;
        
        /* 좌석예약이 되어 있지 않으면 */
        if(empty($seatPayIdxInfo)){
            $isReserv = false;
        }
        
        return $isReserv;
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
            $this->seatIdx,
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
    
    
     /* 좌석내역 가져오기 */
    function SetSeatList(): void
    {
        $sql = "
            SELECT
                S.seatIdx,
                S.seatNumber,
                S.coordX,
                S.coordY,
                IF(SP.seatPayIdx IS NOT NULL, 'U', S.isActive) AS isActive 
            FROM
                seat AS S LEFT JOIN
                seatPayment AS SP ON SP.seatIdx = S.seatIdx AND SP.endDateTime >= ?                            
        ";
        
        $nowDateTime = date("Y-m-d H:i:s");
                
        $data = array(            
            $nowDateTime
        );
        
        $query = $this->db->query($sql, $data);
        $seatList = $query->result_array($query);
        
        $this->seatList = $seatList;
    }                        
    
    /* 좌석내역 불러오기 */
    function GetSeatList(): ?array
    {
        return $this->seatList;
    }
}