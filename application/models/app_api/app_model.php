<?php

class app_model extends CI_Model {

    public function registration($data) {
        if (count($data) == 8 && isset($data['device_name']) && isset($data['device_version']) && isset($data['device_uuid']) && isset($data['device_company']) && isset($data['device_width']) && isset($data['device_height']) && isset($data['device_platform']) && isset($data['device_colordepth'])) {
            $this->db->select("device_uuid");
            $avail = $this->db->get_where("app_device_registration_details", array("device_uuid" => $data['device_uuid']))->row_array();
            if (empty($avail)) {
                $ins = $this->db->insert("app_device_registration_details", $data);
                if ($ins) {
                    return '{"type":"TRUE","message":"Device Registered Successfully","result":"TRUE","value":"1"}';
                } else {
                    return '{"type":"FALSE","message":"Device not register Please contact to Admin","result":"ERROR","value":"0"}';
                }
            } else {
                return '{"type":"TRUE","message":"Device already Register","result":"TRUE","value":"1"}';
            }
        } else {
            return '{"type":"FALSE","message":"Invalid parameter supplied","result":"ERROR","value":"0"}';
        }
    }

    public function login($data) {
        if (count($data) == 3 && isset($data['username']) && isset($data['password']) && isset($data['device_uuid'])) {
            $valid_device = $this->db->get_where("app_device_registration_details", array("device_uuid" => $data['device_uuid']))->row_array();
            if (empty($valid_device)) {
                return '{"type":"FALSE","message":"Device Not Registered.","result":"ERROR","value":"0"}';
            } else {
                $result = $this->db->get_where('system_users', array('usrname' => $data['username'], 'pass' => $data['password']))->row_array();
                if (isset($result['id']) && $result['member_type'] == 'COMPANY') {
                    if ($result['login_activated'] == 'YES') {
                        if ($result['password_reset'] == 'NO') {
                            $companyStaffDetail = $this->db->get_where('company_staff_details', array("id" => $result['staff_id']))->row_array();
                            $access_key = substr(base64_encode(rand(pow(10, 9), pow(10, 10))), 0, 10);
                            $valid_key = $this->db->get_where("app_login_log", array("access_key" => $access_key))->row_array();
                            while (!empty($valid_key)) {
                                $access_key = substr(base64_encode(rand(pow(10, 9), pow(10, 10))), 0, 10);
                                $valid_key = $this->db->get_where("app_login_log", array("access_key" => $access_key))->row_array();
                            }
                            $this->db->update("app_login_log", array("is_true" => "FALSE"), array("company_staff_id" => $result['staff_id']));
                            $log = array(
                                'user_id' => $result['id'],
                                "logintype" => "COMPANY",
                                "company_staff_id" => $result['staff_id'],
                                "workinghrs" => '8',
                                "staff_rm_id" => $companyStaffDetail['rm_id'],
                                "admin_type" => $companyStaffDetail['admin_type'],
                                "company_staff_name" => $companyStaffDetail['name'],
                                "company_staff_designation" => $companyStaffDetail['designation'],
                                'login_person' => "USER",
                                'ip_info' => $_SERVER['REMOTE_ADDR'],
                                'browser_info' => $_SERVER['HTTP_USER_AGENT'],
                                'device_uuid' => $data['device_uuid'],
                                'access_key' => $access_key,
                                'is_true' => "TRUE"
                            );
                            $this->db->insert("app_login_log", $log);
                            $data = array(
                                "logintype" => "COMPANY",
                                "company_staff_id" => $result['staff_id'],
                                "user_id" => $result['id'],
                                "workinghrs" => '8',
                                "staff_rm_id" => $companyStaffDetail['rm_id'],
                                "admin_type" => $companyStaffDetail['admin_type'],
                                "company_staff_name" => $companyStaffDetail['name'],
                                "company_staff_designation" => $companyStaffDetail['designation'],
                                'access_key' => $access_key
                            );
                            return json_encode(array(
                                "type" => "TRUE",
                                "message" => "Login Success.",
                                "result" => "TRUE",
                                "value" => $data
                            ));
                        } else {
                            return '{"type":"FALSE","message":"Your Account password is reset by Administrator. You must change your passowrd and proceed.","result":"ERROR","value":"0"}';
                        }
                    } else {
                        return '{"type":"FALSE","message":"Your acoount is not activated. Please contact administrator.","result":"ERROR","value":"0"}';
                    }
                } else {
                    return '{"type":"FALSE","message":"Invalid username and password.","result":"ERROR","value":"0"}';
                }
            }
        } else {
            return '{"type":"FALSE","message":"Invalid parameter supplied.","result":"ERROR","value":"0"}';
        }
    }

