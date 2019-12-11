<?php

class staffapp_model extends CI_Model {

    public function checkLoginDetail($postDataObj) {
        $staffData = array();
        $this->db->select('id,name,designation,email_address,mobile_for_sms');
        $staffData = $this->db->get_where('company_staff_details', array('email_address' => $postDataObj['staff_email']))->row_array();

        if (empty($staffData)) {
            return -1;
        }
        $this->db->select('access_key');
        $accessKey = $this->db->get_where('user_access_apikey', array('staff_id' => $staffData['id']))->row_array();

        if (empty($accessKey)) {
            $myAccesskey = $this->GenrateAccesskey();
           $this->db->insert('user_access_apikey', array('staff_id' => $staffData['id'], 'access_key' => $myAccesskey));
            if ($this->db->insert_id()) {
                $staffData['access_key'] = $myAccesskey;
                return $staffData;
            }
        } else {
            $staffData['access_key'] = $accessKey['access_key'];
            return $staffData;
        }
    }


    public function GenrateAccesskey() {
        $Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
        $QuantidadeCaracteres = strlen($Caracteres);
        $QuantidadeCaracteres--;
        $Hash = NULL;
        for ($x = 1; $x <= 32; $x++) {
            $Posicao = rand(0, $QuantidadeCaracteres);
            $Hash .= substr($Caracteres, $Posicao, 1);
        }
        return $Hash;
    }

    public function myDashboardData($postDataObj) {
        $staffaccessKey = $this->checkStaffAccesskey($postDataObj);
        if (!empty($staffaccessKey)) {
            $todaydate = date('Y-m-d');
            $dayss = date("l", strtotime($todaydate));
            $holidayDay = $this->getholiday($todaydate);
          if (!empty($holidayDay) || $dayss == 'Sunday') {
                return 'HOLIDAY';
            }
            $dateArray = array();
           if ($dayss == 'Monday') {
                $dateArray[] = $todaydate;
            } elseif ($dayss == 'Tuesday') {
                while (count($dateArray) < 3) {
                    $date = $todaydate;
                    $dateArray[] = $date;
                    $todaydate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                }
            } elseif ($dayss == 'Wednesday') {
                while (count($dateArray) < 4) {
                    $date = $todaydate;
                    $dateArray[] = $date;
                    $todaydate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                }
            } elseif ($dayss == 'Thursday') {
                while (count($dateArray) < 5) {
                    $date = $todaydate;
                    $dateArray[] = $date;
                    $todaydate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                }
            } elseif ($dayss == 'Friday') {
                while (count($dateArray) < 6) {
                    $date = $todaydate;
                    $dateArray[] = $date;
                    $todaydate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                }
            } else {
                while (count($dateArray) < 7) {
                    $date = $todaydate;
                    $dateArray[] = $date;
                    $todaydate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                }
            }
          
            $todaydate = date('Y-m-d');
            $weekHr_Wrkd = 0;
            foreach ($dateArray as $value) {
                $this->db->select('sum(TIME_TO_SEC(hour_worked)) AS hour_worked');
                $work_time = $this->db->get_where('acr_emp_activity_detail', array('staff_id' => $postDataObj['staff_id'], 'activity_date' => $value))->result_array();
                foreach ($work_time as $hr_wrked) {

                    $weekHr_Wrkd = $weekHr_Wrkd + $hr_wrked['hour_worked'];
                }
            }
            $totalWeekWrkTime = gmdate('H:i:s', $weekHr_Wrkd);

            $todayWrkTime = 0;
            $this->db->select('sum(TIME_TO_SEC(hour_worked)) AS hour_worked');
            $todayHrwrked = $this->db->get_where('acr_emp_activity_detail', array('staff_id' => $postDataObj['staff_id'], 'activity_date' => $todaydate))->result_array();
            foreach ($todayHrwrked as $hr_wrked) {

                $todayWrkTime = $todayWrkTime + $hr_wrked['hour_worked'];
            }
            $todayTotalWrkTime = gmdate('H:i:s', $todayWrkTime);
            if ($todayTotalWrkTime == '00:00:00') {
                $todayTotalWrkTime = 'NA';
            }
            return array('totalWeekWrkedHr' => $totalWeekWrkTime, 'todayWrkTime' => $todayTotalWrkTime);
        } else {
            return -1;
        }
    }

