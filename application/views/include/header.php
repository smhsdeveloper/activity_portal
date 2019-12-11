<?php
$deo_staff_name = $this->session->userdata('deo_staff_name');
?>
<header id="header" >
    <div class="headerbar">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="headerbar-left">
            <ul class="header-nav haeader-nav-options">

                <li>
                    <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
                <li class="header-nav-brand" >
                    <div class="brand-holder">
                        <a href="javascript:void(0);">
                       <span class="text-lg text-bold text-info"><img style="width: 100px;height: 50px" src="<?php echo base_url() .$this->session->userdata('brand_logo') ?>"/> ||  <?php echo $this->session->userdata('brand_name') != false ? $this->session->userdata('brand_name') : "" ?></span>  </a>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="headerbar-right">
            <ul class="header-nav header-nav-options">
                <?php if ($deo_staff_name != 'NA') { ?>
                    <li>
                        <h4 class="text-danger">Welcome! <a href="<?php echo base_url(); ?>index.php/staff/deo"><?php echo $deo_staff_name; ?> </a></h4>
                    </li>
                <?php } ?>
                <li>
                    <!-- Search form -->
                    <form class="navbar-search" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" name="headerSearch" placeholder="Enter your keyword">
                        </div>
                        <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                    </form>
                </li>
                <li class="dropdown hidden-xs">
                    <a href="javascript:void(0);" class="btn btn-icon-toggle btn-default" data-toggle="dropdown">
                        <i class="fa fa-bell"></i><sup class="badge style-danger"></sup>
                    </a>
                    <ul class="dropdown-menu animation-expand">
                        <li class="dropdown-header">Today's messages</li>
                        <!--                        <li>
                                                    <a class="alert alert-callout alert-warning" href="javascript:void(0);">
                                                        <img class="pull-right img-circle dropdown-avatar" src="<?php echo base_url(); ?>assets/img/modules/materialadmin/avatar2666b.jpg?1422538624" alt="" />
                                                        <strong>Alex Anistor</strong><br/>
                                                        <small>Testing functionality...</small>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="alert alert-callout alert-info" href="javascript:void(0);">
                                                        <img class="pull-right img-circle dropdown-avatar" src="<?php echo base_url(); ?>assets/img/modules/materialadmin/avatar3666b.jpg?1422538624" alt="" />
                                                        <strong>Alicia Adell</strong><br/>
                                                        <small>Reviewing last changes...</small>
                                                    </a>
                                                </li>
                                                <li class="dropdown-header">Options</li>
                                                <li><a href="../pages/login.html">View all messages <span class="pull-right"><i class="fa fa-arrow-right"></i></span></a></li>
                                                <li><a href="../pages/login.html">Mark as read <span class="pull-right"><i class="fa fa-arrow-right"></i></span></a></li>-->
                    </ul><!--end .dropdown-menu -->
                </li><!--end .dropdown -->

            </ul><!--end .header-nav-options -->
            <ul class="header-nav header-nav-profile">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                        <img src="<?php echo base_url() . "/index.php/staff/getphoto/" . $this->session->userdata('staff_id') . "/full"; ?>" alt="" />
                        <span class="profile-info">
                            <?php echo $this->session->userdata('staff_name'); ?>
                            <?php echo $this->session->userdata('is_staff_classteacher') != false ? "<small>Class teacher[" . $this->session->userdata('staff_classteacher_class') . "]</small>" : "" ?>

                        </span>
                    </a>
                    <ul class="dropdown-menu animation-dock">
                        <!--<li class="dropdown-header">Config</li>-->
                        <li><a href="#"><span class="badge style-danger pull-right">80%</span>My Profile</a></li>
                        <li><a href="#"><span class="badge style-danger pull-right">9</span>My Task</a></li>
                        <li><a href="#"><span class="badge style-danger pull-right">2</span>My Events</a></li>
                        <li class="divider"></li>

                        <li><a href="<?php echo site_url('login/resetpassword'); ?>"><i class="fa fa-key"></i>Reset Password</a></li>

                        <li class="divider"></li>

                        <li><a href="<?php echo site_url('login/logout'); ?>"><i class="fa fa-fw fa-power-off text-danger"></i> Logout</a></li>
                    </ul><!--end .dropdown-menu -->
                </li><!--end .dropdown -->
            </ul><!--end .header-nav-profile -->
            <!--            <ul class="header-nav header-nav-toggle">
                            <li>
                                <a class="btn btn-icon-toggle btn-default" href="#offcanvas-search" data-toggle="offcanvas" data-backdrop="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                </a>
                            </li>
                        </ul>end .header-nav-toggle -->
        </div><!--end #header-navbar-collapse -->
    </div>
</header>