    public function getLoginInfo($accessKey) {
        $loginInfo = $this->db->get_where("app_login_log", array("access_key" => $accessKey, "is_true" => "TRUE"))->row_array();
        return empty($loginInfo) ? FALSE : $loginInfo;
    }

    public function validateOTP($otp, $staff_id) {
        $today = date("Y-m-d");
        $result = $this->db->get_where('otp_sms_validation_details', array('staff_id' => $staff_id, 'otp_date' => $today, 'otp' => $otp))->row_array();
        if (!empty($result)) {
            if ($result['otp_validation'] == "YES") {
                return '{"type":"TRUE","message":"OTP already validated.","result":"TRUE","value":"1"}';
            } else {
                $update = $this->db->update('otp_sms_validation_details', array("otp_validation" => 'YES'), array("id" => $result['id']));
                if ($update) {
                    return '{"type":"TRUE","message":"OTP validated successfully.","result":"TRUE","value":"1"}';
                } else {
                    return '{"type":"FALSE","message":"An unknown error occured.","result":"ERROR","value":"0"}';
                }
            }
        } else {
            return '{"type":"FALSE","message":"Invalid OTP.","result":"ERROR","value":"0"}';
        }
    }

    public function getProjectList() {
        $this->db->select("id,title");
        $data = $this->db->get("test_project_details")->result_array();
        if (empty($data)) {
            return '{"type":"FALSE","message":"Unable to fetch product list.","result":"ERROR","value":"0"}';
        } else {
            return json_encode(array(
                "type" => "TRUE",
                "message" => "",
                "result" => "TRUE",
                "value" => $data
            ));
        }
    }

    public function getActivityList() {
        $this->db->select("id,activity_name");
        $data = $this->db->get("acr_activity_master_list")->result_array();
        if (empty($data)) {
            return '{"type":"FALSE","message":"Unable to fetch activity list.","result":"ERROR","value":"0"}';
        } else {
            return json_encode(array(
                "type" => "TRUE",
                "message" => "",
                "result" => "TRUE",
                "value" => $data
            ));
        }
    }

    public function getModuleList($project_id) {
        $prj_Exist = $this->db->get_where("test_project_details", array("id" => $project_id))->row_array();
        if (empty($prj_Exist)) {
            return '{"type":"FALSE","message":"Invalid project id supplied.","result":"ERROR","value":"0"}';
        } else {
            $this->db->select("id,title");
            $modules = $this->db->get_where("test_project_modules_details", array("project_id" => $project_id))->result_array();
            return json_encode(array(
                "type" => "TRUE",
                "message" => "",
                "result" => "TRUE",
                "value" => $modules
            ));
        }
    }

    public function activityentry($data, $loginInfo) {
        $today=date("Y-m-d");
        $startDate=date("Y-m-d",  strtotime($today . ' -2 day'));
        if (strtotime($data['date']) > 0 && strtotime($data['date'])>=strtotime($startDate) && strtotime($data['date'])<=strtotime($today)) {
            $ins = array();
            foreach ($data['activity'] as $activity) {
                if (strtotime($activity['hour_worked']) > 0) {
                    $ins[] = array(
                        "project_id" => $activity['project_id'],
                        "module_id" => $activity['module_id'],
                        "activity_id" => $activity['activity_id'],
                        "remarks" => $activity['remarks'],
                        "activity_date" => date("Y-m-d",strtotime($data['date'])),
                        "hour_worked" => $activity['hour_worked'],
                        "activity_status" => isset($activity['activity_status']) ? $activity['activity_status'] : "",
                        "staff_id" => $loginInfo['company_staff_id'],
                        "staff_rm_id" => $loginInfo['staff_rm_id'],
                        "entry_by" => $loginInfo['company_staff_id'],
                        'entry_from' => 'APP'
                    );
                } else {
                    return '{"type":"FALSE","message":"Invalid hour worked.","result":"ERROR","value":"0"}';
                }
            }
            $ins = $this->db->insert_batch("acr_emp_activity_detail", $ins);
            if ($ins) {
                return json_encode(array(
                    "type" => "TRUE",
                    "message" => "Activity entry successfully completed.",
                    "result" => "TRUE",
                    "value" => "1"
                ));
            } else {
                return '{"type":"FALSE","message":"An unknown error occured while saving activity data.","result":"ERROR","value":"0"}';
            }
        } else {
            return '{"type":"FALSE","message":"Invalid date.","result":"ERROR","value":"0"}';
        }
    }

}
