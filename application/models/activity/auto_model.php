<?php

class auto_model extends CI_Model {

    public function empforotp() {
        $dbname = $this->load->database();
        $date = date('Y-m-d');
        $dayss = date("l", strtotime($date));
        $holidayDeatil = $this->getTodayholiday($date);
        if ($dayss == 'Saturday') {
            
        } else if ($dayss == 'Sunday') {
            
        } else if ($holidayDeatil[0]['holiday_name'] != '') {
            
        } else {
            $rmEmp = $this->getAllEmplist();
            $dataArray = array();
            for ($k = 0; $k < count($rmEmp); $k++) {
                $eid = $rmEmp[$k]['id'];
                $holidayDeatil = $this->getTodayattendance($eid, $date);
                if (empty($holidayDeatil)) {
                    $dataArray[] = array(
                        "id" => $eid,
                        "empname" => $rmEmp[$k]['empname'],
                        "contact" => $rmEmp[$k]['mobile_for_sms'],
                        "email" => $rmEmp[$k]['email_address']
                    );
                }
            }
            for ($i = 0; $i < count($dataArray); $i++) {
                $id = $dataArray[$i]['id'];
                $empname = $dataArray[$i]['empname'];
                $contact = $dataArray[$i]['contact'];
                $email = $dataArray[$i]['email'];
                $otpsend = $this->getOtpsend($id, $date);
                $otp = mt_rand(1000, 9999);
                $genrateotp = $this->getOtpMatched($otp);

                if (empty($otpsend)) {
                    echo 'hi';
                    if ($contact == '') {
                        $insertArray = array("staff_id" => $id,
                            "contact_no" => 'NA',
                            "otp" => $genrateotp,
                            "otp_date" => $date,
                        );
                        $this->db->insert('otp_sms_validation_details', $insertArray);
                        echo 'Contact Not Found' . '<br>';
                    } else {
                        $insertArray = array("staff_id" => $id,
                            "contact_no" => $contact,
                            "otp" => $genrateotp,
                            "otp_date" => $date,
                        );
                        $this->db->insert('otp_sms_validation_details', $insertArray);
                        $strmobileno = "Dear " . $empname . ",Your otp is " . $genrateotp . " Please validate your OTP" . " `$contact";
                        $APItype = 'GLOBEL';
                        $xmltype = 'MmsgMno';
                        if (sendsms($APItype, $xmltype, $strmobileno, $dbname)) {
                            echo 'Send OTP' . '<br>';
                        }
                    }
                    if ($email != '') {
                        $to = $email;
                        $subject = "OTP FOR " . date('d-M-Y', strtotime($date));
                        $txt = '<html>
                    <body>
                    <h2>OTP FOR ' . date('d-F-Y') . '</h2>
                    <p>Dear ' . $empname . ',</p>
                    <br/>
                    <p>Your OTP is ' . $genrateotp . ' ,Please validate your OTP </p>
                    <p>Kindly Visit the following URL </p>
                    <p>url :http://activity.smartechenergy.in/ </p>
                    <br/>
                    <p>Thanks & Regards,</p>
                    <h3>Adarsh Kumar</h3>
                    <p>Software Developer</p>
                    <p>INVETECH SOLUTIONS LLP</p>
                    <p>https://www.invetechsolutions.com</p>
                    <p>D/F +91-11-66666986 | M +91-9654664388</p>
                    <p>2F-CS, 53 Ansal Plaza,</p>
                    <p>Sector-1 Vaishali, Ghaziabad, Uttar Pradesh 201010</p>
                    </body>
                    </html>';

                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'From: adarsh.labh@invetechsolutions.com' . "\r\n";
                        if (mail($to, $subject, $txt, $headers)) {
                            echo 'Success';
                        } else {
                            echo 'Err';
                        }
                    }
                }
            }

            return $dataArray;
        }
    }

