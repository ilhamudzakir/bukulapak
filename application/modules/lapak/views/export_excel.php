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
              <div class="col-md-12">
                <span class="head-title">Export Excel</span>
              </div>
             
            </div>

          </div>

          <div class="grid-body ">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <form  name="my_form" method="post" enctipe="multipart/form-data" class="form" action="<?php echo base_url() ?>lapak/export">
                 

            <div class="form-group">
              <label class="control-label col-md-2">Username Sales</label>
              <div class="col-md-8">
               <input type="text" name="sales" class="form-controll" />
                <span class="help-block"></span>
              </div>
              <div class="clearfix"></div>
            </div>
			
			
			<div class="form-group">
              <label class="control-label col-md-2">Lapak Kode</label>
              <div class="col-md-8">
               <input type="text" name="kode_lapak" class="form-controll" />
                <span class="help-block"></span>
              </div>
              <div class="clearfix"></div>
            </div>
			
             <div class="form-group">
              <label class="control-label col-md-2">Active</label>
              <div class="col-md-8">
               <select name="active">
                 <option value="">All</option>
                 <option value="1">Active</option>
                 <option value="0">Inactive</option>
               </select>
                <span class="help-block"></span>
              </div>
              <div class="clearfix"></div>
            </div>

            <div class="form-group">

               <button type="submit" id="btnSave"  class="btn btn-primary">Save</button>
          <a href="<?php echo site_url('static_page') ?>"><button type="button" class="btn btn-danger">Back</button></a>
            </div>
                </form>
               </div>
              </div>
              </div> 
        </div>
        
      </div>
    </div>
  </div>
</div>