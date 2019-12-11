<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!defined('BASEPATH'))
 exit('No direct script access allowed');

class login_model extends CI_Model {

 public function SuperLogin($user_id, $login_person, $login_person_id) {
  include(APPPATH . 'config/database' . EXT);
  $webUserDsn = "mysqli://" . $db['default']['username'] . ":" . $db['default']['password'] . "@localhost/" . $db['default']['database'];
  $systemDBObj = $this->load->database($webUserDsn, TRUE);
  $systemDBObj->select('usrname as username,pass as password');
  $data = $systemDBObj->get_where('system_users', array('id' => $user_id))->row_array();
  if (!empty($data)) {


   $result = $this->checkLoginDetail($data, $login_person, $login_person_id);
   if ($result == 'TRUE') {
    return $result;
   } else {
    return $result;
   }
  } else {
   return $data = -1;
  }
 }

 public function checkLoginDetail($data, $login_person, $login_person_id) {

  $results = $this->getusername($data['username']);

  if (!empty($results)) {
   $result = $this->db->get_where('system_users', array('staff_id' => $results['id'], 'pass' => $data['password']))->row_array();

   if (isset($result['id'])) {
    if ($result['member_type'] == 'COMPANY') {
     $resultLogin = $this->db->get_where('user_login_logs', array("user_id" => $result['id'], "login_person" => 'USER'))->row_array();

     if (isset($resultLogin['id']) || $login_person_id > 0) {
      if ($result['login_activated'] == 'YES' || $login_person_id > 0) {
       if ($result['password_reset'] == 'NO' || $login_person_id > 0) {

        switch ($result['member_type']) {

         case 'COMPANY':
         $companyStaffDetail = $this->db->get_where('company_staff_details', array("id" => $result['staff_id']))->row_array();

         $this->session->set_userdata(array("logintype" => "COMPANY",
          "company_staff_id" => $result['staff_id'],
          "user_id" => $result['id'],
          "workinghrs" => '8',
          "staff_rm_id" => $companyStaffDetail['rm_id'],
          "admin_type" => $companyStaffDetail['admin_type'],
          "department" => $companyStaffDetail['department'],
          "company_staff_name" => $companyStaffDetail['name'],
          "company_staff_designation" => $companyStaffDetail['designation']));

                                        //Insert a touple in login logs___
         $dataLogin = array(
          'user_id' => $result['id'],
          'login_person' => $login_person,
          'ip_info' => $_SERVER['REMOTE_ADDR'],
          'browser_info' => $_SERVER['HTTP_USER_AGENT']
          );
         $this->db->insert('user_login_logs', $dataLogin);
         return "COMPANY";
         break;
         default :
         break;
        }
       } else {
        return "RESET";
       }
      } else {
       return "DEACTIVATED";
      }
     } else {
      
      $this->session->set_userdata(array("staff_id" => $result['staff_id']));
      return "FIRSTTIMELOGIN";
     }
                } else { // If DB name not found
                 return "DBNOTFOUND";
                }
               } else {
                return "MISMATCH";
               }
              } else {
               return "MISMATCH";
              }

              exit();
             }

             public function verifypassword($data, $empid) {
              $this->db->select('id');
              $result = $this->db->get_where('system_users', array('staff_id' => $empid, 'pass' => $data))->row_array();
              if (count($result) > 0) {
               return TRUE;
              } else {
               return FALSE;
              }
             }

