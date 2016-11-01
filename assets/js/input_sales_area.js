var save_method; //for save method string
var table;
var table_admin;
var table_sales;
var table_agen;
var controller_name;
$(document).ready(function() {
  controller_name = $('#controller_name').val();

  $("#gen_password").click(function(){
      var gen_password = randomPassword(8);
      $("#password").val(gen_password);
  });
    $('#nik').select2();

});

function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyABCDEFGHIJKLMNOP1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}

function nik_change()
{
    var nik= $('[name="nik"]').val();
    $.ajax({
    url : controller_name + "/sales_employe/" + nik,
    type: "GET",
    dataType: "JSON",
    success: function(data){
                 
      $('[name="first_name"]').val(data.first_name);
      $('[name="last_name"]').val(data.last_name);
      $('[name="email"]').val(data.email);
      $('[name="phone"]').val(data.phone);
                 
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      alert('Error get data from ajax');
    }
    });
}

          