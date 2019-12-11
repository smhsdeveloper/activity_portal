<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class staffkitgeneration_controller extends MY_Controller {

    public function index() {

        $this->load->view('login/staffkitgeneration_view.php');
    }

    public function GetAllStaff() {
        $this->load->model('login/staffkitgeneration_model', 'modelSysObj');
        $result = $this->modelSysObj->GetFinalSystemUserDetails();

       echo json_encode(array("myStaffList" => $result));
    }

    public function ResetPassword() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('login/staffkitgeneration_model', 'modelPwdObj');
        $result_updated = $this->modelPwdObj->UpdatePassword($myArr);
        echo json_encode(array("myResultPwdResult" => $result_updated));
    }

    public function UpdateLoginStatus() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('login/staffkitgeneration_model', 'modelUpObj');
        $result_status = $this->modelUpObj->UpdateLoginStatusModel($myArr);
        echo json_encode(array("myActivatedResult" => $result_status));
    }

    public function SendSmsDetails() {
        $myArr = json_decode($this->input->post('data'), true);
        foreach ($myArr as $value) {
            if (!empty($value['smsSend'])) {
                $arrSendSms[] = array("username" => $value['username'], "password" => $value['password']);
            }
        }
        print_r($arrSendSms);
    }

}
