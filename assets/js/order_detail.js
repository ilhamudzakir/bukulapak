var save_method; //for save method string
var table;
var table_admin_area;
var table_status;
var controller_name;
var base_url = $("#base_url").val();
$.fn.modal.Constructor.prototype.enforceFocus = function () {};
$(document).ready(function() {

});

function ubahstatus()
{
  controller_name = $('#controller_name').val();
  save_method = 'add';
  $('#form')[0].reset(); // reset form on modals
  $('.form-group').removeClass('has-error'); // clear error class
  $('.help-block').empty(); // clear error string
  $('#modal_form').modal('show'); // show bootstrap modal
}

function lihatconfirmationimg(id,con)
{   

    $.ajax({
    url : base_url+"order/get_image_confirm/"+id+'/'+con,
    success : function(response){
    var duce = jQuery.parseJSON(response);
      $('#confirm_img').attr('src',base_url+'uploads/transaksi/'+duce.upload_file);
      document.getElementById("namabank").innerHTML = "<b>Nama Bank</b> : "+duce.confirmation_bank;
      document.getElementById("namapeng").innerHTML = "<b>Nama Pengirim</b> : "+duce.confirmation_name;
      document.getElementById("metode").innerHTML = "<b>Metode Pembayaran</b> : "+duce.confirmation_method;
      document.getElementById("notes").innerHTML = "<b>Notes</b> : "+duce.notes;
      $('#modal_img').modal('show'); // show bootstrap modal
          
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    },
    dataType: "html",
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
                url = base_url + controller_name + "/ajax_add";
            }
            else
            {
                url = controller_name + "/ajax_update";
            }

             // ajax adding data to database
                $.ajax({
                  url : url,
                  type: "POST",
                  data: $('#form').serialize(),
                  dataType: "JSON",
                  success: function(data)
                  {

                      if(data.status==true) //if success close modal and reload ajax table
                      {
                          window.location.reload();
                          //$('#modal_form').modal('hide');
                          //$('#ul-order-history').html(data.html_);
                          //reload_table();
                      }
                      else
                      {
                          document.getElementById("resi").required = true;
                          $('#btnSave').attr('disabled',false);
                          $("#alert").attr("class","alert alert-error col-md-12");
                      }
                      $('#btnSave').text('save'); //change button text
                       //set button enable 


                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      alert('Error adding / update data');
                      $('#btnSave').text('save'); //change button text
                      $('#btnSave').attr('disabled',false); //set button enable 

                  }
              });
          }