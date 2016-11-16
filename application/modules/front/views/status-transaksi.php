<section>
<div class="title2">
  <div class="container">
   <div class="col-md-6 pull-left padding-botop"><h3>Status Transaksi</h3>
      <input type="hidden" id="base_url" name="base_url" value="<?php echo base_url()?>">
    </div>
  </div>
</div>
</section>
<section class="matobot">
<div  class="container">
  <div class="col-md-5 center">
    <div class="row"><?php if(isset($_GET['no_trans'])){ ?>
    <div class="col-m-12 alert alert-info">Selamat, anda telah berhasil melakukan konfirmasi pembayaran</div>
    <?php } ?>
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12 padding-none">
            <input type="text" placeholder="Masukan Nomor Transaksi" value="<?php if(isset($_GET['no_trans'])){ echo $_GET['no_trans']; } ?>" name="confirmation_code" id="confirmation_code" class="form medium">
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <input type="button" value="cek" class="form btn2 medium" name="submit" onClick="cektransaksi()">
          </div>
        </div>
      </div>
    </div>
  </div>
<div id="loading" style="display:none">
  <div class="row">
    <div class="col-md-12 text-center">
        <i class="fa fa-cog fa-spin"></i> Loading
    </div>
  </div>
</div>
<div id="statustransaksi">
<?php
if(isset($_GET['no_trans'])){
  echo $item;
}

?>
</div>

 </div>
  </div> 
</section>

<div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Masukan Email order anda untuk validasi</h4>
      </div>
      <div class="modal-body form">
        
        
        <div class="row">
       
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12 padding-none">
            <input placeholder="Masukan Email" name="email" id="email_order" class="form medium" type="text">
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <input value="cek" class="form btn2 medium" name="submit" onclick="cek_diterima()" type="button">
          </div>
        </div>
      </div>
      
      <div class="col-md-12" id="validasi_email" style="display: none">
        <div class="row" style="">
        <div class="alert alert-error">Email yang anda masukan tidak sama dengan email order anda</div>
          
        </div>
      </div>
      
    </div>
        
      </div>
    </div>
  </div>
</div>
