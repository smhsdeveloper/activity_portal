<?php
include(APPPATH . 'config/database' . EXT);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Email Template </title>
    <?php
//echo $class;

    $this->load->view('include/headcss');
    $staff_id = $this->session->userdata('company_staff_id');
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/autocomplete/autocomplete.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modules/materialadmin/css/theme-default/libs/wizard/wizardfa6c.css?1422823375" />
    <body class="menubar-hoverable header-fixed ">
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
                                        <header><i class="fa fa-fw fa-tag"></i>Email Template</header>
                                    </div><!--end .card-head -->
                                    <div class="card-body style-default-bright">
                                        <?php
                                        $this->load->library('loadxcrud');
                                        echo Xcrud::load_css();
                                        Xcrud_config::$editor_url = base_url() . 'assets/js/ckeditor/ckeditor.js';
                                        $xcrud = Xcrud::get_instance();
                                        $xcrud->table('email_template');
                                        $xcrud->columns('mail_subject,mail_body,sms_body,cc,tag,template_code');
                                        $xcrud->fields('mail_subject,mail_body,sms_body,cc,tag,template_code');
                                        $xcrud->limit(25);
                                        $xcrud->validation_required('mail_subject');
                                        $xcrud->validation_required('mail_body');
                                        $xcrud->validation_required('template_code');
                                        $xcrud->pass_var("entry_by", $staff_id);
                                        $xcrud->unset_title(TRUE);
                                        $xcrud->unset_view(TRUE);
                                        $xcrud->unset_print(TRUE);
                                        $xcrud->unset_csv(TRUE);
                                        $xcrud->unset_search(FALSE);
                                        $xcrud->unset_remove(FALSE);
                                        $xcrud->unset_edit(FALSE);
                                        $xcrud->before_insert('checktemplate');
//                                        $xcrud->before_update('before_updatetempl');
                                        echo $xcrud->render();
                                        ?>

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
    echo Xcrud::load_js();
    ?>
