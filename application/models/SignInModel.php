<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SignInModel extends CI_Model {

    private string $mbId; /* 회원 아이디 */
    private string $mbPassword; /* 회원 비밀번호 */
        
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

    /* 로그인 처리 */
    function CallSignIn(): ?array
    {
        $sql = "
            SELECT
                mbId,
                mbName,
                regDate
            FROM
                member
            WHERE
                mbId = ? AND
                mbPassword = password(?)
        ";
        
        $data = array(
            $this->mbId,
            $this->mbPassword
        );
        
        $query = $this->db->query($sql, $data);
        $userInfo = $query->row_array();
        
        /*  유저정보 리턴 */
        return $userInfo;
    }
}