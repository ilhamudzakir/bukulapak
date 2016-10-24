<div class="page-content">
  <div class="content">
    <div class="grid simple">
    <input type="hidden" id="controller_name" value="<?php echo current_url(); ?>">
    <div class="grid-title">
      <h3>Data Area</h3>
    </div>
    <div class="grid-body ">
      <button class="btn btn-success" onclick="add_area()"><i class="glyphicon glyphicon-plus"></i> Add Area</button>
    <br />
    <br />
    <table id="table" class="table" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Location</th>
          <th>No Rek</th>
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
        <h3 class="modal-title">Area Form</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Title</label>
              <div class="col-md-9">
                <input type="hidden" value="" name="id"/> 
                <input name="title" placeholder="title" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">location</label>
              <div class="col-md-9">
                <input name="location" placeholder="location" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">no_rek</label>
              <div class="col-md-9">
                <input name="no_rek" placeholder="no_rek" class="form-control" type="text">
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
        
  