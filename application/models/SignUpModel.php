<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SignUpModel extends CI_Model {

    private string $mbId; /* 회원 아이디 */
    private string $mbPassword; /* 회원 비밀번호 */
    private string $mbName; /* 회원 이름 */
        
    public function __construct() {
        parent::__construct();        
    }
    
     /* 회원 아이디 값 저장 */
    function SetMbId(string $mbId): void
    {
        $this->mbId = $mbId;
    }
    
    /* 회원 비밀번호 값 저장 */
    function SetMbPassword(string $mbPassword): void
    {
        $this->mbPassword = $mbPassword;
    }
    
    /* 회원 이름 값 저장 */
    function SetMbName(string $mbName): void
    {
        $this->mbName = $mbName;
    }
    
    /* 아이디 중복 체크 처리 */
    function CheckSameId(): bool
    {
        $sql = "
            SELECT
                mbId
            FROM
                member
            WHERE
                mbId = ?
        ";
                
        $query = $this->db->query($sql, array($this->mbId));
        $userInfo = $query->row_array();
        
        /*  유저정보가 존재하면 true 아니면 false */
        return !empty($userInfo)? true : false;
    }
    
    /* 회원가입 처리 */
    function CallSignUp(): bool
    {
        $sql = "
            INSERT INTO
                member
            SET
                mbId = ?,
                mbPassword = password(?),
                mbName = ?
        ";
        
        $data = array(
            $this->mbId,
            $this->mbPassword,
            $this->mbName
        );
        
        $signupResult = $this->db->query($sql, $data);
        
        return $signupResult;
    }

}