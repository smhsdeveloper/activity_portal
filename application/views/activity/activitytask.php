<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Activity Entry </title>
    <?php
    //echo $class;

    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base" ng-app="activitytask" ng-controller="activitytaskcontroller" ng-cloak>
            <div id="content">
                
                
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Activity  Entry</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-horizontal">
                                                    <form name="workdetail" nonvalidate>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label" for="select13">Select Project</label>
                                                            <div class="col-sm-5">

                                                                <select class="form-control" name="select13" id="select13" ng-model="projectname" ng-init="projectname = 'NA'" ng-change="selectproject()" required>
                                                                    <option value="NA">Select Project</option>
                                                                    <option ng-repeat="projectname in project" value="{{projectname.id}}">{{projectname.title}}</option>

                                                                </select>
                                                                 <!---<input type="text" id="regular13" class="form-control">--->

                                                                <div class="form-control-line"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" ng-show="type == 'true'">
                                                            <label class="col-sm-2 control-label" for="select13">Select Module</label>
                                                            <div class="col-sm-5" ng-show="othermoduleentry == 'false'">
                                                                <select  class="form-control" name="select13" id="select13" ng-model="modulename" ng-init="modulename = 'NA'" ng-change="selectmodule()">
                                                                    <option value="NA">Select Module</option>
                                                                    <option ng-repeat="modulename in module" value="{{modulename.id}}">{{modulename.title}}</option>
                                                                    <option value="OTHER">Other</option>

                                                                </select><div class="form-control-line"></div>
                                                            </div>
                                                            <div class="col-sm-5" ng-show="moduletxtbx == 'TRUE'">
                                                                <input  type="text" id="regular13" class="form-control" ng-model="moduletext" >   
                                                            </div>
                                                            <div class="col-sm-1" ng-show="moduletxtbx == 'TRUE'">
                                                                <button type="button" class="btn btn-block ink-reaction btn-success" ng-click="SaveModule()">Save</button>
                                                            </div>
                                                            <div class="col-sm-1" ng-show="moduletxtbx == 'TRUE'">
                                                                <button type="button" class="btn btn-block ink-reaction btn-danger" ng-click="cancelmodltxtbxbtn()">Cancel</button>
                                                            </div>
                                                            <!--<div class="col-sm-2" ng-if="othermoduleentry == 'true'">
                                                                <input class="btn ink-reaction btn-raised btn-default btn-sm" type="button" ng-click="othermodule()" value="Saves">
                                                                <button class="btn ink-reaction btn-raised btn-default btn-sm" type="button" ng-click="cancelmodule()">cancel</button>
                                                            </div>--->
                                                            <div class="col-sm-2" ng-if="othermoduleentry != 'true'">
                                                                <input class="btn ink-reaction btn-raised btn-default btn-sm" type="button" ng-click="othermodule()" value="Others">
                                                                <button class="btn ink-reaction btn-raised btn-default btn-sm" type="button" ng-click="cancelmodule()">cancel</button>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" ng-show="activity == 'true'">
                                                            <label class="col-sm-2 control-label" for="select13">Activity Name</label>
                                                            <div class="col-sm-5" ng-show="otheractivityentry == 'false'">
                                                                <select  class="form-control" name="select13" id="select13" ng-model="activityname" ng-init="activityname = 'NA'" ng-change="selectactivity()">
                                                                    <option value="NA">Select Activity</option>
                                                                    <option ng-repeat="activityname in activitylist" value="{{activityname.id}}">{{activityname.activity_name}}</option>

                                                                </select>

                                                            </div>
                                                            <div class="col-sm-5" ng-show="activitytxtbx == 'TRUE'">
                                                                <input  type="text" id="regular13" class="form-control" ng-model="activitytext">   
                                                            </div>
                                                            <div class="col-sm-1" ng-show="activitytxtbx == 'TRUE'" >
                                                                <button type="button" class="btn btn-block ink-reaction btn-success" ng-click="SaveActivity()">Save</button>
                                                            </div>
                                                            <div class="col-sm-1" ng-show="activitytxtbx == 'TRUE'">
                                                                <button type="button" class="btn btn-block ink-reaction btn-danger" ng-click="cancelactivtytxtbxbtn()">Cancel</button>
                                                            </div>
                                                            <div class="col-sm-2" ng-show="othractivitybtn == 'FALSE'">
                                                                <button class="btn ink-reaction btn-raised btn-default btn-sm" type="button" ng-click="otheractivity()">other</button>
                                                                <button class="btn ink-reaction btn-raised btn-default btn-sm" type="button" ng-click="cancelactivity()">cancel</button>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" ng-show="workentry == 'true'">
                                                            <label class="col-sm-2 control-label" for="regular13">Work Details</label>
                                                            <div class="col-sm-5">
                                                                <textarea placeholder="" rows="3" class="form-control" id="textarea13" ng-model="textareavalue" name="textarea13" required></textarea>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>


                                            <div class="col-sm-12" ng-show="workentry == 'true'">
                                                <div class="form-group">
                                                    <div class="col-sm-7 pull-right">
                                                        <button class="btn ink-reaction btn-raised btn-success" type="button" ng-disabled="!workdetail.$valid" ng-click="startwork()">Start Work</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>



                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->

                        </div>
                        <div class="row" >
                            <div class="col-md-12" ng-show="startwrk.length > 0">
                                <div class="card card-bordered style-primary">
                                    <div class="card-body style-default-bright">
                                    <table class="table table-bordered no-margin" >
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Project</th>
                                                    <th>Work Details</th>
                                                    <th>Timer</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="xx in startwrk">
                                                    <td>{{$index + 1}}</td>
                                                    <td>{{xx.title}}</td>
                                                    <td>{{xx.remarks}}</td>
                                                    <td>{{xx.timer | secondsToTime}}</td>
                                                    <td>
                                                        <button ng-if="xx.activity_status === 'PAUSED'" class="btn btn-success btn-xs" type="button" ng-click="startworktimer(xx.id)">Start Work</button>
                                                        <button ng-if="xx.activity_status === 'START'" class="btn btn-danger btn-xs" type="button" ng-click="pauseworktimer(xx.id)">Pause Work</button></td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
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

    
    <!-- Timer -->
    <script src="<?php echo base_url() ?>assets/examjs/angular-timer-all.min.js"></script>
    <script type="text/javascript">
                                                            var myURL = "<?php echo base_url(); ?>";
                                                            var myDate = "<?php echo date('d-m-Y'); ?>";
                                                            var empid = "<?php echo $this->session->userdata('company_staff_id'); ?>";
                                                           
    </script>
    <script src="<?php echo base_url(); ?>assets/myjs/activitytask.js"></script>


