<?php

class bugpost_model extends CI_Model {

    public function GetProjectModule() {
        $this->load->database();
        $this->db->select('id,title');
        $projectDeatil = $this->db->get("test_project_details")->result_array();
        return $projectDeatil;
    }
    public function GetProjectModuleName($moduleId) {
        $this->load->database();
        $this->db->select('title');
        $this->db->where('id',$moduleId);
        $moduleDeatil = $this->db->get("test_project_modules_details")->result_array();
        if(!empty($moduleDeatil)){
        return $moduleDeatil[0]['title'];
        }
    }

}
