<div class="page-content">
<input type="hidden" id="controller_name" name="controller_name" value="<?php echo base_url() ?>users_groups/">
    <div class="content">
        <div class="grid simple">
            <div class="grid-title">
                <h1><?php echo lang('create_user_heading');?> Sales</h1>
            </div>
            <div class="grid-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                        <div class="alert alert-info">
                            INFO :
                            <ol>
                                <li>Semua kolom bertanda * wajib diisi</li>
                                <li>Tekan tombol generate password sebelum melakukan penyimpanan</li>
                                <li>Informasi username dan password dibawah akan terkirim melalui email setelah berhasil melakukan penyimpanan</li>
                            </ol>
                        </div>
                        <div <?php ( ! empty($message)) && print('class="alert alert-danger"'); ?> id="infoMessage"><?php echo $message;?></div>
                    </div>           
                        <?php echo form_open("users_groups/create_user/".$this->uri->segment(3));?>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">

                                <p>
                                    <?php echo lang('create_user_nik_label', 'nik');?> <br />
                                    <select onchange="nik_change()" name="nik" id="nik" style="width:100%">
                                    <option value="">Select NIK</option>   
                                    <?php foreach ($employe as $nik) {
                                    ?>
                                    <option value="<?php echo $nik->nik ?>"><?php echo $nik->nik ?></option>
                                    <?php } ?>
                                    </select>
                                </p>

                                <p>
                                    <?php echo lang('create_user_fname_label', 'first_name');?> <br />
                                    <?php echo bs_form_input($first_name);?>
                                </p>

                                <p>
                                    <?php echo lang('create_user_lname_label', 'last_name');?> <br />
                                    <?php echo bs_form_input($last_name);?>
                                </p>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
                                <p>
                                    <?php echo lang('create_user_email_label', 'email');?> <br />
                                    <?php echo bs_form_input($email);?>
                                </p>

                                <p>
                                    <?php echo lang('create_user_phone_label', 'phone');?> <br />
                                    <?php echo bs_form_input($phone);?>
                                </p>

                                <p>
                                    <?php echo lang('create_user_password_label', 'password');?> <br />
                                    <?php echo bs_form_input($password);?>
                                    <?php echo bs_form_button($gen_password,'Generate Password');?>
                                    
                                </p>

                                <p>
                                    <?php echo bs_form_input($group_id);?>
                                    <?php echo bs_form_submit('submit', lang('create_user_submit_btn')).'&nbsp;&nbsp;'.anchor("users_groups/sales_area", 'Cancel', array('class'=>'btn btn-danger'));?>
                                    

                                </p>
                            </div>
                            </div>
                            <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>
