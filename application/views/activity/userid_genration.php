<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Add User </title>
    <?php
    //echo $class;

    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed " ng-app="activitymail" ng-controller="activitymailcontroller">
        <?php $this->load->view('testing/include/header'); ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i>User Lists</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <?php
                                        $login_activated = array("YES" => "YES", "NO" => "NO");
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();
                                        $xcrud = Xcrud::get_instance();
//                                        $xcrud->connection($db['default']['username'], $db['default']['password'], $db['default']['database'], $db['default']['hostname']);
                                        $xcrud->table('system_users');
                                        $xcrud->columns("staff_id,usrname"); //,entry_byng-click='sendEmail({staff_id});'
                                        $xcrud->fields("staff_id,login_activated");
                                        $xcrud->label("staff_id", "Username");
                                        $xcrud->label("pass", "Password");
                                        $xcrud->label("usrname", "Action");
                                        $xcrud->where("member_type", "COMPANY");
                                        $xcrud->column_pattern('usrname', "<button class='btn btn-success' onclick='sendEmail({staff_id})' id='Emailtoclient' empid='staff_id' >Send Email</button>");
                                        $xcrud->relation('staff_id', 'company_staff_details', 'id', array("email_address"));
                                        $xcrud->change_type("login_activated", "select", "", $login_activated);
                                        $xcrud->pass_var("member_type", 'COMPANY');
                                        $xcrud->pass_var("pass", 'abcd123');
                                        $xcrud->validation_required(array('staff_id', 'login_activated'));
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(FALSE);
                                        $xcrud->unset_remove(FALSE);
                                        $xcrud->unset_add(FALSE);
                                        $xcrud->unset_edit(FALSE);
                                        $xcrud->limit(25);

                                        echo $xcrud->render();
                                        ?>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                            </div><!--end .col -->
                            <div class="col-md-4">
                                <div class="card card-bordered style-primary">
                                    <div class="card-head card-head-xs">
                                        <div class="tools">
                                        </div>
                                        <header><i class="fa fa-fw fa-tag"></i> How to create a userid</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright"> 
                                        1. Click on ADD button to create a new userid.<br>
                                        2. For edit or delete a employee Detail click on the row's edit or delete button.

                                    </div> 
                                </div><!--end .card-body -->
                            </div><!-- end .card -->

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
<!--    <script type="text/javascript">
     var myUrl = "<?php // echo base_url();      ?>";        
 </script>-->
    <script>var myURL = "<?php echo base_url(); ?>";</script>
    <script src="<?php echo base_url(); ?>assets/myjs/genrateuser.js?a=<?php echo rand(2, 50) ?>"></script>


    <script>
//        $('#Emailtoclient').click(function(){
//            alert($this.attr('empid'));
//        })
        function sendEmail(staffid) {
            if (confirm('Are you sure want to send Email')) {
                if (staffid) {
                    $.ajax({
                        url: myURL + 'index.php/activity/sendEmail',
                        type: "POST",
                        data: 'data=' + staffid,
                        success: function (jsondata) {
                            if (jsondata === 'Email_Sent') {
                                alert('Email Successfully Sent');
                            } else if (jsondata === 'Contact_to _Admin') {
                                alert('Please Contact to Admin !');
                            } else if (jsondata === 'Email_Password_Not_found') {
                                alert('Email Password not Fouund!');
                            } else {
                                alert('Email not Fouund!');
                            }
                        }
                    });
//                    $.ajax({
//                        method: 'POST',
//                        url: myURL + 'index.php/activity/sendEmail',
//                        data: 'data=' + staffid,
//                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
//                    }).success(function (jsondata) {
//                        if (jsondata === 'Email_Sent') {
//                            alert('Email Successfully Sent');
//                        } else if (jsondata === 'Contact_to _Admin') {
//                            alert('Please Contact to Admin !');
//                        } else if (jsondata === 'Email_Password_Not_found') {
//                            alert('Email Password not Fouund!');
//                        } else {
//                            alert('Email not Fouund!');
//                        }
//                    });
                } else {
                    alert('Please Contact to Admin !');
                }
            }
            
        }

//     function changeURL(element) {
//         if (element.value == '') {
//         } else {
//             window.location = "<?php // echo base_url();      ?>index.php/staff/managesubject/" + element.value;
//         }
//     }
    </script>
