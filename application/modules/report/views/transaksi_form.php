<div class="page-content">
  <div class="content">
    <div class="grid simple">
    <input type="hidden" id="controller_name" value="<?php echo $controller_name; ?>">
    <div class="grid-title">
      <h3><?php echo $title ?></h3>
    </div>
    <div class="grid-body ">
      <?php echo validation_errors('<div class="alert alert-error">','</div>')?>
      
          <div class="form-body lapak">
           <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <label class="control-label">Periode</label>
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
              <div class="row">
              <div class="col-md-3">
                <button onclick="filter_transaksi()" type="submit" class="btn btn-block btn-success ">Filter</button>
              </div></div>
            </div>
        </div>
    </div> 
</br>
          <div class="grid-body" id="tablenya">
            <div class="row">
            <div class="col-md-3">
             <a id="url_download" href='<?php echo $controller_name ?>transaksi_csv/'><button class='btn btn-info btn-cons' type='button'><i class='
fa fa-cloud-download'></i> Download Excel</button></a>
            </div>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table id="table_admin" class="table table-striped datatable" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Order Code</th>
                      <th>Order Name</th>
                      <th>Order Email</th>
                      <th>Order Phone</th>
                      <th>Order Recipient Name</th>
                      <th>Order Recipient Address</th>
                      <th>Order Recipient Phone</th>
                      <th>Order Propinsi</th>
                      <th>Order Kabupaten</th>
                      <th>Order Kecamatan</th>
                      <th>Order Receipient Postcode</th>
                      <th>Order Shipping Price</th>
                      <th>Order Subtotal</th>
                      <th>Order Total</th>
                      <th>Order Date</th>
                      <th>Order Confirm</th>
                      <th>Order Date Confirm</th>
                      <th>Order Status</th>
                      <th>Area</th>
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


