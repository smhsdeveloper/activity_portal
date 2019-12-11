<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>

<style>
    thead tr th, tbody tr td {
        text-align: center;
    }
    tbody tr td,tbody tr th span {
        text-align: left !important;
    }


    [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-    ng-cloak {
        display: none !important;
    }
    th {
        text-align: center !important;
    }
    textarea.form-control {
        border: 2px solid #e7ebeb;
        font-size: 14px !important;
    }
    
    .input-group{
        width: 100%;
    }
    
    .form-group{
        margin-bottom: 0px!important;
    }

    .input-group .form-control {
        max-width: 300px;
    }
    
    .colored-table tbody tr:first-child{
        background: #0aa89e;
        color: #ffffff;
        
    }
    
    .colored-table > tbody > tr > td{
        vertical-align: top!important;
    }
    
    .colored-table > thead > tr th{
    width: 50%;
    }
    
    .form-control {
    border: 1px solid rgba(12, 12, 12, 0.12)!important;
    }
    
    .input-group-content{
            width: 300px;
    }
    
    textarea.form-control {
    padding: 8px!important;
}
    
</style>
<html lang="en">
    <title>Review Details </title>
    <?php
    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="review" ng-cloak>
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base" >
            <div id="content" ng-controller="reviewEmpController">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Review Details</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <select id="select1" name="select1" class="form-control" ng-model="selectedYear" ng-options="yearObj as yearObj.showYr for yearObj in yearData" ng-change="getreviews()">
                                                        <option value="">Select Month </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <form name="reviewForm" ng-if="slecectYear">
                                            <table class="table table-bordered no-margin colored-table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3">{{reviewData.prev_month_name}} {{reviewData.year}}</th>
                                                        <th colspan="2">{{reviewData.next_month_name}} {{reviewData.year}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Target</th>
                                                        <th>Achivement</th>
                                                        <th>Target</th>
                                                        <th>Achivement</th>
                                                    </tr>

                                                    <tr>
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{reviewData.target}}</td>
                                                        <td>{{reviewData.achievement}}</td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-content">
                                                                        <textarea name="self_target"  id="textarea1" ng-model="reviewData.self_target" class="form-control" rows="2" ></textarea>
                                                                        <span style="color:green;" class="align-text text-sm">Self - {{reviewData.self_target}}</span><br>
                                                                        <span style="color:green;" class="align-text text-sm" ng-if="reviewData.rm_target != ''" title="{{reviewData.rm_dt}}">RM - {{reviewData.rm_target}}</span><br>
                                                                        <span style="color:green;" class="align-text text-sm" ng-if="reviewData.final_target != ''" title="{{reviewData.rm_dt}}">Admin - {{reviewData.final_target}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-content">
                                                                        <textarea name="self_review" ng-model="reviewData.self_review" ng-model="self_review" id="textarea1" class="form-control" rows="2" placeholder="" required="required"></textarea>
                                                                        <span style="color:green;" class="align-text text-sm">Self -{{reviewData.self_review}}</span><br>
                                                                        <span style="color:green;" class="align-text text-sm" ng-if="reviewData.rm_remark != ''" title="{{reviewData.rm_dt}}">RM -{{reviewData.rm_remark}}</span><br>
                                                                        <span style="color:green;" class="align-text text-sm"  ng-if="reviewData.final_remark != ''" title="{{reviewData.admin_dt}}">Admin -{{reviewData.final_remark}}</span>
                                                                    </div>
                                                                    <div class="input-group-btn">
                                                                        <button ng-if="reviewData.is_save" ng-disabled="reviewForm.$invalid"  class="btn btn-success" type="button" ng-click="saveSelfReviewEmp(reviewData)">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
            <script>
                var myURL = "<?php echo base_url(); ?>";
            </script>
            <script src="<?php echo base_url('assets/myjs/review.js?v=' . time()) ?>"></script>


