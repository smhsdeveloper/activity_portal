<?php
include(APPPATH . 'config/database' . EXT);
//echo 'Busy Please try after sometime';
//exit();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Activity Entry</title>
    <?php

    //echo $class;
    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');
    $staff_rm_id = $this->session->userdata('staff_rm_id');
    $department = $this->session->userdata('department');
    // print_r($department);exit;
    ?>
<!--    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/autocomplete/autocomplete.css">-->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="activityreportentry" ng-controller="activityreportentrycontroller">     
        <?php $this->load->view('testing/include/header'); ?>

        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Activity List test </header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-outlined style-primary">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-6"> 
                                                                <form class="form-inline">
                                                                    <div class="form-group">
                                                                        <datepicker date-format="dd-MM-yyyy">
                                                                            <input type="text" class="form-control" id="Firstname5" ng-model="entrydate" ng-change="changedate()">
                                                                        </datepicker>
                                                                    </div>
                                                                    <!--<a href="<?php // echo base_url(); ?>index.php/activity/empactivityentry/{{entrydate}}"  class="btn btn-raised btn-danger ink-reaction">Entry</a>-->
                                                                </form>
                                                            </div>

                                                            <div class="col-sm-4 pull-right"> 
                                                                <div role="alert" class="alert alert-callout alert-success small-padding no-margin text-lg">
                                                                    Total Minutes Worked : <strong >{{totalhour.hour_worked}} Min.</strong> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!--end .card-body -->
                                                </div><!--end .card -->
                                            </div><!--end .col -->
                                        </div>
                                        <?php
                                        if ($entryDate != -1) {
                                            $curDate = date('Y-m-d', strtotime($entryDate));
                                        } else {
                                            $curDate = date('Y-m-d');
                                        }
//                                        if ($entryDate != -1) {
                                        $todaydDate = date('Y-m-d');
                                        $prevdate = date('Y-m-d', strtotime($todaydDate . ' -60 day'));
//                                        echo $prevdate.'--'.$curDate.'--'.$todaydDate.'---'.$entryDate;
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();
                                        $xcrud = Xcrud::get_instance();
//                                            $xcrud->connection($db['default']['username'], $db['default']['password'], $db['default']['database'], $db['default']['hostname']);
                                        $xcrud->table('acr_emp_activity_detail');
                                        $xcrud->columns("project_id,module_id,activity_id,remarks,activity_date,hour_worked");
                                        $xcrud->fields("project_id,module_id,activity_id,remarks,hour_worked");
//                                            $xcrud->relation('department_id', 'department_master', 'id', array("title"));
                                        $xcrud->relation('project_id', 'test_project_details', 'id', 'title',array('status' => 'ACTIVATE'));
                                        
//                                            $xcrud->relation('project_id', 'test_project_details', 'id', array("title"), '', '', '', ' ', '', $department, 'department_id');
                                        $xcrud->relation('module_id', 'test_project_modules_details', 'id', array('title'), '', '', '', ' ', '', 'project_id', 'project_id');
//                                            $xcrud->relation('module_id', 'test_project_modules_details', 'id', array("title"));
                                        $xcrud->relation('activity_id', 'acr_activity_master_list', 'id', "activity_name", array('department_id' => $department));
                                        $xcrud->where('staff_id', $staff_id);
                                        $xcrud->where('activity_date', $curDate);
                                        $xcrud->validation_required(array('project_id')); //, 'activity_id'
                                        $xcrud->label("project_id", "Project Name");
                                        $xcrud->label("module_id", "Module Name");
                                        $xcrud->label("activity_id", "Activity Name");
                                        $xcrud->label("remarks", "Remark");
                                        $xcrud->label("hour_worked", "Hour Worked");
                                        $xcrud->label("staff_rm_id", "R.M. Name");
                                        $xcrud->pass_var("staff_id", $staff_id);
                                        $xcrud->pass_var("staff_rm_id", $staff_rm_id);
                                        $xcrud->before_remove('confirmation');
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->pass_var("activity_date", $curDate);
//                                        if ($prevdate <= $curDate && $curDate <= $todaydDate) {
//                                            $xcrud->unset_add(FALSE);
//                                        } else {
//                                            $xcrud->unset_add(TRUE);
//                                        }
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(FALSE);
                                        $xcrud->unset_remove(FALSE);
                                        echo $xcrud->render();
//                                        }
                                        ?>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                        </div>
                    </div><!--end .row -->
                </section>
            </div><!--end .section-body -->
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
                    function changeURL(element) {
                        if (element.value == '') {
                        } else {
                            window.location = "<?php echo base_url(); ?>index.php/staff/managesubject/" + element.value;
                        }
                    }
        </script>
        <script type="text/javascript">
                    var myURL = "<?php echo base_url(); ?>";
                    var myDate = "<?php
        if ($entryDate == -1) {
            echo date("d-m-Y");
        } else {
            echo $entryDate;
        }
        ?>";
        </script>
        <script>var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>assets/myjs/activity.js?a=<?php echo rand(5, 10) ?>"></script>
    </body>
</html>

