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
    <div class="row">
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12 padding-none">
            <input type="text" placeholder="Masukan Nomor Transaksi" name="confirmation_code" id="confirmation_code" class="form medium">
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
</div>
<div id="loading" style="display:none">
  <div class="row">
    <div class="col-md-12 text-center">
        <i class="fa fa-cog fa-spin"></i> Loading
    </div>
  </div>
</div>
<div id="statustransaksi">
  <!-- <div class="center text-center">
    <h4>Detail dan Status Transaksi Nomor 7627367</h4>    
  </div>
  <div class="col-md-7 center" style="padding:0px; top:-5px;">
    <div class="kotak-bullet">
      <div class="bullet bullet-left">&#10004</div>
      Order
    </div>
    <div class="kotak-bullet">
      <div class="bullet bullet-left">&#10004</div>
      Konfirmasi Pembayaran
    </div>
    <div class="kotak-bullet">
      <div class="bullet bullet-left">&#10004</div>
      Pembayaran Diterima
    </div>
    <div class="kotak-bullet">
      <div class="bullet bullet-left">&#10004</div>
      Pesan Diproses
    </div>
    <div class="kotak-bullet">
      <div class="bullet bullet-left">&#10004</div>
      Barang Dirikirim
    </div>
    <div class="kotak-bullet kotak-w-n">
      <div class="bullet bullet-left">&#10004</div>
      Barang Diterima
    </div>    
  </div>

  <div class="col-md-6 center">
    <div class="col-md-12  martop2" style="border-top:1px solid grey; padding: 20px 0px;">
      <div class="col-md-3 text-center">
        <img src="assets/front/images/book.jpg" width="70px">
      </div>
      <div class="col-md-6">
        <h5><b>Judul Buku</b></h5>
        <h5><b>1 Pcs</b></h5>
      </div>
      <div class="col-md-3">
        <h5><b>45.000</b></h5>
      </div>
    </div>

    <div class="col-md-12" style="border-top:1px solid grey; padding: 20px 0px;">
      <div class="col-md-3 text-center">
        <img src="assets/front/images/book.jpg" width="70px">
      </div>
      <div class="col-md-6">
        <h5><b>Judul Buku</b></h5>
        <h5><b>1 Pcs</b></h5>
      </div>
      <div class="col-md-3">
        <h5><b>45.000</b></h5>
      </div>
    </div>

    <div class="col-md-12" style="border-top:1px solid grey; border-bottom:1px solid grey; padding:20px 0px">
      <div class="col-md-9 text-center"><b>Ongkos Kirim</b></div>
      <div class="col-md-3"><b>Gratis</b></div>
    </div>
    <div class="col-md-12">
      <div class="col-md-9"></div>
      <div class="col-md-3"><h5><b>90.000</b></h5></div>
    </div>
  </div> -->
</div>

 <!--  </div>
  </div> -->
</section>