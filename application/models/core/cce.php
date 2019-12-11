<?php

class cce extends CI_Model {
    /*     * **************CCE SERVICES ****************** */

    public function fillCCETeacherMasterData($section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $this->load->model('core/core', 'dbobj');
        $standard = $this->dbobj->GetStandardfromsection_id($section_id);
        $cceid_stan = array();
        $cceid_stan = $this->getcceid_from_standard($standard);

        foreach ($cceid_stan as $val) {
            $cce_id = $val;
            $resultt = $this->check_cce_id_sectionid_found($cce_id, $section_id);
            // echo $resultt;

            if ($resultt == 'NO') {
                $this->insert_cce_id_sectionid($cce_id, $section_id);
            }
        }
    }

    public function insert_cce_id_sectionid($cce_id, $section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $data = array(
            'section_id' => $section_id,
            'cce_id' => $cce_id,
            'staff_id' => '-1',
            'deo_entry_by' => $this->session->userdata('deo_staff_id'),
            'entry_by' => $this->session->userdata('staff_id')
        );
        $dbObj->insert('cce_staff_relation', $data);
    }

    public function check_cce_id_sectionid_found($cce_id, $section_id) {
        $output = 'YES';
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $str = "SELECT cce_id FROM cce_staff_relation WHERE section_id=" . $section_id . ' AND cce_id=' . $cce_id;
        $query = $dbObj->query($str)->result_array();
        if (count($query) == 0) {
            $output = 'NO';
        } else {
            $output = 'YES';
        }
        return $output;
    }

