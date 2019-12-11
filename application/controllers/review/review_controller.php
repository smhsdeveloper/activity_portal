<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class review_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('review/review_model', 'modelObj');
        $this->load->model('activity/activity_model', 'att');
    }

    public function empReviews() {
        $this->load->view('review/review_emp', array());
    }

    public function saveSelfReviewEmp() {
        $data = json_decode($this->input->post('data'), true);
        if ($data) {
            $insert = $this->modelObj->saveSelfReviewEmp($data);
            if ($insert) {
                echo printCustomMsg('TRUE');
            } else {
                echo printCustomMsg('FALSE');
            }
        } else {
            echo printCustomMsg('FALSE');
        }
    }

    public function rmReviews() {
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '$1', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrl = str_replace('index.php/', '', $pageUrl1);
        $result = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if (!empty($result)) {
            $data['reviewData'] = $this->modelObj->getRMReviews();
            if ($this->session->userdata('admin_type') == 'ADMIN' || $this->session->userdata('admin_type') == 'RM') {
                $this->load->view('review/review_rm', $data);
            } else {
                echo 'No access';
            }
        } else {
            $this->load->view('error_404view');
        }
    }

    public function saveEmpReviewByRMOrAdmin() {
        $data = json_decode($this->input->post('data'), true);
        if ($data) {
            $insert = $this->modelObj->saveEmpReviewByRMOrAdmin($data);
            if ($insert) {
                echo printCustomMsg('TRUE');
            } else {
                echo printCustomMsg('FALSE');
            }
        } else {
            echo printCustomMsg('FALSE');
        }
    }

    public function getAllRMs() {
        $data['rmDetails'] = $this->modelObj->getAllRMs();
        echo json_encode($data['rmDetails']);
    }

    public function getRMEmpList() {
        $dataObj = json_decode($this->input->post('data'), true);
        $result = $this->modelObj->getRMEmpList($dataObj);
        echo printCustomMsg('TRUE', 'data loaded successfully', $result);
    }

    public function getemprating() {
        $dataObj = json_decode($this->input->post('data'), true);
        $result = $this->modelObj->GetEmpRating($dataObj);
        echo printCustomMsg('TRUE', 'data loaded successfully', $result);
    }

    public function SaveEmpRating() {
        $dataObj = json_decode($this->input->post('data'), true);
        $result = $this->modelObj->SaveEmpRating($dataObj);
        if ($result) {
            echo printCustomMsg('TRUE', 'Rating save successfully');
        } else {
            echo printCustomMsg('ERROR', 'Technical error in rating save.');
        }
    }

    public function GetYearMonthList() {
        $startYear = 2019;
        $startMonth = 10;
        $finalArr = array();
        for ($i = $startYear; $i <= date('Y'); $i++) {
            if ($i == $startYear) {
                $monthStart = $startMonth;
            } else {
                $monthStart = 1;
            }

            if ($i == date('Y')) {
                $limitMonth = date('d') > '26' ? date('n') : (date('n') - 1);
            } else {
                $limitMonth = 12;
            }
            for ($j = $monthStart; $j <= $limitMonth; $j++) {
                $finalArr[] = array('month' => $j, 'year' => $i, 'showYr' => getMonthNames()[$j] . '-' . $i);
            }
        }
        echo printCustomMsg('TRUE', 'Year list loaded successfully.', $finalArr);
    }

    public function GetMonthlyReviews() {
        $dataObj = json_decode($this->input->post('data'), true);
        $result = $this->modelObj->getRMReviews($dataObj['selectedPeroid']);
        echo printCustomMsg('TRUE', 'Data loaded successfully.', $result);
    }

    public function GetSelfReviews() {
        $dataObj = json_decode($this->input->post('data'), true);
        $result = $this->modelObj->getEmpReviews($dataObj['selectedPeroid']);
        echo printCustomMsg('TRUE', 'Data loaded successfully.', $result);
    }

