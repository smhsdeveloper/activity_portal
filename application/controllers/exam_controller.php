<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class exam_controller extends CI_Controller {

    public function exam($examkey = NULL, $examtype = NULL) {
        $this->load->view('activity/examview', array("examkey" => $examkey, "examtype" => $examtype));
    }

}
