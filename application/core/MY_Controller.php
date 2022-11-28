<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 *
 * @author Paul's Hardware
 */
class MY_Controller extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function user_page($page = NULL, $data = NULL)
    {
        $data["cur_date"] = $this->get_current_date("lain");
        $data["yesss"] = $this->get_yester_dates();
        $data["lastmonth"] = $this->get_last_month();
        $data["hosp_name"] = $this->user_model->get_hospital();
        $data['todays_month'] = $this->get_my();
        $this->load->view('templates/header',$data);
        
        if ($page === NULL) {
            if ($this->has_log_in()) {
                if($this->validate_medphic() || $this->session->userdata('admin') !== "1")
                {
                    redirect('user/mandadailycensus','refresh');
                }
                else
                {
                    redirect('user/dashboard','refresh');
                }
                }else{
                $this->load->view('pages/login',$data);
            }
        }else{
            if ($page === 'lockscreen') {
                $this->load->view('pages/'.$page,$data);
            }else{
                $this->load->view('templates/navbar',$data);
                $this->load->view('templates/sidebar',$data);
    //            $this->load->view('templates/right_sidebar',$data);
                $this->load->view('pages/'.$page,$data);
            }
        }
        $this->load->view('templates/footer',$data);
    }
    
    
    public function has_log_in()
    {
        if ($this->session->userdata('logged_in')) {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function validate_log_in()
    {
        if ($this->has_log_in()) {
            return TRUE;
        }else{
            show_404();
        }
    }
    
    public function validate_admin()
    {
         if ($this->session->userdata('admin') === "1") {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function validate_medphic()
    {
         if ($this->session->userdata('medicalphic') === "1") {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function set_session_data($data)
    {
        $newdata = array(
                    'empname'       => $data['EmpName'],
                    'empId'         => $data['EmpID'],
                    'usertype'      => $data['leveluser'],
                    'userid'        => $data['ID'], 
                    'approver'      => $data['approver'],
                    'prapprover'    => $data["prapprover"],
                    'poapprover'    => $data["poapprover"],
                    'admin'         => $data["Adminsys"],
                    'medicalphic'   => $data["medicalphic"],
                    'logged_in'    => TRUE
            );

            $this->session->set_userdata($newdata);
    }
    
    public function format_money($money)
    {
        $m = number_format($money,2);
        return '&#8369; '.$m;
    }
    public function format_moneyx($money)
    {
        $m = number_format($money,2);
        return $m;
    }
    
    public function get_current_date($type = "server")
    {
        $now = new DateTime();
        return ($type === "server") ? $now->format('Y-m-d h:i:s') : $now->format('Y-m-d') ;
    }
    
    public function format_date($date)
    {
          $now = new DateTime($date);
        return $now->format('m/d/Y ');
    }
    
    public function format_dates($date)
    {
          $now = new DateTime($date);
        return $now->format('m-d-Y h:i:s');
    }
    
    public function get_current_dates()
    {
        $now = new DateTime();
        return $now->format('m-d-Y');
    }
    
    public function get_YDMdate($date)
    {
          $now = new DateTime($date);
        return $now->format('Y-m-d');
    }
    
    public function get_yester_dates()
    {
        $now = new DateTime();
        $now->modify('-1 day');
        return $now->format('Y-m-d');
    }
    
    public function get_last_month()
    {
        $now = new DateTime();
        $now->modify('-1 month');
        return $now->format('Y-m');
    }
    
    public function format_datexx($date)
    {
          $now = new DateTime($date);
        return $now->format('F j, Y ');
    }
    
     public function get_my()
    {
        $now = new DateTime();
        return $now->format("Y-m");
    }
    
    public function format_datea($date)
    {
          $now = new DateTime($date);
        return $now->format('m-d-Y h:i A');
    }
    
}
