<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
      parent::__construct();
//      echo "<pre>";
//      print_r($this->session->userdata);exit;
        if (!$this->session->userdata('logintype')) {
                redirect("/");
            }
    }

}
