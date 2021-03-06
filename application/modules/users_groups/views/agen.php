<div class="page-content">
  <div class="content">
    <div class="grid simple">
    <input type="hidden" id="controller_name" value="<?php echo $controller_name; ?>">
    <div class="grid-title">
      <h3>Users Groups <?php echo ucwords($this->uri->segment(2)); ?></h3>
    </div>
    <div class="grid-body ">
      <a href="<?php echo site_url('users_groups/create_user/4')?>"
        <button class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add</button>
      </a>
    <br />
    <br />
    <table id="table_agen" class="table" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>Id</th>
          <th>User ID</th>
          <th>Username</th>
          <th>Group Name</th>
          <th>Active</th>
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
        <h3 class="modal-title">groups Form</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Title</label>
              <div class="col-md-9">
                <input type="hidden" value="" name="id"/> 
                <input name="name" placeholder="name" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">description</label>
              <div class="col-md-9">
                <input name="description" placeholder="Description" class="form-control" type="text">
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
        
  