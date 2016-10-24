<section>
	<div class="container">
		<div class="col-md-9">
    <h4 class="grey">Lapak Saya > Lapak 892174</h4>
   
    <div class="martop grey">
      <form action="sales/finish">
        <div class="form-group">
          <h4>Nama Lapak</h4>
          <div class="col-md-2"><h2>830</h2></div>
          <div class="col-md-5"><input type="text" name="name" class="form border"></div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group">
          <h5>Masa Aktif</h5>
          <label>29-05-2016 s.d. 29-05-2016 </label>

          </div>

          <div class="form-group martop2">
          
          <h4>Data Sekolah</h4>
          <div class="row">
          <div class="col-md-3">
          <label>Propinsi</label>
          <select class="form border arrow-sel">
                    <option value="">Pilih Propinsi</option>
                  </select>
          </div>
          <div class="col-md-3">
          <label>Kota</label>
          <select class="form border arrow-sel">
                    <option value="">Pilih Propinsi</option>
                  </select>
          </div>
          <div class="col-md-3">
          <label>Nama Sekolah</label>
          <select class="form border arrow-sel">
                    <option value="">Pilih Propinsi</option>
                  </select>
          </div></div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group">
          <div class="row">
          <div class="col-md-3">
          <label>Nama Agen</label>
          <select class="form border arrow-sel">
                    <option value="">Pilih Propinsi</option>
                  </select>
          </div>
           <div class="col-md-3">
           <label></label>
          <a data-toggle="modal" data-target="#myModal"  href=""><button type="submit" name="submit" class="form btn2">+ Tambah Agen</button></a>
          </div>
         </div>
          <div class="clearfix"></div>
        </div>


        <div class="form-group">
          <div class="row">
          <div class="col-md-2">
          <label>Diskon Agen</label>
          <input type="text" class="form border" name="name">
          </div>
                    <div class="col-md-2">
          <label>Diskon Pembeli</label>
          <input type="text" class="form border" name="name">
          </div>
          
         </div>
          <div class="clearfix"></div>
        </div>
          <div class="form-group bortom">
          <div class="row">
          <div class="col-md-8"><h3>Buku</h3></div>
          <div class="col-md-4"><a href="sales/add_book"><button class="form btn2" name="submit" type="submit">+ Tambah Buku</button></a></div>
          <div class="clearfix"></div>
          </div></div>

           <div class="form-group">
          <table width="100%">
          <tr>
          <td><h4>Image</h4></td>
          <td><h4>Judul Buku</h4></td>
          <td><h4>Kelas</h4></td>
          <td></td>
          </tr>
            <tr>
              <td width="20%"><img src="assets/front/images/book.jpg" width="60" /></td>
              <td width="40%"><span class="grey">Ipa Menengah</span></td>
               <td class=""><span class="grey">3 Ipa, 2 IPS</span></td>
                <td class=""><button type="submit" name="submit" class="form btn2">Delete</button></td>
            </tr>
          </table>
          <div class="clearfix"></div>
          </div>

          <div class="form-group martop2">
          <div class="row">
          <label>Catatan Tambahan</label>
          <textarea class="form border" style="height:120px;"></textarea>
          </div>
          <div class="clearfix"></div>
          </div>
           <div class="form-group">
          <div class="row">
          <div class="col-md-6 center">
            <button type="submit" name="submit" class="form btn2 large">Simpan Lapak Baru</button>
          </div>
          </div></div>
      </form>
    </div>

    <div class="clearfix"></div>
    </div>



<?php $this->load->view('side-right'); ?>

	</div><!----end container-------------->
</section>