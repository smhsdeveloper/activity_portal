<?php

class deo_model extends CI_Model {

    public function GetAllStaffData() {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id,staff_fname,staff_lname');
        $staffDetails = $dbObj->get_where('staff_details', array("show_in_portal" => 'YES'))->result_array();
        for ($i = 0; $i < count($staffDetails); $i++) {
            $staff_id = $staffDetails[$i]['id'];
            $userId = $this->GetUserId($staff_id);
            $classTeacher = $this->GetClassTeacherStatus($staff_id);
            $subjectList = $this->GetTeacherSubjectList($staff_id);
            $staffDetails[$i]['classTeacher'] = $classTeacher;
            $staffDetails[$i]['subjectList'] = $subjectList;
            $staffDetails[$i]['user_id']=$userId;
        }
        return $staffDetails;
    }

    public function GetClassTeacherStatus($staff_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('section,standard');
        $classTeacher = $dbObj->get_where('section_list', array("class_teacher_id" => $staff_id))->result_array();
        if (!empty($classTeacher)) {
            $classTeacher = $classTeacher[0]['standard'] . $classTeacher[0]['section'];
            return $classTeacher;
        } else {
            return "-";
        }
    }

    public function GetTeacherSubjectList($staff_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.subject_name,c.section,c.standard');
        $dbObj->from('subject_list as a');
        $dbObj->join('subject_staff_relation as b', 'a.id=b.subject_id');
        $dbObj->join('section_list as c', 'b.section_id=c.id');
        $dbObj->where('b.staff_id', $staff_id);
        $subjectList = $dbObj->get()->result_array();
        if (!empty($subjectList)) {
            $arrTemp = array();
            foreach ($subjectList as $row) {
                $arrTemp[] = $row['subject_name'] . ' ' . $row['standard'] . $row['section'];
            }
            $string = implode(',', $arrTemp);
            return $string;
        } else {
            return "No Subject Assign Yet";
        }
    }

    public function GetUserId($staff_id) {
        $loginType = $this->session->userdata('logintype');
        $school_code = $this->session->userdata('school_code');
        $this->db->select('id');
        $user_id = $this->db->get_where('system_users', array('staff_id' => $staff_id, 'school_code' => $school_code, 'member_type' => $loginType))->row_array();
        if (!empty($user_id)) {
            return $user_id['id'];
        } else {
            return -1;
        }
    }
       public function GetDeoUserId($staff_id, $school_code, $login_type) {
        $this->db->select('id');
           if ($login_type == 'COMPANY') {
           $user_id = $this->db->get_where('system_users', array('staff_id' => $staff_id, 'member_type' => $login_type))->row_array();
        } else {
            $user_id = $this->db->get_where('system_users', array('staff_id' => $staff_id, 'school_code' => $school_code, 'member_type' => $login_type))->row_array();
           }
        if (!empty($user_id)) {
            return $user_id['id'];
        } else {
            return -1;
        }
    }

}
