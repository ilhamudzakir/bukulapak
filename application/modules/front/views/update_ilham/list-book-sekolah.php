<section>
  <div class="title2">
    <div class="container">
      <div class="col-md-6 pull-left patop">
        <h3><?php echo $nama_sekolah; ?></h3>
      </div>
      <div class="col-md-3 pull-right text-right">  
        <a href="<?php echo base_url() ?>">
          <button class="form btn1" name="submit" type="submit">
            <span id="search">Cari</span>
          </button>
        </a>
      </div>
    </div>
  </div>
</section>
<section>
 	<div class="container white padding-none matobot">
    <div> 
<ul  class="nav nev nav-pills  nev-pills" id="p-sekolah">
    <li class="active tabse" id="tabsekolah">
          <a  href="#sekolah" data-toggle="tab">Buku</a>
    </li>
    <li class="tabse" id="tablapak">
      <a href="#lapak" data-toggle="tab">lapak</a>
    </li>
</ul>

<div class="tab-content clearfix">
    <div class="tab-pane teb active" id="sekolah">

   <div class="col-md-12 center box-search">
    <div class="row">
      <div class="col-md-12 col-md-offset-3 "> 
      <!-- <select class="form border select2 arrow-sel">
               <option value="1">Kelas </option>
          </select> -->
        <select class="form border select2 arrow-sel" name="bstudy" id="bstudy" onChange="">
          <option value="0">Bidang Studi</option>
          <option value="AKTIVITAS">AKTIVITAS</option>
          <option value="BHS ASING">BHS ASING</option>
          <option value="BHS DAERAH">BHS DAERAH</option>
          <option value="BHS INDONESIA">BHS INDONESIA</option>
          <option value="FILSAFAT">FILSAFAT</option>
          <option value="GABPEL">GABPEL</option>
          <option value="GEOGRAFI">GEOGRAFI</option>
          <option value="GEOGRAFI">GEOGRAFI</option>
          <option value="ILMU KEDOKTERAN">ILMU KEDOKTERAN</option>
          <option value="ILMU POLITIK">ILMU POLITIK</option>
          <option value="ILMU POLITIK">ILMU POLITIK</option>
          <option value="IPA">IPA</option>
          <option value="IPS">IPS</option>
          <option value="ISLAM">ISLAM</option>
          <option value="KESENIAN">KESENIAN</option>
          <option value="KOMPUTER">KOMPUTER</option>
          <option value="MATEMATIKA">MATEMATIKA</option>
          <option value="PENDIDIKAN">PENDIDIKAN</option>
          <option value="SEJARAH">SEJARAH</option>
          <option value="SOSPOL">SOSPOL</option>
        </select>
    
      </div>
      
    </div>
  </div>
		<div class="kotak">
      <?php if($buku->num_rows() > 0) { ?>
        <?php foreach ($buku->result_array() as $key => $value) { ?>
          <!------------------------list---------------->
            <div class="list-book">
              <div class="col-md-3"> 
                <a href="front/book/detail">
                  <!-- <img src="<?php echo base_url().$value['cover']?>" width="130px"> -->
                  <img src="http://placehold.it/130x125" width="130px">
                </a>
              </div>
              <div class="col-md-5" >
                <a href="front/book/detail">
                  <h4><?php echo $value['judul']; ?></h4>
                </a>
                <span><?php echo $value['bstudi']; ?>, <?php echo $value['pengarang']; ?></span><br/>
                <span><?php echo $value['jenjang']; ?></span><br/>
                <span><?php echo strtoupper(url_title($value['lapak_id'].'-'.$value['title'])); ?></span>
                <div class="ko-price">
                  <!-- <h4 class="price-list disc">RP 45.000</h4>  -->
                  <h4 class="price-list2">RP <?php echo number_format($value['harga'])?></h4>
                </div>
              </div>
              <div class="col-md-4 text-right">
                <div class="row">
                  <form action="front/cart">
                    <div class="col-md-12">
                      <select class="form border arrow-sel select2" name="cty_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" id="cty_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>">
                        <option value="1">1 Buku</option>
                        <option value="2">2 Buku</option>
                        <option value="3">3 Buku</option>
                        <option value="4">4 Buku</option>
                        <option value="5">5 Buku</option>
                      </select> 
                    </div>
                    <div class="col-md-12">
                      <input type="hidden" name="current_url" id="current_url" value="<?php echo current_url(); ?>">
                      <input type="hidden" name="kode_buku" id="kode_buku" value="<?php echo $value['kode_buku']?>">
                      <input type="hidden" name="lapak_id" id="lapak_id" value="<?php echo $value['lapak_id']?>">
                      <input type="hidden" name="berat_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" id="berat_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" value="<?php echo $value['berat']?>">
                      <input type="hidden" name="harga_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" id="harga_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" value="<?php echo $value['harga']?>">
                      <input type="hidden" name="judul_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" id="judul_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" value="<?php echo $value['judul']?>">
                      <!-- <input type="hidden" name="sales_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" id="sales_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" value="<?php echo $value['sales_id']?>"> -->
                      <input type="button" name="submit" value="Beli" class="form btn2" onClick="addcart(<?php echo $value['lapak_id']?>,<?php echo $value['kode_buku']?>,<?php echo $value['sales_id']?>)">
                    </div>
                  </form>
                </div>
              </div>
              <div class="clearfix"></div>
            </div><!--endlist-->   
            <?php } ?> 
        <?php }else{ ?>
          <h4>Tidak ada Buku</h4>
        <?php }?>  

          

    </div>
	</div><!----end container-------------->



<div class="tab-pane teb" id="lapak">
   <div class="col-md-11 center lapak-list">
    <a href="front/book/lapak"><h4>672 - Nama Lapak</h4></a>
     </div>

        <div class="col-md-11 center lapak-list">
     <a href="front/book/lapak"><h4>672 - Nama Lapak</h4></a>
     </div>

        <div class="col-md-11 center lapak-list">
     <a href="front/book/lapak"><h4>672 - Nama Lapak</h4></a>
     </div>

        <div class="col-md-11 center lapak-list">
     <a href="front/book/lapak"><h4>672 - Nama Lapak</h4></a>
     </div>
     
</div>



  </div></div></div>
</section>