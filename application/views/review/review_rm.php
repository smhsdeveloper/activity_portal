<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>

<style>
    thead tr th, tbody tr td,tbody tr th {
        text-align: center;
    }
    tbody tr td,tbody tr th span {
        text-align: left !important;
    }
    .vertical-center-class{
        position: relative;
        top: 50%;
        transform: translateY(-110%);
    }
    [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-    ng-cloak {
        display: none !important;
    }
    th {
        text-align: center !important;
    }
    .custom-width{
        width: 450px !important;
    }

    .table>tbody>tr>td, 
    .table>tbody>tr>th, 
    .table>tfoot>tr>td, 
    .table>tfoot>tr>th, 
    .table>thead>tr>td, 
    .table>thead>tr>th {
        vertical-align: middle !important;
        width: auto;
    }

    .my-pointer{
        cursor: pointer;
    }
    textarea.form-control {
        border: 2px solid #e7ebeb;
        font-size: 14px !important;
        resize:none;
    }
    .bg-classtd{
        background: #bee7e85e;
    }
    
    .colored-table thead tr:first-child{
        background: #0aa89e;
        color: #ffffff;
        
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
    <script>
        var isAdmin = '<?php
    if ($this->session->userdata('admin_type') == 'ADMIN' && !$this->session->userdata('isRM')) {
        echo true;
    } else {
        echo false;
    }
    ?>';
    </script>
    <body class="menubar-hoverable header-fixed " ng-app="review" ng-controller="reviewRmController" ng-cloak>
        <?php $this->load->view('testing/include/header'); ?>


        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Rating For {{selectedEmpObject.emp_name}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <form name="ratingForm" novalidate>
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Parameter Name</th>
                                            <th colspan="2">Rating</th>                                           
                                        </tr>
                                         <tr>
                                            <td></td>
                                            <td></td>
                                            <td>{{selectedYear.month-1 | monthName }} </td>  
                                            <td>{{selectedYear.month | monthName }} </td> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="ratingObj in ratingData">
                                            <td>{{$index + 1}}</td>
                                            <td>{{ratingObj.param_name}}</td>
                                            <td>{{ratingObj.prevrating}}</td>
                                            <td>
                                               
                                                <input id="{{$index}}" ng-keyup="getOverAll()" class="form-control" ng-model="ratingObj.rating" type="text" name="rating{{$index}}" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/">
                                                <span style="color:Red"  ng-show="ratingForm['rating'+{{$index}}].$error.pattern">Only Numbers Allowed, Maximum 1 Characters</span>
                                            </td>                               
                                        </tr>
                                    <td colspan="2">Overall Rating</td>
                                    <td >{{overAllPreRating| number:2}}</td>
                                    <td >{{overAllRating| number:2}}</td>
                                    <tr>

                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary pull-left" ng-disabled="!ratingForm.$valid" data-dismiss="modal" ng-click="saveEmpRating()">Save</button>
                        <button type="button" class="btn btn-primary pull-left" ng-if ="showCopyBtn"  ng-click="copyEmpRating()" style="margin-left:37% !important">Copy</button>
                        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
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
                                        <header><i class="fa fa-fw fa-tag"></i>Review Details</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <select id="select1" name="select1" class="form-control" ng-model="selectedYear" ng-options="yearObj as yearObj.showYr for yearObj in yearData" ng-change="getreviews()">
                                                        <option value="">Select Month </option>
                                                        <!--<option value="{{yearObj}}"  ng-repeat="yearObj in yearData">{{yearObj.showYr}}</option>-->
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if ($this->session->userdata('admin_type') == 'ADMIN' && !in_array($this->session->userdata('company_staff_id'), BlockReviewAdmin())) { ?> 
                                                <div class="col-md-6">
                                                    <div class="col-sm-6"> <label>Select RM   </label> </div>
                                                    <div class="col-sm-6 margin-bottom-xxl">
                                                        <div class="form-group">
                                                            <select id="select1" name="select1" class="form-control" ng-model="rmid"  ng-change="getRMEmpList()">
                                                                <option value="">Select RM </option>
                                                                <option value="ALL">ALL</option>
                                                                <option value="{{rmdetails.id}}"  ng-repeat="rmdetails in rmData">{{rmdetails.name}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div> 
                                        <form name="reviewForm" ng-if="reviewData.length > 0">
                                            <table class="table table-bordered no-margin colored-table">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Emp Name</th>
                                                        <th>Month</th>
                                                        <th>Target ({{selectedYear.month+1 | monthName }}-{{selectedYear.year}} )</th>
                                                        <th>Achivement</th>
                                                    </tr>
                                                </thead>
                                                <tbody ng-repeat="reviewObj in reviewData | orderBy:'emp_name'">      
                                                    <tr> 
                                                        <th rowspan="2">{{$index + 1}}</th> 
                                                        <th rowspan="2" style="white-space:nowrap">{{reviewObj.emp_name}}<br>
                                                            <a href="javascript:void(0)" ng-if="reviewObj.is_save" ng-disabled="!reviewObj.rm_target" ng-click="saveEmpReviewByRM(reviewObj)" class="btn ink-reaction btn-floating-action btn-xs btn-primary" style="margin-right:15px" title="Save"><i class="fa fa-save"></i></a>
                                                            <a href="javascript:void(0)" data-toggle="modal" ng-click="selectedEmp(reviewObj)" data-target="#myModal" class="btn ink-reaction btn-floating-action btn-xs btn-info"  title="Rating"><i class="fa fa-star-half-o"></i></a>

                                                        </th> 
                                                        <th style="white-space:nowrap" ng-class="(reviewObj.final_target != '') ?'bg-classtd':''">{{reviewData[0].next_month_name}}- {{reviewData[0].year}}
                                                            <br> Rating : {{reviewObj.overall_current_rating}}
                                                        </th> 
                                                        <td class="custom-width" ng-class="(reviewObj.final_target != '') ?'bg-classtd':''">
                                                            <textarea name="rm_target"  id="textarea1" ng-model="reviewObj.rm_target" class="form-control" rows="3" placeholder="" required="required"></textarea>
                                                            <span style="color:green;" class="align-text text-sm">Self - {{reviewObj.self_target}}</span><br>
                                                            <span style="color:#134456;" class="align-text text-sm" ng-if="reviewObj.rm_target_show != ''" title="{{reviewObj.rm_dt}}">RM - {{reviewObj.rm_target_show}}</span><br>
                                                            <span style="color:#ce1526;" class="align-text text-sm" ng-if="reviewObj.final_target != ''" title="{{reviewObj.admin_dt}}">Admin - {{reviewObj.final_target}}</span>
                                                            
                                                        </td> 
                                                        <td class="custom-width" ng-class="(reviewObj.final_target != '') ?'bg-classtd':''">
                                                            <textarea name="rm_review"  id="textarea1" ng-model="reviewObj.rm_review"  class="form-control" rows="3" placeholder="" ></textarea>
                                                            <span style="color:green; " class="align-text text-sm" >Self -{{reviewObj.self_review}}</span><br>
                                                            <span style="color:#134456;" ng-if="reviewObj.rm_review_show != ''" class="align-text text-sm" title="{{reviewObj.rm_dt}}">RM -{{reviewObj.rm_review_show}}</span><br>
                                                            <span style="color:#ce1526;" ng-if="reviewObj.final_remark != ''" class="align-text text-sm" title="{{reviewObj.admin_dt}}">Admin -{{reviewObj.final_remark}}</span>

                                                        </td>
                                                    </tr>
                                                    <tr>                                                        
                                                        <th style="white-space:nowrap">{{reviewData[0].prev_month_name}}- {{reviewData[0].year}}
                                                        <br> Rating : {{reviewObj.overall_previous_rating}}</th> 
                                                        <td class="custom-width" >{{reviewObj.target}}</td> 
                                                        <td class="custom-width">{{reviewObj.achievement}}</td>
                                                    </tr> 


                                                </tbody>
                                            </table>
                                        </form>

                                        <div class="alert alert-danger" role="alert" ng-if="!reviewData">
                                            <strong>Oh snap !</strong> No record found !!.
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
