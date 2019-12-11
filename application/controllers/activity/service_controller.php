<?php

class service_controller extends CI_Controller {

    public function InformationOfActivity() {
        $this->load->model('activity/activity_model', 'modelObj');
        $empList = $this->modelObj->GetEmpInformationOfActivity();
//        $smsResult = $this->modelObj->NightMessageDeatils();
        $result = $this->sendMyMail($empList);
    }

    public function ReminderOfActivity() {
        $this->load->model('activity/activity_model', 'modelObj');
        $empList = $this->modelObj->ReminderForReport();
//        $smsResult = $this->modelObj->MorningMessageDeatils();
        $result = $this->sendMyMail($empList);
    }

    public function sendMyMail($empList) {
        $emailConfig = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.postmarkapp.com',
            'smtp_port' => 587,
            'smtp_user' => 'ad7b7094-4214-48ca-8690-bddf536b8178', //Valid Email ID
            'smtp_pass' => 'ad7b7094-4214-48ca-8690-bddf536b8178', //Valid password
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'newline' => '\r\n'
        );
        $empNameArrToday = array();
        $empNameArrPre = array();
        $this->load->library('email', $emailConfig);
        $this->email->initialize($emailConfig);
        $serviceType = $empList[0]['serviceType'];
        foreach ($empList as $row) {
            if ($row['status'] == 'BOTH') {
                $empNameArrToday[] = $row['name'];
                $empNameArrPre[] = $row['name'];
            } else if ($row['status'] == 'TODAY') {
                $empNameArrToday[] = $row['name'];
            } else if ($row['status'] == 'PREVIOUS') {
                $empNameArrPre[] = $row['name'];
            }
            if ($row['email_address'] != '' && $row['message'] != '' && $row['email_status'] == 'YES') {
                $this->email->from('alert@meraschoolportal.com', 'SmartechEnergy');
                $this->email->to($row['email_address']);
                $this->email->subject($row['subject']);
                $this->email->message($row['message']);
                if ($this->email->send()) {
                    echo "Mail Sent!";
                } else {
                    echo "FALSE";
                }
            }
        }
        if ($serviceType == 'NIGHT') {
            $empNameTodayMiss = implode(',', $empNameArrToday);
            $empNamePreMiss = implode(',', $empNameArrPre);
            $this->StatusSendAdmin($emailConfig, $empNameTodayMiss, $empNamePreMiss, $empList);
        }
    }

    public function StatusSendAdmin($emailConfig, $empNameTodayMiss, $empNamePreMiss, $empList) {
        $this->load->library('email', $emailConfig);
        $this->email->initialize($emailConfig);
        $arr = explode(",", $empNameTodayMiss);
        $arr1 = explode(",", $empNamePreMiss);
        $message = "Dear Admin,<p>Today:" . count($arr) . " /" . count($empList) . "<br>Missed by:" . $empNameTodayMiss . "<br>
Yesterday: " . count($arr1) . " /" . count($empList) . "<br>Missed by:" . $empNamePreMiss . "</p>";
        foreach ($empList as $row) {
            if ($row['email_address'] != '' && $row['email_status'] == 'YES' && $row['admin_type'] == 1) {
                $this->email->from('alert@meraschoolportal.com', 'SmartechEnergy');
                $this->email->to($row['email_address']);
                $this->email->subject($row['subject']);
                $this->email->message($message);
                if ($this->email->send()) {
                    echo "Mail Sent!";
                } else {
                    echo "FALSE";
                }
            }
        }
    }

}
