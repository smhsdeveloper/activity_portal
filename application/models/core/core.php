<?php

class core extends CI_Model {

    public function GetAllSection() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,standard,section');
        $dbObj->where('status', '1');
        $dbObj->order_by('order');
        return $dbObj->get("section_list")->result_array();
    }

    public function GetAllStudent($section_id) {

        if ($section_id == "ALL") {
            $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
            $dbObj->select('adm_no, adm_no_display, firstname, lastname, sex, dob_date, ad_date, address1, city, state, pin_code, section_id,profile_pic_path_thumbnail, roll_no');
            return $dbObj->get("biodata")->result_array();
        } else {
            $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
            $dbObj->select('adm_no, adm_no_display, firstname, lastname, sex, dob_date, ad_date, address1, city, state, pin_code,profile_pic_path_thumbnail, section_id, roll_no');
            return $dbObj->get_where('biodata', array('section_id' => $section_id))->result_array();
        }
    }

    public function getClassList($cce = 'ALL') {

        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        if ($cce == 'ALL') {
            
        } else {
            $dbObj->where('cce_applicable', $cce);
        }
        $dbObj->order_by('order_by');
        return $dbObj->get("master_class_list")->result_array();
    }

    public function getSectionlist() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('status', '1');
        $dbObj->order_by('order');
        return $dbObj->get("section_list")->result_array();
    }

    public function GetStandardFromSection_id($Section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $str = "SELECT standard FROM section_list WHERE id=" . $Section_id;
        $query = $dbObj->query($str)->result_array();
        $standard = $query[0]['standard'];
        return $standard;
    }

    public function getSectionlistfromclass($class) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('standard', $class);
        $dbObj->where('status', '1');
        $dbObj->order_by('order');
        return $dbObj->get("section_list")->result_array();
    }
    public function getstaffsubjectlist($staff_id) {
        $dbObj = $this->load->database($this->session->userdata('database'),TRUE);
        $str = "SELECT a.`section_id`,a.`subject_id`,concat( b.`standard`,' ',b.`section`) as class, c.subject_name as subject FROM `subject_staff_relation` as a,section_list as b, subject_list as c WHERE a.section_id=b.id and c.id=a.subject_id and a.staff_id=" . $staff_id . " AND b.status=1";
        //echo $str;exit;
        $objstddata = $dbObj->query($str)->result_array();
        return $objstddata;
    }

    public function getpermission($pageUrl, $emp_id) {
        $this->db->select('*');
        $this->db->from('child_main_menu_relation as a');
        $this->db->join('emp_menu_relation as b', 'a.id = b.menu_id', 'left');
        $this->db->where(array('a.url' => $pageUrl));
        $this->db->where(array('b.emp_id' => $emp_id));
        $result = $this->db->get()->row_array();
        if (!empty($result)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
