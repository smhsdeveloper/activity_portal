<?php

class masterlogin_controller extends MY_Controller {

    public function MasterLogin($userId = 'NA') {
        if ($this->session->userdata('logintype') == 'COMPANY') {
            $this->load->model('login/masterlogin_model', 'modelObj');
            $resultData = $this->modelObj->GetSchooldata($userId);
            $this->load->view('login/masterlogin_view', array("schoolRecord" => $resultData));
        } else {
            $this->load->view('error_view');
        }
    }

    public function GetSchoolList() {
        $this->load->model('login/masterlogin_model', 'modelObj');
        $schoolList = $this->modelObj->GetAllSchoolList();
        echo json_encode($schoolList);
    }

    public function GetFullSchoolDetail() {
        $dataObj = json_decode($this->input->post('data'));
        $this->load->model('login/masterlogin_model', 'modelObj');
        $result = $this->modelObj->GetFullDeatils($dataObj);
        echo json_encode($result);
    }

    public function SerachStudent() {
        $studentName = $this->input->get('search');
        $schoolId = $this->input->get('schoolId');
        $myType = $this->input->get('type');
        $this->load->model('login/masterlogin_model', 'modelObj');
        $searchData = $this->modelObj->GetUserIdForRequest($studentName, $schoolId, $myType);
        echo json_encode(array("results" => $searchData));
    }

}
