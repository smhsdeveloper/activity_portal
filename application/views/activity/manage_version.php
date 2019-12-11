<?php
include(APPPATH . 'config/database' . EXT);
$emid = $this->session->userdata('company_staff_id');
?>
<!DOCTYPE html>
<html lang="en">
    <title>
        Manage Version
    </title>
    <?php
    $this->load->view('include/headcss');
    $this->load->library('loadxcrud');
    ?>
    <body class="menubar-hoverable header-fixed" ng-app="versionapp" ng-controller="versionappcontroller">
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head">

                                        <header>Manage Version</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="row">
                                            <div class="col-sm-4 margin-bottom-xxl">
                                                <span>Select Project</span>
                                            </div>
                                            <div class="col-sm-8 margin-bottom-xxl">
                                                <div class="form-group">
                                                    <select id="select1" name="select1" class="form-control" ng-model="prjId" ng-init="prjId = 0" ng-change="selectproject()">
                                                        <option value="0">Select Project </option>
                                                        <option value="{{x.id}}" ng-repeat="x in projectlist" ng-selected="<?php echo $project_id ?> == x.id">{{x.title}}</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <?php if ($project_id > 0) { ?>
                                            <div class="row">
                                                <?php
                                                echo Xcrud::load_css();

                                                $xcrud = Xcrud::get_instance();
//                                        $xcrud->connection($db['default']['username'],$db['default']['password'], $db['default']['database'],$db['default']['hostname']);
                                                $xcrud->table('version_details');


                                                $xcrud->columns("version_name,version_date,type,description,entry_by");
                                                $xcrud->order_by("version_name");

                                                $xcrud->fields("version_name,version_date,type,description");
                                                $xcrud->label("entry_by", 'Action');

                                                $xcrud->column_pattern('entry_by', "<a href='" . base_url() . "index.php/activity/manageversion/" . $project_id . "/{id}' class='btn btn-warning '>View</a>");
                                                $xcrud->validation_required('version_name');
                                                $xcrud->validation_required('version_date');
                                                $xcrud->validation_required('type');
                                                $xcrud->limit(25);
                                                if (($emid != 8) && ($emid != 32)) {
                                                    $xcrud->unset_add(true);
                                                    $xcrud->unset_edit(true);
                                                } else {

                                                    $xcrud->unset_add(false);
                                                    $xcrud->unset_edit(false);
                                                }
                                                $xcrud->unset_remove(TRUE);
                                                $xcrud->unset_title();
                                                $xcrud->unset_print(TRUE);
                                                $xcrud->unset_csv(TRUE);


                                                echo $xcrud->render();
                                                ?>
                                            </div>

                                        </div>
                                    <?php } ?>
                                </div><!--end .card-body --> 

                            </div><!--end .col -->
                            <?php if (($project_id > 0) && ($version > 0)) { ?>
                                <div class="col-md-6">
                                    <div class="card card-bordered style-primary">
                                        <div class="card-head">

                                            <header>Version <span class="pull-right"><a href="<?php base_url() ?>"><i class="fa fa-backward"></i></a></span></header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright">
                                            <div class="form-group">

                                            </div>
                                            <?php
                                            $xcrudmodules = Xcrud::get_instance();
                                            $xcrudmodules->connection($db['default']['username'], $db['default']['password'], $db['default']['database'], $db['default']['hostname']);
                                            $xcrudmodules->table('version_control_details');
                                            $xcrudmodules->columns("version_id,change_type,theory");
                                            $xcrudmodules->order_by("version_id");
                                            $xcrudmodules->fields("version_id,change_type,theory");
                                            $xcrudmodules->relation("version_id", "version_details", "id", array("version_name"));
//                                            $xcrudmodules->where("entry_by", $emid);
                                            $xcrudmodules->validation_required('version_id');
                                            $xcrudmodules->validation_required('change_type');
                                            $xcrudmodules->validation_required('theory');
                                            $xcrudmodules->pass_var("version_id", $version);
                                            if (($emid != '8') && ($emid != "32")) {
                                                $xcrudmodules->unset_add(true);
                                                $xcrudmodules->unset_edit(true);
                                            }
                                            $xcrudmodules->unset_view(false);
                                            $xcrudmodules->unset_title();
                                            $xcrudmodules->unset_print(TRUE);
                                            $xcrudmodules->unset_csv(TRUE);
                                            $xcrudmodules->unset_search(TRUE);
                                            $xcrudmodules->unset_remove(true);

                                            echo $xcrudmodules->render();
                                            ?>
                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div><!--end .card -->
                            <?php } ?>

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
    echo Xcrud::load_js();
    ?>
    <script>
        var myURL = "<?php echo base_url(); ?>";

    </script>
    <script src="<?php echo base_url(); ?>assets/myjs/versioncontrol.js"></script>
</body>
</html>

