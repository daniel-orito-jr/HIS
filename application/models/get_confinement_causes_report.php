<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_model
 *
 * @author Paul's Hardware
 */
class user_model extends MY_Model{
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
    
    public function get_all_data($start_date, $end_date, $by_doctor = FALSE, $by_patient = FALSE, $by_classification = FALSE)
    {
        if ($by_doctor) {
            $this->db->select('doctorname')
                    ->select_sum('n')
                    ->select_sum('m')
                    ->select_sum('(m + n)','z')
                    ->from(docview_tbl)
                    ->where('admitdate <=',$end_date)
                    ->where('dischadate >=',$start_date)
                    ->group_by('doctorname');
            $query = $this->db->get();
        }
        
        if ($by_patient) {
            $this->db->select('name, phicmembr, admitdate, admittime')
                    ->from(inpatient_tbl)
                    ->where('discharged',0)
                    ->where('(dischadate >= "'.$start_date.'" and admitdate <= "'.$end_date.'")', NULL, FALSE)
                    ->where('pxtype','IPD');
            $query = $this->db->get();
        }
        
        if ($by_classification) {
            $this->db->select('pat_classification, count(*) c')
                    ->from(inpatient_tbl)
                    ->where('discharged',0)
                    ->where('(dischadate >= "'.$start_date.'" and admitdate <= "'.$end_date.'")', NULL, FALSE)
                    ->where('pxtype','IPD')
                    ->group_by('pat_classification having count(*) > 0',NULL,FALSE);
            $query = $this->db->get();
        }
        
        return $query->result_array();
    }
//    select doctorname,admitdate,dischadate,(case when (`inpatient`.`phicmembr` <> 'Non-NHIP') 
//            then count(`inpatient`.`phicmembr`) else 0 end) AS `n`,(case when (`inpatient`.`phicmembr` = 'Non-NHIP')
//                    then count(`inpatient`.`phicmembr`) else 0 end) AS `m` from inpatient where 
//                        (admitdate>='2017-11-01' and admitdate<='2017-11-01' and dischadate>'2017-11-01') 
//                        or (admitdate<='2017-11-01' and dischadate >='2017-11-01')
//    group by doctorname
    
    public function get_census_data($s_date,$e_date,$type)
    {
        $this->db->select('name, phicmembr, admitdate, admittime')
                ->from(inpatient_tbl);
        
        if ($type === 0) {
            $this->db->where("admitdate",$s_date);
             $this->db->where('discharged','0');
                   
        }else{
            $this->db->where("dischadate",$s_date);
            $this->db->where('discharged','1');
                    
        }
      
        $this->db->where('pxtype','IPD');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_all_records($s_date,$e_date)
    {
        $result['px_records'] = $this->user_model->get_all_data($s_date,$e_date,FALSE,TRUE,FALSE);
        
        return $result; 
    }
    
    public function get_sign_in_data($username,$pass)
    {
        $this->hub_db->select('*')
                ->from(usersrights_tbl)
                ->where('EmpID', $username)
                ->where('EmpPass', $this->encrypt_pass($pass));
        $query = $this->hub_db->get();
        
        return $query->row_array();
    }
    
    public function check_username($username)
    {
        $this->hub_db->select('*')
                ->from(usersrights_tbl)
                ->where('EmpID', $username);
        $query = $this->hub_db->get();
        
        return $query->row_array();
    }
    
    public function check_pass($username,$pass)
    {
        $this->hub_db->select('*')
                ->from(usersrights_tbl)
                ->where('EmpID', $username)
                ->where('EmpPass', $this->encrypt_pass($pass));
        $query = $this->hub_db->get();
        
        return (count($query->row_array()) !== 0) ? TRUE : FALSE;
    }
    public function _test()
    {
        $s_date = "2017-06-01";
        $e_date = "2017-07-03";
        $true = FALSE;
//        $rrrr = $this->get_patient_by_type('casetype','OPD',$s_date,$e_date);
        if ($this->get_patient_by_type('casetype','OPD',$s_date,$e_date)) {
            $true = TRUE;
        }
        
        var_dump($true);
        
        
    }
    
    /**
     * 
     * @param type $by if 1 = date, 0 = cashier
     * @param type $s_date
     * @param type $e_date
     * @return type
     */
    public function get_proofs($by,$s_date,$e_date)
    {
        if ($by == 1) {
            $this->cas_db->select('updatedby,updated,'
                . 'DATE(updated) as udate,'
                . 'sum(dbamt) debit,'
                . 'sum(cramt) credit')
                ->from(proofsheetdetails_tbl)
                ->where('DATE(updated) >=', $s_date)    
                ->where('DATE(updated) <=', $e_date)
                ->group_by('udate');
        
            $query = $this->cas_db->get();
        }else{
            $this->cas_db->select('updatedby,updated,'
                . 'DATE(updated) as udate,'
                . 'sum(dbamt) debit,'
                . 'sum(cramt) credit')
                ->from(proofsheetdetails_tbl)
                ->where('DATE(updated) >=', $s_date)    
                ->where('DATE(updated) <=', $e_date)
                ->group_by(array("udate", "updatedby"));
        
            $query = $this->cas_db->get();
        }
//        
       return $query->result_array();
    }
    
    public function get_proof_details($by)
    {
        $date = $this->input->post('date');
        $mydate = new DateTime($date);
        $input_date = $mydate->format('Y-m-d');
        
        if (intval($by) === 1) {
            $this->cas_db->select('coa,coadscr,'
                    . 'DATE(updated) as udate,'
                    . 'sum(dbamt) as debit,'
                    . 'sum(cramt) as credit')
                    ->from(proofsheetdetails_tbl)
                    ->where('DATE(updated)', $input_date)
                    ->group_by('coadscr');

            $query = $this->cas_db->get();
        }else{
            $cashier = $this->input->post('cashier');
            $this->cas_db->select('coa,coadscr,'
                    . 'DATE(updated) as udate,'
                    . 'sum(dbamt) debit,'
                    . 'sum(cramt) credit')
                    ->from(proofsheetdetails_tbl)
                    ->where('DATE(updated)', $input_date)
                    ->where('updatedby', $cashier)
                    ->group_by('coadscr');

            $query = $this->cas_db->get();
        }
        
        return $query->result_array();
    }
    
    
    
    
    
    //NAVP-LKWN-AZB2-FDU5
    //----------------------------------------------------------------------------------------------------------------------------
    
    public function get_patients($s_date,$e_date,$type)
    {
        
        $order_column = array("name", "admitdate", null, "dischadate", null, "pat_classification" );
        if ($type === 0) {
            $this->db->select('name, admitdate, admittime, dischadate, dischatime, pat_classification')
                ->from(inpatient_tbl)
                ->group_start()
                    ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                    ->where('pxtype','IPD')
                ->group_end();
            if(!empty($this->input->post("search")["value"]))  
            {  
                $this->db->group_start()
                    ->like("name", $this->input->post("search")["value"]) 
                    ->or_like("admitdate", $this->input->post("search")["value"]) 
                    ->or_like("dischadate", $this->input->post("search")["value"]) 
                    ->or_like("pat_classification", $this->input->post("search")["value"])
                ->group_end();
            }  
            if(!empty($this->input->post("order")))  
            {  
                $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
            }  
            else  
            {  
                $this->db->order_by('name', 'ASC');  
            }
        }else{
            $this->db->select('name, admitdate, admittime, dischadate, dischatime, pat_classification')
                ->from(inpatient_tbl)
               ->group_start()
                    ->where('pxtype','IPD')
                    ->where('dischadate ', $s_date)  
                    ->where('discharged ', '1')
                ->group_end();
            
            if(!empty($this->input->post("search")["value"]))  
            {  
                $this->db->group_start()
                    ->like("name", $this->input->post("search")["value"]) 
                    ->or_like("admitdate", $this->input->post("search")["value"]) 
                    ->or_like("dischadate", $this->input->post("search")["value"]) 
                    ->or_like("pat_classification", $this->input->post("search")["value"])
                ->group_end();
            }  
            if(!empty($this->input->post("order")))  
            {  
                $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
            }  
            else  
            {  
                $this->db->order_by('name', 'ASC');  
            }
        }
    }
    
    /**
     * 
     * make admitted and discharged patient table
     */
    function make_patients_datatables($s_date,$e_date,$type){  
        $this->get_patients($s_date,$e_date,$type);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }  
        $query = $this->db->get();  
        return $query->result();  
    }
    
    /**
     * search for admitted and discharged patient table
     */
    
    function get_patients_filtered_data($s_date,$e_date,$type){  
        $this->get_patients($s_date,$e_date,$type);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_patients_data($s_date,$e_date,$type)
    {
        if ($type === 0) {
            $this->db->select('name, admitdate, admittime, dischadate, dischatime, pat_classification')
                ->from(inpatient_tbl)
                   ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                    ->where('pxtype','IPD');
        }else{
            $this->db->select('name, admitdate, admittime, dischadate, dischatime, pat_classification')
                ->from(inpatient_tbl)
                    ->where('pxtype','IPD')
                    ->where('dischadate ', $s_date)  
                    ->where('discharged ', '1');
        }
        
        return $this->db->count_all_results();
    }
    
    
    //get total patients: Alingling
    
    
    
    //-----------------------------------------------------------------------------------doctors table
    
    
    /**
     * doctors table
     */
    public function get_doctors($start_date)
    {
        $order_column = array("doctorname", null, null, null);
        $this->db->select('doctorname,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                            .',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(inpatient_tbl)
                ->where('((admitdate <= "'.$start_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$start_date.'" AND admitdate <= "'.$start_date.'"))')
                ->where('pxtype','IPD');
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->like("doctorname", $this->input->post("search")["value"]); 
        }  
        
        $this->db->group_by('doctorid');
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('doctorname', 'ASC');  
        }
    }
    
