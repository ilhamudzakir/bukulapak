<div class="page-content">
  <div class="content">
    <div class="grid simple">
    <input type="hidden" id="controller_name" value="<?php echo current_url(); ?>">
    <div class="grid-title">
      <h3>Data Employe</h3>
    </div>
    <div class="grid-body ">
    <div id="alert" class="alert alert-info hide">Succses, Data Employe telah di perbarui</div>
      <button class="btn btn-success" onclick="add_groups()"><i class="glyphicon glyphicon-plus"></i> Upload Employe</button>
       <button class="btn btn-success" onclick="add_employe()"><i class="glyphicon glyphicon-plus"></i> Add Employe</button>
      <br />
    <br />
    <table id="table" class="table" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>NIK</th>
          <th>Email</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Phone</th>
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
        <h3 class="modal-title">Upload Employe</h3>
      </div>
      <div class="modal-body form">
        <div id="loading" style="display:none">
          <i class="fa fa-cog fa-spin"></i> Loading
        </div>
        <div id="validation_errors" class=""></div>
        <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-5">Unggah data Employe (.xls)</label>
              <div class="col-md-7">
                <input type="file" class="form border" name="upload_file" id="upload_file">
                <input type="hidden" id="base_url" name="base_url" value="<?php echo base_url()?>">
                <span class="help-block"></span>
              </div>
            </div>
            <!-- <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label class="grey">Unggah data buku (.xls)</label>
                <input type="file" class="form border" name="upload_file" id="upload_file">
                <input type="hidden" id="base_url" name="base_url" value="<?php echo base_url()?>">
                </div>
              </div>
            </div> -->
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="upload()" class="btn btn-primary">Upload</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modal_form_edit" role="dialog">
  <div class="modal-dialog modal-lg">
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">groups Form</h3>
      </div>
      <div class="modal-body">
        <form action="#" id="form_edit" class="form row" enctype="multipart/form-data">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">NIK</label>
              <div class="col-md-9">
                <input name="nik" placeholder="NIK" class="form-control" type="text" id="nik">
                 <input name="id" placeholder="NIK" class="form-control" type="hidden" id="nik">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Email</label>
              <div class="col-md-9">
                <input name="email" id="email" placeholder="Email" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>

             <div class="form-group">
              <label class="control-label col-md-3">First Name</label>
              <div class="col-md-9">
                <input name="first_name" id="first_name" placeholder="First Name" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
           
           <div class="form-group">
              <label class="control-label col-md-3">Last Name</label>
              <div class="col-md-9">
                <input name="last_name" id="last_name" placeholder="Last Name" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
           
            <div class="form-group">
              <label class="control-label col-md-3">Phone</label>
              <div class="col-md-9">
                <input name="phone" id="phone" placeholder="Phone" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
             
              <div class="col-md-12">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
            </div>

          </div>
          </form>
        
        
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>
        
  