// New code added by Dev
    public function reviewListing() {
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
            $data['reviewData'] = $this->modelObj->getRMReviews();
            if ($this->session->userdata('admin_type') == 'ADMIN' || $this->session->userdata('admin_type') == 'RM') {
                $dataObj = json_decode($this->input->post('data'), true);
                if (!empty($dataObj)) {
                    $reviewData = $this->modelObj->GetReviewData($dataObj);
                    if (isset($dataObj['action']) == 'downloadExcel') {
                        echo $this->downlodaReviewExcel($reviewData);
                    } else {
                        echo json_encode($reviewData);
                    }
                } else {
                    $this->load->view('review/reviewListing');
                }
            } else {
                echo 'No access';
            }
        } else {
            $this->load->view('error_404view');
        }
    }

    public function downlodaReviewExcel($dataArr) {
        ini_set('memory_limit', '2048M');
        if (count($dataArr) > 0) {
            require './assets/PHPExcel/PHPExcel.php';
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = new PHPExcel();

            $uploadFolder = "./files/ReviewReport/";
            $outlinethickborder = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'wrap' => true
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            );
            $filepath = "./files/template/Review.xlsx";

            $objPHPExcel = $objReader->load($filepath);
            $objPHPExcel->getActiveSheet(0);

            $startRow = 2;
            $objPHPExcel->getActiveSheet()->setTitle("Review Details");

            foreach ($dataArr as $key => $val) {
                if (file_exists($filepath)) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $startRow, $key + 1);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $startRow, $val['emp_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $startRow, $val['emp_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $startRow, $val['rm_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $startRow, $val['productivity']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $startRow, $val['job_knowledge']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $startRow, $val['foresightedness_planning']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $startRow, $val['problem_solving_debugging']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $startRow, $val['communication_problem']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $startRow, $val['interpersonal_skills']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $startRow, $val['dedication']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $startRow, $val['deadline_achievement']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $startRow, $val['work_understanding']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $startRow, $val['attendance_punctuality']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $startRow, $val['overall']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P' . $startRow, $val['final_target']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $startRow, $val['final_remark']);
                }
                $startRow = $startRow + 1;
            }
            $fileName = $uploadFolder . date('Ymdhms_') . "ReviewDetails.xlsx";


            if ($fileName != '') {
                if (file_exists($fileName)) {
                    unlink($fileName);
                }
                @mkdir($uploadFolder, 0777, true);
                $baseURL = ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http') . "://{$_SERVER['SERVER_NAME']}" . str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                //echo $baseURL . 'files/ReviewReport/' . basename($fileName); exit;
                $objWriter->save($fileName);
                $fileURL = $baseURL . 'files/ReviewReport/' . basename($fileName);
                if ($fileURL) {
                    return $fileURL;
                }
            }
        }
    }


   

    /* .....................................send review by template (Akash Giri)................... */

    public function empSendReviews() {

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

            $data['reviewData'] = $this->modelObj->getRMReviews();
            if ($this->session->userdata('admin_type') == 'ADMIN') {
                $dataObj = json_decode($this->input->post('data'), true);                
                $this->load->view('review/reviewSetting');
            } else {
                echo 'No access';
            }

            $this->load->view('review/send_review');
        } else {
            $this->load->view('error_404view');
        }
    }

    public function getreviewtemplate() {
        $postdata = json_decode($this->input->post("data"), TRUE);
        $result = $this->modelObj->getreviewstemplate($postdata);
        if (!empty($result)) {
            echo printCustomMsg('TRUE', 'Data loaded successfully.', $result);
        } else {
            echo printCustomMsg('FALSE', 'No data found !', array());
        }
    }

    public function sendreviewemail() {
        $empList = json_decode($this->input->post("data"), TRUE);
        $i = 0;
        foreach ($empList as $row) {
            if (isset($row['ischecked']) && $row['ischecked'] == 1) {
                if ($row['final_remark'] != '' && $row['final_target'] != '') {
                    if ($row['email_address'] != '') {
                        $id = $this->modelObj->insertemaildetails($row);
                        $result = sendMyMail(new PHPMailer(), array($row['email_address']), $row['cc'], $row['subject'], $row['template']);
                        if ($result) {
                            if ($id > 0) {
                                $update = array(
                                    'sent_status' => 1
                                );
                                $this->db->where('emp_id', $row['id']);
                                $this->db->where('id', $id);
                                $this->db->update('email_sent_details', $update);
                            }
                            $i++;
                        } else {
                            
                        }
                    }
                }
            }
        }
        if ($i > 0) {
            echo printCustomMsg('TRUE', 'Email sent successfully', array());
        } else {
            echo printCustomMsg('FALSE', 'Email not send !', array());
        }
    }

    public function emailtemplates() {
        $this->load->model('core/core', 'coreobj');
        $curntUrl = current_url();
        if ($this->uri->segment(3)) {
            $tempVal = $this->uri->segment(3);
            $curntUrl = str_replace($tempVal, '', $curntUrl);
        }
        $pageUrl1 = str_replace(base_url(), '', $curntUrl);
        $pageUrlll = str_replace('index.php/', '', $pageUrl1);
        $pageUrl = rtrim($pageUrlll, '/');
        $data = $this->coreobj->getpermission($pageUrl, $this->session->userdata('company_staff_id'));
        if ($data) {
            $this->load->view('review/email_template');
        } else {
            $this->load->view('error_404view');
        }
    }

    public function sendreminder() {
        $empList = json_decode($this->input->post("data"), TRUE);
        $staff = $this->att->getEmpInfo($this->session->userdata('company_staff_id'));
        $currenttime = date('H:i:s');
        if ($currenttime == '19:00:00') {
            $Day1 = date('d-m-Y');
        } else {
            $Day1 = date('d-m-Y', strtotime("-1 days"));
        }
        $Day2 = date('d-m-Y', strtotime($Day1 . "-1 days"));

        $i = 0;
        $cclist = array();
        foreach ($empList as $row) {
            $this->db->select('email_address');
            $rm_email = $this->db->get_where('company_staff_details', array('active_status' => 'WORKING', 'id' => $row['rm_id']))->row_array();
            $cclist[0] = $rm_email['email_address'];
            if (isset($row['ischecked']) && $row['ischecked'] == 1) {
                if ($row['date0'] == 'NA' || $row['date1'] == 'NA') {
                    if ($row['email_address'] != '') {
                        $day1_status = $this->att->getactivitybydate(date('Y-m-d', strtotime($Day1)), $row['emp_id']);
                        if ($day1_status) {
                            $d1 = '';
                        } else {
                            $d1 = date('dS-F', strtotime($Day1));
                        }
                        $day2_status = $this->att->getactivitybydate(date('Y-m-d', strtotime($Day2)), $row['emp_id']);
                        if ($day2_status) {
                            $d2 = '';
                        } else {
                            $d2 = date('dS-F', strtotime($Day2));
                        }
                        if ($d1 != '' && $d2 != '') {
                            $ss = 'and';
                        } else {
                            $ss = '';
                        }
                        $subject = "Activity punch missed for Date " . $d1 . ' ' . $ss . ' ' . $d2;
                        $msg = "<p>Dear <strong>{name}</strong><br />
                                <br />
                                It has been observed that you have not punched your daily activity for the date " . $d1 . ' ' . $ss . ' ' . $d2 . " Kindly make your entries on immediately basis.<br />
                               <br />
                               <br />
                                                              
                                {send_user}
                                </p>";

                        $body = str_replace('{name}', $row['empname'], $msg);
                        $body1 = str_replace('{send_user}', $staff[0]['name'], $body);
                        $result = sendMyMail(new PHPMailer(), array($row['email_address']), $cclist, $subject, $body1);
                        if ($result == 'true') {
                            $i++;
                        } else {
                            
                        }
                    }
                }
            }
        }
        if ($i > 0) {
            echo printCustomMsg('TRUE', 'Email sent successfully', array());
        } else {
            echo printCustomMsg('FALSE', 'Email not send !', array());
        }
    }

    public function sendsingle() {
        $empList = json_decode($this->input->post("data"), TRUE);
        $currenttime = date('H:i:s');
        if ($currenttime == '19:00:00') {
            $Day1 = date('d-m-Y');
        } else {
            $Day1 = date('d-m-Y', strtotime("-1 days"));
        }
        $Day2 = date('d-m-Y', strtotime($Day1 . "-1 days"));

        $day1_status = $this->att->getactivitybydate(date('Y-m-d', strtotime($Day1)), $empList['emp_id']);
        if ($day1_status) {
            $d1 = '';
        } else {
            $d1 = date('dS-F', strtotime($Day1));
        }
        $day2_status = $this->att->getactivitybydate(date('Y-m-d', strtotime($Day2)), $empList['emp_id']);
        if ($day2_status) {
            $d2 = '';
        } else {
            $d2 = date('dS-F', strtotime($Day2));
        }
        if ($d1 != '' && $d2 != '') {
            $ss = 'and';
        } else {
            $ss = '';
        }
        $cclist = array();
        $this->db->select('email_address');
        $rm_email = $this->db->get_where('company_staff_details', array('active_status' => 'WORKING', 'id' => $empList['rm_id']))->row_array();
        $cclist[0] = $rm_email['email_address'];
        $staff = $this->att->getEmpInfo($this->session->userdata('company_staff_id'));
        $i = 0;
        if (isset($empList['ischecked']) && $empList['ischecked'] == 1) {
            if ($empList['date0'] == 'NA' || $empList['date1'] == 'NA') {
                if ($empList['email_address'] != '') {
                    $subject = "Activity punch missed for Date " . $d1 . ' ' . $ss . ' ' . $d2;
                    $msg = "<p>Dear <strong>{name}</strong><br />
                                <br />
                                It has been observed that you have not punched your daily activity for the date " . $d1 . ' ' . $ss . ' ' . $d2 . " Kindly make your entries on immediately basis.<br />
                               <br />
                               <br />
                                                              
                                {send_user}
                                </p>";
                    $body = str_replace('{name}', $empList['empname'], $msg);
                    $body1 = str_replace('{send_user}', $staff[0]['name'], $body);
                    $result = sendMyMail(new PHPMailer(), array($empList['email_address']), $cclist, $subject, $body1);
                    if ($result == 'true') {
                        $i++;
                    } else {
                        
                    }
                }
            }
        }
        if ($i > 0) {
            echo printCustomMsg('TRUE', 'Email sent successfully', array());
        } else {
            echo printCustomMsg('FALSE', 'Email not send !', array());
        }
    }
    
    
    /*************Code Added By Dev   *************/
    
       public function getFinancialYearList() {
        $fyList = getFinancialYearList();
        if (!empty($fyList)) {
            echo printCustomMsg('TRUE', 'Data loaded successfully.', $fyList);
        }
    }

    public function reviewSetting() {
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
            $data['reviewData'] = $this->modelObj->getRMReviews();
            if ($this->session->userdata('admin_type') == 'ADMIN') {
                $dataObj = json_decode($this->input->post('data'), true);                
                $this->load->view('review/reviewSetting');
            } else {
                echo 'No access';
            }
        } else {
            $this->load->view('error_404view');
        }
    }

    public function getReviewSettings() {
        $fy = json_decode($this->input->post('data'), true);
        $result = $this->modelObj->GetReviewSettings($fy['selectedFy']);
        echo printCustomMsg('TRUE', 'data loaded successfully', $result);
    }

    public function getMonthList() {
        $monthList = array();
        $monthList = getMonthNames();
        if (!empty($monthList)) {
            echo printCustomMsg('TRUE', 'Data loaded successfully.', $monthList);
        }
    }
    
    public function saveReviewSettings(){
        $dataObj = json_decode($this->input->post('data'), true);
        $result = $this->modelObj->SaveReviewSettings($dataObj);
        if ($result) {
            echo printCustomMsg('TRUE', 'Review Settings save successfully');
        } else {
            echo printCustomMsg('ERROR', 'Technical error in review settings save.');
        }
    }
    public function deleteReviewSettings(){
       $dataObj = json_decode($this->input->post('data'), true);
        $result = $this->modelObj->DeleteReviewSettings($dataObj);
        if ($result) {
            echo printCustomMsg('TRUE', 'Review Settings deleted successfully', $result);
        } else {
            echo printCustomMsg('ERROR', 'Technical error in review settings delete.', $result);
        } 
    }
    public function getRemainTime(){
        $dataObj = json_decode($this->input->post('data'), true);
        $result = $this->modelObj->GetRemainTime($dataObj);
        if (!empty($result)) {
            echo printCustomMsg('TRUE', 'Data loaded successfully.', $result);
        }
    }

}

?>