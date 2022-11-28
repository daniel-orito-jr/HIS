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
class confine_model extends MY_Model{
      public function __construct()
    {
        parent::__construct();
        $this->cas_db = $this->load->database('casv2', true);
        $this->hub_db = $this->load->database('hubv2', true);
        $this->ams_db = $this->load->database('amsv1', true);
        $this->med_db = $this->load->database('medv2', true);
        $this->esched_db = $this->load->database('esched', true);
        $this->bms_db = $this->load->database('bmsv2', true);
        $this->pms_db = $this->load->database('pmsv2', true);
        
    }
    
    /**
     * GEt Confinement Causes: Mandatory Monthly Hospital Report
     * @author Alingling
     */
    
    public function get_common_confinement_causes($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));
               

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("diagnosis","caseno","name","dischadate","phicmembr","ID");
        $this->bms_db->select("diagcateg,diagnosis,caseno, name,dischadate, phicmembr,ID")
                    ->from(causeofconfinement_vw)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"');
                   
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->bms_db->group_start()
                -> like("diagcateg", $this->input->post("search")["value"])
                -> or_like("diagnosis", $this->input->post("search")["value"])
                -> or_like("casecode", $this->input->post("search")["value"])
                -> or_like("name", $this->input->post("search")["value"])
                -> or_like("phicmembr", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->bms_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->bms_db->order_by("diagcateg","ASC");
        }
    }
    

    function get_common_confinement_causes_datatables($month){  
        $this->get_common_confinement_causes($month);  
        if($this->input->post("length") != -1)  
        {  
            $this->bms_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->bms_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_common_confinement_causes_filtered_data($month){  
        $this->get_common_confinement_causes($month);  
        $query = $this->bms_db->get();  
        return $query->num_rows();  
    }
    
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_common_confinement_causes_data($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));
               

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

         $this->bms_db->select("diagcateg,diagnosis,caseno, name,dischadate, phicmembr")
                    ->from(causeofconfinement_vw)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->order_by('diagcateg','ASC');

        return $this->bms_db->count_all_results();
    }





      /**
     * GEt top common Confinement Causes: Mandatory Monthly Hospital Report
     * @author Alingling
     */
    
    public function get_top_common_confinement_causes($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("causeofconfinement","nhip","non","totalx");
         $this->db->select('causeofconfinement,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(causesofconfinement_tbl)
                ->where('dischadate >= "'.$first.'"')
                ->where('dischadate <= "'.$end.'"')
                ->group_by('refnocause')
                ->limit(10);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                -> like("causeofconfinement", $this->input->post("search")["value"])
                
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
    
    /**
     * 
     * make all purchases table
     */
    function get_top_common_confinement_causes_datatables($month){  
        $this->get_top_common_confinement_causes($month);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
    function get_top_common_confinement_causes_filtered_data($month){  
        $this->get_top_common_confinement_causes($month);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    public function get_top_common_confinement_causes_data($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $this->db->select('causeofconfinement,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(causesofconfinement_tbl)
                ->where('dischadate >= "'.$first.'"')
                ->where('dischadate <= "'.$end.'"')
                ->group_by('refnocause')
                ->order_by('totalx',"DESC")
                ->limit(10);

        return $this->db->count_all_results();
    }
    
    public function get_top_confinement_causes_report($month)
    {
       $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $this->db->select('causeofconfinement,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(causesofconfinement_tbl)
                ->where('dischadate >= "'.$first.'"')
                ->where('dischadate <= "'.$end.'"')
                ->group_by('refnocause')
                ->order_by('totalx',"DESC")
                ->limit(10);
        
        $query = $this->db->get();  
       return $query->result_array(); 
    }
/**
     * GEt Diagnosis List: Mandatory Monthly Hospital Report
     * @author Alingling
     */
    
    public function get_diagnosis_list()
    {
        

        $order_column = array("categdiag","refno");
        $this->bms_db->select('categdiag,refno')
                    ->from(diagnosiscateg_tbl);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->bms_db->group_start()
                -> like("categdiag", $this->input->post("search")["value"])
                
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->bms_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->bms_db->order_by("categdiag","ASC");
        }
    }
    
    
    function get_diagnosis_list_datatables(){  
        $this->get_diagnosis_list();  
        if($this->input->post("length") != -1)  
        {  
            $this->bms_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->bms_db->get();  
        return $query->result();  
    }
    
    
    function get_diagnosis_list_filtered_data(){  
        $this->get_diagnosis_list();  
        $query = $this->bms_db->get();  
        return $query->num_rows();  
    }
    
  
    
    public function get_diagnosis_list_data()
    {
        
        $this->bms_db->select('categdiag,refno')
                    ->from(diagnosiscateg_tbl)
                    ->order_by('categdiag','ASC');
        return $this->bms_db->count_all_results();
    }

    public function check_patient_diagnosis($diagnosis,$casecode)
    {
       
        $this->bms_db->select('*')
                    ->from(finaldiagnosis_tbl)
                    ->where('casecode',$casecode)
                    ->where('diagnosis',$diagnosis);
         
        
        $query = $this->bms_db->get();  
        return $query->result_array(); 
        
      
    }


    public function insert_finaldiagnosis($datax)
    {
        $approved = FALSE;
        for ($i = 0; $i < count($datax['casecode']); $i++) {
          
             $data = array(
            'causescode'    => $this->security->xss_clean($datax['causescode']),
            'casecode'      => $this->security->xss_clean($datax['casecode'][$i]),
            'caseno'        => $this->security->xss_clean($datax['caseno'][$i]),
            'membercardno'  => $this->security->xss_clean($datax['membercardno'][$i]),
            'PIN'           => $this->security->xss_clean($datax['PIN'][$i]),
            'pincode'       => $this->security->xss_clean($datax['pincode'][$i]),
            'patientname'   => $this->security->xss_clean($datax['patientname'][$i]),
            'diagcode'      => $this->security->xss_clean($datax['diagcode']),
            'diagnosis'     => $this->security->xss_clean($datax['diagnosis']),
            'diaggroup'     => $this->security->xss_clean("DISCH"),
            'recid'         => $this->session->userdata('userid'),
            'recby'         => $this->session->userdata('empname'),
            'lastupdate'    => $this->get_current_date('server'),
            'station'       => $this->security->xss_clean(count($datax['casecode']))

            
        );
           $this->bms_db->insert(finaldiagnosis_tbl, $data);
          

        }
         if($i === count($datax['casecode']))
           {
             $approved = TRUE;
           }
         return $approved;
    }

     public function get_patient_causeofconfinement($id)
    {
        $this->bms_db->select('*')
            ->from(causeofconfinement_vw)
            ->where('ID',$id);
        
            $query = $this->bms_db->get();
            return $query->row_array();
    }


    /**
     * GEt Patient's Final Diagnosis: Mandatory Monthly Hospital Report
     * @author Alingling
     */
    
    public function get_patient_final_diagnosis($casecode)
    {
        

        $order_column = array("ID,diagnosis");
        $this->bms_db->select('ID,diagnosis')
                    ->from(finaldiagnosis_tbl)
                    ->where('casecode',$casecode);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->bms_db->group_start()
                -> like("diagnosis", $this->input->post("search")["value"])
                
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->bms_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->bms_db->order_by("diagnosis","ASC");
        }
    }
    
    
    function get_patient_final_diagnosis_datatables($casecode){  
        $this->get_patient_final_diagnosis($casecode);  
        if($this->input->post("length") != -1)  
        {  
            $this->bms_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->bms_db->get();  
        return $query->result();  
    }
    
    
    function get_patient_final_diagnosis_filtered_data($casecode){  
        $this->get_patient_final_diagnosis($casecode);  
        $query = $this->bms_db->get();  
        return $query->num_rows();  
    }
    
  
    
    public function get_patient_final_diagnosis_data($casecode)
    {
        
         $this->bms_db->select('ID,diagnosis')
                    ->from(finaldiagnosis_tbl)
                    ->where('casecode',$casecode)
                    ->order_by('diagnosis','ASC');
        return $this->bms_db->count_all_results();
    }


    /**
     * GEt Patients of Every Diagnosis: Mandatory Monthly Hospital Report
     * @author Alingling
     */
    
    public function get_final_diagnosis_patient($diagnosis,$month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));
               

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("patientname","dischadate","phicmembr");
        $this->bms_db->select('patientname,dischadate,phicmembr')
                    ->from(diagnosisfinal_vw)
                    ->where('diagnosis',$diagnosis)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"');
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->bms_db->group_start()
                -> like("patientname", $this->input->post("search")["value"])
                
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->bms_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->bms_db->order_by("patientname","ASC");
        }
    }
    
    
    function get_final_diagnosis_patient_datatables($diagnosis,$month){  
        $this->get_final_diagnosis_patient($diagnosis,$month);  
        if($this->input->post("length") != -1)  
        {  
            $this->bms_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->bms_db->get();  
        return $query->result();  
    }
    
    
    function get_final_diagnosis_patient_filtered_data($diagnosis,$month){  
        $this->get_final_diagnosis_patient($diagnosis,$month);  
        $query = $this->bms_db->get();  
        return $query->num_rows();  
    }
    
  
    
    public function get_final_diagnosis_patient_data($diagnosis,$month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));
               

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
          $this->bms_db->select('patientname , dischadate,phicmembr')
                    ->from(diagnosisfinal_vw)
                    ->where('diagnosis',$diagnosis)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->order_by('patientname','ASC');
        return $this->bms_db->count_all_results();
    }


    public function removediagnosis($id)
    {
        $this->db-> where('ID', $id);
       return $this->db-> delete(causesofconfinement_tbl);  
    }
    
    //add_confinement
    public function add_confinement($datax)
    {
        $data = array(
            'refnocause'            => $this->security->xss_clean($datax['refnocause']),
            'causeofconfinement'    => $this->security->xss_clean($datax['causeofconfinement']),
            'caseno'                => $this->security->xss_clean($datax['caseno']),
            'patientname'           => $this->security->xss_clean($datax['patientname']),
            'dischadate'            => $this->security->xss_clean($datax['dischadate']),
            'phicmembr'             => $this->security->xss_clean($datax['phicmembr']),
            'diagnosis'             => $this->security->xss_clean($datax['diagnosis']),
            'updated'               => $this->security->xss_clean($this->get_current_date()),
            'updatedby'             => $this->security->xss_clean($this->session->userdata('userid'))
        );
      return $this->db->insert(causesofconfinement_tbl, $data);
    }
    
    /**
     * GEt PX Diagnosis List: Mandatory Monthly Hospital Report
     * @author Alingling
     */
    
    public function get_px_diagnosis_list($datax)
    {
        $monthstart = date("Y-m-01", strtotime($datax['startdate']."-01"));
        $monthend =  date("Y-m-t", strtotime($datax['startdate']."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $order_column = array("ID","refnocause","causeofconfinement");
        $this->db->select('ID,refnocause,causeofconfinement')
                    ->from(causesofconfinement_tbl)
                    ->where('caseno',$datax['caseno'])
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"');
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                -> like("refnocause", $this->input->post("search")["value"])
                -> like("causeofconfinement", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by("causeofconfinement","ASC");
        }
    }
    
    function get_px_diagnosis_list_datatables($datax){  
        $this->get_px_diagnosis_list($datax);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
    function get_px_diagnosis_list_filtered_data($datax){  
        $this->get_px_diagnosis_list($datax);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    public function get_px_diagnosis_list_data($datax)
    {
        $monthstart = date("Y-m-01", strtotime($datax['startdate']."-01"));
        $monthend =  date("Y-m-t", strtotime($datax['startdate']."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $this->db->select('ID,refnocause,causeofconfinement')
                    ->from(causesofconfinement_tbl)
                    ->where('caseno',$datax['caseno'])
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->order_by("causeofconfinement","ASC");
        return $this->db->count_all_results();
    }
}