    public function getTodayholiday($date) {
        $this->load->database();
        $this->db->select('holiday_name');
        $this->db->from('holiday_list');
        $this->db->where('date', $date);
        $holidayDeatil = $this->db->get()->result_array();
        return $holidayDeatil;
    }

    public function getAllEmplist() {
        $this->load->database();
        $this->db->select('id,name as empname,designation,mobile_for_sms,email_address');
        $this->db->from('company_staff_details');
        $this->db->where('otp_sms', 'YES');
        $otpSch = $this->db->get()->result_array();
        return $otpSch;
    }

    public function getTodayattendance($id, $date) {
        $this->load->database();
        $this->db->select('id,staff_id,status');
        $this->db->from('attendance_details');
        $this->db->where('staff_id', $id);
        $this->db->where('date', $date);
        $attDeatil = $this->db->get()->result_array();
        return $attDeatil;
    }

    public function getOtpsend($id, $date) {
        $this->load->database();
        $this->db->select('*');
        $this->db->from('otp_sms_validation_details');
        $this->db->where('staff_id', $id);
        $this->db->where('otp_date', $date);
        $attDeatil = $this->db->get()->result_array();
        return $attDeatil;
    }

    public function getOtpMatched($otp) {
        $this->load->database();
        $this->db->select('*');
        $this->db->from('otp_sms_validation_details');
        $this->db->where('otp', $otp);
        $otpfound = $this->db->get()->result_array();
        if (count($otpfound) > 0) {
            return mt_rand(1000, 9999);
        } else {
            return $otp;
        }
    }

    /*     * *********************************REMINDER SMS*********************************** */

    public function empforreminder() {
        $dbname = $this->load->database();
        $date = date('Y-m-d');
        $dayss = date("l", strtotime($date));
        $holidayDeatil = $this->getTodayholiday($date);
        if ($dayss == 'Saturday' || $dayss == 'Sunday' && $holidayDeatil[0]['holiday_name'] != '') {
            echo 'Weekly Off';
        } else {
            $rmEmp = $this->getAllRemEmplist();
            $fdate = date('Y-m-d', strtotime($date . "-1 days"));
            $returnJson = "[";
            for ($m = 0; $m < count($rmEmp); $m++) {
                $eid = $rmEmp[$m]['id'];
                $Empactivity = $this->reminderEmpactivity($eid, $fdate);
                $returnJson .= '{"empname":"' . $rmEmp[$m]['empname'] . '",';
                $returnJson .= '"id":"' . $rmEmp[$m]['id'] . '",';
                $returnJson .= '"contact":"' . $rmEmp[$m]['mobile_for_sms'] . '",';
                if ($Empactivity[0]['activity_date'] == '') {
                    $dayss = date("l", strtotime($fdate));
                    if ($dayss == 'Saturday' || $dayss == 'Sunday') {
                        $returnJson .= '"reminder":"Weekly Holiday"';
                    } else {
                        $returnJson .= '"reminder":"NA"';
                    }
                } else {
                    $returnJson .= '"reminder":"NO Need to send reminder"';
                }
                $returnJson .= '},';
            }
            $output = substr($returnJson, 0, -1) . ']';
            echo $output;
            $dataArray = json_decode($output, TRUE);
            echo '<pre>';
            print_r($dataArray);
            for ($i = 0; $i < count($dataArray); $i++) {
                if ($dataArray[$i]['reminder'] == 'NA') {
                    $id = $dataArray[$i]['id'];
                    $empname = $dataArray[$i]['empname'];
                    $contact = $dataArray[$i]['contact'];
                    $remindersend = $this->reminder_sms_details($id, $fdate);
                    if (empty($remindersend)) {
                        $reminder = 'Dear ' . $empname . ', You have not Punched your Activity please punch Your activity';
                        if ($contact == '') {
                            $insertArray = array("staff_id" => $id,
                                "contact_no" => 'NA',
                                "reminder" => $reminder,
                                "date" => $fdate
                            );
                            $this->db->insert('reminder_sms_details', $insertArray);
                            echo 'Send Reminder Without Contact' . '<br>';
                        } else {
                            $insertArray = array("staff_id" => $id,
                                "contact_no" => $contact,
                                "reminder" => $reminder,
                                "date" => $fdate
                            );
                            $this->db->insert('reminder_sms_details', $insertArray);
                            $strmobileno = $reminder . " `$contact";
                            $APItype = 'GLOBEL';
                            $xmltype = 'MmsgMno';
                            if (sendsms($APItype, $xmltype, $strmobileno, $dbname)) {
                                echo 'Send Reminder' . '<br>';
                            }
                        }
                    }
                }
            }
        }
    }

