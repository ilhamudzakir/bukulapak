<div class="page-content">
    <div class="content">
    	<div class="grid simple">
	        <div class="grid-title">   		
				<h1><?php echo lang('deactivate_heading');?></h1>
			</div>
			<div class="grid-body">
						<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>

						<?php echo form_open("auth/deactivate/".$user->id);?>

						    <p>
						        <?php //echo lang('deactivate_confirm_y_label', 'confirm');?>
						        <label><input type="radio" name="confirm" value="yes" checked="checked" /> Yes</label>
						        
						        <?php //echo lang('deactivate_confirm_n_label', 'confirm');?>
						        <label><input type="radio" name="confirm" value="no" /> No</label>
						    </p>

						    <?php echo form_hidden($csrf); ?>
						    <?php echo form_hidden(array('id'=>$user->id)); ?>

						    <p><?php echo bs_form_submit('submit', lang('deactivate_submit_btn'));?></p>

						<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>