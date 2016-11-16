var save_method; //for save method string
var table_admin;
var table_admin_area;
var table_status;
var controller_name;
var base_url = $("#base_url").val();
$.fn.modal.Constructor.prototype.enforceFocus = function () {};
$(document).ready(function() {

  controller_name = $('#controller_name').val();

  var order_status = $('#order_status').val();


  table_admin = $('#table_admin').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    "ajax": {
        "url": base_url + controller_name + "/ajax_admin_list",
        "type": "POST"
    },

    "columnDefs": [
    { 
      "targets": [ -1 ], //last column
      "orderable": false, //set not orderable
    },
    ],
    "oLanguage": {
         "sSearch": "Title :"
       }

  });


  //$("#order_status_id").select2();
  $("#order_status_id").css('width','250px');

  $('#table_wrapper .dataTables_filter input').addClass("input-medium ");
  $('#table_wrapper .dataTables_length select').addClass("select2-wrapper span12"); 
	
});



function save()
{
  controller_name = $('#controller_name').val();
  $('#btnSave').text('saving...'); //change button text
  $('#btnSave').attr('disabled',true); //set button disable 
  var url;
  if(save_method == 'add') 
  {
      //url = "<?php echo site_url('lapak/ajax_add')?>";
      url = 'http://localhost/bukulapak/'+controller_name + "/ajax_add";
  }
  else
  {
    //url = "<?php echo site_url('lapak/ajax_update')?>";
    url = controller_name + "/ajax_update";
  }

   // ajax adding data to database
      $.ajax({
        url : url,
        type: "POST",
        data: $('#form_agen').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form_agen').modal('hide');
                $('#agen_id').html(data.data_agen);
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('#form_agen [name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('#form_agen [name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
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
    });
}


function delete_lapak(id)
{
  controller_name = $('#controller_name').val();
  if(confirm('Are you sure delete this data?'))
  {
    // ajax delete data to database
      $.ajax({
        //url : "<?php echo site_url('lapak/ajax_delete')?>/"+id,
        url : controller_name + "/ajax_delete/"+id,
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {
           //if success reload ajax table
           $('#modal_form').modal('hide');
           reload_table();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
     
  }
}
