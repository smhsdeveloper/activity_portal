<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">

    <title><?php echo appName; ?></title>

    <!-- BEGIN META -->
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- END META -->

    <?php
    $this->load->view('include/headcss');
    $sess_id = $this->session->userdata('staff_id');
    if ($this->session->userdata('logintype') == "COMPANY") {
        $nameStatus = 'Dear ' . $this->session->userdata('company_staff_name');
    } else {
        $nameStatus = '';
    }
    ?>
    <style type="text/css"></style>


    <style>

        body{
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-page{
            display: flex;
            flex-direction: column;
            width: 400px;
            padding: 4%;
            margin: auto;
            background-color: #fff;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
        
        .form-control label{
            color:#000!important;
            
        }
        
        .form-control{
        margin-top: 9px;
        font-size: 14px;
        padding: 0px 10px;
        }

        .login-page form{
            padding: 25px;
        }
        .login-page img{
            width: 300px;
            margin: auto;
        }

        marquee{
            font-size: 15px;
            color:#fff;
        }
        .login-button{
            width:100%;
            border-radius: 0px;
            padding: 8px;
        }

        input:-webkit-autofill{
            background-color: rgb(0, 167, 157) !important;
        }
        
        .card {
           margin-bottom: 0px !important;
        }

    </style>

</head>






<body ng-app="login" ng-controller="loginController" class="menubar-hoverable header-fixed " style="background-image:url('../activity/assets/img/portfolio-item581.jpg');">

    <!-- BEGIN LOGIN SECTION -->
    <section class="section-account" >
        <!--<div class="img-backdrop" style="background-image: url('<?php // echo base_url();              ?>assets/img/modules/materialadmin/img16.jpg')"></div>-->
        <!--<div class="spacer"></div>-->
        <div class="card contain-sm style-transparent">
            <div class="card-body" >

                <div class="row" ng-show="uitype === 'TRUE'">
<!--                    <marquee>Please use your official E-mail id as username </marquee>-->

                    <div class="login-page">

                        <img src="<?php echo base_url() . appLogo; ?>"/>

                        <form name="myForm" class="form floating-label"  accept-charset="utf-8" novalidate>
                            <div class="form-group">
                                <input ng-enter="loginMe()"  required ng-model="username" type="text" class="form-control" id="username" placeholder="Enter Your Official Email ID" name="username">
                                <label for="username">Username</label>
                            </div>
                            <div class="form-group">
                                <input ng-enter="loginMe()" required ng-model="password" type="password" class="form-control" id="password" name="password">
                                <label for="password">Password</label>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button ng-click="loginMe()" class="login-button btn btn-primary btn-raised" type="submit">Login</button>
                                </div><!--end .col -->
                                 <div class="col-xs-12 g-signin2" style="margin-top: 5px;display:none;" >
                                 <a href="<?php echo base_url().'index.php/server/glogin' ?>"><img src="<?php echo base_url() .'assets/img/gbtn.png'; ?>"></a>
                                </div><!--end .col -->
                            </div><!--end .row -->
                            <?php if($msg!='') { ?>
                                <h5> <span class="text-danger"><?php echo$msg;  ?></span></h5>
                         <?php } ?>
                        </form>
                        
                    </div><!--end .col -->

                </div>
            </div><!--end .card-body -->

        </div><!--end .card -->
    </section>
    <!-- END LOGIN SECTION -->
    <!-- BEGIN JAVASCRIPT -->
    <?php $this->load->view('include/headjs'); ?>
    <script src="<?php echo base_url(); ?>assets/myjs/login.js?a=<?php echo rand(2, 50) ?>"></script>
    <script>
                                                            var myUrl = "<?php echo base_url(); ?>";
                                                            var staff_id = '<?php echo $sess_id; ?>';
    </script>
    <div id="device-breakpoints"><div class="device-xs visible-xs" data-breakpoint="xs"></div><div class="device-sm visible-sm" data-breakpoint="sm"></div><div class="device-md visible-md" data-breakpoint="md"></div><div class="device-lg visible-lg" data-breakpoint="lg"></div></div></body></html>
