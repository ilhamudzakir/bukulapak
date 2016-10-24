<section>
<div class="title2">
     <div class="container">
          <div class="col-md-6 pull-left padding-botop"><h3>Konfirmasi Pembayaran</h3>
            <input type="hidden" id="base_url" name="base_url" value="<?php echo base_url()?>">
          </div>
         
     </div>
</div>
</section>
<section class="matobot">
	<div class="container">
<div class="col-md-6 center">
   <form action="" method="post" id="confirmation_upload" enctype="multipart/form-data">
    <div class="form-group marbot">
      <h4><b>Lengkapi data berikut</b></h4>
    </div>
    <?php //echo validation_errors(); ?>
    <div id="loading" style="display:none">
      <i class="fa fa-cog fa-spin"></i> Loading
    </div>
    <div id="validation_errors" class=""></div>
    <div class="form-group">
      <label class="grey">Nomor Transaksi</label>
      <input type="text" class="form border" name="confirmation_code" id="confirmation_code">
      <?php echo form_error('confirmation_code','<div class="alert alert-error">','</div>'); ?>

    </div>

    <div class="form-group">
      <label class="grey">Metode Pembayaran</label>
      <select class="form border arrow-sel" name="confirmation_method" id="confirmation_method">
        <option value="transfer">Transfer antar bank</option>
        <option value="setor">Setor tunai</option>
      </select>
      <?php echo form_error('confirmation_method','<div class="alert alert-error">','</div>'); ?>
    </div>
      <div class="form-group">
      <div class="row">
      <div class="col-md-6">
        <label class="grey">Nama Pengirim</label>
      <input type="text" class="form border" name="confirmation_name" id="confirmation_name">
      <?php echo form_error('confirmation_name','<div class="alert alert-error">','</div>'); ?>
      </div>
      <div class="col-md-6">
        <label class="grey">Nama Bank</label>
        <select class="form border arrow-sel" name="confirmation_bank" id="confirmation_bank">
                    <option value="mandiri">Bank Mandiri</option>
                    <option value="bca">BCA</option>
                    <option value="bni">BNI</option>
                    <option value="bri">BRI</option>
                    <option value="permata">Bank Permata</option>
                    <option value="cimb">CIMB Niaga</option>
                  </select>
                  <?php echo form_error('confirmation_bank','<div class="alert alert-error">','</div>'); ?>
      </div>
    </div>
    </div>

    <div class="form-group">
      <div class="row">
      <div class="col-md-6">
        <label class="grey">Unggah Bukti Transfer</label>
      <input type="file" class="form border" name="upload_file" id="upload_file">
      <?php //echo form_error('upload_file','<div class="alert alert-error">','</div>'); ?>
      </div>
     
    </div>
    </div>
    <div class="form-group">
    <div class="col-md-6 center">
      <input type="button" name="submit" value="Submit" class="form btn2 large" id="confirmation_submit" onClick="submit_confirmation()">
    </div>
      
    </div>

      </div>
    </div>
  </form>  
</div>

	</div><!----end container-------------->
</section>