    public function getcceid_from_standard($standard) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('id');
        $dbObj->where('class', $standard);
        $subjectinclass = $dbObj->get("cce_list")->result_array();
        $blankarray = array();
        foreach ($subjectinclass as $value) {
            $blankarray[] = $value['id'];
        }
        return $blankarray;
    }

    //Function below given by Amit

    public function GetAllCceSubjectName($staff_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $query = "SELECT c.`cce_name`,c.`id` as cce_id,a.`standard`,a.`section`,a.`id` as section_id FROM `cce_staff_relation` as b ,`section_list` as a,`cce_list` as c WHERE  b.`staff_id`='$staff_id' AND c.`id`= b.`cce_id`AND a.`id`=b.`section_id`";
        $output = $dbObj->query($query)->result_array();
        return $output;
    }

    public function GetAllCceGrade($dataObj) {
        $dataNew = json_decode($dataObj->detail);
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->distinct();
        $dbObj->select('id, grade');
        $dbObj->group_by('grade');
        return $dbObj->get_where('cce_grade_setting', array('standard' => $dataNew->standard))->result_array();
    }

    public function GetAllStudent($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $term = $dataObj->term;
        $dataNew = json_decode($dataObj->detail);
        $dbObj->select('adm_no, adm_no_display, firstname, lastname, sex, dob_date, ad_date, address1, city, state, pin_code,profile_pic_path_thumbnail, section_id, roll_no');
        $resultStudent = $dbObj->get_where('biodata', array('section_id' => $dataNew->section_id))->result_array();
        for ($i = 0; $i < count($resultStudent); $i++) {
            $dbObj->select('di,grade');
            $dbObj->where('term', $term);
            $dbObj->where('adm_no', $resultStudent[$i]['adm_no']);
            $dbObj->where('cce_id', $dataNew->cce_id);
            $result = $dbObj->get('cce_grades_di')->result_array();
            if (sizeof($result) > 0) {
                for ($j = 0; $j < count($result); $j++) {
                    $resultStudent[$i]['di'] = $result[$j]['di'];
                    $resultStudent[$i]['grade'] = $result[$j]['grade'];
                }
            } else {
                $resultStudent[$i]['grade'] = 0;
                $resultStudent[$i]['di'] = NULL;
            }
        }
        return $resultStudent;
    }

    public function SaveGradeDetails($dataObj) {
        $dataMy = json_decode($dataObj->cce_id);
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        if ($dataObj->di == null) {
            $dataObj->di = '';
        }
        if ($dataObj->grade == null) {
            $dataObj->grade = '';
        }
        $data = array('di' => $dataObj->di, 'term' => $dataObj->term, 'grade' => $dataObj->grade, 'adm_no' => $dataObj->adm_no, 'cce_id' => $dataMy->cce_id, 'entry_by' => $this->session->userdata('staff_id'), 'deo_entry_by' => $this->session->userdata('deo_staff_id'));
        $dbObj->where('adm_no', $dataObj->adm_no);
        $dbObj->where('cce_id', $dataMy->cce_id);
        $dbObj->where('term', $dataObj->term);
        $dbObj->delete('cce_grades_di');
        $dbObj->insert('cce_grades_di', $data);
        $groupData = array('di_msg' => $dataObj->di);
        $dbObj->insert('cce_di_list', $groupData);
        return true;
    }

    public function GetCceStaffNameList($cce_id, $Section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $query = "SELECT s.staff_fname,s.staff_lname,c.section_id,c.cce_id,c.staff_id FROM staff_details s,cce_staff_relation c where s.id=c.staff_id and c.cce_id='$cce_id' and c.section_id='$Section_id'";
        $data = $dbObj->query($query)->result_array();
        return $data;
    }

    public function GetCceStudentList($dataObj) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $term = $dataObj->term;
        $Section_id = $dataObj->section_id;
        $this->load->model('core/core', 'newObj');
        $standard = $this->newObj->GetStandardFromSection_id($Section_id);
        $finalmeraaraay = array();
        $dbObj->select('id,cce_name,class,caption_short');
        $cce_list = $dbObj->get_where('cce_list', array('class' => $standard))->result_array();
        for ($k = 0; $k < count($cce_list); $k++) {
            $cceStaffName = $this->GetCceStaffNameList($cce_list[$k]['id'], $Section_id);
            if (sizeof($cceStaffName) > 0) {
                $cce_list[$k]['teacher_name'] = $cceStaffName[0]['staff_fname'] . ' ' . $cceStaffName[0]['staff_lname'];
            } else {
                $cce_list[$k]['teacher_name'] = ' ';
            }
        }
        $finalmeraaraay['cce_element'] = $cce_list;
        $dbObj->select('adm_no,firstname,lastname,profile_pic_path_thumbnail as pic');
        $bioDataResult = $dbObj->get_where('biodata', array('section_id' => $Section_id))->result_array();
        $kk = 0;
        foreach ($bioDataResult as $bio) {
            $adm_no = $bio['adm_no'];
            $ccemeraaraay = array();
            for ($j = 0; $j < count($cce_list); $j++) {

                $dbObj->select('grade,di');
                $dbObj->where('adm_no', $adm_no);
                $dbObj->where('cce_id', $cce_list[$j]['id']);
                $dbObj->where('term', $term);
                $result = $dbObj->get('cce_grades_di')->result_array();

                if (sizeof($result) > 0) {
                    $gradeId = $result[0]['grade'];
                    $garde = $this->GetGradeName($gradeId);
                    $ccemeraaraay[$j]['di'] = $result[0]['di'];
                    $ccemeraaraay[$j]['grade'] = $garde;
                } else {
                    $ccemeraaraay[$j]['di'] = 'NA';
                    $ccemeraaraay[$j]['grade'] = 'NA';
                }
            }
            for ($l = 0; $l < count($ccemeraaraay); $l++) {
                if ($ccemeraaraay[$l]['di'] == 'NA' && $ccemeraaraay[$l]['grade'] == 'NA') {
                    $ccemeraaraay[$l]['color'] = 'style-danger';
                } else if ($ccemeraaraay[$l]['grade'] == 'NA' || $ccemeraaraay[$l]['grade'] == '') {
                    $ccemeraaraay[$l]['color'] = 'style-warning';
                    $ccemeraaraay[$l]['grade'] = 'NA';
                } else if ($ccemeraaraay[$l]['di'] == 'NA' || $ccemeraaraay[$l]['di'] == '') {
                    $ccemeraaraay[$l]['color'] = 'style-info';
                    $ccemeraaraay[$l]['di'] = 'NA';
                } else {
                    $ccemeraaraay[$l]['color'] = 'style-success';
                }
            }

            $bioDataResult[$kk]['cce'] = $ccemeraaraay;
            $kk = $kk + 1;
        }
        $finalmeraaraay['student'] = $bioDataResult;
        return $finalmeraaraay;
    }

    public function GetGradeName($gradeId) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('grade');
        $result = $dbObj->get_where('cce_grade_setting', array('id' => $gradeId))->result_array();
        $grade = $result[0]['grade'];
        return $grade;
    }

    public function GetClassTeacherName($section_id) {
        $dbObj = $this->load->database($this->session->userdata('database'), TRUE);
        $dbObj->select('a.staff_fname,a.staff_lname');
        $dbObj->from('staff_details as a');
        $dbObj->join('section_list as b', 'a.id=b.class_teacher_id');
        $dbObj->where('b.id', $section_id);
        $staff_detail = $dbObj->get()->row_array();
        if (!empty($staff_detail)) {
            $staff_name = $staff_detail['staff_fname'] . ' ' . $staff_detail['staff_lname'];
            return $staff_name;
        } else {
            $staff_name = "No Teacher Assign yet..";
            return $staff_name;
        }
    }

}
