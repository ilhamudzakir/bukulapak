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
                            <div class="col-md-6"> <span class="head-title">Pesanan > <?php echo $order['order_code']; ?></span> </br>
                                </br>
                                <?php if($order[ 'order_status_id']>=2){ ?>
                                <a href="<?php echo base_url() ?>order/download_surat/<?php echo $order['order_id'] ?>">
                                    <button class='btn btn-info btn-cons' type='button'><i class='fa fa-cloud-download'></i> Download Surat Pesanan</button>
                                </a>
                                <?php } ?> </div>
                            <div class="col-md-6 text-right"> <span class="subhead-title">Status : <?php echo $order['order_status']; ?></span> </div>
                        </div>
                    </div>
                    <div class="grid-body ">
                        <div class="row detail-pesanan">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h4>Detail pesanan</h4> </div>
                        </div>
                        <div class="row order-item-info">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <h4>Data lengkap</h4>
                                        <div class="form form-group">
                                            <label>Nama pemesan</label>
                                            <label><strong><?php echo strtoupper($order['order_name'])?></strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                        <div class="form form-group">
                                            <label>Email pemesan</label>
                                            <label><strong><?php echo strtolower($order['order_email'])?></strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form form-group">
                                            <label>Telepon pemesan</label>
                                            <label><strong><?php echo strtoupper($order['order_phone'])?></strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <h4>Alamat pengiriman</h4>
                                        <div class="form form-group">
                                            <label>Nama penerima</label>
                                            <label><strong><?php echo strtoupper($order['order_recipient_name'])?></strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form form-group">
                                            <label>Alamat penerima</label>
                                            <label><strong><?php echo strtolower($order['order_recipient_address'])?></strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form form-group">
                                            <label>Telepon penerima</label>
                                            <label><strong><?php echo strtoupper($order['order_recipient_phone'])?></strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <h4>Status Pesanan</h4>
                                <?php if($order_history->num_rows() > 0) { ?>
                                <ul class="ul-order-history" id="ul-order-history">
                                    <?php $no=0; foreach ($order_history->result_array() as $key => $value) { $x=$no-1; $i=$value['order_status_id']; ?>
                                    <li class="row">
                                        <div class="col-md-5"><strong><?php echo $value['order_status']?></strong>
                                            <br>
                                            <?php echo date( 'd M Y H:i',strtotime($value[ 'create_date']))?>
                                            <?php if($value[ 'username']) { ?>
                                            <?php echo 'oleh : '. $value[ 'username']. ', ';?>
                                            <?php } ?>
                                            <?php if($value[ 'catatan']) { ?>
                                            <?php echo 'catatan : '. $value[ 'catatan'];?>
                                            <?php } ?>
                                            <br>
                                            <?php if($i==2 ) echo '<span style="text-decoration:underline; cursor:pointer" onClick="lihatconfirmationimg('.$value[ 'order_id']. ','.$x. ')">Detail Konfirmasi</span>'?> </div>
                                        <div class="col-md-5" <?php if($no>1){?> style="display: none"
                                            <?php } ?>>
                                            <?php if($i==2 and $next_order_status_title!='' ) { ?>
                                            <?php if($next_order_status_id !=3 ){ ?>
                                            <?php if($this->ion_auth->is_admin_area()) { ?>
                                            <button type="button" class="btn btn-danger" onClick="ubahstatus()">Ubah status :
                                                <?php echo $next_order_status_title; ?>
                                            </button>
                                            <?php }elseif($this->ion_auth->is_admin()){ ?>
                                            <?php }} ?>
                                            <?php }else{ ?>
                                            <?php //if($this->ion_auth->) { ?>
                                            <?php if($cek_rekening==0 and $next_order_status_title!='' ) { ?>
                                            <?php if($this->ion_auth->is_admin()) { ?>
                                            <button type="button" class="btn btn-danger" onClick="ubahstatus()">Ubah status :
                                                <?php echo $next_order_status_title; ?>
                                            </button>
                                            <?php }?>
                                            <?php }else{ ?>
                                            <?php if($this->ion_auth->is_admin_area()) { ?>
                                            <button type="button" class="btn btn-danger" onClick="ubahstatus()">Ubah status :
                                                <?php echo $next_order_status_title; ?>
                                            </button>
                                            <?php }?>
                                            <?php }?>
                                            <?php } ?> </div>
                                    </li>
                                    <?php $no++;} ?> </ul>
                                <?php } ?> </div>
                        </div>
                        <div class="row order-history"> </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h4>Data Order Buku</h4> </br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <?php echo $items_order ?>
                                        <div class="row border-top-bottom">
                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                                <label>Ongkos Kirim : </label>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-right">
                                                <label>
                                                    <?php echo 'IDR. '.number_format($order[ 'order_shipping_price'])?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                                <h3><?php echo 'IDR. '.number_format($order['order_total'])?></h3> </div>
                                        </div>
                                    </div>
                                </div>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">Detail transaksi konfirmasi pembayaran</h3> </div>
            <div class="modal-body form text-center"> <img id="confirm_img" width="300" src=""> </div>
            <div class="modal-footer text-left">
                <div class="row">
                    <div class="col-md-12" id="metode"> <b>Metode Pembayaran</b> </div>
                    <div class="col-md-12" id="namapeng"> <b>Nama Pengirim</b> </div>
                    <div class="col-md-12" id="namabank"> <b>Nama Bank</b> </div>
                    <div class="col-md-12" id="notes"> <b>Notes</b> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">Ubah Status : <?php echo $next_order_status_title;?> </h3> </div>
            <div class="modal-body form">
                <form action="#" id="form" class="add_order_status">
                    <ul>
                        <?php if($next_order_status_id==5 ) { ?>
                        <li class="row">
                            <label class="control-label col-md-12">Nama Operator (wajib diisi)</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="operator" required id="operator"> <span class="help-block"></span> </div>
                        </li>
                        <?php } ?>
                        <li class="row">
                            <label class="control-label col-md-12">Catatan (wajib diisi)</label>
                            <div class="col-md-12">
                                <?php if($next_order_status_id==3 ) { $value_msg='Pembayaran sudah diterima, admin area dipersilahkan melanjutkan proses pengiriman barang' ; }elseif($next_order_status_id==4 ) { $value_msg='pesanan sedang diproses' ; }elseif($next_order_status_id==5 ) { $value_msg='Barang telah dikirim dengan nomor resi pengiriman = ' ; }else{ $value_msg='' ; } ?>
                                <textarea class="form-control" name="catatan" id="catatan">
                                    <?php echo $value_msg?>
                                </textarea> <span class="help-block"></span> </div>
                        </li>
                        <?php if($next_order_status_id==5 ) { ?>
                        <li class="row">
                            <label class="control-label col-md-12">No Resi (wajib diisi)</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="resi" name="resi" required> </br>
                                <div id="alert" class="alert alert-error hide col-md-12">No.Resi Wajib diisi</div>
                            </div>
                        </li>
                        <?php } ?>
                        <li class="row">
                            <?php if($next_order_status_id==3 ) { ?>
                            <p class="col-md-12">pastikan pembayaran sudah diterima rekening
                                <br/>jika status sudah dirubah ke "pembayaran diterima" maka notifikasi akan diberikan
                                <br/> kepada admin area untuk memproses pengiriman barang</p>
                            <?php }elseif($next_order_status_id==4 ) { ?>
                            <p class="col-md-12">pastikan barang tersedia
                                <br/>jika status sudah dirubah ke "pembayaran diproses" maka notifikasi akan diberikan
                                <br/> kepada pemesan bahwa pesanan sedang diproses</p>
                            <?php }elseif($next_order_status_id==5 ) { ?>
                            <p class="col-md-12">pastikan barang tersedia
                                <br/>jika status sudah dirubah ke "barang dikirim" maka notifikasi akan diberikan
                                <br/> kepada pemesan bahwa barang telah dikirim beserta nomor resi pengiriman</p>
                            <?php } ?> </li>
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