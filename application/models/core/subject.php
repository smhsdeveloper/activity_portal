<?php

class subject extends CI_Model {

    public function fillSubjectTeacherMasterData($section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('core/core', 'xx');
        $standard = $this->xx->GetStandardfromsection_id($section_id);
      
        $subjectid_stan = array();
        $subjectid_stan = $this->getSubjectidfrom_standard($standard);
    
        foreach ($subjectid_stan as $val) {
            $subject_id = $val;
            $resultt = $this->check_sujectid_sectionid_found($subject_id, $section_id);
            if ($resultt == 'NO') {
                $this->insert_sujectid_sectionid($subject_id, $section_id);
            }
        }
    }
    //not in use. 
   public function MasterSubjectTeacherEntry($section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->distinct();
        $dbObj->select('subject_list.id as sub_id');
        $dbObj->from('subject_list');
        $dbObj->join('combo_subject_relation', 'subject_list.id=combo_subject_relation.subject_id');
        $dbObj->join('combo_section_relation', 'combo_subject_relation.combo_id=combo_section_relation.combo_id');
        $dbObj->where('combo_section_relation.section_id', $section_id);
        $subjectList = $dbObj->get()->result_array();
        for ($i = 0; $i < count($subjectList); $i++) {
            $dbObj->select('staff_id');
            $result = $dbObj->get_where('subject_staff_relation', array('section_id' => $section_id, 'subject_id' => $subjectList[$i]['sub_id']))->result_array();
            if (!empty($result)) {
                
            } else {
                $arrInput = array('subject_id' => $subjectList[$i]['sub_id'], 'section_id' => $section_id, 'staff_id' => -1);
                $dbObj->insert('subject_staff_relation', $arrInput);
                return $dbObj->insert_id();
            }
        }
    }

    public function insert_sujectid_sectionid($subject_id, $section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data = array(
            'section_id' => $section_id,
            'subject_id' => $subject_id,
            'staff_id' => '-1',
            'deo_entry_by' => $this->session->userdata('deo_staff_id'),
            'entry_by' => $this->session->userdata('staff_id')
        );
        $dbObj->insert('subject_staff_relation', $data);
    }

    public function check_sujectid_sectionid_found($subject_id, $section_id) {
        $output = 'YES';
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $str = "SELECT subject_id FROM subject_staff_relation section_list WHERE section_id=" . $section_id . ' AND subject_id=' . $subject_id;
        $query = $dbObj->query($str)->result_array();
        if (count($query) == 0) {
            $output = 'NO';
        } else {
            $output = 'YES';
        }
        return $output;
    }

    public function getSubjectidfrom_standard($standard) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id');
        $dbObj->where('class_name', $standard);
        $subjectinclass = $dbObj->get("subject_list")->result_array();
        $blankarray = array();
        foreach ($subjectinclass as $value) {
            $blankarray[] = $value['id'];
        }
        return $blankarray;
    }

}
