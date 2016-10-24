<div class="page-content">
  <div class="content">

  <div class="grid simple">
    <div class="grid-title">
      <h3>Rangkuman</h3>
    </div>
    <div class="grid-body ">
    <div class="row">
      <div class="col-md-6">
        <?php $penjualan = GetOrderSalesbySales($this->session->userdata('user_id')); ?>
          <?php if($penjualan->num_rows() > 0) { ?>
            <?php $value = $penjualan->row_array(); ?>
            <div class="">IDR. <?php echo number_format($value['total_order'])?></div>
          <?php }else{ ?>
             <div class="">IDR. 0</div> 
          <?php } ?>
      </div>
      <div class="col-md-6">
        <h2>Lapak</h2>
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


    <div class="grid simple">
      <div class="row">
        <div class="col-md-12">
          <?php echo $this->session->flashdata('message');?>
          <input type="hidden" id="controller_name" value="<?php echo $controller_name; ?>">
          <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
          <div class="grid-title">
            <div class="row">
              <div class="col-md-12">
                <span class="head-title">Pesanan</span>
                <select name="order_status_id" id="order_status_id" onChange="changeorderstatus()">
                  <!-- <option value="">Pilih Status</option> -->
                  <!-- <option value="99" <?php //echo ($this->session->userdata('order_status_id') == 99)? 'selected="selected"' : '' ;?> >Today</option> -->
                  <option value="0" <?php echo ($this->session->userdata('order_status_id') == 0)? 'selected="selected"' : '' ;?>>Status: ALL</option>
                  <option value="1" <?php echo ($this->session->userdata('order_status_id') == 1)? 'selected="selected"' : '' ;?>>Status: Order</option>
                  <option value="2" <?php echo ($this->session->userdata('order_status_id') == 2)? 'selected="selected"' : '' ;?>>Status: Konfirmasi pembayaran</option>
                  <option value="3" <?php echo ($this->session->userdata('order_status_id') == 3)? 'selected="selected"' : '' ;?>>Status: Pembayaran diterima</option>
                  <option value="4" <?php echo ($this->session->userdata('order_status_id') == 4)? 'selected="selected"' : '' ;?>>Status: Pesanan diproses</option>
                  <option value="5" <?php echo ($this->session->userdata('order_status_id') == 5)? 'selected="selected"' : '' ;?>>Status: Barang dikirim</option>
                  <option value="6" <?php echo ($this->session->userdata('order_status_id') == 6)? 'selected="selected"' : '' ;?>>Status: Barang diterima</option>
                  <option value="7" <?php echo ($this->session->userdata('order_status_id') == 7)? 'selected="selected"' : '' ;?>>Status: Pesanan dibatalkan</option>
                </select>
              </div>
            </div>
          </div>
       <?php if($this->session->userdata('order_status_id') == 2){ ?>
          <div class="row ">
         
             <div class="col-md-12">
               <div class="grid-title">
          <div>
            <h5><b>Report Konfirmasi Pembayaran</b></h5>
          </div>
         
          <div class="form-group">
         
          <label>Dari Tanggal</label>
          <div class="row">
          <div class="col-md-5">
          <div class="row">
          <div class="col-md-4 col-xs-4">
          <select id="tgl1" name="tgl" class="form-control" >

            <option value="0">Tgl</option>
            <?php for($a=1;$a<=31;$a++){ ?>
            <option value="<?php if($a<10){ echo"0";} echo $a ?>"><?php if($a<10){ echo"0";} echo $a ?> </option>
            <?php } ?>
            </select>
          </div>
          <div class="col-md-4 col-xs-4">
          <select id="bln1" name="bln" class="form-control" >

            <option value="0">Bln</option>
            <?php for($a=1;$a<=12;$a++){ ?>
            <option value="<?php if($a<10){ echo"0";} echo $a ?>"><?php if($a<10){ echo"0";} echo $a ?> </option>
            <?php } ?>
            </select>
          </div>

           <div class="col-md-4 col-xs-4">
          <select id="thn1" name="thn" class="form-control" >

            <option value="0">Thn</option>
            <?php for($a=2000;$a<=date('Y');$a++){ ?>
            <option value="<?php if($a<10){ echo"0";} echo $a ?>"><?php if($a<10){ echo"0";} echo $a ?> </option>
            <?php } ?>
            </select>
          </div>

          </div>
          </div>
          </div>
          </div>
           <div class="form-group">
         
          <label>Sampai Tanggal</label>
          <div class="row">
          <div class="col-md-5">
          <div class="row">
          <div class="col-md-4 col-xs-4">
          <select id="tgl2" name="tgl2" class="form-control" >

            <option value="0">Tgl</option>
            <?php for($a=1;$a<=31;$a++){ ?>
            <option value="<?php if($a<10){ echo"0";} echo $a ?>"><?php if($a<10){ echo"0";} echo $a ?> </option>
            <?php } ?>
            </select>
          </div>
          <div class="col-md-4 col-xs-4">
          <select id="bln2" name="bln2" class="form-control" >

            <option value="0">Bln</option>
            <?php for($a=1;$a<=12;$a++){ ?>
            <option value="<?php if($a<10){ echo"0";} echo $a ?>"><?php if($a<10){ echo"0";} echo $a ?> </option>
            <?php } ?>
            </select>
          </div>

           <div class="col-md-7 col-xs-4">
          <select id="thn2" name="thn2" class="form-control" >

            <option value="0">Thn</option>
            <?php for($a=2000;$a<=date('Y');$a++){ ?>
            <option value="<?php if($a<10){ echo"0";} echo $a ?>"><?php if($a<10){ echo"0";} echo $a ?> </option>
            <?php } ?>
            </select>
          </div>

          </div>
          </div>
          </div>
          </div>
          <div class="form-group">
          <div class="col-md-3">
            <button onclick="cek_orderbayar()" type="submit" class="btn btn-block btn-success ">Filter</button>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group" id="resultfilter">
          
          </div>
          
          </div>
          </div>
          </div>
          <?php } ?>
          <div class="grid-body ">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table id="table_admin" class="table table-striped datatable" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Kode Pesanan</th>
                      <th>Upload file</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Tlp</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Tanggal pesan</th>
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
      </div>
    </div>
  </div>
</div>