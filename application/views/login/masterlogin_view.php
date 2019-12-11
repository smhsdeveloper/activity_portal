<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Master Login</title>
        <?php
        $this->load->view('include/headcss');
        ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/angucomplete.css">
        </head>
    <body class="menubar-hoverable header-fixed full-content" ng-app="masterlogin" ng-controller="masterLoginController">
        <!--<body class="menubar-hoverable header-fixed  ">-->
        <!-- BEGIN HEADER-->
        <?php $this->load->view('testing/include/header');
        ?>
        <!-- END HEADER-->
        <!-- BEGIN BASE-->

        <script>
                    var type = '<?php echo $schoolRecord[0]['type']; ?>';
                    var schoolId = '<?php echo $schoolRecord[0]['schoolId']; ?>';
        </script>

        <div id="base">
            <!-- BEGIN OFFCANVAS LEFT -->
            <!-- END OFFCANVAS LEFT -->
            <!-- BEGIN CONTENT-->
            <div id="content">

                <section class="has-actions style-default-bright">

                    <!-- BEGIN INBOX -->
                    <div class="section-body  ng-cloak">
                        <div class="row">
                            <div class="col-lg-12 col-sm-5">
                                <div class="card card-outlined style-primary">
                                    <div class="card-head card-head-xs style-primary">
                                        <header>Master Login</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body small-padding">
                                        <div class="card">
                                            <div class="card-body small-padding">
                                                <div class="form">
                                                    <div class="form-group no-margin no-padding">
                                                        <select ng-model="schoolId" id="sel1" class="form-control">
                                                            <option value="0">Select School</option>
                                                            <option ng-repeat="school in schoolList"  value="{{school.id}}" ng-selected="school.id === schoolId">{{school.school_name}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-outlined style-primary" ng-show="schoolId > 0">
                                            <div class="card-body small-padding">
                                                <div class="col-sm-4">
                                                    <p class="no-margin">
                                                        <button ng-click="type = 'STAFF'"  ng-class="type == 'STAFF' ? 'btn-primary' : 'btn - primary - bright'" class="btn btn-block ink-reaction" type="button">LOGIN AS STAFF</button>
                                                    </p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="no-margin">
                                                        <button ng-click="type = 'PARENT'"  ng-class="type == 'PARENT' ? 'btn-primary' : 'btn - primary - bright'" class="btn btn-block ink-reaction" type="button">LOGIN AS PARENT</button>
                                                    </p>
                                                </div>

                                            </div><!--end .card-body -->
                                        </div>
                                        <div ng-show="type != ''">
                                            <div class="card card-outlined style-primary">
                                                <div class="card-body small-padding">
                                                    <div class="col-sm-4" ng-show="type != ''">
                                                        <form class="form">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="form-group">

                                                                        <angucomplete id="staffName"
                                                                                      placeholder="Search name"
                                                                                      pause="20"
                                                                                      selectedobject="testObj"
                                                                                      url="<?php echo base_url(); ?>index.php/staff/getallnamelist?schoolId={{schoolId}} & type={{type}} & search= "
                                                                                      datafield="results"
                                                                                      titlefield="firstname,lastname"
                                                                                      inputclass="form-control form-control-small"
                                                                                      />

                                                                    </div>
                                                                </div><!--end .card-body -->
                                                            </div><!--end .card -->
                                                        </form>
                                                    </div>
                                                    <div class="col-sm-8" ng-show="myErrorMsg != ''">
                                                        <div class="table-responsive scrollbar" style="height:360px">
                                                            <p class="text-danger"><h3> {{myErrorMsg}}</h3> </p>
                                                        </div>
                                                    </div>
                                                    <?php if ($schoolRecord != -1) { ?>
                                                        <div class="col-sm-8">
                                                            <?php for ($i = 0; $i < count($schoolRecord); $i++) { ?>
                                                                <div class="card card-outlined style-primary"> 
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <dl class="col-sm-6 pull-left dl-horizontal text-lg">
                                                                                <?php if (isset($schoolRecord[$i]['adm_no'])) { ?>
                                                                                    <dt>Admission No:</dt>
                                                                                    <dd><?php echo $schoolRecord[$i]['adm_no']; ?></dd>
                                                                                <?php } ?>
                                                                                <dt>Name:</dt>
                                                                                <dd><?php echo $schoolRecord[$i]['firstname'] . ' ' . $schoolRecord[$i]['lastname']; ?></dd>
                                                                                <dt>Verified Mobile:</dt>
                                                                                <dd><?php echo $schoolRecord[$i]['mobile']; ?></dd>
                                                                                <dt>Class Teacher:</dt>
                                                                                <dd><?php
                                                                                    if (isset($schoolRecord[$i]['section']) && isset($schoolRecord[$i]['standard'])) {
                                                                                        echo $schoolRecord[$i]['standard'] . ' ' . $schoolRecord[$i]['section'];
                                                                                    } else {
                                                                                        echo $schoolRecord[$i]['staff_fname'] . ' ' . $schoolRecord[$i]['staff_lname'];
                                                                                    }
                                                                                    ?></dd>

                                                                                <?php if (isset($schoolRecord[$i]['e_mail'])) { ?>
                                                                                    <dt>E-mail:</dt>
                                                                                    <dd><?php echo $schoolRecord[$i]['e_mail']; ?></dd>
                                                                                <?php } ?>
                                                                            </dl>
                                                                            <dl class="col-sm-6 dl-horizontal text-lg">
                                                                                <?php if (isset($schoolRecord[$i]['g_name'])) { ?>
                                                                                    <dt>Father Name:</dt>
                                                                                    <dd><?php echo $schoolRecord[$i]['g_name']; ?></dd>
                                                                                <?php } ?>
                                                                                <dt>User Name:</dt>
                                                                                <dd><?php echo $schoolRecord[$i]['username']; ?></dd>
                                                                            </dl>
                                                                        </div><!--end .card-body -->
                                                                        <div class="card-actionbar">
                                                                            <div class="card-actionbar-row">
                                                                                <button type="button" ng-click="masterLoginNow(<?php echo $schoolRecord[$i]['userid']; ?>)" class="btn ink-reaction btn-raised btn-xs btn-success">Login</button>
                                                                            </div>
                                                                        </div>
                                                                    </div><!--end .card -->
                                                                </div>
                                                            <?php } ?>
                                                        </div><!--end .card-body -->
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div><!--end .col -->
                            </div>
                        </div><!--end .section-body -->
                        <!-- END INBOX -->

                        <!-- BEGIN SECTION ACTION -->
                        <!-- END SECTION ACTION -->
                </section>
            </div><!--end #content-->		
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
            </div><!--end #menubar-->
            <!-- END MENUBAR -->
        </div><!--end #base-->	
        <?php
        $this->load->view('include/headjs');
        ?>
        <!-- END BASE -->
        <!-- BEGIN JAVASCRIPT -->
        <script type="text/javascript">
                            var myURL = "<?php echo base_url(); ?>";
        </script>
        <script src="<?php echo base_url(); ?>/assets/myjs/masterlogin.js"></script>
        <script src="<?php echo base_url(); ?>/assets/myjs/angucomplete.js"></script>
        <script src="<?php echo base_url(); ?>/assets/js/angular-touch.min.js"></script>
        <!-- END JAVASCRIPT -->

        <script>

        </script>
    </body>
</html>