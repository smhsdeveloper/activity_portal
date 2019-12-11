<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <title>Activity Portal | Reset Password</title>
    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Mera School Portal,School Management Online Portal,SAMS">
    <meta name="description" content="Mera School Portal is web based school automation sytstem to handle all type of school activity">
    <!-- END META -->
    <?php
    
    $sess_id = $this->session->userdata('company_staff_id');
    if ($this->session->userdata('logintype') == "COMPANY") {
        $nameStatus = 'Dear ' . $this->session->userdata('company_staff_name');
    } else {
        $nameStatus = '';
    }
    ?>
    <?php $this->load->view('include/headcss'); ?>
    <style type="text/css"></style>

</head>
<body ng-app="login" ng-controller="loginController" class="menubar-hoverable header-fixed " style="background-color: white">

    <!-- BEGIN LOGIN SECTION -->

    <section class="section-account" >
        <!--<div class="img-backdrop" style="background-image: url('<?php //echo base_url();     ?>assets/img/modules/materialadmin/img16.jpg')"></div>-->
        <div class="spacer"></div>
        <div class="card contain-sm style-transparent">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card card-underline">
                            <div class="card-head card-head-xs">
                                <header class="text-lg text-bold text-primary">Reset your account password</header>                                
                            </div>
                            <div class="card-body">
                                <div class="form floating-label">
                                 <form name="userForm">
                                    <div class="form-group">
                                        <input required ng-model="newpassword" type="password" class="form-control" id="username" name="newpassword">
                                        <label for="username">New Password</label>
                                    </div>
                                    <div class="form-group">
                                        <input required ng-model="reenternewpassword" type="password" class="form-control" id="password" name="reenternewpassword">
                                        <label for="password">Re-Enter New Password</label>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-6 text-left">
                                            <div class="checkbox checkbox-inline checkbox-styled">
                                                <label>

                                                </label>
                                            </div>
                                        </div><!--end .col -->
                                        <div class="col-xs-6 text-right">
                                            <button ng-click="resetPassword()" ng-disabled="userForm.$invalid" class="btn btn-primary btn-raised" type="submit">Reset Password</button>
                                        </div><!--end .col -->
                                    </div><!--end .row -->
                                </form>
                                    </div>
                            </div>
                        </div>
                    </div><!--end .col -->
                    <div class="col-sm-6">
                        <div class="card card-underline">
                            <div class="card-head card-head-xs">
                                <header class="text-lg text-bold text-primary">Reset Password</header>                                
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