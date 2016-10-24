<!-- BEGIN SIDEBAR -->
      <!-- BEGIN MENU -->
      <div class="page-sidebar" id="main-menu">
        <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
          <!-- BEGIN MINI-PROFILE -->
          <div class="user-info-wrapper">
            <div class="profile-wrapper">
              <img src="<?php echo base_url(); ?>assets/img/profiles/avatar.jpg" alt="" data-src="<?php echo base_url(); ?>assets/img/profiles/avatar.jpg" data-src-retina="<?php echo base_url(); ?>assets/img/profiles/avatar2x.jpg" width="69" height="69" />
            </div>
            <div class="user-info">
              <div class="greeting">Welcome</div>
              <div class="username"><span class="semi-bold"><?php echo ucwords(GetUserNameLogin());?></span></div>
              <div class="status">Status
                <a href="#">
                  <div class="status-icon green"></div>Online</a>
              </div>
            </div>
          </div>
          <!-- END MINI-PROFILE -->
          <!-- BEGIN SIDEBAR MENU -->
          <p class="menu-title">BROWSE<span class="pull-right"></span></p>
          <ul>
            <!-- BEGIN SELECTED LINK -->
            <li class="start active">
              <a href="#">
                <i class="icon-custom-home"></i>
                <span class="title">Dashboard</span>
                <span class="selected"></span>
              </a>
            </li>
            <!-- BEGIN TWO LEVEL MENU -->
            <?php if($this->ion_auth->is_admin()) {?>
            <li class="">
              <a href="javascript:;">
                <i class="fa fa-folder-open"></i>
                <span class="title">Admin Panel</span>
                <span class="arrow"></span>
              </a>
              <ul class="sub-menu">
                <li>
                  <a href="javascript:;"><i class="fa fa-bars"></i> <span class="title">Master</span><span class="arrow "></span></a>
                  <ul class="sub-menu">
                    <li><a href="<?php echo site_url('auth'); ?>"><i class="fa fa-user"></i> Auth</a></li>
                    <li><a href="<?php echo site_url('groups'); ?>"><i class="fa fa-users"></i> Groups</a></li>
                  </ul>
                </li>
                <li>
                  <a href="javascript:;"><i class="fa fa-users"></i> <span class="title">Users</span><span class="arrow "></span></a>
                  <ul class="sub-menu">
                    <li><a href="<?php echo site_url('users_groups/admin'); ?>"><i class="fa fa-user"></i> Admin</a></li>
                    <li><a href="<?php echo site_url('users_groups/sales'); ?>"><i class="fa fa-user"></i> Sales</a></li>
                    <li><a href="<?php echo site_url('users_groups/agen'); ?>"><i class="fa fa-user"></i> Agen</a></li>
                  </ul>
                </li> 
                
              </ul>
            </li>
            <?php } ?>
            <!-- END TWO LEVEL MENU -->
            <!-- BEGIN TWO LEVEL MENU -->
            <?php if($this->ion_auth->is_sales()) {?>
            <li class="">
              <a href="javascript:;">
                <i class="fa fa-folder-open"></i>
                <span class="title">Sales Panel</span>
                <span class="arrow"></span>
              </a>
              <ul class="sub-menu">
                <li>
                  <a href="<?php echo site_url('lapak'); ?>"><i class="fa fa-home"></i> <span class="title">Lapak</span></a>  
                </li>
                <li>
                  <a href="<?php echo site_url('lapak/approve_atasan_1'); ?>"><i class="fa fa-home"></i> <span class="title">Approval Atasan 1</span></a>  
                </li>
                <li>
                  <a href="<?php echo site_url('lapak/approve_atasan_2'); ?>"><i class="fa fa-home"></i> <span class="title">Approval Atasan 2</span></a>  
                </li>
              </ul>
            </li>
            <?php } ?>
            <!-- END TWO LEVEL MENU -->
            <!-- BEGIN TWO LEVEL MENU -->
            <?php if($this->ion_auth->is_admin_area()) {?>
            <li class="">
              <a href="javascript:;">
                <i class="fa fa-folder-open"></i>
                <span class="title">Admin Area Panel</span>
                <span class="arrow"></span>
              </a>
              <ul class="sub-menu">
                <li>
                  <a href="<?php echo site_url('auth'); ?>"><i class="fa fa-users"></i> <span class="title">Users</span></a>  
                </li>
                <li>
                  <a href="<?php echo site_url('lapak'); ?>"><i class="fa fa-book"></i> <span class="title">Lapak</span></a>  
                </li>
                 
                
              </ul>
            </li>
            <?php } ?>
            <!-- END TWO LEVEL MENU -->
            <!-- END SELECTED LINK -->
            <!-- BEGIN BADGE LINK -->
            <li class="">
              <a href="#">
                <i class="fa fa-envelope"></i>
                <span class="title">Link 2</span>
              </a>
            </li>
            <!-- END BADGE LINK -->
            <!-- BEGIN SINGLE LINK -->
            <li class="">
              <a href="#">
                <i class="fa fa-flag"></i>
                <span class="title">Link 3</span>
              </a>
            </li>
            <!-- END SINGLE LINK -->
            <!-- BEGIN ONE LEVEL MENU -->
            <li class="">
              <a href="javascript:;">
                <i class="icon-custom-ui"></i>
                <span class="title">Link 4</span>
                <span class="arrow"></span>
              </a>
              <ul class="sub-menu">
                <li><a href="#">Sub Link 1</a></li>
              </ul>
            </li>
            <!-- END ONE LEVEL MENU -->
          </ul>
          <!-- END SIDEBAR MENU -->
          
        </div>
      </div>
      <!-- BEGIN SCROLL UP HOVER -->
      <a href="#" class="scrollup">Scroll</a>
      <!-- END SCROLL UP HOVER -->
      <!-- END MENU -->
      
      <!-- END SIDEBAR -->