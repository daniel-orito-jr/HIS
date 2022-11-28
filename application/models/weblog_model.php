<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of weblog_model
 *
 * @author DRAINWIZ-pc`
 */
class weblog_model extends MY_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function insert_log($devicedetails)
    {
        $data = array(
            'action' => $devicedetails["action"],
            'devicetype' => $devicedetails["type"],
            'deviceos' => $devicedetails["os"],
            'devicename' => $devicedetails["name"],
            'ip' => '',
            'browser' => $devicedetails["browser"],
            'logername' => $this->session->userdata('empname'),
            'logdate' => $this->get_current_date()
        );
        return $this->db->insert(weblog_tbl, $data);
    }
}
