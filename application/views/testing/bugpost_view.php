<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Bug Post</title>
    <?php
    $moduleId = trim($moduleId);
    $projectId = trim($projectId);
    $company_staff_id = $this->session->userdata('company_staff_id');
    $this->load->view('include/headcss');
    ?>
    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="md md-colorize"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Project Module</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">
                                            <select id="dd_section_type" onchange="changeURL(this)" name="select1" class="my-select">
                                                <option value="0">Select Project</option>
                                                <?php
                                                foreach ($myprojectarr as $val) {
                                                    ?>
                                                    <option <?php echo ($projectId) == $val['id'] ? 'selected' : ''; ?> value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->connection($db['default']['username'], $db['default']['password'], $db['default']['database'], $db['default']['hostname']);
                                        $xcrud->table('test_project_modules_details');
                                        $xcrud->columns("id,title,description,developer_id,entry_by");
                                        $xcrud->where('project_id =', $projectId);

                                        $xcrud->fields("title,description,developer_id");
                                        $xcrud->relation("developer_id", "company_staff_details", "id", array("name"));
                                        $xcrud->label("title", "Name");
                                        $xcrud->label("id", "Id");
                                        $xcrud->label("entry_by", "Post");
                                        $xcrud->label("description", "Description");
                                        $xcrud->label("developer_id", "Developer");
                                        $xcrud->column_pattern('entry_by', "<a href='" . base_url() . "index.php/testing/bugpost/$projectId/{id}/{developer_id}' class='btn btn-warning '>POST</a>");
                                        $xcrud->limit(25);
                                        $xcrud->unset_search(FALSE);
                                        $xcrud->unset_add(FALSE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_edit(TRUE);
                                        $xcrud->pass_var('project_id', $projectId);
                                        $xcrud->unset_remove(TRUE);


                                        echo $xcrud->render();
                                        ?>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                            <?php if ($moduleId > 0) { ?>
                                <div class="col-md-6">
                                    <div class="card card-bordered style-primary">
                                        <div class="card-head card-head-xs">
                                            <div class="tools">

                                            </div>
                                            <header><i class="fa fa-fw fa-tag"></i>Post Bug-<?php echo $module_title ?> </header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright" style="text-align: justify">
                                            <?php
                                            $postBug = Xcrud::get_instance();
                                            $postBug->connection($db['default']['username'], $db['default']['password'], $db['default']['database'], $db['default']['hostname']);
                                            $postBug->table('test_bug_details');
                                            $postBug->columns("description,type");
                                            $postBug->where('module_id =', $moduleId);
                                            $postBug->fields("description,type");
                                            $postBug->relation("type", "test_bug_type", "type_name", array("type_name"));
                                            $postBug->label("description", "Description");
                                            $postBug->label("tester_status", "Status");
                                            $postBug->label("type", "Type");
                                            $postBug->change_type('type', 'select', 'General');
                                            $postBug->limit(25);
                                            $postBug->pass_var("module_id", $moduleId);
                                            $postBug->pass_var("entry_by", $company_staff_id);
                                            $postBug->pass_var("developer_id", $developer_id);
                                            $postBug->pass_var("punch_time", date('Y-m-d H:i:s'));

                                            $postBug->unset_view(FALSE);
                                            $postBug->unset_title(TRUE);
                                            $postBug->unset_print(TRUE);
                                            $postBug->unset_csv(TRUE);
                                            $postBug->unset_edit(FALSE);
                                            $postBug->unset_search(TRUE);
                                            $postBug->unset_remove(FALSE);


                                            echo $postBug->render();
                                            ?>

                                        </div>     
                                    </div><!--end .card-body -->
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
        function changeURL(element) {
            if (element.value == '') {
            } else {
                window.location = "<?php echo base_url(); ?>index.php/testing/bugpost/" + element.value;
            }
        }
    </script>
