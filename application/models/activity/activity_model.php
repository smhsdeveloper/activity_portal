<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class activity_model extends CI_Model {

    public function empName($desig = NULL) {
        $this->db->select('id,name,email_address,admin_type,email_status,sms_status,mobile_for_sms');
        $this->db->where(array("active_status" => 'WORKING'));
        $this->db->from('company_staff_details');
        if ($desig) {
            $this->db->where(array("designation !=" => $desig));
        }
        $this->db->order_by("name", "asc");
        $emplist = $this->db->get()->result_array();

        return $emplist;
    }

    public function emplisttype($type, $emid) {
        $this->db->select('id,name');
        $this->db->from('company_staff_details');
        if ($type == 'RM') {
            $this->db->where(array("rm_id =" => $emid));
        }
        $this->db->order_by("name", "asc");
        $emplist = $this->db->get()->result_array();
        return $emplist;
    }

    public function getEmpHour($from, $to, $staff_id) {
        $newfromdate = date('Y-m-d', strtotime($from));
        $newtodate = date('Y-m-d', strtotime($to));
        $this->db->select('sum(TIME_TO_SEC(hour_worked))/60 AS hour_worked');
        $this->db->from('acr_emp_activity_detail');
        $this->db->where('activity_date >=', $newfromdate);
        $this->db->where('activity_date <=', $newtodate);
        $this->db->where('staff_id', $staff_id);
        $totalhour = $this->db->get()->row_array();
        if (!empty($totalhour)) {
            return $totalhour;
        } else {
            return 0;
        }
    }

    public function totalHour() {
        $staff_id = $this->session->userdata('company_staff_id');
        $currentdate = date('Y-m-d', strtotime($this->input->post('date')));
        $this->db->select('sum(TIME_TO_SEC(hour_worked))/60 AS hour_worked');
        $hour = $this->db->get_where('acr_emp_activity_detail', array('activity_date' => $currentdate, 'staff_id' => $staff_id))->row_array();
        if ($hour['hour_worked'] != '') {
            return $hour;
        } else {
            return 0;
        }
    }

    public function GetEmpInformationOfActivity() {
        $prevdate = date('jS M,Y', strtotime($date . ' -1 day'));
        $todayDate = date('jS M,Y');
        $empList = $this->empName();
        for ($i = 0; $i < count($empList); $i++) {
            $todayStatus = $this->TodayActivityInfo($empList[$i]['id']);
            $previousStatus = $this->PrevdayActivityInfo($empList[$i]['id']);
            $message = '';
            switch ($empList[$i]['id']) {
                case (!empty($todayStatus) && !empty($previousStatus)):
                    "Dear " . $empList[$i]['name'] . ", <p>You have succesfully punched your daily activity report today. Excellent, Good work.</p>";
                    break;
                case(!empty($todayStatus)):
                    $message = "Dear " . $empList[$i]['name'] . ", <p>You have missed punching your activity report for yesterday (" . $prevdate . ").. Please fill it by EOD.</p>";
                    $empList[$i]['status'] = 'PREVIOUS';
                    break;
                case (!empty($previousStatus)):
                    $message = "Dear " . $empList[$i]['name'] . ",<p>You have missed punching your activity report today (" . $todayDate . "). Please fill it by EOD.</p>";
                    $empList[$i]['status'] = 'TODAY';
                    break;
                case (empty($todayStatus) && empty($previousStatus)):
                    $message = "Dear " . $empList[$i]['name'] . ",<p>You have missed punching your activity report in last two days. Kindly please punch it at top most priority.</p>";
                    $empList[$i]['status'] = 'BOTH';
                    break;
            }
            $empList[$i]['message'] = $message;
            $empList[$i]['subject'] = "Daily activity report status-" . $todayDate;
            $empList[$i]['serviceType'] = 'NIGHT';
        }
        return $empList;
    }

    public function TodayActivityInfo($empId) {
        $todayDate = date('Y-m-d');
        $EmpRecord = $this->db->get_where('acr_emp_activity_detail', array('staff_id' => $empId, 'activity_date' => $todayDate))->result_array();
        return $EmpRecord;
    }

    public function TodayAttendanceInfo($date) {
        $dayss = date("l", strtotime($date));
        $holidayDeatil = $this->getholiday($date);
        $returnJson = "";
        if (empty($holidayDeatil)) {
            if ($dayss == 'Saturday' || $dayss == 'Sunday') {
                $returnJson .= 'Weekly Holiday';
            }
        } else {
            if ($dayss == 'Saturday' || $dayss == 'Sunday' && $holidayDeatil[0]['holiday_name'] != '') {
                $returnJson .= 'Weekly Holiday And ' . $holidayDeatil[0]['holiday_name'];
            } else {
                $returnJson .= $holidayDeatil[0]['holiday_name'];
            }
        }
        if ($returnJson == '') {
            $data = '{"atten":"NA"}';
        } else {
            $data = '{"atten":"' . $returnJson . '"}';
        }
        return $data;
    }

    public function getholiday($date) {
        $this->load->database();
        $this->db->select('holiday_name');
        $this->db->from('holiday_list');
        $this->db->where('date', $date);
        $holidayDeatil = $this->db->get()->result_array();
        return $holidayDeatil;
    }

    public function moduleentry($data, $modules) {
        $insertArray = array(
            "project_id" => $data,
            "title" => $modules,
            "developer_id" => $this->session->userdata('company_staff_id')
        );
        if ($this->db->insert('test_project_modules_details', $insertArray)) {
            $insert_id = $this->db->insert_id();
            return '{"STATUS":"TRUE","msg":"Data Saved","data":"' . $insert_id . '"}';
        } else {
            return'{"STATUS":"FALSE","msg":"Contact to admin !"}';
        }
    }

    public function sendEmail($data) {
        require_once FCPATH . "/assets/phpmailer/class.phpmailer.php";
        $this->db->select('id,name,email_address');
        $this->db->from('company_staff_details');
        $this->db->where(array("id =" => $data));
        $emplist = $this->db->get()->row_array();
        if (!empty($emplist)) {
            $this->db->select('pass');
            $this->db->from('system_users');
            $this->db->where(array("staff_id =" => $emplist['id']));
            $password = $this->db->get()->row_array();
            if (!empty($password)) {
                $emplist['password'] = $password['pass'];
            } else {
                $emplist['password'] = '';
            }
            $subject = 'Activity Credential';
            $message = "Dear " . $emplist['name'] . ",<br/><br/>";
            $message .= "Please find Login Credential of activity portal.";
            $message .= "<br/>";
            $message .= "Username : " . $emplist['email_address'] . "";
            $message .= "<br/>";
            $message .= "Password : " . $emplist['password'] . "";
            $message .= "<br/>";
            $message .= "Weburl : http://activity.invetechsolutions.com";
            $message .= "<br/>";
            $message .= "Play store : https://play.google.com/store/apps/details?id=com.telerik.ActivityPortal";
            $message .= "<br/>";
            $message .= "<br/>";
            $message .= "<br/>";
            $message .= "<br/><br/>";
            $message .= "Invetch HR<br/>";
            $message .= "Invetch Solutions LLP<br/>";
            $to = array($emplist['email_address']);
            $cc = array();
            $pass = $emplist['password'];
            $attachment = array();
            if ($to !== '' && $pass !== '') {
                if ($this->sendMyMail(new PHPMailer(), $attachment, $to, $cc, $subject, $message)) {
                    return "Email_Sent";
                } else {
                    return "Contact_to _Admin";
                }
            } else {
                return "Email_Password_Not_found";
            }
        } else {
            return "Employee_Not_Found";
        }
    }

    public function sendMyMail($mail, $attachFile, $EmailContactJson, $cc, $subject, $msgContent) {
        $mail->IsSMTP();
        $mail->Host = "smtp.postmarkapp.com";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = '605b8357-e985-4e18-8136-2a285bf46747';
        $mail->Password = '605b8357-e985-4e18-8136-2a285bf46747';
//    $mail->Username = 'ad7b7094-4214-48ca-8690-bddf536b8178';
//    $mail->Password = 'ad7b7094-4214-48ca-8690-bddf536b8178';
        $mail->Subject = $subject;
        $mail->MsgHTML($msgContent);
        $mail->SetFrom('nandini.sharma@invetechsolutions.com', 'Invetech Activity');
        $mail->ClearAddresses();
        $mail->ClearAllRecipients();
        foreach ($EmailContactJson as $value) {
            $mail->AddAddress(trim($value));
        }

        foreach ($cc as $value) {
            $mail->AddCC(trim($value));
        }
        $mail->AltBody = 'This is a plain-text message body';
        if (count($attachFile) > 0) {
            for ($i = 0; isset($attachFile[$i]); $i++) {
                if (file_exists(trim($attachFile[$i]))) {
                    $mail->AddAttachment(trim($attachFile[$i]));
                    // return $attachFile[$i];
                }
            }
        }
        if (!$mail->Send()) {
            return "false" . $mail->ErrorInfo;
        } else {
            return "true";
        }
    }

    public function newactivity($activity) {
        $insertArray = array(
            "activity_name" => $activity,
            "entry_by" => $this->session->userdata('company_staff_id')
        );
        if ($this->db->insert('acr_activity_master_list', $insertArray)) {
            $insert_id = $this->db->insert_id();
            return '{"STATUS":"TRUE","msg":"Data Saved","data":"' . $insert_id . '"}';
        } else {
            return'{"STATUS":"FALSE","msg":"Contact to admin !"}';
        }
    }

    public function projectlist() {
        $this->load->database();
        $this->db->select('id,title');
        $this->db->from('test_project_details');
        $project = $this->db->get()->result_array();
        return $project;
    }

    public function modulelist($data) {
        $this->load->database();
        $this->db->select('id,title');
        $this->db->from('test_project_modules_details');
        $this->db->where('project_id', $data);
        $project = $this->db->get()->result_array();
        return $project;
    }

    public function activitylist() {
        $this->load->database();
        $this->db->select('id,activity_name');
        $this->db->from('acr_activity_master_list');
        $project = $this->db->get()->result_array();
        return $project;
    }

    public function allempDetails($date) {
        $currenttime = date('H:i:s');
        if ($currenttime == '19:00:00') {
            $currentDate = date('Y-m-d');
        } else {
            $currentDate = date('Y-m-d', strtotime("-1 days"));
        }

        $lastDate = date('Y-m-d', strtotime($currentDate . "-1 days"));
        $alldate = array($lastDate, $currentDate);
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $rmEmp = $this->ModelObj->getAllEmpWithRM();

        for ($i = 0; $i < count($alldate); $i++) {
            $returnJson = "[";
            for ($m = 0; $m < count($rmEmp); $m++) {
                $eid = $rmEmp[$m]['id'];
                $attendance = $this->attendance_details($eid, $date);
                if (empty($attendance)) {
                    $status = 'NA';
                } else {
                    $status = 'Absent';
                }
                $Empactivity = $this->ModelObj->rmEmpactivity($eid, $alldate[$i]);
                $returnJson .= '{"empname":"' . $rmEmp[$m]['empname'] . '",';
                $returnJson .= '"rmname":"' . $rmEmp[$m]['rm'] . '",';
                $returnJson .= '"id":"' . $rmEmp[$m]['id'] . '",';
                $returnJson .= '"designation":"' . $rmEmp[$m]['designation'] . '",';
                $returnJson .= '"status":"' . $status . '"';
                $returnJson .= '},';
            }
        }
        $output = substr($returnJson, 0, -1) . ']';

        return $output;
    }

    public function attendance_details($id, $date) {
        $this->load->database();
        $this->db->select('id,staff_id,status');
        $this->db->from('attendance_details');
        $this->db->where('staff_id', $id);
        $this->db->where('date', $date);
        $attDeatil = $this->db->get()->result_array();
        return $attDeatil;
    }

    public function newtask($data) {
        $insertArray = array(
            "activity_id" => $data['activity_id'],
            "module_id" => $data['module_id'],
            "project_id" => $data['project_id'],
            "remarks" => $data['remarks'],
            "activity_date" => date('Y-m-d'),
            "hour_worked" => '00:00:00',
            "staff_id" => $this->session->userdata('company_staff_id'),
            "staff_rm_id" => $this->session->userdata('staff_rm_id'),
        );
        if ($this->db->insert('test_acr_emp_activity_detail', $insertArray)) {
            $last_id = $this->db->insert_id();
            $date = date('Y-m-d');
            $dataArray = $this->getActivityDetails($date);
            for ($i = 0; $i < count($dataArray); $i++) {
                $starttime = $date . $dataArray[$i]['hour_worked'];
                if ($i == $last_id) {
                    $dataArray[$i]['status'] = 'START';
                    $dataArray[$i]['starttime'] = strtotime($starttime) * 1000

                    ;
                }
            }
            $datajson = json_encode($dataArray, TRUE);
            return '{"STATUS":"TRUE","msg":"Activity Punched","data":' . $datajson . '}';
        } else {
            return'{"STATUS":"FALSE","msg":"Contact to admin !"}';
        }
    }

    public function getActivityDetails($date) {
        $this->load->database();
        $this->db->select('a.project_id,a.activity_id,a.module_id,a.remarks,activity_date,a.hour_worked,a.staff_id,a.staff_rm_id,b.title');
        $this->db->from('test_acr_emp_activity_detail as a');
        $this->db->where('a.activity_date', $date);
        $this->db->where('a.staff_id', $this->session->userdata('company_staff_id'));
        $this->db->where('a.staff_rm_id', $this->session->userdata('staff_rm_id'));
        $this->db->join('test_project_details as b', 'b.id= a.project_id');
        $otpSch = $this->db->get()->result_array();
        return $otpSch;
    }

    public function markAttendance($date, $data) {
        $insertArray = array("staff_id" => $data,
            "date" => $date,
            "status" => 'ABSENT',
            "entry_by" => $this->session->userdata('company_staff_id'));
        if ($this->db->insert('attendance_details', $insertArray)) {
            return '{"STATUS":"TRUE","msg":"Attendance Marked Absent for ' . $date . '"}';
        } else {
            return'{"STATUS":"FALSE","msg":"Contact to admin !"}';
        }
    }

    public function getAllEmp() {
        $this->load->database();
        $this->db->select('id,name as empname,designation,mobile_for_sms');
        $this->db->from('company_staff_details');
        $otpSch = $this->db->get()->result_array();
        return $otpSch;
    }

    public function activityvalidateornot($data) {
        $date = date('Y-m-d', strtotime($data));
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $rmEmp = $this->ModelObj->getAllEmpWithRM();
        for ($i = 0; $i < count($rmEmp); $i++) {
            $id = $rmEmp[$i]['id'];
            $otpstatus = $this->getOTPStatus($id, $date);
            if ($otpstatus[0]['otp_validation'] == '') {
                $rmEmp[$i]['status'] = 'Not Validated';
                $rmEmp[$i]['otp'] = $otpstatus[0]['otp'];
            } else {
                $rmEmp[$i]['status'] = 'Validated';
                $rmEmp[$i]['otp'] = $otpstatus[0]['otp'];
            }
        }
        return json_encode($rmEmp);
    }

    public function getOTPStatus($id, $date) {
        $this->load->database();
        $this->db->select('*');
        $this->db->from('otp_sms_validation_details');
        $this->db->where('otp_date', $date);
        $this->db->where('staff_id', $id);
//        $this->db->where('otp_validation', 'YES');
        $otpSch = $this->db->get()->result_array();
        return $otpSch;
    }

    public function PrevdayActivityInfo($empId) {
        $prevdate = date('Y-m-d', strtotime($date . ' -1 day'));
        $EmpRecord = $this->db->get_where('acr_emp_activity_detail', array('staff_id' => $empId, 'activity_date' => $prevdate))->result_array();
        return $EmpRecord;
    }

    public function ReminderForReport() {
        $empList = $this->empName();
        for ($i = 0; $i < count($empList); $i++) {
            $previousStatus = $this->PrevdayActivityInfo($empList[$i]['id']);
            switch ($empList[$i]['id']) {
                case (empty($previousStatus)):
                    $message = "Dear " . $empList[$i]['name'] . ",<p> Genral Reminder, you have not punched your daily activity report for yesterday. Please punch it now.</p>";
                    break;
            }
            $empList[$i]['message'] = $message;
            $empList[$i]['subject'] = 'Reminder: Punch your daily activity report ';
            $empList[$i]['serviceType'] = 'MORNING';
        }
        return $empList;
    }

    public function NightMessageDeatils() {
        include(APPPATH . 'config/database' . EXT);
        $webUserDsn = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $db['default']['database'];
        $systemDBObj = $this->load->database($webUserDsn, TRUE);
        $empList = $this->GetEmpInformationOfActivity();
        foreach ($empList as $row) {
            if ($row['mobile_for_sms'] != '' && $row['mobile_for_sms'] != 0) {
                $msgTempArr[] = $row['message'];
                $msgTempArr[] = $row['mobile_for_sms'];
            }
        }
        $strmobileno = implode("`", $msgTempArr);
        $this->load->model('core/sms_api', 'smsApiObj');
        $smsReasult = $this->smsApiObj->sendsms('GLOBEL', 'MmsgMno', $strmobileno, $systemDBObj);
        if ($smsReasult == 'TRUE') {
            return 'TRUE';
        } else {
            return 'FALSE';
        }
    }

    public function MorningMessageDeatils() {
        include(APPPATH . 'config/database' . EXT);
        $webUserDsn = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $db['default']['database'];
        $systemDBObj = $this->load->database($webUserDsn, TRUE);
        $empList = $this->ReminderForReport();
        foreach ($empList as $row) {
            if ($row['mobile_for_sms'] != '' && $row['mobile_for_sms'] != 0) {
                $msgTempArr[] = $row['message'];
                $msgTempArr[] = $row['mobile_for_sms'];
            }
        }
        $strmobileno = implode("`", $msgTempArr);
        $this->load->model('core/sms_api', 'smsApiObj');
        $smsReasult = $this->smsApiObj->sendsms('GLOBEL', 'MmsgMno', $strmobileno, $systemDBObj);
        if ($smsReasult == 'TRUE') {
            return 'TRUE';
        } else {
            return 'FALSE';
        }
    }

    /*     * ***************************************************Akhileshkarn************************************************* */

    public function getEmpInfo($empid) {
        $info = $this->db->get_where("company_staff_details", array("id" => $empid, "active_status" => 'WORKING'))->result_array();
        return $info;
    }

    public function getActivitySummary($from, $to, $empid) {
        $this->load->database();
        $start = strtotime($from);
        $end = strtotime($to);
        $this->db->select("date");
        $holidayList = $this->db->get("holiday_list")->result_array();
        $holidayList = array_column($holidayList, "date");
        $summary = array();
        $total_activity_hour = 0;
        $daysPresent = 0;
        while ($start <= $end) {
            $date = date("Y-m-d", $start);
            if (!in_array($date, $holidayList) && strtolower(date("D", $start)) != "sat" && strtolower(date("D", $start)) != "sun") {
                $this->db->select("status");
                $absentDates = $this->db->get_where("attendance_details", array("staff_id" => $empid, "date" => $date))->result_array();
                $this->db->select("otp_validation");
                $otp = $this->db->get_where("otp_sms_validation_details", array("staff_id" => $empid, "otp_date" => $date))->row_array();
                $this->db->select("hour_worked");
                $activity = $this->db->get_where("acr_emp_activity_detail", array("activity_date" => $date, "staff_id" => $empid))->result_array();
                $activity = array_column($activity, "hour_worked");
                $sum = 0;
                foreach ($activity as $val) {
                    $sum += (strtotime($val) - strtotime(date("Y-m-d")));
                }
                $total_activity_hour += $sum;
                $hour = date("G", ($sum + strtotime(date("Y-m-d"))));
                $hour = $hour > 1 ? "$hour hour " : "$hour hour ";
                $min = (int) (date("i", ($sum + strtotime(date("Y-m-d")))));
                $min = $min > 1 ? "$min min." : "$min min.";
                $activity_hour = $hour . $min;
                $daysPresent++;
                if (empty($absentDates)) {
                    $summary[] = array(
                        "date" => date("d-m-Y (l)", $start),
                        "otp" => ($otp && $otp['otp_validation'] == "YES") ? "Validated" : "Not Validated",
                        "activity" => $activity_hour . " ( " . round($sum / 288, 2) . " )",
                        "punch" => trim($activity_hour) == "0 hour 0 minute" ? "Not Punched" : "Punched",
                    );
                } else {
                    $summary[] = array(
                        "date" => date("d-m-Y (l)", $start),
                        "otp" => "ABSENT",
                        "activity" => "ABSENT",
                        "punch" => "ABSENT",
                    );
                }
            }
            $start += (24 * 60 * 60);
        }
        $hour = (int) ($total_activity_hour / 60 / 60);
        $hour = $hour > 1 ? "$hour hours " : "$hour hour ";
        $min = (int) (date("i", ($total_activity_hour + strtotime(date("Y-m-d")))));
        $min = $min > 1 ? "$min minutes" : "$min minute";
        $total_activity_hour = $hour . $min;
        foreach ($summary as $key => $val) {
            $summary[$key]['class'] = $val['otp'] == "Validated" && $val['punch'] == "Punched" ? "success" : (($val['otp'] == "Not Validated" && $val['punch'] == "Not Punched") ? "danger" : ($val['otp'] == "Validated" ? "warning" : "info"));
        }
        return array("total_activity_hour" => $total_activity_hour . " (" . round((($hour * 60 + $min) * 100) / ($daysPresent * 480), 1) . "%)", "summary" => $summary);
    }

    public function getProjectList() {
        $projectList = $this->db->get("test_project_details")->result_array();
        return $projectList;
    }

    public function getProjectSummary($prjId) {
        $prj = $this->db->get_where("test_project_details", array("id" => $prjId))->row_array();
        $this->db->select("id,title");
        $modules = $this->db->get_where("test_project_modules_details", array("project_id" => $prjId))->result_array();
        $this->db->select("b.id,b.name");
        $this->db->join("company_staff_details as b", "a.staff_id=b.id", "left");
        // exit('test');
        $this->db->group_by("b.id");
        $developer = $this->db->get_where("acr_emp_activity_detail as a", array("a.project_id" => $prjId, "staff_id >" => 0))->result_array();
        $start = strtotime(date("Y-m-d", mktime()));
        foreach ($modules as $k => $mod) {
            $modsec = 0;
            foreach ($developer as $key => $dev) {
                $this->db->select("hour_worked");
                $duration = $this->db->get_where("acr_emp_activity_detail", array("module_id" => $mod['id'], "staff_id" => $dev['id']))->result_array();
                $seconds = 0;
                foreach ($duration as $time) {
                    $seconds += strtotime($time['hour_worked']) - $start;
                }
                $h = (int) ($seconds / 60 / 60);
                $m = date("i", ($seconds + $start));
                $s = date("s", ($seconds + $start));
                if ($dev['id']) {
                    $modules[$k]['dev'][] = array(
                        "id" => $dev['id'],
                        "name" => $dev['name'],
                        "time" => "$h:$m:$s"
                    );
                }
                $modsec += $seconds;
                if (!isset($developer[$key]['total'])) {
                    $developer[$key]['total'] = 0;
                }
                $developer[$key]['total'] += $seconds;
            }
            $h = (int) ($modsec / 60 / 60);
            $m = date("i", ($modsec + $start));
            $s = date("s", ($modsec + $start));
            $modules[$k]['totalTime'] = "$h:$m:$s";
        }
        $total = 0;
        foreach ($developer as $key => $dev) {
            if (!isset($dev['total'])) {
                unset($developer[$key]);
                continue;
            }
            $total += $dev['total'];
            $h = (int) ($dev['total'] / 60 / 60);
            $m = date("i", ($dev['total'] + $start));
            $s = date("s", ($dev['total'] + $start));
            $developer[$key]['total'] = "$h:$m:$s";
        }
        $h = (int) ($total / 60 / 60);
        $m = date("i", ($total + $start));
        $s = date("s", ($total + $start));
        $total = "$h:$m:$s";
        return array("prj" => $prj['title'], "mod" => $modules, "dev" => $developer, "total" => $total);
    }

    /*     * *******************************************Nitin***************************** */

    public function saveWorkDetails($data, $rmid) {

        $this->load->database();
        $dataArray = array(
            'project_id' => $data['projectid'],
            'module_id' => $data['moduleid'],
            'activity_id' => $data['activityid'],
            'remarks' => $data['workdetail'],
            'activity_date' => date('Y-m-d', strtotime($data['date'])),
            'hour_worked' => '00:00',
            'activity_status' => 'START',
            'staff_id' => $data['empid'],
            'staff_rm_id' => $rmid
        );

        $this->db->insert('acr_emp_activity_detail', $dataArray);
        $lastInsertId = $this->db->insert_id();
        $this->saveDetail($data, $lastInsertId);

        if ($this->db->insert_id() > 0) {
            $data = $this->getTableDetail();
            return $data;
        } else {
            return -1;
        }
    }

    public function saveDetail($data, $id) {
        $this->load->database();
        $totaltime = strtotime(date('H:i:s')) - strtotime(0);
        $myArray = array(
            'ac_id' => $id,
            'start_time' => date('H:i:s'),
            'pause_time' => '00:00:00',
            'status' => 'START'
        );
        $this->db->insert('emp_workdetail', $myArray);
        $lastId = $this->db->insert_id();
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return -1;
        }
    }

    public function getTableDetail() {
        $this->load->database();
        $empid = $this->session->userdata('company_staff_id');
        $date = date('Y-m-d');
        $this->db->select('b.title,a.remarks,a.id,a.staff_id,a.staff_rm_id,a.project_id,a.module_id,a.activity_id,a.activity_status');
        $this->db->join('test_project_details as b', 'a.project_id = b.id', 'left');
        $data = $this->db->get_where('acr_emp_activity_detail as a', array('a.activity_date' => $date, 'a.staff_id' => $empid))->result_array();
        for ($k = 0; $k < count($data); $k++) {
            $id = $data[$k]['id'];
            $data[$k]['timer'] = $this->calculateTime($id);
        }
        return $data;
    }

    public function calculateTime($id) {
        $this->load->database();
        $this->db->select('start_time,pause_time');
        $this->db->from('emp_workdetail');
        $this->db->where('ac_id', $id);
        $data = $this->db->get()->result_array();
        $totaltime = "00:00:00";
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['pause_time'] === '00:00:00') {
                $paused = $data[$i]['start_time'];
            } else {
                $paused = $data[$i]['pause_time'];
            }
            $timedifference = strtotime($paused) - strtotime($data[$i]['start_time']);
            $totaltime += $timedifference;
        }
        return $totaltime;
    }

    public function pauseWorkTimer($data) {
        $id = $data['id'];

        $myArray = array(
            'pause_time' => date("H:i:s"),
            'status' => 'PAUSED'
        );
        $this->load->database();
        $this->db->select_max('id');
        $lastid = $this->db->get_where('emp_workdetail', array('ac_id' => $id))->row_array();
        $this->db->where('id', $lastid['id']);
        $this->db->update('emp_workdetail', $myArray);
        if ($this->db->affected_rows() > 0) {
            $this->db->where('id', $id);
            $this->db->update('acr_emp_activity_detail', array('activity_status' => 'PAUSED'));
            $data = $this->getTableDetail();
            return $data;
        } else {
            return -1;
        }
    }

    public function startWorkTimer($data) {
        $id = $data['id'];
        $this->load->database();
        $myArray = array(
            'ac_id' => $id,
            'start_time' => date('H:i:s'),
            'pause_time' => '00:00:00',
            'status' => 'START'
        );
        $this->db->insert('emp_workdetail', $myArray);
        if ($this->db->affected_rows() > 0) {
            $this->db->where('id', $id);
            $this->db->update('acr_emp_activity_detail', array('activity_status' => 'START'));

            $data = $this->getTableDetail();
            return $data;
        } else {
            return -1;
        }
    }

    public function checkStartWork() {
        $this->load->database();
        $date = date('Y-m-d');
        $empid = $this->session->userdata('company_staff_id');
        $this->db->select('activity_status,id');
        $start = $this->db->get_where('acr_emp_activity_detail', array('activity_status' => 'START', 'staff_id' => $empid))->result_array();
        $this->db->where('id', $start[0]['id']);
        $this->db->update('acr_emp_activity_detail', array('activity_status' => 'PAUSED'));
        $myArray = array(
            'pause_time' => date("H:i:s"),
            'status' => 'PAUSED'
        );
        $this->db->select_max('id');
        $lastid = $this->db->get_where('emp_workdetail', array('ac_id' => $start[0]['id']))->row_array();
        $this->db->where('id', $lastid['id']);
        $this->db->update('emp_workdetail', $myArray);
        return $start;
    }

    public function stopActivityStatus() {
        $this->load->database();
        $date = date('Y-m-d');
        $this->db->where('activity_date', $date);
        $this->db->update('acr_emp_activity_detail', array('activity_status' => 'PAUSED'));
        $this->db->select('id');
        $id = $this->db->get_where('acr_emp_activity_detail', array('activity_date' => $date))->result_array();
        foreach ($id as $value) {
            $this->db->where('ac_id', $value['id']);
            $myArray = array(
                'pause_time' => date("H:i:s"),
                'status' => 'PAUSED'
            );
            $this->db->update('emp_workdetail', $myArray);
        }
        if ($this->db->affected_rows() > 0) {

            return 1;
        } else {
            return -1;
        }
    }

    public function saveModule($data) {
        $this->load->database();
        $myArray = array(
            'project_id' => $data['projectid'],
            'module_no' => 0,
            'title' => $data['modulename'],
            'description' => 'START',
            'developer_id' => $data['empid'],
            'module_type' => 'NEW'
        );
        $this->db->insert('test_project_modules_details', $myArray);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return -1;
        }
    }

    public function saveActivity($data) {
        $this->load->database();
        $myArray = array(
            'activity_name' => $data,
        );
        $this->db->insert('acr_activity_master_list', $myArray);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return -1;
        }
    }

    public function gettestingproject($empid) {

        $this->load->database();
        $this->db->select('id,title');
        if (($empid == '8') || ($empid == '32')) {
            $result = $this->db->get_where('test_project_details', array("tester_id" => $empid, "category !=" => 'BUSINESS DEVELOPMENT'))->result_array();
        } else {
            $result = $this->db->get_where('test_project_details', array("category !=" => 'BUSINESS DEVELOPMENT'))->result_array();
        }
        return $result;
    }

    /* ..........AKASH GIRI (Get Project List Model)......... */

    public function getprojectlists() {
        $this->db->select('id,title');
        $this->db->from('test_project_details');
        $this->db->order_by('title', 'asc');
        $this->db->where('status', 'ACTIVATE');
        $emplist = $this->db->get()->result_array();
        return $emplist;
    }

    public function getmonthsactivity($postdata) {
        if (isset($postdata['fromdate']) || isset($postdata['todate'])) {
            $reportArr['MonthList'] = $this->getMonthsInRange($postdata['fromdate'], $postdata['todate']);
            if (isset($postdata['project_id'])) {
                $this->db->select('b.name,b.id');
                $this->db->join('company_staff_details as b', 'a.staff_id = b.id', 'right');
                $this->db->group_by('b.id');
                $reportArr['UserList'] = $this->db->get_where('acr_emp_activity_detail as a', array('a.project_id' => $postdata['project_id'], 'MONTH(a.activity_date)>=' => '04', 'YEAR(a.activity_date)' => date('Y')))->result_array();
                $grand_sum = 0;
                $sumArr = array();
                $totalsum = 0;
                $ratsum = 0;
                if (!empty($reportArr['UserList'])) {
                    foreach ($reportArr['UserList'] as $key => $value) {
                        if ($value['name'] != '' || $value['name'] != null) {
                            $reportArr['UserList'][$key]['rating'] = $postdata['rating'];
                            $sum = 0;
                            $hour = 0;
                            $min = 0;
                            foreach ($reportArr['MonthList'] as $key1 => $val) {
                                $this->db->select('SEC_TO_TIME(sum(time_to_sec(hour_worked))) AS hour_worked,MONTH(a.activity_date) as m_id,YEAR(a.activity_date) as year');
                                $housrs = $this->db->get_where('acr_emp_activity_detail as a', array('a.staff_id' => $value['id'], 'MONTH(a.activity_date)' => $val['id'], 'YEAR(a.activity_date)' => $val['year'], 'a.project_id' => $postdata['project_id']))->row_array();
                                if ($housrs['hour_worked'] == '' || $housrs['hour_worked'] == null) {
                                    $housrs['hour_worked'] = '00:00:00';
                                }
                                $time = explode(':', $housrs['hour_worked']);
                                if (empty($time)) {
                                    $time[0] = '0';
                                    $time[1] = '0';
                                }
                                if (is_float($time[1] / 60)) {
                                    $new_min = explode('.', $time[1] / 60);
                                    $time[0] = $time[0] + $new_min[0];
                                }
                                $hour = $hour + $time[0];
                                $min = $min + $time[1];

                                $reportArr['UserList'][$key1]['hour'][] = $time[0];
                                $sumArr[$key1][] = $time[0] . '.' . $time[1];
                                $totalsum = array_sum($sumArr[$key1]);
                                $reportArr['MonthList'][$key1]['totalsum'] = $totalsum;
                                $sum = $sum + $housrs['hour_worked'];
                                $reportArr['UserList'][$key]['hourArr'][] = $housrs;
//                            $reportArr['UserList'][$key]['total_sum'] = $sum;
                                $reportArr['UserList'][$key]['total_sum'] = $hour . ':' . $min;
                                $reportArr['UserList'][$key]['multiply_val'] = $sum * $postdata['rating'];
                            }
                            $ratsum = $ratsum + $reportArr['UserList'][$key]['multiply_val'];
                            $grand_sum = $grand_sum + $reportArr['UserList'][$key]['total_sum'];
                            $reportArr['grand_totalsum'] = $grand_sum;
                            $reportArr['rating_sum'] = $ratsum;
                        }
                    }
                }
                return $reportArr;
            } else {
                foreach ($reportArr['MonthList'] as $val) {
                    $this->db->select('SEC_TO_TIME(sum(time_to_sec(hour_worked))) AS total_time,a.project_id,b.title');
                    $this->db->join('test_project_details as b', 'a.project_id = b.id', 'right');
                    $this->db->group_by('a.project_id');
                    $this->db->order_by('total_time', 'DESC');
                    $this->db->where('b.status', 'ACTIVATE');
                    $this->db->limit(10);
                    $housrs = $this->db->get_where('acr_emp_activity_detail as a', array('a.activity_date >=' => date('Y-m-d', strtotime($postdata['fromdate'])), 'a.activity_date <=' => date('Y-m-d', strtotime($postdata['todate']))))->result_array();
                    if (!empty($housrs)) {
                        foreach ($housrs as $key => $val) {
                            $reportArr['data'][] = (int) $val['total_time']; //(int) (strtotime($val['total_time']) / 60 / 60);;//(int)($val['total_time']);
                            $reportArr['month_name'][] = $val['title'];
                        }
                        return array('data' => $reportArr['data'], 'category' => $reportArr['month_name']);
                    } else {
                        return array('data' => array(), 'category' => array());
                    }
                }
            }
        } else {
            $reportArr = array();
            $reportArr['MonthList'] = $this->getMonthsInRange('1-04-2018', date('d-m-Y'));
            foreach ($reportArr['MonthList'] as $key => $month) {
                $this->db->select('b.name,b.id');
                $this->db->join('company_staff_details as b', 'a.staff_id = b.id', 'right');
                $this->db->group_by('b.id');
                $reportArr['MonthList'][$key]['user'] = $this->db->get_where('acr_emp_activity_detail as a', array('a.project_id' => $postdata['project_id'], 'YEAR(a.activity_date)=' => date('Y'), 'MONTH(a.activity_date)>=' => '04'))->result_array();
                foreach ($reportArr['MonthList'][$key]['user'] as $key1 => $value) {
                    if ($value['name'] != '' || $value['name'] != null) {
                        $reportArr['chartdata'][$key1]['name'] = $value['name'];
                        $this->db->select('SEC_TO_TIME(sum(time_to_sec(hour_worked))) AS total_time');
                        $hour = $this->db->get_where('acr_emp_activity_detail as a', array('a.staff_id' => $value['id'], 'a.project_id' => $postdata['project_id'], 'YEAR(a.activity_date)' => $month['year'], 'MONTH(a.activity_date)' => $month['id']))->row_array();
                        if (empty($hour['total_time'])) {
                            $hour['total_time'] = 0;
                        }
                        $reportArr['chartdata'][$key1]['data'][] = (int) $hour['total_time'];
                    }
                }
                $reportArr['month_name'][] = $month['name'] . '-' . $month['year'];
            }
            return array('chartdata' => isset($reportArr['chartdata']) ? $reportArr['chartdata'] : array(), 'category' => $reportArr['month_name']);
        }
    }

    function getMonthsInRange($startDate, $endDate) {
        $months = array();
        while (strtotime($startDate) <= strtotime($endDate)) {
            $months[] = array('year' => date('Y', strtotime($startDate)), 'id' => date('m', strtotime($startDate)), 'name' => date('M', strtotime($startDate)),);
            $startDate = date('d M Y', strtotime($startDate .
                            '+ 1 month'));
        }
        return $months;
    }

    function getmonthdatabyid($postdata) {
        $userlist = array();
        $this->db->select('title');
        $userlist['project_name'] = $this->db->get_where('test_project_details', array('id' => $postdata['project_id']))->row_array();
        $this->db->select('name');
        $userlist['staff_name'] = $this->db->get_where('company_staff_details', array('id' => $postdata['staff_id']))->row_array();
        $this->db->select('id,activity_date,project_id,staff_id, SEC_TO_TIME(sum(time_to_sec(hour_worked))) AS hour_worked');
        $this->db->group_by('activity_date');
        $userlist['userlist'] = $this->db->get_where('acr_emp_activity_detail', array('staff_id' => $postdata['staff_id'], 'project_id' => $postdata['project_id'], 'YEAR(activity_date)=' => $postdata['year'], 'MONTH(activity_date)' => $postdata['month_id']))->result_array();
        foreach ($userlist['userlist'] as $key => $value) {
            $this->db->select('remarks,hour_worked');
            $userlist['userlist'][$key]['remark'] = $this->db->get_where('acr_emp_activity_detail', array('staff_id' => $value['staff_id'], 'project_id' => $value['project_id'], 'activity_date' => $value['activity_date']))->result_array();
        }
        return $userlist;
    }

    function getactivitybydate($date, $emp_id) {
        $result = $this->db->get_where('acr_emp_activity_detail', array('activity_date' => $date, 'staff_id' => $emp_id))->row_array();
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

}
