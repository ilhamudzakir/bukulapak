<style type="text/css">
     body{
          background:url("<?php echo base_url(); ?>assets/front/images/girls-back.jpg") no-repeat;
          background-size: 100%;
     }
</style>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/owl.carousel.css">
<section class="sec-main">
<a href="#" id="back-to-top" title="Back to top"><img src="<?php echo base_url() ?>assets/img/rewind.png"></a>
     <div class="container">
          <div class="col-md-11 center trans-white">
               <div class="title1 left-text"><h2 class="col-blue">Cara Mudah Beli Buku</h2></div>
               <div class="col-md-12 center">
                    <div class="row">
                         <div id="exTab1">   
                              <ul  class="nav nav-pills">
                                   <li class="active tabs" id="tabsekolah">
                                        <a  href="#sekolah" data-toggle="tab">Cari berdasarkan sekolah</a>
                                   </li>
                                   <li class="tabs" id="tablapak">
                                        <a href="#lapak" data-toggle="tab">Cari kode lapak</a>
                                   </li>
                              </ul>

                              <div class="tab-content clearfix">
                                   <div class="tab-pane active" id="sekolah">
                                        <form action="<?php echo site_url('front/sekolah')?>">
                                             <div class="form-group">
                                                  <div class="row">
                                                       <div class="col-md-12">
                                                            <div class="row">
                                                                 
                                                                 <div class="col-md-4 padding-none">
                                                                      <select id="propinsi_id" class="form arrow-sel" name="propinsi_id" style="width: 100%" onChange="getkabupaten()">
                                                                      <option value="0">Pilih propinsi</option>
                                                                      <?php foreach ($propinsi as $key => $value) { ?>
                                                                        <option value="<?php echo $value['propinsi_id']; ?>" > <?php echo $value['title']; ?></option>
                                                                      <?php }?>
                                                                    </select>
                                                                    <div id="propinsi_id_help"></div>
                                                                 </div>
                                                                 <div class="col-md-3 padding-none" id="kabupatendiv">
                                                                      <select id="kabupaten_id" class="form arrow-sel" name="kabupaten_id" style="width: 100%" onChange="getsekolah()">
                                                                           <option value="0">Pilih Kabupaten</option>
                                                                           <!--<?php foreach ($kabupaten as $key => $value) { ?>
                                                                             <option value="<?php echo $value['kabupaten_id']; ?>"> <?php echo $value['title']; ?></option>
                                                                           <?php }?> -->
                                                                         </select>
                                                                      <div id="kabupaten_id_help"></div>
                                                                 </div>
                                                                 <div class="col-md-3 padding-none">
                                                                      <select  id="sekolah_id" onChange="sekolah()" name="sekolah_id" style="width: 100%" class="form arrow-sel" >
                                                                           <option value="0">Pilih Sekolah</option>
                                                                           <?php foreach ($sekolah as $key => $value) { ?>
                                                                           <?php $selected = ($value['id'] == $sekolah_id) ? 'selected="selected"' : '' ?>
                                                                           <option value="<?php echo $value['id']; ?>" <?php echo $selected ?> > <?php echo $value['title']; ?></option>
                                                                      <?php }?>
                                                                    </select>
                                                                    <div id="sekolah_id_help"></div>
                                                                 </div>
                                                                 <div class="col-md-2 padding-none">
                                                                      <button type="button" name="submit" class="form btn1" onClick="search_sekolah()"><span id="search">Cari</span></button>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </form>
                                   </div>
                                   <div class="tab-pane" id="lapak">
                                        <!-- <form action="front/book/lapak"> -->
                                             <div class="form-group">
                                                  <div class="row">
                                                       <div class="col-md-12">
                                                            <div class="row">
                                                                 <div class="col-md-10 padding-none">
                                                                      <input type="text" class="form school schoolin" id="kodelapak" name="kodelapak" placeholder="Tuliskan Kode Lapak">
                                                                      <div id="kodelapak_help"></div>
                                                                 </div>
                                                                 <div class="col-md-2 padding-none">
                                                                      <button type="button" name="submit" class="form btn1" onClick="search_lapak()"><span id="search">Cari</span></button>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        <!-- </form> -->
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</section>


