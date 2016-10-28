<div class="page-content" <?php if($this->ion_auth->is_sales()) { ?> style="margin-left:0px" <?php } ?>>
  <div class="content">
  <div class="grid simple">    
    <div>
    <div class="row">
        <div class="col-md-4">
      <div class="tiles green ">
          <div class="tiles-body">
	  <div class="tiles-title">TOTAL PENJUALAN</div>
        <?php $penjualan = GetOrderSalesbySales($this->session->userdata('user_id')); ?>
          <?php if($penjualan->num_rows() > 0) { ?>
            <?php $value = $penjualan->row_array(); ?>
            <div class="">Rp. <?php echo number_format($value['total_order'])?></div>
          <?php }else{ ?>
             <div class="">Rp. 0</div> 
          <?php } ?>
              </div>
            </div>
      </div>
        <div class="col-md-4">
      <div class="tiles red">
          <div class="tiles-body">
         <div class="tiles-title">STATUS LAPAKk</div>
        <ul>
            <?php $summary = GetLapakSummarybySales($this->session->userdata('user_id'));?>
            <?php if($summary->num_rows() > 0) { ?>
              <?php foreach ($summary->result_array() as $key => $value) { ?>
                <li><?php echo $value['jumlah_lapak'].' '.strtoupper($value['status_lapak']);?></li>
              <?php } ?>
            <?php }else{ ?>
              <li>Area ini belum mempunyai lapak</li>
            <?php } ?>
          </ul>
          </div>
        </div>
        </div>
        <div class="col-md-4">
      <div class="tiles blue">
        <div class="tiles-body">
          <div>
            <a href="#" onClick="add_agen()">
              <button class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Tambah Agen Baru</button>
            </a>
          </div>
          <br/>
          <div>
            <a href="<?php echo site_url('lapak/create')?>">
              <button class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Buat Lapak Baru</button>
            </a>
          </div>
          </div>
      </div>
        </div>
    </div>
    </div>
    </div>

    <div class="grid simple">
      <div class="row">
        <div class="col-md-12">
          <?php echo $this->session->flashdata('message_success');?>
          <input type="hidden" id="controller_name" value="<?php echo $controller_name; ?>">
          <div class="grid-title">
            <div class="row">
              <div class="col-md-6">
                <h3><span class="semi-bold">Lapak Saya</span></h3>
              </div>
              <div class="col-md-6 text-right">
                <a href="<?php echo site_url('lapak/create')?>">
                  <!-- <button class="btn btn-success" onclick="add_lapak()"><i class="glyphicon glyphicon-plus"></i> Lapak</button> -->
                  <button class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Buat Lapak Baru</button>
                </a>
              </div>
            </div>
          </div>
          <div class="grid-body ">
            <table id="table" class="table table-bordered" cellspacing="0" width="100%">
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
                  <th width="150px">Tgl Berlaku</th>
                  <th width="150px">Jumlah buku</th>
                  <th width="150px">Status aktif</th>
                  <th width="150px">Tanggal aktif</th>
                  <th width="150px">User yg mengaktifkan</th>
                  <th width="150px">Action</th>
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


        



        
  