var base_url = $('#base_url').val();

$(document).ready(function() {

})

function cektransaksi()
{
    
    var confirmation_code = $('#confirmation_code').val();
    $('#loading').show();
    $.ajax({
      url : base_url+"front/cektransaksi/",
      type: 'POST',
      data: {
        confirmation_code: confirmation_code
      },
      success : function(response){
        $('#loading').hide();
        if(!response.status)
        {
          $("#statustransaksi").html(response.validation_errors);
        }else{
          $("#statustransaksi").html(response.html_result);
          //window.location.reload();
        }
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      },
      dataType: "json",
    });
  }
 function submit_diterima()
{
  
    
     $('#modal_form').modal('show'); // show bootstrap modal
   
}

function cek_diterima(){
  var data = '';
    var id = document.getElementById("barangok").getAttribute("order-id");
    var email = document.getElementById("email_order").value;
     var code = document.getElementById("confirmation_code").value;
    $('#loading').show();
   $.ajax({
    type: "POST",
    data: {
      id: id,
      email: email,
      code: code,
    },
    url: "front/barang_diterima/",
    success: function(html){ 
    var html=jQuery.parseJSON(html);
    if(html=='success'){
      $('#modal_form').modal('hide');
    document.getElementById("validasi_email").style.display="none";
    document.getElementById("textbarang").innerHTML="Barang pesanan anda sudah diterima menggunakan";
    document.getElementById("textbarang2").innerHTML="Terima kasih sudah berbelanja di website kami.";
    document.getElementById("terima").innerHTML="&#10004";
    $('#loading').hide();
    }else{
    document.getElementById("validasi_email").style.display="block";
    }
    }
});
}