<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class studentkitgeneration_controller extends MY_Controller {

    public function index() {

        $this->load->view('login/studentkitgeneration_view.php');
    }

    public function GetAllSections() {

        $this->load->model('core/core', 'modelCoreObj');
        $result_section = $this->modelCoreObj->GetAllSection();
        echo json_encode(array("mySectionList" => $result_section));
    }

    public function GetAllStudents() {
        $section_id = json_decode($this->input->post('section_id'), true);

        $this->load->model('login/studentkitgeneration_model', 'modelSysObj');
        $result = $this->modelSysObj->GetFinalSystemUserDetails($section_id);
        echo json_encode(array("myStudList" => $result));
    }

    public function ResetPassword() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('login/studentkitgeneration_model', 'modelPwdObj');
        $result_updated = $this->modelPwdObj->UpdatePassword($myArr);
         echo json_encode(array("myResultPwdResult" => $result_updated));
    }

    public function UpdateLoginStatus() {
        $myArr = json_decode($this->input->post('data'), true);
        $this->load->model('login/studentkitgeneration_model', 'modelUpObj');
        $result_status = $this->modelUpObj->UpdateLoginStatusModel($myArr);
        echo json_encode(array("myActivatedResult" => $result_status));
    }

    public function SendSmsDetails() {
        $myArr = json_decode($this->input->post('data'), true);
        foreach($myArr as $value){
            if(isset($value['smsSend'])){
               $arrSendSms[]=array("username"=>$value['username'],"password"=>$value['password']);
            }
        }
        print_r($arrSendSms);
    }

}
