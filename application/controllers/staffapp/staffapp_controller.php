<?php
class staffapp_controller extends CI_Controller {

    public function loginMe() {
//        $postDataObj = json_decode('{"staff_email":"adarsh.labh@invetechsolutions.com"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $stafffulldata = $this->modelObj->checkLoginDetail($postDataObj);
        if ($stafffulldata != -1) {
            echo json_encode(array("status" => "TRUE", "message" => "Login success.", "value" => $stafffulldata));
        } else {
            echo printCustomMsg('ERROR', 'Invalid Login detail,please contact to admin..', -1);
        }
    }
    
     public function projectFullData() {
        
        //$postDataObj = json_decode('{"staff_id":"1","access_key":"2WPHX6EFFY6A9EA12C6VQPEIAV9O7EX0","project_id":"5557", TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE); 

        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $taskDetails = $this->modelObj->projectFullData($postDataObj);
        if ($taskDetails != -1) {
            echo json_encode(array('tasksdata' => $taskDetails));
        }
        else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }
    
    public function punchActivity() {
        
        //$postDataObj = json_decode('{"staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD","project_id":"3","module_id":"31","activity_id":"10","workdetail":"Algorithm for module","activity_date":"Wed Nov 02 2016 00:00:00 GMT+0530 (IST)","start_timer":"Thu Jan 01 1970 16:00:00 GMT+0530 (IST)","stop_timer":"Thu Jan 01 1970 20:00:00 GMT+0530 (IST)"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE); 

        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $taskDetails = $this->modelObj->punchActivity($postDataObj);
        if ($taskDetails != -1) {
            echo json_encode(array("status" => "TRUE", "message" => "Activity punched successfully", "value" => $taskDetails));
        }elseif ($taskDetails === 'invalidtime' ) {
            echo printCustomMsg('ERROR', 'Please enter correct time..!!', -1);
        } 
        else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }




    public function myDashboardData() {
        //$postDataObj = json_decode('{"staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $workDetails = $this->modelObj->myDashboardData($postDataObj);
        if ($workDetails == -1) {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        } elseif ($workDetails == 'HOLIDAY') {
            echo printCustomMsg('ERROR', 'Today is a Holiday..!!', $workDetails);
        } else {
            echo json_encode(array('workdetail' => $workDetails));
        }
    }

    public function taskEntry() {
//        $postDataObj = json_decode('{"staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $projectList = $this->modelObj->projectList($postDataObj);
        if ($projectList != -1) {
            echo json_encode(array('projectlist' => $projectList));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function moduleList() {
//        $postDataObj = json_decode('{"staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD","project_id":"3"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $moduletList = $this->modelObj->getModuleList($postDataObj);
        if ($moduletList != -1) {
            echo json_encode(array('modulelist' => $moduletList));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function activityList() {
//        $postDataObj = json_decode('{"staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $activityList = $this->modelObj->getactivityList($postDataObj);
        if ($activityList != -1) {
            echo json_encode(array('activitylist' => $activityList));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function getTaskDetails() {
//        $postDataObj = json_decode('{"id":"5517","staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $taskDetail = $this->modelObj->getTaskDetails($postDataObj);
        if ($taskDetail != -1) {
            echo json_encode(array('taskdetail' => $taskDetail));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function restartTask() {
//        $postDataObj = json_decode('{"id":"5522","staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $data = $this->modelObj->restartTask($postDataObj);
        if ($restartTask != -1) {
            echo json_encode(array('data' => $data));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function stopTask() {
//      $postDataObj = json_decode('{"id":"5522","staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $data = $this->modelObj->stopTask($postDataObj);
        if ($stopTask != -1) {
            echo json_encode(array('data' => $data));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function reports() {
//      $postDataObj = json_decode('{"staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $reports = $this->modelObj->getReports($postDataObj);
        if ($reports != -1) {
            echo json_encode(array('reports' => $reports));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function getfulltaskdetail() {
//     $postDataObj = json_decode('{"staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $data = $this->modelObj->getFullTaskDetail($postDataObj);
        if ($reports != -1) {
            echo json_encode(array('data' => $data));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function checkstartwork() {
//       $postDataObj = json_decode('{"staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $data = $this->modelObj->checkstartwork($postDataObj);
        if ($reports != -1) {
            echo json_encode(array('data' => $data));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function getTodayTaskDetails() {
//        $postDataObj = json_decode('{"staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $todaytask = $this->modelObj->getTodayTaskDetails($postDataObj);
        if ($todaytask != -1) {
            echo json_encode(array('todaytasks' => $todaytask));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

    public function saveTaskDetails() {
//        $postDataObj = json_decode('{"staff_id":"6","access_key":"FME4715LYVE8AZDV1XXB43L89PPO7AZD","project_id":"3","module_id":"31","activity_id":"10","workdetail":"Algorithm for module"}', TRUE);
        $postDataObj = json_decode($this->input->post('data'), TRUE);
        $this->load->model('staffapp/staffapp_model', 'modelObj');
        $taskDetails = $this->modelObj->saveTaskDetails($postDataObj);
        if ($todaytask != -1) {
            echo json_encode(array('tasksdetail' => $taskDetails));
        } else {
            echo printCustomMsg('ERROR', 'Invalid detail,please contact to admin..', -1);
        }
    }

}
