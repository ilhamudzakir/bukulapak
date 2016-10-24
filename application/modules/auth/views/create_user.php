<div class="page-content">
    <div class="content">
        <div class="grid simple">
            <div class="grid-title">
                <h1><?php echo lang('create_user_heading');?></h1>
            </div>
            <div class="grid-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                        <div <?php ( ! empty($message)) && print('class="alert alert-danger"'); ?> id="infoMessage"><?php echo $message;?></div>
                    </div>

                    <?php echo form_open("auth/create_user");?>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">

                                <p>
                                    <?php echo lang('create_user_nik_label', 'nik');?> <br />
                                    <?php echo bs_form_input($nik);?>
                                </p>

                                <p>
                                    <?php echo lang('create_user_fname_label', 'first_name');?> <br />
                                    <?php echo bs_form_input($first_name);?>
                                </p>

                                <p>
                                    <?php echo lang('create_user_lname_label', 'last_name');?> <br />
                                    <?php echo bs_form_input($last_name);?>
                                </p>

                                <p>
                                    <?php echo lang('create_user_email_label', 'email');?> <br />
                                    <?php echo bs_form_input($email);?>
                                </p>

                               
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
                                <p>
                                    <?php echo lang('create_user_phone_label', 'phone');?> <br />
                                    <?php echo bs_form_input($phone);?>
                                </p>

                                <p>
                                    <?php echo 'Area';?> <br />
                                    <select id="area_id" name="area_id" style="width: 100%">
                                    <option value="0">Pilih Area</option>
                                    <?php foreach ($area as $key => $value) { ?>
                                        <?php $selected = ($value['id'] == $area_id) ? 'selected="selected"' : '' ;?>
                                      <option value="<?php echo $value['id']; ?>" <?php echo $selected; ?>><?php echo $value['title']; ?></option>
                                    <?php }?>
                                  </select>
                                </p>

                                <p>
                                    <?php echo lang('create_user_password_label', 'password');?> <br />
                                    <?php echo bs_form_input($password);?>
                                </p>

                                <p>
                                    <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
                                    <?php echo bs_form_input($password_confirm);?>
                                </p>

				
                   </div>
				   <div class="col-md-12">
				   								 <?php if ($this->ion_auth->is_admin()): ?>



                                    <h3><?php echo lang('edit_user_groups_heading');?></h3>
                                    <!-- <div class="checkbox check-success  ">
                                      <input id="checkbox2" type="checkbox" value="1" checked="checked">
                                      <label for="checkbox2">I agree</label>
                                    </div>
                                    <div class="checkbox check-success  ">
                                      <input id="checkbox1" type="checkbox" value="2" >
                                      <label for="checkbox1">Not agree</label>
                                    </div> -->
                                    <?php foreach ($groups as $group):?>
                                    
                                    
                                    <div class="checkbox check-success  ">
                                      <input id="checkbox<?php echo $group['id'];?>" type="checkbox" value="<?php echo $group['id'];?>"  name="groups[]">
                                      <label for="checkbox<?php echo $group['id'];?>"> <?php echo $group['name'];?></label>
                                    </div>
                                    <!-- <div class="checkbox check-success  ">
                                      <input id="checkbox1" type="checkbox" value="2" >
                                      <label for="checkbox1">Not agree</label>
                                    </div> -->
                                    <!-- <div class="checkbox check-success">
                                        <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>" <?php echo $checked;?> id="checkbox<?php echo $gID;?>">    
                                        <label class="checkbox<?php echo $gID;?>"> <?php echo $group['name'];?></label>
                                    </div> -->
                                    <?php endforeach?>

                                <?php endif ?></div>
				   <div class="col-md-12">             <p><?php echo bs_form_submit('submit', lang('create_user_submit_btn')).'&nbsp;&nbsp;'.anchor("auth", 'Cancel', array('class'=>'btn btn-danger'));?></p>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>
