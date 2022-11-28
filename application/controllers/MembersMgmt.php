<?php

class MembersMgmt extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('MembersMgmt_model', 'membersmgmt_model');
        $this->load->model('user_model');
    }

    public function index() {
        if ($this->has_log_in()) {

            $data["page_title"] = "Dashboard";
//            $data["census"] = $this->user_model->today_census();
//            $data["census_month"] = $this->user_model->get_daily_census();
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
                'assets/js/membersmgmt.js',
//                'assets/js/dashboard.js',
                'assets/js/lock.js');

            $this->user_page('membersmgmt', $data);
        } else {
            redirect(base_url("user/index"));
        }
    }

    public function fetchMembersList() {
        $membermonth = $this->input->post('membermonth');
        $fetch_data = $this->membersmgmt_model->make_MembersList_datatables($membermonth);
        $data = array();
        foreach ($fetch_data as $row) {

            $edit = ' <button type="button" class="btn btn-sm bg-blue waves-effect" onclick="editMember(' . "'" . $row->id . "','" . $row->inpatPIN . "','" . $row->membercardno  . "','" . $row->name  . "','" . $row->nostocks . "','" . $row->valueamount . "','" . $row->membersince. "','" . $row->bday. "','" . $row->sex . "','" . $row->address . "','" . $row->cityadd . "','" .  $row->cellphone . "','" .  $row->emailadd  ."','" .  $row->zone . "'" .')">
                                            <i class="material-icons">edit</i>
                                        </button>';

            $delete = ' <button type="button" class="btn btn-sm  bg-red waves-effect" onclick="deleteMember(' . $row->id . ')">
                                            <i class="material-icons">delete</i>
                                        </button>';

            $sub_array = array();
            $sub_array[] = $edit . $delete;
            $sub_array[] = $row->inpatPIN;
            $sub_array[] = $row->membercardno;
            $sub_array[] = $row->name;
            $sub_array[] = $row->nostocks;
            $sub_array[] = $this->format_moneyx($row->valueamount);
            $sub_array[] = $this->format_datexx($row->membersince);
            $sub_array[] = $this->format_datexx($row->bday);
            $sub_array[] = $row->sex;
            $sub_array[] = $row->address;
            $sub_array[] = $row->cellphone;
            $sub_array[] = $row->emailadd;
            $sub_array[] = $row->zone;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->membersmgmt_model->fetch_MembersList_data($membermonth),
            "recordsFiltered" => $this->membersmgmt_model->fetch_MembersList_filtered_data($membermonth),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetchZoneList() {
        $fetch_data = $this->membersmgmt_model->make_ZoneList_datatables();
        $data = array();
        foreach ($fetch_data as $row) {

            $edit = ' <button type="button" class="btn bg-blue waves-effect" onclick="editZone(' . "'" . $row->id . "','" . $row->zone . "','" . $row->description . "'" . ')">
                                            <i class="material-icons">update</i>
                                            <span>Edit</span>
                                        </button>';

            $delete = ' <button type="button" class="btn bg-red waves-effect" onclick="deleteZone(' . $row->id . ')">
                                            <i class="material-icons">delete</i>
                                            <span>Delete</span>
                                        </button>';


            $sub_array = array();
            $sub_array[] = $edit . ' ' . $delete;
            $sub_array[] = $row->zone;
            $sub_array[] = $row->description;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->membersmgmt_model->fetch_ZoneList_data(),
            "recordsFiltered" => $this->membersmgmt_model->fetch_ZoneList_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function fetchListOfZones() {
        $fetch_data = $this->membersmgmt_model->make_ZoneList_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->zone;
            $sub_array[] = $row->description;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->membersmgmt_model->fetch_ZoneList_data(),
            "recordsFiltered" => $this->membersmgmt_model->fetch_ZoneList_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function announcementsmembers() {
        if ($this->has_log_in()) {

            $data["page_title"] = "Dashboard";
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
                'assets/vendors/plugins/momentjs/moment.js',
//                'assets/vendors/plugins/Flot/jquery.flot.barlabels.js',
                'assets/vendors/js/Chart.js',
                'assets/js/myChart.js',
                'assets/js/membersmgmt.js',
//                'assets/js/dashboard.js',
                'assets/js/lock.js');

            $this->user_page('membersannouncement', $data);
        } else {
            redirect(base_url("user/index"));
        }
    }

    public function zonemangmt() {
        if ($this->has_log_in()) {

            $data["page_title"] = "Dashboard";
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
                'assets/js/membersmgmt.js',
//                'assets/js/dashboard.js',
                'assets/js/lock.js');

            $this->user_page('memberszonemanagement', $data);
        } else {
            redirect(base_url("user/index"));
        }
    }

    public function fetchFinalRecipients() {
        $noticerefno = $this->input->post('noticerefno');
        $finalrecipient = $this->membersmgmt_model->FinalRecipientsList($noticerefno);
        $fetch_data = $this->membersmgmt_model->make_FinalRecipients_datatables($noticerefno);
        $data = $total = array();
        $total = $finalrecipient;
        foreach ($fetch_data as $row) {

            $sub_array = array();

            $sub_array[] = '<button type="button" class="btn bg-red btn-sm waves-effect btn-block" data-toggle="tooltip" data-placement="right" title="Remove" onclick="deleteRecipientInfo(' . $row->id . ')">
                                            <i class="material-icons">arrow_back</i>
                                        </button>';
            $sub_array[] = $row->cardno;
            $sub_array[] = $row->name;
            $sub_array[] = $row->address;
            $sub_array[] = $row->mobileno;
            $sub_array[] = $row->emailadd;
            $sub_array[] = $row->zone;
            $sub_array[] = $row->issent;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->membersmgmt_model->fetch_FinalRecipients_data($noticerefno),
            "recordsFiltered" => $this->membersmgmt_model->fetch_FinalRecipients_filtered_data($noticerefno),
            "data" => $data,
            "total" => $total
        );
        echo json_encode($output);
    }

    public function fetchRecipient_All() {
        $noticerefno = $this->input->post('noticerefno');
        $membercardno = $this->input->post('membercardno');
        $fetchrecipientrow = $this->membersmgmt_model->fetch_MembersList_filtered_data('All');
        $totalrow = intval($fetchrecipientrow) - intval($membercardno);
        $fetch_data = $this->membersmgmt_model->make_Recipient_All_datatables();
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->membercardno;
            $sub_array[] = $row->name;
            $sub_array[] = "<button type='button' id='selectbutton' class='btn bg-primary waves-effect btn-block' onclick='addRecipientInfo(" . '"' . $row->membercardno . '",' . '"' . $row->name . '",' . '"' . $row->address . '",' . '"' . $row->cityadd . '",' . '"' . $row->cellphone . '",' . '"' . $row->emailadd . '",' . '"' . $row->zone . '"' . ")'>
                                <span>Select</span> <i class='material-icons'>arrow_forward</i>
                            </button>";
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $totalrow,
            "recordsFiltered" => $totalrow,
            "data" => $data
        );
        echo json_encode($output);
    }

    public function fetchAreaZone() {
        $fetch_data = $this->membersmgmt_model->make_Recipient_AreaZone_datatables();
        $data = array();
        foreach ($fetch_data as $row) {

            $sub_array = array();
            $sub_array[] = $row->zone;
            $sub_array[] = "<button type='button' id='selectbutton' class='btn bg-primary waves-effect btn-block' onclick='addRecipient_AreaZone(" . '"' . $row->zone . '"' . ")'>
                                <span>Select</span> <i class='material-icons'>arrow_forward</i>
                            </button>";
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->membersmgmt_model->fetch_Recipient_AreaZone_data(),
            "recordsFiltered" => $this->membersmgmt_model->fetch_Recipient_AreaZone_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function getRecipientPerAreaZone() {
        $result = array('status' => FALSE);
        $zone = $this->input->post('zone');
        $getRecipientPerAreaZone = $this->membersmgmt_model->getRecipientPerAreaZone($zone);
        if ($getRecipientPerAreaZone) {
            $result['getRecipientPerAreaZone'] = $getRecipientPerAreaZone;
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function AddAllMembers() {
        $result = array('status' => FALSE);
        $zone = $this->input->post('zone');
        $AddAllMembers = $this->membersmgmt_model->AddAllMembers();
        if ($AddAllMembers) {
            $result['AddAllMembers'] = $AddAllMembers;
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function saveRecipient() {
        $result = array('status' => false);

        $data['referenceno'] = $this->input->post('referenceno');
        $data['template'] = $this->input->post('template');
        $data['subject'] = $this->input->post('subject');
        $data['meetingdate'] = $this->input->post('meetingdate');
        $data['location'] = $this->input->post('location');
        $data['agenda'] = $this->input->post('agenda');
        $data['cardno'] = $this->input->post('cardno');
        $data['name'] = $this->input->post('name');
        $data['address'] = $this->input->post('address');
        $data['emailadd'] = $this->input->post('emailadd');
        $data['mobileno'] = $this->input->post('mobileno');
        $data['zone'] = $this->input->post('zone');

        $data['registrationtime'] = $this->input->post('registrationtime');
        $data['contactperson'] = $this->input->post('contactperson');
        $data['contactno'] = $this->input->post('contactno');
        $data['reasonofcancellation'] = $this->input->post('reasonofcancellation');


        $FinalRecipientsListMemberCardno = $this->membersmgmt_model->FinalRecipientsListMemberCardnox($data['referenceno'], $data['cardno']);
        if ($FinalRecipientsListMemberCardno['countxx'] == 0) {
            if ($this->membersmgmt_model->saveRecipient($data)) {
                $result['status'] = true;
            }
        } else {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function updateAnnouncement() {
        $result = array('status' => false);

        $data['referenceno'] = $this->input->post('referenceno');
        $data['template'] = $this->input->post('template');
        $data['subject'] = $this->input->post('subject');
        $data['meetingdate'] = $this->input->post('meetingdate');
        $data['location'] = $this->input->post('location');
        $data['agenda'] = $this->input->post('agenda');
        $data['registrationtime'] = $this->input->post('registrationtime');
        $data['contactperson'] = $this->input->post('contactperson');
        $data['contactno'] = $this->input->post('contactno');
        $data['reasonofcancellation'] = $this->input->post('reasonofcancellation');

        if ($this->membersmgmt_model->updateAnnouncement($data)) {
            $result['status'] = true;
        }

        echo json_encode($result);
    }

    public function removeFinalRecipient() {
        $result = array('status' => FALSE);
        $id = $this->input->post('id');

        if ($this->membersmgmt_model->removeFinalRecipient($id)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function generate_announcement() {
        $s_date = new DateTime($this->input->post("s_date"));
        $e_date = new DateTime($this->input->post("e_date"));
        $this->load->library('pdf');
        $data["s_date"] = $s_date->format("Y-m-d");
        $data["e_date"] = $e_date->format("Y-m-d");
        $data['searc'] = $this->input->post('search');
        $data['exp'] = $this->input->post('exp');
        $data["dx_record"] = $this->user_model->doc_report($data);
        $data["title"] = "Notice For Annual General Members Meeting";

        $data['profile'] = $this->user_model->get_hospital();

        $data['datenow'] = $this->get_current_date();

        $this->pdf->load_view('reports/membersmgmt/noticeforannualgeneralmeeting', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("general-meeting-announcement.pdf", array('Attachment' => 0));
    }

    public function generate_cancellation_anouncement() {
        $s_date = new DateTime($this->input->post("s_date"));
        $e_date = new DateTime($this->input->post("e_date"));
        $this->load->library('pdf');
        $data["s_date"] = $s_date->format("Y-m-d");
        $data["e_date"] = $e_date->format("Y-m-d");
        $data['searc'] = $this->input->post('search');
        $data['exp'] = $this->input->post('exp');
        $data["dx_record"] = $this->user_model->doc_report($data);
        $data["title"] = "Meeting Cancellation";

        $data['profile'] = $this->user_model->get_hospital();

        $data['datenow'] = $this->get_current_date();

        $this->pdf->load_view('reports/membersmgmt/noticecancellationannouncement', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("cancellation-announcement.pdf", array('Attachment' => 0));
    }

    public function GenerateBoardMeetingAnnouncement() {
        $s_date = new DateTime($this->input->post("s_date"));
        $e_date = new DateTime($this->input->post("e_date"));



        $this->load->library('pdf');
        $data["s_date"] = $s_date->format("Y-m-d");
        $data["e_date"] = $e_date->format("Y-m-d");
        $data['searc'] = $this->input->post('search');
        $data['exp'] = $this->input->post('exp');
        $data["dx_record"] = $this->user_model->doc_report($data);
        $data["title"] = "Notice For Board Meeting";
        $data['profile'] = $this->user_model->get_hospital();
        $data['datenow'] = $this->get_current_date();

        $this->pdf->load_view('reports/membersmgmt/noticeforboardmeeting', $data);
        $this->pdf->set_paper('A4', 'portrait');

        $this->pdf->render();
        $canvas = $this->pdf->get_canvas();
        $font = Font_Metrics::get_font("helvetica", "bold");
        $canvas->page_text(35, 810, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        $this->pdf->stream("general-meeting-announcement.pdf", array('Attachment' => 0));
    }

    public function SendAnnualMeetingTextMessage() {
        $notice_ref_no = $this->input->post('noticeRefNo', TRUE);
        $notice_time = $this->input->post('noticeTime', TRUE);
        $notice_date = $this->format_datexx($this->input->post('noticeDate', TRUE));
        $notice_subject = $this->input->post('noticeSubject', TRUE);
        $notice_place = $this->input->post('noticePlace', TRUE);
        $registration_time = $this->input->post('registrationTime', TRUE);

        $this->form_validation->set_rules('noticeRefNo', 'Ref No.', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeTime', 'Time', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeDate', 'Date', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeSubject', 'Subject', 'required|min_length[1]|max_length[500]');
        $this->form_validation->set_rules('noticePlace', 'Place', 'required|min_length[1]|max_length[500]');
        $this->form_validation->set_rules('registrationTime', 'Registration Time', 'required|min_length[1]|max_length[500]');
        if ($this->form_validation->run() == FALSE) {
            $errors['txtnoticerefno'] = form_error('noticeRefNo');
            $errors['txtnoticetime'] = form_error('noticeTime');
            $errors['txtnoticedate'] = form_error('noticeDate');
            $errors['txtnoticesubject'] = form_error('noticeSubject');
            $errors['txtnoticeplace'] = form_error('noticePlace');
            $errors['txtregistrationtime'] = form_error('registrationTime');

            $result = ['status' => FALSE, 'errors' => $errors, 'meetingtype' => 'Annual'];
        } else {
            $recipients = $this->membersmgmt_model->get_all_recipient($notice_ref_no);

            foreach ($recipients as $row) {
                $station = "DrainwizV2 Auto Text System";
                $transaction = $notice_subject;
                $message = 'Dear, ' . $row->name . PHP_EOL .
                        'What: ' . $notice_subject . PHP_EOL .
                        'When: ' . $notice_date . PHP_EOL .
                        'Where: ' . $notice_place . ' at ' . $notice_time . PHP_EOL .
                        'Registration Time: ' . $registration_time;

                if (strlen($message) > 160) {
                    $result = ['status' => FALSE, 'errors' => 'messagelengtherror', 'meetingtype' => 'BM'];
                } else {

                    $myfile = fopen("webconfig\\server.txt", "r") or die("Unable to open file!");
                    $server = fgets($myfile);

                    fclose($myfile);

                    $headnumber['cellphone'] = $row->mobileno;
                    $my_file = '\\\\' . $server . '\\BinaryDepot\\DrainwizMessage\\Inbox\\' . $transaction . '.txt';
                    $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
                    $dataxx = $message;
//            $dataxx = $headnumber['cellphone'] . "\r\n" . $message;

                    if (fwrite($handle, $dataxx)) {
                        $this->membersmgmt_model->insert_message_applicant($message, $headnumber['cellphone'], $station, $transaction);
                    }

                    $this->membersmgmt_model->update_meeting('text', $row->id);
                    $result = ['status' => TRUE, 'meetingtype' => 'Annual'];
                }
            }
        }

        echo json_encode($result);
    }

    public function SendBoardMeetingTextMessage() {
        $notice_ref_no = $this->input->post('noticeRefNo', TRUE);
        $notice_time = $this->input->post('noticeTime', TRUE);
        $notice_date = $this->format_datexx($this->input->post('noticeDate', TRUE));
        $notice_subject = $this->input->post('noticeSubject', TRUE);
        $notice_place = $this->input->post('noticePlace', TRUE);
        $notice_agenda = $this->input->post('noticeAgenda');

        $recipients = $this->membersmgmt_model->get_all_recipient($notice_ref_no);

        $this->form_validation->set_rules('noticeRefNo', 'Ref No.', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeTime', 'Time', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeDate', 'Date', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeSubject', 'Subject', 'required|min_length[1]|max_length[500]');
        $this->form_validation->set_rules('noticePlace', 'Place', 'required|min_length[1]|max_length[500]');
        $this->form_validation->set_rules('noticeAgenda', 'Agenda', 'required|min_length[1]|max_length[500]');
        if ($this->form_validation->run() == FALSE) {
            $errors['txtnoticerefno'] = form_error('noticeRefNo');
            $errors['txtnoticetime'] = form_error('noticeTime');
            $errors['txtnoticedate'] = form_error('noticeDate');
            $errors['txtnoticesubject'] = form_error('noticeSubject');
            $errors['txtnoticeplace'] = form_error('noticePlace');
            $errors['txtnoticeagenda'] = form_error('noticeAgenda');

            $result = ['status' => FALSE, 'errors' => $errors, 'meetingtype' => 'BM'];
        } else {

            foreach ($recipients as $row) {
                $station = "DrainwizV2 Auto Text System";
                $transaction = $notice_subject;
                $message = 'Dear, ' . $row->name . PHP_EOL .
                        'What: ' . $notice_subject . PHP_EOL .
                        'When: ' . $notice_date . PHP_EOL .
                        'Where: ' . $notice_place . ' at ' . $notice_time . PHP_EOL .
                        'Agenda: ' . $notice_agenda;

                if (strlen($message) > 160) {
                    $result = ['status' => FALSE, 'errors' => 'messagelengtherror'];
                } else {

                    $myfile = fopen("webconfig\\server.txt", "r") or die("Unable to open file!");
                    $server = fgets($myfile);

                    fclose($myfile);

                    $headnumber['cellphone'] = $row->mobileno;
                    $my_file = '\\\\' . $server . '\\BinaryDepot\\DrainwizMessage\\Inbox\\' . $transaction . '.txt';
                    $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
                    $dataxx = $message;
//            $dataxx = $headnumber['cellphone'] . "\r\n" . $message;

                    if (fwrite($handle, $dataxx)) {
                        $this->membersmgmt_model->insert_message_applicant($message, $headnumber['cellphone'], $station, $transaction);
                    }

                    $this->membersmgmt_model->update_meeting('text', $row->id);
                    $result = ['status' => TRUE, 'meetingtype' => 'BM'];
                }
            }
        }


//        }

        echo json_encode($result);
    }

    public function SendMeetingCancellationTextMessage() {
        $notice_ref_no = $this->input->post('noticeRefNo', TRUE);
        $notice_date = $this->format_datexx($this->input->post('noticeDate', TRUE));
        $notice_subject = $this->input->post('noticeSubject', TRUE);
        $contact_person = $this->input->post('noticeContactPerson', TRUE);
        $contact_number = $this->input->post('noticeContactNumber', TRUE);
        $reason_of_cancellation = $this->input->post('noticeReasonOfCancellation', TRUE);

        $recipients = $this->membersmgmt_model->get_all_recipient($notice_ref_no);

        $this->form_validation->set_rules('noticeRefNo', 'Ref No.', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeSubject', 'Subject', 'required|min_length[1]|max_length[500]');
        $this->form_validation->set_rules('noticeDate', 'Date', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeContactPerson', 'Contact Person', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeContactNumber', 'Contact Number', 'required|min_length[1]|max_length[500]');
        $this->form_validation->set_rules('noticeReasonOfCancellation', 'Reason of cancellation', 'required|min_length[1]|max_length[500]');
        if ($this->form_validation->run() == FALSE) {
            $errors['txtnoticerefno'] = form_error('noticeRefNo');
            $errors['txtnoticesubject'] = form_error('noticeSubject');
            $errors['txtnoticedate'] = form_error('noticeDate');
            $errors['txtnoticecontactperson'] = form_error('noticeContactPerson');
            $errors['txtnoticecontactnumber'] = form_error('noticeContactNumber');
            $errors['txtnoticereasonofcancellation'] = form_error('noticeReasonOfCancellation');

            $result = ['status' => FALSE, 'errors' => $errors, 'meetingtype' => 'MC'];
        } else {

            foreach ($recipients as $row) {
                $station = "DrainwizV2 Auto Text System";
                $transaction = $notice_subject;
                $message = 'Dear, ' . $row->name . PHP_EOL .
                        'What: ' . $notice_subject . PHP_EOL .
                        'When: ' . $notice_date . PHP_EOL .
                        'Reason: ' . $reason_of_cancellation . PHP_EOL;
//                    'Contact Person: ' . $contact_person . ' , ' . $contact_number;

                if (strlen($message) > 160) {
                    $result = ['status' => FALSE, 'errors' => 'messagelengtherror'];
                } else {

                    $myfile = fopen("webconfig\\server.txt", "r") or die("Unable to open file!");
                    $server = fgets($myfile);

                    fclose($myfile);

                    $headnumber['cellphone'] = $row->mobileno;
                    $my_file = '\\\\' . $server . '\\BinaryDepot\\DrainwizMessage\\Inbox\\' . $transaction . '.txt';
                    $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
                    $dataxx = $message;
//            $dataxx = $headnumber['cellphone'] . "\r\n" . $message;

                    if (fwrite($handle, $dataxx)) {
                        $this->membersmgmt_model->insert_message_applicant($message, $headnumber['cellphone'], $station, $transaction);
                    }

                    $this->membersmgmt_model->update_meeting('text', $row->id);

                    $result = ['status' => TRUE, 'meetingtype' => 'MC'];
                }
            }
        }

        echo json_encode($result);
    }

    public function SendBoardMeetingEmail() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = 'drainwiz.info@gmail.com';
        $config['smtp_pass'] = 'sqputaqqzitpziby';
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $this->load->library('email', $config);

        $this->email->set_newline("\r\n");

        $notice_ref_no = $this->input->post('noticeRefNo', TRUE);
        $notice_time = $this->input->post('noticeTime', TRUE);
        $notice_date = $this->format_datexx($this->input->post('noticeDate', TRUE));
        $notice_subject = $this->input->post('noticeSubject', TRUE);
        $notice_place = $this->input->post('noticePlace', TRUE);
        $send_email_is_checked = $this->input->post('sendMailIsChecked', TRUE);
        $notice_agenda = nl2br($this->input->post('noticeAgenda'));

        $recipients = $this->membersmgmt_model->get_all_recipient($notice_ref_no);

        $this->form_validation->set_rules('noticeRefNo', 'Ref No.', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeTime', 'Time', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeDate', 'Date', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeSubject', 'Subject', 'required|min_length[1]|max_length[500]');
        $this->form_validation->set_rules('noticePlace', 'Place', 'required|min_length[1]|max_length[500]');
        $this->form_validation->set_rules('noticeAgenda', 'Agenda', 'required|min_length[1]|max_length[500]');
        if ($this->form_validation->run() == FALSE) {
            $errors['txtnoticerefno'] = form_error('noticeRefNo');
            $errors['txtnoticetime'] = form_error('noticeTime');
            $errors['txtnoticedate'] = form_error('noticeDate');
            $errors['txtnoticesubject'] = form_error('noticeSubject');
            $errors['txtnoticeplace'] = form_error('noticePlace');
            $errors['txtnoticeagenda'] = form_error('noticeAgenda');

            $result = ['status' => FALSE, 'errors' => $errors, 'meetingtype' => 'BM'];
        } else {

            foreach ($recipients as $row) {
                $this->email->from('drainwiz.info@gmail.com', 'Drainwiz Computer Systems');

                if ($send_email_is_checked == 'true') {
                    $this->email->cc('drainwiz.info@gmail.com');
                }

                $this->email->to($row->emailadd);
                $this->email->subject($notice_subject);
                $this->email->message("<h3>NOTICE OF BOARD MEETING</h3> <br>"
                        . "Dear members: <br>"
                        . "$notice_subject ON $notice_date $notice_time<br><br>"
                        . "Please be informed that the $notice_subject of the Drainwiz Computer System will be held "
                        . "at the $notice_place on $notice_date $notice_time <br><br>"
                        . "<h4>Agenda</h4>"
                        . "$notice_agenda<br><br>"
                        . "Thank you.<br><br>"
                        . "Respectfully Yours,<br>"
                        . "Regan Andrew Nacario<br>"
                        . "CEO");

                $result_send = $this->email->send();

                if ($result_send) {
                    $this->membersmgmt_model->update_meeting('email', $row->id);
                }
            }

            $result = ['status' => TRUE, 'meetingtype' => 'BM'];
        }
        echo json_encode($result);
    }

    public function SendAnnualMeetingEmail() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = 'drainwiz.info@gmail.com';
        $config['smtp_pass'] = 'sqputaqqzitpziby';
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $this->load->library('email', $config);

        $this->email->set_newline("\r\n");

        $notice_ref_no = $this->input->post('noticeRefNo', TRUE);
        $notice_time = $this->input->post('noticeTime', TRUE);
        $notice_date = $this->format_datexx($this->input->post('noticeDate', TRUE));
        $notice_subject = $this->input->post('noticeSubject', TRUE);
        $notice_place = $this->input->post('noticePlace', TRUE);
        $registration_time = $this->input->post('registrationTime', TRUE);
        $send_email_is_checked = $this->input->post('sendMailIsChecked', TRUE);
        $notice_agenda = nl2br($this->input->post('noticeAgenda'));

        $recipients = $this->membersmgmt_model->get_all_recipient($notice_ref_no);

        $this->form_validation->set_rules('noticeRefNo', 'Ref No.', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeTime', 'Time', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeDate', 'Date', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeSubject', 'Subject', 'required|min_length[1]|max_length[500]');
        $this->form_validation->set_rules('noticePlace', 'Place', 'required|min_length[1]|max_length[500]');
        $this->form_validation->set_rules('registrationTime', 'Registration Time', 'required|min_length[1]|max_length[500]');
        if ($this->form_validation->run() == FALSE) {
            $errors['txtnoticerefno'] = form_error('noticeRefNo');
            $errors['txtnoticetime'] = form_error('noticeTime');
            $errors['txtnoticedate'] = form_error('noticeDate');
            $errors['txtnoticesubject'] = form_error('noticeSubject');
            $errors['txtnoticeplace'] = form_error('noticePlace');
            $errors['txtregistrationtime'] = form_error('registrationTime');

            $result = ['status' => FALSE, 'errors' => $errors, 'meetingtype' => 'Annual'];
        } else {
            foreach ($recipients as $row) {
                $this->email->from('drainwiz.info@gmail.com', 'Drainwiz Computer Systems');

                if ($send_email_is_checked == 'true') {
                    $this->email->cc('drainwiz.info@gmail.com');
                }

                $this->email->to($row->emailadd);
                $this->email->subject($notice_subject);
                $this->email->message("<h3>NOTICE OF ANNUAL GENERAL MEMBERS MEETING</h3> <br>"
                        . "Dear $row->name: <br>"
                        . "The $notice_subject of Drainwiz Computer System "
                        . "agenda has been scheduled for:<br><br>"
                        . "$notice_date<br>"
                        . "AT $notice_time<br>"
                        . "In the $notice_place<br>"
                        . "Registration starts at $registration_time<br><br>"
                        . "<u>Please note that quorum must be maintained during the entire meeting.</u><br><br>"
                        . "Thank you.<br><br>"
                        . "Respectfully Yours,<br>"
                        . "Regan Andrew Nacario<br>"
                        . "CEO");

                $result_send = $this->email->send();

                if ($result_send) {
                    $this->membersmgmt_model->update_meeting('email', $row->id);
                }
            }

            $result = ['status' => TRUE, 'meetingtype' => 'Annual'];
        }
        echo json_encode($result);
    }

    public function SendMeetingCancellationEmail() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = 'drainwiz.info@gmail.com';
        $config['smtp_pass'] = 'sqputaqqzitpziby';
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $this->load->library('email', $config);

        $this->email->set_newline("\r\n");

        $notice_ref_no = $this->input->post('noticeRefNo', TRUE);
        $notice_time = $this->input->post('noticeTime', TRUE);
        $notice_date = $this->format_datexx($this->input->post('noticeDate', TRUE));
        $notice_subject = $this->input->post('noticeSubject', TRUE);
        $notice_place = $this->input->post('noticePlace', TRUE);
        $registration_time = $this->input->post('registrationTime', TRUE);
        $contact_person = $this->input->post('noticeContactPerson', TRUE);
        $contact_number = $this->input->post('noticeContactNumber', TRUE);
        $reason_of_cancellation = $this->input->post('noticeReasonOfCancellation', TRUE);
        $send_email_is_checked = $this->input->post('sendMailIsChecked', TRUE);
        $notice_agenda = nl2br($this->input->post('noticeAgenda'));

        $recipients = $this->membersmgmt_model->get_all_recipient($notice_ref_no);

        $this->form_validation->set_rules('noticeRefNo', 'Ref No.', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeSubject', 'Subject', 'required|min_length[1]|max_length[500]');
        $this->form_validation->set_rules('noticeDate', 'Date', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeContactPerson', 'Contact Person', 'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('noticeContactNumber', 'Contact Number', 'required|min_length[1]|max_length[500]');
        $this->form_validation->set_rules('noticeReasonOfCancellation', 'Reason of cancellation', 'required|min_length[1]|max_length[500]');
        if ($this->form_validation->run() == FALSE) {
            $errors['txtnoticerefno'] = form_error('noticeRefNo');
            $errors['txtnoticesubject'] = form_error('noticeSubject');
            $errors['txtnoticedate'] = form_error('noticeDate');
            $errors['txtnoticecontactperson'] = form_error('noticeContactPerson');
            $errors['txtnoticecontactnumber'] = form_error('noticeContactNumber');
            $errors['txtnoticereasonofcancellation'] = form_error('noticeReasonOfCancellation');

            $result = ['status' => FALSE, 'errors' => $errors, 'meetingtype' => 'MC'];
        } else {
            foreach ($recipients as $row) {
                $this->email->from('drainwiz.info@gmail.com', 'Drainwiz Computer Systems');

                if ($send_email_is_checked == 'true') {
                    $this->email->cc('drainwiz.info@gmail.com');
                }

                $this->email->to($row->emailadd);
                $this->email->subject($notice_subject);
                $this->email->message("<h3>NOTICE OF MEETING CANCELLATION</h3> <br>"
                        . "$notice_subject <br><br>"
                        . "The $notice_date meeting has been cancelled due to $reason_of_cancellation. The meeting will be "
                        . "rescheduled at a later date. <br><br>"
                        . "For any questions please contact $contact_person $contact_number<br><br>"
                        . "Respectfully Yours,<br>"
                        . "Regan Andrew Nacario<br>"
                        . "CEO");

                $result_send = $this->email->send();

                if ($result_send) {
                    $this->membersmgmt_model->update_meeting('email', $row->id);
                }
            }

            $result = ['status' => TRUE, 'meetingtype' => 'MC'];
        }
        echo json_encode($result);
    }

    public function GetAllRecipients() {

        $notice_ref_no = $this->input->post('noticeRefNo', TRUE);

        $recipients = $this->membersmgmt_model->get_all_recipient($notice_ref_no);

        if ($recipients) {
            echo json_encode($recipients);
        } else {
            $recipients = ['recipientserror' => TRUE];
            echo json_encode($recipients);
        }
    }

    public function CheckSupervisorAccount() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $result = $this->user_model->check_if_supervisor_account_is_correct($username, $password);

        echo json_encode($result);
    }

    public function fetchAllAnnouncements() {

        $fetch_data = $this->membersmgmt_model->make_AllAnnouncements_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $FinalRecipientsList = $this->membersmgmt_model->FinalRecipientsList($row->referenceno);
            $sub_array = array();
            $sub_array[] = $row->referenceno;
            if ($row->template == "Annual") {
                $sub_array[] = 'Notice of Annual General Members Meeting';
            } else if ($row->template == "BM") {
                $sub_array[] = 'Board Meeting';
            } else {
                $sub_array[] = 'Meeting Cancellation';
            }

            $sub_array[] = $row->subject;
            $sub_array[] = $this->format_datexx($row->meetingdate);
            $sub_array[] = $row->location;
            $sub_array[] = '<center>' . count($FinalRecipientsList) . '</center>';
            if ($row->status == 1) {
                $sub_array[] = "Done";
            } else {
                $sub_array[] = "<button type='button' class='btn bg-red waves-effect btn-block' onclick='setInactive(" . '"' . $row->referenceno . '"' . ")'>
                                 <i class='material-icons'>close</i> <span>Done</span>
                            </button>";
            }
            $sub_array[] = "<button type='button' class='btn bg-green waves-effect btn-block' onclick='viewDetails(" . '"' . $row->referenceno . '",' . '"' . $row->status . '"' . ")'>
                                <i class='material-icons'>pageview</i><span> View Details</span> 
                            </button>";

            $sub_array[] = $row->status;
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $this->membersmgmt_model->fetch_AllAnnouncements_data(),
            "recordsFiltered" => $this->membersmgmt_model->fetch_AllAnnouncements_filtered_data(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function setInactive() {
        $result = array('status' => FALSE);
        $referenceno = $this->input->post('referenceno');
        $setAnnouncementToInactive = $this->membersmgmt_model->setAnnouncementToInactive($referenceno);
        if ($setAnnouncementToInactive) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function viewDetailsByReferenceNo() {
        $result = array('status' => FALSE);
        $referenceno = $this->input->post('referenceno');
        $viewDetailsByReferenceNo = $this->membersmgmt_model->viewDetailsByReferenceNo($referenceno);
        if ($viewDetailsByReferenceNo) {
            $result['viewDetailsByReferenceNo'] = $viewDetailsByReferenceNo;
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function saveAnnouncement() {
        $result = array('status' => false);

        $data['referenceno'] = $this->input->post('referenceno');
        $data['template'] = $this->input->post('template');
        $data['subject'] = $this->input->post('subject');
        $data['meetingdate'] = $this->input->post('meetingdate');
        $data['location'] = $this->input->post('location');
        $data['agenda'] = $this->input->post('agenda');
        $data['registrationtime'] = $this->input->post('registrationtime');
        $data['contactperson'] = $this->input->post('contactperson');
        $data['contactno'] = $this->input->post('contactno');
        $data['reasonofcancellation'] = $this->input->post('reasonofcancellation');

        if ($this->membersmgmt_model->saveAnnouncement($data)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function SavedZone() {
        $result = array('status' => FALSE);
        $zone = $this->input->post('zone');
        $description = $this->input->post('desc');
        $count = $this->membersmgmt_model->get_Zone($zone);
        if ($this->membersmgmt_model->save_zone($zone, $description, $count)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function DeleteZone() {
        $result = array('status' => FALSE);
        $id = $this->input->post('id');
        if ($this->membersmgmt_model->delete_zone($id)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function DeleteMember() {
        $result = array('status' => FALSE);
        $id = $this->input->post('id');
        if ($this->membersmgmt_model->delete_member($id)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

    public function EditZone() {
        $result = array('status' => FALSE);
        $id = $this->input->post('id');
        $zone = $this->input->post('zone');
        $description = $this->input->post('desc');
        $count = $this->membersmgmt_model->get_Zone($zone);
        if ($this->membersmgmt_model->edit_zone($id, $zone, $description, $count)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }
    
    public function EditMember() {
        $result = array('status' => FALSE);
         
        
        $data['id'] = $this->input->post('txtid');
       
        $data['membercardno'] = $this->input->post('txtcardno');
        $data['membersince'] = $this->input->post('txtdate');
        $data['name'] = $this->input->post('txtname');
        $data['emailadd'] = $this->input->post('txtemail');
        $data['bday'] = $this->input->post('txtbday');
        $data['address'] = $this->input->post('txtAddress');
        $data['cellphone'] = $this->input->post('txtmobileno');
        $data['zone'] = $this->input->post('txtzone');
        $data['nostocks'] = $this->input->post('txtstocks');
        $data['valueamount'] = $this->input->post('txtvalues');

        if ($this->membersmgmt_model->edit_member($data)) {
            $result['status'] = true;
        }
        echo json_encode($result);
    }

}
