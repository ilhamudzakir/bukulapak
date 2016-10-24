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

          