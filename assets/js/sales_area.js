var save_method; //for save method string
          var table;
          var table_admin;
          var table_sales;
          var table_agen;
          var controller_name;
          var base_url = $('#base_url').val();;
          $(document).ready(function() {
            controller_name = $('#controller_name').val();
            table_sales = $('#table_sales').DataTable({ 
              
              "processing": true, //Feature control the processing indicator.
              "serverSide": true, //Feature control DataTables' server-side processing mode.
              
              // Load data for the table's content from an Ajax source
              "ajax": {
                  "url": base_url + controller_name + "/area_ajax_list",
                  "type": "POST"
              },

              //Set column definition initialisation properties.
              "columnDefs": [
              { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
              },
              ],
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

            $("#gen_password").click(function(){
                var gen_password = randomPassword(5);
                $("#password").val(gen_password);
                alert(gen_password);
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

          function add_users_groups()
          {
            controller_name = $('#controller_name').val();
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add users_groups'); // Set Title to Bootstrap modal title
          }

          function edit_users_groups(id)
          {
            controller_name = $('#controller_name').val();
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
             $('.help-block').empty(); // clear error string
            
            //Ajax Load data from ajax
            $.ajax({
              //url : "<?php echo site_url('users_groups/ajax_edit/')?>/" + id,
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
                  $('.modal-title').text('Edit users_groups'); // Set title to Bootstrap modal title
                  
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
                //url = "<?php echo site_url('users_groups/ajax_add')?>";
                url = base_url + controller_name + "/ajax_add";
            }
            else
            {
              //url = "<?php echo site_url('users_groups/ajax_update')?>";
              url = base_url + controller_name + "/ajax_update";
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

          function delete_users_groups(id)
          {
            controller_name = $('#controller_name').val();
            if(confirm('Are you sure delete this data?'))
            {
              // ajax delete data to database
                $.ajax({
                  //url : "<?php echo site_url('users_groups/ajax_delete')?>/"+id,
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