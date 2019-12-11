<?php

class auto_controller extends CI_Controller {

    public function empforotp() {

        $this->load->model('activity/auto_model', 'att');
        $this->att->empforotp();
    }

    public function empforreminder() {
        $this->load->model('activity/auto_model', 'att');
        $this->att->empforreminder();
    }

    public function adminSMS() {
        $this->load->model('activity/auto_model', 'att');
        echo $empname = $this->att->adminSMS();
    }

    public function manpower() {

        $this->load->model('activity/auto_model', 'att');
        $result = $this->att->manpower();
        $this->load->view('activity/manpower_view', array('output' => $result));
    }

}
