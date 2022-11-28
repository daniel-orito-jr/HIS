<?php

class Dashboard_model extends MY_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        
        $this->hospv2_db = $this->load->database('hospv2', true);
        $this->med_db = $this->load->database('medv2', true);
        $this->dweclaims_db = $this->load->database('dweclaims', true);
        $this->ams_db = $this->load->database('amsv1', true);
        $this->hlsv2_db = $this->load->database('hlsv2', true);
        $this->hrsv2_db = $this->load->database('hrsv2', true);
        $this->pmsv2_db = $this->load->database('pmsv2', true);
        $this->localset_db = $this->load->database('localset', true);
    }
    
    public function today_census()
    {
       $this->db->select('sum(caseno) as px, sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(inpatient_tbl)
//                ->where('dischadate >=', $date)    
                ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype','IPD')
                ->where("discharged",0);
        $query = $this->db->get();
        return $query->row_array(); 
    }   
    
    public function getUnpreparedClaims()
    {
        $this->med_db->select(' sum(case when datediff("'.$this->get_current_datex().'", dischadate) <= 30 then 1 else 0 end) first,'
                . 'sum(case when datediff("'.$this->get_current_datex().'", dischadate) >= 31 and datediff("'.$this->get_current_datex().'", dischadate) <= 45 then 1 else 0 end) second,'
                . 'sum(case when datediff("'.$this->get_current_datex().'", dischadate) >= 46 and datediff("'.$this->get_current_datex().'", dischadate) <= 60 then 1 else 0 end) third,'
                . 'sum(case when datediff("'.$this->get_current_datex().'", dischadate) >= 61 then 1 else 0 end) fourth')
                ->from(patientphic_vw)
                ->where('dischadate <=',$this->get_current_datex())
                ->where('discharged',1)
                ->where('phiccode <>','NHP')
                ->where('claimcontrolno','');
        $query = $this->med_db->get();
        return $query->row_array();
    }
    
    public function getPendingClaims()
    {
        $this->dweclaims_db->select(' sum(case when datediff("'.$this->get_current_datex().'", processdate) <= 30 then 1 else 0 end) nontransmitted1,'
                . 'sum(case when datediff("'.$this->get_current_datex().'", processdate) >= 31 and datediff('.$this->get_current_datex().', processdate) <= 45 then 1 else 0 end) nontransmitted2,'
                . 'sum(case when datediff("'.$this->get_current_datex().'", processdate) >= 46 and datediff('.$this->get_current_datex().', processdate) <= 60 then 1 else 0 end) nontransmitted3,'
                . 'sum(case when datediff("'.$this->get_current_datex().'", processdate) >= 61 then 1 else 0 end) nontransmitted4')
                ->from(eclaims_tbl)
                ->where('status',0)
                ->where('batchno != ""');
        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }
    
     public function getSentClaims($sentEclaimsDate)
    {
        $monthstart = date("Y-m-01", strtotime($sentEclaimsDate."-01"));
        $monthend =  date("Y-m-t", strtotime($sentEclaimsDate."-01"));
            
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $this->dweclaims_db->select('count(CSNO) as monthly, '
                . 'sum(case when pStatus = "IN PROCESS" then 1 else 0 end) inprocess,'
                . 'sum(case when pStatus = "RETURN" then 1 else 0 end) returnx,'
                . 'sum(case when pStatus = "DENIED" then 1 else 0 end) denied,'
                . 'sum(case when pStatus = "WITH VOUCHER" OR pStatus = "VOUCHER"  then 1 else 0 end) voucher,'
                . 'sum(case when pStatus = "WITH CHEQUE" then 1 else 0 end) wcheque')
//                . 'sum(case when proc1date >= "'.$first.'" and proc1date <= "'.$end.'" then 1 else 0 end) monthly'
                ->from(masterview_vw)
                ->where('ReceiveDate >=',$first)
                ->where('ReceiveDate <=',$end);
        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }
    
    public function getPHARoftheMonth()
    {
        $monthstart = date("Y-m-01", strtotime($this->get_my()."-01"));
        $monthend =  date("Y-m-t", strtotime($this->get_my()."-01"));
            
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        
        $this->dweclaims_db->select('sum(grandtotal) as totalamt')
            ->from(masterview_vw)
            ->where('proc1date >= "'.$first.'"')
            ->where('proc1date <= "'.$end.'"')
            ->where('pStatus != "WITH CHEQUE"')
            ->where('tagged',0);
        
        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }
    
    public function getAdmitDischargeDaily($admitDischaDate)
    {
//        $monthstart = date("Y-m-01", strtotime($admitDischaDate."-01"));
//        $monthend =  date("Y-m-t", strtotime($admitDischaDate."-01"));
//            
//        $d = new DateTime($monthstart);
//        $first = $d->format('Y-m-d');
//        $e= new DateTime($monthend);
//        $end = $e->format('Y-m-d');
        $this->db->select("sum(case when admitdate = '".$admitDischaDate."' and phicmembr <> 'Non-NHIP' then 1 else 0 end) admittedPHIC,"
                        . "sum(case when admitdate = '".$admitDischaDate."' and phicmembr = 'Non-NHIP' then 1 else 0 end) admittedNonPHIC,"
                        . "sum(case when dischadate = '".$admitDischaDate."' and phicmembr <> 'Non-NHIP' and discharged = 1 then 1 else 0 end) dischargedPHIC,"
                        . "sum(case when dischadate = '".$admitDischaDate."' and phicmembr = 'Non-NHIP' and discharged = 1 then 1 else 0 end) dischargedNonPHIC")
                ->from(inpatient_tbl)
                ->where('pxtype','IPD');
        
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getTotalAccPHICAR()
    {
         $this->dweclaims_db->select('sum(grandtotal) as totalamt')
            ->from(masterview_vw)
            ->where('pStatus != "WITH CHEQUE"')
            ->where('tagged',0);
        
        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }
    
    
    public function getPaymentForTheMonth()
    {
        $monthstart = date("Y-m-01", strtotime($this->get_my()."-01"));
        $monthend =  date("Y-m-t", strtotime($this->get_my()."-01"));
               

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->dweclaims_db->select('sum(case when tagged = "1" then granpaid else grandtotal end) totalamount')
                ->from(masterview_vw)
                ->where('asof BETWEEN "'.$first.'" and "'.$end.'"')
                ->where('pStatus',"WITH CHEQUE");
        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }
    
    
    /*
     * Gets all patients info for Payment For the Month
     * 
     * @author Alingling
     * @param string 06-12-2019
     * 
     */
    

    public function get_monthlyphilhealthpayments($date)
    {
         $monthstart = date("Y-m-01", strtotime($date."-01"));
            $monthend =  date("Y-m-t", strtotime($date."-01"));
               

            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e= new DateTime($monthend);
            $end = $e->format('Y-m-d');
        
       $order_column = array("CSNO,PatientName","hcifee","profee","dischargedate","proc1date","age","pStatus","processdate");
          $this->dweclaims_db->select('CSNO,PatientName,hcifee,profee,dischargedate,proc1date,datediff("'.date('Y-m-d').'",proc1date) as age, pStatus,processdate')
        ->from(masterview_vw)
                 ->where('asof BETWEEN "'.$first.'" and "'.$end.'"')
                ->where('pStatus',"WITH CHEQUE");
          
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->dweclaims_db->group_start()
                    ->like('PatientName', $this->input->post("search")["value"])
                   
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            $this->dweclaims_db->order_by('proc1date','ASC');
        }
    }
    
 
    function make_monthlyphilhealthpayments_datatables($date){  
        $this->get_monthlyphilhealthpayments($date);  
        if($this->input->post("length") != -1)  
        {  
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->dweclaims_db->get();  
        return $query->result();  
    }
    
   
    function get_monthlyphilhealthpayments_filtered_data($date){  
        $this->get_monthlyphilhealthpayments($date);  
        $query = $this->dweclaims_db->get();  
        return $query->num_rows();  
    }
    
    public function get_monthlyphilhealthpayments_data($date)
    {
        $monthstart = date("Y-m-01", strtotime($date."-01"));
        $monthend =  date("Y-m-t", strtotime($date."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $this->dweclaims_db->select('CSNO,PatientName,hcifee,profee,dischargedate,proc1date,datediff("'.date('Y-m-d').'",proc1date) as age, pStatus,processdate')
            ->from(masterview_vw)
            ->where('asof BETWEEN "'.$first.'" and "'.$end.'"')
            ->where('pStatus',"WITH CHEQUE")
            ->order_by('proc1date','ASC');
        return $this->dweclaims_db->count_all_results();
    }
    
    
    public function monthlyPhilhealthPayments($date)
    {
        $monthstart = date("Y-m-01", strtotime($date."-01"));
        $monthend =  date("Y-m-t", strtotime($date."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $this->dweclaims_db->select('sum(hcifee) as hospfee,sum(profee) as profee')
            ->from(masterview_vw)
            ->where('asof BETWEEN "'.$first.'" and "'.$end.'"')
            ->where('pStatus',"WITH CHEQUE");
        
        $query = $this->dweclaims_db->get();  
        return $query->row_array();
    }
    
    /*
     * Gets Profit and Loss Per Month
     * 
     * @author Alingling
     * @param string 06-12-2019
     * 
     */
    public function getProfitandLoss($month,$costcenter)
    {
        $monthend =  date("Y-m-t", strtotime($month."-01"));
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->ams_db->select('sum(case when accttype  = "INCOME" then creditBD else 0 end) getProfit,'
                . 'sum(case when accttype  = "EXPENSE" then debitBD else 0 end) getLoss')
                ->from(sumreport_tbl)
                ->where('effectivedate',$end)
                ->where('Forposting',"1");
                if($costcenter <> ""){
                    $this->ams_db->where('costcenter',$costcenter);
                }
        $query = $this->ams_db->get();
        return $query->row_array();
    }
    
    public function fetchCostCenter()
    {
        $this->ams_db->select('*')
                ->from(costcenter_tbl)
                ->order_by('COSTCNTRNAME','ASC');
        $query = $this->ams_db->get();
        return $query->result_array();
    }
    
    public function getExpenses($month)
    {
        $monthend =  date("Y-m-t", strtotime($month."-01"));
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->ams_db->select('coadscr,sum(debitBD) as debitxx')
                ->from(sumreport_tbl)
                ->where('accttype',"EXPENSE")
                ->where('effectivedate',$end)
                ->where('Forposting',"1")
                ->group_by('coadscr')
                ->order_by('debitxx','DESC');
        $query = $this->ams_db->get();
        return $query->result_array();
    }
    
    public function getPxType($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->db->select('sum(case when pxtype  = "IPD" then 1 else 0 end) getIPD,'
                . 'sum(case when pxtype  = "OPD" then 1 else 0 end) getOPD')
                ->from(inpatient_tbl)
                ->where('dischadate >=',$first)
                ->where('dischadate <=',$end)
                ->where('discharged','1');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function get_inpatient_gender($monthyear,$pxtype)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

        if($pxtype === "ALL")
        {
            $this->db->select('sum(case when sex  = "MALE" or sex = "Male" then 1 else 0 end) getMALE,'
                        . 'sum(case when sex  = "FEMALE" or sex = "Female" then 1 else 0 end) getFEMALE')
                ->from(inpatient_tbl)
                ->where('cityadd !=""')
                ->where('provadd !=""') 
                ->where('roomno !=""') 
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end);
        }
        else
        {
            $this->db->select('sum(case when sex  = "MALE" or sex = "Male" then 1 else 0 end) getMALE,'
                        . 'sum(case when sex  = "FEMALE" or sex = "Female" then 1 else 0 end) getFEMALE')
                ->from(inpatient_tbl)
                ->where('cityadd !=""')
                ->where('provadd !=""') 
                ->where('roomno !=""')     
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$pxtype);
        }
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function get_inpatient_age($monthyear,$pxtype)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

        if($pxtype === "ALL")
        {
            $this->db->select('sum(case when Age  >= 0 and Age <= 3 then 1 else 0 end) getInfant,'
                        . 'sum(case when Age  > 3 and Age <= 11 then 1 else 0 end) getChild,'
                        . 'sum(case when Age  > 11 and Age <= 25 then 1 else 0 end) getYouth,'
                        . 'sum(case when Age  > 25 and Age <= 60 then 1 else 0 end) getAdult,'
                        . 'sum(case when Age  > 60 then 1 else 0 end) getSenior')
                ->from(inpatient_tbl)
                ->where('cityadd !=""')
                ->where('provadd !=""') 
                ->where('roomno !=""') 
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end);
        }
        else
        {
            $this->db->select('sum(case when Age  >= 0 and Age <= 3 then 1 else 0 end) getInfant,'
                        . 'sum(case when Age  > 3 and Age <= 11 then 1 else 0 end) getChild,'
                        . 'sum(case when Age  > 11 and Age <= 25 then 1 else 0 end) getYouth,'
                        . 'sum(case when Age  > 25 and Age <= 60 then 1 else 0 end) getAdult,'
                        . 'sum(case when Age  > 60 then 1 else 0 end) getSenior')
                ->from(inpatient_tbl)
                ->where('cityadd !=""')
                ->where('provadd !=""') 
                ->where('roomno !=""')
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$pxtype);
        }
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function get_inpatient_citymun($monthyear,$pxtype)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($pxtype === "ALL")
        {
            $this->db->select('cityadd, count(cityadd) as "MAX_COUNT"')
                ->from(inpatient_tbl)
                ->group_by('cityadd')
                ->order_by('MAX_COUNT','DESC')
                ->limit(10)
                ->where('cityadd !=""')
                ->where('provadd !=""')
                ->where('roomno !=""')
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end);
        }
        else
        {
            $this->db->select('cityadd, count(cityadd) as "MAX_COUNT"')
                ->from(inpatient_tbl)
                ->group_by('cityadd')
                ->order_by('MAX_COUNT','DESC')
                ->limit(10)
                ->where('cityadd !=""')
                ->where('provadd !=""')
                ->where('roomno !=""')
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$pxtype);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_inpatient_province($monthyear,$pxtype)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($pxtype === "ALL")
        {
            $this->db->select('provadd, count(provadd) as "MAX_COUNT"')
                ->from(inpatient_tbl)
                ->group_by('provadd')
                ->order_by('MAX_COUNT','DESC')
                ->limit(10)
                ->where('cityadd !=""')
                ->where('provadd !=""')
                ->where('roomno !=""')
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end);
        }
        else
        {
            $this->db->select('provadd, count(provadd) as "MAX_COUNT"')
                ->from(inpatient_tbl)
                ->group_by('provadd')
                ->order_by('MAX_COUNT','DESC')
                ->limit(10)
                ->where('cityadd !=""')
                ->where('provadd !=""')
                ->where('roomno !=""')
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$pxtype);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_inpatient_insurance($monthyear,$pxtype)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($pxtype === "ALL")
        {
            $this->db->select('hmoname, count(hmoname) as "MAX_COUNT"')
                ->from(inpatient_tbl)
                ->group_by('hmoname')
                ->order_by('MAX_COUNT','DESC')
                ->limit(10)
                ->where('cityadd !=""')
                ->where('provadd !=""')
                ->where('roomno !=""')
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end);
        }
        else
        {
            $this->db->select('hmoname, count(hmoname) as "MAX_COUNT"')
                ->from(inpatient_tbl)
                ->group_by('hmoname')
                ->order_by('MAX_COUNT','DESC')
                ->limit(10)
                ->where('cityadd !=""')
                ->where('provadd !=""')
                ->where('roomno !=""')
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$pxtype);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_inpatient_room_occupancy_rate($monthyear,$pxtype)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($pxtype === "ALL")
        {
            $this->db->select('roomno, count(roomno) as "MAX_COUNT"')
                ->from(inpatient_tbl)
                ->group_by('roomno')
                ->order_by('MAX_COUNT','DESC')
                ->limit(10)
                ->where('cityadd !=""')
                ->where('provadd !=""')
                ->where('roomno !=""')
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end);
        }
        else
        {
            $this->db->select('roomno, count(roomno) as "MAX_COUNT"')
                ->from(inpatient_tbl)
                ->group_by('roomno')
                ->order_by('MAX_COUNT','DESC')
                ->limit(10)
                ->where('cityadd !=""')
                ->where('provadd !=""')
                ->where('roomno !=""')
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$pxtype);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_laboratory_ledgersales_request_volume($monthyear)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d h:i:s');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d h:i:s');
        
        $this->hlsv2_db
                ->select('sum(case when reqcode  != "" then 1 else 0 end) getLabRequestVolume')
                ->from('ledgersales')
                ->where('reqdate >=',$first)
                ->where('reqdate <=',$end);
        $query = $this->hlsv2_db->get();
        
        return $query->row_array();
    }
    
    public function get_radiology_ledgersales_request_volume($monthyear)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d h:i:s');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d h:i:s');
        
        $this->hrsv2_db
                ->select('sum(case when reqcode  != "" then 1 else 0 end) getRadRequestVolume')
                ->from('ledgersales')
                ->where('reqdate >=',$first)
                ->where('reqdate <=',$end);
        $query = $this->hrsv2_db->get();
        
        return $query->row_array();
    }
    
    public function get_pharmacy_ledgersales_request_volume($monthyear)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d h:i:s');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d h:i:s');
        
        $this->pmsv2_db
                ->select('sum(case when reqref  != "" then 1 else 0 end) getPhaRequestVolume')
                ->from('ledgersales')
                ->where('reqdate >=',$first)
                ->where('reqdate <=',$end);
        $query = $this->pmsv2_db->get();
        
        return $query->row_array();
    }
    
    public function getTotalIncome($month)
    {
        $monthstart = date("Y-m-01", strtotime($month."-01"));
        $monthend =  date("Y-m-t", strtotime($month."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->db->select('sum(drugs) drugin,sum(medsply) medsplyin,sum(pharmisc) pharmiscin,sum(lab) labin,sum(rad) radin,sum(hosp) hospin,
	(sum(ipdpay)+ sum(hmoacct)+ sum(pcsoacct)+ sum(phicacct)+ sum(opdlab)+ sum(opdrad)+ sum(opdhosp) + sum(pnacct) + sum(deliveryphar) + sum(deliverylab) + sum(deliveryrad) + sum(deliveryhosp))otherincome')
                ->from(dailytransaction_tbl)
                ->where('transdate >=',$first)
                ->where('transdate <=',$end);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getProfitOrLoss($type,$month,$costcenter)
    {
        $monthend =  date("Y-m-t", strtotime($month."-01"));
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($type== "PROFIT")
        {
            $order_column = array("COAcode","coadscr","creditBD","costcenter");
            $this->ams_db->select("sumreport.COAcode,sumreport.coadscr,sumreport.creditBD,sumreport.costcenter,costcenter.COSTCNTRNAME")
                ->from(sumreport_tbl)
                ->join('costcenter', 'sumreport.costcenter= costcenter.COSTCNTRCODE')
                ->where('sumreport.accttype','INCOME')
                ->where('sumreport.effectivedate',$end)
                ->where('sumreport.Forposting',"1");
                if($costcenter <> ""){
                    $this->ams_db->where('sumreport.costcenter',$costcenter);
                }
        }else{
            $order_column = array("COAcode","coadscr","debitBD","costcenter");
            $this->ams_db->select("sumreport.COAcode,sumreport.coadscr,sumreport.debitBD,sumreport.costcenter,costcenter.COSTCNTRNAME")
                ->from(sumreport_tbl)
                ->join('costcenter', 'sumreport.costcenter= costcenter.COSTCNTRCODE')
                ->where('sumreport.accttype','EXPENSE')
                ->where('sumreport.effectivedate',$end)
                ->where('sumreport.Forposting',"1");
                if($costcenter <> ""){
                    $this->ams_db->where('sumreport.costcenter',$costcenter);
                }
        }
      
          
        if(!empty($this->input->post("search")["value"]))  
        {  
            $this->ams_db->group_start()
                    ->like('sumreport.COAcode', $this->input->post("search")["value"])
                    ->or_like('sumreport.coadscr', $this->input->post("search")["value"])
                    ->or_like('costcenter.COSTCNTRNAME', $this->input->post("search")["value"])
                   
            ->group_end();
        }  
        
        if(!empty($this->input->post("order")))  
        {  
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
        }  
        else  
        {  
            if($type== "PROFIT")
            {
                $this->ams_db->order_by('creditBD','DESC');
            }else{
                $this->ams_db->order_by('debitBD','DESC');
            }
        }
    }
    
 
    function make_ProfitOrLoss_datatables($type,$month,$costcenter){  
        $this->getProfitOrLoss($type,$month,$costcenter);  
        if($this->input->post("length") != -1)  
        {  
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));  
        }
        $query = $this->ams_db->get();  
        return $query->result();  
    }
    
   
    function getProfitOrLoss_filtered_data($type,$month,$costcenter){  
        $this->getProfitOrLoss($type,$month,$costcenter);  
        $query = $this->ams_db->get();  
        return $query->num_rows();  
    }
    
    public function getProfitOrLoss_data($type,$month,$costcenter)
    {
        $monthend =  date("Y-m-t", strtotime($month."-01"));
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($type== "PROFIT")
        {
            $order_column = array("COAcode","coadscr","creditBD","costcenter");
             $this->ams_db->select("sumreport.COAcode,sumreport.coadscr,sumreport.creditBD,sumreport.costcenter,costcenter.COSTCNTRNAME")
                ->from(sumreport_tbl)
                ->join('costcenter', 'sumreport.costcenter= costcenter.COSTCNTRCODE')
                ->where('sumreport.accttype','INCOME')
                ->where('sumreport.effectivedate',$end)
                ->where('sumreport.Forposting',"1");
                if($costcenter <> ""){
                    $this->ams_db->where('sumreport.costcenter',$costcenter);
                }
                $this->ams_db->order_by('creditBD','DESC');
        }else{
            $order_column = array("COAcode","coadscr","debitBD","costcenter");
             $this->ams_db->select("sumreport.COAcode,sumreport.coadscr,sumreport.debitBD,sumreport.costcenter,costcenter.COSTCNTRNAME")
              ->from(sumreport_tbl)
                ->join('costcenter', 'sumreport.costcenter= costcenter.COSTCNTRCODE')
                ->where('sumreport.accttype','EXPENSE')
                ->where('sumreport.effectivedate',$end)
                ->where('sumreport.Forposting',"1");
                if($costcenter <> ""){
                    $this->ams_db->where('sumreport.costcenter',$costcenter);
                }
                $this->ams_db->order_by('debitBD','DESC');
        }
        return $this->ams_db->count_all_results();
    }
    
    public function fetch_inpatients_masterlist_data($cityname, $fulldate, $pxtype) 
    {
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($cityname === "ALL CITY/MUNICIPALITY")
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd', $cityname)
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd', $cityname)
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
            
        return $this->hospv2_db->count_all_results();
    }

    public function fetch_inpatients_masterlist_filtered_data($cityname, $fulldate, $pxtype) 
    {
        $this->fetch_inpatients_masterlist($cityname, $fulldate, $pxtype);

        $query = $this->hospv2_db->get();
        return $query->num_rows();
    }

    public function fetch_inpatients_masterlist($cityname, $fulldate, $pxtype) 
    {
        $order_column = array
        (
            "id","pxtype","opdtype","casetype","admittype","logbookCN","logbookPIN",
            "HRnCODE","billingcprecipient","lasttextsent","lasttransactionsent","vip",
            "pincode","casecode","caseyr","caseseq","caseno","memberrefno","membercardno",
            "ledgerfile","pinyr","pinseq","PIN","pinformat","lname","fname","mname","suffix",
            "name","hideinfo","spouse","spousebday","sex","bday","Age","Weight","packageCODE",
            "nationality","passportno","guarantor","guarantor_rltn","guarantor_mobileno",
            "guarantor_bday","adrs","brgy","cityadd","provadd","zipcode","civilstatus",
            "contactno","mobileno","email","religion","father","fatheradrs","fathernationality",
            "mother","motheradrs","mothernationality","updated","doctorid","doctorname","nurseid",
            "nursename","hmoid","hmoname","hmoholder","hmonumber","hmoapprovalno","archived",
            "lastadmitdate","archiveddate","lastadmittime","lastdischdate","lastdischtime","pat_clascode",
            "pat_classub","pat_classification","recid","recby","station","admitdate","admittime",
            "tagfordischa","tagfordischaDT","dischadate","dischatime","dischaid","dischaby","discharged",
            "daysconfined","disposition","expireddate","expiredtime","ReferredFromHCI","TransRefHCI",
            "reasonforreferral","roomref","roomcd","roomtype","roomno","roombed","roominfo","roombrief",
            "roomdate","roomtime","roomrate","PRICEPACKAGE","rmrateschm","RmPHICtype","creditmax",
            "addonserv","phiccode","phicmembr","phicdependent","phicPIN","phicmembrname","relationtomember",
            "phiccasefirst","phiccasefirstRefno","phiccasefirstDx","phiccasesecond","phiccasesecondRefno",
            "phiccasesecondDx","phicHCItotal","PHICpfTotal","PHICrmtype","dietarycd","diatary_ins",
            "dietstatus","Diag_chiefcomplain","Diag_admit","Diag_discharge","Diag_discharge_updatedby",
            "Diag_discharge_updatedDT","Diag_surg_ref","Diag_surg","Diag_surgICD","Diag_surg_type",
            "Diag_anes_ref","Diag_anes","Diag_anesICD","ICD10","icdcasetype","flagme","suprvid","suprvby",
            "clearedid","clearedby","clearedtd","clearedat","Quikadmit","patfile","imagefile","mypix",
            "nursestation","phicpapers","phicclearby","phicdeductions","phicnote","printedby","printeddate",
            "billingnote","nobillingdischarged","nbdhospamount","nbddocamount","GrossHospAmt","GrossDocAmt",
            "GrandTotalBill","phic1caseHCIrecommend","phic2caseHCIrecommend","phic1caseDOCrecommend",
            "phic2caseDOCrecommend","DiscountPHIChosp","DiscountPHICdoc","DiscountHosp","DiscountHospDoc",
            "DiscountHMOHosp","DiscountHMODoc","DiscountSrHosp","DiscountSrDoc","DiscountVATHosp","DiscountVATDoc",
            "PNrefno","PNduedate","PNamount","PNBalance","PNlastupdate","PNlastRefno","PNby","PNAddress1",
            "PNaddress2","PNbyCellnumber","OBprocedure","dischargedsameday","dischargein48","deliverycausesofdeaths",
            "deathtype","HAIcase_deviceinfection","HAIcasedays","HAIVAPinfection","HAIVAPdays","HAIBSIinfection",
            "HAIBSIdays","HAIUTIinfection","HAIUTIdays","HAIcase_nonedeviceinfection","HAInonecasedays",
            "HAISSInoneinfection","HAISSIdays","admissionsource","phicclaimrefno","phicclaimstatus","pcsoamount",
            "pcsorefcode","pcsogrant","hmoclaimrefno","hmopapers","hmodeductions","hmoclaimstatus","hmoclaimeddate",
            "hmoclaimedamount","hmobalance","hmovoucherdate","hmovoucherno","hmovoucheramount","needdeposit",
            "advisedeposit","InqBal","NeedDepoamt","phiccf2prepby","phiccf2updated","Phiccf2done","ReqPHICmdrno",
            "ReqPHICmdrweb","ReqPHICspouse","ReqPHICChild","ReqPHICOFW","ReqPHICparent","cashierpaid","cashiername",
            "cashierbatchrefno","cashierDT","verifiedby","verifiedadmission","verifieddatetime","medcertrefno",
            "patientnickname","Birthcertrefno","medicolegalrefno","diagnosisdone","archivedby","restoreddate",
            "restored","restoredby","cautions","MedicoLegalReference","minorOR","NurseInchargeID","NurseIncharge",
            "TBstatus","patientisNBB","hascateg","phicmemberverified","otherdiag","nursedischadate","nursedischatime",
            "TICKETCODE","TICKETDATE","TICKETBY","postedby","postingdate","pxgroup","slcode","lmp","antenatal","postnatal"
        );
        
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($cityname === "ALL CITY/MUNICIPALITY")
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd', $cityname)
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd', $cityname)
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
            

        if (!empty($this->input->post("search")["value"]))
        {
            $this->hospv2_db
                    ->group_start()
                    ->like('name', $this->input->post("search")["value"])  
                    ->or_like('caseno', $this->input->post("search")["value"])  
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) 
        { 
            $this->hospv2_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']); 
        } 
        else 
        {
            $this->hospv2_db->order_by('name', 'ASC'); 
        }
    }

    public function fetch_inpatients_masterlist_datatables($cityname, $fulldate, $pxtype) 
    {
        $this->fetch_inpatients_masterlist($cityname, $fulldate, $pxtype); 

        if ($this->input->post("length") != -1)
        {
            $this->hospv2_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hospv2_db->get();
        return $query->result();
    }
    
    public function fetch_inpatients_others_masterlist_data($citynames, $fulldate, $pxtype) 
    {
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $explodecitynames = explode("|", $citynames);
        $countexplodecityname = count($explodecitynames);

        if($countexplodecityname === 10)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('cityadd !=', $explodecitynames[8])
                    ->where('cityadd !=', $explodecitynames[9])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('cityadd !=', $explodecitynames[8])
                    ->where('cityadd !=', $explodecitynames[9])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodecityname === 9)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('cityadd !=', $explodecitynames[8])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('cityadd !=', $explodecitynames[8])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodecityname === 8)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodecityname === 7)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodecityname === 6)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodecityname === 5)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodecityname === 4)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodecityname === 3)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodecityname === 2)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodecityname === 1)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        
        return $this->hospv2_db->count_all_results();
    }

    public function fetch_inpatients_others_masterlist_filtered_data($citynames, $fulldate, $pxtype) 
    {
        $this->fetch_inpatients_others_masterlist($citynames, $fulldate, $pxtype);

        $query = $this->hospv2_db->get();
        return $query->num_rows();
    }

    public function fetch_inpatients_others_masterlist($citynames, $fulldate, $pxtype) 
    {
        $order_column = array
        (
            "id","pxtype","opdtype","casetype","admittype","logbookCN","logbookPIN",
            "HRnCODE","billingcprecipient","lasttextsent","lasttransactionsent","vip",
            "pincode","casecode","caseyr","caseseq","caseno","memberrefno","membercardno",
            "ledgerfile","pinyr","pinseq","PIN","pinformat","lname","fname","mname","suffix",
            "name","hideinfo","spouse","spousebday","sex","bday","Age","Weight","packageCODE",
            "nationality","passportno","guarantor","guarantor_rltn","guarantor_mobileno",
            "guarantor_bday","adrs","brgy","cityadd","provadd","zipcode","civilstatus",
            "contactno","mobileno","email","religion","father","fatheradrs","fathernationality",
            "mother","motheradrs","mothernationality","updated","doctorid","doctorname","nurseid",
            "nursename","hmoid","hmoname","hmoholder","hmonumber","hmoapprovalno","archived",
            "lastadmitdate","archiveddate","lastadmittime","lastdischdate","lastdischtime","pat_clascode",
            "pat_classub","pat_classification","recid","recby","station","admitdate","admittime",
            "tagfordischa","tagfordischaDT","dischadate","dischatime","dischaid","dischaby","discharged",
            "daysconfined","disposition","expireddate","expiredtime","ReferredFromHCI","TransRefHCI",
            "reasonforreferral","roomref","roomcd","roomtype","roomno","roombed","roominfo","roombrief",
            "roomdate","roomtime","roomrate","PRICEPACKAGE","rmrateschm","RmPHICtype","creditmax",
            "addonserv","phiccode","phicmembr","phicdependent","phicPIN","phicmembrname","relationtomember",
            "phiccasefirst","phiccasefirstRefno","phiccasefirstDx","phiccasesecond","phiccasesecondRefno",
            "phiccasesecondDx","phicHCItotal","PHICpfTotal","PHICrmtype","dietarycd","diatary_ins",
            "dietstatus","Diag_chiefcomplain","Diag_admit","Diag_discharge","Diag_discharge_updatedby",
            "Diag_discharge_updatedDT","Diag_surg_ref","Diag_surg","Diag_surgICD","Diag_surg_type",
            "Diag_anes_ref","Diag_anes","Diag_anesICD","ICD10","icdcasetype","flagme","suprvid","suprvby",
            "clearedid","clearedby","clearedtd","clearedat","Quikadmit","patfile","imagefile","mypix",
            "nursestation","phicpapers","phicclearby","phicdeductions","phicnote","printedby","printeddate",
            "billingnote","nobillingdischarged","nbdhospamount","nbddocamount","GrossHospAmt","GrossDocAmt",
            "GrandTotalBill","phic1caseHCIrecommend","phic2caseHCIrecommend","phic1caseDOCrecommend",
            "phic2caseDOCrecommend","DiscountPHIChosp","DiscountPHICdoc","DiscountHosp","DiscountHospDoc",
            "DiscountHMOHosp","DiscountHMODoc","DiscountSrHosp","DiscountSrDoc","DiscountVATHosp","DiscountVATDoc",
            "PNrefno","PNduedate","PNamount","PNBalance","PNlastupdate","PNlastRefno","PNby","PNAddress1",
            "PNaddress2","PNbyCellnumber","OBprocedure","dischargedsameday","dischargein48","deliverycausesofdeaths",
            "deathtype","HAIcase_deviceinfection","HAIcasedays","HAIVAPinfection","HAIVAPdays","HAIBSIinfection",
            "HAIBSIdays","HAIUTIinfection","HAIUTIdays","HAIcase_nonedeviceinfection","HAInonecasedays",
            "HAISSInoneinfection","HAISSIdays","admissionsource","phicclaimrefno","phicclaimstatus","pcsoamount",
            "pcsorefcode","pcsogrant","hmoclaimrefno","hmopapers","hmodeductions","hmoclaimstatus","hmoclaimeddate",
            "hmoclaimedamount","hmobalance","hmovoucherdate","hmovoucherno","hmovoucheramount","needdeposit",
            "advisedeposit","InqBal","NeedDepoamt","phiccf2prepby","phiccf2updated","Phiccf2done","ReqPHICmdrno",
            "ReqPHICmdrweb","ReqPHICspouse","ReqPHICChild","ReqPHICOFW","ReqPHICparent","cashierpaid","cashiername",
            "cashierbatchrefno","cashierDT","verifiedby","verifiedadmission","verifieddatetime","medcertrefno",
            "patientnickname","Birthcertrefno","medicolegalrefno","diagnosisdone","archivedby","restoreddate",
            "restored","restoredby","cautions","MedicoLegalReference","minorOR","NurseInchargeID","NurseIncharge",
            "TBstatus","patientisNBB","hascateg","phicmemberverified","otherdiag","nursedischadate","nursedischatime",
            "TICKETCODE","TICKETDATE","TICKETBY","postedby","postingdate","pxgroup","slcode","lmp","antenatal","postnatal"
        );
        
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $explodecitynames = explode("|", $citynames);
        $countexplodecityname = count($explodecitynames);

        if($countexplodecityname === 10)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('cityadd !=', $explodecitynames[8])
                    ->where('cityadd !=', $explodecitynames[9])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('cityadd !=', $explodecitynames[8])
                    ->where('cityadd !=', $explodecitynames[9])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 9)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('cityadd !=', $explodecitynames[8])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('cityadd !=', $explodecitynames[8])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 8)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 7)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 6)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 5)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 4)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 3)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 2)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 1)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }

        if (!empty($this->input->post("search")["value"]))
        {
            $this->hospv2_db
                    ->group_start()
                    ->like('name', $this->input->post("search")["value"])  
                    ->or_like('caseno', $this->input->post("search")["value"])  
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) 
        { 
            $this->hospv2_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']); 
        } 
        else 
        {
            $this->hospv2_db->order_by('name', 'ASC'); 
        }
    }

    public function fetch_inpatients_others_masterlist_datatables($cityname, $fulldate, $pxtype) 
    {
        $this->fetch_inpatients_others_masterlist($cityname, $fulldate, $pxtype); 

        if ($this->input->post("length") != -1)
        {
            $this->hospv2_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hospv2_db->get();
        return $query->result();
    }
    
    public function fetch_inpatients_provadd_others_masterlist_data($provnames, $fulldate, $pxtype) 
    {
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $explodeprovnames = explode("|", $provnames);
        $countexplodeprovname = count($explodeprovnames);

        if($countexplodeprovname === 10)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('provadd !=', $explodeprovnames[8])
                    ->where('provadd !=', $explodeprovnames[9])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('provadd !=', $explodeprovnames[8])
                    ->where('provadd !=', $explodeprovnames[9])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodeprovname === 9)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('provadd !=', $explodeprovnames[8])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('provadd !=', $explodeprovnames[8])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodeprovname === 8)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodeprovname === 7)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodeprovname === 6)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodeprovname === 5)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodeprovname === 4)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodeprovname === 3)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodeprovname === 2)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodeprovname === 1)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        
        return $this->hospv2_db->count_all_results();
    }

    public function fetch_inpatients_provadd_others_masterlist_filtered_data($provnames, $fulldate, $pxtype) 
    {
        $this->fetch_inpatients_provadd_others_masterlist($provnames, $fulldate, $pxtype);

        $query = $this->hospv2_db->get();
        return $query->num_rows();
    }

    public function fetch_inpatients_provadd_others_masterlist($provnames, $fulldate, $pxtype) 
    {
        $order_column = array
        (
            "id","pxtype","opdtype","casetype","admittype","logbookCN","logbookPIN",
            "HRnCODE","billingcprecipient","lasttextsent","lasttransactionsent","vip",
            "pincode","casecode","caseyr","caseseq","caseno","memberrefno","membercardno",
            "ledgerfile","pinyr","pinseq","PIN","pinformat","lname","fname","mname","suffix",
            "name","hideinfo","spouse","spousebday","sex","bday","Age","Weight","packageCODE",
            "nationality","passportno","guarantor","guarantor_rltn","guarantor_mobileno",
            "guarantor_bday","adrs","brgy","cityadd","provadd","zipcode","civilstatus",
            "contactno","mobileno","email","religion","father","fatheradrs","fathernationality",
            "mother","motheradrs","mothernationality","updated","doctorid","doctorname","nurseid",
            "nursename","hmoid","hmoname","hmoholder","hmonumber","hmoapprovalno","archived",
            "lastadmitdate","archiveddate","lastadmittime","lastdischdate","lastdischtime","pat_clascode",
            "pat_classub","pat_classification","recid","recby","station","admitdate","admittime",
            "tagfordischa","tagfordischaDT","dischadate","dischatime","dischaid","dischaby","discharged",
            "daysconfined","disposition","expireddate","expiredtime","ReferredFromHCI","TransRefHCI",
            "reasonforreferral","roomref","roomcd","roomtype","roomno","roombed","roominfo","roombrief",
            "roomdate","roomtime","roomrate","PRICEPACKAGE","rmrateschm","RmPHICtype","creditmax",
            "addonserv","phiccode","phicmembr","phicdependent","phicPIN","phicmembrname","relationtomember",
            "phiccasefirst","phiccasefirstRefno","phiccasefirstDx","phiccasesecond","phiccasesecondRefno",
            "phiccasesecondDx","phicHCItotal","PHICpfTotal","PHICrmtype","dietarycd","diatary_ins",
            "dietstatus","Diag_chiefcomplain","Diag_admit","Diag_discharge","Diag_discharge_updatedby",
            "Diag_discharge_updatedDT","Diag_surg_ref","Diag_surg","Diag_surgICD","Diag_surg_type",
            "Diag_anes_ref","Diag_anes","Diag_anesICD","ICD10","icdcasetype","flagme","suprvid","suprvby",
            "clearedid","clearedby","clearedtd","clearedat","Quikadmit","patfile","imagefile","mypix",
            "nursestation","phicpapers","phicclearby","phicdeductions","phicnote","printedby","printeddate",
            "billingnote","nobillingdischarged","nbdhospamount","nbddocamount","GrossHospAmt","GrossDocAmt",
            "GrandTotalBill","phic1caseHCIrecommend","phic2caseHCIrecommend","phic1caseDOCrecommend",
            "phic2caseDOCrecommend","DiscountPHIChosp","DiscountPHICdoc","DiscountHosp","DiscountHospDoc",
            "DiscountHMOHosp","DiscountHMODoc","DiscountSrHosp","DiscountSrDoc","DiscountVATHosp","DiscountVATDoc",
            "PNrefno","PNduedate","PNamount","PNBalance","PNlastupdate","PNlastRefno","PNby","PNAddress1",
            "PNaddress2","PNbyCellnumber","OBprocedure","dischargedsameday","dischargein48","deliverycausesofdeaths",
            "deathtype","HAIcase_deviceinfection","HAIcasedays","HAIVAPinfection","HAIVAPdays","HAIBSIinfection",
            "HAIBSIdays","HAIUTIinfection","HAIUTIdays","HAIcase_nonedeviceinfection","HAInonecasedays",
            "HAISSInoneinfection","HAISSIdays","admissionsource","phicclaimrefno","phicclaimstatus","pcsoamount",
            "pcsorefcode","pcsogrant","hmoclaimrefno","hmopapers","hmodeductions","hmoclaimstatus","hmoclaimeddate",
            "hmoclaimedamount","hmobalance","hmovoucherdate","hmovoucherno","hmovoucheramount","needdeposit",
            "advisedeposit","InqBal","NeedDepoamt","phiccf2prepby","phiccf2updated","Phiccf2done","ReqPHICmdrno",
            "ReqPHICmdrweb","ReqPHICspouse","ReqPHICChild","ReqPHICOFW","ReqPHICparent","cashierpaid","cashiername",
            "cashierbatchrefno","cashierDT","verifiedby","verifiedadmission","verifieddatetime","medcertrefno",
            "patientnickname","Birthcertrefno","medicolegalrefno","diagnosisdone","archivedby","restoreddate",
            "restored","restoredby","cautions","MedicoLegalReference","minorOR","NurseInchargeID","NurseIncharge",
            "TBstatus","patientisNBB","hascateg","phicmemberverified","otherdiag","nursedischadate","nursedischatime",
            "TICKETCODE","TICKETDATE","TICKETBY","postedby","postingdate","pxgroup","slcode","lmp","antenatal","postnatal"
        );
        
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $explodeprovnames = explode("|", $provnames);
        $countexplodeprovnames = count($explodeprovnames);

        if($countexplodeprovnames === 10)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('provadd !=', $explodeprovnames[8])
                    ->where('provadd !=', $explodeprovnames[9])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('provadd !=', $explodeprovnames[8])
                    ->where('provadd !=', $explodeprovnames[9])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 9)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('provadd !=', $explodeprovnames[8])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('provadd !=', $explodeprovnames[8])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 8)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 7)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 6)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 5)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 4)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 3)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 2)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 1)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }

        if (!empty($this->input->post("search")["value"]))
        {
            $this->hospv2_db
                    ->group_start()
                    ->like('name', $this->input->post("search")["value"])  
                    ->or_like('caseno', $this->input->post("search")["value"])  
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) 
        { 
            $this->hospv2_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']); 
        } 
        else 
        {
            $this->hospv2_db->order_by('name', 'ASC'); 
        }
    }

    public function fetch_inpatients_provadd_others_masterlist_datatables($provnames, $fulldate, $pxtype) 
    {
        $this->fetch_inpatients_provadd_others_masterlist($provnames, $fulldate, $pxtype); 

        if ($this->input->post("length") != -1)
        {
            $this->hospv2_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hospv2_db->get();
        return $query->result();
    }
    
    
    
    
    
    
    
    
    
    public function fetch_inpatients_insurance_others_masterlist_data($hmonames, $fulldate, $pxtype) 
    {
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $explodehmonames = explode("|", $hmonames);
        $countexplodehmoname = count($explodehmonames);

        if($countexplodehmoname === 10)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('hmoname !=', $explodehmonames[8])
                    ->where('hmoname !=', $explodehmonames[9])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('hmoname !=', $explodehmonames[8])
                    ->where('hmoname !=', $explodehmonames[9])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodehmoname === 9)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('hmoname !=', $explodehmonames[8])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('hmoname !=', $explodehmonames[8])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodehmoname === 8)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodehmoname === 7)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodehmoname === 6)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodehmoname === 5)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodehmoname === 4)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodehmoname === 3)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodehmoname === 2)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexplodehmoname === 1)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        
        return $this->hospv2_db->count_all_results();
    }

    public function fetch_inpatients_insurance_others_masterlist_filtered_data($hmonames, $fulldate, $pxtype) 
    {
        $this->fetch_inpatients_insurance_others_masterlist($hmonames, $fulldate, $pxtype);

        $query = $this->hospv2_db->get();
        return $query->num_rows();
    }

    public function fetch_inpatients_insurance_others_masterlist($hmonames, $fulldate, $pxtype) 
    {
        $order_column = array
        (
            "id","pxtype","opdtype","casetype","admittype","logbookCN","logbookPIN",
            "HRnCODE","billingcprecipient","lasttextsent","lasttransactionsent","vip",
            "pincode","casecode","caseyr","caseseq","caseno","memberrefno","membercardno",
            "ledgerfile","pinyr","pinseq","PIN","pinformat","lname","fname","mname","suffix",
            "name","hideinfo","spouse","spousebday","sex","bday","Age","Weight","packageCODE",
            "nationality","passportno","guarantor","guarantor_rltn","guarantor_mobileno",
            "guarantor_bday","adrs","brgy","cityadd","provadd","zipcode","civilstatus",
            "contactno","mobileno","email","religion","father","fatheradrs","fathernationality",
            "mother","motheradrs","mothernationality","updated","doctorid","doctorname","nurseid",
            "nursename","hmoid","hmoname","hmoholder","hmonumber","hmoapprovalno","archived",
            "lastadmitdate","archiveddate","lastadmittime","lastdischdate","lastdischtime","pat_clascode",
            "pat_classub","pat_classification","recid","recby","station","admitdate","admittime",
            "tagfordischa","tagfordischaDT","dischadate","dischatime","dischaid","dischaby","discharged",
            "daysconfined","disposition","expireddate","expiredtime","ReferredFromHCI","TransRefHCI",
            "reasonforreferral","roomref","roomcd","roomtype","roomno","roombed","roominfo","roombrief",
            "roomdate","roomtime","roomrate","PRICEPACKAGE","rmrateschm","RmPHICtype","creditmax",
            "addonserv","phiccode","phicmembr","phicdependent","phicPIN","phicmembrname","relationtomember",
            "phiccasefirst","phiccasefirstRefno","phiccasefirstDx","phiccasesecond","phiccasesecondRefno",
            "phiccasesecondDx","phicHCItotal","PHICpfTotal","PHICrmtype","dietarycd","diatary_ins",
            "dietstatus","Diag_chiefcomplain","Diag_admit","Diag_discharge","Diag_discharge_updatedby",
            "Diag_discharge_updatedDT","Diag_surg_ref","Diag_surg","Diag_surgICD","Diag_surg_type",
            "Diag_anes_ref","Diag_anes","Diag_anesICD","ICD10","icdcasetype","flagme","suprvid","suprvby",
            "clearedid","clearedby","clearedtd","clearedat","Quikadmit","patfile","imagefile","mypix",
            "nursestation","phicpapers","phicclearby","phicdeductions","phicnote","printedby","printeddate",
            "billingnote","nobillingdischarged","nbdhospamount","nbddocamount","GrossHospAmt","GrossDocAmt",
            "GrandTotalBill","phic1caseHCIrecommend","phic2caseHCIrecommend","phic1caseDOCrecommend",
            "phic2caseDOCrecommend","DiscountPHIChosp","DiscountPHICdoc","DiscountHosp","DiscountHospDoc",
            "DiscountHMOHosp","DiscountHMODoc","DiscountSrHosp","DiscountSrDoc","DiscountVATHosp","DiscountVATDoc",
            "PNrefno","PNduedate","PNamount","PNBalance","PNlastupdate","PNlastRefno","PNby","PNAddress1",
            "PNaddress2","PNbyCellnumber","OBprocedure","dischargedsameday","dischargein48","deliverycausesofdeaths",
            "deathtype","HAIcase_deviceinfection","HAIcasedays","HAIVAPinfection","HAIVAPdays","HAIBSIinfection",
            "HAIBSIdays","HAIUTIinfection","HAIUTIdays","HAIcase_nonedeviceinfection","HAInonecasedays",
            "HAISSInoneinfection","HAISSIdays","admissionsource","phicclaimrefno","phicclaimstatus","pcsoamount",
            "pcsorefcode","pcsogrant","hmoclaimrefno","hmopapers","hmodeductions","hmoclaimstatus","hmoclaimeddate",
            "hmoclaimedamount","hmobalance","hmovoucherdate","hmovoucherno","hmovoucheramount","needdeposit",
            "advisedeposit","InqBal","NeedDepoamt","phiccf2prepby","phiccf2updated","Phiccf2done","ReqPHICmdrno",
            "ReqPHICmdrweb","ReqPHICspouse","ReqPHICChild","ReqPHICOFW","ReqPHICparent","cashierpaid","cashiername",
            "cashierbatchrefno","cashierDT","verifiedby","verifiedadmission","verifieddatetime","medcertrefno",
            "patientnickname","Birthcertrefno","medicolegalrefno","diagnosisdone","archivedby","restoreddate",
            "restored","restoredby","cautions","MedicoLegalReference","minorOR","NurseInchargeID","NurseIncharge",
            "TBstatus","patientisNBB","hascateg","phicmemberverified","otherdiag","nursedischadate","nursedischatime",
            "TICKETCODE","TICKETDATE","TICKETBY","postedby","postingdate","pxgroup","slcode","lmp","antenatal","postnatal"
        );
        
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $explodehmonames = explode("|", $hmonames);
        $countexplodehmonames = count($explodehmonames);

        if($countexplodehmonames === 10)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('hmoname !=', $explodehmonames[8])
                    ->where('hmoname !=', $explodehmonames[9])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('hmoname !=', $explodehmonames[8])
                    ->where('hmoname !=', $explodehmonames[9])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 9)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('hmoname !=', $explodehmonames[8])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('hmoname !=', $explodehmonames[8])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 8)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 7)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 6)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 5)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 4)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 3)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 2)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 1)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }

        if (!empty($this->input->post("search")["value"]))
        {
            $this->hospv2_db
                    ->group_start()
                    ->like('name', $this->input->post("search")["value"])  
                    ->or_like('caseno', $this->input->post("search")["value"])  
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) 
        { 
            $this->hospv2_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']); 
        } 
        else 
        {
            $this->hospv2_db->order_by('name', 'ASC'); 
        }
    }

    public function fetch_inpatients_insurance_others_masterlist_datatables($hmonames, $fulldate, $pxtype) 
    {
        $this->fetch_inpatients_insurance_others_masterlist($hmonames, $fulldate, $pxtype); 

        if ($this->input->post("length") != -1)
        {
            $this->hospv2_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hospv2_db->get();
        return $query->result();
    }
    
    
    
    
    
    
    
    
    
    public function fetch_inpatients_roomrate_others_masterlist_data($roomnames, $fulldate, $pxtype) 
    {
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $exploderoomnames = explode("|", $roomnames);
        $countexploderoomnames = count($exploderoomnames);

        if($countexploderoomnames === 10)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('roomno !=', $exploderoomnames[8])
                    ->where('roomno !=', $exploderoomnames[9])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('roomno !=', $exploderoomnames[8])
                    ->where('roomno !=', $exploderoomnames[9])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexploderoomnames === 9)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('roomno !=', $exploderoomnames[8])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('roomno !=', $exploderoomnames[8])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexploderoomnames === 8)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexploderoomnames === 7)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexploderoomnames === 6)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexploderoomnames === 5)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexploderoomnames === 4)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexploderoomnames === 3)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexploderoomnames === 2)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        else if($countexploderoomnames === 1)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype)
                    ->limit(100);
            }
        }
        
        return $this->hospv2_db->count_all_results();
    }

    public function fetch_inpatients_roomrate_others_masterlist_filtered_data($roomnames, $fulldate, $pxtype) 
    {
        $this->fetch_inpatients_provadd_others_masterlist($roomnames, $fulldate, $pxtype);

        $query = $this->hospv2_db->get();
        return $query->num_rows();
    }

    public function fetch_inpatients_roomrate_others_masterlist($roomnames, $fulldate, $pxtype) 
    {
        $order_column = array
        (
            "id","pxtype","opdtype","casetype","admittype","logbookCN","logbookPIN",
            "HRnCODE","billingcprecipient","lasttextsent","lasttransactionsent","vip",
            "pincode","casecode","caseyr","caseseq","caseno","memberrefno","membercardno",
            "ledgerfile","pinyr","pinseq","PIN","pinformat","lname","fname","mname","suffix",
            "name","hideinfo","spouse","spousebday","sex","bday","Age","Weight","packageCODE",
            "nationality","passportno","guarantor","guarantor_rltn","guarantor_mobileno",
            "guarantor_bday","adrs","brgy","cityadd","provadd","zipcode","civilstatus",
            "contactno","mobileno","email","religion","father","fatheradrs","fathernationality",
            "mother","motheradrs","mothernationality","updated","doctorid","doctorname","nurseid",
            "nursename","hmoid","hmoname","hmoholder","hmonumber","hmoapprovalno","archived",
            "lastadmitdate","archiveddate","lastadmittime","lastdischdate","lastdischtime","pat_clascode",
            "pat_classub","pat_classification","recid","recby","station","admitdate","admittime",
            "tagfordischa","tagfordischaDT","dischadate","dischatime","dischaid","dischaby","discharged",
            "daysconfined","disposition","expireddate","expiredtime","ReferredFromHCI","TransRefHCI",
            "reasonforreferral","roomref","roomcd","roomtype","roomno","roombed","roominfo","roombrief",
            "roomdate","roomtime","roomrate","PRICEPACKAGE","rmrateschm","RmPHICtype","creditmax",
            "addonserv","phiccode","phicmembr","phicdependent","phicPIN","phicmembrname","relationtomember",
            "phiccasefirst","phiccasefirstRefno","phiccasefirstDx","phiccasesecond","phiccasesecondRefno",
            "phiccasesecondDx","phicHCItotal","PHICpfTotal","PHICrmtype","dietarycd","diatary_ins",
            "dietstatus","Diag_chiefcomplain","Diag_admit","Diag_discharge","Diag_discharge_updatedby",
            "Diag_discharge_updatedDT","Diag_surg_ref","Diag_surg","Diag_surgICD","Diag_surg_type",
            "Diag_anes_ref","Diag_anes","Diag_anesICD","ICD10","icdcasetype","flagme","suprvid","suprvby",
            "clearedid","clearedby","clearedtd","clearedat","Quikadmit","patfile","imagefile","mypix",
            "nursestation","phicpapers","phicclearby","phicdeductions","phicnote","printedby","printeddate",
            "billingnote","nobillingdischarged","nbdhospamount","nbddocamount","GrossHospAmt","GrossDocAmt",
            "GrandTotalBill","phic1caseHCIrecommend","phic2caseHCIrecommend","phic1caseDOCrecommend",
            "phic2caseDOCrecommend","DiscountPHIChosp","DiscountPHICdoc","DiscountHosp","DiscountHospDoc",
            "DiscountHMOHosp","DiscountHMODoc","DiscountSrHosp","DiscountSrDoc","DiscountVATHosp","DiscountVATDoc",
            "PNrefno","PNduedate","PNamount","PNBalance","PNlastupdate","PNlastRefno","PNby","PNAddress1",
            "PNaddress2","PNbyCellnumber","OBprocedure","dischargedsameday","dischargein48","deliverycausesofdeaths",
            "deathtype","HAIcase_deviceinfection","HAIcasedays","HAIVAPinfection","HAIVAPdays","HAIBSIinfection",
            "HAIBSIdays","HAIUTIinfection","HAIUTIdays","HAIcase_nonedeviceinfection","HAInonecasedays",
            "HAISSInoneinfection","HAISSIdays","admissionsource","phicclaimrefno","phicclaimstatus","pcsoamount",
            "pcsorefcode","pcsogrant","hmoclaimrefno","hmopapers","hmodeductions","hmoclaimstatus","hmoclaimeddate",
            "hmoclaimedamount","hmobalance","hmovoucherdate","hmovoucherno","hmovoucheramount","needdeposit",
            "advisedeposit","InqBal","NeedDepoamt","phiccf2prepby","phiccf2updated","Phiccf2done","ReqPHICmdrno",
            "ReqPHICmdrweb","ReqPHICspouse","ReqPHICChild","ReqPHICOFW","ReqPHICparent","cashierpaid","cashiername",
            "cashierbatchrefno","cashierDT","verifiedby","verifiedadmission","verifieddatetime","medcertrefno",
            "patientnickname","Birthcertrefno","medicolegalrefno","diagnosisdone","archivedby","restoreddate",
            "restored","restoredby","cautions","MedicoLegalReference","minorOR","NurseInchargeID","NurseIncharge",
            "TBstatus","patientisNBB","hascateg","phicmemberverified","otherdiag","nursedischadate","nursedischatime",
            "TICKETCODE","TICKETDATE","TICKETBY","postedby","postingdate","pxgroup","slcode","lmp","antenatal","postnatal"
        );
        
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $exploderoomnames = explode("|", $roomnames);
        $countexploderoomnames = count($exploderoomnames);

        if($countexploderoomnames === 10)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('roomno !=', $exploderoomnames[8])
                    ->where('roomno !=', $exploderoomnames[9])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('roomno !=', $exploderoomnames[8])
                    ->where('roomno !=', $exploderoomnames[9])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 9)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('roomno !=', $exploderoomnames[8])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('roomno !=', $exploderoomnames[8])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 8)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 7)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 6)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 5)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 4)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 3)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 2)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 1)
        {
            if($pxtype === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('provadd !=', "")
                    ->where('cityadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }

        if (!empty($this->input->post("search")["value"]))
        {
            $this->hospv2_db
                    ->group_start()
                    ->like('name', $this->input->post("search")["value"])  
                    ->or_like('caseno', $this->input->post("search")["value"])  
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) 
        { 
            $this->hospv2_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']); 
        } 
        else 
        {
            $this->hospv2_db->order_by('name', 'ASC'); 
        }
    }

    public function fetch_inpatients_roomrate_others_masterlist_datatables($provnames, $fulldate, $pxtype) 
    {
        $this->fetch_inpatients_roomrate_others_masterlist($provnames, $fulldate, $pxtype); 

        if ($this->input->post("length") != -1)
        {
            $this->hospv2_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hospv2_db->get();
        return $query->result();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function fetch_inpatients_provparam_masterlist_data($provname, $fulldate, $pxtypexx) 
    {
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($provname === "ALL PROVINCE")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd', $provname)
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('provadd', $provname)
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
            
        return $this->hospv2_db->count_all_results();
    }

    public function fetch_inpatients_provparam_masterlist_filtered_data($provname, $fulldate, $pxtypexx) 
    {
        $this->fetch_inpatients_provparam_masterlist($provname, $fulldate, $pxtypexx);

        $query = $this->hospv2_db->get();
        return $query->num_rows();
    }

    public function fetch_inpatients_provparam_masterlist($provname, $fulldate, $pxtypexx) 
    {
        $order_column = array
        (
            "id","pxtype","opdtype","casetype","admittype","logbookCN","logbookPIN",
            "HRnCODE","billingcprecipient","lasttextsent","lasttransactionsent","vip",
            "pincode","casecode","caseyr","caseseq","caseno","memberrefno","membercardno",
            "ledgerfile","pinyr","pinseq","PIN","pinformat","lname","fname","mname","suffix",
            "name","hideinfo","spouse","spousebday","sex","bday","Age","Weight","packageCODE",
            "nationality","passportno","guarantor","guarantor_rltn","guarantor_mobileno",
            "guarantor_bday","adrs","brgy","cityadd","provadd","zipcode","civilstatus",
            "contactno","mobileno","email","religion","father","fatheradrs","fathernationality",
            "mother","motheradrs","mothernationality","updated","doctorid","doctorname","nurseid",
            "nursename","hmoid","hmoname","hmoholder","hmonumber","hmoapprovalno","archived",
            "lastadmitdate","archiveddate","lastadmittime","lastdischdate","lastdischtime","pat_clascode",
            "pat_classub","pat_classification","recid","recby","station","admitdate","admittime",
            "tagfordischa","tagfordischaDT","dischadate","dischatime","dischaid","dischaby","discharged",
            "daysconfined","disposition","expireddate","expiredtime","ReferredFromHCI","TransRefHCI",
            "reasonforreferral","roomref","roomcd","roomtype","roomno","roombed","roominfo","roombrief",
            "roomdate","roomtime","roomrate","PRICEPACKAGE","rmrateschm","RmPHICtype","creditmax",
            "addonserv","phiccode","phicmembr","phicdependent","phicPIN","phicmembrname","relationtomember",
            "phiccasefirst","phiccasefirstRefno","phiccasefirstDx","phiccasesecond","phiccasesecondRefno",
            "phiccasesecondDx","phicHCItotal","PHICpfTotal","PHICrmtype","dietarycd","diatary_ins",
            "dietstatus","Diag_chiefcomplain","Diag_admit","Diag_discharge","Diag_discharge_updatedby",
            "Diag_discharge_updatedDT","Diag_surg_ref","Diag_surg","Diag_surgICD","Diag_surg_type",
            "Diag_anes_ref","Diag_anes","Diag_anesICD","ICD10","icdcasetype","flagme","suprvid","suprvby",
            "clearedid","clearedby","clearedtd","clearedat","Quikadmit","patfile","imagefile","mypix",
            "nursestation","phicpapers","phicclearby","phicdeductions","phicnote","printedby","printeddate",
            "billingnote","nobillingdischarged","nbdhospamount","nbddocamount","GrossHospAmt","GrossDocAmt",
            "GrandTotalBill","phic1caseHCIrecommend","phic2caseHCIrecommend","phic1caseDOCrecommend",
            "phic2caseDOCrecommend","DiscountPHIChosp","DiscountPHICdoc","DiscountHosp","DiscountHospDoc",
            "DiscountHMOHosp","DiscountHMODoc","DiscountSrHosp","DiscountSrDoc","DiscountVATHosp","DiscountVATDoc",
            "PNrefno","PNduedate","PNamount","PNBalance","PNlastupdate","PNlastRefno","PNby","PNAddress1",
            "PNaddress2","PNbyCellnumber","OBprocedure","dischargedsameday","dischargein48","deliverycausesofdeaths",
            "deathtype","HAIcase_deviceinfection","HAIcasedays","HAIVAPinfection","HAIVAPdays","HAIBSIinfection",
            "HAIBSIdays","HAIUTIinfection","HAIUTIdays","HAIcase_nonedeviceinfection","HAInonecasedays",
            "HAISSInoneinfection","HAISSIdays","admissionsource","phicclaimrefno","phicclaimstatus","pcsoamount",
            "pcsorefcode","pcsogrant","hmoclaimrefno","hmopapers","hmodeductions","hmoclaimstatus","hmoclaimeddate",
            "hmoclaimedamount","hmobalance","hmovoucherdate","hmovoucherno","hmovoucheramount","needdeposit",
            "advisedeposit","InqBal","NeedDepoamt","phiccf2prepby","phiccf2updated","Phiccf2done","ReqPHICmdrno",
            "ReqPHICmdrweb","ReqPHICspouse","ReqPHICChild","ReqPHICOFW","ReqPHICparent","cashierpaid","cashiername",
            "cashierbatchrefno","cashierDT","verifiedby","verifiedadmission","verifieddatetime","medcertrefno",
            "patientnickname","Birthcertrefno","medicolegalrefno","diagnosisdone","archivedby","restoreddate",
            "restored","restoredby","cautions","MedicoLegalReference","minorOR","NurseInchargeID","NurseIncharge",
            "TBstatus","patientisNBB","hascateg","phicmemberverified","otherdiag","nursedischadate","nursedischatime",
            "TICKETCODE","TICKETDATE","TICKETBY","postedby","postingdate","pxgroup","slcode","lmp","antenatal","postnatal"
        );
        
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($provname === "ALL PROVINCE")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx);
            }
        }
        else
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd', $provname)
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('provadd', $provname)
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx);
            }
        }
            
        if (!empty($this->input->post("search")["value"]))
        {
            $this->hospv2_db
                    ->group_start()
                    ->like('name', $this->input->post("search")["value"])  
                    ->or_like('caseno', $this->input->post("search")["value"])  
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) 
        { 
            $this->hospv2_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']); 
        } 
        else 
        {
            $this->hospv2_db->order_by('name', 'ASC'); 
        }
    }

    public function fetch_inpatients_provparam_masterlist_datatables($provname, $fulldate, $pxtypexx) 
    {
        $this->fetch_inpatients_provparam_masterlist($provname, $fulldate, $pxtypexx); 

        if ($this->input->post("length") != -1)
        {
            $this->hospv2_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hospv2_db->get();
        return $query->result();
    }
    
    
    public function fetch_inpatients_insurance_masterlist_data($hmoxname, $fulldate, $pxtypexx) 
    {
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($hmoxname === "ALL HMO/INSURANCE")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else
        {
            if($hmoxname === "NON-HMO")
            {
                if($pxtypexx === "ALL")
                {
                    $this->hospv2_db->select('*')
                        ->from('inpatient')
                        ->order_by('name')
                        ->where('hmoname = ""')
                        ->where('cityadd !=', "")
                        ->where('provadd !=', "")
                        ->where('roomno !=', "")
                        ->where('admitdate >=',$first)
                        ->where('admitdate <=',$end)
                        ->limit(100);
                }
                else
                {
                    $this->hospv2_db->select('*')
                        ->from('inpatient')
                        ->order_by('name')
                        ->where('hmoname = ""')
                        ->where('cityadd !=', "")
                        ->where('provadd !=', "")
                        ->where('roomno !=', "")
                        ->where('admitdate >=',$first)
                        ->where('admitdate <=',$end)
                        ->where('pxtype',$pxtypexx)
                        ->limit(100);
                }
            }
            else
            {
                if($pxtypexx === "ALL")
                {
                    $this->hospv2_db->select('*')
                        ->from('inpatient')
                        ->order_by('name')
                        ->where('hmoname', $hmoxname)
                        ->where('cityadd !=', "")
                        ->where('provadd !=', "")
                        ->where('roomno !=', "")
                        ->where('admitdate >=',$first)
                        ->where('admitdate <=',$end)
                        ->limit(100);
                }
                else
                {
                    $this->hospv2_db->select('*')
                        ->from('inpatient')
                        ->order_by('name')
                        ->where('hmoname', $hmoxname)
                        ->where('cityadd !=', "")
                        ->where('provadd !=', "")
                        ->where('roomno !=', "")
                        ->where('admitdate >=',$first)
                        ->where('admitdate <=',$end)
                        ->where('pxtype',$pxtypexx)
                        ->limit(100);
                }
            }
        }
            
        return $this->hospv2_db->count_all_results();
    }

    public function fetch_inpatients_insurance_masterlist_filtered_data($hmoxname, $fulldate, $pxtypexx) 
    {
        $this->fetch_inpatients_insurance_masterlist($hmoxname, $fulldate, $pxtypexx);

        $query = $this->hospv2_db->get();
        return $query->num_rows();
    }

    public function fetch_inpatients_insurance_masterlist($hmoxname, $fulldate, $pxtypexx) 
    {
        $order_column = array
        (
            "id","pxtype","opdtype","casetype","admittype","logbookCN","logbookPIN",
            "HRnCODE","billingcprecipient","lasttextsent","lasttransactionsent","vip",
            "pincode","casecode","caseyr","caseseq","caseno","memberrefno","membercardno",
            "ledgerfile","pinyr","pinseq","PIN","pinformat","lname","fname","mname","suffix",
            "name","hideinfo","spouse","spousebday","sex","bday","Age","Weight","packageCODE",
            "nationality","passportno","guarantor","guarantor_rltn","guarantor_mobileno",
            "guarantor_bday","adrs","brgy","cityadd","provadd","zipcode","civilstatus",
            "contactno","mobileno","email","religion","father","fatheradrs","fathernationality",
            "mother","motheradrs","mothernationality","updated","doctorid","doctorname","nurseid",
            "nursename","hmoid","hmoname","hmoholder","hmonumber","hmoapprovalno","archived",
            "lastadmitdate","archiveddate","lastadmittime","lastdischdate","lastdischtime","pat_clascode",
            "pat_classub","pat_classification","recid","recby","station","admitdate","admittime",
            "tagfordischa","tagfordischaDT","dischadate","dischatime","dischaid","dischaby","discharged",
            "daysconfined","disposition","expireddate","expiredtime","ReferredFromHCI","TransRefHCI",
            "reasonforreferral","roomref","roomcd","roomtype","roomno","roombed","roominfo","roombrief",
            "roomdate","roomtime","roomrate","PRICEPACKAGE","rmrateschm","RmPHICtype","creditmax",
            "addonserv","phiccode","phicmembr","phicdependent","phicPIN","phicmembrname","relationtomember",
            "phiccasefirst","phiccasefirstRefno","phiccasefirstDx","phiccasesecond","phiccasesecondRefno",
            "phiccasesecondDx","phicHCItotal","PHICpfTotal","PHICrmtype","dietarycd","diatary_ins",
            "dietstatus","Diag_chiefcomplain","Diag_admit","Diag_discharge","Diag_discharge_updatedby",
            "Diag_discharge_updatedDT","Diag_surg_ref","Diag_surg","Diag_surgICD","Diag_surg_type",
            "Diag_anes_ref","Diag_anes","Diag_anesICD","ICD10","icdcasetype","flagme","suprvid","suprvby",
            "clearedid","clearedby","clearedtd","clearedat","Quikadmit","patfile","imagefile","mypix",
            "nursestation","phicpapers","phicclearby","phicdeductions","phicnote","printedby","printeddate",
            "billingnote","nobillingdischarged","nbdhospamount","nbddocamount","GrossHospAmt","GrossDocAmt",
            "GrandTotalBill","phic1caseHCIrecommend","phic2caseHCIrecommend","phic1caseDOCrecommend",
            "phic2caseDOCrecommend","DiscountPHIChosp","DiscountPHICdoc","DiscountHosp","DiscountHospDoc",
            "DiscountHMOHosp","DiscountHMODoc","DiscountSrHosp","DiscountSrDoc","DiscountVATHosp","DiscountVATDoc",
            "PNrefno","PNduedate","PNamount","PNBalance","PNlastupdate","PNlastRefno","PNby","PNAddress1",
            "PNaddress2","PNbyCellnumber","OBprocedure","dischargedsameday","dischargein48","deliverycausesofdeaths",
            "deathtype","HAIcase_deviceinfection","HAIcasedays","HAIVAPinfection","HAIVAPdays","HAIBSIinfection",
            "HAIBSIdays","HAIUTIinfection","HAIUTIdays","HAIcase_nonedeviceinfection","HAInonecasedays",
            "HAISSInoneinfection","HAISSIdays","admissionsource","phicclaimrefno","phicclaimstatus","pcsoamount",
            "pcsorefcode","pcsogrant","hmoclaimrefno","hmopapers","hmodeductions","hmoclaimstatus","hmoclaimeddate",
            "hmoclaimedamount","hmobalance","hmovoucherdate","hmovoucherno","hmovoucheramount","needdeposit",
            "advisedeposit","InqBal","NeedDepoamt","phiccf2prepby","phiccf2updated","Phiccf2done","ReqPHICmdrno",
            "ReqPHICmdrweb","ReqPHICspouse","ReqPHICChild","ReqPHICOFW","ReqPHICparent","cashierpaid","cashiername",
            "cashierbatchrefno","cashierDT","verifiedby","verifiedadmission","verifieddatetime","medcertrefno",
            "patientnickname","Birthcertrefno","medicolegalrefno","diagnosisdone","archivedby","restoreddate",
            "restored","restoredby","cautions","MedicoLegalReference","minorOR","NurseInchargeID","NurseIncharge",
            "TBstatus","patientisNBB","hascateg","phicmemberverified","otherdiag","nursedischadate","nursedischatime",
            "TICKETCODE","TICKETDATE","TICKETBY","postedby","postingdate","pxgroup","slcode","lmp","antenatal","postnatal"
        );
        
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($hmoxname === "ALL HMO/INSURANCE")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx);
            }
        }
        else
        {
            if($hmoxname === "NON-HMO")
            {
                if($pxtypexx === "ALL")
                {
                    $this->hospv2_db
                        ->select('*')
                        ->limit(100)
                        ->from('inpatient use index(namex)')
                        ->where('hmoname',"")
                        ->where('cityadd !=', "")
                        ->where('provadd !=', "")
                        ->where('roomno !=', "")
                        ->where('admitdate >=',$first)
                        ->where('admitdate <=',$end);
                }
                else
                {
                    $this->hospv2_db
                        ->select('*')
                        ->limit(100)
                        ->from('inpatient use index(namex)')
                        ->where('hmoname',"")
                        ->where('cityadd !=', "")
                        ->where('provadd !=', "")
                        ->where('roomno !=', "")
                        ->where('admitdate >=',$first)
                        ->where('admitdate <=',$end)
                        ->where('pxtype',$pxtypexx);
                }
            }
            else
            {
                if($pxtypexx === "ALL")
                {
                    $this->hospv2_db
                        ->select('*')
                        ->limit(100)
                        ->from('inpatient use index(namex)')
                        ->where('hmoname', $hmoxname)
                        ->where('cityadd !=', "")
                        ->where('provadd !=', "")
                        ->where('roomno !=', "")
                        ->where('admitdate >=',$first)
                        ->where('admitdate <=',$end);
                }
                else
                {
                    $this->hospv2_db
                        ->select('*')
                        ->limit(100)
                        ->from('inpatient use index(namex)')
                        ->where('hmoname', $hmoxname)
                        ->where('cityadd !=', "")
                        ->where('provadd !=', "")
                        ->where('roomno !=', "")
                        ->where('admitdate >=',$first)
                        ->where('admitdate <=',$end)
                        ->where('pxtype',$pxtypexx);
                }
            }
        }
            
        if (!empty($this->input->post("search")["value"]))
        {
            $this->hospv2_db
                    ->group_start()
                    ->like('name', $this->input->post("search")["value"])  
                    ->or_like('caseno', $this->input->post("search")["value"])  
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) 
        { 
            $this->hospv2_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']); 
        } 
        else 
        {
            $this->hospv2_db->order_by('name', 'ASC'); 
        }
    }

    public function fetch_inpatients_insurance_masterlist_datatables($hmoxname, $fulldate, $pxtypexx) 
    {
        $this->fetch_inpatients_insurance_masterlist($hmoxname, $fulldate, $pxtypexx); 

        if ($this->input->post("length") != -1)
        {
            $this->hospv2_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hospv2_db->get();
        return $query->result();
    }

    public function fetch_inpatients_roomparam_masterlist_data($roomname, $fulldate, $pxtypexx) 
    {
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($roomname === "ALL ROOMS")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno', $roomname)
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('roomno', $roomname)
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        
        return $this->hospv2_db->count_all_results();
    }

    public function fetch_inpatients_roomparam_masterlist_filtered_data($roomname, $fulldate, $pxtypexx) 
    {
        $this->fetch_inpatients_roomparam_masterlist($roomname, $fulldate, $pxtypexx);

        $query = $this->hospv2_db->get();
        return $query->num_rows();
    }

    public function fetch_inpatients_roomparam_masterlist($roomname, $fulldate, $pxtypexx) 
    {
        $order_column = array
        (
            "id","pxtype","opdtype","casetype","admittype","logbookCN","logbookPIN",
            "HRnCODE","billingcprecipient","lasttextsent","lasttransactionsent","vip",
            "pincode","casecode","caseyr","caseseq","caseno","memberrefno","membercardno",
            "ledgerfile","pinyr","pinseq","PIN","pinformat","lname","fname","mname","suffix",
            "name","hideinfo","spouse","spousebday","sex","bday","Age","Weight","packageCODE",
            "nationality","passportno","guarantor","guarantor_rltn","guarantor_mobileno",
            "guarantor_bday","adrs","brgy","cityadd","provadd","zipcode","civilstatus",
            "contactno","mobileno","email","religion","father","fatheradrs","fathernationality",
            "mother","motheradrs","mothernationality","updated","doctorid","doctorname","nurseid",
            "nursename","hmoid","hmoname","hmoholder","hmonumber","hmoapprovalno","archived",
            "lastadmitdate","archiveddate","lastadmittime","lastdischdate","lastdischtime","pat_clascode",
            "pat_classub","pat_classification","recid","recby","station","admitdate","admittime",
            "tagfordischa","tagfordischaDT","dischadate","dischatime","dischaid","dischaby","discharged",
            "daysconfined","disposition","expireddate","expiredtime","ReferredFromHCI","TransRefHCI",
            "reasonforreferral","roomref","roomcd","roomtype","roomno","roombed","roominfo","roombrief",
            "roomdate","roomtime","roomrate","PRICEPACKAGE","rmrateschm","RmPHICtype","creditmax",
            "addonserv","phiccode","phicmembr","phicdependent","phicPIN","phicmembrname","relationtomember",
            "phiccasefirst","phiccasefirstRefno","phiccasefirstDx","phiccasesecond","phiccasesecondRefno",
            "phiccasesecondDx","phicHCItotal","PHICpfTotal","PHICrmtype","dietarycd","diatary_ins",
            "dietstatus","Diag_chiefcomplain","Diag_admit","Diag_discharge","Diag_discharge_updatedby",
            "Diag_discharge_updatedDT","Diag_surg_ref","Diag_surg","Diag_surgICD","Diag_surg_type",
            "Diag_anes_ref","Diag_anes","Diag_anesICD","ICD10","icdcasetype","flagme","suprvid","suprvby",
            "clearedid","clearedby","clearedtd","clearedat","Quikadmit","patfile","imagefile","mypix",
            "nursestation","phicpapers","phicclearby","phicdeductions","phicnote","printedby","printeddate",
            "billingnote","nobillingdischarged","nbdhospamount","nbddocamount","GrossHospAmt","GrossDocAmt",
            "GrandTotalBill","phic1caseHCIrecommend","phic2caseHCIrecommend","phic1caseDOCrecommend",
            "phic2caseDOCrecommend","DiscountPHIChosp","DiscountPHICdoc","DiscountHosp","DiscountHospDoc",
            "DiscountHMOHosp","DiscountHMODoc","DiscountSrHosp","DiscountSrDoc","DiscountVATHosp","DiscountVATDoc",
            "PNrefno","PNduedate","PNamount","PNBalance","PNlastupdate","PNlastRefno","PNby","PNAddress1",
            "PNaddress2","PNbyCellnumber","OBprocedure","dischargedsameday","dischargein48","deliverycausesofdeaths",
            "deathtype","HAIcase_deviceinfection","HAIcasedays","HAIVAPinfection","HAIVAPdays","HAIBSIinfection",
            "HAIBSIdays","HAIUTIinfection","HAIUTIdays","HAIcase_nonedeviceinfection","HAInonecasedays",
            "HAISSInoneinfection","HAISSIdays","admissionsource","phicclaimrefno","phicclaimstatus","pcsoamount",
            "pcsorefcode","pcsogrant","hmoclaimrefno","hmopapers","hmodeductions","hmoclaimstatus","hmoclaimeddate",
            "hmoclaimedamount","hmobalance","hmovoucherdate","hmovoucherno","hmovoucheramount","needdeposit",
            "advisedeposit","InqBal","NeedDepoamt","phiccf2prepby","phiccf2updated","Phiccf2done","ReqPHICmdrno",
            "ReqPHICmdrweb","ReqPHICspouse","ReqPHICChild","ReqPHICOFW","ReqPHICparent","cashierpaid","cashiername",
            "cashierbatchrefno","cashierDT","verifiedby","verifiedadmission","verifieddatetime","medcertrefno",
            "patientnickname","Birthcertrefno","medicolegalrefno","diagnosisdone","archivedby","restoreddate",
            "restored","restoredby","cautions","MedicoLegalReference","minorOR","NurseInchargeID","NurseIncharge",
            "TBstatus","patientisNBB","hascateg","phicmemberverified","otherdiag","nursedischadate","nursedischatime",
            "TICKETCODE","TICKETDATE","TICKETBY","postedby","postingdate","pxgroup","slcode","lmp","antenatal","postnatal"
        );
        
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($roomname === "ALL ROOMS")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx);
            }
        }
        else
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno', $roomname)
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->limit(100)
                    ->from('inpatient use index(namex)')
                    ->where('roomno', $roomname)
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx);
            }
        }
        
        if (!empty($this->input->post("search")["value"]))
        {
            $this->hospv2_db
                    ->group_start()
                    ->like('name', $this->input->post("search")["value"])  
                    ->or_like('caseno', $this->input->post("search")["value"])  
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) 
        { 
            $this->hospv2_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']); 
        } 
        else 
        {
            $this->hospv2_db->order_by('name', 'ASC'); 
        }
    }

    public function fetch_inpatients_roomparam_masterlist_datatables($roomname, $fulldate, $pxtypexx) 
    {
        $this->fetch_inpatients_roomparam_masterlist($roomname, $fulldate, $pxtypexx); 

        if ($this->input->post("length") != -1)
        {
            $this->hospv2_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hospv2_db->get();
        return $query->result();
    }
    
    public function fetch_inpatients_agecateg_masterlist_data($agecateg, $fulldate, $pxtypexx) 
    {
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($agecateg === "ALL")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else if($agecateg === "INFANT")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',0)
                    ->where('Age <=',3)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',0)
                    ->where('Age <=',3)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else if($agecateg === "CHILD")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',3)
                    ->where('Age <=',11)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',3)
                    ->where('Age <=',11)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else if($agecateg === "YOUTH")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',11)
                    ->where('Age <=',25)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',11)
                    ->where('Age <=',25)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else if($agecateg === "ADULT")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',25)
                    ->where('Age <=',60)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',25)
                    ->where('Age <=',60)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',60)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',60)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
       
        return $this->hospv2_db->count_all_results();
    }

    public function fetch_inpatients_agecateg_masterlist_filtered_data($agecateg, $fulldate, $pxtypexx) 
    {
        $this->fetch_inpatients_agecateg_masterlist($agecateg, $fulldate, $pxtypexx);

        $query = $this->hospv2_db->get();
        return $query->num_rows();
    }

    public function fetch_inpatients_agecateg_masterlist($agecateg, $fulldate, $pxtypexx) 
    {
        $order_column = array
        (
            "id","pxtype","opdtype","casetype","admittype","logbookCN","logbookPIN",
            "HRnCODE","billingcprecipient","lasttextsent","lasttransactionsent","vip",
            "pincode","casecode","caseyr","caseseq","caseno","memberrefno","membercardno",
            "ledgerfile","pinyr","pinseq","PIN","pinformat","lname","fname","mname","suffix",
            "name","hideinfo","spouse","spousebday","sex","bday","Age","Weight","packageCODE",
            "nationality","passportno","guarantor","guarantor_rltn","guarantor_mobileno",
            "guarantor_bday","adrs","brgy","cityadd","provadd","zipcode","civilstatus",
            "contactno","mobileno","email","religion","father","fatheradrs","fathernationality",
            "mother","motheradrs","mothernationality","updated","doctorid","doctorname","nurseid",
            "nursename","hmoid","hmoname","hmoholder","hmonumber","hmoapprovalno","archived",
            "lastadmitdate","archiveddate","lastadmittime","lastdischdate","lastdischtime","pat_clascode",
            "pat_classub","pat_classification","recid","recby","station","admitdate","admittime",
            "tagfordischa","tagfordischaDT","dischadate","dischatime","dischaid","dischaby","discharged",
            "daysconfined","disposition","expireddate","expiredtime","ReferredFromHCI","TransRefHCI",
            "reasonforreferral","roomref","roomcd","roomtype","roomno","roombed","roominfo","roombrief",
            "roomdate","roomtime","roomrate","PRICEPACKAGE","rmrateschm","RmPHICtype","creditmax",
            "addonserv","phiccode","phicmembr","phicdependent","phicPIN","phicmembrname","relationtomember",
            "phiccasefirst","phiccasefirstRefno","phiccasefirstDx","phiccasesecond","phiccasesecondRefno",
            "phiccasesecondDx","phicHCItotal","PHICpfTotal","PHICrmtype","dietarycd","diatary_ins",
            "dietstatus","Diag_chiefcomplain","Diag_admit","Diag_discharge","Diag_discharge_updatedby",
            "Diag_discharge_updatedDT","Diag_surg_ref","Diag_surg","Diag_surgICD","Diag_surg_type",
            "Diag_anes_ref","Diag_anes","Diag_anesICD","ICD10","icdcasetype","flagme","suprvid","suprvby",
            "clearedid","clearedby","clearedtd","clearedat","Quikadmit","patfile","imagefile","mypix",
            "nursestation","phicpapers","phicclearby","phicdeductions","phicnote","printedby","printeddate",
            "billingnote","nobillingdischarged","nbdhospamount","nbddocamount","GrossHospAmt","GrossDocAmt",
            "GrandTotalBill","phic1caseHCIrecommend","phic2caseHCIrecommend","phic1caseDOCrecommend",
            "phic2caseDOCrecommend","DiscountPHIChosp","DiscountPHICdoc","DiscountHosp","DiscountHospDoc",
            "DiscountHMOHosp","DiscountHMODoc","DiscountSrHosp","DiscountSrDoc","DiscountVATHosp","DiscountVATDoc",
            "PNrefno","PNduedate","PNamount","PNBalance","PNlastupdate","PNlastRefno","PNby","PNAddress1",
            "PNaddress2","PNbyCellnumber","OBprocedure","dischargedsameday","dischargein48","deliverycausesofdeaths",
            "deathtype","HAIcase_deviceinfection","HAIcasedays","HAIVAPinfection","HAIVAPdays","HAIBSIinfection",
            "HAIBSIdays","HAIUTIinfection","HAIUTIdays","HAIcase_nonedeviceinfection","HAInonecasedays",
            "HAISSInoneinfection","HAISSIdays","admissionsource","phicclaimrefno","phicclaimstatus","pcsoamount",
            "pcsorefcode","pcsogrant","hmoclaimrefno","hmopapers","hmodeductions","hmoclaimstatus","hmoclaimeddate",
            "hmoclaimedamount","hmobalance","hmovoucherdate","hmovoucherno","hmovoucheramount","needdeposit",
            "advisedeposit","InqBal","NeedDepoamt","phiccf2prepby","phiccf2updated","Phiccf2done","ReqPHICmdrno",
            "ReqPHICmdrweb","ReqPHICspouse","ReqPHICChild","ReqPHICOFW","ReqPHICparent","cashierpaid","cashiername",
            "cashierbatchrefno","cashierDT","verifiedby","verifiedadmission","verifieddatetime","medcertrefno",
            "patientnickname","Birthcertrefno","medicolegalrefno","diagnosisdone","archivedby","restoreddate",
            "restored","restoredby","cautions","MedicoLegalReference","minorOR","NurseInchargeID","NurseIncharge",
            "TBstatus","patientisNBB","hascateg","phicmemberverified","otherdiag","nursedischadate","nursedischatime",
            "TICKETCODE","TICKETDATE","TICKETBY","postedby","postingdate","pxgroup","slcode","lmp","antenatal","postnatal"
        );
        
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        
        if($agecateg === "ALL")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else if($agecateg === "INFANT")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',0)
                    ->where('Age <=',3)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',0)
                    ->where('Age <=',3)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else if($agecateg === "CHILD")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',3)
                    ->where('Age <=',11)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',3)
                    ->where('Age <=',11)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else if($agecateg === "YOUTH")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',11)
                    ->where('Age <=',25)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',11)
                    ->where('Age <=',25)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else if($agecateg === "ADULT")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',25)
                    ->where('Age <=',60)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',25)
                    ->where('Age <=',60)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',60)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('Age >=',60)
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }

        if (!empty($this->input->post("search")["value"]))
        {
            $this->hospv2_db
                    ->group_start()
                    ->like('name', $this->input->post("search")["value"])  
                    ->or_like('caseno', $this->input->post("search")["value"])  
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) 
        { 
            $this->hospv2_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']); 
        } 
        else 
        {
            $this->hospv2_db->order_by('name', 'ASC'); 
        }
    }

    public function fetch_inpatients_agecateg_masterlist_datatables($agecateg, $fulldate, $pxtypexx) 
    {
        $this->fetch_inpatients_agecateg_masterlist($agecateg, $fulldate, $pxtypexx); 

        if ($this->input->post("length") != -1)
        {
            $this->hospv2_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hospv2_db->get();
        return $query->result();
    }
    
    public function fetch_inpatients_sexcateg_masterlist_data($sexcateg, $fulldate, $pxtypexx) 
    {
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($sexcateg === "ALL")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else if($sexcateg === "MALE")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('sex ="MALE"')
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->where('sex ="MALE"')
                    ->limit(100);
            }
        }
        else
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('sex ="FEMALE"')
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->order_by('name')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->where('sex ="FEMALE"')
                    ->limit(100);
            }
        }
       
        return $this->hospv2_db->count_all_results();
    }

    public function fetch_inpatients_sexcateg_masterlist_filtered_data($sexcateg, $fulldate, $pxtypexx) 
    {
        $this->fetch_inpatients_sexcateg_masterlist($sexcateg, $fulldate, $pxtypexx);

        $query = $this->hospv2_db->get();
        return $query->num_rows();
    }

    public function fetch_inpatients_sexcateg_masterlist($sexcateg, $fulldate, $pxtypexx) 
    {
        $order_column = array
        (
            "id","pxtype","opdtype","casetype","admittype","logbookCN","logbookPIN",
            "HRnCODE","billingcprecipient","lasttextsent","lasttransactionsent","vip",
            "pincode","casecode","caseyr","caseseq","caseno","memberrefno","membercardno",
            "ledgerfile","pinyr","pinseq","PIN","pinformat","lname","fname","mname","suffix",
            "name","hideinfo","spouse","spousebday","sex","bday","Age","Weight","packageCODE",
            "nationality","passportno","guarantor","guarantor_rltn","guarantor_mobileno",
            "guarantor_bday","adrs","brgy","cityadd","provadd","zipcode","civilstatus",
            "contactno","mobileno","email","religion","father","fatheradrs","fathernationality",
            "mother","motheradrs","mothernationality","updated","doctorid","doctorname","nurseid",
            "nursename","hmoid","hmoname","hmoholder","hmonumber","hmoapprovalno","archived",
            "lastadmitdate","archiveddate","lastadmittime","lastdischdate","lastdischtime","pat_clascode",
            "pat_classub","pat_classification","recid","recby","station","admitdate","admittime",
            "tagfordischa","tagfordischaDT","dischadate","dischatime","dischaid","dischaby","discharged",
            "daysconfined","disposition","expireddate","expiredtime","ReferredFromHCI","TransRefHCI",
            "reasonforreferral","roomref","roomcd","roomtype","roomno","roombed","roominfo","roombrief",
            "roomdate","roomtime","roomrate","PRICEPACKAGE","rmrateschm","RmPHICtype","creditmax",
            "addonserv","phiccode","phicmembr","phicdependent","phicPIN","phicmembrname","relationtomember",
            "phiccasefirst","phiccasefirstRefno","phiccasefirstDx","phiccasesecond","phiccasesecondRefno",
            "phiccasesecondDx","phicHCItotal","PHICpfTotal","PHICrmtype","dietarycd","diatary_ins",
            "dietstatus","Diag_chiefcomplain","Diag_admit","Diag_discharge","Diag_discharge_updatedby",
            "Diag_discharge_updatedDT","Diag_surg_ref","Diag_surg","Diag_surgICD","Diag_surg_type",
            "Diag_anes_ref","Diag_anes","Diag_anesICD","ICD10","icdcasetype","flagme","suprvid","suprvby",
            "clearedid","clearedby","clearedtd","clearedat","Quikadmit","patfile","imagefile","mypix",
            "nursestation","phicpapers","phicclearby","phicdeductions","phicnote","printedby","printeddate",
            "billingnote","nobillingdischarged","nbdhospamount","nbddocamount","GrossHospAmt","GrossDocAmt",
            "GrandTotalBill","phic1caseHCIrecommend","phic2caseHCIrecommend","phic1caseDOCrecommend",
            "phic2caseDOCrecommend","DiscountPHIChosp","DiscountPHICdoc","DiscountHosp","DiscountHospDoc",
            "DiscountHMOHosp","DiscountHMODoc","DiscountSrHosp","DiscountSrDoc","DiscountVATHosp","DiscountVATDoc",
            "PNrefno","PNduedate","PNamount","PNBalance","PNlastupdate","PNlastRefno","PNby","PNAddress1",
            "PNaddress2","PNbyCellnumber","OBprocedure","dischargedsameday","dischargein48","deliverycausesofdeaths",
            "deathtype","HAIcase_deviceinfection","HAIcasedays","HAIVAPinfection","HAIVAPdays","HAIBSIinfection",
            "HAIBSIdays","HAIUTIinfection","HAIUTIdays","HAIcase_nonedeviceinfection","HAInonecasedays",
            "HAISSInoneinfection","HAISSIdays","admissionsource","phicclaimrefno","phicclaimstatus","pcsoamount",
            "pcsorefcode","pcsogrant","hmoclaimrefno","hmopapers","hmodeductions","hmoclaimstatus","hmoclaimeddate",
            "hmoclaimedamount","hmobalance","hmovoucherdate","hmovoucherno","hmovoucheramount","needdeposit",
            "advisedeposit","InqBal","NeedDepoamt","phiccf2prepby","phiccf2updated","Phiccf2done","ReqPHICmdrno",
            "ReqPHICmdrweb","ReqPHICspouse","ReqPHICChild","ReqPHICOFW","ReqPHICparent","cashierpaid","cashiername",
            "cashierbatchrefno","cashierDT","verifiedby","verifiedadmission","verifieddatetime","medcertrefno",
            "patientnickname","Birthcertrefno","medicolegalrefno","diagnosisdone","archivedby","restoreddate",
            "restored","restoredby","cautions","MedicoLegalReference","minorOR","NurseInchargeID","NurseIncharge",
            "TBstatus","patientisNBB","hascateg","phicmemberverified","otherdiag","nursedischadate","nursedischatime",
            "TICKETCODE","TICKETDATE","TICKETBY","postedby","postingdate","pxgroup","slcode","lmp","antenatal","postnatal"
        );
        
        $monthstart = date("Y-m-01", strtotime($fulldate."-01"));
        $monthend =  date("Y-m-t", strtotime($fulldate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        
        if($sexcateg === "ALL")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->limit(100);
            }
        }
        else if($sexcateg === "MALE")
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('sex ="MALE"')
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->where('sex ="MALE"')
                    ->limit(100);
            }
        }
        else
        {
            if($pxtypexx === "ALL")
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('sex ="FEMALE"')
                    ->limit(100);
            }
            else
            {
                $this->hospv2_db->select('*')
                    ->from('inpatient')
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexx)
                    ->where('sex ="FEMALE"')
                    ->limit(100);
            }
        }

        if (!empty($this->input->post("search")["value"]))
        {
            $this->hospv2_db
                    ->group_start()
                    ->like('name', $this->input->post("search")["value"])  
                    ->or_like('caseno', $this->input->post("search")["value"])  
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) 
        { 
            $this->hospv2_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']); 
        } 
        else 
        {
            $this->hospv2_db->order_by('name', 'ASC'); 
        }
    }

    public function fetch_inpatients_sexcateg_masterlist_datatables($sexcateg, $fulldate, $pxtypexx) 
    {
        $this->fetch_inpatients_sexcateg_masterlist($sexcateg, $fulldate, $pxtypexx); 

        if ($this->input->post("length") != -1)
        {
            $this->hospv2_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hospv2_db->get();
        return $query->result();
    }
    
    public function getPatientViaAgeCategoryParameter($daterequest,$patienttype,$agecategory)
    {
        $monthstart = date("Y-m-01", strtotime($daterequest."-01"));
        $monthend =  date("Y-m-t", strtotime($daterequest."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($agecategory === "ALL")
        {
            if($patienttype === "ALL")
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')    
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->order_by("name");
            }
            else
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$patienttype)
                ->order_by("name");
            }
        }
        else if($agecategory === "INFANT")
        {
            if($patienttype === "ALL")
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('Age >=',0)
                ->where('Age <=',3)
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->order_by("name");
            }
            else
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('Age >=',0)
                ->where('Age <=',3)
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$patienttype)
                ->order_by("name");
            }
        }
        else if($agecategory === "CHILD")
        {
            if($patienttype === "ALL")
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('Age >=',3)
                ->where('Age <=',11)
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->order_by("name");
            }
            else
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('Age >=',3)
                ->where('Age <=',11)
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$patienttype)
                ->order_by("name");
            }
        }
        else if($agecategory === "YOUTH")
        {
            if($patienttype === "ALL")
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('Age >=',11)
                ->where('Age <=',25)
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->order_by("name");
            }
            else
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('Age >=',11)
                ->where('Age <=',25)
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$patienttype)
                ->order_by("name");
            }
        }
        else if($agecategory === "ADULT")
        {
            if($patienttype === "ALL")
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('Age >=',25)
                ->where('Age <=',60)
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->order_by("name");
            }
            else
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('Age >=',25)
                ->where('Age <=',60)
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$patienttype)
                ->order_by("name");
            }
        }
        else
        {
            if($patienttype === "ALL")
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('Age >=',60)
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->order_by("name");
            }
            else
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('Age >=',60)
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$patienttype)
                ->order_by("name");
            }
        }
        
        $query = $this->hospv2_db->get();
        return $query->result_array();
    }
    
    public function getPatientViaSexCategoryParameter($daterequest,$patienttype,$sexcategory)
    {
        $monthstart = date("Y-m-01", strtotime($daterequest."-01"));
        $monthend =  date("Y-m-t", strtotime($daterequest."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        if($sexcategory === "ALL")
        {
            if($patienttype === "ALL")
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')    
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->order_by("name");
            }
            else
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$patienttype)
                ->order_by("name");
            }
        }
        else if($sexcategory === "MALE")
        {
            if($patienttype === "ALL")
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('sex', "MALE")
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->order_by("name");
            }
            else
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('sex', "MALE")
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$patienttype)
                ->order_by("name");
            }
        }
        else
        {
            if($patienttype === "ALL")
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('sex', "FEMALE")
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->order_by("name");
            }
            else
            {
                $this->hospv2_db
                ->select('*')
                ->from('inpatient')
                ->where('sex', "FEMALE")
                ->where('cityadd !=', "")
                ->where('provadd !=', "")
                ->where('roomno !=', "")
                ->where('admitdate >=',$first)
                ->where('admitdate <=',$end)
                ->where('pxtype',$patienttype)
                ->order_by("name");
            }
        }
        
        $query = $this->hospv2_db->get();
        return $query->result_array();
    }

    public function getPatientViaCityMunicipalParameter($requestdate,$citymunname,$patienttype,$othersindic)
    {
        $monthstart = date("Y-m-01", strtotime($requestdate."-01"));
        $monthend =  date("Y-m-t", strtotime($requestdate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $explodecitymunname = explode("|", $citymunname);
        $countexplodecityname = count($explodecitymunname);
        
        if($othersindic === "OTHERS")
        {
            if($countexplodecityname === 10)
            {
                if($patienttype === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', $explodecitymunname[4])
                     ->where('cityadd !=', $explodecitymunname[5])
                     ->where('cityadd !=', $explodecitymunname[6])
                     ->where('cityadd !=', $explodecitymunname[7])
                     ->where('cityadd !=', $explodecitymunname[8])
                     ->where('cityadd !=', $explodecitymunname[9])       
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', $explodecitymunname[4])
                     ->where('cityadd !=', $explodecitymunname[5])
                     ->where('cityadd !=', $explodecitymunname[6])
                     ->where('cityadd !=', $explodecitymunname[7])
                     ->where('cityadd !=', $explodecitymunname[8])
                     ->where('cityadd !=', $explodecitymunname[9])   
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$patienttype)
                     ->order_by("name");
                }
            } 
            else if($countexplodecityname === 9)
            {
                if($patienttype === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', $explodecitymunname[4])
                     ->where('cityadd !=', $explodecitymunname[5])
                     ->where('cityadd !=', $explodecitymunname[6])
                     ->where('cityadd !=', $explodecitymunname[7])
                     ->where('cityadd !=', $explodecitymunname[8])     
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', $explodecitymunname[4])
                     ->where('cityadd !=', $explodecitymunname[5])
                     ->where('cityadd !=', $explodecitymunname[6])
                     ->where('cityadd !=', $explodecitymunname[7])
                     ->where('cityadd !=', $explodecitymunname[8])  
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$patienttype)
                     ->order_by("name");
                }
            } 
            else if($countexplodecityname === 8)
            {
                if($patienttype === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', $explodecitymunname[4])
                     ->where('cityadd !=', $explodecitymunname[5])
                     ->where('cityadd !=', $explodecitymunname[6])
                     ->where('cityadd !=', $explodecitymunname[7])  
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', $explodecitymunname[4])
                     ->where('cityadd !=', $explodecitymunname[5])
                     ->where('cityadd !=', $explodecitymunname[6])
                     ->where('cityadd !=', $explodecitymunname[7])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$patienttype)
                     ->order_by("name");
                }
            } 
            else if($countexplodecityname === 7)
            {
                if($patienttype === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', $explodecitymunname[4])
                     ->where('cityadd !=', $explodecitymunname[5])
                     ->where('cityadd !=', $explodecitymunname[6])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', $explodecitymunname[4])
                     ->where('cityadd !=', $explodecitymunname[5])
                     ->where('cityadd !=', $explodecitymunname[6])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$patienttype)
                     ->order_by("name");
                }
            }
            else if($countexplodecityname === 6)
            {
                if($patienttype === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', $explodecitymunname[4])
                     ->where('cityadd !=', $explodecitymunname[5])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', $explodecitymunname[4])
                     ->where('cityadd !=', $explodecitymunname[5])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$patienttype)
                     ->order_by("name");
                }
            }
            else if($countexplodecityname === 5)
            {
                if($patienttype === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', $explodecitymunname[4])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', $explodecitymunname[4])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$patienttype)
                     ->order_by("name");
                }
            }
            else if($countexplodecityname === 4)
            {
                if($patienttype === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', $explodecitymunname[3])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$patienttype)
                     ->order_by("name");
                }
            }
            else if($countexplodecityname === 3)
            {
                if($patienttype === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', $explodecitymunname[2])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$patienttype)
                     ->order_by("name");
                }
            }
            else if($countexplodecityname === 2)
            {
                if($patienttype === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', $explodecitymunname[1])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$patienttype)
                     ->order_by("name");
                }
            }
            else
            {
                if($patienttype === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', $explodecitymunname[0])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$patienttype)
                     ->order_by("name");
                }
            }
        }
        else
        {
            if($citymunname === "ALL CITY/MUNICIPALITY")
            {
                if($patienttype === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$patienttype)
                     ->order_by("name");
                }
            }
            else
            {
                if($patienttype === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd', $citymunname)
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd', $citymunname)
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$patienttype)
                     ->order_by("name");
                }
            }
        }
        
        $query = $this->hospv2_db->get();
        return $query->result_array();
    }
    
    public function getPatientViaProvinceAddressParameter($requestdate,$provaddname,$pxtypexprov,$othersindic)
    {
        $monthstart = date("Y-m-01", strtotime($requestdate."-01"));
        $monthend =  date("Y-m-t", strtotime($requestdate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $explodeprovaddname = explode("|", $provaddname);
        $countexplodeprovname = count($explodeprovaddname);
        
        if($othersindic === "OTHERS")
        {
            if($countexplodeprovname === 10)
            {
                if($pxtypexprov === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('provadd !=', $explodeprovaddname[4])
                     ->where('provadd !=', $explodeprovaddname[5])
                     ->where('provadd !=', $explodeprovaddname[6])
                     ->where('provadd !=', $explodeprovaddname[7])
                     ->where('provadd !=', $explodeprovaddname[8])
                     ->where('provadd !=', $explodeprovaddname[9])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('provadd !=', $explodeprovaddname[4])
                     ->where('provadd !=', $explodeprovaddname[5])
                     ->where('provadd !=', $explodeprovaddname[6])
                     ->where('provadd !=', $explodeprovaddname[7])
                     ->where('provadd !=', $explodeprovaddname[8])
                     ->where('provadd !=', $explodeprovaddname[9])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexprov)
                     ->order_by("name");
                }
            }
            else if($countexplodeprovname === 9)
            {
                if($pxtypexprov === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('provadd !=', $explodeprovaddname[4])
                     ->where('provadd !=', $explodeprovaddname[5])
                     ->where('provadd !=', $explodeprovaddname[6])
                     ->where('provadd !=', $explodeprovaddname[7])
                     ->where('provadd !=', $explodeprovaddname[8])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('provadd !=', $explodeprovaddname[4])
                     ->where('provadd !=', $explodeprovaddname[5])
                     ->where('provadd !=', $explodeprovaddname[6])
                     ->where('provadd !=', $explodeprovaddname[7])
                     ->where('provadd !=', $explodeprovaddname[8])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexprov)
                     ->order_by("name");
                }
            }
            else if($countexplodeprovname === 8)
            {
                if($pxtypexprov === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('provadd !=', $explodeprovaddname[4])
                     ->where('provadd !=', $explodeprovaddname[5])
                     ->where('provadd !=', $explodeprovaddname[6])
                     ->where('provadd !=', $explodeprovaddname[7])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('provadd !=', $explodeprovaddname[4])
                     ->where('provadd !=', $explodeprovaddname[5])
                     ->where('provadd !=', $explodeprovaddname[6])
                     ->where('provadd !=', $explodeprovaddname[7])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexprov)
                     ->order_by("name");
                }
            }
            else if($countexplodeprovname === 7)
            {
                if($pxtypexprov === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('provadd !=', $explodeprovaddname[4])
                     ->where('provadd !=', $explodeprovaddname[5])
                     ->where('provadd !=', $explodeprovaddname[6])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('provadd !=', $explodeprovaddname[4])
                     ->where('provadd !=', $explodeprovaddname[5])
                     ->where('provadd !=', $explodeprovaddname[6])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexprov)
                     ->order_by("name");
                }
            }
            else if($countexplodeprovname === 6)
            {
                if($pxtypexprov === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('provadd !=', $explodeprovaddname[4])
                     ->where('provadd !=', $explodeprovaddname[5])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('provadd !=', $explodeprovaddname[4])
                     ->where('provadd !=', $explodeprovaddname[5])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexprov)
                     ->order_by("name");
                }
            }
            else if($countexplodeprovname === 5)
            {
                if($pxtypexprov === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('provadd !=', $explodeprovaddname[4])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('provadd !=', $explodeprovaddname[4])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexprov)
                     ->order_by("name");
                }
            }
            else if($countexplodeprovname === 4)
            {
                if($pxtypexprov === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('provadd !=', $explodeprovaddname[3])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexprov)
                     ->order_by("name");
                }
            }
            else if($countexplodeprovname === 3)
            {
                if($pxtypexprov === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('provadd !=', $explodeprovaddname[2])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexprov)
                     ->order_by("name");
                }
            }
            else if($countexplodeprovname === 2)
            {
                if($pxtypexprov === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('provadd !=', $explodeprovaddname[1])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexprov)
                     ->order_by("name");
                }
            }
            else if($countexplodeprovname === 1)
            {
                if($pxtypexprov === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd !=', $explodeprovaddname[0])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexprov)
                     ->order_by("name");
                }
            }
        }
        else
        {
            if($provaddname === "ALL PROVINCE")
            {
                if($pxtypexprov === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexprov)
                     ->order_by("name");
                }
            }
            else
            {
                if($pxtypexprov === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd', $provaddname)
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('provadd', $provaddname)
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexprov)
                     ->order_by("name");
                }
            }
        }
        
        $query = $this->hospv2_db->get();
        return $query->result_array();
    }
    
    public function getPatientViaHMOInsuranceAddressParameter($requestdate,$insurancename,$pxtypexhmox,$othersindic)
    {
        $monthstart = date("Y-m-01", strtotime($requestdate."-01"));
        $monthend =  date("Y-m-t", strtotime($requestdate."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $explodeinsurancename = explode("|", $insurancename);
        $countexplodeinsurance = count($explodeinsurancename);
        
        if($othersindic === "OTHERS")
        {
            if($countexplodeinsurance === 10)
            {
                if($pxtypexhmox === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('hmoname !=', $explodeinsurancename[4])
                     ->where('hmoname !=', $explodeinsurancename[5])
                     ->where('hmoname !=', $explodeinsurancename[6])
                     ->where('hmoname !=', $explodeinsurancename[7])
                     ->where('hmoname !=', $explodeinsurancename[8])
                     ->where('hmoname !=', $explodeinsurancename[9])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('hmoname !=', $explodeinsurancename[4])
                     ->where('hmoname !=', $explodeinsurancename[5])
                     ->where('hmoname !=', $explodeinsurancename[6])
                     ->where('hmoname !=', $explodeinsurancename[7])
                     ->where('hmoname !=', $explodeinsurancename[8])
                     ->where('hmoname !=', $explodeinsurancename[9])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexhmox)
                     ->order_by("name");
                }
            }
            else if($countexplodeinsurance === 9)
            {
                if($pxtypexhmox === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('hmoname !=', $explodeinsurancename[4])
                     ->where('hmoname !=', $explodeinsurancename[5])
                     ->where('hmoname !=', $explodeinsurancename[6])
                     ->where('hmoname !=', $explodeinsurancename[7])
                     ->where('hmoname !=', $explodeinsurancename[8])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('hmoname !=', $explodeinsurancename[4])
                     ->where('hmoname !=', $explodeinsurancename[5])
                     ->where('hmoname !=', $explodeinsurancename[6])
                     ->where('hmoname !=', $explodeinsurancename[7])
                     ->where('hmoname !=', $explodeinsurancename[8])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexhmox)
                     ->order_by("name");
                }
            }
            else if($countexplodeinsurance === 8)
            {
                if($pxtypexhmox === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('hmoname !=', $explodeinsurancename[4])
                     ->where('hmoname !=', $explodeinsurancename[5])
                     ->where('hmoname !=', $explodeinsurancename[6])
                     ->where('hmoname !=', $explodeinsurancename[7])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('hmoname !=', $explodeinsurancename[4])
                     ->where('hmoname !=', $explodeinsurancename[5])
                     ->where('hmoname !=', $explodeinsurancename[6])
                     ->where('hmoname !=', $explodeinsurancename[7])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexhmox)
                     ->order_by("name");
                }
            }
            else if($countexplodeinsurance === 7)
            {
                if($pxtypexhmox === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('hmoname !=', $explodeinsurancename[4])
                     ->where('hmoname !=', $explodeinsurancename[5])
                     ->where('hmoname !=', $explodeinsurancename[6])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('hmoname !=', $explodeinsurancename[4])
                     ->where('hmoname !=', $explodeinsurancename[5])
                     ->where('hmoname !=', $explodeinsurancename[6])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexhmox)
                     ->order_by("name");
                }
            }
            else if($countexplodeinsurance === 6)
            {
                if($pxtypexhmox === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('hmoname !=', $explodeinsurancename[4])
                     ->where('hmoname !=', $explodeinsurancename[5])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('hmoname !=', $explodeinsurancename[4])
                     ->where('hmoname !=', $explodeinsurancename[5])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexhmox)
                     ->order_by("name");
                }
            }
            else if($countexplodeinsurance === 5)
            {
                if($pxtypexhmox === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('hmoname !=', $explodeinsurancename[4])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('hmoname !=', $explodeinsurancename[4])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexhmox)
                     ->order_by("name");
                }
            }
            else if($countexplodeinsurance === 4)
            {
                if($pxtypexhmox === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('hmoname !=', $explodeinsurancename[3])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexhmox)
                     ->order_by("name");
                }
            }
            else if($countexplodeinsurance === 3)
            {
                if($pxtypexhmox === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('hmoname !=', $explodeinsurancename[2])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexhmox)
                     ->order_by("name");
                }
            }
            else if($countexplodeinsurance === 2)
            {
                if($pxtypexhmox === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('hmoname !=', $explodeinsurancename[1])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexhmox)
                     ->order_by("name");
                }
            }
            else if($countexplodeinsurance === 1)
            {
                if($pxtypexhmox === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('hmoname !=', $explodeinsurancename[0])
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexhmox)
                     ->order_by("name");
                }
            }
        }
        else
        {
            if($insurancename === "ALL HMO/INSURANCE")
            {
                if($pxtypexhmox === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexhmox)
                     ->order_by("name");
                }
            }
            else
            {
                if($insurancename === "NON-HMO")
                {
                    if($pxtypexhmox === "ALL")
                    {
                        $this->hospv2_db
                         ->select('*')
                         ->from('inpatient')
                         ->where('hmoname', "")
                         ->where('cityadd !=', "")
                         ->where('provadd !=', "")
                         ->where('roomno !=', "")
                         ->where('admitdate >=',$first)
                         ->where('admitdate <=',$end)
                         ->order_by("name");
                    }
                    else
                    {
                        $this->hospv2_db
                         ->select('*')
                         ->from('inpatient')
                         ->where('hmoname', "")
                         ->where('cityadd !=', "")
                         ->where('provadd !=', "")
                         ->where('roomno !=', "")
                         ->where('admitdate >=',$first)
                         ->where('admitdate <=',$end)
                         ->where('pxtype',$pxtypexhmox)
                         ->order_by("name");
                    }
                }
                else
                {
                    if($pxtypexhmox === "ALL")
                    {
                        $this->hospv2_db
                         ->select('*')
                         ->from('inpatient')
                         ->where('hmoname', $insurancename)
                         ->where('cityadd !=', "")
                         ->where('provadd !=', "")
                         ->where('roomno !=', "")
                         ->where('admitdate >=',$first)
                         ->where('admitdate <=',$end)
                         ->order_by("name");
                    }
                    else
                    {
                        $this->hospv2_db
                         ->select('*')
                         ->from('inpatient')
                         ->where('hmoname', $insurancename)
                         ->where('cityadd !=', "")
                         ->where('provadd !=', "")
                         ->where('roomno !=', "")
                         ->where('admitdate >=',$first)
                         ->where('admitdate <=',$end)
                         ->where('pxtype',$pxtypexhmox)
                         ->order_by("name");
                    }
                } 
            }
        }
        
        $query = $this->hospv2_db->get();
        return $query->result_array();
    }
    
    public function getPatientViaRoomOccupancyRateParameter($daterequest,$roomaddname,$pxtypexroom,$othersindic)
    {
        $monthstart = date("Y-m-01", strtotime($daterequest."-01"));
        $monthend =  date("Y-m-t", strtotime($daterequest."-01"));
        
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');
        
        $exploderoomaddname = explode("|", $roomaddname);
        $countexploderoomname = count($exploderoomaddname);
        
        if($othersindic === "OTHERS")
        {
            if($countexploderoomname === 10)
            {
                if($pxtypexroom === "ALL")
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('roomno !=', $exploderoomaddname[4])
                    ->where('roomno !=', $exploderoomaddname[5])
                    ->where('roomno !=', $exploderoomaddname[6])
                    ->where('roomno !=', $exploderoomaddname[7])
                    ->where('roomno !=', $exploderoomaddname[8])
                    ->where('roomno !=', $exploderoomaddname[9])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('roomno !=', $exploderoomaddname[4])
                    ->where('roomno !=', $exploderoomaddname[5])
                    ->where('roomno !=', $exploderoomaddname[6])
                    ->where('roomno !=', $exploderoomaddname[7])
                    ->where('roomno !=', $exploderoomaddname[8])
                    ->where('roomno !=', $exploderoomaddname[9])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexroom)
                    ->order_by("name");
                }
            }
            else if($countexploderoomname === 9)
            {
                if($pxtypexroom === "ALL")
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('roomno !=', $exploderoomaddname[4])
                    ->where('roomno !=', $exploderoomaddname[5])
                    ->where('roomno !=', $exploderoomaddname[6])
                    ->where('roomno !=', $exploderoomaddname[7])
                    ->where('roomno !=', $exploderoomaddname[8])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('roomno !=', $exploderoomaddname[4])
                    ->where('roomno !=', $exploderoomaddname[5])
                    ->where('roomno !=', $exploderoomaddname[6])
                    ->where('roomno !=', $exploderoomaddname[7])
                    ->where('roomno !=', $exploderoomaddname[8])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexroom)
                    ->order_by("name");
                }
            }
            else if($countexploderoomname === 8)
            {
                if($pxtypexroom === "ALL")
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('roomno !=', $exploderoomaddname[4])
                    ->where('roomno !=', $exploderoomaddname[5])
                    ->where('roomno !=', $exploderoomaddname[6])
                    ->where('roomno !=', $exploderoomaddname[7])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('roomno !=', $exploderoomaddname[4])
                    ->where('roomno !=', $exploderoomaddname[5])
                    ->where('roomno !=', $exploderoomaddname[6])
                    ->where('roomno !=', $exploderoomaddname[7])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexroom)
                    ->order_by("name");
                }
            }
            else if($countexploderoomname === 7)
            {
                if($pxtypexroom === "ALL")
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('roomno !=', $exploderoomaddname[4])
                    ->where('roomno !=', $exploderoomaddname[5])
                    ->where('roomno !=', $exploderoomaddname[6])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('roomno !=', $exploderoomaddname[4])
                    ->where('roomno !=', $exploderoomaddname[5])
                    ->where('roomno !=', $exploderoomaddname[6])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexroom)
                    ->order_by("name");
                }
            }
            else if($countexploderoomname === 6)
            {
                if($pxtypexroom === "ALL")
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('roomno !=', $exploderoomaddname[4])
                    ->where('roomno !=', $exploderoomaddname[5])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('roomno !=', $exploderoomaddname[4])
                    ->where('roomno !=', $exploderoomaddname[5])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexroom)
                    ->order_by("name");
                }
            }
            else if($countexploderoomname === 5)
            {
                if($pxtypexroom === "ALL")
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('roomno !=', $exploderoomaddname[4])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('roomno !=', $exploderoomaddname[4])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexroom)
                    ->order_by("name");
                }
            }
            else if($countexploderoomname === 4)
            {
                if($pxtypexroom === "ALL")
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('roomno !=', $exploderoomaddname[3])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexroom)
                    ->order_by("name");
                }
            }
            else if($countexploderoomname === 3)
            {
                if($pxtypexroom === "ALL")
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('roomno !=', $exploderoomaddname[2])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexroom)
                    ->order_by("name");
                }
            }
            else if($countexploderoomname === 2)
            {
                if($pxtypexroom === "ALL")
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('roomno !=', $exploderoomaddname[1])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexroom)
                    ->order_by("name");
                }
            }
            else
            {
                if($pxtypexroom === "ALL")
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                    ->select('*')
                    ->from('inpatient')
                    ->where('roomno !=', $exploderoomaddname[0])
                    ->where('cityadd !=', "")
                    ->where('provadd !=', "")
                    ->where('roomno !=', "")
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtypexroom)
                    ->order_by("name");
                }
            }
        }
        else
        {
            if($roomaddname === "ALL ROOMS")
            {
                if($pxtypexroom === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexroom)
                     ->order_by("name");
                }
            }
            else
            {
                if($pxtypexroom === "ALL")
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('roomno', $roomaddname)
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->order_by("name");
                }
                else
                {
                    $this->hospv2_db
                     ->select('*')
                     ->from('inpatient')
                     ->where('roomno', $roomaddname)
                     ->where('cityadd !=', "")
                     ->where('provadd !=', "")
                     ->where('roomno !=', "")
                     ->where('admitdate >=',$first)
                     ->where('admitdate <=',$end)
                     ->where('pxtype',$pxtypexroom)
                     ->order_by("name");
                }
            }
        }

        $query = $this->hospv2_db->get();
        return $query->result_array();
    }
    
    public function get_crm_directory_path()
    {
        $this->localset_db
                ->select('*')
                ->from('reporting')
                ->where('systemapp = "drainwizv2"')
                ->where('module = "CRM"');
        $query = $this->localset_db->get();
        
        return $query->row_array();
    }
    
    public function get_inpatient_citymun_for_others($monthyear,$pxtype,$citynames)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $explodecitynames = explode("|", $citynames);
        $countexplodecityname = count($explodecitynames) - intval(1);   

        if($countexplodecityname === 10)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4]) 
                    ->where('cityadd !=', $explodecitynames[5]) 
                    ->where('cityadd !=', $explodecitynames[6]) 
                    ->where('cityadd !=', $explodecitynames[7])  
                    ->where('cityadd !=', $explodecitynames[8])
                    ->where('cityadd !=', $explodecitynames[9])    
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4]) 
                    ->where('cityadd !=', $explodecitynames[5]) 
                    ->where('cityadd !=', $explodecitynames[6]) 
                    ->where('cityadd !=', $explodecitynames[7])  
                    ->where('cityadd !=', $explodecitynames[8])
                    ->where('cityadd !=', $explodecitynames[9])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 9)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4]) 
                    ->where('cityadd !=', $explodecitynames[5]) 
                    ->where('cityadd !=', $explodecitynames[6]) 
                    ->where('cityadd !=', $explodecitynames[7])  
                    ->where('cityadd !=', $explodecitynames[8])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4]) 
                    ->where('cityadd !=', $explodecitynames[5]) 
                    ->where('cityadd !=', $explodecitynames[6]) 
                    ->where('cityadd !=', $explodecitynames[7])  
                    ->where('cityadd !=', $explodecitynames[8])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 8)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4]) 
                    ->where('cityadd !=', $explodecitynames[5]) 
                    ->where('cityadd !=', $explodecitynames[6]) 
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4]) 
                    ->where('cityadd !=', $explodecitynames[5]) 
                    ->where('cityadd !=', $explodecitynames[6]) 
                    ->where('cityadd !=', $explodecitynames[7])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 7)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4]) 
                    ->where('cityadd !=', $explodecitynames[5]) 
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4]) 
                    ->where('cityadd !=', $explodecitynames[5]) 
                    ->where('cityadd !=', $explodecitynames[6])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 6)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4]) 
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4]) 
                    ->where('cityadd !=', $explodecitynames[5])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 5)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('cityadd !=', $explodecitynames[4])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 4)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('cityadd !=', $explodecitynames[3])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 3)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('cityadd !=', $explodecitynames[2])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodecityname === 2)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('cityadd !=', $explodecitynames[1])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else
        {
            if($pxtype === "ALL")
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('cityadd, count(cityadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('cityadd !=', $explodecitynames[0])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_inpatient_province_for_others($monthyear,$pxtype,$provnames)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $explodeprovnames = explode("|", $provnames);
        $countexplodeprovnames = count($explodeprovnames) - intval(1);   

        if($countexplodeprovnames === 10)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4]) 
                    ->where('provadd !=', $explodeprovnames[5]) 
                    ->where('provadd !=', $explodeprovnames[6]) 
                    ->where('provadd !=', $explodeprovnames[7])  
                    ->where('provadd !=', $explodeprovnames[8])
                    ->where('provadd !=', $explodeprovnames[9])    
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4]) 
                    ->where('provadd !=', $explodeprovnames[5]) 
                    ->where('provadd !=', $explodeprovnames[6]) 
                    ->where('provadd !=', $explodeprovnames[7])  
                    ->where('provadd !=', $explodeprovnames[8])
                    ->where('provadd !=', $explodeprovnames[9])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 9)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4]) 
                    ->where('provadd !=', $explodeprovnames[5]) 
                    ->where('provadd !=', $explodeprovnames[6]) 
                    ->where('provadd !=', $explodeprovnames[7])  
                    ->where('provadd !=', $explodeprovnames[8])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4]) 
                    ->where('provadd !=', $explodeprovnames[5]) 
                    ->where('provadd !=', $explodeprovnames[6]) 
                    ->where('provadd !=', $explodeprovnames[7])  
                    ->where('provadd !=', $explodeprovnames[8])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 8)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4]) 
                    ->where('provadd !=', $explodeprovnames[5]) 
                    ->where('provadd !=', $explodeprovnames[6]) 
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4]) 
                    ->where('provadd !=', $explodeprovnames[5]) 
                    ->where('provadd !=', $explodeprovnames[6]) 
                    ->where('provadd !=', $explodeprovnames[7])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 7)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4]) 
                    ->where('provadd !=', $explodeprovnames[5]) 
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4]) 
                    ->where('provadd !=', $explodeprovnames[5]) 
                    ->where('provadd !=', $explodeprovnames[6])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 6)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4]) 
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4]) 
                    ->where('provadd !=', $explodeprovnames[5])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 5)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('provadd !=', $explodeprovnames[4])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 4)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('provadd !=', $explodeprovnames[3])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 3)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('provadd !=', $explodeprovnames[2])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodeprovnames === 2)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('provadd !=', $explodeprovnames[1])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else
        {
            if($pxtype === "ALL")
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('provadd, count(provadd) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('provadd !=', $explodeprovnames[0])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_inpatient_insurance_for_others($monthyear,$pxtype,$hmonames)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $explodehmonames = explode("|", $hmonames);
        $countexplodehmonames = count($explodehmonames) - intval(1);   
        
//        var_dump($explodehmonames[1]);
//        exit(0);
//        

        if($countexplodehmonames === 10)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4]) 
                    ->where('hmoname !=', $explodehmonames[5]) 
                    ->where('hmoname !=', $explodehmonames[6]) 
                    ->where('hmoname !=', $explodehmonames[7])  
                    ->where('hmoname !=', $explodehmonames[8])
                    ->where('hmoname !=', $explodehmonames[9])    
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4]) 
                    ->where('hmoname !=', $explodehmonames[5]) 
                    ->where('hmoname !=', $explodehmonames[6]) 
                    ->where('hmoname !=', $explodehmonames[7])  
                    ->where('hmoname !=', $explodehmonames[8])
                    ->where('hmoname !=', $explodehmonames[9])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 9)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4]) 
                    ->where('hmoname !=', $explodehmonames[5]) 
                    ->where('hmoname !=', $explodehmonames[6]) 
                    ->where('hmoname !=', $explodehmonames[7])  
                    ->where('hmoname !=', $explodehmonames[8])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4]) 
                    ->where('hmoname !=', $explodehmonames[5]) 
                    ->where('hmoname !=', $explodehmonames[6]) 
                    ->where('hmoname !=', $explodehmonames[7])  
                    ->where('hmoname !=', $explodehmonames[8])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 8)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4]) 
                    ->where('hmoname !=', $explodehmonames[5]) 
                    ->where('hmoname !=', $explodehmonames[6]) 
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4]) 
                    ->where('hmoname !=', $explodehmonames[5]) 
                    ->where('hmoname !=', $explodehmonames[6]) 
                    ->where('hmoname !=', $explodehmonames[7])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 7)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4]) 
                    ->where('hmoname !=', $explodehmonames[5]) 
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4]) 
                    ->where('hmoname !=', $explodehmonames[5]) 
                    ->where('hmoname !=', $explodehmonames[6])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 6)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4]) 
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4]) 
                    ->where('hmoname !=', $explodehmonames[5])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 5)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('hmoname !=', $explodehmonames[4])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 4)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('hmoname !=', $explodehmonames[3])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 3)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('hmoname !=', $explodehmonames[2])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexplodehmonames === 2)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('hmoname !=', $explodehmonames[1])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else
        {
            if($pxtype === "ALL")
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('hmoname, count(hmoname) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('hmoname !=', $explodehmonames[0])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_inpatient_room_for_others($monthyear,$pxtype,$roomnames)
    {
        $monthstart = date("Y-m-01", strtotime($monthyear."-01"));
        $monthend =  date("Y-m-t", strtotime($monthyear."-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e= new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $exploderoomnames = explode("|", $roomnames);
        $countexploderoomnames = count($exploderoomnames) - intval(1);   

        if($countexploderoomnames === 10)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4]) 
                    ->where('roomno !=', $exploderoomnames[5]) 
                    ->where('roomno !=', $exploderoomnames[6]) 
                    ->where('roomno !=', $exploderoomnames[7])  
                    ->where('roomno !=', $exploderoomnames[8])
                    ->where('roomno !=', $exploderoomnames[9])    
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4]) 
                    ->where('roomno !=', $exploderoomnames[5]) 
                    ->where('roomno !=', $exploderoomnames[6]) 
                    ->where('roomno !=', $exploderoomnames[7])  
                    ->where('roomno !=', $exploderoomnames[8])
                    ->where('roomno !=', $exploderoomnames[9])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 9)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4]) 
                    ->where('roomno !=', $exploderoomnames[5]) 
                    ->where('roomno !=', $exploderoomnames[6]) 
                    ->where('roomno !=', $exploderoomnames[7])  
                    ->where('roomno !=', $exploderoomnames[8])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4]) 
                    ->where('roomno !=', $exploderoomnames[5]) 
                    ->where('roomno !=', $exploderoomnames[6]) 
                    ->where('roomno !=', $exploderoomnames[7])  
                    ->where('roomno !=', $exploderoomnames[8])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 8)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4]) 
                    ->where('roomno !=', $exploderoomnames[5]) 
                    ->where('roomno !=', $exploderoomnames[6]) 
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4]) 
                    ->where('roomno !=', $exploderoomnames[5]) 
                    ->where('roomno !=', $exploderoomnames[6]) 
                    ->where('roomno !=', $exploderoomnames[7])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 7)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4]) 
                    ->where('roomno !=', $exploderoomnames[5]) 
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4]) 
                    ->where('roomno !=', $exploderoomnames[5]) 
                    ->where('roomno !=', $exploderoomnames[6])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 6)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4]) 
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4]) 
                    ->where('roomno !=', $exploderoomnames[5])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 5)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('roomno !=', $exploderoomnames[4])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 4)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('roomno !=', $exploderoomnames[3])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 3)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('roomno !=', $exploderoomnames[2])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else if($countexploderoomnames === 2)
        {
            if($pxtype === "ALL")
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('roomno !=', $exploderoomnames[1])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        else
        {
            if($pxtype === "ALL")
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end);
            }
            else
            {
                $this->db->select('roomno, count(roomno) as "MAX_COUNT_OTHERS"')
                    ->from(inpatient_tbl)
                    ->order_by('MAX_COUNT_OTHERS','DESC')
                    ->where('provadd !=""')  
                    ->where('roomno !=""')
                    ->where('cityadd !=""')
                    ->where('roomno !=', $exploderoomnames[0])
                    ->where('admitdate >=',$first)
                    ->where('admitdate <=',$end)
                    ->where('pxtype',$pxtype);
            }
        }
        
        $query = $this->db->get();
        return $query->result();
    }
}
