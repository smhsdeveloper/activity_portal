<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class email_controller extends CI_Controller {
    
    public function fetchrmlist() {
        $this->load->model('activity/email_model', 'emailmodelObj');
        $empname = $this->emailmodelObj->fetchrmlist();
        echo json_encode($empname);
    }
    
}
