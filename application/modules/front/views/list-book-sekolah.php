
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
    <div class="row">
      <div class="col-md-12 col-md-offset-3 "> 
      <!-- <select class="form border select2 arrow-sel">
               <option value="1">Kelas </option>
          </select> -->
        <select class="form border select2 arrow-sel" name="bstudy" id="bstudy" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>">Bidang Studi</option>
		  <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/">SEMUA</option>
          
		  <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/AKTIVITAS">AKTIVITAS</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/BHS ASING">BHS ASING</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/BHS DAERAH">BHS DAERAH</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/BHS INDONESIA">BHS INDONESIA</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/FILSAFAT">FILSAFAT</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/GABPEL">GABPEL</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/GEOGRAFI">GEOGRAFI</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/GEOGRAFI">GEOGRAFI</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/ILMU KEDOKTERAN">ILMU KEDOKTERAN</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/ILMU POLITIK">ILMU POLITIK</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/ILMU POLITIK">ILMU POLITIK</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/IPA">IPA</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/IPS">IPS</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/ISLAM">ISLAM</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/KESENIAN">KESENIAN</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/KOMPUTER">KOMPUTER</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/MATEMATIKA">MATEMATIKA</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/PENDIDIKAN">PENDIDIKAN</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/SEJARAH">SEJARAH</option>
          <option value="<?php echo base_url(); ?>front/search_sekolah/<?php echo $this->uri->segment(3);echo"/";echo $this->uri->segment(4);echo"/";echo $this->uri->segment(5); ?>/SOSPOL">SOSPOL</option>
        </select>
      </div>
      
    </div>
  </div>
		<div class="kotak">
      <?php if($buku->num_rows() > 0) { ?>
        <?php foreach ($buku->result_array() as $key => $value) { ?>
          <!------------------------list---------------->
          <?php $area_sales = GetAreaSales($value['sales_id']); $area_id = $area_sales['area_id']; $area_title = $area_sales['area_title']?>
            <div class="list-book">
              <div class="col-md-3"> 
                <a href="#">
                  <!-- <img src="<?php echo base_url().$value['cover']?>" width="130px"> -->
                  <img src="<?php echo base_url().'uploads/cover/'.$value['cover']?>" width="130px">
                </a>
              </div>
              <div class="col-md-5" >
                <a href="$">
                  <h4><?php echo $value['judul']; ?></h4>
                </a>
                <span><?php echo $value['bstudi']; ?>, <?php echo $value['pengarang']; ?></span><br/>
                <span><?php echo $value['jenjang']; ?></span><br/>
                <span><?php echo strtoupper(url_title($value['lapak_id'].'-'.$value['title'])); ?></span><br/>
                <span>AREA PENGIRIMAN : <?php echo strtoupper($area_title); ?></span>
                <div class="ko-price">
                  <!-- <h4 class="price-list disc">RP 45.000</h4>  -->
                  <h4 class="price-list2">RP <?php echo number_format($value['harga'])?></h4>
                </div>
              </div>
              <div class="col-md-4 text-right">
                <div class="row">
                  <!-- <form action="front/cart"> -->
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
                      <!-- <input type="hidden" name="sales_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" id="sales_<?php echo $value['lapak_id']?>_<?php echo $value['kode_buku']?>" value="<?php echo $value['sales_id']?>"> -->
                      
                      <input type="button" name="submit" value="Beli" class="form btn2" onClick="addcart(<?php echo $value['lapak_id']?>,<?php echo $value['kode_buku']?>,<?php echo $value['sales_id']?>,<?php echo $area_id?>)">
                    </div>
                  <!-- </form> -->
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
  <?php if($lapak->num_rows() > 0) { ?>
    <?php foreach ($lapak->result_array() as $key => $value) { ?>
      <div class="col-md-11 center lapak-list">
        <a href="<?php echo site_url('front/search_lapak/'.$value['lapak_code']); ?>"><h4><?php echo $value['lapak_code']; ?></h4></a>
      </div>
    <?php } ?>
    
  <?php } ?>     
</div>



  </div></div></div>
</section>