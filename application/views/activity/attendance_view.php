<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Manage Attendance</title>
    <?php
    //echo $class;

    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');
    $this->load->library("loadxcrud");
    echo Xcrud::load_css();
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="attendance" ng-controller="attendanceController">
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base" >
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-outlined style-primary">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-6"> 
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <datepicker date-format="dd-MM-yyyy">
                                                                            <input type="text" class="form-control" id="Firstname5" ng-model="entrydate">
                                                                        </datepicker>
                                                                    </div>
                                                                    <a href="<?php echo base_url(); ?>index.php/activity/attendance/{{entrydate}}"  class="btn btn-raised btn-danger ink-reaction">GO</a>
                                                                </form>
                                                            </div>

                                                            
                                                        </div>
                                                    </div><!--end .card-body -->
                                                </div><!--end .card -->
                                            </div><!--end .col -->
                                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-body style-default-bright">

                                        <table class="table table-condensed table-bordered no-margin" ng-show="type === 'true'">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Employee Name</th>
                                                    <th>Designation</th>
                                                    <th>RM Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr ng-repeat="x in alluser">
                                                    <td>{{$index + 1}}</td>
                                                    <td>{{x.empname}}</td>
                                                    <td>{{x.designation}}</td>
                                                    <td>{{x.rmname}}</td>
                                                    <td ng-if="x.status === 'NA'" ><button  class="btn btn-success btn-xs" ng-click="actionClick(x.id)">Absent/Leave</button></td>
                                                    <td ng-if="x.status === 'Absent'"><button class="btn btn-danger btn-xs"> Absent </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-center"ng-show="type === 'false'">
                                            <h4>Today is {{attendance.atten}} so you Can not mark Attendance</h4>
                                        </div>

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
    echo Xcrud::load_js();
    ?>
    <script>
        var base_url = '<?php echo base_url(); ?>';
        var myDate = "<?php
        if ($entryDate == -1) {
            echo date("d-m-Y");
        } else {
            echo $entryDate;
        }
        ?>";
    </script>
    <script src="<?php echo base_url(); ?>/assets/myjs/common.js"></script>
    <script src="<?php echo base_url(); ?>/assets/myjs/attendance.js"></script>