             public function changeidpassword($arrData) {
              $data = json_decode($arrData, true);

              $staff_id = $data['staff_id'];
              $newpassword = $data['newpassword'];
              $oldpassword = $data['oldpassword'];

              $this->db->select('id');
              $validateoldlogin = $this->db->get_where("system_users", array('staff_id' => $staff_id, 'pass' => $oldpassword))->result_array();

              if (!empty($validateoldlogin)) {
               $this->db->select('id');
               $username = $this->db->get_where("system_users", array('staff_id' => $staff_id))->row_array();
               if (!empty($username)) {
                ///ALL IS WELL CASE- change its login id as password
                $dataInsert = array(
                 'pass' => $newpassword
                 );
                $dataLogin = array(
                 'user_id' => $username['id'],
                 'login_person' => 'USER',
                 'login_person_id' => '-2',
                 'ip_info' => $_SERVER['REMOTE_ADDR'],
                 'browser_info' => $_SERVER['HTTP_USER_AGENT']
                 );
                $this->db->where('staff_id', $staff_id);
                if ($this->db->update('system_users', $dataInsert)) {
                 $this->db->insert('user_login_logs', $dataLogin);
                 return "TRUE";
                } else {
                 return "DB_ENTRY_WRONG";
                }
               } else {
                return 'USER_NAME_NOT_AVAILABLE';
               }
              } else {
               return 'WRONG_OLD_ID_PASSWORD';
              }
             }

             public function resetPassword($arrPassword) {
              if (isset($arrPassword)) {
               $data = array(
                'pass' => $arrPassword['newpassword']
                );
               $this->db->where('staff_id', $arrPassword['staff_id']);
               if ($this->db->update('system_users', $data)) {
                return "TRUE";
               } else {
                return "WRONG";
               }
              } else {
               return "FALSE";
              }
              exit();
              $user_id = $this->session->userdata('user_id');
              $this->db->select('id');
              $this->db->from('system_users');
              $this->db->where('id', $user_id);
              $this->db->where('pass', $arrPassword['oldpassword']);
              $query = $this->db->get();
              if ($query->num_rows() > 0) {
               $row = $query->row();
               if ($row->id == $this->session->userdata('user_id')) {
                $data = array(
                 'pass' => $arrPassword['newpassword']
                 );
                $this->db->where('id', $this->session->userdata('user_id'));
                if ($this->db->update('system_users', $data)) {
                 return "TRUE";
                } else {
                 return "WRONG";
                }
               } else {
                return "WRONG";
               }
              } else {
               return "FALSE";
              }
             }

             public function resetforgotpassword($arrPassword) {
              $this->db->select('id');
              $this->db->from('system_users');
              $this->db->like('usrname', $arrPassword['username']);
              $query = $this->db->get()->row_array();

              if (count($query) > 0) {
               $data = array(
                'pass' => $arrPassword['newpassword']
                );
               $updatecondition = array(
                "id" => $query['id']
                );
               if ($this->db->update('system_users', $data, $updatecondition)) {
                return "TRUE";
               } else {
                return "WRONG";
               }
              } else {
               return "FALSE";
              }
             }

             public function checkLogin($id) {
              $this->db->select('user_id');
              $username = $this->db->get_where("user_login_logs", array('user_id' => $id))->result_array();
              if (count($username) > 0) {
               return $username[0]['user_id'];
              } else {
               return 'NA';
              }
             }

             public function getusername($email) {
              $this->db->select('id');
              $result = $this->db->get_where("company_staff_details", array('email_address' => $email))->row_array();
              return $result;
             }

             public function getmenulist($id) {
              $chekarr = array();
              $this->db->select('*');
              $chekarr['menuArr'] = $this->db->get_where('child_main_menu_relation')->result_array();
              if (!empty($chekarr['menuArr'])) {
               $i = 0;
               foreach ($chekarr['menuArr'] as $key => $value) {
                $data = $this->db->get_where('emp_menu_relation', array('menu_id' => $value['id'], 'emp_id' => $id))->row_array();
                if (!empty($data)) {

                 $chekarr['menuArr'][$key]['color'] = 'lightgreen';
                 $chekarr['menuArr'][$key]['is_check'] = TRUE;
                 $i++;
                } else {
                 $chekarr['menuArr'][$key]['is_check'] = FALSE;
                 $chekarr['menuArr'][$key]['color'] = 'white';
                }
               }
               $chekarr['checkCount'] = $i;
              }

              return $chekarr;
             }