    public function getholiday($date) {
        $this->load->database();
        $this->db->select('holiday_name');
        $this->db->from('holiday_list');
        $this->db->where('date', $date);
        $holidayDeatil = $this->db->get()->result_array();
        return $holidayDeatil;
    }

    public function projectList($postDataObj) {
        $staffaccessKey = $this->checkStaffAccesskey($postDataObj);
        if (!empty($staffaccessKey)) {

                $this->db->select('title,id');
                $projectList = $this->db->get('test_project_details')->result_array();
            
            $start_date = date('Y-m-d');
            $lastdate = date('Y-m-d', strtotime('-7 day', strtotime($start_date)));
            $this->db->select('TIME_TO_SEC(hour_worked) AS hour_worked,project_id,');
            $this->db->from('acr_emp_activity_detail');
            $this->db->where('staff_id ', $postDataObj['staff_id']);
            $this->db->where('activity_date  BETWEEN "' . date('Y-m-d', strtotime($lastdate)) . '" and "' . date('Y-m-d', strtotime($start_date)) . '"');
            $myProjectData = $this->db->get_where()->result_array();
            $summedArray = array();
            foreach ($myProjectData as $data) {
                $summedArray[$data['project_id']] = isset($summedArray[$data['project_id']]) ? $summedArray[$data['project_id']] + $data[hour_worked] : $data[hour_worked];
            }
            $maxHrWorkdID = FALSE;
            $maxHourWorked = 0;
            foreach ($summedArray as $k => $val) {
                if ($val > $maxHourWorked) {
                    $maxHourWorked = $val;
                    $maxHrWorkdID = $k;
                }
            }
            $this->db->select('title,id');
            $projectTitle = $this->db->get_where('test_project_details', array('id' => $maxHrWorkdID))->row_array();
            $todaydate = date('M/d/Y', strtotime($start_date));
            $currentTime = date('h:i a');
            return array('projectlist' => $projectList, 'maxTimeTknPrjct' => $projectTitle,'todaydate'=>$todaydate,'currentime'=>$currentTime);
        } else {
            return -1;
        }
    }

    public function getModuleList($postDataObj) {
        $staffaccessKey = $this->checkStaffAccesskey($postDataObj);
        if (!empty($staffaccessKey)) {
            $this->db->select('title,id');
            $moduleList = $this->db->get_where('test_project_modules_details', array('project_id' => $postDataObj['project_id']))->result_array();
            //$moduleList = array_column($moduleList, "title");
            $start_date = date('Y-m-d');
            $lastdate = date('Y-m-d', strtotime('-7 day', strtotime($start_date)));
            $this->db->select('TIME_TO_SEC(hour_worked) AS hour_worked,module_id,');
            $this->db->from('acr_emp_activity_detail');
            $this->db->where('staff_id ', $postDataObj['staff_id']);
            $this->db->where('activity_date  BETWEEN "' . date('Y-m-d', strtotime($lastdate)) . '" and "' . date('Y-m-d', strtotime($start_date)) . '"');
            $myModuleData = $this->db->get_where()->result_array();
            $summedArray = array();
            foreach ($myModuleData as $data) {
                $summedArray[$data['module_id']] = isset($summedArray[$data['module_id']]) ? $summedArray[$data['module_id']] + $data[hour_worked] : $data[hour_worked];
            }
            $maxHrWorkdID = FALSE;
            $maxHourWorked = 0;
            foreach ($summedArray as $k => $val) {
                if ($val > $maxHourWorked) {
                    $maxHourWorked = $val;
                    $maxHrWorkdID = $k;
                }
            }
            $this->db->select('title,id');
            $moduleTitle = $this->db->get_where('test_project_modules_details', array('id' => $maxHrWorkdID))->row_array();
            return array('moduleList' => $moduleList, 'maxTimeTknModule' => $moduleTitle);
        } else {
            return -1;
        }
    }

    public function getactivityList($postDataObj) {
        $staffaccessKey = $this->checkStaffAccesskey($postDataObj);
        if (!empty($staffaccessKey)) {
            $this->db->select('activity_name,id');
            $activityList = $this->db->get_where('acr_activity_master_list')->result_array();
            //$activityList = array_column($activityList, "activity_name");
            return $activityList;
        } else {
            return -1;
        }
    }

