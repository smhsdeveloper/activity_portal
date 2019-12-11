<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Monthly Summary</title>
    <?php
    //echo $class;
    $this->load->view('include/headcss');
    ?>

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style>
        .modal-backdrop fade in{
            height: auto;
        }
    </style>
    <body class="menubar-hoverable header-fixed" ng-app="dailysummary" ng-controller="dailysummarycontroller" ng-cloak>
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
                                        <header><i class="fa fa-fw fa-tag"></i>Monthly Summary</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="" ng-show="reports.length">
                                            <div class="row">
                                                <div class="">
                                                    <div class="">
                                                        <div class="">
                                                            <label class="form-control">Staff Name : {{staff_name}}</label>

                                                            <div class="table-responsive no-margin" id="printdiv">
                                                                <div class="panel-group" id="accordion1">
                                                                    <div class="card panel expanded" ng-repeat="obj in reports| orderBy : 'activity_date'">
                                                                        <div style="background-color: lightblue;" class="card-head" data-toggle="collapse" data-parent="#accordion1-1" data-target="#accordion1-{{$index}}" aria-expanded="true">
                                                                            <header style="font-size: 15px;">{{obj.activity_date| date : "fullDate"}}</header>
                                                                            <div class="tools">
                                                                                <strong>{{obj.hour_worked}} <i class="fa fa-clock-o" aria-hidden="true"></i></strong>
                                                                            </div>
                                                                        </div>
                                                                        <div id="accordion1-{{$index}}" class="collapse in" aria-expanded="true" style="background-color: whitesmoke;">
                                                                            <div class="card-body" ng-show="obj.remark.length > 0">
                                                                                <p ng-repeat="obj1 in obj.remark">{{$index + 1}}. {{obj1.remarks}} : {{obj1.hour_worked}} <i class="fa fa-clock-o" aria-hidden="true"></i></p>
                                                                            </div>
                                                                            <p ng-show="obj.remark.length == 0">No Data Found !</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                    var staff_id = "<?php echo $staff_id; ?>";
                    var project_id = "<?php echo $project_id; ?>";
                    var month_id = "<?php echo $month_id; ?>";
                    var year = "<?php echo $year; ?>";
        </script>
        <script src="<?php echo base_url(); ?>assets/js/table2excel.js"></script>
        <script src="<?php echo base_url(); ?>assets/myjs/activityreport.js?<?php echo rand(20, 100) ?>"></script>

    </body>
</html>


