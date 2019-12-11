
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
        <div id="content">
            <!-- BEGIN BLANK SECTION -->
            <section>
                <div class="section-body contain-lg">
                    <div class="row">			
                        <div class="col-lg-12 text-center">
                            <h1><span class="text-xxxl text-light">404 <i class="fa fa-search-minus text-primary"></i></span></h1>
                            <h2 class="text-light">This page does not exist</h2>
                        </div><!--end .col -->
                    </div><!--end .row -->
                </div><!--end .section-body -->
                <div class="section-body contain-sm">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="input-group">
                            <span class="input-group-btn"><a href="<?php echo base_url() . 'index.php/testing/company' ?>"><button class="btn btn-primary" type="submit">Back To Home </button></a></span>
                        </div>
                    </div>
                </div><!--end .section-body -->
            </section>
            <!-- BEGIN BLANK SECTION -->

        </div>
        <!-- END CONTENT -->
        <!-- BEGIN MENUBAR-->

        <?php
        $this->load->view('include/headjs');
        ?>
