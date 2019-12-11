<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class email_model extends CI_Model {

    public function fetchrmlist() {
        $date = date('Y-m-d');
        $categories = array('RM', 'ADMIN');
        $id_not = array("1", "7");
        $this->db->select('id,name');
        $this->db->from('company_staff_details');
        $this->db->where_in("admin_type", $categories);
        $this->db->where_in("active_status", 'WORKING');
        $this->db->order_by("name", "asc");
        $emplist = $this->db->get()->result_array();
        $finalArray = array();
        for ($a = 0; $a < count($emplist); $a++) {
            $rm_id = $emplist[$a]['id'];
            $rmemailstatus = $this->getRmmailDetails($rm_id);
            if (empty($rmemailstatus)) {
                $finalArray[] = $emplist[$a];
            } else {
                $finalArray = array();
            }
        }
        return $finalArray;
    }

    public function getRmmailDetails($id) {
        $date = date('Y-m-d');
        $this->db->select('id');
        $this->db->from('rm_email_details');
        $this->db->where("date", $date);
        $this->db->where("rm_id", $id);
        $rmemail = $this->db->get()->row_array();
        return $rmemail;
    }

}
