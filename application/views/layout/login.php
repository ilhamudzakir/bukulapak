<style type="text/css">
     body{
          background:url("<?php echo base_url(); ?>assets/front/images/girls-back.jpg") no-repeat;
          background-size: 100%;
     }
</style>
<div class="container">
  <div class="row login-container column-seperation">
    <div class="col-md-5 col-md-offset-1" style="background-color: rgba(255,255,255,0.7); padding-bottom: 20px;">
      <h2>
        <?php echo lang('login_heading');?>
      </h2>
      <p><?php echo lang('login_subheading');?></p>
      <div <?php ( ! empty($message)) && print('class="alert alert-danger"'); ?> id="infoMessage"><?php echo $message;?></div>
      <?php echo form_open("auth/login");?>
      <!-- <form action="index.html" class="login-form validate" id="login-form" method="post" name="login-form"> -->
        <div class="row">
          <div class="form-group col-md-10">
            <?php echo lang('login_identity_label', 'identity');?>
            <?php echo bs_form_input($identity);?>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-10">
            <?php echo lang('login_password_label', 'password');?>
        <?php echo bs_form_input($password);?>
          </div>
        </div>
        <div class="row">
          <div class="control-group col-md-10">
            <div class="row">
              <div class="col-md-4">
                <?php echo lang('login_remember_label', 'remember');?>
              </div>
              <div class="col-md-6">
                <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
              </div>
            </div>
            <!-- <p><a href="auth/forgot_password" rel="async" ajaxify="<?php echo site_url('auth/auth_ajax/ion_auth_dialog/forgot_password'); ?>"><?php echo lang('login_forgot_password');?></a></p> -->
            
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-10">
            <?php echo bs_form_submit('submit', lang('login_submit_btn'));?>
          </div>
        </div>
      <?php echo form_close();?>
      
    </div>
  </div>
</div>