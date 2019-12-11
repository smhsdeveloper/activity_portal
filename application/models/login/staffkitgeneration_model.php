<?php

class Staffkitgeneration_model extends CI_Model {

    public function GetSystemUserDetails($id) {
        $this->db->select('id,usrname,pass,password_reset,login_activated,date(register_date) as register_date');
        $this->db->from('system_users');
        $this->db->where('school_code', 'TESTDB');
        $this->db->where('member_type', 'STAFF');
        $this->db->where('staff_id', $id);
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

    public function SaveGeneratedKit($id) {
        $uname = random_string('numeric', 8);
        $password = random_string('numeric', 8);
        $resultValidateUname = $this->ValidateUserName($uname);
        $arrSysUser = array("staff_id" => $id, "usrname" => $resultValidateUname, "pass" => $password, "school_code" => 'TESTDB', "member_type" => 'STAFF');
        $this->db->insert('system_users', $arrSysUser);
      }
    
    public function GetAllStaff() {
            $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
            $dbObj->select('id,staff_fname,staff_lname,profile_pic_path,profile_pic_path_thumbnail,mobile_no_for_sms');
            return $dbObj->get_where('staff_details')->result_array();
  
    }
    public function CountLogin($user_id) {
            $this->db->select('count(id) as count_login');
            return $this->db->get_where('user_login_logs', array('user_id' => $user_id))->result_array();
  
    }
     public function GetFinalSystemUserDetails() {
        $result_staff = $this->GetAllStaff();
        $arrGeneratedStaff = array();
        $arrNonGeneratedStaff = array();
        foreach ($result_staff as $value) {
            $TempResult = $this->GetSystemUserDetails($value['id']);
            if (!empty($TempResult)) {
                $arrCountLogin1=$this->CountLogin($value['id']);
                $arrGeneratedStaff[] = array("selected" => 'NO', "id" => $TempResult[0]['id'],"password_reset"=>$TempResult[0]['password_reset'],"photo" => $value['profile_pic_path_thumbnail'],"mobile"=>$value['mobile_no_for_sms'], "staff_id" => $value['id'], "name" => $value['staff_fname'] . ' ' . $value['staff_lname'],"username" => $TempResult[0]['usrname'],"password" => $TempResult[0]['pass'], "register_date" => $TempResult[0]['register_date'], "login_activated" => $TempResult[0]['login_activated'],"count_login"=>$arrCountLogin1[0]['count_login']);
            } else {

                $pwd = random_string('numeric', 6);
                $this->SaveGeneratedKit($value['id']);
                $TempArr = $this->GetSystemUserDetails($value['id']);
                $arrCountLogin2=$this->CountLogin($value['id']);
                $arrNonGeneratedStaff[] = array("selected" => 'YES', "id" => $TempArr[0]['id'],"password_reset"=>$TempArr[0]['password_reset'], "photo" => $value['profile_pic_path_thumbnail'],"mobile"=>$value['mobile_no_for_sms'], "staff_id" => $value['id'], "name" => $value['staff_fname'] . ' ' . $value['staff_lname'],"username" => $TempArr[0]['usrname'],"password" => $TempArr[0]['pass'], "register_date" => $TempArr[0]['register_date'], "login_activated" => $TempArr[0]['login_activated'],"count_login"=>$arrCountLogin2[0]['count_login']);
            }
        }
        $finalResult = array_merge($arrNonGeneratedStaff, $arrGeneratedStaff);
        return $finalResult;
    }


}
