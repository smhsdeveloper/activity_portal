<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Send Review's</title>
    <?php
    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style>
        .head_sytle{
            background-color: black;
            color: white;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
        }
        .tr_style{
            background-color: #fef7f76b;
        }
        .body_style{
            background-color: whitesmoke;
            padding: 13px;
            /*border-radius: 5px;*/
            box-shadow: 5px 5px #d6dce1;
        }
        .header_style{
            background-color: #000;
            /* padding: 30px; */
            text-align: left;
            /* font-size: 35px; */
            color: white;
            box-shadow: 5px 5px #d6dce1;
        }
        .errr_text{
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-app="review" ng-cloak>
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base" >
            <div id="content" ng-controller="sendreviewController" ng-cloak>
                <section>
                    <div class="section-body contain-lg" style="display: block;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <header><i class="fa fa-fw fa-tag"></i>Send Review's</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <select class="form-control" ng-model="month_name" ng-init="month_name = ''" ng-change="reset()">
                                                        <option value="">Select Month</option>
                                                        <option ng-repeat="obj in monthname" value="{{obj.value}}">{{obj.Month}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2" ng-show="month_name != ''">
                                                    <select class="form-control" ng-model="years" ng-init="years = ''" ng-change="reset()">
                                                        <option value="">Select Year</option>
                                                        <option ng-repeat="obj in year">{{obj.value}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1" ng-show="month_name != '' && years != ''">
                                                    <button class="btn btn-danger" ng-click="allstaff()">GO</button>
                                                </div>
                                                <div class="col-md-4" ng-show="month_name != '' && years != '' && data.length > 0">
                                                    <label style="font-weight: bold;">{{data[0].subject}} | </label>
                                                    <label> Total :{{data.length}} | Total Selected :{{myCount}}</label>
                                                </div>
                                                <div class="col-md-3" ng-show="data.length > 0">
                                                    <button ng-show="myCount > 0 && selectall == true" class="btn btn-success" ng-click="sendmail()"> <i style="cursor: pointer;" class="fa fa-paper-plane" aria-hidden="true"></i> to {{myCount}}</button>
                                                    <a class="btn btn-primary" href="<?php echo base_url() . "index.php/review/emailtemplate" ?>" target="_blank" style="cursor: pointer;" class="fa fa-pencil" aria-hidden="true"><i style="cursor: pointer;" class="fa fa-pencil" aria-hidden="true"></i> Edit In Template</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" ng-show="data.length > 0">
                                            <div class="form-group">
                                                <div class="col-md-3 col-md-offset-9">
                                                    <input type="text" class="form-control" ng-model="search" placeholder="Search">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                        </div>
                                        <div class="row" id="exportthis">
                                            <table class="table table-responsive" ng-show="data.length > 0">
                                                <thead class="head_sytle">
                                                    <tr>
                                                        <th>
                                                            <div style="margin-bottom: 0px;" class="checkbox checkbox-styled tile-text">
                                                                <label>
                                                                    <input ng-change="checkall()" type="checkbox" checked="" ng-model="selectall">
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </th>
                                                        <th>Sr.no</th>
                                                        <th>Name</th>
                                                        <th>Email Content</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tr_style">
                                                    <tr ng-repeat="obj in data| orderBy : '-final_remark' | filter: search">
                                                        <td style="width: 30px; ">
                                                            <div ng-hide="obj.final_remark == '' || obj.final_target == ''" class="checkbox checkbox-styled tile-text">
                                                                <label>
                                                                    <input ng-change="selecsingle()" type="checkbox" checked="" ng-model="obj.ischecked" ng-init="obj.ischecked = false">
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td style="width: 85px; ">{{$index + 1}}</td>
                                                        <td style="width: 150px; font-weight: bold;">{{obj.name}}</td>
                                                        <td><header ng-hide="obj.final_remark == '' || obj.final_target == ''" class="header_style">TO : {{obj.email_address}}</header><header ng-hide="obj.final_remark == '' || obj.final_target == ''" class="header_style">CC : <span ng-repeat="ccobj in obj.cc">{{ccobj}} ,</span></header><p class="body_style" ng-hide="obj.final_remark == '' || obj.final_target == ''" id="{{$index}}" ng-bind-html="obj.template"></p><p style="color:red; font-weight: bold;" ng-show="obj.final_remark == '' || obj.final_target == ''">Final Remark not save yet ! </p></td>
                                                        <td style="width: 100px;"><button ng-hide="obj.final_remark == '' || obj.final_target == '' || obj.ischecked == false || selectall == true" class="btn btn-success" ng-click="sendmail(data)"><i style="cursor: pointer;" class="fa fa-paper-plane" aria-hidden="true"></i></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div ng-show="data.length > 0">
                                                <p class="errr_text" ng-show="(data | filter:search).length == 0">No data found !</p>
                                            </div>
                                        </div>
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
            <script>
                var myURL = "<?php echo base_url(); ?>";
            </script>
            <script src="<?php echo base_url('assets/myjs/review.js?v=' . time()) ?>"></script>


