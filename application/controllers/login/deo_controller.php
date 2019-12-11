<?php

class deo_controller extends MY_Controller {

    public function index() {
        $this->load->view('login/deohomepage_view.php');
    }

    public function GetAllStaff() {
        $this->load->model('login/deo_model', 'modelObj');
        $result = $this->modelObj->GetAllStaffData();
        echo json_encode($result);
    }

    public function SuperLogin() {
        $this->load->model('login/deo_model', 'objDeomodel');

        $dataObj = json_decode($this->input->post('data'));
        $user_id = $dataObj->user_id;
        $login_from = $dataObj->logintype;

        $school_code = $this->session->userdata['school_code'];
        if ($login_from == 'DEO') {
            $staff_id = $this->session->userdata('deo_staff_id');

            $login_person_id = $this->objDeomodel->GetDeoUserId($staff_id,  $school_code,'STAFF');
        } elseif ($login_from == 'COMPANY') {
            $staff_id = $this->session->userdata('company_staff_id');
            $login_person_id = $this->objDeomodel->GetDeoUserId($staff_id, 'hello dear farzi value',$login_from);
        } else {
            exit('wrong type');
        }
        // echo $staff_id;
       //  echo '-';
        //echo $login_person_id;
       // exit();
        $this->load->model('login/login_model', 'modelObj');
        $result = $this->modelObj->SuperLogin($user_id, $login_from, $login_person_id);
        if ($result == -1) {
            echo printCustomMsg("SAVEERR", "Login id not created ", -1);
        } else {
            echo printCustomMsg("TRUE", "login successfully", $result);
        }
    }

}
