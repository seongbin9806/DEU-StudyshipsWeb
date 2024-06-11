<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdmSeatInsertModel extends CI_Model {

    private array $seatList;
    private int $seatNumber;
    private int $coordX;
    private int $coordY;
    private string $isActive;
        
    public function __construct() {
        parent::__construct();
    }
    
    // 관리자 등록 좌석 정보 불러오기
    function SetSeatList(): void
    {
        $sql = "
            SELECT
                seatNumber,
                coordX,
                coordY,
                isActive
            FROM
                seat            
        ";                
        
        $query = $this->db->query($sql, array());
        $seatList = $query->result_array();
        
        $this->seatList = $seatList;
    }
    
    function SetCoordX(int $coordX): void
    {
        $this->coordX = $coordX;
    }
    
    function SetCoordY(int $coordY): void
    {
        $this->coordY = $coordY;
    }        
    
    function SetSeatNumber(int $seatNumber): void
    {
        $this->seatNumber = $seatNumber;
    }
    
    function SetIsActive(string $isActive): void
    {
        $this->isActive = $isActive;
    }
    
    function GetSeatList(): array
    {
        return $this->seatList;                
    }
    
    // 같은 좌석번호 체크
    function CheckSameSeatNumber(): bool
    {        
        $sql = "
            SELECT
                seatIdx
            FROM
                seat
            WHERE
                seatNumber = ?
        ";
        
        $query = $this->db->query($sql, array($this->seatNumber));
        $seatInfo = $query->row_array();
        
        /* 시트정보가 존재하면 true 아니면 false */
        $isSameSeat = !empty($seatInfo)? true : false;
        return $isSameSeat;
    }
    
    // 좌석정보 DB 저장
    function SaveSeat(): bool
    {
         $sql = "
            INSERT INTO
                seat
            SET
                seatNumber = ?,
                coordX = ?,
                coordY = ?,
                isActive = ?                
        ";
        
        $data = array(
            $this->seatNumber,
            $this->coordX,
            $this->coordY,
            $this->isActive
        );
        
        $SaveSeatResult = $this->db->query($sql, $data);
        
        return $SaveSeatResult;
    }
}