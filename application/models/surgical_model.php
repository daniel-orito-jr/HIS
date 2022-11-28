<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of surgical_model
 *
 * @author DRAINWIZ-pc
 */
class surgical_model extends MY_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function insert_surgical($datax)
    {
        $data = array(
            'causeofsurgery'    => $this->security->xss_clean($datax['cause']),
            'nhip'       => $this->security->xss_clean($datax['nhip']),
            'non'    => $this->security->xss_clean($datax['non']),
            'total'       => $this->security->xss_clean($datax['total']),
            'updated'               => $this->get_current_date('server'),
            'updatedby'             => $this->session->userdata('empname'),
        );
        
        return $this->db->insert(causeofsurg_tbl, $data);
    }
    
    
    public function get_surgicals($month)
    {
        $date = new DateTime($month);
        
        $order_column = array("causeofsurgery","nhip","non");
        $this->db->select('causeofsurgery, nhip, non')
                    ->from(causeofsurg_tbl)
                    ->where('MONTH(updated) >=',intval($date->format("n")))
                    ->where('YEAR(updated) <= ',intval($date->format("Y")))
                    ->order_by('total',"DESC")
                    ->limit(10);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                -> like("causeofsurgery", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by("total","ASC");
        }
    }
    

    function create_surgicals_datatables($month){  
        $this->get_surgicals($month);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }

    
    function get_surgicals_filtered_data($month){  
        $this->get_surgicals($month);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    

    public function get_surgicals_data($month)
    {
        $date = new DateTime($month);
        
        $this->db->select('causeofsurgery,nhip,non')
                    ->from(causeofsurg_tbl)
                    ->where('MONTH(updated) >=',$date->format("n"))
                    ->where('YEAR(updated) <= ',$date->format("Y"))
                    ->order_by('total',"DESC")
                    ->limit(10);
        return $this->db->count_all_results();
    }
    
    
    
    public function get_unmerge_surgicals()
    {
        $date = new DateTime();
        
        $order_column = array("diag_surg","Nhip","Non");
        $this->db->select('diag_surg, Nhip, Non')
                    ->from(surgicalvw)
                    ->where('Months >=',$date->format("n"))
                    ->where('years <= ',$date->format("Y"));
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                -> like("diag_surg", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by("diag_surg","ASC");
        }
    }
    
    function create_unmerge_surgicals_datatables(){  
        $this->get_unmerge_surgicals();  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }

    
    function get_unmerge_surgicals_filtered_data(){  
        $this->get_unmerge_surgicals();  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    

    public function get_unmerge_surgicals_data()
    {
        $date = new DateTime();
        
        $this->db->select('diag_surg, Nhip, Non')
                    ->from(surgicalvw)
                    ->where('Months >=',$date->format("n"))
                    ->where('years <= ',$date->format("Y"));
        return $this->db->count_all_results();
    }

    ////



    //alingling

    /**
    *   Get Surgical Output (for merging): Mandatory Hospital Report
    *
    */
    public function get_surgicals_merge()
    {
        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');

        
       
        $order_column = array("Diag_surg","nhip","non");
        $this->db->select('Diag_surg,count(*) as counts,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                    ->from(inpatient_tbl)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"')
                    ->where("Diag_surg <>''")
                    ->group_by('Diag_surg');
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                -> like("Diag_anes", $this->input->post("search")["value"])
                
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by("Diag_surg","ASC");
        }
    }
    
    function create_surgicals_merge_datatables(){  
        $this->get_surgicals_merge();  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }

    
    function get_surgicals_merge_filtered_data(){  
        $this->get_surgicals_merge();  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    

    public function get_surgicals_merge_data()
    {
         $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');
        
       $this->db->select('Diag_surg,count(*) as counts,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                    ->from(inpatient_tbl)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"')
                    ->where("Diag_surg <>''")
                    ->group_by('Diag_surg');
        return $this->db->count_all_results();
    }


    //merge_total_surgical
    public function insert_surgical_output($datax){
          $data = array(
            'causeofsurgery'    => $this->security->xss_clean($datax['causeofsurgery']),
            'nhip'              => $this->security->xss_clean($datax['nhip']),
            'non'               => $this->security->xss_clean($datax['non']),
            'total'             => $this->security->xss_clean($datax['total']),
            'updatedby'         => $this->session->userdata('empname'),
            'updated'           => $this->get_current_date('server')
        );
      return $this->db->insert(causeofsurg_tbl, $data);
    }


/**
*
*   Get Final Surgical Output : Mandatory Hospital Report
*/

public function get_surgical_output($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $order_column = array("Diag_surg","nhip","non");
        $this->db->select('Diag_surg,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                    ->from(inpatient_tbl)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('Diag_surg <> ""')
                    ->group_by('Diag_surg')
                    ->limit(10);
//        $this->db->select('causeofsurgery,nhip,non')
//                    ->from(causeofsurg_tbl)
//                    ->where('updated >= "'.$first.'"')
//                    ->where('updated <= "'.$end.'"')
//                    ->limit(10);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                -> like("Diag_surg", $this->input->post("search")["value"])
                
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by("totalx","DESC");
        }
    }
    
    function create_surgicals_output_datatables($month){  
        $this->get_surgical_output($month);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }

    
    function get_surgicals_output_filtered_data($month){  
        $this->get_surgical_output($month);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    

    public function get_surgicals_output_data($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));
               

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
       $this->db->select('Diag_surg,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                    ->from(inpatient_tbl)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('Diag_surg <> ""')
                    ->group_by('Diag_surg')
                    ->order_by('totalx','DESC')
                    ->limit(10);
        return $this->db->count_all_results();
    }

    public function get_final_surgical_output($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));
               

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
       $this->db->select('Diag_surg,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                    ->from(inpatient_tbl)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('Diag_surg <> ""')
                    ->group_by('Diag_surg')
                    ->order_by('totalx','DESC')
                    ->limit(10);

        $query = $this->db->get();  
        return $query->result_array(); 
    }

}
