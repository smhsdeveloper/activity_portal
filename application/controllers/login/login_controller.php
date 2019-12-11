<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login_controller extends CI_Controller {

    public function index() {
        if (!$this->session->userdata('logintype')) {
            $this->load->view('login/login',array('msg'=>($this->input->get('msg'))?$this->input->get('msg'):''));
        } else {

            switch ($this->session->userdata('logintype')) {
                case "STAFF":
                switch ($this->session->userdata('staff_desig')) {
                    case "ADMIN":
                    redirect(str_replace("index.php/", "", 'staff/admindashboard'));
                    break;
                    case "FACULTY":
                    redirect(str_replace("index.php/", "", 'staff/staffdashboard'));
                    break;
                    case "DEO":
                    redirect(str_replace("index.php/", "", 'staff/deo'));
                     break;
                    default :
                    echo 'PROBLEM IN LOGIN TYPE. Please contact to admin.';
                    exit();
                }
                break;
                case "PARENT":
                redirect(str_replace("index.php/", "", 'parent/homepage'));
                break;

                case "COMPANY":
                redirect(str_replace("index.php/", "", 'testing/company'));
                break;
                default :
                $this->session->sess_destroy();
                redirect("/");
            }
        }
    }

    public function checkLoginDetail() {

        $this->load->model('login/login_model', "loginModel");
        $result = $this->loginModel->checkLoginDetail(json_decode($this->input->post('data'), true), 'USER', '-1');

        switch ($result) {
            case "TRUE":
            echo printCustomMsg("TRUE", "Login Successfully", null);
            break;
            case "COMPANY":
            echo printCustomMsg("COMPANY", "Login Successfully", null);
            break;
            case "MISMATCH":
            echo printCustomMsg("FALSE", "Login ID and password mismatch", null);
            break;
            case "FIRSTTIMELOGIN":
            echo printCustomMsg("FIRSTTIMELOGIN", "It seems you have login here first time. You must change you Login Id and passowrd.", null);
            break;
            case "DEACTIVATED":
            echo printCustomMsg("DEACTIVATED", "Your Account has been deactivated. Please contact to admin for further detail.", null);
            break;
            case "RESET":
            echo printCustomMsg("RESET", "Your Account password is reset by School Admin. You must change your passowrd and proceed.", null);
            break;
            case "FALSE":
            echo printCustomMsg("FALSE", "UNKNOWN ERROR", null);
            break;
            case "DBNOTFOUND":
            echo printCustomMsg("DBNOTFOUND", "Problem in School Database configuration. Please contact to school admin", null);
            break;
            default :
            echo printCustomMsg("FALSE", $result, null);
            break;
        }
    }

    public function resetpassword() {
        if ($this->session->userdata('logintype')) {
            $this->load->view('login/changepassword');
        } else {
            $this->session->sess_destroy();
            redirect("/");
        }
    }

    public function forgotpassword() {
        $this->load->view('login/resetpassword');
    }

    public function CheckResetPassword() {
        $this->load->model('login/login_model', "loginModel");
        $result = $this->loginModel->resetPassword(json_decode($this->input->post('data'), true));
        switch ($result) {
            case "TRUE":
            echo printCustomMsg("TRUE", "Password Changed Successfully", null);
            break;
            case "FALSE":
            echo printCustomMsg("FALSE", "Wrong Old Password", null);
            break;
            case "WRONG":
            echo printCustomMsg("WRONG", "Something Went Wrong, Password Not Changed", null);
            break;
            default :
            echo printCustomMsg("FALSE", $result, null);
            break;
        }
    }
    public function resetforgotpassword() {
        $this->load->model('login/login_model', "loginModel");
        $result = $this->loginModel->resetforgotpassword(json_decode($this->input->post('data'), true));
        switch ($result) {
            case "TRUE":
            echo printCustomMsg("TRUE", "Password Changed Successfully", null);
            break;
            case "FALSE":
            echo printCustomMsg("FALSE", "Username Not Found", null);
            break;
            case "WRONG":
            echo printCustomMsg("WRONG", "Something Went Wrong, Password Not Changed", null);
            break;
            default :
            echo printCustomMsg("FALSE", $result, null);
            break;
        }
    }

    public function changeidalso() {
        $this->load->model('login/login_model', 'checklogin');
        $result = $this->checklogin->checkLogin($this->session->userdata('user_id'), true);
        $this->load->view('login/change_loginid_password', array("login" => $result));
    }
    public function verifypassword() {
        $this->load->model('login/login_model', 'checklogin');
        $result = $this->checklogin->verifypassword($this->input->post('data'), $this->session->userdata('staff_id'));
        if($result){
            echo 'TRUE';
        }else{
            echo 'FALSE';
        }
    }

    public function changeidpassword() {
        $this->load->model('login/login_model', 'changeidpassword');
        $result = $this->changeidpassword->changeidpassword($this->input->post('data'), true);
        switch ($result) {
            case "WRONG_OLD_ID_PASSWORD":
            echo printCustomMsg($result, "Your current login id password is not correct. Please re-enete it and proceed.", null);
            break;
            case "USER_NAME_NOT_AVAILABLE":
            echo printCustomMsg($result, "This username is not available. Please select the other username", null);
            break;
            case "DB_ENTRY_WRONG":
            echo printCustomMsg($result, "Problem in saving data", null);
            break;
            case "TRUE":
            echo printCustomMsg($result, "Password Succesfully Changed, Please login again with your new username and password", null);
            break;
            case "NEW_PASSWORD_MISMATCH":
            echo printCustomMsg($result, "New Password Mistach", null);
            break;
            default :
            echo printCustomMsg('NA', "Something went wrong", null);
            break;
        }
        exit();
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect("/");
    }

    public function accountdeactivate() {
        $this->load->view('login/accountdeactivated');
    }

    private function getFirstController($staffMenu) {
        foreach ($staffMenu as $value) {
            foreach ($value['childDetail'] as $value) {
                if ($value['selected']) {
                    return $value['page_url'];
                }
            }
        }
    }
    public function getmenulists() {
        $id = json_decode($this->input->post('data'), true);
        $this->load->model('login/login_model', 'menulist');
        $result = $this->menulist->getmenulist($id);
        if (!empty($result)) {
            echo printCustomMsg("TRUE", "Data Load Successfully", $result);
        } else {
            echo printCustomMsg("FALSE", "No Data Found !", array());
        }
    }

    public function savelist() {
        $data = json_decode($this->input->post('data'), true);
        $this->load->model('login/login_model', 'savemodel');
        $result = $this->savemodel->savelists($data);
        if (!empty($result)) {
            echo printCustomMsg("TRUE", "Data Save Successfully", $result);
        } else {
            echo printCustomMsg("FALSE", "Please check insert data !", array());
        }
    }
    public function previlage() {
        $this->load->model('login/login_model', 'savemodel');
        $this->savemodel->assingMenuNormalUser();
        
    }


    public function GmailLogin(){
        $filePath= FCPATH.'client_secret.json';
        $client = new Google_Client();
        $client->setAuthConfigFile($filePath);
        $client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));
        if ($this->session->userdata('google_access_key')) {
          $client->setAccessToken($this->session->userdata('google_access_key'));
          redirect("/");
      } else {
          $redirect_uri = base_url() . 'index.php/oauth2callback';
          redirect( filter_var($redirect_uri, FILTER_SANITIZE_URL));       
      }

  }


  public function OauthCallBack(){
    $this->load->model('login/login_model', "modelObj");
    $filePath= FCPATH.'client_secret.json';
    $client = new Google_Client();
    $client->setAuthConfig($filePath);
    $client->setRedirectUri(base_url() . 'oauth2callback');
    $client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));
    if (! isset($_GET['code'])) {
      $auth_url = $client->createAuthUrl();
      header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
  } else {  
    $client->authenticate($_GET['code']);
    $token= $client->getAccessToken();
    $userDetails = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $token['access_token']);
    $userData = json_decode($userDetails,true);
    if(VerifyDomain($userData['hd'])){
     $result= $this->modelObj->GmailAuth($userData,$token);
      redirect("/");
 }else{
    $msg='Please use official email id for login.';
    redirect("/?msg=".$msg); 
 }

}

}
}

?>
