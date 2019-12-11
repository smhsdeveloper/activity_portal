<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>OTP Details </title>
    <?php
    //echo $class;

    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="otp" ng-controller="otpController">
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base" >
            <div id="content">

                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header></header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label for="regular13" class="col-sm-2 control-label">Select Date</label>
                                                <div class="col-sm-2">
                                                    <datepicker date-format="dd-MM-yyyy">
                                                        <input type="text" class="ng-pristine ng-valid ng-touched" ng-model="datea" id="regular13">
                                                    </datepicker>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button ng-click="seleDate(datea);" class="btn btn-success btn-sm" id="regular13" type="text">Go</button>
                                                </div>
                                            </div> 

                                        </div>

                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Employee Activity List</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No </th>
                                                    <th>Employee Name</th>
                                                    <th>Designation</th>
                                                    <th>OTP</th>
                                                    <th>OTP Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="x in otpstatus">
                                                    <td>{{$index + 1}}</td>
                                                    <td>{{x.empname}}</td>
                                                    <td>{{x.designation}}</td>
                                                    <td>{{x.otp}}</td>
                                                    <td>{{x.status}}</td>
                                                </tr>
                                            </tbody>

                                        </table>

                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->

                        </div>
                    </div><!--end .row -->
            </div><!--end .section-body -->
        </section>
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN MENUBAR-->
    <div id="menubar" class="menubar-inverse ">
        <div class="menubar-fixed-panel">
            <div>
                <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="expanded">
                <a href="dashboard.html">
                    <span class="text-lg text-bold text-primary ">MATERIAL&nbsp;ADMIN</span>
                </a>
            </div>
        </div>
        <div class="menubar-scroll-panel">
            <?php $this->load->view('testing/include/menu'); ?>
        </div>
    </div>
    <?php
    $this->load->view('include/headjs');
    ?>
    <script>var myURL = "<?php echo base_url(); ?>";</script>
    <script>var currentDate = "<?php echo date('d-m-Y'); ?>";</script>
    <script src="<?php echo base_url(); ?>assets/myjs/otpdetails.js"></script> 
</body>
</html>