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
        "url": base_url + controller_name + "/layout_email_list",
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

function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyABCDEFGHIJKLMNOP1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}

function changeorderstatus()
{
  var order_status_id = $('#order_status_id').val();
  var controller_name = $('#controller_name').val();
  window.location.href = base_url + controller_name + "/status/" + order_status_id;
}

function getkabupaten()
{
  var propinsi_id = $('#propinsi_id').val();
  var controller_name = $('#controller_name').val();
  $('#propinsi_sekolah').val(propinsi_id);
  $.ajax({
    url : "http://localhost/bukulapak/lapak/getkabupaten/"+propinsi_id,
    success : function(response){

      $('#kabupaten_id').html(response);
      
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    },
    dataType: "html",
  });
}

function add_agen()
{
  controller_name = $('#controller_name').val();
  save_method = 'add';
  $('#form_agen')[0].reset(); // reset form on modals
  $('.form-group_agen').removeClass('has-error'); // clear error class
  $('.help-block_agen').empty(); // clear error string
  $('#modal_form_agen').modal('show'); // show bootstrap modal
  $('.modal-title_agen').text('Tambah Agen'); // Set Title to Bootstrap modal title
}

function add_sekolah()
{
  controller_name = $('#controller_name').val();
  save_method = 'add';
  //$('#form_sekolah')[0].reset(); // reset form on modals
  $('.form-group_sekolah').removeClass('has-error'); // clear error class
  $('.help-block_sekolah').empty(); // clear error string
  $('#modal_form_sekolah').modal('show'); // show bootstrap modal
  $('.modal-title_sekolah').text('Tambah Sekolah'); // Set Title to Bootstrap modal title
}

function add_buku()
{
  controller_name = $('#controller_name').val();
  save_method = 'search';
  $('#form_buku')[0].reset(); // reset form on modals
  $('.form-group_buku').removeClass('has-error'); // clear error class
  $('.help-block_buku').empty(); // clear error string
  $('#modal_form_buku').modal('show'); // show bootstrap modal
  $('.modal-title_buku').text('Tambah Buku'); // Set Title to Bootstrap modal title
}

function add_lapak()
{
  controller_name = $('#controller_name').val();
  save_method = 'add';
  $('#form')[0].reset(); // reset form on modals
  $('.form-group').removeClass('has-error'); // clear error class
  $('.help-block').empty(); // clear error string
  $('#modal_form').modal('show'); // show bootstrap modal
  $('.modal-title').text('Add lapak'); // Set Title to Bootstrap modal title
}



function edit_lapak(id)
{
  controller_name = $('#controller_name').val();
  save_method = 'update';
  $('#form')[0].reset(); // reset form on modals
  $('.form-group').removeClass('has-error'); // clear error class
   $('.help-block').empty(); // clear error string
  
  //Ajax Load data from ajax
  $.ajax({
    //url : "<?php echo site_url('lapak/ajax_edit/')?>/" + id,
    url : controller_name + "/ajax_edit/" + id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
       
        $('[name="id"]').val(data.id);
        $('[name="name"]').val(data.name);
        $('[name="description"]').val(data.description);
        /*$('[name="lastName"]').val(data.lastName);
        $('[name="gender"]').val(data.gender);
        $('[name="address"]').val(data.address);
        $('[name="dob"]').val(data.dob);*/
        
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit lapak'); // Set title to Bootstrap modal title
        
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    }
});
}
function getsekolah()
{
  var controller_name = $('#controller_name').val();
  var kabupaten_id = $('#kabupaten_id').val();
  var propinsi_id = $('#propinsi_id').val();
  $('#kabupaten_sekolah').val(kabupaten_id);
  $.ajax({
    url : "http://localhost/bukulapak/lapak/getsekolah/"+propinsi_id+"/"+kabupaten_id,
    success : function(response){

      $('#sekolah_id').html(response);
      
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    },
    dataType: "html",
  });
}

function reload_table()
{
  table.ajax.reload(null,false); //reload datatable ajax 
}

function ParentWindowFunction()
{
    alert('Need to refresh targetdiv. I am instructed from child window');
    //refresh the div
    return false;
}

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

