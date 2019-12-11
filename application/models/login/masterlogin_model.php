<?php

class masterlogin_model extends CI_Model {

    public function GetAllSchoolList() {
        $this->db->select('id,school_code,school_name');
        $schoolList = $this->db->get('school_list')->result_array();
        if (!empty($schoolList)) {
            return $schoolList;
        } else {
            return -1;
        }
    }

    Public function GetSchoolData($userId) {
        include(APPPATH . 'config/database' . EXT);
        $this->db->select('id,staff_id,usrname,school_code,member_type');
        $userdata = $this->db->get_where('system_users', array('id' => $userId))->row_array();
        $schoolDeatil = $this->db->get_where('school_list', array('school_code' => $userdata['school_code']))->row_array();
        if (!empty($userdata)) {
            $schoolDb = $this->db->get_where('school_db_year_wise', array("school_code" => $userdata['school_code'], "current_db" => "YES"))->row_array();
            $dynamicDb = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $schoolDb['db_name'];
            if ($userdata['member_type'] == 'STAFF') {

                $staff_details = $this->GetStaffDeatils($userdata['staff_id'], $dynamicDb);
                $staff_details[0]['userid'] = $userId;
                $staff_details[0]['username'] = $userdata['usrname'];
                $staff_details[0]['type'] = 'STAFF';
                $staff_details[0]['schoolId'] = $schoolDeatil['id'];
                return $staff_details;
            } else if ($userdata['member_type'] == 'PARENT') {
                $student_details = $this->GetStudentDetails($userId, $dynamicDb, $userdata['school_code'], $userdata['usrname'], $schoolDeatil['id']);
                return $student_details;
            } else {
                return "Wrong User";
            }
        } else {
            return -1;
        }
    }

    public function GetStaffDeatils($staff_id, $dynamicDb) {
        $dbObj = $this->load->database($dynamicDb, TRUE);
        $dbObj->select('a.staff_fname as firstname,a.staff_lname as lastname,a.mobile_no_for_sms as mobile,a.e_mail,b.section,b.standard');
        $dbObj->from('staff_details as a');
        $dbObj->join('section_list as b', 'a.id=b.class_teacher_id');
        $dbObj->where('a.id', $staff_id);
        $dbObj->where('a.show_in_portal', 'YES');
        $staffRecord = $dbObj->get()->result_array();
        if (!empty($staffRecord)) {
            return $staffRecord;
        } else {
            return -1;
        }
    }

    public function GetStudentDetails($userId, $dynamicDb, $school_code, $username, $schoolId) {
        $dbObj = $this->load->database($dynamicDb, TRUE);
        $this->db->select('adm_no');
        $adm_no_list = $this->db->get_where('user_std_relation', array('user_id' => $userId, 'school_code' => $school_code))->result_array();
        $studentList = array();
        if (!empty($adm_no_list)) {
            for ($i = 0; $i < count($adm_no_list); $i++) {
                $dbObj->select('a.adm_no,a.firstname,a.lastname,a.mobile_no_for_sms as mobile,d.staff_fname,d.staff_lname');
                $dbObj->from('biodata as a');
                $dbObj->join('section_list as c', 'a.section_id=c.id');
                $dbObj->join('staff_details as d', 'c.class_teacher_id=d.id');
                $dbObj->where('a.adm_no', $adm_no_list[$i]['adm_no']);
                $studentRecord = $dbObj->get()->row_array();
                $gaurdianName = $this->GetGaurdianDetails($adm_no, $dynamicDb);
                $studentRecord['g_name'] = $gaurdianName;
                $studentRecord['userid'] = $userId;
                $studentRecord['username'] = $username;
                $studentRecord['schoolId'] = $schoolId;
                $studentRecord['type'] = 'PARENT';
                $studentList[] = $studentRecord;
            }
            return $studentList;
        } else {
            return -1;
        }
    }

    public function GetGaurdianDetails($adm_no, $dynamicDb) {
        $dbObj = $this->load->database($dynamicDb, TRUE);
        $dbObj->select('g_name');
        $gaurdianName = $dbObj->get_where('gaurdian_details', array('adm_no' => $adm_no))->row_array();
        if (!empty($gaurdianName)) {
            return $gaurdianName['g_name'];
        } else {
            return 'No  Record';
        }
    }

    public function GetUserIdForRequest($data, $schoolId, $mytype) {
        include(APPPATH . 'config/database' . EXT);
        $schoolDetail = $this->db->get_where('school_list', array('id' => $schoolId))->row_array();
        $dbName = $this->db->get_where('school_db_year_wise', array('school_code' => $schoolDetail['school_code'], "current_db" => "YES"))->row_array();
        $dynamicDb = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $dbName['db_name'];
        $dbObj = $this->load->database($dynamicDb, TRUE);
        if (strtoupper(trim($mytype)) == 'STAFF') {
            $dbObj->select('id,staff_fname as firstname,staff_lname as lastname');
            $dbObj->like('staff_fname', $data);
            $result = $dbObj->get('staff_details')->result_array();
            if (!empty($result)) {
                for ($i = 0; $i < count($result); $i++) {
                    $this->db->select('id');
                    $myUserId = $this->db->get_where('system_users', array('staff_id' => $result[$i]['id'], 'school_code' => $schoolDetail['school_code'], 'member_type' => $mytype))->row_array();
                    $result[$i]['userid'] = $myUserId['id'];
                }
            }
            return $result;
        } else if (strtoupper(trim($mytype)) == 'PARENT') {
            $dbObj->select('adm_no as id,firstname,lastname');
            $dbObj->like('firstname', $data);
            $result = $dbObj->get('biodata')->result_array();
            if (!empty($result)) {
                for ($i = 0; $i < count($result); $i++) {
                    $this->db->select('user_id');
                    $myUserId = $this->db->get_where('user_std_relation', array('adm_no' => $result[$i]['id'], 'school_code' => $schoolDetail['school_code']))->row_array();
                    if ($myUserId['user_id'] != null) {
                        $result[$i]['userid'] = $myUserId['user_id'];
                    } else {
                        $result[$i]['userid'] = '-';
                    }
                }
            }
            return $result;
        } else {
            return 'baba ji ka thulu';
        }
    }

}
