<div class="page-content">
  <div class="content">
    <div class="grid simple">
    <div class="grid-title">
      <h3>Rangkuman</h3>
    </div>
    <div class="grid-body ">
    <div class="row">
      <div class="col-md-6">
       <h4>Total Penjualan</h4>
          <?php $penjualan = GetOrderSalesbyArea($this->session->userdata('area_id')); ?>
          <?php if($penjualan->num_rows() > 0) { ?>
            <?php $value = $penjualan->row_array(); ?>
            <div class="">IDR. <?php echo number_format($value['total_order'])?></div>
          <?php }else{ ?>
             <div class="">IDR. 0</div> 
          <?php } ?>
      </div>
      <div class="col-md-6">
         <h4>Lapak</h4>
          <ul>
            <?php $summary = GetLapakSummarybyArea($this->session->userdata('area_id'));?>
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
    </div>
	
    <div class="grid simple">
      <div class="row">
        <div class="col-md-12">
          <?php echo $this->session->flashdata('message_success');?>
          <input type="hidden" id="controller_name" value="<?php echo $controller_name; ?>">
          <div class="grid-title">
            <div class="row">
              <div class="col-md-12">
                <h3>Data Lapak Sebagai Atasan 1</h3>
              </div>
            </div>
          </div>
          <div class="grid-body ">
            <table id="table_atasan_1" class="table" cellspacing="0" width="100%">
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



        
  