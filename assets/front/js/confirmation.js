var base_url = $('#base_url').val();

$(document).ready(function() {

})

function submit_confirmation()
{
 
    var data = new FormData($('#confirmation_upload')[0]);
    $('#loading').show();
 
     $.ajax({
               type:"POST",
               url: base_url+"front/proceedconfirmation/",
               data:data,
               mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
               success:function(data)
              {
                $('#loading').hide();
                  $('#confirmation_upload')[0].reset();
                  $('#validation_errors').html(data.validation_errors);  
              }
       });
 
}