    public function getTaskDetails($postDataObj) {
        $staffaccessKey = $this->checkStaffAccesskey($postDataObj);
        if (!empty($staffaccessKey)) {
            $this->db->select('a.id,b.title as project,c.title as module,d.activity_name,a.remarks,a.activity_status,a.hour_worked,');
            $this->db->join('test_project_details as b', 'a.project_id = b.id', 'left');
            $this->db->join('test_project_modules_details as c', 'a.module_id = c.id', 'left');
            $this->db->join('acr_activity_master_list as d', 'a.activity_id = d.id', 'left');
            $taskdata['data'] = $this->db->get_where('acr_emp_activity_detail as a', array('a.id' => $postDataObj['id'], 'a.staff_id' => $postDataObj['staff_id']))->result_array();
            $this->db->select('start_time,pause_time');
            $data = $this->db->get_where('emp_workdetail', array('ac_id' => $postDataObj['id']))->result_array();
            $taskdata['time'] = $data;
            return $taskdata;
        } else {
            return -1;
        }
    }

    public function restartTask($postDataObj) {
        $staffaccessKey = $this->checkStaffAccesskey($postDataObj);
        if (!empty($staffaccessKey)) {
            $myArray = array(
                'ac_id' => $postDataObj['id'],
                'start_time' => date('H:i:s'),
                'pause_time' => '00:00:00',
                'status' => 'START'
            );
            $this->db->insert('emp_workdetail', $myArray);
            if ($this->db->affected_rows() > 0) {
                $this->db->where('id', $postDataObj['id']);
                $this->db->update('acr_emp_activity_detail', array('activity_status' => 'START'));
                $data = $this->getFullTaskDetail($postDataObj);
                return $data;
            }
        } else {
            return -1;
        }
    }

    public function stopTask($postDataObj) {
        $staffaccessKey = $this->checkStaffAccesskey($postDataObj);
        if (!empty($staffaccessKey)) {
            $myArray = array(
                'pause_time' => date("H:i:s"),
                'status' => 'PAUSED'
            );
            $this->db->select_max('id');
            $lastid = $this->db->get_where('emp_workdetail', array('ac_id' => $postDataObj['id']))->row_array();
            $this->db->where('id', $lastid['id']);
            $this->db->update('emp_workdetail', $myArray);
            if ($this->db->affected_rows() > 0) {
                $hrwrked = $this->calculateTime($postDataObj['id']);
                $hrwrked = gmdate('H:i:s', $hrwrked);
                $this->db->where('id', $postDataObj['id']);
                $this->db->update('acr_emp_activity_detail', array('activity_status' => 'PAUSED', 'hour_worked' => $hrwrked));
                $data = $this->getFullTaskDetail($postDataObj);
                return $data;
            }
        } else {
            return -1;
        }
    }

    public function getReports($postDataObj) {
        $staffaccessKey = $this->checkStaffAccesskey($postDataObj);
        if (!empty($staffaccessKey)) {
            $todaydate = date('Y-m-d');
            $dateArray = array();
            while (count($dateArray) < 8) {
                $date = $todaydate;
                $dateArray[] = $date;
                $todaydate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
            }
            $data=array();
            foreach ($dateArray as $value) {
                $this->db->select('b.title as project,c.title as module,d.activity_name,a.remarks,a.hour_worked,a.activity_date');
                $this->db->join('test_project_details as b', 'a.project_id = b.id', 'left');
                $this->db->join('test_project_modules_details as c', 'a.module_id = c.id', 'left');
                $this->db->join('acr_activity_master_list as d', 'a.activity_id = d.id', 'left');
                $data[] = array("date"=>$value,"data"=>$this->db->get_where('acr_emp_activity_detail as a', array('a.activity_date' => $value, 'a.staff_id' => $postDataObj['staff_id']))->result_array());
                 
            }
             return $data;
            
        } else {
            return -1;
        }
    }