    /**
     * 
     * make doctors table
     */
    function make_doctors_datatables($s_date){  
        $this->get_doctors($s_date);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }  
        $query = $this->db->get();  
        return $query->result();  
    }
    
    /**
     * returned doctors table search data
     */
    
    function get_doctors_filtered_data($s_date){  
        $this->get_doctors($s_date);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    /**
     * count all doctors data
     */
    
    public function get_all_doctors_data($s_date)
    {
        $this->db->select('doctorname,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                            .',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(inpatient_tbl)
                ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                ->where('pxtype','IPD')
                ->group_by('doctorid');
        
        
        return $this->db->count_all_results();
    }
    
    
    //-------------------------------------------------------------------------------id patients
    public function get_ipd_patients($s_date,$e_date)
    {
        $order_column = array("pat_classification", null, null);
        $this->db->select('pat_classification,'
                . ' sum(case when discharged = 0 then 1 else 0 end) admitted,'
                . ' sum(case when discharged = 1 then 1 else 0 end) discharged_px')
                ->from(inpatient_tbl)
                ->where('(admitdate <= "'.$s_date.'" and dischadate >= "'.$e_date.'")', NULL, FALSE)
                ->where('pxtype','IPD')
                ->group_by('pat_classification')
                ->having('admitted > 0 or discharged_px > 0');
        
        if(!empty($this->input->post("search")["value"]))  
        {  
                $this->db->like("pat_classification", $this->input->post("search")["value"]);
        }  
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('pat_classification', 'ASC');  
        }
    }
    
    /**
     * 
     * make ipd patient table
     */
    function make_ipd_patients_datatables($s_date,$e_date){  
        $this->get_ipd_patients($s_date,$e_date);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }  
        $query = $this->db->get();  
        return $query->result();  
    }
    
    /**
     * search for ipd patient table
     */
    
    function get_ipd_patients_filtered_data($s_date,$e_date){  
        $this->get_ipd_patients($s_date,$e_date);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_ipd_patients_data($s_date,$e_date)
    {
        $this->db->select('pat_classification,'
            . ' sum(case when discharged = 0 then 1 else 0 end) admitted,'
            . ' sum(case when discharged = 1 then 1 else 0 end) discharged_px')
            ->from(inpatient_tbl)
            ->where('(admitdate >= "'.$s_date.'" and admitdate <= "'.$e_date.'")', NULL, FALSE)
            ->where('(dischadate >= "'.$s_date.'" and dischadate <= "'.$e_date.'")', NULL, FALSE)
            ->where('pxtype','IPD')
            ->group_by('pat_classification')
            ->having('admitted > 0 or discharged_px > 0');
        
        return $this->db->count_all_results();
    }
    
    
    //-----------------------------------------------------------------------------------------------opd patients
    public function get_opd_patients($s_date,$e_date)
    {
        $order_column = array("casetype", null, null);
        $this->db->select('casetype,'
                . ' sum(case when discharged = 0 then 1 else 0 end) admitted,'
                . ' sum(case when discharged = 1 then 1 else 0 end) discharged_px')
                ->from(inpatient_tbl)
                ->where('(admitdate <= "'.$s_date.'" and dischadate >= "'.$e_date.'")', NULL, FALSE)
                ->where('pxtype','OPD')
                ->group_by('casetype')
                ->having('admitted > 0 or discharged_px > 0');
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->like("casetype", $this->input->post("search")["value"]);
        }  
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('casetype', 'ASC');  
        }
    }
    
    /**
     * 
     * make opd patient table
     */
    function make_opd_patients_datatables($s_date,$e_date){  
        $this->get_opd_patients($s_date,$e_date);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }  
        $query = $this->db->get();  
        return $query->result();  
    }
    
    
    /**
     * search for opd patient table
     */
    
    function get_opd_patients_filtered_data($s_date,$e_date){  
        $this->get_opd_patients($s_date,$e_date);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_opd_patients_data($s_date,$e_date)
    {
        $this->db->select('casetype,'
            . ' sum(case when discharged = 0 then 1 else 0 end) admitted,'
            . ' sum(case when discharged = 1 then 1 else 0 end) discharged_px')
            ->from(inpatient_tbl)
            ->where('(admitdate >= "'.$s_date.'" and admitdate <= "'.$e_date.'")', NULL, FALSE)
            ->where('(dischadate >= "'.$s_date.'" and dischadate <= "'.$e_date.'")', NULL, FALSE)
            ->where('pxtype','OPD')
            ->group_by('casetype')
            ->having('admitted > 0 or discharged_px > 0');
        
        return $this->db->count_all_results();
    }
    
    //------------------------------------------------------------------------------------------patients
    
    public function get_all_patients()
    {
        $order_column = array("name", "phicmembr", "admitdate");
        $this->db->select('name, phicmembr, admitdate, admittime')
                    ->from(inpatient_tbl)
                    ->group_start()
                        ->where('discharged',0)
                    ->group_end();
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like("name", $this->input->post("search")["value"])
                    ->or_like("phicmembr", $this->input->post("search")["value"])
                    ->or_like("admitdate", $this->input->post("search")["value"])
            ->group_end();
        }  
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('name', 'ASC');  
        }
    }
    
    /**
     * 
     * make all patient table
     */
    function make_all_patients_datatables(){  
        $this->get_all_patients();  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
    /**
     * search for all patient table
     */
    
    function get_all_patients_filtered_data(){  
        $this->get_all_patients();  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_patients_data()
    {
        $this->db->select('name, phicmembr, admitdate, admittime')
                    ->from(inpatient_tbl)
                    ->where('discharged',0);
        
        return $this->db->count_all_results();
    }
    
    //---------------------------------------------------------------------------px classification
    
    public function get_all_patients_classification($s_date,$e_date)
    {
        $order_column = array("pat_classification", null);
        $this->db->select('pat_classification, count(*) c')
                    ->from(inpatient_tbl)
                    ->group_start()
                         ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                        ->where('pxtype','IPD')
                        ->group_by('pat_classification')
                    ->group_end();
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like("pat_classification", $this->input->post("search")["value"])
            ->group_end();
        }  
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('pat_classification', 'ASC');  
        }
    }
    
    /**
     * 
     * make all patient table
     */
    function make_all_patients_classification_datatables($s_date,$e_date){  
        $this->get_all_patients_classification($s_date,$e_date);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
    /**
     * search for all patient table
     */
    
    function get_all_patients_classification_filtered_data($s_date,$e_date){  
        $this->get_all_patients_classification($s_date,$e_date);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_patients_classification_data($s_date,$e_date)
    {
       $this->db->select('pat_classification, count(*) c')
                    ->from(inpatient_tbl)
                   ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                    ->where('pxtype','IPD')
                    ->group_by('pat_classification');
        
        return $this->db->count_all_results();
    }
    
    /*
     * Get information from the classification
     * 
     */
    public function get_all_classification_patients($class,$s_date,$e_date)
    {
        $order_column = array("name","admit","discharge", null);
        $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge')
                    ->from(inpatient_tbl)
                    ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                    ->where('pxtype','IPD')
                    ->where("pat_classification",$class);
                    
        
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like("name", $this->input->post("search")["value"])
            ->group_end();
        }  
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('name', 'ASC');  
        }
    }
    
    /**
     * 
     * make all patient table
     */
    function make_all_classification_patients_datatables($class,$s_date,$e_date){  
        $this->get_all_classification_patients($class,$s_date,$e_date);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
    /**
     * search for all patient table
     */
    
    function get_all_classification_patients_filtered_data($class,$s_date,$e_date){  
        $this->get_all_classification_patients($class,$s_date,$e_date);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_classification_patients_data($class,$s_date,$e_date)
    {
      $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge')
                    ->from(inpatient_tbl)
                   ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                    ->where('pxtype','IPD')
                    ->where("pat_classification",$class);
        
        return $this->db->count_all_results();
    }
    //
    
     /*
     * Get information from the disposition
     * 
     */
    public function get_all_disposition_patients($class,$s_date,$e_date)
    {
        $order_column = array("name","admit","discharge", null);
        $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge')
                    ->from(inpatient_tbl)
                      ->where('dischadate >=', $s_date)
                        ->where('discharged','1')
                        ->where('pxtype','IPD')
                    ->where("disposition",$class);
                    
        
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like("name", $this->input->post("search")["value"])
            ->group_end();
        }  
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('name', 'ASC');  
        }
    }
    
 
    function make_all_disposition_patients_datatables($class,$s_date,$e_date){  
        $this->get_all_disposition_patients($class,$s_date,$e_date);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
  
    
    function get_all_disposition_patients_filtered_data($class,$s_date,$e_date){  
        $this->get_all_disposition_patients($class,$s_date,$e_date);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    
    public function get_all_disposition_patients_data($class,$s_date,$e_date)
    {
     $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge')
                    ->from(inpatient_tbl)
                      ->where('dischadate >=', $s_date)
                        ->where('discharged','1')
                        ->where('pxtype','IPD')
                    ->where("disposition",$class);
        
        return $this->db->count_all_results();
    }
    
    //disposition: alingling
    function make_all_patients_disposition_datatables($s_date,$e_date){  
        $this->get_all_patients_disposition($s_date,$e_date);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    public function get_all_patients_disposition($s_date,$e_date)
    {
        $order_column = array("disposition", null);
        $this->db->select('disposition, count(*) c')
                    ->from(inpatient_tbl)
                    ->group_start()
                        ->where('dischadate >=', $s_date)
                        ->where('discharged','1')
                        ->where('pxtype','IPD')
                        ->group_by('disposition having count(*) > 0',NULL,FALSE)
                    ->group_end();
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like("disposition", $this->input->post("search")["value"])
            ->group_end();
        }  
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('disposition', 'ASC');  
        }
    }
    
    public function get_all_patients_disposition_data($s_date,$e_date)
    {
       $this->db->select('disposition, count(*) c')
                    ->from(inpatient_tbl)
                    ->where('dischadate >=', $s_date)
                    ->where('discharged','1')
                    ->where('pxtype','IPD')
                    ->group_by('disposition having count(*) > 0',NULL,FALSE);
        
        return $this->db->count_all_results();
    }
    
    
    function get_all_patients_disposition_filtered_data($s_date,$e_date){  
         $this->get_all_patients_disposition($s_date,$e_date);  
         
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    //disposition
    
    
    
    
    //-----------------------------------------------------------------------------------------------cahs flow
    public function get_all_proofs($by,$s_date,$e_date)
    {
        $order_column = array();
        
        if ($by === 1) {
            $order_column = array("updated",null,null,null);
            $this->cas_db->select('updatedby,updated,'
                . 'DATE(updated) as udate,'
                . 'sum(dbamt) as debit,'
                . 'sum(cramt) as credit')
                ->from(proofsheetdetails_tbl)
                ->group_start()
                    ->where('DATE(updated) >=', $s_date)    
                    ->where('DATE(updated) <=', $e_date)
                    ->group_by('udate')
                ->group_end();
        }else{
            $order_column = array("updated","updatedby",null,null,null);
            $this->cas_db->select('updatedby,updated,'
                . 'DATE(updated) as udate,'
                . 'sum(dbamt) as debit,'
                . 'sum(cramt) as credit')
                ->from(proofsheetdetails_tbl)
                ->group_start()
                    ->where('DATE(updated) >=', $s_date)    
                    ->where('DATE(updated) <=', $e_date)
                    ->group_by(array("udate", "updatedby"))
                ->group_end();
        }
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->cas_db->group_start();
                $this->cas_db->like("updated",$this->input->post("search")["value"]);
                if ($by !== 1) {
                    $this->cas_db->or_like("updatedby",$this->input->post("search")["value"]);
                }
            $this->cas_db->group_end();
        }  
        if(!empty($this->input->post("order")))  
        {  
            $this->cas_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            if ($by === 1) {
                $this->cas_db->order_by('updated', 'DESC');
            }else{
                $this->cas_db->order_by('updated', 'DESC'); 
            }
        }
    }
    
    /**
     * 
     * make all patient table
     */
    function make_all_proofs_datatables($by,$s_date,$e_date){  
        $this->get_all_proofs($by,$s_date,$e_date);  
        if($this->input->post("length") != -1)  
        {  
            $this->cas_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->cas_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all patient table
     */
    
    function get_all_proofs_filtered_data($by,$s_date,$e_date){  
        $this->get_all_proofs($by,$s_date,$e_date);  
        $query = $this->cas_db->get();  
        return $query->num_rows();  
    }
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_proofs_data($by,$s_date,$e_date)
    {
       if ($by === 1) {
            $order_column = array("udate","debit","credit",null);
            $this->cas_db->select('updatedby,updated,'
                . 'DATE(updated) as udate,'
                . 'sum(dbamt) debit,'
                . 'sum(cramt) credit')
                ->from(proofsheetdetails_tbl)
                ->group_start()
                    ->where('DATE(updated) >=', $s_date)    
                    ->where('DATE(updated) <=', $e_date)
                    ->group_by('udate')
                ->group_end();
        }else{
            $order_column = array("updated","updatedby","debit","credit",null);
            $this->cas_db->select('updatedby,updated,'
                . 'DATE(updated) as udate,'
                . 'sum(dbamt) as debit,'
                . 'sum(cramt) as credit')
                ->from(proofsheetdetails_tbl)
                ->group_start()
                    ->where('DATE(updated) >=', $s_date)    
                    ->where('DATE(updated) <=', $e_date)
                    ->group_by(array("udate", "updatedby"))
                ->group_end();
        }
        
        return $this->cas_db->count_all_results();
    }
    
    public function get_hospital()
    {
        $this->db->select("compname")->from(profile_tbl);
        $query = $this->db->get();
        return $query->row('compname');
    }
    
    public function ipd_dis_ad_report($s_date,$e_date,$search)
    {
        $this->db->select('pat_classification,'
                . ' sum(case when discharged = 0 then 1 else 0 end) admitted,'
                . ' sum(case when discharged = 1 then 1 else 0 end) discharged_px')
                ->from(inpatient_tbl)
                ->where('(admitdate >= "'.$s_date.'" and admitdate <= "'.$e_date.'")', NULL, FALSE)
                ->where('(dischadate >= "'.$s_date.'" and dischadate <= "'.$e_date.'")', NULL, FALSE)
                ->where('pxtype','IPD')
                ->group_by('pat_classification')
                ->having('admitted > 0 or discharged_px > 0');
        
        if(!empty($search))  
        {  
            $this->db->like("pat_classification", $search);
        } 
        
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
    
     public function opd_dis_ad_report($s_date,$e_date,$search)
    {
        $this->db->select('casetype,'
                . ' sum(case when discharged = 0 then 1 else 0 end) admitted,'
                . ' sum(case when discharged = 1 then 1 else 0 end) discharged_px')
                ->from(inpatient_tbl)
                ->where('(admitdate >= "'.$s_date.'" and admitdate <= "'.$e_date.'")', NULL, FALSE)
                ->where('(dischadate >= "'.$s_date.'" and dischadate <= "'.$e_date.'")', NULL, FALSE)
                ->where('pxtype','OPD')
                ->group_by('casetype')
                ->having('admitted > 0 or discharged_px > 0');
        
        if(!empty($search))  
        {  
            $this->db->like("casetype", $search);
        } 
        
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
    public function dis_phic_report($s_date,$e_date,$search)
    {
        $this->db->select('phicmembr, count(*) c')
                    ->from(inpatient_tbl)
                    ->group_start()
                        ->where('(dischadate <= "'.$s_date.'" and dischadate >= "'.$e_date.'")', NULL, FALSE)
                        ->where('pxtype','IPD')
                        ->where('discharged',1)
                        ->group_by('phicmembr')
                    ->group_end();
                
        if(!empty($search))  
        {  
            $this->db->group_start()
                    ->like('phicmembr', $search)
            ->group_end();
        }  
        $this->db->order_by('phicmembr','ASC');
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
    public function doc_report($start_date,$search)
    {
                 $this->db->select('doctorname,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                            .',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(inpatient_tbl)
                ->where('((admitdate <= "'.$start_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$start_date.'" AND admitdate <= "'.$start_date.'"))')
                ->where('pxtype','IPD')
                ->group_by('doctorid');
        if(!empty($search))  
        {  
            $this->db->like("doctorname", $search); 
        }  
        
        $this->db->group_by('doctorid');
        
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
    public function px_report($search)
    {
        $this->db->select('name, phicmembr, admitdate, admittime')
                    ->from(inpatient_tbl)
                    ->group_start()
                        ->where('discharged',0)
                    ->group_end();
        if(!empty($search))  
        {  
            $this->db->group_start()
                    ->like("name", $search)
                    ->or_like("phicmembr", $search)
                    ->or_like("admitdate", $search)
            ->group_end();
        } 
        
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
    public function class_report($s_date,$e_date,$search)
    {
        $this->db->select('pat_classification, count(*) c')
                ->from(inpatient_tbl)
                ->group_start()
                    ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                    ->where('pxtype','IPD')
                    ->group_by('pat_classification having count(*) > 0',NULL,FALSE)
                ->group_end();
        
        
        if(!empty($search))  
        {  
            $this->db->group_start()
                    ->like("pat_classification", $search)
            ->group_end();
        } 
        
        $query = $this->db->get();  
        return $query->result_array(); 
    }

    public function class_info_report($s_date,$classx)
    {
         $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge')
                    ->from(inpatient_tbl)
                    ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                    ->where('pxtype','IPD')
                    ->where("pat_classification",$classx)
                    ->order_by('admit','DESC');
        
        $query = $this->db->get();  
        return $query->result_array(); 
    }



    public function dispo_info_report($s_date,$classx)
    {
          $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge')
                    ->from(inpatient_tbl)
                      ->where('dischadate >=', $s_date)
                        ->where('discharged','1')
                        ->where('pxtype','IPD')
                    ->where("disposition",$classx)
                    ->order_by('discharge','DESC');
        
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
    public function approvedticket_report($s_date)
    {
        
     $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                    ->where('CHKDONE','1')
                    ->where('APRVDONE','1')
                    ->where('deferred','0')
                    ->where('RETURNTICKET','0')
                    ->where('BOOKTYPE','CDB')
                    ->like('APRVDATETIME',$s_date)
                ->group_end();
     
        $query = $this->ams_db->get();  
        return $query->result_array(); 
    }
    
     public function csv_approvedticket_report($s_date)
    {
        
     $this->ams_db->select('PAYEE,CHEQUEAMT,EXPLANATION,TICKETDATE,note')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                    ->where('CHKDONE','1')
                    ->where('APRVDONE','1')
                    ->where('deferred','0')
                    ->where('RETURNTICKET','0')
                    ->where('BOOKTYPE','CDB')
                    ->like('APRVDATETIME',$s_date)
                ->group_end();
     
        $query = $this->ams_db->get();  
        return $query->result_array(); 
    }
    
    //deferred_report:alingling
    public function deferredticket_report()
    {
        
     $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                    ->where('CHKDONE','1')
                    ->where('APRVDONE','0')
                    ->where('deferred','1')
                    ->where('RETURNTICKET','0')
                    ->where('BOOKTYPE','CDB')
                ->group_end();
     
        $query = $this->ams_db->get();  
        return $query->result_array(); 
    }
    
    public function csv_deferredticket_report()
    {
        
     $this->ams_db->select('APRVDATETIME,PAYEE,CHEQUEAMT,EXPLANATION,TICKETDATE,note')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                    ->where('CHKDONE','1')
                    ->where('APRVDONE','0')
                    ->where('deferred','1')
                    ->where('RETURNTICKET','0')
                    ->where('BOOKTYPE','CDB')
                ->group_end();
     
        $query = $this->ams_db->get();  
        return $query->result_array(); 
    }
    
    
    public function disapprovedticket_report()
    {
        
     $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                    ->where('CHKDONE','1')
                    ->where('APRVDONE','0')
                    ->where('deferred','0')
                    ->where('RETURNTICKET','1')
                    ->where('BOOKTYPE','CDB')
                ->group_end();
     
        $query = $this->ams_db->get();  
        return $query->result_array(); 
    }
    
    public function csv_disapprovedticket_report()
    {
        
     $this->ams_db->select('APRVDATETIME,PAYEE,CHEQUEAMT,EXPLANATION,TICKETDATE,note')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                    ->where('CHKDONE','1')
                    ->where('APRVDONE','0')
                    ->where('deferred','0')
                    ->where('RETURNTICKET','1')
                    ->where('BOOKTYPE','CDB')
                ->group_end();
     
        $query = $this->ams_db->get();  
        return $query->result_array(); 
    }
    
    //disposition: alingling
    public function dispo_report($s_date,$e_date,$search)
    {
        $this->db->select('disposition, count(*) c')
                ->from(inpatient_tbl)
                ->group_start()
                    ->where('dischadate >=', $s_date)
                    ->where('discharged','1')
                    ->where('pxtype','IPD')
                    ->group_by('disposition having count(*) > 0',NULL,FALSE)
                ->group_end();
        
        
        if(!empty($search))  
        {  
            $this->db->group_start()
                    ->like("disposition", $search)
            ->group_end();
        } 
        
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
    
    //disposition
    
    public function pat_report($s_date,$e_date,$search,$type)
    {
        if ($type === 0) {
            $this->db->select('name, admitdate, admittime, dischadate, dischatime, pat_classification')
                ->from(inpatient_tbl)
                    ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                    ->where('pxtype','IPD');
        }else{
            $this->db->select('name, admitdate, admittime, dischadate, dischatime, pat_classification')
                ->from(inpatient_tbl)
                    ->where('pxtype','IPD')
                    ->where('dischadate ', $s_date)  
                    ->where('discharged ', '1');
        }
        
       
                
        if(!empty($search))  
        {  
            $this->db->group_start()
                ->like("name", $search) 
                ->or_like("admitdate", $search) 
                ->or_like("dischadate", $search) 
                ->or_like("pat_classification", $search)
            ->group_end();
        } 
        
        $this->db->order_by('name','ASC');
        
        $query = $this->db->get();  
        return $query->result_array();
    }
    
    public function proofsheet_report($s_date,$e_date,$search,$by)
    {
        $this->cas_db->select('updatedby,updated,'
                . 'DATE(updated) as udate,'
                . 'sum(dbamt) as debit,'
                . 'sum(cramt) as credit')
                ->from(proofsheetdetails_tbl)
                ->group_start()
                    ->where('DATE(updated) >=', $s_date)    
                    ->where('DATE(updated) <=', $e_date);
        if (intval($by) === 1) {
            $this->cas_db->group_by('udate');
        }else{
            $this->cas_db->group_by(array("udate", "updatedby"));
        }  
        $this->cas_db->group_end();
        
        if(!empty($search))  
        {  
            $this->cas_db->group_start();
                $this->cas_db->like("updated",$search);
                if (intval($by) === 0){
                    $this->cas_db->or_like("updatedby",$search);
                }
            $this->cas_db->group_end();
        } 
        
        $this->cas_db->order_by("udate","DESC");
        
        $query = $this->cas_db->get();  
        return $query->result_array();
        
    }
    
    //---------------------------------------------------------------------------------room stats
    
    public function get_rooms($date)
    {
        $this->db->select('roomno,"'.$date.'" as mydate,count(*) as total,
                            (select count(*) from rmlist where rmno=roomno) as totalbed,
                            (count(*) / (select count(*) from rmlist where rmno=roomno)) * 100 as percentage ')
                ->from(inpatient_tbl)
                ->where('dischadate >=', $date)    
                ->where('admitdate <=', $date)
                ->group_by('roomno');
        $query = $this->db->get();  
        return $query->result_array();
    }
    
    public function get_raw_expenses()
    {
        $this->cas_db->select('updated, expgroup, amount, debit, credit, expenseno, expcode, particulars')
                    ->from(expenses_tbl)
                    ->order_by('updated');
        $query = $this->cas_db->get();  
        return $query->result_array();
    }
    
    public function create_exp_table()
    {
        $data = $this->generate_exp_data($this->get_raw_expenses());
        $this->cas_db->empty_table(exptemp_tbl);
        $this->cas_db->insert_batch(exptemp_tbl, $data);
    }
    
    public function generate_exp_data($data)
    {
        $totaldebit = 0;
        $expenses = array();
        
        for ($i = 0; $i < count($data); $i++) {
            $totaldebit += $data[$i]['debit'];
            array_push($expenses,array(
                    'id' => $i+1,
                    'updated' => $data[$i]['updated'],
                    'expgroup' => $data[$i]['expgroup'],
                    'particulars' => $data[$i]['particulars'],
                    'amount' => $data[$i]['amount'],
                    'debit' => $data[$i]['debit'],
                    'credit' => $data[$i]['credit'],
                    'balance' => $totaldebit -= $data[$i]['credit'],
                    'expenseno' => $data[$i]['expenseno'],
                    'expcode' => $data[$i]['expcode']
                    ));
        }
        
        return $expenses;
    }
    
    //----------------------------------------------------------------------------------------expenses
    public function get_all_expenses()
    {
        $order_column = array("updated","expgroup","amount","debit","credit","balance",NULL);
        $this->cas_db->select('updated, expgroup, amount, debit, credit, balance, id, particulars')->from(exptemp_tbl);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->cas_db->group_start()
                    ->like("updated", $this->input->post("search")["value"])
                    ->or_like("expgroup", $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->cas_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->cas_db->order_by("updated","DESC");
        }
    }
    
    /**
     * 
     * make all expenses table
     */
    function make_all_expenses_datatables(){  
        $this->get_all_expenses();  
        if($this->input->post("length") != -1)  
        {  
            $this->cas_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->cas_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all expenses table
     */
    
    function get_all_expenses_filtered_data(){  
        $this->get_all_expenses();  
        $query = $this->cas_db->get();  
        return $query->num_rows();  
    }
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_expenses_data()
    {
        $this->cas_db->select('updated, expgroup, amount, debit, credit, balance, id')->from(exptemp_tbl);
        
        return $this->cas_db->count_all_results();
    }
    
    public function exp_report($search)
    {
        $this->cas_db->select('updated, expgroup, amount, debit, credit, expenseno, expcode, particulars, balance')->from(exptemp_tbl);
        
        if(!empty($search))  
        {  
            $this->cas_db->group_start()
                ->like("updated", $search) 
                ->or_like("expgroup", $search) 
            ->group_end();
        } 
        
        $this->cas_db->order_by('updated','DESC');
        
        $query = $this->cas_db->get();  
        return $query->result_array();
    }   

//    public function get_ledger($stock_barcode)
//    {
//        // $this->
//        $this->pms_db->select(ledgersales_tbl.'.dscr,'
//                .ledgersales_tbl.'.cost,'
//                .ledgersales_tbl.'.qty,'
//                .ledgersales_tbl.'.totalcost')
//                ->where("prodid",$stock_barcode);
//        
//        $query = $this->db->get();
//        
//        return $query->result_array();
//    }
    
    //---------------------------------------------------------------------------------------------ledger
    public function get_ledger($stock_barcode)
    {
        $order_column = array(ledgersales_tbl.".dscr",ledgersales_tbl.".cost",ledgersales_tbl.".qty",ledgersales_tbl.".totalcost");
        $this->pms_db->select(ledgersales_tbl.'.dscr,'
                .ledgersales_tbl.'.cost,'
                .ledgersales_tbl.'.qty,'
                .ledgersales_tbl.'.totalcost,'
                .ledgersales_tbl.'.tdate')
                ->from(ledgersales_tbl)
                ->where("prodid",$stock_barcode);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->pms_db->group_start()
                    ->like(ledgersales_tbl.'.dscr', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->pms_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->pms_db->order_by("tdate","DESC");
        }
    }
    
    /**
     * 
     * make all purchases table
     */
    function make_ledger_datatables($bar_code){  
        $this->get_ledger($bar_code);  
        if($this->input->post("length") != -1)  
        {  
            $this->pms_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->pms_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_ledger_filtered_data($bar_code){  
        $this->get_ledger($bar_code);  
        $query = $this->pms_db->get();  
        return $query->num_rows();  
    }
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_ledger_data($stock_barcode)
    {
        $this->pms_db->select(ledgersales_tbl.'.dscr,'
                .ledgersales_tbl.'.cost,'
                .ledgersales_tbl.'.qty,'
                .ledgersales_tbl.'.totalcost')
                ->from(ledgersales_tbl)
                ->where("prodid",$stock_barcode);
        return $this->pms_db->count_all_results();
    }
    
    //---------------------------------------------------------------------------------------------purchases
    public function get_all_purchases($type)
    {
        $order_column = array(prequests_tbl.".dscr",pomaster_tbl.".reqdatetime",prequests_tbl.".cost",prequests_tbl.".qty",prequests_tbl.".totalcost",NULL);
        $this->db->select(prequests_tbl.'.dscr,'
                            . prequests_tbl.'.qty,'
                            . prequests_tbl.'.cost,'
                            . prequests_tbl.'.totalcost,'
                            . prequests_tbl.'.control,'
                            . prequests_tbl.'.noteofdisapproval,'
                            . prequests_tbl.'.noteofresubmission,'
                            . pomaster_tbl.'.suppliername,'
                            . pomaster_tbl.'.address,'
                            . pomaster_tbl.'.term,'
                            . pomaster_tbl.'.podate,'
                            . prequests_tbl.'.balqty,'
                            . prequests_tbl.'.stockbarcode,'
                            . 'DATE('.pomaster_tbl.'.reqdatetime) as reqdatetime')
                ->from(prequests_tbl)
                ->join(pomaster_tbl,pomaster_tbl.".pocode = ".prequests_tbl.".pocode")
                ->where(prequests_tbl.'.forapproval',($type === "fapproval") ? 1 : 1)
                ->where(prequests_tbl.'.approved',($type === "approve") ? 1 : 0)
                ->where(prequests_tbl.'.deffered',($type === "deffer") ? 1 : 0)
                ->where(prequests_tbl.'.disapproved',($type === "disaprove") ? 1 : 0);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like(prequests_tbl.'.dscr', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by("reqdatetime","DESC");
        }
    }
    
    /**
     * 
     * make all purchases table
     */
    function make_all_purchases_datatables($type){  
        $this->get_all_purchases($type);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_all_purchases_filtered_data($type){  
        $this->get_all_purchases($type);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_purchases_data($type)
    {
        $this->db->select(prequests_tbl.'.dscr,'
                            . prequests_tbl.'.qty,'
                            . prequests_tbl.'.cost,'
                            . prequests_tbl.'.totalcost,'
                            . prequests_tbl.'.control,'
                            . prequests_tbl.'.noteofdisapproval,'
                            . prequests_tbl.'.noteofresubmission,'
                            . pomaster_tbl.'.suppliername,'
                            . pomaster_tbl.'.address,'
                            . pomaster_tbl.'.term'
                            . pomaster_tbl.'.podate'
                            . pomaster_tbl.'.reqdatetime')
                ->from(prequests_tbl)
                ->join(pomaster_tbl,pomaster_tbl.".pocode = ".prequests_tbl.".pocode")
                ->where(prequests_tbl.'.forapproval',($type === "fapproval") ? 1 : 0)
                ->where(prequests_tbl.'.approved',($type === "approve") ? 1 : 0)
                ->where(prequests_tbl.'.deffered',($type === "deffer") ? 1 : 0)
                ->where(prequests_tbl.'.disapproved',($type === "disaprove") ? 1 : 0);
        return $this->db->count_all_results();
    }
    
    
    public function approve_purchase($ctrls)
    {
        $approved = FALSE;
        $data = array(
            'approved' => 1,
            'dateapproved' => $this->get_current_date(),
            'approvedby' => $this->session->userdata('empname')
        );
        
        for ($i = 0; $i < count($ctrls); $i++) {
            $this->db->where('control',  $this->security->xss_clean(intval($ctrls[$i])));
            if ($this->db->update(prequests_tbl, $data)) {
                $approved = TRUE;
            }
        }
        
        return $approved;
    }
    
    
    public function disapprove_purchase($ctrls)
    {
        $disapproved = FALSE;
        $data = array(
            'disapproved' => 1,
            'datedisapproved' => $this->get_current_date(),
            'noteofdisapproval' => $this->security->xss_clean($this->input->post('b')),
            'approvedby' => $this->session->userdata('empname')
        );
        
        for ($i = 0; $i < count($ctrls); $i++) {
            $this->db->where('control',  $this->security->xss_clean(intval($ctrls[$i])));
            if ($this->db->update(prequests_tbl, $data)) {
                $disapproved = TRUE;
            }
        }
        
        return $disapproved;
    }
    
    public function deffer_purchase($ctrls)
    {
        $deffered = FALSE;
        $data = array(
            'deffered' => 1,
            'datedisapproved' => $this->get_current_date(),
            'noteofresubmission' => $this->security->xss_clean($this->input->post('b')),
            'approvedby' => $this->session->userdata('empname')
        );
        
        for ($i = 0; $i < count($ctrls); $i++) {
            $this->db->where('control',  $this->security->xss_clean(intval($ctrls[$i])));
            if ($this->db->update(prequests_tbl, $data)) {
                $deffered = TRUE;
            }
        }
        
        return $deffered;
    }
    
    public function today_census()
    {
       $this->db->select('sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(inpatient_tbl)
//                ->where('dischadate >=', $date)    
            ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype','IPD')
                ->where("discharged",0);
        $query = $this->db->get();
        return $query->row_array(); 
    }   
    
    //---------------------------------------------------------------------------------------------purchases
    public function get_phic($s_date,$e_date)
    {
        $order_column = array("phicmembr","c");
        $this->db->select('phicmembr, count(*) c')
                    ->from(inpatient_tbl)
                    ->group_start()
                        ->where('(dischadate <= "'.$s_date.'" and dischadate >= "'.$e_date.'")', NULL, FALSE)
                        ->where('pxtype','IPD')
                        ->where('discharged',1)
                        ->group_by('phicmembr')
                    ->group_end();
                
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like('phicmembr', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by("phicmembr","ASC");
        }
    }
    
    /**
     * 
     * make all purchases table
     */
    function make_phic_datatables($s_date,$e_date){  
        $this->get_phic($s_date,$e_date);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_phic_filtered_data($s_date,$e_date){  
        $this->get_phic($s_date,$e_date);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_phic_data($s_date,$e_date)
    {
        $this->db->select('phicmembr, count(*) c')
                    ->from(inpatient_tbl)
                    ->group_start()
                        ->where('dischadate <= "'.$s_date.'" and dischadate >= "'.$e_date.'"', NULL, FALSE)
                        ->where('pxtype','IPD')
                        ->where('discharged',1)
                        ->group_by('phicmembr')
                    ->group_end();
        return $this->db->count_all_results();
    }
    
    /* Voucher-> Cheque Approval
     * @author Alingling
     */
    public function get_all_ticket()
    {
        $order_column = array("TICKETDATE","EXPLANATION","PAYEE","CHEQUEAMT");
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE','1')
                ->where('APRVDONE','0')
                ->where('RETURNTICKET','0')
                ->where('deferred','0')
                ->where('BOOKTYPE','CDB');
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->ams_db->group_start()
                -> like("EXPLANATION", $this->input->post("search")["value"])
                ->or_like("PAYEE", $this->input->post("search")["value"])
                ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->ams_db->order_by("TICKETDATE","DESC");
        }
    }
    
    /**
     * 
     * make all purchases table
     */
    function make_all_ticket_datatables(){  
        $this->get_all_ticket();  
        if($this->input->post("length") != -1)  
        {  
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->ams_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_all_ticket_filtered_data(){  
        $this->get_all_ticket();  
        $query = $this->ams_db->get();  
        return $query->num_rows();  
    }
    
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_ticket_data()
    {
      $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE','1')
                ->where('APRVDONE','0')
              ->where('RETURNTICKET','0')
               ->where('deferred','0')
               ->where('BOOKTYPE','CDB');
        return $this->ams_db->count_all_results();
    }
    
    
    /**
     * GEt Disapproved Ticket
     * @author Alingling
     */
    
    public function get_all_disapprovedticket()
    {
        $order_column = array("TICKETDATE","EXPLANATION","PAYEE","CHEQUEAMT","note");
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE','1')
                ->where('APRVDONE','0')
                ->where('RETURNTICKET','1')
                 ->where('BOOKTYPE','CDB');
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->ams_db->group_start()
                -> like("EXPLANATION", $this->input->post("search")["value"])
                ->or_like("PAYEE", $this->input->post("search")["value"])
                ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                ->or_like("note", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->ams_db->order_by("TICKETDATE","DESC");
        }
    }
    
    /**
     * 
     * make all purchases table
     */
    function make_all_disapprovedticket_datatables(){  
        $this->get_all_disapprovedticket();  
        if($this->input->post("length") != -1)  
        {  
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->ams_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_all_disapprovedticket_filtered_data(){  
        $this->get_all_disapprovedticket();  
        $query = $this->ams_db->get();  
        return $query->num_rows();  
    }
    
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_disapprovedticket_data()
    {
      $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE','1')
                ->where('APRVDONE','0')
              ->where('RETURNTICKET','1')
               ->where('BOOKTYPE','CDB');
        return $this->ams_db->count_all_results();
    }
    
    /*
     * Get deferred Ticket
     * @author Alingling
     */
    public function get_all_deferredticket()
    {
        $order_column = array("TICKETDATE","EXPLANATION","PAYEE","CHEQUEAMT","note");
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE','1')
                ->where('APRVDONE','0')
                ->where('deferred','1')
                 ->where('BOOKTYPE','CDB');
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->ams_db->group_start()
                -> like("EXPLANATION", $this->input->post("search")["value"])
                ->or_like("PAYEE", $this->input->post("search")["value"])
                ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                ->or_like("note", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->ams_db->order_by("TICKETDATE","DESC");
        }
    }
    
    /**
     * 
     * make all purchases table
     */
    function make_all_deferredticket_datatables(){  
        $this->get_all_deferredticket();  
        if($this->input->post("length") != -1)  
        {  
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->ams_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_all_deferredticket_filtered_data(){  
        $this->get_all_deferredticket();  
        $query = $this->ams_db->get();  
        return $query->num_rows();  
    }
    
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_deferredticket_data()
    {
      $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE','1')
                ->where('APRVDONE','0')
              ->where('deferred','1')
               ->where('BOOKTYPE','CDB');
        return $this->ams_db->count_all_results();
    }
    //
    public function get_all_approvedticket()
    {
          $currentdate = $this->get_current_datex();
        $order_column = array("TICKETDATE","EXPLANATION","PAYEE","CHEQUEAMT","note","PREPARE","CHEQUE","APPROVE");
        $this->ams_db->select('TICKETDATE,TICKETCODE,EXPLANATION,PAYEE,CHEQUEAMT,note,concat(PREPARED," @ ",PREPDATETIME) as PREPARE,concat(CHECKED," @ ",CHKDATETIME) as CHEQUE,concat(APPROVED," @ ",APRVDATETIME) as APPROVE')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                    ->where('CHKDONE','1')
                    ->where('APRVDONE','1')
                    ->where('deferred','0')
                    ->where('RETURNTICKET','0')
                    ->where('BOOKTYPE','CDB')
                    ->like('APRVDATETIME',$currentdate)
                ->group_end();
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->ams_db->group_start()
                -> like("EXPLANATION", $this->input->post("search")["value"])
                ->or_like("PAYEE", $this->input->post("search")["value"])
                ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                ->or_like("note", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->ams_db->order_by("TICKETDATE","DESC");
        }
    }
    
    /**
     * 
     * make all purchases table
     */
    function make_all_approvedticket_datatables(){  
        $this->get_all_approvedticket();  
        if($this->input->post("length") != -1)  
        {  
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->ams_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_all_approvedticket_filtered_data(){  
        $this->get_all_approvedticket();  
        $query = $this->ams_db->get();  
        return $query->num_rows();  
    }
    
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_approvedticket_data()
    {
        $currentdate = $this->get_current_datex();
        $this->ams_db->select('TICKETDATE,TICKETCODE,EXPLANATION,PAYEE,CHEQUEAMT,note,concat(PREPARED," @ ",PREPDATETIME) as PREPARE,concat(CHECKED," @ ",CHKDATETIME) as CHEQUE,concat(APPROVED," @ ",APRVDATETIME) as APPROVE')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                    ->where('CHKDONE','1')
                    ->where('APRVDONE','1')
                    ->where('deferred','0')
                    ->where('RETURNTICKET','0')
                    ->where('BOOKTYPE','CDB')
                    ->like('APRVDATETIME',$currentdate)
                ->group_end();
        return $this->ams_db->count_all_results();
    }
    
    //////////////////////
     public function get_all_approvedticketbydate($s_date)
    {
        $order_column = array("TICKETDATE","EXPLANATION","PAYEE","CHEQUEAMT","note","PREPARE","CHEQUE","APPROVE");
        $this->ams_db->select('TICKETDATE,TICKETCODE,EXPLANATION,PAYEE,CHEQUEAMT,note,concat(PREPARED," @ ",PREPDATETIME) as PREPARE,concat(CHECKED," @ ",CHKDATETIME) as CHEQUE,concat(APPROVED," @ ",APRVDATETIME) as APPROVE')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE','1')
                ->where('APRVDONE','1')
                ->where('deferred','0')
                ->where('RETURNTICKET','0')
                ->where('BOOKTYPE','CDB')
                ->like('APRVDATETIME',$s_date);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->ams_db->group_start()
                -> like("EXPLANATION", $this->input->post("search")["value"])
                ->or_like("PAYEE", $this->input->post("search")["value"])
                ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                ->or_like("note", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->ams_db->order_by("TICKETDATE","DESC");
        }
    }
    
    /**
     * 
     * make all purchases table
     */
    function make_all_approvedticketbydate_datatables($s_date){  
        $this->get_all_approvedticketbydate($s_date);  
        if($this->input->post("length") != -1)  
        {  
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->ams_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_all_approvedticketbydate_filtered_data($s_date){  
        $this->get_all_approvedticketbydate($s_date);  
        $query = $this->ams_db->get();  
        return $query->num_rows();  
    }
    
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_approvedticketbydate_data($s_date)
    {
      $this->ams_db->select('TICKETDATE,TICKETCODE,EXPLANATION,PAYEE,CHEQUEAMT,note,concat(PREPARED," @ ",PREPDATETIME) as PREPARE,concat(CHECKED," @ ",CHKDATETIME) as CHEQUE,concat(APPROVED," @ ",APRVDATETIME) as APPROVE')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE','1')
                ->where('APRVDONE','1')
                ->where('deferred','0')
                ->where('RETURNTICKET','0')
                ->where('BOOKTYPE','CDB')
                ->like('APRVDATETIME',$s_date);
        return $this->ams_db->count_all_results();
    }
    
    
    
    //
    
    public function get_ticketdetails($id)
    {
            $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE','1')
                ->where('APRVDONE','0')
                ->where('TICKETREF',$id);
            $query = $this->ams_db->get();
            return $query->row_array();
    
    }
    
    public function get_ticketdetailx($id)
    {
            $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
         
                ->where('TICKETREF',$id);
            $query = $this->ams_db->get();
            return $query->row_array();
    
    }
    
    public function get_all_creditdebit_ticket($ticketcode)
    {
        $order_column = array("COACODE","ACCTTITLE","DBAMT","CRAMT");
        $this->ams_db->select('*')
                ->from(viewmyticket_view)
                ->where('TICKETCODE',$ticketcode);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->ams_db->group_start()
                -> like("EXPLANATION", $this->input->post("search")["value"])
                ->or_like("PAYEE", $this->input->post("search")["value"])
                ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->ams_db->order_by("TICKETDATE","DESC");
        }
    }
    
    /**
     * 
     * make all purchases table
     */
    function make_all_creditdebit_ticket_datatables($ticketcode){  
        $this->get_all_creditdebit_ticket($ticketcode);  
        if($this->input->post("length") != -1)  
        {  
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->ams_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_all_creditdebit_ticket_filtered_data($ticketcode){  
        $this->get_all_creditdebit_ticket($ticketcode);  
        $query = $this->ams_db->get();  
        return $query->num_rows();  
    }
    
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_creditdebit_ticket_data($ticketcode)
    {
      $this->ams_db->select('*')
                ->from(viewmyticket_view)
                ->where('TICKETCODE',$ticketcode);
        return $this->ams_db->count_all_results();
    }
    
     public function checkapprovedticket($d)
    {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE','1')
                ->group_start()
                ->where('APRVDONE','1')
                ->or_where('RETURNTICKET','1')
                ->or_where('deferred','1')
                ->group_end()
                ->where('TICKETREF',$d["ticketref"]);
                $query = $this->ams_db->get();
                return $query->row_array();
    }
    
    public function checkticket($ctrls)
    {
        
            $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE','1')
                ->group_start()
                ->where('APRVDONE','1')
                ->or_where('RETURNTICKET','1')
                ->or_where('deferred','1')
                ->group_end()
                ->where('TICKETREF',$this->security->xss_clean(intval($ctrls)));
                $query = $this->ams_db->get();
                return $query->row_array();
        
    }
    
    /*
     * update ticketsumfinal
     * @author Alingling
     */
    public function update_ticketdetails($d)
    {
        $data = array(
            'APRVDONE'      => $this->security->xss_clean("1"),
            'APPROVED'      => $this->session->userdata('empname'),
            'APRVDATETIME'  => $this->get_current_date(),
            );
        $this->ams_db->where('TICKETREF', $this->security->xss_clean($d['ticketref']));
        return $this->ams_db->update("ticketsumfinal", $data);
    }
    
    public function approve_ticketdetails($ctrls)
    {
        $data = array(
            'APRVDONE'      => $this->security->xss_clean("1"),
            'APPROVED'      => $this->session->userdata('empname'),
            'APRVDATETIME'  => $this->get_current_date(),
            );
        
        for ($i = 0; $i < count($ctrls); $i++) {
            $this->ams_db->where('TICKETREF',  $this->security->xss_clean(intval($ctrls[$i])));
            if ($this->ams_db->update(ticketsumfinal_tbl, $data)) {
                $approved = TRUE;
            }
        }
        
        return $approved;
        
    }
    
    public function disapprove_ticketdetails($ctrl)
    {
        $data = array(
            'RETURNTICKET'  => $this->security->xss_clean("1"),
            'deferred'  => $this->security->xss_clean("0"),
            'APPROVED'      => $this->session->userdata('empname'),
            'APRVDATETIME'  => $this->get_current_date(),
            'note'          =>$this->security->xss_clean($this->input->post('b')),
            );
        for ($i = 0; $i < count($ctrl); $i++) {
            $this->ams_db->where('TICKETREF',  $this->security->xss_clean(intval($ctrl[$i])));
            if ($this->ams_db->update(ticketsumfinal_tbl, $data)) {
                $approved = TRUE;
            }
        }
         return $approved;
    }
    
    public function deferred_ticketdetails($ctrl)
    { 
        $data = array(
            'deferred'  => $this->security->xss_clean("1"),
            'RETURNTICKET'  => $this->security->xss_clean("0"),
            'APPROVED'      => $this->session->userdata('empname'),
            'APRVDATETIME'  => $this->get_current_date(),
            'note'          =>$this->security->xss_clean($this->input->post('b')),
            );
        for ($i = 0; $i < count($ctrl); $i++) {
            $this->ams_db->where('TICKETREF',  $this->security->xss_clean(intval($ctrl[$i])));
            if ($this->ams_db->update(ticketsumfinal_tbl, $data)) {
                $approved = TRUE;
            }
        }
         return $approved;
    }
    
     public function update_ticketdetailsdis($d)
    {
        $data = array(
            'RETURNTICKET'  => $this->security->xss_clean("1"),
            'deferred'  => $this->security->xss_clean("0"),
            'APPROVED'      => $this->session->userdata('empname'),
            'APRVDATETIME'  => $this->get_current_date(),
            'note'          => $this->security->xss_clean($d['note'])
            );
        $this->ams_db->where('TICKETREF', $this->security->xss_clean($d['ticketref']));
        return $this->ams_db->update("ticketsumfinal", $data);
    }
    
    public function update_ticketdetailsdef($d)
    {
        $data = array(
            'deferred'  => $this->security->xss_clean("1"),
            'RETURNTICKET'  => $this->security->xss_clean("0"),
            'APPROVED'      => $this->session->userdata('empname'),
            'APRVDATETIME'  => $this->get_current_date(),
            'note'          => $this->security->xss_clean($d['note'])
            );
        $this->ams_db->where('TICKETREF', $this->security->xss_clean($d['ticketref']));
        return $this->ams_db->update("ticketsumfinal", $data);
    }
    
     /* Cheque Monitoring
     * @author Alingling
     */
    public function get_all_prep_ticket()
    {
        $order_column = array("TICKETDATE","EXPLANATION","PAYEE","CHEQUEAMT");
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('PREPDONE','1')
                ->where('CHKDONE','0')
                ->where('APRVDONE','0')
                ->where('RETURNTICKET','0')
                ->where('deferred','0')
                ->where('BOOKTYPE','CDB');
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->ams_db->group_start()
                -> like("EXPLANATION", $this->input->post("search")["value"])
                ->or_like("PAYEE", $this->input->post("search")["value"])
                ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->ams_db->order_by("TICKETDATE","DESC");
        }
    }
    
    /**
     * 
     * make all purchases table
     */
    function make_all_prep_ticket_datatables(){  
        $this->get_all_prep_ticket();  
        if($this->input->post("length") != -1)  
        {  
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->ams_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_all_prep_ticket_filtered_data(){  
        $this->get_all_prep_ticket();  
        $query = $this->ams_db->get();  
        return $query->num_rows();  
    }
    
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_prep_ticket_data()
    {
      $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('PREPDONE','1')
                ->where('CHKDONE','0')
                ->where('APRVDONE','0')
                ->where('RETURNTICKET','0')
               ->where('deferred','0')
               ->where('BOOKTYPE','CDB');
        return $this->ams_db->count_all_results();
    }
    
     /* get ALL CHEQUE TICKETS
     * @author Alingling
     */
    public function get_all_cheque_ticket()
    {
        $order_column = array("TICKETDATE","EXPLANATION","PAYEE","CHEQUEAMT","CHKDATETIME","TICKETDATE","TICKETCODE");
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('BOOKTYPE','CDB');
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->ams_db->group_start()
                -> like("EXPLANATION", $this->input->post("search")["value"])
                ->or_like("PAYEE", $this->input->post("search")["value"])
                ->or_like("CHKDATETIME", $this->input->post("search")["value"])
                ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->ams_db->order_by("TICKETDATE","DESC");
        }
    }
    
    /**
     * 
     * make all purchases table
     */
    function make_all_cheque_ticket_datatables(){  
        $this->get_all_cheque_ticket();  
        if($this->input->post("length") != -1)  
        {  
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->ams_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_all_cheque_ticket_filtered_data(){  
        $this->get_all_cheque_ticket();  
        $query = $this->ams_db->get();  
        return $query->num_rows();  
    }
    
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_cheque_ticket_data()
    {
      $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
               ->where('BOOKTYPE','CDB');
        return $this->ams_db->count_all_results();
    }
    
    
    /**
     * Gets all on process philhealth account.
     * 
     * @author pauldigz@gmail.com
     * @param string $date(Y-m-d)
     */
    
    public function get_op_phic_accnt($date)
    {
        $order_column = array("aging","total","totalamount");
        $this->med_db->select('case 
                                when  datediff("'.$date.'", dischadate) <= 15 THEN "1-15 Days"
                                when  datediff("'.$date.'", dischadate) <= 30 THEN "16-30 Days"
                                when  datediff("'.$date.'", dischadate) <= 45 THEN "31-45 Days"
                                when  datediff("'.$date.'", dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(phicHCItotal) as totalamount')
                ->from(patientphic_vw)
                ->where('dischadate <=',$date)
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno','')
                ->group_by('aging');
                
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->med_db->group_start()
                    ->like('(case 
                                when  datediff("'.$date.'", dischadate) <= 15  THEN "1-15 days" 
                                when  datediff("'.$date.'", dischadate) <= 30 THEN "16-30 days" 
                                when  datediff("'.$date.'", dischadate) <= 45 THEN "31-45 days" 
                                when  datediff("'.$date.'", dischadate) <= 60 THEN "46-60 days"
                                ELSE "61 Days aboved"
                           END)', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->med_db->order_by('aging','ASC');
        }
    }
    
    /**
     * Make on process philhealth account datatable. 
     * 
     * @author pauldigz@gmail.com
     * @param datetime $date (Y-m-d)
     * @return array
     */
    function make_op_phic_accnt_datatables($date){  
        $this->get_op_phic_accnt($date);  
        if($this->input->post("length") != -1)  
        {  
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->med_db->get();  
        return $query->result();  
    }
    
    /**
     * Return the number of rows when a user search a data in jquery datatable.
     * 
     * @author pauldigz@gmail.com 
     * @param date $date (Y-m-d)
     * @return int
     */
    function get_op_phic_accnt_filtered_data($date){  
        $this->get_op_phic_accnt($date);  
        $query = $this->med_db->get();  
        return $query->num_rows();  
    }
    
    public function get_op_phic_accnt_data($date)
    {
        $this->med_db->select('case 
                                when  datediff("'.$date.'", dischadate) <= 15 THEN "1-15 Days"
                                when  datediff("'.$date.'", dischadate) <= 30 THEN "16-30 Days"
                                when  datediff("'.$date.'", dischadate) <= 45 THEN "31-45 Days"
                                when  datediff("'.$date.'", dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(phicHCItotal) as totalamount')
                ->from(patientphic_vw)
                ->where('dischadate <=',$date)
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno','')
                ->group_by('aging');
        return $this->med_db->count_all_results();
    }
    
    /*
     * Get Transmittal Account
     * 
     * @author Alingling
     * @patam string 11-25-2017
     */
    
    public function get_transmit_phic_accnt($date)
    {
        
        $order_column = array("aging","total","totalamount");
        
        $this->med_db->select('case 
                                when  datediff(postingdateclaim,dischadate) <= 15 THEN "1-15 Days"
                                when  datediff(postingdateclaim,dischadate) <= 30 THEN "16-30 Days"
                                when  datediff(postingdateclaim,dischadate) <= 45 THEN "31-45 Days"
                                when  datediff(postingdateclaim,dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphic_vw)
                ->where('YEAR(dischadate) <= YEAR("'.$date.'")')
                ->where('MONTH(dischadate) <= MONTH("'.$date.'")')
                ->where('YEAR(postingdateclaim) <= YEAR("'.$date.'")')
                ->where('MONTH(postingdateclaim) >= MONTH("'.$date.'")')
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno <> ""')
                ->group_by('aging');
                
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->med_db->group_start()
                    ->like('(case 
                               when  datediff(postingdateclaim,dischadate) <= 15 THEN "1-15 Days"
                                when  datediff(postingdateclaim,dischadate) <= 30 THEN "16-30 Days"
                                when  datediff(postingdateclaim,dischadate) <= 45 THEN "31-45 Days"
                                when  datediff(postingdateclaim,dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days aboved"
                           END)', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->med_db->order_by('aging','ASC');
        }
    }
    
 
    function make_transmit_phic_accnt_datatables($date){  
        $this->get_transmit_phic_accnt($date);  
        if($this->input->post("length") != -1)  
        {  
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->med_db->get();  
        return $query->result();  
    }
    
   
    function get_transmit_phic_accnt_filtered_data($date){  
        $this->get_transmit_phic_accnt($date);  
        $query = $this->med_db->get();  
        return $query->num_rows();  
    }
    
    public function get_transmit_phic_accnt_data($date)
    {
        
      $this->med_db->select('case 
                                when  datediff(postingdateclaim,dischadate) <= 15 THEN "1-15 Days"
                                when  datediff(postingdateclaim,dischadate) <= 30 THEN "16-30 Days"
                                when  datediff(postingdateclaim,dischadate) <= 45 THEN "31-45 Days"
                                when  datediff(postingdateclaim,dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphic_vw)
                ->where('YEAR(dischadate) <= YEAR("'.$date.'")')
                ->where('MONTH(dischadate) <= MONTH("'.$date.'")')
                ->where('YEAR(postingdateclaim) <= YEAR("'.$date.'")')
                ->where('MONTH(postingdateclaim) >= MONTH("'.$date.'")')
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno <> ""')
                ->group_by('aging');
        return $this->med_db->count_all_results();
    }
    
    //payments_PHIC_aging to transmittal: alingling
    public function get_payment_phic_accnt($date)
    {
        
        $order_column = array("aging","total","totalamount");
        
        $this->med_db->select('case 
                            when  datediff(postingdateclaim,phicvoucherdate) <= 30 THEN "1-30 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 60 THEN "31-60 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 90 THEN "61-90 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphic_vw)
                 ->where('YEAR(phicvoucherdate) >= YEAR("'.$date.'")')
                ->where('MONTH(phicvoucherdate) = MONTH("'.$date.'")')
                ->where('claimstatus',"PAYMENTS")
                ->group_by('aging');
                
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->med_db->group_start()
                    ->like('(case 
                            when  datediff(postingdateclaim,phicvoucherdate) <= 30 THEN "1-30 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 60 THEN "31-60 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 90 THEN "61-90 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                           END)', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->med_db->order_by('aging','ASC');
        }
    }
    
 
    function make_payment_phic_accnt_datatables($date){  
        $this->get_payment_phic_accnt($date);  
        if($this->input->post("length") != -1)  
        {  
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->med_db->get();  
        return $query->result();  
    }
    
   
    function get_payment_phic_accnt_filtered_data($date){  
        $this->get_payment_phic_accnt($date);  
        $query = $this->med_db->get();  
        return $query->num_rows();  
    }
    
    public function get_payment_phic_accnt_data($date)
    {
       $this->med_db->select('case 
                            when  datediff(postingdateclaim,phicvoucherdate) <= 30 THEN "1-30 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 60 THEN "31-60 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 90 THEN "61-90 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphic_vw)
                  ->where('YEAR(phicvoucherdate) >= YEAR("'.$date.'")')
                ->where('MONTH(phicvoucherdate) = MONTH("'.$date.'")')
                ->where('claimstatus',"PAYMENTS")
                ->group_by('aging');
        return $this->med_db->count_all_results();
    }
    
    //payments_PHIC_aging to discharge: alingling
    public function get_payment_discharge_phic_accnt($date)
    {
        
        $order_column = array("aging","total","totalamount");
        
        $this->med_db->select('case 
                            when  datediff(dischadate,phicvoucherdate) <= 30 THEN "1-30 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 60 THEN "31-60 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 90 THEN "61-90 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphic_vw)
                ->where('YEAR(phicvoucherdate) >= YEAR("'.$date.'")')
                ->where('MONTH(phicvoucherdate) = MONTH("'.$date.'")')
                ->where('claimstatus',"PAYMENTS")
                ->group_by('aging');
                
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->med_db->group_start()
                    ->like('(case 
                            when  datediff(dischadate,phicvoucherdate) <= 30 THEN "1-30 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 60 THEN "31-60 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 90 THEN "61-90 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                           END)', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->med_db->order_by('aging','ASC');
        }
    }
    
 
    function make_payment_discharge_phic_accnt_datatables($date){  
        $this->get_payment_discharge_phic_accnt($date);  
        if($this->input->post("length") != -1)  
        {  
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->med_db->get();  
        return $query->result();  
    }
    
   
    function get_payment_discharge_phic_accnt_filtered_data($date){  
        $this->get_payment_discharge_phic_accnt($date);  
        $query = $this->med_db->get();  
        return $query->num_rows();  
    }
    
    public function get_payment_discharge_phic_accnt_data($date)
    {
       $this->med_db->select('case 
                            when  datediff(dischadate,phicvoucherdate) <= 30 THEN "1-30 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 60 THEN "31-60 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 90 THEN "61-90 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphic_vw)
                  ->where('YEAR(phicvoucherdate) >= YEAR("'.$date.'")')
                ->where('MONTH(phicvoucherdate) = MONTH("'.$date.'")')
                ->where('claimstatus',"PAYMENTS")
                ->group_by('aging');
        return $this->med_db->count_all_results();
    }
    
      
    /**
     * Get Payment: Aging to Transmittal Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_payment_transmittal_phic_patients($date,$aging)
    {
        
        $order_column = array("name","caserateTotalActual","phicvoucherno","dischadate","postingdateclaim","age","phicmembr");
          $this->med_db->select('name,dischadate,phicmembr,postingdateclaim,datediff(postingdateclaim,phicvoucherdate) as age,phicvoucherdate,caserateTotalActual,phicvoucherno')
                ->from(patientphic_vw)
                  ->where('YEAR(phicvoucherdate) >= YEAR("'.$date.'")')
                ->where('MONTH(phicvoucherdate) = MONTH("'.$date.'")')
                ->where('claimstatus',"PAYMENTS")
                ->where ('case 
                            when  datediff(postingdateclaim,phicvoucherdate) <= 30 THEN "1-30 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 60 THEN "31-60 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 90 THEN "61-90 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END = "'.$aging.'"');
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->med_db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                     ->or_like('phicmembr', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->med_db->order_by('postingdateclaim','ASC');
        }
    }
    
 
    function make_payment_transmittal_patient_datatables($date,$aging){  
        $this->get_payment_transmittal_phic_patients($date,$aging);  
        if($this->input->post("length") != -1)  
        {  
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->med_db->get();  
        return $query->result();  
    }
    
   
    function get_payment_transmittal_patients_filtered_data($date,$aging){  
        $this->get_payment_transmittal_phic_patients($date,$aging);  
        $query = $this->med_db->get();  
        return $query->num_rows();  
    }
    
    public function get_payment_transmittal_patients_data($date,$aging)
    {
        $this->med_db->select('name,dischadate,phicmembr,postingdateclaim,datediff(postingdateclaim,phicvoucherdate) as age,phicvoucherdate,caserateTotalActual,phicvoucherno')
                ->from(patientphic_vw)
                 ->where('YEAR(phicvoucherdate) >= YEAR("'.$date.'")')
                ->where('MONTH(phicvoucherdate) = MONTH("'.$date.'")')
                ->where('claimstatus',"PAYMENTS")
                ->where ('case 
                            when  datediff(postingdateclaim,phicvoucherdate) <= 30 THEN "1-30 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 60 THEN "31-60 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 90 THEN "61-90 Days"
                            when  datediff(postingdateclaim,phicvoucherdate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END = "'.$aging.'"');
        return $this->med_db->count_all_results();
    }  
    
    /**
     * Get Payment: Aging to Discharge Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_payment_discharge_phic_patients($date,$aging)
    {
       
        $order_column = array("name","caserateTotalActual","phicvoucherno","dischadate","postingdateclaim","age","phicmembr");
          $this->med_db->select('name,dischadate,phicmembr,postingdateclaim,datediff(dischadate,phicvoucherdate) as age,phicvoucherdate,caserateTotalActual,phicvoucherno')
                ->from(patientphic_vw)
                  ->where('YEAR(phicvoucherdate) >= YEAR("'.$date.'")')
                ->where('MONTH(phicvoucherdate) = MONTH("'.$date.'")')
                ->where('claimstatus',"PAYMENTS")
                ->where ('case 
                            when  datediff(dischadate,phicvoucherdate) <= 30 THEN "1-30 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 60 THEN "31-60 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 90 THEN "61-90 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END = "'.$aging.'"');
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->med_db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                     ->or_like('phicmembr', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->med_db->order_by('postingdateclaim','ASC');
        }
    }
    
 
    function make_payment_discharge_patient_datatables($date,$aging){  
        $this->get_payment_discharge_phic_patients($date,$aging);  
        if($this->input->post("length") != -1)  
        {  
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->med_db->get();  
        return $query->result();  
    }
    
   
    function get_payment_discharge_patients_filtered_data($date,$aging){  
        $this->get_payment_discharge_phic_patients($date,$aging);  
        $query = $this->med_db->get();  
        return $query->num_rows();  
    }
    
    public function get_payment_discharge_patients_data($date,$aging)
    {
        $this->med_db->select('name,dischadate,phicmembr,postingdateclaim,datediff(dischadate,phicvoucherdate) as age, phicvoucherdate,caserateTotalActual,phicvoucherno')
                ->from(patientphic_vw)
                 ->where('YEAR(phicvoucherdate) >= YEAR("'.$date.'")')
                ->where('MONTH(phicvoucherdate) = MONTH("'.$date.'")')
                ->where('claimstatus',"PAYMENTS")
                ->where ('case 
                            when  datediff(dischadate,phicvoucherdate) <= 30 THEN "1-30 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 60 THEN "31-60 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 90 THEN "61-90 Days"
                            when  datediff(dischadate,phicvoucherdate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END = "'.$aging.'"');
        return $this->med_db->count_all_results();
    }  
    
    //
    
    /*
     * Gets all patients info for on process
     * 
     * @author Alingling
     * @param string 11-25-2017
     * 
     */
    

    public function get_onprocess_phic_patients($date,$aging)
    {
        $order_column = array("name","discharges",null,"phicmembr");
          $this->med_db->select('name,concat(dischadate," ",dischatime) as discharges ,phicmembr')
                  ->from(patientphic_vw)
                ->where('dischadate <=',$date)
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno','')
                ->where('claimstatus <> "PAYMENTS"')
                ->where ('case 
                            when  datediff("'.$date.'", dischadate) <= 15 THEN "1-15 Days"
                            when  datediff("'.$date.'", dischadate) <= 30 THEN "16-30 Days"
                            when  datediff("'.$date.'", dischadate) <= 45 THEN "31-45 Days"
                            when  datediff("'.$date.'", dischadate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "'.$aging.'"');
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->med_db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                     ->or_like('phicmembr', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->med_db->order_by('dischadate','ASC');
        }
    }
    
 
    function make_onprocess_phic_patient_datatables($date,$aging){  
        $this->get_onprocess_phic_patients($date,$aging);  
        if($this->input->post("length") != -1)  
        {  
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->med_db->get();  
        return $query->result();  
    }
    
   
    function get_onprocess_phic_patients_filtered_data($date,$aging){  
        $this->get_onprocess_phic_patients($date,$aging);  
        $query = $this->med_db->get();  
        return $query->num_rows();  
    }
    
    public function get_onprocess_phic_patients_data($date,$aging)
    {
        $this->med_db->select('name,concat(dischadate," ",dischatime) as discharges ,phicmembr')
                  ->from(patientphic_vw)
                ->where('dischadate <=',$date)
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno <> ""')
                ->where('claimstatus <> "PAYMENTS"')
                ->where ('case 
                            when  datediff("'.$date.'", dischadate) <= 15 THEN "1-15 Days"
                            when  datediff("'.$date.'", dischadate) <= 30 THEN "16-30 Days"
                            when  datediff("'.$date.'", dischadate) <= 45 THEN "31-45 Days"
                            when  datediff("'.$date.'", dischadate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "'.$aging.'"');
        return $this->med_db->count_all_results();
    }

    
    /*
     * Gets all patients for on process
     * 
     * @author Alingling
     * @param string 11-25-2017
     * 
     */
    

    public function get_onprocess_phic_patients_all()
    {
        $order_column = array("name","discharges",null,"phicmembr");
          $this->med_db->select('name,concat(dischadate," ",dischatime) as discharges ,phicmembr,phicHCItotal, datediff("'.$date.'", dischadate) as aging')
                  ->from(patientphic_vw)
                ->where('dischadate <=',$this->get_current_date())
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno','')
                ->where('claimstatus <> "PAYMENTS"');
               
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->med_db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                     ->or_like('phicmembr', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->med_db->order_by('dischadate','ASC');
        }
    }
    
 
    function make_onprocess_phic_patient_all_datatables(){  
        $this->get_onprocess_phic_patients_all();  
        if($this->input->post("length") != -1)  
        {  
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->med_db->get();  
        return $query->result();  
    }
    
   
    function get_onprocess_phic_patients_all_filtered_data(){  
        $this->get_onprocess_phic_patients_all();  
        $query = $this->med_db->get();  
        return $query->num_rows();  
    }
    
    public function get_onprocess_phic_patients_all_data()
    {
        $this->med_db->select('name,concat(dischadate," ",dischatime) as discharges ,phicmembr,phicHCItotal, datediff("'.$date.'", dischadate) as aging')
                  ->from(patientphic_vw)
                ->where('dischadate <=',$this->get_current_date())
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno','')
                ->where('claimstatus <> "PAYMENTS"');
        return $this->med_db->count_all_results();
    }
/*
     * Gets all patients info for transmittal
     * 
     * @author Alingling
     * @param string 11-27-2017
     * 
     */
    

    public function get_transmitted_phic_patients($date,$aging)
    {
         
        
        $order_column = array("name","dischadate","postingdateclaim","age","phicmembr");
          $this->med_db->select('name,dischadate,phicmembr,postingdateclaim,datediff(postingdateclaim,dischadate) as age')
                ->from(patientphic_vw)
                 ->where('YEAR(dischadate) <= YEAR("'.$date.'")')
                ->where('MONTH(dischadate) <= MONTH("'.$date.'")')
                ->where('YEAR(postingdateclaim) <= YEAR("'.$date.'")')
                ->where('MONTH(postingdateclaim) >= MONTH("'.$date.'")')
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno <> ""')
                ->where ('case 
                             when  datediff(postingdateclaim,dischadate) <= 15 THEN "1-15 Days"
                            when  datediff(postingdateclaim,dischadate) <= 30 THEN "16-30 Days"
                            when  datediff(postingdateclaim,dischadate) <= 45 THEN "31-45 Days"
                            when  datediff(postingdateclaim,dischadate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "'.$aging.'"');
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->med_db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                     ->or_like('phicmembr', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->med_db->order_by('postingdateclaim','ASC');
        }
    }
    
 
    function make_transmitted_phic_patient_datatables($date,$aging){  
        $this->get_transmitted_phic_patients($date,$aging);  
        if($this->input->post("length") != -1)  
        {  
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->med_db->get();  
        return $query->result();  
    }
    
   
    function get_transmitted_phic_patients_filtered_data($date,$aging){  
        $this->get_transmitted_phic_patients($date,$aging);  
        $query = $this->med_db->get();  
        return $query->num_rows();  
    }
    
    public function get_transmitted_phic_patients_data($date,$aging)
    {
        $this->med_db->select('name,dischadate,phicmembr,postingdateclaim,
                        case 
                            when  datediff(postingdateclaim,dischadate) as age')
                ->from(patientphic_vw)
                 ->where('YEAR(dischadate) <= YEAR("'.$date.'")')
                ->where('MONTH(dischadate) <= MONTH("'.$date.'")')
                ->where('YEAR(postingdateclaim) <= YEAR("'.$date.'")')
                ->where('MONTH(postingdateclaim) >= MONTH("'.$date.'")')
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno <> ""')
                ->where ('case 
                            when  datediff(postingdateclaim,dischadate) <= 15 THEN "1-15 Days"
                            when  datediff(postingdateclaim,dischadate) <= 30 THEN "16-30 Days"
                            when  datediff(postingdateclaim,dischadate) <= 45 THEN "31-45 Days"
                            when  datediff(postingdateclaim,dischadate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "'.$aging.'"');
        return $this->med_db->count_all_results();
    }  
  
    
    
    /**
     * Get Admitted Patients of the Day Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_admitted_day_patients()
    {
      
        $order_column = array("name","admission","pat_classification","Age","bday","roombrief","doctorname","phicmembr","admittedby");
         $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where("admitdate", $this->get_current_datex())
                
                ->where('pxtype','IPD');
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('pat_classification', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('admission','ASC');
        }
    }
    
 
    function make_admitted_day_patient_datatables(){  
        $this->get_admitted_day_patients();  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
   
    function get_admitted_day_patient_filtered_data(){  
        $this->get_admitted_day_patients();  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    public function get_admitted_day_patient_data()
    {
       $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where("admitdate ", $this->get_current_datex())
                ->where('pxtype','IPD');
        return $this->db->count_all_results();
    }  
    
    
    /**
     * Get Admitted Patients of the Day Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_total_admitted_day_patients()
    {
      
        $order_column = array("name","admission","pat_classification","Age","bday","roombrief","doctorname","phicmembr","admittedby");
         $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
               
                ->where('discharged','0')
                ->where('pxtype','IPD')
          ->where ("admitdate <=", $this->get_current_datex());
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('pat_classification', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('admission','ASC');
        }
    }
    
 
    function make_total_admitted_day_patient_datatables(){  
        $this->get_total_admitted_day_patients();  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
   
    function get_total_admitted_day_patient_filtered_data(){  
        $this->get_total_admitted_day_patients();  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    public function get_total_admitted_day_patient_data()
    {
       $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
               ->where('discharged','0')
                ->where('pxtype','IPD')
               ->where ("admitdate <=", $this->get_current_datex());
        return $this->db->count_all_results();
    }  
    
    
    /**
     * Get Discharge Patients of the Day Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_discharged_day_patients()
    {
       
        $order_column = array("name", "discharged","admission","pat_classification","Age","roombrief","doctorname","phicmembr");
         $this->db->select("name, concat(dischadate,' ',dischatime) as discharged,concat(admitdate,' ',admittime) as admission,pat_classification,Age,roombrief,doctorname,phicmembr")
                ->from(inpatient_tbl)
                ->where("dischadate", $this->get_current_datex())
                ->where("discharged",1)
                ->where('pxtype','IPD');
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('discharged', $this->input->post("search")["value"])
                    ->or_like('pat_classification', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('discharged','ASC');
        }
    }
    
 
    function make_discharged_day_patient_datatables(){  
        $this->get_discharged_day_patients();  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
   
    function get_discharged_day_patient_filtered_data(){  
        $this->get_discharged_day_patients();  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    public function get_discharged_day_patient_data()
    { 
        $this->db->select("name, concat(dischadate,' ',dischatime) as discharged,concat(admitdate,' ',admittime) as admission,pat_classification,Age,roombrief,doctorname,phicmembr")
                ->from(inpatient_tbl)
                ->where("dischadate", $this->get_current_datex())
                ->where("discharged",1)
                ->where('pxtype','IPD');
        return $this->db->count_all_results();
    }  
    
    /**
     * Get PHIC Patients of the Day Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_admitted__phic_day_patients()
    {
      
        $order_column = array("name","admission","pat_classification","Age","bday","roombrief","doctorname","phicmembr","admittedby");
         $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' @ ',updated) as admittedby")
                ->from(inpatient_tbl)
                 ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype','IPD')
                ->where("discharged",0)
                 ->where("phicmembr <> 'Non-NHIP'");
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('pat_classification', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('admission','ASC');
        }
    }
    
 
    function make_admitted__phic_day_patient_datatables(){  
        $this->get_admitted__phic_day_patients();  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
   
    function get_admitted__phic_day_patient_filtered_data(){  
        $this->get_admitted__phic_day_patients();  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    public function get_admitted_phic_day_patient_data()
    {
       $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' @ ',updated) as admittedby")
                ->from(inpatient_tbl)
                 ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype','IPD')
                ->where("discharged",0)
                 ->where("phicmembr <> 'Non-NHIP'");
        return $this->db->count_all_results();
    }  
    
    /**
     * Get Non-PHIC Patients of the Day Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_admitted_non_phic_day_patients()
    {
      
        $order_column = array("name","admission","pat_classification","Age","bday","roombrief","doctorname","phicmembr","admittedby");
         $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' @ ',updated) as admittedby")
                ->from(inpatient_tbl)
                 ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype','IPD')
                ->where("discharged",0)
                 ->where("phicmembr = 'Non-NHIP'");
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('pat_classification', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('admission','ASC');
        }
    }
    
 
    function make_admitted_non_phic_day_patient_datatables(){  
        $this->get_admitted_non_phic_day_patients();  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
   
    function get_admitted_non_phic_day_patient_filtered_data(){  
        $this->get_admitted_non_phic_day_patients();  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    public function get_admitted_non_phic_day_patient_data()
    {
       $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' @ ',updated) as admittedby")
                ->from(inpatient_tbl)
                 ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype','IPD')
                ->where("discharged",0)
                 ->where("phicmembr = 'Non-NHIP'");
        return $this->db->count_all_results();
    }  
    
    /**
     * Gets all on process philhealth account.
     * 
     * @author pauldigz@gmail.com
     * @param string $date(Y-m-d)
     */
    
    public function get_op_phic_accnt_px($date)
    {
        $order_column = array("aging","total","totalamount");
        $this->med_db->select('case 
                                when  DATE("'.$date.'") - DATE(dischadate) <= 15 THEN "1-15 Days"
                                when  DATE("'.$date.'") - DATE(dischadate) <= 30 THEN "16-30 Days"
                                when  DATE("'.$date.'") - DATE(dischadate) <= 45 THEN "31-45 Days"
                                when  DATE("'.$date.'") - DATE(dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(phicHCItotal) as totalamount')
                ->from(patientphic_vw)
                ->where('dischadate',$date)
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno','')
                ->group_by('aging');
                
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->med_db->group_start()
                    ->like('aging', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->med_db->order_by('aging','ASC');
        }
    }
    
    /**
     * Make on process philhealth account datatable. 
     * 
     * @author pauldigz@gmail.com
     * @param datetime $date (Y-m-d)
     * @return array
     */
    function make_op_phic_accnt_px_datatables($date){  
        $this->get_op_phic_accnt($date);  
        if($this->input->post("length") != -1)  
        {  
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->med_db->get();  
        return $query->result();  
    }
    
    /**
     * Return the number of rows when a user search a data in jquery datatable.
     * 
     * @author pauldigz@gmail.com 
     * @param date $date (Y-m-d)
     * @return int
     */
    function get_op_phic_accnt_px_filtered_data($date){  
        $this->get_op_phic_accnt($date);  
        $query = $this->med_db->get();  
        return $query->num_rows();  
    }
    
    public function get_op_phic_px_accnt_data($date)
    {
        $this->med_db->select('case 
                                when  DATE('.$date.') - DATE(dischadate) <= 15 THEN "1-15 Days"
                                when  DATE('.$date.') - DATE(dischadate) <= 30 THEN "16-30 Days"
                                when  DATE('.$date.') - DATE(dischadate) <= 45 THEN "31-45 Days"
                                when  DATE('.$date.') - DATE(dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(phicHCItotal) as totalamount')
                ->from(patientphic_vw)
                ->where('dischadate',$date)
                ->group_by('aging');
        return $this->med_db->count_all_results();
    }
    
    public function get_phic_op_census($date)
    {
        $this->med_db->select('case 
                                when  datediff("'.$date.'", dischadate) <= 15 THEN "1-15 Days"
                                when  datediff("'.$date.'", dischadate) <= 30 THEN "16-30 Days"
                                when  datediff("'.$date.'", dischadate) <= 45 THEN "31-45 Days"
                                when  datediff("'.$date.'", dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(phicHCItotal) as totalamount')
                ->from(patientphic_vw)
                ->where('dischadate <=',$date)
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno','')
                ->group_by('aging');
        
        $query = $this->med_db->get();
        return $query->result_array(); 
    }
    
    public function get_phic_phic_payments_census($date)
    {
        $this->med_db->select('sum(TOTALPHICPAID) as totalpayments')
                ->from(phicmasterlist_tbl)
                ->where('claimstatus','PAYMENTS')
                ->where('YEAR(CHEQUEDATE) = YEAR("'.$date.'")')
                ->where('MONTH(CHEQUEDATE) = MONTH("'.$date.'")');
        
        $query = $this->med_db->get();
        return $query->row_array();
    }
    
    public function modify_account()
    {
        $data = array(
            'EmpID' => $this->security->xss_clean($this->input->post("username")),
            'EmpPass' => $this->encrypt_pass($this->security->xss_clean($this->input->post("pass"))),
            'updated' => $this->get_current_date()
        );
        
        $this->hub_db->where('ID',  $this->security->xss_clean($this->session->userdata('userid')));
        return $this->hub_db->update(usersrights_tbl, $data);
    }
    
    public function check_uname($uname)
    {
        $id = $this->security->xss_clean($this->session->userdata('userid'));
        
        $this->hub_db->select('EmpID')
                ->from(usersrights_tbl)
                ->where('EmpID',$uname)
                ->where('ID <>',$id);
        
        $query = $this->hub_db->get();
        return $query->num_rows() ? $query->row_array() : FALSE;
    }
    
    public function check_oldpass($oldpass)
    {
        $id = $this->security->xss_clean($this->session->userdata('userid'));
        
        $this->hub_db->select('EmpID')
                ->from(usersrights_tbl)
                ->where('ID',$id)
                ->where('EmpPass', $this->encrypt_pass($oldpass));
        
        $query = $this->hub_db->get();
        return $query->num_rows() ? $query->row_array() : FALSE;
    }
    
    public function get_today_add()
    {
        $this->db->select("*")
                ->from(inpatient_tbl)
                ->where("admitdate", $this->get_current_datex())
                ->where('pxtype','IPD');
        
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function get_today_disc()
    {
        $this->db->select("*")
                ->from(inpatient_tbl)
                ->where("dischadate", $this->get_current_datex())
                ->where("discharged",1)
                ->where('pxtype','IPD');
        
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get all assets
     * 
     * @author Alingling
     * @param 12-1-2017
     */
    
    public function get_all_assets()
    {
        $order_column = array("ControlNumber","Category","AssetType","Department","Manufacturer","Suppliers","Quantity","DatePurchase","assetstatus");
        $this->esched_db->select('*')
                ->from(inventorytable_vw);
                
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->esched_db->group_start()
                -> like("ControlNumber", $this->input->post("search")["value"])
                ->or_like("Category", $this->input->post("search")["value"])
                ->or_like("AssetType", $this->input->post("search")["value"])
                ->or_like("Manufacturer", $this->input->post("search")["value"])
                ->or_like("Suppliers", $this->input->post("search")["value"])
                ->or_like("Quantity", $this->input->post("search")["value"])
                ->or_like("assetstatus", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->esched_db->order_by("AssetType","ASC");
        }
    }
    
  
    function make_all_assets_datatables(){  
        $this->get_all_assets();  
        if($this->input->post("length") != -1)  
        {  
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->esched_db->get();  
        return $query->result();  
    }
    
   
    
    function get_all_assets_filtered_data(){  
        $this->get_all_assets();  
        $query = $this->esched_db->get();  
        return $query->num_rows();  
    }
    
    public function get_all_assets_data()
    { 
        $this->esched_db->select("*")
                ->from(inventorytable_vw);
        return $this->esched_db->count_all_results();
    }
    
    /**
     * Get all assets info, i.e. service date
     * 
     * @author Alingling
     * @param 12-1-2017
     */
    
    public function get_all_assets_info($cnumber)
    {
        $order_column = array("Controlnumber","ServiceDate","Complaints","Assetstatus","Findings");
        $this->esched_db->select('*')
                ->from(servicing_tbl)
                ->where('Controlnumber',$cnumber);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->esched_db->group_start()
                -> like("Controlnumber", $this->input->post("search")["value"])
                ->or_like("ServiceDate", $this->input->post("search")["value"])
                ->or_like("Complaints", $this->input->post("search")["value"])
                ->or_like("Assetstatus", $this->input->post("search")["value"])
                ->or_like("Findings", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->esched_db->order_by("ServiceDate","ASC");
        }
    }
    
  
    function make_all_assets_info_datatables($cnumber){  
        $this->get_all_assets_info($cnumber);  
        if($this->input->post("length") != -1)  
        {  
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->esched_db->get();  
        return $query->result();  
    }
    
   
    
    function get_all_assets_info_filtered_data($cnumber){  
        $this->get_all_assets_info($cnumber);  
        $query = $this->esched_db->get();  
        return $query->num_rows();  
    }
    
    public function get_all_assets_info_data($cnumber)
    { 
       $this->esched_db->select('*')
                ->from(servicing_tbl)
                ->where('Controlnumber',$cnumber);
                
        return $this->esched_db->count_all_results();
    }
    
    /**
     * Get Room Occupancy Rate
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    
  
    
    public function get_room_occupancy_ward_data($date)
    { 
        $this->db->select("count(*) as totalbed, (select WardRoom from profile) as Beds, (count(*)/ (select WardRoom from profile) * 100)  as percentage")
            ->from(inpatient_tbl)
//            ->where('dischadate >=', $date)    
             ->where('((admitdate <= "'.$date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$date.'" AND admitdate <= "'.$date.'"))')
            ->where('pxtype','IPD')
            ->where('roomtype',"WARD");
        $query = $this->db->get();  
        return $query->result_array();
    } 
    
    public function get_room_occupancy_private_data($date)
    { 
        $this->db->select("count(*) as totalbed,(select PrivateRoom from profile) as Beds, (count(*)/ (select PrivateRoom from profile) * 100)  as percentage")
            ->from(inpatient_tbl)
//            ->where('dischadate >=', $date)    
           ->where('((admitdate <= "'.$date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$date.'" AND admitdate <= "'.$date.'"))')
                    ->where('pxtype','IPD')
        ->where('roomtype',"PRIVATE");
        $query = $this->db->get();  
        return $query->result_array();
    } 
    
    public function get_room_occupancy_suite_data($date)
    { 
        $this->db->select("count(*) as totalbed,(select SuiteRoom from profile) as Beds, (count(*)/ (select SuiteRoom from profile) * 100)  as percentage")
            ->from(inpatient_tbl)
//            ->where('dischadate >=', $date)    
           ->where('((admitdate <= "'.$date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$date.'" AND admitdate <= "'.$date.'"))')
                    ->where('pxtype','IPD')
            ->where('roomtype',"SUITEROOM");
        $query = $this->db->get();  
        return $query->result_array();
    } 
    
   public function get_room_occupancy_ward_day()
    { 
        $this->db->select("count(*) as totalbed, (select WardRoom from profile) as Beds, (count(*)/ (select WardRoom from profile) * 100)  as percentage")
            ->from(inpatient_tbl)
   //         ->where('dischadate >=', $this->get_current_datex())    
            ->where('admitdate <=', $this->get_current_datex())
                    ->where('pxtype','IPD')
            ->where("discharged",0)
            ->where('roomtype',"WARD");
        $query = $this->db->get();  
        return $query->result_array();
    } 
    
    public function get_room_occupancy_private_day()
    { 
        $this->db->select("count(*) as totalbed,(select PrivateRoom from profile) as Beds, (count(*)/ (select PrivateRoom from profile) * 100)  as percentage")
            ->from(inpatient_tbl)
     //       ->where('dischadate >=', $this->get_current_datex())    
            ->where('admitdate <=', $this->get_current_datex())
                    ->where('pxtype','IPD')
            ->where("discharged",0)
        ->where('roomtype',"PRIVATE");
        $query = $this->db->get();  
        return $query->result_array();
    } 
    
    public function get_room_occupancy_suite_day()
    { 
        $this->db->select("count(*) as totalbed,(select SuiteRoom from profile) as Beds, (count(*)/ (select SuiteRoom from profile) * 100)  as percentage")
            ->from(inpatient_tbl)
       //     ->where('dischadate >=', $this->get_current_datex())    
            ->where('admitdate <=', $this->get_current_datex())
                    ->where('pxtype','IPD')
            ->where("discharged",0)
            ->where('roomtype',"SUITEROOM");
        $query = $this->db->get();  
        return $query->result_array();
    } 
    
    public function get_daily_census()
    {
        $data = array();
        $dates = array();
        
        $start_date = date('Y-m-d', strtotime('today - 29 days'));
        $end_date = new DateTime();
        $end_date->format("Y-m-d");
        
        $period = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1D'),
            $end_date
       );
        
        
        foreach( $period as $date) 
        { 
            $dates[] = $date->format('Y-m-d'); 
        }
        
        for ($i = 0; $i < count($dates); $i++) {
            $this->db->select('"'.$dates[$i].'" as datex,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(inpatient_tbl)
                ->where('((admitdate <= "'.$dates[$i].'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$dates[$i].'" AND admitdate <= "'.$dates[$i].'")) and pxtype = "IPD"');
            
            $query = $this->db->get();
            
            array_push($data, $query->row_array());
        }
        
        return $data;
    }
    
    public function get_monthly_census()
    {
        // $dateTime = new DateTime();
        // $data = array();

        $data = array();
        $dates = array();
        
        $start_date = date('Y-m-d', strtotime('today - 5 months'));
        $end_date = new DateTime();
        $end_date->format("Y-m-d");
        
        $period = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1M'),
            $end_date
       );
        
        
        foreach( $period as $date) 
        { 
            $dates[] = $date->format('Y-m-d'); 
        }
     
        
for ($i = 0; $i < count($dates); $i++) {
       $datexx = $this->get_yearmonths($dates[$i]);
            $this->db->select('"'.$datexx.'" as datex,count(*) as totalpx')
                ->from(inpatient_tbl)
                ->where('(MONTH(dischadate) = MONTH("'.$dates[$i].'") and YEAR(dischadate) = YEAR("'.$dates[$i].'")) and discharged = 1 and pxtype="IPD"');
            
            $query = $this->db->get();
            
            array_push($data, $query->row_array());
        }
        
        return $data;
    }
    
    
    
     public function get_all_log()
    {
        $order_column = array("logername","action","logdate","devicetype","deviceos","browser");
        $this->db->select('*')->from(weblog_tbl);
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like("logername", $this->input->post("search")["value"])
                    ->or_like("action", $this->input->post("search")["value"])
                    ->or_like("logdate", $this->input->post("search")["value"])
                    ->or_like("devicetype", $this->input->post("search")["value"])
                    ->or_like("deviceos", $this->input->post("search")["value"])
                    ->or_like("browser", $this->input->post("search")["value"])
            ->group_end();
        }  
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('logdate', 'DESC');  
        }
    }
    
    /**
     * 
     * make all patient table
     */
    function make_all_log_datatables(){  
        $this->get_all_log();  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
    /**
     * search for all patient table
     */
    
    function get_all_log_filtered_data(){  
        $this->get_all_log();  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_all_log_data()
    {
       $this->db->select('*')->from(weblog_tbl);
        
        return $this->db->count_all_results();
    }
    
    
  
    
    public function get_each_day_census($date)
    {
        $order_column = array("name","admitdate","dischadate","pat_classification","age","bday","roombrief","doctorname","phicmembr");
        $this->db->select('name,admitdate,dischadate,pat_classification,age,bday,roombrief,doctorname,phicmembr')
                ->from(inpatient_tbl)
                ->where('((admitdate <= "'.$date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$date.'" AND admitdate <= "'.$date.'")) and pxtype = "IPD"');
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like("name", $this->input->post("search")["value"])
                    ->or_like("admitdate", $this->input->post("search")["value"])
                    ->or_like("dischadate", $this->input->post("search")["value"])
                    ->or_like("pat_classification", $this->input->post("search")["value"])
                    ->or_like("age", $this->input->post("search")["value"])
                    ->or_like("bday", $this->input->post("search")["value"])
                    ->or_like("roombrief", $this->input->post("search")["value"])
                    ->or_like("doctorname", $this->input->post("search")["value"])
                    ->or_like("phicmembr", $this->input->post("search")["value"])
            ->group_end();
        }  
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('name', 'ASC');  
        }
    }
    
    /**
     * 
     * make all patient table
     */
    function make_each_day_census_datatables($date){  
        $this->get_each_day_census($date);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
    /**
     * search for all patient table
     */
    
    function get_each_day_census_filtered_data($date){  
        $this->get_each_day_census($date);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_each_day_census_data($date)
    {
       $this->db->select('name,admitdate,dischadate,pat_classification,age,bday,roombrief,doctorname,phicmembr')
                ->from(inpatient_tbl)
                ->where('((admitdate <= "'.$date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$date.'" AND admitdate <= "'.$date.'")) and pxtype = "IPD"');
        
        return $this->db->count_all_results();
    }
    
    
    public function get_daily_transaction($dating)
    {
        $data = array();
        $dates = array();
        
        $start_date = date('Y-m-d', strtotime("-29 days", strtotime($dating)));
        //echo $start_date;
        $end_date = new DateTime($dating);
        $end_date->format("Y-m-d");
        
        $period = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1D'),
            $end_date
       );
        
        
        foreach( $period as $date) 
        { 
            $dates[] = $date->format('Y-m-d'); 
        }
        $dates[] = $dating;
 
        for ($i = 0; $i < count($dates); $i++) {
             $this->db->select('"'.$dates[$i].'" as datex,drugs,medsply,pharmisc,lab,rad,hosp,'
                    . 'ipdpay,hmoacct,pcsoacct,phicacct,opdlab,opdrad,opdhosp,pnacct,deliveryphar,deliverylab,deliveryrad,deliveryhosp, '
                     . '(drugs+medsply+pharmisc) pharmacy,'
                     . '(drugs+medsply+pharmisc+lab+rad+hosp) total')
                ->from(dailytransaction_tbl)
                ->where('transdate',$dates[$i]);
            $query = $this->db->get();
            
            array_push($data, $query->row_array());
        }
        
        return $data;
    
    }
    
    public function get_monthly_transaction($monthdate,$month)
    {
        $data = array();
        $dates = array();
        switch($month)
    {
        case "12":
            $start_date = date('Y-m-d', strtotime("-11 months", strtotime($monthdate)));
            break;
        case "9":
             $start_date = date('Y-m-d', strtotime("-8 months", strtotime($monthdate)));
           
            break;
        case "6":
          $start_date = date('Y-m-d', strtotime("-5 months", strtotime($monthdate)));
          
            break;
        case "3":
           $start_date = date('Y-m-d', strtotime("-2 months", strtotime($monthdate)));
          
            break;
        default:
             $start_date = date('Y-m-d', strtotime("-11 months", strtotime($monthdate)));
            break;
    }
         
    
        $end_date = new DateTime($monthdate );
        $end_date->format("Y-m-d");
        
        $period = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1M'),
            $end_date
       );
        
        
        foreach( $period as $date) 
        { 
            $dates[] = $date->format('Y-m-d'); 
        }
        $dates[] = $monthdate;
       $d = count($dates);
         for ($i = 0; $i < count($dates); $i++) {
             $datexx = $this->get_yearmonths($dates[$i]);
             $this->db->select('"'.$datexx.'" as datex,'
                    . 'sum(drugs) drugin,'
                    . 'sum(medsply) medsplyin,'
                    . 'sum(pharmisc) pharmiscin,'
                    . 'sum(lab) labin,'
                    . 'sum(rad) radin,'
                    . 'sum(hosp) hospin,'
                    . 'sum(ipdpay) ipdayin,'
                    . 'sum(hmoacct) hmoacctin,'
                    . 'sum(pcsoacct) pcsoacctin,'
                    . 'sum(phicacct) phicacctin,'
                    . 'sum(opdlab) opdlabin,'
                    . 'sum(opdrad) opdradin,'
                    . 'sum(opdhosp) opdhospin,'
                    . 'sum(pnacct) pnacctin,'
                    . 'sum(deliveryphar) deliverypharin,'
                    . 'sum(deliverylab) deliverylabin,'
                    . 'sum(deliveryrad) deliveryradin,'
                    . 'sum(deliveryhosp) deliveryhospin, '
                    .'(sum(drugs)+sum(medsply)+sum(pharmisc)) pharmacy,'
                   
                    . '(sum(drugs)+sum(medsply)+sum(pharmisc)+sum(lab)+sum(rad)+sum(hosp)) total')
                ->from(dailytransaction_tbl)
                ->where('YEAR(transdate) = YEAR("'.$dates[$i].'")')
                ->where('MONTH(transdate) = MONTH("'.$dates[$i].'")');
               
            $query = $this->db->get();
            
            array_push($data, $query->row_array());
        }
        
        return $data;
    }
    
    
    /* Fix Asset-> Job Order Approval
     * @author Alingling
     */
    public function get_jobapproval_ticket($dept=NULL)
    {
         $order_column = array("requestid","requestdate","AssetType","Department","Complaints","details");
        if($dept === "All")
        {
            $this->esched_db->select('*')
                    ->from(servicereq_vw)
                    ->where('approved','0');
        }
        else if ($dept <> "")
        {
             $this->esched_db->select('*')
                ->from(servicereq_vw)
                ->where('approved','0')
                ->where('Department',$dept);
        }
        else 
        {
             $this->esched_db->select('*')
                    ->from(servicereq_vw)
                    ->where('approved','0');
        }
       
           
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->esched_db->group_start()
                -> like("AssetType", $this->input->post("search")["value"])
                ->or_like("Department", $this->input->post("search")["value"])
                ->or_like("Complaints", $this->input->post("search")["value"])
                ->or_like("details", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->esched_db->order_by("requestdate","DESC");
        }
    }
   
    function make_jobapproval_ticket_datatables($dept){  
        $this->get_jobapproval_ticket($dept);  
        if($this->input->post("length") != -1)  
        {  
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->esched_db->get();  
        return $query->result();  
    }

    
    function get_jobapproval_ticket_filtered_data($dept){  
        $this->get_jobapproval_ticket($dept);  
        $query = $this->esched_db->get();  
        return $query->num_rows();  
    }
  
    
    public function get_jobapproval_ticket_data($dept)
    {
       if($dept === "All")
        {
            $this->esched_db->select('*')
                    ->from(servicereq_vw)
                    ->where('approved','0');
        }
        else if ($dept <> "")
        {
             $this->esched_db->select('*')
                ->from(servicereq_vw)
                ->where('approved','0')
                ->where('Department',$dept);
        }
        else 
        {
             $this->esched_db->select('*')
                    ->from(servicereq_vw)
                    ->where('approved','0');
        }
        return $this->esched_db->count_all_results();
    }
    
    public function get_transmit()
    {
        $data = array();
        $dates = array();
        
        $start_date = date('Y-m-d', strtotime('today - 5 months'));
        $end_date = new DateTime();
        $end_date->format("Y-m-d");
        
        $period = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1M'),
            $end_date
       );
        
        
        foreach( $period as $date) 
        { 
            $dates[] = $date->format('Y-m-d'); 
        }
       $d = count($dates);
        for ($i = $d-1; $i >= 0; $i--) {
            $datexx = $this->get_yearmonths($dates[$i]);
            $this->med_db->select('"'.$datexx.'" as datex,count(dischadate) as discharges,count(case when phicmembr <> "non-nhip" then 1 else 0 end) phicmemb,count(postingdateclaim) as transmitted, sum(caseratetotalActual) as totalamount')
            
                ->from(patientphic_vw)
                ->where('YEAR(dischadate) = YEAR("'.$dates[$i].'")')
                ->where('MONTH(dischadate) = MONTH("'.$dates[$i].'")')
                ->where('YEAR(postingdateclaim) = YEAR("'.$dates[$i].'")')
                ->where('MONTH(postingdateclaim) = MONTH("'.$dates[$i].'")')
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno <> ""');
            $query = $this->med_db->get();
            
            array_push($data, $query->row_array());
        }
        
        return $data;
    }
    
    public function get_monthly_transmittal($datexx)
    {
        $order_column = array("name","caserateTotalActual","dischadate","postingdateclaim","age","phicmembr");
        $this->med_db->select('name,caserateTotalActual,dischadate,phicmembr,postingdateclaim,datediff(postingdateclaim,dischadate) as age')
                ->from(patientphic_vw)
               ->where('YEAR(dischadate) = YEAR("'.$datexx.'")')
                ->where('MONTH(dischadate) = MONTH("'.$datexx.'")')
                ->where('YEAR(postingdateclaim) = YEAR("'.$datexx.'")')
                ->where('MONTH(postingdateclaim) = MONTH("'.$datexx.'")')
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno <> ""');
           
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->med_db->group_start()
                -> like("name", $this->input->post("search")["value"])
                ->or_like("age", $this->input->post("search")["value"])
                ->or_like("phicmembr", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->med_db->order_by("postingdateclaim","DESC");
        }
    }
   
    function make_monthly_transmittal_datatables($datexx){  
        $this->get_monthly_transmittal($datexx);  
        if($this->input->post("length") != -1)  
        {  
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->med_db->get();  
        return $query->result();  
    }

    
    function get_monthly_transmittal_filtered_data($datexx){  
        $this->get_monthly_transmittal($datexx);  
        $query = $this->med_db->get();  
        return $query->num_rows();  
    }
  
    
    public function get_monthly_transmittal_data($datexx)
    {
      $this->med_db->select('name,caserateTotalActual,dischadate,phicmembr,postingdateclaim,datediff(postingdateclaim,dischadate) as age')
                ->from(patientphic_vw)
                 ->where('YEAR(dischadate) = YEAR("'.$datexx.'")')
                ->where('MONTH(dischadate) = MONTH("'.$datexx.'")')
                ->where('YEAR(postingdateclaim) = YEAR("'.$datexx.'")')
                ->where('MONTH(postingdateclaim) = MONTH("'.$datexx.'")')
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno <> ""');
        return $this->med_db->count_all_results();
    }
     
     public function philhealth_now_report()
    {
        
     $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' @ ',updated) as admittedby")
                ->from(inpatient_tbl)
                 ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype','IPD')
                ->where("discharged",0)
                 ->where("phicmembr <> 'Non-NHIP'")
                 ->order_by("name","ASC");
     
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
     public function nonphilhealth_now_report()
    {
        
     $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' @ ',updated) as admittedby")
                ->from(inpatient_tbl)
                 ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype','IPD')
                ->where("discharged",0)
                 ->where('phicmembr','Non-NHIP')
                 ->order_by("name","ASC");
     
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
    public function total_patients_report()
    {
        
     $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
               ->where('discharged','0')
                ->where('pxtype','IPD')
               ->where ("admitdate <=", $this->get_current_datex())
               ->order_by("name","ASC");
     
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
    public function admitted_patients_report()
    {
        
     $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where("admitdate ", $this->get_current_datex())
                ->where('pxtype','IPD');
     
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
    public function discharged_patients_report()
    {
        
     $this->db->select("name, concat(dischadate,' ',dischatime) as discharged,concat(admitdate,' ',admittime) as admission,pat_classification,Age,roombrief,doctorname,phicmembr")
                ->from(inpatient_tbl)
                ->where("dischadate", $this->get_current_datex())
                ->where("discharged",1)
                ->where('pxtype','IPD');
     
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
    public function eachd_patients_report($date)
    {
        
     $this->db->select('name,admitdate,dischadate,pat_classification,age,bday,roombrief,doctorname,phicmembr')
                ->from(inpatient_tbl)
                ->where('((admitdate <= "'.$date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$date.'" AND admitdate <= "'.$date.'")) and pxtype = "IPD"')
                ->order_by("name","ASC");
     
        $query = $this->db->get();  
        return $query->result_array(); 
    }
    
   public function get_asset_report()
   {
            $this->esched_db->select("*")
                ->from(inventorytable_vw);
       
        $query = $this->esched_db->get();  
        return $query->result_array(); 
   }
    
   public function assets_info_report($cnumber)
   {
         $this->esched_db->select('*')
                ->from(servicing_tbl)
                ->where('Controlnumber',$cnumber);
         
         $query = $this->esched_db->get();  
        return $query->result_array(); 
   }
    
   public function getDept()
   {
       $this->esched_db->select('distinct(Department)')
                ->from(servicereq_vw);
         
         $query = $this->esched_db->get();  
        return $query->result_array(); 
   }
    
   
   // check for job orders
   
   public function check_joborders($ctrls)
    {
        
            $this->esched_db->select('*')
                ->from(servicereq_vw)
               
                ->where('approved','1')
                
                ->where('requestid',$this->security->xss_clean($ctrls));
                $query = $this->esched_db->get();
                return $query->row_array();
        
    }
    
    public function approve_joborders($ctrls)
    {
        $data = array(
            'approved'      => $this->security->xss_clean("1"),
            'updatedby'      => $this->session->userdata('empname'),
            'updated'  => $this->get_current_date(),
            );
        
        for ($i = 0; $i < count($ctrls); $i++) {
            $this->esched_db->where('requestid',  $this->security->xss_clean($ctrls[$i]));
            if ($this->esched_db->update(servicereq_vw, $data)) {
                $approved = TRUE;
               
            }
        }
        return $approved;
    }
    public function disapprove_joborders($ctrl)
    {
        $data = array(
            'approved'          => $this->security->xss_clean("2"),
            'updatedby'         => $this->session->userdata('empname'),
            'updated'           => $this->get_current_date(),
            'note'              =>$this->security->xss_clean($this->input->post('b')),
            );
        for ($i = 0; $i < count($ctrl); $i++) {
            $this->esched_db->where('requestid',  $this->security->xss_clean($ctrl[$i]));
            if ($this->esched_db->update(servicereq_vw, $data)) {
                $approved = TRUE;
               
            }
        }
        return $approved;
    }
    
    public function defer_joborders($ctrl)
    {
        $data = array(
            'approved'          => $this->security->xss_clean("3"),
            'updatedby'         => $this->session->userdata('empname'),
            'updated'           => $this->get_current_date(),
            'note'              =>$this->security->xss_clean($this->input->post('b')),
            );
        for ($i = 0; $i < count($ctrl); $i++) {
            $this->esched_db->where('requestid',  $this->security->xss_clean($ctrl[$i]));
            if ($this->esched_db->update(servicereq_vw, $data)) {
                $approved = TRUE;
               
            }
        }
        return $approved;
    }
    
    
    /* Disapproved Job Orders
     * 
     * @author Alingling
     */
       public function get_disapproved_joborder()
    {
         $order_column = array("requestid","requestdate","AssetType","Department","Complaints","details");
     
            $this->esched_db->select('*')
                    ->from(servicereq_vw)
                    ->where('approved','2');
            if(!empty($this->input->post("search")["value"]))  
                {  
                    $this->esched_db->group_start()
                        -> like("AssetType", $this->input->post("search")["value"])
                        ->or_like("Department", $this->input->post("search")["value"])
                        ->or_like("Complaints", $this->input->post("search")["value"])
                        ->or_like("details", $this->input->post("search")["value"])
                        ->group_end();
                }  
        
            if(!empty($this->input->post("order")))  
            {  
                $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
            }  
            else  
            {  
                $this->esched_db->order_by("requestdate","DESC");
            }
    }
   
    function make_disapproved_joborders_datatables(){  
        $this->get_disapproved_joborder();  
        if($this->input->post("length") != -1)  
        {  
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->esched_db->get();  
        return $query->result();  
    }

    
    function get_disapproved_joborders_filtered_data(){  
        $this->get_disapproved_joborder();  
        $query = $this->esched_db->get();  
        return $query->num_rows();  
    }
  
    
    public function get_disapproved_joborders_data()
    {
      
            $this->esched_db->select('*')
                    ->from(servicereq_vw)
                    ->where('approved','2');
        
        return $this->esched_db->count_all_results();
    }
    
    public function get_disapproved_joborders_report()
    {
         $this->esched_db->select('requestid,updated,requestdate,AssetType,Department,Complaints,Details,note')
                    ->from(servicereq_vw)
                    ->where('approved','2');
         
          $query = $this->esched_db->get();  
        return $query->result_array(); 
    }
    
    
     /* Deferred Job Orders
     * 
     * @author Alingling
     */
       public function get_deferred_joborder()
    {
         $order_column = array("requestid","requestdate","AssetType","Department","Complaints","details");
     
            $this->esched_db->select('*')
                    ->from(servicereq_vw)
                    ->where('approved','3');
            if(!empty($this->input->post("search")["value"]))  
                {  
                    $this->esched_db->group_start()
                        -> like("AssetType", $this->input->post("search")["value"])
                        ->or_like("Department", $this->input->post("search")["value"])
                        ->or_like("Complaints", $this->input->post("search")["value"])
                        ->or_like("details", $this->input->post("search")["value"])
                        ->group_end();
                }  
        
            if(!empty($this->input->post("order")))  
            {  
                $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
            }  
            else  
            {  
                $this->esched_db->order_by("requestdate","DESC");
            }
    }
   
    function make_deferred_joborders_datatables(){  
        $this->get_deferred_joborder();  
        if($this->input->post("length") != -1)  
        {  
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->esched_db->get();  
        return $query->result();  
    }

    
    function get_deferred_joborders_filtered_data(){  
        $this->get_deferred_joborder();  
        $query = $this->esched_db->get();  
        return $query->num_rows();  
    }
  
    
    public function get_deferred_joborders_data()
    {
        $this->esched_db->select('*')
                    ->from(servicereq_vw)
                    ->where('approved','3');
        
        return $this->esched_db->count_all_results();
    }
    
    
    public function get_deferred_joborders_report()
    {
         $this->esched_db->select('requestid,updated,requestdate,AssetType,Department,Complaints,Details,note')
                    ->from(servicereq_vw)
                    ->where('approved','3');
         
          $query = $this->esched_db->get();  
        return $query->result_array(); 
    }
    
    /* Deferred Job Orders
     * 
     * @author Alingling
     */
       public function get_approved_joborder()
    {
         $order_column = array("requestid","requestdate","AssetType","Department","Complaints","details");
     
            $this->esched_db->select('*')
                    ->from(servicereq_vw)
                    ->where('approved','1');
            if(!empty($this->input->post("search")["value"]))  
                {  
                    $this->esched_db->group_start()
                        -> like("AssetType", $this->input->post("search")["value"])
                        ->or_like("Department", $this->input->post("search")["value"])
                        ->or_like("Complaints", $this->input->post("search")["value"])
                        ->or_like("details", $this->input->post("search")["value"])
                        ->group_end();
                }  
        
            if(!empty($this->input->post("order")))  
            {  
                $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
            }  
            else  
            {  
                $this->esched_db->order_by("requestdate","DESC");
            }
    }
   
    function make_approved_joborders_datatables(){  
        $this->get_approved_joborder();  
        if($this->input->post("length") != -1)  
        {  
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->esched_db->get();  
        return $query->result();  
    }

    
    function get_approved_joborders_filtered_data(){  
        $this->get_approved_joborder();  
        $query = $this->esched_db->get();  
        return $query->num_rows();  
    }
  
    
    public function get_approved_joborders_data()
    {
        $this->esched_db->select('*')
                    ->from(servicereq_vw)
                    ->where('approved','1');
        
        return $this->esched_db->count_all_results();
    }
    
    
      public function get_all_approvedjoborderbydate($s_date)
    {
        $order_column = array("requestid","requestdate","AssetType","Department","Complaints","details");
     
            $this->esched_db->select('*')
                    ->from(servicereq_vw)
                    ->where('approved','1')
                    ->like('updated', $s_date);
            if(!empty($this->input->post("search")["value"]))  
                {  
                    $this->esched_db->group_start()
                        -> like("AssetType", $this->input->post("search")["value"])
                        ->or_like("Department", $this->input->post("search")["value"])
                        ->or_like("Complaints", $this->input->post("search")["value"])
                        ->or_like("details", $this->input->post("search")["value"])
                        ->group_end();
                }  
        
            if(!empty($this->input->post("order")))  
            {  
                $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
            }  
            else  
            {  
                $this->esched_db->order_by("requestdate","DESC");
            }
    }
    
    /**
     * 
     * make all purchases table
     */
    function make_all_approvedjoborderbydate_datatables($s_date){  
        $this->get_all_approvedjoborderbydate($s_date);  
        if($this->input->post("length") != -1)  
        {  
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->esched_db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_all_approvedjoborderbydate_filtered_data($s_date){  
        $this->get_all_approvedjoborderbydate($s_date);  
        $query = $this->esched_db->get();  
        return $query->num_rows();  
    }
    
    public function get_all_approved_joborders_data($s_date)
    {
         $this->esched_db->select('*')
                    ->from(servicereq_vw)
                    ->where('approved','1')
                    ->like('updated', $s_date);
        
        return $this->esched_db->count_all_results();
    }
    
     public function get_approved_joborders_bydate_report($s_date)
    {
          $this->esched_db->select('requestid,updated,requestdate,AssetType,Department,Complaints,details,note')
                    ->from(servicereq_vw)
                    ->where('approved','1')
                    ->like('updated', $s_date);
         
          $query = $this->esched_db->get();  
        return $query->result_array(); 
    }
    
    /*
     * Mandatory Monthly Hospital Report
     * 
     * @author Alingling
     * @param 12-20-2017
     */
     
    public function get_daily_census_of_nhip($month)
    {
      
       $d = new DateTime('first day of this month');
        $monthnow = $d->format('m');
        $yearnow = $d->format('Y');
        
        $cm = new DateTime($month); 
        $covermonth = $cm->format('m');
        $coveryear = $cm->format('Y');
        if($monthnow.$yearnow === $covermonth.$coveryear)
        {
                $dating = $this->get_current_datex();
               $datee= new DateTime();
               $diff = date_diff($datee,$d);
                $dd  = $diff->format('%r%a days');

                $data = array();
                $dates = array();
                
               $start_date = date('Y-m-d', strtotime($dd, strtotime($dating)));
                //echo $start_date;
                $end_date = new DateTime($dating);
                $end_date->format("Y-m-d");
                
                $period = new DatePeriod(
                    new DateTime($start_date),
                    new DateInterval('P1D'),
                    $end_date
               );
                
                
                foreach( $period as $date) 
                { 
                    $dates[] = $date->format('Y-m-d'); 
                }
                $dates[] = $dating;
                }
        else
        {
            //   $d = new DateTime('first day of this month');
                $monthstart = date("Y-m-01", strtotime($month."-01"));
                $monthend =  date("Y-m-t", strtotime($month."-01"));
               

                $d = new DateTime($monthstart);
              // $dating = $this->get_current_datex();
               $datee= new DateTime($monthend);
               $diff = date_diff($datee,$d);
                $dd  = $diff->format('%r%a days');

                $data = array();
                $dates = array();
                
               $start_date = date('Y-m-d', strtotime($dd, strtotime($monthend)));
                //echo $start_date;
                $end_date = new DateTime($monthend);
                $end_date->format("Y-m-d");
                
                $period = new DatePeriod(
                    new DateTime($start_date),
                    new DateInterval('P1D'),
                    $end_date
               );
                
                
                foreach( $period as $date) 
                { 
                    $dates[] = $date->format('Y-m-d'); 
                }
                $dates[] = $monthend;
        }
        
        
        for ($i = 0; $i < count($dates); $i++) {
            $this->db->select('"'.$dates[$i].'" as datex,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(inpatient_tbl)
                ->where('((admitdate <= "'.$dates[$i].'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$dates[$i].'" AND admitdate <= "'.$dates[$i].'")) and pxtype = "IPD"');
            
            $query = $this->db->get();
            
            array_push($data, $query->row_array());
        }
        
        return $data;
    }
    
   


    public function get_daily_discharges($month)
    {

        $d = new DateTime('first day of this month');
        $monthnow = $d->format('m');
        $yearnow = $d->format('Y');
        
        $cm = new DateTime($month); 
        $covermonth = $cm->format('m');
        $coveryear = $cm->format('Y');
        if($monthnow.$yearnow === $covermonth.$coveryear)
        {
            $d = new DateTime('first day of this month');
            $dating = $this->get_current_datex();
            $datee= new DateTime();$diff = date_diff($datee,$d);
            $dd  = $diff->format('%r%a days');
        
            $data = array();
            $dates = array();
        
            $start_date = date('Y-m-d', strtotime($dd, strtotime($dating)));
            //echo $start_date;
            $end_date = new DateTime($dating);
            $end_date->format("Y-m-d");
        
            $period = new DatePeriod(
                new DateTime($start_date),
                new DateInterval('P1D'),
                $end_date
            );

            foreach( $period as $date) 
            { 
                $dates[] = $date->format('Y-m-d'); 
            }
                $dates[] = $dating;
        }
        else
        {
            $monthstart = date("Y-m-01", strtotime($month."-01"));
                $monthend =  date("Y-m-t", strtotime($month."-01"));
               

                $d = new DateTime($monthstart);
              // $dating = $this->get_current_datex();
               $datee= new DateTime($monthend);
               $diff = date_diff($datee,$d);
                $dd  = $diff->format('%r%a days');

                $data = array();
                $dates = array();
                
               $start_date = date('Y-m-d', strtotime($dd, strtotime($monthend)));
                //echo $start_date;
                $end_date = new DateTime($monthend);
                $end_date->format("Y-m-d");
                
                $period = new DatePeriod(
                    new DateTime($start_date),
                    new DateInterval('P1D'),
                    $end_date
               );
                
                
                foreach( $period as $date) 
                { 
                    $dates[] = $date->format('Y-m-d'); 
                }
                $dates[] = $monthend;
        }







        
        
        for ($i = 0; $i < count($dates); $i++) {
            $this->db->select('"'.$dates[$i].'" as datex,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(inpatient_tbl)
                ->where("dischadate", $dates[$i])
                ->where("discharged",1)
                ->where('pxtype','IPD');
            
            $query = $this->db->get();
            
            array_push($data, $query->row_array());
        }
        
        return $data;


    }

    public function get_authorized_bed()
    {
          $this->med_db->select('DOHauthorizedbed,authorizedbed')
                    ->from(profile_tbl);
         
          $query = $this->med_db->get();  
        return $query->result_array(); 
    }

    public function get_newborn_census($month)
    {

        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));
               

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');


            $diff = date_diff($e,$d);
            $data['dd']  = $diff->format('%a')+1;

       $this->db->select('sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(inpatient_tbl)
                ->where('((admitdate <= "'.$first.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$end.'" AND admitdate <= "'.$first.'")) and pxtype = "IPD"')
                ->where("pat_classification = 'New Born' or pat_classification = 'newborn'");

                  $query = $this->db->get();  
                return $query->result_array(); 


    }


    

    
      public function get_casecode($diagnosis)
    {
         $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');

        $this->bms_db->select('ID,diagnosis')
                    ->from(causeofconfinement_vw)
                    ->where('diagnosis',$diagnosis)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"');
        
        $query = $this->bms_db->get();
        
        return $query->result_array();
    }

    public function update_causeofconfinement($datas)
    {
        $approved = False;
        $data = array(
            'diagcateg'      => $this->security->xss_clean($datas['confinename']),
        );  
        for ($i = 0; $i < count($datas['controls']); $i++) {
            $cases = $this->user_model->get_casecode($datas['controls'][$i]);
            
            for ($j = 0; $j < count($cases); $j++) {
                $this->bms_db->where('ID',  $cases[$j]["ID"]);
                if ($this->bms_db->update(confinementcauses_tbl, $data)) {
                    $approved = TRUE;
                }
            }
             
        }
        return $approved;
    }

    public function insert_causesofconfinement($datax){
          $data = array(
            'causeofconfinement'    => $this->security->xss_clean($datax['confinename']),
            'confinementnhip'       => $this->security->xss_clean($datax['nhip']),
            'confinementnonnhip'    => $this->security->xss_clean($datax['non']),
            'confinmenttotal'       => $this->security->xss_clean($datax['total']),
            'updatedby'             => $this->session->userdata('empname'),
            'updated'               => $this->get_current_date('server')

            
        );
      return $this->db->insert(causesofconfinement_tbl, $data);
    }


  


    //PDF report
    public function get_confinement_causes_report($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

       $this->db->select('*')
                    ->from(causesofconfinement_tbl)
                    ->where('updated >= "'.$first.'"')
                    ->where('updated <= "'.$end.'"')
                    ->order_by('confinmenttotal',"DESC")
                    ->limit(10);

        $query = $this->db->get();  
        return $query->result_array(); 
    }

    
    public function get_surgical_procedures()
    {
        $now = new DateTime();
        $this->db->select('*')
                    ->from(surgicalvw)
                    ->where('Months',$now->format("n"))
                    ->where('years',$now->format("Y"))
                    ->limit(10);
        
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    
/**
     * GEt top Total Surgical Sterilization: Mandatory Monthly Hospital Report
     * @author Alingling
     */
    
  
    
    public function get_total_surgical_data($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->db->select('surgicalsterile,sum(nhip) nhipc, sum(nonnhip) nonc, sum(total) totalc')
                    ->from(mandatotalsurgical_tbl)
                    ->where('updated >= "'.$first.'"')
                    ->where('updated <= "'.$end.'"')
                    ->group_by('surgicalsterile')
                    ->limit(10);
         $query = $this->db->get();
         return $query->result_array();
    }

    public function get_total_surgical_total($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->db->select('sum(nhip) nhipc, sum(nonnhip) nonc, sum(total) totalc')
                    ->from(mandatotalsurgical_tbl)
                    ->where('updated >= "'.$first.'"')
                    ->where('updated <= "'.$end.'"')
                    ->limit(10);
         $query = $this->db->get();
         return $query->row_array();
    }


      /**
     * GEt Total Surgical Sterilization (for merging): Mandatory Monthly Hospital Report
     * @author Alingling
     */
    
    public function get_total_surgical_merge()
    {
        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');

        $order_column = array("Diag_anes","nhip","non");
        $this->db->select('Diag_anes,count(*) as counts,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                    ->from(inpatient_tbl)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"')
                    ->where("Diag_anes <>''")
                    ->group_by('Diag_anes');
        
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
            $this->db->order_by("Diag_anes","ASC");
        }
    }
    
  
    
    /**
     * 
     * make all purchases table
     */
    function get_total_surgical_merge_datatables(){  
        $this->get_total_surgical_merge();  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
    /**
     * search for all purchases table
     */
    
    function get_total_surgical_merge_filtered_data(){  
        $this->get_total_surgical_merge();  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    
    /**
     * get and returns the count of the fetch data
     */
    
    public function get_total_surgical_merge_data()
    {
        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');

     $this->db->select('Diag_anes, count(*) as counts,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                    ->from(inpatient_tbl)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"')
                     ->where("Diag_anes <>''")
                    ->group_by('Diag_anes');
        return $this->db->count_all_results();
    }


    //merge_total_surgical
    public function insert_totalsurgical($datax){
          $data = array(
            'surgicalsterile'   => $this->security->xss_clean($datax['surgicalsterile']),
            'nhip'              => $this->security->xss_clean($datax['nhip']),
            'nonnhip'           => $this->security->xss_clean($datax['nonnhip']),
            'total'             => $this->security->xss_clean($datax['total']),
            'updatedby'         => $this->session->userdata('empname'),
            'updated'           => $this->get_current_date('server')

            
        );
      return $this->db->insert(mandatotalsurgical_tbl, $data);
    }

    //end total surgical merge


    public function get_diagnosis_summary()
    {

        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');


        $this->db->select('causeofconfinement,')
                ->from(causesofconfinement_tbl)
                ->where('updated >= "'.$first.'"')
                ->where('updated <= "'.$end.'"')
                ->where("causeofconfinement <>''");

        $query = $this->db->get();  
        return $query->result_array(); 
    }


     public function get_ob_procedure($month)
    {

        $monthstart = date("Y-m-01", strtotime($month."-01"));
            $monthend =  date("Y-m-t", strtotime($month."-01"));
               

            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e= new DateTime($monthend);
            $end = $e->format('Y-m-d');




       $this->db->select('OBprocedure,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non ,sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(inpatient_tbl)
                ->where('dischadate >= "'.$first.'"')
                ->where('dischadate <= "'.$end.'"')
                ->where("OBprocedure <>''");

        $query = $this->db->get();  
        return $query->row_array(); 
    }

    public function get_ob_procedure_cs($month)
    {
          $monthstart = date("Y-m-01", strtotime($month."-01"));
            $monthend =  date("Y-m-t", strtotime($month."-01"));
               

            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e= new DateTime($monthend);
            $end = $e->format('Y-m-d');


       $this->db->select('OBprocedure,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non ,sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(inpatient_tbl)
                ->where('dischadate >= "'.$first.'"')
                ->where('dischadate <= "'.$end.'"')
                ->where('OBprocedure','Ceasarian');

        $query = $this->db->get();  
        return $query->row_array(); 
    }

    public function get_cs_indications($month)
    {

        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));
               

            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e= new DateTime($monthend);
            $end = $e->format('Y-m-d');




       $this->bms_db->select('diagnosis,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non ,sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(mandatory_obprocedure_vw)
                ->where('dischadate >= "'.$first.'"')
                ->where('dischadate <= "'.$end.'"')
                ->limit(5);
         

        $query = $this->bms_db->get();  
        return $query->result_array(); 
    }


     /**
     * GEt Obstetrics Procedure: Mandatory Monthly Hospital Report
     * @author Alingling
     */
    
    public function get_obstetric_procedure()
    {
        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');

        $order_column = array("diagcateg","diagnosis","nhip","non");
        $this->bms_db->select('diagcateg,diagnosis, count(*) as counts,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                    ->from(mandatory_obprocedure_vw)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"')
                    ->group_by('diagnosis');
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->bms_db->group_start()
                -> like("diagnosis", $this->input->post("search")["value"])
                -> or_like("diagcateg", $this->input->post("search")["value"])
                
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
    

    function get_obstetric_procedure_datatables(){  
        $this->get_obstetric_procedure();  
        if($this->input->post("length") != -1)  
        {  
            $this->bms_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->bms_db->get();  
        return $query->result();  
    }

    
    function get_obstetric_procedure_filtered_data(){  
        $this->get_obstetric_procedure();  
        $query = $this->bms_db->get();  
        return $query->num_rows();  
    }
    

    public function get_obstetric_procedure_data()
    {
        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');

    $this->bms_db->select('diagcateg,diagnosis, count(*) as counts,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                    ->from(mandatory_obprocedure_vw)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                      ->where('pxtype = "IPD"')
                      ->group_by('diagnosis');
        return $this->bms_db->count_all_results();
    }

    ///top ob procedure

    public function get_top_obstetric_procedure($month)
    {
         $monthstart = date("Y-m-01", strtotime($month."-01"));
            $monthend =  date("Y-m-t", strtotime($month."-01"));
               

            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e= new DateTime($monthend);
            $end = $e->format('Y-m-d');


        $this->bms_db->select('*')
                    ->from(mandaobstetric_tbl)
                    ->where('updated >= "'.$first.'"')
                    ->where('updated <= "'.$end.'"')
                    ->order_by('total','desc')
                    ->limit(5);


        $query = $this->bms_db->get();
        return $query->result_array();
        
   }



     public function get_casecode_ob($diagnosis)
    {
         $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');

        $this->bms_db->select('ID,diagnosis')
                    ->from(mandatory_obprocedure_vw)
                    ->where('diagnosis',$diagnosis)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"');
        
        $query = $this->bms_db->get();
        
        return $query->result_array();
    }

    public function update_obprocedure($datas)
    {
        $approved = False;
        $data = array(
            'diagcateg'      => $this->security->xss_clean($datas['confinename']),
        );  
        for ($i = 0; $i < count($datas['diagnosis']); $i++) {
            $cases = $this->user_model->get_casecode_ob($datas['diagnosis'][$i]);
            
            for ($j = 0; $j < count($cases); $j++) {
                $this->bms_db->where('ID',  $cases[$j]["ID"]);
                if ($this->bms_db->update(indicationcauses_tbl, $data)) {
                    $approved = TRUE;
                }
            }
             
        }
        return $approved;
    }

    public function insert_obprocedure($datax){
          $data = array(
            'indicationcause'    => $this->security->xss_clean($datax['confinename']),
            'nhip'       => $this->security->xss_clean($datax['nhip']),
            'nonnhip'    => $this->security->xss_clean($datax['non']),
            'total'       => $this->security->xss_clean($datax['total']),
            'updatedby'             => $this->session->userdata('empname'),
            'updated'               => $this->get_current_date('server')

            
        );
      return $this->bms_db->insert(mandaobstetric_tbl, $data);
    }






/**
    *
    * Mortality: Mandatory Monthly Hospital Report
    *
    *
     * @author Alingling
     */
    
    public function get_mortalitycases($month)
    {
            $monthstart = date("Y-m-01", strtotime($month."-01"));
            $monthend =  date("Y-m-t", strtotime($month."-01"));
               

            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e= new DateTime($monthend);
            $end = $e->format('Y-m-d');



     

        $order_column = array("Diag_discharge","nhip","non");
        $this->db->select('Diag_discharge,nhip,non')
                    ->from(manda_mortality_vw)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"')
                    ->where('disposition','Expired')
                    ->where("Diag_discharge <> ''")
                    ->limit(5);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                -> like("Diag_discharge", $this->input->post("search")["value"])
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
    

    function get_mortality_cases_datatables($month){  
        $this->get_mortalitycases($month);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }

    
    function get_mortality_cases_filtered_data($month){  
        $this->get_mortalitycases($month);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    

    public function get_mortality_cases_data($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
            $monthend =  date("Y-m-t", strtotime($month."-01"));
               

            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e= new DateTime($monthend);
            $end = $e->format('Y-m-d');
        $this->db->select('Diag_discharge,nhip,non')
                    ->from(manda_mortality_vw)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"')
                    ->where('disposition','Expired')
                    ->where("Diag_discharge <> ''")
                    ->limit(5);
        return $this->db->count_all_results();
    }


 public function get_mortality($month)
 {
    $monthstart = date("Y-m-01", strtotime($month."-01"));
            $monthend =  date("Y-m-t", strtotime($month."-01"));
               

            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e= new DateTime($monthend);
            $end = $e->format('Y-m-d');
        $this->db->select('Diag_discharge,nhip,non')
                    ->from(manda_mortality_vw)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"')
                    ->where('disposition','Expired')
                    ->where("Diag_discharge <> ''")
                    ->limit(5);

         $query = $this->db->get();  
        return $query->result_array(); 
 }



    /**
    *
    * Referrals: Mandatory Monthly Hospital Report
    *@author Alingling
    **/

    
    public function get_referrals()
    {
        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');

        $order_column = array("reasonforreferral","nhip","non");
        $this->db->select('reasonforreferral,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                    ->from(inpatient_tbl)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"')
                    ->where('disposition','Transferred/Referred')
                    ->group_by('reasonforreferral')
                       ->order_by('totalx',"DESC")
                    ->limit(10);
        
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                -> like("reasonforreferral", $this->input->post("search")["value"])
                ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by("totalx","ASC");
        }
    }
    

    function get_referrals_datatables(){  
        $this->get_referrals();  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }

    
    function get_referrals_filtered_data(){  
        $this->get_referrals();  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    

    public function get_referrals_data()
    {
        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');
        $this->db->select('reasonforreferral,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                    ->from(inpatient_tbl)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"')
                    ->where('disposition','Transferred/Referred')
                    ->group_by('reasonforreferral')
                    ->order_by('totalx',"DESC")
                    ->limit(10);
        return $this->db->count_all_results();
    }

    public function get_referral($month)
    {

            $monthstart = date("Y-m-01", strtotime($month."-01"));
            $monthend =  date("Y-m-t", strtotime($month."-01"));
               

            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e= new DateTime($monthend);
            $end = $e->format('Y-m-d');


    $this->db->select('reasonforreferral,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                    ->from(inpatient_tbl)
                    ->where('dischadate >= "'.$first.'"')
                    ->where('dischadate <= "'.$end.'"')
                    ->where('pxtype = "IPD"')
                    ->where('disposition','Transferred/Referred')
                    ->group_by('reasonforreferral')
                    ->order_by('totalx',"DESC")
                    ->limit(5);
          $query = $this->db->get();  
        return $query->result_array(); 
    }

     public function get_mandaprofile()
    {
        $this->med_db->select('*')
                    ->from(profile_tbl);
                  
        $query = $this->med_db->get();  
        return $query->row_array(); 
    }

}


 