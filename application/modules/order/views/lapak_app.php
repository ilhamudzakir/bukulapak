<div class="page-content">
  <div class="content">
    <div class="grid simple">
    <input type="hidden" id="controller_name" value="<?php echo $controller_name; ?>">
    <div class="grid-title">
      <h3>Data Lapak</h3>
    </div>
    <div class="grid-body ">
      <form action="<?php echo site_url(uri_string())?>" id="form" class="form" method="post">
          <div class="form-body lapak">
            <?php if($this->ion_auth->is_admin_area()) { ?>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <div class="alert alert-info">
                   Atasan 1 dan atasan 2 Wajib diisi oleh Admin Area
                    <?php //echo validation_errors(); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label class="control-label">Atasan 1</label>
                  <select id="superior_id" name="superior_id" style="width: 100%">
                    <option value="">Pilih Atasan 1</option>
                    <?php foreach ($superior_id as $key => $value) { ?>
                      <?php $selected = ($value['sales_id'] == $valuesuperior_id) ? 'selected="selected"' : '' ?>
                      <option value="<?php echo $value['sales_id']; ?>" <?php echo $selected ?> > <?php echo $value['title']; ?></option>
                    <?php }?>
                  </select>
                  <span class="help-block"></span>
                  <?php echo form_error('superior_id', '<div class="alert alert-error">', '</div>'); ?>
                </div>
                <div class="col-md-6">
                  <label class="control-label">Atasan 2</label>
                  <select id="next_superior_id" name="next_superior_id" style="width: 100%">
                    <option value="">Pilih Atasan 2</option>
                    <?php foreach ($next_superior_id as $key => $value) { ?>
                      <?php $selected = ($value['sales_id'] == $valuenext_superior_id) ? 'selected="selected"' : '' ?>
                      <option value="<?php echo $value['sales_id']; ?>" <?php echo $selected ?> > <?php echo $value['title']; ?></option>
                    <?php }?>
                  </select>
                  <span class="help-block"></span>
                  <?php echo form_error('next_superior_id', '<div class="alert alert-error">', '</div>'); ?>
                  
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12 text-right">
                  <?php if($valuesuperior_id != 0 || $valuenext_superior_id != 0) { ?>
                    <button type="button" class="btn btn-info" disabled="disabled">Approved</button>
                  <?php }else { ?>
                    <button type="submit" class="btn btn-info">Approve</button>
                  <?php } ?>
                  <button type="cancel" class="btn btn-danger">Cancel</button>
                </div>
                
              </div>
            </div>
            <?php } ?>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12"><label class="control-label">Nama Lapak</label></div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <?php echo bs_form_input($lapak_id); ?>
                  <span class="help-block"></span>
                </div>
                <div class="col-md-6">
                  <input type="hidden" value="<?php echo $this->session->userdata('user_id')?>" name="sales_id"/>
                  <?php echo bs_form_input($title_input);?>
                  <span class="help-block"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <label class="control-label">Berlaku</label>
                </div>
                <div class="col-md-4">
                  <?php echo bs_form_input($start_active);?>
                  <span class="help-block"></span>
                </div>
                <div class="col-md-1">
                  s.d
                </div>
                <div class="col-md-4">
                  <?php echo bs_form_input($end_active);?>
                  <!-- <input name="end_date" placeholder="End Date" class="form-control" type="text" id="dt2"> -->
                  <span class="help-block"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label class="control-label">Propinsi</label>
                  <?php if(strlen($propinsi_name) > 0 && $propinsi_id != 0) { ?>
                    <input type="text" value="<?php echo $propinsi_name ?>" class="form-control" disabled="disabled" id="propinsi_name">
                  <?php } ?>
                  
                  <span class="help-block"></span>
                </div>
                <div class="col-md-4">
                  <label class="control-label">Kota/Kabupaten</label>
                  <?php if(strlen($kabupaten_name) > 0 && $kabupaten_id != 0) { ?>
                    <input type="text" value="<?php echo $kabupaten_name ?>" class="form-control" disabled="disabled" id="kabupaten_name">
                  <?php } ?>
                  
                  <span class="help-block"></span>
                </div>
                <div class="col-md-4">
                  <label class="control-label">Nama Sekolah</label>
                  <?php //echo bs_form_input($school_name);?>
                  <?php if(strlen($sekolah_name) > 0 && $sekolah_id != 0) { ?>
                    <input type="text" value="<?php echo $sekolah_name ?>" class="form-control" disabled="disabled" id="sekolah_name">
                  <?php } ?>
                  <span class="help-block"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label class="control-label">Nama Agen</label>
                  <?php if(strlen($agen_name) > 0 && $agen_id != 0) { ?>
                    <input type="text" value="<?php echo $agen_name ?>" class="form-control" disabled="disabled" id="agen_name">
                  <?php } ?>
                  
                  <span class="help-block"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label class="control-label">Disc. Agen (%)</label>
                  <?php echo bs_form_input($agen_disc);?>
                  <span class="help-block"></span>
                </div>
                <div class="col-md-4">
                  <label class="control-label">Diskon Pembeli (%)</label>
                  <?php echo bs_form_input($buyer_disc);?>
                  <span class="help-block"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <div id="lapak_buku_id">
                    <h3>BUKU</h3>
                    <?php if($lapak_buku->num_rows() > 0) { ?>
                    <table class="table">
                      <?php foreach ($lapak_buku->result_array() as $key => $value) { ?>
                        <tr>
                          <!-- <td><img src="<?php echo $value['cover'] ?>"></td> -->
                          <td>
                            <img src="http://placehold.it/100x125">
                          </td>
                          <td>
                            <?php echo $value['judul'] .'<br/>IDR. '.number_format($value['harga']) ?>; 
                          </td>
                          <td>
                            <?php echo $value['jenjang']?>; 
                          </td>
                          <!-- <td>
                            <button type="button" class="btn btn-danger" onClick="delete_lapak_buku(<?php echo $value['lapak_id']?>,<?php echo $value['id']?>)"><i class="fa fa-trash"></i></button>
                          </td> -->
                        </tr>
                      <?php } ?>
                      
                    </table>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <label class="control-label">Notes</label>
                  <?php echo bs_form_textarea($notes)?>
                  <!-- <textarea class="form-control" name="notes"></textarea> -->
                  <span class="help-block"></span>
                </div>
              </div>
            </div>
            <!-- <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label class="control-label">Atasan Langsung</label>
                  <input name="superior_id" placeholder="Atasan Langsung" class="form-control" type="text">
                  <span class="help-block"></span>
                </div>
                <div class="col-md-4">
                  <label class="control-label">Atasan Tidak Langsung</label>
                  <input name="next_superior_id" placeholder="Atasan Tidak Langsung" class="form-control" type="text">
                  <span class="help-block"></span>
                </div>
              </div>
            </div> -->
            
          </div>
        </form>
</div>
</div>
</div>
</div>

<div id="modal_form_agen" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title_agen">Agen Form</h3>
      </div>
      <div class="modal-body">
        <form action="#" id="form_agen" class="form">
          <input type="hidden" value="<?php echo $this->session->userdata('user_id')?>" name="create_user_id"/> 
          <div class="form-body lapak">
            <div class="form-group_agen">
              <div class="row">
                <div class="col-md-12">
                  <label class="control-label">username</label>
                  <input name="username" placeholder="Username" class="form-control" type="text">
                  <span class="help-block_agen"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label class="control-label">Nama</label>
                  <input name="first_name" placeholder="Username" class="form-control" type="text">
                  <span class="help-block_agen"></span>
                </div>
                <div class="col-md-6">
                  <label class="control-label">Email</label>
                  <input name="email" placeholder="email" class="form-control" type="text">
                  <span class="help-block_agen"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label class="control-label">password</label>
                  <input name="password" placeholder="password" class="form-control" type="text" id="password">
                  <?php echo bs_form_button($gen_password,'Generate Password');?>
                  <span class="help-block_agen"></span>
                </div>
              </div>
            </div>
          </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      
    </div>
  </div>
</div> 


<div id="modal_form_buku" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title_buku">Tambah Buku</h3>
      </div>
      <div class="modal-body">
        <form action="#" id="form_buku" class="form">
          <div class="form-body lapak">
            <div class="form-group_buku">
              <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                  <div class="col-md-10">
                    <div class="row">
                      <div class="col-md-12">
                        <input name="kode_buku" id="kode_buku" type="text" style="width: 100%" placeholder="Kode Buku">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <label class="control-label">Jenjang</label>
                        <select id="jenjang" name="jenjang" style="width: 100%">
                          <option value="0">Pilih Jenjang</option>
                          <option value="SD">SD</option>
                          <option value="SMP">SMP</option>
                          <option value="SMA">SMA</option>
                        </select>
                      </div>
                      <div class="col-md-8">
                        <label class="control-label">Judul Buku</label>
                        <input name="judul_buku" id="judul_buku" placeholder="Judul Buku" type="text" style="width: 100%">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <input type="hidden" value="<?php echo $this->uri->segment(3)?>" name="lapak_id"/>
                    <button type="button" id="btnSearch" onclick="search_buku()" class="btn btn-primary">Search</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </form>
        
            <div id="table_buku" class="table_buku"></div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      
    </div>
  </div>
</div> 
  
