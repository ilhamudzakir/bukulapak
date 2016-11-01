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
                <span class="head-title">Detail Page <?php echo $static->title ?></span>
              </div>
             
            </div>

          </div>

          <div class="grid-body ">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
               <?php echo form_open_multipart('static_page/upload');?>
                  <input type="hidden" name="id" value="<?php echo $static->id ?>">
                   <div class="form-group">
              <label class="control-label col-md-2">Title</label>
              <div class="col-md-10">
               <input readonly name="title" placeholder="title" value="<?php echo $static->title ?>" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
              <div class="clearfix"></div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">File</label>
              <div class="col-md-10">
              <img width="200" src="<?php echo base_url() ?>assets/front/images/<?php echo $static->content ?>">
              </br></br>
               <input type="file" name="user_file" />
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