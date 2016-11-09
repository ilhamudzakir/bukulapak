var save_method; //for save method string
var table;
var controller_name;
$(document).ready(function() {
  controller_name = $('#controller_name').val();
  table = $('#table').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    // Load data for the table's content from an Ajax source
    "ajax": {
        "url": controller_name + "/ajax_list",
        "type": "POST"
    },

    //Set column definition initialisation properties.
    "columnDefs": [
    { 
      "targets": [ -1 ], //last column
      "orderable": false, //set not orderable
    },
    ],

  });

  $(".select2-wrapper").select2();

  $('#table_wrapper .dataTables_filter input').addClass("input-medium ");
  $('#table_wrapper .dataTables_length select').addClass("select2-wrapper span12"); 

  $("input").change(function(){
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
  });
  $("textarea").change(function(){
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
  });
  $("select").change(function(){
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
  });
  //HTML5 editor
  $('#sinopsis_html').wysihtml5();

});

function add_groups()
{
  controller_name = $('#controller_name').val();
  save_method = 'add';
  $('#form')[0].reset(); // reset form on modals
  $('.form-group').removeClass('has-error'); // clear error class
  $('.help-block').empty(); // clear error string
  $('#modal_form').modal('show'); // show bootstrap modal
  $('.modal-title').text('Upload Employe'); // Set Title to Bootstrap modal title
}

function add_employe()
{
  controller_name = $('#controller_name').val();
  save_method = 'add';
  $('#form_edit')[0].reset(); // reset form on modals
  $('.form-group').removeClass('has-error'); // clear error class
  $('.help-block').empty(); // clear error string
  $('#modal_form_edit').modal('show'); // show bootstrap modal
  $('.modal-title').text('Add Employe'); // Set Title to Bootstrap modal title
}
var base_url = $('#base_url').val();

function upload()
{
 
    var data = new FormData($('#form')[0]);
    $('#loading').show();
 
    $.ajax({
        type:"POST",
        url: base_url+"employe/upload/",
        data:data,
        mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success:function(data)
        {
          if(data.status = 'true'){
            $('#loading').hide();
          //if(data.status) {
            $('#form')[0].reset();
            $('#validation_errors').html(data.validation_errors);  
          //}  
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $('#loading').hide();
          //if(data.status) {
          $('#form')[0].reset();
          $('#validation_errors').html(data.validation_errors); 
        }
    });
 
}

function edit_employe(id)
{
  controller_name = $('#controller_name').val();
  save_method = 'update';
  $('#form_edit')[0].reset(); // reset form on modals
  $('.form-employe').removeClass('has-error'); // clear error class
   $('.help-block').empty(); // clear error string
  
  //Ajax Load data from ajax
  $.ajax({
    //url : "<?php echo site_url('groups/ajax_edit/')?>/" + id,
    url : controller_name + "/ajax_edit/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
        $('[name="id"]').val(data.id);
      $('[name="nik"]').val(data.nik);
       $('[name="email"]').val(data.email);
       $('[name="first_name"]').val(data.first_name);
         $('[name="last_name"]').val(data.last_name);
         $('[name="phone"]').val(data.phone);
        
      $('#modal_form_edit').modal('show'); // show bootstrap modal when complete loaded
      $('.modal-title').text('Edit employe'); // Set title to Bootstrap modal title
      
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    }
  });
}

function deleted(id){
    $.ajax({
    //url : "<?php echo site_url('groups/ajax_edit/')?>/" + id,
    url : controller_name + "/ajax_delete/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      table.ajax.reload(); 
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    }
  });
}

function save()
{
  controller_name = $('#controller_name').val();
  $('#btnSave').text('saving...'); //change button text
  $('#btnSave').attr('disabled',true); //set button disable 
  var url;
  if(save_method == 'add') 
  {
      //url = "<?php echo site_url('groups/ajax_add')?>";
      url = controller_name + "/ajax_add";
  }
  else
  {
    //url = "<?php echo site_url('groups/ajax_update')?>";
    url = controller_name + "/ajax_update";
  }

  var data = new FormData($('#form_edit')[0]);

   // ajax adding data to database
      $.ajax({
        url : url,
        type: "POST",
        data: data,
        mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form_edit').modal('hide');
                 table.ajax.reload();
                //reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('#form_edit [name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('#form_edit [name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
        /*success: function(data)
        {
           //if success close modal and reload ajax table
           $('#modal_form').modal('hide');
           reload_table();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }*/
    });


    
      
}
function change_publish(){
           if(confirm("Are you sure you want to change this?"))  
           {    
                var publish= $('#change').val();
                var id = [];  
                $(':checkbox:checked').each(function(i){  
                     id[i] = $(this).val();  
                });  
                if(id.length === 0) //tell you if the array is empty  
                {  
                     alert("Please Select atleast one checkbox");  
                }  
                else  
                {  
                     $.ajax({  
                          url:controller_name+'/change_publish',  
                          method:'POST',  
                          data:{id:id,publish:publish},  
                          success:function()  
                          {  
                                $("#alert").attr("class","alert alert-info");
                                 table.ajax.reload();
                                $('#change').val('');
                          }  
                     });  
                }  
           }  
           else  
           {  
                return false;  
           }  
}

