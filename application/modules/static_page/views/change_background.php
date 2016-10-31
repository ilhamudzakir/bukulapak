<div class="page-content">
  <div class="content">

  

    <div class="grid simple">
      <div class="row">
        <div class="col-md-12">
          <?php echo $this->session->flashdata('message');?>
          <input type="hidden" id="controller_name" value="<?php echo $controller_name; ?>">
          <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
          <div class="grid-title">
            <div class="row">
              <div class="col-md-12">
                <span class="head-title">Static Page</span>
               
              </div>
            </div>
          </div>
          <div class="grid-body ">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table id="table_admin" class="table table-striped datatable" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Title</th>
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