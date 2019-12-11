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

<?php 
$isAdmin = 0;
$isRM = 0;
        if ($this->session->userdata('admin_type') == 'RM' || $this->session->userdata('isRM')) { //Admin
                       $isRM = 1;
                    } 
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
                   ?>';
        var isRM = '<?php
                    if ($isRM) { //RM
                        echo true;
                    } else {
                        echo false;
                    }
                   ?>';
                      
    </script>
<html lang="en">
    <title>Review Lisitng Details </title>
    <?php
    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');    
    ?>    
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <script type="text/javascript">
      
        
    </script>
    <body class="menubar-hoverable header-fixed " ng-app="review" ng-controller="reviewListingController" ng-cloak>
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

                                        <header><i class="fa fa-fw fa-tag"></i>Review Lisitng Details</header>
                                    </div><!--end .card-head -->

                                    <div class="card-body style-default-bright">
                                        <div class="row">
                                            <div class="col-sm-2"> </div>
                                            <div class="col-md-4">
                                                <?php if($isAdmin || $isRM){ ?>
                                                <div class="form-group">
                                                    <select id="select1" name="select1" class="form-control" ng-model="selectedYear" ng-options="yearObj as yearObj.showYr for yearObj in yearData" ng-change="pageReload()">
                                                        <option value="">Select Month </option>
                                                    </select>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-4 margin-bottom-xxl">
                                                <?php if($isAdmin){ ?>
                                                <div class="form-group">
                                                    <select id="select1" name="select1" class="form-control" ng-model="rmid" ng-init="rmid = 0" ng-change="pageReload()">
                                                        <option value="0">Select RM </option>
                                                        <option value="all">Select All </option>
                                                        <option value="{{rmdetails.id}}"  ng-repeat="rmdetails in rmData">{{rmdetails.name}}</option>
                                                    </select>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-2 margin-bottom-xxl" ng-if="reviewData.length > 0">
                                                <button type="button" class="btn btn-success xcrud-action" ng-click="downloadExcel()">Download Excel</button>
                                            </div>
                                            
                                        </div>
                                        <form name="reviewForm" ng-if="reviewData.length > 0">
                                            <div class="table-responsive">
                                            <table class="table table-bordered no-margin">
                                               
                                                <tbody>
                                                    <tr >
                                                        <th>S No</th>
                                                        <th>Ecode </th>
                                                        <th>Employee Name</th>
                                                        <th>Reporting Manager</th>
                                                        <th>Productivity(Efficiency)</th>
                                                        <th>Job Knowledge(Code Standards & logics )</th>
                                                        <th>Foresightedness & Planning  (Responsibility)</th>
                                                        <th>Problem Solving & debugging </th>
                                                        <th>Communication & Problem Explaining </th>
                                                        <th>Interpersonal Skills(Behaviour) </th>
                                                        <th>Dedication </th>
                                                        <th>Deadline Achievement </th>
                                                        <th>Work Understanding </th>
                                                        <th>Attendance & Punctuality</th>
                                                        <th>Overall</th>
                                                        <th>Achievements</th>
                                                        <th>Targets</th>                                                        
                                                    </tr>

                                                    
                                                    <tr ng-repeat="reviewObj in reviewData">
                                                        <td>{{$index+1}}</td>
                                                        <td>{{reviewObj.emp_code}}</td>
                                                        <td>{{reviewObj.emp_name}}</td>
                                                        <td>{{reviewObj.rm_name}}</td>
                                                        <td>{{reviewObj.productivity}}</td>
                                                        <td>{{reviewObj.job_knowledge}}</td>
                                                        <td>{{reviewObj.foresightedness_planning}}</td>
                                                        <td>{{reviewObj.problem_solving_debugging}}</td>
                                                        <td>{{reviewObj.communication_problem}}</td>
                                                        <td>{{reviewObj.interpersonal_skills}}</td>
                                                        <td>{{reviewObj.dedication}}</td>
                                                        <td>{{reviewObj.deadline_achievement}}</td>
                                                        <td>{{reviewObj.work_understanding}}</td>
                                                        <td>{{reviewObj.attendance_punctuality}}</td>
                                                        <td>{{reviewObj.overall}}</td>
                                                        <td style="min-width: 250px;">{{reviewObj.final_target}}</td>
                                                        <td style="min-width: 250px;">{{reviewObj.final_remark}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                        </form>
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
    <script src="<?php echo base_url('assets/myjs/review.js') ?>"></script>


