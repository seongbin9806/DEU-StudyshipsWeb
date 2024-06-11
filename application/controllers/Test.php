<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
    
	public function __construct() {
       	parent::__construct();
		
		$this->load->config('common');
        $this->load->model('SignUpModel');
    }
	
    public function index(){
          $sql = "
            SELECT
                *
            FROM
                member
        ";
                
        $query = $this->db->query($sql, array());
        $arr = $query->result_array();
        
        echo '<pre>';
        var_dump($arr);
        echo '</pre>';
    }
}
