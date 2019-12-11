<?php
$sess_id = $this->session->userdata('staff_id');

if ($this->session->userdata('login_case') == 'FIRSTTIMELOGIN') {

} else {
  
  //    <li><a href="<?php echo site_url('login/logout'); "><i class="fa fa-fw fa-power-off text-danger"></i> Login again</a></li>
 
}
if ($this->session->userdata('logintype') == "COMPANY") {
        $nameStatus = 'Dear ' . $this->session->userdata('company_staff_name');
    } else {
        $nameStatus = '';
    }
   
?>
<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">

    <title>Mera School Portal Login | Change ID Password</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Mera School Portal,School Management Online Portal,SAMS">
    <meta name="description" content="Mera School Portal is web based school automation sytstem to handle all type of school activity">
    <!-- END META -->

<?php $this->load->view('include/headcss'); ?>
    <style type="text/css"></style>

</head>

<body ng-app="login" ng-controller="loginController" class="menubar-hoverable header-fixed " style="background-color: white">

    <!-- BEGIN LOGIN SECTION -->
    <section class="section-account" >
        <div class="img-backdrop" style="background-image: url('<?php echo base_url(); ?>assets/img/modules/materialadmin/img16.jpg')"></div>
        <div class="spacer"></div>
        <div class="card contain-sm style-transparent">

            <div class="card-body">
                <div class="row">

                    <div class="col-sm-6">
                        <div class="card ">
                            <div class="card-head card-head-xs">
                                <header class="text-lg text-bold text-primary"><span class="text-lg text-bold text-primary">Invetech Activity Portal</span></header>                                
                            </div>
                            <div class="card-body">
                                <div class="form floating-label">
                                    <form name="userForm">
                                        <div class="form-group" show-errors>
                                            <input  ng-keyup="getolduser(main.currentuser, $index)" required type="text" class="form-control" name="currentuser" ng-model="main.currentuser" >
                                            <p ng-show="user == 'no'" class="help-block" style="color: red">Please Enter Current User Name</p>
                                            <label for="currentuser">Current User Name</label>
                                        </div>
                                        <div class="form-group">
                                            <input ng-keyup="getcurrentpassword(main.currentpassword, $index)" required type="password" class="form-control" name="currentpassword" ng-model="main.currentpassword">
                                            <p ng-show="oldpass == 'no'" class="help-block" style="color: red">Please Enter Current Password</p>
                                            <label for="currentpassword">Current Password</label>
                                        </div>

                                        <div class="form-group">
                                            <input ng-keyup="getnewuser(main.newuser, $index)" ng-enter="loginMe()" required type="text" class="form-control" name="newuser" ng-model="main.newuser">
                                            <p ng-show="user == 'yes'" class="help-block" style="color: red">Your old And New user Name is Same</p>
                                            <label for="newuser">New User Name</label>
                                        </div>
                                        <div class="form-group">
                                            <input ng-keyup="getNewpass(main.newpass, $index)" required type="password" class="form-control" name="newpass" ng-model="main.newpass">
                                            <span ng-show="type == 'no'" class="glyphicon glyphicon-remove-sign form-control-feedback"></span>
                                            <span ng-show="type == 'yes'" class="glyphicon glyphicon-ok form-control-feedback"></span>
                                            <p ng-show="oldpass == 'yes'" class="help-block" style="color: red">Your old And New Password is Same</p>
                                            <label for="newpass">New Password</label>
                                        </div>
                                        <div class="form-group" >
                                            <input ng-keyup="getrepass(main.repasword, $index)" ng-enter="loginMe()" required type="password" class="form-control" name="repasword" ng-model="main.repasword">
                                            <p ng-show="types == 'yes'" class="help-block"style="color: green">Password Match</p>
                                            <p ng-show="types == 'no'" class="help-block" style="color: red">Password Not Match</p>
                                            <p ng-show="types == 'ok'" class="help-block">New Password Not Found</p>
                                            <label for="repasword">Re-Enter New Password</label>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-xs-6 text-right">
                                            <button ng-click="resetfirstPassword()" ng-disabled="userForm.$invalid" class="btn btn-primary btn-raised" type="button">Change UserName & Password</button>
                                        </div><!--end .col -->
                                    </div><!--end .row -->
                                </div>
                            </div><!--end .col -->
                        </div><!--end .col -->
                    </div><!--end .col -->
                    <div class="col-sm-6">
                        <div class="card card-underline">
                            <div class="card-head card-head-xs">
                                <header class="text-lg text-bold text-primary">How to change ID Password?</header>                                
                            </div>
                            <div class="card-body">
                                Welcome <?php echo $nameStatus; ?>, You account password is reset. You can not login into the portal without setting you new password. 
                                you password is being reset by either School Admin or by you.
                            </div>
                        </div>
                    </div><!--end .col -->
                </div><!--end .row -->
            </div><!--end .card-body -->
        </div><!--end .card -->
    </section>
    <!-- END LOGIN SECTION -->
    <!-- BEGIN JAVASCRIPT -->
<?php $this->load->view('include/headjs'); ?>
    <script src="<?php echo base_url(); ?>assets/myjs/login.js?a=1"></script>
   <script>
                                                            var myUrl = "<?php echo base_url(); ?>";
                                                            var staff_id = '<?php echo $sess_id; ?>';
    </script>

    <div id="device-breakpoints"><div class="device-xs visible-xs" data-breakpoint="xs"></div><div class="device-sm visible-sm" data-breakpoint="sm"></div><div class="device-md visible-md" data-breakpoint="md"></div><div class="device-lg visible-lg" data-breakpoint="lg"></div></div></body></html>
<?php
?>