    public function calculateTime($id) {
        $this->db->select('start_time,pause_time');
        $this->db->from('emp_workdetail');
        $this->db->where('ac_id', $id);
        $data = $this->db->get()->result_array();
        $totaltime = "00:00:00";
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['pause_time'] === '00:00:00') {
                $paused = date('H:i:s');
            } else {
                $paused = $data[$i]['pause_time'];
            }
            $timedifference = strtotime($paused) - strtotime($data[$i]['start_time']);
            $totaltime += $timedifference;
        }
        return $totaltime; //gmdate('H:i:s', $totaltime);
    }

    public function getAllholiday() {
        $this->db->select('date');
        $this->db->from('holiday_list');
        $holidayDeatil = $this->db->get()->result_array();
        return $holidayDeatil;
    }

    public function checkStaffAccesskey($postDataObj) {
        $this->db->select('access_key');
        $staffAccessKey = $this->db->get_where('user_access_apikey', array('staff_id' => $postDataObj['staff_id'], 'access_key' => $postDataObj['access_key']))->row_array();
        return $staffAccessKey;
    }

    

    public function getTodayTaskDetails($postDataObj) {
        $staffaccessKey = $this->checkStaffAccesskey($postDataObj);
        $today = date('Y-m-d');
        if (!empty($staffaccessKey)) {
            $this->db->select('b.title as project,c.title as module,d.activity_name,a.remarks,a.activity_status,a.hour_worked');
            $this->db->join('test_project_details as b', 'a.project_id = b.id', 'left');
            $this->db->join('test_project_modules_details as c', 'a.module_id = c.id', 'left');
            $this->db->join('acr_activity_master_list as d', 'a.activity_id = d.id', 'left');
            $TodayTasks = $this->db->get_where('acr_emp_activity_detail as a', array('a.activity_date' => $today, 'a.staff_id' => $postDataObj['staff_id']))->result_array();
            return $TodayTasks;
        } else {
            return -1;
        }
    }

     public function saveTaskDetails($postDataObj) {
        $rm_id = $this->getRmId($postDataObj['staff_id']);
        $dataArray = array(
            'project_id' => $postDataObj['project_id'],
            'module_id' => $postDataObj['module_id'],
            'activity_id' => $postDataObj['activity_id'],
            'remarks' => $postDataObj['workdetail'],
            'activity_date' => date('Y-m-d'),
            'hour_worked' => 0,
            'activity_status' => 'START',
            'staff_id' => $postDataObj['staff_id'],
            'staff_rm_id' => $rm_id['rm_id'],
            'entry_from' => 'APP'
        );
       
        $this->db->insert('acr_emp_activity_detail', $dataArray);
        $lastInsertId = $this->db->insert_id();
        $this->saveDetail($lastInsertId);
        if ($lastInsertId > 0) {
            $data = $this->getFullTaskDetail($postDataObj['staff_id']);
            return $data;
        }else {
            return -1;
        }
    }
    
     public function saveDetail($id) {
        $totaltime = strtotime(date('H:i:s')) - strtotime(0);
        $myArray = array(
            'ac_id' => $id,
            'start_time' => date('H:i:s'),
            'pause_time' => '00:00:00',
            'status' => 'START'
        );
        $this->db->insert('emp_workdetail', $myArray);
        $lastId = $this->db->insert_id();
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return -1;
        }
    }
    
     public function getFullTaskDetail($postDataObj) {
        $empid = $postDataObj['staff_id'];
        $date = date('Y-m-d');
        $this->db->select('b.title,a.remarks,a.id,a.staff_id,a.staff_rm_id,a.project_id,a.module_id,a.activity_id,a.activity_status');
        $this->db->join('test_project_details as b', 'a.project_id = b.id', 'left');
        $data = $this->db->get_where('acr_emp_activity_detail as a', array('a.activity_date' => $date, 'a.staff_id' => $empid))->result_array();
        for ($k = 0; $k < count($data); $k++) {
            $id = $data[$k]['id'];
            $data[$k]['timer'] = $this->calculateTime($id);
        }

        
        return array('data' => $data);
    }
    
    public function checkstartwork($postDataObj) {
         $date = date('Y-m-d');
        $this->db->select('activity_status,id');
        $start = $this->db->get_where('acr_emp_activity_detail', array('activity_status' => 'START', 'staff_id' => $postDataObj['staff_id'], 'activity_date' => $date))->result_array();
        $this->db->where('id', $start[0]['id']);
        $this->db->update('acr_emp_activity_detail', array('activity_status' => 'PAUSED'));
        $myArray = array(
            'pause_time' => date("H:i:s"),
            'status' => 'PAUSED'
        );
        $this->db->select_max('id');
        $lastid = $this->db->get_where('emp_workdetail', array('ac_id' => $start[0]['id']))->row_array();
        $this->db->where('id', $lastid['id']);
        $this->db->update('emp_workdetail', $myArray);
        return $start;
    }
    
    public function getRmId($id) {
         $this->db->select('rm_id,name,designation');
        $this->db->where('id', $id);
        $rm_id = $this->db->get("company_staff_details")->row_array();
        return $rm_id;
    }

}
