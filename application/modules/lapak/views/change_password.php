<div class="page-content">
    <div class="content">
        <div class="grid simple">
            <div class="grid-title">   
                <h1><?php echo lang('change_password_heading');?></h1>
            </div>
            <div class="grid-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                        <div <?php ( ! empty($message)) && print('class="alert alert-danger"'); ?> id="infoMessage"><?php echo $message;?></div>
                    </div>

                    <?php echo form_open("lapak/change_password");?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <p>
                                <?php echo lang('change_password_old_password_label', 'old_password');?> <br />
                                <?php echo bs_form_input($old_password);?>
                                </p>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <p>
                                <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> <br />
                                <?php echo bs_form_input($new_password);?>
                                </p>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <p>
                                <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> <br />
                                <?php echo bs_form_input($new_password_confirm);?>
                                </p>
                            </div>

                            <?php echo form_input($user_id);?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                </p>
                                    <?php echo bs_form_submit('submit', lang('change_password_submit_btn'));?>
                                    <a href="<?php echo site_url('lapak')?>">
                                        <button class="btn btn-danger" value="Cancel" type="button">Cancel</button>
                                    </a>
                                </p>
                                </div>
                        </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>
