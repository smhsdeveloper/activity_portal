<!DOCTYPE html>
<html lang="en">
    <title>DEO View</title>
    <?php
    if(!isset($this->session->userdata)){
    echo    "<script type='text/javascript'> window.location=myURL+ 'index.php' ;</script>";
    }
    ?>
    <?php
    $this->load->view('include/headcss');    
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="deo" ng-controller="deoController">
        <?php $this->load->view('include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg" ng-cloak>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head">
                                        <header><i class="fa fa-fw fa-tag"></i>DEO Login </header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="col-xs-12">
                                            <table class="table table-condensed no-margin">
                                                <thead>
                                                    <tr>
                                                        <th>Profile Pic</th>
                                                        <th>Name</th>
                                                        <th>Class Teacher</th>
                                                        <th>Subject List</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="staffDetail in staffData">
                                                        <td><img class="img-circle width-1" src="<?php echo base_url() . "index.php/staff/getstudphoto/" . "{{staffDetail.id}}/THUMB"; ?>" alt=""></td>
                                                        <td><a href="<?php echo base_url(); ?>index.php/staff/staffprofile/{{staffDetail.id}}">{{staffDetail.staff_fname + ' ' + staffDetail.staff_lname}}</a></td>
                                                        <td>{{staffDetail.classTeacher}} </td>
                                                        <td>{{staffDetail.subjectList}}</td>
                                                        <td> <button style="width: 60px;" type="button"  class="btn btn-block ink-reaction btn-primary" ng-click="loginAsTeacher(staffDetail.user_id)">Login</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div><!--end .col -->
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
            <script> var myURL = "<?php echo base_url(); ?>";</script>
            <script src="<?php echo base_url(); ?>/assets/myjs/deo.js"></script>