    public function reminderEmpactivity($eid, $fdate) {
        $this->load->database();
        $this->db->select('activity_date,sum(TIME_TO_SEC(hour_worked))/60 AS hour_worked');
        $this->db->from('acr_emp_activity_detail');
        $this->db->where('staff_id', $eid);
        $this->db->where('DATE(`activity_date`)', $fdate);
        $activityDeatil = $this->db->get()->result_array();
        return $activityDeatil;
    }

    public function reminder_sms_details($id, $date) {
        $this->load->database();
        $this->db->select('*');
        $this->db->from('reminder_sms_details');
        $this->db->where('staff_id', $id);
        $this->db->where('date', $date);
        $attDeatil = $this->db->get()->result_array();
        return $attDeatil;
    }

    public function getAllRemEmplist() {
        $this->load->database();
        $this->db->select('id,name as empname,designation,mobile_for_sms,email_address');
        $this->db->from('company_staff_details');
        $this->db->where('reminder_sms', 'YES');
        $remEmp = $this->db->get()->result_array();
        return $remEmp;
    }

    /*     * *********************************ADMIN SMS*********************************** */

    public function adminSMS() {
        $dbname = $this->load->database();
        $date = date('Y-m-d');
        $dayss = date("l", strtotime($date));
        $holidayDeatil = $this->getTodayholiday($date);
        if ($dayss == 'Saturday' || $dayss == 'Sunday' && $holidayDeatil[0]['holiday_name'] != '') {
            echo 'Weekly Off';
        } else {
            $returnJson = "{";
            $adminEmp = $this->getAllEmployee();
            for ($i = 0; $i < count($adminEmp); $i++) {
                $empid = $adminEmp[$i]['id'];
                $fdate = date('Y-m-d', strtotime($date . "-1 days"));
                $attendanceDeatil = $this->getEmployeelastAttendance($empid, $fdate);
                if (empty($attendanceDeatil)) {
                    $returnJson .= $adminEmp[$i]['empname'] . ',';
                }
            }
            $output = substr($returnJson, 0, -1) . '}';

            $adminSMS = $this->getAllEmployeeForAdmin();
            for ($k = 0; $k < count($adminSMS); $k++) {
                $eid = $adminSMS[$k]['id'];
                $contact = $adminSMS[$k]['mobile_for_sms'];
                $Empactivity = $this->admin_sms_details($eid, $fdate);
                if ($Empactivity[0]['date'] == '') {
                    $adminsmscontent = 'Dear ADMIN, Following Employe have not punched their Attendence' . $output;
                    if ($contact == '') {
                        $insertArray = array("staff_id" => $eid,
                            "contact_no" => 'NA',
                            "sms_content" => $output,
                            "date" => $fdate
                        );
                        $this->db->insert('admin_sms_details', $insertArray);
                        echo 'Send Admin SMS Without Contact' . '<br>';
                    } else {
                        $insertArray = array("staff_id" => $eid,
                            "contact_no" => $contact,
                            "sms_content" => $adminsmscontent,
                            "date" => $fdate
                        );
                        $this->db->insert('admin_sms_details', $insertArray);
                        $strmobileno = $adminsmscontent . " `$contact";
                        $APItype = 'GLOBEL';
                        $xmltype = 'MmsgMno';
//                        sendsms($APItype, $xmltype, $strmobileno, $dbname);
                    }
                }
            }
            echo $output;
        }
    }

