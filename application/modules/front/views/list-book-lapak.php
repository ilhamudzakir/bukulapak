<section>
<div class="title2">
     <div class="container">
          <div class="col-md-6 pull-left"><h3><?php echo $lapak_code; ?></h3>
          <span><?php echo $nama_sekolah; ?></span>
          </div>
          <div class="col-md-3 pull-right text-right"> 
            <a href="<?php echo base_url() ?>"><button class="form btn1" name="submit" type="submit">
<span id="search">Cari</span>
</button>
</a>
          </div>
     </div>
</div>
</section>
<section>
	<div class="container">
		<div class="kotak">
        <?php if($buku->num_rows() > 0) { ?>
        <?php foreach ($buku->result_array() as $key => $value) { ?>
        <!------------------------list---------------->
       <div class="list-book">
          <div class="col-md-3">
            <a href="#">
              <!-- <img src="<?php echo base_url().$value['cover']?>" width="130px"> -->
              <img src="http://placehold.it/130x125" width="130px">
            </a>
          </div>
          <div class="col-md-5">
            <a href="#">
              <h4><?php echo $value['judul']; ?></h4>
            </a>
            <span><?php echo $value['bstudi']; ?>, <?php echo $value['pengarang']; ?></span><br/>
            <span><?php echo $value['jenjang']; ?></span>
            <div class="ko-price">
                  <!-- <h4 class="price-list disc">RP 45.000</h4>  -->
                  <h4 class="price-list">RP <?php echo number_format($value['harga'])?></h4>
                </div>
          </div>
          <div class="col-md-4 text-right">
           <!-- <form action="front/cart"> -->
            <div class="row">
              <div class="col-md-12">

                <input  type="number" min="1" step="1" value ="1" class="form border select2" name="cty_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" id="cty_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>"/>
              </div>
              <div class="col-md-12">
                <input type="hidden" name="current_url" id="current_url" value="<?php echo current_url(); ?>">
                <input type="hidden" name="kode_buku" id="kode_buku" value="<?php echo $value['kode_buku']?>">
                <input type="hidden" name="lapak_id" id="lapak_id" value="<?php echo $value['lapak_id']?>">
                <input type="hidden" name="berat_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" id="berat_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" value="<?php echo $value['berat']?>">
                <input type="hidden" name="harga_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" id="harga_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" value="<?php echo $value['harga']?>">
                <input type="hidden" name="judul_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" id="judul_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" value="<?php echo $value['judul']?>">
                <input type="button" name="submit" value="Beli" class="form btn2" onClick="addcart(<?php echo $value['lapak_id']?>,<?php echo $value['kode_buku']?>,<?php echo $value['sales_id']?>)">
              </div>
           </div>
          <!-- </form> -->
           </div>
           <div class="clearfix"></div>
        </div><!--endlist--> 
       <?php } ?>
       <?php }else{ ?>
          <h4>Tidak ada Buku</h4>
        <?php }?>        
       
          </div>

	</div><!----end container-------------->
</section>