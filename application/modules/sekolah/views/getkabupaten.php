<select id="kabupaten_id" name="kabupaten_id">
	<?php if($kabupaten->num_rows() > 0) { ?>
			<option value="0">Pilih Kabupaten</option>
		<?php foreach($kabupaten->result_array() as $key=>$value) { ?>
			<option value="<?php echo $value['kabupaten_id']?>"><?php echo $value['title']?></option>
		<?php } ?>
	<?php } ?>
</select>