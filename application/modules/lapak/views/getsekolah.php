<select id="sekolah_id" name="sekolah_id">
	<?php if($sekolah->num_rows() > 0) { ?>
		<?php foreach($sekolah->result_array() as $key=>$value) { ?>
			<option value="<?php echo $value['id']?>"><?php echo $value['title']?></option>
		<?php } ?>
	<?php } ?>
</select>