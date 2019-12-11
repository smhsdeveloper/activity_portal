<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">

    <title>RMera School Portal Login | Reset Password</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Mera School Portal,School Management Online Portal,SAMS">
    <meta name="description" content="Mera School Portal is web based school automation sytstem to handle all type of school activity">
    <!-- END META -->

    <?php $this->load->view('include/headcss');?>
    <style type="text/css"></style>

</head>

<body ng-app="login" ng-controller="loginController" class="menubar-hoverable header-fixed " style="background-color: white">

    <!-- BEGIN LOGIN SECTION -->
    
    <section class="section-account" >
        <!--<div class="img-backdrop" style="background-image: url('<?php //echo base_url(); ?>assets/img/modules/materialadmin/img16.jpg')"></div>-->
        <div class="spacer"></div>
        <div class="card contain-sm style-transparent">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-head card-head-xs">
                                <header class="text-lg text-bold text-primary"></header>                                
                            </div>
                            <div class="card-body">
                                <img src="<?php echo base_url(); ?>assets/img/modules/materialadmin/deactivate.jpg">
                            </div>
                        </div>
                    </div><!--end .col -->
                    <div class="col-sm-6">
                        <div class="card card-underline">
                            <div class="card-head card-head-xs">
                                <header class="text-lg text-bold text-primary"> Account Deactivated</header>                                
                            
                            </div>
                            
                            <div class="card-body">
                                <p>Your can not login to portal. You account is deactivated by School ADMIN. Contact to school to activate your account. </p>    
                               <!--<div class="img-backdrop" style="background-image: url('<?php //echo base_url(); ?>assets/img/modules/materialadmin/deactivated.jpg')"></div>-->
                            </div>
                        </div>
                    </div><!--end .col -->
                </div><!--end .row -->
            </div><!--end .card-body -->
        </div><!--end .card -->
    </section>
    <!-- END LOGIN SECTION -->
    <!-- BEGIN JAVASCRIPT -->
    <?php $this->load->view('include/headjs');?>
    <script src="<?php echo base_url(); ?>assets/myjs/login.js?a=1"></script>
    <script>var myUrl = "<?php echo base_url(); ?>";</script>
    <div id="device-breakpoints"><div class="device-xs visible-xs" data-breakpoint="xs"></div><div class="device-sm visible-sm" data-breakpoint="sm"></div><div class="device-md visible-md" data-breakpoint="md"></div><div class="device-lg visible-lg" data-breakpoint="lg"></div></div></body></html>