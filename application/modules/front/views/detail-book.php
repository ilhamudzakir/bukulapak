<section>
<div class="title2">
     <div class="container">
          <div class="col-md-6 pull-left"><h3>Kode Lapak : <?php echo $lapak->lapak_code ?></h3>
          </div>
          <div class="col-md-6 pull-right text-right"> <a href="<?php echo base_url() ?>"><input type="button" name="cari" class="btn3" value="Cari buku lainya"></a></div>
     </div>
</div>
</section>
<section>
	<div class="container">
		<div class="kotak">
        
        <!------------------------list---------------->
       <div class="list-book">
          <div class="col-md-3"> <img src="<?php echo base_url() ?>uploads/cover/<?php echo $buku->cover?>" width="180px"></div>
           <div class="col-md-9">
          <h3><?php echo $buku->judul?></h3>
         <div class="desc">
           <?php echo $buku->sinopsis_html ?>
         </div>
           </div>
           <div class="col-md-6 text-center center">
           <div class="row">
           <div class="col-md-8 padding-none"><input  type="number" min="1" step="1" value ="1" class="form border select2" name="cty_<?php echo $lapak->id?>_<?php echo $buku->kode_buku?>" id="cty_<?php echo $lapak->id?>_<?php echo $buku->kode_buku?>"/></div>
           <div class="col-md-4">
                      <input type="hidden" name="current_url" id="current_url" value="<?php echo current_url(); ?>">
                      <input type="hidden" name="kode_buku" id="kode_buku" value="<?php echo  $lapak_buku->kode_buku ?>">
                      <input type="hidden" name="lapak_id" id="lapak_id" value="<?php echo  $lapak_buku->lapak_id ?>">
                      <input type="hidden" name="berat_<?php echo  $lapak_buku->lapak_id ?>_<?php echo  $lapak_buku->kode_buku ?>" id="berat_<?php echo  $lapak_buku->lapak_id ?>_<?php echo  $lapak_buku->kode_buku ?>" value="<?php echo  $buku->berat ?>">
                      <input type="hidden" name="harga_<?php echo  $lapak_buku->lapak_id ?>_<?php echo  $lapak_buku->kode_buku ?>" id="harga_<?php echo  $lapak_buku->lapak_id ?>_<?php echo  $lapak_buku->kode_buku ?>" value="<?php echo $value_harga?>">
                      
                      <input type="hidden" name="judul_<?php echo  $lapak_buku->lapak_id ?>_<?php echo  $lapak_buku->kode_buku ?>" id="judul_<?php echo  $lapak_buku->lapak_id ?>_<?php echo  $lapak_buku->kode_buku ?>" value="<?php echo  $buku->judul ?>">
                      <!-- <input type="hidden" name="sales_<?php echo  $lapak_buku->lapak_id ?>_<?php echo  $lapak_buku->kode_buku ?>" id="sales_<?php echo  $lapak_buku->lapak_id ?>_<?php echo  $lapak_buku->kode_buku ?>" value="<?php echo  $lapak_buku->sales_id ?>"> -->
                      
                      <input type="button" name="submit" value="Beli" class="form btn2" onClick="addcart(<?php echo  $lapak_buku->lapak_id ?>,'<?php echo  $lapak_buku->kode_buku ?>',<?php echo  $sales->id ?>,<?php echo $sales->area_id?>)">
                      <div class="alert alert-info text-left hide" id="alert_<?php echo  $lapak_buku->kode_buku ?>">
                     <p>Buku ini sudah berada di keranjang belanja anda.</p></div>
                    </div>
           </div>
          
           </div>
           <div class="clearfix"></div>
       </div><!--endlist-->        
          </div>

	</div><!----end container-------------->
</section>