function save_sekolah()
{
  controller_name = $('#controller_name').val();
  $('#btnSaveSekolah').text('saving...'); //change button text
  $('#btnSaveSekolah').attr('disabled',true); //set button disable 
  var url;
  if(save_method == 'add') 
  {
      //url = "<?php echo site_url('lapak/ajax_add')?>";
      url = 'http://localhost/bukulapak/'+controller_name + "/ajax_add_sekolah";
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
        data: $('#form_sekolah').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form_sekolah').modal('hide');
                $('#sekolah_id').html(data.data_sekolah);
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('#form_sekolah [name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('#form_sekolah [name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSaveSekolah').text('save'); //change button text
            $('#btnSaveSekolah').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSaveSekolah').text('save'); //change button text
            $('#btnSaveSekolah').attr('disabled',false); //set button enable 

        }
    });
}

function search_buku()
{
  controller_name = $('#controller_name').val();
  $('#btnSearch').text('searching...'); //change button text
  $('#btnSearch').attr('disabled',true); //set button disable 
  var url;
  if(save_method == 'search') 
  {
      //url = "<?php echo site_url('lapak/ajax_add')?>";
      url = 'http://localhost/bukulapak/'+controller_name + "/ajax_search_buku";
  }

   // ajax adding data to database
      $.ajax({
        url : url,
        type: "POST",
        data: $('#form_buku').serialize(),
        dataType: "JSON",
        success: function(data)
        {
          $('#table_buku').html(data.data_buku);
          $('#btnSearch').text('Search'); //change button text
          $('#btnSearch').attr('disabled',false); //set button enable 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          $('#btnSearch').text('Search'); //change button text
          $('#btnSearch').attr('disabled',false); //set button enable 
          alert('Error fetching data');
        }
    });
}

function masukkan_buku(lapak_id, buku_id)
{

  controller_name = $('#controller_name').val();
  //alert(controller_name + "/ajax_masukkan_buku/" + lapak_id + "/" + buku_id);
  $('#btnmasukkanbuku_' + buku_id).text('Loading'); //change button text
  $('#btnmasukkanbuku_' + buku_id).attr('disabled',true); //set button enable 
  $.ajax({
    url : "http://localhost/bukulapak/" + controller_name + "/ajax_masukkan_buku/" + lapak_id + "/" + buku_id,
    type: "POST",
    dataType: "JSON",
    success: function(data)
    {
        $('#lapak_buku_id').html(data.data_lapak_buku);
        $('#btnmasukkanbuku_' + buku_id).text('Buku ini sudah ditambahkan'); //change button text
        $('#btnmasukkanbuku_' + buku_id).attr('disabled',true); //set button enable 


    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error adding / update data');
        $('#btnmasukkanbuku_' + buku_id).text('Tambahkan buku ini'); //change button text
        $('#btnmasukkanbuku_' + buku_id).attr('disabled',false); //set button disable 

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

function delete_lapak_buku(lapak_id,id)
{
  controller_name = $('#controller_name').val();
  if(confirm('Anda yakin akan menghapusnya??'))
  {
    // ajax delete data to database
      $.ajax({
        //url : "<?php echo site_url('lapak/ajax_delete')?>/"+id,
        url : "http://localhost/bukulapak/" + controller_name + "/ajax_delete_lapak_buku/" + lapak_id + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
           $('#lapak_buku_id').html(data.data_lapak_buku);
           //if success reload ajax table
           //$('#modal_form').modal('hide');
           //reload_table();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
     
  }
}


function cek_orderbayar(){
  var tgl1 = document.getElementById("thn1").value+"-"+document.getElementById("bln1").value+"-"+document.getElementById("tgl1").value;
  var tgl2 = document.getElementById("thn2").value+"-"+document.getElementById("bln2").value+"-"+document.getElementById("tgl2").value;
  if(tgl1==="0-0-0" && tgl2==="0-0-0"){
     document.getElementById("resultfilter").innerHTML = "";
    alert('Tanggal Harus diisi');
  }else{
  $.ajax({
    url : "order/cek_orderbayar/"+ tgl1 + "/" +tgl2,
    success : function(response){
   var duce = jQuery.parseJSON(response);
   var status = duce.status;
   var result = duce.result;
   if(status=='null'){
    document.getElementById("resultfilter").innerHTML = result;
    alert('maaf data tidak ada');
   }else{
     document.getElementById("resultfilter").innerHTML = result;
    
   }
   },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    },
    dataType: "html",
  });
}
}