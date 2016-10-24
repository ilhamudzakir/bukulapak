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
  
    var data = '';
    var id = document.getElementById("barangok").getAttribute("order-id");
    $('#loading').show();
 
    $.ajax({
    type: "POST",
    url: "front/barang_diterima/"+id,
    success: function(html){ 
    document.getElementById("textbarang").innerHTML="Barang pesanan anda sudah diterima menggunakan";
    document.getElementById("textbarang2").innerHTML="Terima kasih sudah berbelanja di website kami.";
    document.getElementById("terima").innerHTML="&#10004";
    
    $('#loading').hide();
    }
});
}

