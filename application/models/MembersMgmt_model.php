<?php

class MembersMgmt_model extends MY_Model {

    //put your code here
    public function __construct() {
        parent::__construct();

        $this->messaging_db = $this->load->database('messaging', TRUE);
    }

    /* Member's Listing
     * Alynna Pajaron
     * @version 09.15.2019
     */

    public function fetchMembersList($membermonth) {
        $monthstart = date("Y-m-01", strtotime($membermonth . "-01"));
        $monthend = date("Y-m-t", strtotime($membermonth . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $order_column = array("inpatPIN", "membercardno", "name", "nostocks", "valueamount", "membersince", "bday", "sex", "address", "cellphone", 'emailadd');

        $this->db->select('*')
                ->from(memberlisting_tbl);
        if ($membermonth <> "All") {
            $this->db->where('membersince >=', $first)
                    ->where('membersince <=', $end);
        }

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('inpatPIN', $this->input->post("search")["value"])
                    ->or_like('membercardno', $this->input->post("search")["value"])
                    ->or_like('name', $this->input->post("search")["value"])
                    ->or_like('nostocks', $this->input->post("search")["value"])
                    ->or_like('valueamount', $this->input->post("search")["value"])
                    ->or_like('membersince', $this->input->post("search")["value"])
                    ->or_like('sex', $this->input->post("search")["value"])
                    ->or_like('address', $this->input->post("search")["value"])
                    ->or_like('cellphone', $this->input->post("search")["value"])
                    ->or_like('emailadd', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('name', 'ASC');
        }
    }

    public function fetchZoneList() {
        $order_column = array("zone", "description");

        $this->db->select('*')
                ->from('zonelisting');

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('zone', $this->input->post("search")["value"])
                    ->or_like('description', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('zone', 'ASC');
        }
    }

    function make_MembersList_datatables($membermonth) {
        $this->fetchMembersList($membermonth);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function make_ZoneList_datatables() {
        $this->fetchZoneList();
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_MembersList_filtered_data($membermonth) {
        $this->fetchMembersList($membermonth);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function fetch_ZoneList_filtered_data() {
        $this->fetchZoneList();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function fetch_MembersList_data($membermonth) {
        $monthstart = date("Y-m-01", strtotime($membermonth . "-01"));
        $monthend = date("Y-m-t", strtotime($membermonth . "-01"));

        $d = new DateTime($monthstart);
        $first = $d->format('Y-m-d');
        $e = new DateTime($monthend);
        $end = $e->format('Y-m-d');

        $this->db->select('*')
                ->from(memberlisting_tbl);
        if ($membermonth <> "All") {
            $this->db->where('membersince >=', $first)
                    ->where('membersince <=', $end);
        }
        $this->db->order_by('name', 'ASC');

        return $this->db->count_all_results();
    }

    public function fetch_ZoneList_data() {
        $this->db->select('*')
                ->from('zonelisting')
                ->order_by('zone', 'ASC');

        return $this->db->count_all_results();
    }

    /* Notice Final Recipients
     * Alynna Pajaron
     * @version 09.15.2019
     */

    public function fetchFinalRecipients($noticerefno) {
        $order_column = array(null, "cardno", "name", "address", "mobileno", "emailadd", 'zone', 'issent');

        $this->db->select("id,cardno,name, address, mobileno, emailadd,zone,issent")
                ->from(membernotices_tbl)
                ->where('referenceno', $noticerefno);

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('cardno', $this->input->post("search")["value"])
                    ->or_like('name ', $this->input->post("search")["value"])
                    ->or_like('address', $this->input->post("search")["value"])
                    ->or_like('mobileno', $this->input->post("search")["value"])
                    ->or_like('emailadd', $this->input->post("search")["value"])
                    ->or_like('zone', $this->input->post("search")["value"])
                    ->or_like('issent', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('name', 'ASC');
        }
    }

    function make_FinalRecipients_datatables($noticerefno) {
        $this->fetchFinalRecipients($noticerefno);
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_FinalRecipients_filtered_data($noticerefno) {
        $this->fetchFinalRecipients($noticerefno);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function fetch_FinalRecipients_data($noticerefno) {
        $this->db->select("id,cardno,name, address, mobileno, emailadd,zone,issent")
                ->from(membernotices_tbl)
                ->where('referenceno', $noticerefno)
                ->order_by('name', 'ASC');

        return $this->db->count_all_results();
    }

    function FinalRecipientsList($noticerefno) {
        $this->db->select("cardno,name, address, mobileno, emailadd,zone")
                ->from(membernotices_tbl)
                ->where('referenceno', $noticerefno);
        $query = $this->db->get();
        return $query->result_array();
    }

    function viewDetailsByReferenceNo($noticerefno) {
        $this->db->select("*")
                ->from(membernotices_tbl)
                ->where('referenceno', $noticerefno)
                ->group_by('referenceno');
        $query = $this->db->get();
        return $query->row_array();
    }

    function FinalRecipientsListMemberCardnox($noticerefno, $membercardno) {
        $this->db->select("count(id) as countxx")
                ->from(membernotices_tbl)
                ->where('referenceno', $noticerefno)
                ->where('cardno', $membercardno);
        $query = $this->db->get();
        return $query->row_array();
    }

    /* Notice  Recipients _All
     * Alynna Pajaron
     * @version 09.15.2019
     */

    public function fetchRecipient_All() {
        $order_column = array("membercardno", "name", null);

        $this->db->select("*")
                ->from(memberlisting_tbl);

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('membercardno', $this->input->post("search")["value"])
                    ->or_like('name', $this->input->post("search")["value"])
                    ->or_like('address', $this->input->post("search")["value"])
                    ->or_like('cellphone', $this->input->post("search")["value"])
                    ->or_like('emailadd', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('name', 'ASC');
        }
    }

    function make_Recipient_All_datatables() {
        $this->fetchRecipient_All();
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_Recipient_All_filtered_data() {
        $this->fetchRecipient_All();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function fetch_Recipient_All_data() {
        $this->db->select("*")
                ->from(memberlisting_tbl)
                ->order_by('name', 'ASC');

        return $this->db->count_all_results();
    }

    public function saveRecipient($datax) {

        if ($datax['template'] == 'Annual') {
            $data = array(
                'referenceno' => $this->security->xss_clean($datax['referenceno']),
                'template' => $this->security->xss_clean($datax['template']),
                'subject' => $this->security->xss_clean($datax['subject']),
                'meetingdate' => $this->security->xss_clean($datax['meetingdate']),
                'location' => $this->security->xss_clean($datax['location']),
                'registrationtime' => $this->security->xss_clean($datax['registrationtime']),
                'cardno' => $this->security->xss_clean($datax['cardno']),
                'name' => $this->security->xss_clean($datax['name']),
                'address' => $this->security->xss_clean($datax['address']),
                'emailadd' => $this->security->xss_clean($datax['emailadd']),
                'mobileno' => $this->security->xss_clean($datax['mobileno']),
                'zone' => $this->security->xss_clean($datax['zone']),
                'updateID' => $this->security->xss_clean($this->session->userdata('empId')),
                'updatedby' => $this->security->xss_clean($this->session->userdata('empname')),
                'updated' => $this->security->xss_clean($this->get_current_date()),
            );
        } else if ($datax['template'] == 'BM') {
            $data = array(
                'referenceno' => $this->security->xss_clean($datax['referenceno']),
                'template' => $this->security->xss_clean($datax['template']),
                'subject' => $this->security->xss_clean($datax['subject']),
                'meetingdate' => $this->security->xss_clean($datax['meetingdate']),
                'location' => $this->security->xss_clean($datax['location']),
                'agenda' => $this->security->xss_clean($datax['agenda']),
                'cardno' => $this->security->xss_clean($datax['cardno']),
                'name' => $this->security->xss_clean($datax['name']),
                'address' => $this->security->xss_clean($datax['address']),
                'emailadd' => $this->security->xss_clean($datax['emailadd']),
                'mobileno' => $this->security->xss_clean($datax['mobileno']),
                'zone' => $this->security->xss_clean($datax['zone']),
                'updateID' => $this->security->xss_clean($this->session->userdata('empId')),
                'updatedby' => $this->security->xss_clean($this->session->userdata('empname')),
                'updated' => $this->security->xss_clean($this->get_current_date()),
            );
        } else {
            $data = array(
                'referenceno' => $this->security->xss_clean($datax['referenceno']),
                'template' => $this->security->xss_clean($datax['template']),
                'subject' => $this->security->xss_clean($datax['subject']),
                'meetingdate' => $this->security->xss_clean($datax['meetingdate']),
                'reasonofcancellation' => $this->security->xss_clean($datax['reasonofcancellation']),
                'contactperson' => $this->security->xss_clean($datax['contactperson']),
                'contactno' => $this->security->xss_clean($datax['contactno']),
                'cardno' => $this->security->xss_clean($datax['cardno']),
                'name' => $this->security->xss_clean($datax['name']),
                'address' => $this->security->xss_clean($datax['address']),
                'emailadd' => $this->security->xss_clean($datax['emailadd']),
                'mobileno' => $this->security->xss_clean($datax['mobileno']),
                'zone' => $this->security->xss_clean($datax['zone']),
                'updateID' => $this->security->xss_clean($this->session->userdata('empId')),
                'updatedby' => $this->security->xss_clean($this->session->userdata('empname')),
                'updated' => $this->security->xss_clean($this->get_current_date()),
            );
        }


        return $this->db->insert(membernotices_tbl, $data);
    }

    public function saveAnnouncement($datax) {

        if ($datax['template'] == 'Annual') {
            $data = array(
                'referenceno' => $this->security->xss_clean($datax['referenceno']),
                'template' => $this->security->xss_clean($datax['template']),
                'subject' => $this->security->xss_clean($datax['subject']),
                'meetingdate' => $this->security->xss_clean($datax['meetingdate']),
                'location' => $this->security->xss_clean($datax['location']),
                'registrationtime' => $this->security->xss_clean($datax['registrationtime']),
                'updateID' => $this->security->xss_clean($this->session->userdata('empId')),
                'updatedby' => $this->security->xss_clean($this->session->userdata('empname')),
                'updated' => $this->security->xss_clean($this->get_current_date()),
            );
        } else if ($datax['template'] == 'BM') {
            $data = array(
                'referenceno' => $this->security->xss_clean($datax['referenceno']),
                'template' => $this->security->xss_clean($datax['template']),
                'subject' => $this->security->xss_clean($datax['subject']),
                'meetingdate' => $this->security->xss_clean($datax['meetingdate']),
                'location' => $this->security->xss_clean($datax['location']),
                'agenda' => $this->security->xss_clean($datax['agenda']),
                'updateID' => $this->security->xss_clean($this->session->userdata('empId')),
                'updatedby' => $this->security->xss_clean($this->session->userdata('empname')),
                'updated' => $this->security->xss_clean($this->get_current_date()),
            );
        } else {
            $data = array(
                'referenceno' => $this->security->xss_clean($datax['referenceno']),
                'template' => $this->security->xss_clean($datax['template']),
                'subject' => $this->security->xss_clean($datax['subject']),
                'meetingdate' => $this->security->xss_clean($datax['meetingdate']),
                'reasonofcancellation' => $this->security->xss_clean($datax['reasonofcancellation']),
                'contactperson' => $this->security->xss_clean($datax['contactperson']),
                'contactno' => $this->security->xss_clean($datax['contactno']),
                'updateID' => $this->security->xss_clean($this->session->userdata('empId')),
                'updatedby' => $this->security->xss_clean($this->session->userdata('empname')),
                'updated' => $this->security->xss_clean($this->get_current_date()),
            );
        }


        return $this->db->insert(membernotices_tbl, $data);
    }

    public function removeFinalRecipient($id) {
        $this->db->where('id', $id);
        return $this->db->delete(membernotices_tbl);
    }

    function getRecipientPerAreaZone($zone) {
        $this->db->select("*")
                ->from(memberlisting_tbl)
                ->where('zone', $zone);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_recipient($recipient_number) {

        $this->db->select('*')
                ->from('membernotices')
                ->where('referenceno', $recipient_number)
                ->where("issent", 0);

        $query = $this->db->get();
        return $query->result();
    }

    /* Notice  Recipients _AreaZone
     * Alynna Pajaron
     * @version 09.16.2019
     */

    public function fetchRecipient_AreaZone() {
        $order_column = array("zone", null);

        $this->db->select("zone")
                ->from(memberlisting_tbl)
                ->group_by('zone');

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('zone', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('zone', 'ASC');
        }
    }

    function make_Recipient_AreaZone_datatables() {
        $this->fetchRecipient_AreaZone();
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_Recipient_AreaZone_filtered_data() {
        $this->fetchRecipient_AreaZone();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function fetch_Recipient_AreaZone_data() {
        $this->db->select("zone")
                ->from(memberlisting_tbl)
                ->group_by('zone')
                ->order_by('zone', 'ASC');

        return $this->db->count_all_results();
    }

    public function save_zone($zone, $description, $count) {
        if ($count == 0) {
            $data = array
                (
                'zone' => $zone,
                'description' => $description,
            );
            return $this->db->insert('zonelisting', $data);
        } else {
            return null;
        }
    }

    public function delete_zone($id) {
        $this->db->where('id', $id);
        return $this->db->delete('zonelisting');
    }

    public function delete_member($id) {
        $this->db->where('id', $id);
        return $this->db->delete(memberlisting_tbl);
    }

    public function edit_zone($id, $zone, $description, $count) {
        if ($count == 1) {
            $data = array
                (
                'zone' => $zone,
                'description' => $description,
                'updated_by' => $this->session->userdata('empname'),
                'updated' => $this->get_current_date(),
                'updated_id' => $this->session->userdata('userid'),
            );

            $this->db->where('id', $id);
            return $this->db->update('zonelisting', $data);
        } else {
            return null;
        }
    }
        
    public function edit_member($datax) {
      $data = array
                (
        'id' => $datax['id'],
       
        'membercardno' => $datax['membercardno'],
        'membersince' => $datax['membersince'],
        'name' => $datax['name'],
        'emailadd' => $datax['emailadd'],
        'bday' =>  $datax['bday'],
        'address' => $datax['address'],
        'cellphone' => $datax['cellphone'],
        'zone' =>  $datax['zone'],
        'nostocks' => $datax['nostocks'],
        'valueamount' =>  $datax['valueamount']
          );

            $this->db->where('id', $datax['id']);
            return $this->db->update(memberlisting_tbl, $data);
         
    }

    public function get_Zone($zone) {
        $this->db->select('zone')
                ->where('zone', $zone)
                ->from('zonelisting');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function AddAllMembers() {
        $this->db->select("*")
                ->from(memberlisting_tbl)
                ->where('active', '1');
        $query = $this->db->get();
        return $query->result_array();
    }

    /* Fetch All Announcements
     * Alynna Pajaron
     * @version 09.16.2019
     */

    public function fetchAllAnnouncements() {
        $order_column = array("referenceno", "template", "subject", "meetingdate", "location", null, null, null, null);

        $this->db->select("*")
                ->from(membernotices_tbl)
                ->group_by('referenceno');

        if (!empty($this->input->post("search")["value"])) {
            $this->db->group_start()
                    ->like('referenceno', $this->input->post("search")["value"])
                    ->or_like('template', $this->input->post("search")["value"])
                    ->or_like('subject', $this->input->post("search")["value"])
                    ->or_like('meetingdate', $this->input->post("search")["value"])
                    ->or_like('location', $this->input->post("search")["value"])
                    ->group_end();
        }

        if (!empty($this->input->post("order"))) {
            $this->db->order_by($order_column[$this->input->post("order")['0']['column']], $this->input->post("order")['0']['dir']);
        } else {
            $this->db->order_by('status', 'ASC')
                     ->order_by('updated', 'DESC');
        }
    }

    function make_AllAnnouncements_datatables() {
        $this->fetchAllAnnouncements();
        if ($this->input->post("length") != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_AllAnnouncements_filtered_data() {
        $this->fetchAllAnnouncements();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function fetch_AllAnnouncements_data() {
        $this->db->select("*")
                ->from(membernotices_tbl)
                ->group_by('referenceno')
                ->order_by('status', 'ASC')
                ->order_by('updated', 'DESC');

        return $this->db->count_all_results();
    }

    public function setAnnouncementToInactive($referenceno) {
        $data = array(
            'status' => $this->security->xss_clean('1'),
            'statusbyID' => $this->security->xss_clean($this->session->userdata('empId')),
            'statusby' => $this->security->xss_clean($this->session->userdata('empname')),
            'statusDate' => $this->security->xss_clean($this->get_current_date()),
        );

        $this->db->where('referenceno', $this->security->xss_clean($referenceno));
        return $this->db->update(membernotices_tbl, $data);
    }

    public function insert_message_applicant($message, $cellphone, $station, $transaction) {
        $data = array
            (
            'Datelog' => $this->security->xss_clean($this->get_current_date()),
            'Message' => $this->security->xss_clean($message),
            'Status' => $this->security->xss_clean('0'),
            'Number' => $this->security->xss_clean($cellphone),
            'userid' => $this->security->xss_clean($this->session->userdata('hubuserPasscode')),
            'station' => $this->security->xss_clean($station),
            'transaction' => $this->security->xss_clean($transaction),
        );
        return $this->messaging_db->insert('tb_text', $data);
    }

    public function updateAnnouncement($datax) {
        if ($datax['template'] == 'Annual') {
            $data = array(
                'referenceno' => $this->security->xss_clean($datax['referenceno']),
                'template' => $this->security->xss_clean($datax['template']),
                'subject' => $this->security->xss_clean($datax['subject']),
                'meetingdate' => $this->security->xss_clean($datax['meetingdate']),
                'location' => $this->security->xss_clean($datax['location']),
                'registrationtime' => $this->security->xss_clean($datax['registrationtime']),
                'issent' => $this->security->xss_clean('0'),
                'updateID' => $this->security->xss_clean($this->session->userdata('empId')),
                'updatedby' => $this->security->xss_clean($this->session->userdata('empname')),
                'updated' => $this->security->xss_clean($this->get_current_date()),
            );
        } else if ($datax['template'] == 'BM') {
            $data = array(
                'referenceno' => $this->security->xss_clean($datax['referenceno']),
                'template' => $this->security->xss_clean($datax['template']),
                'subject' => $this->security->xss_clean($datax['subject']),
                'meetingdate' => $this->security->xss_clean($datax['meetingdate']),
                'location' => $this->security->xss_clean($datax['location']),
                'agenda' => $this->security->xss_clean($datax['agenda']),
                'issent' => $this->security->xss_clean('0'),
                'updateID' => $this->security->xss_clean($this->session->userdata('empId')),
                'updatedby' => $this->security->xss_clean($this->session->userdata('empname')),
                'updated' => $this->security->xss_clean($this->get_current_date()),
            );
        } else {
            $data = array(
                'referenceno' => $this->security->xss_clean($datax['referenceno']),
                'template' => $this->security->xss_clean($datax['template']),
                'subject' => $this->security->xss_clean($datax['subject']),
                'meetingdate' => $this->security->xss_clean($datax['meetingdate']),
                'reasonofcancellation' => $this->security->xss_clean($datax['reasonofcancellation']),
                'contactperson' => $this->security->xss_clean($datax['contactperson']),
                'contactno' => $this->security->xss_clean($datax['contactno']),
                'issent' => $this->security->xss_clean('0'),
                'updateID' => $this->security->xss_clean($this->session->userdata('empId')),
                'updatedby' => $this->security->xss_clean($this->session->userdata('empname')),
                'updated' => $this->security->xss_clean($this->get_current_date()),
            );
        }

        $this->db->where('referenceno', $this->security->xss_clean($datax['referenceno']));
        return $this->db->update(membernotices_tbl, $data);
    }

    public function update_meeting($type, $id) {

        $data = array(
            'issent' => $this->security->xss_clean('1'),
            'sentid' => $this->security->xss_clean($this->session->userdata('empId')),
            'sentby' => $this->security->xss_clean($this->session->userdata('empname')),
            'sentdate' => $this->security->xss_clean($this->get_current_date()),
            'type' => $this->security->xss_clean($type),
        );

        $this->db->where('id', $id);
        return $this->db->update(membernotices_tbl, $data);
    }

}
