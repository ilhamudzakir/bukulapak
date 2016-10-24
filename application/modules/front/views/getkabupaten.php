<select id="kabupaten_id" class="form arrow-sel" name="kabupaten_id" style="width: 100%" onChange="getsekolah()">
	<option value="0">Pilih Kabupaten</option>
	<?php if($kabupaten->num_rows() > 0) { ?>
		<?php foreach($kabupaten->result_array() as $key=>$value) { ?>
			<option value="<?php echo $value['kabupaten_id']?>"><?php echo $value['title']?></option>
		<?php } ?>
	<?php } ?>
</select>