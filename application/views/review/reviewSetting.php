<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>

<style>
    thead tr th, tbody tr td,tbody tr th {
        text-align: center;
    }

    [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-    ng-cloak {
        display: none !important;
    }
    .pre-line{

        white-space: pre-line;
    }

</style>
<style>
    .date-p-pos{margin-top: 35px !important;}
    .date-p-btn-pos{position: absolute;top: 0;right: 11px;}
    .date-p-label{margin-top: 30px;}

</style>

<?php
$isAdmin = 0;
if ($this->session->userdata('admin_type') == 'ADMIN') { //RM
    $isAdmin = 1;
}
?>
<script>
    var isAdmin = '<?php
if ($isAdmin) { //Admin
    echo true;
} else {
    echo false;
}
?>';</script>
<html lang="en">
    <title>Review Setting Details </title>
    <?php
    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');
    ?>    
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <script type="text/javascript">


    </script>
    <body class="menubar-hoverable header-fixed " ng-app="reviewSettings" ng-controller="reviewSettingController" ng-cloak>
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>

                                        <header><i class="fa fa-fw fa-tag"></i>Review Setting Details</header>
                                    </div><!--end .card-head -->

                                    <div class="card-body style-default-bright">
                                        
                                        <div class="row" ng-show="showTable">
                                            <div class="col-md-2"> </div>
                                            <label class="col-sm-1 control-label" for="select13">Select FY</label>
                                            <div class="col-md-4">
                                                <?php if ($isAdmin) { ?>
                                                    <div class="form-group">
                                                        <select id="select1" name="select1" class="form-control" ng-model="fy" ng-options="key1 as value1 for (key1 , value1) in fylist" ng-change="pageReload()">
                                                            <option value="">Select Financial Year </option>
                                                        </select>
                                                    </div>
                                                <?php } ?>
                                            </div> 
                                        </div>
                                        
                                        <div class="row" ng-show="showAddNew">
                                            <div class="col-md-10"></div>
                                            <div class="col-md-2" ng-show="showTable">
                                                <button ng-click="addReviewSettings()" class="btn btn-success btn-md pull-right" id="regular13" type="text"> Add New</button>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="table-responsive" ng-show="showTable && reviewSettings.length > 0">
                                            <table class="table table-bordered no-margin">

                                                <tbody>
                                                    <tr >
                                                        <th>S No</th>
                                                        <th>Month </th>
                                                        <th colspan="2">Employee</th>
                                                        <th colspan="2">RM</th>
                                                        <th colspan="2">Admin</th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                    <tr >
                                                        <th colspan="2"></th>
                                                        <th>Start Date Time</th>
                                                        <th>End Date Time</th>
                                                        <th>Start Date Time</th>
                                                        <th>End Date Time</th>
                                                        <th>Start Date Time</th>
                                                        <th>End Date Time</th>
                                                        <th colspan="2">Action</th>
                                                    </tr>
                                                    <tr ng-repeat="reviewObj in reviewSettings">
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{reviewObj.month| monthName}}</td>
                                                        <td>{{reviewObj.start_datetime.EMP}}</td>
                                                        <td>{{reviewObj.end_datetime.EMP}}  </td>
                                                        <td>{{reviewObj.start_datetime.RM}}</td>
                                                        <td>{{reviewObj.end_datetime.RM}}  </td>
                                                        <td>{{reviewObj.start_datetime.ADM}}</td>
                                                        <td>{{reviewObj.end_datetime.ADM}}  </td>
                                                        <td>
                                                            <button type="button" class="btn ink-reaction btn-raised btn-success" ng-click="editReviewSettings(reviewObj)">Edit</button>
                                                        </td>
                                                        <td>
                                                             <button type="button" class="btn ink-reaction btn-raised btn-danger" ng-click="deleteReviewSettings(reviewObj.month,reviewObj.financial_year)">Delete</button>
                                                        </td>
                                                    </tr>                                                  

                                                </tbody>
                                            </table>
                                        </div>
                                        <!--Review Settings Entry Form-->
                                        <form class="form-horizontal" ng-show="showForm" name="review_settings">
                                            <div class="form-group">
                                                <label for="regular13" class="col-sm-2 control-label">Select FY {{data.fy}}</label>
                                                <div class="col-sm-3">
                                                    <select id="select1" name="fy" class="form-control" ng-model="data.fy" ng-options="key1 as value1 for (key1 , value1) in fylist" required="required">
                                                        <option value="">Select Financial Year</option>
                                                    </select>
                                                    <div class="form-control-line"></div>
                                                </div>
                                                <label for="regular13" class="col-sm-2 control-label">Select Month</label>
                                                <div class="col-sm-3">
                                                     <!--ng-options="key as value for (key , value) in monthlist"-->
                                                    <select name="select1" class="form-control" ng-model="data.month"  required="required">
                                                        <option value="">Select Month</option>
                                                        <option ng-repeat="item in nthlist)" value="{{item}}">{{monthlist[item]}}</option>
                                                    </select>keys(mo
                                                    <div class="form-control-line"></div>
                                                </div>
                                                
                                              
                                            </div>  
                                            <br/>

                                            <div class="form-group">
                                                <label for="regular13" class="col-sm-2 control-label date-p-label">Employee Start Date & Time</label>
                                                <div class="col-sm-4 date-p-pos">
                                                    <input class="form-control" name="" is-open="dt1opened" uib-datepicker-popup="{{dateformat}}" ng-model="data.em_start_date"  class="form-control" placeholder="" type="text">
                                                    <button type="button" class="btn btn-default date-p-btn-pos" ng-click="(dt1opened)?dt1opened = false:dt1opened = true;"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div class="col-sm-3">
                                                    <div uib-timepicker ng-model="data.em_start_time" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></div>         
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="form-group">
                                                <label for="regular13" class="col-sm-2 control-label date-p-label">Employee End Date & Time</label>
                                                <div class="col-sm-4 date-p-pos">
                                                    <input class="form-control" name="" is-open="dt2opened" uib-datepicker-popup="{{dateformat}}" ng-model="data.em_end_date"  class="form-control" placeholder="" type="text">
                                                    <button type="button" class="btn btn-default date-p-btn-pos" ng-click="(dt2opened)?dt2opened = false:dt2opened = true;"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div class="col-sm-3">
                                                    <div uib-timepicker ng-model="data.em_end_time" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></div>         
                                                </div>
                                            </div>
                                            <br/>
                                            
                                            <div class="form-group">
                                                <label for="regular13" class="col-sm-2 control-label date-p-label">RM Start Date & Time</label>
                                                <div class="col-sm-4 date-p-pos">
                                                    <input class="form-control" name="" is-open="dt3opened" uib-datepicker-popup="{{dateformat}}" ng-model="data.rm_start_date"  class="form-control" placeholder="" type="text">
                                                    <button type="button" class="btn btn-default date-p-btn-pos" ng-click="(dt3opened)?dt3opened = false:dt3opened = true;"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div class="col-sm-3">
                                                    <div uib-timepicker ng-model="data.rm_start_time" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></div>         
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="form-group">
                                                <label for="regular13" class="col-sm-2 control-label date-p-label">RM End Date & Time</label>
                                                <div class="col-sm-4 date-p-pos">
                                                    <input class="form-control" name="" is-open="dt4opened" uib-datepicker-popup="{{dateformat}}" ng-model="data.rm_end_date"  class="form-control" placeholder="" type="text">
                                                    <button type="button" class="btn btn-default date-p-btn-pos" ng-click="(dt4opened)?dt4opened = false:dt4opened = true;"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div class="col-sm-3">
                                                    <div uib-timepicker ng-model="data.rm_end_time" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></div>         
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="form-group">
                                                <label for="regular13" class="col-sm-2 control-label date-p-label">Admin Start Date & Time</label>
                                                <div class="col-sm-4 date-p-pos">
                                                    <input class="form-control" name="" is-open="dt5opened" uib-datepicker-popup="{{dateformat}}" ng-model="data.admin_start_date"  class="form-control" placeholder="" type="text">
                                                    <button type="button" class="btn btn-default date-p-btn-pos" ng-click="(dt5opened)?dt5opened = false:dt5opened = true;"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div class="col-sm-3">
                                                    <div uib-timepicker ng-model="data.admin_start_time" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></div>         
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="form-group">
                                                <label for="regular13" class="col-sm-2 control-label date-p-label">Admin End Date & Time</label>
                                                <div class="col-sm-4 date-p-pos">
                                                    <input class="form-control" name="" is-open="dt6opened" uib-datepicker-popup="{{dateformat}}" ng-model="data.admin_end_date"  class="form-control" placeholder="" type="text">
                                                    <button type="button" class="btn btn-default date-p-btn-pos" ng-click="(dt6opened)?dt6opened = false:dt6opened = true;"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div class="col-sm-3">
                                                    <div uib-timepicker ng-model="data.admin_end_time" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></div>         
                                                </div>
                                            </div>
                                            <br/>
                                            
                                            <div class="card-actionbar">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-3">
                                                    <button type="button" class="btn ink-reaction btn-raised btn-primary" ng-disabled="review_settings.$invalid"  ng-click="saveReviewSettings(data)">Save Settings</button>
                                                    <button type="button" class="btn ink-reaction btn-raised btn-default" ng-click="cancelReviewSettings()">Cancel</button>
                                                </div>
                                            </div>
                                        </form>



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
            ?>
            <script src="<?php echo base_url('assets/js/ui-bootstrap-tpls.js'); ?>"></script>
            <script>
                                                        var myURL = "<?php echo base_url(); ?>";
            </script>
            <script src="<?php echo base_url('assets/myjs/reviewsettings.js') ?>"></script>


