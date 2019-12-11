<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>
        Manage Bug Details for Tester
    </title>
    <?php
    if ($this->session->userdata('logintype') == "COMPANY") {
        $developer_id = $this->session->userdata('company_staff_id');
    } else {
        exit();
    } 
    $this->load->view('include/headcss');
    ?>
     <body class="menubar-hoverable header-fixed" ng-app="testingApp" ng-controller="testingAppController">
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head">
                                        <div class="tools">
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="md md-colorize"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Bug Details</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <div class="form-group">

                                        </div>
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();

                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->connection($db['default']['username'], $db['default']['password'], $db['default']['database'], $db['default']['hostname']);
                                        $xcrud->table('test_bug_details');
                                        $xcrud->columns("id,module_id,description,developer_status,tester_status,entry_by");
                                        $xcrud->order_by("id");
                                        $xcrud->where("entry_by", $developer_id);
                                        $xcrud->where("developer_status!",array('DONE'));
                                        $xcrud->or_where("tester_status!",array('DONE'));
                                        $xcrud->relation("module_id", "test_project_modules_details", "id", array("title"));
                  
                                        $xcrud->column_pattern('entry_by', "<a href='" . base_url() . "index.php/testing/testerbugdetail/{id}' class='btn btn-warning '>Status</a>");
                                        $xcrud->label("module_id", "Module");
                                        $xcrud->label("description", "Description");
                                        $xcrud->label("developer_status", "Developer");
                                        $xcrud->label("tester_status", "Tester");
                                        $xcrud->label("entry_by", "Action");
                                        $xcrud->limit(25);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_add(TRUE);
                                        $xcrud->unset_title();
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(TRUE);
                                        $xcrud->unset_remove(TRUE);
                                        $xcrud->unset_edit(TRUE);
                                        $xcrud->unset_search(FALSE);
                                        echo $xcrud->render();
                                        ?>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                            <?php if ($bug_id > 0) { ?>
                                <div class="col-md-6">
                                    <div class="card card-bordered style-primary">
                                        <div class="card-head">
                                            <div class="tools">
                                                <div class="btn-group">
                                                    <div class="btn-group">
                                                        <a href="#" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="md md-colorize"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <header><i class="fa fa-fw fa-tag"></i>Bug Status</header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright">
                                            <dl class="dl-horizontal text-lg">
                                                <dt>Bug Ref. No:</dt>
                                                <dd>#{{myBugDetails.id}}</dd>
                                                <dt>Bug:</dt>
                                                <dd>{{myBugDetails.description}}</dd>
                                                <dt>Module:</dt>
                                                <dd>{{myBugDetails.title}}</dd>
                                                <dt>Developer Status:</dt>
                                                <dd>{{myBugDetails.developer_status}}&nbsp;({{myBugDetails.developer_comment}})</dd>
                                                <dt>Developer Name:</dt>
                                                <dd><?php echo $team_name['developer_name']; ?></dd>
                                                <dt>Tester Status:</dt>
                                                <dd>{{myBugDetails.tester_status}}&nbsp;({{myBugDetails.tester_comment}})</dd>
                                                <dt>Tester Name:</dt>
                                                <dd><?php echo $team_name['tester_name']; ?></dd>
                                            </dl>
                                            <p>Is module seems Ok?</p>
                                            <div class="form-group floating-label">
                                                <div class="input-group">
                                                    <div class="input-group-content">
                                                        <input type="text" placeholder="Remark" id="groupbutton10" ng-model="tester_comment" class="form-control">
                                                 
                                                    </div>
                                                    <div class="input-group-btn">
                                                        <p><button  class="btn ink-reaction btn-raised btn-xs btn-success"  ng-click="UpdateStatusTester(<?php echo $bug_id; ?>)"  type="button">Done</button><button  class="btn ink-reaction btn-raised btn-xs btn-danger"  ng-click="UpdatePendingStatusTester(<?php echo $bug_id; ?>)"  type="button">Mark as Pending</button></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="style-default-bright">
                                                        <header class="text-primary">Chat with Developer</header>
                                                        <form class="form">
                                                            <div class="form-group floating-label">
                                                                <textarea ng-model="remark" ng-enter="SaveRemarkMessage()" rows="1" class="form-control autosize" id="sidebarChatMessage" name="sidebarChatMessage"></textarea>
                                                                <input type="text" ng-model="remark_from" value="TESTER" style="display: none">
                                                                <label for="sidebarChatMessage">Leave a message</label>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div style="background:  Gainsboro ">
                                                        <div class="nano has-scrollbar" style="height: 222.55px;"><div class="nano-content" tabindex="0" style="right: -13px;"><div class="offcanvas-body">
                                                                    <ul ng-repeat="remarkObj in remark_details1| orderBy:'timestamp':true" class="list-chats">
                                                                        <li ng-if="remarkObj.remarks_from == 'TESTER'">
                                                                            <div class="chat">
                                                                                <div class="chat-avatar"><img alt="" src="http://www.codecovers.eu/assets/img/modules/materialadmin/avatar1.jpg?1422538623" class="img-circle"></div>
                                                                                <div class="chat-body">
                                                                                    {{remarkObj.remarks}}
                                                                                    <small>{{remarkObj.time_timestamp}}</small>
                                                                                </div>
                                                                            </div> 
                                                                        </li>
                                                                        <li ng-if="remarkObj.remarks_from == 'DEVELOPER'" class="chat-left">
                                                                            <div class="chat">
                                                                                <div class="chat-avatar"><img alt="" src="http://www.codecovers.eu/assets/img/modules/materialadmin/avatar9.jpg?1422538626" class="img-circle"></div>
                                                                                <div class="chat-body">
                                                                                    {{remarkObj.remarks}}
                                                                                    <small>{{remarkObj.time_timestamp}}</small>
                                                                                </div>
                                                                            </div> 
                                                                        </li>
                                                                    </ul>
                                                                </div></div><div class="nano-pane"><div class="nano-slider" style="height: 80px; transform: translate(0px, 24.9505px);"></div></div></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>





                                    </div><!--end .card-body -->

                                </div><!--end .card -->
                            </div><!--end .col -->
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
            var bug_details =<?php echo json_encode($bug_details); ?>;
            var remark_details =<?php echo json_encode($remark_details); ?>;
            var myURL = "<?php echo base_url(); ?>";
            var remark_from = 'TESTER';
            var developer_id = "<?php echo $this->session->userdata('company_staff_id'); ?>";</script>

<script src="<?php echo base_url(); ?>assets/myjs/testing.js"></script>