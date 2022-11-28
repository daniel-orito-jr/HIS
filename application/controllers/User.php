<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('weblog_model');
        $this->load->model('surgical_model');
        $this->load->model('confine_model');
        $this->load->model('doh_model');
        $this->load->model('MembersMgmt_model', 'membersmgmt_model');
    }

    public function index() {
        $data["page_title"] = "Sign in";
        $data["css"] = array(
            'assets/vendors/plugins/bootstrap/css/bootstrap.css',
            'assets/vendors/plugins/node-waves/waves.css',
            'assets/vendors/plugins/animate-css/animate.css',
            'assets/vendors/plugins/sweetalert/sweetalert.css',
            'assets/vendors/css/style.css',
            'assets/vendors/css/themes/all-themes.css',
            'assets/css/myStyle.css',
            'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',);

        $data["js"] = array(
            'assets/vendors/plugins/jquery/jquery.min.js',
            'assets/vendors/plugins/bootstrap/js/bootstrap.js',
            'assets/vendors/plugins/node-waves/waves.js',
            'assets/vendors/plugins/jquery-validation/jquery.validate.js',
            'assets/vendors/js/admin.js',
            'assets/vendors/js/pages/examples/sign-in.js',
            'assets/vendors/plugins/sweetalert/sweetalert.min.js',
            'assets/vendors/plugins/momentjs/moment.js',
            'assets/js/myJs.js',
            'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',);
        $this->user_page(NULL, $data);
//        }else{
//            
//        }
    }

    public function sign_in() {
        $result = array('status' => false, 'error_acct' => false, 'error_pass' => false, 'error_access' => false);
        $result['error'] = '';
        $uname = $this->input->post('username');
        $pass = $this->input->post('password');
        if ($this->user_model->get_sign_in_data($uname, $pass)) {
            $result['user'] = $this->user_model->get_sign_in_data($uname, $pass);
            if ($result['user']['mobileapp'] == '1' && ($result['user']['Adminsys'] == '1' || $result['user']['medicalphic'] == '1')) {
                $result['user'] = $this->user_model->get_sign_in_data($uname, $pass);
                $this->set_session_data($result['user']); //pending
                $this->create_log('log in');
                $result['status'] = true;
            } else {
                $result['error_acct'] = true;
            }
        } else {
            $result['error_acct'] = true;
        }
        echo json_encode($result);
    }

    public function dashboard() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Dashboard";
            $data["census"] = $this->user_model->today_census();
            $data["census_month"] = $this->user_model->get_daily_census();
//            
//            $data['a'] = $this->user_model->get_phic_op_census($this->get_current_date("asdf"));
//            $data['phic']['totalpx'] = 0;
//            $data['phic']['totalamt'] = 0;
//            
//            $data["totalpayments"] = $this->user_model->get_phic_phic_payments_census($this->get_my());
//            
//            for ($i = 0; $i < count($data['a']); $i++) {
//                if ($data['a'][$i]['aging'] != "61 Days above") {
//                    $data['phic']['totalpx'] += intval($data['a'][$i]['total']);
//                    $data['phic']['totalamt'] += $data['a'][$i]['totalamount'];
//                }
//            }
//            
//            $data["adm"] = $this->user_model->get_today_add();
//            $data["disc"] = $this->user_model->get_today_disc();
//
//            $data["disadd"]["phic"]["admitted"] = 0; 
//            $data["disadd"]["phic"]["discharged"] = 0; 
//            $data["disadd"]["non"]["admitted"] = 0;
//            $data["disadd"]["non"]["discharged"] = 0; 
//            
//            for ($i = 0; $i < count($data["adm"]); $i++) {
//                if ($data["adm"][$i]["phicmembr"] === "Non-NHIP") {
//                        $data["disadd"]["non"]["admitted"]++;
//                }else{
//                        $data["disadd"]["phic"]["admitted"]++;
//                }
//            }
//
//            for ($i = 0; $i < count($data["disc"]); $i++) {
//                if ($data["disc"][$i]["phicmembr"] === "Non-NHIP") {
//                        $data["disadd"]["non"]["discharged"]++;
//                }else{
//                        $data["disadd"]["phic"]["discharged"]++;
//                }
//            }
//            
//              
//            $data["ward"] = $this->user_model->get_room_occupancy_ward_day();
//            $data["private"] = $this->user_model->get_room_occupancy_private_day();
//            $data["suite"] = $this->user_model->get_room_occupancy_suite_day();
//            
//            $data['onpro_1'] = $this->user_model->get_op_phic_accnt_dashboard('1');
//            $data['onpro_2'] = $this->user_model->get_op_phic_accnt_dashboard('2');
//            $data['onpro_3'] = $this->user_model->get_op_phic_accnt_dashboard('3');
//            $data['onpro_4'] = $this->user_model->get_op_phic_accnt_dashboard('4');
//            
//            $data['pending_1'] = $this->user_model->get_pending_claims_dashboard('1');
//            $data['pending_2'] = $this->user_model->get_pending_claims_dashboard('2');
//            $data['pending_3'] = $this->user_model->get_pending_claims_dashboard('3');
//            $data['pending_4'] = $this->user_model->get_pending_claims_dashboard('4');
//            
//            $data['sent_inpro'] = $this->user_model->get_sent_claims_dashboard('IN PROCESS');
//            $data['sent_rth'] = $this->user_model->get_sent_claims_dashboard('RTH');
//            $data['sent_denied'] = $this->user_model->get_sent_claims_dashboard('DENIED');
//            $data['sent_voucher'] = $this->user_model->get_sent_claims_dashboard('WITH VOUCHER');
//            $data['sent_cheque'] = $this->user_model->get_sent_claims_dashboard('WITH CHEQUE');
//            $data['sent_all'] = $this->user_model->get_sent_claims_dashboard('SENT');
//            
//            $data['phar_month'] = $this->user_model->get_phar_dashboard();
//            $data['phar_acc'] = $this->user_model->get_phar_acc_dashboard();



            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
                'assets/js/dashboard.js',
                'assets/js/lock.js');

            $this->user_page('dashboard', $data);
        } else {
            $this->index();
        }
    }

    public function crm() {
        if ($this->has_log_in()) {
            $data["page_title"] = "CRM";
            $data["css"] = array
                (
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css',
                'assets/vendors/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/vendors/plugins/morrisjs/morris.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/MaterialDesign-Webfont-master/css/materialdesignicons.min.css',
                'assets/css/myCSS.css',
                'assets/css/myStyle.css'
            );

            $data["js"] = array
                (
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/jquery-countto/jquery.countTo.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/plugins/chartjs/Chart.bundle.js',
                'assets/vendors/plugins/raphael/raphael.min.js',
                'assets/vendors/plugins/morrisjs/morris.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/js/horizontalmorrisbargraph.js',
                'assets/js/crmjs.js',
                'assets/js/lock.js'
            );

            $this->user_page('crm', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_total_accumulated_PHICAR() {
        $s_date = new DateTime($this->input->post('month'));
        $fetch_data = $this->user_model->make_total_accumulated_PHICAR_datatables($s_date->format('Y-m-d'));
        $fetch_total = $this->user_model->totalAccPhicAR($s_date->format('Y-m-d'));
        $data = array();
        $total = array('hcifee' => 0.00, 'profee' => 0.00);
        $total['hcifee'] = $fetch_total['hospfee'];
        $total['profee'] = $fetch_total['profee'];
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->CSNO;
            $sub_array[] = $row->PatientName;
            $sub_array[] = $this->format_money($row->hcifee);
            $sub_array[] = $this->format_money($row->profee);
            $sub_array[] = $this->format_date($row->dischargedate);
            $sub_array[] = $this->format_date($row->proc1date);
            $sub_array[] = $row->age;
            $sub_array[] = $row->pStatus;
            $sub_array[] = $this->format_date($row->processdate);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_total_accumulated_PHICAR_data($s_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_total_accumulated_PHICAR_filtered_data($s_date->format('Y-m-d')),
            "data" => $data,
            "totalx" => $total
        );
        echo json_encode($output);
    }

    //fetch_onprocess_info: alingling
    public function fetch_dashboard_onpro_info() {
        $aging = $this->input->post('age');
//        $end_age = $this->input->post('end_age');
        $total = array('hospp' => 0, 'proff' => 0, 'totalamount' => 0);
        $totalamt = $this->user_model->get_op_phic_accnt_dashboard_total($aging);
        $total["hospp"] = $totalamt['hospp'];
        $total["proff"] = $totalamt['proff'];
        $total['totalamount'] = $totalamt['hospp'] + $totalamt['proff'];

        $fetch_data = $this->user_model->make_op_phic_accnt_dashboard_datatables($aging);
        $data = array();
        foreach ($fetch_data as $row) {
//           $order_column = array("patname","admitdate","dischadate","membertype","aging");
            $sub_array = array();
            $sub_array[] = $row->caseno;
            $sub_array[] = $row->name;
            $sub_array[] = $this->format_datexx($row->admitdate);
            $sub_array[] = $this->format_datexx($row->dischadate);
            $sub_array[] = $this->format_money($row->phicHCItotal);
            $sub_array[] = $this->format_money($row->PHICpfTotal);
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->aging;

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_op_phic_accnt_dashboard_data($aging),
            "recordsFiltered" => $this->user_model->get_op_phic_accnt_dashboard_filtered_data($aging),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function fetch_dashboard_nontransmit_info() {
        $aging = $this->input->post('age');
        $fetch_data = $this->user_model->make_nontransmit_claims_datatables($aging);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->batchno;
            $sub_array[] = $row->PatientName;
            $sub_array[] = $this->format_datexx($row->processdate);
            $sub_array[] = $row->claimno;
            $sub_array[] = $row->patpin;
            $sub_array[] = $row->aging;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_nontransmit_claims_data($aging),
            "recordsFiltered" => $this->user_model->get_nontransmit_claims_filtered_data($aging),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //fetch_transmitted_info: alingling
    public function fetch_dashboard_eclaimstat_patients() {
        $stat = $this->input->post('stat');
        $sentEclaimsDate = $this->input->post('sentEclaimsDate');
        $fetch_data = $this->user_model->make_eclaims_datatables($stat,$sentEclaimsDate);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->patpin;
            $sub_array[] = $row->PatientName;
            $sub_array[] = $this->format_money($row->hcifee);
            $sub_array[] = $this->format_money($row->profee);
            $sub_array[] = $this->format_date($row->dischargedate);
            $sub_array[] = $this->format_date($row->ReceiveDate);
            $sub_array[] = $row->age;
            $sub_array[] = $row->pStatus;
            $sub_array[] = $this->format_date($row->proc1date);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_eclaims_data($stat,$sentEclaimsDate),
            "recordsFiltered" => $this->user_model->get_eclaims_filtered_data($stat,$sentEclaimsDate),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function census($page) {
        if ($this->has_log_in()) {
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js',
                'assets/js/roompercent.js',
                'assets/vendors/js/accounting.js');

            switch ($page) {
                case "casetype":
                    $data["page_title"] = "Case Type Census";
                    $this->user_page('phicCensus', $data);
                    break;
                case "patType":
                    $data["page_title"] = "Patient Type Census";
                    $this->user_page('patientTypeCensus', $data);
                    break;
                case "doctors":
                    $data["page_title"] = "Doctor's Census";
                    $data["expertise"] = $this->user_model->get_all_expertise();
                    $this->user_page('doctorCensus', $data);
                    break;
                case "allpatients":
                    $data["page_title"] = "Patient's Census";
                    $this->user_page('patCensus', $data);
                    break;
                case "classifications":

                    $data["page_title"] = "Patient Classification Census";
                    $data["doctors"] = $this->user_model->get_alldoctors();
                    $this->user_page('classCensus', $data);
                    break;
                case "patients":
                    $data["page_title"] = "Patient Classification Census";
                    $this->user_page('disAddPatientsCensus', $data);
                    break;
                case "ros":
                    $data["page_title"] = "Room Occupational Statistics";
                    $this->user_page('rosCensus', $data);
                    break;
                case "ros1":

                    $data["page_title"] = "Room Occupational Statistics";
                    $date = new DateTime($this->input->post('start_date'));

                    $data["ward"] = $this->user_model->get_room_occupancy_ward_data($date->format("Y-m-d"));
                    $data["private"] = $this->user_model->get_room_occupancy_private_data($date->format("Y-m-d"));

                    $this->user_page('roompercent', $data);
                    break;
                default:
                    show_404();
                    break;
            }
        } else {
            $this->index();
        }
    }

    public function get_ward() {
        $result = array('status' => FALSE);
        $date = new DateTime($this->input->post('start_date'));

        $result["census"] = $this->user_model->get_patients_data($date->format("Y-m-d"), '', 0);

        $result["ward"] = $this->user_model->get_room_occupancy_ward_data($date->format("Y-m-d"));
        $result["private"] = $this->user_model->get_room_occupancy_private_data($date->format("Y-m-d"));
        $result["suite"] = $this->user_model->get_room_occupancy_suite_data($date->format("Y-m-d"));

        $result['status'] = true;
        echo json_encode($result);
    }

    public function expenses() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data['totaldebit'] = 0;
            $data['expenses'] = $this->user_model->get_raw_expenses();

            for ($i = 0; $i < count($data['expenses']); $i++) {
                $data['totaldebit'] += $data['expenses'][$i]['debit'];
            }

            for ($i = 0; $i < count($data['expenses']); $i++) {
                $data['totaldebit'] -= $data['expenses'][$i]['credit'];
            }

            $data["page_title"] = "Expenses";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
//                'assets/vendors/js/pages/ui/tooltips-popovers.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/expenses.js',
                'assets/js/lock.js');


            $this->user_page('expenses', $data);
        } else {
            $this->index();
        }
    }

    public function phiconprocess() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - On Process";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
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
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/onpro.js',
                'assets/js/lock.js');

            $this->user_page('onProcessPhicAcct', $data);
        } else {
            $this->index();
        }
    }

    // transmitted: Alingling
    public function phictransmitted() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - Transmitted";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/transmitphic.js',
                'assets/js/lock.js');

            $this->user_page('transmitPhicAcct', $data);
        } else {
            $this->index();
        }
    }

    //payments_Phic: Alingling
    public function phicpayments() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - Payments";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/paymentphic.js',
                'assets/js/lock.js');

            $this->user_page('paymentPhicAcct', $data);
        } else {
            $this->index();
        }
    }

    //

    public function disphic() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - Total PHIC Discharges";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/js/myJs.js',
                'assets/js/disphic.js',
                'assets/js/lock.js');

            $this->user_page('disPhic', $data);
        } else {
            $this->index();
        }
    }

    public function forapproval() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Purchase - For Approval";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/checkbox.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/js/myJs.js',
                'assets/js/purchases1.js',
                'assets/vendors/js/pages/widgets/infobox/infobox-4.js',
                'assets/vendors/plugins/jquery-countto/jquery.countTo.js',
                'assets/vendors/plugins/jquery-sparkline/jquery.sparkline.js',
                'assets/vendors/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js');
