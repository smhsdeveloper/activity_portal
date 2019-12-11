<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
define('Window_Open', (date('Y-m') . '-26'));

class review_model extends CI_Model {

    public function getEmpReviews($dataObj) {
        $userId = $this->session->userdata('company_staff_id');
        if ($userId != '') {
            $result = array();
            $tempDate = date('Y-m');
            $getCurrentYear = date("Y");
            if (!empty($dataObj)) {
                $tempDate = $dataObj['year'] . '-' . $dataObj['month'] . '-1';
                $getCurrentYear = $dataObj['year'];
            }
            $getPreviousMonth = date('m', strtotime($tempDate . ' -1 month'));
            $result = $this->db->get_where("review_details", array('emp_id' => $userId, 'month' => $getPreviousMonth, 'year' => $getCurrentYear))->row_array();
            $target = $remark = $self_target = $self_achievement = $rm_target = $rm_remark = $final_target = $final_remark = '';
            if (count($result) > 0) {
                if (isset($result['final_target'])) {
                    $target = $result['final_target'];
                } else {
                    $target = $result['rm_target'];
                }
                if (isset($result['final_remark'])) {
                    $remark = $result['final_remark'];
                } else {
                    $remark = $result['rm_remark'];
                }
            }

            $resultCurrentMonth = $this->db->get_where("review_details", array('emp_id' => $userId, 'month' => $getPreviousMonth + 1, 'year' => $getCurrentYear))->row_array();
            if (count($resultCurrentMonth) > 0) {
                if (isset($resultCurrentMonth['self_target'])) {
                    $self_target = $resultCurrentMonth['self_target'];
                }if (isset($resultCurrentMonth['self_achievement'])) {
                    $self_achievement = $resultCurrentMonth['self_achievement'];
                }if (isset($resultCurrentMonth['rm_target'])) {
                    $rm_target = $resultCurrentMonth['rm_target'];
                }if (isset($resultCurrentMonth['rm_remark'])) {
                    $rm_remark = $resultCurrentMonth['rm_remark'];
                }if (isset($resultCurrentMonth['final_target'])) {
                    $final_target = $resultCurrentMonth['final_target'];
                }if (isset($resultCurrentMonth['final_remark'])) {
                    $final_remark = $resultCurrentMonth['final_remark'];
                }
            }
            $result['prev_month_name'] = getMonthNameUsingNumber($getPreviousMonth);
            $result['next_month_name'] = getMonthNameUsingNumber($getPreviousMonth + 1);
            $result['month'] = $getPreviousMonth;
            $result['year'] = $getCurrentYear;
            $result['target'] = $target;
            $result['achievement'] = $remark;
            $result['self_target'] = $self_target;
            $result['self_review'] = $self_achievement;
            $result['rm_target'] = $rm_target;
            $result['rm_remark'] = $rm_remark;
            $result['rm_dt'] = ($rm_remark != '') ? date('j-M-Y H:i', strtotime($resultCurrentMonth['rm_approved_datetime'])) : '';
            $result['admin_dt'] = ($final_remark != '') ? date('j-M-Y H:i', strtotime($resultCurrentMonth['timestamp'])) : '';
            $result['final_target'] = $final_target;
            $result['final_remark'] = $final_remark;

            $result['is_save'] = (($rm_target != '' && $rm_remark != '') ) ? false : true;
            if ($result['is_save']) {
                $result['is_save'] = ($final_target != '' && $final_remark != '') ? false : true;
            }
            if (count($result) > 0) {
                return $result;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function saveSelfReviewEmp($dataObj) {
        $data = $dataObj['data'];
        $data['month'] = $dataObj['selectedPeroid']['month'];
        $data['year'] = $dataObj['selectedPeroid']['year'];
        $userId = $this->session->userdata('company_staff_id');
        if ($userId) {
            $isResultExist = $this->db->get_where("review_details", array('emp_id' => $userId, 'month' => $data['month'], 'year' => $data['year']))->row_array();
            if (!empty($isResultExist)) {
                $this->db->where(array('emp_id' => $userId, 'month' => $data['month'], 'year' => $data['year']));
                $this->db->update('review_details', array('self_achievement' => $data['self_review'], 'self_target' => $data['self_target']));
            } else {
                $this->db->insert('review_details', array('month' => $data['month'], 'year' => $data['year'], 'self_achievement' => $data['self_review'], 'self_target' => $data['self_target'], 'emp_id' => $userId));
            }
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function getRMReviews($dataObj = array()) {

        $userId = $this->session->userdata('company_staff_id');
        $result = array();
        $tempDate = date('Y-m');
        $getCurrentYear = date("Y");
        if ($userId != '') {
            if (!empty($dataObj)) {
                $tempDate = $dataObj['year'] . '-' . $dataObj['month'] . '-1';
                $getCurrentYear = $dataObj['year'];
            }
            $getPreviousMonth = date('m', strtotime($tempDate . ' -1 month'));
            if ($this->session->userdata('admin_type') == 'RM' || $this->session->userdata('isRM')) {
                // print_r($dataObj);exit;
                $getAllEmpUnderRM = $this->getRmEmployee($this->session->userdata('company_staff_id'));
                if (!empty($getAllEmpUnderRM)) {
                    foreach ($getAllEmpUnderRM as $rmKey => $rmVal) {
                        $target = $remark = $self_target = $self_achievement = $rm_target = $rm_remark = $final_target = $final_remark = $textTarget = $textAchievement = '';
                        $result[$rmKey] = $this->db->get_where("review_details", array('emp_id' => $rmVal['id'], 'month' => $getPreviousMonth, 'year' => $getCurrentYear))->row_array();
                        if (count($result[$rmKey]) > 0) {
                            if (isset($result[$rmKey]['final_target'])) {
                                $target = $result[$rmKey]['final_target'];
                            } else {
                                $target = $result[$rmKey]['rm_target'];
                            }
                            if (isset($result[$rmKey]['final_remark'])) {
                                $remark = $result[$rmKey]['final_remark'];
                            } else {
                                $remark = $result[$rmKey]['rm_remark'];
                            }
                        }

                        $resultCurrentMonth = $this->db->get_where("review_details", array('emp_id' => $rmVal['id'], 'month' => $getPreviousMonth + 1, 'year' => $getCurrentYear))->row_array();
                        if (count($resultCurrentMonth) > 0) {
                            if (isset($resultCurrentMonth['self_target'])) {
                                $self_target = $resultCurrentMonth['self_target'];
                            }if (isset($resultCurrentMonth['self_achievement'])) {
                                $self_achievement = $resultCurrentMonth['self_achievement'];
                            }if (isset($resultCurrentMonth['rm_target'])) {
                                $rm_target = $resultCurrentMonth['rm_target'];
                            }if (isset($resultCurrentMonth['rm_remark'])) {
                                $rm_remark = $resultCurrentMonth['rm_remark'];
                            }if (isset($resultCurrentMonth['final_target'])) {
                                $final_target = $resultCurrentMonth['final_target'];
                            }if (isset($resultCurrentMonth['final_remark'])) {
                                $final_remark = $resultCurrentMonth['final_remark'];
                            }
                        }

                        if ($rm_target != '') {
                            $textTarget = $rm_target;
                            $rmTextTarget = $rm_target;
                        } else {
                            $textTarget = $self_target;
                            $rmTextTarget = '';
                        }

                        if ($rm_remark != '') {
                            $textAchievement = $rm_remark;
                            $rmTextAchievement = $rm_remark;
                        } else {
                            $textAchievement = $self_achievement;
                            $rmTextAchievement = '';
                        }

                        $result[$rmKey]['emp_name'] = $this->db->get_where("company_staff_details", array('id' => $rmVal['id'], 'active_status' => 'WORKING'))->row_array()['name'];
                        $result[$rmKey]['emp_id'] = $this->db->get_where("company_staff_details", array('id' => $rmVal['id'], 'active_status' => 'WORKING'))->row_array()['id'];
                        $result[$rmKey]['prev_month_name'] = getMonthNameUsingNumber($getPreviousMonth);
                        $result[$rmKey]['next_month_name'] = getMonthNameUsingNumber($getPreviousMonth + 1);
                        $result[$rmKey]['year'] = $getCurrentYear;
                        $result[$rmKey]['target'] = $target;
                        $result[$rmKey]['achievement'] = $remark;
                        $result[$rmKey]['self_target'] = $self_target;
                        $result[$rmKey]['self_review'] = $self_achievement;
                        $result[$rmKey]['rm_target'] = $textTarget;
                        $result[$rmKey]['rm_target_show'] = $rmTextTarget;
                        $result[$rmKey]['rm_review'] = $textAchievement;
                        $result[$rmKey]['rm_review_show'] = $rmTextAchievement;
                        $result[$rmKey]['final_target'] = $final_target;
                        $result[$rmKey]['final_remark'] = $final_remark;
                        $result[$rmKey]['rm_dt'] = ($rmTextAchievement != '') ? date('j-M-Y H:i', strtotime($resultCurrentMonth['rm_approved_datetime'])) : '';
                        $result[$rmKey]['admin_dt'] = ($final_remark != '') ? date('j-M-Y H:i', strtotime($resultCurrentMonth['timestamp'])) : '';
                        if (!empty($dataObj)) {
                            $result[$rmKey]['overall_current_rating'] = $this->GetOverallRating($rmVal['id'], $dataObj['month'], $dataObj['year']);
                            $result[$rmKey]['overall_previous_rating'] = $this->GetOverallRating($rmVal['id'], $dataObj['month'] - 1, $dataObj['year']);
                        }
//                        $result[$rmKey]['is_save'] = (($rm_target != '' && $rm_remark != '') ) ? false : true;
//                        if ($result[$rmKey]['is_save']) {
                        $result[$rmKey]['is_save'] = ($final_target != '' && $final_remark != '') ? false : true;
//                        }
                        //$result[$rmKey]['is_save'] = ($final_target != '' && $final_remark != '') ? false : true;
                    }
                    if (count($result[$rmKey]) > 0) {
                        return $result;
                    } else {
                        return $result;
                    }
                }
            } else if ($this->session->userdata('admin_type') == 'ADMIN') {
                $getAllEmpUnderRM = $this->getRmEmployee($userId);

                if (!empty($getAllEmpUnderRM)) {
                    foreach ($getAllEmpUnderRM as $rmKey => $rmVal) {
                        $result[$rmKey] = $this->db->get_where("review_details", array('emp_id' => $rmVal['id'], 'month' => $getPreviousMonth, 'year' => $getCurrentYear))->row_array();
                        $result[$rmKey]['emp_name'] = $this->db->get_where("company_staff_details", array('id' => $rmVal['id'], 'active_status' => 'WORKING'))->row_array()['name'];
                        $result[$rmKey]['id'] = $this->db->get_where("company_staff_details", array('id' => $rmVal['id'], 'active_status' => 'WORKING'))->row_array()['id'];

                        $result[$rmKey]['emp_id'] = $this->db->get_where("company_staff_details", array('id' => $rmVal['id'], 'active_status' => 'WORKING'))->row_array()['id'];
                        $result[$rmKey]['rm_name'] = $this->db->get_where("company_staff_details", array('id' => $userId, 'active_status' => 'WORKING'))->row_array()['name'];
                        $result[$rmKey]['prev_month_name'] = getMonthNameUsingNumber($getPreviousMonth);
                        $result[$rmKey]['next_month_name'] = getMonthNameUsingNumber($getPreviousMonth + 1);
                        $result[$rmKey]['year'] = $getCurrentYear;
                        $result[$rmKey]['target'] = isset($result[$rmKey]['target']) ? $result[$rmKey]['target'] : '-';
                        $result[$rmKey]['achievement'] = isset($result[$rmKey]['final_remark']) ? $result[$rmKey]['final_remark'] : '-';
                        $result[$rmKey]['get_remark'] = isset($result[$rmKey]['rm_remark']) || isset($result[$rmKey]['self_achievement']) ? $result[$rmKey]['emp_name'] . '-' . $result[$rmKey]['self_achievement'] . "\r\n" . $result[$rmKey]['rm_name'] . '-' . $result[$rmKey]['rm_remark'] : '-';
                        $result[$rmKey]['get_target'] = isset($result[$rmKey]['target']) ? $result[$rmKey]['target'] : '-';
                        if (!empty($dataObj)) {
                            $result[$rmKey]['overall_current_rating'] = $this->GetOverallRating($rmVal['id'], $dataObj['month'], $dataObj['year']);
                            $result[$rmKey]['overall_previous_rating'] = $this->GetOverallRating($rmVal['id'], $dataObj['month'] - 1, $dataObj['year']);
                        }

//                        $result[$rmKey]['rm_dt'] = date('j-M-Y H:i', strtotime($resultCurrentMonth['rm_approved_datetime']));
//                        $result[$rmKey]['admin_dt'] = date('j-M-Y H:i', strtotime($resultCurrentMonth['timestamp']));

                        $result[$rmKey]['is_save'] = true;
                    }
                    if (count($result[$rmKey]) > 0) {
                        return $result;
                    } else {
                        return $result;
                    }
                }
            }
        } else {
            return $result;
        }
    }

    public function getRMEmpList($dataObj) {
        $rmIdarr = array();

        $tempDate = date('Y-m');
        $getCurrentYear = date("Y");
        $finalArr = array();
        if (!empty($dataObj)) {
            $tempDate = $dataObj['selectedPeroid']['year'] . '-' . $dataObj['selectedPeroid']['month'] . '-1';
            $getCurrentYear = $dataObj['selectedPeroid']['year'];
        }
        $getPreviousMonth = date('m', strtotime($tempDate . ' -1 month'));
        if ($dataObj['rmID'] == 'ALL') {
            $rmIdarr = $this->getAllRMs();
        } else {
            $rmIdarr[] = $dataObj['rmID'];
        }
        // print_r($rmIdarr);
        foreach ($rmIdarr as $row => $val) {
            $result = array();
            $rmId = $userId = (isset($val['id'])) ? $val['id'] : $val;
            if ($this->session->userdata('admin_type') == 'ADMIN') {
                $getAllEmpUnderRM = $this->getRmEmployee($userId);
                if (count($getAllEmpUnderRM) > 0) {
                    $getSelectedRm = $this->db->get_where("company_staff_details", array('id' => $userId, 'active_status' => 'WORKING'))->row_array();
                    if (!empty($getAllEmpUnderRM)) {
                        foreach ($getAllEmpUnderRM as $rmKey => $rmVal) {
                            $target = $remark = $self_target = $self_achievement = $rm_target = $rm_remark = $final_target = $final_remark = $textTarget = $textAchievement = '';
                            $result[$rmKey] = $this->db->get_where("review_details", array('emp_id' => $rmVal['id'], 'month' => $getPreviousMonth, 'year' => $getCurrentYear))->row_array();

                            if (count($result[$rmKey]) > 0) {
                                if (isset($result[$rmKey]['final_target'])) {
                                    $target = $result[$rmKey]['final_target'];
                                } else {
                                    $target = $result[$rmKey]['rm_target'];
                                }
                                if (isset($result[$rmKey]['final_remark'])) {
                                    $remark = $result[$rmKey]['final_remark'];
                                } else {
                                    $remark = $result[$rmKey]['rm_remark'];
                                }
                            }

                            $resultCurrentMonth = $this->db->get_where("review_details", array('emp_id' => $rmVal['id'], 'month' => $getPreviousMonth + 1, 'year' => $getCurrentYear))->row_array();
                            if (count($resultCurrentMonth) > 0) {
                                if (isset($resultCurrentMonth['self_target'])) {
                                    $self_target = $resultCurrentMonth['self_target'];
                                }if (isset($resultCurrentMonth['self_achievement'])) {
                                    $self_achievement = $resultCurrentMonth['self_achievement'];
                                }if (isset($resultCurrentMonth['rm_target'])) {
                                    $rm_target = $resultCurrentMonth['rm_target'];
                                }if (isset($resultCurrentMonth['rm_remark'])) {
                                    $rm_remark = $resultCurrentMonth['rm_remark'];
                                }if (isset($resultCurrentMonth['final_target'])) {
                                    $final_target = $resultCurrentMonth['final_target'];
                                }if (isset($resultCurrentMonth['final_remark'])) {
                                    $final_remark = $resultCurrentMonth['final_remark'];
                                }
                            }


                            if ($rm_target != '') {
                                $textTarget = $rm_target;
                                $rmTextTarget = $rm_target;
                            } else {
                                $textTarget = $self_target;
                                $rmTextTarget = '';
                            }

                            if ($rm_remark != '') {
                                $textAchievement = $rm_remark;
                                $rmTextAchievement = $rm_remark;
                            } else {
                                $textAchievement = $self_achievement;
                                $rmTextAchievement = '';
                            }

                            if ($final_remark != '') {
                                $rm_remark = $final_remark;
                            } else {
                                $rm_remark = $rm_remark;
                            }

                            if ($final_target != '') {
                                $rm_target = $final_target;
                            } else {
                                $rm_target = $rm_target;
                            }

                            $result[$rmKey]['emp_name'] = $this->db->get_where("company_staff_details", array('id' => $rmVal['id'], 'active_status' => 'WORKING'))->row_array()['name'];
                            $result[$rmKey]['emp_id'] = $rmVal['id'];
                            $result[$rmKey]['rm_name'] = $this->db->get_where("company_staff_details", array('id' => $rmId, 'active_status' => 'WORKING'))->row_array()['name'];
                            $result[$rmKey]['prev_month_name'] = getMonthNameUsingNumber($getPreviousMonth);
                            $result[$rmKey]['next_month_name'] = getMonthNameUsingNumber($getPreviousMonth + 1);
                            $result[$rmKey]['year'] = $getCurrentYear;
                            $result[$rmKey]['target'] = $target;
                            $result[$rmKey]['achievement'] = $remark;
                            $result[$rmKey]['id'] = $this->db->get_where("company_staff_details", array('id' => $rmVal['id'], 'active_status' => 'WORKING'))->row_array()['id'];
                            $result[$rmKey]['self_target'] = $self_target;
                            $result[$rmKey]['self_review'] = $self_achievement;
                            $result[$rmKey]['rm_target'] = $rm_target;
                            $result[$rmKey]['rm_target_show'] = $rmTextTarget;
                            $result[$rmKey]['rm_review'] = $rm_remark;
                            $result[$rmKey]['rm_review_show'] = $rmTextAchievement;
                            $result[$rmKey]['final_target'] = $final_target;
                            $result[$rmKey]['final_remark'] = $final_remark;
                            $result[$rmKey]['rm_dt'] = ($rm_remark != '') ? date('j-M-Y H:i', strtotime($resultCurrentMonth['rm_approved_datetime'])) : '';
                            $result[$rmKey]['admin_dt'] = ($final_remark != '') ? date('j-M-Y H:i', strtotime($resultCurrentMonth['timestamp'])) : '';
                            if (!empty($dataObj)) {
                                $result[$rmKey]['overall_current_rating'] = $this->GetOverallRating($rmVal['id'], $dataObj['selectedPeroid']['month'], $dataObj['selectedPeroid']['year']);
                                $result[$rmKey]['overall_previous_rating'] = $this->GetOverallRating($rmVal['id'], $dataObj['selectedPeroid']['month'] - 1, $dataObj['selectedPeroid']['year']);
                            }
                            $result[$rmKey]['is_save'] = true;

                            $finalArr[] = $result[$rmKey];
                        }
                        $preMonthData = $this->db->get_where("review_details", array('emp_id' => $getSelectedRm['id'], 'month' => $getPreviousMonth, 'year' => $getCurrentYear))->row_array();
                        $selectedRMComments = $this->db->get_where("review_details", array('emp_id' => $getSelectedRm['id'], 'month' => $getPreviousMonth + 1, 'year' => $getCurrentYear))->row_array();
                        if (!empty($selectedRMComments)) {
                            if (isset($selectedRMComments['self_target'])) {
                                $self_target = $selectedRMComments['self_target'];
                            }if (isset($selectedRMComments['self_achievement'])) {
                                $self_achievement = $selectedRMComments['self_achievement'];
                            }if (isset($selectedRMComments['rm_target'])) {
                                $rm_target = $selectedRMComments['rm_target'];
                            }if (isset($selectedRMComments['rm_remark'])) {
                                $rm_remark = $selectedRMComments['rm_remark'];
                            }if (isset($selectedRMComments['final_target'])) {
                                $final_target = $selectedRMComments['final_target'];
                            }if (isset($selectedRMComments['final_remark'])) {
                                $final_remark = $selectedRMComments['final_remark'];
                            }
                            if ($rm_target != '') {
                                $textTarget = $rm_target;
                                $rmTextTarget = $self_target;
                            } else {
                                $textTarget = $self_target;
                                $rmTextTarget = '';
                            }

                            if ($rm_remark != '') {
                                $textAchievement = $rm_remark;
                                $rmTextAchievement = $self_achievement;
                            } else {
                                $textAchievement = $self_achievement;
                                $rmTextAchievement = '';
                            }
                            $rmDt = ($selectedRMComments['rm_remark'] != '') ? date('j-M-Y H:i', strtotime($selectedRMComments['rm_approved_datetime'])) : '';
                            $adminDt = ($selectedRMComments['final_target'] != '') ? date('j-M-Y H:i', strtotime($selectedRMComments['timestamp'])) : '';
                            $selectedRMArr = array('id' => $getSelectedRm['id'], 'is_save' => true, 'rm_dt' => $rmDt, 'admin_dt' => $adminDt, 'target' => (isset($preMonthData['final_target'])) ? $preMonthData['final_target'] : '', 'achievement' => (isset($preMonthData['final_remark'])) ? $preMonthData['final_remark'] : '', 'emp_id' => $getSelectedRm['id'], 'emp_name' => $getSelectedRm['name'], 'self_target' => $selectedRMComments['self_target'], 'rm_target' => $selectedRMComments['self_target'], 'final_target' => $selectedRMComments['final_target'], 'self_review' => $selectedRMComments['self_achievement'], 'rm_remark' => $selectedRMComments['rm_remark'], 'final_remark' => $selectedRMComments['final_remark'], 'rm_target_show' => $rmTextTarget, 'rm_review' => $self_achievement);
                        } else {
                            $selectedRMArr = array('id' => $getSelectedRm['id'], 'is_save' => true, 'rm_dt' => '', 'admin_dt' => '', 'target' => '', 'achievement' => '', 'emp_id' => $getSelectedRm['id'], 'emp_name' => $getSelectedRm['name'], 'self_target' => '', 'rm_target' => '', 'final_target' => '', 'self_review' => '', 'rm_remark' => '', 'final_remark' => '');
                        }
                    } else { //who is admin not rm 
                        $getSelectedRm = $this->db->get_where("company_staff_details", array('id' => $userId, 'active_status' => 'WORKING'))->row_array();
                        $preMonthData = $this->db->get_where("review_details", array('emp_id' => $getSelectedRm['id'], 'month' => $getPreviousMonth, 'year' => $getCurrentYear))->row_array();
                        $selectedRMComments = $this->db->get_where("review_details", array('emp_id' => $getSelectedRm['id'], 'month' => $getPreviousMonth + 1, 'year' => $getCurrentYear))->row_array();
                        if (!empty($selectedRMComments)) {
                            if (isset($selectedRMComments['self_target'])) {
                                $self_target = $selectedRMComments['self_target'];
                            }if (isset($selectedRMComments['self_achievement'])) {
                                $self_achievement = $selectedRMComments['self_achievement'];
                            }if (isset($selectedRMComments['rm_target'])) {
                                $rm_target = $selectedRMComments['rm_target'];
                            }if (isset($selectedRMComments['rm_remark'])) {
                                $rm_remark = $selectedRMComments['rm_remark'];
                            }if (isset($selectedRMComments['final_target'])) {
                                $final_target = $selectedRMComments['final_target'];
                            }if (isset($selectedRMComments['final_remark'])) {
                                $final_remark = $selectedRMComments['final_remark'];
                            }
                            if ($rm_target != '') {
                                $textTarget = $rm_target;
                                $rmTextTarget = $self_target;
                            } else {
                                $textTarget = $self_target;
                                $rmTextTarget = '';
                            }

                            if ($rm_remark != '') {
                                $textAchievement = $rm_remark;
                                $rmTextAchievement = $self_achievement;
                            } else {
                                $textAchievement = $self_achievement;
                                $rmTextAchievement = '';
                            }
                            $rmDt = ($selectedRMComments['rm_remark'] != '') ? date('j-M-Y H:i', strtotime($selectedRMComments['rm_approved_datetime'])) : '';
                            $adminDt = ($selectedRMComments['final_target'] != '') ? date('j-M-Y H:i', strtotime($selectedRMComments['timestamp'])) : '';

                            $selectedRMArr = array('id' => $getSelectedRm['id'], 'is_save' => true, 'rm_dt' => $rmDt, 'admin_dt' => $adminDt, 'target' => (isset($preMonthData['final_target'])) ? $preMonthData['final_target'] : '', 'achievement' => (isset($preMonthData['final_remark'])) ? $preMonthData['final_remark'] : '', 'emp_id' => $getSelectedRm['id'], 'emp_name' => $getSelectedRm['name'], 'self_target' => $selectedRMComments['self_target'], 'rm_target' => $selectedRMComments['rm_target'], 'final_target' => $selectedRMComments['final_target'], 'self_review' => $selectedRMComments['self_achievement'], 'rm_remark' => $selectedRMComments['rm_remark'], 'final_remark' => $selectedRMComments['final_remark'], 'rm_target_show' => $textTarget, 'rm_review_show' => $textAchievement);
                        } else {
                            $selectedRMArr = array('id' => $getSelectedRm['id'], 'is_save' => true, 'rm_dt' => '', 'admin_dt' => '', 'target' => '', 'achievement' => '', 'emp_id' => $getSelectedRm['id'], 'emp_name' => $getSelectedRm['name'], 'self_target' => '', 'rm_target' => '', 'final_target' => '', 'self_review' => '', 'rm_remark' => '', 'final_remark' => '');
                        }
                    }
                }
            }
        }

        return $finalArr;
    }

    public function saveEmpReviewByRMOrAdmin($dataObj) {
        $data = $dataObj['selectedEmp'];
        $userId = $this->session->userdata('company_staff_id');
        $tempDate = date('Y-m');
        $getCurrentYear = date("Y");
        if (!empty($dataObj)) {
            $tempDate = $dataObj['selectedPeroid']['year'] . '-' . $dataObj['selectedPeroid']['month'] . '-1';
            $getCurrentYear = $dataObj['selectedPeroid']['year'];
        }
        $getCurrentMonth = $dataObj['selectedPeroid']['month'];
        $getPreviousMonth = date('m', strtotime($tempDate . ' -1 month'));
        $currentDateTime = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
        $isEmpRm = $this->checkIsEmpRm($data['emp_id'], $userId);
        if ($this->session->userdata('admin_type') == 'RM') {
            if ($isEmpRm) {
                $result = $this->db->get_where("review_details", array('emp_id' => $data['emp_id'], 'month' => $getPreviousMonth + 1, 'year' => $getCurrentYear))->row_array();
                if (!empty($result)) {
                    $this->db->where(array('emp_id' => $data['emp_id'], 'month' => $getPreviousMonth + 1, 'year' => $data['year']));
                    $this->db->update('review_details', array('rm_target' => $data['rm_target'], 'rm_remark' => $data['rm_review'], 'rm_approved_datetime' => $currentDateTime));
                } else {
                    $this->db->insert('review_details', array('month' => $getPreviousMonth + 1, 'year' => $getCurrentYear, 'emp_id' => $data['emp_id'], 'rm_target' => $data['rm_target'], 'rm_remark' => $data['rm_review'], 'rm_approved_datetime' => $currentDateTime));
                }
            }
        } else if ($this->session->userdata('admin_type') == 'ADMIN') {

            if (!empty($data['id'])) {
                if (isset($data['rm_review'])) {
                    $remark = $data['rm_review'];
                } else if (isset($data['rm_review_show'])) {
                    $remark = $data['rm_review_show'];
                }
                if (isset($data['rm_target'])) {
                    $target = $data['rm_target'];
                } else if (isset($data['rm_target_show'])) {
                    $target = $data['rm_target_show'];
                }
                $target = isset($data['admin_target']) ? $data['admin_target'] : $data['rm_target'];

                $result = $this->db->get_where("review_details", array('emp_id' => $data['id'], 'month' => $getPreviousMonth + 1, 'year' => $getCurrentYear))->row_array();

                if (count($result) > 0) {
                    $this->db->where(array('emp_id' => $data['id'], 'month' => $getPreviousMonth + 1, 'year' => $getCurrentYear));
                    $this->db->update('review_details', array('final_target' => $target, 'final_remark' => $remark));
                } else {
                    $this->db->insert('review_details', array('month' => $getPreviousMonth + 1, 'year' => $getCurrentYear, 'final_remark' => $remark, 'final_target' => $target, 'emp_id' => $data['id']));
                }
            }
        }
        if ($this->db->affected_rows()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getRmEmployee($uid) {
        $this->load->database();
        $this->db->select('*');
        $this->db->from('company_staff_details');
        $this->db->where(array('rm_id' => $uid, 'active_status' => 'WORKING'));
        $activityDeatil = $this->db->get()->result_array();
        foreach ($activityDeatil as $key => $val) {
            $activityDeatil[$key]['emp_id'] = $val['id'];
        }
        return $activityDeatil;
    }

    public function getAllRMs() {
        $result = array();
        $loginAdminId = $this->session->userdata('company_staff_id');
        $where = "(active_status='WORKING' AND (is_rm=1 OR is_super_admin=1) )";
        $this->db->where($where);
        $result = $this->db->get("company_staff_details")->result_array();
        if (count($result) > 0) {
            return $result;
        }
    }

    public function GetEmpRating($dataObj) {
        $userId = $this->session->userdata('company_staff_id');
        $where = array();
        $tempDate = date('Y-m');
        $getCurrentYear = date("Y");
        if (!empty($dataObj)) {
            $tempDate = $dataObj['selectedPeroid']['year'] . '-' . $dataObj['selectedPeroid']['month'] . '-1';
            $getCurrentYear = $dataObj['selectedPeroid']['year'];
        }
        $getPreviousMonth = date('m', strtotime($tempDate . ' -1 month'));
        $this->db->select('id as param_id,name as param_name');
        $parmArr = $this->db->get('review_rating_key_parameters_details')->result_array();
        if ($this->session->userdata('admin_type') == 'RM' || $this->session->userdata('isRM')) {
            $where['b.rm_id'] = $userId;
            $where1['b.rm_id'] = $userId;
        }
        foreach ($parmArr as $key => $val) {
            $where['a.key_parm_id'] = $val['param_id'];
            $where['a.month_no'] = $getPreviousMonth + 1;
            $where['a.year'] = $getCurrentYear;
            $where['a.emp_id'] = $dataObj['emp_id'];
            $this->db->join('company_staff_details as b', 'a.emp_id=b.id');
            $result = $this->db->get_where('emp_review_rating_details as a', $where)->row_array();
            $parmArr[$key]['rating'] = (isset($result['rating'])) ? $result['rating'] : '';
            $where1['a.key_parm_id'] = $val['param_id'];
            $where1['a.month_no'] = $getPreviousMonth;
            $where1['a.year'] = $getCurrentYear;
            $where1['a.emp_id'] = $dataObj['emp_id'];
            $this->db->join('company_staff_details as b', 'a.emp_id=b.id');
            $result1 = $this->db->get_where('emp_review_rating_details as a', $where1)->row_array();
            $parmArr[$key]['prevrating'] = (isset($result1['rating'])) ? $result1['rating'] : '';
        }
        return $parmArr;
    }

    public function SaveEmpRating($dataObj) {
        $userId = $this->session->userdata('company_staff_id');
        $tempDate = date('Y-m');
        $getCurrentYear = date("Y");
        if (!empty($dataObj)) {
            $tempDate = $dataObj['selectedPeroid']['year'] . '-' . $dataObj['selectedPeroid']['month'] . '-1';
            $getCurrentYear = $dataObj['selectedPeroid']['year'];
        }
        $getPreviousMonth = date('m', strtotime($tempDate . ' -1 month'));
//        $getPreviousMonth = date('m', strtotime('-1 month'));
        $currentDateTime = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
        if ($this->session->userdata('admin_type') == 'RM' || $this->session->userdata('isRM')) {
            $isEmpRm = $this->checkIsEmpRm($dataObj['emp_id'], $userId);
            if ($isEmpRm) {
                $this->db->delete('emp_review_rating_details', array('month_no' => $getPreviousMonth + 1, 'year' => $getCurrentYear, 'emp_id' => $dataObj['emp_id']));
                foreach ($dataObj['ratingData'] as $key => $val) {

                    $insertArr[] = array(
                        'emp_id' => $dataObj['emp_id'],
                        'month_no' => $getPreviousMonth + 1,
                        'year' => $getCurrentYear,
                        'key_parm_id' => $val['param_id'],
                        'rating' => ($val['rating'] <= 10) ? $val['rating'] : 0,
                        'rm_datetime' => date('Y-m-d H:i:s'),
                        'entry_by' => $userId
                    );
                }
                $this->db->insert_batch('emp_review_rating_details', $insertArr);
                return true;
            } else {
                return false;
            }
        } else if ($this->session->userdata('admin_type') == 'ADMIN') {
            foreach ($dataObj['ratingData'] as $key => $val) {
                $result = $this->db->get_where('emp_review_rating_details', array('key_parm_id' => $val['param_id'], 'month_no' => $getPreviousMonth + 1, 'year' => $getCurrentYear, 'emp_id' => $dataObj['emp_id']))->row_array();
                if (!empty($result)) {
                    $this->db->update('emp_review_rating_details', array('rating' => $val['rating'], 'entry_by' => $userId), array('key_parm_id' => $val['param_id'], 'month_no' => $getPreviousMonth + 1, 'year' => $getCurrentYear, 'emp_id' => $dataObj['emp_id']));
                } else {
                    $this->db->insert('emp_review_rating_details', array(
                        'emp_id' => $dataObj['emp_id'],
                        'month_no' => $getPreviousMonth + 1,
                        'year' => $getCurrentYear,
                        'key_parm_id' => $val['param_id'],
                        'rating' => ($val['rating'] <= 10) ? $val['rating'] : 0,
                        'rm_datetime' => date('Y-m-d H:i:s'),
                        'entry_by' => $userId
                    ));
                }
            }
            return true;
        }
    }

// New code added by Dev
    public function GetReviewData($dataObj = false) {

        $result = array();
        $empIds = array();
        if ($this->session->userdata('admin_type') == 'RM' || $this->session->userdata('isRM')) {

            $userId = $this->session->userdata('company_staff_id');
            $rmEmp = $this->getRmEmployee($userId);

            if (!empty($rmEmp)) {
                foreach ($rmEmp as $key => $val) {
                    $empIds[] = $val['id'];
                }
                $empIds = array_unique($empIds);
            }
        } else if ($this->session->userdata('admin_type') == 'ADMIN') {
            if (!empty($dataObj)) {
                if ($dataObj['rmID'] == 'all') {
                    $rmEmp = $this->db->get_where('company_staff_details', array('active_status' => 'WORKING'))->result_array();
                    if (!empty($rmEmp)) {
                        foreach ($rmEmp as $key => $val) {
                            $empIds[] = $val['id'];
                        }
                        $empIds = array_unique($empIds);
                    }
                } else {
                    $rmEmp = $this->getRmEmployee($dataObj['rmID']);
                    if (!empty($rmEmp)) {
                        foreach ($rmEmp as $key => $val) {
                            $empIds[] = $val['id'];
                        }
                        $empIds = array_unique($empIds);
                    }
                }
            }
        }

        if (!empty($empIds)) {
            $result = $this->db->where_in('emp_id', $empIds)->where(array('month' => $dataObj['selectedYear']['month'], 'year' => $dataObj['selectedYear']['year']))->get('review_details')->result_array();
        }

        if (!empty($result)) {
            foreach ($result as $key => $val) {
                $result[$key]['emp_code'] = $this->GetEmpDetails($val['emp_id'])['emp_code'];
                $result[$key]['emp_name'] = $this->GetEmpDetails($val['emp_id'])['name'];
                $result[$key]['rm_name'] = $this->GetEmpDetails($this->GetEmpDetails($val['emp_id'])['rm_id'])['name'];
                $result[$key]['productivity'] = $this->GetReviewRatingDetails($val['emp_id'], $dataObj['selectedYear']['month'], $dataObj['selectedYear']['year'], 1);
                $result[$key]['job_knowledge'] = $this->GetReviewRatingDetails($val['emp_id'], $dataObj['selectedYear']['month'], $dataObj['selectedYear']['year'], 2);
                $result[$key]['foresightedness_planning'] = $this->GetReviewRatingDetails($val['emp_id'], $dataObj['selectedYear']['month'], $dataObj['selectedYear']['year'], 3);
                $result[$key]['problem_solving_debugging'] = $this->GetReviewRatingDetails($val['emp_id'], $dataObj['selectedYear']['month'], $dataObj['selectedYear']['year'], 4);
                $result[$key]['communication_problem'] = $this->GetReviewRatingDetails($val['emp_id'], $dataObj['selectedYear']['month'], $dataObj['selectedYear']['year'], 5);
                $result[$key]['interpersonal_skills'] = $this->GetReviewRatingDetails($val['emp_id'], $dataObj['selectedYear']['month'], $dataObj['selectedYear']['year'], 6);
                $result[$key]['dedication'] = $this->GetReviewRatingDetails($val['emp_id'], $dataObj['selectedYear']['month'], $dataObj['selectedYear']['year'], 7);
                $result[$key]['deadline_achievement'] = $this->GetReviewRatingDetails($val['emp_id'], $dataObj['selectedYear']['month'], $dataObj['selectedYear']['year'], 8);
                $result[$key]['work_understanding'] = $this->GetReviewRatingDetails($val['emp_id'], $dataObj['selectedYear']['month'], $dataObj['selectedYear']['year'], 9);
                $result[$key]['attendance_punctuality'] = $this->GetReviewRatingDetails($val['emp_id'], $dataObj['selectedYear']['month'], $dataObj['selectedYear']['year'], 10);
                $result[$key]['overall'] = ($result[$key]['productivity'] + $result[$key]['job_knowledge'] + $result[$key]['foresightedness_planning'] + $result[$key]['problem_solving_debugging'] + $result[$key]['communication_problem'] + $result[$key]['interpersonal_skills'] + $result[$key]['dedication'] + $result[$key]['deadline_achievement'] + $result[$key]['work_understanding'] + $result[$key]['attendance_punctuality']) / 10;
            }
        }
        return $result;
    }

    public function GetEmpDetails($empId) {
        $result = $this->db->get_where('company_staff_details', array('id' => $empId))->row_array();
        return $result;
    }

    public function GetReviewRatingDetails($empId, $month, $year, $param_id) {
        $result = $this->db->get_where('emp_review_rating_details', array('emp_id' => $empId, 'month_no' => $month, 'year' => $year, 'key_parm_id' => $param_id))->row_array();
        if (!empty($result)) {
            return $result['rating'] ? $result['rating'] : 0;
        } else {
            return 0;
        }
    }

    public function checkIsEmpRm($empid, $userid) {
        $rmEmp = $this->db->get_where('company_staff_details', array('id' => $empid, 'rm_id' => $userid))->row_array();
        if (!empty($rmEmp)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function GetOverallRating($empId, $month, $year) {
        $overallRatingCurrent = 0;
        $empRatingDetailsCurrentMonth = $this->db->get_where('emp_review_rating_details', array('emp_id' => $empId, 'month_no' => $month, 'year' => $year))->result_array();
        if (!empty($empRatingDetailsCurrentMonth)) {
            foreach ($empRatingDetailsCurrentMonth as $currentKey => $currentVal) {
                $overallRatingCurrent += $currentVal['rating'];
            }
            $overallRatingCurrent = $overallRatingCurrent / 10;
        }
        return $overallRatingCurrent;
    }

    public function getreviewstemplate($postdata) {
        $this->db->select('id,name,email_address,rm_id');
        $staff_list = $this->db->get_where('company_staff_details', array('active_status' => 'WORKING', 'is_super_admin' => 0))->result_array();
        if (!empty($staff_list)) {
            foreach ($staff_list as $key => $value) {
                $template = $this->db->get_where('email_template', array('template_code' => 'REVIEW'))->row_array();
                if (!empty($template['cc'])) {
                    $cclist = explode(",", $template['cc']);
                } else {
                    $cclist = array();
                }

                $staff_list[$key]['cc'] = $cclist;
                $this->db->select('email_address');
                $rm_email = $this->db->get_where('company_staff_details', array('active_status' => 'WORKING', 'id' => $value['rm_id']))->row_array();
                if (in_array(isset($rm_email['email_address']) ? $rm_email['email_address'] : '', $staff_list[$key]['cc'])) {
                    
                } else {
                    array_push($staff_list[$key]['cc'], isset($rm_email['email_address']) ? $rm_email['email_address'] : '');
                }
                $this->db->select('final_target,final_remark');
                $emp_review = $this->db->get_where('review_details', array('emp_id' => $value['id'], 'month' => $postdata['month'], 'year' => $postdata['year']))->row_array();

                if (empty($emp_review)) {
                    $emp_review['final_remark'] = '';
                    $emp_review['final_target'] = '';
                }
                $monthName = date('F', mktime(0, 0, 0, $postdata['month'], 10));
                $staff_list[$key]['final_remark'] = $emp_review['final_remark'];
                $staff_list[$key]['final_target'] = $emp_review['final_target'];
                $subject1 = str_replace('{month}', $monthName, $template['mail_subject']);
                $staff_list[$key]['subject'] = str_replace('{year}', $postdata['year'], $subject1);
                $name = str_replace('{name}', $value['name'], $template['mail_body']);
                $achivement = str_replace('{achivement}', $emp_review['final_remark'], $name);
                $month = str_replace('{month}', $monthName, $achivement);
                $staff_list[$key]['template'] = str_replace('{target}', $emp_review['final_target'], $month);
            }
            return $staff_list;
        } else {
            return FALSE;
        }
    }

    public function insertemaildetails($row) {
        $result = $this->db->get_where('email_sent_details', array('emp_id' => $row['id'], 'month' => date('m'), 'year' => date('Y'), 'subject' => $row['subject']))->row_array();
        if (empty($result)) {
            $insertArr = array(
                'emp_id' => $row['id'],
                'email_body' => $row['template'],
                'subject' => $row['subject'],
                'cc' => json_encode($row['cc'], TRUE),
                'to' => $row['email_address'],
                'sms_body' => '',
                'sent_status' => 0,
                'month' => date('m'),
                'year' => date('Y'),
                'entry_by' => ''
            );
            $this->db->insert('email_sent_details', $insertArr);
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    //new code added by dev
    public function GetReviewSettings($fy) {
        $table = 'review_settings';
        $cond = array('financial_year' => $fy);
        $reviewSettings = array();
        $tempArr = array();
        //$reviewSettings = $this->db->get_where($table,$cond)->result_array();
        $this->db->where($cond);
        $this->db->order_by("month", "asc");
        $query = $this->db->get($table);
        $reviewSettings = $query->result_array();
        if (!empty($reviewSettings)) {
            $k = 0;
            for ($i = 0; $i < count($reviewSettings) / 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $tempArr[$i]['id'] = $reviewSettings[$k]['id'];
                    $tempArr[$i]['financial_year'] = $reviewSettings[$k]['financial_year'];
                    $tempArr[$i]['month'] = $reviewSettings[$k]['month'];
                    $tempArr[$i]['emp_type'][] = $reviewSettings[$k]['emp_type'];
                    if ($reviewSettings[$k]['emp_type'] == 'EMP') {
                        $tempArr[$i]['start_datetime']['EMP'] = date('d-M-Y H:i', strtotime($reviewSettings[$k]['start_datetime']));
                        $tempArr[$i]['end_datetime']['EMP'] = date('d-M-Y H:i', strtotime($reviewSettings[$k]['end_datetime']));
                    }
                    if ($reviewSettings[$k]['emp_type'] == 'RM') {
                        $tempArr[$i]['start_datetime']['RM'] = date('d-M-Y H:i', strtotime($reviewSettings[$k]['start_datetime']));
                        $tempArr[$i]['end_datetime']['RM'] = date('d-M-Y H:i', strtotime($reviewSettings[$k]['end_datetime']));
                    }
                    if ($reviewSettings[$k]['emp_type'] == 'ADM') {
                        $tempArr[$i]['start_datetime']['ADM'] = date('d-M-Y H:i', strtotime($reviewSettings[$k]['start_datetime']));
                        $tempArr[$i]['end_datetime']['ADM'] = date('d-M-Y H:i', strtotime($reviewSettings[$k]['end_datetime']));
                    }
//                    $tempArr[$i]['start_datetime'][] = date('d-M-Y H:i', strtotime($reviewSettings[$k]['start_datetime']));
//                    $tempArr[$i]['end_datetime'][] = date('d-M-Y H:i', strtotime($reviewSettings[$k]['end_datetime']));
                    $k++;
                }
            }
            return $tempArr;
        } else {
            return $tempArr;
        }
    }

    public function SaveReviewSettings($data) {
        if (!empty($data)) {
            $tempArr = array();
            $dateFormat = "Y-m-d";
            $timeFormat = "H:i:s";
            for ($i = 0; $i < 3; $i++) {
                $temp[$i]['financial_year'] = $data['fy'];
                $temp[$i]['month'] = $data['month'];
                $temp[$i]['entry_by'] = 1;
                if ($i == 0) {
                    $temp[$i]['emp_type'] = 'EMP';
                    $startDate = date('Y-m-d', strtotime($data['em_start_date']));
                    $startTime = date('H:i:s', strtotime($data['em_start_time']));
                    $startDateTime = $startDate . ' ' . $startTime;

                    $endDate = date('Y-m-d', strtotime($data['em_end_date']));
                    $endTime = date('H:i:s', strtotime($data['em_end_time']));
                    $endDateTime = $endDate . ' ' . $endTime;
                    $temp[$i]['start_datetime'] = $startDateTime;
                    $temp[$i]['end_datetime'] = $endDateTime;
                }
                if ($i == 1) {
                    $temp[$i]['emp_type'] = 'RM';
                    $startDate = date('Y-m-d', strtotime($data['rm_start_date']));
                    $startTime = date('H:i:s', strtotime($data['rm_start_time']));
                    $startDateTime = $startDate . ' ' . $startTime;

                    $endDate = date('Y-m-d', strtotime($data['rm_end_date']));
                    $endTime = date('H:i:s', strtotime($data['rm_end_time']));
                    $endDateTime = $endDate . ' ' . $endTime;
                    $temp[$i]['start_datetime'] = $startDateTime;
                    $temp[$i]['end_datetime'] = $endDateTime;
                }
                if ($i == 2) {
                    $temp[$i]['emp_type'] = 'ADM';
                    $startDate = date('Y-m-d', strtotime($data['admin_start_date']));
                    $startTime = date('H:i:s', strtotime($data['admin_start_time']));
                    $startDateTime = $startDate . ' ' . $startTime;

                    $endDate = date('Y-m-d', strtotime($data['admin_end_date']));
                    $endTime = date('H:i:s', strtotime($data['admin_end_time']));
                    $endDateTime = $endDate . ' ' . $endTime;
                    $temp[$i]['start_datetime'] = $startDateTime;
                    $temp[$i]['end_datetime'] = $endDateTime;
                }
            }

            if (isset($data['id'])) {
                $month = $data['month'];
                $fy = $data['fy'];
                $cond = array('financial_year' => $fy, 'month' => $month);
                $this->db->where($cond);
                $this->db->delete('review_settings');

                if (!empty($temp)) {
                    for ($j = 0; $j < count($temp); $j++) {
                        $this->db->insert('review_settings', $temp[$j]);
                    }
                    if ($this->db->affected_rows() > 0) {
                        return TRUE;
                    }
                } else {
                    return FALSE;
                }
            } else {
                if (!empty($temp)) {
                    for ($j = 0; $j < count($temp); $j++) {
                        $this->db->insert('review_settings', $temp[$j]);
                    }
                    if ($this->db->affected_rows() > 0) {
                        return TRUE;
                    }
                } else {
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
    }

    public function DeleteReviewSettings($data) {
        if (!empty($data)) {
            $month = $data['month'];
            $fy = $data['fy'];
            $cond = array('financial_year' => $fy, 'month' => $month);
            $this->db->where($cond);
            $this->db->delete('review_settings');
            if ($this->db->affected_rows() > 0) {
                $result = $this->GetReviewSettings($fy);
                return $result;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function GetRemainTime($dataObj) {
        $currentMonth = date('m')-1;
        $currentYear = date('Y');
        $result = array();
        $table = 'review_settings';
        if ($dataObj['action'] == 'emp_time') {
            $cond = array('financial_year' => $currentYear, 'month' => $currentMonth, 'emp_type' => 'EMP');
        } elseif ($dataObj['action'] == 'rm_time') {
            $cond = array('financial_year' => $currentYear, 'month' => $currentMonth, 'emp_type' => 'RM');
        }
        $result = $this->db->get_where($table, $cond)->row_array();
        if (!empty($result)) {
            return $result;
        } else {
            return $result;
        }
    }

}
