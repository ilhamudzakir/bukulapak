var save_method; //for save method string
var controller_name;
var base_url = $('#base_url').val();
$.fn.modal.Constructor.prototype.enforceFocus = function () {};
$(document).ready(function() {
document.getElementById('tablenya').style.display = 'none';
controller_name = $('#controller_name').val();

 $('#dt1').datepicker({
      autoclose: true,
      todayHighlight: true,
      format : 'yyyy-mm-dd',
  }).on('changeDate', function(){
      
  }); 

  $('#dt2').datepicker({
      autoclose: true,
       format : 'yyyy-mm-dd',
  }).on('changeDate', function(){
        });

});

function filter_transaksi(){
  var froms = $('#dt1').val();
var to = $('#dt2').val();
  document.getElementById('tablenya').style.display = 'block';
  if (document.getElementById('table_admin_length') !=null) {
     $('#url_download').attr(controller_name+"/transaksi_csv/"+froms+"/"+to);
    $('#table_admin').DataTable().ajax.url(base_url + controller_name + "/ajax_admin_transaksi/"+froms+"/"+to).load();
    $('#table_admin').DataTable().ajax.reload(null, false);
   
    
  }else{
  $('#url_download').attr('href',controller_name+"/transaksi_csv/"+froms+"/"+to);
   table_admin = $('#table_admin').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    "ajax": {
        "url": base_url + controller_name + "/ajax_admin_transaksi/"+froms+"/"+to,
        "type": "POST"
    },

    "columnDefs": [
    { 
      "targets": [ -1 ], //last column
      "orderable": false, //set not orderable
    },
    ],
    "oLanguage": {
         "sSearch": "Order Code:"
       },
    "scrollY": 500,
    "scrollX": true

  });
}
}
