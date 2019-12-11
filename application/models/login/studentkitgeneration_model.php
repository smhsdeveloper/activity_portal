<?php

class Studentkitgeneration_model extends CI_Model {

    public function GetSystemUserDetails($adm_no) {
        $school_code=$this->session->userdata('school_code');
        
        $this->db->select('a.id,a.usrname,a.pass,a.password_reset,a.login_activated,date(a.register_date) as register_date');
        $this->db->from('system_users a');
        $this->db->join('user_std_relation b', 'a.id = b.user_id');
        $this->db->where('b.school_code', $school_code);
        $this->db->where('a.member_type', 'PARENT');
        $this->db->where('b.adm_no', $adm_no);
        $myTempCt = $this->db->get()->result_array();
        return $myTempCt;
    }

    public function GetALLSystemUserDetails($id) {
        $this->db->select('login_activated,password_reset');
        $this->db->from('system_users');
        $this->db->where('id', $id);
        $queryresult = $this->db->get()->result_array();
        return $queryresult;
    }

    public function UpdatePassword($myArr) {
        $resultSysDetail = $this->GetALLSystemUserDetails($myArr['id']);
        if($resultSysDetail[0]['password_reset'] == 'NO'){
        $resetPwd = random_string('numeric', 8);
        $arrUpdatePwd = array("pass" => $resetPwd, "password_reset" => 'YES');
        $this->db->where('id', $myArr['id']);
        $this->db->update('system_users', $arrUpdatePwd);
        if ($this->db->affected_rows() > 0) {
                return 'YES';
            } else {
                 return 'NO';
            }
       
        }
        
    }

    public function UpdateLoginStatusModel($myArr) {
        $resultSysDetail = $this->GetALLSystemUserDetails($myArr['id']);
        if ($resultSysDetail[0]['login_activated'] == 'YES') {
            $arrUpdateStatus = array("login_activated" => 'NO');
            $this->db->where('id', $myArr['id']);
            $this->db->update('system_users', $arrUpdateStatus);
            return 'NO';
        } else {
            $arrUpdateStatus = array("login_activated" => 'YES');
            $this->db->where('id', $myArr['id']);
            $this->db->update('system_users', $arrUpdateStatus);
            return 'YES';
        }
    }

    public function ValidateUserName($uname) {
        aa:
        $query = $this->db->get_where('system_users', array('usrname' => $uname))->result_array();
        if (!empty($query)) {
            $uname = random_string('numeric', 8);
            goto aa;
        } else {
            return $uname;
        }
    }

    public function SaveGeneratedKit($adm_no) {
        $school_code=$this->session->userdata('school_code');
                
        $uname = random_string('numeric', 8);
        $password = random_string('numeric', 8);
        $resultValidateUname = $this->ValidateUserName($uname);
        $arrSysUser = array("staff_id" => -1, "usrname" => $resultValidateUname, "pass" => $password, "school_code" =>  $school_code, "member_type" => 'PARENT',"register_date"=>date("Y/m/d"));
        $this->db->insert('system_users', $arrSysUser);
        $user_id = $this->db->insert_id();
        $arrUserStdRelation = array("user_id" => $user_id, "adm_no" => $adm_no, "school_code" => $school_code);
        $this->db->insert('user_std_relation', $arrUserStdRelation);
         
    }
    
    public function GetAllStudent($section_id) {
            $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
            $dbObj->select('adm_no, adm_no_display, firstname, lastname,mobile_no_for_sms, sex, dob_date, ad_date, address1, city, state, pin_code,profile_pic_path_thumbnail, section_id, roll_no');
            return $dbObj->get_where('biodata', array('section_id' => $section_id))->result_array();
  
    }
    public function CountLogin($user_id) {
            $this->db->select('count(id) as count_login');
            return $this->db->get_where('user_login_logs', array('user_id' => $user_id))->result_array();
  
    }

    public function GetFinalSystemUserDetails($section_id) {
        $result_student = $this->GetAllStudent($section_id);
        $arrGeneratedStudent = array();
        $arrNonGeneratedStudent = array();

        foreach ($result_student as $value) {
            $TempResult = $this->GetSystemUserDetails($value['adm_no']);
            if (!empty($TempResult)) {
                $arrCountLogin1=$this->CountLogin($TempResult[0]['id']);
                $arrGeneratedStudent[] = array("selected" => 'NO', "id" => $TempResult[0]['id'],"password_reset"=>$TempResult[0]['password_reset'],"photo" => $value['profile_pic_path_thumbnail'],"mobile"=>$value['mobile_no_for_sms'], "adm_no" => $value['adm_no'], "name" => $value['firstname'] . ' ' . $value['lastname'],"username" => $TempResult[0]['usrname'],"password" => $TempResult[0]['pass'], "register_date" => $TempResult[0]['register_date'], "login_activated" => $TempResult[0]['login_activated'],"count_login"=>$arrCountLogin1[0]['count_login']);
            } else {

                $pwd = random_string('numeric', 6);
                $this->SaveGeneratedKit($value['adm_no']);
     
                $TempArr = $this->GetSystemUserDetails($value['adm_no']);
                $arrCountLogin2=$this->CountLogin($TempArr[0]['id']);
                $arrNonGeneratedStudent[] = array("selected" => 'YES', "id" => $TempArr[0]['id'],"password_reset"=>$TempArr[0]['password_reset'], "photo" => $value['profile_pic_path_thumbnail'],"mobile"=>$value['mobile_no_for_sms'], "adm_no" => $value['adm_no'], "name" => $value['firstname'] . ' ' . $value['lastname'],"username" => $TempArr[0]['usrname'],"password" => $TempArr[0]['pass'],"register_date" => $TempArr[0]['register_date'], "login_activated" => $TempArr[0]['login_activated'],"count_login"=>$arrCountLogin2[0]['count_login']);
            }
        }
        $finalResult = array_merge($arrNonGeneratedStudent, $arrGeneratedStudent);
        return $finalResult;
    }
    
    public function SendSmsDetailsModel() {
     echo "hello";
    }

}
