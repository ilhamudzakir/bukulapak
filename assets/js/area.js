var save_method; //for save method string
          var table;
          var controller_name;
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

          function add_area()
          {
            controller_name = $('#controller_name').val();
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add area'); // Set Title to Bootstrap modal title
          }

          function edit_area(id)
          {
            controller_name = $('#controller_name').val();
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
             $('.help-block').empty(); // clear error string
            
            //Ajax Load data from ajax
            $.ajax({
              //url : "<?php echo site_url('area/ajax_edit/')?>/" + id,
              url : controller_name + "/ajax_edit/" + id,
              type: "GET",
              dataType: "JSON",
              success: function(data)
              {
                 
                  $('[name="id"]').val(data.id);
                  $('[name="title"]').val(data.title);
                  $('[name="location"]').val(data.location);
                  $('[name="no_rek"]').val(data.no_rek);
                  /*$('[name="lastName"]').val(data.lastName);
                  $('[name="gender"]').val(data.gender);
                  $('[name="address"]').val(data.address);
                  $('[name="dob"]').val(data.dob);*/
                  
                  $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Edit area'); // Set title to Bootstrap modal title
                  
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
                //url = "<?php echo site_url('area/ajax_add')?>";
                url = controller_name + "/ajax_add";
            }
            else
            {
              //url = "<?php echo site_url('area/ajax_update')?>";
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

          function delete_area(id)
          {
            controller_name = $('#controller_name').val();
            if(confirm('Are you sure delete this data?'))
            {
              // ajax delete data to database
                $.ajax({
                  //url : "<?php echo site_url('area/ajax_delete')?>/"+id,
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