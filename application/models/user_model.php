<?php

class user_model extends MY_Model {

    public function __construct() {
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

    public function get_hospital() {
        $this->db->select("*")
                ->from(profile_tbl);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_textdata() {
        $this->db->select("*")
                ->from(textdata_tbl);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_all_data($start_date, $end_date, $by_doctor = FALSE, $by_patient = FALSE, $by_classification = FALSE) {
        if ($by_doctor) {
            $this->db->select('doctorname')
                    ->select_sum('n')
                    ->select_sum('m')
                    ->select_sum('(m + n)', 'z')
                    ->from(docview_tbl)
                    ->where('admitdate <=', $end_date)
                    ->where('dischadate >=', $start_date)
                    ->group_by('doctorname');
            $query = $this->db->get();
        }

        if ($by_patient) {
            $this->db->select('name, phicmembr, admitdate, admittime')
                    ->from(inpatient_tbl)
                    ->where('discharged', 0)
                    ->where('(dischadate >= "' . $start_date . '" and admitdate <= "' . $end_date . '")', NULL, FALSE)
                    ->where('pxtype', 'IPD');
            $query = $this->db->get();
        }

        if ($by_classification) {
            $this->db->select('pat_classification, count(*) c')
                    ->from(inpatient_tbl)
                    ->where('discharged', 0)
                    ->where('(dischadate >= "' . $start_date . '" and admitdate <= "' . $end_date . '")', NULL, FALSE)
                    ->where('pxtype', 'IPD')
                    ->group_by('pat_classification having count(*) > 0', NULL, FALSE);
            $query = $this->db->get();
        }

        return $query->result_array();
    }

    public function get_census_data($s_date, $e_date, $type) {
        $this->db->select('name, phicmembr, admitdate, admittime')
                ->from(inpatient_tbl);

        if ($type === 0) {
            $this->db->where("admitdate", $s_date);
            $this->db->where('discharged', '0');
        } else {
            $this->db->where("dischadate", $s_date);
            $this->db->where('discharged', '1');
        }

        $this->db->where('pxtype', 'IPD');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_records($s_date, $e_date) {
        $result['px_records'] = $this->user_model->get_all_data($s_date, $e_date, FALSE, TRUE, FALSE);

        return $result;
    }

    public function get_sign_in_data($username, $pass) {
        $this->hub_db->select('*')
                ->from(usersrights_tbl)
                ->where('EmpID', $username)
                ->where('EmpPass', $this->encrypt_pass($pass));
        $query = $this->hub_db->get();

        return $query->row_array();
    }

    public function check_username($username) {
        $this->hub_db->select('*')
                ->from(usersrights_tbl)
                ->where('EmpID', $username);
        $query = $this->hub_db->get();

        return $query->row_array();
    }

    public function check_pass($username, $pass) {
        $this->hub_db->select('*')
                ->from(usersrights_tbl)
                ->where('EmpID', $username)
                ->where('EmpPass', $this->encrypt_pass($pass));
        $query = $this->hub_db->get();

        return (count($query->row_array()) !== 0) ? TRUE : FALSE;
    }

    public function check_if_supervisor_account_is_correct($username, $pass) {
        $this->hub_db->select('*')
                ->from(usersrights_tbl)
                ->where('EmpID', $username)
                ->where('EmpPass', $this->encrypt_pass($pass))
                ->where('leveluser', 'S');
        $query = $this->hub_db->get();

        return (count($query->row_array()) !== 0) ? TRUE : FALSE;
    }

    public function _test() {
        $s_date = "2017-06-01";
        $e_date = "2017-07-03";
        $true = FALSE;
        if ($this->get_patient_by_type('casetype', 'OPD', $s_date, $e_date)) {
            $true = TRUE;
        }
        var_dump($true);
    }

    public function modify_accountx($datax) {
        $data = array(
            'EmpPass' => $this->encrypt_pass($this->security->xss_clean($datax["pword"])),
            'updated' => $this->get_current_date()
        );

        $this->hub_db->where('ID', $this->security->xss_clean($this->session->userdata('userid')));
        return $this->hub_db->update(usersrights_tbl, $data);
    }

    public function get_proofs($by, $s_date, $e_date) {
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
        } else {
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

    public function get_proof_details($by) {
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
        } else {
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

    public function get_patients($s_date, $type) {

        $order_column = array("caseno", "name", "admitdate", null, "dischadate", null, "pat_classification", "phicmembr", "roombrief", "doctorname");
        if ($type === 0) {
            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,phicmembr,roombrief,doctorname')
                    ->from(inpatient_tbl)
                    ->group_start()
                    ->where('admitdate', $s_date)
                    ->where('pxtype', 'IPD')
                    ->group_end();
            if (!empty($this->input->post("search")["value"])) {
                $this->db->group_start()
                        ->like("name", $this->input->post("search")["value"])
                        ->or_like("admitdate", $this->input->post("search")["value"])
                        ->or_like("dischadate", $this->input->post("search")["value"])
                        ->or_like("pat_classification", $this->input->post("search")["value"])
                        ->group_end();
            }
            if (!empty($this->input->post("order"))) {
                $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
            } else {
                $this->db->order_by('admittime', 'ASC');
            }
        } else {
            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,phicmembr,roombrief,doctorname')
                    ->from(inpatient_tbl)
                    ->group_start()
                    ->where('pxtype', 'IPD')
                    ->where('dischadate ', $s_date)
                    ->where('discharged ', '1')
                    ->group_end();

            if (!empty($this->input->post("search")["value"])) {
                $this->db->group_start()
                        ->like("name", $this->input->post("search")["value"])
                        ->or_like("admitdate", $this->input->post("search")["value"])
                        ->or_like("dischadate", $this->input->post("search")["value"])
                        ->or_like("pat_classification", $this->input->post("search")["value"])
                        ->group_end();
            }
            if (!empty($this->input->post("order"))) {
                $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
            } else {
                $this->db->order_by('dischatime', 'ASC');
            }
        }
    }

    /**
     * 
     * make admitted and discharged patient table
     */
    function make_patients_datatables($s_date, $type) {
        $this->get_patients($s_date, $type);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for admitted and discharged patient table
     */
    function get_patients_filtered_data($s_date, $type) {
        $this->get_patients($s_date, $type);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_patients_data($s_date, $type) {
        if ($type === 0) {
            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,phicmembr,roombrief,doctorname')
                    ->from(inpatient_tbl)
//                   ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                    ->where('admitdate', $s_date)
                    ->where('pxtype', 'IPD')
                    ->order_by('admittime', 'ASC');
        } else {
            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,phicmembr,roombrief,doctorname')
                    ->from(inpatient_tbl)
                    ->where('pxtype', 'IPD')
                    ->where('dischadate ', $s_date)
                    ->where('discharged ', '1')
                    ->order_by('dischatime', 'ASC');
        }

        return $this->db->count_all_results();
    }

    public function pat_report($s_date, $type) {
        $monthstart = date("Y-m-01", strtotime($s_date . "-01"));
        $monthend = date("Y-m-t", strtotime($s_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        if ($type === 0) {
            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,roombrief,doctorname')
                    ->from(inpatient_tbl)
                    ->where('admitdate', $s_date)
                    ->where('pxtype', 'IPD')
                    ->order_by('admittime', 'ASC');
        } else if ($type === 1) {
            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,roombrief,doctorname')
                    ->from(inpatient_tbl)
                    ->where('pxtype', 'IPD')
                    ->where('dischadate ', $s_date)
                    ->where('discharged ', '1')
                    ->order_by('dischatime', 'ASC');
        } else if ($type === 3) {
            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,roombrief,doctorname')
                    ->from(inpatient_tbl)
//                   ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                    ->where('admitdate >=', $first)
                    ->where('admitdate <=', $end)
                    ->where('pxtype', 'IPD')
                    ->order_by('admittime', 'ASC');
        } else {
            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,roombrief,doctorname')
                    ->from(inpatient_tbl)
                    ->where('pxtype', 'IPD')
                    ->where('dischadate ', $s_date)
                    ->where('discharged ', '1')
                    ->order_by('dischatime', 'ASC');
        }


        $query = $this->db->get();
        return $query->result_array();
    }

    //get total patients: Alingling

    public function get_patients_month($s_date, $type) {
        $monthstart = date("Y-m-01", strtotime($s_date . "-01"));
        $monthend = date("Y-m-t", strtotime($s_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("caseno", "name", "admitdate", null, "dischadate", null, "pat_classification", "phicmembr", "roombrief", "doctorname");
        if ($type === 0) {
            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,phicmembr,roombrief,doctorname')
                    ->from(inpatient_tbl)
                    ->group_start()
//                    ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
//                    ->where('admitdate = "'.$s_date.'" AND discharged = 0')
                    ->where('admitdate >=', $first)
                    ->where('admitdate <=', $end)
                    ->where('pxtype', 'IPD')
                    ->group_end();
            if (!empty($this->input->post("search")["value"])) {
                $this->db->group_start()
                        ->like("name", $this->input->post("search")["value"])
                        ->or_like("admitdate", $this->input->post("search")["value"])
                        ->or_like("dischadate", $this->input->post("search")["value"])
                        ->or_like("pat_classification", $this->input->post("search")["value"])
                        ->group_end();
            }
            if (!empty($this->input->post("order"))) {
                $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
            } else {
                $this->db->order_by('admittime', 'ASC');
            }
        } else {
            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,phicmembr,roombrief,doctorname')
                    ->from(inpatient_tbl)
                    ->group_start()
                    ->where('pxtype', 'IPD')
                    ->where('dischadate >=', $first)
                    ->where('dischadate <=', $end)
                    ->where('discharged ', '1')
                    ->group_end();

            if (!empty($this->input->post("search")["value"])) {
                $this->db->group_start()
                        ->like("name", $this->input->post("search")["value"])
                        ->or_like("admitdate", $this->input->post("search")["value"])
                        ->or_like("dischadate", $this->input->post("search")["value"])
                        ->or_like("pat_classification", $this->input->post("search")["value"])
                        ->group_end();
            }
            if (!empty($this->input->post("order"))) {
                $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
            } else {
                $this->db->order_by('dischatime', 'ASC');
            }
        }
    }

    /**
     * 
     * make admitted and discharged patient table
     */
    function make_patients_month_datatables($s_date, $type) {
        $this->get_patients_month($s_date, $type);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for admitted and discharged patient table
     */
    function get_patients_month_filtered_data($s_date, $type) {
        $this->get_patients_month($s_date, $type);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_patients_month_data($s_date, $type) {
        $monthstart = date("Y-m-01", strtotime($s_date . "-01"));
        $monthend = date("Y-m-t", strtotime($s_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        if ($type === 0) {
            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,phicmembr,roombrief,doctorname')
                    ->from(inpatient_tbl)
//                   ->where('((admitdate <= "'.$s_date.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$s_date.'" AND admitdate <= "'.$s_date.'"))')
                    ->where('admitdate >=', $first)
                    ->where('admitdate <=', $end)
                    ->where('pxtype', 'IPD')
                    ->order_by('admittime', 'ASC');
        } else {
            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,phicmembr,roombrief,doctorname')
                    ->from(inpatient_tbl)
                    ->where('pxtype', 'IPD')
                    ->where('dischadate >=', $first)
                    ->where('dischadate <=', $end)
                    ->where('discharged ', '1')
                    ->order_by('dischatime', 'IPD');
        }

        return $this->db->count_all_results();
    }

    //-----------------------------------------------------------------------------------doctors table

    public function get_doctor_expertise($expert) {
        $this->db->select(' docrefno, docname')
                ->from(doctors_tbl)
                ->where('expertise', $expert);

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * doctors table
     */
    public function get_doctors($start_date, $end_date, $expert = NULL) {
        $order_column = array("doctorid", "doctorname", "expertise", "nhip", "non", "total");
        $this->db->select('doctorid,expertise,dischadate,doctorname,count(phicmembr) as total, sum(case when phicmembr = "non-nhip" then 1 else 0 end) non,sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,')
                ->from(doctor_inpatient_vw)
                ->where('dischadate BETWEEN "' . $start_date . '" and "' . $end_date . '"');
        if ($expert !== NULL && $expert !== "All") {
            $this->db->where('expertise', $expert);
        }

        $this->db->group_by('doctorid');


        if (!empty($this->input->post("search")["value"])) {
            $this->db->like("doctorname", $this->input->post("search")["value"]);
        }

        $this->db->group_by('doctorid');

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else {
            $this->db->order_by('total', 'DESC');
        }
    }

    /**
     * 
     * make doctors table
     */
    function make_doctors_datatables($start_date, $end_date, $expert = NULL) {
        $this->get_doctors($start_date, $end_date, $expert);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * returned doctors table search data
     */
    function get_doctors_filtered_data($start_date, $end_date, $expert = NULL) {
        $this->get_doctors($start_date, $end_date, $expert);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * count all doctors data
     */
    public function get_all_doctors_data($start_date, $end_date, $expert = NULL) {
        $this->db->select('doctorid,expertise,dischadate,doctorname,count(phicmembr) as total, sum(case when phicmembr = "non-nhip" then 1 else 0 end) non,sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,')
                ->from(doctor_inpatient_vw)
                ->where('dischadate BETWEEN "' . $start_date . '" and "' . $end_date . '"');
        if ($expert !== NULL && $expert !== "All") {
            $this->db->where('expertise', $expert);
        }
        $this->db->order_by('total', 'DESC');
        $this->db->group_by('doctorid');

        return $this->db->count_all_results();
    }

    //-------------------------------------------------------------------------------id patients
    public function get_ipd_patients($s_date, $e_date) {
        $order_column = array("pat_classification", null, null);
        $this->db->select('pat_classification,'
                        . ' sum(case when discharged = 0 then 1 else 0 end) admitted,'
                        . ' sum(case when discharged = 1 then 1 else 0 end) discharged_px')
                ->from(inpatient_tbl)
                ->where('(admitdate <= "' . $s_date . '" and dischadate >= "' . $e_date . '")', NULL, FALSE)
                ->where('pxtype', 'IPD')
                ->group_by('pat_classification')
                ->having('admitted > 0 or discharged_px > 0');

        if (!empty($this->input->post("search")["value"])) {
            $this->db->like("pat_classification", $this->input->post("search")["value"]);
        }
        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('pat_classification', 'ASC');
        }
    }

    /**
     * 
     * make ipd patient table
     */
    function make_ipd_patients_datatables($s_date, $e_date) {
        $this->get_ipd_patients($s_date, $e_date);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for ipd patient table
     */
    function get_ipd_patients_filtered_data($s_date, $e_date) {
        $this->get_ipd_patients($s_date, $e_date);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_ipd_patients_data($s_date, $e_date) {
        $this->db->select('pat_classification,'
                        . ' sum(case when discharged = 0 then 1 else 0 end) admitted,'
                        . ' sum(case when discharged = 1 then 1 else 0 end) discharged_px')
                ->from(inpatient_tbl)
                ->where('(admitdate >= "' . $s_date . '" and admitdate <= "' . $e_date . '")', NULL, FALSE)
                ->where('(dischadate >= "' . $s_date . '" and dischadate <= "' . $e_date . '")', NULL, FALSE)
                ->where('pxtype', 'IPD')
                ->group_by('pat_classification')
                ->having('admitted > 0 or discharged_px > 0');

        return $this->db->count_all_results();
    }

    //-----------------------------------------------------------------------------------------------opd patients
    public function get_opd_patients($s_date, $e_date) {
        $order_column = array("casetype", null, null);
        $this->db->select('casetype,'
                        . ' sum(case when discharged = 0 then 1 else 0 end) admitted,'
                        . ' sum(case when discharged = 1 then 1 else 0 end) discharged_px')
                ->from(inpatient_tbl)
                ->where('(admitdate <= "' . $s_date . '" and dischadate >= "' . $e_date . '")', NULL, FALSE)
                ->where('pxtype', 'OPD')
                ->group_by('casetype')
                ->having('admitted > 0 or discharged_px > 0');

        if (!empty($this->input->post("search")["value"])) {
            $this->db->like("casetype", $this->input->post("search")["value"]);
        }
        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('casetype', 'ASC');
        }
    }

    /**
     * 
     * make opd patient table
     */
    function make_opd_patients_datatables($s_date, $e_date) {
        $this->get_opd_patients($s_date, $e_date);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for opd patient table
     */
    function get_opd_patients_filtered_data($s_date, $e_date) {
        $this->get_opd_patients($s_date, $e_date);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_opd_patients_data($s_date, $e_date) {
        $this->db->select('casetype,'
                        . ' sum(case when discharged = 0 then 1 else 0 end) admitted,'
                        . ' sum(case when discharged = 1 then 1 else 0 end) discharged_px')
                ->from(inpatient_tbl)
                ->where('(admitdate >= "' . $s_date . '" and admitdate <= "' . $e_date . '")', NULL, FALSE)
                ->where('(dischadate >= "' . $s_date . '" and dischadate <= "' . $e_date . '")', NULL, FALSE)
                ->where('pxtype', 'OPD')
                ->group_by('casetype')
                ->having('admitted > 0 or discharged_px > 0');

        return $this->db->count_all_results();
    }

    //------------------------------------------------------------------------------------------patients

    public function get_all_patients() {
        $order_column = array("name", "phicmembr", "admitdate");
        $this->db->select('name, phicmembr, admitdate, admittime')
                ->from(inpatient_tbl)
                ->group_start()
                ->where('discharged', 0)
                ->group_end();
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("name", $this->input->post("search")["value"])
                    ->or_like("phicmembr", $this->input->post("search")["value"])
                    ->or_like("admitdate", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('name', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_all_patients_datatables() {
        $this->get_all_patients();
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_all_patients_filtered_data() {
        $this->get_all_patients();
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_patients_data() {
        $this->db->select('name, phicmembr, admitdate, admittime')
                ->from(inpatient_tbl)
                ->where('discharged', 0);

        return $this->db->count_all_results();
    }

    //---------------------------------------------------------------------------px classification

    public function get_all_patients_classification($s_date, $e_date, $doccode = NULL) {
        $order_column = array("pat_classification", null);
        $this->db->select('pat_classification, count(*) c')
                ->from(inpatient_tbl)
                ->group_start()
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD');
        if ($doccode !== NULL && $doccode !== "All") {
            $this->db->where('doctorid', $doccode);
        }
        $this->db->group_by('pat_classification')
                ->group_end();
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("pat_classification", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('pat_classification', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_all_patients_classification_datatables($s_date, $e_date, $doccode = NULL) {
        $this->get_all_patients_classification($s_date, $e_date, $doccode);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_all_patients_classification_filtered_data($s_date, $e_date, $doccode = NULL) {
        $this->get_all_patients_classification($s_date, $e_date, $doccode);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_patients_classification_data($s_date, $e_date, $doccode = NULL) {
        $this->db->select('pat_classification, count(*) c')
                ->from(inpatient_tbl)
                ->group_start()
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD');
        if ($doccode !== NULL && $doccode !== "All") {
            $this->db->where('doctorid', $doccode);
        }
        $this->db->group_by('pat_classification')
                ->group_end();

        return $this->db->count_all_results();
    }

    /*
     * Get information from the classification
     * 
     */

    public function get_all_classification_patients($class, $s_date, $e_date, $doccode = NULL) {
        $order_column = array("name", "admit", "discharge", "doctorname");
        $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge,doctorname')
                ->from(inpatient_tbl)
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD')
                ->where("pat_classification", $class);
        if ($doccode !== NULL && $doccode !== "All") {
            $this->db->where('doctorid', $doccode);
        }



        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("name", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('name', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_all_classification_patients_datatables($class, $s_date, $e_date, $doccode = NULL) {
        $this->get_all_classification_patients($class, $s_date, $e_date, $doccode);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_all_classification_patients_filtered_data($class, $s_date, $e_date, $doccode = NULL) {
        $this->get_all_classification_patients($class, $s_date, $e_date, $doccode);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_classification_patients_data($class, $s_date, $e_date, $doccode = NULL) {
        $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge,doctorname')
                ->from(inpatient_tbl)
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD')
                ->where("pat_classification", $class);
        if ($doccode !== NULL && $doccode !== "All") {
            $this->db->where('doctorid', $doccode);
        }

        return $this->db->count_all_results();
    }

    //

    /*
     * Get information from the disposition: patients
     * 
     */
    public function get_all_disposition_patients($class, $s_date, $e_date, $doccode = NULL) {
        $order_column = array("name", "admit", "discharge", null);
        $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge,doctorname')
                ->from(inpatient_tbl)
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD')
                ->where("disposition", $class);
        if ($doccode !== NULL && $doccode !== "All") {
            $this->db->where('doctorid', $doccode);
        }


        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("name", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('name', 'ASC');
        }
    }

    function make_all_disposition_patients_datatables($class, $s_date, $e_date, $doccode = NULL) {
        $this->get_all_disposition_patients($class, $s_date, $e_date, $doccode);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_all_disposition_patients_filtered_data($class, $s_date, $e_date, $doccode = NULL) {
        $this->get_all_disposition_patients($class, $s_date, $e_date, $doccode);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_disposition_patients_data($class, $s_date, $e_date, $doccode = NULL) {
        $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge,doctorname')
                ->from(inpatient_tbl)
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD')
                ->where("disposition", $class);
        if ($doccode !== NULL && $doccode !== "All") {
            $this->db->where('doctorid', $doccode);
        }

        return $this->db->count_all_results();
    }

    //disposition: alingling



    public function get_all_patients_disposition($s_date, $e_date, $doccode = NULL) {
        $order_column = array("disposition", null);
        $this->db->select('disposition, count(*) c')
                ->from(inpatient_tbl)
                ->group_start()
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD')
                ->group_by('disposition having count(*) > 0', NULL, FALSE);
        if ($doccode !== NULL && $doccode !== "All") {
            $this->db->where('doctorid', $doccode);
        }
        $this->db->group_end();
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("disposition", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('disposition', 'ASC');
        }
    }

    function get_all_patients_disposition_filtered_data($s_date, $e_date, $doccode = NULL) {
        $this->get_all_patients_disposition($s_date, $e_date, $doccode);

        $query = $this->db->get();
        return $query->num_rows();
    }

    function make_all_patients_disposition_datatables($s_date, $e_date, $doccode = NULL) {
        $this->get_all_patients_disposition($s_date, $e_date, $doccode);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_patients_disposition_data($s_date, $e_date, $doccode = NULL) {
        $this->db->select('disposition, count(*) c')
                ->from(inpatient_tbl)
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD');
        if ($doccode !== NULL && $doccode !== "All") {
            $this->db->where('doctorid', $doccode);
        }
        $this->db->group_by('disposition having count(*) > 0', NULL, FALSE);

        return $this->db->count_all_results();
    }

    //disposition
    //-----------------------------------------------------------------------------------------------cahs flow
    public function get_all_proofs($by, $s_date, $e_date) {
        $order_column = array();

        if ($by === 1) {
            $order_column = array("updated", null, null, null);
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
        } else {
            $order_column = array("updated", "updatedby", null, null, null);
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
        if (!empty($this->input->post("search")["value"])) {
            $this->cas_db->group_start();
            $this->cas_db->like("updated", $this->input->post("search")["value"]);
            if ($by !== 1) {
                $this->cas_db->or_like("updatedby", $this->input->post("search")["value"]);
            }
            $this->cas_db->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->cas_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            if ($by === 1) {
                $this->cas_db->order_by('updated', 'DESC');
            } else {
                $this->cas_db->order_by('updated', 'DESC');
            }
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_all_proofs_datatables($by, $s_date, $e_date) {
        $this->get_all_proofs($by, $s_date, $e_date);
        if ($this->input->post("length") != -1) {
            $this->cas_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->cas_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_all_proofs_filtered_data($by, $s_date, $e_date) {
        $this->get_all_proofs($by, $s_date, $e_date);
        $query = $this->cas_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_proofs_data($by, $s_date, $e_date) {
        if ($by === 1) {
            $order_column = array("udate", "debit", "credit", null);
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
        } else {
            $order_column = array("updated", "updatedby", "debit", "credit", null);
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

    public function get_all_proofs_chart($by, $s_date) {
        $data = array();
        $dates = array();

        $start_date = date('Y-m-d', strtotime("-29 days", strtotime($s_date)));
        //echo $start_date;
        $end_date = new DateTime($s_date);
        $end_date->format("Y-m-d");

        $period = new DatePeriod(
                new DateTime($start_date), new DateInterval('P1D'), $end_date
        );


        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        $dates[] = $s_date;

        if ($by === 1) {
            for ($i = 0; $i < count($dates); $i++) {
                $order_column = array("udate", "debit", "credit", null);
                $this->cas_db->select('"' . $dates[$i] . '" as datex,updatedby,updated,'
                                . 'DATE(updated) as udate,'
                                . 'sum(dbamt) as debit,'
                                . 'sum(cramt) as credit')
                        ->from(proofsheetdetails_tbl)
                        ->group_start()
                        ->where('DATE(updated)', $dates[$i])
                        ->group_by('udate')
                        ->group_end();

                $query = $this->cas_db->get();
                array_push($data, $query->row_array());
            }
        } else {
            for ($i = 0; $i < count($dates); $i++) {
                $order_column = array("updated", "updatedby", "debit", "credit", null);
                $this->cas_db->select('"' . $dates[$i] . '" as datex,updatedby,updated,'
                                . 'DATE(updated) as udate,'
                                . 'sum(dbamt) as debit,'
                                . 'sum(cramt) as credit')
                        ->from(proofsheetdetails_tbl)
                        ->group_start()
                        ->where('DATE(updated)', $dates[$i])
                        ->group_by(array("udate", "updatedby"))
                        ->group_end();


                $query = $this->cas_db->get();

                array_push($data, $query->row_array());
            }
        }


        return $data;





        //
    }

    public function ipd_dis_ad_report($s_date, $e_date, $search) {
        $this->db->select('pat_classification,'
                        . ' sum(case when discharged = 0 then 1 else 0 end) admitted,'
                        . ' sum(case when discharged = 1 then 1 else 0 end) discharged_px')
                ->from(inpatient_tbl)
                ->where('(admitdate >= "' . $s_date . '" and admitdate <= "' . $e_date . '")', NULL, FALSE)
                ->where('(dischadate >= "' . $s_date . '" and dischadate <= "' . $e_date . '")', NULL, FALSE)
                ->where('pxtype', 'IPD')
                ->group_by('pat_classification')
                ->having('admitted > 0 or discharged_px > 0');

        if (!empty($search)) {
            $this->db->like("pat_classification", $search);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function opd_dis_ad_report($s_date, $e_date, $search) {
        $this->db->select('casetype,'
                        . ' sum(case when discharged = 0 then 1 else 0 end) admitted,'
                        . ' sum(case when discharged = 1 then 1 else 0 end) discharged_px')
                ->from(inpatient_tbl)
                ->where('(admitdate >= "' . $s_date . '" and admitdate <= "' . $e_date . '")', NULL, FALSE)
                ->where('(dischadate >= "' . $s_date . '" and dischadate <= "' . $e_date . '")', NULL, FALSE)
                ->where('pxtype', 'OPD')
                ->group_by('casetype')
                ->having('admitted > 0 or discharged_px > 0');

        if (!empty($search)) {
            $this->db->like("casetype", $search);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function dis_phic_report($s_date, $e_date, $search) {
        $this->db->select('phicmembr, count(*) c')
                ->from(inpatient_tbl)
                ->group_start()
                ->where('(dischadate <= "' . $s_date . '" and dischadate >= "' . $e_date . '")', NULL, FALSE)
                ->where('pxtype', 'IPD')
                ->where('discharged', 1)
                ->group_by('phicmembr')
                ->group_end();

        if (!empty($search)) {
            $this->db->group_start()
                    ->like('phicmembr', $search)
                    ->group_end();
        }
        $this->db->order_by('phicmembr', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function doc_report($dd) {

        $this->db->select('doctorid,expertise,dischadate,doctorname,count(phicmembr) as total, sum(case when phicmembr = "non-nhip" then 1 else 0 end) non,sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,')
                ->from(doctor_inpatient_vw)
                ->where('dischadate BETWEEN "' . $dd['s_date'] . '" and "' . $dd['e_date'] . '"');
        if ($dd['exp'] !== NULL && $dd['exp'] !== "All") {
            $this->db->where('expertise', $dd['exp']);
        }
        if ($dd['searc'] !== NULL && $dd['searc'] !== "") {
            $this->db->like('doctorname', $dd['searc']);
        }

        $this->db->order_by('total', 'DESC');
        $this->db->group_by('doctorid');


        $query = $this->db->get();
        return $query->result_array();
    }

    public function px_report($search) {
        $this->db->select('name, phicmembr, admitdate, admittime')
                ->from(inpatient_tbl)
                ->group_start()
                ->where('discharged', 0)
                ->group_end();
        if (!empty($search)) {
            $this->db->group_start()
                    ->like("name", $search)
                    ->or_like("phicmembr", $search)
                    ->or_like("admitdate", $search)
                    ->group_end();
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function class_report($s_date, $e_date, $doccode = NULL) {
        $this->db->select('pat_classification, count(*) c')
                ->from(inpatient_tbl)
                ->group_start()
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD');
        if ($doccode !== NULL && $doccode !== "All") {
            $this->db->where('doctorid', $doccode);
        }

        $this->db->group_by('pat_classification')
                ->group_end();
        $query = $this->db->get();
        return $query->result_array();
    }

    public function class_info_report($s_date, $e_date, $classx, $doccode = NULL) {
        $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge,doctorname')
                ->from(inpatient_tbl)
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD')
                ->where("pat_classification", $classx);
        if ($doccode !== NULL && $doccode !== "All") {
            $this->db->where('doctorid', $doccode);
        }
        $this->db->order_by('dischadate', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function dispo_info_report($s_date, $e_date, $classx, $doccode = NULL) {
        $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge,doctorname')
                ->from(inpatient_tbl)
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD')
                ->where("disposition", $classx);
        if ($doccode !== NULL && $doccode !== "All") {
            $this->db->where('doctorid', $doccode);
        }
        $this->db->order_by('dischadate', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function approvedticket_report($s_date) {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '1')
                ->where('deferred', '0')
                ->where('RETURNTICKET', '0')
                ->where('BOOKTYPE', 'CDB')
                ->like('APRVDATETIME', $s_date)
                ->group_end();

        $query = $this->ams_db->get();
        return $query->result_array();
    }

    public function csv_approvedticket_report($s_date) {

        $this->ams_db->select('PAYEE,CHEQUEAMT,EXPLANATION,TICKETDATE,note')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '1')
                ->where('deferred', '0')
                ->where('RETURNTICKET', '0')
                ->where('BOOKTYPE', 'CDB')
                ->like('APRVDATETIME', $s_date)
                ->group_end();

        $query = $this->ams_db->get();
        return $query->result_array();
    }

    //deferred_report:alingling
    public function deferredticket_report() {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '0')
                ->where('deferred', '1')
                ->where('RETURNTICKET', '0')
                ->where('BOOKTYPE', 'CDB')
                ->group_end();

        $query = $this->ams_db->get();
        return $query->result_array();
    }

    public function csv_deferredticket_report() {

        $this->ams_db->select('APRVDATETIME,PAYEE,CHEQUEAMT,EXPLANATION,TICKETDATE,note')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '0')
                ->where('deferred', '1')
                ->where('RETURNTICKET', '0')
                ->where('BOOKTYPE', 'CDB')
                ->group_end();

        $query = $this->ams_db->get();
        return $query->result_array();
    }

    public function disapprovedticket_report() {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '0')
                ->where('deferred', '0')
                ->where('RETURNTICKET', '1')
                ->where('BOOKTYPE', 'CDB')
                ->group_end();

        $query = $this->ams_db->get();
        return $query->result_array();
    }

    public function csv_disapprovedticket_report() {
        $this->ams_db->select('APRVDATETIME,PAYEE,CHEQUEAMT,EXPLANATION,TICKETDATE,note')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '0')
                ->where('deferred', '0')
                ->where('RETURNTICKET', '1')
                ->where('BOOKTYPE', 'CDB')
                ->group_end();

        $query = $this->ams_db->get();
        return $query->result_array();
    }

    //disposition: alingling
    public function dispo_report($s_date, $e_date, $doccode = NULL) {
        $this->db->select('disposition, count(*) c')
                ->from(inpatient_tbl)
                ->group_start()
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD');
        if ($doccode !== NULL && $doccode !== "All") {
            $this->db->where('doctorid', $doccode);
        }
        $this->db->group_by('disposition')
                ->group_end();
        $query = $this->db->get();
        return $query->result_array();
    }

    //disposition



    public function proofsheet_report($s_date, $e_date, $search, $by) {
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
        } else {
            $this->cas_db->group_by(array("udate", "updatedby"));
        }
        $this->cas_db->group_end();

        if (!empty($search)) {
            $this->cas_db->group_start();
            $this->cas_db->like("updated", $search);
            if (intval($by) === 0) {
                $this->cas_db->or_like("updatedby", $search);
            }
            $this->cas_db->group_end();
        }

        $this->cas_db->order_by("udate", "DESC");

        $query = $this->cas_db->get();
        return $query->result_array();
    }

    //---------------------------------------------------------------------------------room stats

    public function get_rooms($date) {
        $this->db->select('roomno,"' . $date . '" as mydate,count(*) as total,
                            (select count(*) from rmlist where rmno=roomno) as totalbed,
                            (count(*) / (select count(*) from rmlist where rmno=roomno)) * 100 as percentage ')
                ->from(inpatient_tbl)
                ->where('dischadate >=', $date)
                ->where('admitdate <=', $date)
                ->group_by('roomno');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_raw_expenses() {
        $this->cas_db->select('updated, expgroup, amount, debit, credit, expenseno, expcode, particulars')
                ->from(expenses_tbl)
                ->order_by('updated');
        $query = $this->cas_db->get();
        return $query->result_array();
    }

    public function create_exp_table() {
        $data = $this->generate_exp_data($this->get_raw_expenses());
        $this->cas_db->empty_table(exptemp_tbl);
        $this->cas_db->insert_batch(exptemp_tbl, $data);
    }

    public function generate_exp_data($data) {
        $totaldebit = 0;
        $expenses = array();

        for ($i = 0; $i < count($data); $i++) {
            $totaldebit += $data[$i]['debit'];
            array_push($expenses, array(
                'id' => $i + 1,
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
    public function get_all_expenses() {
        $order_column = array("updated", "expgroup", "amount", "debit", "credit", "balance", NULL);
        $this->cas_db->select('updated, expgroup, amount, debit, credit, balance, id, particulars')->from(exptemp_tbl);

        if (!empty($this->input->post("search")["value"])) {
            $this->cas_db->group_start()
                    ->like("updated", $this->input->post("search")["value"])
                    ->or_like("expgroup", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->cas_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->cas_db->order_by("updated", "DESC");
        }
    }

    /**
     * 
     * make all expenses table
     */
    function make_all_expenses_datatables() {
        $this->get_all_expenses();
        if ($this->input->post("length") != -1) {
            $this->cas_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->cas_db->get();
        return $query->result();
    }

    /**
     * search for all expenses table
     */
    function get_all_expenses_filtered_data() {
        $this->get_all_expenses();
        $query = $this->cas_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_expenses_data() {
        $this->cas_db->select('updated, expgroup, amount, debit, credit, balance, id')->from(exptemp_tbl);

        return $this->cas_db->count_all_results();
    }

    public function exp_report($search) {
        $this->cas_db->select('updated, expgroup, amount, debit, credit, expenseno, expcode, particulars, balance')->from(exptemp_tbl);

        if (!empty($search)) {
            $this->cas_db->group_start()
                    ->like("updated", $search)
                    ->or_like("expgroup", $search)
                    ->group_end();
        }

        $this->cas_db->order_by('updated', 'DESC');

        $query = $this->cas_db->get();
        return $query->result_array();
    }

    //---------------------------------------------------------------------------------------------ledger
    public function get_ledger($stock_barcode, $start_date = NULL) {
        if ($start_date !== NULL && $start_date !== "All") {
            $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
            $monthend = date("Y-m-t", strtotime($start_date . "-01"));


            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e = new DateTime($monthend);
            $end = $e->format('Y-m-d');
        }

        $order_column = array(ledgersales_tbl . ".dscr", ledgersales_tbl . ".transactiontype", ledgersales_tbl . ".cost", ledgersales_tbl . ".qty", ledgersales_tbl . ".totalcost", ledgersales_tbl . ".endbal", ledgersales_tbl . ".tdate");
        $this->pms_db->select(ledgersales_tbl . '.dscr,'
                        . ledgersales_tbl . '.cost,'
                        . ledgersales_tbl . '.transactiontype,'
                        . ledgersales_tbl . '.qty,'
                        . ledgersales_tbl . '.totalcost,'
                        . ledgersales_tbl . '.endbal,'
                        . ledgersales_tbl . '.tdate')
                ->from(ledgersales_tbl)
                ->where("prodid", $stock_barcode);
        if ($start_date !== NULL && $start_date !== "All") {
            $this->pms_db->where('tdate >= "' . $first . '"')
                    ->where('tdate <= "' . $end . '"');
        }
        $this->pms_db->limit(50);

        if (!empty($this->input->post("search")["value"])) {
            $this->pms_db->group_start()
                    ->like(ledgersales_tbl . '.dscr', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->pms_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->pms_db->order_by("tdate", "DESC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_ledger_datatables($stock_barcode, $start_date = NULL) {
        $this->get_ledger($stock_barcode, $start_date);
        if ($this->input->post("length") != -1) {
            $this->pms_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->pms_db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_ledger_filtered_data($stock_barcode, $start_date = NULL) {
        $this->get_ledger($stock_barcode, $start_date);
        $query = $this->pms_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_ledger_data($stock_barcode, $start_date = NULL) {
        if ($start_date !== NULL && $start_date !== "All") {
            $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
            $monthend = date("Y-m-t", strtotime($start_date . "-01"));


            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e = new DateTime($monthend);
            $end = $e->format('Y-m-d');
        }

        $this->pms_db->select(ledgersales_tbl . '.dscr,'
                        . ledgersales_tbl . '.cost,'
                        . ledgersales_tbl . '.transactiontype,'
                        . ledgersales_tbl . '.qty,'
                        . ledgersales_tbl . '.totalcost,'
                        . ledgersales_tbl . '.endbal,'
                        . ledgersales_tbl . '.tdate')
                ->from(ledgersales_tbl)
                ->where("prodid", $stock_barcode);
        if ($start_date !== NULL && $start_date !== "All") {
            $this->pms_db->where('tdate >= "' . $first . '"')
                    ->where('tdate <= "' . $end . '"');
        }
        $this->pms_db->limit(50);

        return $this->pms_db->count_all_results();
    }

    //----------------------------------------fetch_ledger1-----------------------------------------------------ledger
    public function get_ledger1($code, $dept, $transtype, $monthdate) {
        $monthstart = date("Y-m-01", strtotime($monthdate . "-01"));
        $monthend = date("Y-m-t", strtotime($monthdate . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        if ($dept == "PH") {
            $order_column = array("dscr", "tdate", "realcost", "qty", "totalamt", "transactiontype", "Supplier");
            $this->pms_db->select("dscr,tdate,realcost,qty,totalamt,transactiontype,Supplier")
                    ->from(ledgersales_tbl)
                    ->where("prodid", $code)
                    // ->where('tdate >= "'.$first.'"')
                    ->where('tdate <= "' . $end . '"');
            if ($transtype == "Delivery") {
                $this->pms_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
            }
            $this->pms_db->limit(100);

            if (!empty($this->input->post("search")["value"])) {
                $this->pms_db->group_start()
                        ->like('dscr', $this->input->post("search")["value"])
                        ->group_end();
            }

            if (!empty($this->input->post("order"))) {
                $this->pms_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
            } else {
                $this->pms_db->order_by("tdate", "DESC");
            }
        } else if ($dept == "LT") {
            $order_column = array("dscr", "tdate", "realcost", "qty", "totalamt", "transactiontype", "Supplier");
            $this->hls_db->select("dscr,tdate,realcost,qty,totalamt,transactiontype,Supplier")
                    ->from(ledgersales_tbl)
                    ->where("prodid", $code)
                    // ->where('tdate >= "'.$first.'"')
                    ->where('tdate <= "' . $end . '"');
            if ($transtype == "Delivery") {
                $this->hls_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
            }
            $this->hls_db->limit(100);

            if (!empty($this->input->post("search")["value"])) {
                $this->hls_db->group_start()
                        ->like('dscr', $this->input->post("search")["value"])
                        ->group_end();
            }

            if (!empty($this->input->post("order"))) {
                $this->hls_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
            } else {
                $this->hls_db->order_by("tdate", "DESC");
            }
        } else if ($dept == "CS") {
            $order_column = array("dscr", "tdate", "realcost", "qty", "totalamt", "transactiontype", "Supplier");
            $this->csr_db->select("dscr,tdate,realcost,qty,totalamt,transactiontype,Supplier")
                    ->from(ledgersales_tbl)
                    ->where("prodid", $code)
                    // ->where('tdate >= "'.$first.'"')
                    ->where('tdate <= "' . $end . '"');
            if ($transtype == "Delivery") {
                $this->csr_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
            }
            $this->csr_db->limit(100);

            if (!empty($this->input->post("search")["value"])) {
                $this->csr_db->group_start()
                        ->like('dscr', $this->input->post("search")["value"])
                        ->group_end();
            }

            if (!empty($this->input->post("order"))) {
                $this->csr_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
            } else {
                $this->csr_db->order_by("tdate", "DESC");
            }
        } else if ($dept == "RT" || $dept == "US") {
            $order_column = array("dscr", "tdate", "realcost", "qty", "totalamt", "transactiontype", "Supplier");
            $this->hrs_db->select("dscr,tdate,realcost,qty,totalamt,transactiontype,Supplier")
                    ->from(ledgersales_tbl)
                    ->where("prodid", $code)
                    // ->where('tdate >= "'.$first.'"')
                    ->where('tdate <= "' . $end . '"');
            if ($transtype == "Delivery") {
                $this->hrs_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
            }
            $this->hrs_db->limit(100);

            if (!empty($this->input->post("search")["value"])) {
                $this->hrs_db->group_start()
                        ->like('dscr', $this->input->post("search")["value"])
                        ->group_end();
            }

            if (!empty($this->input->post("order"))) {
                $this->hrs_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
            } else {
                $this->hrs_db->order_by("tdate", "DESC");
            }
        } else {
            $order_column = array("dscr", "tdate", "realcost", "qty", "totalamt", "transactiontype", "Supplier");
            $this->bms_db->select("dscr,tdate,realcost,qty,totalamt,transactiontype,Supplier")
                    ->from(ledgersales_tbl)
                    ->where("prodid", $code)
                    // ->where('tdate >= "'.$first.'"')
                    ->where('tdate <= "' . $end . '"');
            if ($transtype == "Delivery") {
                $this->bms_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
            }
            $this->bms_db->limit(100);

            if (!empty($this->input->post("search")["value"])) {
                $this->bms_db->group_start()
                        ->like('dscr', $this->input->post("search")["value"])
                        ->group_end();
            }

            if (!empty($this->input->post("order"))) {
                $this->bms_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
            } else {
                $this->bms_db->order_by("tdate", "DESC");
            }
        }
    }

    function make_ledger1_datatables($code, $dept, $transtype, $monthdate) {
        $this->get_ledger1($code, $dept, $transtype, $monthdate);
        if ($dept == "PH") {
            if ($this->input->post("length") != -1) {
                $this->pms_db->limit($this->input->post('length'), $this->input->post('start'));
            }
            $query = $this->pms_db->get();
            return $query->result();
        } else if ($dept == "LT") {
            if ($this->input->post("length") != -1) {
                $this->hls_db->limit($this->input->post('length'), $this->input->post('start'));
            }
            $query = $this->hls_db->get();
            return $query->result();
        } else if ($dept == "CS") {
            if ($this->input->post("length") != -1) {
                $this->csr_db->limit($this->input->post('length'), $this->input->post('start'));
            }
            $query = $this->csr_db->get();
            return $query->result();
        } else if ($dept == "RT" || $dept == "US") {
            if ($this->input->post("length") != -1) {
                $this->hrs_db->limit($this->input->post('length'), $this->input->post('start'));
            }
            $query = $this->hrs_db->get();
            return $query->result();
        } else if ($dept == "DI") {
            if ($this->input->post("length") != -1) {
                $this->bms_db->limit($this->input->post('length'), $this->input->post('start'));
            }
            $query = $this->bms_db->get();
            return $query->result();
        }
    }

    function get_ledger1_filtered_data($code, $dept, $transtype, $monthdate) {
        $this->get_ledger1($code, $dept, $transtype, $monthdate);


        if ($dept == "PH") {
            $query = $this->pms_db->get();
            return $query->num_rows();
        } else if ($dept == "LT") {
            $query = $this->hls_db->get();
            return $query->num_rows();
        } else if ($dept == "CS") {
            $query = $this->csr_db->get();
            return $query->num_rows();
        } else if ($dept == "RT" || $dept == "US") {
            $query = $this->hrs_db->get();
            return $query->num_rows();
        } else if ($dept == "DI") {
            $query = $this->bms_db->get();
            return $query->num_rows();
        }
    }

    public function get_ledger1_data($code, $dept, $transtype, $monthdate) {
        $monthstart = date("Y-m-01", strtotime($monthdate . "-01"));
        $monthend = date("Y-m-t", strtotime($monthdate . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        if ($dept == "PH") {
            $this->pms_db->select("dscr,tdate,realcost,qty,totalamt,transactiontype,Supplier")
                    ->from(ledgersales_tbl)
                    ->where("prodid", $code)
                    // ->where('tdate >= "'.$first.'"')
                    ->where('tdate <= "' . $end . '"');
            if ($transtype == "Delivery") {
                $this->pms_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
            }
            $this->pms_db->order_by('tdate', "DESC")
                    ->limit(100);

            return $this->pms_db->count_all_results();
        } else if ($dept == "LT") {
            $this->hls_db->select("dscr,tdate,realcost,qty,totalamt,transactiontype,Supplier")
                    ->from(ledgersales_tbl)
                    ->where("prodid", $code)
                    // ->where('tdate >= "'.$first.'"')
                    ->where('tdate <= "' . $end . '"');
            if ($transtype == "Delivery") {
                $this->hls_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
            }
            $this->hls_db->order_by('tdate', "DESC")
                    ->limit(100);

            return $this->hls_db->count_all_results();
        } else if ($dept == "CS") {
            $this->csr_db->select("dscr,tdate,realcost,qty,totalamt,transactiontype,Supplier")
                    ->from(ledgersales_tbl)
                    ->where("prodid", $code)
                    // ->where('tdate >= "'.$first.'"')
                    ->where('tdate <= "' . $end . '"');
            if ($transtype == "Delivery") {
                $this->csr_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
            }
            $this->csr_db->order_by('tdate', "DESC")
                    ->limit(100);
            return $this->csr_db->count_all_results();
        } else if ($dept == "RT" || $dept == "US") {
            $this->hrs_db->select("dscr,tdate,realcost,qty,totalamt,transactiontype,Supplier")
                    ->from(ledgersales_tbl)
                    ->where("prodid", $code)
                    // ->where('tdate >= "'.$first.'"')
                    ->where('tdate <= "' . $end . '"');
            if ($transtype == "Delivery") {
                $this->hrs_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
            }
            $this->hrs_db->order_by('tdate', "DESC")
                    ->limit(100);
            return $this->hrs_db->count_all_results();
        } else {
            $this->bms_db->select("dscr,tdate,realcost,qty,totalamt,transactiontype,Supplier")
                    ->from(ledgersales_tbl)
                    ->where("prodid", $code)
                    // ->where('tdate >= "'.$first.'"')
                    ->where('tdate <= "' . $end . '"');
            if ($transtype == "Delivery") {
                $this->bms_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
            }
            $this->bms_db->order_by('tdate', "DESC")
                    ->limit(100);
            return $this->bms_db->count_all_results();
        }
    }

    //---------------------------------------------------------------------------------------------purchases
    public function get_all_purchases($type) {
        $order_column = array("dscr", "reqdatetime", "cost", "qty", "totalcost", NULL);
        $this->db->select('*')
                ->from(purchases_vw);
        if ($type === "fapproval") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 0)
                    ->where('deffered', 0)
                    ->where('disapproved', 0);
        } else if ($type === "approve") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 1)
                    ->where('deffered', 0)
                    ->where('disapproved', 0);
        } else if ($type === "deffer") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 0)
                    ->where('deffered', 1)
                    ->where('disapproved', 0);
        } else if ($type === "disaprove") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 0)
                    ->where('deffered', 0)
                    ->where('disapproved', 1);
        } else {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 0)
                    ->where('approved', 0)
                    ->where('deffered', 0)
                    ->where('disapproved', 0);
        }

//                ->where(prequests_tbl.'.forapproval',($type === "fapproval") ? 1 : 1)
//                ->where(prequests_tbl.'.approved',($type === "approve") ? 1 : 0)
//                ->where(prequests_tbl.'.deffered',($type === "deffer") ? 1 : 0)
//                ->where(prequests_tbl.'.disapproved',($type === "disaprove") ? 1 : 0);

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like(prequests_tbl . '.dscr', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by("reqdatetime", "DESC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_all_purchases_datatables($type) {
        $this->get_all_purchases($type);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_all_purchases_filtered_data($type) {
        $this->get_all_purchases($type);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_purchases_data($type) {
        $this->db->select('*')
                ->from(purchases_vw);
        if ($type === "fapproval") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 0)
                    ->where('deffered', 0)
                    ->where('disapproved', 0);
        } else if ($type === "approve") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 1)
                    ->where('deffered', 0)
                    ->where('disapproved', 0);
        } else if ($type === "deffer") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 0)
                    ->where('deffered', 1)
                    ->where('disapproved', 0);
        } else if ($type === "disaprove") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 0)
                    ->where('deffered', 0)
                    ->where('disapproved', 1);
        } else {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 0)
                    ->where('approved', 0)
                    ->where('deffered', 0)
                    ->where('disapproved', 0);
        }

//                ->where(prequests_tbl.'.approved',($type === "approve") ? 1 : 0)
//                ->where(prequests_tbl.'.deffered',($type === "deffer") ? 1 : 0)
//                ->where(prequests_tbl.'.disapproved',($type === "disaprove") ? 1 : 0);
        return $this->db->count_all_results();
    }

    public function approve_purchase($control) {
//        $approved = FALSE;
        $data = array(
            'approved' => 1,
            'dateapproved' => $this->get_current_date(),
            'approvedby' => $this->session->userdata('empname'),
            'disapproved' => 0,
            'deffered' => 0,
            'noteofdisapproval' => '',
            'noteofresubmission' => ''
        );

        $this->db->where('control', $this->security->xss_clean($control));
        return $this->db->update(prequests_tbl, $data);
    }

    public function approve_purchase1($pocode) {
        $approved = FALSE;
        $data = array(
            'approved' => 1,
            'dateapproved' => $this->get_current_date(),
            'approvedby' => $this->session->userdata('empname')
        );

        for ($i = 0; $i < count($pocode); $i++) {
            $this->db->where('pocode', $this->security->xss_clean($pocode[$i]))
                    ->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 0)
                    ->where('disapproved', 0)
                    ->where('deffered', 0)
            ;
            if ($this->db->update(prequests_tbl, $data)) {
                $approved = TRUE;
            }
        }

        return $approved;
    }

    public function approve_purchase_all($ctrls) {
        $approved = FALSE;
        $data = array(
            'approved' => 1,
            'dateapproved' => $this->get_current_date(),
            'approvedby' => $this->session->userdata('empname'),
            'disapproved' => 0,
            'deffered' => 0,
            'noteofdisapproval' => '',
            'noteofresubmission' => ''
        );

        for ($i = 0; $i < count($ctrls); $i++) {
            $this->db->where('control', $this->security->xss_clean(intval($ctrls[$i])));
            if ($this->db->update(prequests_tbl, $data)) {
                $approved = TRUE;
            }
        }

        return $approved;
    }

    public function disapprove_purchase($control) {
        $data = array(
            'disapproved' => 1,
            'datedisapproved' => $this->get_current_date(),
            'noteofdisapproval' => $this->security->xss_clean($this->input->post('note')),
            'approvedby' => $this->session->userdata('empname'),
            'approved' => 0,
            'deffered' => 0,
            'noteofresubmission' => ''
        );



        $this->db->where('control', $this->security->xss_clean($control));
        return $this->db->update(prequests_tbl, $data);
    }

    public function disapprove_purchase1($pocode) {
        $disapproved = FALSE;
        $data = array(
            'disapproved' => 1,
            'datedisapproved' => $this->get_current_date(),
            'noteofdisapproval' => $this->security->xss_clean($this->input->post('b')),
            'approvedby' => $this->session->userdata('empname')
        );

        for ($i = 0; $i < count($pocode); $i++) {
            $this->db->where('pocode', $this->security->xss_clean($pocode[$i]))
                    ->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 0)
                    ->where('disapproved', 0)
                    ->where('deffered', 0)
            ;
            if ($this->db->update(prequests_tbl, $data)) {
                $disapproved = TRUE;
            }
        }

        return $disapproved;
    }

    public function disapprove_purchase_all($ctrls) {
        $disapproved = FALSE;
        $data = array(
            'disapproved' => 1,
            'datedisapproved' => $this->get_current_date(),
            'noteofdisapproval' => $this->security->xss_clean($this->input->post('b')),
            'approvedby' => $this->session->userdata('empname'),
            'approved' => 0,
            'deffered' => 0,
            'noteofresubmission' => ''
        );

        for ($i = 0; $i < count($ctrls); $i++) {
            $this->db->where('control', $this->security->xss_clean(intval($ctrls[$i])));
            if ($this->db->update(prequests_tbl, $data)) {
                $disapproved = TRUE;
            }
        }

        return $disapproved;
    }

    public function deffer_purchase($control) {
        $data = array(
            'deffered' => 1,
            'datedisapproved' => $this->get_current_date(),
            'noteofresubmission' => $this->security->xss_clean($this->input->post('noted')),
            'approvedby' => $this->session->userdata('empname'),
            'approved' => 0,
            'disapproved' => 0,
            'noteofdisapproval' => ''
        );



        $this->db->where('control', $this->security->xss_clean($control));
        return $this->db->update(prequests_tbl, $data);
    }

    public function update_prmaster($prnumber) {
        $data = array(
            'approved' => 1,
            'approveddatetime' => $this->get_current_date(),
            'approvedby' => $this->session->userdata('empname'),
            'approvedID' => $this->session->userdata('userid'),
            'updatedid' => $this->session->userdata('userid'),
            'updatedby' => $this->session->userdata('empname'),
        );

        $this->db->where('pocode', $this->security->xss_clean($prnumber));
        return $this->db->update(prmaster_tbl, $data);
    }

    public function deffer_purchase1($ctrl) {
        $deffered = FALSE;
        $data = array(
            'deffered' => 1,
            'datedisapproved' => $this->get_current_date(),
            'noteofresubmission' => $this->security->xss_clean('No action made'),
            'approvedby' => $this->session->userdata('empname')
        );

        for ($i = 0; $i < count($ctrl); $i++) {
            $this->db->where('control', $this->security->xss_clean($ctrl[$i]));
            if ($this->db->update(prequests_tbl, $data)) {
                $deffered = TRUE;
            }
        }
        return $deffered;
    }

    public function deffer_purchase_all($ctrls) {
        $deffered = FALSE;
        $data = array(
            'deffered' => 1,
            'datedisapproved' => $this->get_current_date(),
            'noteofresubmission' => $this->security->xss_clean($this->input->post('b')),
            'approvedby' => $this->session->userdata('empname'),
            'approved' => 0,
            'disapproved' => 0,
            'noteofdisapproval' => ''
        );

        for ($i = 0; $i < count($ctrls); $i++) {
            $this->db->where('control', $this->security->xss_clean(intval($ctrls[$i])));
            if ($this->db->update(prequests_tbl, $data)) {
                $deffered = TRUE;
            }
        }

        return $deffered;
    }

    public function get_action_purchase($pocode) {
        $this->db->select('*')
                ->from(prequests_tbl)
                ->where('pocode', $pocode)
                ->where('needapproval', 1)
                ->where('forapproval', 1)
                ->where('approved', 0)
                ->where('disapproved', 0)
                ->where('deffered', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_prapprovers_mobile($dept) {
        $this->db->select('mobileno')
                ->from(prapprovers_tbl)
                ->where('dept', $dept);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function send_message_pr($mobile, $prnumber, $prdate, $supplier, $dept, $hosppref) {
        $message = "PR No: " . $prnumber . "\n" .
                "Supplier: " . $supplier . "\n" .
                "PR Date: " . $prdate . "\n" .
                "PR is now ready for PO. \n \n" .
                $hosppref . " " . $dept;

        $data = array(
            'Datelog' => $this->get_current_date(),
            'Message' => $this->security->xss_clean($message),
            'Status' => $this->security->xss_clean('0'),
            'Number' => $this->security->xss_clean($mobile),
            'station' => $this->security->xss_clean('Web Application'),
            'userid' => $this->session->userdata('userid'),
            'transaction' => $this->security->xss_clean('Purchase Request Approval')
        );
        return $this->messaging_db->insert(tb_text_tbl, $data);
    }

    public function today_census() {
        $this->db->select('sum(caseno) as px, sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                        . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(inpatient_tbl)
//                ->where('dischadate >=', $date)    
                ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype', 'IPD')
                ->where("discharged", 0);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function changeqty($datax) {
        $data = array(
            'qty' => $this->security->xss_clean($datax['qty'])
        );
        $this->db->where('control', $this->security->xss_clean($datax['id']));
        return $this->db->update(prequests_tbl, $data);
    }

    public function changeqtylog($datax) {
        $data = array(
            'dscr' => $this->security->xss_clean("Updated"),
            'controlno' => $this->security->xss_clean($datax['id']),
            'item' => $this->security->xss_clean($datax['item']),
            'oldqty' => $this->security->xss_clean($datax['oldqty']),
            'newqty' => $this->security->xss_clean($datax['qty']),
            'updatedby' => $this->session->userdata('empname'),
            'updated' => $this->get_current_date('server')
        );
        return $this->hubuserlog_db->insert(purchaselog_tbl, $data);
    }

    //---------------------------------------------------------------------------------------------purchases
    public function get_phic($s_date, $e_date) {
        $order_column = array("phicmembr", "c");
        $this->db->select('phicmembr, count(*) c')
                ->from(inpatient_tbl)
                ->group_start()
                ->where('(dischadate <= "' . $s_date . '" and dischadate >= "' . $e_date . '")', NULL, FALSE)
                ->where('pxtype', 'IPD')
                ->where('discharged', 1)
                ->group_by('phicmembr')
                ->group_end();

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('phicmembr', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by("phicmembr", "ASC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_phic_datatables($s_date, $e_date) {
        $this->get_phic($s_date, $e_date);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_phic_filtered_data($s_date, $e_date) {
        $this->get_phic($s_date, $e_date);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_phic_data($s_date, $e_date) {
        $this->db->select('phicmembr, count(*) c')
                ->from(inpatient_tbl)
                ->group_start()
                ->where('dischadate <= "' . $s_date . '" and dischadate >= "' . $e_date . '"', NULL, FALSE)
                ->where('pxtype', 'IPD')
                ->where('discharged', 1)
                ->group_by('phicmembr')
                ->group_end();
        return $this->db->count_all_results();
    }

    /* Voucher-> Cheque Approval
     * @author Alingling
     */

    public function get_all_ticket() {
        $order_column = array("TICKETDATE", "EXPLANATION", "PAYEE", "CHEQUEAMT");
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '0')
                ->where('RETURNTICKET', '0')
                ->where('deferred', '0')
                ->where('BOOKTYPE', 'CDB');

        if (!empty($this->input->post("search")["value"])) {
            $this->ams_db->group_start()
                    ->like("EXPLANATION", $this->input->post("search")["value"])
                    ->or_like("PAYEE", $this->input->post("search")["value"])
                    ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->ams_db->order_by("TICKETDATE", "DESC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_all_ticket_datatables() {
        $this->get_all_ticket();
        if ($this->input->post("length") != -1) {
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->ams_db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_all_ticket_filtered_data() {
        $this->get_all_ticket();
        $query = $this->ams_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_ticket_data() {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '0')
                ->where('RETURNTICKET', '0')
                ->where('deferred', '0')
                ->where('BOOKTYPE', 'CDB');
        return $this->ams_db->count_all_results();
    }

    /**
     * GEt Disapproved Ticket
     * @author Alingling
     */
    public function get_all_disapprovedticket() {
        $order_column = array("TICKETDATE", "EXPLANATION", "PAYEE", "CHEQUEAMT", "note");
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '0')
                ->where('RETURNTICKET', '1')
                ->where('BOOKTYPE', 'CDB');

        if (!empty($this->input->post("search")["value"])) {
            $this->ams_db->group_start()
                    ->like("EXPLANATION", $this->input->post("search")["value"])
                    ->or_like("PAYEE", $this->input->post("search")["value"])
                    ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                    ->or_like("note", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->ams_db->order_by("TICKETDATE", "DESC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_all_disapprovedticket_datatables() {
        $this->get_all_disapprovedticket();
        if ($this->input->post("length") != -1) {
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->ams_db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_all_disapprovedticket_filtered_data() {
        $this->get_all_disapprovedticket();
        $query = $this->ams_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_disapprovedticket_data() {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '0')
                ->where('RETURNTICKET', '1')
                ->where('BOOKTYPE', 'CDB');
        return $this->ams_db->count_all_results();
    }

    /*
     * Get deferred Ticket
     * @author Alingling
     */

    public function get_all_deferredticket() {
        $order_column = array("TICKETDATE", "EXPLANATION", "PAYEE", "CHEQUEAMT", "note");
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '0')
                ->where('deferred', '1')
                ->where('BOOKTYPE', 'CDB');

        if (!empty($this->input->post("search")["value"])) {
            $this->ams_db->group_start()
                    ->like("EXPLANATION", $this->input->post("search")["value"])
                    ->or_like("PAYEE", $this->input->post("search")["value"])
                    ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                    ->or_like("note", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->ams_db->order_by("TICKETDATE", "DESC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_all_deferredticket_datatables() {
        $this->get_all_deferredticket();
        if ($this->input->post("length") != -1) {
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->ams_db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_all_deferredticket_filtered_data() {
        $this->get_all_deferredticket();
        $query = $this->ams_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_deferredticket_data() {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '0')
                ->where('deferred', '1')
                ->where('BOOKTYPE', 'CDB');
        return $this->ams_db->count_all_results();
    }

    //
    public function get_all_approvedticket() {
        $currentdate = $this->get_current_datex();
        $order_column = array("TICKETDATE", "EXPLANATION", "PAYEE", "CHEQUEAMT", "note", "PREPARE", "CHEQUE", "APPROVE");
        $this->ams_db->select('TICKETDATE,TICKETCODE,EXPLANATION,PAYEE,CHEQUEAMT,note,concat(PREPARED," @ ",PREPDATETIME) as PREPARE,concat(CHECKED," @ ",CHKDATETIME) as CHEQUE,concat(APPROVED," @ ",APRVDATETIME) as APPROVE')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '1')
                ->where('deferred', '0')
                ->where('RETURNTICKET', '0')
                ->where('BOOKTYPE', 'CDB')
                ->like('APRVDATETIME', $currentdate)
                ->group_end();

        if (!empty($this->input->post("search")["value"])) {
            $this->ams_db->group_start()
                    ->like("EXPLANATION", $this->input->post("search")["value"])
                    ->or_like("PAYEE", $this->input->post("search")["value"])
                    ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                    ->or_like("note", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->ams_db->order_by("TICKETDATE", "DESC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_all_approvedticket_datatables() {
        $this->get_all_approvedticket();
        if ($this->input->post("length") != -1) {
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->ams_db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_all_approvedticket_filtered_data() {
        $this->get_all_approvedticket();
        $query = $this->ams_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_approvedticket_data() {
        $currentdate = $this->get_current_datex();
        $this->ams_db->select('TICKETDATE,TICKETCODE,EXPLANATION,PAYEE,CHEQUEAMT,note,concat(PREPARED," @ ",PREPDATETIME) as PREPARE,concat(CHECKED," @ ",CHKDATETIME) as CHEQUE,concat(APPROVED," @ ",APRVDATETIME) as APPROVE')
                ->from(ticketsumfinal_tbl)
                ->group_start()
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '1')
                ->where('deferred', '0')
                ->where('RETURNTICKET', '0')
                ->where('BOOKTYPE', 'CDB')
                ->like('APRVDATETIME', $currentdate)
                ->group_end();
        return $this->ams_db->count_all_results();
    }

    //////////////////////
    public function get_all_approvedticketbydate($s_date) {
        $order_column = array("TICKETDATE", "EXPLANATION", "PAYEE", "CHEQUEAMT", "note", "PREPARE", "CHEQUE", "APPROVE");
        $this->ams_db->select('TICKETDATE,TICKETCODE,EXPLANATION,PAYEE,CHEQUEAMT,note,concat(PREPARED," @ ",PREPDATETIME) as PREPARE,concat(CHECKED," @ ",CHKDATETIME) as CHEQUE,concat(APPROVED," @ ",APRVDATETIME) as APPROVE')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '1')
                ->where('deferred', '0')
                ->where('RETURNTICKET', '0')
                ->where('BOOKTYPE', 'CDB')
                ->like('APRVDATETIME', $s_date);

        if (!empty($this->input->post("search")["value"])) {
            $this->ams_db->group_start()
                    ->like("EXPLANATION", $this->input->post("search")["value"])
                    ->or_like("PAYEE", $this->input->post("search")["value"])
                    ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                    ->or_like("note", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->ams_db->order_by("TICKETDATE", "DESC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_all_approvedticketbydate_datatables($s_date) {
        $this->get_all_approvedticketbydate($s_date);
        if ($this->input->post("length") != -1) {
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->ams_db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_all_approvedticketbydate_filtered_data($s_date) {
        $this->get_all_approvedticketbydate($s_date);
        $query = $this->ams_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_approvedticketbydate_data($s_date) {
        $this->ams_db->select('TICKETDATE,TICKETCODE,EXPLANATION,PAYEE,CHEQUEAMT,note,concat(PREPARED," @ ",PREPDATETIME) as PREPARE,concat(CHECKED," @ ",CHKDATETIME) as CHEQUE,concat(APPROVED," @ ",APRVDATETIME) as APPROVE')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '1')
                ->where('deferred', '0')
                ->where('RETURNTICKET', '0')
                ->where('BOOKTYPE', 'CDB')
                ->like('APRVDATETIME', $s_date);
        return $this->ams_db->count_all_results();
    }

    //

    public function get_ticketdetails($id) {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE', '1')
                ->where('APRVDONE', '0')
                ->where('TICKETREF', $id);
        $query = $this->ams_db->get();
        return $query->row_array();
    }

    public function get_ticketdetailx($id) {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('TICKETREF', $id);
        $query = $this->ams_db->get();
        return $query->row_array();
    }

    public function get_all_creditdebit_ticket($ticketcode) {
        $order_column = array("COACODE", "ACCTTITLE", "DBAMT", "CRAMT");
        $this->ams_db->select('*')
                ->from(viewmyticket_view)
                ->where('TICKETCODE', $ticketcode);

        if (!empty($this->input->post("search")["value"])) {
            $this->ams_db->group_start()
                    ->like("EXPLANATION", $this->input->post("search")["value"])
                    ->or_like("PAYEE", $this->input->post("search")["value"])
                    ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->ams_db->order_by("TICKETDATE", "DESC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_all_creditdebit_ticket_datatables($ticketcode) {
        $this->get_all_creditdebit_ticket($ticketcode);
        if ($this->input->post("length") != -1) {
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->ams_db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_all_creditdebit_ticket_filtered_data($ticketcode) {
        $this->get_all_creditdebit_ticket($ticketcode);
        $query = $this->ams_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_creditdebit_ticket_data($ticketcode) {
        $this->ams_db->select('*')
                ->from(viewmyticket_view)
                ->where('TICKETCODE', $ticketcode);
        return $this->ams_db->count_all_results();
    }

    public function checkapprovedticket($d) {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE', '1')
                ->group_start()
                ->where('APRVDONE', '1')
                ->or_where('RETURNTICKET', '1')
                ->or_where('deferred', '1')
                ->group_end()
                ->where('TICKETREF', $d["ticketref"]);
        $query = $this->ams_db->get();
        return $query->row_array();
    }

    public function checkticket($ctrls) {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('CHKDONE', '1')
                ->group_start()
                ->where('APRVDONE', '1')
                ->or_where('RETURNTICKET', '1')
                ->or_where('deferred', '1')
                ->group_end()
                ->where('TICKETREF', $this->security->xss_clean(intval($ctrls)));
        $query = $this->ams_db->get();
        return $query->row_array();
    }

    /*
     * update ticketsumfinal
     * @author Alingling
     */

    public function update_ticketdetails($d) {
        $data = array(
            'APRVDONE' => $this->security->xss_clean("1"),
            'APPROVED' => $this->session->userdata('empname'),
            'APRVDATETIME' => $this->get_current_date(),
        );
        $this->ams_db->where('TICKETREF', $this->security->xss_clean($d['ticketref']));
        return $this->ams_db->update("ticketsumfinal", $data);
    }

    public function approve_ticketdetails($ctrls) {
        $data = array(
            'APRVDONE' => $this->security->xss_clean("1"),
            'APPROVED' => $this->session->userdata('empname'),
            'APRVDATETIME' => $this->get_current_date(),
        );

        for ($i = 0; $i < count($ctrls); $i++) {
            $this->ams_db->where('TICKETREF', $this->security->xss_clean(intval($ctrls[$i])));
            if ($this->ams_db->update(ticketsumfinal_tbl, $data)) {
                $approved = TRUE;
            }
        }

        return $approved;
    }

    public function disapprove_ticketdetails($ctrl) {
        $data = array(
            'RETURNTICKET' => $this->security->xss_clean("1"),
            'deferred' => $this->security->xss_clean("0"),
            'APPROVED' => $this->session->userdata('empname'),
            'APRVDATETIME' => $this->get_current_date(),
            'note' => $this->security->xss_clean($this->input->post('b')),
        );
        for ($i = 0; $i < count($ctrl); $i++) {
            $this->ams_db->where('TICKETREF', $this->security->xss_clean(intval($ctrl[$i])));
            if ($this->ams_db->update(ticketsumfinal_tbl, $data)) {
                $approved = TRUE;
            }
        }
        return $approved;
    }

    public function deferred_ticketdetails($ctrl) {
        $data = array(
            'deferred' => $this->security->xss_clean("1"),
            'RETURNTICKET' => $this->security->xss_clean("0"),
            'APPROVED' => $this->session->userdata('empname'),
            'APRVDATETIME' => $this->get_current_date(),
            'note' => $this->security->xss_clean($this->input->post('b')),
        );
        for ($i = 0; $i < count($ctrl); $i++) {
            $this->ams_db->where('TICKETREF', $this->security->xss_clean(intval($ctrl[$i])));
            if ($this->ams_db->update(ticketsumfinal_tbl, $data)) {
                $approved = TRUE;
            }
        }
        return $approved;
    }

    public function update_ticketdetailsdis($d) {
        $data = array(
            'RETURNTICKET' => $this->security->xss_clean("1"),
            'deferred' => $this->security->xss_clean("0"),
            'APPROVED' => $this->session->userdata('empname'),
            'APRVDATETIME' => $this->get_current_date(),
            'note' => $this->security->xss_clean($d['note'])
        );
        $this->ams_db->where('TICKETREF', $this->security->xss_clean($d['ticketref']));
        return $this->ams_db->update("ticketsumfinal", $data);
    }

    public function update_ticketdetailsdef($d) {
        $data = array(
            'deferred' => $this->security->xss_clean("1"),
            'RETURNTICKET' => $this->security->xss_clean("0"),
            'APPROVED' => $this->session->userdata('empname'),
            'APRVDATETIME' => $this->get_current_date(),
            'note' => $this->security->xss_clean($d['note'])
        );
        $this->ams_db->where('TICKETREF', $this->security->xss_clean($d['ticketref']));
        return $this->ams_db->update("ticketsumfinal", $data);
    }

    /* Cheque Monitoring
     * @author Alingling
     */

    public function get_all_prep_ticket() {
        $order_column = array("TICKETDATE", "EXPLANATION", "PAYEE", "CHEQUEAMT");
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('PREPDONE', '1')
                ->where('CHKDONE', '0')
                ->where('APRVDONE', '0')
                ->where('RETURNTICKET', '0')
                ->where('deferred', '0')
                ->where('BOOKTYPE', 'CDB');

        if (!empty($this->input->post("search")["value"])) {
            $this->ams_db->group_start()
                    ->like("EXPLANATION", $this->input->post("search")["value"])
                    ->or_like("PAYEE", $this->input->post("search")["value"])
                    ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->ams_db->order_by("TICKETDATE", "DESC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_all_prep_ticket_datatables() {
        $this->get_all_prep_ticket();
        if ($this->input->post("length") != -1) {
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->ams_db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_all_prep_ticket_filtered_data() {
        $this->get_all_prep_ticket();
        $query = $this->ams_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_prep_ticket_data() {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('PREPDONE', '1')
                ->where('CHKDONE', '0')
                ->where('APRVDONE', '0')
                ->where('RETURNTICKET', '0')
                ->where('deferred', '0')
                ->where('BOOKTYPE', 'CDB');
        return $this->ams_db->count_all_results();
    }

    /* get ALL CHEQUE TICKETS
     * @author Alingling
     */

    public function get_all_cheque_ticket() {
        $order_column = array("PAYEE", "CHEQUEAMT", "CHKDATETIME", "EXPLANATION", "TICKETDATE", "TICKETREF", "CHKDONE");
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('BOOKTYPE', 'CDB');

        if (!empty($this->input->post("search")["value"])) {
            $this->ams_db->group_start()
                    ->like("EXPLANATION", $this->input->post("search")["value"])
                    ->or_like("PAYEE", $this->input->post("search")["value"])
                    ->or_like("CHKDATETIME", $this->input->post("search")["value"])
                    ->or_like("CHEQUEAMT", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->ams_db->order_by("TICKETDATE", "DESC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_all_cheque_ticket_datatables() {
        $this->get_all_cheque_ticket();
        if ($this->input->post("length") != -1) {
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->ams_db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_all_cheque_ticket_filtered_data() {
        $this->get_all_cheque_ticket();
        $query = $this->ams_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_cheque_ticket_data() {
        $this->ams_db->select('*')
                ->from(ticketsumfinal_tbl)
                ->where('BOOKTYPE', 'CDB');
        return $this->ams_db->count_all_results();
    }

    /**
     * Gets all on process philhealth account.
     * 
     * @author pauldigz@gmail.com
     * @param string $date(Y-m-d)
     */
    public function get_op_phic_accnt($date) {
        $order_column = array("aging", "total", null);
        $this->med_db->select('case 
                                when  datediff("' . $date . '", dischadate) <= 15 THEN "1-15 Days"
                                when  datediff("' . $date . '", dischadate) <= 30 THEN "16-30 Days"
                                when  datediff("' . $date . '", dischadate) <= 45 THEN "31-45 Days"
                                when  datediff("' . $date . '", dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(phicHCItotal) as totalamounthci, sum(PHICpfTotal) as totalamountpf')
                ->from(patientphic_vw)
                ->where('dischadate <=', $date)
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '')
                ->group_by('aging');

        if (!empty($this->input->post("search")["value"])) {
            $this->med_db->group_start()
                    ->like('(case 
                                when  datediff("' . $date . '", dischadate) <= 15  THEN "1-15 days" 
                                when  datediff("' . $date . '", dischadate) <= 30 THEN "16-30 days" 
                                when  datediff("' . $date . '", dischadate) <= 45 THEN "31-45 days" 
                                when  datediff("' . $date . '", dischadate) <= 60 THEN "46-60 days"
                                ELSE "61 Days aboved"
                           END)', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->med_db->order_by('aging', 'ASC');
        }
    }

    /**
     * Make on process philhealth account datatable. 
     * 
     * @author pauldigz@gmail.com
     * @param datetime $date (Y-m-d)
     * @return array
     */
    function make_op_phic_accnt_datatables($date) {
        $this->get_op_phic_accnt($date);
        if ($this->input->post("length") != -1) {
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
    function get_op_phic_accnt_filtered_data($date) {
        $this->get_op_phic_accnt($date);
        $query = $this->med_db->get();
        return $query->num_rows();
    }

    public function get_op_phic_accnt_data($date) {
        $this->med_db->select('case 
                                when  datediff("' . $date . '", dischadate) <= 15 THEN "1-15 Days"
                                when  datediff("' . $date . '", dischadate) <= 30 THEN "16-30 Days"
                                when  datediff("' . $date . '", dischadate) <= 45 THEN "31-45 Days"
                                when  datediff("' . $date . '", dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(phicHCItotal) as totalamounthci, sum(PHICpfTotal) as totalamountpf')
                ->from(patientphic_vw)
                ->where('dischadate <=', $date)
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '')
                ->group_by('aging');
        return $this->med_db->count_all_results();
    }

    public function get_op_phic_accnt_report($date) {
        $this->med_db->select('case 
                                when  datediff("' . $date . '", dischadate) <= 15 THEN "1-15 Days"
                                when  datediff("' . $date . '", dischadate) <= 30 THEN "16-30 Days"
                                when  datediff("' . $date . '", dischadate) <= 45 THEN "31-45 Days"
                                when  datediff("' . $date . '", dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(phicHCItotal) as totalamounthci, sum(PHICpfTotal) as totalamountpf')
                ->from(patientphic_vw)
                ->where('dischadate <=', $date)
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '')
                ->group_by('aging');
        $query = $this->med_db->get();
        return $query->result_array();
    }

    public function get_op_phic_accnt_dashboard($age) {
        $date = $this->get_current_datex();
        if ($age == "1") {
            $this->med_db->select('count(*) as total')
                    ->from(patientphic_vw)
                    ->where('dischadate <=', $date)
                    ->where('datediff("' . $date . '", dischadate) <= 30')
                    ->where('discharged', 1)
                    ->where('phiccode <>', 'NHP')
                    ->where('claimcontrolno', '');
        } else if ($age == "2") {
            $this->med_db->select('count(*) as total')
                    ->from(patientphic_vw)
                    ->where('dischadate <=', $date)
                    ->where('datediff("' . $date . '", dischadate) >= 31')
                    ->where('datediff("' . $date . '", dischadate) <= 45')
                    ->where('discharged', 1)
                    ->where('phiccode <>', 'NHP')
                    ->where('claimcontrolno', '');
        } else if ($age == "3") {
            $this->med_db->select('count(*) as total')
                    ->from(patientphic_vw)
                    ->where('dischadate <=', $date)
                    ->where('datediff("' . $date . '", dischadate) >= 46')
                    ->where('datediff("' . $date . '", dischadate) <= 60')
                    ->where('discharged', 1)
                    ->where('phiccode <>', 'NHP')
                    ->where('claimcontrolno', '');
        } else {
            $this->med_db->select('count(*) as total')
                    ->from(patientphic_vw)
                    ->where('dischadate <=', $date)
                    ->where('datediff("' . $date . '", dischadate) >= 61')
                    ->where('discharged', 1)
                    ->where('phiccode <>', 'NHP')
                    ->where('claimcontrolno', '');
        }

        $query = $this->med_db->get();
        return $query->row_array();
    }

    public function get_op_phic_accnt_dash($age) {

        $date = $this->get_current_datex();

        $order_column = array("caseno", "name", "admitdate", "dischadate", "phicHCItotal", "PHICpfTotal", "phicmembr", "aging",);
        $this->med_db->select('caseno,name,admitdate,dischadate,phicmembr,datediff("' . $date . '", dischadate) as aging,phicHCItotal,PHICpfTotal')
                ->from(patientphic_vw)
                ->where('dischadate <=', $date)
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '');
        if ($age == "1") {
            $this->med_db->where('datediff("' . $date . '", dischadate) <= 30');
        } else if ($age == "2") {
            $this->med_db->where('datediff("' . $date . '", dischadate) >= 31')
                    ->where('datediff("' . $date . '", dischadate) <= 45');
        } else if ($age == "3") {
            $this->med_db->where('datediff("' . $date . '", dischadate) >= 46')
                    ->where('datediff("' . $date . '", dischadate) <= 60');
        } else {
            $this->med_db->where('datediff("' . $date . '", dischadate) >= 61');
        }


        if (!empty($this->input->post("search")["value"])) {
            $this->med_db->group_start()
                    ->like('caseno', $this->input->post("search")["value"])
                    ->or_like('name', $this->input->post("search")["value"])
                    ->or_like('phicmembr', $this->input->post("search")["value"])
                    ->or_like('aging', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->med_db->order_by('dischadate', 'ASC');
        }
    }

    function make_op_phic_accnt_dashboard_datatables($age) {
        $this->get_op_phic_accnt_dash($age);
        if ($this->input->post("length") != -1) {
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->med_db->get();
        return $query->result();
    }

    function get_op_phic_accnt_dashboard_filtered_data($age) {
        $this->get_op_phic_accnt_dash($age);
        $query = $this->med_db->get();
        return $query->num_rows();
    }

    public function get_op_phic_accnt_dashboard_data($age) {
        $date = $this->get_current_datex();

        $order_column = array("caseno", "name", "admitdate", "dischadate", "phicHCItotal", "PHICpfTotal", "phicmembr", "aging",);
        $this->med_db->select('caseno,name,admitdate,dischadate,phicmembr,datediff("' . $date . '", dischadate) as aging,phicHCItotal,PHICpfTotal')
                ->from(patientphic_vw)
                ->where('dischadate <=', $date)
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '');
        if ($age == "1") {
            $this->med_db->where('datediff("' . $date . '", dischadate) <= 30');
        } else if ($age == "2") {
            $this->med_db->where('datediff("' . $date . '", dischadate) >= 31')
                    ->where('datediff("' . $date . '", dischadate) <= 45');
        } else if ($age == "3") {
            $this->med_db->where('datediff("' . $date . '", dischadate) >= 46')
                    ->where('datediff("' . $date . '", dischadate) <= 60');
        } else {
            $this->med_db->where('datediff("' . $date . '", dischadate) >= 61');
        }
        return $this->med_db->count_all_results();
    }

    public function get_nontransmit_claims($age) {
        $date = $this->get_current_datex();
        $order_column = array("batchno", "PatientName", "processdate", "claimno", "patpin", "aging");
        $this->dweclaims_db->select('batchno,PatientName,processdate,claimno,patpin,datediff(NOW(),processdate) as aging')
                ->from(eclaims_tbl)
                ->where('status', 0)
                ->where('batchno != ""');
        if ($age == "1") {
            $this->dweclaims_db->where('datediff("' . $date . '", processdate) <= 30');
        } else if ($age == "2") {
            $this->dweclaims_db->where('datediff("' . $date . '", processdate) >= 31')
                    ->where('datediff("' . $date . '", processdate) <= 45');
        } else if ($age == "3") {
            $this->dweclaims_db->where('datediff("' . $date . '", processdate) >= 46')
                    ->where('datediff("' . $date . '", processdate) <= 60');
        } else {
            $this->dweclaims_db->where('datediff("' . $date . '", processdate) >= 61');
        }

        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('batchno', $this->input->post("search")["value"])
                    ->or_like('PatientName', $this->input->post("search")["value"])
                    ->or_like('processdate', $this->input->post("search")["value"])
                    ->or_like('claimno', $this->input->post("search")["value"])
                    ->or_like('patpin', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('aging', 'DESC');
        }
    }

    function make_nontransmit_claims_datatables($age) {
        $this->get_nontransmit_claims($age);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    public function get_nontransmit_claims_filtered_data($age) {
        $this->get_nontransmit_claims($age);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_nontransmit_claims_data($age) {
        $date = $this->get_current_datex();
        $this->dweclaims_db->select('batchno,PatientName,processdate,claimno,patpin,datediff(NOW(),processdate) as aging')
                ->from(eclaims_tbl)
                ->where('status', 0)
                ->where('batchno != ""');

        if ($age == "1") {
            $this->dweclaims_db->where('datediff("' . $date . '", processdate) <= 30');
        } else if ($age == "2") {
            $this->dweclaims_db->where('datediff("' . $date . '", processdate) >= 31')
                    ->where('datediff("' . $date . '", processdate) <= 45');
        } else if ($age == "3") {
            $this->dweclaims_db->where('datediff("' . $date . '", processdate) >= 46')
                    ->where('datediff("' . $date . '", processdate) <= 60');
        } else {
            $this->dweclaims_db->where('datediff("' . $date . '", processdate) >= 61');
        }
        $this->dweclaims_db->order_by('aging', 'DESC');

        return $this->dweclaims_db->count_all_results();
    }

    public function get_eclaims($statx, $sentEclaimsDate) {
//        $date = $this->get_current_datex();
        $monthstart = date("Y-m-01", strtotime($sentEclaimsDate . "-01"));
        $monthend = date("Y-m-t", strtotime($sentEclaimsDate . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $order_column = array("patpin", "PatientName", "hcifee", "profee", "dischargedate", "ReceiveDate", "age", "pStatus", "proc1date");


        if ($statx == "IN PROCESS") {
            $this->dweclaims_db->select('patpin,PatientName,hcifee,profee,dischargedate,ReceiveDate,datediff(ReceiveDate, dischargedate) as age, pStatus,processdate')
                    ->from(masterview_vw)
                    ->where('pStatus', 'IN PROCESS')
                    ->where('ReceiveDate >= "' . $first . '"')
                    ->where('ReceiveDate <= "' . $end . '"');
        } else if ($statx == "RTH") {
            $this->dweclaims_db->select('patpin,PatientName,hcifee,profee,dischargedate,ReceiveDate,datediff(ReceiveDate, dischargedate)  as age, pStatus,processdate')
                    ->from(masterview_vw)
                    ->where('pStatus', 'RETURN')
                    ->where('ReceiveDate >= "' . $first . '"')
                    ->where('ReceiveDate <= "' . $end . '"');
        } else if ($statx == "DENIED") {
            $this->dweclaims_db->select('patpin,PatientName,hcifee,profee,dischargedate,ReceiveDate,datediff(ReceiveDate, dischargedate)  as age, pStatus,proc1date')
                    ->from(masterview_vw)
                    ->where('pStatus', 'DENIED')
                    ->where('ReceiveDate >= "' . $first . '"')
                    ->where('ReceiveDate <= "' . $end . '"');
        } else if ($statx == "WITH VOUCHER") {
            $this->dweclaims_db->select('patpin,PatientName,hcifee,profee,dischargedate,ReceiveDate,datediff(ReceiveDate, dischargedate)  as age, pStatus,proc1date')
                    ->from(masterview_vw)
                    ->where('(pStatus = "WITH VOUCHER" OR pStatus = "VOUCHER")')
                    ->where('ReceiveDate >= "' . $first . '"')
                    ->where('ReceiveDate <= "' . $end . '"');
        } else if ($statx == "WITH CHEQUE") {
            $this->dweclaims_db->select('patpin,PatientName,hcifee,profee,dischargedate,ReceiveDate,datediff(ReceiveDate, dischargedate)  as age, pStatus,proc1date')
                    ->from(masterview_vw)
                    ->where('pStatus', 'WITH CHEQUE')
                    ->where('ReceiveDate >= "' . $first . '"')
                    ->where('ReceiveDate <= "' . $end . '"');
        } else {
            $this->dweclaims_db->select('patpin,PatientName,hcifee,profee,dischargedate,ReceiveDate,datediff(ReceiveDate, dischargedate)  as age, pStatus,proc1date')
                    ->from(masterview_vw)
                    ->where('ReceiveDate >= "' . $first . '"')
                    ->where('ReceiveDate <= "' . $end . '"');
        }

        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('PatientName', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('age', 'ASC');
        }
    }

    function make_eclaims_datatables($statx, $sentEclaimsDate) {
        $this->get_eclaims($statx, $sentEclaimsDate);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    public function get_eclaims_filtered_data($statx, $sentEclaimsDate) {
        $this->get_eclaims($statx, $sentEclaimsDate);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_eclaims_data($statx, $sentEclaimsDate) {
        $date = $this->get_current_datex();
        $monthstart = date("Y-m-01", strtotime($sentEclaimsDate . "-01"));
        $monthend = date("Y-m-t", strtotime($sentEclaimsDate . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $order_column = array("patpin", "PatientName", "hcifee", "profee", "dischargedate", "proc1date", "age", "pStatus", "processdate");


        if ($statx == "IN PROCESS") {
            $this->dweclaims_db->select('patpin,PatientName,hcifee,profee,dischargedate,ReceiveDate,datediff(ReceiveDate, dischargedate) as age, pStatus,processdate')
                    ->from(masterview_vw)
                    ->where('pStatus', 'IN PROCESS')
                    ->where('ReceiveDate >= "' . $first . '"')
                    ->where('ReceiveDate <= "' . $end . '"');
        } else if ($statx == "RTH") {
            $this->dweclaims_db->select('patpin,PatientName,hcifee,profee,dischargedate,ReceiveDate,datediff(ReceiveDate, dischargedate)  as age, pStatus,processdate')
                    ->from(masterview_vw)
                    ->where('pStatus', 'RETURN')
                    ->where('ReceiveDate >= "' . $first . '"')
                    ->where('ReceiveDate <= "' . $end . '"');
        } else if ($statx == "DENIED") {
            $this->dweclaims_db->select('patpin,PatientName,hcifee,profee,dischargedate,ReceiveDate,datediff(ReceiveDate, dischargedate)  as age, pStatus,proc1date')
                    ->from(masterview_vw)
                    ->where('pStatus', 'DENIED')
                    ->where('ReceiveDate >= "' . $first . '"')
                    ->where('ReceiveDate <= "' . $end . '"');
        } else if ($statx == "WITH VOUCHER") {
            $this->dweclaims_db->select('patpin,PatientName,hcifee,profee,dischargedate,ReceiveDate,datediff(ReceiveDate, dischargedate)  as age, pStatus,proc1date')
                    ->from(masterview_vw)
                    ->where('(pStatus = "WITH VOUCHER" OR pStatus = "VOUCHER")')
                    ->where('ReceiveDate >= "' . $first . '"')
                    ->where('ReceiveDate <= "' . $end . '"');
        } else if ($statx == "WITH CHEQUE") {
            $this->dweclaims_db->select('patpin,PatientName,hcifee,profee,dischargedate,ReceiveDate,datediff(ReceiveDate, dischargedate)  as age, pStatus,proc1date')
                    ->from(masterview_vw)
                    ->where('pStatus', 'WITH CHEQUE')
                    ->where('ReceiveDate >= "' . $first . '"')
                    ->where('ReceiveDate <= "' . $end . '"');
        } else {
            $this->dweclaims_db->select('patpin,PatientName,hcifee,profee,dischargedate,ReceiveDate,datediff(ReceiveDate, dischargedate)  as age, pStatus,proc1date')
                    ->from(masterview_vw)
                    ->where('ReceiveDate >= "' . $first . '"')
                    ->where('ReceiveDate <= "' . $end . '"');
        }
        $this->dweclaims_db->order_by('age', 'ASC');

        return $this->dweclaims_db->count_all_results();
    }

    public function get_op_phic_accnt_dashboard_total($age) {
        $date = $this->get_current_datex();
        $this->med_db->select('sum(phicHCItotal) as hospp,sum(PHICpfTotal) as proff')
                ->from(patientphic_vw)
                ->where('dischadate <=', $date)
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '');
        if ($age == "1") {
            $this->med_db->where('datediff("' . $date . '", dischadate) <= 30');
        } else if ($age == "2") {
            $this->med_db->where('datediff("' . $date . '", dischadate) >= 31')
                    ->where('datediff("' . $date . '", dischadate) <= 45');
        } else if ($age == "3") {
            $this->med_db->where('datediff("' . $date . '", dischadate) >= 46')
                    ->where('datediff("' . $date . '", dischadate) <= 60');
        } else {
            $this->med_db->where('datediff("' . $date . '", dischadate) >= 61');
        }
        $query = $this->med_db->get();
        return $query->row_array();
    }

    /*
     * Get Transmittal Account
     * 
     * @author Alingling
     * @patam string 11-25-2017
     */

    public function get_transmit_phic_accnt($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("aging", "total", "totalamount");

        $this->med_db->select('case 
                                when  datediff(postingdateclaim,dischadate) <= 15 THEN "1-15 Days"
                                when  datediff(postingdateclaim,dischadate) <= 30 THEN "16-30 Days"
                                when  datediff(postingdateclaim,dischadate) <= 45 THEN "31-45 Days"
                                when  datediff(postingdateclaim,dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphic_vw)
                ->where('postingdateclaim BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno <> ""')
                ->group_by('aging');

        if (!empty($this->input->post("search")["value"])) {
            $this->med_db->group_start()
                    ->like('(case 
                               when  datediff(postingdateclaim,dischadate) <= 15 THEN "1-15 Days"
                                when  datediff(postingdateclaim,dischadate) <= 30 THEN "16-30 Days"
                                when  datediff(postingdateclaim,dischadate) <= 45 THEN "31-45 Days"
                                when  datediff(postingdateclaim,dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                           END)', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->med_db->order_by('aging', 'ASC');
        }
    }

    function make_transmit_phic_accnt_datatables($date) {
        $this->get_transmit_phic_accnt($date);
        if ($this->input->post("length") != -1) {
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->med_db->get();
        return $query->result();
    }

    function get_transmit_phic_accnt_filtered_data($date) {
        $this->get_transmit_phic_accnt($date);
        $query = $this->med_db->get();
        return $query->num_rows();
    }

    public function get_transmit_phic_accnt_data($date) {

        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->med_db->select('case 
                                when  datediff(postingdateclaim,dischadate) <= 15 THEN "1-15 Days"
                                when  datediff(postingdateclaim,dischadate) <= 30 THEN "16-30 Days"
                                when  datediff(postingdateclaim,dischadate) <= 45 THEN "31-45 Days"
                                when  datediff(postingdateclaim,dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphic_vw)
                ->where('postingdateclaim BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno <> ""')
                ->group_by('aging');
        return $this->med_db->count_all_results();
    }

    public function get_phic_transmittal_report($date) {


        $this->med_db->select('case 
                                when  datediff(postingdateclaim,dischadate) <= 15 THEN "1-15 Days"
                                when  datediff(postingdateclaim,dischadate) <= 30 THEN "16-30 Days"
                                when  datediff(postingdateclaim,dischadate) <= 45 THEN "31-45 Days"
                                when  datediff(postingdateclaim,dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphicstat_vw)
                ->where('YEAR(dischadate) <= YEAR("' . $date . '")')
                ->where('MONTH(dischadate) <= MONTH("' . $date . '")')
                ->where('YEAR(postingdateclaim) <= YEAR("' . $date . '")')
                ->where('MONTH(postingdateclaim) >= MONTH("' . $date . '")')
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno <> ""')
                ->group_by('aging');
        $query = $this->med_db->get();
        return $query->result_array();
    }

    public function get_phic_transmittal_daily_report($s_date, $e_date) {
        $this->dweclaims_db->select('patpin,PatientName,dischargedate,processdate,hcifee,profee,grandtotal,claimedby,aging')
                ->from(masterview_vw)
                ->where('processdate >=', $s_date)
                ->where('processdate <=', $e_date)
                ->order_by("processdate", "DESC");
        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    public function generate_phic_transmittal_daily_date_report($s_date, $e_date) {
//      SELECT name, group_concat(`data`) FROM table GROUP BY name;
        $this->dweclaims_db->select('distinct(processdate)')
                ->from(masterview_vw)
                ->where('processdate >=', $s_date)
                ->where('processdate <=', $e_date)
                ->order_by("processdate", "DESC");
        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    public function generate_phic_transmittal_daily_rate_report($s_date, $e_date) {
//      SELECT name, group_concat(`data`) FROM table GROUP BY name;
        $this->dweclaims_db->select('processdate,sum(hcifee) as hosp, sum(profee) as prof,sum(grandtotal) as totalamt')
                ->from(masterview_vw)
                ->where('processdate >=', $s_date)
                ->where('processdate <=', $e_date)
                ->group_by('processdate');

        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    //payments_PHIC_aging to transmittal: alingling
    public function get_payment_phic_accnt($date) {

        $order_column = array("aging", "total", "totalamount");

        $this->med_db->select('case 
                            when  datediff(phicvoucherdate,postingdateclaim) <= 30 THEN "1-30 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 60 THEN "31-60 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 90 THEN "61-90 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphic_vw)
                ->where('YEAR(phicvoucherdate) >= YEAR("' . $date . '")')
                ->where('MONTH(phicvoucherdate) = MONTH("' . $date . '")')
                ->where('claimstatus', "PAYMENTS")
                ->group_by('aging');

        if (!empty($this->input->post("search")["value"])) {
            $this->med_db->group_start()
                    ->like('(case 
                            when  datediff(phicvoucherdate,postingdateclaim) <= 30 THEN "1-30 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 60 THEN "31-60 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 90 THEN "61-90 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                           END)', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->med_db->order_by('aging', 'ASC');
        }
    }

    function make_payment_phic_accnt_datatables($date) {
        $this->get_payment_phic_accnt($date);
        if ($this->input->post("length") != -1) {
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->med_db->get();
        return $query->result();
    }

    function get_payment_phic_accnt_filtered_data($date) {
        $this->get_payment_phic_accnt($date);
        $query = $this->med_db->get();
        return $query->num_rows();
    }

    public function get_payment_phic_accnt_data($date) {
        $this->med_db->select('case 
                            when  datediff(phicvoucherdate,postingdateclaim) <= 30 THEN "1-30 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 60 THEN "31-60 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 90 THEN "61-90 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphic_vw)
                ->where('YEAR(phicvoucherdate) >= YEAR("' . $date . '")')
                ->where('MONTH(phicvoucherdate) = MONTH("' . $date . '")')
                ->where('claimstatus', "PAYMENTS")
                ->group_by('aging');
        return $this->med_db->count_all_results();
    }

    //payments_PHIC_aging to discharge: alingling
    public function get_payment_discharge_phic_accnt($date) {

        $order_column = array("aging", "total", "totalamount");

        $this->med_db->select('case 
                            when  datediff(phicvoucherdate,dischadate) <= 30 THEN "1-30 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 60 THEN "31-60 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 90 THEN "61-90 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphic_vw)
                ->where('YEAR(phicvoucherdate) >= YEAR("' . $date . '")')
                ->where('MONTH(phicvoucherdate) = MONTH("' . $date . '")')
                ->where('claimstatus', "PAYMENTS")
                ->group_by('aging');

        if (!empty($this->input->post("search")["value"])) {
            $this->med_db->group_start()
                    ->like('(case 
                            when  datediff(phicvoucherdate,dischadate) <= 30 THEN "1-30 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 60 THEN "31-60 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 90 THEN "61-90 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                           END)', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->med_db->order_by('aging', 'ASC');
        }
    }

    function make_payment_discharge_phic_accnt_datatables($date) {
        $this->get_payment_discharge_phic_accnt($date);
        if ($this->input->post("length") != -1) {
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->med_db->get();
        return $query->result();
    }

    function get_payment_discharge_phic_accnt_filtered_data($date) {
        $this->get_payment_discharge_phic_accnt($date);
        $query = $this->med_db->get();
        return $query->num_rows();
    }

    public function get_payment_discharge_phic_accnt_data($date) {
        $this->med_db->select('case 
                            when  datediff(phicvoucherdate,dischadate) <= 30 THEN "1-30 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 60 THEN "31-60 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 90 THEN "61-90 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END as aging,count(*) as total,sum(caseratetotalActual) as totalamount')
                ->from(patientphic_vw)
                ->where('YEAR(phicvoucherdate) >= YEAR("' . $date . '")')
                ->where('MONTH(phicvoucherdate) = MONTH("' . $date . '")')
                ->where('claimstatus', "PAYMENTS")
                ->group_by('aging');
        return $this->med_db->count_all_results();
    }

    /**
     * Get Payment: Aging to Transmittal Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_payment_transmittal_phic_patients($date, $aging) {
        $order_column = array("name", "caserateTotalActual", "phicvoucherno", "dischadate", "postingdateclaim", "age", "phicmembr");
        $this->med_db->select('name,dischadate,phicmembr,postingdateclaim,datediff(phicvoucherdate,postingdateclaim) as age,phicvoucherdate,caserateTotalActual,phicvoucherno')
                ->from(patientphic_vw)
                ->where('YEAR(phicvoucherdate) >= YEAR("' . $date . '")')
                ->where('MONTH(phicvoucherdate) = MONTH("' . $date . '")')
                ->where('claimstatus', "PAYMENTS")
                ->where('case 
                            when  datediff(phicvoucherdate,postingdateclaim) <= 30 THEN "1-30 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 60 THEN "31-60 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 90 THEN "61-90 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END = "' . $aging . '"');
        if (!empty($this->input->post("search")["value"])) {
            $this->med_db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('phicmembr', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->med_db->order_by('postingdateclaim', 'ASC');
        }
    }

    function make_payment_transmittal_patient_datatables($date, $aging) {
        $this->get_payment_transmittal_phic_patients($date, $aging);
        if ($this->input->post("length") != -1) {
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->med_db->get();
        return $query->result();
    }

    function get_payment_transmittal_patients_filtered_data($date, $aging) {
        $this->get_payment_transmittal_phic_patients($date, $aging);
        $query = $this->med_db->get();
        return $query->num_rows();
    }

    public function get_payment_transmittal_patients_data($date, $aging) {
        $this->med_db->select('name,dischadate,phicmembr,postingdateclaim,datediff(phicvoucherdate,postingdateclaim) as age,phicvoucherdate,caserateTotalActual,phicvoucherno')
                ->from(patientphic_vw)
                ->where('YEAR(phicvoucherdate) >= YEAR("' . $date . '")')
                ->where('MONTH(phicvoucherdate) = MONTH("' . $date . '")')
                ->where('claimstatus', "PAYMENTS")
                ->where('case 
                            when  datediff(phicvoucherdate,postingdateclaim) <= 30 THEN "1-30 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 60 THEN "31-60 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 90 THEN "61-90 Days"
                            when  datediff(phicvoucherdate,postingdateclaim) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END = "' . $aging . '"');
        return $this->med_db->count_all_results();
    }

    /**
     * Get Payment: Aging to Discharge Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_payment_discharge_phic_patients($date, $aging) {
        $order_column = array("name", "caserateTotalActual", "phicvoucherno", "dischadate", "postingdateclaim", "age", "phicmembr");
        $this->med_db->select('name,dischadate,phicmembr,postingdateclaim,datediff(phicvoucherdate,dischadate) as age,phicvoucherdate,caserateTotalActual,phicvoucherno')
                ->from(patientphic_vw)
                ->where('YEAR(phicvoucherdate) >= YEAR("' . $date . '")')
                ->where('MONTH(phicvoucherdate) = MONTH("' . $date . '")')
                ->where('claimstatus', "PAYMENTS")
                ->where('case 
                            when  datediff(phicvoucherdate,dischadate) <= 30 THEN "1-30 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 60 THEN "31-60 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 90 THEN "61-90 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END = "' . $aging . '"');
        if (!empty($this->input->post("search")["value"])) {
            $this->med_db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('phicmembr', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->med_db->order_by('postingdateclaim', 'ASC');
        }
    }

    function make_payment_discharge_patient_datatables($date, $aging) {
        $this->get_payment_discharge_phic_patients($date, $aging);
        if ($this->input->post("length") != -1) {
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->med_db->get();
        return $query->result();
    }

    function get_payment_discharge_patients_filtered_data($date, $aging) {
        $this->get_payment_discharge_phic_patients($date, $aging);
        $query = $this->med_db->get();
        return $query->num_rows();
    }

    public function get_payment_discharge_patients_data($date, $aging) {
        $this->med_db->select('name,dischadate,phicmembr,postingdateclaim,datediff(phicvoucherdate,dischadate) as age, phicvoucherdate,caserateTotalActual,phicvoucherno')
                ->from(patientphic_vw)
                ->where('YEAR(phicvoucherdate) >= YEAR("' . $date . '")')
                ->where('MONTH(phicvoucherdate) = MONTH("' . $date . '")')
                ->where('claimstatus', "PAYMENTS")
                ->where('case 
                            when  datediff(phicvoucherdate,dischadate) <= 30 THEN "1-30 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 60 THEN "31-60 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 90 THEN "61-90 Days"
                            when  datediff(phicvoucherdate,dischadate) <= 120 THEN "91-120 Days"
                            ELSE "120 Days aboved"
                            END = "' . $aging . '"');
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


    public function get_onprocess_phic_patients($date, $aging) {
        $order_column = array("caseno", "name", "admitdate", "dischadate", "phicHCItotal", "PHICpfTotal", "phicmembr", "aging",);
        $this->med_db->select('caseno,name,admitdate,dischadate,phicmembr,datediff("' . $date . '", dischadate) as aging,phicHCItotal,PHICpfTotal')
                ->from(patientphic_vw)
                ->where('dischadate <=', $date)
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '')
                ->where('case 
                            when  datediff("' . $date . '", dischadate) <= 15 THEN "1-15 Days"
                            when  datediff("' . $date . '", dischadate) <= 30 THEN "16-30 Days"
                            when  datediff("' . $date . '", dischadate) <= 45 THEN "31-45 Days"
                            when  datediff("' . $date . '", dischadate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"');
        if (!empty($this->input->post("search")["value"])) {
            $this->med_db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('phicmembr', $this->input->post("search")["value"])
                    ->or_like('admitdate', $this->input->post("search")["value"])
                    ->or_like('dischadate', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->med_db->order_by('aging', 'ASC');
        }
    }

    function make_onprocess_phic_patient_datatables($date, $aging) {
        $this->get_onprocess_phic_patients($date, $aging);
        if ($this->input->post("length") != -1) {
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->med_db->get();
        return $query->result();
    }

    function get_onprocess_phic_patients_filtered_data($date, $aging) {
        $this->get_onprocess_phic_patients($date, $aging);
        $query = $this->med_db->get();
        return $query->num_rows();
    }

    public function get_onprocess_phic_patients_data($date, $aging) {
        $this->med_db->select('caseno,name,admitdate,dischadate,phicmembr,datediff("' . $date . '", dischadate) as aging,phicHCItotal,PHICpfTotal')
                ->from(patientphic_vw)
                ->where('dischadate <=', $date)
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '')
                ->where('case 
                            when  datediff("' . $date . '", dischadate) <= 15 THEN "1-15 Days"
                            when  datediff("' . $date . '", dischadate) <= 30 THEN "16-30 Days"
                            when  datediff("' . $date . '", dischadate) <= 45 THEN "31-45 Days"
                            when  datediff("' . $date . '", dischadate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"')
                ->order_by('aging', 'ASC');
        return $this->med_db->count_all_results();
    }

    public function get_onprocess_phic_patients_report($date, $aging) {
        $this->med_db->select('caseno,name,admitdate,dischadate,phicmembr,datediff("' . $date . '", dischadate) as aging,phicHCItotal,PHICpfTotal')
                ->from(patientphic_vw)
                ->where('dischadate <=', $date)
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '')
                ->where('case 
                            when  datediff("' . $date . '", dischadate) <= 15 THEN "1-15 Days"
                            when  datediff("' . $date . '", dischadate) <= 30 THEN "16-30 Days"
                            when  datediff("' . $date . '", dischadate) <= 45 THEN "31-45 Days"
                            when  datediff("' . $date . '", dischadate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"')
                ->order_by('aging', 'ASC');
        $query = $this->med_db->get();
        return $query->result_array();
    }

    public function get_onprocess_phic_patients_total($date, $aging) {
        $this->med_db->select('sum(phicHCItotal) as hospp,sum(PHICpfTotal) as proff')
                ->from(patientphic_vw)
                ->where('dischadate <=', $date)
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '')
                ->where('case 
                            when  datediff("' . $date . '", dischadate) <= 15 THEN "1-15 Days"
                            when  datediff("' . $date . '", dischadate) <= 30 THEN "16-30 Days"
                            when  datediff("' . $date . '", dischadate) <= 45 THEN "31-45 Days"
                            when  datediff("' . $date . '", dischadate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"')
                ->group_by('claimcontrolno');
        $query = $this->med_db->get();
        return $query->row_array();
    }

    /*
     * Gets all patients for on process
     * 
     * @author Alingling
     * @param string 11-25-2017
     * 
     */

    public function get_onprocess_phic_patients_all() {
        $order_column = array("name", "discharges", null, "phicmembr");
        $this->med_db->select('name,concat(dischadate," ",dischatime) as discharges ,phicmembr,phicHCItotal, datediff("' . $date . '", dischadate) as aging')
                ->from(patientphic_vw)
                ->where('dischadate <=', $this->get_current_date())
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '')
                ->where('claimstatus <> "PAYMENTS"');

        if (!empty($this->input->post("search")["value"])) {
            $this->med_db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('phicmembr', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->med_db->order_by('dischadate', 'ASC');
        }
    }

    function make_onprocess_phic_patient_all_datatables() {
        $this->get_onprocess_phic_patients_all();
        if ($this->input->post("length") != -1) {
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->med_db->get();
        return $query->result();
    }

    function get_onprocess_phic_patients_all_filtered_data() {
        $this->get_onprocess_phic_patients_all();
        $query = $this->med_db->get();
        return $query->num_rows();
    }

    public function get_onprocess_phic_patients_all_data() {
        $this->med_db->select('name,concat(dischadate," ",dischatime) as discharges ,phicmembr,phicHCItotal, datediff("' . $date . '", dischadate) as aging')
                ->from(patientphic_vw)
                ->where('dischadate <=', $this->get_current_date())
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '')
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

    public function get_transmitted_phic_patients($date, $aging) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("name", "dischadate", "postingdateclaim", "age", "phicmembr");
        $this->med_db->select('name,dischadate,phicmembr,postingdateclaim,datediff(postingdateclaim,dischadate) as age')
                ->from(patientphic_vw)
                ->where('postingdateclaim BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno <> ""')
                ->where('case 
                             when  datediff(postingdateclaim,dischadate) <= 15 THEN "1-15 Days"
                            when  datediff(postingdateclaim,dischadate) <= 30 THEN "16-30 Days"
                            when  datediff(postingdateclaim,dischadate) <= 45 THEN "31-45 Days"
                            when  datediff(postingdateclaim,dischadate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"');
        if (!empty($this->input->post("search")["value"])) {
            $this->med_db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('phicmembr', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->med_db->order_by('postingdateclaim', 'ASC');
        }
    }

    function make_transmitted_phic_patient_datatables($date, $aging) {
        $this->get_transmitted_phic_patients($date, $aging);
        if ($this->input->post("length") != -1) {
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->med_db->get();
        return $query->result();
    }

    function get_transmitted_phic_patients_filtered_data($date, $aging) {
        $this->get_transmitted_phic_patients($date, $aging);
        $query = $this->med_db->get();
        return $query->num_rows();
    }

    public function get_transmitted_phic_patients_data($date, $aging) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("name", "dischadate", "postingdateclaim", "age", "phicmembr");
        $this->med_db->select('name,dischadate,phicmembr,postingdateclaim,datediff(postingdateclaim,dischadate) as age')
                ->from(patientphic_vw)
                ->where('postingdateclaim BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno <> ""')
                ->where('case 
                            when  datediff(postingdateclaim,dischadate) <= 15 THEN "1-15 Days"
                            when  datediff(postingdateclaim,dischadate) <= 30 THEN "16-30 Days"
                            when  datediff(postingdateclaim,dischadate) <= 45 THEN "31-45 Days"
                            when  datediff(postingdateclaim,dischadate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"')
                ->order_by('postingdateclaim', 'ASC');
        return $this->med_db->count_all_results();
    }

    /**
     * Get Admitted Patients of the Day Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_admitted_day_patients($admitDischaDate) {

        $order_column = array("name", "admission", "pat_classification", "Age", "bday", "roombrief", "doctorname", "phicmembr", "admittedby");
        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where("admitdate", $admitDischaDate)
                ->where('pxtype', 'IPD');
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('pat_classification', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('admission', 'ASC');
        }
    }

    function make_admitted_day_patient_datatables($admitDischaDate) {
        $this->get_admitted_day_patients($admitDischaDate);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_admitted_day_patient_filtered_data($admitDischaDate) {
        $this->get_admitted_day_patients($admitDischaDate);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_admitted_day_patient_data($admitDischaDate) {
        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where("admitdate ", $admitDischaDate)
                ->where('pxtype', 'IPD');
        return $this->db->count_all_results();
    }

    /**
     * Get Admitted Patients of the Day Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_total_admitted_day_patients() {
        $order_column = array("name", "admission", "pat_classification", "Age", "bday", "roombrief", "doctorname", "phicmembr", "admittedby");
        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where('discharged', '0')
                ->where('pxtype', 'IPD')
                ->where("admitdate <=", $this->get_current_datex());
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('pat_classification', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('admission', 'ASC');
        }
    }

    function make_total_admitted_day_patient_datatables() {
        $this->get_total_admitted_day_patients();
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_total_admitted_day_patient_filtered_data() {
        $this->get_total_admitted_day_patients();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_total_admitted_day_patient_data() {
        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where('discharged', '0')
                ->where('pxtype', 'IPD')
                ->where("admitdate <=", $this->get_current_datex());
        return $this->db->count_all_results();
    }

    /**
     * Get Discharge Patients of the Day Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_discharged_day_patients($admitDischaDate) {

        $order_column = array("name", "discharged", "admission", "pat_classification", "Age", "roombrief", "doctorname", "phicmembr");
        $this->db->select("name, concat(dischadate,' ',dischatime) as discharged,concat(admitdate,' ',admittime) as admission,pat_classification,Age,roombrief,doctorname,phicmembr")
                ->from(inpatient_tbl)
                ->where("dischadate", $admitDischaDate)
                ->where("discharged", 1)
                ->where('pxtype', 'IPD');
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('discharged', $this->input->post("search")["value"])
                    ->or_like('pat_classification', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('discharged', 'ASC');
        }
    }

    function make_discharged_day_patient_datatables($admitDischaDate) {
        $this->get_discharged_day_patients($admitDischaDate);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_discharged_day_patient_filtered_data($admitDischaDate) {
        $this->get_discharged_day_patients($admitDischaDate);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_discharged_day_patient_data($admitDischaDate) {
        $this->db->select("name, concat(dischadate,' ',dischatime) as discharged,concat(admitdate,' ',admittime) as admission,pat_classification,Age,roombrief,doctorname,phicmembr")
                ->from(inpatient_tbl)
                ->where("dischadate", $admitDischaDate)
                ->where("discharged", 1)
                ->where('pxtype', 'IPD');
        return $this->db->count_all_results();
    }

    /**
     * Get PHIC Patients of the Day Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_admitted__phic_day_patients() {
        $order_column = array("name", "admission", "pat_classification", "Age", "bday", "roombrief", "doctorname", "phicmembr", "admittedby");
        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' @ ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype', 'IPD')
                ->where("discharged", 0)
                ->where("phicmembr <> 'Non-NHIP'");
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('pat_classification', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('admission', 'ASC');
        }
    }

    function make_admitted__phic_day_patient_datatables() {
        $this->get_admitted__phic_day_patients();
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_admitted__phic_day_patient_filtered_data() {
        $this->get_admitted__phic_day_patients();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_admitted_phic_day_patient_data() {
        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' @ ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype', 'IPD')
                ->where("discharged", 0)
                ->where("phicmembr <> 'Non-NHIP'");
        return $this->db->count_all_results();
    }

    /**
     * Get Non-PHIC Patients of the Day Patients
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_admitted_non_phic_day_patients() {
        $order_column = array("name", "admission", "pat_classification", "Age", "bday", "roombrief", "doctorname", "phicmembr", "admittedby");
        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' @ ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype', 'IPD')
                ->where("discharged", 0)
                ->where("phicmembr = 'Non-NHIP'");
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('name', $this->input->post("search")["value"])
                    ->or_like('pat_classification', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('admission', 'ASC');
        }
    }

    function make_admitted_non_phic_day_patient_datatables() {
        $this->get_admitted_non_phic_day_patients();
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_admitted_non_phic_day_patient_filtered_data() {
        $this->get_admitted_non_phic_day_patients();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_admitted_non_phic_day_patient_data() {
        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' @ ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype', 'IPD')
                ->where("discharged", 0)
                ->where("phicmembr = 'Non-NHIP'");
        return $this->db->count_all_results();
    }

    /**
     * Gets all on process philhealth account.
     * 
     * @author pauldigz@gmail.com
     * @param string $date(Y-m-d)
     */
    public function get_op_phic_accnt_px($date) {
        $order_column = array("aging", "total", "totalamount");
        $this->med_db->select('case 
                                when  DATE("' . $date . '") - DATE(dischadate) <= 15 THEN "1-15 Days"
                                when  DATE("' . $date . '") - DATE(dischadate) <= 30 THEN "16-30 Days"
                                when  DATE("' . $date . '") - DATE(dischadate) <= 45 THEN "31-45 Days"
                                when  DATE("' . $date . '") - DATE(dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(phicHCItotal) as totalamount')
                ->from(patientphic_vw)
                ->where('dischadate', $date)
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '')
                ->group_by('aging');

        if (!empty($this->input->post("search")["value"])) {
            $this->med_db->group_start()
                    ->like('aging', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->med_db->order_by('aging', 'ASC');
        }
    }

    /**
     * Make on process philhealth account datatable. 
     * 
     * @author pauldigz@gmail.com
     * @param datetime $date (Y-m-d)
     * @return array
     */
    function make_op_phic_accnt_px_datatables($date) {
        $this->get_op_phic_accnt($date);
        if ($this->input->post("length") != -1) {
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
    function get_op_phic_accnt_px_filtered_data($date) {
        $this->get_op_phic_accnt($date);
        $query = $this->med_db->get();
        return $query->num_rows();
    }

    public function get_op_phic_px_accnt_data($date) {
        $this->med_db->select('case 
                                when  DATE(' . $date . ') - DATE(dischadate) <= 15 THEN "1-15 Days"
                                when  DATE(' . $date . ') - DATE(dischadate) <= 30 THEN "16-30 Days"
                                when  DATE(' . $date . ') - DATE(dischadate) <= 45 THEN "31-45 Days"
                                when  DATE(' . $date . ') - DATE(dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(phicHCItotal) as totalamount')
                ->from(patientphic_vw)
                ->where('dischadate', $date)
                ->group_by('aging');
        return $this->med_db->count_all_results();
    }

    public function get_phic_op_census($date) {
        $this->med_db->select('case 
                                when  datediff("' . $date . '", dischadate) <= 15 THEN "1-15 Days"
                                when  datediff("' . $date . '", dischadate) <= 30 THEN "16-30 Days"
                                when  datediff("' . $date . '", dischadate) <= 45 THEN "31-45 Days"
                                when  datediff("' . $date . '", dischadate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as aging,count(*) as total,sum(phicHCItotal) as totalamount')
                ->from(patientphic_vw)
                ->where('dischadate <=', $date)
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno', '')
                ->group_by('aging');

        $query = $this->med_db->get();
        return $query->result_array();
    }

    public function modify_account() {
        $data = array(
            'EmpID' => $this->security->xss_clean($this->input->post("username")),
            'EmpPass' => $this->encrypt_pass($this->security->xss_clean($this->input->post("pass"))),
            'updated' => $this->get_current_date()
        );

        $this->hub_db->where('ID', $this->security->xss_clean($this->session->userdata('userid')));
        return $this->hub_db->update(usersrights_tbl, $data);
    }

    public function check_uname($uname) {
        $id = $this->security->xss_clean($this->session->userdata('userid'));

        $this->hub_db->select('EmpID')
                ->from(usersrights_tbl)
                ->where('EmpID', $uname)
                ->where('ID <>', $id);

        $query = $this->hub_db->get();
        return $query->num_rows() ? $query->row_array() : FALSE;
    }

    public function check_oldpass($oldpass) {
        $id = $this->security->xss_clean($this->session->userdata('userid'));

        $this->hub_db->select('EmpID')
                ->from(usersrights_tbl)
                ->where('ID', $id)
                ->where('EmpPass', $this->encrypt_pass($oldpass));

        $query = $this->hub_db->get();
        return $query->num_rows() ? $query->row_array() : FALSE;
    }

    public function get_today_add() {
        $this->db->select("*")
                ->from(inpatient_tbl)
                ->where("admitdate", $this->get_current_datex())
                ->where('pxtype', 'IPD');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_today_disc() {
        $this->db->select("*")
                ->from(inpatient_tbl)
                ->where("dischadate", $this->get_current_datex())
                ->where("discharged", 1)
                ->where('pxtype', 'IPD');

        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     * Get all assets
     * 
     * @author Alingling
     * @param 12-1-2017
     */
    public function get_all_assets() {
        $order_column = array("ControlNumber", "Category", "AssetType", "Department", "Manufacturer", "Suppliers", "Quantity", "DatePurchase", "PersonResponsible");
        $this->esched_db->select('*')
                ->from(fixedassets_tbl);


        if (!empty($this->input->post("search")["value"])) {
            $this->esched_db->group_start()
                    ->like("ControlNumber", $this->input->post("search")["value"])
                    ->or_like("Category", $this->input->post("search")["value"])
                    ->or_like("AssetType", $this->input->post("search")["value"])
                    ->or_like("Manufacturer", $this->input->post("search")["value"])
                    ->or_like("Suppliers", $this->input->post("search")["value"])
                    ->or_like("Quantity", $this->input->post("search")["value"])
                    ->or_like("assetstatus", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->esched_db->order_by("AssetType", "ASC");
        }
    }

    function make_all_assets_datatables() {
        $this->get_all_assets();
        if ($this->input->post("length") != -1) {
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->esched_db->get();
        return $query->result();
    }

    function get_all_assets_filtered_data() {
        $this->get_all_assets();
        $query = $this->esched_db->get();
        return $query->num_rows();
    }

    public function get_all_assets_data() {
        $this->esched_db->select("*")
                ->from(fixedassets_tbl);
        return $this->esched_db->count_all_results();
    }

    /**
     * Get all assets info, i.e. service date
     * 
     * @author Alingling
     * @param 12-1-2017
     */
    public function get_all_assets_info($cnumber) {
        $order_column = array("Controlnumber", "ServiceDate", "Complaints", "Assetstatus", "Findings");
        $this->esched_db->select('*')
                ->from(servicing_tbl)
                ->where('Controlnumber', $cnumber);

        if (!empty($this->input->post("search")["value"])) {
            $this->esched_db->group_start()
                    ->like("Controlnumber", $this->input->post("search")["value"])
                    ->or_like("ServiceDate", $this->input->post("search")["value"])
                    ->or_like("Complaints", $this->input->post("search")["value"])
                    ->or_like("Assetstatus", $this->input->post("search")["value"])
                    ->or_like("Findings", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->esched_db->order_by("ServiceDate", "ASC");
        }
    }

    function make_all_assets_info_datatables($cnumber) {
        $this->get_all_assets_info($cnumber);
        if ($this->input->post("length") != -1) {
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->esched_db->get();
        return $query->result();
    }

    function get_all_assets_info_filtered_data($cnumber) {
        $this->get_all_assets_info($cnumber);
        $query = $this->esched_db->get();
        return $query->num_rows();
    }

    public function get_all_assets_info_data($cnumber) {
        $this->esched_db->select('*')
                ->from(servicing_tbl)
                ->where('Controlnumber', $cnumber);

        return $this->esched_db->count_all_results();
    }

    /**
     * Get Room Occupancy Rate
     * 
     * @author Alingling
     * @param 11-29-2017
     */
    public function get_room_occupancy_ward_data($date) {
        $this->db->select("count(*) as totalbed, (select WardRoom from profile) as Beds, (count(*)/ (select WardRoom from profile) * 100)  as percentage")
                ->from(inpatient_tbl)
//            ->where('dischadate >=', $date)    
                ->where('((admitdate <= "' . $date . '" AND discharged = 0) OR (discharged = 1 and dischadate > "' . $date . '" AND admitdate <= "' . $date . '"))')
                ->where('pxtype', 'IPD')
                ->where('roomtype', "WARD");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_room_occupancy_private_data($date) {
        $this->db->select("count(*) as totalbed,(select PrivateRoom from profile) as Beds, (count(*)/ (select PrivateRoom from profile) * 100)  as percentage")
                ->from(inpatient_tbl)
//            ->where('dischadate >=', $date)    
                ->where('((admitdate <= "' . $date . '" AND discharged = 0) OR (discharged = 1 and dischadate > "' . $date . '" AND admitdate <= "' . $date . '"))')
                ->where('pxtype', 'IPD')
                ->where('roomtype', "PRIVATE");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_room_occupancy_suite_data($date) {
        $this->db->select("count(*) as totalbed,(select SuiteRoom from profile) as Beds, (count(*)/ (select SuiteRoom from profile) * 100)  as percentage")
                ->from(inpatient_tbl)
//            ->where('dischadate >=', $date)    
                ->where('((admitdate <= "' . $date . '" AND discharged = 0) OR (discharged = 1 and dischadate > "' . $date . '" AND admitdate <= "' . $date . '"))')
                ->where('pxtype', 'IPD')
                ->where('roomtype', "SUITEROOM");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_room_occupancy_ward_day() {
        $this->db->select("count(*) as totalbed, (select WardRoom from profile) as Beds, (count(*)/ (select WardRoom from profile) * 100)  as percentage")
                ->from(inpatient_tbl)
                //         ->where('dischadate >=', $this->get_current_datex())    
                ->where('admitdate <=', $this->get_current_datex())
                ->where('pxtype', 'IPD')
                ->where("discharged", 0)
                ->where('roomtype', "WARD");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_room_occupancy_private_day() {
        $this->db->select("count(*) as totalbed,(select PrivateRoom from profile) as Beds, (count(*)/ (select PrivateRoom from profile) * 100)  as percentage")
                ->from(inpatient_tbl)
                //       ->where('dischadate >=', $this->get_current_datex())    
                ->where('admitdate <=', $this->get_current_datex())
                ->where('pxtype', 'IPD')
                ->where("discharged", 0)
                ->where('roomtype', "PRIVATE");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_room_occupancy_suite_day() {
        $this->db->select("count(*) as totalbed,(select SuiteRoom from profile) as Beds, (count(*)/ (select SuiteRoom from profile) * 100)  as percentage")
                ->from(inpatient_tbl)
                //     ->where('dischadate >=', $this->get_current_datex())    
                ->where('admitdate <=', $this->get_current_datex())
                ->where('pxtype', 'IPD')
                ->where("discharged", 0)
                ->where('roomtype', "SUITEROOM");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_daily_census() {
        $data = array();
        $dates = array();

        $start_date = date('Y-m-d', strtotime('today - 29 days'));
        $end_date = new DateTime();
        $end_date->format("Y-m-d");

        $period = new DatePeriod(
                new DateTime($start_date), new DateInterval('P1D'), $end_date
        );


        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        for ($i = 0; $i < count($dates); $i++) {
            $this->db->select('"' . $dates[$i] . '" as datex,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                            . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                    ->from(inpatient_tbl)
                    ->where('((admitdate <= "' . $dates[$i] . '" AND discharged = 0) OR (discharged = 1 and dischadate > "' . $dates[$i] . '" AND admitdate <= "' . $dates[$i] . '")) and pxtype = "IPD"');
//                ->where ('admitdate <="'.$dates[$i].'"')
//                ->where('discharged',0)
//                ->where('pxtype','IPD');
            $query = $this->db->get();

            array_push($data, $query->row_array());
        }

        return $data;
    }

    public function get_monthly_census() {
        $data = array();
        $dates = array();

        $start_date = date('Y-m-d', strtotime('today - 5 months'));
        $end_date = new DateTime();
        $end_date->format("Y-m-d");

        $period = new DatePeriod(
                new DateTime($start_date), new DateInterval('P1M'), $end_date
        );


        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }


        for ($i = 0; $i < count($dates); $i++) {
            $datexx = $this->get_yearmonths($dates[$i]);
            $this->db->select('"' . $datexx . '" as datex,SUM(case when UPPER(pat_clascode)  = "GYNECOLOGY" THEN 1 ELSE 0 END) Gynecology,
                SUM(case when UPPER(pat_clascode)  = "MEDICALl" THEN 1 ELSE 0 END) Medical, 
                SUM(case when UPPER(pat_clascode)  = "NEW BORN" THEN 1 ELSE 0 END) NewBorn, 
                SUM(case when UPPER(pat_clascode)  = "OBSTETRICS" THEN 1 ELSE 0 END) Obstetrics, 
                SUM(case when UPPER(pat_clascode)  = "OTHERS" THEN 1 ELSE 0 END) Others, 
                SUM(case when UPPER(pat_clascode) = "PEDIA 1 - NURSERY" or UPPER(pat_clascode) = "PEDIA 1 - INSIDE" or UPPER(pat_clascode) ="PEDIA FROM  INSIDE" OR UPPER(pat_clascode) = "PEDIA FROM OUTSIDE" THEN 1 ELSE 0 END) Pediatrics, 
                SUM(case when UPPER(pat_clascode) = "SURGERY" OR  UPPER(pat_clascode) = "SURGICAL" THEN 1 ELSE 0 END) Surgery')
                    ->from(inpatient_tbl)
                    ->where('(MONTH(dischadate) = MONTH("' . $dates[$i] . '") and YEAR(dischadate) = YEAR("' . $dates[$i] . '")) and discharged = 1 and pxtype="IPD"');

            $query = $this->db->get();

            array_push($data, $query->row_array());
        }

        return $data;
    }

    public function get_all_log() {
        $order_column = array("logername", "action", "logdate", "devicetype", "deviceos", "browser");
        $this->db->select('*')->from(weblog_tbl);
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("logername", $this->input->post("search")["value"])
                    ->or_like("action", $this->input->post("search")["value"])
                    ->or_like("logdate", $this->input->post("search")["value"])
                    ->or_like("devicetype", $this->input->post("search")["value"])
                    ->or_like("deviceos", $this->input->post("search")["value"])
                    ->or_like("browser", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('logdate', 'DESC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_all_log_datatables() {
        $this->get_all_log();
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_all_log_filtered_data() {
        $this->get_all_log();
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_log_data() {
        $this->db->select('*')->from(weblog_tbl);

        return $this->db->count_all_results();
    }

    public function get_each_day_census($date) {
        $order_column = array("name", "admitdate", "dischadate", "pat_classification", "age", "bday", "roombrief", "doctorname", "phicmembr");
        $this->db->select('name,admitdate,dischadate,pat_classification,age,bday,roombrief,doctorname,phicmembr')
                ->from(inpatient_tbl)
                ->where('((admitdate <= "' . $date . '" AND discharged = 0) OR (discharged = 1 and dischadate > "' . $date . '" AND admitdate <= "' . $date . '")) and pxtype = "IPD"');
        if (!empty($this->input->post("search")["value"])) {
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
        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('name', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_each_day_census_datatables($date) {
        $this->get_each_day_census($date);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_each_day_census_filtered_data($date) {
        $this->get_each_day_census($date);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_each_day_census_data($date) {
        $this->db->select('name,admitdate,dischadate,pat_classification,age,bday,roombrief,doctorname,phicmembr')
                ->from(inpatient_tbl)
                ->where('((admitdate <= "' . $date . '" AND discharged = 0) OR (discharged = 1 and dischadate > "' . $date . '" AND admitdate <= "' . $date . '")) and pxtype = "IPD"');

        return $this->db->count_all_results();
    }

    public function get_daily_transaction($dating) {
        $data = array();
        $dates = array();

        $start_date = date('Y-m-d', strtotime("-29 days", strtotime($dating)));
        //echo $start_date;
        $end_date = new DateTime($dating);
        $end_date->format("Y-m-d");

        $period = new DatePeriod(
                new DateTime($start_date), new DateInterval('P1D'), $end_date
        );


        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        $dates[] = $dating;

        for ($i = 0; $i < count($dates); $i++) {
            $this->db->select('"' . $dates[$i] . '" as datex,drugs,medsply,pharmisc,lab,rad,hosp,'
                            . 'ipdpay,hmoacct,pcsoacct,phicacct,opdlab,opdrad,opdhosp,pnacct,deliveryphar,deliverylab,deliveryrad,deliveryhosp, '
                            . '(drugs+medsply+pharmisc) pharmacy,'
                            . '(drugs+medsply+pharmisc+lab+rad+hosp) total')
                    ->from(dailytransaction_tbl)
                    ->where('transdate', $dates[$i]);
            $query = $this->db->get();

            array_push($data, $query->row_array());
        }

        return $data;
    }

    public function get_monthly_transaction($monthdate, $month) {
        $data = array();
        $dates = array();
        switch ($month) {
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


        $end_date = new DateTime($monthdate);
        $end_date->format("Y-m-d");

        $period = new DatePeriod(
                new DateTime($start_date), new DateInterval('P1M'), $end_date
        );


        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        $dates[] = $monthdate;
        $d = count($dates);
        for ($i = 0; $i < count($dates); $i++) {
            $datexx = $this->get_yearmonths($dates[$i]);
            $this->db->select('"' . $datexx . '" as datex,'
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
                            . '(sum(drugs)+sum(medsply)+sum(pharmisc)) pharmacy,'
                            . '(sum(drugs)+sum(medsply)+sum(pharmisc)+sum(lab)+sum(rad)+sum(hosp)) total')
                    ->from(dailytransaction_tbl)
                    ->where('YEAR(transdate) = YEAR("' . $dates[$i] . '")')
                    ->where('MONTH(transdate) = MONTH("' . $dates[$i] . '")');

            $query = $this->db->get();

            array_push($data, $query->row_array());
        }

        return $data;
    }

    /* Fix Asset-> Job Order Approval
     * @author Alingling
     */

    public function get_jobapproval_ticket($dept = NULL) {
        $order_column = array("requestid", "requestdate", "AssetType", "Department", "Complaints", "details");
        if ($dept === "All") {
            $this->esched_db->select('*')
                    ->from(request_tbl)
                    ->where('approved', '0');
        } else if ($dept <> "") {
            $this->esched_db->select('*')
                    ->from(request_tbl)
                    ->where('approved', '0')
                    ->where('Department', $dept);
        } else {
            $this->esched_db->select('*')
                    ->from(request_tbl)
                    ->where('approved', '0');
        }


        if (!empty($this->input->post("search")["value"])) {
            $this->esched_db->group_start()
                    ->like("AssetType", $this->input->post("search")["value"])
                    ->or_like("Department", $this->input->post("search")["value"])
                    ->or_like("Complaints", $this->input->post("search")["value"])
                    ->or_like("details", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->esched_db->order_by("requestdate", "DESC");
        }
    }

    function make_jobapproval_ticket_datatables($dept) {
        $this->get_jobapproval_ticket($dept);
        if ($this->input->post("length") != -1) {
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->esched_db->get();
        return $query->result();
    }

    function get_jobapproval_ticket_filtered_data($dept) {
        $this->get_jobapproval_ticket($dept);
        $query = $this->esched_db->get();
        return $query->num_rows();
    }

    public function get_jobapproval_ticket_data($dept) {
        if ($dept === "All") {
            $this->esched_db->select('*')
                    ->from(request_tbl)
                    ->where('approved', '0');
        } else if ($dept <> "") {
            $this->esched_db->select('*')
                    ->from(request_tbl)
                    ->where('approved', '0')
                    ->where('Department', $dept);
        } else {
            $this->esched_db->select('*')
                    ->from(request_tbl)
                    ->where('approved', '0');
        }
        return $this->esched_db->count_all_results();
    }

    public function get_transmit() {
        $data = array();
        $dates = array();

        $start_date = date('Y-m-d', strtotime('today - 5 months'));
        $end_date = new DateTime();
        $end_date->format("Y-m-d");

        $period = new DatePeriod(
                new DateTime($start_date), new DateInterval('P1M'), $end_date
        );


        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        $d = count($dates);
        for ($i = 0; $i < count($dates); $i++) {
            $datexx = $this->get_yearmonths($dates[$i]);

            $this->med_db->select('"' . $datexx . '" as datex,count(dischadate) as discharges,count(case when phicmembr <> "non-nhip" then 1 else 0 end) phicmemb,count(postingdateclaim) as transmitted, sum(caseratetotalActual) as totalamount')
                    ->from(patientphic_vw)
                    ->where('YEAR(postingdateclaim) = YEAR("' . $dates[$i] . '")')
                    ->where('MONTH(postingdateclaim) = MONTH("' . $dates[$i] . '")')
                    ->where('discharged', 1)
                    ->where('phiccode <>', 'NHP')
                    ->where('claimcontrolno <> ""');
            $query = $this->med_db->get();

            array_push($data, $query->row_array());
        }

        return $data;
    }

    public function get_monthly_transmittal($datexx) {
        $monthstart = date("Y-m-01", strtotime($datexx . "-01"));
        $monthend = date("Y-m-t", strtotime($datexx . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("name", "caserateTotalActual", "dischadate", "postingdateclaim", "age", "phicmembr");
        $this->med_db->select('name,caserateTotalActual,dischadate,phicmembr,postingdateclaim,datediff(postingdateclaim,dischadate) as age')
                ->from(patientphic_vw)
                ->where('postingdateclaim BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno <> ""');

        if (!empty($this->input->post("search")["value"])) {
            $this->med_db->group_start()
                    ->like("name", $this->input->post("search")["value"])
                    ->or_like("age", $this->input->post("search")["value"])
                    ->or_like("phicmembr", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->med_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->med_db->order_by("postingdateclaim", "DESC");
        }
    }

    function make_monthly_transmittal_datatables($datexx) {
        $this->get_monthly_transmittal($datexx);
        if ($this->input->post("length") != -1) {
            $this->med_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->med_db->get();
        return $query->result();
    }

    function get_monthly_transmittal_filtered_data($datexx) {
        $this->get_monthly_transmittal($datexx);
        $query = $this->med_db->get();
        return $query->num_rows();
    }

    public function get_monthly_transmittal_data($datexx) {
        $monthstart = date("Y-m-01", strtotime($datexx . "-01"));
        $monthend = date("Y-m-t", strtotime($datexx . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->med_db->select('name,caserateTotalActual,dischadate,phicmembr,postingdateclaim,datediff(postingdateclaim,dischadate) as age')
                ->from(patientphic_vw)
                ->where('postingdateclaim BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('discharged', 1)
                ->where('phiccode <>', 'NHP')
                ->where('claimcontrolno <> ""');
        return $this->med_db->count_all_results();
    }

    public function philhealth_now_report() {

        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' @ ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype', 'IPD')
                ->where("discharged", 0)
                ->where("phicmembr <> 'Non-NHIP'")
                ->order_by("name", "ASC");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function nonphilhealth_now_report() {

        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' @ ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where('admitdate <=', $this->get_current_date())
                ->where('pxtype', 'IPD')
                ->where("discharged", 0)
                ->where('phicmembr', 'Non-NHIP')
                ->order_by("name", "ASC");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function total_patients_report() {

        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where('discharged', '0')
                ->where('pxtype', 'IPD')
                ->where("admitdate <=", $this->get_current_datex())
                ->order_by("name", "ASC");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function admitted_patients_report($admitDischaDatex) {

        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where("admitdate ", $admitDischaDatex)
                ->where('pxtype', 'IPD');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function discharged_patients_report($admitDischaDatex) {

        $this->db->select("name, concat(admitdate,' ',admittime) as admission,pat_classification,Age,bday,roombrief,doctorname,phicmembr,concat(recby,' ',updated) as admittedby")
                ->from(inpatient_tbl)
                ->where("dischadate", $admitDischaDatex)
                ->where("discharged", 1)
                ->where('pxtype', 'IPD');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function eachd_patients_report($date) {

        $this->db->select('name,admitdate,dischadate,pat_classification,age,bday,roombrief,doctorname,phicmembr')
                ->from(inpatient_tbl)
                ->where('((admitdate <= "' . $date . '" AND discharged = 0) OR (discharged = 1 and dischadate > "' . $date . '" AND admitdate <= "' . $date . '")) and pxtype = "IPD"')
                ->order_by("name", "ASC");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_asset_report() {
        $this->esched_db->select("*")
                ->from(fixedassets_tbl);

        $query = $this->esched_db->get();
        return $query->result_array();
    }

    public function assets_info_report($cnumber) {
        $this->esched_db->select('*')
                ->from(servicing_tbl)
                ->where('Controlnumber', $cnumber);

        $query = $this->esched_db->get();
        return $query->result_array();
    }

    public function getDept() {
        $this->esched_db->select('distinct(Department)')
                ->from(servicereq_vw);

        $query = $this->esched_db->get();
        return $query->result_array();
    }

    // check for job orders

    public function check_joborders($ctrls) {

        $this->esched_db->select('*')
                ->from(servicereq_vw)
                ->where('approved', '1')
                ->where('requestid', $this->security->xss_clean($ctrls));
        $query = $this->esched_db->get();
        return $query->row_array();
    }

    public function approve_joborders($ctrls) {
        $data = array(
            'approved' => $this->security->xss_clean("1"),
            'updatedby' => $this->session->userdata('empname'),
            'updated' => $this->get_current_date(),
        );

        for ($i = 0; $i < count($ctrls); $i++) {
            $this->esched_db->where('requestid', $this->security->xss_clean($ctrls[$i]));
            if ($this->esched_db->update(servicereq_vw, $data)) {
                $approved = TRUE;
            }
        }
        return $approved;
    }

    public function disapprove_joborders($ctrl) {
        $data = array(
            'approved' => $this->security->xss_clean("2"),
            'updatedby' => $this->session->userdata('empname'),
            'updated' => $this->get_current_date(),
            'note' => $this->security->xss_clean($this->input->post('b')),
        );
        for ($i = 0; $i < count($ctrl); $i++) {
            $this->esched_db->where('requestid', $this->security->xss_clean($ctrl[$i]));
            if ($this->esched_db->update(servicereq_vw, $data)) {
                $approved = TRUE;
            }
        }
        return $approved;
    }

    public function defer_joborders($ctrl) {
        $data = array(
            'approved' => $this->security->xss_clean("3"),
            'updatedby' => $this->session->userdata('empname'),
            'updated' => $this->get_current_date(),
            'note' => $this->security->xss_clean($this->input->post('b')),
        );
        for ($i = 0; $i < count($ctrl); $i++) {
            $this->esched_db->where('requestid', $this->security->xss_clean($ctrl[$i]));
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

    public function get_disapproved_joborder() {
        $order_column = array("requestid", "requestdate", "AssetType", "Department", "Complaints", "details");

        $this->esched_db->select('*')
                ->from(servicereq_vw)
                ->where('approved', '2');
        if (!empty($this->input->post("search")["value"])) {
            $this->esched_db->group_start()
                    ->like("AssetType", $this->input->post("search")["value"])
                    ->or_like("Department", $this->input->post("search")["value"])
                    ->or_like("Complaints", $this->input->post("search")["value"])
                    ->or_like("details", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->esched_db->order_by("requestdate", "DESC");
        }
    }

    function make_disapproved_joborders_datatables() {
        $this->get_disapproved_joborder();
        if ($this->input->post("length") != -1) {
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->esched_db->get();
        return $query->result();
    }

    function get_disapproved_joborders_filtered_data() {
        $this->get_disapproved_joborder();
        $query = $this->esched_db->get();
        return $query->num_rows();
    }

    public function get_disapproved_joborders_data() {

        $this->esched_db->select('*')
                ->from(servicereq_vw)
                ->where('approved', '2');

        return $this->esched_db->count_all_results();
    }

    public function get_disapproved_joborders_report() {
        $this->esched_db->select('requestid,updated,requestdate,AssetType,Department,Complaints,Details,note')
                ->from(servicereq_vw)
                ->where('approved', '2');

        $query = $this->esched_db->get();
        return $query->result_array();
    }

    /* Deferred Job Orders
     * 
     * @author Alingling
     */

    public function get_deferred_joborder() {
        $order_column = array("requestid", "requestdate", "AssetType", "Department", "Complaints", "details");

        $this->esched_db->select('*')
                ->from(servicereq_vw)
                ->where('approved', '3');
        if (!empty($this->input->post("search")["value"])) {
            $this->esched_db->group_start()
                    ->like("AssetType", $this->input->post("search")["value"])
                    ->or_like("Department", $this->input->post("search")["value"])
                    ->or_like("Complaints", $this->input->post("search")["value"])
                    ->or_like("details", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->esched_db->order_by("requestdate", "DESC");
        }
    }

    function make_deferred_joborders_datatables() {
        $this->get_deferred_joborder();
        if ($this->input->post("length") != -1) {
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->esched_db->get();
        return $query->result();
    }

    function get_deferred_joborders_filtered_data() {
        $this->get_deferred_joborder();
        $query = $this->esched_db->get();
        return $query->num_rows();
    }

    public function get_deferred_joborders_data() {
        $this->esched_db->select('*')
                ->from(servicereq_vw)
                ->where('approved', '3');

        return $this->esched_db->count_all_results();
    }

    public function get_deferred_joborders_report() {
        $this->esched_db->select('requestid,updated,requestdate,AssetType,Department,Complaints,Details,note')
                ->from(servicereq_vw)
                ->where('approved', '3');

        $query = $this->esched_db->get();
        return $query->result_array();
    }

    /* Deferred Job Orders
     * 
     * @author Alingling
     */

    public function get_approved_joborder() {
        $order_column = array("requestid", "requestdate", "AssetType", "Department", "Complaints", "details");

        $this->esched_db->select('*')
                ->from(servicereq_vw)
                ->where('approved', '1');
        if (!empty($this->input->post("search")["value"])) {
            $this->esched_db->group_start()
                    ->like("AssetType", $this->input->post("search")["value"])
                    ->or_like("Department", $this->input->post("search")["value"])
                    ->or_like("Complaints", $this->input->post("search")["value"])
                    ->or_like("details", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->esched_db->order_by("requestdate", "DESC");
        }
    }

    function make_approved_joborders_datatables() {
        $this->get_approved_joborder();
        if ($this->input->post("length") != -1) {
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->esched_db->get();
        return $query->result();
    }

    function get_approved_joborders_filtered_data() {
        $this->get_approved_joborder();
        $query = $this->esched_db->get();
        return $query->num_rows();
    }

    public function get_approved_joborders_data() {
        $this->esched_db->select('*')
                ->from(servicereq_vw)
                ->where('approved', '1');

        return $this->esched_db->count_all_results();
    }

    public function get_all_approvedjoborderbydate($s_date) {
        $order_column = array("requestid", "requestdate", "AssetType", "Department", "Complaints", "details");

        $this->esched_db->select('*')
                ->from(servicereq_vw)
                ->where('approved', '1')
                ->like('updated', $s_date);
        if (!empty($this->input->post("search")["value"])) {
            $this->esched_db->group_start()
                    ->like("AssetType", $this->input->post("search")["value"])
                    ->or_like("Department", $this->input->post("search")["value"])
                    ->or_like("Complaints", $this->input->post("search")["value"])
                    ->or_like("details", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->esched_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->esched_db->order_by("requestdate", "DESC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_all_approvedjoborderbydate_datatables($s_date) {
        $this->get_all_approvedjoborderbydate($s_date);
        if ($this->input->post("length") != -1) {
            $this->esched_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->esched_db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_all_approvedjoborderbydate_filtered_data($s_date) {
        $this->get_all_approvedjoborderbydate($s_date);
        $query = $this->esched_db->get();
        return $query->num_rows();
    }

    public function get_all_approved_joborders_data($s_date) {
        $this->esched_db->select('*')
                ->from(servicereq_vw)
                ->where('approved', '1')
                ->like('updated', $s_date);

        return $this->esched_db->count_all_results();
    }

    public function get_approved_joborders_bydate_report($s_date) {
        $this->esched_db->select('requestid,updated,requestdate,AssetType,Department,Complaints,details,note')
                ->from(servicereq_vw)
                ->where('approved', '1')
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

    public function get_daily_census_of_nhip($month) {

        $d = new DateTime('first day of this month');
        $monthnow = $d->format('m');
        $yearnow = $d->format('Y');

        $cm = new DateTime($month);
        $covermonth = $cm->format('m');
        $coveryear = $cm->format('Y');
        if ($monthnow . $yearnow === $covermonth . $coveryear) {
            $dating = $this->get_current_datex();
            $datee = new DateTime();
            $diff = date_diff($datee, $d);
            $dd = $diff->format('%r%a days');

            $data = array();
            $dates = array();

            $start_date = date('Y-m-d', strtotime($dd, strtotime($dating)));
            //echo $start_date;
            $end_date = new DateTime($dating);
            $end_date->format("Y-m-d");

            $period = new DatePeriod(
                    new DateTime($start_date), new DateInterval('P1D'), $end_date
            );


            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }
            $dates[] = $dating;
        } else {
            //   $d = new DateTime('first day of this month');
            $monthstart = date("Y-m-01", strtotime($month . "-01"));
            $monthend = date("Y-m-t", strtotime($month . "-01"));


            $d = new DateTime($monthstart);
            // $dating = $this->get_current_datex();
            $datee = new DateTime($monthend);
            $diff = date_diff($datee, $d);
            $dd = $diff->format('%r%a days');

            $data = array();
            $dates = array();

            $start_date = date('Y-m-d', strtotime($dd, strtotime($monthend)));
            //echo $start_date;
            $end_date = new DateTime($monthend);
            $end_date->format("Y-m-d");

            $period = new DatePeriod(
                    new DateTime($start_date), new DateInterval('P1D'), $end_date
            );


            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }
            $dates[] = $monthend;
        }


        for ($i = 0; $i < count($dates); $i++) {
            $this->db->select('"' . $dates[$i] . '" as datex,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                            . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                    ->from(inpatient_tbl)
                    // ->where('((admitdate <= "'.$dates[$i].'" AND discharged = 0) OR (discharged = 1 and dischadate = "'.$dates[$i].'" AND admitdate <= "'.$dates[$i].'")) and pxtype = "IPD"')
                    ->where('((admitdate < "' . $dates[$i] . '" AND discharged = 0) OR ( admitdate = "' . $dates[$i] . '")) and pxtype = "IPD"');
//                ->where('((admitdate <= "'.$dates[$i].'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$dates[$i].'" AND admitdate <= "'.$dates[$i].'")) and pxtype = "IPD"');
//                    ->where('((admitdate = "'.$dates[$i].'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$dates[$i].'" AND admitdate <= "'.$dates[$i].'")) and pxtype = "IPD"');
            // ->where('admitdate',$dates[$i])
            $query = $this->db->get();

            array_push($data, $query->row_array());
        }

        return $data;
    }

    public function get_daily_discharges($month) {

        $d = new DateTime('first day of this month');
        $monthnow = $d->format('m');
        $yearnow = $d->format('Y');

        $cm = new DateTime($month);
        $covermonth = $cm->format('m');
        $coveryear = $cm->format('Y');
        if ($monthnow . $yearnow === $covermonth . $coveryear) {
            $d = new DateTime('first day of this month');
            $dating = $this->get_current_datex();
            $datee = new DateTime();
            $diff = date_diff($datee, $d);
            $dd = $diff->format('%r%a days');

            $data = array();
            $dates = array();

            $start_date = date('Y-m-d', strtotime($dd, strtotime($dating)));
            //echo $start_date;
            $end_date = new DateTime($dating);
            $end_date->format("Y-m-d");

            $period = new DatePeriod(
                    new DateTime($start_date), new DateInterval('P1D'), $end_date
            );

            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }
            $dates[] = $dating;
        } else {
            $monthstart = date("Y-m-01", strtotime($month . "-01"));
            $monthend = date("Y-m-t", strtotime($month . "-01"));


            $d = new DateTime($monthstart);
            // $dating = $this->get_current_datex();
            $datee = new DateTime($monthend);
            $diff = date_diff($datee, $d);
            $dd = $diff->format('%r%a days');

            $data = array();
            $dates = array();

            $start_date = date('Y-m-d', strtotime($dd, strtotime($monthend)));
            //echo $start_date;
            $end_date = new DateTime($monthend);
            $end_date->format("Y-m-d");

            $period = new DatePeriod(
                    new DateTime($start_date), new DateInterval('P1D'), $end_date
            );


            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }
            $dates[] = $monthend;
        }

        for ($i = 0; $i < count($dates); $i++) {
            $this->db->select('"' . $dates[$i] . '" as datex,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                            . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                    ->from(inpatient_tbl)
                    // ->where('((admitdate <= "'.$dates[$i].'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$dates[$i].'" AND admitdate <= "'.$dates[$i].'")) and pxtype = "IPD"');
                    ->where("dischadate", $dates[$i])
                    ->where("discharged", 1)
                    ->where('pxtype', 'IPD');

            $query = $this->db->get();

            array_push($data, $query->row_array());
        }

        return $data;
    }

    public function get_authorized_bed() {
        $this->med_db->select('DOHauthorizedbed,authorizedbed')
                ->from(profile_tbl);

        $query = $this->med_db->get();
        return $query->result_array();
    }

    public function get_newborn_census($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $diff = date_diff($e, $d);
        $data['dd'] = $diff->format('%a') + 1;

        $this->db->select('sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                        . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(inpatient_tbl)
                ->where("admitdate >=", $first)
                ->where('admitdate <=', $end)
                ->where('pxtype', 'IPD')
//                ->where('((admitdate <= "'.$first.'" AND discharged = 0) OR (discharged = 1 and dischadate > "'.$end.'" AND admitdate <= "'.$first.'")) and pxtype = "IPD"')
                ->where("pat_classification = 'New Born' or pat_classification = 'newborn'");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_casecode($diagnosis) {
        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');

        $this->bms_db->select('ID,diagnosis')
                ->from(causeofconfinement_vw)
                ->where('diagnosis', $diagnosis)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where('pxtype = "IPD"');

        $query = $this->bms_db->get();

        return $query->result_array();
    }

    public function update_causeofconfinement($datas) {
        $approved = False;
        $data = array(
            'diagcateg' => $this->security->xss_clean($datas['confinename']),
        );
        for ($i = 0; $i < count($datas['controls']); $i++) {
            $cases = $this->user_model->get_casecode($datas['controls'][$i]);

            for ($j = 0; $j < count($cases); $j++) {
                $this->bms_db->where('ID', $cases[$j]["ID"]);
                if ($this->bms_db->update(confinementcauses_tbl, $data)) {
                    $approved = TRUE;
                }
            }
        }
        return $approved;
    }

    public function insert_causesofconfinement($datax) {
        $data = array(
            'causeofconfinement' => $this->security->xss_clean($datax['confinename']),
            'confinementnhip' => $this->security->xss_clean($datax['nhip']),
            'confinementnonnhip' => $this->security->xss_clean($datax['non']),
            'confinmenttotal' => $this->security->xss_clean($datax['total']),
            'updatedby' => $this->session->userdata('empname'),
            'updated' => $this->get_current_date('server')
        );
        return $this->db->insert(causesofconfinement_tbl, $data);
    }

    //PDF report
    public function get_confinement_causes_report($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->db->select('*')
                ->from(causesofconfinement_tbl)
                ->where('updated >= "' . $first . '"')
                ->where('updated <= "' . $end . '"')
                ->order_by('confinmenttotal', "DESC")
                ->limit(10);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_surgical_procedures() {
        $now = new DateTime();
        $this->db->select('*')
                ->from(surgicalvw)
                ->where('Months', $now->format("n"))
                ->where('years', $now->format("Y"))
                ->limit(10);

        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     * GEt top Total Surgical Sterilization: Mandatory Monthly Hospital Report
     * @author Alingling
     */
    public function get_total_surgical_data($month, $categ) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->db->select('sum(case when phicmembr = "non-nhip" then 1 else 0 end) non ,sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(inpatient_tbl)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where("hascateg", $categ)
                ->group_by('hascateg')
                ->limit(10);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_total_surgical_total($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->db->select('sum(nhip) nhipc, sum(nonnhip) nonc, sum(total) totalc')
                ->from(mandatotalsurgical_tbl)
                ->where('updated >= "' . $first . '"')
                ->where('updated <= "' . $end . '"')
                ->limit(10);
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * GEt Total Surgical Sterilization (for merging): Mandatory Monthly Hospital Report
     * @author Alingling
     */
    public function get_total_surgical_merge($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("hascateg", "Diag_surg", "caseno", "name", "dischadate", "phicmembr");
        $this->db->select('hascateg,Diag_surg,caseno,name,dischadate,phicmembr')
                ->from(inpatient_tbl)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where('pxtype = "IPD"')
                ->where("Diag_surg <>''");

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("hascateg", $this->input->post("search")["value"])
                    ->like("Diag_surg", $this->input->post("search")["value"])
                    ->or_like("name", $this->input->post("search")["value"])
                    ->or_like("phicmembr", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by("hascateg", "ASC");
        }
    }

    function get_total_surgical_merge_datatables($month) {
        $this->get_total_surgical_merge($month);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_total_surgical_merge_filtered_data($month) {
        $this->get_total_surgical_merge($month);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_total_surgical_merge_data($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->db->select('hascateg,Diag_surg,caseno,name,dischadate,phicmembr')
                ->from(inpatient_tbl)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where('pxtype = "IPD"')
                ->where("Diag_surg <>''")
                ->order_by("hascateg", "ASC");
        return $this->db->count_all_results();
    }

    //merge_total_surgical
    public function insert_totalsurgical($datax) {
        $data = array(
            'hascateg' => $this->security->xss_clean($datax['category']),
        );

        for ($i = 0; $i < count($datax['controls']); $i++) {
            $this->db->where('caseno', $this->security->xss_clean($datax['controls'][$i]));
            if ($this->db->update(inpatient_tbl, $data)) {
                $approved = TRUE;
            }
        }

        return $approved;
    }

    //end total surgical merge


    public function get_diagnosis_summary() {

        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');


        $this->db->select('causeofconfinement,')
                ->from(causesofconfinement_tbl)
                ->where('updated >= "' . $first . '"')
                ->where('updated <= "' . $end . '"')
                ->where("causeofconfinement <>''");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_ob_procedure($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->db->select('sum(case when phicmembr = "non-nhip" then 1 else 0 end) non ,sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(inpatient_tbl)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where("UPPER(pat_clascode)", "OBSTETRICS")
                ->where('(UPPER(obprocedure) = "CEASARIAN" OR UPPER(obprocedure) = "NORMAL")');

        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_ob_procedure_cs($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));
        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $this->db->select('sum(case when phicmembr = "non-nhip" then 1 else 0 end) non ,sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(inpatient_tbl)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where("UPPER(pat_clascode)", "OBSTETRICS")
                ->where('UPPER(obprocedure)', "CEASARIAN");

        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_cs_indications($month) {

        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');




        $this->bms_db->select('diagnosis,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non ,sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(mandatory_obprocedure_vw)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->limit(5);


        $query = $this->bms_db->get();
        return $query->result_array();
    }

    /**
     * GEt Obstetrics Procedure: Mandatory Monthly Hospital Report
     * @author Alingling
     */
    public function get_obstetric_procedure() {
        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');

        $order_column = array("diagcateg", "diagnosis", "nhip", "non");
        $this->bms_db->select('diagcateg,diagnosis, count(*) as counts,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                        . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(mandatory_obprocedure_vw)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where('pxtype = "IPD"')
                ->group_by('diagnosis');

        if (!empty($this->input->post("search")["value"])) {
            $this->bms_db->group_start()
                    ->like("diagnosis", $tlikehis->input->post("search")["value"])
                    ->or_like("diagcateg", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->bms_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->bms_db->order_by("diagnosis", "ASC");
        }
    }

    function get_obstetric_procedure_datatables() {
        $this->get_obstetric_procedure();
        if ($this->input->post("length") != -1) {
            $this->bms_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->bms_db->get();
        return $query->result();
    }

    function get_obstetric_procedure_filtered_data() {
        $this->get_obstetric_procedure();
        $query = $this->bms_db->get();
        return $query->num_rows();
    }

    public function get_obstetric_procedure_data() {
        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');

        $this->bms_db->select('diagcateg,diagnosis, count(*) as counts,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                        . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip')
                ->from(mandatory_obprocedure_vw)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where('pxtype = "IPD"')
                ->group_by('diagnosis');
        return $this->bms_db->count_all_results();
    }

    ///top ob procedure

    public function get_top_obstetric_procedure($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->db->select('categdiag,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                        . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(mandaobstetric_vw)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->group_by('refno')
                ->limit(5);


        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_casecode_ob($diagnosis) {
        $d = new DateTime('first day of this month');
        $first = $d->format('Y-m-d');

        $e = new DateTime('last day of this month');
        $end = $e->format('Y-m-d');

        $this->bms_db->select('ID,diagnosis')
                ->from(mandatory_obprocedure_vw)
                ->where('diagnosis', $diagnosis)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where('pxtype = "IPD"');

        $query = $this->bms_db->get();

        return $query->result_array();
    }

    public function update_obprocedure($datas) {
        $approved = False;
        $data = array(
            'diagcateg' => $this->security->xss_clean($datas['confinename']),
        );
        for ($i = 0; $i < count($datas['diagnosis']); $i++) {
            $cases = $this->user_model->get_casecode_ob($datas['diagnosis'][$i]);

            for ($j = 0; $j < count($cases); $j++) {
                $this->bms_db->where('ID', $cases[$j]["ID"]);
                if ($this->bms_db->update(indicationcauses_tbl, $data)) {
                    $approved = TRUE;
                }
            }
        }
        return $approved;
    }

    public function insert_obprocedure($datax) {
        $data = array(
            'indicationcause' => $this->security->xss_clean($datax['confinename']),
            'nhip' => $this->security->xss_clean($datax['nhip']),
            'nonnhip' => $this->security->xss_clean($datax['non']),
            'total' => $this->security->xss_clean($datax['total']),
            'updatedby' => $this->session->userdata('empname'),
            'updated' => $this->get_current_date('server')
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
    public function get_mortalitycases($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("categdiag", "nhip", "non");
        $this->db->select('categdiag,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                        . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(manda_mortality_vw)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->group_by('refno')
                ->limit(5);

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("categdiag", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by("totalx", "DESC");
        }
    }

    function get_mortality_cases_datatables($month) {
        $this->get_mortalitycases($month);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_mortality_cases_filtered_data($month) {
        $this->get_mortalitycases($month);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_mortality_cases_data($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->db->select('categdiag,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                        . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(manda_mortality_vw)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->group_by('refno')
                ->order_by('totalx', "DESC")
                ->limit(5);
        return $this->db->count_all_results();
    }

    public function get_mortality($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->db->select('categdiag,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                        . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(manda_mortality_vw)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->group_by('refno')
                ->order_by('totalx', "DESC")
                ->limit(5);

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     *
     * Referrals: Mandatory Monthly Hospital Report
     * @author Alingling
     * */
    public function get_referrals($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("reasonforreferral", "nhip", "non");
        $this->db->select('reasonforreferral,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                        . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(inpatient_tbl)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where('pxtype = "IPD"')
                ->where('disposition', 'Transferred/Referred')
                ->group_by('reasonforreferral')
                ->limit(5);

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("reasonforreferral", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by("totalx", "DESC");
        }
    }

    function get_referrals_datatables($month) {
        $this->get_referrals($month);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_referrals_filtered_data($month) {
        $this->get_referrals($month);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_referrals_data($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->db->select('reasonforreferral,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                        . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(inpatient_tbl)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where('pxtype = "IPD"')
                ->where('disposition', 'Transferred/Referred')
                ->group_by('reasonforreferral')
                ->order_by('totalx', "DESC")
                ->limit(5);
        return $this->db->count_all_results();
    }

    public function get_referral($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->db->select('reasonforreferral,sum(case when phicmembr = "non-nhip" then 1 else 0 end) non'
                        . ',sum(case when phicmembr = "non-nhip" then 0 else 1 end) nhip,count(*) as totalx')
                ->from(inpatient_tbl)
                ->where('dischadate >= "' . $first . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where('pxtype = "IPD"')
                ->where('disposition', 'Transferred/Referred')
                ->group_by('reasonforreferral')
                ->order_by('totalx', "DESC")
                ->limit(5);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_mandaprofile() {
        $this->med_db->select('*')
                ->from(profile_tbl);

        $query = $this->med_db->get();
        return $query->row_array();
    }

    /**
     *
     * Get Status: In Process
     * @author Alingling: 1-25-2018
     */
    public function get_inprocess_phic_accnt($date) {

        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("ageing", "total", "totalamount");

        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus', 'IN PROCESS')
                ->group_by('ageing');

        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('(case 
                               when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days aboved"
                           END)', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('aging', 'ASC');
        }
    }

    function make_inprocess_phic_accnt_datatables($date) {
        $this->get_inprocess_phic_accnt($date);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_inprocess_phic_accnt_filtered_data($date) {
        $this->get_inprocess_phic_accnt($date);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_inprocess_phic_accnt_data($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus', 'IN PROCESS')
                ->group_by('ageing')
                ->order_by('ageing', 'ASC');
        return $this->dweclaims_db->count_all_results();
    }

    /*
     * Gets all patients info for in process accounts
     * 
     * @author Alingling
     * @param string 11-27-2017
     * 
     */

    public function get_phic_inprocess_patients($date, $aging) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("PatientName", "hcifee", "profee", "dischargedate", "proc1date", "age", "pStatus", "processdate");
        $this->dweclaims_db->select('PatientName,hcifee,profee,dischargedate,proc1date,datediff(proc1date,dischargedate) as age, pStatus,processdate')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus', 'IN PROCESS')
                ->where('case 
                             when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                            when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                            when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                            when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"');
        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('PatientName', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('proc1date', 'ASC');
        }
    }

    function make_phic_inprocess_patient_datatables($date, $aging) {
        $this->get_phic_inprocess_patients($date, $aging);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_phic_inprocess_patients_filtered_data($date, $aging) {
        $this->get_phic_inprocess_patients($date, $aging);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_phic_inprocess_patients_data($date, $aging) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $this->dweclaims_db->select('PatientName,hcifee,profee,dischargedate,proc1date,datediff(proc1date,dischargedate) as age, pStatus,processdate')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus', 'IN PROCESS')
                ->where('case 
                             when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                            when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                            when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                            when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"')
                ->order_by('proc1date', 'ASC');
        return $this->dweclaims_db->count_all_results();
    }

    public function get_phic_inprocess_report($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus', 'IN PROCESS')
                ->group_by('ageing')
                ->order_by('ageing', 'ASC');
        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    /**
     *
     * Get Status: Return
     * Alingling: 1-25-2018
     */
    public function get_return_phic_accnt($date) {

        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("ageing", "total", "totalamount");

        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus', 'RETURN')
                ->group_by('ageing');

        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('(case 
                               when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days aboved"
                           END)', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('aging', 'ASC');
        }
    }

    function make_return_phic_accnt_datatables($date) {
        $this->get_return_phic_accnt($date);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_return_phic_accnt_filtered_data($date) {
        $this->get_return_phic_accnt($date);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_return_phic_accnt_data($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus', 'RETURN')
                ->group_by('ageing')
                ->order_by('ageing', 'ASC');
        return $this->dweclaims_db->count_all_results();
    }

    /*
     * Gets all patients info for return accounts
     * 
     * @author Alingling
     * @param string 11-27-2017
     * 
     */

    public function get_phic_return_patients($date, $aging) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("PatientName", "hcifee", "profee", "dischargedate", "proc1date", "age", "pStatus", "processdate");
        $this->dweclaims_db->select('PatientName,hcifee,profee,dischargedate,proc1date,datediff(proc1date,dischargedate) as age, pStatus,processdate')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus', 'RETURN')
                ->where('case 
                             when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                            when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                            when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                            when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"');
        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('PatientName', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('proc1date', 'ASC');
        }
    }

    function make_phic_return_patient_datatables($date, $aging) {
        $this->get_phic_return_patients($date, $aging);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_phic_return_patients_filtered_data($date, $aging) {
        $this->get_phic_return_patients($date, $aging);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_phic_return_patients_data($date, $aging) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->dweclaims_db->select('PatientName,hcifee,profee,dischargedate,proc1date,datediff(proc1date,dischargedate) as age, pStatus,processdate')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus', 'RETURN')
                ->where('case 
                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                ELSE "61 Days above"
                END = "' . $aging . '"')
                ->order_by('proc1date', 'ASC');

        return $this->dweclaims_db->count_all_results();
    }

    public function get_phic_return_report($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus', 'RETURN')
                ->group_by('ageing')
                ->order_by('ageing', 'ASC');
        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    /**
     *
     * Get Status: With Voucher/Voucher
     * Alingling: 1-25-2018
     */
    public function get_voucher_phic_accnt($date) {

        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("ageing", "total", "totalamount");

        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where("pStatus = 'WITH VOUCHER' and proc1date >= '" . $first . "' and proc1date <= '" . $end . "' ")
                ->or_where("pStatus = 'VOUCHER' and proc1date >= '" . $first . "' and proc1date <= '" . $end . "' ")
                ->group_by('ageing');

        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('(case 
                               when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days aboved"
                           END)', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('ageing', 'ASC');
        }
    }

    function make_voucher_phic_accnt_datatables($date) {
        $this->get_voucher_phic_accnt($date);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_voucher_phic_accnt_filtered_data($date) {
        $this->get_voucher_phic_accnt($date);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_voucher_phic_accnt_data($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where("pStatus = 'WITH VOUCHER' and proc1date >= '" . $first . "' and proc1date <= '" . $end . "' ")
                ->or_where("pStatus = 'VOUCHER' and proc1date >= '" . $first . "' and proc1date <= '" . $end . "' ")
                ->group_by('ageing')
                ->order_by('ageing', 'ASC');
        return $this->dweclaims_db->count_all_results();
    }

    /*
     * Gets all patients info for with voucher accounts
     * 
     * @author Alingling
     * @param string 11-27-2017
     * 
     */

    public function get_phic_voucher_patients($date, $aging) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("PatientName", "hcifee", "profee", "dischargedate", "proc1date", "age", "pStatus", "processdate");
        $this->dweclaims_db->select('PatientName,hcifee,profee,dischargedate,proc1date,datediff(proc1date,dischargedate) as age, pStatus,processdate')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where("pStatus = 'WITH VOUCHER' or pStatus = 'VOUCHER'")
                ->where('case 
                             when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                            when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                            when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                            when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"');
        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('PatientName', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('proc1date', 'ASC');
        }
    }

    function make_phic_voucher_patient_datatables($date, $aging) {
        $this->get_phic_voucher_patients($date, $aging);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_phic_voucher_patients_filtered_data($date, $aging) {
        $this->get_phic_voucher_patients($date, $aging);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_phic_voucher_patients_data($date, $aging) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $this->dweclaims_db->select('PatientName,hcifee,profee,dischargedate,proc1date,datediff(proc1date,dischargedate) as age, pStatus,processdate')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where("pStatus = 'WITH VOUCHER' or pStatus = 'VOUCHER'")
                ->where('case 
                             when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                            when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                            when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                            when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"')
                ->order_by('proc1date', 'ASC');
        return $this->dweclaims_db->count_all_results();
    }

    public function get_phic_voucher_report($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where("pStatus = 'WITH VOUCHER' or pStatus = 'VOUCHER'")
                ->group_by('ageing')
                ->order_by('ageing', 'ASC');

        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    /**
     *
     * Get Status: Denied
     * Alingling: 1-25-2018
     */
    public function get_denied_phic_accnt($date) {

        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("ageing", "total", "totalamount");

        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where("pStatus = 'DENIED'")
                ->group_by('ageing');

        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('(case 
                               when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days aboved"
                           END)', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('ageing', 'ASC');
        }
    }

    function make_denied_phic_accnt_datatables($date) {
        $this->get_denied_phic_accnt($date);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_denied_phic_accnt_filtered_data($date) {
        $this->get_denied_phic_accnt($date);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_denied_phic_accnt_data($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where("pStatus = 'DENIED'")
                ->group_by('ageing')
                ->order_by('ageing', 'ASC');
        return $this->dweclaims_db->count_all_results();
    }

    public function get_phic_denied_report($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where("pStatus = 'DENIED'")
                ->group_by('ageing')
                ->order_by('ageing', 'ASC');

        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    /*
     * Gets all patients info for with denied accounts
     * 
     * @author Alingling
     * @param string 11-27-2017
     * 
     */

    public function get_phic_denied_patients($date, $aging) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("PatientName", "hcifee", "profee", "dischargedate", "proc1date", "age", "pStatus", "processdate");
        $this->dweclaims_db->select('PatientName,hcifee,profee,dischargedate,proc1date,datediff(proc1date,dischargedate) as age, pStatus,processdate')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where("pStatus = 'DENIED'")
                ->where('case 
                             when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                            when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                            when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                            when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"');
        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('PatientName', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('proc1date', 'ASC');
        }
    }

    function make_phic_denied_patient_datatables($date, $aging) {
        $this->get_phic_denied_patients($date, $aging);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_phic_denied_patients_filtered_data($date, $aging) {
        $this->get_phic_denied_patients($date, $aging);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_phic_denied_patients_data($date, $aging) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $this->dweclaims_db->select('PatientName,hcifee,profee,dischargedate,proc1date,datediff(proc1date,dischargedate) as age, pStatus,processdate')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where("pStatus = 'DENIED'")
                ->where('case 
                    when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                    when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                    when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                    when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                    ELSE "61 Days above"
                    END = "' . $aging . '"')
                ->order_by('proc1date', 'ASC');

        return $this->dweclaims_db->count_all_results();
    }

    /**
     *
     * Get Status: With Check
     * Alingling: 6-26-2018
     */
    public function get_check_phic_accnt($date) {

        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("ageing", "total", "totalamount");

        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where("pStatus = 'WITH CHEQUE'")
                ->group_by('ageing');

        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('(case 
                               when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days aboved"
                           END)', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('ageing', 'ASC');
        }
    }

    function make_check_phic_accnt_datatables($date) {
        $this->get_check_phic_accnt($date);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_check_phic_accnt_filtered_data($date) {
        $this->get_check_phic_accnt($date);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_check_phic_accnt_data($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->dweclaims_db->select('case 
                                when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                                when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                                when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                                when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                                ELSE "61 Days above"
                            END as ageing,count(*) as total,sum(grandtotal) as totalamount')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where("pStatus = 'WITH CHEQUE'")
                ->group_by('ageing')
                ->order_by('ageing', 'ASC');
        return $this->dweclaims_db->count_all_results();
    }

    /*
     * Gets all patients info for with check accounts
     * 
     * @author Alingling
     * @param string 6.26.2018
     * 
     */

    public function get_phic_check_patients($date, $aging) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("PatientName", "hcifee", "profee", "dischargedate", "proc1date", "age", "pStatus", "processdate");
        $this->dweclaims_db->select('PatientName,hcifee,profee,dischargedate,proc1date,datediff(proc1date,dischargedate) as age, pStatus,processdate')->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where("pStatus = 'WITH CHEQUE'")
                ->where('case 
                             when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                            when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                            when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                            when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                            ELSE "61 Days above"
                            END = "' . $aging . '"');
        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('PatientName', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('proc1date', 'ASC');
        }
    }

    function make_phic_check_patient_datatables($date, $aging) {
        $this->get_phic_check_patients($date, $aging);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_phic_check_patients_filtered_data($date, $aging) {
        $this->get_phic_check_patients($date, $aging);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_phic_check_patients_data($date, $aging) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $this->dweclaims_db->select('PatientName,hcifee,profee,dischargedate,proc1date,datediff(proc1date,dischargedate) as age, pStatus,processdate')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where("pStatus = 'WITH CHEQUE'")
                ->where('case 
                    when  datediff(proc1date,dischargedate) <= 15 THEN "1-15 Days"
                    when  datediff(proc1date,dischargedate) <= 30 THEN "16-30 Days"
                    when  datediff(proc1date,dischargedate) <= 45 THEN "31-45 Days"
                    when  datediff(proc1date,dischargedate) <= 60 THEN "46-60 Days"
                    ELSE "61 Days above"
                    END = "' . $aging . '"')
                ->order_by('proc1date', 'ASC');
        return $this->dweclaims_db->count_all_results();
    }

    /*
     * Gets all patients info for HMO as of date
     * 
     * @author Alingling
     * @param string 11-27-2017
     * 
     */

    public function get_hmo_asofdate_patients($start_date, $end_date, $hmocode = NULL) {

        $d = new DateTime($start_date);
        $start = $d->format('Y-m-d');
        $e = new DateTime($end_date);
        $end = $e->format('Y-m-d');

        $order_column = array("casecodex", "pxtype", "patientname", "discha", "hmoname", "ACTUALHOSP", "PHICHOSP", "HMOHOSP", "ACTUALPF", "PHICPF", "HMOPF");
        $this->db->select("pxtype,(casecode) as casecodex,patientname,concat(dischadate,' ',dischatime) as discha ,hmoname, 
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start2 <> 'MI' and Start2 <> 'PD' and Start2 <> 'PF' and casecode = casecodex) as ACTUALHOSP,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start4 = 'PDPP' and casecode = casecodex ) as PHICHOSP,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start2 = 'MI' and Start4 <> 'MIMD' and casecode = casecodex) as HMOHOSP,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start4 = 'PFMD' and casecode = casecodex) as ACTUALPF,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start2 = 'PD' and Start4 <> 'PDPP' and casecode = casecodex) as PHICPF,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start4 = 'MIMD' and casecode = casecodex) as HMOPF")
                ->from(inpatient_ipd_vw)
                ->where('dischadate >= "' . $start . '"')
                ->where('dischadate <= "' . $end . '"');
        if ($hmocode !== NULL && $hmocode !== "All") {
            $this->db->where('hmocode', $hmocode);
        }
        $this->db->group_by('casecodex');
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('pxtype', $this->input->post("search")["value"])
                    ->or_like('patientname', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('patientname', 'ASC');
        }
    }

    function make_hmo_asofdate_patients_datatables($start_date, $end_date, $hmocode = NULL) {
        $this->get_hmo_asofdate_patients($start_date, $end_date, $hmocode);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_hmo_asofdate_patients_filtered_data($start_date, $end_date, $hmocode = NULL) {
        $this->get_hmo_asofdate_patients($start_date, $end_date, $hmocode);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_hmo_asofdate_patients_data($start_date, $end_date, $hmocode = NULL) {
        $d = new DateTime($start_date);
        $start = $d->format('Y-m-d');
        $e = new DateTime($end_date);
        $end = $e->format('Y-m-d');

        $this->db->select("pxtype,(casecode) as casecodex,patientname,concat(dischadate,' ',dischatime) as discha ,hmoname, 
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start2 <> 'MI' and Start2 <> 'PD' and Start2 <> 'PF' and casecode = casecodex) as ACTUALHOSP,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start4 = 'PDPP' and casecode = casecodex ) as PHICHOSP,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start2 = 'MI' and Start4 <> 'MIMD' and casecode = casecodex) as HMOHOSP,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start4 = 'PFMD' and casecode = casecodex) as ACTUALPF,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start2 = 'PD' and Start4 <> 'PDPP' and casecode = casecodex) as PHICPF,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start4 = 'MIMD' and casecode = casecodex) as HMOPF")
                ->from(inpatient_ipd_vw)
                ->where('dischadate >= "' . $start . '"')
                ->where('dischadate <= "' . $end . '"');
//                 ->where("Start2 = 'MI'");
//                      ->where("dischadate BETWEEN '2017-09-01' and '2017-09-02'")
        if ($hmocode !== NULL && $hmocode !== "All") {
            $this->db->where('hmocode', $hmocode);
        }
        $this->db->group_by('casecodex');
        $this->db->order_by('patientname', 'ASC');

        return $this->db->count_all_results();
    }

    public function generate_HMO_asof_date_report($start_date, $end_date, $hmocode) {

        $d = new DateTime($start_date);
        $start = $d->format('Y-m-d');
        $e = new DateTime($end_date);
        $end = $e->format('Y-m-d');

        $this->db->select("pxtype,(casecode) as casecodex,patientname,concat(dischadate,' ',dischatime) as discha ,hmoname, 
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start2 <> 'MI' and Start2 <> 'PD' and Start2 <> 'PF' and casecode = casecodex) as ACTUALHOSP,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start4 = 'PDPP' and casecode = casecodex ) as PHICHOSP,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start2 = 'MI' and Start4 <> 'MIMD' and casecode = casecodex) as HMOHOSP,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start4 = 'PFMD' and casecode = casecodex) as ACTUALPF,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start2 = 'PD' and Start4 <> 'PDPP' and casecode = casecodex) as PHICPF,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start4 = 'MIMD' and casecode = casecodex) as HMOPF")
                ->from(inpatient_ipd_vw)
                ->where('dischadate >= "' . $start . '"')
                ->where('dischadate <= "' . $end . '"');
//                 ->where("Start2 = 'MI'");
//                      ->where("dischadate BETWEEN '2017-09-01' and '2017-09-02'")
        if ($hmocode !== NULL && $hmocode !== "All") {
            $this->db->where('hmocode', $hmocode);
        }
        $this->db->group_by('casecodex');
        $this->db->order_by('patientname', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_patients_hmo($casecode) {
        $order_column = array("hmoname", "hmocredit", "hmoapprovaldate", "priorityno", "hmocardholder", "hmocardno");
        $this->db->select("hmoname,hmocredit,hmoapprovaldate,priorityno,hmocardholder,hmocardno")
                ->from(hmomasterlist_tbl)
                ->where('acctcode', $casecode);
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('hmoname', $this->input->post("search")["value"])
                    ->or_like('priorityno', $this->input->post("search")["value"])
                    ->or_like('hmocardholder', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('priorityno', 'ASC');
        }
    }

    function make_patients_hmo_datatables($casecode) {
        $this->get_patients_hmo($casecode);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_patients_hmo_filtered_data($casecode) {
        $this->get_patients_hmo($casecode);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_patients_hmo_data($casecode) {
        $this->db->select("hmoname,hmocredit,hmoapprovaldate,priorityno,hmocardholder,hmocardno")
                ->from(hmomasterlist_tbl)
                ->where('acctcode', $casecode)
                ->order_by('priorityno', 'ASC');
        return $this->db->count_all_results();
    }

    //
    public function get_hmo_list($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
//        SELECT hmoname,count(patientname) as patientcount FROM `hmo_hmomasterlist` group by hmorefno order by hmoname ASC;
        $order_column = array("hmocode", "hmoname", "patientcount");
        $this->db->select("hmocode,hmoname,count(patientname) as patientcount")
                ->from(hmo_hmomasterlist_vw)
                ->where('admitdate >= "' . $first . '"')
                ->where('admitdate <= "' . $end . '"')
                ->group_by('hmocode');
//                ->where('admitdate '$casecode);
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('hmoname', $this->input->post("search")["value"])
                    ->or_like('priorityno', $this->input->post("search")["value"])
                    ->or_like('hmocardholder', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('hmoname', 'ASC');
        }
    }

    function make_hmo_list_datatables($date) {
        $this->get_hmo_list($date);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_hmo_list_filtered_data($date) {
        $this->get_hmo_list($date);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_hmo_list_data($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->db->select("hmocode,hmoname,count(patientname) as patientcount")
                ->from(hmo_hmomasterlist_vw)
                ->where('admitdate >= "' . $first . '"')
                ->where('admitdate <= "' . $end . '"')
                ->group_by('hmocode')
                ->order_by('hmoname', 'ASC');
        return $this->db->count_all_results();
    }

    //alingling
    public function get_hmolist_patients($date, $hmocode) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
//        SELECT hmoname,count(patientname) as patientcount FROM `hmo_hmomasterlist` group by hmorefno order by hmoname ASC;
        $order_column = array("caseno", "patientname", "admission", "hmocredit");
        $this->db->select("caseno,patientname,concat(admitdate,' ',admittime) as admission, hmocredit")
                ->from(hmo_hmomasterlist_vw)
                ->where('admitdate >= "' . $first . '"')
                ->where('admitdate <= "' . $end . '"')
                ->where('hmocode', $hmocode);

//                ->where('admitdate '$casecode);
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('hmoname', $this->input->post("search")["value"])
                    ->or_like('priorityno', $this->input->post("search")["value"])
                    ->or_like('hmocardholder', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('patientname', 'ASC');
        }
    }

    function make_hmolist_patient_datatables($date, $hmocode) {
        $this->get_hmolist_patients($date, $hmocode);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_hmolist_patient_filtered_data($date, $hmocode) {
        $this->get_hmolist_patients($date, $hmocode);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_hmolist_patient_data($date, $hmocode) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->db->select("caseno,patientname,concat(admitdate,' ',admittime) as admission, hmocredit")
                ->from(hmo_hmomasterlist_vw)
                ->where('admitdate >= "' . $first . '"')
                ->where('admitdate <= "' . $end . '"')
                ->where('hmocode', $hmocode)
                ->order_by('patientname', 'ASC');
        return $this->db->count_all_results();
    }

    public function getallhmo() {
        $this->db->select("hmoname,hmorefno")
                ->from(hmo_tbl)
                ->order_by('hmoname', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     * Gets all patients info for HMO account only
     * 
     * @author Alingling
     * @param string 11-27-2017
     * 
     */

    public function get_hmo_acct_patients($start_date, $end_date, $hmocode = NULL) {
        $d = new DateTime($start_date);
        $start = $d->format('Y-m-d');
        $e = new DateTime($end_date);
        $end = $e->format('Y-m-d');


        $order_column = array("casecodex", "pxtype", "patientname", "discha", "hmoname", "HMOHOSP", "HMOPF");
        $this->db->select("pxtype,(casecode) as casecodex,patientname,concat(dischadate,' ',dischatime) as discha ,hmoname,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start2 = 'MI' and Start4 <> 'MIMD' and casecode = casecodex) as HMOHOSP,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start4 = 'MIMD' and casecode = casecodex) as HMOPF")
                ->from(inpatient_ipd_vw)
                ->where('dischadate >= "' . $start . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where("Start2 = 'MI'");
//                      ->where("dischadate BETWEEN '2017-09-01' and '2017-09-02'")
        if ($hmocode !== NULL && $hmocode !== "All") {
            $this->db->where('hmocode', $hmocode);
        }
        $this->db->group_by('casecodex');
        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('pxtype', $this->input->post("search")["value"])
                    ->or_like('patientname', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('dischadate', 'ASC');
        }
    }

    function make_hmo_acct_patients_datatables($start_date, $end_date, $hmocode = NULL) {
        $this->get_hmo_acct_patients($start_date, $end_date, $hmocode);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_hmo_acct_patients_filtered_data($start_date, $end_date, $hmocode = NULL) {
        $this->get_hmo_acct_patients($start_date, $end_date, $hmocode);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_hmo_acct_patients_data($start_date, $end_date, $hmocode = NULL) {

        $d = new DateTime($start_date);
        $start = $d->format('Y-m-d');
        $e = new DateTime($end_date);
        $end = $e->format('Y-m-d');

        $this->db->select("pxtype,(casecode) as casecodex,patientname,concat(dischadate,' ',dischatime) as discha ,hmoname,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start2 = 'MI' and Start4 <> 'MIMD' and casecode = casecodex) as HMOHOSP,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start4 = 'MIMD' and casecode = casecodex) as HMOPF")
                ->from(inpatient_ipd_vw)
                ->where('dischadate >= "' . $start . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where("Start2 = 'MI'");
//                      ->where("dischadate BETWEEN '2017-09-01' and '2017-09-02'")
        if ($hmocode !== NULL && $hmocode !== "All") {
            $this->db->where('hmocode', $hmocode);
        }
        $this->db->group_by('casecodex');
        $this->db->order_by('dischadate', 'ASC');

        return $this->db->count_all_results();
    }

    public function generate_HMO_acct_report($start_date, $end_date, $hmocode) {
        $d = new DateTime($start_date);
        $start = $d->format('Y-m-d');
        $e = new DateTime($end_date);
        $end = $e->format('Y-m-d');


        $this->db->select("pxtype,(casecode) as casecodex,patientname,concat(dischadate,' ',dischatime) as discha ,hmoname,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start2 = 'MI' and Start4 <> 'MIMD' and casecode = casecodex) as HMOHOSP,
            (select sum(totalamt) FROM " . inpatient_ipd_vw . " where Start4 = 'MIMD' and casecode = casecodex) as HMOPF")
                ->from(inpatient_ipd_vw)
                ->where('dischadate >= "' . $start . '"')
                ->where('dischadate <= "' . $end . '"')
                ->where("Start2 = 'MI'");
        if ($hmocode !== NULL && $hmocode !== "All") {
            $this->db->where('hmocode', $hmocode);
        }
        $this->db->group_by('casecodex');
        $this->db->order_by('dischadate', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_alldoctors() {

        $this->db->select("docname,docrefno")
                ->from(doctors_tbl)
                ->order_by('doclname', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_expertise() {
        $this->db->select("expertise")
                ->from(doctors_tbl)
                ->group_by('expertise')
                ->order_by('expertise', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     * Get information from the classification
     * 
     */

    public function get_all_doctors_patients($s_date, $e_date, $doccode) {
        $order_column = array("name", "admit", "discharge", "phicmembr");
        $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge,phicmembr')
                ->from(inpatient_tbl)
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD')
                ->where('doctorid', $doccode);




        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("name", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('dischadate', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_all_doctors_patients_datatables($s_date, $e_date, $doccode) {
        $this->get_all_doctors_patients($s_date, $e_date, $doccode);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_all_doctors_patients_filtered_data($s_date, $e_date, $doccode) {
        $this->get_all_doctors_patients($s_date, $e_date, $doccode);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_all_doctors_patients_data($s_date, $e_date, $doccode) {
        $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge,doctorname,phicmembr')
                ->from(inpatient_tbl)
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD')
                ->where('doctorid', $doccode)
                ->order_by('dischadate', 'ASC');

        return $this->db->count_all_results();
    }

    public function get_doctors_patient_report($s_date, $e_date, $doccode) {
        $this->db->select('name, concat(admitdate," ",admittime) as admit, concat(dischadate," ",dischatime) as discharge,doctorname,phicmembr')
                ->from(inpatient_tbl)
                ->where('dischadate BETWEEN "' . $s_date . '" and "' . $e_date . '"')
                ->where('discharged', '1')
                ->where('pxtype', 'IPD')
                ->where('doctorid', $doccode)
                ->order_by('dischadate', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_med_frequency($code, $monthdate) {
        $data = array();
        $dates = array();

        $start_date = date('Y-m-d', strtotime("-5 months", strtotime($monthdate)));

        $end_date = new DateTime($monthdate);
        $end_date->format("Y-m-d");

        $period = new DatePeriod(
                new DateTime($start_date), new DateInterval('P1M'), $end_date
        );


        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        $dates[] = $monthdate;
        $d = count($dates);


        for ($i = 0; $i < count($dates); $i++) {
            $datexx = $this->get_yearmonths($dates[$i]);
            $this->pms_db->select('"' . $datexx . '" as datex, sum(qty) as qty')
                    ->from(inventoryend_tbl)
                    ->where('prodid', $code)
                    ->where('YEAR(enddate) = YEAR("' . $dates[$i] . '")')
                    ->where('MONTH(enddate) = MONTH("' . $dates[$i] . '")');
            $query = $this->pms_db->get();

            array_push($data, $query->row_array());
        }

        return $data;
    }

    public function get_med_frequency1($code, $dept, $transtype, $monthdate) {
        $data = array();
        $dates = array();

        $start_date = date('Y-m-d', strtotime("-5 months", strtotime($monthdate)));

        $end_date = new DateTime($monthdate);
        $end_date->format("Y-m-d");

        $period = new DatePeriod(
                new DateTime($start_date), new DateInterval('P1M'), $end_date
        );


        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        $dates[] = $monthdate;
        $d = count($dates);


        for ($i = 0; $i < count($dates); $i++) {
            $monthstart = date("Y-m-01", strtotime($dates[$i] . "-01"));
            $monthend = date("Y-m-t", strtotime($dates[$i] . "-01"));

            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e = new DateTime($monthend);
            $end = $e->format('Y-m-d');

            if ($dept == "PH") {
                $datexx = $this->get_yearmonths($dates[$i]);
                $this->pms_db->select('"' . $datexx . '" as datex, sum(qty) as qty')
                        ->from(ledgersales_tbl)
                        ->where('prodid', $code)
                        ->where('tdate >= "' . $first . '"')
                        ->where('tdate <= "' . $end . '"');
                $query = $this->pms_db->get();
                array_push($data, $query->row_array());
            } else if ($dept == "LT") {
                $datexx = $this->get_yearmonths($dates[$i]);
                $this->hls_db->select('"' . $datexx . '" as datex, sum(qty) as qty')
                        ->from(ledgersales_tbl)
                        ->where('prodid', $code)
                        ->where('tdate >= "' . $first . '"')
                        ->where('tdate <= "' . $end . '"');
                if ($transtype == "Delivery") {
                    $this->hls_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
                }
                $query = $this->hls_db->get();
                array_push($data, $query->row_array());
            } else if ($dept == "CS") {
                $datexx = $this->get_yearmonths($dates[$i]);
                $this->csr_db->select('"' . $datexx . '" as datex, sum(qty) as qty')
                        ->from(ledgersales_tbl)
                        ->where('prodid', $code)
                        ->where('tdate >= "' . $first . '"')
                        ->where('tdate <= "' . $end . '"');
                if ($transtype == "Delivery") {
                    $this->csr_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
                }
                $query = $this->csr_db->get();
                array_push($data, $query->row_array());
            } else if ($dept == "RT" || $dept == "US") {
                $datexx = $this->get_yearmonths($dates[$i]);
                $this->hrs_db->select('"' . $datexx . '" as datex, sum(qty) as qty')
                        ->from(ledgersales_tbl)
                        ->where('prodid', $code)
                        ->where('tdate >= "' . $first . '"')
                        ->where('tdate <= "' . $end . '"');
                if ($transtype == "Delivery") {
                    $this->hrs_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
                }
                $query = $this->hrs_db->get();
                array_push($data, $query->row_array());
            } else {
                $datexx = $this->get_yearmonths($dates[$i]);
                $this->bms_db->select('"' . $datexx . '" as datex, sum(qty) as qty')
                        ->from(ledgersales_tbl)
                        ->where('prodid', $code)
                        ->where('tdate >= "' . $first . '"')
                        ->where('tdate <= "' . $end . '"');
                if ($transtype == "Delivery") {
                    $this->bms_db->where('(transactiontype = "DELIVERY" OR transactiontype = "DELIVRET")');
                }
                $query = $this->bms_db->get();
                array_push($data, $query->row_array());
            }
        }

        return $data;
    }

    /*
     * Get pharmacy inventory
     * 
     */

    public function get_inventory_monitoring($start_date) {

        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $order_column = array("groupname", null, "beginningbalance", "beginningcost", "purchaseqty",
            "purchasescost", "adjustqty", "adjustcost", "salesqty", "salescost", "endingbalance", "endingcost");
        $this->pms_db->select(' groupname, 
                            sum(begbalance) as beginningbalance, 
                            sum(begCost) as beginningcost,  
                            sum(purchasesqty) as purchaseqty,
                            sum( purchasesamt)as purchasescost, 
                            sum(adjustQty) as adjustqty, 
                            sum(adjustCost) as adjustcost, 
                            sum(qty) as salesqty, 
                            sum(totalamount) as salescost, 
                            sum(endbalance) as endingbalance, 
                            sum(endCost) as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->group_by('groupname');




        if (!empty($this->input->post("search")["value"])) {
            $this->pms_db->group_start()
                    ->like("name", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->pms_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->pms_db->order_by('groupname', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_inventory_monitoring_datatables($start_date) {
        $this->get_inventory_monitoring($start_date);
        if ($this->input->post("length") != -1) {
            $this->pms_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->pms_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_inventory_monitoring_filtered_data($start_date) {
        $this->get_inventory_monitoring($start_date);
        $query = $this->pms_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_inventory_monitoring_data($start_date) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->pms_db->select(' groupname, 
                            sum(begbalance) as beginningbalance, 
                            sum(begCost) as beginningcost,  
                            sum(purchasesqty) as purchaseqty,
                            sum( purchasesamt)as purchasescost, 
                            sum(adjustQty) as adjustqty, 
                            sum(adjustCost) as adjustcost, 
                            sum(qty) as salesqty, 
                            sum(totalamount) as salescost, 
                            sum(endbalance) as endingbalance, 
                            sum(endCost) as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->group_by('groupname')
                ->order_by('groupname', 'ASC');

        return $this->pms_db->count_all_results();
    }

    public function generate_inventory_monitoring_report($start_date) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->pms_db->select(' groupname, 
                            sum(begbalance) as beginningbalance, 
                            sum(begCost) as beginningcost,  
                            sum(purchasesqty) as purchaseqty,
                            sum( purchasesamt)as purchasescost, 
                            sum(adjustQty) as adjustqty, 
                            sum(adjustCost) as adjustcost, 
                            sum(qty) as salesqty, 
                            sum(totalamount) as salescost, 
                            sum(endbalance) as endingbalance, 
                            sum(endCost) as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->group_by('groupname')
                ->order_by('groupname', 'ASC');

        $query = $this->pms_db->get();
        return $query->result_array();
    }

    /*
     * Get pharmacy inventory by groupname
     * 
     */

    public function get_inventory_monitoring_group($start_date, $groupname) {

        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $order_column = array("dscr", "unitprice", "beginningbalance", "beginningcost", "purchaseqty",
            "purchasescost", "adjustqty", "adjustcost", "salesqty", "salescost", "endingbalance", "endingcost");
        $this->pms_db->select(' dscr, unitprice,
                            begbalance as beginningbalance, 
                            begCost as beginningcost,  
                           purchasesqty as purchaseqty,
                            purchasesamt as purchasescost, 
                            adjustQty as adjustqty, 
                            adjustCost as adjustcost, 
                            qty as salesqty, 
                            totalamount as salescost, 
                            endbalance as endingbalance, 
                            endCost as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('groupname', $groupname);





        if (!empty($this->input->post("search")["value"])) {
            $this->pms_db->group_start()
                    ->like("dscr", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->pms_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->pms_db->order_by('dscr', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_inventory_monitoring_group_datatables($start_date, $groupname) {
        $this->get_inventory_monitoring_group($start_date, $groupname);
        if ($this->input->post("length") != -1) {
            $this->pms_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->pms_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_inventory_monitoring_group_filtered_data($start_date, $groupname) {
        $this->get_inventory_monitoring_group($start_date, $groupname);
        $query = $this->pms_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_inventory_monitoring_group_data($start_date, $groupname) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->pms_db->select(' dscr, unitprice,
                            begbalance as beginningbalance, 
                            begCost as beginningcost,  
                           purchasesqty as purchaseqty,
                            purchasesamt as purchasescost, 
                            adjustQty as adjustqty, 
                            adjustCost as adjustcost, 
                            qty as salesqty, 
                            totalamount as salescost, 
                            endbalance as endingbalance, 
                            endCost as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('groupname', $groupname)
                ->order_by('dscr', 'ASC');

        return $this->pms_db->count_all_results();
    }

    /*
     * Get laboratory inventory
     * 
     */

    public function get_rad_inventory_monitoring($start_date) {

        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $order_column = array("groupname", null, "beginningbalance", "beginningcost", "purchaseqty",
            "purchasescost", "adjustqty", "adjustcost", "salesqty", "salescost", "endingbalance", "endingcost");
        $this->hrs_db->select(' groupname, 
                            sum(begbalance) as beginningbalance, 
                            sum(begCost) as beginningcost,  
                            sum(purchasesqty) as purchaseqty,
                            sum( purchasesamt)as purchasescost, 
                            sum(adjustQty) as adjustqty, 
                            sum(adjustCost) as adjustcost, 
                            sum(qty) as salesqty, 
                            sum(totalamount) as salescost, 
                            sum(endbalance) as endingbalance, 
                            sum(endCost) as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->group_by('groupname');




        if (!empty($this->input->post("search")["value"])) {
            $this->hrs_db->group_start()
                    ->like("name", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->hrs_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->hrs_db->order_by('groupname', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_rad_inventory_monitoring_datatables($start_date) {
        $this->get_rad_inventory_monitoring($start_date);
        if ($this->input->post("length") != -1) {
            $this->hrs_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hrs_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_rad_inventory_monitoring_filtered_data($start_date) {
        $this->get_rad_inventory_monitoring($start_date);
        $query = $this->hrs_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_rad_inventory_monitoring_data($start_date) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->hrs_db->select(' groupname, 
                            sum(begbalance) as beginningbalance, 
                            sum(begCost) as beginningcost,  
                            sum(purchasesqty) as purchaseqty,
                            sum( purchasesamt)as purchasescost, 
                            sum(adjustQty) as adjustqty, 
                            sum(adjustCost) as adjustcost, 
                            sum(qty) as salesqty, 
                            sum(totalamount) as salescost, 
                            sum(endbalance) as endingbalance, 
                            sum(endCost) as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->group_by('groupname')
                ->order_by('groupname', 'ASC');

        return $this->hrs_db->count_all_results();
    }

    /*
     * Get pharmacy inventory by groupname
     * 
     */

    public function get_inventory_monitoring_rad_group($start_date, $groupname) {

        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $order_column = array("dscr", "unitprice", "beginningbalance", "beginningcost", "purchaseqty",
            "purchasescost", "adjustqty", "adjustcost", "salesqty", "salescost", "endingbalance", "endingcost");
        $this->hrs_db->select(' dscr, unitprice,
                            begbalance as beginningbalance, 
                            begCost as beginningcost,  
                           purchasesqty as purchaseqty,
                            purchasesamt as purchasescost, 
                            adjustQty as adjustqty, 
                            adjustCost as adjustcost, 
                            qty as salesqty, 
                            totalamount as salescost, 
                            endbalance as endingbalance, 
                            endCost as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('groupname', $groupname);





        if (!empty($this->input->post("search")["value"])) {
            $this->hrs_db->group_start()
                    ->like("dscr", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->hrs_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->hrs_db->order_by('dscr', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_inventory_monitoring_rad_group_datatables($start_date, $groupname) {
        $this->get_inventory_monitoring_rad_group($start_date, $groupname);
        if ($this->input->post("length") != -1) {
            $this->hrs_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hrs_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_inventory_monitoring_rad_group_filtered_data($start_date, $groupname) {
        $this->get_inventory_monitoring_rad_group($start_date, $groupname);
        $query = $this->hrs_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_inventory_monitoring_rad_group_data($start_date, $groupname) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->hrs_db->select(' dscr, unitprice,
                            begbalance as beginningbalance, 
                            begCost as beginningcost,  
                           purchasesqty as purchaseqty,
                            purchasesamt as purchasescost, 
                            adjustQty as adjustqty, 
                            adjustCost as adjustcost, 
                            qty as salesqty, 
                            totalamount as salescost, 
                            endbalance as endingbalance, 
                            endCost as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('groupname', $groupname)
                ->order_by('dscr', 'ASC');

        return $this->hrs_db->count_all_results();
    }

    /*
     * Get pharmacy inventory by groupname
     * 
     */

    public function get_inventory_monitoring_lab_group($start_date, $groupname) {

        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $order_column = array("dscr", "unitprice", "beginningbalance", "beginningcost", "purchaseqty",
            "purchasescost", "adjustqty", "adjustcost", "salesqty", "salescost", "endingbalance", "endingcost");
        $this->hls_db->select(' dscr, unitprice,
                            begbalance as beginningbalance, 
                            begCost as beginningcost,  
                           purchasesqty as purchaseqty,
                            purchasesamt as purchasescost, 
                            adjustQty as adjustqty, 
                            adjustCost as adjustcost, 
                            qty as salesqty, 
                            totalamount as salescost, 
                            endbalance as endingbalance, 
                            endCost as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('groupname', $groupname);





        if (!empty($this->input->post("search")["value"])) {
            $this->hls_db->group_start()
                    ->like("dscr", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->hls_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->hls_db->order_by('dscr', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_inventory_monitoring_lab_group_datatables($start_date, $groupname) {
        $this->get_inventory_monitoring_lab_group($start_date, $groupname);
        if ($this->input->post("length") != -1) {
            $this->hls_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hls_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_inventory_monitoring_lab_group_filtered_data($start_date, $groupname) {
        $this->get_inventory_monitoring_lab_group($start_date, $groupname);
        $query = $this->hls_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_inventory_monitoring_lab_group_data($start_date, $groupname) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->hls_db->select(' dscr, unitprice,
                            begbalance as beginningbalance, 
                            begCost as beginningcost,  
                           purchasesqty as purchaseqty,
                            purchasesamt as purchasescost, 
                            adjustQty as adjustqty, 
                            adjustCost as adjustcost, 
                            qty as salesqty, 
                            totalamount as salescost, 
                            endbalance as endingbalance, 
                            endCost as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('groupname', $groupname)
                ->order_by('dscr', 'ASC');

        return $this->hls_db->count_all_results();
    }

    /*
     * Get laboratory inventory
     * 
     */

    public function get_lab_inventory_monitoring($start_date) {

        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $order_column = array("groupname", null, "beginningbalance", "beginningcost", "purchaseqty",
            "purchasescost", "adjustqty", "adjustcost", "salesqty", "salescost", "endingbalance", "endingcost");
        $this->hls_db->select(' groupname, 
                            sum(begbalance) as beginningbalance, 
                            sum(begCost) as beginningcost,  
                            sum(purchasesqty) as purchaseqty,
                            sum( purchasesamt)as purchasescost, 
                            sum(adjustQty) as adjustqty, 
                            sum(adjustCost) as adjustcost, 
                            sum(qty) as salesqty, 
                            sum(totalamount) as salescost, 
                            sum(endbalance) as endingbalance, 
                            sum(endCost) as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->group_by('groupname');




        if (!empty($this->input->post("search")["value"])) {
            $this->hls_db->group_start()
                    ->like("name", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->hls_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->hls_db->order_by('groupname', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_lab_inventory_monitoring_datatables($start_date) {
        $this->get_lab_inventory_monitoring($start_date);
        if ($this->input->post("length") != -1) {
            $this->hls_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hls_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_lab_inventory_monitoring_filtered_data($start_date) {
        $this->get_lab_inventory_monitoring($start_date);
        $query = $this->hls_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_lab_inventory_monitoring_data($start_date) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->hls_db->select(' groupname, 
                            sum(begbalance) as beginningbalance, 
                            sum(begCost) as beginningcost,  
                            sum(purchasesqty) as purchaseqty,
                            sum( purchasesamt)as purchasescost, 
                            sum(adjustQty) as adjustqty, 
                            sum(adjustCost) as adjustcost, 
                            sum(qty) as salesqty, 
                            sum(totalamount) as salescost, 
                            sum(endbalance) as endingbalance, 
                            sum(endCost) as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->group_by('groupname')
                ->order_by('groupname', 'ASC');

        return $this->hls_db->count_all_results();
    }

    /*
     * Get laboratory inventory
     * 
     */

    public function get_csr_inventory_monitoring($start_date) {

        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $order_column = array("groupname", null, "beginningbalance", "beginningcost", "purchaseqty",
            "purchasescost", "adjustqty", "adjustcost", "salesqty", "salescost", "endingbalance", "endingcost");
        $this->csr_db->select(' groupname, 
                            sum(begbalance) as beginningbalance, 
                            sum(begCost) as beginningcost,  
                            sum(purchasesqty) as purchaseqty,
                            sum( purchasesamt)as purchasescost, 
                            sum(adjustQty) as adjustqty, 
                            sum(adjustCost) as adjustcost, 
                            sum(qty) as salesqty, 
                            sum(totalamount) as salescost, 
                            sum(endbalance) as endingbalance, 
                            sum(endCost) as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->group_by('groupname');




        if (!empty($this->input->post("search")["value"])) {
            $this->csr_db->group_start()
                    ->like("name", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->csr_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->csr_db->order_by('groupname', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_csr_inventory_monitoring_datatables($start_date) {
        $this->get_csr_inventory_monitoring($start_date);
        if ($this->input->post("length") != -1) {
            $this->csr_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->csr_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_csr_inventory_monitoring_filtered_data($start_date) {
        $this->get_csr_inventory_monitoring($start_date);
        $query = $this->csr_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_csr_inventory_monitoring_data($start_date) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->csr_db->select(' groupname, 
                            sum(begbalance) as beginningbalance, 
                            sum(begCost) as beginningcost,  
                            sum(purchasesqty) as purchaseqty,
                            sum( purchasesamt)as purchasescost, 
                            sum(adjustQty) as adjustqty, 
                            sum(adjustCost) as adjustcost, 
                            sum(qty) as salesqty, 
                            sum(totalamount) as salescost, 
                            sum(endbalance) as endingbalance, 
                            sum(endCost) as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->group_by('groupname')
                ->order_by('groupname', 'ASC');

        return $this->csr_db->count_all_results();
    }

    /*
     * Get pharmacy inventory by groupname
     * 
     */

    public function get_inventory_monitoring_csr_group($start_date, $groupname) {

        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $order_column = array("dscr", "unitprice", "beginningbalance", "beginningcost", "purchaseqty",
            "purchasescost", "adjustqty", "adjustcost", "salesqty", "salescost", "endingbalance", "endingcost");
        $this->csr_db->select(' dscr, unitprice,
                            begbalance as beginningbalance, 
                            begCost as beginningcost,  
                           purchasesqty as purchaseqty,
                            purchasesamt as purchasescost, 
                            adjustQty as adjustqty, 
                            adjustCost as adjustcost, 
                            qty as salesqty, 
                            totalamount as salescost, 
                            endbalance as endingbalance, 
                            endCost as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('groupname', $groupname);





        if (!empty($this->input->post("search")["value"])) {
            $this->csr_db->group_start()
                    ->like("dscr", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->csr_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->csr_db->order_by('dscr', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_inventory_monitoring_csr_group_datatables($start_date, $groupname) {
        $this->get_inventory_monitoring_csr_group($start_date, $groupname);
        if ($this->input->post("length") != -1) {
            $this->csr_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->csr_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_inventory_monitoring_csr_group_filtered_data($start_date, $groupname) {
        $this->get_inventory_monitoring_csr_group($start_date, $groupname);
        $query = $this->csr_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_inventory_monitoring_csr_group_data($start_date, $groupname) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->csr_db->select(' dscr, unitprice,
                            begbalance as beginningbalance, 
                            begCost as beginningcost,  
                           purchasesqty as purchaseqty,
                            purchasesamt as purchasescost, 
                            adjustQty as adjustqty, 
                            adjustCost as adjustcost, 
                            qty as salesqty, 
                            totalamount as salescost, 
                            endbalance as endingbalance, 
                            endCost as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('groupname', $groupname)
                ->order_by('dscr', 'ASC');

        return $this->csr_db->count_all_results();
    }

    public function generate_csr_inventory_monitoring_report($start_date) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->csr_db->select(' groupname, 
                            sum(begbalance) as beginningbalance, 
                            sum(begCost) as beginningcost,  
                            sum(purchasesqty) as purchaseqty,
                            sum( purchasesamt)as purchasescost, 
                            sum(adjustQty) as adjustqty, 
                            sum(adjustCost) as adjustcost, 
                            sum(qty) as salesqty, 
                            sum(totalamount) as salescost, 
                            sum(endbalance) as endingbalance, 
                            sum(endCost) as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->group_by('groupname')
                ->order_by('groupname', 'ASC');

        $query = $this->csr_db->get();
        return $query->result_array();
    }

    public function generate_lab_inventory_monitoring_report($start_date) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->hls_db->select(' groupname, 
                            sum(begbalance) as beginningbalance, 
                            sum(begCost) as beginningcost,  
                            sum(purchasesqty) as purchaseqty,
                            sum( purchasesamt)as purchasescost, 
                            sum(adjustQty) as adjustqty, 
                            sum(adjustCost) as adjustcost, 
                            sum(qty) as salesqty, 
                            sum(totalamount) as salescost, 
                            sum(endbalance) as endingbalance, 
                            sum(endCost) as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->group_by('groupname')
                ->order_by('groupname', 'ASC');

        $query = $this->hls_db->get();
        return $query->result_array();
    }

    public function generate_rad_inventory_monitoring_report($start_date) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->hrs_db->select(' groupname, 
                            sum(begbalance) as beginningbalance, 
                            sum(begCost) as beginningcost,  
                            sum(purchasesqty) as purchaseqty,
                            sum( purchasesamt)as purchasescost, 
                            sum(adjustQty) as adjustqty, 
                            sum(adjustCost) as adjustcost, 
                            sum(qty) as salesqty, 
                            sum(totalamount) as salescost, 
                            sum(endbalance) as endingbalance, 
                            sum(endCost) as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->group_by('groupname')
                ->order_by('groupname', 'ASC');

        $query = $this->hrs_db->get();
        return $query->result_array();
    }

    /*
     * Get AR Payment Recording Patient
     * 
     */

    public function get_hmo_patient_acct() {

        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $order_column = array("dscr", "unitprice", "beginningbalance", "beginningcost", "purchaseqty",
            "purchasescost", "adjustqty", "adjustcost", "salesqty", "salescost", "endingbalance", "endingcost");
        $this->pms_db->select(' dscr, unitprice,
                            begbalance as beginningbalance, 
                            begCost as beginningcost,  
                           purchasesqty as purchaseqty,
                            purchasesamt as purchasescost, 
                            adjustQty as adjustqty, 
                            adjustCost as adjustcost, 
                            qty as salesqty, 
                            totalamount as salescost, 
                            endbalance as endingbalance, 
                            endCost as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('groupname', $groupname);





        if (!empty($this->input->post("search")["value"])) {
            $this->pms_db->group_start()
                    ->like("dscr", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->pms_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->pms_db->order_by('dscr', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_hmo_patient_acct_datatables($start_date, $groupname) {
        $this->get_inventory_monitoring_group($start_date, $groupname);
        if ($this->input->post("length") != -1) {
            $this->pms_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->pms_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_hmo_patient_acct_filtered_data($start_date, $groupname) {
        $this->get_inventory_monitoring_group($start_date, $groupname);
        $query = $this->pms_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_hmo_patient_acct_data($start_date, $groupname) {
        $monthstart = date("Y-m-01", strtotime($start_date . "-01"));
        $monthend = date("Y-m-t", strtotime($start_date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->pms_db->select(' dscr, unitprice,
                            begbalance as beginningbalance, 
                            begCost as beginningcost,  
                           purchasesqty as purchaseqty,
                            purchasesamt as purchasescost, 
                            adjustQty as adjustqty, 
                            adjustCost as adjustcost, 
                            qty as salesqty, 
                            totalamount as salescost, 
                            endbalance as endingbalance, 
                            endCost as endingcost')
                ->from(inventoryend_tbl)
                ->where('enddate BETWEEN "' . $first . '" and "' . $end . '"')
                ->where('groupname', $groupname)
                ->order_by('dscr', 'ASC');

        return $this->pms_db->count_all_results();
    }

    //transmit today
    public function get_monthly_day_transmittal($s_date, $e_date) {
        $order_column = array("patpin", "PatientName", "dischargedate", "processdate", "hcifee", "profee", "grandtotal", "claimedby", "aging");
        $this->dweclaims_db->select('patpin,PatientName,dischargedate,processdate,hcifee,profee,grandtotal,claimedby,aging')
                ->from(masterview_vw)
                ->where('processdate >=', $s_date)
                ->where('processdate <=', $e_date);

        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like("patpin", $this->input->post("search")["value"])
                    ->or_like("PatientName", $this->input->post("search")["value"])
                    ->or_like("dischargedate", $this->input->post("search")["value"])
                    ->or_like("processdate", $this->input->post("search")["value"])
                    ->or_like("aging", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by("processdate", "DESC");
        }
    }

    function make_monthly_transmittal_day_datatables($s_date, $e_date) {
        $this->get_monthly_day_transmittal($s_date, $e_date);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_monthly_transmittal_day_filtered_data($s_date, $e_date) {
        $this->get_monthly_day_transmittal($s_date, $e_date);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_monthly_transmittal_day_data($s_date, $e_date) {
        $this->dweclaims_db->select('patpin,PatientName,dischargedate,processdate,hcifee,profee,grandtotal,claimedby,aging')
                ->from(masterview_vw)
                ->where('processdate >=', $s_date)
                ->where('processdate <=', $e_date)
                ->order_by("processdate", "DESC");
        return $this->dweclaims_db->count_all_results();
    }

    public function get_phic_transmittal_daily_rate($s_date, $e_date) {
//      SELECT name, group_concat(`data`) FROM table GROUP BY name;
        $this->dweclaims_db->select('sum(grandtotal) as totalamt,sum(hcifee) as hosp,sum(profee) as prof')
                ->from(masterview_vw)
                ->where('processdate >=', $s_date)
                ->where('processdate <=', $e_date);

        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }

    /*
     * Get LABORATORY SALES
     * 
     */

    public function get_lab_sales_monitoring() {
        $order_column = array("batchcode", "indate", "outdate", "monthyear", "createdby", "actv");
        $this->hls_db->select('*')
                ->from(invtrep_tbl);

        if (!empty($this->input->post("search")["value"])) {
            $this->hls_db->group_start()
                    ->like("batchcode", $this->input->post("search")["value"])
                    ->or_like("monthyear", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->hls_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->hls_db->order_by('indate', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_lab_sales_monitoring_datatables() {
        $this->get_lab_sales_monitoring();
        if ($this->input->post("length") != -1) {
            $this->hls_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hls_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_lab_sales_monitoring_filtered_data() {
        $this->get_lab_sales_monitoring();
        $query = $this->hls_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_lab_sales_monitoring_data() {
        $this->hls_db->select('*')
                ->from(invtrep_tbl)
                ->order_by('indate', 'ASC');


        return $this->hls_db->count_all_results();
    }

    /*
     * Get LABORATORY SALES by groupname
     * 
     */

    public function get_sales_summarized_lab($batch, $indate, $outdate) {
        $order_column = array("dscr", "qty", "totalamount", "opdqty", "ipdqty", "addonprice", "unitprice", "hospcode", "formname", "prodid");
        $this->hls_db->select('*')
                ->from(inventory_tbl)
                ->where('startdate', $indate)
                ->where('enddate', $outdate)
                ->where('batchcode', $batch);

        if (!empty($this->input->post("search")["value"])) {
            $this->hls_db->group_start()
                    ->like("dscr", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->hls_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->hls_db->order_by('dscr', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_sales_summarized_lab_datatables($batch, $indate, $outdate) {
        $this->get_sales_summarized_lab($batch, $indate, $outdate);
        if ($this->input->post("length") != -1) {
            $this->hls_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hls_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_sales_summarized_lab_filtered_data($batch, $indate, $outdate) {
        $this->get_sales_summarized_lab($batch, $indate, $outdate);
        $query = $this->hls_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_sales_summarized_lab_data($batch, $indate, $outdate) {
        $this->hls_db->select('*')
                ->from(inventory_tbl)
                ->where('startdate', $indate)
                ->where('enddate', $outdate)
                ->where('batchcode', $batch)
                ->order_by('dscr', 'ASC');

        return $this->hls_db->count_all_results();
    }

    /*
     * Get LABORATORY SALES DETAILD
     * 
     */

    public function get_sales_detailed_lab($prodid, $startdate, $enddate) {
        $endx = $enddate . ' 23:59:59';
        $order_column = array("patientname", "transactiontype", "addonrate", "totalamt", "deptcateg", "tdate", "reqcode", "reportcode", "transcode", "status", "medtech", "reqby", "recby", "prodid");
        $this->hls_db->select('*')
                ->from(ledgersales_tbl)
                ->where('prodid', $prodid)
                ->where('status', 'DONE')
                ->where("tdate >='" . $startdate . "'")
                ->where("tdate <='" . $endx . "'");

        if (!empty($this->input->post("search")["value"])) {
            $this->hls_db->group_start()
                    ->like("patientname", $this->input->post("search")["value"])
                    ->or_like("transactiontype", $this->input->post("search")["value"])
                    ->or_like("deptcateg", $this->input->post("search")["value"])
                    ->or_like("medtech", $this->input->post("search")["value"])
                    ->or_like("reqby", $this->input->post("search")["value"])
                    ->or_like("recby", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->hls_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->hls_db->order_by('tdate', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_sales_detailed_lab_datatables($prodid, $startdate, $enddate) {
        $this->get_sales_detailed_lab($prodid, $startdate, $enddate);
        if ($this->input->post("length") != -1) {
            $this->hls_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hls_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_sales_detailed_lab_filtered_data($prodid, $startdate, $enddate) {
        $this->get_sales_detailed_lab($prodid, $startdate, $enddate);
        $query = $this->hls_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_sales_detailed_lab_data($prodid, $startdate, $enddate) {
        $endx = $enddate . ' 23:59:59';

        $this->hls_db->select('*')
                ->from(ledgersales_tbl)
                ->where('prodid', $prodid)
                ->where('status', 'DONE')
                ->where("tdate >='" . $startdate . "'")
                ->where("tdate <='" . $endx . "'")
                ->order_by('tdate', 'ASC');

        return $this->hls_db->count_all_results();
    }

    public function generate_lab_sales_monitoring_report() {
        $this->hls_db->select('*')
                ->from(invtrep_tbl)
                ->order_by('indate', 'ASC');

        $query = $this->hls_db->get();
        return $query->result_array();
    }

    public function generate_lab_sales_summarized_group_report($batch, $indate, $outdate) {
        $this->hls_db->select('*')
                ->from(inventory_tbl)
                ->where('startdate', $indate)
                ->where('enddate', $outdate)
                ->where('batchcode', $batch)
                ->order_by('dscr', 'ASC');

        $query = $this->hls_db->get();
        return $query->result_array();
    }

    public function generate_lab_sales_detailed_group_report($prodid, $startdate, $enddate) {
        $endx = $enddate . ' 23:59:59';

        $this->hls_db->select('*')
                ->from(ledgersales_tbl)
                ->where('prodid', $prodid)
                ->where('status', 'DONE')
                ->where("tdate >='" . $startdate . "'")
                ->where("tdate <='" . $endx . "'")
                ->order_by('tdate', 'ASC');

        $query = $this->hls_db->get();
        return $query->result_array();
    }

    //GET RADIOLOGY SALES

    /*
     * Get LABORATORY SALES
     * 
     */
    public function get_rad_sales_monitoring() {
        $order_column = array("batchcode", "indate", "outdate", "monthyear", "createdby", "actv");
        $this->hrs_db->select('*')
                ->from(invtrep_tbl);

        if (!empty($this->input->post("search")["value"])) {
            $this->hrs_db->group_start()
                    ->like("batchcode", $this->input->post("search")["value"])
                    ->or_like("monthyear", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->hrs_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->hrs_db->order_by('indate', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_rad_sales_monitoring_datatables() {
        $this->get_rad_sales_monitoring();
        if ($this->input->post("length") != -1) {
            $this->hrs_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hrs_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_rad_sales_monitoring_filtered_data() {
        $this->get_rad_sales_monitoring();
        $query = $this->hrs_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_rad_sales_monitoring_data() {
        $this->hrs_db->select('*')
                ->from(invtrep_tbl)
                ->order_by('indate', 'ASC');


        return $this->hrs_db->count_all_results();
    }

    /*
     * Get RADIOLOGY SALES by groupname
     * 
     */

    public function get_sales_summarized_rad($batch, $indate, $outdate) {
        $order_column = array("dscr", "qty", "totalamount", "opdqty", "ipdqty", "addonprice", "unitprice", "hospcode", "formname", "prodid");
        $this->hrs_db->select('*')
                ->from(inventory_tbl)
                ->where('startdate', $indate)
                ->where('enddate', $outdate)
                ->where('batchcode', $batch);

        if (!empty($this->input->post("search")["value"])) {
            $this->hrs_db->group_start()
                    ->like("dscr", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->hrs_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->hrs_db->order_by('dscr', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_sales_summarized_rad_datatables($batch, $indate, $outdate) {
        $this->get_sales_summarized_rad($batch, $indate, $outdate);
        if ($this->input->post("length") != -1) {
            $this->hrs_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hrs_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_sales_summarized_rad_filtered_data($batch, $indate, $outdate) {
        $this->get_sales_summarized_rad($batch, $indate, $outdate);
        $query = $this->hrs_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_sales_summarized_rad_data($batch, $indate, $outdate) {
        $this->hrs_db->select('*')
                ->from(inventory_tbl)
                ->where('startdate', $indate)
                ->where('enddate', $outdate)
                ->where('batchcode', $batch)
                ->order_by('dscr', 'ASC');

        return $this->hrs_db->count_all_results();
    }

    /*
     * Get LABORATORY SALES DETAILD
     * 
     */

    public function get_sales_detailed_rad($prodid, $startdate, $enddate) {
        $endx = $enddate . ' 23:59:59';
        $order_column = array("patientname", "transactiontype", "addonrate", "totalamt", "deptcateg", "tdate", "reqcode", "reportcode", "transcode", "status", "medtech", "reqby", "recby", "prodid");
        $this->hrs_db->select('*')
                ->from(ledgersales_tbl)
                ->where('prodid', $prodid)
                ->where('status', 'DONE')
                ->where("tdate >='" . $startdate . "'")
                ->where("tdate <='" . $endx . "'");

        if (!empty($this->input->post("search")["value"])) {
            $this->hrs_db->group_start()
                    ->like("patientname", $this->input->post("search")["value"])
                    ->or_like("transactiontype", $this->input->post("search")["value"])
                    ->or_like("deptcateg", $this->input->post("search")["value"])
                    ->or_like("medtech", $this->input->post("search")["value"])
                    ->or_like("reqby", $this->input->post("search")["value"])
                    ->or_like("recby", $this->input->post("search")["value"])
                    ->group_end();
        }
        if (!empty($this->input->post("order"))) {
            $this->hrs_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->hrs_db->order_by('tdate', 'ASC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_sales_detailed_rad_datatables($prodid, $startdate, $enddate) {
        $this->get_sales_detailed_rad($prodid, $startdate, $enddate);
        if ($this->input->post("length") != -1) {
            $this->hrs_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->hrs_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_sales_detailed_rad_filtered_data($prodid, $startdate, $enddate) {
        $this->get_sales_detailed_rad($prodid, $startdate, $enddate);
        $query = $this->hrs_db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_sales_detailed_rad_data($prodid, $startdate, $enddate) {
        $endx = $enddate . ' 23:59:59';

        $this->hrs_db->select('*')
                ->from(ledgersales_tbl)
                ->where('prodid', $prodid)
                ->where('status', 'DONE')
                ->where("tdate >='" . $startdate . "'")
                ->where("tdate <='" . $endx . "'")
                ->order_by('tdate', 'ASC');

        return $this->hrs_db->count_all_results();
    }

    public function generate_rad_sales_monitoring_report() {
        $this->hrs_db->select('*')
                ->from(invtrep_tbl)
                ->order_by('indate', 'ASC');

        $query = $this->hrs_db->get();
        return $query->result_array();
    }

    public function generate_rad_sales_summarized_group_report($batch, $indate, $outdate) {
        $this->hrs_db->select('*')
                ->from(inventory_tbl)
                ->where('startdate', $indate)
                ->where('enddate', $outdate)
                ->where('batchcode', $batch)
                ->order_by('dscr', 'ASC');

        $query = $this->hrs_db->get();
        return $query->result_array();
    }

    public function generate_rad_sales_detailed_group_report($prodid, $startdate, $enddate) {
        $endx = $enddate . ' 23:59:59';

        $this->hrs_db->select('*')
                ->from(ledgersales_tbl)
                ->where('prodid', $prodid)
                ->where('status', 'DONE')
                ->where("tdate >='" . $startdate . "'")
                ->where("tdate <='" . $endx . "'")
                ->order_by('tdate', 'ASC');

        $query = $this->hrs_db->get();
        return $query->result_array();
    }

    public function get_ad_dis_census_monthly() {
        $data = array();
        $dates = array();

        $start_date = date('Y-m-d', strtotime('today - 6 months'));
        $end_date = new DateTime();
        $end_date->format("Y-m-d");

        $period = new DatePeriod(
                new DateTime($start_date), new DateInterval('P1M'), $end_date
        );


        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }


        for ($i = 0; $i < count($dates); $i++) {

            $monthstart = date("Y-m-01", strtotime($dates[$i] . "-01"));
            $monthend = date("Y-m-t", strtotime($dates[$i] . "-01"));

            $d = new DateTime($monthstart);
            $first = $d->format('Y-m-d');
            $e = new DateTime($monthend);
            $end = $e->format('Y-m-d');

            $datexx = $this->get_yearmonths($dates[$i]);
            $this->db->select('"' . $datexx . '" as datexx,sum(case when admitdate >= "' . $first . '" and admitdate <= "' . $end . '" and phicmembr = "non-nhip" then 1 else 0 end) nonad,sum(case when admitdate >= "' . $first . '" and admitdate <= "' . $end . '" and phicmembr <> "non-nhip" then 1 else 0 end) phicad,'
                            . 'sum(case when dischadate >= "' . $first . '" and dischadate <= "' . $end . '" and discharged = 1 and phicmembr = "non-nhip" then 1 else 0 end) nondis,sum(case when dischadate >= "' . $first . '" and dischadate <= "' . $end . '" and discharged = 1 and phicmembr <> "non-nhip" then 1 else 0 end) phicdis')
                    ->where('pxtype', 'IPD')
                    ->from(inpatient_tbl);

            $query = $this->db->get();

            array_push($data, $query->row_array());
        }

        return $data;
    }

    public function get_payroll_summary() {

//            $order_column = array("dept","profileno","Empname", "salarygrade","basic","totalincentives", "GRS","SSSded","PHICded","HDMFded","TAXded","ABSENTded","Net");
//            $this->epay_db->select('*')
//                    ->from(employeepayslip_vw)
//                    ->where('payschedfrom',$s_date)
//                    ->where('payschedto',$e_date);
//                    
//            if(!empty($this->input->post("search")["value"]))  
//            {  
//                $this->epay_db->group_start()
//                        ->like("profileno", $this->input->post("search")["value"])
//                        ->or_like("Empname", $this->input->post("search")["value"])
//                        ->or_like("salarygrade", $this->input->post("search")["value"])
//                        ->or_like("basic", $this->input->post("search")["value"])
//                        ->or_like("totalincentives", $this->input->post("search")["value"])
//                        ->or_like("GRS", $this->input->post("search")["value"])
//                        ->or_like("Net", $this->input->post("search")["value"])
//                ->group_end();
//            }  
//            if(!empty($this->input->post("order")))  
//            {  
//                $this->epay_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);  
//            }  
//            else  
//            {  
//                $this->epay_db->order_by('dept','asc')
//                              ->order_by('Empname','asc');
//            }

        $order_column = array("batchno", "batchdate", "gross", "deductions", "net", "status", null);
        $this->epay_db
                ->select('*')
                ->from(payroll_tbl);

        if (!empty($this->input->post("search")["value"])) {
            $this->epay_db
                    ->group_start()
                    ->like('batchno', $this->input->post("search")["value"])
                    ->or_like('batchdate', $this->input->post("search")["value"])
                    ->or_like('gross', $this->input->post("search")["value"])
                    ->or_like('deductions', $this->input->post("search")["value"])
                    ->or_like('net', $this->input->post("search")["value"])
                    ->or_like('status', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->epay_db
                    ->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->epay_db
                    ->order_by('id', 'DESC');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_payroll_summary_datatables() {
        $this->get_payroll_summary();
        if ($this->input->post("length") != -1) {
            $this->epay_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->epay_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_payroll_summary_filtered_data() {
        $this->get_payroll_summary();
        $query = $this->epay_db->get();
        return $query->num_rows();
    }

    public function get_payroll_summary_data() {
//            $this->epay_db->select('*')
//                    ->from(employeepayslip_vw)
//                    ->where('payschedfrom',$s_date)
//                    ->where('payschedto',$e_date)
//                    ->order_by('dept','asc')
//                    ->order_by('Empname','asc');
//        
//        return $this->epay_db->count_all_results();

        $this->epay_db
                ->select('*')
                ->from(payroll_tbl);

        return $this->epay_db->count_all_results();
    }

    public function get_payroll_details($batchno) {
        $order_column = array("dept", "profileno", "Empname", "salarygrade", "basic", "totalincentives", "GRS", "SSSded", "PHICded", "HDMFded", "TAXded", "ABSENTded", "Net");
        $this->epay_db->select('*')
                ->from(employeepayslip_vw)
                ->where('batchcode', $batchno);

        if (!empty($this->input->post("search")["value"])) {
            $this->epay_db->group_start()
                    ->like("profileno", $this->input->post("search")["value"])
                    ->or_like("Empname", $this->input->post("search")["value"])
                    ->or_like("salarygrade", $this->input->post("search")["value"])
                    ->or_like("basic", $this->input->post("search")["value"])
                    ->or_like("totalincentives", $this->input->post("search")["value"])
                    ->or_like("GRS", $this->input->post("search")["value"])
                    ->or_like("Net", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->epay_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->epay_db->order_by('dept', 'asc')
                    ->order_by('Empname', 'asc');
        }
    }

    /**
     * 
     * make all patient table
     */
    function make_payroll_details_datatables($batchno) {
        $this->get_payroll_details($batchno);
        if ($this->input->post("length") != -1) {
            $this->epay_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->epay_db->get();
        return $query->result();
    }

    /**
     * search for all patient table
     */
    function get_payroll_details_filtered_data($batchno) {
        $this->get_payroll_details($batchno);
        $query = $this->epay_db->get();
        return $query->num_rows();
    }

    public function get_payroll_details_data($batchno) {
        $this->epay_db->select('*')
                ->from(employeepayslip_vw)
                ->where('batchcode', $batchno)
                ->order_by('dept', 'asc')
                ->order_by('Empname', 'asc');

        return $this->epay_db->count_all_results();
    }

    public function generate_payroll_summary_report($batchno) {
        $this->epay_db->select('*')
                ->from(employeepayslip_vw)
                ->where('batchcode', $batchno)
                ->order_by('dept', 'ASC')
                ->order_by('Empname', 'ASC');

        $query = $this->epay_db->get();
        return $query->result_array();
    }

    public function fetch_paysched_from_employeepayslipvw($batchno) {
        $this->epay_db
                ->select('payschedfrom,payschedto')
                ->from(employeepayslip_vw)
                ->where('batchcode', $batchno);

        $query = $this->epay_db->get();
        return $query->result_array();
    }

    public function generate_payroll_dept_report($batchno) {
//      SELECT name, group_concat(`data`) FROM table GROUP BY name;
        $this->epay_db->select('distinct(dept)')
                ->from(employeepayslip_vw)
                ->where('batchcode', $batchno)
                ->order_by('dept', 'ASC');

        $query = $this->epay_db->get();
        return $query->result_array();
    }

    public function generate_net_dept_report($batchno) {
//      SELECT name, group_concat(`data`) FROM table GROUP BY name;
        $this->epay_db->select('dept,sum(Net) as sumnet')
                ->from(employeepayslip_vw)
                ->where('batchcode', $batchno)
                ->group_by('dept', 'ASC');

        $query = $this->epay_db->get();
        return $query->result_array();
    }

    /**
     * GEt Supplier for Purchases
     * @author Alingling
     */
    public function get_purchase_supplier($type) {
        $order_column = array("pocode", "suppliername", "TotalPOamount", "podate", "term", "checked", "noted", "recommendedby", "updated", "pono", "dept", "approved");
        if ($type == "fapproval") {
            $this->db->select('*')
                    ->from(prmaster_tbl)
                    ->where('approved', 0)
                    ->where('checked', 1);
        } else if ($type == "approved") {
            $this->db->select('*')
                    ->from(purapproved_vw);
        } else if ($type == "defer") {
            $this->db->select('*')
                    ->from(purdeferred_vw);
        } else {
            $this->db->select('*')
                    ->from(purdisapproved_vw);
        }

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("pocode", $this->input->post("search")["value"])
                    ->or_like("suppliername", $this->input->post("search")["value"])
                    ->or_like("TotalPOamount", $this->input->post("search")["value"])
                    ->or_like("podate", $this->input->post("search")["value"])
                    ->or_like("term", $this->input->post("search")["value"])
                    ->or_like("checked", $this->input->post("search")["value"])
                    ->or_like("noted", $this->input->post("search")["value"])
                    ->or_like("recommendedby", $this->input->post("search")["value"])
                    ->or_like("updated", $this->input->post("search")["value"])
                    ->or_like("pono", $this->input->post("search")["value"])
                    ->or_like("approved", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by("pocode", "ASC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_purchase_supplier_datatables($type) {
        $this->get_purchase_supplier($type);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_purchase_supplier_filtered_data($type) {
        $this->get_purchase_supplier($type);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_purchase_supplier_data($type) {
        if ($type == "fapproval") {
            $this->db->select('*')
                    ->from(prmaster_tbl)
                    ->where('approved', 0)
                    ->where('checked', 1);
        } else if ($type == "approved") {
            $this->db->select('*')
                    ->from(purapproved_vw);
        } else if ($type == "defer") {
            $this->db->select('*')
                    ->from(purdeferred_vw);
        } else {
            $this->db->select('*')
                    ->from(purdisapproved_vw);
        }
        return $this->db->count_all_results();
    }

    /**
     * GEt Purchase Stock
     * @author Alingling
     */
    public function get_purchase_stock($pocode) {
        $order_column = array(null, null, null, "dscr", "qty", "packing", "cost", "totalcost", "balqty", "noteofresubmission", "potranscode", "pocode", "updated", "pono", "deptseries", "potranscode", "control", "approved", "disapproved", "deffered");
        $this->db->select('*')
                ->from(prequests_tbl)
                ->where('pocode', $pocode)
                ->where('needapproval', 1)
                ->where('forapproval', 1);

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("dscr", $this->input->post("search")["value"])
                    ->or_like("qty", $this->input->post("search")["value"])
                    ->or_like("packing", $this->input->post("search")["value"])
                    ->or_like("cost", $this->input->post("search")["value"])
                    ->or_like("totalcost", $this->input->post("search")["value"])
                    ->or_like("balqty", $this->input->post("search")["value"])
                    ->or_like("potranscode", $this->input->post("search")["value"])
                    ->or_like("pocode", $this->input->post("search")["value"])
                    ->or_like("updated", $this->input->post("search")["value"])
                    ->or_like("pono", $this->input->post("search")["value"])
                    ->or_like("deptseries", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by("dscr", "ASC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_purchase_stock_datatables($pocode) {
        $this->get_purchase_stock($pocode);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_purchase_stock_filtered_data($pocode) {
        $this->get_purchase_stock($pocode);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_purchase_stock_data($pocode) {
        $this->db->select('*')
                ->from(prequests_tbl)
                ->where('pocode', $pocode)
                ->where('needapproval', 1)
                ->where('forapproval', 1);
        return $this->db->count_all_results();
    }

    /**
     * GEt Purchase Stock OnProcess
     * @author Alingling
     */
    public function get_purchase_stock_onprocess($pocode, $type) {
        $order_column = array("dscr", "qty", "packing", "cost", "totalcost", "balqty", "noteofresubmission", "potranscode", "pocode", "updated", "pono", "deptseries", "potranscode", "control");
        $this->db->select('*')
                ->from(prequests_tbl)
                ->where('pocode', $pocode);
        if ($type === "onprocess") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 0)
                    ->where('approved', 0)
                    ->where('disapproved', 0)
                    ->where('deffered', 0);
        } else if ($type === "defer") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 0)
                    ->where('disapproved', 0)
                    ->where('deffered', 1);
        } else if ($type === "approved") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 1)
                    ->where('disapproved', 0)
                    ->where('deffered', 0);
        } else {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 0)
                    ->where('disapproved', 1)
                    ->where('deffered', 0);
        }


        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like("dscr", $this->input->post("search")["value"])
                    ->or_like("qty", $this->input->post("search")["value"])
                    ->or_like("packing", $this->input->post("search")["value"])
                    ->or_like("cost", $this->input->post("search")["value"])
                    ->or_like("totalcost", $this->input->post("search")["value"])
                    ->or_like("balqty", $this->input->post("search")["value"])
                    ->or_like("potranscode", $this->input->post("search")["value"])
                    ->or_like("pocode", $this->input->post("search")["value"])
                    ->or_like("updated", $this->input->post("search")["value"])
                    ->or_like("pono", $this->input->post("search")["value"])
                    ->or_like("deptseries", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by("dscr", "ASC");
        }
    }

    /**
     * 
     * make all purchases table
     */
    function make_purchase_stock_onprocess_datatables($pocode, $type) {
        $this->get_purchase_stock_onprocess($pocode, $type);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * search for all purchases table
     */
    function get_purchase_stock_onprocess_filtered_data($pocode, $type) {
        $this->get_purchase_stock_onprocess($pocode, $type);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * get and returns the count of the fetch data
     */
    public function get_purchase_stock_onprocess_data($pocode, $type) {
        $this->db->select('*')
                ->from(prequests_tbl)
                ->where('pocode', $pocode);
        if ($type === "onprocess") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 0)
                    ->where('approved', 0)
                    ->where('disapproved', 0)
                    ->where('deffered', 0);
        } else if ($type === "defer") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 0)
                    ->where('disapproved', 0)
                    ->where('deffered', 1);
        } else if ($type === "approved") {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 1)
                    ->where('disapproved', 0)
                    ->where('deffered', 0);
        } else {
            $this->db->where('needapproval', 1)
                    ->where('forapproval', 1)
                    ->where('approved', 0)
                    ->where('disapproved', 1)
                    ->where('deffered', 0);
        }
        return $this->db->count_all_results();
    }

    //unposted_with check
    public function get_payment_unposted_check($datax) {

        $order_column = array("CSNO", "PatientName", "patpin", "hcifee", "profee", "grandtotal", "processdate", "asof");
        if ($datax['stat'] == "check") {
            $this->dweclaims_db->select('CSNO,PatientName,patpin,hcifee,profee,grandtotal, processdate,asof')
                    ->from(masterview_vw)
                    ->where('asof >= "' . $datax['s_date'] . '"')
                    ->where('asof <= "' . $datax['e_date'] . '"')
                    ->where('pStatus', 'WITH CHEQUE')
                    ->where('tagged', 0);
        } else {

            $this->dweclaims_db->select('CSNO,PatientName,patpin,hcifee,profee,grandtotal, processdate,asof')
                    ->from(masterview_vw)
                    ->where('asof >= "' . $datax['s_date'] . '"')
                    ->where('asof <= "' . $datax['e_date'] . '"')
                    ->where('pStatus != "WITH CHEQUE"')
                    ->where('tagged', 0);
        }
        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('CSNO', $this->input->post("search")["value"])
                    ->or_like('PatientName', $this->input->post("search")["value"])
                    ->or_like('patpin', $this->input->post("search")["value"])
                    ->or_like('hcifee', $this->input->post("search")["value"])
                    ->or_like('profee', $this->input->post("search")["value"])
                    ->or_like('grandtotal', $this->input->post("search")["value"])
                    ->or_like('processdate', $this->input->post("search")["value"])
                    ->or_like('asof', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('asof', 'ASC');
        }
    }

    function make_payment_unposted_check_datatables($datax) {
        $this->get_payment_unposted_check($datax);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_payment_unposted_check_filtered_data($datax) {
        $this->get_payment_unposted_check($datax);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_payment_unposted_check_data($datax) {
        if ($datax['stat'] == "check") {
            $this->dweclaims_db->select('CSNO,PatientName,patpin,hcifee,profee,grandtotal, processdate,asof')
                    ->from(masterview_vw)
                    ->where('asof >= "' . $datax['s_date'] . '"')
                    ->where('asof <= "' . $datax['e_date'] . '"')
                    ->where('pStatus', 'WITH CHEQUE')
                    ->where('tagged', 0)
                    ->order_by('asof', 'ASC');
        } else {
            $this->dweclaims_db->select('CSNO,PatientName,patpin,hcifee,profee,grandtotal, processdate,asof')
                    ->from(masterview_vw)
                    ->where('asof >= "' . $datax['s_date'] . '"')
                    ->where('asof <= "' . $datax['e_date'] . '"')
                    ->where('pStatus != "WITH CHEQUE"')
                    ->where('tagged', 0)
                    ->order_by('asof', 'ASC');
        }
        return $this->dweclaims_db->count_all_results();
    }

    public function get_total_payment_unposted_check($datax) {

        $this->dweclaims_db->select('sum(hcifee) as hosp, sum(profee) as prof, sum(grandtotal) as grand')
                ->from(masterview_vw)
                ->where('asof >= "' . $datax['s_date'] . '"')
                ->where('asof <= "' . $datax['e_date'] . '"')
                ->where('pStatus', "WITH CHEQUE")
                ->where('tagged', 0)
                ->order_by('asof', 'ASC');

        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }

    public function get_total_payment_unposted_wcheck($datax) {
        $this->dweclaims_db->select('sum(hcifee) as hosp, sum(profee) as prof, sum(grandtotal) as grand')
                ->from(masterview_vw)
                ->where('asof >= "' . $datax['s_date'] . '"')
                ->where('asof <= "' . $datax['e_date'] . '"')
                ->where('pStatus != "WITH CHEQUE"')
                ->where('tagged', 0)
                ->order_by('asof', 'ASC');

        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }

    public function get_payment_unposted_report($datax) {
        if ($datax['stat'] == "check") {
            $this->dweclaims_db->select('CSNO,PatientName,patpin,hcifee,profee,grandtotal, processdate,asof')
                    ->from(masterview_vw)
                    ->where('asof >= "' . $datax['s_date'] . '"')
                    ->where('asof <= "' . $datax['e_date'] . '"')
                    ->where('pStatus', 'WITH CHEQUE')
                    ->where('tagged', 0)
                    ->order_by('asof', 'ASC');
        } else {
            $this->dweclaims_db->select('CSNO,PatientName,patpin,hcifee,profee,grandtotal, processdate,asof')
                    ->from(masterview_vw)
                    ->where('asof >= "' . $datax['s_date'] . '"')
                    ->where('asof <= "' . $datax['e_date'] . '"')
                    ->where('pStatus != "WITH CHEQUE"')
                    ->where('tagged', 0)
                    ->order_by('asof', 'ASC');
        }

        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    //posted_with check
    public function get_payment_posted_check($datax) {

        $order_column = array("CSNO", "PatientName", "patpin", "hosppaid", "hospvar", "profpaid", "profvar", "granpaid", "granvar", "pvc", "asof");

        $this->dweclaims_db->select('CSNO,PatientName,patpin,hosppaid,hospvar,profpaid, profvar,granpaid,granvar,pvc,asof')
                ->from(masterview_vw)
                ->where('asof >= "' . $datax['s_date'] . '"')
                ->where('asof <= "' . $datax['e_date'] . '"')
                ->where('pStatus', 'WITH CHEQUE')
                ->where('tagged', 1);

        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('CSNO', $this->input->post("search")["value"])
                    ->or_like('PatientName', $this->input->post("search")["value"])
                    ->or_like('patpin', $this->input->post("search")["value"])
                    ->or_like('hosppaid', $this->input->post("search")["value"])
                    ->or_like('hospvar', $this->input->post("search")["value"])
                    ->or_like('profpaid', $this->input->post("search")["value"])
                    ->or_like('profvar', $this->input->post("search")["value"])
                    ->or_like('granpaid', $this->input->post("search")["value"])
                    ->or_like('granvar', $this->input->post("search")["value"])
                    ->or_like('pvc', $this->input->post("search")["value"])
                    ->or_like('asof', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('asof', 'ASC');
        }
    }

    function make_payment_posted_check_datatables($datax) {
        $this->get_payment_posted_check($datax);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_payment_posted_check_filtered_data($datax) {
        $this->get_payment_posted_check($datax);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_payment_posted_check_data($datax) {

        $this->dweclaims_db->select('CSNO,PatientName,patpin,hosppaid,hospvar,profpaid, profvar,granpaid,granvar,pvc,asof')
                ->from(masterview_vw)
                ->where('asof >= "' . $datax['s_date'] . '"')
                ->where('asof <= "' . $datax['e_date'] . '"')
                ->where('pStatus', 'WITH CHEQUE')
                ->where('tagged', 1)
                ->order_by('asof', 'ASC');

        return $this->dweclaims_db->count_all_results();
    }

    public function get_total_payment_posted_check($datax) {

        $this->dweclaims_db->select('sum(hosppaid) as hosppaidx, sum(hospvar) as hospunpaid, sum(profpaid) as profpaidx, sum(profvar) as profunpaid, sum(granpaid) as granpaidx, sum(granvar) as grandunpaid')
                ->from(masterview_vw)
                ->where('asof >= "' . $datax['s_date'] . '"')
                ->where('asof <= "' . $datax['e_date'] . '"')
                ->where('pStatus', "WITH CHEQUE")
                ->where('tagged', 1)
                ->order_by('asof', 'ASC');

        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }

    public function get_payment_posted_report($datax) {
        $this->dweclaims_db->select('CSNO,PatientName,patpin,hosppaid,hospvar,profpaid, profvar,granpaid,granvar,pvc,asof')
                ->from(masterview_vw)
                ->where('asof >= "' . $datax['s_date'] . '"')
                ->where('asof <= "' . $datax['e_date'] . '"')
                ->where('pStatus', 'WITH CHEQUE')
                ->where('tagged', 1)
                ->order_by('asof', 'ASC');


        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    //Check Status
    public function get_check_status($datax) {

        $order_column = array("CSNO", "PatientName", "patpin", "hosppaid", "hospvar", "profpaid", "profvar", "granpaid", "granvar", "pvc", "asof", "tagged");

        $this->dweclaims_db->select('CSNO,PatientName,patpin,hcifee,profee,grandtotal,hosppaid,hospvar,profpaid, profvar,granpaid,granvar,pvc,asof,tagged')
                ->from(masterview_vw)
                ->where('asof >= "' . $datax['s_date'] . '"')
                ->where('asof <= "' . $datax['e_date'] . '"')
                ->where('pStatus', 'WITH CHEQUE');

        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('CSNO', $this->input->post("search")["value"])
                    ->or_like('PatientName', $this->input->post("search")["value"])
                    ->or_like('patpin', $this->input->post("search")["value"])
                    ->or_like('hosppaid', $this->input->post("search")["value"])
                    ->or_like('hospvar', $this->input->post("search")["value"])
                    ->or_like('profpaid', $this->input->post("search")["value"])
                    ->or_like('profvar', $this->input->post("search")["value"])
                    ->or_like('granpaid', $this->input->post("search")["value"])
                    ->or_like('granvar', $this->input->post("search")["value"])
                    ->or_like('pvc', $this->input->post("search")["value"])
                    ->or_like('asof', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('tagged', 'DESC')
                    ->order_by('asof', 'ASC');
        }
    }

    function make_check_status_datatables($datax) {
        $this->get_check_status($datax);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_check_status_filtered_data($datax) {
        $this->get_check_status($datax);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_check_status_data($datax) {

        $this->dweclaims_db->select('CSNO,PatientName,patpin,hcifee,profee,grandtotal,hosppaid,hospvar,profpaid, profvar,granpaid,granvar,pvc,asof,tagged')
                ->from(masterview_vw)
                ->where('asof >= "' . $datax['s_date'] . '"')
                ->where('asof <= "' . $datax['e_date'] . '"')
                ->where('pStatus', 'WITH CHEQUE')
                ->order_by('asof', 'ASC');

        return $this->dweclaims_db->count_all_results();
    }

    public function get_check_status_report($datax) {
        $this->dweclaims_db->select('CSNO,PatientName,patpin,hcifee,profee,grandtotal,hosppaid,hospvar,profpaid, profvar,granpaid,granvar,pvc,asof,tagged')
                ->from(masterview_vw)
                ->where('asof >= "' . $datax['s_date'] . '"')
                ->where('asof <= "' . $datax['e_date'] . '"')
                ->where('pStatus', 'WITH CHEQUE')
                ->order_by('asof', 'ASC');


        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    //Pending Claims
    public function get_pending_claims() {
        $order_column = array("batchno", "PatientName", "processdate", "claimno", "patpin", "aging");
        $this->dweclaims_db->select('batchno,PatientName,processdate,claimno,patpin,datediff(NOW(),processdate) as aging')
                ->from(eclaims_tbl)
                ->where('status', 0)
                ->where('batchno != ""');

        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('batchno', $this->input->post("search")["value"])
                    ->or_like('PatientName', $this->input->post("search")["value"])
                    ->or_like('processdate', $this->input->post("search")["value"])
                    ->or_like('claimno', $this->input->post("search")["value"])
                    ->or_like('patpin', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('aging', 'DESC');
        }
    }

    function make_pending_claims_datatables() {
        $this->get_pending_claims();
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_pending_claims_filtered_data() {
        $this->get_pending_claims();
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_pending_claims_data() {

        $this->dweclaims_db->select('batchno,PatientName,processdate,claimno,patpin,datediff(NOW(),processdate) as aging')
                ->from(eclaims_tbl)
                ->where('status', 0)
                ->where('batchno != ""')
                ->order_by('aging', 'DESC');

        return $this->dweclaims_db->count_all_results();
    }

    public function get_pending_claims_report() {
        $this->dweclaims_db->select('batchno,PatientName,processdate,claimno,patpin,datediff(NOW(),processdate) as aging')
                ->from(eclaims_tbl)
                ->where('status', 0)
                ->where('batchno != ""')
                ->order_by('aging', 'DESC');


        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    public function get_pending_claims_dashboard($age) {
        $date = $this->get_current_datex();
        if ($age == "1") {
            $this->dweclaims_db->select('count(*) as total')
                    ->from(eclaims_tbl)
                    ->where('status', 0)
                    ->where('datediff("' . $date . '", processdate) <= 30')
                    ->where('batchno != ""');
        } else if ($age == "2") {
            $this->dweclaims_db->select('count(*) as total')
                    ->from(eclaims_tbl)
                    ->where('status', 0)
                    ->where('datediff("' . $date . '", processdate) >= 31')
                    ->where('datediff("' . $date . '", processdate) <= 45')
                    ->where('batchno != ""');
        } else if ($age == "3") {
            $this->dweclaims_db->select('count(*) as total')
                    ->from(eclaims_tbl)
                    ->where('status', 0)
                    ->where('datediff("' . $date . '", processdate) >= 46')
                    ->where('datediff("' . $date . '", processdate) <= 60')
                    ->where('batchno != ""');
        } else {
            $this->dweclaims_db->select('count(*) as total')
                    ->from(eclaims_tbl)
                    ->where('status', 0)
                    ->where('datediff("' . $date . '", processdate) >= 61')
                    ->where('batchno != ""');
        }

        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }

    public function get_sent_claims_dashboard($statx) {
        $monthstart = date("Y-m-01", strtotime($this->get_my() . "-01"));
        $monthend = date("Y-m-t", strtotime($this->get_my() . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        if ($statx == "IN PROCESS") {
            $this->dweclaims_db->select('count(*) as total')
                    ->from(masterview_vw)
                    ->where('pStatus', 'IN PROCESS');
        } else if ($statx == "RTH") {
            $this->dweclaims_db->select('count(*) as total')
                    ->from(masterview_vw)
                    ->where('pStatus', 'RETURN');
        } else if ($statx == "DENIED") {
            $this->dweclaims_db->select('count(*) as total')
                    ->from(masterview_vw)
                    ->where('pStatus', 'DENIED');
        } else if ($statx == "WITH VOUCHER") {
            $this->dweclaims_db->select('count(*) as total')
                    ->from(masterview_vw)
                    ->where('pStatus', 'WITH VOUCHER')
                    ->or_where('pStatus', 'VOUCHER');
        } else if ($statx == "WITH CHEQUE") {
            $this->dweclaims_db->select('count(*) as total')
                    ->from(masterview_vw)
                    ->where('pStatus', 'WITH CHEQUE');
        } else {
            $this->dweclaims_db->select('count(*) as total')
                    ->from(masterview_vw)
                    ->where('proc1date >= "' . $first . '"')
                    ->where('proc1date <= "' . $end . '"');
        }

        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }

    public function get_phar_acc_dashboard() {
        $this->dweclaims_db->select('sum(grandtotal) as totalamt')
                ->from(masterview_vw)
                ->where('pStatus != "WITH CHEQUE"')
                ->where('tagged', 0);

        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }

    //History Log
    public function get_history_log() {
        $order_column = array("transactno", "csno", "pname", "patpin", "amount", "tagdate", "tagby", "untagdate", "untagby", "aging", "vchr");

        $this->dweclaims_db->select('transactno,csno,pname,patpin,amount,tagdate,tagby,untagdate,untagby,aging,vchr')
                ->from(acctlogs_tbl);

        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('transactno', $this->input->post("search")["value"])
                    ->or_like('csno', $this->input->post("search")["value"])
                    ->or_like('pname', $this->input->post("search")["value"])
                    ->or_like('patpin', $this->input->post("search")["value"])
                    ->or_like('amount', $this->input->post("search")["value"])
                    ->or_like('tagdate', $this->input->post("search")["value"])
                    ->or_like('tagby', $this->input->post("search")["value"])
                    ->or_like('untagdate', $this->input->post("search")["value"])
                    ->or_like('untagby', $this->input->post("search")["value"])
                    ->or_like('aging', $this->input->post("search")["value"])
                    ->or_like('aging', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('aging', 'DESC');
        }
    }

    function make_history_log_datatables() {
        $this->get_history_log();
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_history_log_filtered_data() {
        $this->get_history_log();
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_history_log_data() {
        $this->dweclaims_db->select('transactno,csno,pname,patpin,amount,tagdate,tagby,untagdate,untagby,aging,vchr')
                ->from(acctlogs_tbl);

        return $this->dweclaims_db->count_all_results();
    }

    public function get_history_log_report() {
        $this->dweclaims_db->select('transactno,csno,pname,patpin,amount,tagdate,tagby,untagdate,untagby,aging,vchr')
                ->from(acctlogs_tbl);


        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    /*
     * Gets all patients info for total accumulated PHIC AR
     * 
     * @author Alingling
     * @param string 11-27-2017
     * 
     */

    public function get_total_accumulated_PHICAR($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));


        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("CSNO,PatientName", "hcifee", "profee", "dischargedate", "proc1date", "age", "pStatus", "processdate");
        $this->dweclaims_db->select('CSNO,PatientName,hcifee,profee,dischargedate,proc1date,datediff("' . date('Y-m-d') . '",proc1date) as age, pStatus,processdate')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus != "WITH CHEQUE"')
                ->where('tagged', 0);
        if (!empty($this->input->post("search")["value"])) {
            $this->dweclaims_db->group_start()
                    ->like('PatientName', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->dweclaims_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->dweclaims_db->order_by('proc1date', 'ASC');
        }
    }

    function make_total_accumulated_PHICAR_datatables($date) {
        $this->get_total_accumulated_PHICAR($date);
        if ($this->input->post("length") != -1) {
            $this->dweclaims_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->dweclaims_db->get();
        return $query->result();
    }

    function get_total_accumulated_PHICAR_filtered_data($date) {
        $this->get_total_accumulated_PHICAR($date);
        $query = $this->dweclaims_db->get();
        return $query->num_rows();
    }

    public function get_total_accumulated_PHICAR_data($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->dweclaims_db->select('CSNO,PatientName,hcifee,profee,dischargedate,proc1date,datediff("' . date('Y-m-d') . '",proc1date) as age, pStatus,processdate')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus != "WITH CHEQUE"')
                ->where('tagged', 0)
                ->order_by('proc1date', 'ASC');
        return $this->dweclaims_db->count_all_results();
    }

    public function totalAccPhicAR($date) {
        $monthstart = date("Y-m-01", strtotime($date . "-01"));
        $monthend = date("Y-m-t", strtotime($date . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->dweclaims_db->select('sum(hcifee) as hospfee,sum(profee) as profee')
                ->from(masterview_vw)
                ->where('proc1date >= "' . $first . '"')
                ->where('proc1date <= "' . $end . '"')
                ->where('pStatus != "WITH CHEQUE"')
                ->where('tagged', 0);

        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }

    public function argrouping($grouping) {
        $this->ams_db->select('coacode,accttitle')
                ->from(coa_tbl);
        if ($grouping === "AR") {
            $this->ams_db->where("argroup ", '1');
        } else {
            $this->ams_db->where("apgroup ", '1');
        }
        $this->ams_db->order_by("accttitle", "ASC");
        $query = $this->ams_db->get();
        return $query->result_array();
    }

    /**
     * Get AR/AP Summary Account Aging
     * @author Alingling
     * @version 05-25-2019
     */
    public function get_acctng_summary_aging($coacode, $coveredmonth, $zero) {
        $monthend = date("Y-m-t", strtotime($coveredmonth . "-01"));
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');


        $order_column = array(null, "coaname", "slname", "accttype", "balance", "daysnow", "current", "upto30d", "upto45d", "upto60d", "upto90d", "above120d", "upto120d", "updatedby", "evaluated");
        $this->ams_db->select('*')
                ->from(accountaging_tbl);
        if ($zero == 0) {
            $this->ams_db->where('balance <>', 0);
        }
        if ($coacode <> "ALL") {
            $this->ams_db->where('coacode', $coacode);
        }
        $this->ams_db->where('monthbatch', $end)
        ;

        if (!empty($this->input->post("search")["value"])) {
            $this->ams_db->group_start()
                    ->like("slname", $this->input->post("search")["value"])
                    ->or_like("accttype", $this->input->post("search")["value"])
                    ->or_like("daysnow", $this->input->post("search")["value"])
                    ->or_like("updatedby", $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->ams_db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->ams_db->order_by("slname", "ASC");
        }
    }

    function make_acctng_summary_aging_datatables($coacode, $coveredmonth, $zero) {
        $this->get_acctng_summary_aging($coacode, $coveredmonth, $zero);
        if ($this->input->post("length") != -1) {
            $this->ams_db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->ams_db->get();
        return $query->result();
    }

    function get_acctng_summary_aging_filtered_data($coacode, $coveredmonth, $zero) {
        $this->get_acctng_summary_aging($coacode, $coveredmonth, $zero);
        $query = $this->ams_db->get();
        return $query->num_rows();
    }

    public function get_acctng_summary_aging_data($coacode, $coveredmonth, $zero) {
        $monthend = date("Y-m-t", strtotime($coveredmonth . "-01"));
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->ams_db->select('*')
                ->from(accountaging_tbl);
        if ($zero == 0) {
            $this->ams_db->where('balance <>', 0);
        }
        if ($coacode <> "ALL") {
            $this->ams_db->where('coacode', $coacode);
        }
        $this->ams_db->where('monthbatch', $end)
                ->order_by('slname', 'ASC');

        return $this->ams_db->count_all_results();
    }

    public function fetch_totalsummaryaging($coacode, $coveredmonth, $zero) {
        $monthend = date("Y-m-t", strtotime($coveredmonth . "-01"));
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->ams_db->select('sum(balance) as totalrisk, sum(current) as totalcurrent, sum(upto30d) as sum30days, sum(upto45d) as sum45days, sum(upto60d) as sum60days, sum(upto90d) as sum90days, sum(upto120d) as sum120days, sum(above120d) as sum120daysabove')
                ->from(accountaging_tbl);
        if ($zero == 0) {
            $this->ams_db->where('balance <>', 0);
        }
        if ($coacode <> "ALL") {
            $this->ams_db->where('coacode', $coacode);
        }
        $this->ams_db->where('monthbatch', $end);

        $query = $this->ams_db->get();
        return $query->row_array();
    }

    /**
     *
     * Get EClaims Summary Report
     * @author Alingling: 1-25-2018
     */
    public function fetch_eclaimssummary_report($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->dweclaims_db->select('pStatus,	sum(case when proc1date >= "' . $first . '" and proc1date <= "' . $end . '" then 1 else 0 end)  sent,
				sum(case when DATE_FORMAT(dischargedate,"%Y-%m-%d") >= "' . $first . '" and DATE_FORMAT(dischargedate,"%Y-%m-%d") <= "' . $end . '" then  1 else 0 end)  discharged')
                ->from(masterview_vw)
                ->group_by('pStatus')
                ->order_by('pStatus', 'ASC');


        $query = $this->dweclaims_db->get();
        return $query->result_array();
    }

    public function fetch_all_eclaimssummary_report($month) {
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');
        $this->dweclaims_db->select('sum(case when proc1date >= "' . $first . '" and proc1date <= "' . $end . '" then 1 else 0 end)  allsent,
				sum(case when DATE_FORMAT(dischargedate,"%Y-%m-%d") >= "' . $first . '" and DATE_FORMAT(dischargedate,"%Y-%m-%d") <= "' . $end . '" then  1 else 0 end)  alldischarged')
                ->from(masterview_vw);


        $query = $this->dweclaims_db->get();
        return $query->row_array();
    }

}
