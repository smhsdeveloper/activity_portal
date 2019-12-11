
<header id="header" >
    <div class="headerbar">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="headerbar-left">
            <ul class="header-nav header-nav-options">

                <li>
                    <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
                <li class="header-nav-brand" >
                    <div class="brand-holder">
                    </div>
                </li>
            </ul>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="headerbar-right">
            <!--            <ul class="header-nav header-nav-options">
                            <li>
                                 Search form 
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
                                                            <li>
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
                                                            <li><a href="../pages/login.html">Mark as read <span class="pull-right"><i class="fa fa-arrow-right"></i></span></a></li>
                                </ul>end .dropdown-menu 
                            </li>end .dropdown 
            
                        </ul>end .header-nav-options -->
            <ul class="header-nav header-nav-profile">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                        <img src="<?php echo base_url() . "assets/img/default.png" ?>" alt="" />
                        <span class="profile-info">
                            <b><?php echo $this->session->userdata('company_staff_name'); ?>
                                (<?php echo $this->session->userdata('company_staff_designation'); ?>)</b>
                        </span>
                    </a>
                    <ul class="dropdown-menu animation-dock">
                        <li><a href="javascript:void(0);"><span class="badge style-danger pull-right"></span>My Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url();?>index.php/login/resetpassword"><i class="fa fa-fw fa-key text-primary"></i>Change Password</a></li>
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