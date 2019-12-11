<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class projectmanagement_model extends CI_Model {

    public function GetProject() {
        $this->load->database();
        $this->db->select('id,title');
        $projectDeatil = $this->db->get("test_project_details")->result_array();
        return $projectDeatil;
    }

    /*     * ***************************************************************************** */

    public function myrmactivity($uid) {
        $currenttime = date('H:i:s');
        if ($currenttime == '19:00:00') {
            $currentDate = date('Y-m-d');
        } else {
            $currentDate = date('Y-m-d', strtotime("-1 days"));
        }
        $lastDate = date('Y-m-d', strtotime($currentDate . "-1 days"));
        $alldate = array($lastDate, $currentDate);
        $rmEmp = $this->getRmEmployee($uid);
        $returnJson = "[";
        for ($m = 0; $m < count($rmEmp); $m++) {
            $eid = $rmEmp[$m]['id'];
            $rm = $this->getRm($uid);

            $returnJson .= '{'
                    . '"emp_id":"' . $rmEmp[$m]['id'] . '",'
                    . '"empname":"' . $rmEmp[$m]['name'] . '",'
                    . '"rm_id":"' . $rmEmp[$m]['rm_id'] . '",'
                    . '"email_address":"' . $rmEmp[$m]['email_address'] . '",'
                    . '"rmname":"' . $rm[0]['name'] . '",';
            for ($i = 0; $i < count($alldate); $i++) {
                $Empactivity = $this->rmEmpactivity($eid, $alldate[$i]);
                if ($Empactivity[0]['activity_date'] == '') {
                    $holiday = $this->checkHoliday($alldate[$i]);
                    $attendance = $this->checkAttendance($alldate[$i], $eid);
                    $dayss = date("l", strtotime($alldate[$i]));
                    if ($dayss == 'Saturday' || $dayss == 'Sunday') {
                        $data = 'Weekly Holiday';
                    } else if (!empty($holiday)) {
                        $data = 'Holiday';
                    } else if (!empty($attendance)) {
                        $data = 'Holiday';
                    } else {
                        $data = 'NA';
                    }
                } else {
                    $data = 'Punched' . '  (' . round(($Empactivity [0]['hour_worked'] / 480) * 100, 2) . '%' . ')';
                }
                $returnJson .= '"date' . $i . '":"' . $data . '",';
            }
            $returnJson = substr($returnJson, 0, -1);

            $returnJson .= '},';
        }
        $output = substr($returnJson, 0, -1) . ']';

        return $output;
    }

    public function alluser() {
        $currenttime = date('H:i:s');
        if ($currenttime == '19:00:00') {
            $currentDate = date('Y-m-d');
        } else {
            $currentDate = date('Y-m-d', strtotime("-1 days"));
        }

        $lastDate = date('Y-m-d', strtotime($currentDate . "-1 days"));
        $alldate = array($lastDate, $currentDate);
        $rmEmp = $this->getAllEmpWithRM();


        $returnJson = "[";
        for ($m = 0; $m < count($rmEmp); $m++) {
            $eid = $rmEmp[$m]['id'];
            $returnJson .= '{'
                    . '"emp_id":"' . $rmEmp[$m]['id'] . '",'
                    . '"rm_id":"' . $rmEmp[$m]['rm_id'] . '",'
                    . '"empname":"' . $rmEmp[$m]['empname'] . '",'
                    . '"email_address":"' . $rmEmp[$m]['email_address'] . '",'
                    . '"rmname":"' . $rmEmp[$m]['rm'] . '",'
                    . '"id":"' . $rmEmp[$m]['id'] . '",';
            for ($i = 0; $i < count($alldate); $i++) {
                $Empactivity = $this->rmEmpactivity($eid, $alldate[$i]);
                if ($Empactivity[0]['activity_date'] == '') {
                    $holiday = $this->checkHoliday($alldate[$i]);
                    $attendance = $this->checkAttendance($alldate[$i], $eid);
                    $dayss = date("l", strtotime($alldate[$i]));
                    if ($dayss == 'Saturday' || $dayss == 'Sunday') {
                        $data = 'Weekly Holiday';
                    } else if (!empty($holiday)) {
                        $data = 'Holiday';
                    } else if (!empty($attendance)) {
                        $data = 'Holiday';
                    } else {
                        $data = 'NA';
                    }
                } else {
                    $data = 'Punched' . '  (' . round(($Empactivity [0]['hour_worked'] / 480) * 100, 2) . '%' . ')';
                }
                $returnJson .= '"date' . $i . '":"' . $data . '",';
            }
            $returnJson = substr($returnJson, 0, -1);

            $returnJson .= '},';
        }
        $output = substr($returnJson, 0, -1) . ']';

        return $output;
    }

    public function getRmEmployee($uid) {
        $this->load->database();
        $this->db->select('*');
        $this->db->from('company_staff_details');
        $this->db->where('active_status', 'WORKING');
        $this->db->where('review_conduct', 1);
        $this->db->where('rm_id', $uid);
        $activityDeatil = $this->db->get()->result_array();
        return $activityDeatil;
    }

    public function getAllEmpWithRM() {
        $dor = '0000-00-00';
        $this->load->database();
        $this->db->where('a.active_status', 'WORKING');
        $this->db->where('a.review_conduct', 1);
        $this->db->where('a.id !=', $this->session->userdata('company_staff_id'));
        //b.active_status='WORKING'
        $this->db->select('a.id,a.rm_id,a.name as empname,a.designation,a.email_address,b.name as rm');
        $this->db->from('company_staff_details as a');
        $this->db->join('company_staff_details as b', "b.id = a.rm_id AND a.d_o_r=$dor");
        $activityDeatil = $this->db->get()->result_array();

        return $activityDeatil;
    }

    public function GetProjectName($projectId) {
        $this->load->database();
        $this->db->select('id,title');
        $this->db->where('id', $projectId);
        $projectDetail = $this->db->get("test_project_details")->row_array();
        return $projectDetail;
    }

    public function getRm($uid) {
        $this->load->database();
        $this->db->select('name');
        $this->db->from('company_staff_details');
        $this->db->where('id', $uid);
        $activityDeatil = $this->db->get()->result_array();
        return $activityDeatil;
    }

    public function rmEmpactivity($eid, $fdate) {
        $this->load->database();
        $this->db->select('activity_date,sum(TIME_TO_SEC(hour_worked))/60 AS hour_worked');
        $this->db->from('acr_emp_activity_detail');
        $this->db->where('staff_id', $eid);
        $this->db->where('DATE(`activity_date`)', $fdate);
//        echo $this->db->last_query();
        $activityDeatil = $this->db->get()->result_array();
        return $activityDeatil;
    }

    public function myactivity($uid) {
        $currenttime = date('H:i:s');
        if ($currenttime == '19:00:00') {
            $currentDate = date('Y-m-d');
        } else {
            $currentDate = date('Y-m-d', strtotime("-1 days"));
        }
        $firstday = date('Y-m-01');
        $alldate = array();

        while (strtotime($firstday) <= strtotime($currentDate)) {
            $alldate[] = $firstday;
            $firstday++;
        }
        $finalData = array();
        for ($i = 0; $i < count($alldate); $i++) {
            $activity = $this->activtyDetails($uid, $alldate[$i]);
            if ($activity[0]['activity_date'] == '' && $activity[0]['hour_worked'] == '') {
                $holiday = $this->checkHoliday($alldate[$i]);
                $attendance = $this->checkAttendance($alldate[$i], $uid);

                $dayss = date("l", strtotime($alldate[$i]));
                if ($dayss == 'Saturday' || $dayss == 'Sunday') {
                    $finalData[$i]['date'] = date('d-m-Y', strtotime($alldate[$i]));
                    $finalData[$i]['status'] = 'Weekly Holiday';
                    $finalData[$i]['cc'] = '#3CFD62';
                } else if (!empty($holiday)) {
                    $finalData[$i]['date'] = date('d-m-Y', strtotime($alldate[$i]));
                    $finalData[$i]['status'] = 'Holiday';
                    $finalData[$i]['cc'] = '#f7aa53';
                } else if (!empty($attendance)) {
                    $finalData[$i]['date'] = date('d-m-Y', strtotime($alldate[$i]));
                    $finalData[$i]['status'] = 'Absent';
                    $finalData[$i]['cc'] = ' #9bf753 ';
                } else {
                    $finalData[$i]['date'] = date('d-m-Y', strtotime($alldate[$i]));
                    $finalData[$i]['status'] = 'NA';
                    $finalData[$i]['cc'] = '#FD3C3C';
                }
            } else {
                for ($k = 0; $k < count($activity); $k++) {
                    $finalData[$i]['date'] = date('d-m-Y', strtotime($alldate[$i]));
                    $finalData[$i]['status'] = 'Punched' . '  (' . round(($activity[$k]['hour_worked'] / 480) * 100, 2) . '%' . ')';
                    $finalData[$i]['cc'] = '#3CE0FD';
                }
            }
        }
        return $finalData;
    }

    public function activtyDetails($uid, $date) {
        $this->load->database();
        $this->db->select('activity_date,sum(TIME_TO_SEC(hour_worked))/60 AS hour_worked');
        $this->db->from('acr_emp_activity_detail');
        $this->db->where('staff_id', $uid);
        $this->db->where('DATE(`activity_date`)', $date);
        $activityDeatil = $this->db->get()->result_array();
        return $activityDeatil;
    }

    public function checkHoliday($date) {
        $this->load->database();
        $this->db->select('holiday_name');
        $this->db->from('holiday_list');
        $this->db->where('date', $date);
        $holidayDeatil = $this->db->get()->result_array();
        return $holidayDeatil;
    }

    public function checkAttendance($date, $staffid) {
        $this->load->database();
        $this->db->select('status');
        $this->db->from('attendance_details');
        $this->db->where('date', $date);
        $this->db->where('staff_id', $staffid);
        $attDeatil = $this->db->get()->result_array();

        return $attDeatil;
    }

    public function validateotp($otp, $today) {//
        $staff_id = $this->session->userdata('company_staff_id');
        $this->load->database();
        $this->db->select('id');
        $this->db->from('otp_sms_validation_details');
        $this->db->where('staff_id', $staff_id);
        $this->db->where('otp_date', $today);
        $this->db->where('otp', $otp);
        $result = $this->db->get()->row_array();
        if (count($result) > 0) {
            $updateArray = array("otp_validation" => 'YES');
            $updateCondition = array("id" => $result['id']);
            $this->db->update('otp_sms_validation_details', $updateArray, $updateCondition);
            return true;
        } else {
            return false;
        }
    }

    public function IsOTPvalidate($today) {//
        $staff_id = $this->session->userdata('company_staff_id');
        $this->load->database();
        $this->db->select('id');
        $this->db->from('otp_sms_validation_details');
        $this->db->where('staff_id', $staff_id);
        $this->db->where('otp_date', $today);
        $this->db->where('otp_validation', 'YES');
        $result = $this->db->get()->row_array();
        if (count($result) > 0) {
            $validate = 'YES';
        } else {
            $validate = 'NO';
        }
        return $validate;
    }

    /*     * ***************************************************************************** */

    public function GetProjectModule($projectId) {
        $this->load->database();
        $this->db->select('id,title');
        $this->db->where('project_id', $projectId);
        $projectModuleDetail = $this->db->get("test_project_modules_details")->result_array();
        return $projectModuleDetail;
    }

    public function GetDeveloperTesterName($bug_id) {
        $this->load->database();
        $this->db->select('a.name,b.module_id');
        $this->db->from('company_staff_details a');
        $this->db->join('test_bug_details b', 'a.id=b.developer_id');
        $this->db->where('b.id', $bug_id);
        $arrDname = $this->db->get()->result_array();

        $this->load->database();
        $this->db->select('a.name,b.module_id');
        $this->db->from('company_staff_details a');
        $this->db->join('test_bug_details b', 'a.id=b.entry_by');
        $this->db->where('b.id', $bug_id);
        $arrTname = $this->db->get()->result_array();
        $arrFinalName = array("module_id" => isset($arrDname[0]['module_id']) ? $arrDname[0]['module_id'] : '', "developer_name" => isset($arrDname[0]['name']) ? $arrDname[0]['name'] : '', "tester_name" => isset($arrTname[0]['name']) ? $arrTname[0]['name'] : '');
        return $arrFinalName;
    }

    public function UpdateBugStatus_model($myArr) {
        $this->load->database();
        if (isset($myArr['developer_comment'])) {
            $arrUpdateComment = array("developer_comment" => $myArr['developer_comment']);
            $this->db->where('id', $myArr['bug_id']);
            $this->db->update('test_bug_details', $arrUpdateComment);
        }
        $arrUpdateStatus = array("developer_status" => 'CHECKED');
        $this->db->where('id', $myArr['bug_id']);
        $this->db->update('test_bug_details', $arrUpdateStatus);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function GetBugStatus($bug_id) {
        $this->load->database();
        $this->db->select('a.id,b.title,a.developer_status,a.description,a.developer_comment,a.tester_comment,a.tester_status,a.entry_by');
        $this->db->from('test_bug_details a');
        $this->db->join('test_project_modules_details b', 'a.module_id = b.id');
        $this->db->where('a.id', $bug_id);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function UpdateBugStatusTester_model($myArr) {
        $this->load->database();
        if (isset($myArr['tester_comment'])) {
            $arrUpdateComment = array("tester_comment" => $myArr['tester_comment']);
            $this->db->where('id', $myArr['bug_id']);
            $this->db->update('test_bug_details', $arrUpdateComment);
        }
        $arrUpdateStatus = array("developer_status" => 'DONE', "tester_status" => 'DONE');
        $this->db->where('id', $myArr['bug_id']);
        $this->db->update('test_bug_details', $arrUpdateStatus);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function UpdateBugPendingStatusTester_model($myArr) {
        $this->load->database();
        if (isset($myArr['tester_comment'])) {
            $arrUpdateComment = array("tester_comment" => $myArr['tester_comment']);
            $this->db->where('id', $myArr['bug_id']);
            $this->db->update('test_bug_details', $arrUpdateComment);
        }
        $arrUpdateStatus = array("developer_status" => 'PENDING', "tester_status" => 'PENDING');
        $this->db->where('id', $myArr['bug_id']);
        $this->db->update('test_bug_details', $arrUpdateStatus);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function SaveRemarkMessageModel($myArr) {
        $this->load->database();
        if ($myArr['remark_from'] == 'TESTER') {
            $arrRemark = array("module_id" => $myArr['module_id'], "remarks" => $myArr['remark'], "screenshot_path" => '', "remarks_from" => $myArr['remark_from'], "entry_by" => $myArr['developer_id']);
            $this->db->insert('test_bugs_remarks', $arrRemark);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $arrRemark = array("module_id" => $myArr['module_id'], "remarks" => $myArr['remark'], "screenshot_path" => '', "remarks_from" => $myArr['remark_from'], "entry_by" => $myArr['developer_id']);
            $this->db->insert('test_bugs_remarks', $arrRemark);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function GetRemarkMessageModel($module_id) {
        $this->load->database();
        $company_staff_id = $this->session->userdata('company_staff_id');
        $this->db->select("remarks,screenshot_path,remarks_from,timestamp,DATE_FORMAT(timestamp,'%H-%S') as time_timestamp", false);
        $this->db->where('module_id', $module_id);
        $this->db->order_by('timestamp', 'desc');
        $remarkDetail = $this->db->get("test_bugs_remarks")->result_array();
        return $remarkDetail;
    }

}
