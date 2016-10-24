<!-- BEGIN HEADER -->
    <div class="header navbar navbar-inverse">
      <!-- BEGIN TOP NAVIGATION BAR -->
      <div class="navbar-inner">
        <!-- BEGIN NAVIGATION HEADER -->
        <div class="header-seperation">
          <!-- BEGIN MOBILE HEADER -->
          <ul class="nav pull-left notifcation-center visible-xs visible-sm">
            <li class="dropdown">
              <a href="#main-menu" data-webarch="toggle-left-side">
                <div class="iconset top-menu-toggle-white"></div>
              </a>
            </li>
          </ul>
          <!-- END MOBILE HEADER -->
          <!-- BEGIN LOGO -->
          <a href="<?php echo site_url()?>">
            <img src="<?php echo base_url(); ?>assets/front/images/logo.png" class="logo" alt="" data-src="<?php echo base_url(); ?>assets/front/images/logo.png" data-src-retina="<?php echo base_url(); ?>assets/front/images/logo.png" width="106" height="21" />
          </a>
          <!-- END LOGO -->
          <!-- BEGIN LOGO NAV BUTTONS -->
          <ul class="nav pull-right notifcation-center">
            <li class="dropdown hidden-xs hidden-sm">
              <a href="<?php echo base_url();echo $this->uri->segment(1) ?>" class="dropdown-toggle active" data-toggle="">
                <div class="iconset top-home"></div>
              </a>
            </li>
            <li class="dropdown visible-xs visible-sm">
              <a href="#" data-webarch="toggle-right-side">
                <div class="iconset top-chat-white "></div>
              </a>
            </li>
          </ul>
          <!-- END LOGO NAV BUTTONS -->
        </div>
        <!-- END NAVIGATION HEADER -->
        <!-- BEGIN CONTENT HEADER -->
        <div class="header-quick-nav">
          <!-- BEGIN HEADER LEFT SIDE SECTION -->
          <div class="pull-left">
            <!-- BEGIN SLIM NAVIGATION TOGGLE -->
            <ul class="nav quick-section">
              <li class="quicklinks">
                <a href="#" class="" id="layout-condensed-toggle">
                  <div class="iconset top-menu-toggle-dark"></div>
                </a>
              </li>
            </ul>
            <!-- END SLIM NAVIGATION TOGGLE -->
            <!-- BEGIN HEADER QUICK LINKS -->
            <ul class="nav quick-section">
              <!-- BEGIN SEARCH BOX -->
              <!--<li class="m-r-10 input-prepend inside search-form no-boarder">
                <span class="add-on"><span class="iconset top-search"></span></span>
                <input name="" type="text" class="no-boarder" placeholder="Search Dashboard" style="width:250px;">
              </li>-->
              <!-- END SEARCH BOX -->
            </ul>
            <!-- BEGIN HEADER QUICK LINKS -->
          </div>
          <!-- END HEADER LEFT SIDE SECTION -->
          <!-- BEGIN HEADER RIGHT SIDE SECTION -->
          <div class="pull-right">
            <div class="chat-toggler">
              <!-- BEGIN NOTIFICATION CENTER -->
              <a href="#" class="dropdown-toggle" id="my-task-list" data-placement="bottom" data-content="" data-toggle="dropdown" data-original-title="Profile">
                <div class="user-details">
                  <div class="username">
                    &nbsp;<?php echo ucwords(GetUserNameLogin());?></span>
                  </div>
                </div>
                <div class="iconset top-down-arrow"></div>
              </a>
              <div id="notification-list" style="display:none">
                <div style="width:300px">
                  <!-- BEGIN NOTIFICATION MESSAGE -->
                  <!--<div class="notification-messages info">
                    <div class="user-profile">
                      <img src="assets/img/profiles/d.jpg" alt="" data-src="assets/img/profiles/d.jpg" data-src-retina="assets/img/profiles/d2x.jpg" width="35" height="35">
                    </div>
                    <div class="message-wrapper">
                      <div class="heading">Title of Notification</div>
                      <div class="description">Description...</div>
                      <div class="date pull-left">A min ago</div>
                    </div>
                    <div class="clearfix"></div>
                  </div> -->
                  <!-- END NOTIFICATION MESSAGE -->
                </div>
              </div>
              <!-- END NOTIFICATION CENTER -->
              <!-- BEGIN PROFILE PICTURE -->
              <div class="profile-pic">
                <img src="<?php echo base_url(); ?>assets/img/profiles/avatar_small.jpg" alt="" data-src="<?php echo base_url(); ?>assets/img/profiles/avatar_small.jpg" data-src-retina="<?php echo base_url(); ?>assets/img/profiles/avatar_small2x.jpg" width="35" height="35" />
              </div>
              <!-- END PROFILE PICTURE -->
            </div>
            <!-- BEGIN HEADER NAV BUTTONS -->
            <ul class="nav quick-section">
              <!-- BEGIN SETTINGS -->
              <li class="quicklinks">
                <a data-toggle="dropdown" class="dropdown-toggle pull-right" href="#" id="user-options">
                  <div class="iconset top-settings-dark"></div>
                </a>
                <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="user-options">
                  <!-- <li><a href="#">Normal Link</a></li>
                  <li><a href="#">Badge Link&nbsp;&nbsp;<span class="badge badge-important animated bounceIn">2</span></a></li>
                  <li class="divider"></li> -->
                  <li><a href="<?php echo site_url('auth/logout'); ?>"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Logout</a></li>
                </ul>
              </li>
              <!-- END SETTINGS -->
              <!-- <li class="quicklinks"><span class="h-seperate"></span></li> -->
              
            </ul>
            <!-- END HEADER NAV BUTTONS -->
          </div>
          <!-- END HEADER RIGHT SIDE SECTION -->
        </div>
        <!-- END CONTENT HEADER -->
      </div>
      <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->


    



<!-- <header class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="<?php echo site_url(); ?>" class="navbar-brand">CodeIgniter Skeleton</a>
        </div>
        <nav class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo site_url(); ?>">Home</a></li>
                <li><a href="<?php echo site_url('addons'); ?>">Add-ons</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Example <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url('todo'); ?>">Todo</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a target="_blank" href="https://github.com/anvoz/CodeIgniter-Skeleton">Github</a></li>
            </ul>
        </nav>
    </div>
</header> -->