    public function getAllEmployeeForAdmin() {
        $this->load->database();
        $this->db->select('id,name as empname,designation,mobile_for_sms');
        $this->db->from('company_staff_details');
        $this->db->where('admin_sms', 'YES');
        $remEmp = $this->db->get()->result_array();
        return $remEmp;
    }

    public function getAllEmployee() {
        $this->load->database();
        $this->db->select('id,name as empname,designation,mobile_for_sms');
        $this->db->from('company_staff_details');
        $this->db->where('admin_type !=', 'ADMIN');
        $remEmp = $this->db->get()->result_array();
        return $remEmp;
    }

    public function admin_sms_details($id, $date) {
        $this->load->database();
        $this->db->select('*');
        $this->db->from('admin_sms_details');
        $this->db->where('staff_id', $id);
        $this->db->where('date', $date);
        $attDeatil = $this->db->get()->result_array();
        return $attDeatil;
    }

    public function getEmployeelastAttendance($id, $date) {
        $this->load->database();
        $this->db->select('*');
        $this->db->from('acr_emp_activity_detail');
        $this->db->where('staff_id', $id);
        $this->db->where('activity_date', $date);
        $attDeatil = $this->db->get()->result_array();
        return $attDeatil;
    }

    public function manpower() {
        $staff = $this->staffname();
        $project = $this->projectname();

        $LeloMuhM = [];
        $allactivty = $this->Allactivity();
        foreach ($allactivty as $value) {
            if (($value['project_id'] != '') || ($value['project_id'] != NULL)) {
                if(!$project[$value['project_id']]){
                    echo $value['project_id']."~~";
                }
                $LeloMuhM[$project[$value['project_id']]] [$staff[$value['staff_id']]]['TOT_HRS']+= $value['TOT_HRS'];
            }
        }
        echo "<table><tr><th>#</th><th>Project Name</th><th>Employee Name</th><th>Hours Working</th></tr>";
        foreach ($LeloMuhM as $key=>$value) {
            foreach ($value as $key1=>$value1) {
      ?>
<tr><td>#</td><td><?php echo $key; ?></td><td><?php echo $key1; ?></td><td><?php echo $value1['TOT_HRS']; ?></td></tr>
<?php
        }
        }
        
         echo "</table>";
    }

    public function Allactivity() {
        $this->load->database();
//        $this->db->select('a.*,b.title,c.name');
//        $this->db->from('acr_emp_activity_detail as a');
//        $this->db->where("a.activity_date BETWEEN '2017-07-01' AND '2017-07-31'");
//        $this->db->join('test_project_details as b', 'b.id = a.project_id');
//        $this->db->join('company_staff_details as c', 'c.id = a.staff_id');
        $attDeatil = $this->db->query("SELECT `staff_id`,`project_id`, SUM(TIME_TO_SEC(`hour_worked`))/60/60 AS `TOT_HRS` FROM `acr_emp_activity_detail` WHERE `activity_date` BETWEEN '2017-07-01' AND '2017-07-31' GROUP BY `staff_id`, `project_id` WITH ROLLUP")->result_array();
//        echo $this->db->last_query();
//        exit();
        return $attDeatil;
    }

    public function projectname() {
        $this->load->database();
        $this->db->select('id,title');
        $this->db->from('test_project_details');
        $attDeatil = $this->db->get()->result_array();
        $project = array();
        foreach ($attDeatil as $key => $value) {
            $project[$value['id']] = $value['title'];
        }
        return $project;
    }

    public function staffname() {
        $this->load->database();
        $this->db->select('id,name');
        $this->db->from('company_staff_details');
        $attDeatil = $this->db->get()->result_array();
        $staff = array();
        foreach ($attDeatil as $key => $value) {
            $staff[$value['id']] = $value['name'];
        }
        return $staff;
    }

}
