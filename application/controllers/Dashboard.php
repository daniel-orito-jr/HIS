<?php

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model', 'dashboard_model');
            $this->load->model('user_model');
    }

    public function index() {
        if ($this->has_log_in()) {

            $data["page_title"] = "Dashboard";
            $data["census"] = $this->user_model->today_census();
            $data["census_month"] = $this->user_model->get_daily_census();
//            
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/jquery-countto/jquery.countTo.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/plugins/Flot/jquery.flot.js',
                'assets/vendors/plugins/Flot/jquery.flot.resize.js',
                'assets/vendors/plugins/Flot/jquery.flot.pie.js',
                'assets/vendors/plugins/Flot/jquery.flot.canvas.js',
                'assets/vendors/plugins/flot-charts/jquery.flot.categories.js',
                'assets/vendors/plugins/flot-charts/jquery.flot.time.js',
//                'assets/vendors/plugins/Flot/jquery.flot.barlabels.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
                'assets/js/dashboard.js',
                'assets/js/lock.js');
            
            $this->user_page('dashboard', $data);
        }else{
            redirect(base_url("user/index"));
        }
    }

    public function getUnpreparedClaims() {
        $result = array('status' => FALSE);

        if ($this->dashboard_model->getUnpreparedClaims()) {
            $result['getUnpreparedClaims'] = $this->dashboard_model->getUnpreparedClaims();
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }

    public function getPendingClaims() {
        $result = array('status' => FALSE);

        if ($this->dashboard_model->getPendingClaims()) {
            $result['getPendingClaims'] = $this->dashboard_model->getPendingClaims();
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }
 
    public function getSentClaims() {
        $result = array('status' => FALSE);
        $sentEclaimsDate = $this->input->post('sentEclaimsDate');
        $getSentClaims = $this->dashboard_model->getSentClaims($sentEclaimsDate);
        if ($getSentClaims) {
            $result['getSentClaims'] = $getSentClaims;
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }
    
    public function getPHARoftheMonth() {
        $result = array('status' => FALSE);

        if ($this->dashboard_model->getPHARoftheMonth()) {
            $result['getPHARoftheMonth'] = $this->dashboard_model->getPHARoftheMonth();
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }
    
    public function getAdmitDischargeDaily()
    {   
        $result = array('status' => FALSE);
        $admitDischaDate = $this->input->post('admitDischaDate');
        $getAdmitDischargeDaily = $this->dashboard_model->getAdmitDischargeDaily($admitDischaDate);
        if($getAdmitDischargeDaily)
        {
            $result['getAdmitDischargeDaily'] = $getAdmitDischargeDaily;
            $result['status'] = true;
        }
        echo json_encode($result);
    }
    
     public function getTotalAccPHICAR()
    {   
        $result = array('status' => FALSE);
        $getTotalAccPHICAR = $this->dashboard_model->getTotalAccPHICAR();
        if($getTotalAccPHICAR)
        {
            $result['getTotalAccPHICAR'] = $getTotalAccPHICAR;
            $result['status'] = true;
        }
        echo json_encode($result);
    }
    
    public function getPaymentForTheMonth()
    {   
        $result = array('status' => FALSE);
        $getPaymentForTheMonth = $this->dashboard_model->getPaymentForTheMonth();
        if($getPaymentForTheMonth)
        {
            $result['getPaymentForTheMonth'] = $getPaymentForTheMonth;
            $result['status'] = true;
        }
        echo json_encode($result);
    }
    
     public function fetch_monthlyphilhealthpayments()
    {
        $s_date = new DateTime($this->input->post('month'));
        $fetch_data = $this->dashboard_model->make_monthlyphilhealthpayments_datatables($s_date->format('Y-m-d'));  
        $fetch_total = $this->dashboard_model->monthlyPhilhealthPayments($s_date->format('Y-m-d'));  
        $data = array();  
        $total = array('hcifee' => 0.00, 'profee' => 0.00);
        $total['hcifee'] = $fetch_total['hospfee'];
        $total['profee'] = $fetch_total['profee'];
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();
            $sub_array[] = $row->CSNO;   
            $sub_array[] = $row->PatientName;   
            $sub_array[] = $this->format_money($row->hcifee); 
            $sub_array[] = $this->format_money($row->profee); 
            $sub_array[] = $this->format_date($row->dischargedate); 
            $sub_array[] = $this->format_date($row->proc1date); 
            $sub_array[] =  $row->age;
            $sub_array[] = $row->pStatus;
            $sub_array[] = $this->format_date($row->processdate);
            $data[] = $sub_array;    
        }  
        $output = array(  
            "draw"                =>     intval($this->input->post("draw")),  
            "recordsTotal"        =>     $this->dashboard_model->get_monthlyphilhealthpayments_data($s_date->format('Y-m-d')),  
            "recordsFiltered"     =>     $this->dashboard_model->get_monthlyphilhealthpayments_filtered_data($s_date->format('Y-m-d')),  
            "data"                =>     $data,
            "totalx"              =>     $total
            
        );  
        echo json_encode($output); 
    }
    
    public function getProfitandLoss() {
        $result = array('status' => FALSE);
        $month = $this->input->post('month');
        $costcenter = $this->input->post('costcenter');
        $getProfitandLoss = $this->dashboard_model->getProfitandLoss($month,$costcenter);
        if ($getProfitandLoss) {
            $result['getProfitandLoss'] = $getProfitandLoss;
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }
    
    public function fetchCostCenter() {
        $result = array('status' => FALSE);
        $month = $this->input->post('month');
        $fetchCostCenter = $this->dashboard_model->fetchCostCenter($month);
        if ($fetchCostCenter) {
            $result['fetchCostCenter'] = $fetchCostCenter;
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }
    
    public function getExpenses() {
        $result = array('status' => FALSE);
        $month = $this->input->post('month');
        $getExpenses = $this->dashboard_model->getExpenses($month);
        if ($getExpenses) {
            $result['getExpenses'] = $getExpenses;
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }
    
     public function getPxType() {
        $result = array('status' => FALSE);
        $month = $this->input->post('month');
        $getPxType = $this->dashboard_model->getPxType($month);
        if ($getPxType) {
            $result['getPxType'] = $getPxType;
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }
    
    public function getInpatientGender()
    {
        $result = array('status' => FALSE);
        $monthyear = $this->input->post('monthyearx');
        $pxtype = $this->input->post('pxtypex');
        
        $getinpatientgender = $this->dashboard_model->get_inpatient_gender($monthyear,$pxtype);
        if ($getinpatientgender) 
        {
            $result['getinpatientgender'] = $getinpatientgender;
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }
    
    public function getInpatientAge()
    {
        $result = array('status' => FALSE);
        $monthyear = $this->input->post('monthyearx');
        $pxtype = $this->input->post('pxtypex');
        
        $getinpatientage = $this->dashboard_model->get_inpatient_age($monthyear,$pxtype);
        if ($getinpatientage) 
        {
            $result['getinpatientage'] = $getinpatientage;
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }
    
    public function getInpatientCityMunicipality()
    {
        $result = array('status' => FALSE);
        
        $monthyear = $this->input->post('monthyearx');
        $pxtype = $this->input->post('pxtypex');
        
        $getinpatientcitymun = $this->dashboard_model->get_inpatient_citymun($monthyear,$pxtype);
        if ($getinpatientcitymun) 
        {
            $result['getinpatientcitymun'] = $getinpatientcitymun;
            $result['status'] = TRUE;
        }
        
        echo json_encode($result);
    }
    
    public function getInpatientProvince()
    {
        $result = array('status' => FALSE);
        
        $monthyear = $this->input->post('monthyearx');
        $pxtype = $this->input->post('pxtypex');
        
        $getinpatientprovince = $this->dashboard_model->get_inpatient_province($monthyear,$pxtype);
        if ($getinpatientprovince) 
        {
            $result['getinpatientprovince'] = $getinpatientprovince;
            $result['status'] = TRUE;
        }
        
        echo json_encode($result);
    }
    
    public function getInpatientInsurance()
    {
        $result = array('status' => FALSE);
        
        $monthyear = $this->input->post('monthyearx');
        $pxtype = $this->input->post('pxtypex');
        
        $getinpatientinsurance = $this->dashboard_model->get_inpatient_insurance($monthyear,$pxtype);
        if ($getinpatientinsurance) 
        {
            $result['getinpatientinsurance'] = $getinpatientinsurance;
            $result['status'] = TRUE;
        }
        
        echo json_encode($result);
    }
    
    public function getInpatientRoomOccupancyRate()
    {
        $result = array('status' => FALSE);
        
        $monthyear = $this->input->post('monthyearx');
        $pxtype = $this->input->post('pxtypex');
        
        $getinpatientroomoccupancyrate = $this->dashboard_model->get_inpatient_room_occupancy_rate($monthyear,$pxtype);
        if ($getinpatientroomoccupancyrate) 
        {
            $result['getinpatientroomoccupancyrate'] = $getinpatientroomoccupancyrate;
            $result['status'] = TRUE;
        }
        
        echo json_encode($result);
    }
    
    public function getLaboratoryLedgersalesRequestVolume()
    {
        $result = array('status' => FALSE);
        $monthyear = $this->input->post('monthyearx');
        
        $getlabrequestvolume = $this->dashboard_model->get_laboratory_ledgersales_request_volume($monthyear);
        $getradrequestvolume = $this->dashboard_model->get_radiology_ledgersales_request_volume($monthyear);
        $getpharequestvolume = $this->dashboard_model->get_pharmacy_ledgersales_request_volume($monthyear);
        
        if ($getlabrequestvolume && $getradrequestvolume && $getpharequestvolume) 
        {
            $result['getlabrequestvolume'] = $getlabrequestvolume;
            $result['getradrequestvolume'] = $getradrequestvolume;
            $result['getpharequestvolume'] = $getpharequestvolume;
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }
    
    public function getTotalIncome() {
        $result = array('status' => FALSE);
        $month = $this->input->post('month');
        $getTotalIncome = $this->dashboard_model->getTotalIncome($month);
        if ($getTotalIncome) {
            $result['getTotalIncome'] = $getTotalIncome;
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }
    
     public function getProfitOrLoss()
    {
        $month = $this->input->post('month');
        $type = $this->input->post('type');
        $costcenter = $this->input->post('costcenter');
        $fetch_data = $this->dashboard_model->make_ProfitOrLoss_datatables($type,$month,$costcenter);  
        $data = array();  

        foreach($fetch_data as $row)  
        {  
            $sub_array = array();
            $sub_array[] = $row->COAcode;   
            $sub_array[] = $row->coadscr;   
            if($type == "PROFIT")
            {
               $sub_array[] = $this->format_money($row->creditBD);  
            }else{
                $sub_array[] = $this->format_money($row->debitBD);  
            }
            
            $sub_array[] = $row->COSTCNTRNAME; 
            $data[] = $sub_array;    
        }  
        $output = array(  
            "draw"                =>     intval($this->input->post("draw")),  
            "recordsTotal"        =>     $this->dashboard_model->getProfitOrLoss_data($type,$month,$costcenter),  
            "recordsFiltered"     =>     $this->dashboard_model->getProfitOrLoss_filtered_data($type,$month,$costcenter),  
            "data"                =>     $data
            
        );  
        echo json_encode($output); 
    }
   
    public function GetAllPatientViaCitymunParameter() 
    {
        $cityname = $this->input->post('barcityname', TRUE);
        $fulldate = $this->input->post('fulldate', TRUE);
        $pxtype = $this->input->post('pxtypex', TRUE); 
        
        $fetched_data = $this->dashboard_model->fetch_inpatients_masterlist_datatables($cityname, $fulldate, $pxtype);
        $data = array();

        foreach ($fetched_data as $row) 
        {
            $sub_array = array();
            
            $birthdate = new DateTime($row->bday);
            $birthday = $birthdate->format('F j, Y');

            $admitdate = new DateTime($row->admitdate);
            $admitday = $admitdate->format('F j, Y');

            $sub_array[] = "";
            $sub_array[] = $row->name;
            $sub_array[] = $admitday;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $birthday;
            $sub_array[] = $row->adrs." ".$row->brgy.", ".$row->cityadd." ".$row->provadd;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->recby;

            $data[] = $sub_array;
        }

        $output = array
        (
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->dashboard_model->fetch_inpatients_masterlist_data($cityname, $fulldate, $pxtype),
            "recordsFiltered" => $this->dashboard_model->fetch_inpatients_masterlist_filtered_data($cityname, $fulldate, $pxtype),
            "data" => $data
        );
        echo json_encode($output);
    }
    
    public function GetAllPatientViaCitymunParameterOthers() 
    {
        $citynames = $this->input->post('barcityname', TRUE);
        $fulldate = $this->input->post('fulldate', TRUE);
        $pxtype = $this->input->post('pxtypex', TRUE); 
        
        $fetched_data = $this->dashboard_model->fetch_inpatients_others_masterlist_datatables($citynames, $fulldate, $pxtype);
        $data = array();

        foreach ($fetched_data as $row) 
        {
            $sub_array = array();

            $birthdate = new DateTime($row->bday);
            $birthday = $birthdate->format('F j, Y');

            $admitdate = new DateTime($row->admitdate);
            $admitday = $admitdate->format('F j, Y');
            
            $sub_array[] = "";
            $sub_array[] = $row->name;
            $sub_array[] = $admitday;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $birthday;
            $sub_array[] = $row->adrs." ".$row->brgy.", ".$row->cityadd." ".$row->provadd;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->recby;

            $data[] = $sub_array;
        }

        $output = array
        (
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->dashboard_model->fetch_inpatients_others_masterlist_data($citynames, $fulldate, $pxtype),
            "recordsFiltered" => $this->dashboard_model->fetch_inpatients_others_masterlist_filtered_data($citynames, $fulldate, $pxtype),
            "data" => $data
        );
        
        echo json_encode($output);
    }
    
    public function GetAllPatientViaProvinceParameter() 
    {
        $provname = $this->input->post('barprovname', TRUE);
        $fulldate = $this->input->post('fulldate', TRUE);
        $pxtypexx = $this->input->post('pxtypex', TRUE);

        $fetched_data = $this->dashboard_model->fetch_inpatients_provparam_masterlist_datatables($provname, $fulldate, $pxtypexx);

        $data = array();

        foreach ($fetched_data as $row) 
        {
            $sub_array = array();

            $birthdate = new DateTime($row->bday);
            $birthday = $birthdate->format('F j, Y');

            $admitdate = new DateTime($row->admitdate);
            $admitday = $admitdate->format('F j, Y');
            
            $sub_array[] = "";
            $sub_array[] = $row->name;
            $sub_array[] = $admitday;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $birthday;
            $sub_array[] = $row->adrs." ".$row->brgy.", ".$row->cityadd." ".$row->provadd;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->recby;

            $data[] = $sub_array;
        }

        $output = array
        (
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->dashboard_model->fetch_inpatients_provparam_masterlist_data($provname, $fulldate, $pxtypexx),
            "recordsFiltered" => $this->dashboard_model->fetch_inpatients_provparam_masterlist_filtered_data($provname, $fulldate, $pxtypexx),
            "data" => $data
        );
        echo json_encode($output);
    }
    
    public function GetAllPatientViaInsuranceParameter() 
    {
        $hmoxname = $this->input->post('hmoname', TRUE);
        $fulldate = $this->input->post('fulldate', TRUE);
        $pxtypexx = $this->input->post('pxtypex', TRUE);

        $fetched_data = $this->dashboard_model->fetch_inpatients_insurance_masterlist_datatables($hmoxname, $fulldate, $pxtypexx);

        $data = array();

        foreach ($fetched_data as $row) 
        {
            $sub_array = array();

            $birthdate = new DateTime($row->bday);
            $birthday = $birthdate->format('F j, Y');

            $admitdate = new DateTime($row->admitdate);
            $admitday = $admitdate->format('F j, Y');
            
            $sub_array[] = "";
            $sub_array[] = $row->name;
            $sub_array[] = $admitday;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $birthday;
            $sub_array[] = $row->adrs." ".$row->brgy.", ".$row->cityadd." ".$row->provadd;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->recby;

            $data[] = $sub_array;
        }

        $output = array
        (
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->dashboard_model->fetch_inpatients_insurance_masterlist_data($hmoxname, $fulldate, $pxtypexx),
            "recordsFiltered" => $this->dashboard_model->fetch_inpatients_insurance_masterlist_filtered_data($hmoxname, $fulldate, $pxtypexx),
            "data" => $data
        );
        echo json_encode($output);
    }
    
    public function GetAllPatientViaProvinceParameterOthers() 
    {
        $provnames = $this->input->post('barprovname', TRUE);
        $fulldate = $this->input->post('fulldate', TRUE);
        $pxtype = $this->input->post('pxtypex', TRUE); 
        
        $fetched_data = $this->dashboard_model->fetch_inpatients_provadd_others_masterlist_datatables($provnames, $fulldate, $pxtype);
        $data = array();

        foreach ($fetched_data as $row) 
        {
            $sub_array = array();

            $birthdate = new DateTime($row->bday);
            $birthday = $birthdate->format('F j, Y');

            $admitdate = new DateTime($row->admitdate);
            $admitday = $admitdate->format('F j, Y');
            
            $sub_array[] = "";
            $sub_array[] = $row->name;
            $sub_array[] = $admitday;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $birthday;
            $sub_array[] = $row->adrs." ".$row->brgy.", ".$row->cityadd." ".$row->provadd;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->recby;

            $data[] = $sub_array;
        }

        $output = array
        (
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->dashboard_model->fetch_inpatients_provadd_others_masterlist_data($provnames, $fulldate, $pxtype),
            "recordsFiltered" => $this->dashboard_model->fetch_inpatients_provadd_others_masterlist_filtered_data($provnames, $fulldate, $pxtype),
            "data" => $data
        );
        
        echo json_encode($output);
    }
    
    public function GetAllPatientViaInsuranceParameterOthers() 
    {
        $hmonames = $this->input->post('hmonames', TRUE);
        $fulldate = $this->input->post('fulldate', TRUE);
        $pxtype = $this->input->post('pxtypex', TRUE); 
        
        $fetched_data = $this->dashboard_model->fetch_inpatients_insurance_others_masterlist_datatables($hmonames, $fulldate, $pxtype);
        $data = array();

        foreach ($fetched_data as $row) 
        {
            $sub_array = array();

            $birthdate = new DateTime($row->bday);
            $birthday = $birthdate->format('F j, Y');

            $admitdate = new DateTime($row->admitdate);
            $admitday = $admitdate->format('F j, Y');
            
            $sub_array[] = "";
            $sub_array[] = $row->name;
            $sub_array[] = $admitday;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $birthday;
            $sub_array[] = $row->adrs." ".$row->brgy.", ".$row->cityadd." ".$row->provadd;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->recby;

            $data[] = $sub_array;
        }

        $output = array
        (
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->dashboard_model->fetch_inpatients_insurance_others_masterlist_data($hmonames, $fulldate, $pxtype),
            "recordsFiltered" => $this->dashboard_model->fetch_inpatients_insurance_others_masterlist_filtered_data($hmonames, $fulldate, $pxtype),
            "data" => $data
        );
        
        echo json_encode($output);
    }
    
    public function GetAllPatientViaRoomrateParameter() 
    {
        $roomname = $this->input->post('barroomname', TRUE);
        $fulldate = $this->input->post('fulldate', TRUE);
        $pxtypexx = $this->input->post('pxtypex', TRUE);

        $fetched_data = $this->dashboard_model->fetch_inpatients_roomparam_masterlist_datatables($roomname, $fulldate, $pxtypexx);

        $data = array();

        foreach ($fetched_data as $row) 
        {
            $sub_array = array();
            
            $birthdate = new DateTime($row->bday);
            $birthday = $birthdate->format('F j, Y');

            $admitdate = new DateTime($row->admitdate);
            $admitday = $admitdate->format('F j, Y');
            
            $sub_array[] = "";
            $sub_array[] = $row->name;
            $sub_array[] = $admitday;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $birthday;
            $sub_array[] = $row->adrs." ".$row->brgy.", ".$row->cityadd." ".$row->provadd;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->recby;

            $data[] = $sub_array;
        }

        $output = array
        (
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->dashboard_model->fetch_inpatients_roomparam_masterlist_data($roomname, $fulldate, $pxtypexx),
            "recordsFiltered" => $this->dashboard_model->fetch_inpatients_roomparam_masterlist_filtered_data($roomname, $fulldate, $pxtypexx),
            "data" => $data
        );
        echo json_encode($output);
    }
    
    public function GetAllPatientViaRoomrateParameterOthers() 
    {
        $roomnames = $this->input->post('barroomname', TRUE);
        $fulldate = $this->input->post('fulldate', TRUE);
        $pxtypexx = $this->input->post('pxtypex', TRUE);

        $fetched_data = $this->dashboard_model->fetch_inpatients_roomrate_others_masterlist_datatables($roomnames, $fulldate, $pxtypexx);

        $data = array();

        foreach ($fetched_data as $row) 
        {
            $sub_array = array();
            
            $birthdate = new DateTime($row->bday);
            $birthday = $birthdate->format('F j, Y');

            $admitdate = new DateTime($row->admitdate);
            $admitday = $admitdate->format('F j, Y');
            
            $sub_array[] = "";
            $sub_array[] = $row->name;
            $sub_array[] = $admitday;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $birthday;
            $sub_array[] = $row->adrs." ".$row->brgy.", ".$row->cityadd." ".$row->provadd;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->recby;

            $data[] = $sub_array;
        }

        $output = array
        (
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->dashboard_model->fetch_inpatients_roomrate_others_masterlist_data($roomnames, $fulldate, $pxtypexx),
            "recordsFiltered" => $this->dashboard_model->fetch_inpatients_roomrate_others_masterlist_filtered_data($roomnames, $fulldate, $pxtypexx),
            "data" => $data
        );
        echo json_encode($output);
    }
    
    public function GetAllPatientViaAgeCategoryParameter() 
    {
        $agecateg = $this->input->post('agecateg', TRUE);
        $fulldate = $this->input->post('fulldate', TRUE);
        $pxtypexx = $this->input->post('pxtypex', TRUE);

        $fetched_data = $this->dashboard_model->fetch_inpatients_agecateg_masterlist_datatables($agecateg, $fulldate, $pxtypexx);

        $data = array();

        foreach ($fetched_data as $row) 
        {
            $sub_array = array();
            
            $birthdate = new DateTime($row->bday);
            $birthday = $birthdate->format('F j, Y');

            $admitdate = new DateTime($row->admitdate);
            $admitday = $admitdate->format('F j, Y');
            
            $sub_array[] = "";
            $sub_array[] = $row->name;
            $sub_array[] = $admitday;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $birthday;
            $sub_array[] = $row->adrs." ".$row->brgy.", ".$row->cityadd." ".$row->provadd;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->recby;

            $data[] = $sub_array;
        }

        $output = array
        (
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->dashboard_model->fetch_inpatients_agecateg_masterlist_data($agecateg, $fulldate, $pxtypexx),
            "recordsFiltered" => $this->dashboard_model->fetch_inpatients_agecateg_masterlist_filtered_data($agecateg, $fulldate, $pxtypexx),
            "data" => $data
        );
        echo json_encode($output);
    }
    
    public function GetAllPatientViaSexCategoryParameter() 
    {
        $sexcateg = $this->input->post('sexcateg', TRUE);
        $fulldate = $this->input->post('fulldate', TRUE);
        $pxtypexx = $this->input->post('pxtypex', TRUE);

        $fetched_data = $this->dashboard_model->fetch_inpatients_sexcateg_masterlist_datatables($sexcateg, $fulldate, $pxtypexx);

        $data = array();

        foreach ($fetched_data as $row) 
        {
            $sub_array = array();
            
            $birthdate = new DateTime($row->bday);
            $birthday = $birthdate->format('F j, Y');

            $admitdate = new DateTime($row->admitdate);
            $admitday = $admitdate->format('F j, Y');
            
            $sub_array[] = "";
            $sub_array[] = $row->name;
            $sub_array[] = $admitday;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $birthday;
            $sub_array[] = $row->adrs." ".$row->brgy.", ".$row->cityadd." ".$row->provadd;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->recby;

            $data[] = $sub_array;
        }

        $output = array
        (
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->dashboard_model->fetch_inpatients_sexcateg_masterlist_data($sexcateg, $fulldate, $pxtypexx),
            "recordsFiltered" => $this->dashboard_model->fetch_inpatients_sexcateg_masterlist_filtered_data($sexcateg, $fulldate, $pxtypexx),
            "data" => $data
        );
        echo json_encode($output);
    }
    
    public function PatientListingViaAgeCategoryGeneratedData()
    {
        if ($this->has_log_in())
        {
            $this->load->library('javabridge');
            
            $this->javabridge->load_system();
            $this->javabridge->load_class();

            $compileManager = $this->javabridge->load_manager($type = 'compiler');
            
            $getcrmdirectory = $this->dashboard_model->get_crm_directory_path();
            $reportdirectory = $getcrmdirectory['directory'];
            $reportmodulexxx = $getcrmdirectory['module'];
            $targetjrxml = $reportdirectory.$reportmodulexxx."/PatientListingViaMunicipality.jrxml";
            
            $report = $compileManager->compileReport($targetjrxml);

            $fillManager = $this->javabridge->load_manager($type = 'importer');
            $emptyDataSource = $this->javabridge->load_datasource($source = 'emptydata');
            
            $params = $this->javabridge->load_util($util = 'hashmap');
            
            $arrayListTableData = $this->javabridge->load_util($util = 'arraylist');
            
            $agecategory = $this->input->post('hiddenname_agecatename');
            $daterequest = $this->input->post('hiddenname_daterequest');
            $patienttype = $this->input->post('hiddenname_patienttype');
            
            $data = [];
            $patient = $this->dashboard_model->getPatientViaAgeCategoryParameter($daterequest,$patienttype,$agecategory);

            $stringnumb = $stringname = $stringadmd = $stringpxcl = $stringagex = $stringbday = "";
            $stringadrs = $stringroom = $stringdocs = $stringphic = $stringadmb = "";
            
            for ($cv = 0; $cv < count($patient); $cv++)
            {
                $counter = intval($cv) + intval(1);
                $stringnumb = $stringnumb.$counter."|";
                $stringname = $stringname.$patient[$cv]['name']."|";
                $stringadmd = $stringadmd.$patient[$cv]['admitdate']."|";
                $stringpxcl = $stringpxcl.$patient[$cv]['pat_classification']."|";
                $stringagex = $stringagex.$patient[$cv]['Age']."|";
                $stringbday = $stringbday.$patient[$cv]['bday']."|";
                $stringadrs = $stringadrs.$patient[$cv]['cityadd'].", ".$patient[$cv]['provadd']."|";
                $stringroom = $stringroom.$patient[$cv]['roombrief']."|";
                $stringdocs = $stringdocs.$patient[$cv]['doctorname']."|";
                $stringphic = $stringphic.$patient[$cv]['phicmembr']."|";
                $stringadmb = $stringadmb.$patient[$cv]['recby']."|";
            }

            $firstDimensionNumb = explode('|', $stringnumb);
            $firstDimensionName = explode('|', $stringname);
            $firstDimensionAdmd = explode('|', $stringadmd);
            $firstDimensionPxcl = explode('|', $stringpxcl);
            $firstDimensionAgex = explode('|', $stringagex);
            $firstDimensionBday = explode('|', $stringbday); 
            $firstDimensionAdrs = explode('|', $stringadrs);
            $firstDimensionRoom = explode('|', $stringroom);
            $firstDimensionDocs = explode('|', $stringdocs);
            $firstDimensionPhic = explode('|', $stringphic);
            $firstDimensionAdmb = explode('|', $stringadmb);

            $count = count($firstDimensionName);

            for ($i = 0; $i < $count - 1; $i++)
            {
                $birthdate = new DateTime($firstDimensionBday[$i]);
                $birthday = $birthdate->format('F j, Y');
                
                $admitdate = new DateTime($firstDimensionAdmd[$i]);
                $admitday = $admitdate->format('F j, Y');
                
                $data['HeaderNumber']   = strtoupper($firstDimensionNumb[$i]);
                $data['HeaderPxName']   = strtoupper($firstDimensionName[$i]);
                $data['HeaderAdmdate']  = strtoupper($admitday);
                $data['HeaderPatclass'] = strtoupper($firstDimensionPxcl[$i]);
                $data['HeaderPatAge']   = strtoupper($firstDimensionAgex[$i]);
                $data['HeaderPxBirth']  = strtoupper($birthday);
                $data['HeaderAddress']  = strtoupper($firstDimensionAdrs[$i]);
                $data['HeaderRoom']     = strtoupper($firstDimensionRoom[$i]);
                $data['HeaderDoctor']   = strtoupper($firstDimensionDocs[$i]);
                $data['HeaderPhealth']  = strtoupper($firstDimensionPhic[$i]);
                $data['HeaderAdmby']    = strtoupper($firstDimensionAdmb[$i]);
                
                $arrayListTableData->add($data);
            }
            
            $beanCollectionTableData = $this->javabridge->load_datasource($source = 'multidata', $arrayListTableData);
            
            $params->put("CompanyLogo","C:/xampp/htdocs/drainwizv2/assets/img/logo.png");
            $params->put('CompanyName', "DRAINWIZ SYSTEMS INC.");
            $params->put('CompanyAdrs', "Echaves St. Dipolog City, Zamboanga Del Norte 7100");
            $params->put('CompanyCont', "(+639)38-278-6751");
            $params->put('SelectedMonth', strval($daterequest));
            $params->put('PatientListDataSource', $beanCollectionTableData);
            
            if($agecategory === "ALL")
            {
                $params->put('CRMReportTitle', $agecategory." AGE(S) PATIENT LISTING");
            }
            else
            {
                $params->put('CRMReportTitle', "ALL ".$agecategory." PATIENT LISTING");
            }
            
            $jasperPrint = $fillManager->fillReport($report, $params, $emptyDataSource);
            $exportManager = $this->javabridge->load_manager($type = 'exporter');
            
            $outputPath = $reportdirectory.$reportmodulexxx."/PatientListingViaAgeCategory.pdf";
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition:filename=Patient Listing Via Age Category.pdf');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

            readfile($outputPath);
            unlink($outputPath);
        }
        else
        {
            redirect(base_url("user/index"));
        }
    }
    
    public function PatientListingViaSexCategoryGeneratedData()
    {
        if ($this->has_log_in())
        {
            $this->load->library('javabridge');
            
            $this->javabridge->load_system();
            $this->javabridge->load_class();

            $compileManager = $this->javabridge->load_manager($type = 'compiler');
            
            $getcrmdirectory = $this->dashboard_model->get_crm_directory_path();
            $reportdirectory = $getcrmdirectory['directory'];
            $reportmodulexxx = $getcrmdirectory['module'];
            $targetjrxml = $reportdirectory.$reportmodulexxx."/PatientListingViaMunicipality.jrxml";
            
            $report = $compileManager->compileReport($targetjrxml);

            $fillManager = $this->javabridge->load_manager($type = 'importer');
            $emptyDataSource = $this->javabridge->load_datasource($source = 'emptydata');
            
            $params = $this->javabridge->load_util($util = 'hashmap');
            
            $arrayListTableData = $this->javabridge->load_util($util = 'arraylist');
            
            $sexcategory = $this->input->post('hiddenname_sexcateindi');
            $daterequest = $this->input->post('hiddenname_daterequest');
            $patienttype = $this->input->post('hiddenname_patienttype');
            
            $data = [];
            $patient = $this->dashboard_model->getPatientViaSexCategoryParameter($daterequest,$patienttype,$sexcategory);

            $stringnumb = $stringname = $stringadmd = $stringpxcl = $stringagex = $stringbday = "";
            $stringadrs = $stringroom = $stringdocs = $stringphic = $stringadmb = "";
            
            for ($cv = 0; $cv < count($patient); $cv++)
            {
                $counter = intval($cv) + intval(1);
                $stringnumb = $stringnumb.$counter."|";
                $stringname = $stringname.$patient[$cv]['name']."|";
                $stringadmd = $stringadmd.$patient[$cv]['admitdate']."|";
                $stringpxcl = $stringpxcl.$patient[$cv]['pat_classification']."|";
                $stringagex = $stringagex.$patient[$cv]['Age']."|";
                $stringbday = $stringbday.$patient[$cv]['bday']."|";
                $stringadrs = $stringadrs.$patient[$cv]['cityadd'].", ".$patient[$cv]['provadd']."|";
                $stringroom = $stringroom.$patient[$cv]['roombrief']."|";
                $stringdocs = $stringdocs.$patient[$cv]['doctorname']."|";
                $stringphic = $stringphic.$patient[$cv]['phicmembr']."|";
                $stringadmb = $stringadmb.$patient[$cv]['recby']."|";
            }

            $firstDimensionNumb = explode('|', $stringnumb);
            $firstDimensionName = explode('|', $stringname);
            $firstDimensionAdmd = explode('|', $stringadmd);
            $firstDimensionPxcl = explode('|', $stringpxcl);
            $firstDimensionAgex = explode('|', $stringagex);
            $firstDimensionBday = explode('|', $stringbday); 
            $firstDimensionAdrs = explode('|', $stringadrs);
            $firstDimensionRoom = explode('|', $stringroom);
            $firstDimensionDocs = explode('|', $stringdocs);
            $firstDimensionPhic = explode('|', $stringphic);
            $firstDimensionAdmb = explode('|', $stringadmb);

            $count = count($firstDimensionName);

            for ($i = 0; $i < $count - 1; $i++)
            {
                $birthdate = new DateTime($firstDimensionBday[$i]);
                $birthday = $birthdate->format('F j, Y');
                
                $admitdate = new DateTime($firstDimensionAdmd[$i]);
                $admitday = $admitdate->format('F j, Y');
                
                $data['HeaderNumber']   = strtoupper($firstDimensionNumb[$i]);
                $data['HeaderPxName']   = strtoupper($firstDimensionName[$i]);
                $data['HeaderAdmdate']  = strtoupper($admitday);
                $data['HeaderPatclass'] = strtoupper($firstDimensionPxcl[$i]);
                $data['HeaderPatAge']   = strtoupper($firstDimensionAgex[$i]);
                $data['HeaderPxBirth']  = strtoupper($birthday);
                $data['HeaderAddress']  = strtoupper($firstDimensionAdrs[$i]);
                $data['HeaderRoom']     = strtoupper($firstDimensionRoom[$i]);
                $data['HeaderDoctor']   = strtoupper($firstDimensionDocs[$i]);
                $data['HeaderPhealth']  = strtoupper($firstDimensionPhic[$i]);
                $data['HeaderAdmby']    = strtoupper($firstDimensionAdmb[$i]);
                
                $arrayListTableData->add($data);
            }
            
            $beanCollectionTableData = $this->javabridge->load_datasource($source = 'multidata', $arrayListTableData);
            
            $params->put("CompanyLogo","C:/xampp/htdocs/drainwizv2/assets/img/logo.png");
            $params->put('CompanyName', "DRAINWIZ SYSTEMS INC.");
            $params->put('CompanyAdrs', "Echaves St. Dipolog City, Zamboanga Del Norte 7100");
            $params->put('CompanyCont', "(+639)38-278-6751");
            $params->put('SelectedMonth', strval($daterequest));
            $params->put('PatientListDataSource', $beanCollectionTableData);
            
            if($sexcategory === "ALL")
            {
                $params->put('CRMReportTitle', $sexcategory." GENDER PATIENT LISTING");
            }
            else
            {
                $params->put('CRMReportTitle', "ALL ".$sexcategory." PATIENT LISTING");
            }
            
            
            $jasperPrint = $fillManager->fillReport($report, $params, $emptyDataSource);
            $exportManager = $this->javabridge->load_manager($type = 'exporter');
            
            $outputPath = $reportdirectory.$reportmodulexxx."/PatientListingViaSexCategory.pdf";
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition:filename=Patient Listing Via Sex Category.pdf');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

            readfile($outputPath);
            unlink($outputPath);
        }
        else
        {
            redirect(base_url("user/index"));
        }
    }
    
    public function PatientListingViaMunicipalityGeneratedData()
    {
        if ($this->has_log_in())
        {
            $this->load->library('javabridge');
            
            $this->javabridge->load_system();
            $this->javabridge->load_class();

            $compileManager = $this->javabridge->load_manager($type = 'compiler');
            
            $getcrmdirectory = $this->dashboard_model->get_crm_directory_path();
            $reportdirectory = $getcrmdirectory['directory'];
            $reportmodulexxx = $getcrmdirectory['module'];
            $targetjrxml = $reportdirectory.$reportmodulexxx."/PatientListingViaMunicipality.jrxml";
            
            $report = $compileManager->compileReport($targetjrxml);

            $fillManager = $this->javabridge->load_manager($type = 'importer');
            $emptyDataSource = $this->javabridge->load_datasource($source = 'emptydata');
            
            $params = $this->javabridge->load_util($util = 'hashmap');
            
            $arrayListTableData = $this->javabridge->load_util($util = 'arraylist');
            
            $othersindic = $this->input->post('hiddenname_indicaother');
            $daterequest = $this->input->post('hiddenname_daterequest');
            $citymunname = $this->input->post('hiddenname_citymunname');
            $patienttype = $this->input->post('hiddenname_patienttype');
            
            $data = [];
            $patient = $this->dashboard_model->getPatientViaCityMunicipalParameter($daterequest,$citymunname,$patienttype,$othersindic);

            $stringnumb = $stringname = $stringadmd = $stringpxcl = $stringagex = $stringbday = "";
            $stringadrs = $stringroom = $stringdocs = $stringphic = $stringadmb = "";
            
            for ($cv = 0; $cv < count($patient); $cv++)
            {
                $counter = intval($cv) + intval(1);
                $stringnumb = $stringnumb.$counter."|";
                $stringname = $stringname.$patient[$cv]['name']."|";
                $stringadmd = $stringadmd.$patient[$cv]['admitdate']."|";
                $stringpxcl = $stringpxcl.$patient[$cv]['pat_classification']."|";
                $stringagex = $stringagex.$patient[$cv]['Age']."|";
                $stringbday = $stringbday.$patient[$cv]['bday']."|";
                $stringadrs = $stringadrs.$patient[$cv]['cityadd'].", ".$patient[$cv]['provadd']."|";
                $stringroom = $stringroom.$patient[$cv]['roombrief']."|";
                $stringdocs = $stringdocs.$patient[$cv]['doctorname']."|";
                $stringphic = $stringphic.$patient[$cv]['phicmembr']."|";
                $stringadmb = $stringadmb.$patient[$cv]['recby']."|";
            }

            $firstDimensionNumb = explode('|', $stringnumb);
            $firstDimensionName = explode('|', $stringname);
            $firstDimensionAdmd = explode('|', $stringadmd);
            $firstDimensionPxcl = explode('|', $stringpxcl);
            $firstDimensionAgex = explode('|', $stringagex);
            $firstDimensionBday = explode('|', $stringbday); 
            $firstDimensionAdrs = explode('|', $stringadrs);
            $firstDimensionRoom = explode('|', $stringroom);
            $firstDimensionDocs = explode('|', $stringdocs);
            $firstDimensionPhic = explode('|', $stringphic);
            $firstDimensionAdmb = explode('|', $stringadmb);

            $count = count($firstDimensionName);

            for ($i = 0; $i < $count - 1; $i++)
            {
                $birthdate = new DateTime($firstDimensionBday[$i]);
                $birthday = $birthdate->format('F j, Y');
                
                $admitdate = new DateTime($firstDimensionAdmd[$i]);
                $admitday = $admitdate->format('F j, Y');
                
                $data['HeaderNumber']   = strtoupper($firstDimensionNumb[$i]);
                $data['HeaderPxName']   = strtoupper($firstDimensionName[$i]);
                $data['HeaderAdmdate']  = strtoupper($admitday);
                $data['HeaderPatclass'] = strtoupper($firstDimensionPxcl[$i]);
                $data['HeaderPatAge']   = strtoupper($firstDimensionAgex[$i]);
                $data['HeaderPxBirth']  = strtoupper($birthday);
                $data['HeaderAddress']  = strtoupper($firstDimensionAdrs[$i]);
                $data['HeaderRoom']     = strtoupper($firstDimensionRoom[$i]);
                $data['HeaderDoctor']   = strtoupper($firstDimensionDocs[$i]);
                $data['HeaderPhealth']  = strtoupper($firstDimensionPhic[$i]);
                $data['HeaderAdmby']    = strtoupper($firstDimensionAdmb[$i]);
                
                $arrayListTableData->add($data);
            }
            
            $beanCollectionTableData = $this->javabridge->load_datasource($source = 'multidata', $arrayListTableData);
            
            $params->put("CompanyLogo","C:/xampp/htdocs/drainwizv2/assets/img/logo.png");
            $params->put('CompanyName', "DRAINWIZ SYSTEMS INC.");
            $params->put('CompanyAdrs', "Echaves St. Dipolog City, Zamboanga Del Norte 7100");
            $params->put('CompanyCont', "(+639)38-278-6751");
            $params->put('SelectedMonth', strval($daterequest));
            $params->put('PatientListDataSource', $beanCollectionTableData);
            
            if($othersindic === "OTHERS")
            {
                $params->put('CRMReportTitle', "OTHER CITY/MUNICIPALITY PATIENT LISTING");
            }
            else if($othersindic === "ALL CITY/MUNICIPALITY")
            {
                $params->put('CRMReportTitle', $citymunname." PATIENT LISTING");
            }
            else
            {
                $params->put('CRMReportTitle', "ALL ".$citymunname." PATIENT LISTING");
            }
            
            $jasperPrint = $fillManager->fillReport($report, $params, $emptyDataSource);
            $exportManager = $this->javabridge->load_manager($type = 'exporter');
            
            $outputPath = $reportdirectory.$reportmodulexxx."/PatientListingViaMunicipality.pdf";
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition:filename=Patient Listing Via Municipality.pdf');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

            readfile($outputPath);
            unlink($outputPath);
        }
        else
        {
            redirect(base_url("user/index"));
        }
    }
    
    public function PatientListingViaProvinceGeneratedData()
    {
        if ($this->has_log_in())
        {
            $this->load->library('javabridge');
            
            $this->javabridge->load_system();
            $this->javabridge->load_class();

            $compileManager = $this->javabridge->load_manager($type = 'compiler');
            
            $getcrmdirectory = $this->dashboard_model->get_crm_directory_path();
            $reportdirectory = $getcrmdirectory['directory'];
            $reportmodulexxx = $getcrmdirectory['module'];
            $targetjrxml = $reportdirectory.$reportmodulexxx."/PatientListingViaMunicipality.jrxml";
            
            $report = $compileManager->compileReport($targetjrxml);

            $fillManager = $this->javabridge->load_manager($type = 'importer');
            $emptyDataSource = $this->javabridge->load_datasource($source = 'emptydata');
            
            $params = $this->javabridge->load_util($util = 'hashmap');
            
            $arrayListTableData = $this->javabridge->load_util($util = 'arraylist');
            
            $daterequest = $this->input->post('hiddenname_daterequestprov');
            $provaddname = $this->input->post('hiddenname_provinceaddname');
            $pxtypexprov = $this->input->post('hiddenname_patienttypeprov');
            $othersindic = $this->input->post('hiddenname_indicaotherprov');
            
            $data = [];
            $patient = $this->dashboard_model->getPatientViaProvinceAddressParameter($daterequest,$provaddname,$pxtypexprov,$othersindic);

            $stringnumb = $stringname = $stringadmd = $stringpxcl = $stringagex = $stringbday = "";
            $stringadrs = $stringroom = $stringdocs = $stringphic = $stringadmb = "";
            
            for ($cv = 0; $cv < count($patient); $cv++)
            {
                $counter = intval($cv) + intval(1);
                $stringnumb = $stringnumb.$counter."|";
                $stringname = $stringname.$patient[$cv]['name']."|";
                $stringadmd = $stringadmd.$patient[$cv]['admitdate']."|";
                $stringpxcl = $stringpxcl.$patient[$cv]['pat_classification']."|";
                $stringagex = $stringagex.$patient[$cv]['Age']."|";
                $stringbday = $stringbday.$patient[$cv]['bday']."|";
                $stringadrs = $stringadrs.$patient[$cv]['cityadd'].", ".$patient[$cv]['provadd']."|";
                $stringroom = $stringroom.$patient[$cv]['roombrief']."|";
                $stringdocs = $stringdocs.$patient[$cv]['doctorname']."|";
                $stringphic = $stringphic.$patient[$cv]['phicmembr']."|";
                $stringadmb = $stringadmb.$patient[$cv]['recby']."|";
            }

            $firstDimensionNumb = explode('|', $stringnumb);
            $firstDimensionName = explode('|', $stringname);
            $firstDimensionAdmd = explode('|', $stringadmd);
            $firstDimensionPxcl = explode('|', $stringpxcl);
            $firstDimensionAgex = explode('|', $stringagex);
            $firstDimensionBday = explode('|', $stringbday); 
            $firstDimensionAdrs = explode('|', $stringadrs);
            $firstDimensionRoom = explode('|', $stringroom);
            $firstDimensionDocs = explode('|', $stringdocs);
            $firstDimensionPhic = explode('|', $stringphic);
            $firstDimensionAdmb = explode('|', $stringadmb);

            $count = count($firstDimensionName);

            for ($i = 0; $i < $count - 1; $i++)
            {
                $birthdate = new DateTime($firstDimensionBday[$i]);
                $birthday = $birthdate->format('F j, Y');
                
                $admitdate = new DateTime($firstDimensionAdmd[$i]);
                $admitday = $admitdate->format('F j, Y');
                
                $data['HeaderNumber']   = strtoupper($firstDimensionNumb[$i]);
                $data['HeaderPxName']   = strtoupper($firstDimensionName[$i]);
                $data['HeaderAdmdate']  = strtoupper($admitday);
                $data['HeaderPatclass'] = strtoupper($firstDimensionPxcl[$i]);
                $data['HeaderPatAge']   = strtoupper($firstDimensionAgex[$i]);
                $data['HeaderPxBirth']  = strtoupper($birthday);
                $data['HeaderAddress']  = strtoupper($firstDimensionAdrs[$i]);
                $data['HeaderRoom']     = strtoupper($firstDimensionRoom[$i]);
                $data['HeaderDoctor']   = strtoupper($firstDimensionDocs[$i]);
                $data['HeaderPhealth']  = strtoupper($firstDimensionPhic[$i]);
                $data['HeaderAdmby']    = strtoupper($firstDimensionAdmb[$i]);
                
                $arrayListTableData->add($data);
            }
            
            $beanCollectionTableData = $this->javabridge->load_datasource($source = 'multidata', $arrayListTableData);
            
            $params->put("CompanyLogo","C:/xampp/htdocs/drainwizv2/assets/img/logo.png");
            $params->put('CompanyName', "DRAINWIZ SYSTEMS INC.");
            $params->put('CompanyAdrs', "Echaves St. Dipolog City, Zamboanga Del Norte 7100");
            $params->put('CompanyCont', "(+639)38-278-6751");
            $params->put('SelectedMonth', strval($daterequest));
            $params->put('PatientListDataSource', $beanCollectionTableData);
            
            
            if($othersindic === "OTHERS")
            {
                $params->put('CRMReportTitle', "OTHER PROVINCE PATIENT LISTING");
            }
            else if($othersindic === "ALL PROVINCE")
            {
                $params->put('CRMReportTitle', $provaddname." PATIENT LISTING");
            }
            else
            {
                $params->put('CRMReportTitle', "ALL ".$provaddname." PATIENT LISTING");
            }
            
            $jasperPrint = $fillManager->fillReport($report, $params, $emptyDataSource);
            $exportManager = $this->javabridge->load_manager($type = 'exporter');
            
            $outputPath = $reportdirectory.$reportmodulexxx."/PatientListingViaProvince.pdf";
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition:filename=Patient Listing Via Province.pdf');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

            readfile($outputPath);
            unlink($outputPath);
        }
        else
        {
            redirect(base_url("user/index"));
        }
    }
    
    public function PatientListingViaInsuranceGeneratedData()
    {
        if ($this->has_log_in())
        {
            $this->load->library('javabridge');
            
            $this->javabridge->load_system();
            $this->javabridge->load_class();

            $compileManager = $this->javabridge->load_manager($type = 'compiler');
            
            $getcrmdirectory = $this->dashboard_model->get_crm_directory_path();
            $reportdirectory = $getcrmdirectory['directory'];
            $reportmodulexxx = $getcrmdirectory['module'];
            $targetjrxml = $reportdirectory.$reportmodulexxx."/PatientListingViaMunicipality.jrxml";
            
            $report = $compileManager->compileReport($targetjrxml);

            $fillManager = $this->javabridge->load_manager($type = 'importer');
            $emptyDataSource = $this->javabridge->load_datasource($source = 'emptydata');
            
            $params = $this->javabridge->load_util($util = 'hashmap');
            
            $arrayListTableData = $this->javabridge->load_util($util = 'arraylist');
            
            $daterequest = $this->input->post('hiddenname_daterequesthmox');
            $hmoxaddname = $this->input->post('hiddenname_insurancaddname');
            $pxtypexhmox = $this->input->post('hiddenname_patienttypehmox');
            $othersindic = $this->input->post('hiddenname_indicaotherhmox');
            
            $data = [];
            $patient = $this->dashboard_model->getPatientViaHMOInsuranceAddressParameter($daterequest,$hmoxaddname,$pxtypexhmox,$othersindic);

            $stringnumb = $stringname = $stringadmd = $stringpxcl = $stringagex = $stringbday = "";
            $stringadrs = $stringroom = $stringdocs = $stringphic = $stringadmb = "";
            
            for ($cv = 0; $cv < count($patient); $cv++)
            {
                $counter = intval($cv) + intval(1);
                $stringnumb = $stringnumb.$counter."|";
                $stringname = $stringname.$patient[$cv]['name']."|";
                $stringadmd = $stringadmd.$patient[$cv]['admitdate']."|";
                $stringpxcl = $stringpxcl.$patient[$cv]['pat_classification']."|";
                $stringagex = $stringagex.$patient[$cv]['Age']."|";
                $stringbday = $stringbday.$patient[$cv]['bday']."|";
                $stringadrs = $stringadrs.$patient[$cv]['cityadd'].", ".$patient[$cv]['provadd']."|";
                $stringroom = $stringroom.$patient[$cv]['roombrief']."|";
                $stringdocs = $stringdocs.$patient[$cv]['doctorname']."|";
                $stringphic = $stringphic.$patient[$cv]['phicmembr']."|";
                $stringadmb = $stringadmb.$patient[$cv]['recby']."|";
            }

            $firstDimensionNumb = explode('|', $stringnumb);
            $firstDimensionName = explode('|', $stringname);
            $firstDimensionAdmd = explode('|', $stringadmd);
            $firstDimensionPxcl = explode('|', $stringpxcl);
            $firstDimensionAgex = explode('|', $stringagex);
            $firstDimensionBday = explode('|', $stringbday); 
            $firstDimensionAdrs = explode('|', $stringadrs);
            $firstDimensionRoom = explode('|', $stringroom);
            $firstDimensionDocs = explode('|', $stringdocs);
            $firstDimensionPhic = explode('|', $stringphic);
            $firstDimensionAdmb = explode('|', $stringadmb);

            $count = count($firstDimensionName);

            for ($i = 0; $i < $count - 1; $i++)
            {
                $birthdate = new DateTime($firstDimensionBday[$i]);
                $birthday = $birthdate->format('F j, Y');
                
                $admitdate = new DateTime($firstDimensionAdmd[$i]);
                $admitday = $admitdate->format('F j, Y');
                
                $data['HeaderNumber']   = strtoupper($firstDimensionNumb[$i]);
                $data['HeaderPxName']   = strtoupper($firstDimensionName[$i]);
                $data['HeaderAdmdate']  = strtoupper($admitday);
                $data['HeaderPatclass'] = strtoupper($firstDimensionPxcl[$i]);
                $data['HeaderPatAge']   = strtoupper($firstDimensionAgex[$i]);
                $data['HeaderPxBirth']  = strtoupper($birthday);
                $data['HeaderAddress']  = strtoupper($firstDimensionAdrs[$i]);
                $data['HeaderRoom']     = strtoupper($firstDimensionRoom[$i]);
                $data['HeaderDoctor']   = strtoupper($firstDimensionDocs[$i]);
                $data['HeaderPhealth']  = strtoupper($firstDimensionPhic[$i]);
                $data['HeaderAdmby']    = strtoupper($firstDimensionAdmb[$i]);
                
                $arrayListTableData->add($data);
            }
            
            $beanCollectionTableData = $this->javabridge->load_datasource($source = 'multidata', $arrayListTableData);
            
            $params->put("CompanyLogo","C:/xampp/htdocs/drainwizv2/assets/img/logo.png");
            $params->put('CompanyName', "DRAINWIZ SYSTEMS INC.");
            $params->put('CompanyAdrs', "Echaves St. Dipolog City, Zamboanga Del Norte 7100");
            $params->put('CompanyCont', "(+639)38-278-6751");
            $params->put('SelectedMonth', strval($daterequest));
            $params->put('PatientListDataSource', $beanCollectionTableData);
            
            
            if($othersindic === "OTHERS")
            {
                $params->put('CRMReportTitle', "OTHER INSURANCE PATIENT LISTING");
            }
            else if($othersindic === "ALL HMO/INSURANCE")
            {
                $params->put('CRMReportTitle', $hmoxaddname." PATIENT LISTING");
            }
            else
            {
                $params->put('CRMReportTitle', "ALL ".$hmoxaddname." PATIENT LISTING");
            }
            
            $jasperPrint = $fillManager->fillReport($report, $params, $emptyDataSource);
            $exportManager = $this->javabridge->load_manager($type = 'exporter');
            
            $outputPath = $reportdirectory.$reportmodulexxx."/PatientListingViaProvince.pdf";
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition:filename=Patient Listing Via Province.pdf');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

            readfile($outputPath);
            unlink($outputPath);
        }
        else
        {
            redirect(base_url("user/index"));
        }
    }

    public function PatientListingViaRoomrateGeneratedData()
    {
        if ($this->has_log_in())
        {
            $this->load->library('javabridge');
            
            $this->javabridge->load_system();
            $this->javabridge->load_class();

            $compileManager = $this->javabridge->load_manager($type = 'compiler');
            
            $getcrmdirectory = $this->dashboard_model->get_crm_directory_path();
            $reportdirectory = $getcrmdirectory['directory'];
            $reportmodulexxx = $getcrmdirectory['module'];
            $targetjrxml = $reportdirectory.$reportmodulexxx."/PatientListingViaMunicipality.jrxml";
            
            $report = $compileManager->compileReport($targetjrxml);

            $fillManager = $this->javabridge->load_manager($type = 'importer');
            $emptyDataSource = $this->javabridge->load_datasource($source = 'emptydata');
            
            $params = $this->javabridge->load_util($util = 'hashmap');
            
            $arrayListTableData = $this->javabridge->load_util($util = 'arraylist');
            
            $daterequest = $this->input->post('hiddenname_daterequestroom');
            $roomaddname = $this->input->post('hiddenname_roomrateaddname');
            $pxtypexroom = $this->input->post('hiddenname_patienttyperoom');
            $othersindic = $this->input->post('hiddenname_indicaotherroom');
            
            $data = [];
            $patient = $this->dashboard_model->getPatientViaRoomOccupancyRateParameter($daterequest,$roomaddname,$pxtypexroom,$othersindic);

            $stringnumb = $stringname = $stringadmd = $stringpxcl = $stringagex = $stringbday = "";
            $stringadrs = $stringroom = $stringdocs = $stringphic = $stringadmb = "";
            
            for ($cv = 0; $cv < count($patient); $cv++)
            {
                $counter = intval($cv) + intval(1);
                $stringnumb = $stringnumb.$counter."|";
                $stringname = $stringname.$patient[$cv]['name']."|";
                $stringadmd = $stringadmd.$patient[$cv]['admitdate']."|";
                $stringpxcl = $stringpxcl.$patient[$cv]['pat_classification']."|";
                $stringagex = $stringagex.$patient[$cv]['Age']."|";
                $stringbday = $stringbday.$patient[$cv]['bday']."|";
                $stringadrs = $stringadrs.$patient[$cv]['cityadd'].", ".$patient[$cv]['provadd']."|";
                $stringroom = $stringroom.$patient[$cv]['roombrief']."|";
                $stringdocs = $stringdocs.$patient[$cv]['doctorname']."|";
                $stringphic = $stringphic.$patient[$cv]['phicmembr']."|";
                $stringadmb = $stringadmb.$patient[$cv]['recby']."|";
            }

            $firstDimensionNumb = explode('|', $stringnumb);
            $firstDimensionName = explode('|', $stringname);
            $firstDimensionAdmd = explode('|', $stringadmd);
            $firstDimensionPxcl = explode('|', $stringpxcl);
            $firstDimensionAgex = explode('|', $stringagex);
            $firstDimensionBday = explode('|', $stringbday); 
            $firstDimensionAdrs = explode('|', $stringadrs);
            $firstDimensionRoom = explode('|', $stringroom);
            $firstDimensionDocs = explode('|', $stringdocs);
            $firstDimensionPhic = explode('|', $stringphic);
            $firstDimensionAdmb = explode('|', $stringadmb);

            $count = count($firstDimensionName);

            for ($i = 0; $i < $count - 1; $i++)
            {
                $birthdate = new DateTime($firstDimensionBday[$i]);
                $birthday = $birthdate->format('F j, Y');
                
                $admitdate = new DateTime($firstDimensionAdmd[$i]);
                $admitday = $admitdate->format('F j, Y');
                
                $data['HeaderNumber']   = strtoupper($firstDimensionNumb[$i]);
                $data['HeaderPxName']   = strtoupper($firstDimensionName[$i]);
                $data['HeaderAdmdate']  = strtoupper($admitday);
                $data['HeaderPatclass'] = strtoupper($firstDimensionPxcl[$i]);
                $data['HeaderPatAge']   = strtoupper($firstDimensionAgex[$i]);
                $data['HeaderPxBirth']  = strtoupper($birthday);
                $data['HeaderAddress']  = strtoupper($firstDimensionAdrs[$i]);
                $data['HeaderRoom']     = strtoupper($firstDimensionRoom[$i]);
                $data['HeaderDoctor']   = strtoupper($firstDimensionDocs[$i]);
                $data['HeaderPhealth']  = strtoupper($firstDimensionPhic[$i]);
                $data['HeaderAdmby']    = strtoupper($firstDimensionAdmb[$i]);
                
                $arrayListTableData->add($data);
            }
            
            $beanCollectionTableData = $this->javabridge->load_datasource($source = 'multidata', $arrayListTableData);
            
            $params->put("CompanyLogo","C:/xampp/htdocs/drainwizv2/assets/img/logo.png");
            $params->put('CompanyName', "DRAINWIZ SYSTEMS INC.");
            $params->put('CompanyAdrs', "Echaves St. Dipolog City, Zamboanga Del Norte 7100");
            $params->put('CompanyCont', "(+639)38-278-6751");
            $params->put('SelectedMonth', strval($daterequest));
            $params->put('PatientListDataSource', $beanCollectionTableData);
            
            if($othersindic === "OTHERS")
            {
                $params->put('CRMReportTitle', "OTHER ROOM(S) PATIENT LISTING");
            }
            else if($othersindic === "ALL ROOMS")
            {
                $params->put('CRMReportTitle', $roomaddname." PATIENT LISTING");
            }
            else
            {
                $params->put('CRMReportTitle', "ALL ".$roomaddname." PATIENT LISTING");
            }
            
            $jasperPrint = $fillManager->fillReport($report, $params, $emptyDataSource);
            $exportManager = $this->javabridge->load_manager($type = 'exporter');
            
            $outputPath = $reportdirectory.$reportmodulexxx."/PatientListingViaRoomrate.pdf";
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition:filename=Patient Listing Via Room Occupancy Rate.pdf');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

            readfile($outputPath);
            unlink($outputPath);
        }
        else
        {
            redirect(base_url("user/index"));
        }
    }
    
    public function CRMGeneratedData()
    {   
        if ($this->has_log_in())
        {
            $this->load->library('javabridge');
            
            $this->javabridge->load_system();
            $this->javabridge->load_class();

            $compileManager = $this->javabridge->load_manager($type = 'compiler');
            
            $getcrmdirectory = $this->dashboard_model->get_crm_directory_path();
            $reportdirectory = $getcrmdirectory['directory'];
            $reportmodulexxx = $getcrmdirectory['module'];
            $targetjrxml = $reportdirectory.$reportmodulexxx."/CRMGeneratedData.jrxml";
            
            $report = $compileManager->compileReport($targetjrxml);

            $fillManager = $this->javabridge->load_manager($type = 'importer');
            $emptyDataSource = $this->javabridge->load_datasource($source = 'emptydata');
            
            $params = $this->javabridge->load_util($util = 'hashmap');
            
            $arrayListChartGen = $this->javabridge->load_util($util = 'arraylist');
            $arrayListChartAge = $this->javabridge->load_util($util = 'arraylist');
            $arrayListChartMun = $this->javabridge->load_util($util = 'arraylist');
            $arrayListChartPrv = $this->javabridge->load_util($util = 'arraylist');
            $arrayListChartHMO = $this->javabridge->load_util($util = 'arraylist');
            $arrayListChartROR = $this->javabridge->load_util($util = 'arraylist');
            $arrayListChartVOR = $this->javabridge->load_util($util = 'arraylist');
            
            $genderxparameter = $this->input->post('hiddenname_genderxparameter');
            $agexxxxparameter = $this->input->post('hiddenname_agexxxxparameter');
            $citymunparameter = $this->input->post('hiddenname_cityaddparameter');
            $provaddparameter = $this->input->post('hiddenname_provaddparameter');
            $insuranparameter = $this->input->post('hiddenname_insuranparameter');
            $roomoccparameter = $this->input->post('hiddenname_roomoccparameter');
            $volumexparameter = $this->input->post('hiddenname_volreqxparameter');
            $seldateparameter = $this->input->post('hiddenname_selectedmonthxxx');
            
            $explodegendtag = array('MALE', 'FEMALE');
            $explodegenderx = explode("|", $genderxparameter);
           
            $explodeagextag = array('INFANT','CHILD','YOUTH','ADULT','SENIOR');
            $explodeagexxxx = explode("|", $agexxxxparameter);
            
            $explodecitymun = explode("?", $citymunparameter);
            $citytitlenamex = $explodecitymun[0];
            $citypercentage = $explodecitymun[1];
            $cityrealvaluex = $explodecitymun[2];
            
            $explodecitytitlenamex = explode("|", $citytitlenamex);
            $explodecitypercentage = explode("|", $citypercentage);
            $explodecityrealvaluex = explode("|", $cityrealvaluex);
            
            $explodeprovadd = explode("?", $provaddparameter);
            $provtitlenamex = $explodeprovadd[0];
            $provpercentage = $explodeprovadd[1];
            $provrealvaluex = $explodeprovadd[2];
            
            $explodeprovtitlenamex = explode("|", $provtitlenamex);
            $explodeprovpercentage = explode("|", $provpercentage);
            $explodeprovrealvaluex = explode("|", $provrealvaluex);
  
            $explodeinsuran = explode("?", $insuranparameter);
            $hmoxtitlenamex = $explodeinsuran[0];
            $hmoxpercentage = $explodeinsuran[1];
            $hmoxrealvaluex = $explodeinsuran[2];
            
            $explodehmoxtitlenamex = explode("|", $hmoxtitlenamex);
            $explodehmoxpercentage = explode("|", $hmoxpercentage);
            $explodehmoxrealvaluex = explode("|", $hmoxrealvaluex);
            
            $exploderoomocc = explode("?", $roomoccparameter);
            $roomtitlenamex = $exploderoomocc[0];
            $roompercentage = $exploderoomocc[1];
            $roomtruevaluex = $exploderoomocc[2];
            
            $exploderoomtitlenamex = explode("|", $roomtitlenamex);
            $exploderoompercentage = explode("|", $roompercentage);
            $exploderoomtruevaluex = explode("|", $roomtruevaluex);
            
            $explodevolumelabelxx = array('LABORATORY', 'RADIOLOGY', 'PHARMACY');
            $explodevolumepercent = explode("|", $volumexparameter);

            $datagenderx = [];
            $gendcount = count($explodegenderx);
            for ($gendcounter = 0; $gendcounter < $gendcount; $gendcounter++)
            {
                $datagenderx['title'] = strval($explodegendtag[$gendcounter]);
                $datagenderx['value'] = doubleval($explodegenderx[$gendcounter]);
                
                $arrayListChartGen->add($datagenderx);
            }
            
            $dataagexxxx = [];
            $agexcount = count($explodeagexxxx);
            for ($agexcounter = 0; $agexcounter < $agexcount; $agexcounter++)
            {
                $dataagexxxx['AgeTitle'] = strval($explodeagextag[$agexcounter]);
                $dataagexxxx['AgeValue'] = doubleval($explodeagexxxx[$agexcounter]);
                
                $arrayListChartAge->add($dataagexxxx);
            }
            
            $datacitymun = [];
            $citycount = count($explodecitypercentage);
            for ($citycounter = 0; $citycounter < $citycount; $citycounter++)
            {
                $incrementcitycounter = intval($citycounter) + intval(1);
                if($explodecitytitlenamex[$citycounter] === "NO DATA")
                {
                    $datacitymun['munlabel'] = strval($explodecitytitlenamex[$citycounter])." FOR #".$incrementcitycounter;
                    $datacitymun['munvalue'] = doubleval($explodecitypercentage[$citycounter]);
                }
                else
                {
                    $datacitymun['munlabel'] = strval($explodecitytitlenamex[$citycounter]).": ".strval($explodecityrealvaluex[$citycounter])."(".strval($explodecitypercentage[$citycounter])."%)";
                    $datacitymun['munvalue'] = doubleval($explodecitypercentage[$citycounter]);
                }
                
                $arrayListChartMun->add($datacitymun);
            }
            
            $dataprovadd = [];
            $provcount = count($explodeprovtitlenamex);
            for ($provcounter = 0; $provcounter < $provcount; $provcounter++)
            {
                $incrementprovcounter = intval($provcounter) + intval(1);
                if($explodeprovtitlenamex[$provcounter] === "NO DATA")
                {
                    $dataprovadd['provlabel'] = strval($explodeprovtitlenamex[$provcounter])." FOR #".$incrementprovcounter;
                    $dataprovadd['provvalue'] = doubleval($explodeprovpercentage[$provcounter]);
                }
                else
                {
                    $dataprovadd['provlabel'] = strval($explodeprovtitlenamex[$provcounter]).": ".strval($explodeprovrealvaluex[$provcounter])."(".strval($explodeprovpercentage[$provcounter])."%)";
                    $dataprovadd['provvalue'] = doubleval($explodeprovpercentage[$provcounter]);
                }
                
                $arrayListChartPrv->add($dataprovadd);
            }

            $datainsuran = [];
            $hmoxcount = count($explodehmoxtitlenamex);
            for ($hmoxcounter = 0; $hmoxcounter < $hmoxcount; $hmoxcounter++)
            {
                $datainsuran['hmolabel'] = strval($explodehmoxtitlenamex[$hmoxcounter]).": ".strval($explodehmoxrealvaluex[$hmoxcounter])."(".strval($explodehmoxpercentage[$hmoxcounter])."%)";
                $datainsuran['hmovalue'] = doubleval($explodehmoxpercentage[$hmoxcounter]);
                
                $arrayListChartHMO->add($datainsuran);
            }
 
            $dataroomocc = [];
            $roomcount = count($exploderoomtitlenamex);
            for ($roomcounter = 0; $roomcounter < $roomcount; $roomcounter++)
            {
                $incrementroomcounter = intval($roomcounter) + intval(1);
                if($exploderoomtitlenamex[$roomcounter] === "NO DATA")
                {
                    $dataroomocc['roomlabel'] = strval($exploderoomtitlenamex[$roomcounter])." FOR #".$incrementroomcounter;
                    $dataroomocc['roomvalue'] = doubleval($exploderoompercentage[$roomcounter]);
                }
                else
                {
                    $dataroomocc['roomlabel'] = strval($exploderoomtitlenamex[$roomcounter]).": ".strval($exploderoomtruevaluex[$roomcounter])."(".strval($exploderoompercentage[$roomcounter])."%)";
                    $dataroomocc['roomvalue'] = doubleval($exploderoompercentage[$roomcounter]);
                }
                
                $arrayListChartROR->add($dataroomocc);
            }
            
            $datavolumex = [];
            $volmcount = count($explodevolumepercent);
            for ($volmcounter = 0; $volmcounter < $volmcount; $volmcounter++)
            {
                $datavolumex['vorlabel'] = strval($explodevolumelabelxx[$volmcounter]);
                $datavolumex['vorvalue'] = doubleval($explodevolumepercent[$volmcounter]);
                
                $arrayListChartVOR->add($datavolumex);
            }
   
            $beanCollectionChartGen = $this->javabridge->load_datasource($source = 'multidata', $arrayListChartGen);
            $beanCollectionChartAge = $this->javabridge->load_datasource($source = 'multidata', $arrayListChartAge);
            $beanCollectionChartMun = $this->javabridge->load_datasource($source = 'multidata', $arrayListChartMun);
            $beanCollectionChartPrv = $this->javabridge->load_datasource($source = 'multidata', $arrayListChartPrv);
            $beanCollectionChartHMO = $this->javabridge->load_datasource($source = 'multidata', $arrayListChartHMO);
            $beanCollectionChartROR = $this->javabridge->load_datasource($source = 'multidata', $arrayListChartROR);
            $beanCollectionChartVOR = $this->javabridge->load_datasource($source = 'multidata', $arrayListChartVOR);
 
            $params->put("CompanyLogo","C:/xampp/htdocs/drainwizv2/assets/img/logo.png");
            $params->put('CompanyName', "DRAINWIZ SYSTEMS INC.");
            $params->put('CompanyAdrs', "Echaves St. Dipolog City, Zamboanga Del Norte 7100");
            $params->put('CompanyCont', "(+639)38-278-6751");
            
            $params->put('SelectedMonth', strval($seldateparameter));
            $params->put('CRMReportTitle', "CRM Generated Result");
            
            $params->put('GenderDataSource', $beanCollectionChartGen);
            $params->put('GenderCategoryTitle', "GENDER CATEGORY");
            
            $params->put('AgeDataSource', $beanCollectionChartAge);
            $params->put('AgeCategoryTitle', "AGE CATEGORY");
            
            $params->put('CitymunDataSource', $beanCollectionChartMun);
            $params->put('CitymunCategoryTitle', "CITY/MUNICIPALITY CATEGORY (TOP 10)");
            
            $params->put('ProvinceDataSource', $beanCollectionChartPrv);
            $params->put('ProvinceCategoryTitle', "PROVINCE CATEGORY (TOP 10)");
            
            $params->put('InsuranceDataSource', $beanCollectionChartHMO);
            $params->put('InsuranceCategoryTitle', "HMO/INSURANCE CATEGORY (TOP 10)");
            
            $params->put('RoomrateDataSource', $beanCollectionChartROR);
            $params->put('RoomrateCategoryTitle', "ROOM OCCUPANCY RATE (TOP 10)");
            
            $params->put('VolumerqDataSource', $beanCollectionChartVOR);
            $params->put('VolumerqCategoryTitle', "VOLUME OF REQUEST");
            
            $jasperPrint = $fillManager->fillReport($report, $params, $emptyDataSource);
            $exportManager = $this->javabridge->load_manager($type = 'exporter');
            
            $outputPath = $reportdirectory.$reportmodulexxx."/CRMGeneratedData.pdf";
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition:filename=CRM Generated Data.pdf');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

            readfile($outputPath);
            unlink($outputPath);
        }
        else
        {
            redirect(base_url("user/index"));
        }
    }
    
    public function getInpatientCityMunicipalityOthers()
    {
        $result = array('status' => FALSE);
        
        $monthyear = $this->input->post('monthyearx');
        $pxtype = $this->input->post('pxtypex');
        $citystrings = $this->input->post('citynames');
        
        $getinpatientcitymunothers = $this->dashboard_model->get_inpatient_citymun_for_others($monthyear,$pxtype,$citystrings);
        if ($getinpatientcitymunothers) 
        {
            $result['getinpatientcitymunothers'] = $getinpatientcitymunothers;
            $result['status'] = TRUE;
        }
        
        echo json_encode($result);
    }
    
    public function getInpatientProvinceOthers()
    {
        $result = array('status' => FALSE);
        
        $monthyear = $this->input->post('monthyearx');
        $pxtype = $this->input->post('pxtypex');
        $provstrings = $this->input->post('provnames');
        
        $getinpatientprovinceothers = $this->dashboard_model->get_inpatient_province_for_others($monthyear,$pxtype,$provstrings);
        if ($getinpatientprovinceothers) 
        {
            $result['getinpatientprovinceothers'] = $getinpatientprovinceothers;
            $result['status'] = TRUE;
        }
        
        echo json_encode($result);
    }
    
    public function getInpatientInsuranceOthers()
    {
        $result = array('status' => FALSE);
        
        $monthyear = $this->input->post('monthyearx');
        $pxtype = $this->input->post('pxtypex');
        $hmostrings = $this->input->post('hmonames');
        
        $getinpatientinsuranceeothers = $this->dashboard_model->get_inpatient_insurance_for_others($monthyear,$pxtype,$hmostrings);
        if ($getinpatientinsuranceeothers) 
        {
            $result['getinpatientinsuranceothers'] = $getinpatientinsuranceeothers;
            $result['status'] = TRUE;
        }
        
        echo json_encode($result);
    }
    
    public function getInpatientRoomOccupancyRateOthers()
    {
        $result = array('status' => FALSE);
        
        $monthyear = $this->input->post('monthyearx');
        $pxtype = $this->input->post('pxtypex');
        $roomstrings = $this->input->post('RORnames');
        
        $getinpatientroomrateothers = $this->dashboard_model->get_inpatient_room_for_others($monthyear,$pxtype,$roomstrings);
        if ($getinpatientroomrateothers) 
        {
            $result['getinpatientroomrateothers'] = $getinpatientroomrateothers;
            $result['status'] = TRUE;
        }
        
        echo json_encode($result);
    }
}
