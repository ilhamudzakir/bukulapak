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
                <span class="head-title">Detail Layout Email</span>
              </div>
             
            </div>

          </div>

          <div class="grid-body ">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <form onSubmit="document.my_form.content.value = $('.Editor-editor').html()" name="my_form" method="post" enctipe="multipart/form-data" class="form" action="<?php echo base_url() ?>static_page/update">
                  <input type="hidden" name="id" value="<?php echo $static->id ?>">
                  
                  <div class="form-group">
              <label class="control-label col-md-2">Title</label>
              <div class="col-md-10">
              <input type="text" class="form-controll col-md-12" name="title" readonly value="<?php echo $static->title ?>">
               
                <span class="help-block"></span>
              </div>
              <div class="clearfix"></div>
            </div>


            <div class="form-group">
              <label class="control-label col-md-2">Content</label>
              <div class="col-md-10">
               <textarea name="content" class="form-controll col-md-12" id="txtEditor"><?php echo str_replace('src="', 'src="'.base_url(),$static->content) ?></textarea>
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