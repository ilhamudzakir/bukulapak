<div class="page-content">
  <div class="content">
    <div class="grid simple">
    <input type="hidden" id="controller_name" value="<?php echo current_url(); ?>">
    <div class="grid-title">
      <h3>Data sekolah</h3>
    </div>
    <div class="grid-body ">
      <button class="btn btn-success" onclick="add_sekolah()"><i class="glyphicon glyphicon-plus"></i> Add Sekolah</button>
      <button class="btn btn-success" onclick="upload_sekolah()"><i class="glyphicon glyphicon-plus"></i> Upload Sekolah</button>
    <br />
    <br />
    <table id="table" class="table" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Jenjang</th>
          <th>Propinsi</th>
          <th>Kabupaten</th>
          <th>Kecamatan</th>
          <!-- <th>Description</th> -->
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

<div class="modal fade" id="modal_form_upload" role="dialog">
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
        <form action="#" id="form_upload" class="form-horizontal" enctype="multipart/form-data">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-5">Unggah data buku (.xls)</label>
              <div class="col-md-7">
                <input type="file" class="form border" name="upload_file" id="upload_file">
                <input type="hidden" id="base_url" name="base_url" value="<?php echo base_url()?>">
                <span class="help-block"></span>
              </div>
            </div>
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


        
<div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Sekolah Form</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Title</label>
              <div class="col-md-9">
                <input type="hidden" value="" name="id"/> 
                <input type="hidden" value="" name="propinsi_eid"/> 
                <input name="title" placeholder="title" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">npsn</label>
              <div class="col-md-9">
                <input name="npsn" placeholder="npsn" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Jenjang</label>
              <div class="col-md-9">
                <input name="jenjang" placeholder="Jenjang" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Status</label>
              <div class="col-md-9">
                <select id="status" name="status" style="width: 100%">
                  <option value="negeri">Negeri</option>
                  <option value="swasta">Swasta</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Alamat</label>
              <div class="col-md-9">
                <input name="alamat" placeholder="alamat" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">propinsi</label>
              <div class="col-md-9">
                <select id="propinsi_id" name="propinsi_id" style="width: 100%" onChange="getkabupaten()">
                  <option value="0">Pilih Propinsi</option>
                  <?php foreach ($propinsi as $key => $value) { ?>
                    <option value="<?php echo $value['propinsi_id']; ?>"> <?php echo $value['title']; ?></option>
                  <?php }?>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">kabupaten</label>
              <div class="col-md-9">
                <select id="kabupaten_id" name="kabupaten_id" style="width: 100%" onChange="getkecamatan()">
                  <option value="0">Pilih Kabupaten</option>
                  <?php foreach ($kabupaten as $key => $value) { ?>
                    <option value="<?php echo $value['kabupaten_id']; ?>"> <?php echo $value['title']; ?></option>
                  <?php }?>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">kecamatan</label>
              <div class="col-md-9">
                <select id="kecamatan_id" name="kecamatan_id" style="width: 100%">
                  <option value="0">Pilih Kecamatan</option>
                  <?php foreach ($kecamatan as $key => $value) { ?>
                    <option value="<?php echo $value['kecamatan_id']; ?>"> <?php echo $value['title']; ?></option>
                  <?php }?>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Kelas 1</label>
              <div class="col-md-9">
                <input name="kls1" placeholder="Kelas 1" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Kelas 2</label>
              <div class="col-md-9">
                <input name="kls2" placeholder="Kelas 2" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Kelas 3</label>
              <div class="col-md-9">
                <input name="kls3" placeholder="Kelas 3" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Kelas 4</label>
              <div class="col-md-9">
                <input name="kls4" placeholder="Kelas 4" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Kelas 5</label>
              <div class="col-md-9">
                <input name="kls5" placeholder="Kelas 5" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Kelas 6</label>
              <div class="col-md-9">
                <input name="kls6" placeholder="Kelas 6" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Kelas 7</label>
              <div class="col-md-9">
                <input name="kls7" placeholder="Kelas 7" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Kelas 8</label>
              <div class="col-md-9">
                <input name="kls8" placeholder="Kelas 8" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Kelas 9</label>
              <div class="col-md-9">
                <input name="kls9" placeholder="Kelas 9" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Menerima / Tidak BOS</label>
              <div class="col-md-9">
                <select id="bos" name="bos" style="width: 100%">
                  <option value="menerima">Menerima</option>
                  <option value="tidak">Tidak</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
        
  