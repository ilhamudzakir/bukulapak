<div class="page-content">
  <div class="content">
    <div class="grid simple">
    <div class="grid-title">
      <h3>Config Ongkos Kirim</h3>
    </div>
    <div class="grid-body ">
    <form action="area_shipping/update_cost_config" method="post" enctype="multipart/form-data">
     <div class="row">
       <div class="col-md-6 col-xs-6">
        <div class="formm-control">
        <select name="free" class="form-control">
          <option <?php if($cost->free==1){ echo "selected"; } ?> value="1">Free Cost</option>
          <option <?php if($cost->free==0){ echo "selected"; } ?> value="0">Pay Cost</option>
        </select></br>
        </div>
         <button type="submit" class="btn btn-success">Update</button>
       </div>
     </div>
     
    </form>
    </div>
    </div>

    <div class="grid simple">
    <input type="hidden" id="controller_name" value="<?php echo current_url(); ?>">
    <div class="grid-title">
      <h3>Data Ongkos Kirim</h3>
    </div>
    <div class="grid-body ">
      <button class="btn btn-success" onclick="add_area_shipping()"><i class="glyphicon glyphicon-plus"></i> Add Ongkos Kirim</button> <button class="btn btn-success" onclick="add_ongkir()"><i class="glyphicon glyphicon-plus"></i> Upload Ongkos Kirim</button>
    <br />
    <br />
    <table id="table" class="table" cellspacing="0" width="100%">
      <thead>
        <tr>
        <?php if($this->ion_auth->is_admin()){ ?>
          <th>Area</th>
          <?php } ?>
          <th>Tujuan Propinsi</th>
          <th>Tujuan Kabupaten</th>
          <th>Reguler</th>
          <th>Ok</th>
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
        <h3 class="modal-title">area_shipping Form</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <div class="form-body">
           <input type="hidden" value="" name="id"/> 
          <?php if($this->ion_auth->is_admin()){ ?>
            <div class="form-group">
              <label class="control-label col-md-3">Area</label>
              <div class="col-md-9">
               <select id="area_id" name="area_id" style="width: 100%">
                    <option value="0">Pilih Area</option>
                    <?php foreach ($area as $key => $value) { ?>
                      <?php $selected = ($value['id'] == $area_id) ? 'selected="selected"' : '' ?>
                      <option value="<?php echo $value['id']; ?>" <?php echo $selected ?> > <?php echo $value['title']; ?></option>
                    <?php }?>
                  </select>
                <span class="help-block"></span>
              </div>
            </div>
            <?php }else{ ?>
            <input value="<?php echo $area->area_id ?>" type="hidden" name="area_id">
            <?php } ?>
            <div class="form-group">
              <label class="control-label col-md-3">Tujuan Propinsi</label>
              <div class="col-md-9">
                <select id="propinsi_id" name="propinsi_id" style="width: 100%" onChange="getkabupaten()">
                    <?php if($propinsi_id!=''){ ?> <?php }else{ ?><option value="0">Pilih propinsi</option><?php } ?>
                    <?php foreach ($propinsi as $key => $value) { ?>
                      <?php $selected = ($value['propinsi_id'] == $propinsi_id) ? 'selected="selected"' : '' ?>
                      <option value="<?php echo $value['propinsi_id']; ?>" <?php echo $selected ?> > <?php echo $value['title']; ?></option>
                    <?php }?>
                  </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Tujuan Kabupaten</label>
              <div class="col-md-9">
                <select id="kabupaten_id" name="kabupaten_id" style="width: 100%">
                  <option value="0">Pilih Kabupaten</option>
                  <?php foreach ($kabupaten as $key => $value) { ?>
                    <?php $selected = ($value['kabupaten_id'] == $kabupaten_id) ? 'selected="selected"' : '' ?>
                    <option value="<?php echo $value['kabupaten_id']; ?>" <?php echo $selected ?> > <?php echo $value['title']; ?></option>
                  <?php }?>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Harga Reguler</label>
              <div class="col-md-9">
                <input  name="reguler" placeholder="harga Reguler" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Harga Ok</label>
              <div class="col-md-9">
                <input name="ok" placeholder="harga Ok" class="form-control" type="text">
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
        
  