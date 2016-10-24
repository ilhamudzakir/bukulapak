var save_method; //for save method string
          var table;
          var controller_name;
          var base_url = $('#base_url').val();
          $(document).ready(function() {
            controller_name = $('#controller_name').val();
            table = $('#table').DataTable({ 
              
              "processing": true, //Feature control the processing indicator.
              "serverSide": true, //Feature control DataTables' server-side processing mode.
              
              // Load data for the table's content from an Ajax source
              "ajax": {
                  "url": controller_name + "/ajax_list",
                  "type": "POST"
              },

              //Set column definition initialisation properties.
              "columnDefs": [
              { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
              },
              ],



            });

            $("#propinsi_id").select2();
            $("#kabupaten_id").select2();
            $("#kecamatan_id").select2();
            $("#status").select2();
            $("#bos").select2();

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

          });

          function upload_sekolah()
          {
            controller_name = $('#controller_name').val();
            save_method = 'add';
            $('#form_upload')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form_upload').modal('show'); // show bootstrap modal
            $('.modal-title').text('Upload sekolah'); // Set Title to Bootstrap modal title
          }

          function upload()
          {
           
              var data = new FormData($('#form_upload')[0]);
              $('#loading').show();
           
              $.ajax({
                  type:"POST",
                  url: base_url+"sekolah/upload/",
                  data:data,
                  mimeType: "multipart/form-data",
                  contentType: false,
                  cache: false,
                  processData: false,
                  dataType: "json",
                  success:function(data)
                  {
                    if(data.status = 'true'){
                      $('#loading').hide();
                    //if(data.status) {
                      $('#form_upload')[0].reset();
                      $('#validation_errors').html(data.validation_errors);  
                    //}  
                    }
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      $('#loading').hide();
                    //if(data.status) {
                    $('#form_upload')[0].reset();
                    $('#validation_errors').html(data.validation_errors); 
                  }
              });
           
          }

          function add_sekolah()
          {
            controller_name = $('#controller_name').val();
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add sekolah'); // Set Title to Bootstrap modal title
          }

          function getkabupaten()
          {
            //alert('here');
            var propinsi_id = $('#propinsi_id').val();
            var controller_name = $('#controller_name').val();
            $('#propinsi_sekolah').val(propinsi_id);
            $.ajax({
              url : controller_name + "/getkabupaten/" + propinsi_id,
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

          function getkecamatan()
          {
            var kabupaten_id = $('#kabupaten_id').val();
            var controller_name = $('#controller_name').val();
            $('#kabupaten_sekolah').val(kabupaten_id);
            $.ajax({
              url : controller_name + "/getkecamatan/" + kabupaten_id,
              success : function(response){

                $('#kecamatan_id').html(response);
                
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              },
              dataType: "html",
            });
          }

          function edit_sekolah(id)
          {
            controller_name = $('#controller_name').val();
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
             $('.help-block').empty(); // clear error string
            
            //Ajax Load data from ajax
            $.ajax({
              //url : "<?php echo site_url('sekolah/ajax_edit/')?>/" + id,
              url : controller_name + "/ajax_edit/" + id,
              type: "GET",
              dataType: "JSON",
              success: function(data)
              {
                 
                  $('[name="id"]').val(data.id);
                  $('[name="title"]').val(data.title);
                  $('[name="npsn"]').val(data.npsn);
                  $('[name="status"]').val(data.status);
                  $('[name="jenjang"]').val(data.jenjang);
                  $('[name="alamat"]').val(data.alamat);
                  $('[name="propinsi_id"]').val(data.propinsi_id);
                  $('[name="propinsi_eid"]').val(data.propinsi_eid);
                  $('[name="kabupaten_id"]').val(data.kabupaten_id);
                  $('[name="kecamatan_id"]').val(data.kecamatan_id);
                  $('[name="kls1"]').val(data.kls1);
                  $('[name="kls2"]').val(data.kls2);
                  $('[name="kls3"]').val(data.kls3);
                  $('[name="kls4"]').val(data.kls4);
                  $('[name="kls5"]').val(data.kls5);
                  $('[name="kls6"]').val(data.kls6);
                  $('[name="kls7"]').val(data.kls7);
                  $('[name="kls8"]').val(data.kls8);
                  $('[name="kls9"]').val(data.kls9);
                  $('[name="bos"]').val(data.bos);
                  
                  $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Edit sekolah'); // Set title to Bootstrap modal title
                  
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
          });
          }

          function reload_table()
          {
            table.ajax.reload(null,false); //reload datatable ajax 
          }

          function save()
          {
            controller_name = $('#controller_name').val();
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            var url;
            if(save_method == 'add') 
            {
                //url = "<?php echo site_url('sekolah/ajax_add')?>";
                url = controller_name + "/ajax_add";
            }
            else
            {
              //url = "<?php echo site_url('sekolah/ajax_update')?>";
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

                      if(data.status) //if success close modal and reload ajax table
                      {
                          $('#modal_form').modal('hide');
                          reload_table();
                      }
                      else
                      {
                          for (var i = 0; i < data.inputerror.length; i++) 
                          {
                              $('#form [name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                              $('#form [name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
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
                  /*success: function(data)
                  {
                     //if success close modal and reload ajax table
                     $('#modal_form').modal('hide');
                     reload_table();
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      alert('Error adding / update data');
                  }*/
              });
          }

          function delete_sekolah(id)
          {
            controller_name = $('#controller_name').val();
            if(confirm('Are you sure delete this data?'))
            {
              // ajax delete data to database
                $.ajax({
                  //url : "<?php echo site_url('sekolah/ajax_delete')?>/"+id,
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