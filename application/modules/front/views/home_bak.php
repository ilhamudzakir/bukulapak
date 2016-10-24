<style type="text/css">
     body{
          background:url("<?php echo base_url(); ?>assets/front/images/girls-back.jpg") no-repeat;
          background-size: 100%;
     }
</style>
<section>
     <div class="container marbot2">
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


<section class="sec-fasilitas">
<div class="container animatedParent">
     <div class="header-fasilitas">
     <h2>Fasilitas apa yang anda dapatkan?</h2>
     </div>
     <div class="col-md-3 text-center animated bounceInUp slow">
          <img src="assets/front/images/icon-cepat-new.png" />
          <h3>Mudah</h3>
          <div>
             Pilih materi dan soal yang Anda inginkan. Hanya dengan beberapa klik, Anda dapat membuat soal ujian yang berkualitas dan siap pakai.
          </div>
     </div>
     <div class="col-md-3 text-center animated bounceInUp slow">
          <img src="assets/front/images/icon-mudah-new.png" />
          <h3>Cepat</h3>
          <div>
             Pilih materi dan soal yang Anda inginkan. Hanya dengan beberapa klik, Anda dapat membuat soal ujian yang berkualitas dan siap pakai.
          </div>
     </div>
     <div class="col-md-3 text-center animated bounceInUp slow">
          <img src="assets/front/images/icon-variatif-new.png" />
          <h3>Variatif</h3>
          <div>
             Pilih materi dan soal yang Anda inginkan. Hanya dengan beberapa klik, Anda dapat membuat soal ujian yang berkualitas dan siap pakai.
          </div>
     </div>
     <div class="col-md-3 text-center animated bounceInUp slow">
          <img src="assets/front/images/IKOM-EXAM.png" />
          <h3>Sesuai kurikulum</h3>
          <div>
             Pilih materi dan soal yang Anda inginkan. Hanya dengan beberapa klik, Anda dapat membuat soal ujian yang berkualitas dan siap pakai.
          </div>
     </div>
     

</div>
</section>
<section class="sec-hubungi">
     <div class="container">
         <div class="text-center">
         <h3>Hubungi Kami</h3></div>
     <div class="col-md-8 center animatedParent">
          <div class="row  animated bounceInUp slow">
               <div class="col-md-6">
                    <div class="list"><img src="assets/front/images/icon-address.png" /><p>Jl. H. Baping Raya No. 100 Ciracas Jakarta 13740</p></div>
                      <div class="list"><img src="assets/front/images/icon-telp.png" /><p>(021) 8717006 Ext. 302</p></div>
                        <div class="list"><img src="assets/front/images/icon-fax.png" /><p>(021) 87794609</p></div>
                          <div class="list"><img src="assets/front/images/icon-wa.png" /><p>0819 0609 6020</p></div>
               </div>
               <div class="col-md-6">
                    <div class="list">
                    <img src="assets/front/images/icon-email.png" /><p>Email info    : info@erlanggaexam.com</p>
                    </div>
                    <div class="list">
                    <p id="no-icon">Email info    : info@erlanggaexam.com</p>
                    </div>
                    <div class="list">
                    <p id="no-icon">Email info    : info@erlanggaexam.com</p>
                    </div>
               </div>
          </div>
     </div>
     </div>
</section>
