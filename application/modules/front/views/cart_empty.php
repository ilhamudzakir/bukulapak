<?php $area_sales = GetAreaSales($this->session->userdata('sales_id')); ?>
<section>
<div class="title2">
     <div class="container">
          <div class="col-md-6 pull-left padding-botop"><h3>Keranjang Belanja</h3>
          </div>
         
     </div>
</div>
</section>
<section class="matobot">
	<div class="container">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
      <h4>Keranjang belanja kosong</h4>
      <p>Silakan melakukan pembelian terlebih dahulu. Terima kasih.</p>
      <p><a href="<?php echo site_url('front')?>" class="btn btn-info">Kembali</a></p>
    </div>

  </div>
</section>