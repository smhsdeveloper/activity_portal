<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Project Activity Summary</title>
    <?php
    //echo $class;
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="projectsummary" ng-controller="projectsummarycontroller">
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
                                                                <div class="col-sm-2 margin-bottom-xxl">
                                                                    <span>Select Project</span>
                                                                </div>
                                                                <div class="col-sm-6 margin-bottom-xxl">
                                                                    <div class="form-group">
                                                                        <select id="select1" name="select1" class="form-control" ng-model="prjId" ng-init="prjId =0" ng-change="changeShowResult()">
                                                                            <option value="0">Select Project </option>
                                                                            <option value="{{x.id}}" ng-repeat="x in projectList">{{x.title}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 margin-bottom-xxl">
                                                                    <a class="btn btn-success" href="javascript:void(0);" ng-click="showSummary(prjId)" ng-disabled="prjId==0"><i class="glyphicon glyphicon-search"></i> Show Report</a>
                                                                    <a class="btn btn-info pull-right" title="Export Summary of all employee into CSV" href="javascript:void(0);" ng-click="exportSummary(prjId)" ng-show="projectSummary.dev.length"><i class="glyphicon glyphicon-file"></i> Export Report</a>
                                                                </div>
                                                            </div>
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div><!--end .col -->
                                            </div>
                                        </div><!--end .card-body -->
                                        <div class="card-body" ng-show="showResult">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-outlined style-primary">
                                                        <div class="card-body">
                                                            <div class="col-md-12">
                                                                <div class="table-responsive no-margin" ng-show="projectSummary.dev.length">
                                                                    <table class="table table-striped no-margin">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Modules</th>
                                                                                <th ng-repeat="x in projectSummary.dev">{{x.name}}</th>
                                                                                <th>Total</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr ng-repeat="x in projectSummary.mod">
                                                                                <th>{{x.title}}</th>
                                                                                <td ng-repeat="y in x.dev">{{y.time}}</td>
                                                                                <td>{{x.totalTime}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Total</th>
                                                                                <td ng-repeat="x in projectSummary.dev">{{x.total}}</td>
                                                                                <td>{{projectSummary.total}}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div role="alert" class="alert alert-callout alert-danger" ng-hide="projectSummary.dev.length">
                                                                    <strong>It seems like project has not been started yet.</strong>
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

        </script>
        <script src="<?php echo base_url(); ?>assets/myjs/activityreport.js"></script>

    </body>
</html>


