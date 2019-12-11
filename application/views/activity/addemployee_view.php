<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Add Employee </title>
    <?php
    //echo $class;

    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');
    $this->load->library("loadxcrud");
    echo Xcrud::load_css();
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <style>
        .class-menu{
            background-color: cornsilk;
            height: 20px;
        }
    </style>
    <body class="menubar-hoverable header-fixed " ng-app="login" ng-controller="loginController">
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base">
            <div id="content">
                <div class="modal fade" id="myModal" role="dialog">
                    <div id="modaldiv" class="modal-dialog"  >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 >Privilege set for {{empName}}</h4>
                                <div>selected menu:<strong> {{checkCount}}</strong></div>
                                <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body" style="overflow-y: scroll; height:300px;">
                                <table class="table"  >
                                    <thead class="light-green">
                                    <th>S.No</th>
                                    <th>Select Menu</th>
                                    <th>Menu</th>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="obj in menu" style="background-color: {{obj.color}}">
                                            <td>{{$index + 1}} </td>
                                            <td><input ng-model="obj.is_check" type="checkbox"></td>
                                            <td>{{obj.menu_caption}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" data-dismiss="modal" ng-click="save(menu, masterid)">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>Employee List</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <?php
                                        $typeArray = array("ADMIN" => 'ADMIN', "RM" => 'RM', "EMP" => 'EMPLOYEE');
                                        $typeActive = array("WORKING" => 'WORKING', "LEFT" => 'LEFT');
                                       
                                        $otpArray = array("YES" => 'YES', "NO" => 'NO');
                                        $reminderArray = array("YES" => 'YES', "NO" => 'NO');
                                        $adminArray = array("YES" => 'YES', "NO" => 'NO');
                                        $isRmArray = array("1" => 'YES', "0" => 'NO');
                                        $xcrud = Xcrud::get_instance();
//                                        $xcrud->connection($db['default']['username'], $db['default']['password'], $db['default']['database'], $db['default']['hostname']);
                                        $xcrud->table('company_staff_details');
                                        $xcrud->columns("name,designation,department,email_address,mobile_for_sms,active_status");
                                        $xcrud->fields("name,designation,department,rm_id,admin_type,email_address,mobile_for_sms,sms_status,email_status,otp_sms,reminder_sms,admin_sms,active_status,is_rm");
                                        $xcrud->label("name", "Name");
                                        $xcrud->label("sms_status", "Sms Status");
                                        $xcrud->label("email_address", "Email");
                                        $xcrud->label("mobile_for_sms", "Mobile No.");
                                        $xcrud->label("sms_status", "Sms Status");
                                        $xcrud->label("email_status", "Email Status");
                                        $xcrud->label("rm_id", "Reporting Manager Name");
                                        $xcrud->label("designation", "Designation");
                                        $xcrud->label("admin_type", "Admin Status");
                                        $xcrud->label("d_o_j", "Date Of Joining");
                                        $xcrud->label("d_o_r", "Date Of Reliving");
                                        $xcrud->label("is_rm", "RM Status");
                                        $xcrud->label("Salary", "Salary");
                                        $xcrud->relation('rm_id', 'company_staff_details', 'id', array("name"));
                                        $xcrud->change_type('admin_type', 'select', 'General', $typeArray);
                                        $xcrud->change_type('otp_sms', 'select', 'General', $otpArray);
                                        $xcrud->change_type('reminder_sms', 'select', 'General', $reminderArray);
                                        $xcrud->change_type('admin_sms', 'select', 'General', $adminArray);
                                        $xcrud->change_type('active_status', 'select', 'General', $typeActive);
                                        $xcrud->relation('designation', 'acr_designation', 'designation_name', array("designation_name"));
                                        $xcrud->relation('department', 'department_master', 'id', array("title"));
                                        $xcrud->change_type('is_rm', 'select', 'General', $isRmArray);
//                                        $xcrud->change_type('admin_type', 'select', 'General', array("NO", "YES"));
                                        $xcrud->limit(200);
                                        $xcrud->validation_required('email_address')->validation_required('email_status')->validation_required('sms_status');
                                        $xcrud->validation_pattern('email_status', 'alpha')->validation_pattern('email_address', 'email')->validation_pattern('mobile_for_sms', 'numeric')->validation_pattern('sms_status', 'alpha');
                                        $xcrud->validation_required('department');
                                        $xcrud->validation_required('name');
                                        $xcrud->validation_required('designation');
                                        $xcrud->validation_required('department');
//                                        $xcrud->validation_required('d_o_j');
//                                        $xcrud->validation_required('d_o_r');
//                                        $xcrud->validation_required('salary');
                                        $xcrud->validation_required('rm_id');
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_print(TRUE);
//                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(FALSE);
                                        $xcrud->unset_remove(FALSE);
                                        $xcrud->unset_add(FALSE);
                                        $xcrud->unset_edit(FALSE);
                                        $xcrud->button("#", 'Set Previlage', 'fa fa-cogs', "btn btn-primary btn-sm privilage", array('value' => "Send Cre", 'data-toggle' => "modal", 'data-target' => "#myModal", 'ng-click' => 'getmenudetails({id},"{name}")'));
                                        echo $xcrud->render();
                                        ?>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
<!--                            <div class="col-md-4">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> How to add a employee</header>
                                    </div>end .card-head 
                                    <div class="card-body style-default-bright"> 
                                        1. Click on ADD button to add a new employee.<br>
                                        2. For edit or delete a employee Detail click on the row's edit or delete button.

                                    </div> 
                                </div>end .card-body 
                            </div> end .card -->

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
                window.location = "<?php echo base_url(); ?>index.php/staff/managesubject/" + element.value;
            }
        }
    </script>
    <script src="<?php echo base_url(); ?>assets/myjs/login.js?v=123"></script>
    <script>
        var myUrl = "<?php echo base_url(); ?>";
    </script>

</body>
</html>