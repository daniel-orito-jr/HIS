<?php
class doh_model extends MY_Model{
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
        $this->dweclaims_db = $this->load->database('dweclaims', true);
        $this->hls_db = $this->load->database('hlsv2', true);
        $this->hrs_db = $this->load->database('hrsv2', true);
        $this->csr_db = $this->load->database('csrv2', true);
        $this->hubuserlog_db = $this->load->database('hubuserlog', true);
        $this->epay_db = $this->load->database('epayv2', true);
        $this->messaging_db = $this->load->database('messaging', true);
    }
    
    public function get_discharges_nopatients($pat_clascode,$pat_classub,$year)
    {
        $this->db->select('count(caseno) as nopx,sum(daysconfined) as lengthofstay,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non,sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,sum(case when hmoid = "" then 0 else 1 end)hmo,'
                . 'sum(case when (disposition ="Improved" or disposition="Recovered") then 1 else 0 end) ri,sum(case when (disposition ="HAMA/DAMA" or disposition="HAMA") then 1 else 0 end) H,sum(case when disposition ="Expired"  then 1 else 0 end) D,'
                . 'sum(case when disposition ="Absconded" then 1 else 0 end) A,sum(case when (disposition ="Transferred/Referred" or disposition="Transferred" or disposition = "Referred") then 1 else 0 end) T,'
                . 'sum(case when disposition = "Expired" and dischargein48="< 48HRS" then 1 else 0 end) less48,sum(case when disposition = "Expired" and dischargein48=">= 48HRS" then 1 else 0 end) more48,')
                ->from(inpatient_finaldiag_vw)
                ->where('dischadate >= "'.$year.'-01-01"')
                ->where('dischadate <= "'.$year.'-12-31"');
            if($pat_clascode == "Surgery")
            {   
                $this->db->where('pat_clascode',$pat_clascode);
                if($pat_classub == "Pedia")
                {
                     $this->db->where(round('Age') <= 8);
                }
                else
                {
                   $this->db->where(round('Age') > 8); 
                }   
            }
            else if($pat_clascode == "Pediatrics")
            {
                $this->db->like('pat_clascode','Pedia');
            }else if($pat_clascode == "New Born")
            {
                $this->db->like('pat_clascode','new');
            }else if($pat_clascode == "All")
            {
                
            }else if($pat_clascode == "Pathologic")
            {   
                if($pat_classub == "patho")
                {
                    $this->db->where('pathologic',1);
                }
                else
                {
                    $this->db->where('pathologic',0);
                }
                
            }else if($pat_clascode == "Wellbaby")
            {
                $this->db->where('Age <= 1')
                        ->where('died <= 0');
            }
            
            else
            {   $this->db->where('pat_clascode',$pat_clascode); }
            
            $query = $this->db->get();
            return $query->row_array();
    }
    
    
    public function get_discharges_totaldaysofstay($year)
    {
        
        $this->db->select("sum(daysconfined) as totaldaysofstay")
                ->from(inpatient_finaldiag_vw)
                ->where('dischadate >= "'.$year.'-01-01"')
                ->where('dischadate <= "'.$year.'-12-31"');
           
            $query = $this->db->get();
            return $query->row_array();
    }
    
    public function get_total_lengthofstay($year)
    {
        
        $this->db->select("sum(daysconfined) as totallengthofstay")
                ->from(inpatient_finaldiag_vw)
                ->where('dischadate >= "'.$year.'-01-01"')
                ->where('dischadate <= "'.$year.'-12-31"');
           
            $query = $this->db->get();
            return $query->row_array();
    }
    
    public function get_total_discharges($year)
    {
        $this->db->select("count(caseno) as totaldischarges")
                ->from(inpatient_finaldiag_vw)
                ->where('dischadate >= "'.$year.'-01-01"')
                ->where('dischadate <= "'.$year.'-12-31"');
           
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /*
     * Fetch 10 Causes of Morbidity 
     * 
     * @author Alingling
     * @version 02-11-2019
     */
    
    public function fetch_cause_morbidity_leading($year)
    {
        $order_column = array("Diag_discharge","totalcsno","ICD10");
        
        $this->db->select('Diag_discharge,ICD10,count(caseno) as totalcsno')
                ->from(inpatient_finaldiag_vw)
                ->where('dischadate >= "'.$year.'-01-01"')
                ->where('dischadate <= "'.$year.'-12-31"')
                ->where('pat_clascode <> "Obstetrics"')
                ->group_by('Diag_discharge')
                ->LIMIT(10);
                
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like('Diag_discharge', $this->input->post("search")["value"])
                    ->or_like('ICD10', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('totalcsno','DESC');
        }
    }
    
 
    function make_cause_morbidity_leading_datatables($year){  
        $this->fetch_cause_morbidity_leading($year);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
   
    function fetch_cause_morbidity_leading_filtered_data($year){  
        $this->fetch_cause_morbidity_leading($year);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    public function fetch_cause_morbidity_leading_data($year)
    {
        $this->db->select('Diag_discharge,ICD10,count(caseno) as totalcsno')
                ->from(inpatient_finaldiag_vw)
                ->where('dischadate >= "'.$year.'-01-01"')
                ->where('dischadate <= "'.$year.'-12-31"')
                ->where('pat_clascode <> "Obstetrics"')
                ->group_by('Diag_discharge')
                ->order_by('totalcsno','DESC')
                ->LIMIT(10);
        return $this->db->count_all_results();
    }
    
    public function fetch_cause_morbidity_leading_report($year)
    {
        $this->db->select('Diag_discharge,ICD10,count(caseno) as totalcsno')
                ->from(inpatient_finaldiag_vw)
                ->where('dischadate >= "'.$year.'-01-01"')
                ->where('dischadate <= "'.$year.'-12-31"')
                ->where('pat_clascode <> "Obstetrics"')
                ->group_by('Diag_discharge')
                ->order_by('totalcsno','DESC')
                ->LIMIT(10);
        $query = $this->db->get();
        return $query->result_array();
    }
    /*
     * Fetch 10 Causes of Morbidity - Age Distribution
     * 
     * @author Alingling
     * @version 02-11-2019
     */
    
    public function fetch_cause_morbidity($year)
    {
        $order_column = array("Diag_discharge","under1M","under1F","age1_4M","age1_4F","age5_9M","age5_9F","age10_14M","age10_14F","age15_19M","age15_19F","age20_24M","age20_24F","age25_29M","age25_29F","age30_34M","age30_34F","age35_39M","age35_39F","age40_44M","age40_44F","age45_49M","age45_49F","age50_54M","age50_54F","age55_59M","age55_59F","age60_64M","age60_64F","age65_69M","age65_69F","age70M","age70F","subtotalM","subtotalF","totalcsno","ICD10");
        
        $this->db->select('Diag_discharge,ICD10,count(caseno) as totalcsno, 
		sum(case when sex="Male" and ROUND(Age, 0) < 1 then 1 else 0 end) under1M,
		sum(case when sex="Female" and ROUND(Age, 0) < 1 then 1 else 0 end) under1F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 1 and ROUND(Age, 0) <= 4  then 1 else 0 end) age1_4M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 1 and ROUND(Age, 0) <= 4  then 1 else 0 end) age1_4F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 5 and ROUND(Age, 0) <= 9  then 1 else 0 end) age5_9M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 5 and ROUND(Age, 0) <= 9  then 1 else 0 end) age5_9F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 10 and ROUND(Age, 0) <= 14  then 1 else 0 end) age10_14M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 10 and ROUND(Age, 0) <= 14  then 1 else 0 end) age10_14F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 15 and ROUND(Age, 0) <= 19  then 1 else 0 end) age15_19M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 15 and ROUND(Age, 0) <= 19  then 1 else 0 end) age15_19F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 20 and ROUND(Age, 0) <= 24  then 1 else 0 end) age20_24M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 20 and ROUND(Age, 0) <= 24  then 1 else 0 end) age20_24F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 25 and ROUND(Age, 0) <= 29  then 1 else 0 end) age25_29M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 25 and ROUND(Age, 0) <= 29  then 1 else 0 end) age25_29F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 30 and ROUND(Age, 0) <= 34  then 1 else 0 end) age30_34M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 30 and ROUND(Age, 0) <= 34  then 1 else 0 end) age30_34F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 35 and ROUND(Age, 0) <= 39  then 1 else 0 end) age35_39M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 35 and ROUND(Age, 0) <= 39  then 1 else 0 end) age35_39F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 40 and ROUND(Age, 0) <= 44  then 1 else 0 end) age40_44M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 40 and ROUND(Age, 0) <= 44  then 1 else 0 end) age40_44F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 45 and ROUND(Age, 0) <= 49  then 1 else 0 end) age45_49M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 45 and ROUND(Age, 0) <= 49  then 1 else 0 end) age45_49F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 50 and ROUND(Age, 0) <= 54  then 1 else 0 end) age50_54M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 50 and ROUND(Age, 0) <= 54  then 1 else 0 end) age50_54F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 55 and ROUND(Age, 0) <= 59  then 1 else 0 end) age55_59M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 55 and ROUND(Age, 0) <= 59  then 1 else 0 end) age55_59F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 60 and ROUND(Age, 0) <= 64  then 1 else 0 end) age60_64M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 60 and ROUND(Age, 0) <= 64  then 1 else 0 end) age60_64F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 65 and ROUND(Age, 0) <= 69  then 1 else 0 end) age65_69M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 65 and ROUND(Age, 0) <= 69  then 1 else 0 end) age65_69F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 70 then 1 else 0 end) age70M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 70 then 1 else 0 end) age70F,
		sum(case when sex="Male" then 1 else 0 end) subtotalM,
		sum(case when sex="Female" then 1 else 0 end) subtotalF')
                ->from(inpatient_finaldiag_vw)
                ->where('dischadate >= "'.$year.'-01-01"')
                ->where('dischadate <= "'.$year.'-12-31"')
                ->where('pat_clascode <> "Obstetrics"')
                ->group_by('Diag_discharge')
                ->LIMIT(10);
                
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like('Diag_discharge', $this->input->post("search")["value"])
                    ->or_like('ICD10', $this->input->post("search")["value"])
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('totalcsno','DESC');
        }
    }
    
 
    function make_cause_morbidity_datatables($year){  
        $this->fetch_cause_morbidity($year);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
   
    function fetch_cause_morbidity_filtered_data($year){  
        $this->fetch_cause_morbidity($year);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    public function fetch_cause_morbidity_data($year)
    {
        $this->db->select('Diag_discharge,ICD10,count(caseno) as totalcsno, 
		sum(case when sex="Male" and ROUND(Age, 0) < 1 then 1 else 0 end) under1M,
		sum(case when sex="Female" and ROUND(Age, 0) < 1 then 1 else 0 end) under1F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 1 and ROUND(Age, 0) <= 4  then 1 else 0 end) age1_4M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 1 and ROUND(Age, 0) <= 4  then 1 else 0 end) age1_4F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 5 and ROUND(Age, 0) <= 9  then 1 else 0 end) age5_9M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 5 and ROUND(Age, 0) <= 9  then 1 else 0 end) age5_9F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 10 and ROUND(Age, 0) <= 14  then 1 else 0 end) age10_14M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 10 and ROUND(Age, 0) <= 14  then 1 else 0 end) age10_14F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 15 and ROUND(Age, 0) <= 19  then 1 else 0 end) age15_19M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 15 and ROUND(Age, 0) <= 19  then 1 else 0 end) age15_19F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 20 and ROUND(Age, 0) <= 24  then 1 else 0 end) age20_24M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 20 and ROUND(Age, 0) <= 24  then 1 else 0 end) age20_24F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 25 and ROUND(Age, 0) <= 29  then 1 else 0 end) age25_29M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 25 and ROUND(Age, 0) <= 29  then 1 else 0 end) age25_29F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 30 and ROUND(Age, 0) <= 34  then 1 else 0 end) age30_34M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 30 and ROUND(Age, 0) <= 34  then 1 else 0 end) age30_34F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 35 and ROUND(Age, 0) <= 39  then 1 else 0 end) age35_39M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 35 and ROUND(Age, 0) <= 39  then 1 else 0 end) age35_39F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 40 and ROUND(Age, 0) <= 44  then 1 else 0 end) age40_44M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 40 and ROUND(Age, 0) <= 44  then 1 else 0 end) age40_44F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 45 and ROUND(Age, 0) <= 49  then 1 else 0 end) age45_49M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 45 and ROUND(Age, 0) <= 49  then 1 else 0 end) age45_49F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 50 and ROUND(Age, 0) <= 54  then 1 else 0 end) age50_54M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 50 and ROUND(Age, 0) <= 54  then 1 else 0 end) age50_54F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 55 and ROUND(Age, 0) <= 59  then 1 else 0 end) age55_59M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 55 and ROUND(Age, 0) <= 59  then 1 else 0 end) age55_59F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 60 and ROUND(Age, 0) <= 64  then 1 else 0 end) age60_64M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 60 and ROUND(Age, 0) <= 64  then 1 else 0 end) age60_64F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 65 and ROUND(Age, 0) <= 69  then 1 else 0 end) age65_69M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 65 and ROUND(Age, 0) <= 69  then 1 else 0 end) age65_69F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 70 then 1 else 0 end) age70M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 70 then 1 else 0 end) age70F,
		sum(case when sex="Male" then 1 else 0 end) subtotalM,
		sum(case when sex="Female" then 1 else 0 end) subtotalF')
                ->from(inpatient_finaldiag_vw)
                ->where('dischadate >= "'.$year.'-01-01"')
                ->where('dischadate <= "'.$year.'-12-31"')
                ->where('pat_clascode <> "Obstetrics"')
                ->group_by('Diag_discharge')
                ->order_by('totalcsno','DESC')
                ->LIMIT(10);
        return $this->db->count_all_results();
    }
    
    public function fetch_cause_morbidity_report($year)
    {
        $this->db->select('Diag_discharge,ICD10,count(caseno) as totalcsno, 
		sum(case when sex="Male" and ROUND(Age, 0) < 1 then 1 else 0 end) under1M,
		sum(case when sex="Female" and ROUND(Age, 0) < 1 then 1 else 0 end) under1F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 1 and ROUND(Age, 0) <= 4  then 1 else 0 end) age1_4M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 1 and ROUND(Age, 0) <= 4  then 1 else 0 end) age1_4F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 5 and ROUND(Age, 0) <= 9  then 1 else 0 end) age5_9M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 5 and ROUND(Age, 0) <= 9  then 1 else 0 end) age5_9F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 10 and ROUND(Age, 0) <= 14  then 1 else 0 end) age10_14M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 10 and ROUND(Age, 0) <= 14  then 1 else 0 end) age10_14F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 15 and ROUND(Age, 0) <= 19  then 1 else 0 end) age15_19M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 15 and ROUND(Age, 0) <= 19  then 1 else 0 end) age15_19F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 20 and ROUND(Age, 0) <= 24  then 1 else 0 end) age20_24M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 20 and ROUND(Age, 0) <= 24  then 1 else 0 end) age20_24F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 25 and ROUND(Age, 0) <= 29  then 1 else 0 end) age25_29M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 25 and ROUND(Age, 0) <= 29  then 1 else 0 end) age25_29F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 30 and ROUND(Age, 0) <= 34  then 1 else 0 end) age30_34M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 30 and ROUND(Age, 0) <= 34  then 1 else 0 end) age30_34F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 35 and ROUND(Age, 0) <= 39  then 1 else 0 end) age35_39M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 35 and ROUND(Age, 0) <= 39  then 1 else 0 end) age35_39F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 40 and ROUND(Age, 0) <= 44  then 1 else 0 end) age40_44M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 40 and ROUND(Age, 0) <= 44  then 1 else 0 end) age40_44F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 45 and ROUND(Age, 0) <= 49  then 1 else 0 end) age45_49M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 45 and ROUND(Age, 0) <= 49  then 1 else 0 end) age45_49F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 50 and ROUND(Age, 0) <= 54  then 1 else 0 end) age50_54M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 50 and ROUND(Age, 0) <= 54  then 1 else 0 end) age50_54F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 55 and ROUND(Age, 0) <= 59  then 1 else 0 end) age55_59M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 55 and ROUND(Age, 0) <= 59  then 1 else 0 end) age55_59F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 60 and ROUND(Age, 0) <= 64  then 1 else 0 end) age60_64M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 60 and ROUND(Age, 0) <= 64  then 1 else 0 end) age60_64F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 65 and ROUND(Age, 0) <= 69  then 1 else 0 end) age65_69M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 65 and ROUND(Age, 0) <= 69  then 1 else 0 end) age65_69F,
		sum(case when sex="Male" and ROUND(Age, 0) >= 70 then 1 else 0 end) age70M,
		sum(case when sex="Female" and ROUND(Age, 0) >= 70 then 1 else 0 end) age70F,
		sum(case when sex="Male" then 1 else 0 end) subtotalM,
		sum(case when sex="Female" then 1 else 0 end) subtotalF')
                ->from(inpatient_finaldiag_vw)
                ->where('dischadate >= "'.$year.'-01-01"')
                ->where('dischadate <= "'.$year.'-12-31"')
                ->where('pat_clascode <> "Obstetrics"')
                ->group_by('Diag_discharge')
                ->order_by('totalcsno','DESC')
                ->LIMIT(10);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     * Fetch Inpatient with Final Diagnosis
     * 
     * @author Alingling
     * @version 02-11-2019
     */
    
    public function fetch_inpatients_finaldiagnosis($finaldiag,$year)
    {
        $order_column = array("Diag_discharge","ICD10","caseno","name","sex","Age","admitdate","dischadate","phicmembr","NRclearedby","NRclearedDT");
        
        $this->db->select('id,Diag_discharge,ICD10,caseno,name,sex,Age,admitdate,dischadate,phicmembr,NRclearedby,NRclearedDT')
                ->from(inpatient_finaldiag_vw)
                ->where('dischadate >= "'.$year.'-01-01"')
                ->where('dischadate <= "'.$year.'-12-31"')
                ->where('Diag_discharge',$finaldiag);
                
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like('Diag_discharge', $this->input->post("search")["value"])
                    ->or_like('caseno', $this->input->post("search")["value"])
                    ->or_like('name', $this->input->post("search")["value"])
                    ->or_like('NurseIncharge', $this->input->post("search")["value"])
                    ->or_like('phicmembr', $this->input->post("search")["value"])
                    ->or_like('ICD10', $this->input->post("search")["value"])
                    ->or_like('NRclearedby', $this->input->post("search")["value"])
                     ->or_like('sex', $this->input->post("search")["value"])
                     ->or_like('Age', $this->input->post("search")["value"])
            ->group_end();
        } 
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('dischadate','DESC');
        }
    }
    
 
    function make_inpatients_finaldiagnosis_datatables($finaldiag,$year){  
        $this->fetch_inpatients_finaldiagnosis($finaldiag,$year);  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
   
    function fetch_inpatients_finaldiagnosis_filtered_data($finaldiag,$year){  
        $this->fetch_inpatients_finaldiagnosis($finaldiag,$year);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    public function fetch_inpatients_finaldiagnosis_data($finaldiag,$year)
    {
        $this->db->select('id,Diag_discharge,ICD10,caseno,name,sex,Age, admitdate,dischadate,phicmembr,NRclearedby,NRclearedDT')
                ->from(inpatient_finaldiag_vw)
                ->where('dischadate >= "'.$year.'-01-01"')
                ->where('dischadate <= "'.$year.'-12-31"')
                ->where('Diag_discharge',$finaldiag)
                ->order_by('dischadate','DESC');
        return $this->db->count_all_results();
    }
    
    /*
     * Fetch List of ICD CODE
     * 
     * @author Alingling
     * @version 02-11-2019
     */
    
    public function fetch_icdcode()
    {
        $order_column = array("icdcode","diagnosis");
        
        $this->db->select('icdcode,diagnosis')
                ->from(phicicdcode_tbl)
                ->where('codetype','ICD');
                
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->db->group_start()
                    ->like('icdcode', $this->input->post("search")["value"])
                    ->or_like('diagnosis', $this->input->post("search")["value"])
            ->group_end();
        } 
        
        if(!empty($this->input->post("order")))  
        {  
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('diagnosis','ASC');
        }
    }
    
 
    function make_icdcode_datatables(){  
        $this->fetch_icdcode();  
        if($this->input->post("length") != -1)  
        {  
            $this->db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->db->get();  
        return $query->result();  
    }
    
   
    function fetch_icdcode_filtered_data(){  
        $this->fetch_icdcode();  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    public function fetch_icdcode_data()
    {
        $this->db->select('icdcode,diagnosis')
                ->from(phicicdcode_tbl)
                ->where('codetype','ICD')
                ->order_by('diagnosis','ASC');
        return $this->db->count_all_results();
    }
    
    /*
     * Update Final Diagnosis
     * 
     * @author Alingling
     * @version 02-11-2019
     */
    
    
    public function update_finaldiagnosis($datax)
    {
        $data = array(
            'Diag_discharge' => $this->security->xss_clean($datax["diag"]),
            'ICD10'=> $this->security->xss_clean($datax["icd"]),
            'Diag_discharge_updatedby' => $this->security->xss_clean($this->session->userdata('empname')),
            'Diag_discharge_updatedDT' => $this->get_current_date()
        );
        
        $this->db->where('id',  $this->security->xss_clean($datax['id']));
        return $this->db->update(inpatient_tbl, $data);
        
    }
    
}