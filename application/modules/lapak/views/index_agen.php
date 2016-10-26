<div class="page-content">
  <div class="content">
  <div class="grid simple">
    <div class="grid-title">
      <h3>Rangkuman</h3>
    </div>
    <div class="grid-body ">
    <div class="row">
      <div class="col-md-6">
      <h2>Total Penjualan</h2>
        <?php $penjualan = GetOrderSalesbyArea($this->session->userdata('area_id')); ?>
          <?php if($penjualan->num_rows() > 0) { ?>
            <?php $value = $penjualan->row_array(); ?>
            <div class="">IDR. <?php echo number_format($value['total_order'])?></div>
          <?php }else{ ?>
             <div class="">IDR. 0</div> 
          <?php } ?>
      </div>
      <div>
            <a href="#" onClick="edit_profile()">
              <button class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Edit Profile</button>
            </a>
          </div>
          <br/>
          <div>
            <a href="<?php echo site_url('lapak/change_password')?>">
              <button class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Ganti Password</button>
            </a>
          </div>
    </div>
    </div>
    </div>
	
    <div class="grid simple">
      <div class="row">
        <div class="col-md-12">
          <?php echo $this->session->flashdata('message_success');?>
          <input type="hidden" id="controller_name" value="<?php echo $controller_name; ?>">
          <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
          <div class="grid-title">
            <div class="row">
              <div class="col-md-12">
                <h3>Lapak Saya</h3>
              </div>
            </div>
          </div>
          <div class="grid-body ">
            <table id="table_agen" class="table" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th width="150px">Sales</th>
                  <th width="150px">Nama Lapak</th>
                  <th width="150px">Kode Lapak</th>
                  <th width="150px">Sekolah</th>
                  <th width="150px">Propinsi</th>
                  <th width="150px">Kabupaten</th>
                  <th width="150px">Agen</th>
                  <th width="150px">Disc Agen</th>
                  <th width="150px">Disc Pembeli</th>
                  <th width="150px">Notes</th>
                  <th width="150px">App atasan 1</th>
                  <th width="150px">Nama atasan 1</th>
                  <th width="150px">Tgl App atasan 1</th>
                  <th width="150px">App atasan 2</th>
                  <th width="150px">Nama atasan 2</th>
                  <th width="150px">Tgl App atasan 2</th>
                  <th width="150px">Tgl aktif</th>
                  <th width="150px">Jumlah buku</th>
                  <th width="150px">Status aktif</th>
                  <th width="150px">Tanggal aktif</th>
                  <th width="150px">User yg mengaktifkan</th>
                  <!-- <th width="150px">Action</th> -->
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>



<div id="modal_form_agen" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title_agen">Edit Profile</h3>
      </div>
      <div class="modal-body">
        <form action="#" id="form_agen" class="form">
          <input type="hidden" value="<?php echo $this->session->userdata('user_id')?>" name="create_user_id"/> 
          <div class="form-body lapak">
            <div class="form-group_agen">
              <div class="row">
                <div class="col-md-6">
                  <label class="control-label">User Id</label>
                  <input name="user_id" placeholder="user_id" class="form-control" type="text" disabled="disabled" value="<?php echo $this->session->userdata('user_id')?>">
                  <span class="help-block_agen"></span>
                </div>
                <div class="col-md-6">
                  <label class="control-label">Nama</label>
                  <input name="username" placeholder="Username" class="form-control" type="text" value="<?php echo GetUserNameLogin()?>">
                  <span class="help-block_agen"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label class="control-label">Email</label>
                  <input name="email" placeholder="email" class="form-control" type="text" value="<?php echo getemailbyid($this->session->userdata('user_id'))?>">
                  <span class="help-block_agen"></span>
                </div>
                <div class="col-md-6">
                  <label class="control-label">Telepon</label>
                  <input name="telepon" placeholder="telepon" class="form-control" type="text" id="telepon" value="<?php echo getphonebyid($this->session->userdata('user_id'))?>">
                  <span class="help-block_agen"></span>
                </div>
              </div>
            </div>
          </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save_profile(<?php echo $this->session->userdata('user_id')?>)" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      
    </div>
  </div>
</div> 


<div id="modal_form_password" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title_password">Ganti Password</h3>
      </div>
      <div class="modal-body">
        <form action="#" id="form_password" class="form">
          <input type="hidden" value="<?php echo $this->session->userdata('user_id')?>" name="user_id" id="user_id"/> 
          <div class="form-body lapak">
            <div class="form-group_password">
              <div class="row">
                <div class="col-md-12">
                  <label class="control-label">Password Lama</label>
                  <input name="password_lama" placeholder="password Lama" class="form-control" type="text">
                  <span class="help-block_password"></span>
                </div>
                
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label class="control-label">Password Baru</label>
                  <input name="password_baru" placeholder="password_baru" class="form-control" type="text">
                  <span class="help-block_password"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label class="control-label">Password Baru (sekali lagi)</label>
                  <input name="password_baru_confirm" placeholder="password_baru_confirm" class="form-control" type="text">
                  <span class="help-block_password"></span>
                </div>
              </div>
            </div>
          </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save_password(<?php echo $this->session->userdata('user_id')?>)" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      
    </div>
  </div>
</div> 


        



        
  