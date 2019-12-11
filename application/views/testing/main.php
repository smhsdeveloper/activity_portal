<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>
        Dashboard 
    </title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <style>
        p#rmtimer {
            color: #2196f3;
            color: #ffffff;
            background-color: #505d5d;
            padding: 2px 27px;
            border-color: #e5e6e6;
        }
        p#emptimer {
            color: #2196f3;
            color: #ffffff;
            background-color: #505d5d;
            padding: 2px 27px;
            border-color: #e5e6e6;
        }
    </style>
    <body class="menubar-hoverable header-fixed">
        <?php $this->load->view('testing/include/header'); ?>
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
        <div id="base" ng-app="dashboard" ng-controller="dashboardController">
            <div class="modal fade bs-example-modal-sm" id="myPleaseWait" tabindex="-1"
                 role="dialog" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <span class="glyphicon glyphicon-time">
                                </span>Please Wait
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="progress">
                                <div class="progress-bar progress-bar-info
                                     progress-bar-striped active"
                                     style="width: 100%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="content">
                <section>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-body style-default-bright">
                                        <div class="form-horizontal" ng-if="otpvalidated.validated == 'NO'">
                                            <div class="form-group" >
                                                <!--                                                <label class="col-sm-2 control-label" for="regular13">Enter OTP</label>
                                                                                                <div class="col-sm-2">
                                                                                                    <input type="text" id="regular13" ng-model="otp" class="">
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <button type="text" id="regular13"  class="btn btn-success btn-sm" ng-click="validateOTP(otp);">Validate</button>
                                                                                                </div>-->
                                                <div class="col-sm-1">
                                                    <a href="<?php echo base_url(); ?>index.php/review/selfreview"  class="btn btn-sm btn-info">Self Review</a>
                                                </div>
                                                <div class="col-sm-3" >
                                                    <p ng-show="showEmpDiv" id="emptimer" class="text-center"></p>
                                                </div>
                                                <?php if ($usertype == 'RM' || $usertype == 'ADMIN') { ?>
                                                    <div class="col-sm-1">
                                                        <a href="#"  class="btn btn-sm btn-info">RM Review</a>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p ng-show="showRmDiv" id="rmtimer" class="text-center"></p>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-sm-2 pull-right">

                                                    <a href="../activity/empactivityentry" type="text" id="regular13"  class="btn btn-danger btn-sm">Punch Your Activity</a>
                                                </div>
                                            </div> 

                                        </div>
                                        <!--                                        <div ng-if="otpvalidated.validated == 'YES'">
                                                                                    <h4>OTP Already Validated</h4>
                                                                                    <div class="col-sm-2 pull-right">
                                                                                        <a href="../activity/empactivityentry" type="text" id="regular13"  class="btn btn-danger btn-sm">Punch Your Activity</a>
                                                                                    </div>
                                                                                </div> -->
                                    </div><!--end .card-body -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php if ($usertype == 'ADMIN') { ?>
                                <div class="col-md-6">

                                    <div class="card card-bordered style-primary">
                                        <div class="card-head">
                                            <header>RM BOX</header>
                                        </div>
                                        <div class="card-body style-default-bright">
                                            <div class="row" ng-show="rmactivity != ']'">
                                                <div class="form-group">
                                                    <div class="col-md-4">
                                                        <label style="font-weight: bold;"><span ng-hide="ishide"> Total Selected | {{myCount}}</span><span ng-show="ishide">Select to All</span></label> 
                                                    </div>
                                                    <div class="col-md-5">

                                                    </div>
                                                    <div class="col-md-3">
                                                        <button title="Send Reminder" ng-show="myCount > 1" class="btn btn-success" ng-click="sendmailall(rmactivity)"> <i style="cursor: pointer;" class="fa fa-paper-plane" aria-hidden="true"></i> Reminder</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">

                                            </div>
                                            <table class="table table-condensed table-bordered no-margin" ng-show="rmactivity != ']'">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div style="margin-bottom: 0px;" class="checkbox checkbox-styled tile-text">
                                                                <label>
                                                                    <input ng-change="checkall(rmactivity)" type="checkbox" checked="" ng-model="selectall">
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </th>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>RM Name</th>
                                                        <th><?php echo $Day1; ?></th>
                                                        <th><?php echo $Day2; ?></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr ng-repeat="x in rmactivity" >
                                                        <td>
                                                            <div ng-show="x.date1 == 'NA' || x.date0 == 'NA'" class="checkbox checkbox-styled tile-text">
                                                                <label>
                                                                    <input ng-change="selecsingle(rmactivity)" type="checkbox" checked="" ng-model="x.ischecked" ng-init="x.ischecked = false">
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{x.empname}}</td>
                                                        <td>{{x.rmname}}</td>
                                                        <td>{{x.date1}}</td>
                                                        <td>{{x.date0}}</td>
                                                        <td><button ng-disabled="x.ischecked == false || selectall == true" ng-click="sendsingle(x)" title="Send Reminder" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i></button></td>
    <!--                                                        <td>{{x.rmname}}</td>
                                                        <td>{{x.rmname}}</td>-->

                                                    </tr>
                                                </tbody>
                                            </table>
                                            <p ng-hide="rmactivity != ']'">No Data Found !</p>
                                        </div>

                                    </div>
                                    <div class="card card-bordered style-primary">
                                        <div class="card-head">
                                            <header>Admin BOX</header>

                                        </div>
                                        <div class="card-body style-default-bright">
                                            <div class="row" ng-show="alluser != ']'">
                                                <div class="form-group">
                                                    <div class="col-md-4">
                                                        <label style="font-weight: bold;"><span ng-hide="ishide1"> Total Selected | {{myCount1}}</span><span ng-show="ishide1">Select to All</span></label> 
                                                    </div>
                                                    <div class="col-md-5">

                                                    </div>
                                                    <div class="col-md-3">
                                                        <button title="Send Reminder" ng-show="myCount1 > 1" class="btn btn-success" ng-click="sendmailall(alluser)"> <i style="cursor: pointer;" class="fa fa-paper-plane" aria-hidden="true"></i> Reminder</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">

                                            </div>
                                            <table class="table table-condensed table-bordered no-margin">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div style="margin-bottom: 0px;" class="checkbox checkbox-styled tile-text">
                                                                <label>
                                                                    <input ng-change="checkalladmin(alluser)" type="checkbox" checked="" ng-model="selectall1">
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </th>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>RM Name</th>
                                                        <th><?php echo $Day1; ?></th>
                                                        <th><?php echo $Day2; ?></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr ng-repeat="x in alluser">
                                                        <td>
                                                            <div ng-show="x.date1 == 'NA' || x.date0 == 'NA'" class="checkbox checkbox-styled tile-text">
                                                                <label>
                                                                    <input ng-change="adminselect(alluser)" type="checkbox" checked="" ng-model="x.ischecked" ng-init="x.ischecked = false">
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{x.empname}}</td>
                                                        <td>{{x.rmname}}</td>
                                                        <td>{{x.date1}}</td>
                                                        <td>{{x.date0}}</td>
                                                        <td><button ng-disabled="x.ischecked == false || selectall1 == true || myCount1 > 1" ng-click="sendsingle(x)" title="Send Reminder" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i></button></td>
    <!--                                                        <td>{{x.rmname}}</td>
                                                        <td>{{x.rmname}}</td>-->

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-bordered">
                                        <div class="card-head  style-primary">
                                            <header>My Activity</header>

                                        </div>
                                        <div class="card-body  style-gray">
                                            <table class="table table-condensed table-bordered no-margin">
                                                <thead>
                                                    <tr>

                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Activity Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr ng-repeat="activitydetails in activity" style="background: {{activitydetails.cc}}">
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{activitydetails.date}}</td>
                                                        <td>{{activitydetails.status}}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">


                                </div>
                            <?php } if ($usertype == 'EMP') { ?>
                                <div class="col-md-12">
                                    <div class="card card-bordered  style-primary">
                                        <div class="card-head">
                                            <header>My Activity</header>

                                        </div>
                                        <div class="card-body style-gray">
                                            <table class="table table-condensed table-bordered no-margin">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Activity Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr ng-repeat="activitydetails in activity" style="background: {{activitydetails.cc}}">
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{activitydetails.date}}</td>
                                                        <td>{{activitydetails.status}}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            <?php } if ($usertype == 'RM') { ?>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-head">
                                            <header>RM BOX</header>

                                        </div>
                                        <div class="card-body height-12">
                                            <div class="row" ng-show="rmactivity != ']'">
                                                <div class="form-group">
                                                    <div class="col-md-4">
                                                        <label style="font-weight: bold;"><span ng-hide="ishide"> Total Selected | {{myCount}}</span><span ng-show="ishide">Select to All</span></label> 
                                                    </div>
                                                    <div class="col-md-5">

                                                    </div>
                                                    <div class="col-md-3">
                                                        <button title="Send Reminder" ng-show="myCount > 1" class="btn btn-success" ng-click="sendmailall(rmactivity)"> <i style="cursor: pointer;" class="fa fa-paper-plane" aria-hidden="true"></i> Reminder</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">

                                            </div>

                                            <table class="table table-condensed table-bordered no-margin">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div style="margin-bottom: 0px;" class="checkbox checkbox-styled tile-text">
                                                                <label>
                                                                    <input ng-change="checkall(rmactivity)" type="checkbox" checked="" ng-model="selectall">
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </th>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>RM Name</th>
                                                        <th><?php echo $Day1; ?></th>
                                                        <th><?php echo $Day2; ?></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr ng-repeat="x in rmactivity">
                                                        <td>
                                                            <div ng-show="x.date1 == 'NA' || x.date0 == 'NA'" class="checkbox checkbox-styled tile-text">
                                                                <label>
                                                                    <input ng-change="selecsingle(rmactivity)" type="checkbox" checked="" ng-model="x.ischecked" ng-init="x.ischecked = false">
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{x.empname}}</td>
                                                        <td>{{x.rmname}}</td>
                                                        <td>{{x.date1}}</td>
                                                        <td>{{x.date0}}</td>
                                                        <td><button ng-disabled="x.ischecked == false || selectall == true || myCount > 1" ng-click="sendsingle(x)" title="Send Reminder" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i></button></td>
                                                        <!--<td>{{x.rmname}}</td>-->
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-head style-primary">
                                            <header>My Activity</header>

                                        </div>
                                        <div class="card-body style-gray-dark">
                                            <table class="table table-condensed table-bordered no-margin">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Activity Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr ng-repeat="activitydetails in activity" style="background: {{activitydetails.cc}}">
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{activitydetails.date}}</td>
                                                        <td>{{activitydetails.status}}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            <?php } ?>

                        </div>



                    </div>
                </section>

            </div>

        </div>
        <?php
        $this->load->view('include/headjs');
//        echo Xcrud::load_js();
        ?>
        <script>
            var myURL = "<?php echo base_url(); ?>";
            var userid = "<?php echo $userid; ?>";
            var usertype = "<?php echo $usertype; ?>";
            var today = "<?php echo date('Y-m-d'); ?>";
        </script>
        <script src="<?php echo base_url(); ?>assets/myjs/dashboard.js"></script>
