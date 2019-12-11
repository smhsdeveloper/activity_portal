<!DOCTYPE html>
<html lang="en">
    <title>Student Login/Kit Generator</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body  class="menubar-hoverable header-fixed ng-cloak" ng-app="StudLoginApp" ng-controller="StudLoginAppController" >
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head" style="height: 15px;">

                                        <header ><i class="fa fa-fw fa-tag" ></i>Student Login/Kit Generate </header>


                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="card">

                                            <div class="card-body">


                                                <button  style=" float: right" ng-show="mystudents" class="btn ink-reaction btn-primary" type="button" ng-click="SendSmsToStudent()">Send Sms(Login-Id&nbsp;,&nbsp;Password)</button>
                                                <div class="form-group" >
                                                    <label class="text-bold" >Select Class</label>
                                                    <select   ng-model="studlist" ng-change="SectionStud()" id="dd_section_type" >
                                                        <option value="0">Select Class</option>
                                                        <option  ng-repeat="secObj in mysections" value="{{secObj.id}}">{{secObj.standard + secObj.section}}</option>
                                                    </select>

                                                </div>
                                                <table class="table table-condensed no-margin">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Photo</th>
                                                            <th>Adm No</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Login Status</th>
                                                            <th>Kit Generated</th>
                                                            <th>Active</th>
                                                            <th>Reset</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="studObj in mystudents">
                                                            <td>
                                                                <input ng-model="studObj.smsSend" ng-checked="studObj.selected == 'YES'" type="checkbox">
                                                            </td>

                                                            <td ><img class="img-circle width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{studObj.adm_no}}/THUMB"; ?>" alt=""></td>
                                                            <td title="{{'username: '+studObj.username +', password: '+ studObj.password}}">{{studObj.adm_no}}</td>
                                                            <td title="{{'username: '+studObj.username +', password: '+ studObj.password}}">{{studObj.name}}</td>
                                                            <td>{{studObj.mobile==''?'NA':studObj.mobile}}</td>
                                                            <td>{{studObj.count_login>0?studObj.count_login+' '+'Times':"Not Yet"}}</td>
                                                            <td>{{studObj.register_date}}</td>
                                                            <td><button  class="btn ink-reaction btn-raised btn-xs" ng-click="LoginActivatedStatus(studObj)" ng-class="studObj.login_activated=='NO'?'btn-success':'btn - danger'" type="button">{{studObj.login_activated=='NO'?"Activate Login":"Deactive Login"}}</button>
                                                                <p class="text-danger" ng-show="studObj.adm_no == Obj.adm_no">{{ConfirmMessage}}</p>
                                                            </td>
                                                            <td><button class="btn ink-reaction btn-raised btn-xs btn-primary" ng-click="ResetPassword(studObj)" type="button">{{studObj.password_reset=='NO'?"Reset Password":"Reset Password Again"}}</button>
                                                                <p ng-show="studObj.adm_no == ObjPwd.adm_no" class="text-danger">{{studObj.password_reset=='NO'?"":"Password reset successfully"}}</p>
                                                            </td>
                                                        </tr>



                                                    </tbody>
                                                </table>

                                            </div><!--end .card-body -->

                                        </div>

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
            <?php $this->load->view('include/menu'); ?>
        </div>
    </div>
    <?php
    $this->load->view('include/headjs');
    ?>


    <script>
        var myURL = "<?php echo base_url(); ?>";
    </script>
    <script src="<?php echo base_url(); ?>/assets/myjs/studentkitgen.js"></script>