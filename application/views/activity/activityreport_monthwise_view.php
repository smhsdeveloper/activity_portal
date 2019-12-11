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

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style>
        .modal-backdrop fade in{
            height: auto;
        }
    </style>
    <body class="menubar-hoverable header-fixed" ng-app="monthreport" ng-controller="monthreportcontroller">
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base">
            <div id="content">

<!--                <div class="modal fade "style="height:100%;" id="simpleModal"  role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true"> 
                    <div class="modal-dialog modal-lg" > 
                        <div class="modal-content"> 
                            <div class="modal-header"> 
                                <button type="button" class="close" ng-click="reset()" data-dismiss="modal" aria-hidden="true">&times;</button> 
                                <h4 class="modal-title" id="simpleModalLabel">Activity Details </h4> 
                            </div> 
                            <div class="modal-body">
                                <div class="panel-group" id="accordion1">
                                    <div class="card panel expanded" ng-repeat="obj in data| orderBy : 'activity_date'">
                                        <div class="card-head" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-1" aria-expanded="true">
                                            <header>{{obj.activity_date| date : "fullDate"}}</header>
                                            <div class="tools">
                                                <strong>{{obj.hour_worked}}</strong>
                                            </div>
                                        </div>
                                        <div id="accordion1-1" class="collapse in" aria-expanded="true" style="">
                                            <div class="card-body">
                                                <p ng-repeat="obj1 in obj.remark">{{$index + 1}}. {{obj1.remarks}} : {{obj1.hour_worked}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-responsive" ng-show="data.length > 0">
                            <thead style="background-color: green;font-weight: bold; color: white;">
                                <tr>
                                    
                                    <td>S.no</td>
                                    <td>Date</td>
                                    <td>Activity Type</td>
                                    <td>Activity Remarks</td>
                                    <td>Working Hour's</td>
                                </tr>
                            </thead>
                            <tr style="background-color: whitesmoke;" ng-repeat="obj in data">
                                <td>{{$index+1}}</td>
                                <td>{{obj.activity_date | date : "fullDate"}}</td>
                                <td>{{obj.activity_name}} <i title="{{obj.remarks}}" style="cursor: pointer;" class="fa fa-info-circle" aria-hidden="true"></i></td>
                                <td>{{obj.remarks}}</td>
                                <td>{{obj.hour_worked}}</td>
                            </tr>
                        </table>
                                <p ng-show="data.length == 0">No Data Found !</p>
                            </div>
                        </div> 
                    </div> /.modal-content  
                </div> /.modal-dialog  -->

                <section>
                    <div class="section-body contain-lg " ng-cloak>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Month Wise Reports</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-outlined style-primary">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label for="Firstname5" class="col-sm-4 control-label">From</label>
                                                                        <div class="col-sm-8">
                                                                            <datepicker date-format="dd-MM-yyyy" date-min-limit="<?php echo date('d-M-Y', strtotime('01-04-2018')); ?>">
                                                                                <input type="text" class="form-control" ng-change="changes(month.fromdate, month.todate)" id="Firstname5" ng-model="month.fromdate" ng-init="month.fromdate = '<?php echo date('d-m-Y'); ?>'" readonly>
                                                                            </datepicker>
                                                                            <div class="form-control-line"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label for="Firstname5" class="col-sm-4 control-label">To</label>
                                                                        <div class="col-sm-8">
                                                                            <datepicker date-format="dd-MM-yyyy" date-min-limit="<?php echo date('d-M-Y', strtotime('01-04-2018')); ?>">
                                                                                <input type="text" ng-change="changes(month.fromdate, month.todate)" class="form-control" id="Firstname5" ng-model="month.todate" ng-init="month.todate = '<?php echo date("d-m-Y", strtotime(' +1 day')); ?>'" readonly>
                                                                            </datepicker>
                                                                            <div class="form-control-line"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-4 margin-bottom-xxl">
                                                                    <div class="form-group">
                                                                        <select id="select1" name="select1" class="form-control" ng-model="month.project_id" ng-init="month.project_id = ''">
                                                                            <option value="">Select Project</option>
                                                                            <option value="{{obj.id}}" ng-repeat="obj in projectList">{{obj.title}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-success pull-right" ng-click="getreports()" ng-disabled="month.from_month == '' || month.to_month == '' || month.project_id == '' || month.from_year == '' || month.to_year == ''">GO</button>
                                                                </div>
                                                            </div>
                                                        </div><!--end .card-body -->
                                                    </div><!--end .card -->
                                                </div><!--end .col -->
                                            </div>
                                        </div><!--end .card-body -->
                                        <div class="card-body" ng-show="reports.length">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-outlined style-primary">
                                                        <div class="card-head card-head-xs style-default-light">
                                                            <div class="col-md-12">
                                                                <div class="pull-right">
                                                                    <button class="btn btn-primary-dark" title="export" ng-click="generateExcel('printdiv', 'Asset Assignment Details')"><i class="fa fa-download"> Export into CSV </i></button>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <input type="number" ng-model="month.rating" ng-change="getreport()" ng-init="month.rating = ''" placeholder="Men hour rate" class="form-control" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive no-margin" id="printdiv">
                                                                <table class="table no-margin">
                                                                    <thead style="background-color: whitesmoke;font-weight: bold;">
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Name of Employee</th>
                                                                            <th ng-repeat="obj in monthlist">{{obj.name}}-{{obj.year}}</th>
                                                                            <th>Total Hours</th>
                                                                            <th>Rating</th>
                                                                            <th>Total</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr ng-repeat="obj in reports" ng-show="reports.length > 0" ng-if="obj.name" ng-hide="obj.total_sum =='0:0'">
                                                                            <td>{{$index + 1}}</td>
                                                                            <td>{{obj.name}}</td>
                                                                            <td ng-repeat="h in obj.hourArr"><a ng-hide="h.hour_worked=='00:00:00'" href="<?php echo base_url() . "index.php/activity/monthlysummary/{{obj.id}}/{{month.project_id}}/{{h.m_id}}/{{h.year}}"  ?>" target="_blank">{{h.hour_worked}}</a><a style="cursor: pointer;" ng-show="h.hour_worked=='00:00:00'">{{h.hour_worked}}</a></td>
                                                                            <td>{{obj.total_sum}}</td>
                                                                            <td><span ng-show="obj.rating != ''">{{obj.rating}}</span><span ng-show="obj.rating == ''">0</span></td>
                                                                            <td>{{obj.multiply_val}}</td>
                                                                        </tr>
                                                                        <tr style="font-weight: bold;">
                                                                            <td></td>
                                                                            <td>Total</td>
                                                                            <td ng-repeat="obj in monthlist">{{obj.totalsum}}</td>
                                                                            <td>{{grand_sum}}</td>
                                                                            <th></th>
                                                                            <th>{{rating_sum}}</th>
                                                                        </tr>

                                                                    </tbody>
                                                                    <p ng-show="reports.length == 0">No Data Found !</p>
                                                                </table>
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
            $('.highcharts-axis-title').val = 'dd';
        </script>
        <script src="<?php echo base_url(); ?>assets/js/table2excel.js"></script>
        <script src="<?php echo base_url(); ?>assets/myjs/activityreport.js?<?php echo rand(20, 100) ?>"></script>

    </body>
</html>


