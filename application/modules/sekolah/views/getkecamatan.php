<select id="kecamatan_id" name="kecamatan_id">
	<?php if($kecamatan->num_rows() > 0) { ?>
			<option value="0">Pilih Kecamatan</option>
		<?php foreach($kecamatan->result_array() as $key=>$value) { ?>
			<option value="<?php echo $value['kecamatan_id']?>"><?php echo $value['title']?></option>
		<?php } ?>
	<?php } ?>
</select>