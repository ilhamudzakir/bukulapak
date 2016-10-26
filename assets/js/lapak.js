var save_method; //for save method string
var table;
var table_admin_area;
var table_atasan_1;
var table_atasan_2;
var table_agen;
var controller_name;
var base_url = $('#base_url').val();
$.fn.modal.Constructor.prototype.enforceFocus = function () {};
$(document).ready(function() {

  controller_name = $('#controller_name').val();

  table = $('#table').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    "ajax": {
        "url": base_url + controller_name + "/ajax_list",
        "type": "POST"
    },

    "columnDefs": [
    { 
      "targets": [ -1 ], //last column
      "orderable": false, //set not orderable
    },
    ],
    "oLanguage": {
                 "sSearch": "Kode lapak : _INPUT_"
               },
              "scrollY": 200,
              "scrollX": true

  });

  table_admin_area = $('#table_admin_area').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    "ajax": {
        "url": base_url + controller_name + "/ajax_admin_area_list",
        "type": "POST"
    },

    "columnDefs": [
    { 
      "targets": [ -1 ], //last column
      "orderable": false, //set not orderable
    },
    ],
    "oLanguage": {
                 "sSearch": "Kode lapak : _INPUT_"
               },
              "scrollY": 200,
              "scrollX": true

  });

  table_atasan_1 = $('#table_atasan_1').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    "ajax": {
        "url": base_url + controller_name + "/ajax_atasan_1_list",
        "type": "POST"
    },

    "columnDefs": [
    { 
      "targets": [ -1 ], //last column
      "orderable": false, //set not orderable
    },
    ],
    "oLanguage": {
                 "sSearch": "Kode lapak : _INPUT_"
               },
              "scrollY": 200,
              "scrollX": true

  });

  table_atasan_2 = $('#table_atasan_2').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    "ajax": {
        "url": base_url + controller_name + "/ajax_atasan_2_list",
        "type": "POST"
    },

    "columnDefs": [
    { 
      "targets": [ -1 ], //last column
      "orderable": false, //set not orderable
    },
    ],
    "oLanguage": {
                 "sSearch": "Kode lapak : _INPUT_"
               },
              "scrollY": 200,
              "scrollX": true

  });

  table_agen = $('#table_agen').DataTable({ 
    
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    
    "ajax": {
        "url": base_url + controller_name + "/ajax_agen_list",
        "type": "POST"
    },

    "columnDefs": [
    { 
      "targets": [ -1 ], //last column
      "orderable": false, //set not orderable
    },
    ],
    "oLanguage": {
                 "sSearch": "Kode lapak : _INPUT_"
               },
              "scrollY": 200,
              "scrollX": true

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

  // set default dates
  var start = new Date();
  // set end date to max one year period:
  var end = new Date(new Date().setYear(start.getFullYear()+1));

  $('#dt1').datepicker({
      autoclose: true,
      todayHighlight: true,
      format : 'dd M yyyy',
      startDate : start,
      endDate   : end
  }).on('changeDate', function(){
      $('#dt2').datepicker('setStartDate', new Date($(this).val()));
  }); 

  $('#dt2').datepicker({
      autoclose: true,
      format : 'dd M yyyy',
      startDate : start,
      endDate   : end
  }).on('changeDate', function(){
      $('#dt1').datepicker('setEndDate', new Date($(this).val()));
  });
//$('#inputID').select2('data', {id: 100, a_key: 'Lorem Ipsum'});
  $('#propinsi_id').select2();
  $('#kabupaten_id').select2();
  $('#agen_id').select2();
  $('#jenjang').select2();
  $('#superior_id').select2();
  $('#next_superior_id').select2();
  $('#sekolah_id').select2();
  
  /*$('#kode_buku').select2({
    placeholder: "Kode buku",
    minimumInputLength: 3,
    ajax: {
        url: "http://localhost/bukulapak/lapak/getkodebuku",
        dataType: 'json',
        quietMillis: 100,
        data: function (term, page) { 
          return {
            term: term, 
            page: page 
          };
        },
        results: function (data,page) {
          var more = (page * 30) < data.total_count;
          return { results: data, more:more};
        }
    }
  });*/

  /*$('#judul_buku').select2({
    placeholder: "Judul buku",
    minimumInputLength: 3,
    ajax: {
        url: "http://localhost/bukulapak/lapak/getjudulbuku",
        dataType: 'json',
        quietMillis: 100,
        data: function (term, page) { 
          return {
            term: term, 
            page: page 
          };
        },
        results: function (data,page) {
          var more = (page * 30) < data.total_count;
          return { results: data, more:more};
        }
    }
  });*/

   //$(".bigdrop .select2-results").css("max-height","50px");

  $("#gen_password").click(function(){
      var gen_password = randomPassword(5);
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

function getkabupaten()
{
  var propinsi_id = $('#propinsi_id').val();
  var controller_name = $('#controller_name').val();
  $('#propinsi_sekolah').val(propinsi_id);
  $.ajax({
    url : base_url + controller_name + "/getkabupaten/" + propinsi_id,
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

function edit_profile()
{
  controller_name = $('#controller_name').val();
  save_method = 'update';
  $('#form_agen')[0].reset(); // reset form on modals
  $('.form-group_agen').removeClass('has-error'); // clear error class
  $('.help-block_agen').empty(); // clear error string
  $('#modal_form_agen').modal('show'); // show bootstrap modal
  $('.modal-title_agen').text('Edit Profile'); // Set Title to Bootstrap modal title
}

function ganti_password()
{
  controller_name = $('#controller_name').val();
  save_method = 'update';
  $('#form_password')[0].reset(); // reset form on modals
  $('.form-group_password').removeClass('has-error'); // clear error class
  $('.help-block_password').empty(); // clear error string
  $('#modal_form_password').modal('show'); // show bootstrap modal
  $('.modal-title_password').text('Ganti Password'); // Set Title to Bootstrap modal title
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
    url : base_url + controller_name + "/ajax_edit/" + id,
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
    url : base_url + controller_name + "/getsekolah/"+propinsi_id+"/"+kabupaten_id,
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

function notactivated(id,judul_lapak)
{
  var controller_name = $('#controller_name').val();
  //var not_active = $('#not_active').val();
  $.ajax({
    url : base_url + controller_name + "/not_active/"+id+"/"+judul_lapak,
    success : function(response){
      $('#not_active_result').html(response.status_message);
      window.setTimeout(function(){
        window.location.href = base_url + controller_name + "/lapak";
    }, 2000);
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    },
    dataType: "json",
  });
}

function activated_action(id,judul_lapak)
{
  var controller_name = $('#controller_name').val();
  //var not_active = $('#not_active').val();
  $.ajax({
    url : base_url + controller_name + "/active/"+id+"/"+judul_lapak,
    success : function(response){
      $('#not_active_result').html(response.status_message);
      window.setTimeout(function(){
        window.location.href = base_url + controller_name + "/lapak";
    }, 2000);
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    },
    dataType: "json",
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
      url = base_url + controller_name + "/ajax_add";
  }
  else
  {
    //url = "<?php echo site_url('lapak/ajax_update')?>";
    url = base_url + controller_name + "/ajax_update";
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

function save_profile(id)
{
  controller_name = $('#controller_name').val();
  $('#btnSave').text('saving...'); //change button text
  $('#btnSave').attr('disabled',true); //set button disable 
  var url;
  if(save_method == 'add') 
  {
      //url = "<?php echo site_url('lapak/ajax_add')?>";
      url = base_url + controller_name + "/ajax_add_profile";
  }
  else
  {
    //url = "<?php echo site_url('lapak/ajax_update')?>";
    url = base_url + controller_name + "/ajax_update_profile/" + id;
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
                //$('#agen_id').html(data.data_agen);
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

function save_password(id)
{
  controller_name = $('#controller_name').val();
  $('#btnSave').text('saving...'); //change button text
  $('#btnSave').attr('disabled',true); //set button disable 
  var url;
  if(save_method == 'add') 
  {
      //url = "<?php echo site_url('lapak/ajax_add')?>";
      url = base_url + controller_name + "/ajax_add_password";
  }
  else
  {
    //url = "<?php echo site_url('lapak/ajax_update')?>";
    url = base_url + controller_name + "/ajax_update_password/" + id;
  }

   // ajax adding data to database
      $.ajax({
        url : url,
        type: "POST",
        data: $('#form_password').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form_password').modal('hide');
                //$('#password_id').html(data.data_password);
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('#form_password [name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('#form_password [name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
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
      url = base_url + controller_name + "/ajax_add_sekolah";
  }
  else
  {
    //url = "<?php echo site_url('lapak/ajax_update')?>";
    url = base_url + controller_name + "/ajax_update";
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
      url = base_url + controller_name + "/ajax_search_buku";
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
    url : base_url + controller_name + "/ajax_masukkan_buku/" + lapak_id + "/" + buku_id,
    type: "POST",
    dataType: "JSON",
    success: function(data)
    {
        $('#lapak_buku_id').html(data.data_lapak_buku);
        $('#btnmasukkanbuku_' + buku_id).text('Tambahkan buku ini'); //change button text
        $('#btnmasukkanbuku_' + buku_id).attr('disabled',false); //set button enable 


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
        url : base_url + controller_name + "/ajax_delete/"+id,
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
        url : base_url + controller_name + "/ajax_delete_lapak_buku/" + lapak_id + "/" + id,
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