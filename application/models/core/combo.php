<?php

class combo extends CI_Model {

    public function getComboName($combo_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $str = "SELECT combo_name FROM combo_details WHERE id=" . $combo_id;
        $query = $dbObj->query($str);
        return $query->result_array();
    }

    public function getComboSubjects($combo_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('subject_id');
        $dbObj->where('combo_id', $combo_id);
        $combosubjects = $dbObj->get("combo_subject_relation")->result_array();
        $blankarray = array();
        foreach ($combosubjects as $value) {
            $blankarray[] = $value['subject_id'];
        }
        return $blankarray;
    }

    public function getClassSubjects($class) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('class_name', $class);
        return $dbObj->get("subject_list")->result_array();
    }

    public function getcombosinclass($class) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->where('class_name', $class);
        return $dbObj->get("combo_details")->result_array();
    }

    public function getcombosinsection($sec_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('combo_id');
        $dbObj->where('section_id', $sec_id);
        $comboinclass = $dbObj->get("combo_section_relation")->result_array();
        $blankarray = array();
        foreach ($comboinclass as $value) {
            $blankarray[] = $value['combo_id'];
        }
        return $blankarray;
    }

    public function savecombodata($jsondata) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $input = json_decode($jsondata, TRUE);

        $combo_id = $input['combo_id'];

        $dbObj->where('combo_id', $combo_id);
        $dbObj->delete('combo_subject_relation');

        $data_insert = array();
        foreach ($input['sub_id'] as $val) {
            $data_insert[] = array(
                'combo_id' => $combo_id,
                'subject_id' => $val,
            );
        }
        $dbObj->insert_batch('combo_subject_relation', $data_insert);
        return "TRUE";
    }

    public function combosectionsave($jsondata) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $input = json_decode($jsondata, TRUE);
        $section_id = $input['section_id'];

        $dbObj->where('section_id', $section_id);
        $dbObj->delete('combo_section_relation');

        $data_insert = array();
        foreach ($input['combo_id'] as $val) {
            $data_insert[] = array(
                'combo_id' => $val,
                'section_id' => $section_id,
            );
        }
        $dbObj->insert_batch('combo_section_relation', $data_insert);
        return "TRUE";
    }

}
