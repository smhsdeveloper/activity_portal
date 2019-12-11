<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Activity view</title>
    <?php
    //echo $class;
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="empactivityview" ng-controller="activityviewcontroller">
        <script> var hours = <?php echo json_encode($hourworked); ?>;</script>
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg " ng-cloak>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>view the activity report</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-outlined style-primary">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label for="Firstname5" class="col-sm-4 control-label">From</label>
                                                                        <div class="col-sm-8">
                                                                            <datepicker date-format="dd-MM-yyyy">
                                                                                <input type="text" class="form-control" id="Firstname5" ng-model="from">
                                                                            </datepicker>
                                                                            <div class="form-control-line"></div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 margin-bottom-xxl">
                                                                    <div class="form-group">
                                                                        <label for="Lastname5" class="col-sm-4 control-label">To</label>
                                                                        <div class="col-sm-8">
                                                                            <datepicker date-format="dd-MM-yyyy">
                                                                                <input type="text" class="form-control"  id="Lastname5" ng-model="to">
                                                                            </datepicker>
                                                                            <div class="form-control-line"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 margin-bottom-xxl">
                                                                    <div class="form-group">
                                                                        <select id="select1" name="select1" class="form-control" ng-model="empid" ng-init="empid = 0" ng-change="getReport(from,to,empid)">
                                                                            <option value="0">Select employee </option>
                                                                            <option value="{{emp.id}}" ng-selected="'<?php echo $empid; ?>' === emp.id" ng-repeat="emp in emplist">{{emp.name}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div col-sm-6>  
                                                                    <div class="col-sm-6"> 
                                                                        <div role="alert" class="alert alert-callout alert-success small-padding no-margin text-lg">
                                                                            Total Minutes Worked : <strong> {{totalhours}} Min.</strong> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!--end .card-body -->

                                                    </div><!--end .card -->
                                                </div><!--end .col -->

                                            </div>
                                        </div><!--end .card-body -->
                                        <div class="card-body" ng-show="empid > 0 || '<?php echo $empid; ?>'>0 ">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-outlined style-primary">
                                                        <div class="card-body">
                                                            <?php
                                                            $this->load->library('loadxcrud');
                                                            $xcrud = Xcrud::get_instance();
                                                            $xcrud->connection($db['default']['username'], $db['default']['password'], $db['default']['database'], $db['default']['hostname']);
                                                            $newFromDate = date('Y-m-d', strtotime($fromDate));
                                                            $newToDate = date('Y-m-d', strtotime($toDate));
                                                            $xcrud->table('acr_emp_activity_detail');
                                                            $xcrud->columns("project_id,activity_id,remarks,activity_date,hour_worked");
                                                            $xcrud->where('staff_id =', $empid);
                                                            $xcrud->where('activity_date >=', $newFromDate);
                                                            $xcrud->where('activity_date <=', $newToDate);
                                                            $xcrud->relation('project_id', 'test_project_details', 'id', array("title"));
                                                            $xcrud->relation('activity_id', 'acr_activity_master_list', 'id', array("activity_name"));
                                                            $xcrud->relation('staff_rm_id', 'acr_rm_list', 'id', array("rm_name"));
                                                            $xcrud->label("project_id", "Project Name");
                                                            $xcrud->label("activity_id", "Activity Name");
                                                            $xcrud->label("remarks", "Remark");
                                                            $xcrud->label("activity_date", "Activity Date");
                                                            $xcrud->label("hour_worked", "Hour Worked");
                                                            $xcrud->label("staff_rm_id", "R.M. Name");
                                                            $xcrud->unset_title(TRUE);
                                                            $xcrud->unset_view(TRUE);
                                                            $xcrud->unset_print(FALSE);
                                                            $xcrud->unset_csv(FALSE);
                                                            $xcrud->unset_search(FALSE);
                                                            $xcrud->unset_remove(TRUE);
                                                            $xcrud->unset_add(TRUE);
                                                            $xcrud->unset_edit(TRUE);
                                                            echo $xcrud->render();
                                                            ?>
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div><!--end .col -->
                                            </div>
                                        </div><!--end .card-body -->
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
        ?>
        <script type="text/javascript">
                    var myURL = "<?php echo base_url(); ?>";
                    var myDate = "<?php echo date("d-m-Y"); ?>";
        </script>
        <script>var myURL = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>assets/myjs/activity.js"></script>
        <?php
        echo Xcrud::load_js();
        ?>
    </body>
</html>


