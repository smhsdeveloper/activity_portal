<!DOCTYPE html>
<html lang="en">
    <title>Error Page</title>
    <?php
    $this->load->view('include/headcss');
    ?>
    <style>
        .alert-callout.alert-info.pink::before {
            background: #F52887 none repeat scroll 0 0;
        }
    </style>
    <body class="menubar-hoverable header-fixed ">
        <?php $this->load->view('include/header'); ?>
        <div id="content">
            <!-- BEGIN BLANK SECTION -->
            <section>
                <div class="section-body contain-lg">
                    <div class="row">			
                        <div class="col-lg-12 text-center">
                            <h1><span class="text-xxxl text-light">500 <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
                            <h2 class="text-light">Oops! Something went wrong</h2>
                        </div><!--end .col -->
                    </div><!--end .row -->
                </div><!--end .section-body -->
            </section>
            <!-- BEGIN BLANK SECTION -->

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
                <?php $this->load->view('include/menu'); ?>
            </div>
        </div>
        <?php
        $this->load->view('include/headjs');
        ?>
