<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Monthly Chart</title>
    <?php
    //echo $class;
    $this->load->view('include/headcss');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style>
        #container {
            margin: 0 auto;
        }
        .highcharts-credits{
            display: none;
        }
    </style>
    <body class="menubar-hoverable header-fixed" ng-app="topproject" ng-controller="topprojectcontroller">
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
                                        <header><i class="fa fa-fw fa-tag"></i>Month Wise Chart</header>
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
                                                                            <datepicker date-format="dd-MM-yyyy" date-min-limit="<?php echo date('d-M-Y', strtotime('01-04-2018')); ?>">
                                                                                <input type="text" class="form-control" id="Firstname5" ng-model="month.fromdate" ng-init="month.fromdate = '<?php echo date('d-m-Y'); ?>'" readonly>
                                                                            </datepicker>
                                                                            <div class="form-control-line"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label for="Firstname5" class="col-sm-4 control-label">To</label>
                                                                        <div class="col-sm-8">
                                                                            <datepicker date-format="dd-MM-yyyy" date-min-limit="<?php echo date('d-M-Y', strtotime('01-04-2018')); ?>">
                                                                                <input type="text" class="form-control" id="Firstname5" ng-model="month.todate" ng-init="month.todate = '<?php echo date("d-m-Y", strtotime(' +1 day')); ?>'" readonly>
                                                                            </datepicker>
                                                                            <div class="form-control-line"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <button class="btn btn-success pull-right" ng-click="getreports()" ng-disabled="month.from_month == '' || month.to_month == '' || month.from_year == '' || month.to_year == ''">GO</button>
                                                                </div>
                                                            </div>
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div><!--end .col -->
                                            </div>
                                        </div><!--end .card-body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12" ng-show="data.length > 0">
                                                    <div class="card card-outlined style-primary">
                                                        <div class="card-body">
                                                            <div class="col-md-12">
                                                                <div id="container"></div>
                                                                <button id="plain" class="btn btn-primary">Plain</button>
                                                                <button id="inverted" class="btn btn-success">Inverted</button>
                                                                <button id="polar" class="btn btn-danger">Polar</button>
                                                            </div>
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div><!--end .col -->
                                                <p ng-show="data.length == 0">No Data Found !</p>
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
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/highcharts-more.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script type="text/javascript">
                                                            var myURL = "<?php echo base_url(); ?>";
        </script>
        <script src="<?php echo base_url(); ?>assets/myjs/activityreport.js"></script>

    </body>
</html>


