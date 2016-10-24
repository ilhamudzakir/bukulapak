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
<div class="col-md-6">
   <form action="<?php echo site_url('front/proceedcart')?>" method="post">
   <div style="" class="radius-kotak">
   <div class="header-background">
    <div class="form-group">
      <h4><b>Lengkapi data berikut</b></h4>
    </div>
    </div>
    <div class="padding-20">
    <div class="form-group">
      <label class="blue">Nama Pembeli</label>
      <input type="text" class="form border" placeholder="Nama Lengkap" name="order_name" id="order_name">
      <?php echo form_error('order_name', '<div class="alert alert-error">', '</div>'); ?>
    </div>
    <div class="form-group">
    <div class="row">
      <div class="col-md-6">
        <label class="blue">Email</label>
        <input type="email" class="form border" name="order_email" id="order_email" placeholder="Alamat Email">
        <?php echo form_error('order_email', '<div class="alert alert-error">', '</div>'); ?>
      </div>
      <div class="col-md-6">
        <label class="blue">Telepon</label>
        <input type="text" class="form border" name="order_phone" id="order_phone" placeholder="Nomor Telepon">
        <?php echo form_error('order_phone', '<div class="alert alert-error">', '</div>'); ?>
      </div>
      </div>
    </div>
    </div>
    </div>
    <div style="" class="radius-kotak">
   <div class="header-background">
     <div class="form-group">
      <h4><b>Alamat Pengirim</b></h4>
    </div>
    </div>
    <div class="padding-20">
      <div class="form-group">
    <div class="row">
      <div class="col-md-6">
        <label class="blue">Nama Penerima</label>
        <input type="text" class="form border" name="order_recipient_name" id="order_recipient_name" placeholder="Nama Lengkap">
        <?php echo form_error('order_recipient_name', '<div class="alert alert-error">', '</div>'); ?>
      </div>
      <div class="col-md-6">
        <label class="blue">Telepon</label>
        <input type="text" class="form border" name="order_recipient_phone" id="order_recipient_phone" placeholder="No. Tlp">
        <?php echo form_error('order_recipient_phone', '<div class="alert alert-error">', '</div>'); ?>
      </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
      <div class="col-md-12"><label class="blue">Alamat</label></div>
        <div class="col-md-6">

          <textarea class="form" style="height:180px" placeholder="Alamat" name="order_recipient_address" id="order_recipient_address"></textarea>
          <?php echo form_error('order_recipient_address', '<div class="alert alert-error">', '</div>'); ?>
        </div>
        <div class="col-md-6">

          <select id="propinsi_id" class="form border arrow-sel" name="propinsi_id" style="width: 100%" onChange="getkabupaten()">
            <option value="">Pilih propinsi</option>
            <?php foreach ($propinsi as $key => $value) { ?>
              <option value="<?php echo $value['propinsi_id']; ?>" > <?php echo $value['title']; ?></option>
            <?php }?>
          </select>
          <?php echo form_error('propinsi_id', '<div class="alert alert-error">', '</div>'); ?>
          <select id="kabupaten_id" class="form border arrow-sel" name="kabupaten_id" style="width: 100%" onChange="getongkir(<?php echo $area_sales['area_id']; ?>)">
           <option value="">Pilih Kabupaten</option>
           <?php foreach ($kabupaten as $key => $value) { ?>
             <option value="<?php echo $value['kabupaten_id']; ?>" > <?php echo $value['title']; ?></option>
           <?php }?>
         </select>
         <?php echo form_error('kabupaten_id', '<div class="alert alert-error">', '</div>'); ?>
         <input type="text" placeholder="Kode Pos" class="form border" name="order_recipient_postcode" id="order_recipient_postcode">
         <?php echo form_error('order_recipient_postcode', '<div class="alert alert-error">', '</div>'); ?>
        </div>
        </div>
        </div>
      </div>
    </div>
   
</div>
<div class="col-md-6">
 <div class="kotak2">
  
  <?php $i = 1; ?>
  <?php $totalweight = 0; ?>
  
  <?php foreach($this->cart->contents() as $items): ?>
    <div class="col-md-12 lapak-list center">
      <div class="row">
        <input type="hidden" id="rowid" name="rowid" value="<?php echo $items['rowid']?>">
        <input type="hidden" id="id_<?php echo $items['rowid']?>" name="id_<?php echo $items['rowid']?>" value="<?php echo $items['id']?>">
        <input type="hidden" id="name_<?php echo $items['rowid']?>" name="name_<?php echo $items['rowid']?>" value="<?php echo $items['name']?>">
        <input type="hidden" id="berat_<?php echo $items['rowid']?>" name="berat_<?php echo $items['rowid']?>" value="<?php echo $items['weight']?>">
        <div class="col-md-3">
          <img class="float-l" src="http://placehold.it/80x100" width="80px">
        </div>
        <div class="col-md-6">
            <div class="float-l">
              <h4><?php echo $items['name']?></h4>

              <div class="width-seratus">
                <?php echo form_dropdown('qty_'.$items['rowid'], array('1'=>'1 Buku','2'=>'2 Buku','3'=>'3 Buku','4'=>'4 Buku','5'=>'5 Buku'),$items['qty'],'id="qty_'.$items['rowid'].'" class="form arrow-sel" onChange="updatecart(\''.$items['rowid'].'\')"');?>
              </div>
            </div>
          <div class="clearfix"></div>
        </div>
        <div class="col-md-3">
          <h4 class="price-list" id="price_<?php echo $items['rowid']?>">RP <?php echo number_format($items['subtotal'])?></h4>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>     
  <?php $totalweight += ($items['weight']); ?>
<?php endforeach; ?>

<div class="lapak-list ">
  <div class="row">
    <div class="col-md-6">
      <h4 class="grey">Area Pengiriman</h4>
    </div>
    <div class="col-md-6 text-right">
      <h4 class="grey"><?php echo $area_sales['area_title']; ?></h4>
      <input type="hidden" id="sales_id" name="sales_id" value="<?php echo $area_sales['area_id']; ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <h4 class="grey">Ongkos Kirim</h4>
    </div>
    <div class="col-md-6 text-right">
      <h4 class="price-list grey" id="ongkir">RP. <?php echo number_format($this->session->userdata('ongkir'))?></h4>
    </div>
  </div>
  <div class="clearfix"></div>
</div>

    <div class="text-right">
      <input type="hidden" id="totalongkir" name="totalongkir" value="0">
      <?php $totalsemua = $this->cart->total() + $this->session->userdata('ongkir');?>
      <input type="hidden" id="totalsemua" name="totalsemua" value="<?php echo $totalsemua; ?>">
      <?php $totalweight = $totalweight; if($totalweight < 1) $totalweight = 1; ?>
      <input type="hidden" id="total_weight" name="total_weight" value="<?php echo $totalweight; ?>">
      <h2 class="price-list" id="price_total">RP. <?php echo number_format($totalsemua,0,',','.'); ?></h2>
    </div>
    <div>
      <div class="col-md-8">
        <h3>
          <a href="<?php echo $this->session->userdata('url_sekolah_terakhir'); ?>" id="caribukulain">
            <b>Cari buku lainnya</b>
          </a>
        </h3>
      </div>
      <div class="col-md-4 padding-none text-right">
        <input type="submit" class="form btn2 large" value="Bayar Sekarang" name="submit">
      </div>
      <div class="clearfix"></div>
    </div>
   </div>
</div>
</form>
</div>
</section>