             public function savelists($data) {
              $this->db->where(array('emp_id' => $data['emp_id']));
              $this->db->delete('emp_menu_relation');
              foreach ($data['data'] as $key => $value) {
               if ($value['is_check'] == '1') {
                $dataarry = array(
                 'emp_id' => $data['emp_id'],
                 'menu_id' => $value['id'],
                 'entry_by' => $this->session->userdata('company_staff_id')
                 );
                $this->db->insert('emp_menu_relation', $dataarry);
               }
              }
              return TRUE;
             }

             public function getcurrentmenulist() {
              $emp_id = $this->session->userdata('company_staff_id');
              $this->db->select('id,menu_caption,class');
              $menuarr = array();
              $result = $this->db->get_where('main_menu_details')->result_array();
              foreach ($result as $key => $value) {
               $this->db->select('id,main_menu_id,menu_caption,url');
               $result[$key]['childmenu'] = $this->db->get_where('child_main_menu_relation', array('main_menu_id' => $value['id']))->result_array();

               foreach ($result[$key]['childmenu'] as $key1 => $value1) {
                $data = $this->db->get_where('emp_menu_relation', array('menu_id' => $value1['id'], 'emp_id' => $emp_id))->row_array();
                if (!empty($data)) {

                } else {
                 unset($result[$key]['childmenu'][$key1]);
                }
               }
               if (isset($result[$key]['childmenu']) && !empty($result[$key]['childmenu'])) {
                $menuarr[] = $result[$key];
               } else {
                unset($result[$key]);
               }
              }
              return $menuarr;
             }

             public function assingMenuNormalUser() {
              $allEmp = $this->db->get_where('company_staff_details', array('active_status' => 'WORKING'))->result_array();
        $menuArr = $this->db->query("SELECT * FROM `child_main_menu_relation` WHERE `menu_caption` IN ('Punch Activity','Self Review')")->result_array(); //array('1','16');
        if (!empty($allEmp)) {
         foreach ($allEmp as $key => $val) {
          for ($i = 0; $i < count($menuArr); $i++) {
           $this->db->insert('emp_menu_relation', array('emp_id' => $val['id'], 'menu_id' => $menuArr[$i]['id']));
          }
         }
        }
       }



       public function GmailAuth($userObj,$tokenObj){
        $empdata=  $this->db->get_where('company_staff_details', array("email_address" => $userObj['email'],'active_status'=>'WORKING'))->row_array();
        if(!empty($empdata)){
         $systemuserData=$this->db->get_where('system_users',array('staff_id'=>$empdata['id']))->row_array();
         $updateArr=array(
          'google_access_key'=>$tokenObj['access_token'],
          'google_token_id'=>$tokenObj['id_token'],
          'google_user_id'=>$userObj['id']
          );
         $this->db->update('system_users', $updateArr,array('id'=>$systemuserData['id']));
         $this->session->set_userdata(
          array("logintype" => "COMPANY",
          "company_staff_id" => $systemuserData['staff_id'],
          "user_id" => $systemuserData['id'],
          "workinghrs" => '8',
          "staff_rm_id" => $empdata['rm_id'],
          "admin_type" => $empdata['admin_type'],
          "department" => $empdata['department'],
          "company_staff_name" => $empdata['name'],
          "isRM" => ($empdata['is_rm']) ? true : false,
          'google_access_key'=>$tokenObj['access_token'],
          "company_staff_designation" => $empdata['designation']));

                                        //Insert a touple in login logs___
         $dataLogin = array(
          'user_id' => $systemuserData['id'],
          'login_person' => 'USER',
          'ip_info' => $_SERVER['REMOTE_ADDR'],
          'brand_name'=>'GMAIL_LOGIN',
          'browser_info' => $_SERVER['HTTP_USER_AGENT']
          );
         $this->db->insert('user_login_logs', $dataLogin);
        }
        return $empdata;
       }

      }
