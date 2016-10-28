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
			  <h5 style="color:white;font-weight:bold"><?php if($this->ion_auth->is_admin_area()) {
			
			?> Area :  <?php echo $this->session->userdata('area'); }?></h5>
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
                    <li><a href="<?php echo site_url('buku'); ?>"><i class="fa fa-book"></i> Buku</a></li>
                    <li><a href="<?php echo site_url('area'); ?>"><i class="fa fa-map"></i> Area</a></li>
                    <li><a href="<?php echo site_url('area_shipping'); ?>"><i class="fa fa-truck"></i> Ongkos kirim</a></li>
                  </ul>
                </li>
                <li class="start active">
                  <a href="<?php echo site_url('order')?>">
                    <span class="title">Order</span>
                  </a>
                </li>

                <li class="start active">
                  <a href="<?php echo site_url('static_page')?>">
                    <span class="title">Static Page</span>
                  </a>
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
                <span class="title">Seller Panel</span>
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
                  <!-- <a href="#" data-target="auth" id="pageauth"><i class="fa fa-users"></i> <span class="title">Users</span></a> -->  
                </li>
                <li>
                  <a href="<?php echo site_url('lapak'); ?>"><i class="fa fa-book"></i> <span class="title">Lapak</span></a>  
                </li>
                <li>
                  <a href="<?php echo site_url('order'); ?>"><i class="fa fa-book"></i> <span class="title">Order</span></a>  
                </li>
                <li>
                  <a href="javascript:;"><i class="fa fa-bars"></i> <span class="title">Master</span><span class="arrow "></span></a>
                  <ul class="sub-menu">
                   <li><a href="<?php echo site_url('area_shipping'); ?>"><i class="fa fa-truck"></i> Ongkos kirim</a></li>
                    <li><a href="<?php echo site_url('sekolah'); ?>"><i class="fa fa-bell"></i> Sekolah</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <?php } ?>
            <!-- BEGIN TWO LEVEL MENU -->
            <?php if($this->ion_auth->is_agen()) {?>
            <li class="">
              <a href="javascript:;">
                <i class="fa fa-folder-open"></i>
                <span class="title">Agen Panel</span>
                <span class="arrow"></span>
              </a>
              <ul class="sub-menu">
                <li>
                  <a href="<?php echo site_url('lapak'); ?>"><i class="fa fa-book"></i> <span class="title">Lapak</span></a>  
                </li>
              </ul>
            </li>
            <?php } ?>
            <li><a href="#">Rendered page in <?php echo $this->benchmark->elapsed_time()?> s</a></li>
          </ul>
          <!-- END SIDEBAR MENU -->
        </div>
      </div>
      <!-- BEGIN SCROLL UP HOVER -->
      <a href="#" class="scrollup">Scroll</a>
      <!-- END SCROLL UP HOVER -->
      <!-- END MENU -->
      
      <!-- END SIDEBAR -->