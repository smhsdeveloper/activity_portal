<?php

//error_reporting(E_ALL);
//ini_set('display_error', 1);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class projectmanagement_controller extends MY_Controller {

    public function AddProjects($project_id = -1) {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $resultName = $this->ModelObj->GetProjectName($project_id);
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $url = explode('/', $curntUrl);
            array_pop($url);
            $curntUrl=implode('/', $url);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);

        $pageUrlll = str_replace('index.php/', '', $pageUrl1);
        $pageUrl = rtrim($pageUrlll, '/');
        $data = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if (!empty($data)) {
            $this->load->view('testing/projectmanagement.php', array("project_id" => $project_id, "project_name" => isset($resultName['title'])?$resultName['title']:''));
        } else {
            $this->load->view('error_404view');
        }
    }

    public function adddepartment() {
//        $this->load->view('testing/adddepartment');
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrlll = str_replace('index.php/', '', $pageUrl1);
        $pageUrl = rtrim($pageUrlll, '/');
        $data = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if ($data) {
            $this->load->view('testing/adddepartment');
        } else {
            $this->load->view('error_404view');
        }
    }

    public function TestingMain() {
        $usertype = $this->session->userdata('admin_type');

        $userid = $this->session->userdata('company_staff_id');
        $workinghrs = $this->session->userdata('workinghrs');
        $currenttime = date('H:i:s');
        if ($currenttime == '19:00:00') {
            $Day1 = date('d-m-Y');
        } else {
            $Day1 = date('d-m-Y', strtotime("-1 days"));
        }
        $Day2 = date('d-m-Y', strtotime($Day1 . "-1 days"));
        $this->load->view('testing/main.php', array("usertype" => $usertype, "userid" => $userid, "workinghrs" => $workinghrs, "Day1" => $Day1, "Day2" => $Day2));
    }

    public function DeveloperBugDetails($bug_id = -1) {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->GetBugStatus($bug_id);
        $resultName = $this->ModelObj->GetDeveloperTesterName($bug_id);
        $resultRemark = $this->ModelObj->GetRemarkMessageModel($resultName['module_id']);
        $this->load->view('testing/developerbugdetail.php', array("bug_id" => $bug_id, "bug_details" => isset($result) ? $result : '', "remark_details" => isset($resultRemark) ? $resultRemark : '', "team_name" => isset($resultName) ? $resultName : ''));
    }

    public function TesterBugDetails($bug_id = -1) {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->GetBugStatus($bug_id);
        $resultName = $this->ModelObj->GetDeveloperTesterName($bug_id);
        $resultRemark = $this->ModelObj->GetRemarkMessageModel($resultName['module_id']);
        $this->load->view('testing/testerbugdetail.php', array("bug_id" => $bug_id, "bug_details" => isset($result) ? $result : '', "remark_details" => isset($resultRemark) ? $resultRemark : '', "team_name" => isset($resultName) ? $resultName : ''));
    }

    public function myactivity() {
//        echo 'hi';
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $uid = $this->input->post('data');
        $result = $this->ModelObj->myactivity($uid);
        echo json_encode($result);
    }

    public function dailyemailData() {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->alluser();
        $data = json_decode($result, TRUE);
        $this->load->view('activity/email', array('data' => $data));
    }

    public function dailyemail() {
          require_once FCPATH . "/assets/phpmailer/class.phpmailer.php";
        $to = array("adarsh.labh@invetechsolutions.com");
//$cc = array('adarsh.labh@invetechsolutions.com');
        $cc = array('devang.tyagi@invetechsolutions.com');
        $subject = "Activity Not Punched";
        $timeout = ini_get("default_socket_timeout");
        ini_set("default_socket_timeout", 900);
        $message = file_get_contents(base_url() . "index.php/dailyemaildata");
        ini_set("default_socket_timeout", $timeout);
        $attachment =array();
        if ($this->sendMyMail(new PHPMailer(), $attachment, $to, $cc, $subject, $message)) {
            echo "Meter Sync Status Sent\n";
        } else {
            echo "Error in sending Meter Sync status mail\n";
        }
    }

    public function myrmactivity() {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $uid = $this->input->post('data');
        $result = $this->ModelObj->myrmactivity($uid);
        echo $result;
    }

    public function alluser() {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->alluser();
        echo $result;
    }

    public function validateotp() {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $otp = $this->input->post('data');
        $today = $this->input->post('date');
        $result = $this->ModelObj->validateotp($otp, $today);
        if ($result) {
            echo '{"STATUS":"SUCCESS","msg":"OTP validate"}';
        } else {
            echo '{"STATUS":"ERR","msg":"OTP Not Found"}';
        }
    }

    public function otpvalidation() {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $today = $this->input->post('date');
        $result = $this->ModelObj->IsOTPvalidate($today);
        if ($result == 'YES') {
            echo '{"validated":"YES"}';
        } else {
            echo '{"validated":"NO"}';
        }
    }

    public function AdminBugDetails($projectId = -1, $moduleId = -1) {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $resultproject = $this->ModelObj->GetProject();
        $resultprojectmodule = $this->ModelObj->GetProjectModule($projectId);
        $this->load->view('testing/adminbugdetail.php', array("projectId" => $projectId, "arrProject" => $resultproject, "moduleId" => $moduleId, "arrModule" => $resultprojectmodule));
    }

    public function CompanyLoginDetail() {
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->checkLoginDetail(json_decode($this->input->post('data'), true));
        if ($result == "TRUE") {
            echo printCustomMsg("TRUE", "Login Successfully", null);
        } else {
            echo printCustomMsg("FALSE", $result, null);
        }
    }

    public function UpdateBugStatusDeveloper() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->UpdateBugStatus_model($myArr);
        if ($result == true) {
            echo printCustomMsg("TRUE", 'YES', null);
        } else {
            echo printCustomMsg("FALSE", "NO", null);
        }
    }

    public function UpdateBugStatusTester() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->UpdateBugStatusTester_model($myArr);
        if ($result == true) {
            echo printCustomMsg("TRUE", 'YES', null);
        } else {
            echo printCustomMsg("FALSE", "NO", null);
        }
    }

    public function UpdateBugPendingStatusTester() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->UpdateBugPendingStatusTester_model($myArr);
        if ($result == true) {
            echo printCustomMsg("TRUE", 'YES', null);
        } else {
            echo printCustomMsg("FALSE", "NO", null);
        }
    }

    public function SaveRemarkMessage() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('testing/projectmanagement_model', "ModelObj");
        $result = $this->ModelObj->SaveRemarkMessageModel($myArr);
        if ($result == true) {
            echo printCustomMsg("TRUE", 'YES', null);
        } else {
            echo printCustomMsg("FALSE", "NO", null);
        }
    }

    public function sendMyMail($mail, $attachFile, $EmailContactJson, $cc, $subject, $msgContent) {
        $mail->IsSMTP();
        $mail->Host = "smtp.postmarkapp.com";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'b0666373-ba9a-494e-832f-2659b6c7a12e';
        $mail->Password = 'b0666373-ba9a-494e-832f-2659b6c7a12e';
//    $mail->Username = 'ad7b7094-4214-48ca-8690-bddf536b8178';
//    $mail->Password = 'ad7b7094-4214-48ca-8690-bddf536b8178';
        $mail->Subject = $subject;
        $mail->MsgHTML($msgContent);
        $mail->SetFrom('solutions@smartechenergy.in', 'SmarTech Energy Management');
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

}
