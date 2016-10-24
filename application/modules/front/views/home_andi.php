<style type="text/css">
     body{
          background:url("<?php echo base_url(); ?>assets/front/images/girls-back.jpg");
          background-size: cover;
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
                                                                 <div class="col-md-3 padding-none">
                                                                      <select id="kabupaten_id" class="form arrow-sel" name="kabupaten_id" style="width: 100%" onChange="getsekolah()">
                                                                           <option value="0">Pilih Kabupaten</option>
                                                                           <!--<?php foreach ($kabupaten as $key => $value) { ?>
                                                                             <option value="<?php echo $value['kabupaten_id']; ?>"> <?php echo $value['title']; ?></option>
                                                                           <?php }?> -->
                                                                         </select>
                                                                      <div id="kabupaten_id_help"></div>
                                                                 </div>
                                                                 <div class="col-md-3 padding-none">
                                                                      <select id="sekolah_id" name="sekolah_id" style="width: 100%" class="form arrow-sel" >
                                                                           <option value="0">Pilih Sekolah</option>
                                                                           <!-- <?php foreach ($sekolah as $key => $value) { ?>
                                                                           <?php $selected = ($value['id'] == $sekolah_id) ? 'selected="selected"' : '' ?>
                                                                           <option value="<?php echo $value['id']; ?>" <?php echo $selected ?> > <?php echo $value['title']; ?></option>
                                                                      <?php }?> -->
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