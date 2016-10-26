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
      <input type="text" class="form border" placeholder="Nama Lengkap" name="order_name" id="order_name" value="<?php echo set_value('order_name'); ?>">
      <?php echo form_error('order_name', '<div class="alert alert-error">', '</div>'); ?>
    </div>
    <div class="form-group">
    <div class="row">
      <div class="col-md-6">
        <label class="blue">Email</label>
        <input type="email" class="form border" name="order_email" id="order_email" placeholder="Alamat Email" value="<?php echo set_value('order_email'); ?>">
        <?php echo form_error('order_email', '<div class="alert alert-error">', '</div>'); ?>
      </div>
      <div class="col-md-6">
        <label class="blue">Telepon</label>
        <input type="text" class="form border" name="order_phone" id="order_phone" placeholder="Nomor Telepon" value="<?php echo set_value('order_phone'); ?>">
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
      <div class="col-md-12">
      <input type="checkbox" name="same" onClick="copas()" id="copyname"> <label class="blue"> Samakan dengan data pembeli </label>
      </br></br>
      </div>
      </div>  
    <div class="row">
      <div class="col-md-6" id="namanya">
        <label class="blue">Nama Penerima</label>
        <input type="text" class="form border" name="order_recipient_name" id="order_recipient_name" placeholder="Nama Lengkap" value="<?php echo set_value('order_recipient_name'); ?>">
        <?php echo form_error('order_recipient_name', '<div class="alert alert-error">', '</div>'); ?>
      </div>
      <div class="col-md-6" id="tlpnya">
        <label class="blue">Telepon</label>
        <input type="text" class="form border" name="order_recipient_phone" id="order_recipient_phone" placeholder="No. Tlp" value="<?php echo set_value('order_recipient_phone'); ?>">
        <?php echo form_error('order_recipient_phone', '<div class="alert alert-error">', '</div>'); ?>
      </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
      <div class="col-md-12"><label class="blue">Alamat</label></div>
        <div class="col-md-6">

          <textarea class="form" style="height:180px" placeholder="Alamat" name="order_recipient_address" id="order_recipient_address"><?php echo set_value('order_recipient_address'); ?></textarea>
          <?php echo form_error('order_recipient_address', '<div class="alert alert-error">', '</div>'); ?>
          <input type="text" placeholder="Kode Pos" class="form border" name="order_recipient_postcode" id="order_recipient_postcode" value="<?php echo set_value('order_recipient_postcode'); ?>">
         <?php echo form_error('order_recipient_postcode', '<div class="alert alert-error">', '</div>'); ?>
        </div>
        <div class="col-md-6">

          <select id="propinsi_id" class="form border arrow-sel" name="propinsi_id" style="width: 100%" onChange="getkabupaten()">
            <option value="">Pilih propinsi</option>
            <?php foreach ($propinsi as $key => $value) { ?>
              <option  <?php if($this->session->flashdata('order_propinsi_id')== $value['propinsi_id']){ ?> selected <?php } ?> value="<?php echo $value['propinsi_id']; ?>" <?php echo set_select('propinsi_id',$value['propinsi_id']); ?> > <?php echo $value['title']; ?></option>
            <?php }?>
          </select>
          <?php echo form_error('propinsi_id', '<div class="alert alert-error">', '</div>'); ?>
          <div id="loading_kabupaten" style="display:none">
            <i class="fa fa-cog fa-spin"></i> Loading
          </div>
          <select id="kabupaten_id" class="form border arrow-sel" name="kabupaten_id" style="width: 100%" onChange="getkecamatan()">
           <?php if($this->session->flashdata('order_propinsi_id')){ ?>
           <option value="<?php echo $this->session->flashdata('order_kabupaten_id') ?>"><?php echo $this->session->flashdata('order_kabupaten_nama') ?></option>
           <?php }else{
            ?>
             <option value="0">Pilih kabupaten</option>
            <?php
            } ?>
           <?php foreach ($kabupaten as $key => $value) { ?>
             <option value="<?php echo $value['kabupaten_id']; ?>" <?php echo set_select('kabupaten_id',$value['kabupaten_id']); ?>  > <?php echo $value['title']; ?></option>
           <?php }?>
         </select>
         <?php echo form_error('kabupaten_id', '<div class="alert alert-error">', '</div>'); ?>
         <div id="loading_kecamatan" style="display:none" class="text-center">
            <i class="fa fa-cog fa-spin"></i> Loading
          </div>
         <select id="kecamatan_id" class="form border arrow-sel" name="kecamatan_id" style="width: 100%" onChange="getongkir(<?php echo $area_sales['area_id']; ?>)">
          
           <?php if($this->session->flashdata('order_propinsi_id')){ ?>
           <option value="<?php echo $this->session->flashdata('order_kecamatan_id') ?>"><?php echo $this->session->flashdata('order_kecamatan_nama') ?></option>
           <?php }else{
            ?>
             <option value="0">Pilih Kecamatan</option>
            <?php
            } ?>
           <?php foreach ($kecamatan as $key => $value) { ?>
             <option value="<?php echo $value['kecamatan_id']; ?>" <?php echo set_select('kecamatan_id',$value['kecamatan_id']); ?>  > <?php echo $value['title']; ?></option>
           <?php }?>
         </select>
         <?php echo form_error('kecamatan_id', '<div class="alert alert-error">', '</div>'); ?>
         
        </div>
        </div>
        </div>
      </div>
    </div>
   
