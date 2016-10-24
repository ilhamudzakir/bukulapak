<div class="page-content">
    <div class="content">
        <div class="page-title">   		
			<h1><?php echo lang('deactivate_heading');?></h1>
		</div>
		<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>

		<?php echo form_open("users_groups/deactivate/".$user->id."/".$this->uri->segment(4)."/".$this->uri->segment(5));?>

		    <p>
		        <?php echo lang('deactivate_confirm_y_label', 'confirm');?>
		        <input type="radio" name="confirm" value="yes" checked="checked" />
		        <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
		        <input type="radio" name="confirm" value="no" />
		    </p>

		    <?php echo form_hidden($csrf); ?>
		    <?php echo form_hidden(array('id'=>$user->id)); ?>

		    <p><?php echo bs_form_submit('submit', lang('deactivate_submit_btn'));?></p>

		<?php echo form_close();?>
	</div>
</div>