<section class="sec-lapak-baru">
<div class="container animatedParent">
     
     <div class="col-md-2 text-center column-title">
          
         <div class="icon-lapak">
             <h3>Buku Terbaru</h3>
         </div>
          
     </div>
    
       <div class="col-md-1"></div>
    <div class="col-md-8">
        <div class="row">
        <div class="owl-carousel">
          <?php foreach ($lapak as $data) { ?>
            <div class="item text-center">
                <div class="thumb-area"><img src="<?php echo base_url() ?>uploads/cover/<?php echo $data->cover ?>" width="100"/></div>
                 <p><a href="#"><?php echo $data->judul ?></a></p>
            </div>
             <?php } ?>
          </div>
        </div>
     </div>
    

</div>
</section>

<section class="sec-buku-terlaris">
<div class="container animatedParent">
    <div class="col-md-2 text-center column-title">
     <div class="icon-buku-terlaris">
         <h3>Buku Terlaris</h3>
     </div>
    </div>
  <div class="col-md-1"></div>
    <div class="col-md-8">
        <div class="row">
        <div class="owl-carousel">
        <?php foreach ($buku as $data) { ?>
            <div class="item text-center">
                <div class="thumb-area"><img src="<?php echo base_url() ?>uploads/cover/<?php echo $data->cover ?>" width="100"/></div>
                 <p><a href="#"><?php echo $data->item_name ?></a></p>
            </div>
             <?php } ?>
            </div>
          </div>
        </div>
     </div>

    
    
    

</div>
</section>

<section class="sec-fasilitas">
<div class="container animatedParent">
     <div class="header-fasilitas">
     <h2>Keunggulan beli buku di sini</h2>
     </div>
     <div class="col-md-3 text-center animated bounceInUp slow">
          <img src="assets/front/images/icon-mudah.png" />
          <h3>Mudah</h3>
          
     </div>
     <div class="col-md-3 text-center animated bounceInUp slow">
          <img src="assets/front/images/icon-aman.png" />
          <h3>Aman</h3>
         
     </div>
     <div class="col-md-3 text-center animated bounceInUp slow">
          <img src="assets/front/images/icon-terpercaya.png" />
          <h3>Terpercaya</h3>
          
     </div>
     <div class="col-md-3 text-center animated bounceInUp slow">
          <img src="assets/front/images/icon-sesuai.png" />
          <h3>Sesuai</h3>         
     </div>   

</div>
</section>

<section class="sec-cara-pembelian">
<div class="container animatedParent">
     <div class="header-fasilitas">
     <h2>Cara Pembelian</h2>
     </div>
    <div class="row">
     <div class="col-md-3 animated bounceInUp slow">
         <img src="assets/front/images/comic.jpg" class="img-responsive"/>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
          
     </div>
     <div class="col-md-3 animated bounceInUp slow">
          <img src="assets/front/images/comic.jpg" class="img-responsive"/>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ultricies neque eu ultrices sollicitudin</p>
         
     </div>
     <div class="col-md-3 animated bounceInUp slow">
          <img src="assets/front/images/comic.jpg" class="img-responsive"/>
         <p>Lorem ipsum dolor sit amet, consectetu</p>
          
     </div>
     <div class="col-md-3 animated bounceInUp slow">
        <img src="assets/front/images/comic.jpg" class="img-responsive"/>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ultricies neque eu ultrices sollicitudin</p>        
     </div> 
        </div>
    
    <div class="row">
     <div class="col-md-3 animated bounceInUp slow">
          <img src="assets/front/images/comic.jpg" class="img-responsive"/>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ultricies neque eu ultrices sollicitudin</p>
          
     </div>
     <div class="col-md-3 animated bounceInUp slow">
          <img src="assets/front/images/comic.jpg" class="img-responsive"/>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ult
     </div>
     <div class="col-md-3 animated bounceInUp slow">
        <img src="assets/front/images/comic.jpg" class="img-responsive"/>
         <p>Lorem ipsum dolor sit amet, consectetur altricies neque eu ultrices sollicitudin</p>
          
     </div>
     <div class="col-md-3 animated bounceInUp slow">
         <img src="assets/front/images/comic.jpg" class="img-responsive"s/>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing es neque eu ultrices sollicitudin</p>        
     </div>  
    </div>

</div>
</section>

          
   