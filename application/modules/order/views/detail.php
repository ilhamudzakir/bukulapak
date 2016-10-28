<div class="page-content">
  <div class="content">
    <div class="grid simple">
      <div class="row">
        <div class="col-md-12">
          <?php echo $this->session->flashdata('message_success');?>
          <input type="hidden" id="controller_name" value="<?php echo $controller_name; ?>">
          <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
          <div class="grid-title">
            <div class="row">
              <div class="col-md-6">
                <span class="head-title">Pesanan > <?php echo $order['order_code']; ?></span>
              </div>
              <div class="col-md-6 text-right">
                <span class="subhead-title">Status : <?php echo $order['order_status']; ?></span>
              </div>
            </div>

          </div>

          <div class="grid-body ">
            <div class="row detail-pesanan">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h4>Detail pesanan</h4>
              </div>
            </div>
            <div class="row order-item-info">
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h4>Data lengkap</h4>
                    <div class="form form-group">
                      <label>Nama pemesan</label>
                      <label><strong><?php echo strtoupper($order['order_name'])?></strong></label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form form-group">
                      <label>Email pemesan</label>
                      <label><strong><?php echo strtolower($order['order_email'])?></strong></label>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form form-group">
                      <label>Telepon pemesan</label>
                      <label><strong><?php echo strtoupper($order['order_phone'])?></strong></label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h4>Alamat pengiriman</h4>
                    <div class="form form-group">
                      <label>Nama penerima</label>
                      <label><strong><?php echo strtoupper($order['order_recipient_name'])?></strong></label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form form-group">
                      <label>Alamat penerima</label>
                      <label><strong><?php echo strtolower($order['order_recipient_address'])?></strong></label>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form form-group">
                      <label>Telepon penerima</label>
                      <label><strong><?php echo strtoupper($order['order_recipient_phone'])?></strong></label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 border-all-side">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="no-list-type">
                    <?php if($items_order->num_rows() > 0) { ?>
                      <?php foreach ($items_order->result_array() as $key => $value) { ?>
                        <li class="row">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                              <img src="http://placehold.it/80x80">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                              <label><?php echo $value['judul_buku']?></label>
                              <label><?php echo $value['item_qty']?> buku</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-right">
                              <label><?php echo 'IDR. '.number_format($value['item_subtotal'])?></label>
                            </div>
                        </li>
                      <?php } ?>
                    <?php } ?>
                    </ul>
                    <div class="row border-top-bottom">
                      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"><label>Ongkos Kirim : </label></div>
                      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-right">
                        <label><?php echo 'IDR. '.number_format($order['order_shipping_price'])?></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                        <h3><?php echo 'IDR. '.number_format($order['order_total'])?></h3>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
            <div class="row order-history">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h4>History Status</h4>
                <?php if($order_history->num_rows() > 0) { $i=1; ?>
                <ul class="ul-order-history" id="ul-order-history">
                  <?php foreach ($order_history->result_array() as $key => $value) { ?>
                    <li class="row">
                        <div class="col-md-2"><?php echo $value['order_status']?></div>
                        <div class="col-md-5">
                          <?php echo date('d M Y H:i',strtotime($value['create_date']))?>
                          <?php if($value['username']) { ?>
                            <?php echo 'oleh : '. $value['username'].', ';?>
                          <?php } ?>
                          <?php if($value['catatan']) { ?>
                            <?php echo 'catatan : '. $value['catatan'];?>
                          <?php } ?> 
                        </div>
                        <div class="col-md-2">
                          <?php if($i == 2) echo '<label class="label label-info" onClick="lihatconfirmationimg()">Lihat gambar</label>'?>
                        </div>
                        <div class="col-md-3">
                          <?php 
                          if($i == $order_history->num_rows() && $i <=4) { ?>
                            <?php if($next_order_status_id != 3){ ?>
                              <?php if($this->ion_auth->is_admin_area()) { ?>
                                <label class="label label-inverse" onClick="ubahstatus()">Ubah status : <?php echo $next_order_status_title; ?></label>
                              <?php }elseif($this->ion_auth->is_admin()){ ?>
                                
                              <?php } ?>
                            <?php }else{ ?>
                              <?php //if($this->ion_auth->) { ?>
                              <?php if($cek_rekening == 0) { ?>
                                <?php if($this->ion_auth->is_admin()) { ?>
                                  <label class="label label-inverse" onClick="ubahstatus()">Ubah status : <?php echo $next_order_status_title; ?></label>
                                <?php }?>
                              <?php }else{ ?>
                                <?php if($this->ion_auth->is_admin_area()) { ?>
                                  <label class="label label-inverse" onClick="ubahstatus()">Ubah status : <?php echo $next_order_status_title; ?></label>
                                <?php }?>
                              <?php }?>
                            <?php } ?>
                          <?php } ?>
                          <?php $i++; ?>
                        </div>
                    </li>
                  <?php } ?> 
                  </ul>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_img" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Gambar bukti transfer / konfirmasi pembayaran </h3>
      </div>
      <div class="modal-body form text-center">
        <img src="<?php echo base_url().'uploads/transaksi/'.$img_confirmation  ?>" class="img img-responsive">
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Ubah Status : <?php echo $next_order_status_title;?> </h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="add_order_status">
          <ul>
            <?php if($next_order_status_id == 5) { ?>
              <li class="row">
                  <label class="control-label col-md-12">Nama Operator (wajib diisi)</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="operator" id="operator">
                    <span class="help-block"></span>
                  </div>
              </li>
            <?php } ?>
            
            <li class="row">
                <label class="control-label col-md-12">Catatan (wajib diisi <?php echo ($next_order_status_id == 5)? 'nomor resi' : '';?>)</label>
                <div class="col-md-12">
                  <?php if($next_order_status_id == 3) { 
                      $value_msg = 'Pembayaran sudah diterima, admin area dipersilahkan melanjutkan proses pengiriman barang';
                    }elseif($next_order_status_id == 4) { 
                      $value_msg = 'pesanan sedang diproses'; 
                    }elseif($next_order_status_id == 5) {  
                      $value_msg = 'Barang telah dikirim dengan nomor resi pengiriman = ......'; 
                    } ?>
                  <textarea class="form-control" name="catatan" id="catatan"><?php echo $value_msg?></textarea>
                  <span class="help-block"></span>
                </div>
            </li>

            <li class="row">
              <?php if($next_order_status_id == 3) { ?>
                <p class="col-md-12">pastikan pembayaran sudah diterima rekening<br/>jika status sudah dirubah ke "pembayaran diterima" maka notifikasi akan diberikan <br/>
                kepada admin area untuk memproses pengiriman barang</p>
              <?php }elseif($next_order_status_id == 4) { ?>
                <p class="col-md-12">pastikan barang tersedia<br/>jika status sudah dirubah ke "pembayaran diproses" maka notifikasi akan diberikan <br/>
                kepada pemesan bahwa pesanan sedang diproses</p>
              <?php }elseif($next_order_status_id == 5) { ?>
                <p class="col-md-12">pastikan barang tersedia<br/>jika status sudah dirubah ke "barang dikirim" maka notifikasi akan diberikan <br/>
                kepada pemesan bahwa barang telah dikirim beserta nomor resi pengiriman</p>
              <?php } ?>
            </li>
          </ul>
        
        <div class="modal-footer">
          <input name="order_email" class="form-control" type="hidden" value="<?php echo $order['order_email'];?>">
          <input name="order_name" class="form-control" type="hidden" value="<?php echo $order['order_name'];?>">
          <input name="order_code" class="form-control" type="hidden" value="<?php echo $order['order_code'];?>">
          <input name="admin_area_id" class="form-control" type="hidden" value="<?php echo $admin_area_id;?>">
          <input name="admin_area_name" class="form-control" type="hidden" value="<?php echo $admin_area_name;?>">
          <input name="admin_area_email" class="form-control" type="hidden" value="<?php echo $admin_area_email;?>">
          <input name="order_id" class="form-control" type="hidden" value="<?php echo $order['order_id'];?>">
          <input name="next_order_status_id" class="form-control" type="hidden" value="<?php echo $next_order_status_id;?>">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>