//             $data['frequency'] = $this->user_model->get_med_frequency();
            $this->user_page('purchases1', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_log() {
        if ($this->has_log_in()) {
            $fetch_data = $this->user_model->make_all_log_datatables();
            $data = array();
            foreach ($fetch_data as $row) {

                $sub_array = array();

                $sub_array[] = $row->logername;
                $sub_array[] = $row->action;
                $sub_array[] = $row->logdate;
                $sub_array[] = $row->devicetype;
                $sub_array[] = $row->deviceos;
                $sub_array[] = $row->browser;
                $data[] = $sub_array;
            }
            $output = array(
                "draw" => intval($this->input->post("draw")),
                "recordsTotal" => $this->user_model->get_all_log_data(),
                "recordsFiltered" => $this->user_model->get_all_log_filtered_data(),
                "data" => $data
            );
            echo json_encode($output);
        } else {
            show_404();
        }
    }

    public function activitylog($a = NULL) {
        if ($this->has_log_in()) {
            if ($a === "itko") {
                $data["page_title"] = "Activity Log";
                $data["css"] = array(
                    'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                    'assets/vendors/plugins/node-waves/waves.css',
                    'assets/vendors/plugins/animate-css/animate.css',
                    'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                    'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                    'assets/vendors/plugins/sweetalert/sweetalert.css',
                    'assets/vendors/css/style.css',
                    'assets/vendors/css/responsive.css',
                    'assets/vendors/css/checkboxes.css',
                    'assets/vendors/css/themes/all-themes.css',
                    'assets/css/myStyle.css');

                $data["js"] = array(
                    'assets/vendors/plugins/jquery/jquery.min.js',
                    'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                    'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                    'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                    'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                    'assets/vendors/plugins/node-waves/waves.js',
                    'assets/vendors/plugins/momentjs/moment.js',
                    'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                    'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                    'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                    'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                    'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                    'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                    'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                    'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                    'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                    'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                    'assets/vendors/js/responsive.js',
                    'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                    'assets/vendors/js/admin.js',
                    'assets/vendors/js/checkbox.js',
                    'assets/vendors/js/accounting.js',
                    'assets/vendors/js/pages/forms/advanced-form-elements.js',
                    'assets/vendors/js/demo.js',
                    'assets/js/log.js');

                $this->user_page('webLog', $data);
            } else {
                show_404();
            }
        } else {
            $this->index();
        }
    }

    public function onprocess() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Purchase - On Process";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/js/myJs.js',
                'assets/js/process1.js');

            $this->user_page('onProcessPur1', $data);
        } else {
            $this->index();
        }
    }

    public function approvedPur() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Purchase - Approved";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/js/myJs.js',
                'assets/js/approvedpur1.js',
                'assets/vendors/js/accounting.js');

            $this->user_page('approvedPur1', $data);
        } else {
            $this->index();
        }
    }

    public function disapprovedPur() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Purchase - Disapproved";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/js/myJs.js',
                'assets/js/disapprovedPur.js',
                'assets/vendors/js/accounting.js');

            $this->user_page('disapprovePur1', $data);
        } else {
            $this->index();
        }
    }

    public function deffered() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Purchase - Deffered";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/js/myJs.js',
                'assets/js/deffer1.js',
                'assets/vendors/js/accounting.js');

            $this->user_page('defferedPur1', $data);
        } else {
            $this->index();
        }
    }

    /* For Cheque Approval Page
     * @author Alingling
     *
     */

    public function chequeapproval() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Cheque Approval";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/voucher.js');

            $this->user_page('chequeapproval', $data);
        } else {
            $this->index();
        }
    }

    /* For Cheque Monitoring Page
     * @author Alingling
     *
     */

    public function chequemonitor() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Cheque Monitoring";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/chequemonitor.js',
                'assets/js/voucher.js');

            $this->user_page('chequemonitor', $data);
        } else {
            $this->index();
        }
    }

    //

    public function casetype() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Case Type Census";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js');

            $this->user_page('phicCensus', $data);
        } else {
            $this->index();
        }
    }

    public function patientdept() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Case Type Census";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js');

            $this->user_page('patientTypeCensus', $data);
        } else {
            $this->index();
        }
    }

    public function records() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Show Records";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js');

            $this->user_page('viewRecords', $data);
        } else {
            $this->index();
        }
    }

    public function fixasset() {
        if ($this->has_log_in()) {
            $data['totaldebit'] = 0;
            $data['expenses'] = $this->user_model->get_raw_expenses();

            for ($i = 0; $i < count($data['expenses']); $i++) {
                $data['totaldebit'] += $data['expenses'][$i]['debit'];
            }

            for ($i = 0; $i < count($data['expenses']); $i++) {
                $data['totaldebit'] -= $data['expenses'][$i]['credit'];
            }

            $data["page_title"] = "Fixed Asset Monitoring";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
//                'assets/vendors/js/pages/ui/tooltips-popovers.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/fixasset.js',
                'assets/js/lock.js');


            $this->user_page('fixasset', $data);
        } else {
            $this->index();
        }
    }

    //

    public function lockscreen() {
        $data["page_title"] = "Lockscreen";
        $data["css"] = array(
            'assets/vendors/plugins/bootstrap/css/bootstrap.css',
            'assets/vendors/plugins/node-waves/waves.css',
            'assets/vendors/plugins/animate-css/animate.css',
            'assets/vendors/css/style.css',
            'assets/vendors/css/themes/all-themes.css',
            'assets/css/myStyle.css');

        $data["js"] = array(
            'assets/vendors/plugins/jquery/jquery.min.js',
            'assets/vendors/plugins/bootstrap/js/bootstrap.js',
            'assets/vendors/plugins/node-waves/waves.js',
            'assets/vendors/plugins/jquery-validation/jquery.validate.js',
            'assets/vendors/js/admin.js',
            'assets/vendors/js/pages/examples/sign-in.js',
            'assets/js/myJs.js');
        $this->user_page('lockscreen', $data);
    }

    public function get_records() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            $s_date = new DateTime($this->input->post('start_date'));
            $e_date = new DateTime($this->input->post('end_date'));
            $config = array(
                array(
                    'field' => 'start_date',
                    'label' => 'Start Date',
                    'rules' => 'required|callback_validate_search_start_date'
                ),
                array(
                    'field' => 'end_date',
                    'label' => 'End Date',
                    'rules' => 'required|callback_validate_search_end_date'
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() === FALSE) {
                $result['error_s_date'] = form_error('start_date');
                $result['error_e_date'] = form_error('end_date');
            } else {
                if ($this->user_model->get_all_records($s_date->format('Y-m-d'), $e_date->format('Y-m-d')) !== false) {

                    $result = $this->user_model->get_all_records($s_date->format('Y-m-d'), $e_date->format('Y-m-d'));
                    $result['s_date'] = $s_date->format('Y-m-d');
                    $result['e_date'] = $e_date->format('Y-m-d');
                    $result['status'] = TRUE;
                }
                $result['count'] = count($this->user_model->get_all_records($s_date->format('Y-m-d'), $e_date->format('Y-m-d')));
            }
        }
        echo json_encode($result);
    }

    public function validate_search_start_date($date) {
        $now = new DateTime();
        $curr_date = $now->format('Y-m-d');

        $input_date = new DateTime($date);
        $start_date = $input_date->format('Y-m-d');

        if ($start_date > $curr_date) {
            $this->form_validation->set_message('validate_search_start_date', 'Start date must be equal or lesser the current date.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function validate_search_end_date($date) {
        $now = new DateTime();
        $curr_date = $now->format('Y-m-d');
        $s_date = new DateTime($this->input->post('start_date'));
        $start_date = $s_date->format('Y-m-d');

        $input_date = new DateTime($date);
        $end_date = $input_date->format('Y-m-d');

        if ($end_date > $curr_date || $end_date < $start_date) {
            $this->form_validation->set_message('validate_search_end_date', 'End date must be greater than or equal to start date and lesser than or equal to current date.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function fetch_each_day_census() {
        $date = new DateTime($this->input->post("date"));

        $fetch_data = $this->user_model->make_each_day_census_datatables($date->format("Y-m-d"));
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->name;
            $sub_array[] = $row->admitdate;
            $sub_array[] = $row->dischadate;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->age;
            $sub_array[] = $row->bday;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_each_day_census_data($date->format("Y-m-d")),
            "recordsFiltered" => $this->user_model->get_each_day_census_filtered_data($date->format("Y-m-d")),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetch_monthly_transmittal() {
        $date = new DateTime($this->input->post("datex"));

        $fetch_data = $this->user_model->make_monthly_transmittal_datatables($date->format("Y-m-d"));
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->name;
            $sub_array[] = $this->format_money($row->caserateTotalActual);
            $sub_array[] = $this->format_date($row->dischadate);
            $sub_array[] = $this->format_date($row->postingdateclaim);
            $sub_array[] = $row->age;
            $sub_array[] = $row->phicmembr;
            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_monthly_transmittal_data($date->format("Y-m-d")),
            "recordsFiltered" => $this->user_model->get_monthly_transmittal_filtered_data($date->format("Y-m-d")),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function sign_out($type = 'logout') {
        if ($this->has_log_in()) {
            $this->create_log('log out');
            $userdata = array('empname', 'empId', 'usertype', 'userid', 'approver', 'prapprover', 'poapprover', 'logged_in');
            $this->session->unset_userdata($userdata);

            if ($type === 'xp') {
                $this->session->set_flashdata('action', 'xp');
            } else {
                $this->session->sess_destroy();
            }
            redirect('user', 'refresh');
        } else {
            $this->index();
        }
    }

    public function get_proofsheet() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            $s_date = new DateTime($this->input->post('start_date'));
            $e_date = new DateTime($this->input->post('end_date'));
            $config = array(
                array(
                    'field' => 'start_date',
                    'label' => 'Start Date',
                    'rules' => 'required|callback_validate_search_start_date'
                ),
                array(
                    'field' => 'end_date',
                    'label' => 'End Date',
                    'rules' => 'required|callback_validate_search_end_date'
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() === FALSE) {
                $result['error_s_date'] = form_error('start_date');
                $result['error_e_date'] = form_error('end_date');
            } else {
                $result['s_date'] = $s_date->format('Y-m-d');
                $result['e_date'] = $e_date->format('Y-m-d');
                $result['proofsheets_cash'] = $this->user_model->get_proofs(0, $s_date->format('Y-m-d'), $e_date->format('Y-m-d'));
                $result['proofsheets_date'] = $this->user_model->get_proofs(1, $s_date->format('Y-m-d'), $e_date->format('Y-m-d'));
                $result['status'] = TRUE;
            }
        }
        echo json_encode($result);
    }

    public function fetch_purchases($type) {

        $fetch_data = $this->user_model->make_all_purchases_datatables($type);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            if ($type === "fapproval") {
                $sub_array[] = '';
            }

            $qty = "'" . $row->dscr . '@' . $row->control . '@' . $row->qty . "'";
//            $qq = json_encode($qty);
            $sub_array[] = $row->dscr . '<i style="float: right" tabindex="0" role="button" style="margin-top: -4px" data-toggle="popover"
                                            data-placement="bottom" data-container="body" data-trigger="focus" data-html="true" data-content="
                                            <table>
                                                <tr><td>Supplier:</td><td>' . $row->suppliername . '</td></tr>
                                                <tr><td>Address:</td><td>' . $row->address . '</td></tr>
                                                <tr><td>Term:</td><td>' . $row->term . '</td></tr>
                                                <tr><td>PO Date:</td><td>' . $row->podate . '</td></tr>
                                                <tr><td>Request Date:</td><td>' . $row->reqdatetime . '</td></tr>
                                                <tr><td>Balance Qty:</td><td>' . intval($row->balqty) . '</td></tr>
                                            </table>"
                                            data-title="Details" class="material-icons">report</i>';
            $sub_array[] = $row->reqdatetime;
            $sub_array[] = $this->format_money($row->cost);
            if ($type === "fapproval") {
                $sub_array[] = intval($row->qty) . '<i style="float: right" tabindex="0" role="button" style="margin-top: -4px" 
                                            data-placement="bottom" data-container="body"  onclick="editquantity(' . $qty . ')"
                                            data-title="Details" class="material-icons">mode_edit</i>';
            } else {
                $sub_array[] = intval($row->qty);
            }

            $sub_array[] = $this->format_money($row->totalcost);



            if ($type === "fapproval") {
                $sub_array[] = '<button type="button" id="' . $row->stockbarcode . '" class="btn btn-success waves-effect ledger-btn">Show</button>';
                $sub_array[] = $row->control;
                $sub_array[] = '';
            }
            if ($type === "deffer") {
                $sub_array[] = $row->noteofresubmission;
            }
            if ($type === "disaprove") {
                $sub_array[] = $row->noteofdisapproval;
            }
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_purchases_data($type),
            "recordsFiltered" => $this->user_model->get_all_purchases_filtered_data($type),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function changeqty() {
        $result = array('status' => false);
        $data['id'] = $this->input->post('idx');
        $result['id'] = $this->input->post('idx');
        $data['qty'] = $this->input->post('newqtyx');
        $data['oldqty'] = $this->input->post('oldqty');
        $data['item'] = $this->input->post('item');


        if ($this->user_model->changeqty($data)) {
            if ($this->user_model->changeqtylog($data)) {
                $result['status'] = true;
            }
        }
        echo json_encode($result);
    }

    /* For Cheque Approval Content
     * @author Alingling
     */

    public function fetch_chequeapproval() {
        $fetch_data = $this->user_model->make_all_ticket_datatables();
        $data = array();
        foreach ($fetch_data as $row) {


            $sub_array = array();
//            $sub_array[] = $row->TICKETDATE;
            $sub_array[] = '';
            $sub_array[] = '<i style="float: right" tabindex="0" role="button" style="margin-top: -4px" 
                                            data-placement="bottom" data-container="body" onclick="voucher.get_ticketdetails(' . $row->TICKETREF . ')"
                                            data-title="Details" class="material-icons bg-red">report</i>';
            $sub_array[] = $this->format_money($row->CHEQUEAMT);
            $sub_array[] = $this->format_date($row->CHKDATETIME);
            $sub_array[] = $row->EXPLANATION;
            $sub_array[] = $this->format_date($row->TICKETDATE) . '<br>' . $row->TICKETCODE;
            $sub_array[] = $row->TICKETREF;
            $sub_array[] = '';
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_ticket_data(),
            "recordsFiltered" => $this->user_model->get_all_ticket_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetch_disapprovedticket() {
        $fetch_data = $this->user_model->make_all_disapprovedticket_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $this->format_dates($row->APRVDATETIME);
            $sub_array[] = $row->PAYEE . '<i style="float: right" tabindex="0" role="button" style="margin-top: -4px" 
                                            data-placement="bottom" data-container="body"  onclick="voucher.get_ticketdetail(' . $row->TICKETREF . ')"
                                            data-title="Details" class="material-icons bg-red">help</i>';
            $sub_array[] = $this->format_money($row->CHEQUEAMT);
            $sub_array[] = $row->EXPLANATION;
            $sub_array[] = $this->format_date($row->TICKETDATE) . '<br>' . $row->TICKETCODE;
            $sub_array[] = $row->note;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_disapprovedticket_data(),
            "recordsFiltered" => $this->user_model->get_all_disapprovedticket_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetch_deferredticket() {
        $fetch_data = $this->user_model->make_all_deferredticket_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
//            $sub_array[] = ;
            $sub_array[] = $this->format_dates($row->APRVDATETIME);
            $sub_array[] = $row->PAYEE . '<i style="float: right" tabindex="0" role="button" style="margin-top: -4px" 
                                            data-placement="bottom" data-container="body"  onclick="voucher.get_ticketdetail(' . $row->TICKETREF . ')"
                                            data-title="Details" class="material-icons bg-red">help</i>';
            $sub_array[] = $this->format_money($row->CHEQUEAMT);
            $sub_array[] = $row->EXPLANATION;
            $sub_array[] = $this->format_date($row->TICKETDATE) . '<br>' . $row->TICKETCODE;
            $sub_array[] = $row->note;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_deferredticket_data(),
            "recordsFiltered" => $this->user_model->get_all_deferredticket_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetch_approvedticket() {

        $fetch_data = $this->user_model->make_all_approvedticket_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $this->format_date($row->TICKETDATE) . '<br>' . $row->TICKETCODE;
            $sub_array[] = $row->PAYEE;
            $sub_array[] = $this->format_money($row->CHEQUEAMT);
            $sub_array[] = $row->EXPLANATION;
            $sub_array[] = $row->note;
            $sub_array[] = $row->PREPARE;
            $sub_array[] = $row->CHEQUE;
            $sub_array[] = $row->APPROVE;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_approvedticket_data(),
            "recordsFiltered" => $this->user_model->get_all_approvedticket_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetch_approved_ticket_by_date() {
        $s_date = new DateTime($this->input->post('start_date'));
        //$a = new DateTime($this->input->post('start_date'));


        $fetch_data = $this->user_model->make_all_approvedticketbydate_datatables($s_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $this->format_date($row->TICKETDATE) . '<br>' . $row->TICKETCODE;
            $sub_array[] = $row->PAYEE;
            $sub_array[] = $this->format_money($row->CHEQUEAMT);
            $sub_array[] = $row->EXPLANATION;
            $sub_array[] = $row->note;
            $sub_array[] = $row->PREPARE;
            $sub_array[] = $row->CHEQUE;
            $sub_array[] = $row->APPROVE;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_approvedticketbydate_data($s_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_all_approvedticketbydate_filtered_data($s_date->format('Y-m-d')),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function get_ticketdetails() {
        $result = array('status' => false);
        $ticketdetailx = $this->input->post('ids');
        //  $result["ticketdetailx"] = $this->input->post('ids');
        $result["ticketdetail"] = $this->user_model->get_ticketdetails($ticketdetailx);

        $result['status'] = true;


        echo json_encode($result);
    }

    public function get_ticketdetailx() {
        $result = array('status' => false);
        $ticketdetailx = $this->input->post('ids');
        //  $result["ticketdetailx"] = $this->input->post('ids');
        $result["ticketdetail"] = $this->user_model->get_ticketdetailx($ticketdetailx);

        $result['status'] = true;



        echo json_encode($result);
    }

    public function approveticket() {
        $result = array('status' => false);
        $data['ticketref'] = $this->input->post('ticketref');
        if ($this->user_model->update_ticketdetails($data)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function app_ticket() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->approve_ticketdetails($this->input->post("controls"))) {
                $this->fetch_chequeapproval();
            } else {
                echo json_encode($result);
            }
        }
    }

    public function dis_ticket() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {

            if ($this->user_model->disapprove_ticketdetails($this->input->post("controls"))) {
                $this->fetch_chequeapproval();
            } else {
                echo json_encode($result);
            }
        }
    }

    public function def_ticket() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->deferred_ticketdetails($this->input->post("controls"))) {
                $this->fetch_chequeapproval();
            } else {
                echo json_encode($result);
            }
        }
    }

    public function check_ticket() {
        $result = array('status' => FALSE);
        $count = 0;
        if ($this->has_log_in()) {
            $ctrls = $this->input->post("controls");
            for ($i = 0; $i < count($ctrls); $i++) {
                if ($this->user_model->checkticket($ctrls[$i])) {
                    $result["ticket"] = $this->user_model->checkticket($ctrls[$i]);
//                $this->fetch_chequeapproval();
                    $result['status'] = true;
                    $count += 1;
                }
                $result["count"] = $count;
            }
            echo json_encode($result);
        }
    }

    public function checkapproveticket() {
        $result = array('status' => false);
        $data['ticketref'] = $this->input->post('ticketref');
        if ($this->user_model->checkapprovedticket($data)) {
            $result["ticketapproved"] = $this->user_model->checkapprovedticket($data);
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function checkapproveticket1() {
        $result = array('status' => false);
        $data['ticketref'] = $this->input->post('ids');
        if ($this->user_model->checkapprovedticket($data)) {
            $result["ticketapproved"] = $this->user_model->checkapprovedticket($data);
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function disapproveticket() {
        $result = array('status' => false);
        $data['ticketref'] = $this->input->post('disticketref');
        $data['note'] = $this->input->post('note');
        if ($this->user_model->update_ticketdetailsdis($data)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function deferticket() {
        $result = array('status' => false);
        $data['ticketref'] = $this->input->post('disticketref');
        $result['ticketref'] = $this->input->post('disticketref');
        $data['note'] = $this->input->post('note');
        if ($this->user_model->update_ticketdetailsdef($data)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function fetch_credit_debit_details($code) {

        $total = array('debit' => 0, 'credit' => 0.0);
        $fetch_data = $this->user_model->make_all_creditdebit_ticket_datatables($code);
        $data = array();
        foreach ($fetch_data as $row) {

            $total["debit"] += $row->DBAMT;
            $total["credit"] += $row->CRAMT;


            $sub_array = array();
//            $sub_array[] = $row->TICKETDATE;
            $sub_array[] = $row->COACODE;
            $sub_array[] = $row->ACCTTITLE;
            $sub_array[] = $this->format_money($row->DBAMT);
            $sub_array[] = $this->format_money($row->CRAMT);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_creditdebit_ticket_data($code),
            "recordsFiltered" => $this->user_model->get_all_creditdebit_ticket_filtered_data($code),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    /* For Cheque Monitoring Content
     * @author Alingling
     */

    public function fetch_chequemonitoring() {
        $total["cheque"] = 0;
        $fetch_data = $this->user_model->make_all_prep_ticket_datatables();
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();

            $sub_array[] = $row->PAYEE . '<i style="float: right" tabindex="0" role="button" style="margin-top: -4px" 
                                            data-placement="bottom" data-container="body" onclick="monitor.get_ticketdetails(' . $row->TICKETREF . ')"
                                            data-title="Details" class="material-icons bg-red">report</i>';
            $sub_array[] = $this->format_money($row->CHEQUEAMT);
            $sub_array[] = $this->format_date($row->CHKDATETIME);
            $sub_array[] = $row->EXPLANATION;
            $sub_array[] = $this->format_date($row->TICKETDATE) . '<br>' . $row->TICKETCODE;
            $sub_array[] = $row->TICKETREF;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_prep_ticket_data(),
            "recordsFiltered" => $this->user_model->get_all_prep_ticket_filtered_data(),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function fetch_all_check() {
        $total["cheque"] = 0;
        $fetch_data = $this->user_model->make_all_cheque_ticket_datatables();
        $data = array();
        foreach ($fetch_data as $row) {

            $total["cheque"] += $row->CHEQUEAMT;
            $sub_array = array();
//            $sub_array[] = $row->TICKETDATE;

            $sub_array[] = $row->PAYEE . '<i style="float: right" tabindex="0" role="button" style="margin-top: -4px" 
                                            data-placement="bottom" data-container="body" onclick="voucher.get_ticketdetails(' . $row->TICKETREF . ')"
                                            data-title="Details" class="material-icons bg-red">report</i>';
            $sub_array[] = $this->format_money($row->CHEQUEAMT);
            $sub_array[] = $this->format_date($row->CHKDATETIME);
            $sub_array[] = $row->EXPLANATION;
            $sub_array[] = $this->format_date($row->TICKETDATE) . '<br>' . $row->TICKETCODE;
            $sub_array[] = $row->TICKETREF;
            if ($row->PREPDONE === "1" AND $row->CHKDONE === "0") {
                $sub_array[] = "CURRENT";
            } else if ($row->CHKDONE === "1" AND $row->APRVDONE === '0' AND $row->RETURNTICKET === '0' AND $row->deferred === '0') {
                $sub_array[] = "CHECKED";
            } else if ($row->APRVDONE === "1") {
                $sub_array[] = "APPROVED";
            } else if ($row->RETURNTICKET === '1') {
                $sub_array[] = "DISAPPROVED";
            } else if ($row->deferred === '1') {
                $sub_array[] = "DEFERRED";
            } else {
                $sub_array[] = "";
            }
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_cheque_ticket_data(),
            "recordsFiltered" => $this->user_model->get_all_cheque_ticket_filtered_data(),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    //get all assets: Alingling

    public function get_assets() {
        $fetch_data = $this->user_model->make_all_assets_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->ControlNumber;
            $sub_array[] = $row->Category;
            $sub_array[] = $row->AssetType;
            $sub_array[] = $row->Department;
            $sub_array[] = $row->Manufacturer;
            $sub_array[] = $row->Suppliers;
            $sub_array[] = $row->Quantity;
            $sub_array[] = $this->format_date($row->DatePurchase);
            $sub_array[] = $row->PersonResponsible;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_assets_data(),
            "recordsFiltered" => $this->user_model->get_all_assets_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

    // get asset info, i.e. service date: Alingling
    public function get_assets_info() {
        $cnumber = $this->input->post('ID');
        $fetch_data = $this->user_model->make_all_assets_info_datatables($cnumber);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->Controlnumber;
            $sub_array[] = $this->format_date($row->ServiceDate);
            $sub_array[] = $row->Complaints;
            $sub_array[] = $row->Assetstatus;
            $sub_array[] = $row->Findings;

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_assets_info_data($cnumber),
            "recordsFiltered" => $this->user_model->get_all_assets_info_filtered_data($cnumber),
            "data" => $data,
            "count" => count($fetch_data)
        );
        echo json_encode($output);
    }

    //

    public function fetch_phic_dis() {
        $s_date = new DateTime($this->input->post('start_date'));
        $e_date = new DateTime($this->input->post('end_date'));


        $fetch_data = $this->user_model->make_phic_datatables($s_date->format('Y-m-d'), $e_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->c;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_phic_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_phic_filtered_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d')),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function app_purchase($type) {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
//            if ($this->user_model->approve_purchase($this->input->post("controls"))) 
            if ($this->user_model->approve_purchase1($this->input->post("pocode"))) {
                $this->fetch_purchase_supplier('fapproval');
//                $this->fetch_purchase_stocks();
            } else {
                echo json_encode($result);
            }
        }
    }

    public function app_purchase1($type) {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->approve_purchase($this->input->post("control"))) {
//            if ($this->user_model->approve_purchase1($this->input->post("control"))) 
//                  $this->fetch_purchase_supplier();
                $this->fetch_purchase_stocks($this->input->post("pocode"));
            } else {
                echo json_encode($result);
            }
        }
    }

    public function app_purchase_all() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->approve_purchase_all($this->input->post("controls"))) {
                $this->fetch_purchase_stocks($this->input->post("pocode"));
            } else {
                echo json_encode($result);
            }
        }
    }

    public function app_stocks() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->approve_purchase($this->input->post("control"))) {
                $this->fetch_purchase_stocks($this->input->post("pocode"));
            } else {
                echo json_encode($result);
            }
        }
    }

    public function disapp_stocks() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->disapprove_purchase($this->input->post("control"))) {
                $this->fetch_purchase_stocks($this->input->post("pocode"));
            } else {
                echo json_encode($result);
            }
        }
    }

    public function dis_purchase($type) {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
//            if ($this->user_model->disapprove_purchase($this->input->post("control"))) {
//                $this->fetch_purchase_supplier($type);
            if ($this->user_model->disapprove_purchase1($this->input->post("pocode"))) {
                $this->fetch_purchase_supplier('fapproval');

//                $this->fetch_purchase_stocks();
            } else {
                echo json_encode($result);
            }
        }
    }

    public function dis_purchase1($type) {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->disapprove_purchase($this->input->post("control"))) {
//                $this->fetch_purchase_supplier($type);
//            if ($this->user_model->disapprove_purchase1($this->input->post("pocode"))) {

                $this->fetch_purchase_stocks($this->input->post("pocode"));
//                $this->fetch_purchase_stocks();
            } else {
                echo json_encode($result);
            }
        }
    }

    public function dis_purchase_all() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->disapprove_purchase_all($this->input->post("controls"))) {
                $this->fetch_purchase_stocks($this->input->post("pocode"));
            } else {
                echo json_encode($result);
            }
        }
    }

    public function defapp_stocks() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->deffer_purchase($this->input->post("control"))) {
                $this->fetch_purchase_stocks($this->input->post("pocode"));
            } else {
                echo json_encode($result);
            }
        }
    }

    public function def_purchase_all() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->deffer_purchase_all($this->input->post("controls"))) {
                $this->fetch_purchase_stocks($this->input->post("pocode"));
            } else {
                echo json_encode($result);
            }
        }
    }

    public function proceed_to_po() {
        $result = array('status' => FALSE);
        $procode = $this->input->post('pocode');
        $dept = $this->input->post('dept');
        $department;
        if ($dept == "LABORATORY") {
            $department = "LT";
        } else if ($dept == "PHARMACY") {
            $department = "PH";
        } else if ($dept == "CSR") {
            $department = "CS";
        } else if ($dept == "RADIOLOGY") {
            $department = "RT";
        } else if ($dept == "ULTRASOUND") {
            $department = "US";
        } else {
            $department = "DIA";
        }


        if ($this->user_model->get_action_purchase($procode)) {

            $result['prmobile'] = $this->user_model->get_prapprovers_mobile($department);
            $result['noact'] = $this->user_model->get_action_purchase($procode);
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function proceed_po() {
        $result = array('status' => FALSE);
        $control = $this->input->post("control");
        $prnumber = $this->input->post("prnumber");
        $prmobile = $this->input->post('prmobile');
        $prdate = $this->input->post('prdate');
        $supplier = $this->input->post('supplier');
        $dept = $this->input->post('dept');



        $prapproval = $this->user_model->get_textdata();

        if ($this->user_model->deffer_purchase1($control)) {
            if ($prapproval['sendPRapproval'] == '1') {
                $this->user_model->send_message_pr($prmobile['mobileno'], $prnumber, $prdate, $supplier, $dept, $prapproval['HospitalPrefix']);
            }
            $this->user_model->update_prmaster($prnumber);
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function update_prmaster() {
        $result = array('status' => FALSE);
        $prnumber = $this->input->post("prnumber");
        $dept = $this->input->post('dept');
        $prdate = $this->input->post('prdate');
        $supplier = $this->input->post('supplier');
        $prapproval = $this->user_model->get_textdata();
        $department;
        if ($dept == "LABORATORY") {
            $department = "LT";
        } else if ($dept == "PHARMACY") {
            $department = "PH";
        } else if ($dept == "CSR") {
            $department = "CS";
        } else if ($dept == "RADIOLOGY") {
            $department = "RT";
        } else if ($dept == "ULTRASOUND") {
            $department = "US";
        } else {
            $department = "DIA";
        }
        if ($this->user_model->update_prmaster($prnumber)) {
            if ($prapproval['sendPRapproval'] == '1') {
                $prmobile = $this->user_model->get_prapprovers_mobile($department);
                $this->user_model->send_message_pr($prmobile['mobileno'], $prnumber, $prdate, $supplier, $dept, $prapproval['HospitalPrefix']);
            }
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function def_purchase($type) {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
//            if ($this->user_model->deffer_purchase($this->input->post("controls"))) {
//                $this->fetch_purchases($type);
//            }else{
//               echo json_encode($result); 
//            }
            if ($this->user_model->deffer_purchase1($this->input->post("pocode"))) {
                $this->fetch_purchase_supplier('fapproval');
//                $this->fetch_purchase_stocks();
            } else {
                echo json_encode($result);
            }
        }
    }

    public function def_purchase1($type) {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->deffer_purchase($this->input->post("control"))) {
                $this->fetch_purchase_stocks($this->input->post("pocode"));
            } else {
                echo json_encode($result);
            }
        }
    }

    public function get_proofsheet_details($by) {
        $result = array('status' => FALSE);

        if ($this->has_log_in()) {
            $result['proof_details'] = $this->user_model->get_proof_details($by);
            $result['status'] = TRUE;
        }

        echo json_encode($result);
    }

    public function fetch_ros() {
        $result = array('status' => FALSE);
        $counter = 0;
        if ($this->has_log_in()) {
            for ($i = 4; $i >= 0; $i--) {
                $endDate = new DateTime($this->input->post('start_date'));
                $date = $endDate->sub(new DateInterval('P' . $i . 'D'))->format('Y-m-d');
                $result['rooms'][$counter] = $this->user_model->get_rooms($date);
                $counter++;
                $result['date'][$i] = $date;
            }

            $result['status'] = TRUE;
        }

        echo json_encode($result);
    }

    public function create_chart() {
        $result = array('status' => FALSE);

        if ($this->user_model->get_daily_census()) {
            $result['censusx'] = $this->user_model->get_daily_census();
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }

    public function fetch_monthly_census() {
        $result = array('status' => FALSE);

        if ($this->user_model->get_monthly_census()) {
            $result['censusm'] = $this->user_model->get_monthly_census();
            $result['status'] = TRUE;
        }
        echo json_encode($result);
    }

    public function create_log($action) {
        $this->load->library('user_agent');

        $data = array();

        $data["action"] = $action;
        $data["type"] = ($this->agent->is_mobile()) ? "mobile" : "pc";
        $data["os"] = $this->agent->platform();
        $data["name"] = $this->agent->mobile();
        $data["browser"] = $this->agent->browser() . ' ' . $this->agent->version();

        $this->weblog_model->insert_log($data);
    }

    public function test() {
//        $now = new DateTime();
//        
//        echo $now->format("n");


        phpinfo();
    }

    public function cashflow() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Show Records";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/js/myJs.js',
                'assets/js/cashflow.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js');

            $this->user_page('cashFlow', $data);
        } else {
            $this->index();
        }
    }

    public function patients() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Show Records";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/js/myJs.js',
                'assets/js/onload.js',
                'assets/js/lock.js');

            $this->user_page('patients', $data);
        } else {
            $this->index();
        }
    }

    public function get_patients() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            $s_date = new DateTime($this->input->post('start_date'));
            $e_date = new DateTime($this->input->post('end_date'));
            $config = array(
                array(
                    'field' => 'start_date',
                    'label' => 'Start Date',
                    'rules' => 'required|callback_validate_search_start_date'
                ),
                array(
                    'field' => 'end_date',
                    'label' => 'End Date',
                    'rules' => 'required|callback_validate_search_end_date'
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() === FALSE) {
                $result['error_s_date'] = form_error('start_date');
                $result['error_e_date'] = form_error('end_date');
            } else {
                $result['s_date'] = $s_date->format('Y-m-d');
                $result['e_date'] = $e_date->format('Y-m-d');
                $result['d_count'] = $this->user_model->count_patients($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), 1);
                $result['a_count'] = $this->user_model->count_patients($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), 0);
                $result['status'] = TRUE;
            }
        }
        echo json_encode($result);
    }

    public function all_patients($type, $offset) {
        $result = array('status' => FALSE);
        $s_date = new DateTime($this->input->post('s_date'));
        $e_date = new DateTime($this->input->post('e_date'));
        if ($this->user_model->get_all_patients($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), intval($type), intval($offset))) {
            $result['patients'] = $this->user_model->get_all_patients($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), intval($type), intval($offset));
            $result['status'] = TRUE;
        }

        echo json_encode($result);
    }

    public function fetch_patients($type) {
        $s_date = new DateTime($this->input->post('start_date'));
        $e_date = new DateTime($this->input->post('end_date'));


        $fetch_data = $this->user_model->make_patients_datatables($s_date->format('Y-m-d'), intval($type));
        $data = array();
        foreach ($fetch_data as $row) {
//            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,roombrief,doctorname')
            $sub_array = array();
            $sub_array[] = $row->caseno;
            $sub_array[] = $row->name;
            $sub_array[] = $row->admitdate . "/" . $row->admittime;
            $sub_array[] = $row->dischadate . "/" . $row->dischatime;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_patients_data($s_date->format('Y-m-d'), intval($type)),
            "recordsFiltered" => $this->user_model->get_patients_filtered_data($s_date->format('Y-m-d'), intval($type)),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetch_patients_month($type) {
        $s_date = new DateTime($this->input->post('start_date'));


        $fetch_data = $this->user_model->make_patients_month_datatables($s_date->format('Y-m-d'), intval($type));
        $data = array();
        foreach ($fetch_data as $row) {
//            $this->db->select('caseno,name, admitdate, admittime, dischadate, dischatime, pat_classification,roombrief,doctorname')
            $sub_array = array();
            $sub_array[] = $row->caseno;
            $sub_array[] = $row->name;
            $sub_array[] = $row->admitdate . "/" . $row->admittime;
            $sub_array[] = $row->dischadate . "/" . $row->dischatime;
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_patients_month_data($s_date->format('Y-m-d'), intval($type)),
            "recordsFiltered" => $this->user_model->get_patients_month_filtered_data($s_date->format('Y-m-d'), intval($type)),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetch_doctors() {
        $s_date = new DateTime($this->input->post('start_date'));
        $e_date = new DateTime($this->input->post('end_date'));
        $expert = $this->input->post('expert');



        $fetch_data = $this->user_model->make_doctors_datatables($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $expert);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->doctorid;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->expertise;
            $sub_array[] = $row->nhip;
            $sub_array[] = $row->non;
            $sub_array[] = $row->total;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_doctors_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $expert),
            "recordsFiltered" => $this->user_model->get_doctors_filtered_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $expert),
            "data" => $data,
            "expert" => $expert
        );
        echo json_encode($output);
    }

    public function fetch_ipd_patients() {
        $s_date = new DateTime($this->input->post('start_date'));
        $e_date = new DateTime($this->input->post('end_date'));


        $fetch_data = $this->user_model->make_ipd_patients_datatables($s_date->format('Y-m-d'), $e_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->admitted;
            $sub_array[] = $row->discharged_px;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_ipd_patients_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_ipd_patients_filtered_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d')),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetch_opd_patients() {
        $s_date = new DateTime($this->input->post('start_date'));
        $e_date = new DateTime($this->input->post('end_date'));


        $fetch_data = $this->user_model->make_opd_patients_datatables($s_date->format('Y-m-d'), $e_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->casetype;
            $sub_array[] = $row->admitted;
            $sub_array[] = $row->discharged_px;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_opd_patients_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_opd_patients_filtered_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d')),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetch_all_patients() {
        $fetch_data = $this->user_model->make_all_patients_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->name;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->admitdate . "/" . $row->admittime;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_patients_data(),
            "recordsFiltered" => $this->user_model->get_all_patients_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetch_expenses() {
        $this->user_model->create_exp_table();
        $fetch_data = $this->user_model->make_all_expenses_datatables();

        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->updated;
            $sub_array[] = $row->expgroup . '<i style="float: right" tabindex="0" role="button" style="margin-top: -4px" data-toggle="popover"
                                            data-placement="bottom" data-container="table" data-trigger="focus" data-content="' . $row->particulars . '"
                                            data-title="Particulars" class="material-icons">report</i>';
            $sub_array[] = $this->format_money($row->amount);
            $sub_array[] = $this->format_money($row->debit);
            $sub_array[] = $this->format_money($row->credit);
            $sub_array[] = doubleval($row->balance) <= 0.0 ? '<span style="color: red">' . $this->format_money($row->balance) . '</span>' : '<span style="color: green">' . $this->format_money($row->balance) . '</span>';
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_expenses_data(),
            "recordsFiltered" => $this->user_model->get_all_expenses_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetch_classifications() {
        $s_date = new DateTime($this->input->post('start_date'));
        $e_date = new DateTime($this->input->post('end_date'));
        $doccode = $this->input->post('doccode');

        $fetch_data = $this->user_model->make_all_patients_classification_datatables($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->c;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_patients_classification_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode),
            "recordsFiltered" => $this->user_model->get_all_patients_classification_filtered_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetch_classifications_patients() {
        $s_date = new DateTime($this->input->post('start_date'));
        $e_date = new DateTime($this->input->post('end_date'));
        $classification = $this->input->post('classification');
        $doccode = $this->input->post('doccode');


        $fetch_data = $this->user_model->make_all_classification_patients_datatables($classification, $s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = $row->name;
            $sub_array[] = $this->format_dates($row->admit);
            $sub_array[] = $this->format_dates($row->discharge);
            $sub_array[] = $row->doctorname;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_classification_patients_data($classification, $s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode),
            "recordsFiltered" => $this->user_model->get_all_classification_patients_filtered_data($classification, $s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode),
            "data" => $data
        );
        echo json_encode($output);
    }

    //dispo info: Alingling
    public function fetch_dispo_patients() {
        $s_date = new DateTime($this->input->post('start_date'));
        $e_date = new DateTime($this->input->post('end_date'));
        $classification = $this->input->post('classification');
        $doccode = $this->input->post('doccode');

        $fetch_data = $this->user_model->make_all_disposition_patients_datatables($classification, $s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = $row->name;
            $sub_array[] = $this->format_dates($row->admit);
            $sub_array[] = $this->format_dates($row->discharge);
            $sub_array[] = $row->doctorname;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_disposition_patients_data($classification, $s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode),
            "recordsFiltered" => $this->user_model->get_all_disposition_patients_filtered_data($classification, $s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //fetch_onprocess_info: alingling
    public function fetch_onProcess_patients() {
        $s_date = new DateTime($this->input->post('start_date'));
        $aging = $this->input->post('aging');
//        $end_age = $this->input->post('end_age');
        $total = array('hospp' => 0, 'proff' => 0, 'totalamount' => 0);
        $totalamt = $this->user_model->get_onprocess_phic_patients_total($s_date->format('Y-m-d'), $aging);
        $total["hospp"] = $totalamt['hospp'];
        $total["proff"] = $totalamt['proff'];


        $fetch_data = $this->user_model->make_onprocess_phic_patient_datatables($s_date->format('Y-m-d'), $aging);
        $data = array();
        foreach ($fetch_data as $row) {
//           $order_column = array("patname","admitdate","dischadate","membertype","aging");
            $sub_array = array();
            $sub_array[] = $row->caseno;
            $sub_array[] = $row->name;
            $sub_array[] = $this->format_datexx($row->admitdate);
            $sub_array[] = $this->format_datexx($row->dischadate);
            $sub_array[] = $this->format_money($row->phicHCItotal);
            $sub_array[] = $this->format_money($row->PHICpfTotal);
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->aging;

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_onprocess_phic_patients_data($s_date->format('Y-m-d'), $aging),
            "recordsFiltered" => $this->user_model->get_onprocess_phic_patients_filtered_data($s_date->format('Y-m-d'), $aging),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function generate_onProcess_patients_report() {
        $s_date = $this->input->post('s_date');
        $aging = $this->input->post('agingx');

        $this->load->library('pdf');
        $start_date = new DateTime($s_date);
        $data['s_date'] = date_format($start_date, 'F j Y');
        $data['aging'] = $aging;
        $data['title'] = "ON PROCESS";
        $data["phicstat"] = $this->user_model->get_onprocess_phic_patients_report($start_date->format('Y-m-d'), $aging);
        $data['hospp'] = 0;
        $data['proff'] = 0;


        for ($i = 0; $i < count($data["phicstat"]); $i++) {
            $data['hospp'] += $data["phicstat"][$i]['phicHCItotal'];
            $data['proff'] += $data["phicstat"][$i]['PHICpfTotal'];
        }

//            
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $da = new DateTime($data['datenow']);
        $data['date'] = date_format($da, 'F j, Y');
        $data['time'] = date_format($da, 'H:i:s A');
//        
        $this->pdf->load_view('reports/onProcessinfo', $data);
        $this->pdf->set_paper('Legal', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(525, 20, "Page {PAGE_NUM} ", $font, 8, array(0, 0, 0));

        $this->pdf->stream('"' . $data['title'] . ").pdf", array('Attachment' => 0));
    }

    //fetch_onprocess_all_info: alingling
    public function fetch_onProcess_patients_all() {
        $s_date = new DateTime($this->input->post('start_date'));
        $aging = $this->input->post('aging');
//        $end_age = $this->input->post('end_age');


        $fetch_data = $this->user_model->make_onprocess_phic_patient_all_datatables();
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();

            $sub_array[] = $row->name;
            $sub_array[] = $this->format_dates($row->discharges);
            $sub_array[] = $row->phicmembr;

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_onprocess_phic_patients_all_data(),
            "recordsFiltered" => $this->user_model->get_onprocess_phic_patients_all_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

    //fetch_transmitted_info: alingling
    public function fetch_transmitted_patients() {
        $s_date = new DateTime($this->input->post('start_date'));
        $aging = $this->input->post('aging');

//        $end_age = $this->input->post('end_age');


        $fetch_data = $this->user_model->make_transmitted_phic_patient_datatables($s_date->format('Y-m-d'), $aging);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();

            $sub_array[] = $row->name;
            $sub_array[] = $this->format_date($row->dischadate);
            $sub_array[] = $this->format_date($row->postingdateclaim);
            $sub_array[] = $row->age;
            $sub_array[] = $row->phicmembr;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_transmitted_phic_patients_data($s_date->format('Y-m-d'), $aging),
            "recordsFiltered" => $this->user_model->get_transmitted_phic_patients_filtered_data($s_date->format('Y-m-d'), $aging),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //fetch_payment_transmittal_info: alingling
    public function fetch_payment_transmittal_patients() {
        $s_date = new DateTime($this->input->post('start_date'));
        $aging = $this->input->post('aging');
//        $end_age = $this->input->post('end_age');


        $fetch_data = $this->user_model->make_payment_transmittal_patient_datatables($s_date->format('Y-m-d'), $aging);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->name;
            $sub_array[] = $this->format_money($row->caserateTotalActual);
            $sub_array[] = $row->phicvoucherno;
            $sub_array[] = $this->format_date($row->postingdateclaim);
            $sub_array[] = $this->format_date($row->phicvoucherdate);
            $sub_array[] = $row->age;
            $sub_array[] = $row->phicmembr;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_payment_transmittal_patients_data($s_date->format('Y-m-d'), $aging),
            "recordsFiltered" => $this->user_model->get_payment_transmittal_patients_filtered_data($s_date->format('Y-m-d'), $aging),
            "data" => $data,
            "s_date" => $s_date
        );
        echo json_encode($output);
    }

    //fetch_payment_transmittal_info: alingling
    public function fetch_payment_discharge_patients() {
        $s_date = new DateTime($this->input->post('start_date'));
        $aging = $this->input->post('aging');
//        $end_age = $this->input->post('end_age');


        $fetch_data = $this->user_model->make_payment_discharge_patient_datatables($s_date->format('Y-m-d'), $aging);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();

            $sub_array[] = $row->name;
            $sub_array[] = $this->format_money($row->caserateTotalActual);
            $sub_array[] = $row->phicvoucherno;
            $sub_array[] = $this->format_date($row->dischadate);
            $sub_array[] = $this->format_date($row->phicvoucherdate);
            $sub_array[] = $row->age;
            $sub_array[] = $row->phicmembr;


            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_payment_discharge_patients_data($s_date->format('Y-m-d'), $aging),
            "recordsFiltered" => $this->user_model->get_payment_discharge_patients_filtered_data($s_date->format('Y-m-d'), $aging),
            "data" => $data
        );
        echo json_encode($output);
    }

    //fetch_admitted_day_info: alingling
    public function fetch_admitted_day_patients() {
        $admitDischaDate = $this->input->post('admitDischaDate');
        $fetch_data = $this->user_model->make_admitted_day_patient_datatables($admitDischaDate);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();

            $sub_array[] = $row->name;
            $sub_array[] = $this->format_dates($row->admission);
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $row->bday;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->admittedby;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_admitted_day_patient_data($admitDischaDate),
            "recordsFiltered" => $this->user_model->get_admitted_day_patient_filtered_data($admitDischaDate),
            "data" => $data
        );
        echo json_encode($output);
    }

    //fetch_admitted_day: alingling
    public function fetch_total_admitted_day_patients() {
        $fetch_data = $this->user_model->make_total_admitted_day_patient_datatables();
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();

            $sub_array[] = $row->name;
            $sub_array[] = $this->format_dates($row->admission);
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $row->bday;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->admittedby;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_total_admitted_day_patient_data(),
            "recordsFiltered" => $this->user_model->get_total_admitted_day_patient_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

    //fetch_discharged_day_info: alingling
    public function fetch_discharged_day_patients() {

        $admitDischaDate = $this->input->post('admitDischaDate');
        $fetch_data = $this->user_model->make_discharged_day_patient_datatables($admitDischaDate);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();

            $sub_array[] = $row->name;
            $sub_array[] = $this->format_dates($row->admission);
            $sub_array[] = $this->format_dates($row->discharged);
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_discharged_day_patient_data($admitDischaDate),
            "recordsFiltered" => $this->user_model->get_discharged_day_patient_filtered_data($admitDischaDate),
            "data" => $data
        );
        echo json_encode($output);
    }

    //fetch_phic_day_info: alingling
    public function fetch_admitted_phic_day_patients() {
        $fetch_data = $this->user_model->make_admitted__phic_day_patient_datatables();
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();

            $sub_array[] = $row->name;
            $sub_array[] = $this->format_dates($row->admission);
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $row->bday;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->admittedby;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_admitted_phic_day_patient_data(),
            "recordsFiltered" => $this->user_model->get_admitted__phic_day_patient_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

    //fetch_non-phic_day_info: alingling
    public function fetch_admitted_non_phic_day_patients() {
        $fetch_data = $this->user_model->make_admitted_non_phic_day_patient_datatables();
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();

            $sub_array[] = $row->name;
            $sub_array[] = $this->format_dates($row->admission);
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $row->bday;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->admittedby;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_admitted_non_phic_day_patient_data(),
            "recordsFiltered" => $this->user_model->get_admitted_non_phic_day_patient_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

    //fetch_room_occupancy_info: alingling
    public function fetch_room_occupancy() {
        $fetch_data = $this->user_model->make_discharged_day_patient_datatables();
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();

            $sub_array[] = $row->name;
            $sub_array[] = $this->format_dates($row->admission);
            $sub_array[] = $this->format_dates($row->discharged);
            $sub_array[] = $row->pat_classification;
            $sub_array[] = $row->Age;
            $sub_array[] = $row->roombrief;
            $sub_array[] = $row->doctorname;
            $sub_array[] = $row->phicmembr;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_discharged_day_patient_data(),
            "recordsFiltered" => $this->user_model->get_discharged_day_patient_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

    //
    //disposition: alingling
    public function fetch_disposition() {
        $s_date = new DateTime($this->input->post('start_date'));
        $e_date = new DateTime($this->input->post('end_date'));
        $doccode = $this->input->post('doccode');



        $fetch_data = $this->user_model->make_all_patients_disposition_datatables($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->disposition;
            $sub_array[] = $row->c;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_patients_disposition_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode),
            "recordsFiltered" => $this->user_model->get_all_patients_disposition_filtered_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode),
            "data" => $data
        );
        echo json_encode($output);
    }

    //


    public function fetch_proofsheets($by) {
        $s_date = new DateTime($this->input->post('start_date'));
        $e_date = new DateTime($this->input->post('end_date'));

//echo money_format('%(#10n', $number) . "\n";


        $fetch_data = $this->user_model->make_all_proofs_datatables(intval($by), $s_date->format('Y-m-d'), $e_date->format('Y-m-d'));
        $data = array();
        $button = '<button type="button" style="height: 30px" class="btn-details btn bg-teal waves-effect"><i style="margin-top: -4px" class="material-icons">details</i></button>';

        if (intval($by) === 1) {
            foreach ($fetch_data as $row) {
                $sub_array = array();
                $sub_array[] = $row->udate;
                $sub_array[] = $this->format_money($row->debit);
                $sub_array[] = $this->format_money($row->credit);
                $sub_array[] = $button;
                $data[] = $sub_array;
            }
        } else {
            foreach ($fetch_data as $row) {
                $sub_array = array();
                $sub_array[] = $row->udate;
                $sub_array[] = $row->updatedby;
                $sub_array[] = $this->format_money($row->debit);
                $sub_array[] = $this->format_money($row->credit);
                $sub_array[] = $button;
                $data[] = $sub_array;
            }
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_proofs_data(intval($by), $s_date->format('Y-m-d'), $e_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_all_proofs_filtered_data(intval($by), $s_date->format('Y-m-d'), $e_date->format('Y-m-d')),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetch_census($type) {
        $result = array('status' => FALSE);
        $s_date = new DateTime($this->input->post("start_date"));
        $e_date = new DateTime($this->input->post("end_date"));

        $result["px_records"] = $this->user_model->get_census_data($s_date->format("Y-m-d"), $e_date->format("Y-m-d"), intval($type));
        $result['status'] = TRUE;

        echo json_encode($result);
    }

    public function generate_exp_report() {
        $search = $this->input->post("search");

        $this->load->library('pdf');
        $data["exp"] = $this->user_model->exp_report($search);
        $data["title"] = "Expenses List";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $this->pdf->load_view('reports/expList', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("expenses-list.pdf", array('Attachment' => 0));
    }

    public function generate_opd_report() {
        $s_date = new DateTime($this->input->post("s_date"));
        $e_date = new DateTime($this->input->post("e_date"));
        $search = $this->input->post("search");

        $this->load->library('pdf');
        $data["s_date"] = $s_date->format("Y-m-d");
        $data["e_date"] = $e_date->format("Y-m-d");
        $data["opd"] = $this->user_model->opd_dis_ad_report($data["s_date"], $data["e_date"], $search);


        $this->pdf->load_view('reports/opdList', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("opd-dis-adm-list.pdf", array('Attachment' => 0));
    }

    public function generate_dis_phic_report() {
        $s_date = new DateTime($this->input->post("s_date"));
        $e_date = new DateTime($this->input->post("e_date"));
        $search = $this->input->post("search");

        $this->load->library('pdf');
        $data["s_date"] = $s_date->format("Y-m-d");
        $data["e_date"] = $e_date->format("Y-m-d");
        $data["members"] = $this->user_model->dis_phic_report($data["s_date"], $data["e_date"], $search);


        $this->pdf->load_view('reports/disphiclist', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("opd-dis-adm-list.pdf", array('Attachment' => 0));
    }

    public function generate_ipd_report() {
        $s_date = new DateTime($this->input->post("s_date"));
        $e_date = new DateTime($this->input->post("e_date"));
        $search = $this->input->post("search");

        $this->load->library('pdf');
        $data["s_date"] = $s_date->format("Y-m-d");
        $data["e_date"] = $e_date->format("Y-m-d");
        $data["ipd"] = $this->user_model->ipd_dis_ad_report($data["s_date"], $data["e_date"], $search);

        $this->pdf->load_view('reports/ipdList', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("ipd-dis-adm-list.pdf", array('Attachment' => 0));
    }

    public function generate_doc_report() {
        $s_date = new DateTime($this->input->post("s_date"));
        $e_date = new DateTime($this->input->post("e_date"));



        $this->load->library('pdf');
        $data["s_date"] = $s_date->format("Y-m-d");
        $data["e_date"] = $e_date->format("Y-m-d");
        $data['searc'] = $this->input->post('search');
        $data['exp'] = $this->input->post('exp');
        $data["dx_record"] = $this->user_model->doc_report($data);
        $data["title"] = "Doctors List";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $this->pdf->load_view('reports/doctorList', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("doctor-list.pdf", array('Attachment' => 0));
    }

    public function generate_px_report() {
        $search = $this->input->post("search");

        $this->load->library('pdf');
        $data["px_record"] = $this->user_model->px_report($search);
        $data['profile'] = $this->user_model->get_hospital();
        $data["title"] = "Patient List";
        $data['datenow'] = $this->get_current_date();
        $this->pdf->load_view('reports/patientList', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("patient-list.pdf", array('Attachment' => 0));
    }

    public function generate_class_report() {
        $s_date = new DateTime($this->input->post("s_date"));
        $e_date = new DateTime($this->input->post("e_date"));
        $data['doccode'] = $this->input->post("dokie");
        $data['docname'] = $this->input->post("dokiename");

        $this->load->library('pdf');
        $data["s_date"] = $s_date->format("Y-m-d");
        $data["date"] = $s_date->format("m-d-Y");
        $data["e_date"] = $e_date->format("Y-m-d");
        $data["end_date"] = $e_date->format("m-d-Y");
        $data["title"] = "Classifications List";
        $data["class_record"] = $this->user_model->class_report($data["s_date"], $data["e_date"], $data['doccode']);

        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $this->pdf->load_view('reports/classificationList', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("classification-list.pdf", array('Attachment' => 0));
    }

    public function generate_class_info_report() {
        $datex = new DateTime($this->input->post("datex"));
        $end_date = new DateTime($this->input->post('e_date'));
        $data['classx'] = $this->input->post("classification");
        $data['doccode'] = $this->input->post("dokie");
        $data['docname'] = $this->input->post("dokiename");

        $this->load->library('pdf');
        $data["s_date"] = $datex->format("Y-m-d");
        $data["end_date"] = $end_date->format("Y-m-d");
        $data['start_date'] = date_format($datex, "F j, Y");
        $data['end_datex'] = date_format($end_date, "F j, Y");
        $data["class_record"] = $this->user_model->class_info_report($data["s_date"], $data["end_date"], $data['classx'], $data['doccode']);

        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $this->pdf->load_view('reports/classificationpatList', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream('Classification-patients-list (' . $data['datx'] . ').pdf', array('Attachment' => 0));
    }

    public function generate_dispo_info_report() {
        $datex = new DateTime($this->input->post("datex"));
        $end_date = new DateTime($this->input->post('e_date'));
        $data['classx'] = $this->input->post("disposition");
        $data['doccode'] = $this->input->post("dokie");
        $data['docname'] = $this->input->post("dokiename");

        $this->load->library('pdf');
        $data["s_date"] = $datex->format("Y-m-d");
        $data["end_date"] = $end_date->format("Y-m-d");
        $data['start_date'] = date_format($datex, "F j, Y");
        $data['end_datex'] = date_format($end_date, "F j, Y");
        $data["class_record"] = $this->user_model->dispo_info_report($data["s_date"], $data["end_date"], $data['classx'], $data['doccode']);


        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $this->pdf->load_view('reports/classificationpatList', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream('Disposition-patients-list (' . $data['datx'] . ').pdf', array('Attachment' => 0));
    }

    //approvedticket: alingling



    public function generate_approvedticket_report() {
        $s_date = new DateTime($this->input->post("pdf_date"));


        $this->load->library('pdf');
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["s_date"] = $s_date->format("Y-m-d");
        $data["title"] = "Approved Ticket";
        $data["approvedticket_record"] = $this->user_model->approvedticket_report($data["s_date"]);

        $this->pdf->load_view('reports/approvedticket', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("Georgia", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("approved-ticket.pdf", array('Attachment' => 0));
    }

    //csv_approvedticket:alingling

    public function generate_csv_approvedticket_report() {
        $s_date = new DateTime($this->input->post("csv_date"));

        $data["s_date"] = $s_date->format("Y-m-d");
        $dateapproval = $s_date->format("m-d-Y");
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=approvedticket(' . $dateapproval . ').csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('Payee', 'Amount', 'Explanation', 'Date', 'Note'));

        $row = $this->user_model->csv_approvedticket_report($data["s_date"]);

        for ($i = 0; $i < count($row); $i++) {

            fputcsv($output, $row[$i]);
        }
        fclose($output);
    }

    //deferredticket: alingling
    public function generate_deferredticket_report() {
        $this->load->library('pdf');
        $data["s_date"] = $this->get_current_date();
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["title"] = "Deferred Ticket";

        $data["approvedticket_record"] = $this->user_model->deferredticket_report();

        $this->pdf->load_view('reports/approvedticket', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("deferred-ticket.pdf", array('Attachment' => 0));
    }

    //csv_deferredticket:alingling

    public function generate_csv_deferredticket_report() {

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=deferredticket.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('Deferral Date', 'Payee', 'Amount', 'Explanation', 'Date', 'Note'));

        $row = $this->user_model->csv_deferredticket_report();

        for ($i = 0; $i < count($row); $i++) {

            fputcsv($output, $row[$i]);
        }
        fclose($output);
    }

    //disapprovedticket:alingling

    public function generate_disapprovedticket_report() {
        $this->load->library('pdf');
        $data["s_date"] = $this->get_current_date();
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["title"] = "Disapproved Ticket";

        $data["approvedticket_record"] = $this->user_model->disapprovedticket_report();

        $this->pdf->load_view('reports/approvedticket', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("disapproved-ticket.pdf", array('Attachment' => 0));
    }

    //csv_disapprovedticket:alingling

    public function generate_csv_disapprovedticket_report() {

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=disapprovedticket.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('Disapproval Date', 'Payee', 'Amount', 'Explanation', 'Date', 'Note'));

        $row = $this->user_model->csv_disapprovedticket_report();

        for ($i = 0; $i < count($row); $i++) {
            fputcsv($output, $row[$i]);
        }
        fclose($output);
    }

    //disposition: alingling

    public function generate_dispo_report() {
        $s_date = new DateTime($this->input->post("s_date"));
        $e_date = new DateTime($this->input->post("e_date"));
        $data['doccode'] = $this->input->post("dokie");
        $data['docname'] = $this->input->post("dokiename");

        $this->load->library('pdf');
        $data["s_date"] = $s_date->format("Y-m-d");
        $data["date"] = $s_date->format("m-d-Y");
        $data["e_date"] = $e_date->format("Y-m-d");
        $data["end_date"] = $e_date->format("m-d-Y");
        $data["title"] = "Dispositions List";
        $data["dispo_record"] = $this->user_model->dispo_report($data["s_date"], $data["e_date"], $data['doccode']);
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $this->pdf->load_view('reports/dispoList', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("classification-list.pdf", array('Attachment' => 0));
    }

    //disposition

    public function generate_pat_report($type) {
        $s_date = new DateTime($this->input->post("s_date"));

        $this->load->library('pdf');

        $data["type"] = $type;
        if ($type == '3' OR $type == '4') {
            $data["s_date"] = $s_date->format("Y-m");
            $data["s_datex"] = $s_date->format("F Y");
        } else {
            $data["s_date"] = $s_date->format("Y-m-d");
            $data["s_datex"] = $s_date->format("F j, Y");
        }
        $data["pat_record"] = $this->user_model->pat_report($data["s_date"], intval($type));

        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $this->pdf->load_view('reports/patList', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));

        if (intval($data["type"]) === 0) {
            $this->pdf->stream("admitted-list.pdf", array('Attachment' => 0));
        } else {
            $this->pdf->stream("discharged-list.pdf", array('Attachment' => 0));
        }
    }

    public function generate_proofsheet_report($by) {
        $s_date = new DateTime($this->input->post("s_date"));
        $e_date = new DateTime($this->input->post("e_date"));
        $search = $this->input->post("search");

        $this->load->library('pdf');
        $data["s_date"] = $s_date->format("Y-m-d");
        $data["e_date"] = $e_date->format("Y-m-d");
        $data["by"] = $by;
        $data["proof_record"] = $this->user_model->proofsheet_report($data["s_date"], $data["e_date"], $search, intval($data["by"]));
        $data["title"] = "Proofsheet List";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $this->pdf->load_view('reports/proofsheetList', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "20");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));

        $this->pdf->stream("proofsheet-list.pdf", array('Attachment' => 0));
    }

    public function users() {
        if ($this->has_log_in()) {
            $data["page_title"] = "User Management";
            $ $data["page_title"] = "All Users";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/vendors/plugins/morrisjs/morris.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
//                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/plugins/jquery-countto/jquery.countTo.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/js/myJs.js');


            $this->user_page('users', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_users() {
        if ($this->validate_log_in()) {
            $fetch_data = $this->user_model->make_users_datatables();

            $data = array();
            foreach ($fetch_data as $row) {
                $sub_array = array();
                $sub_array[] = $row->username;
                $sub_array[] = $row->type;
                $sub_array[] = '<button type="button" class="btn-update-branch btn bg-green btn-xs waves-effect" data-toggle="tooltip" data-placement="right" title="Update Branch">'
                        . '<i class="material-icons">edit</i>'
                        . '</button>';
                $data[] = $sub_array;
            }
            $output = array(
                "draw" => intval($this->input->post("draw")),
                "recordsTotal" => $this->user_model->get_users_data(),
                "recordsFiltered" => $this->user_model->get_users_filtered_data(),
                "data" => $data
            );
            echo json_encode($output);
        }
    }

    public function add_user() {
        $result = array('status' => false);
        $config = array(
            array(
                'field' => 'usertype',
                'label' => 'Usertype',
                'rules' => 'callback_validate_utype'
            ),
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|callback_validate_uname'
            ), array(
                'field' => 'pass',
                'label' => 'Password',
                'rules' => 'required'
            ), array(
                'field' => 'passconf',
                'label' => 'Password Confirmation',
                'rules' => 'required|matches[pass]'
            ),
            array(
                'field' => 'contactno',
                'label' => 'Contact No.',
                'rules' => 'required'
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $result['error_utype'] = form_error('usertype');
            $result['error_uname'] = form_error('username');
            $result['error_pass'] = form_error('pass');
            $result['error_passconf'] = form_error('passconf');
            $result['error_contactno'] = form_error('contactno');
        } else {
            if ($this->user_model->insert_user()) {
                $result['status'] = true;
            }
        }
        echo json_encode($result);
    }

    public function validate_uname($uname) {
        if (!empty($uname)) {
            $result = $this->user_model->check_uname($this->security->xss_clean($uname));
            if ($result) {
                $this->form_validation->set_message('validate_uname', 'Username already taken!');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    public function validate_oldpass($pass) {
        if (!empty($pass)) {
            $result = $this->user_model->check_oldpass($this->security->xss_clean($pass));
            if ($result) {
                return TRUE;
            } else {
                $this->form_validation->set_message('validate_oldpass', 'Invalid Password!');
                return FALSE;
            }
        }
    }

    public function update_password() {
        $result = array('status' => false);
        if ($this->user_model->modify_account()) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function update_pword() {
        $result = array('status' => false);
        $data['pword'] = $this->input->post('pwordconf');
        $data['docref'] = $this->input->post('docref');
        $data['userx'] = $this->input->post('docuser');
        if ($this->user_model->modify_accountx($data)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function update_account() {
        $result = array('status' => false);
        $config = array(
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|callback_validate_uname'
            ), array(
                'field' => 'oldpass',
                'label' => 'Old Password',
                'rules' => 'required|callback_validate_oldpass'
            ), array(
                'field' => 'pass',
                'label' => 'Password',
                'rules' => 'required'
            ), array(
                'field' => 'passconf',
                'label' => 'Password Confirmation',
                'rules' => 'required|matches[pass]'
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE) {
            $result['error_uname'] = form_error('username');
            $result['error_pass'] = form_error('pass');
            $result['error_oldpass'] = form_error('oldpass');
            $result['error_passconf'] = form_error('passconf');
        } else {
            if ($this->user_model->modify_account()) {
                $result['status'] = true;
            }
        }
        echo json_encode($result);
    }

    public function fetch_op_phic_accnt() {
        $s_date = new DateTime($this->input->post('start_date'));
        $total = array('px' => 0, 'amount' => 0.0, 'pf' => 0.0);

        $fetch_data = $this->user_model->make_op_phic_accnt_datatables($s_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            if ($row->aging != "61 Days above") {
                $total["px"] += $row->total;
                $total["amount"] += $row->totalamounthci;
                $total["pf"] += $row->totalamountpf;
            }

            $sub_array = array();

            if ($row->aging === "61 Days above") {
                $sub_array[] = $row->aging;
                $sub_array[] = "<span style='color: red'>" . $row->aging . "</span>";
                $sub_array[] = "<span style='color: red'>" . $row->total . "</span>";
                $sub_array[] = "<span style='color: red'>" . $this->format_money($row->totalamounthci) . "</span>";
                $sub_array[] = "<span style='color: red'>" . $this->format_money($row->totalamountpf) . "</span>";
            } else {
                $sub_array[] = $row->aging;
                $sub_array[] = $row->aging;
                $sub_array[] = $row->total;
                $sub_array[] = $this->format_money($row->totalamounthci);
                $sub_array[] = $this->format_money($row->totalamountpf);
            }

            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_op_phic_accnt_data($s_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_op_phic_accnt_filtered_data($s_date->format('Y-m-d')),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function generate_op_phic_accnt_report() {
        $s_date = $this->input->post('s_date');

        $this->load->library('pdf');
        $start_date = new DateTime($s_date);
        $data['s_date'] = date_format($start_date, 'F j Y');

        $data['title'] = "ON PROCESS";
        $data["phicstat"] = $this->user_model->get_op_phic_accnt_report($start_date->format('Y-m-d'));
        $data['pat'] = 0;
        $data['totalamt'] = 0;


        for ($i = 0; $i < count($data["phicstat"]); $i++) {
            if ($data['phicstat'][$i]['aging'] !== "61 Days above") {
                $data['pat'] += $data["phicstat"][$i]['total'];
                $data['totalamt'] += $data["phicstat"][$i]['totalamount'];
            }
        }

//            
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $da = new DateTime($data['datenow']);
        $data['date'] = date_format($da, 'F j, Y');
        $data['time'] = date_format($da, 'H:i:s A');
//        
        $this->pdf->load_view('reports/phiconprocess', $data);
        $this->pdf->set_paper('Legal', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(525, 20, "Page {PAGE_NUM} ", $font, 8, array(0, 0, 0));

        $this->pdf->stream('"' . $data['title'] . ").pdf", array('Attachment' => 0));
    }

    //fetch_transmittal: Alingling
    public function fetch_transmitphic_accnt() {
        $s_date = new DateTime($this->input->post('start_date'));
        $total = array('px' => 0, 'amount' => 0.0);

        $fetch_data = $this->user_model->make_transmit_phic_accnt_datatables($s_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            if ($row->aging != "61 Days above") {
                $total["px"] += $row->total;
                $total["amount"] += $row->totalamount;
            }

            $sub_array = array();

            if ($row->aging === "61 Days above") {
                $sub_array[] = "<span style='color: red'>" . $row->aging . "</span>";
                $sub_array[] = "<span style='color: red'>" . $row->total . "</span>";
                $sub_array[] = "<span style='color: red'>" . $this->format_money($row->totalamount) . "</span>";
            } else {
                $sub_array[] = $row->aging;
                $sub_array[] = $row->total;
                $sub_array[] = $this->format_money($row->totalamount);
            }

            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_transmit_phic_accnt_data($s_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_transmit_phic_accnt_filtered_data($s_date->format('Y-m-d')),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function generate_phic_transmittal_report() {
        $data["s_date"] = $this->input->post('s_date');
        $s_date = new DateTime($this->input->post('s_date'));


        $this->load->library('pdf');
//         = $this->get_current_dates();
        $data["title"] = "TRANSMITTED CLAIMS";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["phicstat"] = $this->user_model->get_phic_transmittal_report($s_date->format('Y-m-d'));

        $this->pdf->load_view('reports/phicstatus', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("PHIC_Transmittal(" . $data["s_date"] . ").pdf", array('Attachment' => 0));
//            
    }

    public function generate_phic_transmittal_daily_report() {
        $data["s_date"] = $this->input->post('s_date');
        $data["e_date"] = $this->input->post('e_date');
        $s_date = new DateTime($this->input->post('s_date'));
        $e_date = new DateTime($this->input->post('e_date'));


        $this->load->library('pdf');
        //         = $this->get_current_dates();
        $data["title"] = "TRANSMITTED CLAIMS";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["phicstat"] = $this->user_model->get_phic_transmittal_daily_report($s_date->format('Y-m-d'), $e_date->format('Y-m-d'));
        $data["phictdate"] = $this->user_model->generate_phic_transmittal_daily_date_report($s_date->format('Y-m-d'), $e_date->format('Y-m-d'));
        $data["phictrate"] = $this->user_model->generate_phic_transmittal_daily_rate_report($s_date->format('Y-m-d'), $e_date->format('Y-m-d'));
        $data['totalamount'] = 0;
        $data['hosp'] = 0;
        $data['prof'] = 0;


        for ($i = 0; $i < count($data["phicstat"]); $i++) {
            $data['totalamount'] += $data["phicstat"][$i]['grandtotal'];
            $data['hosp'] += $data["phicstat"][$i]['hcifee'];
            $data['prof'] += $data["phicstat"][$i]['profee'];
        }
        $this->pdf->load_view('reports/phictransmit', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("PHIC_Transmittal(" . $data["s_date"] . ").pdf", array('Attachment' => 0));
//            
    }

//payments_aging to transmittal: Alingling
    public function fetch_paymentphic_accnt() {
        $s_date = new DateTime($this->input->post('start_date'));
        $total = array('px' => 0, 'amount' => 0.0);

        $fetch_data = $this->user_model->make_payment_phic_accnt_datatables($s_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            if ($row->aging != "61 Days above") {
                $total["px"] += $row->total;
                $total["amount"] += $row->totalamount;
            }

            $sub_array = array();

            if ($row->aging === "61 Days above") {
                $sub_array[] = "<span style='color: red'>" . $row->aging . "</span>";
                $sub_array[] = "<span style='color: red'>" . $row->total . "</span>";
                $sub_array[] = "<span style='color: red'>" . $this->format_money($row->totalamount) . "</span>";
            } else {
                $sub_array[] = $row->aging;
                $sub_array[] = $row->total;
                $sub_array[] = $this->format_money($row->totalamount);
            }

            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_payment_phic_accnt_data($s_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_payment_phic_accnt_filtered_data($s_date->format('Y-m-d')),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    //payments_aging to discharge: Alingling
    public function fetch_paymentphic_discharge_accnt() {
        $s_date = new DateTime($this->input->post('start_date'));
        $total = array('px' => 0, 'amount' => 0.0);

        $fetch_data = $this->user_model->make_payment_discharge_phic_accnt_datatables($s_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            if ($row->aging != "61 Days above") {
                $total["px"] += $row->total;
                $total["amount"] += $row->totalamount;
            }

            $sub_array = array();

            if ($row->aging === "61 Days above") {
                $sub_array[] = "<span style='color: red'>" . $row->aging . "</span>";
                $sub_array[] = "<span style='color: red'>" . $row->total . "</span>";
                $sub_array[] = "<span style='color: red'>" . $this->format_money($row->totalamount) . "</span>";
            } else {
                $sub_array[] = $row->aging;
                $sub_array[] = $row->total;
                $sub_array[] = $this->format_money($row->totalamount);
            }

            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_payment_discharge_phic_accnt_data($s_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_payment_discharge_phic_accnt_filtered_data($s_date->format('Y-m-d')),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    //

    public function ppppddddfff() {
        $this->load->library('pdf');
        $this->pdf->load_view('reports/membersReport');
        $this->pdf->set_paper('8.5x13', 'portrait');
        $this->pdf->render();
        $this->pdf->stream("members.pdf", array('Attachment' => 0));
//        use Dompdf\Dompdf;
//
//// instantiate and use the dompdf class
//        $dompdf = new Dompdf();
//        $dompdf->loadHtml('hello world');
//
//        // (Optional) Setup the paper size and orientation
//        $dompdf->setPaper('A4', 'landscape');
//
//        // Render the HTML as PDF
//        $dompdf->render();
//
//        // Output the generated PDF to Browser
//        $dompdf->stream();
    }

    public function mydate() {
        echo $this->input->post("s_date") . "<br>";
        echo $this->input->post("e_date") . "<br>";
        echo $this->input->post("search");
//        echo $a."<br>";
//        echo $b."<br>";
//        echo urldecode($c);
//        echo urldecode("%2F");
    }

    //Monthy Transaction: Departmentalized Income
// transmitted: Alingling
    public function monthlytrans() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Monthly Transactions";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/transmitphic.js',
                'assets/js/lock.js',
                'assets/js/monthlytransaction.js',
                'assets/vendors/js/Chart.js',);

            $this->user_page('monthlytransaction', $data);
        } else {
            $this->index();
        }
    }

    //Get Daily Transaction: Departmentalized Income
    // ALingling

    public function dailytransactionincome() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Daily Transaction Income";

            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myJs.js',
                'assets/js/dashboard.js',
                'assets/js/lock.js',
                'assets/js/dailytransactionincome.js');

            $this->user_page('dailytransactionincome', $data);
        } else {
            $this->index();
        }
    }

    public function get_daily() {

        $result = array('status' => false);
        $s_date = new DateTime($this->input->post('dating'));

        if ($this->user_model->get_daily_transaction($s_date->format('Y-m-d'))) {
            $result["census_daily"] = $this->user_model->get_daily_transaction($s_date->format('Y-m-d'));
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function get_monthly($month) {

        $result = array('status' => false);
        $s_date = new DateTime($this->input->post('monthdate'));

        if ($this->user_model->get_monthly_transaction($s_date->format('Y-m-d'), $month)) {
            $result["census_monthly"] = $this->user_model->get_monthly_transaction($s_date->format('Y-m-d'), $month);
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    /* Fix Asset Monitoring -> Job Orders COntent
     * @author Alingling
     */

    public function jobapproval() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Job Order Approval";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/jobapproval.js');

            $data["dept"] = $this->user_model->getDept();

            $this->user_page('jobapproval', $data);
        } else {
            $this->index();
        }
    }

    /* Fix Asset Monitoring -> Job Orders
     * @author Alingling
     */

    public function fetch_jobapproval($dept) {

        $fetch_data = $this->user_model->make_jobapproval_ticket_datatables($dept);
        $data = array();
        foreach ($fetch_data as $row) {


            $sub_array = array();
//            $sub_array[] = $row->TICKETDATE;
            $sub_array[] = '';
            $sub_array[] = $row->controlnumber;

            $sub_array[] = $this->format_date($row->requestdate) . '<i style="float: right" tabindex="0" role="button" style="margin-top: -4px" 
                                            data-placement="bottom" data-container="body" onclick="jobapproval.get_fix_assets(' . $row->controlnumber . ')"
                                            data-title="Details" class="material-icons bg-red">report</i>';
            $sub_array[] = $row->AssetType;
            $sub_array[] = $row->Department;
            $sub_array[] = $row->Complaints;
            $sub_array[] = $row->details;
            $sub_array[] = $row->requestid;
            $sub_array[] = '';
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_jobapproval_ticket_data($dept),
            "recordsFiltered" => $this->user_model->get_jobapproval_ticket_filtered_data($dept),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //disapprovedticket:alingling

    public function generate_transmittal_report() {
        $this->load->library('pdf');
        $data["s_date"] = $this->input->post("s_date");
        $data["title"] = "Transmitted Claims";

        $data["approvedticket_record"] = $this->user_model->disapprovedticket_report();

        $this->pdf->load_view('reports/approvedticket', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("disapproved-ticket.pdf", array('Attachment' => 0));
    }

    public function generate_phic_report() {
        $this->load->library('pdf');
        $data["datenow"] = $this->get_current_date();
        $data['profile'] = $this->user_model->get_hospital();
        $data["title"] = "Philhealth Patients";
        $data["philhealth_now"] = $this->user_model->philhealth_now_report();


        $this->pdf->load_view('reports/philhealthpatients', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("Georgia", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream('philhealth-list (' . $data["datenow"] . ').pdf', array('Attachment' => 0));
    }

    public function generate_non_phic_report() {

        $this->load->library('pdf');
        $data["datenow"] = $this->get_current_date();
        $data['profile'] = $this->user_model->get_hospital();
        $data["title"] = "Non-Philhealth Patients";
        $data["philhealth_now"] = $this->user_model->nonphilhealth_now_report();


        $this->pdf->load_view('reports/philhealthpatients', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("Georgia", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream('nonphilhealth-list (' . $data["datenow"] . ').pdf', array('Attachment' => 0));
    }

    public function generate_total_patients_report() {

        $this->load->library('pdf');
        $data["datenow"] = $this->get_current_date();
        $data['profile'] = $this->user_model->get_hospital();
        $data["title"] = "Total Admitted Patients";
        $data["philhealth_now"] = $this->user_model->total_patients_report();


        $this->pdf->load_view('reports/philhealthpatients', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("nonphilhealth-list.pdf", array('Attachment' => 0));
    }

    public function generate_admitted_patients_report() {

        $this->load->library('pdf');
        $data['admitDischaDate'] = $this->input->post('admitDischaDatex');
        $data["datenow"] = $this->get_current_date();
        $data['profile'] = $this->user_model->get_hospital();
        $data["title"] = "Admitted Patients";
        $data["philhealth_now"] = $this->user_model->admitted_patients_report($data['admitDischaDate']);


        $this->pdf->load_view('reports/philhealthpatients', $data);
        $this->pdf->set_paper('A4', 'Landscape');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 550, "{PAGE_NUM} | Page", $font, 8, array(0, 0, 0));
        $this->pdf->stream('Admittedpatients-list (' . $data["datenow"] . ').pdf', array('Attachment' => 0));
    }

    public function generate_discharged_patients_report() {

        $this->load->library('pdf');
        $data['admitDischaDate'] = $this->input->post('admitDischaDatexx');
        $data["datenow"] = $this->get_current_date();
        $data['profile'] = $this->user_model->get_hospital();
        $data["title"] = "Discharged Patients";
        $data["philhealth_now"] = $this->user_model->discharged_patients_report($data['admitDischaDate']);


        $this->pdf->load_view('reports/philhealthpatients', $data);
        $this->pdf->set_paper('A4', 'Landscape');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 550, "{PAGE_NUM} | Page", $font, 8, array(0, 0, 0));
        $this->pdf->stream('Dischargedpatients-list (' . $data["datenow"] . ').pdf', array('Attachment' => 0));
    }

    public function generate_eachd_patients_report() {

        $this->load->library('pdf');
        $data["date"] = $this->input->post("s_date");

        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["title"] = "Patient Census";
        $data["philhealth_now"] = $this->user_model->eachd_patients_report($data["date"]);


        $this->pdf->load_view('reports/patientcensusperday', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream('Dischargedpatients-list (' . $data["datenow"] . ').pdf', array('Attachment' => 0));
    }

    public function generate_daily_transaction_report() {

        $this->load->library('pdf');
        $data["date"] = $this->input->post("s_date");


        $data["title"] = "Daily Income";
        $data["daily_transaction"] = $this->user_model->get_daily_transaction($data["date"]);
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $this->pdf->load_view('reports/dailyincome', $data);
        $this->pdf->set_paper('A3', 'landscape');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream('DailyIncome-list (' . $data["date"] . ').pdf', array('Attachment' => 0));
    }

    public function generate_monthly_transaction_report() {

        $this->load->library('pdf');

        $data["date"] = new DateTime($this->input->post("s_date"));
        $data["dates"] = date_format($data["date"], "F Y");
        $data["month"] = $this->input->post('rangemonth');

        $data["title"] = "Monthly Income";
        $data["daily_transaction"] = $this->user_model->get_monthly_transaction($data["date"]->format('Y-m-d'), $data["month"]);
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $this->pdf->load_view('reports/monthlytransaction', $data);
        $this->pdf->set_paper('A3', 'landscape');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream('MonthlyIncome-list (' . $data["dates"] . ').pdf', array('Attachment' => 0));
    }

    public function generate_assets_report() {

        $this->load->library('pdf');
        $data["date"] = $this->get_current_date();
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["titlex"] = "Fix Asset Monitoring";
        $data["asset_report"] = $this->user_model->get_asset_report();


        $this->pdf->load_view('reports/assetslist', $data);
        $this->pdf->set_paper('letter', 'landscape');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream('Assetmonitoring-list (' . $data["date"] . ').pdf', array('Attachment' => 0));
    }

    public function generate_assets_info_report() {

        $this->load->library('pdf');
        $data["id"] = $this->input->post("id");
        $data["date"] = $this->get_current_date();
        $data["title"] = "Asset Service Monitoring";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["asset_report"] = $this->user_model->assets_info_report($data["id"]);


        $this->pdf->load_view('reports/assetsinfolist', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream('Assetsinfo-list (' . $data["date"] . ').pdf', array('Attachment' => 0));
    }

    //check job orders
    public function check_joborders() {
        $result = array('status' => FALSE);
        $count = 0;
        if ($this->has_log_in()) {
            $ctrls = $this->input->post("controls");
            for ($i = 0; $i < count($ctrls); $i++) {
                if ($this->user_model->check_joborders($ctrls[$i])) {
                    $result["ticket"] = $this->user_model->check_joborders($ctrls[$i]);
                    $result['status'] = true;
                    $count += 1;
                }
                $result["count"] = $count;
            }
            echo json_encode($result);
        }
    }

    public function approve_joborderx() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->approve_joborders($this->input->post("controls"))) {
                $this->fetch_jobapproval("All");
            } else {
                echo json_encode($result);
            }
        }
    }

    public function disapprove_joborderx() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->disapprove_joborders($this->input->post("controls"))) {
                $this->fetch_jobapproval("All");
            } else {
                echo json_encode($result);
            }
        }
    }

    public function defer_joborderx() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            if ($this->user_model->defer_joborders($this->input->post("controls"))) {
                $this->fetch_jobapproval("All");
            } else {
                echo json_encode($result);
            }
        }
    }

    public function fetch_disapprovedjoborders() {
        $fetch_data = $this->user_model->make_disapproved_joborders_datatables();
        $data = array();
        foreach ($fetch_data as $row) {


            $sub_array = array();
            $sub_array[] = $row->controlnumber;
            $sub_array[] = $this->format_dates($row->updated);
            $sub_array[] = $this->format_date($row->requestdate) . '<i style="float: right" tabindex="0" role="button" style="margin-top: -4px" 
                                            data-placement="bottom" data-container="body" onclick="jobapproval.get_fix_assets(' . $row->controlnumber . ')"
                                            data-title="Details" class="material-icons bg-red">report</i>';
            $sub_array[] = $row->AssetType;
            $sub_array[] = $row->Department;
            $sub_array[] = $row->Complaints;
            $sub_array[] = $row->details;
            $sub_array[] = $row->requestid;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_disapproved_joborders_data(),
            "recordsFiltered" => $this->user_model->get_disapproved_joborders_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //disapproved job orders:alingling

    public function generate_disapprovedjoborder_report() {
        $this->load->library('pdf');
        $data["title"] = "Disapproved Job Orders";
        $data["header"] = "Disapproval Date";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["disapproved_joborder_record"] = $this->user_model->get_disapproved_joborders_report();

        $this->pdf->load_view('reports/disapprovedJobOrder', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("disapproved-job-order ('" . $data["date"] . "'.pdf", array('Attachment' => 0));
    }

    public function generate_csv_disapprovedjoborder_report() {
        $data["date"] = $this->get_current_dates();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=disapproved-job-order ("' . $data["date"] . '").csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('Request ID', 'Disapproval Date', 'Request Date', 'Type', 'Department', 'Complaint', 'Details', 'Note'));


        $row = $this->user_model->get_disapproved_joborders_report();

        for ($i = 0; $i < count($row); $i++) {
            fputcsv($output, $row[$i]);
        }
        fclose($output);
    }

    public function fetch_deferredjoborders() {
        $fetch_data = $this->user_model->make_deferred_joborders_datatables();
        $data = array();
        foreach ($fetch_data as $row) {


            $sub_array = array();
            $sub_array[] = $row->controlnumber;
            $sub_array[] = $this->format_dates($row->updated);
            $sub_array[] = $this->format_date($row->requestdate) . '<i style="float: right" tabindex="0" role="button" style="margin-top: -4px" 
                                            data-placement="bottom" data-container="body" onclick="jobapproval.get_fix_assets(' . $row->controlnumber . ')"
                                            data-title="Details" class="material-icons bg-red">report</i>';
            $sub_array[] = $row->AssetType;
            $sub_array[] = $row->Department;
            $sub_array[] = $row->Complaints;
            $sub_array[] = $row->details;
            $sub_array[] = $row->requestid;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_deferred_joborders_data(),
            "recordsFiltered" => $this->user_model->get_deferred_joborders_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //disapproved job orders:alingling

    public function generate_deferredjoborder_report() {
        $this->load->library('pdf');
        $data["date"] = $this->get_current_dates();
        $data["title"] = "Deferred Job Orders";
        $data["header"] = "Deferral Date";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["disapproved_joborder_record"] = $this->user_model->get_deferred_joborders_report();

        $this->pdf->load_view('reports/disapprovedJobOrder', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("disapproved-job-order ('" . $data["date"] . "').pdf", array('Attachment' => 0));
    }

    public function generate_csv_deferredjoborder_report() {
        $data["date"] = $this->get_current_dates();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=deferred-job-order ("' . $data["date"] . '").csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('Request ID', 'Deferral Date', 'Request Date', 'Type', 'Department', 'Complaint', 'Details', 'Note'));


        $row = $this->user_model->get_deferred_joborders_report();
        for ($i = 0; $i < count($row); $i++) {
            fputcsv($output, $row[$i]);
        }
        fclose($output);
    }

    public function fetch_approvedjoborders() {
        $fetch_data = $this->user_model->make_approved_joborders_datatables();
        $data = array();
        foreach ($fetch_data as $row) {


            $sub_array = array();
            $sub_array[] = $row->controlnumber;
            $sub_array[] = $this->format_dates($row->updated);
            $sub_array[] = $this->format_date($row->requestdate) . '<i style="float: right" tabindex="0" role="button" style="margin-top: -4px" 
                                            data-placement="bottom" data-container="body" onclick="jobapproval.get_fix_assets(' . $row->controlnumber . ')"
                                            data-title="Details" class="material-icons bg-red">report</i>';
            $sub_array[] = $row->AssetType;
            $sub_array[] = $row->Department;
            $sub_array[] = $row->Complaints;
            $sub_array[] = $row->details;
            $sub_array[] = $row->requestid;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_approved_joborders_data(),
            "recordsFiltered" => $this->user_model->get_approved_joborders_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetch_approved_joborder_by_date() {
        $s_date = new DateTime($this->input->post('start_date'));



        $fetch_data = $this->user_model->make_all_approvedjoborderbydate_datatables($s_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->controlnumber;
            $sub_array[] = $this->format_dates($row->updated);
            $sub_array[] = $this->format_date($row->requestdate);
            $sub_array[] = $row->AssetType;
            $sub_array[] = $row->Department;
            $sub_array[] = $row->Complaints;
            $sub_array[] = $row->details;
            $sub_array[] = $row->requestid;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_approved_joborders_data($s_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_all_approvedjoborderbydate_filtered_data($s_date->format('Y-m-d')),
            "data" => $data,
            "date" => $s_date
        );
        echo json_encode($output);
    }

    public function generate_approvedjoborder_bydate_report() {
        $this->load->library('pdf');
        $data["datexx"] = new DateTime($this->input->post('pdf_date'));
        $data["date"] = $data["datexx"]->format('m-d-Y');
        $data["title"] = "Approved Job Orders";
        $data["header"] = "Approval Date";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["disapproved_joborder_record"] = $this->user_model->get_approved_joborders_bydate_report($data["datexx"]->format('Y-m-d'));

        $this->pdf->load_view('reports/disapprovedJobOrder', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("approved-job-order by '" . $data["date"] . "'.pdf", array('Attachment' => 0));
    }

    public function generate_csv_approvedjoborder_bydate_report() {
        $data["datexx"] = new DateTime($this->input->post('csv_date'));
        $data["date"] = $data["datexx"]->format('m-d-Y');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=approved-job-order by "' . $data["date"] . '".csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('Request ID', 'Approval Date', 'Request Date', 'Type', 'Department', 'Complaint', 'Details', 'Note'));


        $row = $this->user_model->get_approved_joborders_bydate_report($data["datexx"]->format('Y-m-d'));
        for ($i = 0; $i < count($row); $i++) {
            fputcsv($output, $row[$i]);
        }
        fclose($output);
    }

    /*
     * Mandatory Monthly Hospital Report
     * 
     * @auhtor Alingling
     * @param 12-20-2017
     */

    public function mandadailycensus() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Daily Census";
            $data["census"] = $this->user_model->today_census();
            $month = $this->get_current_date();
            $data["census_month"] = $this->user_model->get_daily_census_of_nhip($month);
            $data["discharge_month"] = $this->user_model->get_daily_discharges($month);

            $totalnhip = 0;
            $totalnon = 0;
            $totalpat = 0;



            for ($i = 0; $i < count($data["census_month"]); $i++) {
                $totalnhip += $data["census_month"][$i]['nhip'];

                $data["phic"] = number_format($totalnhip, 0);
            }

            for ($i = 0; $i < count($data["census_month"]); $i++) {
                $totalnon += $data["census_month"][$i]['non'];
                $data["non"] = number_format($totalnon, 0);
            }

            for ($i = 0; $i < count($data["census_month"]); $i++) {
                $totalpat += $data["census_month"][$i]['totalx'];
                $data["pat"] = number_format($totalpat, 0);
            }

            $dischanhip = 0;
            $dischanon = 0;
            $dischapat = 0;


//discharges

            for ($i = 0; $i < count($data['discharge_month']); $i++) {
                $dischanhip += $data['discharge_month'][$i]['nhip'];

                $data["disphic"] = number_format($dischanhip, 0);
            }

            for ($i = 0; $i < count($data['discharge_month']); $i++) {
                $dischanon += $data['discharge_month'][$i]['non'];
                $data["disnon"] = number_format($dischanon, 0);
            }

            for ($i = 0; $i < count($data['discharge_month']); $i++) {
                $dischapat += $data['discharge_month'][$i]['totalx'];
                $data["dispat"] = number_format($dischapat, 0);
            }

            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
                'assets/js/dashboard.js',
                'assets/js/lock.js',
                'assets/js/mandadailycensus.js');

            $this->user_page('mandadailycensus', $data);
        } else {
            $this->index();
        }
    }

    public function get_census_month() {
        $result = array('status' => false);
        $month = $this->input->post('s_date');
        $result['month'] = $this->input->post('s_date');
        $census_month = $this->user_model->get_daily_census_of_nhip($month);
        $result["census_month"] = $this->user_model->get_daily_census_of_nhip($month);

        $totalnhip = 0;
        $totalnon = 0;
        $totalpat = 0;



        for ($i = 0; $i < count($census_month); $i++) {
            $totalnhip += $census_month[$i]['nhip'];

            $result["phic"] = number_format($totalnhip, 0);
        }

        for ($i = 0; $i < count($census_month); $i++) {
            $totalnon += $census_month[$i]['non'];
            $result["non"] = number_format($totalnon, 0);
        }

        for ($i = 0; $i < count($census_month); $i++) {
            $totalpat += $census_month[$i]['totalx'];
            $result["pat"] = number_format($totalpat, 0);
        }


        $result['status'] = true;

        echo json_encode($result);
    }

    public function get_discharges_month() {
        $result = array('status' => false);
        $month = $this->input->post('s_date');
        $result['month'] = $this->input->post('s_date');
        $discharges_month = $this->user_model->get_daily_discharges($month);
        $result["discharges_month"] = $this->user_model->get_daily_discharges($month);

        $dischanhip = 0;
        $dischanon = 0;
        $dischapat = 0;


//discharges

        for ($i = 0; $i < count($result['discharges_month']); $i++) {
            $dischanhip += $result['discharges_month'][$i]['nhip'];

            $result["disphic"] = number_format($dischanhip, 0);
        }

        for ($i = 0; $i < count($result['discharges_month']); $i++) {
            $dischanon += $result['discharges_month'][$i]['non'];
            $result["disnon"] = number_format($dischanon, 0);
        }

        for ($i = 0; $i < count($result['discharges_month']); $i++) {
            $dischapat += $result['discharges_month'][$i]['totalx'];
            $result["dispat"] = number_format($dischapat, 0);
        }

        $result['status'] = true;

        echo json_encode($result);
    }

    public function generate_daily_census_report() {

        $data['month'] = $this->input->post('s_date');
        $data["census_month"] = $this->user_model->get_daily_census_of_nhip($data['month']);

        $totalnhip = 0;
        $totalnon = 0;
        $totalpat = 0;


        for ($i = 0; $i < count($data['census_month']); $i++) {
            $totalnhip += $data['census_month'][$i]['nhip'];

            $data["disphic"] = number_format($totalnhip, 0);
        }

        for ($i = 0; $i < count($data['census_month']); $i++) {
            $totalnon += $data['census_month'][$i]['non'];
            $data["disnon"] = number_format($totalnon, 0);
        }

        for ($i = 0; $i < count($data['census_month']); $i++) {
            $totalpat += $data['census_month'][$i]['totalx'];
            $data["dispat"] = number_format($totalpat, 0);
        }
        $this->load->library('pdf');

        $data["datex"] = new DateTime($data['month']);
        $data["date"] = date_format($data["datex"], "F  Y");

        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["title"] = "Daily Census Of NHIP";
        //  $data["census_month"] = $this->user_model->get_daily_census_of_nhip();


        $this->pdf->load_view('reports/mandadailycensus', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream('Daily_Census_Of_NHIP-list (' . $data["date"] . ').pdf', array('Attachment' => 0));
    }

    public function generate_daily_discharge_report() {
        $data['month'] = $this->input->post('s_date');
        $data["census_month"] = $this->user_model->get_daily_discharges($data['month']);
        $dischanhip = 0;
        $dischanon = 0;
        $dischapat = 0;



        for ($i = 0; $i < count($data['census_month']); $i++) {
            $dischanhip += $data['census_month'][$i]['nhip'];

            $data["disphic"] = number_format($dischanhip, 0);
        }

        for ($i = 0; $i < count($data['census_month']); $i++) {
            $dischanon += $data['census_month'][$i]['non'];
            $data["disnon"] = number_format($dischanon, 0);
        }

        for ($i = 0; $i < count($data['census_month']); $i++) {
            $dischapat += $data['census_month'][$i]['totalx'];
            $data["dispat"] = number_format($dischapat, 0);
        }

        $this->load->library('pdf');

        $data["datex"] = new DateTime($data['month']);
        $data["date"] = date_format($data["datex"], "F  Y");
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["title"] = "Discharges of the Day";
        //      $data["census_month"] = $this->user_model->get_daily_discharges();
        //   $data["census_month"] = $this->user_model->get_daily_discharges();


        $this->pdf->load_view('reports/mandadailycensus', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream('Daily_Census_Of_NHIP-list (' . $data["date"] . ').pdf', array('Attachment' => 0));
    }

    //Quality Assurance Indicator
    public function mandaquality() {



        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {

            $months = new DateTime();
            $data['month'] = $months->format('Y-m');

            $data["census_month"] = $this->user_model->get_daily_census_of_nhip($data['month']);
            $data["beds"] = $this->user_model->get_authorized_bed();
            $data["discharge_month"] = $this->user_model->get_daily_discharges($data['month']);

            $totalpat = 0;
            //TOTAL PATIENTS
            for ($i = 0; $i < count($data['census_month']); $i++) {
                $totalpat += $data['census_month'][$i]['totalx'];
                $pat = $totalpat;
                $data['px'] = number_format($totalpat, 0);
            }
            //TOTAL NHIP
            $totalnhip = 0;
            for ($i = 0; $i < count($data['census_month']); $i++) {
                $totalnhip += $data['census_month'][$i]['nhip'];
                $nhip = $totalnhip;
                $data["phic"] = number_format($totalnhip, 0);
            }

            //TOTAL DISCHARGES (NHIP)
            $dischapat = 0;
            for ($i = 0; $i < count($data['discharge_month']); $i++) {
                $dischapat += $data['discharge_month'][$i]['nhip'];
                $disnhip = $dischapat;
                $data["dispat"] = number_format($dischapat, 0);
            }

            $d = new DateTime('first day of this month');
            $e = new DateTime('last day of this month');

            $diff = date_diff($e, $d);
            $data['dd'] = $diff->format('%a') + 1;

            //MBOR
            $data["DOHauthorizedbed"] = $data["beds"][0]["DOHauthorizedbed"];
            $dividend = $data['dd'] * $data["beds"][0]["DOHauthorizedbed"];
            $rate = intval($pat) / intval($dividend);
            $data["mbor"] = number_format($rate * 100, 2);

            //MNHIBOR
            $data["authorizedbed"] = number_format($data["beds"][0]["authorizedbed"], 0);
            $dividendx = $data['dd'] * $data["beds"][0]["authorizedbed"];
            $ratex = intval($nhip) / intval($dividendx);
            $data["MNHIBOR"] = number_format($ratex * 100, 2);

            //ALSP
            if ($disnhip === 0) {
                $disnhip = 1;
            }
            $alsp = ($data["phic"] / $data["dispat"]);
            $data['alspp'] = number_format($alsp, 2);



            $data["page_title"] = "Quality Assurance Indicator";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js',
                'assets/js/mandaquality.js');

            $this->user_page('mandaquality', $data);
        } else {
            $this->index();
        }
    }

    public function get_quality() {
        $data = array('status' => false);
        $month = $this->input->post('s_date');
        $data['month'] = $this->input->post('s_date');
        $data["census_month"] = $this->user_model->get_daily_census_of_nhip($month);
        $data["beds"] = $this->user_model->get_authorized_bed();
        $data["discharge_month"] = $this->user_model->get_daily_discharges($month);

        $totalpat = 0;
        //TOTAL PATIENTS
        for ($i = 0; $i < count($data['census_month']); $i++) {
            $totalpat += $data['census_month'][$i]['totalx'];
            $pat = $totalpat;
            $data['px'] = number_format($totalpat, 0);
        }
        //TOTAL NHIP
        $totalnhip = 0;
        for ($i = 0; $i < count($data['census_month']); $i++) {
            $totalnhip += $data['census_month'][$i]['nhip'];
            $nhip = $totalnhip;
            $data["phic"] = number_format($totalnhip, 0);
        }

        //TOTAL DISCHARGES (NHIP)
        $dischapat = 0;
        for ($i = 0; $i < count($data['discharge_month']); $i++) {
            $dischapat += $data['discharge_month'][$i]['nhip'];
            $disnhip = $dischapat;
            $data["dispat"] = number_format($dischapat, 0);
        }

        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $e = new DateTime($monthend);

        $diff = date_diff($e, $d);
        $data['dd'] = $diff->format('%a') + 1;

        //MBOR
        $data["DOHauthorizedbed"] = $data["beds"][0]["DOHauthorizedbed"];
        $dividend = $data['dd'] * $data["beds"][0]["DOHauthorizedbed"];
        $rate = intval($pat) / intval($dividend);
        $data["mbor"] = number_format($rate * 100, 2);

        //MNHIBOR
        $data["authorizedbed"] = number_format($data["beds"][0]["authorizedbed"], 0);
        $dividendx = $data['dd'] * $data["beds"][0]["authorizedbed"];
        $ratex = intval($nhip) / intval($dividendx);
        $data["MNHIBOR"] = number_format($ratex * 100, 2);

        //ALSP
        if ($disnhip === 0) {
            $disnhip = 1;
        }
        $alsp = intval($nhip) / intval($disnhip);
        $data['alspp'] = number_format($alsp, 2);

        $data['status'] = true;

        echo json_encode($data);
    }

    //Newborn Census
    public function mandanewborn() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {

            $months = new DateTime();
            $data['month'] = $months->format('Y-m');
            $data["newborn_census"] = $this->user_model->get_newborn_census($data['month']);



            $data["page_title"] = "Newborn Census";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js',
                'assets/js/mandanewborn.js');

            $this->user_page('mandanewborn', $data);
        } else {
            $this->index();
        }
    }

    public function get_newborn() {
        $result = array('status' => false);
        $result['month'] = $this->input->post('s_date');
        $result["newborn_census"] = $this->user_model->get_newborn_census($result['month']);

        $result['status'] = true;

        echo json_encode($result);
    }

    //Most Common Causes of Confinement
    public function mandaconfine($month = NULL) {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {

//         $date = new DateTime();
//        $month = $date->format('Y-m');
//        $data["confinement_causes"] = $this->confine_model->get_common_confinement_causes($month);
//


            $data["page_title"] = "Most Common Causes of Confinement";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/mandaconfine2.js');

            if ($month == NULL) {
                $monthnow = new DateTime();
                $data['monthx'] = $monthnow->format('Y-m');
            } else {
                $data['monthx'] = $month;
            }
            $this->user_page('mandaconfine', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_common_confinement_causes() {
        $month = $this->input->post('s_date');
        $fetch_data = $this->confine_model->get_top_common_confinement_causes_datatables($month);
        $data = array();
        $number = 1;
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->causeofconfinement;
            $sub_array[] = $row->nhip;
            $sub_array[] = $row->non;
            $data[] = $sub_array;

            $number++;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->confine_model->get_top_common_confinement_causes_data($month),
            "recordsFiltered" => $this->confine_model->get_top_common_confinement_causes_filtered_data($month),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //plan b for confinementcause
    public function add_confinement() {
        $result = array('status' => false);
        $data['mandamonth'] = $this->input->post('txtmonth');
        $data['causeofconfinement'] = $this->input->post('txtconfinementcause');
        $data['confinementnhip'] = $this->input->post('txtnhipconfine');
        $data['confinementnonnhip'] = $this->input->post('txtnonnhipconfine');
        $data['confinementtotal'] = $data['confinementnhip'] + $data['confinementnonnhip'];
        if ($this->confine_model->add_confinement($data)) {
            $result['status'] = true;
        }

        echo json_encode($result);
    }

    public function confinemerge($month) {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {



            $data["page_title"] = "Most Common Causes of Confinement";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/mandaconfine2.js');

            $monthnow = new DateTime($month);
            $data['monthx'] = $monthnow->format('F Y');
            $data['monthxx'] = $month;

            $this->user_page('confinemerge', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_confinement_causes() {
        $month = $this->input->post('s_date');
        $fetch_data = $this->confine_model->get_common_confinement_causes_datatables($month);
        $data = array();
        foreach ($fetch_data as $row) {
// ,,,'
            $sub_array = array();
            $sub_array[] = '';
            $sub_array[] = $row->diagnosis;
            $sub_array[] = $row->caseno;
            $sub_array[] = $row->name;
            $sub_array[] = $row->dischadate;
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->ID;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->confine_model->get_common_confinement_causes_data($month),
            "recordsFiltered" => $this->confine_model->get_common_confinement_causes_filtered_data($month),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetch_diagnosis_list() {

        $fetch_data = $this->confine_model->get_diagnosis_list_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->refno;
            $sub_array[] = $row->categdiag;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->confine_model->get_diagnosis_list_data(),
            "recordsFiltered" => $this->confine_model->get_diagnosis_list_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetch_px_diagnosis() {
        $datax['startdate'] = $this->input->post('s_date');
        $datax['caseno'] = $this->input->post('caseno');
        $fetch_data = $this->confine_model->get_px_diagnosis_list_datatables($datax);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = "<button type='button' onclick='confine.removefromqueue(" . $row->ID . ")' class='btn bg-red btn-xs waves-effect' data-toggle='tooltip' data-placement='bottom' title='Remove from Queue' ><i class='material-icons'>remove</i></button>";
            $sub_array[] = $row->ID;
            $sub_array[] = $row->refnocause;
            $sub_array[] = $row->causeofconfinement;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->confine_model->get_px_diagnosis_list_data($datax),
            "recordsFiltered" => $this->confine_model->get_px_diagnosis_list_filtered_data($datax),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function merge_confinement() {
        $result = array('status' => FALSE);
        $count = 0;
        if ($this->has_log_in()) {
            $ctrls = $this->input->post("controls");
            $data['refnocause'] = $this->input->post("refno");
            $data['causeofconfinement'] = $this->input->post("cause");
            for ($i = 0; $i < count($ctrls); $i++) {
                if ($this->confine_model->get_patient_causeofconfinement($ctrls[$i])) {
                    $px = $this->confine_model->get_patient_causeofconfinement($ctrls[$i]);
                    $data['caseno'] = $px['caseno'];
                    $data['patientname'] = $px['name'];
                    $data['dischadate'] = $px['dischadate'];
                    $data['phicmembr'] = $px['phicmembr'];
                    $data['diagnosis'] = $px['diagnosis'];
                    if ($this->confine_model->add_confinement($data)) {
                        $result['status'] = true;
                    }
                    $count += 1;
                }
                $result["count"] = $count;
            }
            echo json_encode($result);
        }
    }

    public function get_patient_final_diagnosis() {

        $result = array('status' => FALSE);

        $casecode = $this->input->post('casecode');

        $fetch_data = $this->confine_model->get_patient_final_diagnosis_datatables($casecode);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->diagnosis;
            $sub_array[] = "<button type='button' onclick='confine.removefromqueue(" . $row->ID . ")' class='btn bg-red btn-xs waves-effect' data-toggle='tooltip' data-placement='bottom' title='Remove from Queue' ><i class='material-icons'>remove</i></button>";
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->confine_model->get_patient_final_diagnosis_data($casecode),
            "recordsFiltered" => $this->confine_model->get_patient_final_diagnosis_filtered_data($casecode),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function removediagnosis() {

        $result = array('status' => FALSE);
        $id = $this->input->post('id');
        if ($this->confine_model->removediagnosis($id)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function get_diagnosis_patient() {

        $result = array('status' => FALSE);

        $diagnosis = $this->input->post('diagnosis');
        $month = $this->input->post('date');
        $fetch_data = $this->confine_model->get_final_diagnosis_patient_datatables($diagnosis, $month);
        $data = array();
        foreach ($fetch_data as $row) {
            $datex = new DateTime($row->dischadate);

            $sub_array = array();
            $sub_array[] = $row->patientname;
            $sub_array[] = date_format($datex, 'F j, Y');
            $sub_array[] = $row->phicmembr;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->confine_model->get_final_diagnosis_patient_data($diagnosis, $month),
            "recordsFiltered" => $this->confine_model->get_final_diagnosis_patient_filtered_data($diagnosis, $month),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //Surgical Output
    public function mandasurgical() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Surgical Output";
            $data["surgical"] = $this->user_model->get_surgical_procedures();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js',
                'assets/js/mandasurgical.js');

            $this->user_page('mandasurgical', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_surgical() {
        $date = $this->input->post("datex");
        $fetch_data = $this->surgical_model->create_surgicals_datatables($date);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->causeofsurgery;
            $sub_array[] = $row->nhip;
            $sub_array[] = $row->non;

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->surgical_model->get_surgicals_data($date),
            "recordsFiltered" => $this->surgical_model->get_surgicals_filtered_data($date),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetch_un_surgical() {
        $fetch_data = $this->surgical_model->create_unmerge_surgicals_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = '';
            $sub_array[] = $row->diag_surg;
            $sub_array[] = $row->Nhip;
            $sub_array[] = $row->Non;
            $sub_array[] = '';

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->surgical_model->get_unmerge_surgicals_data($type),
            "recordsFiltered" => $this->surgical_model->get_unmerge_surgicals_filtered_data($type),
            "data" => $data
        );
        echo json_encode($output);
    }

    ////final surgical

    public function fetch_final_surgical_output() {
        $month = $this->input->post('s_date');
        $fetch_data = $this->surgical_model->create_surgicals_output_datatables($month);
        $data = array();
        $number = 1;
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $number . '. ' . $row->Diag_surg;
            $sub_array[] = $row->nhip;
            $sub_array[] = $row->non;
            $data[] = $sub_array;

            $number++;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->surgical_model->get_surgicals_output_data($month),
            "recordsFiltered" => $this->surgical_model->get_surgicals_output_filtered_data($month),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //Surgical Output
    public function mandasurgicaltest() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Surgical Output";
            $data["surgical"] = $this->user_model->get_surgical_procedures();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js',
                'assets/js/mandasurgical.js');

            $this->user_page('mandatorySurgical', $data);
        } else {
            $this->index();
        }
    }

    //alingling
    public function surgicalmerge() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Surgical Output";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/mandasurgical.js');

            $data["diagnosis"] = $this->user_model->get_diagnosis_summary();
            $this->user_page('surgicalmerge', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_surgical_merge() {
        // $month = $this->input->post('s_date');
        $fetch_data = $this->surgical_model->create_surgicals_merge_datatables();
        $data = array();
        // $number = 1;
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = '';
            $sub_array[] = '';
            $sub_array[] = $row->Diag_surg;
            $sub_array[] = $row->nhip;
            $sub_array[] = $row->non;
            $sub_array[] = '';
            $data[] = $sub_array;

            // $number++;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->surgical_model->get_surgicals_merge_data(),
            "recordsFiltered" => $this->surgical_model->get_surgicals_merge_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function merge_surgical_output() {

        $result = array('status' => FALSE);
        $data['causeofsurgery'] = $this->input->post('surgicalname');
        $data['nhip'] = $this->input->post('surgicalnhip');
        $data['non'] = $this->input->post('surgicalnon');
        $data['total'] = $this->input->post('total');
        $data['controls'] = $this->input->post("controls");
        // if ($this->user_model->update_causeofconfinement($data) && $this->user_model->insert_totalsurgical($data)) 
        if ($this->surgical_model->insert_surgical_output($data)) {
            $this->fetch_surgical_merge();
        } else {
            echo json_encode($result);
        }
    }

    //Total Surgical Sterilization
    public function mandatotalsurgical($month = NULL) {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Total Surgical Sterilization";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
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
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js',
                'assets/js/mandatotalsurg.js');

            if ($month == NULL) {
                $monthnow = new DateTime();
                $monthx = $monthnow->format('Y-m');
            } else {
                $monthx = $month;
            }
            $data["monthx"] = $monthx;
            $data['bilateral'] = $this->user_model->get_total_surgical_data($monthx, "BILATERAL TUBAL LIGATION");
            $data['vasectomy'] = $this->user_model->get_total_surgical_data($monthx, "VASECTOMY");
            $data['allnon'] = intval($data["bilateral"]["non"]) + intval($data['vasectomy']["non"]);
            $data['allnhip'] = intval($data["bilateral"]["nhip"]) + intval($data['vasectomy']["nhip"]);
            $this->user_page('mandatotalsurgical', $data);
        } else {
            $this->index();
        }
    }

//    public function fetch_total_surgical()
//    {
//       $result = array('status' => false);
//        $result['month'] = $this->input->post('s_date');
//        $result["total_surgical"] = $this->user_model->get_total_surgical_data($result['month']);
//        $result["total_surgical_total"] = $this->user_model->get_total_surgical_total($result['month']);
//        $result['status'] = true;
//       
//      echo json_encode($result);
//    }




    public function mandatotalsurgicalmerge($month) {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Total Surgical Sterilization";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/mandatotalsurg.js');

            $monthnow = new DateTime($month);
            $data['monthx'] = $monthnow->format('F Y');
            $data['monthxx'] = $month;
            $data["diagnosis"] = $this->user_model->get_diagnosis_summary();
            $this->user_page('mandatotalsurgicalmerge', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_total_surgical_merge() {
        $month = $this->input->post('s_date');
        $fetch_data = $this->user_model->get_total_surgical_merge_datatables($month);
        $data = array();
        // $number = 1;
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = "";
            $sub_array[] = $row->hascateg;
            $sub_array[] = $row->Diag_surg;
            $sub_array[] = $row->caseno;
            $sub_array[] = $row->name;
            $sub_array[] = $row->dischadate;
            $sub_array[] = $row->phicmembr;
            $data[] = $sub_array;

            // $number++;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_total_surgical_merge_data($month),
            "recordsFiltered" => $this->user_model->get_total_surgical_merge_filtered_data($month),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function merge_total_surgical() {
        $result = array('status' => FALSE);
        if ($this->has_log_in()) {
            $data['controls'] = $this->input->post('controls');
            $data['category'] = $this->input->post('category');
            if ($this->user_model->insert_totalsurgical($data)) {
                $result["status"] = true;
            }
            echo json_encode($result);
        }
    }

//    public function merge_total_surgical()
//    {
//
//        $result = array('status' => FALSE);
//            $data['surgicalsterile'] = $this->input->post('confinename');
//            $data['nhip'] = $this->input->post('confinenhip');
//            $data['nonnhip'] = $this->input->post('confinenon');
//            $data['total'] = $this->input->post('total');
//            $data['controls'] = $this->input->post("controls");
//             // if ($this->user_model->update_causeofconfinement($data) && $this->user_model->insert_totalsurgical($data)) 
//            if ( $this->user_model->insert_totalsurgical($data)) 
//            {
//                $this->fetch_total_surgical_merge();
//            }
//            else
//            {
//                echo json_encode($result); 
//            } 
//    }
    //Obstetrical Procedures
    public function mandaobstetric($month = NULL) {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Obstetrical Procedures";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js',
                'assets/js/mandaobstetricmerge.js');


            if ($month == NULL) {
                $monthnow = new DateTime();
                $monthx = $monthnow->format('Y-m');
            } else {
                $monthx = $month;
            }
            $data["monthx"] = $monthx;
            $data['obprocedure'] = $this->user_model->get_ob_procedure($monthx);
            $data["cs"] = $this->user_model->get_ob_procedure_cs($monthx);
            $data['indication'] = $this->user_model->get_top_obstetric_procedure($monthx);



            $this->user_page('mandaobstetric', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_obstetric_procedure() {
        $month = $this->input->post('s_date');
        $fetch_data = $this->user_model->get_obstetric_procedure_datatables($month);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = '';
            $sub_array[] = $row->diagcateg;
            $sub_array[] = $row->diagnosis;
            $sub_array[] = $row->nhip;
            $sub_array[] = $row->non;
            $sub_array[] = '';


            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_obstetric_procedure_data($month),
            "recordsFiltered" => $this->user_model->get_obstetric_procedure_filtered_data($month),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function merge_obprocedure() {

        $result = array('status' => FALSE);
        $data['confinename'] = $this->input->post('confinename');
        $data['nhip'] = $this->input->post('confinenhip');
        $data['non'] = $this->input->post('confinenon');
        $data['total'] = $this->input->post('total');
        $data['diagnosis'] = $this->input->post("diagnosis");
        if ($this->user_model->update_obprocedure($data) && $this->user_model->insert_obprocedure($data)) {
            $this->fetch_obstetric_procedure();
        } else {
            echo json_encode($result);
        }
    }

    //Monthly Mortality Census
    public function mandamortality() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Monthly Mortality Census";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js',
                'assets/js/mandamortality.js');

            $this->user_page('mandamortality', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_mortality_case() {
        $month = $this->input->post('s_date');
        $fetch_data = $this->user_model->get_mortality_cases_datatables($month);
        $data = array();
        $number = 1;
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $number . '. ' . $row->categdiag;
            $sub_array[] = $row->nhip;
            $sub_array[] = $row->non;
            $data[] = $sub_array;

            $number++;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_mortality_cases_data($month),
            "recordsFiltered" => $this->user_model->get_mortality_cases_filtered_data($month),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //Referrals
    public function mandareferrals() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Referrals";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
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
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js',
                'assets/js/mandareferrals.js');

            $this->user_page('mandareferrals', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_referrals() {
        $s_date = $this->input->post('start_date');
        $fetch_data = $this->user_model->get_referrals_datatables($s_date);
        $data = array();
        $number = 1;
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = $number . '. ' . $row->reasonforreferral;
            $sub_array[] = $row->nhip;
            $sub_array[] = $row->non;
            $data[] = $sub_array;

            $number++;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_referrals_data($s_date),
            "recordsFiltered" => $this->user_model->get_referrals_filtered_data($s_date),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function mandatoryreport_report() {

        $data['date'] = new DateTime($this->input->post('s_date'));
        $data['month'] = date_format($data['date'], "F");
        $data['year'] = date_format($data['date'], "Y");


        //daily census
        $month = $this->input->post('s_date');
        $data['census_month'] = $this->user_model->get_daily_census_of_nhip($month);

        $totalnhip = 0;
        $totalnon = 0;
        $totalpat = 0;


        for ($i = 0; $i < count($data['census_month']); $i++) {
            $totalnhip += $data['census_month'][$i]['nhip'];
            $nhip = $totalnhip;
            $data["phic"] = number_format($totalnhip, 0);
        }

        for ($i = 0; $i < count($data['census_month']); $i++) {
            $totalnon += $data['census_month'][$i]['non'];
            $data["non"] = number_format($totalnon, 0);
        }

        for ($i = 0; $i < count($data['census_month']); $i++) {
            $totalpat += $data['census_month'][$i]['totalx'];
            $pat = $totalpat;
            $data["pat"] = number_format($totalpat, 0);
        }


        //discharges

        $data["discharge_month"] = $this->user_model->get_daily_discharges($month);
        $dischanhip = 0;
        $dischanon = 0;
        $dischapat = 0;



        for ($i = 0; $i < count($data['discharge_month']); $i++) {
            $dischanhip += $data['discharge_month'][$i]['nhip'];
            $disnhip = $dischanhip;
            $data["disphic"] = number_format($dischanhip, 0);
        }

        for ($i = 0; $i < count($data['discharge_month']); $i++) {
            $dischanon += $data['discharge_month'][$i]['non'];
            $data["disnon"] = number_format($dischanon, 0);
        }

        for ($i = 0; $i < count($data['discharge_month']); $i++) {
            $dischapat += $data['discharge_month'][$i]['totalx'];
            $data["dispat"] = number_format($dischapat, 0);
        }

        //quality assurance indicator

        $data["beds"] = $this->user_model->get_authorized_bed();
        $monthstart = date("Y-m-01", strtotime($month . "-01"));
        $monthend = date("Y-m-t", strtotime($month . "-01"));

        $d = new DateTime($monthstart);
        $e = new DateTime($monthend);

        $diff = date_diff($e, $d);
        $data['dd'] = $diff->format('%a') + 1;

        //MBOR
        $data["DOHauthorizedbed"] = $data["beds"][0]["DOHauthorizedbed"];
        $dividend = $data['dd'] * $data["beds"][0]["DOHauthorizedbed"];
        $rate = intval($pat) / intval($dividend);
        $data["mbor"] = number_format($rate * 100, 2);


        //MNHIBOR
        $data["authorizedbed"] = number_format($data["beds"][0]["authorizedbed"], 0);
        $dividendx = $data['dd'] * $data["beds"][0]["authorizedbed"];
        $ratex = intval($nhip) / intval($dividendx);
        $data["MNHIBOR"] = number_format($ratex * 100, 2);

        //alsp

        if ($disnhip === 0) {
            $disnhip = 1;
        }
        $alsp = intval($nhip) / intval($disnhip);
        $data['alspp'] = number_format($alsp, 2);

        //newborn census
        $data["newborn_census"] = $this->user_model->get_newborn_census($month);

        //confinement_causes
        $data["confinement_causes"] = $this->confine_model->get_top_confinement_causes_report($month);

        //surgical

        $data['surgical_output'] = $this->surgical_model->get_final_surgical_output($month);
//
//            //total surgical
        $data['bilateral'] = $this->user_model->get_total_surgical_data($month, "BILATERAL TUBAL LIGATION");
        $data['vasectomy'] = $this->user_model->get_total_surgical_data($month, "VASECTOMY");
        $data['allnon'] = intval($data["bilateral"]["non"]) + intval($data['vasectomy']["non"]);
        $data['allnhip'] = intval($data["bilateral"]["nhip"]) + intval($data['vasectomy']["nhip"]);
//
//            //obprocedure
        $data['obprocedure'] = $this->user_model->get_ob_procedure($month);
        $data["cs"] = $this->user_model->get_ob_procedure_cs($month);
        $data['indication'] = $this->user_model->get_top_obstetric_procedure($month);
//
//            //mortality
        $data['mortality'] = $this->user_model->get_mortality($month);
//            //referrals
        $data["referrals"] = $this->user_model->get_referral($month);
        //profile

        $data["profile"] = $this->user_model->get_mandaprofile();

        $this->load->library('pdf');
        $this->pdf->load_view('reports/mandatoryreport', $data);
        $this->pdf->set_paper('Legal', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(525, 20, "Page {PAGE_NUM} ", $font, 8, array(0, 0, 0));
        $this->pdf->stream('PHIC_Mandatory_Report (' . $data["date"] . ').pdf', array('Attachment' => 0));
    }

    public function fetch_ledger() {
        $code = $this->input->post("bcode");
        $total['month'] = $this->input->post("month");
//        $s_date = $this->input->post('s_datexx');

        $total['frequency'] = $this->user_model->get_med_frequency($code, $total['month']);

        #region
        $month1 = new DateTime($total['frequency'][0]['datex']);
        $total['month1'] = date_format($month1, 'F Y');
        $month2 = new DateTime($total['frequency'][1]['datex']);
        $total['month2'] = date_format($month2, 'F Y');
        $month3 = new DateTime($total['frequency'][2]['datex']);
        $total['month3'] = date_format($month3, 'F Y');
        $month4 = new DateTime($total['frequency'][3]['datex']);
        $total['month4'] = date_format($month4, 'F Y');
        $month5 = new DateTime($total['frequency'][4]['datex']);
        $total['month5'] = date_format($month5, 'F Y');
        $month6 = new DateTime($total['frequency'][5]['datex']);
        $total['month6'] = date_format($month6, 'F Y');
        #endregion
        $fetch_data = $this->user_model->make_ledger_datatables($code, $total['month']);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->dscr;
            $sub_array[] = $row->transactiontype;
            $sub_array[] = $row->cost;
            $sub_array[] = $row->qty;
            $sub_array[] = $row->totalcost;
            $sub_array[] = $row->endbal;
            $sub_array[] = $row->tdate;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_ledger_data($code, $total['month']),
            "recordsFiltered" => $this->user_model->get_ledger_filtered_data($code, $total['month']),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function fetch_ledger1() {
        $code = $this->input->post("bcode");
        $dept = $this->input->post('dept');
        $transtype = $this->input->post('transtype');
        $monthdate = $this->input->post('monthdate');
        $total['frequency'] = $this->user_model->get_med_frequency1($code, $dept, $transtype, $monthdate);

        $fetch_data = $this->user_model->make_ledger1_datatables($code, $dept, $transtype, $monthdate);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->dscr;
            $sub_array[] = $this->format_dates($row->tdate);
            $sub_array[] = $this->format_money($row->realcost);
            $sub_array[] = $this->format_moneyx($row->qty);
            $sub_array[] = $this->format_money($row->totalamt);
            $sub_array[] = $row->transactiontype;
            if ($row->transactiontype == "DELIVERY" || $row->transactiontype == "DELIVRET") {
                $sub_array[] = $row->Supplier;
            } else {
                $sub_array[] = '';
            }
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_ledger1_data($code, $dept, $transtype, $monthdate),
            "recordsFiltered" => $this->user_model->get_ledger1_filtered_data($code, $dept, $transtype, $monthdate),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    //alingling: PHIC Status

    public function phicinprocess() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - IN PROCESS";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/phicinprocess.js',
                'assets/js/lock.js');

            $this->user_page('phicinprocess', $data);
        } else {
            $this->index();
        }
    }

    //fetch_inprocess: Alingling
    public function fetch_phic_inprocess_accnt() {
        $s_date = new DateTime($this->input->post('start_date'));
        $total = array('px' => 0, 'amount' => 0.0, 'datex' => $s_date);

        $fetch_data = $this->user_model->make_inprocess_phic_accnt_datatables($s_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            if ($row->ageing != "61 Days above") {
                $total["px"] += $row->total;
                $total["amount"] += $row->totalamount;
            }

            $sub_array = array();

            if ($row->ageing === "61 Days above") {
                $sub_array[] = "<span style='color: red'>" . $row->ageing . "</span>";
                $sub_array[] = "<span style='color: red'>" . $row->total . "</span>";
                $sub_array[] = "<span style='color: red'>" . $this->format_money($row->totalamount) . "</span>";
            } else {
                $sub_array[] = $row->ageing;
                $sub_array[] = $row->total;
                $sub_array[] = $this->format_money($row->totalamount);
            }

            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_inprocess_phic_accnt_data($s_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_inprocess_phic_accnt_filtered_data($s_date->format('Y-m-d')),
            "data" => $data,
            "total" => $total,
        );
        echo json_encode($output);
    }

    //fetch_inprocess patient: alingling
    public function fetch_phic_inprocess_patients() {
        $s_date = new DateTime($this->input->post('datex'));
        $aging = $this->input->post('aging');

//        $end_age = $this->input->post('end_age');


        $fetch_data = $this->user_model->make_phic_inprocess_patient_datatables($s_date->format('Y-m-d'), $aging);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->PatientName;
            $sub_array[] = $this->format_money($row->hcifee);
            $sub_array[] = $this->format_money($row->profee);
            $sub_array[] = $this->format_date($row->dischargedate);
            $sub_array[] = $this->format_date($row->proc1date);
            $sub_array[] = $row->age;
            $sub_array[] = $row->pStatus;
            $sub_array[] = $row->processdate;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_phic_inprocess_patients_data($s_date->format('Y-m-d'), $aging),
            "recordsFiltered" => $this->user_model->get_phic_inprocess_patients_filtered_data($s_date->format('Y-m-d'), $aging),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function get_phic_inprocess_report() {
        $data["s_date"] = $this->input->post('s_date');

        $this->load->library('pdf');
//         = $this->get_current_dates();
        $data["title"] = "IN PROCESS";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $data["phicstat"] = $this->user_model->get_phic_inprocess_report($data["s_date"]);

        $this->pdf->load_view('reports/phicstatus', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("PHIC_IN_PROCESS(" . $data["s_date"] . ").pdf", array('Attachment' => 0));
//        
    }

    public function phicreturn() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - RETURN";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/phicreturn.js',
                'assets/js/lock.js');

            $this->user_page('phicreturn', $data);
        } else {
            $this->index();
        }
    }

    //fetch_inprocess: Alingling
    public function fetch_phic_return_accnt() {
        $s_date = new DateTime($this->input->post('start_date'));
        $total = array('px' => 0, 'amount' => 0.0, 'datex' => $s_date);

        $fetch_data = $this->user_model->make_return_phic_accnt_datatables($s_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            if ($row->ageing != "61 Days above") {
                $total["px"] += $row->total;
                $total["amount"] += $row->totalamount;
            }

            $sub_array = array();

            if ($row->ageing === "61 Days above") {
                $sub_array[] = "<span style='color: red'>" . $row->ageing . "</span>";
                $sub_array[] = "<span style='color: red'>" . $row->total . "</span>";
                $sub_array[] = "<span style='color: red'>" . $this->format_money($row->totalamount) . "</span>";
            } else {
                $sub_array[] = $row->ageing;
                $sub_array[] = $row->total;
                $sub_array[] = $this->format_money($row->totalamount);
            }

            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_return_phic_accnt_data($s_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_return_phic_accnt_filtered_data($s_date->format('Y-m-d')),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    //fetch_transmitted_info: alingling
    public function fetch_phic_return_patients() {
        $s_date = new DateTime($this->input->post('datex'));
        $aging = $this->input->post('aging');

//        $end_age = $this->input->post('end_age');


        $fetch_data = $this->user_model->make_phic_return_patient_datatables($s_date->format('Y-m-d'), $aging);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->PatientName;
            $sub_array[] = $this->format_money($row->hcifee);
            $sub_array[] = $this->format_money($row->profee);
            $sub_array[] = $this->format_date($row->dischargedate);
            $sub_array[] = $this->format_date($row->proc1date);
            $sub_array[] = $row->age;
            $sub_array[] = $row->pStatus;
            $sub_array[] = $row->processdate;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_phic_return_patients_data($s_date->format('Y-m-d'), $aging),
            "recordsFiltered" => $this->user_model->get_phic_return_patients_filtered_data($s_date->format('Y-m-d'), $aging),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function generate_phic_return_report() {
        $data["s_date"] = $this->input->post('s_date');

        $this->load->library('pdf');
//         = $this->get_current_dates();
        $data["title"] = "RETURN";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["phicstat"] = $this->user_model->get_phic_return_report($data["s_date"]);

        $this->pdf->load_view('reports/phicstatus', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("PHIC_RETURN(" . $data["s_date"] . ").pdf", array('Attachment' => 0));
//        
    }

    public function phicvoucher() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - WITH VOUCHER";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/phicvoucher.js',
                'assets/js/lock.js');

            $this->user_page('phicvoucher', $data);
        } else {
            $this->index();
        }
    }

    //fetch_with voucher: Alingling
    public function fetch_phic_voucher_accnt() {
        $s_date = new DateTime($this->input->post('start_date'));
        $total = array('px' => 0, 'amount' => 0.0, 'datex' => $s_date);

        $fetch_data = $this->user_model->make_voucher_phic_accnt_datatables($s_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            if ($row->ageing != "61 Days above") {
                $total["px"] += $row->total;
                $total["amount"] += $row->totalamount;
            }

            $sub_array = array();

            if ($row->ageing === "61 Days above") {
                $sub_array[] = "<span style='color: red'>" . $row->ageing . "</span>";
                $sub_array[] = "<span style='color: red'>" . $row->total . "</span>";
                $sub_array[] = "<span style='color: red'>" . $this->format_money($row->totalamount) . "</span>";
            } else {
                $sub_array[] = $row->ageing;
                $sub_array[] = $row->total;
                $sub_array[] = $this->format_money($row->totalamount);
            }

            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_voucher_phic_accnt_data($s_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_voucher_phic_accnt_filtered_data($s_date->format('Y-m-d')),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    //fetch_transmitted_info: alingling
    public function fetch_phic_voucher_patients() {
        $s_date = new DateTime($this->input->post('datex'));
        $aging = $this->input->post('aging');

//        $end_age = $this->input->post('end_age');


        $fetch_data = $this->user_model->make_phic_voucher_patient_datatables($s_date->format('Y-m-d'), $aging);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->PatientName;
            $sub_array[] = $this->format_money($row->hcifee);
            $sub_array[] = $this->format_money($row->profee);
            $sub_array[] = $this->format_date($row->dischargedate);
            $sub_array[] = $this->format_date($row->proc1date);
            $sub_array[] = $row->age;
            $sub_array[] = $row->pStatus;
            $sub_array[] = $row->processdate;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_phic_voucher_patients_data($s_date->format('Y-m-d'), $aging),
            "recordsFiltered" => $this->user_model->get_phic_voucher_patients_filtered_data($s_date->format('Y-m-d'), $aging),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function generate_phic_voucher_report() {
        $data["s_date"] = $this->input->post('s_date');

        $this->load->library('pdf');
//         = $this->get_current_dates();
        $data["title"] = "WITH VOUCHER";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["phicstat"] = $this->user_model->get_phic_voucher_report($data["s_date"]);

        $this->pdf->load_view('reports/phicstatus', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("WithVoucher(" . $data["s_date"] . ").pdf", array('Attachment' => 0));
//        
    }

    public function phicdenied() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - WITH VOUCHER";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/phicdenied.js',
                'assets/js/lock.js');

            $this->user_page('phicdenied', $data);
        } else {
            $this->index();
        }
    }

    //fetch_with voucher: Alingling
    public function fetch_phic_denied_accnt() {
        $s_date = new DateTime($this->input->post('start_date'));
        $total = array('px' => 0, 'amount' => 0.0, 'datex' => $s_date);

        $fetch_data = $this->user_model->make_denied_phic_accnt_datatables($s_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            if ($row->ageing != "61 Days above") {
                $total["px"] += $row->total;
                $total["amount"] += $row->totalamount;
            }

            $sub_array = array();

            if ($row->ageing === "61 Days above") {
                $sub_array[] = "<span style='color: red'>" . $row->ageing . "</span>";
                $sub_array[] = "<span style='color: red'>" . $row->total . "</span>";
                $sub_array[] = "<span style='color: red'>" . $this->format_money($row->totalamount) . "</span>";
            } else {
                $sub_array[] = $row->ageing;
                $sub_array[] = $row->total;
                $sub_array[] = $this->format_money($row->totalamount);
            }

            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_denied_phic_accnt_data($s_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_denied_phic_accnt_filtered_data($s_date->format('Y-m-d')),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    //fetch_phic_denied_patients: alingling
    public function fetch_phic_denied_patients() {
        $s_date = new DateTime($this->input->post('datex'));
        $aging = $this->input->post('aging');

//        $end_age = $this->input->post('end_age');


        $fetch_data = $this->user_model->make_phic_denied_patient_datatables($s_date->format('Y-m-d'), $aging);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->PatientName;
            $sub_array[] = $this->format_money($row->hcifee);
            $sub_array[] = $this->format_money($row->profee);
            $sub_array[] = $this->format_date($row->dischargedate);
            $sub_array[] = $this->format_date($row->proc1date);
            $sub_array[] = $row->age;
            $sub_array[] = $row->pStatus;
            $sub_array[] = $row->processdate;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_phic_denied_patients_data($s_date->format('Y-m-d'), $aging),
            "recordsFiltered" => $this->user_model->get_phic_denied_patients_filtered_data($s_date->format('Y-m-d'), $aging),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function get_phic_denied_report() {
        $data["s_date"] = $this->input->post('s_date');

        $this->load->library('pdf');
//         = $this->get_current_dates();
        $data["title"] = "DENIED";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $data["phicstat"] = $this->user_model->get_phic_denied_report($data["s_date"]);

        $this->pdf->load_view('reports/phicstatus', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("HMO_as_of_date(" . $data["s_date"] . ").pdf", array('Attachment' => 0));
//        
    }

    public function phiccheck() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - WITH CHECK";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/phiccheck.js',
                'assets/js/lock.js');

            $this->user_page('phiccheck', $data);
        } else {
            $this->index();
        }
    }

    //fetch_with voucher: Alingling
    public function fetch_phic_check_accnt() {
        $s_date = new DateTime($this->input->post('start_date'));
        $total = array('px' => 0, 'amount' => 0.0, 'datex' => $s_date);

        $fetch_data = $this->user_model->make_check_phic_accnt_datatables($s_date->format('Y-m-d'));
        $data = array();
        foreach ($fetch_data as $row) {
            if ($row->ageing != "61 Days above") {
                $total["px"] += $row->total;
                $total["amount"] += $row->totalamount;
            }

            $sub_array = array();

            if ($row->ageing === "61 Days above") {
                $sub_array[] = "<span style='color: red'>" . $row->ageing . "</span>";
                $sub_array[] = "<span style='color: red'>" . $row->total . "</span>";
                $sub_array[] = "<span style='color: red'>" . $this->format_money($row->totalamount) . "</span>";
            } else {
                $sub_array[] = $row->ageing;
                $sub_array[] = $row->total;
                $sub_array[] = $this->format_money($row->totalamount);
            }

            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_check_phic_accnt_data($s_date->format('Y-m-d')),
            "recordsFiltered" => $this->user_model->get_check_phic_accnt_filtered_data($s_date->format('Y-m-d')),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    //fetch_phic_denied_patients: alingling
    public function fetch_phic_check_patients() {
        $s_date = new DateTime($this->input->post('datex'));
        $aging = $this->input->post('aging');

        $fetch_data = $this->user_model->make_phic_check_patient_datatables($s_date->format('Y-m-d'), $aging);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->PatientName;
            $sub_array[] = $this->format_money($row->hcifee);
            $sub_array[] = $this->format_money($row->profee);
            $sub_array[] = $this->format_date($row->dischargedate);
            $sub_array[] = $this->format_date($row->proc1date);
            $sub_array[] = $row->age;
            $sub_array[] = $row->pStatus;
            $sub_array[] = $row->processdate;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_phic_check_patients_data($s_date->format('Y-m-d'), $aging),
            "recordsFiltered" => $this->user_model->get_phic_check_patients_filtered_data($s_date->format('Y-m-d'), $aging),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // HMOasofdate: Alingling
    public function HMOasofdate() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "HMO: AR as of date";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/HMOasofdate.js',
                'assets/js/lock.js');

            $data["hmo"] = $this->user_model->getallhmo();

            $this->user_page('HMOasofdate', $data);
        } else {
            $this->index();
        }
    }

    //fetch_hmo_asofdate_patients: alingling
    public function fetch_hmo_asofdate_patients() {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $hmocode = $this->input->post('hmocode');

        $hosphmo = 0;
        $pfhmo = 0;
        $total = array('pfhmo' => 0, 'hosphmo' => 0.0);
        $data["hmo"] = $this->user_model->generate_HMO_asof_date_report($start_date, $end_date, $hmocode);
//        $data['hh'] = $data['hmo']['pxtype'];
        for ($i = 0; $i < count($data["hmo"]); $i++) {
            $total['hosphmo'] += abs($data['hmo'][$i]['HMOHOSP']);
            $total['pfhmo'] += abs($data['hmo'][$i]['HMOPF']);
        }
        $fetch_data = $this->user_model->make_hmo_asofdate_patients_datatables($start_date, $end_date, $hmocode);
        $data = array();
        foreach ($fetch_data as $row) {


            $sub_array = array();
            $sub_array[] = $row->casecodex;
            $sub_array[] = $row->pxtype;
            $sub_array[] = $row->patientname;
            $sub_array[] = $this->format_date($row->discha);
            $sub_array[] = $row->hmoname;
            $sub_array[] = abs($row->ACTUALHOSP) === null ? "₱ 0.00" : $this->format_money(abs($row->ACTUALHOSP));
            $sub_array[] = abs($row->PHICHOSP) === null ? "₱ 0.00" : $this->format_money(abs($row->PHICHOSP));
            $sub_array[] = abs($row->HMOHOSP) === null ? "₱ 0.00" : $this->format_money(abs($row->HMOHOSP));
            $sub_array[] = abs($row->ACTUALPF) === null ? "₱ 0.00" : $this->format_money(abs($row->ACTUALPF));
            $sub_array[] = abs($row->PHICPF) === null ? "₱ 0.00" : $this->format_money(abs($row->PHICPF));
            $sub_array[] = abs($row->HMOPF) === null ? "₱ 0.00" : $this->format_money(abs($row->HMOPF));
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_hmo_asofdate_patients_data($start_date, $end_date, $hmocode),
            "recordsFiltered" => $this->user_model->get_hmo_asofdate_patients_filtered_data($start_date, $end_date, $hmocode),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    //HMO as of date:alingling

    public function generate_HMO_asof_date_report() {
        $this->load->library('pdf');
        $data["s_date"] = $this->input->post('start_date');
        $s_date = new DateTime($data['s_date']);
        $data['start'] = date_format($s_date, 'F j, Y');
        $data['e_date'] = $this->input->post('end_date');
        $e_date = new DateTime($data['e_date']);
        $data['end'] = date_format($e_date, 'F j, Y');




        $data["hmocode"] = $this->input->post('hmocodex');
        $data["hmonamex"] = $this->input->post("hmonamex");
        $data["hospital"] = $this->input->post('hospital');
        $data["proffee"] = $this->input->post("proffee");
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $da = new DateTime($data['datenow']);
        $data['date'] = date_format($da, 'F j, Y');
        $data['time'] = date_format($da, 'H:i:s A');

        $data["title"] = "HMO AS OF DATE";
        $data['totalactual'] = 0;
        $data['totalPHICHOSP'] = 0;
        $data['totalHMOHOSP'] = 0;
        $data['totalACTUALPF'] = 0;
        $data['totalPHICPF'] = 0;
        $data['totalHMOPF'] = 0;
        $data["hmo"] = $this->user_model->generate_HMO_asof_date_report($data["s_date"], $data['e_date'], $data["hmocode"]);
//        $data['hh'] = $data['hmo']['pxtype'];
        for ($i = 0; $i < count($data["hmo"]); $i++) {
            $data['totalactual'] += $data['hmo'][$i]['ACTUALHOSP'];
            $data['totalPHICHOSP'] += $data['hmo'][$i]['PHICHOSP'];
            $data['totalHMOHOSP'] += $data['hmo'][$i]['HMOHOSP'];
            $data['totalACTUALPF'] += $data['hmo'][$i]['ACTUALPF'];
            $data['totalPHICPF'] += $data['hmo'][$i]['PHICPF'];
            $data['totalHMOPF'] += $data['hmo'][$i]['HMOPF'];
        }


        $this->pdf->load_view('reports/hmoasofdate_report', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("Georgia", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("HMO_as_of_date(" . $data["s_date"] . ").pdf", array('Attachment' => 0));
    }

    // alingling
    public function fetch_patients_hmo() {
        $casecode = $this->input->post('casecode');
        $fetch_data = $this->user_model->make_patients_hmo_datatables($casecode);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->hmoname;
            $sub_array[] = $row->hmocredit === null ? "₱ 0.00" : $this->format_money($row->hmocredit);
            $sub_array[] = $this->format_date($row->hmoapprovaldate);
            $sub_array[] = intval($row->priorityno);
            $sub_array[] = $row->hmocardholder;
            $sub_array[] = $row->hmocardno;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_patients_hmo_data($casecode),
            "recordsFiltered" => $this->user_model->get_patients_hmo_filtered_data($casecode),
            "data" => $data,
            "fetch" => $fetch_data
        );
        echo json_encode($output);
    }

    /* List of HMO with patients 
     * @author Alingling
     */

    public function hmolist() {
        if ($this->has_log_in()) {
            $data["page_title"] = "List of HMO";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/hmolist.js');



            $this->user_page('hmolist', $data);
        } else {
            $this->index();
        }
    }

    // alingling
    public function get_hmolist() {
        $month = $this->input->post('start_date');
        $fetch_data = $this->user_model->make_hmo_list_datatables($month);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->hmocode;
            $sub_array[] = $row->hmoname;
            $sub_array[] = $row->patientcount;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_hmo_list_data($month),
            "recordsFiltered" => $this->user_model->get_hmo_list_filtered_data($month),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // alingling
    public function get_hmolist_patients() {
        $month = $this->input->post('s_date');
        $hmocode = $this->input->post('hmocode');
        $fetch_data = $this->user_model->make_hmolist_patient_datatables($month, $hmocode);
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->caseno;
            $sub_array[] = $row->patientname;
            $sub_array[] = $this->format_dates($row->admission);
            $sub_array[] = $this->format_money($row->hmocredit);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_hmolist_patient_data($month, $hmocode),
            "recordsFiltered" => $this->user_model->get_hmolist_patient_filtered_data($month, $hmocode),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // HMO Account Only: Alingling
    public function HMOacct() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "HMO Accounts Only";

            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/hmoacctonly.js',
                'assets/js/lock.js');

            $data["hmo"] = $this->user_model->getallhmo();

            $this->user_page('hmoacctonly', $data);
        } else {
            $this->index();
        }
    }

    //fetch_hmo_asofdate_patients: alingling
    public function fetch_hmo_acct_patients() {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $hmocode = $this->input->post('hmocode');

        $hosphmo = 0;
        $pfhmo = 0;
        $total = array('pfhmo' => 0, 'hosphmo' => 0.0);
        $data["hmo"] = $this->user_model->generate_HMO_acct_report($start_date, $end_date, $hmocode);
//        $data['hh'] = $data['hmo']['pxtype'];
        for ($i = 0; $i < count($data["hmo"]); $i++) {
            $total['hosphmo'] += abs($data['hmo'][$i]['HMOHOSP']);
            $total['pfhmo'] += abs($data['hmo'][$i]['HMOPF']);
        }

        $fetch_data = $this->user_model->make_hmo_acct_patients_datatables($start_date, $end_date, $hmocode);
        $data = array();
        foreach ($fetch_data as $row) {


            $sub_array = array();
            $sub_array[] = $row->casecodex;
            $sub_array[] = $row->pxtype;
            $sub_array[] = $row->patientname;
            $sub_array[] = $this->format_date($row->discha);
            $sub_array[] = $row->hmoname;
            $sub_array[] = abs($row->HMOHOSP) === null ? "₱ 0.00" : $this->format_money(abs($row->HMOHOSP));
            $sub_array[] = abs($row->HMOPF) === null ? "₱ 0.00" : $this->format_money(abs($row->HMOPF));
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_hmo_acct_patients_data($start_date, $end_date, $hmocode),
            "recordsFiltered" => $this->user_model->get_hmo_acct_patients_filtered_data($start_date, $end_date, $hmocode),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    //HMO as of date:alingling

    public function generate_HMO_acct_report() {
        $this->load->library('pdf');
        $data["s_date"] = $this->input->post('start_date');
        $s_date = new DateTime($data['s_date']);
        $data['start'] = date_format($s_date, 'F j, Y');
        $data['e_date'] = $this->input->post('end_date');
        $e_date = new DateTime($data['e_date']);
        $data['end'] = date_format($e_date, 'F j, Y');




        $data["hmocode"] = $this->input->post('hmocodex');
        $data["hmonamex"] = $this->input->post("hmonamex");
        $data["hospital"] = $this->input->post('hospital');
        $data["proffee"] = $this->input->post("proffee");
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $da = new DateTime($data['datenow']);
        $data['date'] = date_format($da, 'F j, Y');
        $data['time'] = date_format($da, 'H:i:s A');

        $data["title"] = "HMO Accounts";
        $data['totalHMOHOSP'] = 0;
        $data['totalHMOPF'] = 0;
        $data["hmo"] = $this->user_model->generate_HMO_acct_report($data["s_date"], $data['e_date'], $data["hmocode"]);
//        $data['hh'] = $data['hmo']['pxtype'];
        for ($i = 0; $i < count($data["hmo"]); $i++) {
            $data['totalHMOHOSP'] += $data['hmo'][$i]['HMOHOSP'];
            $data['totalHMOPF'] += $data['hmo'][$i]['HMOPF'];
        }


        $this->pdf->load_view('reports/hmoacct_report', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("Georgia", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("HMO_as_of_date(" . $data["s_date"] . ").pdf", array('Attachment' => 0));
    }

    public function fetch_doctors_patients() {
        $s_date = new DateTime($this->input->post('start_date'));
        $e_date = new DateTime($this->input->post('end_date'));
//        $classification = $this->input->post('classification');
        $doccode = $this->input->post('doccode');


        $fetch_data = $this->user_model->make_all_doctors_patients_datatables($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            $sub_array[] = $row->name;
            $sub_array[] = $this->format_dates($row->admit);
            $sub_array[] = $this->format_dates($row->discharge);
            $sub_array[] = $row->phicmembr;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_all_doctors_patients_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode),
            "recordsFiltered" => $this->user_model->get_all_doctors_patients_filtered_data($s_date->format('Y-m-d'), $e_date->format('Y-m-d'), $doccode),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function generate_doctors_patients_report() {
        $s_date = new DateTime($this->input->post("datex"));
        $e_date = new DateTime($this->input->post("e_date"));
        $data['doccode'] = $this->input->post("dokie");
        $data['docname'] = $this->input->post("dokiename");

        $this->load->library('pdf');
        $data["s_date"] = $s_date->format("Y-m-d");
        $data["date"] = $s_date->format("m-d-Y");
        $data["e_date"] = $e_date->format("Y-m-d");
        $data["end_date"] = $e_date->format("m-d-Y");

        $data["class_record"] = $this->user_model->get_doctors_patient_report($data["s_date"], $data["e_date"], $data['doccode']);

        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $this->pdf->load_view('reports/doctorspatient', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("classification-list.pdf", array('Attachment' => 0));
    }

    // HMOasofdate: Alingling
    public function phinventorymonitor() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Pharmacy: Inventory Monitoring";

            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/phinventorymonitor.js',
                'assets/js/lock.js');



            $this->user_page('phinventorymonitor', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_inventory_monitoring() {
        $s_date = $this->input->post('start_date');
//       $e_date = new DateTime($this->input->post('end_date'));
//        $classification = $this->input->post('classification');
//        $doccode = $this->input->post('doccode');
        $total = array('beginning' => 0, 'sales' => 0.0, 'ending' => 0.0);

        $fetch_data = $this->user_model->make_inventory_monitoring_datatables($s_date);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['beginning'] += $row->beginningcost;
            $total['sales'] += $row->salescost;
            $total['ending'] += $row->endingcost;
//               $order_column = array("groupname",null, "beginningbalance","beginningcost", "purchaseqty",
//            "purchasescost","adjustqty","adjustcost","salesqty","salescost","endingbalance","endingcost");
            $sub_array = array();
            $sub_array[] = $row->groupname;
            $sub_array[] = '0';
            $sub_array[] = $row->beginningbalance;
            $sub_array[] = $this->format_money($row->beginningcost);
            $sub_array[] = $row->purchaseqty;
            $sub_array[] = $this->format_money($row->purchasescost);
            $sub_array[] = $row->adjustqty;
            $sub_array[] = $this->format_money($row->adjustcost);
            $sub_array[] = $row->salesqty;
            $sub_array[] = $this->format_money($row->salescost);
            $sub_array[] = $row->endingbalance;
            $sub_array[] = $this->format_money($row->endingcost);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_inventory_monitoring_data($s_date),
            "recordsFiltered" => $this->user_model->get_inventory_monitoring_filtered_data($s_date),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function generate_inventory_monitoring_report($dept) {
        $s_date = $this->input->post("start_date");
        $data['beginning'] = $this->input->post("beginning");
        $data['sales'] = $this->input->post("sales");
        $data['ending'] = $this->input->post("ending");
//        
        $this->load->library('pdf');
        $start_date = new DateTime($s_date);
        $data['datex'] = date_format($start_date, 'F Y');

        if ($dept == "pharmacy") {
            $data['title'] = "Pharmacy: Inventory Monitoring";
            $data["inventory"] = $this->user_model->generate_inventory_monitoring_report($s_date);
        } else if ($dept == "laboratory") {
            $data['title'] = "Laboratory: Inventory Monitoring";
            $data["inventory"] = $this->user_model->generate_lab_inventory_monitoring_report($s_date);
        } else if ($dept == "radiology") {
            $data['title'] = "Radiology: Inventory Monitoring";
            $data["inventory"] = $this->user_model->generate_rad_inventory_monitoring_report($s_date);
        } else {
            $data['title'] = "CSR and Office Supplies: Inventory Monitoring";
            $data["inventory"] = $this->user_model->generate_csr_inventory_monitoring_report($s_date);
        }

        $data['totalbegqty'] = 0;
        $data['totalbegcost'] = 0;
        $data['totalpurqty'] = 0;
        $data['totalpurcost'] = 0;
        $data['totaladjqty'] = 0;
        $data['totaladjcost'] = 0;
        $data['totalsalesqty'] = 0;
        $data['totalsalescost'] = 0;
        $data['totalendqty'] = 0;
        $data['totalendcost'] = 0;
//        $data['hh'] = $data['hmo']['pxtype'];
        for ($i = 0; $i < count($data["inventory"]); $i++) {
            $data['totalbegqty'] += $data['inventory'][$i]['beginningbalance'];
            $data['totalbegcost'] += $data['inventory'][$i]['beginningcost'];
            $data['totalpurqty'] += $data['inventory'][$i]['purchaseqty'];
            $data['totalpurcost'] += $data['inventory'][$i]['purchasescost'];
            $data['totaladjqty'] += $data['inventory'][$i]['adjustqty'];
            $data['totaladjcost'] += $data['inventory'][$i]['adjustcost'];
            $data['totalsalesqty'] += $data['inventory'][$i]['salesqty'];
            $data['totalsalescost'] += $data['inventory'][$i]['salescost'];
            $data['totalendqty'] += $data['inventory'][$i]['endingbalance'];
            $data['totalendcost'] += $data['inventory'][$i]['endingcost'];
        }

//            
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $da = new DateTime($data['datenow']);
        $data['date'] = date_format($da, 'F j, Y');
        $data['time'] = date_format($da, 'H:i:s A');
//        
        $this->pdf->load_view('reports/inventorymonitoring', $data);
        $this->pdf->set_paper('A4', 'landscape');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 570, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        if ($dept == "pharmacy") {
            $this->pdf->stream("pharmacy_inventory_monitoring.pdf", array('Attachment' => 0));
        } else if ($dept == "laboratory") {
            $this->pdf->stream("laboratory_inventory_monitoring.pdf", array('Attachment' => 0));
        } else if ($dept == "radiology") {
            $this->pdf->stream("radiology_inventory_monitoring.pdf", array('Attachment' => 0));
        } else {
            $this->pdf->stream("csr_and_officesupplies_inventory_monitoring.pdf", array('Attachment' => 0));
        }
    }

    public function fetch_groupname_info() {
        $s_date = $this->input->post('s_date');
        $groupname = $this->input->post('groupname');

        $total = array('beginning' => 0, 'sales' => 0.0, 'ending' => 0.0);

        $fetch_data = $this->user_model->make_inventory_monitoring_group_datatables($s_date, $groupname);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['beginning'] += $row->beginningcost;
            $total['sales'] += $row->salescost;
            $total['ending'] += $row->endingcost;
//               $order_column = array("groupname",null, "beginningbalance","beginningcost", "purchaseqty",
//            "purchasescost","adjustqty","adjustcost","salesqty","salescost","endingbalance","endingcost");
            $sub_array = array();
            $sub_array[] = $row->dscr;
            $sub_array[] = $row->unitprice;
            $sub_array[] = $row->beginningbalance;
            $sub_array[] = $this->format_money($row->beginningcost);
            $sub_array[] = $row->purchaseqty;
            $sub_array[] = $this->format_money($row->purchasescost);
            $sub_array[] = $row->adjustqty;
            $sub_array[] = $this->format_money($row->adjustcost);
            $sub_array[] = $row->salesqty;
            $sub_array[] = $this->format_money($row->salescost);
            $sub_array[] = $row->endingbalance;
            $sub_array[] = $this->format_money($row->endingcost);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_inventory_monitoring_group_data($s_date, $groupname),
            "recordsFiltered" => $this->user_model->get_inventory_monitoring_group_filtered_data($s_date, $groupname),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function labinventorymonitor() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Laboratory: Inventory Monitoring";

            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/labinventorymonitor.js',
                'assets/js/lock.js');



            $this->user_page('labinventorymonitor', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_lab_inventory_monitoring() {
        $s_date = $this->input->post('start_date');
//       $e_date = new DateTime($this->input->post('end_date'));
//        $classification = $this->input->post('classification');
//        $doccode = $this->input->post('doccode');
        $total = array('beginning' => 0, 'sales' => 0.0, 'ending' => 0.0);

        $fetch_data = $this->user_model->make_lab_inventory_monitoring_datatables($s_date);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['beginning'] += $row->beginningcost;
            $total['sales'] += $row->salescost;
            $total['ending'] += $row->endingcost;
//               $order_column = array("groupname",null, "beginningbalance","beginningcost", "purchaseqty",
//            "purchasescost","adjustqty","adjustcost","salesqty","salescost","endingbalance","endingcost");
            $sub_array = array();
            $sub_array[] = $row->groupname;
            $sub_array[] = '0';
            $sub_array[] = $row->beginningbalance;
            $sub_array[] = $this->format_money($row->beginningcost);
            $sub_array[] = $row->purchaseqty;
            $sub_array[] = $this->format_money($row->purchasescost);
            $sub_array[] = $row->adjustqty;
            $sub_array[] = $this->format_money($row->adjustcost);
            $sub_array[] = $row->salesqty;
            $sub_array[] = $this->format_money($row->salescost);
            $sub_array[] = $row->endingbalance;
            $sub_array[] = $this->format_money($row->endingcost);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_lab_inventory_monitoring_data($s_date),
            "recordsFiltered" => $this->user_model->get_lab_inventory_monitoring_filtered_data($s_date),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function fetch_groupname_info_lab() {
        $s_date = $this->input->post('s_date');
        $groupname = $this->input->post('groupname');

        $total = array('beginning' => 0, 'sales' => 0.0, 'ending' => 0.0);

        $fetch_data = $this->user_model->make_inventory_monitoring_lab_group_datatables($s_date, $groupname);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['beginning'] += $row->beginningcost;
            $total['sales'] += $row->salescost;
            $total['ending'] += $row->endingcost;
//               $order_column = array("groupname",null, "beginningbalance","beginningcost", "purchaseqty",
//            "purchasescost","adjustqty","adjustcost","salesqty","salescost","endingbalance","endingcost");
            $sub_array = array();
            $sub_array[] = $row->dscr;
            $sub_array[] = $row->unitprice;
            $sub_array[] = $row->beginningbalance;
            $sub_array[] = $this->format_money($row->beginningcost);
            $sub_array[] = $row->purchaseqty;
            $sub_array[] = $this->format_money($row->purchasescost);
            $sub_array[] = $row->adjustqty;
            $sub_array[] = $this->format_money($row->adjustcost);
            $sub_array[] = $row->salesqty;
            $sub_array[] = $this->format_money($row->salescost);
            $sub_array[] = $row->endingbalance;
            $sub_array[] = $this->format_money($row->endingcost);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_inventory_monitoring_lab_group_data($s_date, $groupname),
            "recordsFiltered" => $this->user_model->get_inventory_monitoring_lab_group_filtered_data($s_date, $groupname),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function radinventorymonitor() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Radiology: Inventory Monitoring";

            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/radinventorymonitor.js',
                'assets/js/lock.js');



            $this->user_page('radinventorymonitor', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_rad_inventory_monitoring() {
        $s_date = $this->input->post('start_date');
        $total = array('beginning' => 0, 'sales' => 0.0, 'ending' => 0.0);

        $fetch_data = $this->user_model->make_rad_inventory_monitoring_datatables($s_date);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['beginning'] += $row->beginningcost;
            $total['sales'] += $row->salescost;
            $total['ending'] += $row->endingcost;
            $sub_array = array();
            $sub_array[] = $row->groupname;
            $sub_array[] = '0';
            $sub_array[] = $row->beginningbalance;
            $sub_array[] = $this->format_money($row->beginningcost);
            $sub_array[] = $row->purchaseqty;
            $sub_array[] = $this->format_money($row->purchasescost);
            $sub_array[] = $row->adjustqty;
            $sub_array[] = $this->format_money($row->adjustcost);
            $sub_array[] = $row->salesqty;
            $sub_array[] = $this->format_money($row->salescost);
            $sub_array[] = $row->endingbalance;
            $sub_array[] = $this->format_money($row->endingcost);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_rad_inventory_monitoring_data($s_date),
            "recordsFiltered" => $this->user_model->get_rad_inventory_monitoring_filtered_data($s_date),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function fetch_groupname_info_rad() {
        $s_date = $this->input->post('s_date');
        $groupname = $this->input->post('groupname');

        $total = array('beginning' => 0, 'sales' => 0.0, 'ending' => 0.0);

        $fetch_data = $this->user_model->make_inventory_monitoring_rad_group_datatables($s_date, $groupname);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['beginning'] += $row->beginningcost;
            $total['sales'] += $row->salescost;
            $total['ending'] += $row->endingcost;
//               $order_column = array("groupname",null, "beginningbalance","beginningcost", "purchaseqty",
//            "purchasescost","adjustqty","adjustcost","salesqty","salescost","endingbalance","endingcost");
            $sub_array = array();
            $sub_array[] = $row->dscr;
            $sub_array[] = $row->unitprice;
            $sub_array[] = $row->beginningbalance;
            $sub_array[] = $this->format_money($row->beginningcost);
            $sub_array[] = $row->purchaseqty;
            $sub_array[] = $this->format_money($row->purchasescost);
            $sub_array[] = $row->adjustqty;
            $sub_array[] = $this->format_money($row->adjustcost);
            $sub_array[] = $row->salesqty;
            $sub_array[] = $this->format_money($row->salescost);
            $sub_array[] = $row->endingbalance;
            $sub_array[] = $this->format_money($row->endingcost);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_inventory_monitoring_rad_group_data($s_date, $groupname),
            "recordsFiltered" => $this->user_model->get_inventory_monitoring_rad_group_filtered_data($s_date, $groupname),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function csrinventorymonitor() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "CSR and Office Supplies: Inventory Monitoring";

            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/csrinventorymonitor.js',
                'assets/js/lock.js');



            $this->user_page('csrinventorymonitor', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_csr_inventory_monitoring() {
        $s_date = $this->input->post('start_date');
        $total = array('beginning' => 0, 'sales' => 0.0, 'ending' => 0.0);

        $fetch_data = $this->user_model->make_csr_inventory_monitoring_datatables($s_date);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['beginning'] += $row->beginningcost;
            $total['sales'] += $row->salescost;
            $total['ending'] += $row->endingcost;
            $sub_array = array();
            $sub_array[] = $row->groupname;
            $sub_array[] = '0';
            $sub_array[] = $row->beginningbalance;
            $sub_array[] = $this->format_money($row->beginningcost);
            $sub_array[] = $row->purchaseqty;
            $sub_array[] = $this->format_money($row->purchasescost);
            $sub_array[] = $row->adjustqty;
            $sub_array[] = $this->format_money($row->adjustcost);
            $sub_array[] = $row->salesqty;
            $sub_array[] = $this->format_money($row->salescost);
            $sub_array[] = $row->endingbalance;
            $sub_array[] = $this->format_money($row->endingcost);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_csr_inventory_monitoring_data($s_date),
            "recordsFiltered" => $this->user_model->get_csr_inventory_monitoring_filtered_data($s_date),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function fetch_groupname_info_csr() {
        $s_date = $this->input->post('s_date');
        $groupname = $this->input->post('groupname');

        $total = array('beginning' => 0, 'sales' => 0.0, 'ending' => 0.0);

        $fetch_data = $this->user_model->make_inventory_monitoring_csr_group_datatables($s_date, $groupname);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['beginning'] += $row->beginningcost;
            $total['sales'] += $row->salescost;
            $total['ending'] += $row->endingcost;
//               $order_column = array("groupname",null, "beginningbalance","beginningcost", "purchaseqty",
//            "purchasescost","adjustqty","adjustcost","salesqty","salescost","endingbalance","endingcost");
            $sub_array = array();
            $sub_array[] = $row->dscr;
            $sub_array[] = $row->unitprice;
            $sub_array[] = $row->beginningbalance;
            $sub_array[] = $this->format_money($row->beginningcost);
            $sub_array[] = $row->purchaseqty;
            $sub_array[] = $this->format_money($row->purchasescost);
            $sub_array[] = $row->adjustqty;
            $sub_array[] = $this->format_money($row->adjustcost);
            $sub_array[] = $row->salesqty;
            $sub_array[] = $this->format_money($row->salescost);
            $sub_array[] = $row->endingbalance;
            $sub_array[] = $this->format_money($row->endingcost);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_inventory_monitoring_csr_group_data($s_date, $groupname),
            "recordsFiltered" => $this->user_model->get_inventory_monitoring_csr_group_filtered_data($s_date, $groupname),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    /* HMO: AR Payment Recording with patients 
     * @author Alingling
     */

    public function hmopayment() {
        if ($this->has_log_in()) {
            $data["page_title"] = "AR Payment Recording";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/hmopayment.js');



            $this->user_page('hmopayment', $data);
        } else {
            $this->index();
        }
    }

    public function get_hmopatient() {

        $total = array('beginning' => 0, 'sales' => 0.0, 'ending' => 0.0);

        $fetch_data = $this->user_model->make_inventory_monitoring_group_datatables($s_date, $groupname);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['beginning'] += $row->beginningcost;
            $total['sales'] += $row->salescost;
            $total['ending'] += $row->endingcost;
//               $order_column = array("groupname",null, "beginningbalance","beginningcost", "purchaseqty",
//            "purchasescost","adjustqty","adjustcost","salesqty","salescost","endingbalance","endingcost");
            $sub_array = array();
            $sub_array[] = $row->dscr;
            $sub_array[] = $row->unitprice;
            $sub_array[] = $row->beginningbalance;
            $sub_array[] = $this->format_money($row->beginningcost);
            $sub_array[] = $row->purchaseqty;
            $sub_array[] = $this->format_money($row->purchasescost);
            $sub_array[] = $row->adjustqty;
            $sub_array[] = $this->format_money($row->adjustcost);
            $sub_array[] = $row->salesqty;
            $sub_array[] = $this->format_money($row->salescost);
            $sub_array[] = $row->endingbalance;
            $sub_array[] = $this->format_money($row->endingcost);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_inventory_monitoring_group_data($s_date, $groupname),
            "recordsFiltered" => $this->user_model->get_inventory_monitoring_group_filtered_data($s_date, $groupname),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    //fetch_transmitted_info: alingling
    public function fetch_transmitted_patients_day() {
        $s_date = new DateTime($this->input->post('start_datexxx'));
        $e_date = new DateTime($this->input->post('end_datexxx'));
        $sdate = $s_date->format('Y-m-d');
        $edate = $e_date->format('Y-m-d');
        $total = array('px' => 0, 'amount' => 0.0, 'hosp' => 0, 'prof' => 0);
        $amountx = $this->user_model->get_phic_transmittal_daily_rate($sdate, $edate);
        $total["amount"] = $amountx['totalamt'];
        $total["hosp"] = $amountx['hosp'];
        $total["prof"] = $amountx['prof'];
        $fetch_data = $this->user_model->make_monthly_transmittal_day_datatables($sdate, $edate);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->patpin;
            $sub_array[] = $row->PatientName;
            $sub_array[] = $this->format_datexx($row->dischargedate);
            $sub_array[] = $this->format_datexx($row->processdate);
            $sub_array[] = $this->format_money($row->hcifee);
            $sub_array[] = $this->format_money($row->profee);
            $sub_array[] = $this->format_money($row->grandtotal);
            $sub_array[] = $row->claimedby;
            $sub_array[] = $row->aging;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_monthly_transmittal_day_data($sdate, $edate),
            "recordsFiltered" => $this->user_model->get_monthly_transmittal_day_filtered_data($sdate, $edate),
            "data" => $data,
            "total" => $total,
        );
        echo json_encode($output);
    }

    public function fetch_proofsheet_chart($type) {
        $result = array('status' => FALSE);
//        $s_date = new DateTime($this->input->post("start_date"));
        $e_date = new DateTime($this->input->post("end_date"));

        $result["proofx"] = $this->user_model->get_all_proofs_chart(intval($type), $e_date->format('Y-m-d'));
        $result['status'] = TRUE;

        echo json_encode($result);
    }

    public function labsalesmonitor() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Laboratory: Sales Monitoring";

            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/labsalesmonitor.js',
                'assets/js/lock.js');



            $this->user_page('labsalesmonitor', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_lab_sales_monitoring() {
        $fetch_data = $this->user_model->make_lab_sales_monitoring_datatables();

        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->batchcode;
            $sub_array[] = $this->get_YDMdate($row->indate);
            $sub_array[] = $this->get_YDMdate($row->outdate);
            $sub_array[] = $row->monthyear;
            $sub_array[] = $row->createdby;
            if ($row->actv == '1') {
                $sub_array[] = 'YES';
            } else {
                $sub_array[] = 'NO';
            }
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_lab_sales_monitoring_data(),
            "recordsFiltered" => $this->user_model->get_lab_sales_monitoring_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetch_lab_sales_summarized() {
        $batch = $this->input->post('batch');
        $indate = $this->input->post('indate');
        $outdate = $this->input->post('outdate');
        $total = array('qty' => 0, 'totalamount' => 0.0, 'opdqty' => 0, 'ipdqty' => 0, 'addonprice' => 0.0,
            'unitprice' => 0.0,);

        $fetch_data = $this->user_model->make_sales_summarized_lab_datatables($batch, $indate, $outdate);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['qty'] += intval($row->qty);
            $total['totalamount'] += $row->totalamount;
            $total['opdqty'] += intval($row->opdqty);
            $total['ipdqty'] += intval($row->ipdqty);
            $total['addonprice'] += $row->addonprice;
            $total['unitprice'] += $row->unitprice;


            $sub_array = array();
            $sub_array[] = '<p style="text-align:left">' . $row->dscr . '</p>';
            $sub_array[] = intval($row->qty);
            $sub_array[] = $this->format_money($row->totalamount);
            $sub_array[] = intval($row->opdqty);
            $sub_array[] = intval($row->ipdqty);
            $sub_array[] = $this->format_money($row->addonprice);
            $sub_array[] = $this->format_money($row->unitprice);
            $sub_array[] = $row->hospcode;
            $sub_array[] = $row->formname;
            $sub_array[] = $row->prodid;
            $sub_array[] = $row->startdate;
            $sub_array[] = $row->enddate;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_sales_summarized_lab_data($batch, $indate, $outdate),
            "recordsFiltered" => $this->user_model->get_sales_summarized_lab_filtered_data($batch, $indate, $outdate),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function fetch_lab_sales_detailed() {
        $prodid = $this->input->post('prodid');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');

        $total = array('addonrate' => 0, 'totalamt' => 0.0);

        $fetch_data = $this->user_model->make_sales_detailed_lab_datatables($prodid, $startdate, $enddate);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['addonrate'] += $row->addonrate;
            $total['totalamt'] += $row->totalamt;



            $sub_array = array();
            $sub_array[] = $row->patientname;
            $sub_array[] = $row->transactiontype;
            $sub_array[] = '<p style="text-align:right;">' . $this->format_money($row->addonrate) . "</p>";
            $sub_array[] = '<p style="text-align:right;">' . $this->format_money($row->totalamt) . "</p>";
            $sub_array[] = $row->deptcateg;
            $sub_array[] = $this->format_date($row->tdate);
            $sub_array[] = $row->reqcode;
            $sub_array[] = $row->reportcode;
            $sub_array[] = $row->transcode;
            $sub_array[] = $row->status;
            $sub_array[] = $row->medtech;
            $sub_array[] = $row->reqby;
            $sub_array[] = $row->recby;
            $sub_array[] = $row->prodid;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_sales_detailed_lab_data($prodid, $startdate, $enddate),
            "recordsFiltered" => $this->user_model->get_sales_detailed_lab_filtered_data($prodid, $startdate, $enddate),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function generate_sales_monitoring_report($dept) {
        $this->load->library('pdf');

        if ($dept == "pharmacy") {
            $data['title'] = "Pharmacy: Inventory Monitoring";
            $data["inventory"] = $this->user_model->generate_inventory_monitoring_report($s_date);
        } else if ($dept == "laboratory") {
            $data['title'] = "LABORATORY: Sales Monitoring";
            $data["inventory"] = $this->user_model->generate_lab_sales_monitoring_report();
        } else if ($dept == "radiology") {
            $data['title'] = "RADIOLOGY: Inventory Monitoring";
            $data["inventory"] = $this->user_model->generate_rad_sales_monitoring_report();
        } else {
            $data['title'] = "CSR and Office Supplies: Inventory Monitoring";
            $data["inventory"] = $this->user_model->generate_csr_inventory_monitoring_report($s_date);
        }

        $data['totalsales'] = 0;
        $data['totalipd'] = 0;
        $data['totalopd'] = 0;

        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $da = new DateTime($data['datenow']);
        $data['date'] = date_format($da, 'F j, Y');
        $data['time'] = date_format($da, 'H:i:s A');
//        
        $this->pdf->load_view('reports/salesmonitoring', $data);
        $this->pdf->set_paper('Legal', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(525, 20, "Page {PAGE_NUM} ", $font, 8, array(0, 0, 0));
        if ($dept == "pharmacy") {
            $this->pdf->stream("pharmacy_inventory_monitoring.pdf", array('Attachment' => 0));
        } else if ($dept == "laboratory") {
            $this->pdf->stream("laboratory_sales_monitoring.pdf", array('Attachment' => 0));
        } else if ($dept == "radiology") {
            $this->pdf->stream("radiology_inventory_monitoring.pdf", array('Attachment' => 0));
        } else {
            $this->pdf->stream("csr_and_officesupplies_inventory_monitoring.pdf", array('Attachment' => 0));
        }
    }

    public function generate_sales_summarized_report() {
        $batch = $this->input->post("batch");
        $indate = $this->input->post('indate');
        $outdate = $this->input->post('outdate');

        $this->load->library('pdf');
        $start_date = new DateTime($indate);

        $data['title'] = "Inventory Count for " . date_format($start_date, 'F Y');
        $data["inventory"] = $this->user_model->generate_lab_sales_summarized_group_report($batch, $indate, $outdate);

        $data['qty'] = 0;
        $data['totalamount'] = 0;
        $data['opdqty'] = 0;
        $data['ipdqty'] = 0;
        $data['addonprice'] = 0;
        $data['unitprice'] = 0;

        for ($i = 0; $i < count($data["inventory"]); $i++) {
            $data['qty'] += $data['inventory'][$i]['qty'];
            $data['totalamount'] += $data['inventory'][$i]['totalamount'];
            $data['opdqty'] += $data['inventory'][$i]['opdqty'];
            $data['ipdqty'] += $data['inventory'][$i]['ipdqty'];
            $data['addonprice'] += $data['inventory'][$i]['addonprice'];
            $data['unitprice'] += $data['inventory'][$i]['unitprice'];
        }

//            
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $da = new DateTime($data['datenow']);
        $data['date'] = date_format($da, 'F j, Y');
        $data['time'] = date_format($da, 'H:i:s A');
//        
        $this->pdf->load_view('reports/salessummarized', $data);
        $this->pdf->set_paper('Legal', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(525, 20, "Page {PAGE_NUM} ", $font, 8, array(0, 0, 0));

        $this->pdf->stream('"' . $data['title'] . ").pdf", array('Attachment' => 0));
    }

    public function generate_lab_sales_detailed_group_report() {
        $prodid = $this->input->post("prodid");
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $groupnamex = $this->input->post('groupnamex');

        $this->load->library('pdf');
        $start_date = new DateTime($startdate);
        $data['datex'] = date_format($start_date, 'F Y');
        $groupname = strip_tags($groupnamex);
        $data['title'] = $groupname;
        $data["inventory"] = $this->user_model->generate_lab_sales_detailed_group_report($prodid, $startdate, $enddate);
        $data['dept'] = 'lab';
        $data['addonrate'] = 0;
        $data['totalamt'] = 0;

        for ($i = 0; $i < count($data["inventory"]); $i++) {
            $data['addonrate'] += $data['inventory'][$i]['addonrate'];
            $data['totalamt'] += $data['inventory'][$i]['totalamt'];
        }

//            
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $da = new DateTime($data['datenow']);
        $data['date'] = date_format($da, 'F j, Y');
        $data['time'] = date_format($da, 'H:i:s A');
//        
        $this->pdf->load_view('reports/salesdetailed', $data);
        $this->pdf->set_paper('Legal', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(525, 20, "Page {PAGE_NUM} ", $font, 8, array(0, 0, 0));

        $this->pdf->stream('"' . $data['title'] . ").pdf", array('Attachment' => 0));
    }

    //RADIOLOGY

    public function radsalesmonitor() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "RADIOLOGY: Sales Monitoring";

            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/dataTables.checkboxes.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/checkbox.js',
                'assets/js/myJs.js',
                'assets/js/deffer.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/dataTables.checkboxes.min.js',
                'assets/js/radsalesmonitor.js',
                'assets/js/lock.js');



            $this->user_page('radsalesmonitor', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_rad_sales_monitoring() {
        $fetch_data = $this->user_model->make_rad_sales_monitoring_datatables();

        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->batchcode;
            $sub_array[] = $this->get_YDMdate($row->indate);
            $sub_array[] = $this->get_YDMdate($row->outdate);
            $sub_array[] = $row->monthyear;
            $sub_array[] = $row->createdby;
            if ($row->actv == '1') {
                $sub_array[] = 'YES';
            } else {
                $sub_array[] = 'NO';
            }
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_rad_sales_monitoring_data(),
            "recordsFiltered" => $this->user_model->get_rad_sales_monitoring_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetch_rad_sales_summarized() {
        $batch = $this->input->post('batch');
        $indate = $this->input->post('indate');
        $outdate = $this->input->post('outdate');
        $total = array('qty' => 0, 'totalamount' => 0.0, 'opdqty' => 0, 'ipdqty' => 0, 'addonprice' => 0.0,
            'unitprice' => 0.0,);

        $fetch_data = $this->user_model->make_sales_summarized_rad_datatables($batch, $indate, $outdate);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['qty'] += $row->qty;
            $total['totalamount'] += $row->totalamount;
            $total['opdqty'] += $row->opdqty;
            $total['ipdqty'] += $row->ipdqty;
            $total['addonprice'] += $row->addonprice;
            $total['unitprice'] += $row->unitprice;


            $sub_array = array();
            $sub_array[] = '<p style="text-align:left">' . $row->dscr . '</p>';
            $sub_array[] = intval($row->qty);
            $sub_array[] = $this->format_money($row->totalamount);
            $sub_array[] = $row->opdqty;
            $sub_array[] = $row->ipdqty;
            $sub_array[] = $this->format_money($row->addonprice);
            $sub_array[] = $this->format_money($row->unitprice);
            $sub_array[] = $row->hospcode;
            $sub_array[] = $row->formname;
            $sub_array[] = $row->prodid;
            $sub_array[] = $row->startdate;
            $sub_array[] = $row->enddate;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_sales_summarized_rad_data($batch, $indate, $outdate),
            "recordsFiltered" => $this->user_model->get_sales_summarized_rad_filtered_data($batch, $indate, $outdate),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function fetch_rad_sales_detailed() {

        $prodid = $this->input->post('prodid');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');

        $total = array('addonrate' => 0, 'totalamt' => 0.0);

        $fetch_data = $this->user_model->make_sales_detailed_rad_datatables($prodid, $startdate, $enddate);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['addonrate'] += $row->addonrate;
            $total['totalamt'] += $row->totalamt;



            $sub_array = array();
            $sub_array[] = $row->patientname;
            $sub_array[] = $row->transactiontype;
            $sub_array[] = $this->format_money($row->addonrate);
            $sub_array[] = $this->format_money($row->totalamt);
            $sub_array[] = $row->deptcateg;
            $sub_array[] = $this->format_date($row->tdate);
            $sub_array[] = $row->reqcode;
            $sub_array[] = $row->reportcode;
            $sub_array[] = $row->transcode;
            $sub_array[] = $row->status;
            $sub_array[] = $row->docreader;
            $sub_array[] = $row->reqby;
            $sub_array[] = $row->recby;
            $sub_array[] = $row->prodid;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_sales_detailed_rad_data($prodid, $startdate, $enddate),
            "recordsFiltered" => $this->user_model->get_sales_detailed_rad_filtered_data($prodid, $startdate, $enddate),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function generate_sales_rad_summarized_report() {
        $batch = $this->input->post("batch");
        $indate = $this->input->post('indate');
        $outdate = $this->input->post('outdate');

        $this->load->library('pdf');
        $start_date = new DateTime($indate);

        $data['title'] = "Inventory Count for " . date_format($start_date, 'F Y');
        $data["inventory"] = $this->user_model->generate_rad_sales_summarized_group_report($batch, $indate, $outdate);
        $data['dept'] = 'lab';
        $data['qty'] = 0;
        $data['totalamount'] = 0;
        $data['opdqty'] = 0;
        $data['ipdqty'] = 0;
        $data['addonprice'] = 0;
        $data['unitprice'] = 0;

        for ($i = 0; $i < count($data["inventory"]); $i++) {
            $data['qty'] += $data['inventory'][$i]['qty'];
            $data['totalamount'] += $data['inventory'][$i]['totalamount'];
            $data['opdqty'] += $data['inventory'][$i]['opdqty'];
            $data['ipdqty'] += $data['inventory'][$i]['ipdqty'];
            $data['addonprice'] += $data['inventory'][$i]['addonprice'];
            $data['unitprice'] += $data['inventory'][$i]['unitprice'];
        }

//            
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $da = new DateTime($data['datenow']);
        $data['date'] = date_format($da, 'F j, Y');
        $data['time'] = date_format($da, 'H:i:s A');
//        
        $this->pdf->load_view('reports/salessummarized', $data);
        $this->pdf->set_paper('Legal', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(525, 20, "Page {PAGE_NUM} ", $font, 8, array(0, 0, 0));

        $this->pdf->stream('"' . $data['title'] . ").pdf", array('Attachment' => 0));
    }

    public function generate_rad_sales_detailed_group_report() {
        $prodid = $this->input->post("prodid");
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $groupnamex = $this->input->post('groupnamex');

        $this->load->library('pdf');
        $start_date = new DateTime($startdate);
        $data['datex'] = date_format($start_date, 'F Y');
        $groupname = strip_tags($groupnamex);
        $data['title'] = $groupname;
        $data["inventory"] = $this->user_model->generate_rad_sales_detailed_group_report($prodid, $startdate, $enddate);
        $data['dept'] = 'rad';
        $data['addonrate'] = 0;
        $data['totalamt'] = 0;

        for ($i = 0; $i < count($data["inventory"]); $i++) {
            $data['addonrate'] += $data['inventory'][$i]['addonrate'];
            $data['totalamt'] += $data['inventory'][$i]['totalamt'];
        }

//            
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $da = new DateTime($data['datenow']);
        $data['date'] = date_format($da, 'F j, Y');
        $data['time'] = date_format($da, 'H:i:s A');
//        
        $this->pdf->load_view('reports/salesdetailed', $data);
        $this->pdf->set_paper('Legal', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(525, 20, "Page {PAGE_NUM} ", $font, 8, array(0, 0, 0));

        $this->pdf->stream('"' . $data['title'] . ").pdf", array('Attachment' => 0));
    }

    public function get_dis_ad_summary() {

        $result = array('status' => false);

        if ($this->user_model->get_ad_dis_census_monthly()) {
            $result["disad_summary"] = $this->user_model->get_ad_dis_census_monthly();
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function payrollsummary() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Payroll Summary";

            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/js/myJs.js',
                'assets/js/census.js',
                'assets/js/lock.js',
                'assets/js/payrollsum.js',
                'assets/vendors/js/accounting.js');

            $this->user_page('payrollsummary', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_payroll_summary() {
//        $s_date =  $this->input->post('start_date');
//        $e_date =  $this->input->post('end_date');
//
//         $total = array('paysched' => 0,'workdays' => 0,'totalincentives' => 0,'GRS' => 0.0,'SSSded' => 0,'PHICded' => 0,
//             'HDMFded' => 0.0,'TAXded' => 0.0,'ABSENTded' => 0.0,'Net' => 0.0);
//    
//
//        $fetch_data = $this->user_model->make_payroll_summary_datatables($s_date,$e_date);  
//        $data = array();  
//        foreach($fetch_data as $row)  
//        {  
//            $total['paysched'] =  $row->paysched;
//            $total['workdays'] =  $row->workingdays;
//
//            $total['totalincentives']   +=  intval($row->totalincentives);
//            $total['GRS']               +=  $row->GRS;
//            $total['SSSded']            +=  intval($row->SSSded);
//            $total['PHICded']           +=  intval($row->PHICded);
//            $total['HDMFded']           +=  $row->HDMFded;
//            $total['TAXded']            +=  $row->TAXded;
//            $total['ABSENTded']         +=  $row->ABSENTded;
//            $total['Net']               +=  $row->Net;
//
//            $sub_array   = array();
//            $sub_array[] = $row->dept; 
//            $sub_array[] = $row->profileno;   
//            $sub_array[] = $row->Empname;   
//            $sub_array[] = $row->salarygrade;   
//            $sub_array[] = $this->format_moneyx($row->basic);
//            $sub_array[] = $this->format_moneyx($row->totalincentives);
//            $sub_array[] = $this->format_moneyx($row->GRS);
//            $sub_array[] = $this->format_moneyx($row->SSSded);
//            $sub_array[] = $this->format_moneyx($row->PHICded);
//            $sub_array[] = $this->format_moneyx($row->HDMFded);
//            $sub_array[] = $this->format_moneyx($row->TAXded);
//            $sub_array[] = $this->format_moneyx($row->ABSENTded);
//            $sub_array[] = $this->format_moneyx($row->Net);
//            $data[]      = $sub_array;  
//
//        }  
//        $output = array(  
//            "draw"                =>     intval($this->input->post("draw")),  
//            "recordsTotal"        =>     $this->user_model->get_payroll_summary_data($s_date,$e_date),  
//            "recordsFiltered"     =>     $this->user_model->get_payroll_summary_filtered_data($s_date,$e_date),  
//            "data"                =>     $data,
//            "total"               =>     $total
//            
//        );  
//        echo json_encode($output); 

        $fetch_data = $this->user_model->make_payroll_summary_datatables();
        $data = array();
        $batch;

        foreach ($fetch_data as $row) {
            $batch = $row->batchno;
            $sub_array = array();
            $sub_array[] = $row->batchno;
            $sub_array[] = $row->batchdate;
            $sub_array[] = $this->format_money($row->gross);
            $sub_array[] = $this->format_money($row->deductions);
            $sub_array[] = $this->format_money($row->net);
            $sub_array[] = $row->status;
            $sub_array[] = '<button type="button" id="shadow-effect" class="btn btn-success btn-sm" onclick="payroll.view_payroll_details(\'' . $batch . "," . $row->status . '\')" data-toggle="tooltip" data-placement="top" title="Show Details">Show Details</button>';
            $data[] = $sub_array;
        }

        $output = array
            (
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_payroll_summary_data(),
            "recordsFiltered" => $this->user_model->get_payroll_summary_filtered_data(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function fetch_payroll_details() {
        $batchno = $this->input->post('batchno');

        $total = array
            (
            'paysched' => 0, 'workdays' => 0, 'totalincentives' => 0,
            'GRS' => 0.0, 'SSSded' => 0, 'PHICded' => 0, 'HDMFded' => 0.0,
            'TAXded' => 0.0, 'ABSENTded' => 0.0, 'Net' => 0.0
        );

        $fetch_data = $this->user_model->make_payroll_details_datatables($batchno);

        $data = array();

        foreach ($fetch_data as $row) {
            $total['paysched'] = $row->paysched;
            $total['workdays'] = $row->workingdays;

            $total['totalincentives'] += intval($row->totalincentives);
            $total['GRS'] += $row->GRS;
            $total['SSSded'] += intval($row->SSSded);
            $total['PHICded'] += intval($row->PHICded);
            $total['HDMFded'] += $row->HDMFded;
            $total['TAXded'] += $row->TAXded;
            $total['ABSENTded'] += $row->ABSENTded;
            $total['Net'] += $row->Net;

            $sub_array = array();
            $sub_array[] = $row->dept;
            $sub_array[] = $row->profileno;
            $sub_array[] = $row->Empname;
            $sub_array[] = $row->salarygrade;
            $sub_array[] = $this->format_moneyx($row->basic);
            $sub_array[] = $this->format_moneyx($row->totalincentives);
            $sub_array[] = $this->format_moneyx($row->GRS);
            $sub_array[] = $this->format_moneyx($row->SSSded);
            $sub_array[] = $this->format_moneyx($row->PHICded);
            $sub_array[] = $this->format_moneyx($row->HDMFded);
            $sub_array[] = $this->format_moneyx($row->TAXded);
            $sub_array[] = $this->format_moneyx($row->ABSENTded);
            $sub_array[] = $this->format_moneyx($row->Net);
            $data[] = $sub_array;
        }

        $output = array
            (
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_payroll_details_data($batchno),
            "recordsFiltered" => $this->user_model->get_payroll_details_filtered_data($batchno),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function generate_payroll_summary_report() {
        $data['batchno'] = $this->input->post('batchno');

        $fetch_paysched = $this->user_model->fetch_paysched_from_employeepayslipvw($data['batchno']);

        $data['s_date'] = $fetch_paysched[0]['payschedfrom'];
        $data['e_date'] = $fetch_paysched[0]['payschedto'];

        $this->load->library('pdf');

        $data['title'] = "PAYROLL SUMMARY";

        $data["paysum"] = $this->user_model->generate_payroll_summary_report($data['batchno']);
        $data["paydept"] = $this->user_model->generate_payroll_dept_report($data['batchno']);
        $data["paynet"] = $this->user_model->generate_net_dept_report($data['batchno']);

        $data['totalnet'] = 0;
        $data['totalincentives'] = 0;
        $data['totalgross'] = 0;
        $data['totalsss'] = 0;
        $data['totalphic'] = 0;
        $data['totalhdmf'] = 0;
        $data['totaltax'] = 0;
        $data['totalabsent'] = 0;

        for ($i = 0; $i < count($data["paysum"]); $i++) {
            $data['totalnet'] += $data["paysum"][$i]['Net'];
            $data['totalincentives'] += $data["paysum"][$i]['totalincentives'];
            $data['totalgross'] += $data["paysum"][$i]['GRS'];
            $data['totalsss'] += $data["paysum"][$i]['SSSded'];
            $data['totalphic'] += $data["paysum"][$i]['PHICded'];
            $data['totalhdmf'] += $data["paysum"][$i]['HDMFded'];
            $data['totaltax'] += $data["paysum"][$i]['TAXded'];
            $data['totalabsent'] += $data["paysum"][$i]['ABSENTded'];
        }

        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();
        $da = new DateTime($data['datenow']);
        $data['date'] = date_format($da, 'F j, Y');
        $data['time'] = date_format($da, 'H:i:s A');

        $this->pdf->load_view('reports/payrollsummary', $data);
        $this->pdf->set_paper('Legal', 'Landscape');
        $this->pdf->render();

        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");

        $canvas->page_text(525, 20, "Page {PAGE_NUM} ", $font, 8, array(0, 0, 0));
        $this->pdf->stream('"' . $data['title'] . ").pdf", array('Attachment' => 0));
    }

    public function fetch_purchase_supplier($type) {
        $fetch_data = $this->user_model->make_purchase_supplier_datatables($type);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->pocode;
            $sub_array[] = $row->suppliername;
            $sub_array[] = $this->format_money($row->TotalPOamount);
            $sub_array[] = $this->format_dates($row->podate);
            $sub_array[] = $row->term;
            $sub_array[] = $row->checked;
            $sub_array[] = $row->noted;
            $sub_array[] = $row->recommendedby;
            $sub_array[] = $this->format_date($row->updated);
            $sub_array[] = $row->pono;
            $sub_array[] = $row->dept;
            $sub_array[] = $row->approved;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_purchase_supplier_data($type),
            "recordsFiltered" => $this->user_model->get_purchase_supplier_filtered_data($type),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetch_purchase_stocks() {
        $pocode = $this->input->post('pocode');
        $fetch_data = $this->user_model->make_purchase_stock_datatables($pocode);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = '';
            if ($row->approved == '1') {
                $sub_array[] = '<button type="button" class="btn btn-success btn-circle btn-xs waves-effect" onclick="purchase1.approvee(' . $row->control . ')" data-toggle="tooltip" data-placement="top" title="Approve">
                                    <i class="material-icons">check</i>
                                </button>';
            } else {
                $sub_array[] = '<button type="button" class="btn btn-success btn-circle btn-sm waves-effect" onclick="purchase1.approvee(' . $row->control . ')" data-toggle="tooltip" data-placement="top" title="Approve">
                                    <i class="material-icons"></i>
                                </button>';
            }

            if ($row->disapproved == '1') {
                $sub_array[] = '<button type="button" class="btn btn-danger btn-circle btn-xs waves-effect" onclick="purchase1.get_dis_stocks(' . $row->control . ')" data-toggle="tooltip" data-placement="top" title="Disapprove">
                                    <i class="material-icons" id="disx">check</i>
                                </button>';
            } else {
                $sub_array[] = '<button type="button" class="btn btn-danger btn-circle btn-sm waves-effect" onclick="purchase1.get_dis_stocks(' . $row->control . ')" data-toggle="tooltip" data-placement="top" title="Disapprove">
                                    <i class="material-icons" id="disx"></i>
                                </button>';
            }

            if ($row->deffered == '1') {
                $sub_array[] = '<button type="button" class="btn btn-warning btn-circle waves-effect waves-circle waves-float btn-xs" onclick="purchase1.get_def_stocks(' . $row->control . ')" data-toggle="tooltip" data-placement="top" title="Defer">
                                    <i class="material-icons" id="defx">check</i>
                                </button>';
            } else {
                $sub_array[] = '<button type="button" class="btn btn-warning btn-circle waves-effect waves-circle waves-float btn-xs" onclick="purchase1.get_def_stocks(' . $row->control . ')" data-toggle="tooltip" data-placement="top" title="Defer">
                                    <i class="material-icons" id="defx"></i>
                                </button>';
            }


            $sub_array[] = $row->dscr;
            $sub_array[] = $this->format_moneyx($row->qty);
            $sub_array[] = $row->packing;
            $sub_array[] = $this->format_money($row->cost);
            $sub_array[] = $this->format_money($row->totalcost);
            $sub_array[] = $this->format_moneyx($row->balqty);
            if ($row->approved == '1') {
                $sub_array[] = '';
            } else if ($row->disapproved == '1') {
                $sub_array[] = $row->noteofdisapproval;
            } else {
                $sub_array[] = $row->noteofresubmission;
            }
            $sub_array[] = '<button type="button" id="' . $row->stockbarcode . ':' . $row->dept . '" class="btn btn-success waves-effect ledger-btn">Show</button>';
            $sub_array[] = $row->potranscode;
            $sub_array[] = $row->pocode;
            $sub_array[] = $this->format_date($row->updated);
            $sub_array[] = $row->pono;
            $sub_array[] = $row->deptseries;
            $sub_array[] = $row->potranscode;
            $sub_array[] = $row->control;
            $sub_array[] = $row->approved;
            $sub_array[] = $row->disapproved;
            $sub_array[] = $row->deffered;


            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_purchase_stock_data($pocode),
            "recordsFiltered" => $this->user_model->get_purchase_stock_filtered_data($pocode),
            "data" => $data,
            "count" => count($fetch_data)
        );
        echo json_encode($output);
    }

    public function fetch_purchase_stocks_status($type) {
        $pocode = $this->input->post('pocode');
        $total['amt'] = 0;
        $fetch_data = $this->user_model->make_purchase_stock_onprocess_datatables($pocode, $type);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['amt'] += $row->totalcost;

            $sub_array = array();
            $sub_array[] = $row->dscr;
            $sub_array[] = $this->format_moneyx($row->qty);
            $sub_array[] = $row->packing;
            $sub_array[] = $this->format_money($row->cost);
            $sub_array[] = $this->format_money($row->totalcost);
            $sub_array[] = $this->format_moneyx($row->balqty);
            if ($type === "defer") {
                $sub_array[] = $row->noteofresubmission;
            } else if ($type === "disapproved") {
                $sub_array[] = $row->noteofdisapproval;
            }


            $sub_array[] = $row->potranscode;
            $sub_array[] = $row->pocode;
            $sub_array[] = $this->format_date($row->updated);
            $sub_array[] = $row->pono;
            $sub_array[] = $row->deptseries;
            $sub_array[] = $row->potranscode;
            $sub_array[] = $row->control;

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_purchase_stock_onprocess_data($pocode, $type),
            "recordsFiltered" => $this->user_model->get_purchase_stock_onprocess_filtered_data($pocode, $type),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    //alingling: PHIC Unposted

    public function unpostedpayment() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - Unposted";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/unpostedpayment.js',
                'assets/js/lock.js');

            $this->user_page('unpostedpayment', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_unposted_payment() {
        $datax['s_date'] = $this->input->post('start_date');
        $datax['e_date'] = $this->input->post('end_date');
        $datax['stat'] = $this->input->post('status');
        $total = array('hosp' => 0.0, 'prof' => 0.0, 'grand' => 0.0,
            'whosp' => 0.0, 'wprof' => 0.0, 'wgrand' => 0.0);

        $totalamt = $this->user_model->get_total_payment_unposted_check($datax);
        $wtotalamt = $this->user_model->get_total_payment_unposted_wcheck($datax);
        $fetch_data = $this->user_model->make_payment_unposted_check_datatables($datax);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['hosp'] = $totalamt['hosp'];
            $total['prof'] = $totalamt['prof'];
            $total['grand'] = $totalamt['grand'];

            $total['hosp'] = $wtotalamt['hosp'];
            $total['prof'] = $wtotalamt['prof'];
            $total['grand'] = $wtotalamt['grand'];

            $sub_array = array();
            $sub_array[] = $row->CSNO;
            $sub_array[] = $row->PatientName;
            $sub_array[] = $row->patpin;
            $sub_array[] = $this->format_money($row->hcifee);
            $sub_array[] = $this->format_money($row->profee);
            $sub_array[] = $this->format_money($row->grandtotal);
            $sub_array[] = $this->format_date($row->processdate);
            $sub_array[] = $this->format_date($row->asof);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_payment_unposted_check_data($datax),
            "recordsFiltered" => $this->user_model->get_payment_unposted_check_filtered_data($datax),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function get_unposted_payment_report() {
        $data['stat'] = $this->input->post('stat');

        $this->load->library('pdf');
//         = $this->get_current_dates();
        if ($data['stat'] == "check") {
            $data["s_date"] = $this->input->post('s_date');
            $data['startdate'] = date_format(new DateTime($data["s_date"]), 'F j, Y');
            $data["e_date"] = $this->input->post('e_date');
            $data['enddate'] = date_format(new DateTime($data["e_date"]), 'F j, Y');
            $data["title"] = "UNPOSTED PAYMENT - WITH CHEQUE";
            $data['totalamt'] = $this->user_model->get_total_payment_unposted_check($data);
        } else {
            $data["s_date"] = $this->input->post('ws_date');
            $data['startdate'] = date_format(new DateTime($data["s_date"]), 'F j, Y');
            $data["e_date"] = $this->input->post('we_date');
            $data['enddate'] = date_format(new DateTime($data["e_date"]), 'F j, Y');
            $data['totalamt'] = $this->user_model->get_total_payment_unposted_wcheck($data);
            $data["title"] = "UNPOSTED PAYMENT - WITHOUT CHEQUE";
        }

        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $data["unpostedpayment"] = $this->user_model->get_payment_unposted_report($data);

        $this->pdf->load_view('reports/unpostedpayment', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        if ($data['stat'] == "check") {
            $this->pdf->stream("UNPOSTED PAYMENT-WITH CHEQUE(" . $data["s_date"] . "-" . $data["e_date"] . ").pdf", array('Attachment' => 0));
        } else {
            $this->pdf->stream("UNPOSTED PAYMENT-WITHOUT CHEQUE(" . $data["s_date"] . "-" . $data["e_date"] . ").pdf", array('Attachment' => 0));
        }
//        
    }

    //alingling: PHIC Posted

    public function postedpayment() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - Unposted";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/postedpayment.js',
                'assets/js/lock.js');

            $this->user_page('postedpayment', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_posted_payment() {
        $datax['s_date'] = $this->input->post('start_date');
        $datax['e_date'] = $this->input->post('end_date');
        $total = array('hosppaid' => 0.0, 'profpaid' => 0.0, 'grandpaid' => 0.0,
            'hospunpaid' => 0.0, 'profunpaid' => 0.0, 'grandunpaid' => 0.0);

        $totalamt = $this->user_model->get_total_payment_posted_check($datax);
        $fetch_data = $this->user_model->make_payment_posted_check_datatables($datax);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['hosppaid'] = $totalamt['hosppaidx'];
            $total['profpaid'] = $totalamt['profpaidx'];
            $total['grandpaid'] = $totalamt['granpaidx'];

            $total['hospunpaid'] = $totalamt['hospunpaid'];
            $total['profunpaid'] = $totalamt['profunpaid'];
            $total['grandunpaid'] = $totalamt['grandunpaid'];


//           $order_column = array("CSNO","PatientName","patpin","hosppaid","","","","","","","asof");
            $sub_array = array();
            $sub_array[] = $row->CSNO;
            $sub_array[] = $row->PatientName;
            $sub_array[] = $row->patpin;
            $sub_array[] = $this->format_moneyx($row->hosppaid);
            $sub_array[] = $this->format_moneyx($row->hospvar);
            $sub_array[] = $this->format_moneyx($row->profpaid);
            $sub_array[] = $this->format_moneyx($row->profvar);
            $sub_array[] = $this->format_moneyx($row->granpaid);
            $sub_array[] = $this->format_moneyx($row->granvar);
            $sub_array[] = $row->pvc;
            $sub_array[] = $this->format_date($row->asof);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_payment_posted_check_data($datax),
            "recordsFiltered" => $this->user_model->get_payment_posted_check_filtered_data($datax),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function get_posted_payment_report() {
        $this->load->library('pdf');
        $data["s_date"] = $this->input->post('s_date');
        $data['startdate'] = date_format(new DateTime($data["s_date"]), 'F j, Y');
        $data["e_date"] = $this->input->post('e_date');
        $data['enddate'] = date_format(new DateTime($data["e_date"]), 'F j, Y');
        $data['totalamt'] = $this->user_model->get_total_payment_posted_check($data);
        $data["title"] = "POSTED PAYMENT";


        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $data["postedpayment"] = $this->user_model->get_payment_posted_report($data);

        $this->pdf->load_view('reports/postedpayment', $data);
        $this->pdf->set_paper('A4', 'Landscape');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("POSTED PAYMENT (" . $data["s_date"] . "-" . $data["e_date"] . ").pdf", array('Attachment' => 0));
    }

    //alingling: PHIC Cheque Status

    public function chequestat() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - Unposted";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/chequestat.js',
                'assets/js/lock.js');

            $this->user_page('chequestat', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_cheque_status() {
        $datax['s_date'] = $this->input->post('start_date');
        $datax['e_date'] = $this->input->post('end_date');
        $total = array('posthosppaid' => 0.0, 'postprofpaid' => 0.0, 'postgrandpaid' => 0.0,
            'posthospunpaid' => 0.0, 'postprofunpaid' => 0.0, 'postgrandunpaid' => 0.0,
            'unposthosppaid' => 0.0, 'unpostprofpaid' => 0.0, 'unpostgrandpaid' => 0.0);

        $untotalamt = $this->user_model->get_total_payment_unposted_check($datax);
        $ptotalamt = $this->user_model->get_total_payment_posted_check($datax);
        $fetch_data = $this->user_model->make_check_status_datatables($datax);
        $data = array();
        foreach ($fetch_data as $row) {
            $total['posthosppaid'] = $ptotalamt['hosppaidx'];
            $total['postprofpaid'] = $ptotalamt['profpaidx'];
            $total['postgrandpaid'] = $ptotalamt['granpaidx'];
            $total['posthospunpaid'] = $ptotalamt['hospunpaid'];
            $total['postprofunpaid'] = $ptotalamt['profunpaid'];
            $total['postgrandunpaid'] = $ptotalamt['grandunpaid'];

            $total['unposthosppaid'] = $untotalamt['hosp'];
            $total['unpostprofpaid'] = $untotalamt['prof'];
            $total['unpostgrandpaid'] = $untotalamt['grand'];


            $sub_array = array();
            $sub_array[] = $row->CSNO;
            $sub_array[] = $row->PatientName;
            $sub_array[] = $row->patpin;
            if ($row->tagged == 1) {
                $sub_array[] = $this->format_moneyx($row->hosppaid);
                $sub_array[] = $this->format_moneyx($row->hospvar);
                $sub_array[] = $this->format_moneyx($row->profpaid);
                $sub_array[] = $this->format_moneyx($row->profvar);
                $sub_array[] = $this->format_moneyx($row->granpaid);
                $sub_array[] = $this->format_moneyx($row->granvar);
            } else {
                $sub_array[] = $this->format_moneyx($row->hcifee);
                $sub_array[] = $this->format_moneyx($row->hospvar);
                $sub_array[] = $this->format_moneyx($row->profee);
                $sub_array[] = $this->format_moneyx($row->profvar);
                $sub_array[] = $this->format_moneyx($row->grandtotal);
                $sub_array[] = $this->format_moneyx($row->granvar);
            }

            $sub_array[] = $row->pvc;
            $sub_array[] = $this->format_date($row->asof);
            if ($row->tagged == 1) {
                $sub_array[] = "POSTED";
            } else {
                $sub_array[] = "UNPOSTED";
            }
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_check_status_data($datax),
            "recordsFiltered" => $this->user_model->get_check_status_filtered_data($datax),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function get_cheque_status_report() {
        $this->load->library('pdf');
        $data["s_date"] = $this->input->post('s_date');
        $data['startdate'] = date_format(new DateTime($data["s_date"]), 'F j, Y');
        $data["e_date"] = $this->input->post('e_date');
        $data['enddate'] = date_format(new DateTime($data["e_date"]), 'F j, Y');
        $data['untotalamt'] = $this->user_model->get_total_payment_unposted_check($data);
        $data['ptotalamt'] = $this->user_model->get_total_payment_posted_check($data);
        $data["title"] = "CHEQUE STATUS";


        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $data["checkstat"] = $this->user_model->get_check_status_report($data);

        $this->pdf->load_view('reports/chequestat', $data);
        $this->pdf->set_paper('A4', 'Landscape');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("CHEQUE STATUS (" . $data["s_date"] . "-" . $data["e_date"] . ").pdf", array('Attachment' => 0));
    }

    //alingling: PHIC Pending Claims

    public function pendingclaims() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - Unposted";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/pendingclaims.js',
                'assets/js/lock.js');

            $this->user_page('pendingclaims', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_pending_claims() {
        $fetch_data = $this->user_model->make_pending_claims_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->batchno;
            $sub_array[] = $row->PatientName;
            $sub_array[] = $this->format_datexx($row->processdate);
            $sub_array[] = $row->claimno;
            $sub_array[] = $row->patpin;
            $sub_array[] = $row->aging;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_pending_claims_data(),
            "recordsFiltered" => $this->user_model->get_pending_claims_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function get_pending_claims_report() {
        $this->load->library('pdf');
        $data["title"] = "PENDING CLAIMS";


        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $data["pendingclaim"] = $this->user_model->get_pending_claims_report();

        $this->pdf->load_view('reports/pendingclaims', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("PENDING CLAIMS (" . $data["s_date"] . "-" . $data["e_date"] . ").pdf", array('Attachment' => 0));
    }

    //alingling: PHIC History Logs

    public function historylog() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts - Unposted";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/historylog.js',
                'assets/js/lock.js');

            $this->user_page('historylog', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_history_log() {
        $fetch_data = $this->user_model->make_history_log_datatables();
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->transactno;
            $sub_array[] = $row->csno;
            $sub_array[] = $row->pname;
            $sub_array[] = $row->patpin;
            $sub_array[] = $this->format_moneyx($row->amount);
            if ($row->tagby == "") {
                $sub_array[] = "";
            } else {
                $sub_array[] = $this->format_datexx($row->tagdate);
            }
            $sub_array[] = $row->tagby;
            if ($row->untagby == "") {
                $sub_array[] = "";
            } else {
                $sub_array[] = $this->format_datexx($row->untagdate);
            }
            $sub_array[] = $row->untagby;
            $sub_array[] = $row->aging;
            $sub_array[] = $row->vchr;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_history_log_data(),
            "recordsFiltered" => $this->user_model->get_history_log_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function get_history_log_report() {
        $this->load->library('pdf');
        $data["title"] = "HISTORY LOG";


        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $data["historylog"] = $this->user_model->get_history_log_report();

        $this->pdf->load_view('reports/historylog', $data);
        $this->pdf->set_paper('A4', 'Landscape');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 560, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("HISTORY LOG (" . $data["s_date"] . "-" . $data["e_date"] . ").pdf", array('Attachment' => 0));
    }

    /*
     * DOH ANNUAL STATISTICAL
     * 
     * @auhtor Alingling
     * @param 01-05-2019
     */

    public function general_class() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Classification";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
//                'assets/js/dashboard.js',
                'assets/js/lock.js',
//                'assets/js/DOH/general_class.js'
            );

            $this->user_page('DOH/general_class', $data);
        } else {
            $this->index();
        }
    }

    public function save_general_class() {
        $result = array('status' => FALSE);
        $data['service_general'] = $this->input->post('general_service');
        $data['service_trauma'] = $this->input->post('trauma_service');
        $data['service_specialty1'] = $this->input->post('txt_specialty_service_1');
        $data['service_specialty2'] = $this->input->post('txt_specialty_service_2');
        $data['service_specialty3'] = $this->input->post('txt_specialty_service_3');
        $data['service_specialty4'] = $this->input->post('txt_specialty_service_4');

        if ($this->input->post('txt_nature_gov') !== "") {
            $data['service_nature'] = $this->input->post('txt_nature_gov');
        } else if ($this->input->post('txt_nature_pri') !== "") {
            $data['service_nature'] = $this->input->post('txt_nature_pri');
        } else {
            if ($this->input->post('nature_own') == "Local") {
                $data['service_nature'] = $this->input->post('nature_gov_1');
            } else {
                $data['service_nature'] = $this->input->post('nature_own');
            }
        }

        if ($this->doh_model->insert_general_class($data)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function general_quality() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Quality Management";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
//                'assets/js/dashboard.js',
                'assets/js/lock.js',
                'assets/js/mandadailycensus.js');

            $this->user_page('DOH/general_quality', $data);
        } else {
            $this->index();
        }
    }

    public function general_bed() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Bed Capacity/Occupancy";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
//                'assets/js/myChart.js',
                'assets/js/myJs.js',
//                'assets/js/dashboard.js',
                'assets/js/lock.js',
//                'assets/js/mandadailycensus.js'
            );

            $this->user_page('DOH/general_bed', $data);
        } else {
            $this->index();
        }
    }

    public function operation_sumpahosp() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Summary of Patients in the Hospital";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
                'assets/js/dashboard.js',
                'assets/js/lock.js',
                'assets/js/mandadailycensus.js');

            $this->user_page('DOH/operation_sumpahosp', $data);
        } else {
            $this->index();
        }
    }

    public function operation_discharges($month = NULL) {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "DOH Discharges";

            if ($month == NULL) {
                $monthnow = new DateTime();
                $monthx = $monthnow->format('Y');
            } else {
                $monthx = $month;
            }
            $data['monthx'] = $monthx;
            $totaldaysofstay = $this->doh_model->get_discharges_totaldaysofstay($monthx);
            $data['totallengthofstay'] = $this->doh_model->get_total_lengthofstay($monthx);
            $data['totaldischarges'] = $this->doh_model->get_total_discharges($monthx);

            $data['medicine'] = $this->doh_model->get_discharges_nopatients('Medical', '', $monthx);
            $data['obstetrics'] = $this->doh_model->get_discharges_nopatients('Obstetrics', '', $monthx);
            $data['gynecology'] = $this->doh_model->get_discharges_nopatients('Gynecology', '', $monthx);
            $data['pedia'] = $this->doh_model->get_discharges_nopatients('Pediatrics', '', $monthx);
            $data['surgery_pedia'] = $this->doh_model->get_discharges_nopatients('Surgery', 'Pedia', $monthx);
            $data['surgery_adult'] = $this->doh_model->get_discharges_nopatients('Surgery', 'Adult', $monthx);
            $data['newborn'] = $this->doh_model->get_discharges_nopatients('New Born', '', $monthx);
            $data['all'] = $this->doh_model->get_discharges_nopatients('All', '', $monthx);
            $data['pathologic'] = $this->doh_model->get_discharges_nopatients('Pathologic', 'patho', $monthx);
            $data['nonpatho'] = $this->doh_model->get_discharges_nopatients('Pathologic', 'nonpatho', $monthx);
            $data['wellbaby'] = $this->doh_model->get_discharges_nopatients('Wellbaby', '', $monthx);
            $total = $data['medicine']['nopx'] + $data['obstetrics']['nopx'] + $data['gynecology']['nopx'] +
                    $data['pedia']['nopx'] + $data['surgery_pedia']['nopx'] + $data['surgery_adult']['nopx'];
            //NON-NHIP
            $total_nonnhip = $data['medicine']['non'] + $data['obstetrics']['non'] + $data['gynecology']['non'] +
                    $data['pedia']['non'] + $data['surgery_pedia']['non'] + $data['surgery_adult']['non'];
            $data['total_nonnhip'] = number_format($data['all']['non'] - $total_nonnhip);
            //NHIP
            $total_nhip = $data['medicine']['nhip'] + $data['obstetrics']['nhip'] + $data['gynecology']['nhip'] +
                    $data['pedia']['nhip'] + $data['surgery_pedia']['nhip'] + $data['surgery_adult']['nhip'];
            $data['total_nhip'] = number_format($data['all']['nhip'] - $total_nhip);
            //hmo
            $total_hmo = $data['medicine']['hmo'] + $data['obstetrics']['hmo'] + $data['gynecology']['hmo'] +
                    $data['pedia']['hmo'] + $data['surgery_pedia']['hmo'] + $data['surgery_adult']['hmo'];
            $data['total_hmo'] = number_format($data['all']['hmo'] - $total_hmo);
            //Recovered/Improved
            $total_ri = $data['medicine']['ri'] + $data['obstetrics']['ri'] + $data['gynecology']['ri'] +
                    $data['pedia']['ri'] + $data['surgery_pedia']['ri'] + $data['surgery_adult']['ri'];
            $data['total_ri'] = number_format($data['all']['ri'] - $total_ri);
            //Transferred
            $total_t = $data['medicine']['T'] + $data['obstetrics']['T'] + $data['gynecology']['T'] +
                    $data['pedia']['T'] + $data['surgery_pedia']['T'] + $data['surgery_adult']['T'];
            $data['total_t'] = number_format($data['all']['T'] - $total_t);
            //HAMA/DAMA
            $total_h = $data['medicine']['H'] + $data['obstetrics']['H'] + $data['gynecology']['H'] +
                    $data['pedia']['H'] + $data['surgery_pedia']['H'] + $data['surgery_adult']['H'];
            $data['total_h'] = number_format($data['all']['H'] - $total_h);
            //Absconded
            $total_a = $data['medicine']['A'] + $data['obstetrics']['A'] + $data['gynecology']['A'] +
                    $data['pedia']['A'] + $data['surgery_pedia']['A'] + $data['surgery_adult']['A'];
            $data['total_a'] = number_format($data['all']['A'] - $total_a);
            //less48
            $total_less48 = $data['medicine']['less48'] + $data['obstetrics']['less48'] + $data['gynecology']['less48'] +
                    $data['pedia']['less48'] + $data['surgery_pedia']['less48'] + $data['surgery_adult']['less48'];
            $data['total_less48'] = number_format($data['all']['less48'] - $total_less48);
            //more48
            $total_more48 = $data['medicine']['more48'] + $data['obstetrics']['more48'] + $data['gynecology']['more48'] +
                    $data['pedia']['more48'] + $data['surgery_pedia']['more48'] + $data['surgery_adult']['more48'];
            $data['total_more48'] = number_format($data['all']['more48'] - $total_more48);



            //wellbaby
//            $lengthofstay_total = number_format($data['lengthofstay_medicine'] + $data['lengthofstay_obstetrics'] + $data['lengthofstay_gynecology'] +
//                    $data['lengthofstay_pedia'] + $data['lengthofstay_surgery_pedia'] + $data['lengthofstay_surgery_adult'],2);
//            $data['lengthofstay_total'] =  $lengthofstay_total;
            if ($totaldaysofstay['totaldaysofstay'] <> 0) {
                //pathologic
                $data['lengthofstay_medicine'] = ($data['medicine']['lengthofstay'] == 0 ? '0.00' : number_format($data['medicine']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
                $data['lengthofstay_obstetrics'] = ($data['obstetrics']['lengthofstay'] == 0 ? '0.00' : number_format($data['obstetrics']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
                $data['lengthofstay_gynecology'] = ($data['gynecology']['lengthofstay'] == 0 ? '0.00' : number_format($data['gynecology']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
                $data['lengthofstay_pedia'] = ($data['pedia']['lengthofstay'] == 0 ? '0.00' : number_format($data['pedia']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
                $data['lengthofstay_surgery_pedia'] = ($data['surgery_pedia']['lengthofstay'] == 0 ? '0.00' : number_format($data['surgery_pedia']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
                $data['lengthofstay_surgery_adult'] = ($data['surgery_adult']['lengthofstay'] == 0 ? '0.00' : number_format($data['surgery_adult']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
                $data['lengthofstay_newborn'] = ($data['newborn']['lengthofstay'] == 0 ? '0.00' : number_format($data['newborn']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
                $lengthofstay_total = $data['medicine']['lengthofstay'] + $data['obstetrics']['lengthofstay'] + $data['gynecology']['lengthofstay'] +
                        $data['pedia']['lengthofstay'] + $data['surgery_pedia']['lengthofstay'] + $data['surgery_adult']['lengthofstay'];

                $data['total'] = number_format($data['totaldischarges']['totaldischarges'] - $total);
                $lengthofstay = $data['totallengthofstay']['totallengthofstay'] - $lengthofstay_total;



                $data['lengthofstay_pathologic'] = ($data['pathologic']['lengthofstay'] == 0 ? '0.00' : number_format($data['pathologic']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
                //nonpatho
                $data['lengthofstay_nonpathologic'] = ($data['nonpatho']['lengthofstay'] == 0 ? '0.00' : number_format($data['nonpatho']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
                $data['lengthofstay_total'] = number_format($lengthofstay / $totaldaysofstay['totaldaysofstay'], 2);
                $data['lengthofstay_wellbaby'] = ($data['wellbaby']['lengthofstay'] == 0 ? '0.00' : number_format($data['wellbaby']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
            } else {
                $data['lengthofstay_total'] = 0;
                $data['lengthofstay_medicine'] = 0;
                $data['lengthofstay_obstetrics'] = 0;
                $data['lengthofstay_gynecology'] = 0;
                $data['lengthofstay_pedia'] = 0;
                $data['lengthofstay_surgery_pedia'] = 0;
                $data['lengthofstay_surgery_adult'] = 0;
                $data['lengthofstay_newborn'] = 0;
                $lengthofstay_total = 0;

                $data['total'] = 0;
                $lengthofstay = $data['totallengthofstay']['totallengthofstay'] - $lengthofstay_total;



                $data['lengthofstay_pathologic'] = 0;
                //nonpatho
                $data['lengthofstay_nonpathologic'] = 0;
                $data['lengthofstay_wellbaby'] = 0;
            }

            if ($data['totaldischarges']['totaldischarges'] <> 0) {
                $data['alos'] = number_format(($data['totallengthofstay']['totallengthofstay'] / $data['totaldischarges']['totaldischarges'] * 100), 2);
            } else {
                $data['alos'] = 0;
            }

            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
                'assets/js/dashboard.js',
                'assets/js/lock.js',
                'assets/js/doh/discharges.js');

            $this->user_page('DOH/operation_discharges', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_cause_morbidity_leading() {
        $year = $this->input->post('start_date');
        $fetch_data = $this->doh_model->make_cause_morbidity_leading_datatables($year);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->Diag_discharge;
            $sub_array[] = number_format($row->totalcsno);
            $sub_array[] = $row->ICD10;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->doh_model->fetch_cause_morbidity_leading_data($year),
            "recordsFiltered" => $this->doh_model->fetch_cause_morbidity_leading_filtered_data($year),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetch_cause_morbidity() {
        $year = $this->input->post('start_date');
        $fetch_data = $this->doh_model->make_cause_morbidity_datatables($year);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->Diag_discharge;
            $sub_array[] = number_format($row->under1M);
            $sub_array[] = number_format($row->under1F);
            $sub_array[] = number_format($row->age1_4M);
            $sub_array[] = number_format($row->age1_4F);
            $sub_array[] = number_format($row->age5_9M);
            $sub_array[] = number_format($row->age5_9F);
            $sub_array[] = number_format($row->age10_14M);
            $sub_array[] = number_format($row->age10_14F);
            $sub_array[] = number_format($row->age15_19M);
            $sub_array[] = number_format($row->age15_19F);
            $sub_array[] = number_format($row->age20_24M);
            $sub_array[] = number_format($row->age20_24F);
            $sub_array[] = number_format($row->age25_29M);
            $sub_array[] = number_format($row->age25_29F);
            $sub_array[] = number_format($row->age30_34M);
            $sub_array[] = number_format($row->age30_34F);
            $sub_array[] = number_format($row->age35_39M);
            $sub_array[] = number_format($row->age35_39F);
            $sub_array[] = number_format($row->age40_44M);
            $sub_array[] = number_format($row->age40_44F);
            $sub_array[] = number_format($row->age45_49M);
            $sub_array[] = number_format($row->age45_49F);
            $sub_array[] = number_format($row->age50_54M);
            $sub_array[] = number_format($row->age50_54F);
            $sub_array[] = number_format($row->age55_59M);
            $sub_array[] = number_format($row->age55_59F);
            $sub_array[] = number_format($row->age60_64M);
            $sub_array[] = number_format($row->age60_64F);
            $sub_array[] = number_format($row->age65_69M);
            $sub_array[] = number_format($row->age65_69F);
            $sub_array[] = number_format($row->age70M);
            $sub_array[] = number_format($row->age70F);
            $sub_array[] = number_format($row->subtotalM);
            $sub_array[] = number_format($row->subtotalF);
            $sub_array[] = number_format($row->totalcsno);
            $sub_array[] = $row->ICD10;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->doh_model->fetch_cause_morbidity_data($year),
            "recordsFiltered" => $this->doh_model->fetch_cause_morbidity_filtered_data($year),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function edit_finaldiagnosis() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "DOH Discharges";
            $data['datexx'] = $_GET['dx'];
            $data['diagnosis'] = $_GET['fd'];
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
                'assets/js/dashboard.js',
                'assets/js/lock.js',
                'assets/js/doh/discharges.js');

            $this->user_page('DOH/operation_discharges/edit_finaldiagnosis', $data);
        } else {
            $this->index();
        }
    }

    public function fetch_inpatients_finaldiagnosis() {
        $year = $this->input->post('year');
        $finaldiag = $this->input->post('finaldiag');
        $fetch_data = $this->doh_model->make_inpatients_finaldiagnosis_datatables($finaldiag, $year);
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = '<button type="button" class="btn-update-branch btn bg-green btn-xs waves-effect" data-toggle="tooltip" data-placement="right" title="Update Final Diagnosis and ICD10" onclick="doh_discharges.change_finaldiag(' . $row->id . ')">'
                    . '<i class="material-icons">edit</i>'
                    . '</button>';
            $sub_array[] = $row->Diag_discharge;
            $sub_array[] = $row->ICD10;
            $sub_array[] = $row->caseno;
            $sub_array[] = $row->name;
            $sub_array[] = $row->sex;
            $sub_array[] = $row->Age;
            $sub_array[] = $this->format_datexx($row->admitdate);
            $sub_array[] = $this->format_datexx($row->dischadate);
            $sub_array[] = $row->phicmembr;
            $sub_array[] = $row->NRclearedby;
            $sub_array[] = $this->format_datexx($row->NRclearedDT);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->doh_model->fetch_inpatients_finaldiagnosis_data($finaldiag, $year),
            "recordsFiltered" => $this->doh_model->fetch_inpatients_finaldiagnosis_filtered_data($finaldiag, $year),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetch_icdcode() {
        $fetch_data = $this->doh_model->make_icdcode_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->icdcode;
            $sub_array[] = $row->diagnosis;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->doh_model->fetch_icdcode_data(),
            "recordsFiltered" => $this->doh_model->fetch_icdcode_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function update_finaldiagnosis() {
        $result = array('status' => false);
//       data: {id : idx,icd:icdx,diag:diagx},
        $data['id'] = $this->input->post('id');
        $data['icd'] = $this->input->post('icd');
        $data['diag'] = $this->input->post('diag');
        if ($this->doh_model->update_finaldiagnosis($data)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function operation_discharges_report() {

        $monthx = $this->input->post('s_datex');
        $data['year'] = $monthx;
        $totaldaysofstay = $this->doh_model->get_discharges_totaldaysofstay($monthx);
        $data['totallengthofstay'] = $this->doh_model->get_total_lengthofstay($monthx);
        $data['totaldischarges'] = $this->doh_model->get_total_discharges($monthx);

        $data['medicine'] = $this->doh_model->get_discharges_nopatients('Medical', '', $monthx);
        $data['obstetrics'] = $this->doh_model->get_discharges_nopatients('Obstetrics', '', $monthx);
        $data['gynecology'] = $this->doh_model->get_discharges_nopatients('Gynecology', '', $monthx);
        $data['pedia'] = $this->doh_model->get_discharges_nopatients('Pediatrics', '', $monthx);
        $data['surgery_pedia'] = $this->doh_model->get_discharges_nopatients('Surgery', 'Pedia', $monthx);
        $data['surgery_adult'] = $this->doh_model->get_discharges_nopatients('Surgery', 'Adult', $monthx);
        $data['newborn'] = $this->doh_model->get_discharges_nopatients('New Born', '', $monthx);
        $data['all'] = $this->doh_model->get_discharges_nopatients('All', '', $monthx);
        $data['pathologic'] = $this->doh_model->get_discharges_nopatients('Pathologic', 'patho', $monthx);
        $data['nonpatho'] = $this->doh_model->get_discharges_nopatients('Pathologic', 'nonpatho', $monthx);
        $data['wellbaby'] = $this->doh_model->get_discharges_nopatients('Wellbaby', '', $monthx);
        $total = $data['medicine']['nopx'] + $data['obstetrics']['nopx'] + $data['gynecology']['nopx'] +
                $data['pedia']['nopx'] + $data['surgery_pedia']['nopx'] + $data['surgery_adult']['nopx'];
        //NON-NHIP
        $total_nonnhip = $data['medicine']['non'] + $data['obstetrics']['non'] + $data['gynecology']['non'] +
                $data['pedia']['non'] + $data['surgery_pedia']['non'] + $data['surgery_adult']['non'];
        $data['total_nonnhip'] = number_format($data['all']['non'] - $total_nonnhip);
        //NHIP
        $total_nhip = $data['medicine']['nhip'] + $data['obstetrics']['nhip'] + $data['gynecology']['nhip'] +
                $data['pedia']['nhip'] + $data['surgery_pedia']['nhip'] + $data['surgery_adult']['nhip'];
        $data['total_nhip'] = number_format($data['all']['nhip'] - $total_nhip);
        //hmo
        $total_hmo = $data['medicine']['hmo'] + $data['obstetrics']['hmo'] + $data['gynecology']['hmo'] +
                $data['pedia']['hmo'] + $data['surgery_pedia']['hmo'] + $data['surgery_adult']['hmo'];
        $data['total_hmo'] = number_format($data['all']['hmo'] - $total_hmo);
        //Recovered/Improved
        $total_ri = $data['medicine']['ri'] + $data['obstetrics']['ri'] + $data['gynecology']['ri'] +
                $data['pedia']['ri'] + $data['surgery_pedia']['ri'] + $data['surgery_adult']['ri'];
        $data['total_ri'] = number_format($data['all']['ri'] - $total_ri);
        //Transferred
        $total_t = $data['medicine']['T'] + $data['obstetrics']['T'] + $data['gynecology']['T'] +
                $data['pedia']['T'] + $data['surgery_pedia']['T'] + $data['surgery_adult']['T'];
        $data['total_t'] = number_format($data['all']['T'] - $total_t);
        //HAMA/DAMA
        $total_h = $data['medicine']['H'] + $data['obstetrics']['H'] + $data['gynecology']['H'] +
                $data['pedia']['H'] + $data['surgery_pedia']['H'] + $data['surgery_adult']['H'];
        $data['total_h'] = number_format($data['all']['H'] - $total_h);
        //Absconded
        $total_a = $data['medicine']['A'] + $data['obstetrics']['A'] + $data['gynecology']['A'] +
                $data['pedia']['A'] + $data['surgery_pedia']['A'] + $data['surgery_adult']['A'];
        $data['total_a'] = number_format($data['all']['A'] - $total_a);
        //less48
        $total_less48 = $data['medicine']['less48'] + $data['obstetrics']['less48'] + $data['gynecology']['less48'] +
                $data['pedia']['less48'] + $data['surgery_pedia']['less48'] + $data['surgery_adult']['less48'];
        $data['total_less48'] = number_format($data['all']['less48'] - $total_less48);
        //more48
        $total_more48 = $data['medicine']['more48'] + $data['obstetrics']['more48'] + $data['gynecology']['more48'] +
                $data['pedia']['more48'] + $data['surgery_pedia']['more48'] + $data['surgery_adult']['more48'];
        $data['total_more48'] = number_format($data['all']['more48'] - $total_more48);

        if ($totaldaysofstay['totaldaysofstay'] <> 0) {
            //pathologic
            $data['lengthofstay_medicine'] = ($data['medicine']['lengthofstay'] == 0 ? '0.00' : number_format($data['medicine']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
            $data['lengthofstay_obstetrics'] = ($data['obstetrics']['lengthofstay'] == 0 ? '0.00' : number_format($data['obstetrics']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
            $data['lengthofstay_gynecology'] = ($data['gynecology']['lengthofstay'] == 0 ? '0.00' : number_format($data['gynecology']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
            $data['lengthofstay_pedia'] = ($data['pedia']['lengthofstay'] == 0 ? '0.00' : number_format($data['pedia']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
            $data['lengthofstay_surgery_pedia'] = ($data['surgery_pedia']['lengthofstay'] == 0 ? '0.00' : number_format($data['surgery_pedia']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
            $data['lengthofstay_surgery_adult'] = ($data['surgery_adult']['lengthofstay'] == 0 ? '0.00' : number_format($data['surgery_adult']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
            $data['lengthofstay_newborn'] = ($data['newborn']['lengthofstay'] == 0 ? '0.00' : number_format($data['newborn']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
            $lengthofstay_total = $data['medicine']['lengthofstay'] + $data['obstetrics']['lengthofstay'] + $data['gynecology']['lengthofstay'] +
                    $data['pedia']['lengthofstay'] + $data['surgery_pedia']['lengthofstay'] + $data['surgery_adult']['lengthofstay'];

            $data['total'] = number_format($data['totaldischarges']['totaldischarges'] - $total);
            $lengthofstay = $data['totallengthofstay']['totallengthofstay'] - $lengthofstay_total;



            $data['lengthofstay_pathologic'] = ($data['pathologic']['lengthofstay'] == 0 ? '0.00' : number_format($data['pathologic']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
            //nonpatho
            $data['lengthofstay_nonpathologic'] = ($data['nonpatho']['lengthofstay'] == 0 ? '0.00' : number_format($data['nonpatho']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
            $data['lengthofstay_total'] = number_format($lengthofstay / $totaldaysofstay['totaldaysofstay'], 2);
            $data['lengthofstay_wellbaby'] = ($data['wellbaby']['lengthofstay'] == 0 ? '0.00' : number_format($data['wellbaby']['lengthofstay'] / $totaldaysofstay['totaldaysofstay'], 2));
        } else {
            $data['lengthofstay_total'] = 0;
            $data['lengthofstay_medicine'] = 0;
            $data['lengthofstay_obstetrics'] = 0;
            $data['lengthofstay_gynecology'] = 0;
            $data['lengthofstay_pedia'] = 0;
            $data['lengthofstay_surgery_pedia'] = 0;
            $data['lengthofstay_surgery_adult'] = 0;
            $data['lengthofstay_newborn'] = 0;
            $lengthofstay_total = 0;

            $data['total'] = 0;
            $lengthofstay = $data['totallengthofstay']['totallengthofstay'] - $lengthofstay_total;



            $data['lengthofstay_pathologic'] = 0;
            //nonpatho
            $data['lengthofstay_nonpathologic'] = 0;
            $data['lengthofstay_wellbaby'] = 0;
        }

        if ($data['totaldischarges']['totaldischarges'] <> 0) {
            $data['alos'] = number_format($data['totallengthofstay']['totallengthofstay'] / $data['totaldischarges']['totaldischarges'], 2);
        } else {
            $data['alos'] = 0;
        }

        //10 leading morbidity cause
        $data["ten_leading_morbidity_cause"] = $this->doh_model->fetch_cause_morbidity_leading_report($monthx);
        //10 leading morbidity cause - Age Distribution
        $data["morbidity_cause"] = $this->doh_model->fetch_cause_morbidity_report($monthx);

        //profile

        $data["profile"] = $this->user_model->get_mandaprofile();

        $this->load->library('pdf');
        $this->pdf->load_view('reports/DOH/operation_discharges_report', $data);
        $this->pdf->set_paper('Legal', 'landscape');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
//        $canvas->page_text(525, 525, "Page {PAGE_NUM} ", $font, 8, array(0,0,0));
        $this->pdf->stream('PHIC_Mandatory_Report (' . $data["date"] . ').pdf', array('Attachment' => 0));
    }

    public function operation_deaths() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Deaths";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
//                'assets/js/dashboard.js',
                'assets/js/lock.js',
//                'assets/js/mandadailycensus.js'
            );

            $this->user_page('DOH/operation_deaths', $data);
        } else {
            $this->index();
        }
    }

    public function operation_hai() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Healthcare Associated Infections (HAI)";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
//                'assets/js/dashboard.js',
                'assets/js/lock.js',
//                'assets/js/mandadailycensus.js'
            );

            $this->user_page('DOH/operation_hai', $data);
        } else {
            $this->index();
        }
    }

    public function operation_surgical() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Surgical Operations";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
                'assets/js/dashboard.js',
                'assets/js/lock.js',
                'assets/js/mandadailycensus.js');

            $this->user_page('DOH/operation_surgical', $data);
        } else {
            $this->index();
        }
    }

    public function staffing_pattern() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Staffing Pattern";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
                'assets/js/dashboard.js',
                'assets/js/lock.js',
                'assets/js/mandadailycensus.js');

            $this->user_page('DOH/staffing_pattern', $data);
        } else {
            $this->index();
        }
    }

    public function DOH_expenses() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Expenses";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
                'assets/js/dashboard.js',
                'assets/js/lock.js',
                'assets/js/mandadailycensus.js');

            $this->user_page('DOH/expenses', $data);
        } else {
            $this->index();
        }
    }

    public function DOH_revenues() {
        if ($this->has_log_in() && ($this->validate_admin() || $this->validate_medphic())) {
            $data["page_title"] = "Revenues";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/myJs.js',
                'assets/js/dashboard.js',
                'assets/js/lock.js',
                'assets/js/mandadailycensus.js');

            $this->user_page('DOH/DOH_revenues', $data);
        } else {
            $this->index();
        }
    }

    public function profile() {
        if ($this->has_log_in()) {
            $data["page_title"] = "Profile";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
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
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/demo.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/jquery.redirect.js',
                'assets/js/myJs.js',
                'assets/js/profile.js'
            );

            $this->user_page('profile1', $data);
        } else {
            $this->index();
        }
    }

    public function summaryaccountaging() {
        if ($this->has_log_in()) {
            $data["page_title"] = "AR/AP SUMMARY ACCOUNT AGING";
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/checkboxes.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/vendors/plugins/bootstrap-select/css/bootstrap-select.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/jquery-inputmask/jquery.inputmask.bundle.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/js/responsive.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/checkbox.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/forms/advanced-form-elements.js',
                'assets/vendors/js/demo.js',
                'assets/js/myJs.js',
                'assets/js/summaryacctaging.js',
                'assets/vendors/js/pages/widgets/infobox/infobox-4.js',
                'assets/vendors/plugins/jquery-countto/jquery.countTo.js',
                'assets/vendors/plugins/jquery-sparkline/jquery.sparkline.js',
                'assets/vendors/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js');
//             $data['frequency'] = $this->user_model->get_med_frequency();
            $this->user_page('summaryacctaging', $data);
        } else {
            $this->index();
        }
    }

    public function argrouping() {
        $result = array('status' => FALSE);
        $grouping = $this->input->post('grouping');

        $fetchGroup = $this->user_model->argrouping($grouping);
        if ($fetchGroup) {
            $result['fetchGroup'] = $fetchGroup;
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function fetch_acctng_summary_aging() {
        $coacode = $this->input->post('coacode');
        $coveredmonth = $this->input->post('coveredmonth');
        $zero = $this->input->post('zero');
        $fetch_data = $this->user_model->make_acctng_summary_aging_datatables($coacode, $coveredmonth, $zero);
        $totalsummary = $this->user_model->fetch_totalsummaryaging($coacode, $coveredmonth, $zero);
        $data = array();
        $num = 1;
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $num;
            $sub_array[] = "<p style='text-align:left;'>" . $row->coaname . "</p>";
            $sub_array[] = "<p style='text-align:left;'>" . $row->slname . "</p>";
            $sub_array[] = $row->accttype;
            $sub_array[] = $this->format_moneyx($row->balance);
            $sub_array[] = $row->daysnow;
            $sub_array[] = $this->format_moneyx($row->current);
            $sub_array[] = $this->format_moneyx($row->upto30d);
            $sub_array[] = $this->format_moneyx($row->upto45d);
            $sub_array[] = $this->format_moneyx($row->upto60d);
            $sub_array[] = $this->format_moneyx($row->upto90d);
            $sub_array[] = $this->format_moneyx($row->upto120d);
            $sub_array[] = $this->format_moneyx($row->above120d);
            $sub_array[] = $row->updatedby;
            $sub_array[] = $this->format_datea($row->evaluated);
            $data[] = $sub_array;
            $num++;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->user_model->get_acctng_summary_aging_data($coacode, $coveredmonth, $zero),
            "recordsFiltered" => $this->user_model->get_acctng_summary_aging_filtered_data($coacode, $coveredmonth, $zero),
            "data" => $data,
            "totalsumm" => $totalsummary
        );
        echo json_encode($output);
    }

    /*
     * Eclaims Summary Report
     * @author Alynna Pajaron
     * @version 07-09-2019
     * 
     */

    public function phicsummaryreport() {
        if ($this->has_log_in() && $this->validate_admin()) {
            $data["page_title"] = "Philhealth Accounts";
            $data["transmit_month"] = $this->user_model->get_transmit();
            $data["css"] = array(
                'assets/vendors/plugins/bootstrap/css/bootstrap.css',
                'assets/vendors/plugins/node-waves/waves.css',
                'assets/vendors/plugins/animate-css/animate.css',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
                'assets/vendors/plugins/sweetalert/sweetalert.css',
                'assets/vendors/css/style.css',
//                'assets/css/rowreorder.css',
                'assets/vendors/css/responsive.css',
                'assets/vendors/css/themes/all-themes.css',
                'assets/css/myStyle.css');

            $data["js"] = array(
                'assets/vendors/plugins/jquery/jquery.min.js',
                'assets/vendors/plugins/bootstrap/js/bootstrap.js',
                'assets/vendors/plugins/bootstrap-select/js/bootstrap-select.js',
                'assets/vendors/plugins/jquery-slimscroll/jquery.slimscroll.js',
                'assets/vendors/plugins/node-waves/waves.js',
                'assets/vendors/plugins/momentjs/moment.js',
                'assets/vendors/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
                'assets/vendors/plugins/jquery-datatable/jquery.dataTables.js',
                'assets/vendors/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.flash.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/jszip.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/pdfmake.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/vfs_fonts.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.html5.min.js',
                'assets/vendors/plugins/jquery-datatable/extensions/export/buttons.print.min.js',
                'assets/vendors/plugins/sweetalert/sweetalert.min.js',
                'assets/vendors/js/admin.js',
                'assets/vendors/js/accounting.js',
                'assets/vendors/js/pages/ui/tooltips-popovers.js',
//                'assets/vendors/js/demo.js',
                'assets/vendors/js/jquery.redirect.js',
//                'assets/vendors/js/responsive.js',
                'assets/js/myJs.js',
                'assets/js/phicsummaryreport.js',
                'assets/js/lock.js');

            $this->user_page('phicsummaryreport', $data);
        } else {
            $this->index();
        }
    }

    public function eclaimsummaryreport() {
        $result = array('status' => FALSE);
        $date = $this->input->post('start_date');

        $eclaimsummaryreport = $this->user_model->fetch_eclaimssummary_report($date);
        $all_eclaimssummary_report = $this->user_model->fetch_all_eclaimssummary_report($date);

        if ($eclaimsummaryreport) {
            $result['eclaimsummaryreport'] = $eclaimsummaryreport;
            $result['all_eclaimssummary_report'] = $all_eclaimssummary_report;
            $result['status'] = true;
        }


        echo json_encode($result);
    }

}
