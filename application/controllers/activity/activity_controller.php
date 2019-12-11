<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class activity_controller extends MY_Controller {

    public function activityentry() {
//        $this->load->view('activity/activity_entry');
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrlll = str_replace('index.php/', '', $pageUrl1);
        $pageUrl = rtrim($pageUrlll, '/');
        $result = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if (!empty($result)) {
            $this->load->view('activity/activity_entry');
        } else {
            $this->load->view('error_404view');
        }
    }

    public function taskentry() {
        $this->load->view('activity/activitytask');
    }

    public function addholiday($y = NULL, $m = NULL) {
//        $this->load->view('activity/holiday_view', array("year" => $y, "month" => $m));
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(2)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrlll = str_replace('index.php/', '', $pageUrl1);
        $pageUrl = rtrim($pageUrlll, '/');
        $result = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if (!empty($result)) {
            $this->load->view('activity/holiday_view', array("year" => $y, "month" => $m));
        } else {
            $this->load->view('error_404view');
        }
    }

    public function attendance($entryDate = -1) {
//        $this->load->view('activity/attendance_view', array('entryDate' => $entryDate));
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrlll = str_replace('index.php/', '', $pageUrl1);
        $pageUrl = rtrim($pageUrlll, '/');
        $result = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if (!empty($result)) {
            $this->load->view('activity/attendance_view', array('entryDate' => $entryDate));
        } else {
            $this->load->view('error_404view');
        }
    }

    public function userid() {
//        $this->load->view('activity/userid_genration');
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrlll = str_replace('index.php/', '', $pageUrl1);
        $pageUrl = rtrim($pageUrlll, '/');
        $result = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if (!empty($result)) {
            $this->load->view('activity/userid_genration');
        } else {
            $this->load->view('error_404view');
        }
    }

    public function otpdetails() {
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '$1', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrl = str_replace('index.php/', '', $pageUrl1);
        $result = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if ($result) {
            $this->load->view('activity/otpdetails');
        } else {
            $this->load->view('error_404view');
        }
    }

    public function addemployee() {
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '$1', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrl = str_replace('index.php/', '', $pageUrl1);
        $result = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if ($result) {
            $this->load->view('activity/addemployee_view');
        } else {
            $this->load->view('error_404view');
        }
    }

    public function adddesignation() {
//        $this->load->view('activity/add_designation_view');
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrlll = str_replace('index.php/', '', $pageUrl1);
        $pageUrl = rtrim($pageUrlll, '/');
        $result = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if (!empty($result)) {
            $this->load->view('activity/add_designation_view');
        } else {
            $this->load->view('error_404view');
        }
    }

    public function adddrm() {
        $this->load->view('activity/add_rm');
    }

    public function projectyentry() {
        $this->load->view('activity/project_entry_view');
    }

    public function empactivityentry($entryDate = -1) {
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrlll = str_replace('index.php/', '', $pageUrl1);
        $pageUrl = rtrim($pageUrlll, '/');
        $result = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if (!empty($result)) {
            $this->load->view('activity/empl_activity_entry_view', array('entryDate' => $entryDate));
        } else {
            $this->load->view('error_404view');
        }
    }

    public function viewactivity($fromyDate = -1, $toDate = -1, $empid = -1) {
        $this->load->model('activity/activity_model', 'emObj');
        $hourworked = $this->emObj->getEmpHour($fromyDate, $toDate, $empid);
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrlll = str_replace('index.php/', '', $pageUrl1);
        $pageUrl = rtrim($pageUrlll, '/t!0..9-0..9-0..9');
        $result = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if (!empty($result)) {
            $this->load->view('activity/activity_view', array('fromDate' => $fromyDate, 'toDate' => $toDate, 'empid' => $empid, 'hourworked' => $hourworked));
        } else {
            $this->load->view('error_404view');
        }
    }

    public function emplisttype() {

        $type = $this->session->userdata('admin_type');
        $emid = $this->session->userdata('company_staff_id');
        $this->load->model('activity/activity_model', 'empmodelObj');
        $empname = $this->empmodelObj->emplisttype($type, $emid);
        echo json_encode($empname);
    }

    public function moduleentry() {
        $data = $this->input->post("data");
        $modules = $this->input->post("module");
        $this->load->model('activity/activity_model', 'empmodelObj');
        $module = $this->empmodelObj->moduleentry($data, $modules);
        echo $module;
    }

    public function newactivity() {
        $data = $this->input->post("data");
        $modules = $this->input->post("module");
        $activity = $this->input->post("module");
        $this->load->model('activity/activity_model', 'empmodelObj');
        $act = $this->empmodelObj->newactivity($data, $modules, $activity);
        echo $act;
    }

    public function newtask() {
        $data = json_decode($this->input->post("data"), TRUE);
        $this->load->model('activity/activity_model', 'empmodelObj');
        $act = $this->empmodelObj->newtask($data);
        echo $act;
    }

    public function projectlist() {
        $this->load->model('activity/activity_model', 'empmodelObj');
        $empname = $this->empmodelObj->projectlist();
        echo json_encode($empname);
    }

    public function modulelist() {
        $this->load->model('activity/activity_model', 'empmodelObj');
        $data = $this->input->post('data');
        $module = $this->empmodelObj->modulelist($data);
        echo json_encode($module);
    }

    public function activitylist() {
        $this->load->model('activity/activity_model', 'empmodelObj');
        $activity = $this->empmodelObj->activitylist();
        echo json_encode($activity);
    }

    public function allempDetails() {
        $this->load->model('activity/activity_model', 'att');
        $date = date('Y-m-d', strtotime($this->input->post('date')));
        $empname = $this->att->allempDetails($date);
        echo $empname;
    }

    public function markabsent() {
        $this->load->model('activity/activity_model', 'att');
        $date = date('Y-m-d', strtotime($this->input->post('date')));
        $data = $this->input->post('data');
        $empname = $this->att->markAttendance($date, $data);
        echo $empname;
    }

    public function attendancevis() {
        $this->load->model('activity/activity_model', 'att');
        $date = date('Y-m-d');
        $empname = $this->att->TodayAttendanceInfo($date);
        echo $empname;
    }

    public function otpvalidate() {
        $data = $this->input->post('data');
        $this->load->model('activity/activity_model', 'att');
        $empname = $this->att->activityvalidateornot($data);
        echo $empname;
    }

    public function totalhour() {
        $this->load->model('activity/activity_model', 'empmodelObj');
        $totalhour = $this->empmodelObj->totalHour();
        echo json_encode($totalhour);
    }

    public function sendEmail() {
        $this->load->model('activity/activity_model', 'empmodelObj');
        $data = $this->input->post("data");
        $totalhour = $this->empmodelObj->sendEmail($data);
        echo $totalhour;
//        echo json_encode($totalhour);
    }

    /*     * ******************************************************************Akhileshkarn************************************* */

    public function viewActivitySummary($fromyDate = null, $toDate = null, $empid = null) {
        if (!$fromyDate) {
            $fromyDate = "01-" . date("m-Y");
        }
        if (!$toDate) {
            $toDate = date("d-m-Y");
        }
        $this->load->model('activity/activity_model', 'emObj');
        $emp = $this->emObj->getEmpInfo($empid);
        if ($emp) {
            $empname = $emp[0]['name'];
        } else {
            $empname = NULL;
        }
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrlll = str_replace('index.php/', '', $pageUrl1);
        $pageUrl = rtrim($pageUrlll, '/t!0..9-0..9-0..9');
        $result = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if (!empty($result)) {
            $this->load->view('activity/activitysummary_view', array('fromDate' => $fromyDate, 'toDate' => $toDate, 'empid' => $empid, "empname" => $empname));
        } else {
            $this->load->view('error_404view');
        }
    }

    public function viewProjectSummary() {
        $this->load->view('activity/viewprojectsummary');
    }

    public function getActivitySummary() {
        $this->load->model('activity/activity_model', 'emObj');
        $from = $this->input->post("from");
        $to = $this->input->post("to");
        $empid = $this->input->post("empid");
        $summary = $this->emObj->getActivitySummary($from, $to, $empid);
        echo json_encode($summary);
    }

    public function exportSummary() {
        //code changed By gaurav Rupani on 2nd Sept 2017
        //Reason: Want to remove two fields, Attendance and OTS validation
        $this->load->model('activity/activity_model', 'emObj');
        $from = $this->input->post("from");
        $to = $this->input->post("to");
        $changed_formt_from = date('Y_m_d', strtotime($from));
        $changed_formt_to = date('Y_m_d', strtotime($to));
        if ($this->input->post("empid")) {
            $employee = $this->emObj->getEmpInfo($this->input->post("empid"));
            $filename = str_replace(" ", "_", $employee[0]['name'] . date('_Y_m_d', strtotime($from)) . "_to_" . date('Y_m_d', strtotime($to)) . ".xlsx");
        } else {
            $employee = $this->emObj->empName("Manager");
            $filename = date('Y_m_d', strtotime($from)) . "_to_" . date('Y_m_d', strtotime($to)) . ".xlsx";
        }

        if (count($employee) > 0) {
            require './assets/PHPExcel/PHPExcel.php';

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getStyle("A4:A5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth('19');
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setAutoSize(false);
            $objPHPExcel->getActiveSheet()
                    ->SetCellValue('A1', 'Date From :')
                    ->SetCellValue('C1', 'Date To :')
                    ->SetCellValue('B1', $from)
                    ->SetCellValue('D1', $to)
                    ->SetCellValue('A4', 'Employee Name')
                    ->SetCellValue('A5', 'Date');
            $eachthickborder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                )
            );
            $outlinethickborder = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                )
            );
            $outlinethinborder = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            $styleArray = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => 'FF0000'),
                    'size' => 9,
                    'name' => 'Verdana'
            ));

            $styleArray1 = array(
                'font' => array(
                    'size' => 9,
                    'name' => 'Verdana'
            ));

            $start = "B";
            $end = "D";
            $col = 0;
            foreach ($employee as $emp) {

                $summary = $this->emObj->getActivitySummary($from, $to, $emp['id']);
                $numrows = count($summary['summary']) + 5;
                $objPHPExcel->getActiveSheet()->getStyle("A4:A5")->applyFromArray($eachthickborder);
                $objPHPExcel->getActiveSheet()->getStyle("A6:A$numrows")->applyFromArray($outlinethickborder);
                if (count($summary['summary']) > 0) {
                    $index = 6;
                    $newstart = $start;
                    $col++;

                    $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth('21');
                    $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(false);
                    $objPHPExcel->getActiveSheet()
                            ->SetCellValue($newstart . '4', $emp['name'])
                            ->SetCellValue($newstart . '5', "Activity");
                    $newstart++;
                    // ????  $objPHPExcel->getActiveSheet()->getStyle($start . "4:$newstart" . $numrows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $i = 0;
                    foreach ($summary['summary'] as $val) {
                        if ($val['activity'] == "0 hour 0 min. ( 0 )") {
                            $i++;
                        } else {
                            
                        }


                        $newstart = $start;

                        $objPHPExcel->getActiveSheet()->SetCellValue($newstart . $index, $val['activity']);
                        $objPHPExcel->getActiveSheet()->getStyle($start . "6:" . $newstart . $numrows)->getFont()->setSize(9);
                        $objPHPExcel->getActiveSheet()->getStyle($start . "5:" . $newstart . "5")->applyFromArray($eachthickborder);
                        $objPHPExcel->getActiveSheet()->getStyle($start . "5:" . $newstart . $numrows)->applyFromArray($outlinethickborder);
                        $index++;
                    }
                    if ($i > 0) {
                        $objPHPExcel->getActiveSheet()->getStyle($newstart . '4')->applyFromArray($styleArray);
                    } else {
                        $objPHPExcel->getActiveSheet()->getStyle($newstart . '4')->applyFromArray($styleArray1);
                    }
                    $start++;

                    $end++;
                }
            }
            $index = 6;
            $objPHPExcel->getActiveSheet()->getStyle("A6:A$numrows")->getFont()->setSize(9)->setBold(true);

            foreach ($summary['summary'] as $val) {
                $objPHPExcel->getActiveSheet()->SetCellValue("A" . $index, $val['date']);
                $index++;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objPHPExcel->getActiveSheet()->setTitle('Activity Report');
            $dir = './files/ActivityReport/EmployeeActivitySummary/';
            @mkdir($dir, 0777, true);
            $file = $dir . $filename;
            if (file_exists($file)) {
                unlink($file);
            }
            $objWriter->save($file);
            echo '{"status":"SUCCESS","path":"' . $file . '","message":"Report Generated Successfully."}';
            unset($styleArray);
        }
    }

    public function exportSummary_oldbackup() {
        $this->load->model('activity/activity_model', 'emObj');
        $from = $this->input->post("from");
        $to = $this->input->post("to");
        $changed_formt_from = date('Y_m_d', strtotime($from));
        $changed_formt_to = date('Y_m_d', strtotime($to));
        if ($this->input->post("empid")) {
            $employee = $this->emObj->getEmpInfo($this->input->post("empid"));
            $filename = str_replace(" ", "_", $employee[0]['name'] . date('_Y_m_d', strtotime($from)) . "_to_" . date('Y_m_d', strtotime($to)) . ".xlsx");
        } else {
            $employee = $this->emObj->empName("Manager");
            $filename = date('Y_m_d', strtotime($from)) . "_to_" . date('Y_m_d', strtotime($to)) . ".xlsx";
        }

        if (count($employee) > 0) {
            require './assets/PHPExcel/PHPExcel.php';

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getStyle("A4:A5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth('19');
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setAutoSize(false);
            $objPHPExcel->getActiveSheet()
                    ->SetCellValue('A1', 'Date From :')
                    ->SetCellValue('C1', 'Date To :')
                    ->SetCellValue('B1', $from)
                    ->SetCellValue('D1', $to)
                    ->SetCellValue('A4', 'Employee Name')
                    ->SetCellValue('A5', 'Date');
            $eachthickborder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                )
            );
            $outlinethickborder = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                )
            );
            $outlinethinborder = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $start = "B";
            $end = "D";
            $col = 0;
            foreach ($employee as $emp) {

                $summary = $this->emObj->getActivitySummary($from, $to, $emp['id']);
                $numrows = count($summary['summary']) + 5;
                $objPHPExcel->getActiveSheet()->getStyle("A4:A5")->applyFromArray($eachthickborder);
                $objPHPExcel->getActiveSheet()->getStyle("A6:A$numrows")->applyFromArray($outlinethickborder);
                if (count($summary['summary']) > 0) {
                    $index = 6;
                    $newstart = $start;
                    $col++;
                    //  $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth('12');
                    //$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(false);
                    //$col++;
                    //$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth('13');
                    //$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(false);
                    //$col++;
                    $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth('21');
                    $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(false);
                    //   $objPHPExcel->setActiveSheetIndex(0)->mergeCells($start . '4:' . $end . '4');
                    $objPHPExcel->getActiveSheet()
                            //   ->SetCellValue($newstart . '4', $emp['name'])
                            ->SetCellValue($newstart . '5', "Activity");
                    $newstart++;
                    //$objPHPExcel->getActiveSheet()->SetCellValue($newstart . '5', "OTP Validation");
                    //$newstart++;
                    $objPHPExcel->getActiveSheet()->SetCellValue($newstart . '5', "Hour Worked");
                    // ????  $objPHPExcel->getActiveSheet()->getStyle($start . "4:$newstart" . $numrows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    foreach ($summary['summary'] as $val) {
                        $newstart = $start;
                        //     $objPHPExcel->getActiveSheet()->getStyle($newstart . "4:" . $newstart . "4")->applyFromArray($outlinethickborder);
                        //    $objPHPExcel->getActiveSheet()->SetCellValue($newstart . $index, $val['punch']);
                        //   $newstart++;
                        //  $objPHPExcel->getActiveSheet()->SetCellValue($newstart . $index, $val['otp']);
                        // $objPHPExcel->getActiveSheet()->getStyle($newstart . "6:" . $newstart . $numrows)->applyFromArray($outlinethinborder);
                        //$newstart++;
                        $objPHPExcel->getActiveSheet()->SetCellValue($newstart . $index, $val['activity']);
                        $objPHPExcel->getActiveSheet()->getStyle($start . "6:" . $newstart . $numrows)->getFont()->setSize(9);
                        $objPHPExcel->getActiveSheet()->getStyle($start . "5:" . $newstart . "5")->applyFromArray($eachthickborder);
                        $objPHPExcel->getActiveSheet()->getStyle($start . "5:" . $newstart . $numrows)->applyFromArray($outlinethickborder);
                        $index++;
                    }
                    $start++;
                    // $start++;
                    //$start++;
                    //$end++;
                    //$end++;
                    $end++;
                }
            }
            $index = 6;
            $objPHPExcel->getActiveSheet()->getStyle("A6:A$numrows")->getFont()->setSize(9)->setBold(true);

            foreach ($summary['summary'] as $val) {
                $objPHPExcel->getActiveSheet()->SetCellValue("A" . $index, $val['date']);
                $index++;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objPHPExcel->getActiveSheet()->setTitle('Activity Report');
            $dir = './files/ActivityReport/EmployeeActivitySummary/';
            @mkdir($dir, 0777, true);
            $file = $dir . $filename;
            if (file_exists($file)) {
                unlink($file);
            }
            $objWriter->save($file);
            echo '{"status":"SUCCESS","path":"' . $file . '","message":"Report Generated Successfully."}';
            unset($styleArray);
        }
    }

    public function getProjectList() {
        $this->load->model('activity/activity_model', 'emObj');
        $projectList = $this->emObj->getProjectList();
        echo json_encode($projectList);
    }

    public function getProjectSummary() {
        $prjId = $this->input->post("prjId");
        $this->load->model('activity/activity_model', 'emObj');
        $prjSummary = $this->emObj->getProjectSummary($prjId);
        echo json_encode($prjSummary);
    }

    public function exportProjectSummary() {
        //  exit('test1');
        $prjId = $this->input->post("prjId");
        $this->load->model('activity/activity_model', 'emObj');
        $summary = $this->emObj->getProjectSummary($prjId);
        if (count($summary['mod']) > 0) {
            require './assets/PHPExcel/PHPExcel.php';
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $eachthickborder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                )
            );
            $outlinethickborder = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK
                    )
                )
            );
            $objPHPExcel->getActiveSheet()
                    ->SetCellValue('A1', 'Project : ')
                    ->SetCellValue('B1', $summary['prj'])
                    ->SetCellValue('A3', 'Modules');
            $row = 4;
            foreach ($summary['mod'] as $mod) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $mod['title']);
                $col = 1;
                foreach ($mod['dev'] as $dev) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dev["time"]);
                    $col++;
                }
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $mod["totalTime"]);
                $row++;
            }
            $col = 1;
            $acol = "B";
            foreach ($summary['dev'] as $dev) {
                $objPHPExcel->getActiveSheet()->getStyle($acol . "4:$acol" . ($row - 1))->applyFromArray($outlinethickborder);
                $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth('19');
                $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(false);
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow($col, $row, $dev["total"])
                        ->setCellValueByColumnAndRow($col, 3, $dev["name"]);
                $col++;
                $acol++;
            }
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow($col, $row, $summary["total"])
                    ->setCellValueByColumnAndRow(0, $row, "Total")
                    ->setCellValueByColumnAndRow($col, 0, "Total")
                    ->setCellValueByColumnAndRow($col, 3, 'Total')
                    ->getStyle("A1:A$row")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A3:$acol" . "3")->applyFromArray($eachthickborder);
            $objPHPExcel->getActiveSheet()->getStyle("A$row:$acol" . $row)->applyFromArray($eachthickborder);
            $objPHPExcel->getActiveSheet()->getStyle("A4:A$row")->applyFromArray($outlinethickborder);
            $objPHPExcel->getActiveSheet()->getStyle($acol . "4:$acol" . $row)->applyFromArray($outlinethickborder);
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth('30');
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getStyle("A3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("B3:$acol" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("B$row:$acol" . $row)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("B3:" . $acol . "3")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle($acol . "4:" . $acol . ($row - 1))->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A3:$acol" . $row)->getFont()->setSize(9);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objPHPExcel->getActiveSheet()->setTitle('Activity Report');
            $dir = './files/ActivityReport/ProjectActivitySummary/';
            $filename = $summary['prj'] . ".xls";
            @mkdir($dir, 0777, true);
            $file = $dir . $filename;
            if (file_exists($file)) {
                unlink($file);
            }
            $objWriter->save($file);
            echo printCustomMsg("SUCCESS", "Report Generated successfully.", "files/ActivityReport/ProjectActivitySummary/$filename");
        }
    }

    /*     * *******************************************Nitin***************************** */

    public function saveWorkDetails() {
        $data = json_decode($this->input->post('data'), TRUE);
        $rmid = $this->session->userdata('staff_rm_id');
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->saveWorkDetails($data, $rmid);
        echo json_encode($result);
    }

    public function getTableDetail() {
        $this->load->model('activity/activity_model', 'att');
        $getdata = $this->att->getTableDetail();
        echo json_encode($getdata);
    }

    public function pauseWorkDetail() {
        $data = json_decode($this->input->post('data'), TRUE);
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->pauseWorkTimer($data);
        if (count($result) > 0) {
            echo json_encode($result);
        }
    }

    public function startWorkDetail() {
        $data = json_decode($this->input->post('data'), TRUE);
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->startWorkTimer($data);
        if (count($result) > 0) {
            echo json_encode($result);
        }
    }

    public function checkStartWork() {
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->checkStartWork();
        if (count($result) > 0) {
            echo json_encode(count($result));
        } else {
            echo json_encode(count($result));
        }
    }

    public function stopActivityStatus() {
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->stopActivityStatus();
        if ($result > 0) {
            echo $result;
        }
    }

    public function saveModule() {
        $data = json_decode($this->input->post('data'), TRUE);
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->saveModule($data);
        if ($result > 0) {
            echo json_encode($result);
        }
    }

    public function saveActivity() {
        $data = json_decode($this->input->post('data'), TRUE);
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->saveActivity($data);
        if ($result > 0) {
            echo json_encode($result);
        }
    }

    public function gettestingproject() {
        $emid = $this->session->userdata('company_staff_id');
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->gettestingproject($emid);
        if ($result > 0) {
            echo '{"status":"SUCCESS","msg":"Project List Loaded","value":' . json_encode($result) . '}';
        } else {
            echo '{"status":"ERR","msg":"Project List Not Loaded","value":"-1"}';
        }
    }

    public function manageversion($project_id = 0, $version = 0) {
        $emid = $this->session->userdata('company_staff_id');
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->gettestingproject($emid);
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrlll = str_replace('index.php/', '', $pageUrl1);
        $pageUrl = rtrim($pageUrlll, '/t!0..9');
        $data = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if (!empty($data)) {
            $this->load->view('activity/manage_version', array("project_id" => $project_id, "version" => $version));
        } else {
            $this->load->view('error_404view');
        }
    }

    /* ........Akash Giri (Monthwise Report)27-6-18............................................ */

    public function viewActivityMonthWise() {
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '$1', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrl = str_replace('index.php/', '', $pageUrl1);
        $result = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if ($result) {
            $this->load->view('activity/activityreport_monthwise_view');
        } else {
            $this->load->view('error_404view');
        }
    }

    public function getprojectlists() {
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->getprojectlists();
        if (!empty($result)) {
            echo '{"status":"SUCCESS","msg":"Project List Loaded","value":' . json_encode($result) . '}';
        } else {
            echo '{"status":"ERR","msg":"Project List Not Loaded","value":' . json_encode(array()) . '}';
        }
    }

    public function getmonthwisereport() {
        $postdata = json_decode($this->input->post('data'), TRUE);
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->getmonthsactivity($postdata);
        if (!empty($result)) {
            echo '{"status":"SUCCESS","msg":"Report List Loaded","value":' . json_encode($result) . '}';
        } else {
            echo '{"status":"ERR","msg":"Project List Not Loaded","value":' . json_encode(array()) . '}';
        }
    }

    public function viewActiviyChart() {
        $this->load->view('activity/activitychart_view');
    }

    public function getbarchartdata() {
        $postdata = json_decode($this->input->post('data'), TRUE);
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->getmonthsactivity($postdata);
        if (!empty($result)) {
            echo '{"status":"SUCCESS","msg":"Report List Loaded","value":' . json_encode($result) . '}';
        } else {
            echo '{"status":"ERR","msg":"Project List Not Loaded","value":' . json_encode(array()) . '}';
        }
    }

    public function viewtoptenproject() {
        $this->load->view('activity/topten_project_view');
    }

    public function viewdailysummary($staff_id, $project_id, $month_id, $year) {
        $this->load->view('activity/activity_dailysummary', array('staff_id' => $staff_id, 'project_id' => $project_id, 'month_id' => $month_id, 'year' => $year));
    }

    public function getmonthactivitydata() {
        $postdata = json_decode($this->input->post('data'), TRUE);
        $this->load->model('activity/activity_model', 'att');
        $result = $this->att->getmonthdatabyid($postdata);
        if (!empty($result)) {
            echo '{"status":"SUCCESS","msg":"Report List Loaded","value":' . json_encode($result) . '}';
        } else {
            echo '{"status":"ERR","msg":"Project List Not Loaded","value":' . json_encode($result) . '}';
        }
    }

}
