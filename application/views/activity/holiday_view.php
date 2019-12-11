<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Manage Holiday</title>
    <?php
    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');
    $this->load->library("loadxcrud");
    echo Xcrud::load_css();
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="holiday" ng-controller="holidayController">
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base" >
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-body style-default-bright">
                                        <div class="col-md-4">
                                            <div class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label" for="select13">Select Year</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control" ng-model="yearval" ng-init="yearval = 'NA'" ng-change="selectYear()">
                                                            <option value="NA">Please Select Year</option>
                                                            <option ng-repeat="y in year"value="{{y.value}}"ng-selected="'<?php echo $year; ?>' === y.value">{{y.key}}</option>
                                                        </select><div class="form-control-line"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!--                                        <div class="col-md-4">
                                                                                    <div class="form-horizontal">
                                                                                        <div class="form-group">
                                                                                            <label class="col-sm-3 control-label" for="select13">Select Month</label>
                                                                                            <div class="col-sm-7">
                                                                                                <select class="form-control" ng-model="monthval" ng-init="monthval = 'NA'" ng-change="selectMonth()">
                                                                                                    <option value="NA">Please Select Month</option>
                                                                                                    <option ng-repeat="m in month" value="{{m.value}}" ng-selected="'<?php echo $month; ?>' === m.value">{{m.key}}</option>
                                                                                                </select><div class="form-control-line"></div>
                                                                                            </div>
                                                                                        </div>
                                        
                                                                                    </div>
                                                                                </div>-->

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
                                        <header><i class="fa fa-fw fa-tag"></i>Holiday List</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <?php
                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->connection($db['default']['username'], $db['default']['password'], $db['default']['database'], $db['default']['hostname']);
                                        $xcrud->table('holiday_list');
                                        $xcrud->columns("holiday_name,date");
                                        $xcrud->fields("holiday_name,date");
                                        $xcrud->where("year", $year);
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->limit(25);
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(FALSE);
                                        echo $xcrud->render();
                                        ?>
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
        var years = '<?php echo $year; ?>';
    </script>
    <script src="<?php echo base_url(); ?>/assets/myjs/common.js"></script>
    <script src="<?php echo base_url(); ?>/assets/myjs/holiday.js"></script>