</div>
<div class="col-md-6">
  <?php if($this->session->userdata('valid_area_id')) { ?>
  <?php $valid_area_sales = GetAreaSales($this->session->userdata('valid_sales_id')); $valid_area_id = $valid_area_sales['area_id']; $valid_area_title = $valid_area_sales['area_title']?>
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-info" style="margin-top: 0px !important;">
        <h4>INFO</h4>
        <p>Saat ini anda berada pada area pengiriman <strong><?php echo strtoupper($valid_area_title)?></strong></p>
        <p>Anda hanya dapat berbelanja buku pada area pengiriman yang sama.</p>

      </div>
    </div>
  </div>
  <?php } ?>
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
			<?php $buku=$this->db->query("select * from buku where kode_buku='".$items['id']."'")->row(); ?>
          <img class="float-l" src="<?php echo base_url().'uploads/cover/'.$buku->cover?>" width="80px">
        </div>
        <div class="col-md-6">
            <div class="float-l">
              <h4><?php echo $items['name']?></h4>

              <div class="width-seratus">
              <input  type="number" min="1" step="1" value ="<?php echo $items['qty']?>" class="form border select2" name="qty_<?php echo $items['rowid'] ?>" id="qty_<?php echo $items['rowid'] ?>" onChange="updatecart('<?php echo $items['rowid'] ?>')" onKeyUp="updatecart('<?php echo $items['rowid'] ?>')"/>

               
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
      <input type="hidden" id="area_id" name="area_id" value="<?php echo $area_sales['area_id']; ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <h4 class="grey">Ongkos Kirim</h4>
      <?php if($free->free=='1'){ ?>
        <h4>FREE.</h4>
        <?php }else{ ?>
      <select required id="paket" onchange="getongkir(<?php echo $this->session->userdata('valid_area_id') ?>)" name="paket" class="form border arrow-sel">
                    <option value="">Pilih Paket Ongkos</option>
                      <option value="reguler">Reguler</option>
                        <option value="ok">OK</option>
                   
                  </select>
                  <?php } ?>
    </div>
    <div class="col-md-6 text-right">
    </br></br>      <h4 class="price-list grey" id="ongkir">RP. <?php echo number_format($this->session->userdata('ongkir'))?></h4>
    </div>
  </div>
  <div class="clearfix"></div>
</div>

    <div class="text-right">
      <input type="hidden" id="totalongkir" name="totalongkir">
      <?php $totalsemua = $this->cart->total() + $this->session->userdata('ongkir')+$this->session->userdata('uniquecode');?>
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