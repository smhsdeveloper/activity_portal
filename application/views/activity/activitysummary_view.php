<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Monthly Activity Summary</title>
    <?php
    //echo $class;
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="summary" ng-controller="summarycontroller">
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
                                                                <div class="col-sm-<?php echo $empid == 0 ? 3 : 4; ?>">
                                                                    <div class="form-group">
                                                                        <label for="Firstname5" class="col-sm-4 control-label">From</label>
                                                                        <div class="col-sm-8">
                                                                            <datepicker date-format="dd-MM-yyyy">
                                                                                <input type="text" class="form-control" id="Firstname5" ng-model="from" ng-init="from = '<?php echo $fromDate; ?>'">
                                                                            </datepicker>
                                                                            <div class="form-control-line"></div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-<?php echo $empid == 0 ? 3 : 4; ?> margin-bottom-xxl">
                                                                    <div class="form-group">
                                                                        <label for="Lastname5" class="col-sm-4 control-label">To</label>
                                                                        <div class="col-sm-8">
                                                                            <datepicker date-format="dd-MM-yyyy">
                                                                                <input type="text" class="form-control"  id="Lastname5" ng-model="to" ng-init="to = '<?php echo $toDate; ?>'">
                                                                            </datepicker>
                                                                            <div class="form-control-line"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-<?php echo $empid == 0 ? 3 : 4; ?> margin-bottom-xxl">
                                                                    <div class="form-group">
                                                                        <select id="select1" name="select1" class="form-control" ng-model="empid" ng-init="empid = <?php echo $empid ? $empid : 0; ?>" ng-change="getReport(from, to, empid)">
                                                                            <option value="-1">Select employee </option>
                                                                            <option value="0">All </option>
                                                                            <option value="{{emp.id}}" ng-selected="'<?php echo $empid; ?>' === emp.id" ng-repeat="emp in emplist">{{emp.name}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3 margin-bottom-xxl" ng-if="empid == 0">
                                                                    <a class="btn btn-success pull-right" title="Export Summary of all employee into CSV" href="javascript:void(0);" ng-click="exportSummary(from, to, false)"><i class="glyphicon glyphicon-file"></i> Export Summary</a>
                                                                </div>
                                                            </div>
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div><!--end .col -->
                                            </div>
                                        </div><!--end .card-body -->
                                        <div class="card-body" ng-show="summary.length && empid > 0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-outlined style-primary">
                                                        <div class="card-body">
                                                            <div class="col-md-4">
                                                                <div role="alert" class="alert alert-callout alert-success">
                                                                    <strong>Total Hour Worked :</strong> {{totalActivityHours}}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 pull-right">
                                                                <a class="btn btn-success" title="Export Summary of <?php echo $empname; ?> into CSV" href="javascript:void(0);" ng-click="exportSummary(from, to, empid)"><i class="glyphicon glyphicon-file"></i> Export into CSV</a>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="table-responsive no-margin">
                                                                    <table class="table no-margin">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Date</th>
                                                                                <th>Activity Punched</th>
                                                                                <!--<th>OTP Validated</th>-->
                                                                                <th>Hour worked ( % )</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="{{x.class}}" ng-repeat="x in summary">
                                                                                <td>{{$index + 1}}</td>
                                                                                <td>{{x.date}}</td>
                                                                                <td>{{x.punch}}</td>
                                                                                <!--<td>{{x.otp}}</td>-->
                                                                                <td>{{x.activity}}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
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
                    var empid = "<?php echo $empid; ?>";
                    var from = "<?php echo $fromDate; ?>";
                    var to = "<?php echo $toDate; ?>";
        </script>
        <script src="<?php echo base_url(); ?>assets/myjs/activityreport.js"></script>

    </body>
</html>


