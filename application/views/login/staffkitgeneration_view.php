<!DOCTYPE html>
<html lang="en">
    <title>Staff Login/Kit Generator</title>
    <?php
    $staff_id = $this->session->userdata('staff_id');
    $this->load->view('include/headcss');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body  class="menubar-hoverable header-fixed ng-cloak" ng-app="StaffLoginApp" ng-controller="StaffLoginAppController" >
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head" style="height: 15px;">
                                        <header ><i class="fa fa-fw fa-tag" ></i>Staff Login/Kit Generate </header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="card">

                                            <div class="card-body">


                                                <button  style=" float: right" class="btn ink-reaction btn-primary" type="button" ng-click="SendSmsToStudent()">Send Sms(Login-Id&nbsp;,&nbsp;Password)</button>

                                                <table class="table table-condensed no-margin">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Photo</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Login Status</th>
                                                            <th>Kit Generated</th>
                                                            <th>Active</th>
                                                            <th>Reset</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="staffObj in mainstaff">
                                                            <td>
                                                                <input ng-model="staffObj.smsSend" ng-checked="staffObj.selected == 'YES'" type="checkbox">
                                                            </td>

                                                            <td><img class="img-circle width-1" src="<?php echo base_url() . "index.php/staff/getphoto/" . "{{staffObj.id}}/THUMB"; ?>" alt=""></td>
                                                            <td title="{{'username: '+staffObj.username +', password: '+ staffObj.password}}">{{staffObj.name}}</td>
                                                            <td>{{staffObj.mobile==""?'NA':staffObj.mobile}}</td>
                                                            <td>{{staffObj.count_login>0?staffObj.count_login+' '+'Times':"Not Yet"}}</td>
                                                            <td>{{staffObj.register_date}}</td>
                                                            <td><button  class="btn ink-reaction btn-raised btn-xs" ng-click="LoginActivatedStatus(staffObj)" ng-class="staffObj.login_activated=='NO'?'btn-success':'btn - danger'" type="button">{{staffObj.login_activated=='NO'?"Activate Login":"Deactive Login"}}</button>
                                                                <p class="text-danger" ng-show="staffObj.id == Obj.id">{{ConfirmMessage}}</p>
                                                            </td>
                                                            <td><button class="btn ink-reaction btn-raised btn-xs btn-primary" ng-click="ResetPassword(staffObj)" type="button">{{staffObj.password_reset=='NO'?"Reset Password":"Reset Password Again"}}</button>
                                                                <p ng-show="staffObj.staff_id == ObjPwd.staff_id" class="text-danger">{{staffObj.password_reset=='NO'?"":"Password reset successfully"}}</p>
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
    <script src="<?php echo base_url(); ?>/assets/myjs/staffkitgen.js"></script>