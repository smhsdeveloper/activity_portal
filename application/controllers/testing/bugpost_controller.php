<?php

class bugpost_controller extends MY_Controller {

    public function BugPostNow($projectId=-1,$moduleId=-1,$developer_id=-1) {
        $this->load->model('testing/bugpost_model', 'modelObj');
        $projectdetail = $this->modelObj->GetProjectModule();
        $moduledetail = $this->modelObj->GetProjectModuleName($moduleId);
        $this->load->view('testing/bugpost_view.php', array("projectId" => $projectId,"module_title"=>$moduledetail,"myprojectarr" => $projectdetail,"moduleId"=>$moduleId,"developer_id"=>$developer_id));
    }

}
