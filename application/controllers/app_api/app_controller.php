<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class app_controller extends CI_Controller {

    public function testapi($action = NULL) {
        $this->load->model("app_api/app_model", "app");
        $this->load->view("testapi", array("action" => $action));
    }

    public function registration() {
        $this->load->model("app_api/app_model", "app");
        $data = json_decode($this->input->post("data"), TRUE);
        echo $this->app->registration($data);
    }

    public function login() {
        $this->load->model("app_api/app_model", "app");
        $data = json_decode($this->input->post("data"), TRUE);
        echo $this->app->login($data);
    }

    public function dashboard() {
        $data = json_decode($this->input->post("data"), TRUE);
        $accessKey = $data['access_key'];
        $this->load->model("app_api/app_model", "app");
        $loginInfo = $this->app->getLoginInfo($accessKey);
        if ($loginInfo) {
            $this->load->model('testing/projectmanagement_model', "ModelObj");
            $result = $this->ModelObj->myactivity($loginInfo['company_staff_id']);
            echo json_encode($result);
        } else {
            echo '{"type":"FALSE","message":"Invalid Access Key","result":"ERROR","value":"0"}';
        }
    }

    public function otpvalidation() {
        $data = json_decode($this->input->post("data"), TRUE);
        $accessKey = $data['access_key'];
        $this->load->model("app_api/app_model", "app");
        $loginInfo = $this->app->getLoginInfo($accessKey);
        if ($loginInfo) {
            $result = $this->app->validateOTP($data['otp'],$loginInfo['company_staff_id']);
            echo $result;
        } else {
            echo '{"type":"FALSE","message":"Invalid Access Key","result":"ERROR","value":"0"}';
        }
    }
    
    public function projectlist() {
        $data = json_decode($this->input->post("data"), TRUE);
        $accessKey = $data['access_key'];
        $this->load->model("app_api/app_model", "app");
        $loginInfo = $this->app->getLoginInfo($accessKey);
        if ($loginInfo) {
            $result = $this->app->getProjectList();
            echo $result;
        } else {
            echo '{"type":"FALSE","message":"Invalid Access Key","result":"ERROR","value":"0"}';
        }
    }
    
    public function modulelist() {
        $data = json_decode($this->input->post("data"), TRUE);
        $accessKey = $data['access_key'];
        $this->load->model("app_api/app_model", "app");
        $loginInfo = $this->app->getLoginInfo($accessKey);
        if ($loginInfo) {
            $result = $this->app->getModuleList($data['project_id']);
            echo $result;
        } else {
            echo '{"type":"FALSE","message":"Invalid Access Key","result":"ERROR","value":"0"}';
        }
    }
    
    public function activitylist() {
        $data = json_decode($this->input->post("data"), TRUE);
        $accessKey = $data['access_key'];
        $this->load->model("app_api/app_model", "app");
        $loginInfo = $this->app->getLoginInfo($accessKey);
        if ($loginInfo) {
            $result = $this->app->getActivityList();
            echo $result;
        } else {
            echo '{"type":"FALSE","message":"Invalid Access Key","result":"ERROR","value":"0"}';
        }
    }

    public function activityentry() {
        $data=json_decode($this->input->post("data"),true);
        $accessKey = $data['access_key'];
        $this->load->model("app_api/app_model", "app");
        $loginInfo = $this->app->getLoginInfo($accessKey);
        if ($loginInfo) {
            $result = $this->app->activityentry($data,$loginInfo);
            echo $result;
        } else {
            echo '{"type":"FALSE","message":"Invalid Access Key","result":"ERROR","value":"0"}';
        }
    }

}
