<select id="kecamatan_id" class="form arrow-sel" name="kecamatan_id" style="width: 100%" onChange="getsekolah()">
	<option value="0">Pilih Kecamatan</option>
	<?php if($kecamatan->num_rows() > 0) { ?>
		<?php foreach($kecamatan->result_array() as $key=>$value) { ?>
			<option value="<?php echo $value['kecamatan_id']?>"><?php echo $value['title']?></option>
		<?php } ?>
	<?php } ?>
</select>