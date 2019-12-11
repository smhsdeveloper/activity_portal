<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>
        Manage Project
    </title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <body class="menubar-hoverable header-fixed" ng-app="projectApp" ng-controller="projectAppController">
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head">

                                        <header>Manage Project Name</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">

                                        </div>
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
//                                        $xcrud->connection($db['default']['username'],$db['default']['password'], $db['default']['database'],$db['default']['hostname']);
                                        $xcrud->table('test_project_details');
                                        $xcrud->columns("title,department_id,project_incharge_id,tester_id,entry_by");
                                        // $xcrud->columns("sub_project_id,title,description,department_id,project_incharge_id,entry_by");
                                        $xcrud->order_by("title");

                                        $xcrud->fields("sub_project_id,title,department_id,description,project_incharge_id,tester_id,category,status");
                                        $xcrud->relation("sub_project_id", "sub_project", "id", array("project_title"));
//                                        $xcrud->relation('module_id', 'test_project_details', 'id', array('title'), '', '', '', ' ', '', 'project_id', 'project_id');
                                        $xcrud->relation("project_incharge_id", "company_staff_details", "id", array("name"));
                                        $xcrud->relation("tester_id", "company_staff_details", "id", array("name"));
                                        $xcrud->change_type('status','select','',array('Activate'=>'ACTIVATE','Deactivated'=>'DEACTIVATE'));

                                        $xcrud->label("sub_project_id", "Sub Project");
                                        $xcrud->label("title", "Project Title");
                                        $xcrud->label("department_id", "Department");
                                        $xcrud->label("tester_id", "Tester");
                                        $xcrud->label("description", "Description");
                                        $xcrud->label("project_incharge_id", "Incharge");
                                        $xcrud->label("entry_by", "Action");
                                        $xcrud->column_pattern('entry_by', "<a href='" . base_url() . "index.php/testing/manageproject/{id}' class='btn btn-warning '>View</a>");
                                        $xcrud->relation('department_id', 'department_master', 'id', array("title"));
                                        $xcrud->validation_required('title');
                                        $xcrud->validation_required('department_id');
                                        $xcrud->validation_required('project_incharge_id');
                                        $xcrud->limit(25);
                                        $xcrud->unset_view(TRUE);

                                        $xcrud->unset_title();
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_remove(false);
                                        $xcrud->where('status', 'ACTIVATE');
                                        echo $xcrud->render();
                                        ?>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                            <div ng-show="project_id > 0" class="col-md-6">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head">

                                        <header>Modules - {{project_name}}</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">

                                        </div>
                                        <?php
                                        $xcrudmodules = Xcrud::get_instance();
                                        $xcrudmodules->connection($db['default']['username'], $db['default']['password'], $db['default']['database'], $db['default']['hostname']);
                                        $xcrudmodules->table('test_project_modules_details');


                                        $xcrudmodules->columns("module_no,title,description,developer_id,module_type");
                                        $xcrudmodules->order_by("id");

                                        $xcrudmodules->fields("module_no,title,description,developer_id,module_type");
                                        $xcrudmodules->relation("project_id", "test_projects_details", "id", array("title"));
                                        $xcrudmodules->relation("developer_id", "company_staff_details", "id", array("name"));
                                        $xcrudmodules->where("project_id", $project_id);
                                        $xcrudmodules->label("module_no", "Module No");
                                        $xcrudmodules->label("title", "Title");
                                        $xcrudmodules->label("description", "Remark");
                                        $xcrudmodules->label("developer_id", "Developer");
                                        $xcrudmodules->label("module_type", "Module Type");
                                        $moduletype = array("" => "-none-", "OLD" => "OLD", "NEW" => "NEW");
                                        $xcrudmodules->change_type("module_type", "select", "", $moduletype);

                                        $xcrudmodules->validation_required('title');
                                        $xcrudmodules->validation_required('developer_id');

                                        $xcrudmodules->limit(25);
                                        $xcrudmodules->pass_var("project_id", $project_id);
                                        $xcrudmodules->unset_view(TRUE);
                                        $xcrudmodules->unset_title();
                                        $xcrudmodules->unset_print(TRUE);
                                        $xcrudmodules->unset_csv(TRUE);
                                        $xcrudmodules->unset_search(TRUE);
                                        $xcrudmodules->unset_remove(false);

                                        echo $xcrudmodules->render();
                                        ?>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .card -->

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
        var project_id = <?php echo $project_id; ?>;
        var myURL = "<?php echo base_url(); ?>";
        var tittle = "<?php echo $project_name; ?>"
    </script>
    <script>
        var app = angular.module('projectApp', ['blockUI']);
        app.controller('projectAppController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
                $scope.project_id = project_id;
                $scope.project_name = tittle;
                $scope.hideModules = function () {
                    $scope.project_id = 0;
                }

            }]);
    </script>
