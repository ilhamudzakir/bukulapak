<div class="page-content">
  <div class="content">
    <div class="grid simple">
    <input type="hidden" id="controller_name" value="<?php echo current_url(); ?>">
    <div class="grid-title">
      <h3>Data Buku</h3>
    </div>
    <div class="grid-body ">
      <button class="btn btn-success" onclick="add_groups()"><i class="glyphicon glyphicon-plus"></i> Upload Buku</button>
    <br />
    <br />
    <table id="table" class="table" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>Cover</th>
          <th>Kode Buku</th>
          <th>Judul</th>
          <th>jenjang</th>
          <th>Pengarang</th>
          <th>Harga</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
  </div>
  </div>
</div>


        
<div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Upload Buku</h3>
      </div>
      <div class="modal-body form">
        <div id="loading" style="display:none">
          <i class="fa fa-cog fa-spin"></i> Loading
        </div>
        <div id="validation_errors" class=""></div>
        <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-5">Unggah data buku (.xls)</label>
              <div class="col-md-7">
                <input type="file" class="form border" name="upload_file" id="upload_file">
                <input type="hidden" id="base_url" name="base_url" value="<?php echo base_url()?>">
                <span class="help-block"></span>
              </div>
            </div>
            <!-- <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label class="grey">Unggah data buku (.xls)</label>
                <input type="file" class="form border" name="upload_file" id="upload_file">
                <input type="hidden" id="base_url" name="base_url" value="<?php echo base_url()?>">
                </div>
              </div>
            </div> -->
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="upload()" class="btn btn-primary">Upload</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modal_form_edit" role="dialog">
  <div class="modal-dialog modal-lg">
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">groups Form</h3>
      </div>
      <div class="modal-body">
        <form action="#" id="form_edit" class="form row" enctype="multipart/form-data">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Kode Buku</label>
              <div class="col-md-9">
                <input name="kode_buku" placeholder="Kode Buku" class="form-control" type="text" id="kode_buku" readonly="readonly">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Tahun Katalog</label>
              <div class="col-md-9">
                <input name="thn_katalog" id="thn_katalog" placeholder="Tahun Katalog" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Isbn</label>
              <div class="col-md-9">
                <input name="isbn" id="isbn" placeholder="Isbn" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Judul</label>
              <div class="col-md-9">
                <input name="judul" id="judul" placeholder="judul" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Pengarang</label>
              <div class="col-md-9">
                <input name="pengarang" id="pengarang" placeholder="Pengarang" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">sinopsis</label>
              <div class="col-md-9">
                <input name="sinopsis" id="sinopsis" placeholder="sinopsis" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">sinopsis_html</label>
              <div class="col-md-9">
                <textarea name="sinopsis_html" id="sinopsis_html" placeholder="sinopsis_html" class="form-control" ></textarea>
                <!-- <input name="sinopsis_html" placeholder="sinopsis_html" class="form-control" type="text"> -->
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">lebar</label>
              <div class="col-md-9">
                <input name="lebar" id="lebar" placeholder="lebar" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">tinggi</label>
              <div class="col-md-9">
                <input name="tinggi" id="tinggi" placeholder="tinggi" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">warna</label>
              <div class="col-md-9">
                <input name="warna" id="warna" placeholder="warna" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">berat</label>
              <div class="col-md-9">
                <input name="berat" id="berat" placeholder="berat" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">tebal</label>
              <div class="col-md-9">
                <input name="tebal" id="tebal" placeholder="tebal" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">jml_halaman</label>
              <div class="col-md-9">
                <input name="jml_halaman" id="jml_halaman" placeholder="jml_halaman" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">thn_terbit</label>
              <div class="col-md-9">
                <input name="thn_terbit" id="thn_terbit" placeholder="thn_terbit" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">harga</label>
              <div class="col-md-9">
                <input name="harga" id="harga" placeholder="harga" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">kertas</label>
              <div class="col-md-9">
                <input name="kertas" id="kertas" placeholder="kertas" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">jenjang</label>
              <div class="col-md-9">
                <input name="jenjang" id="jenjang" placeholder="jenjang" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">bstudi</label>
              <div class="col-md-9">
                <input name="bstudi" id="bstudi" placeholder="bstudi" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">cover</label>
              <div class="col-md-9">
                <input name="cover" id="cover" placeholder="cover" class="form-control" type="text">
                <input type="file" class="form-control" name="upload_file2" id="upload_file2">
                <input type="hidden" id="base_url" name="base_url" value="<?php echo base_url()?>">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">tgl_terbit</label>
              <div class="col-md-9">
                <input name="tgl_terbit" id="tgl_terbit" placeholder="tgl_terbit" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">brandname</label>
              <div class="col-md-9">
                <input name="brandname" id="brandname" placeholder="brandname" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
             
              <div class="col-md-12">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
            </div>

          </div>
          </form>
        
        
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>
        
  