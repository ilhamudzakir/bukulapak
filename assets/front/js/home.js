var base_url = $('#base_url').val();

$(document).ready(function() {
  $("#sekolah_id").select2();
  $("#propinsi_id").select2();
  $("#kabupaten_id").select2();
  sekolahclear();
  $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                responsiveClass: true,
                 nav: true,
  navText: ["<a class='icon-prev'><em>Prev</em></a>","<a class='icon-next' ><em>Next</em></a>"],
                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  600: {
                    items: 3,
                    nav: false
                  },
                  1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 20
                  }
                }
              })
});

function getkabupaten()
{
  var propinsi_id = $('#propinsi_id').val();
  var controller_name = $('#controller_name').val();
  $('#propinsi_sekolah').val(propinsi_id);
  $.ajax({
    url : base_url+"front/getkabupaten/"+propinsi_id,
    success : function(response){
      $('#propinsi_id_help').html("");
      $('#kabupaten_id').html(response);
      
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    },
    dataType: "html",
  });
}

function search_sekolah()
{
  var sekolah_id = $('#sekolah_id').val();
  var propinsi_id = $('#propinsi_id').val();
  var kabupaten_id = $('#kabupaten_id').val();
  var controller_name = $('#controller_name').val();

  if(propinsi_id == 0){
    $('#propinsi_id_help').html("<div class='alert alert-error'>Propinsi wajib diisi.</div>")
  }else{
    if(kabupaten_id == 0){
      $('#kabupaten_id_help').html("<div class='alert alert-error'>Kabupaten wajib diisi.</div>")
    }else{
      if(sekolah_id == 0){
        $('#sekolah_id_help').html("<div class='alert alert-error'>Sekolah wajib diisi.</div>")
      }else{
        window.location.replace(base_url+'front/search_sekolah/'+sekolah_id+'/'+propinsi_id+'/'+kabupaten_id);
      } 
    }
  }
  
}

function search_lapak()
{
  var kodelapak = $('#kodelapak').val();
  $('#loading').show();
  //alert(!kodelapak);
  if(!kodelapak)
  {
    $('#kodelapak_help').html("<div class='alert alert-error'>Kodel lapak wajib diisi.</div>")
  }else
  {
    window.location.replace(base_url+'front/search_lapak/'+kodelapak);
  }
}

function getpropinsi()
{
  var sekolah_id = $('#sekolah_id').val();
  var controller_name = $('#controller_name').val();
  $.ajax({
    url : base_url+"front/getsekolah/"+sekolah_id,
    success : function(response){
      $("#propinsi_id option[value="+response.propinsi_id+"]").attr('selected', 'selected');
      $("#kabupaten_id option[value="+response.kabupaten_id+"]").attr('selected', 'selected');
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    },
    dataType: "json",
  });
}

function getsekolah()
{
  var controller_name = $('#controller_name').val();
  var kabupaten_id = $('#kabupaten_id').val();
  var propinsi_id = $('#propinsi_id').val();
  $('#sekolah_id').val("");
  $.ajax({
    url : base_url+"front/getsekolahsearch/"+propinsi_id+"/"+kabupaten_id,
    success : function(response){
      $('#kabupaten_id_help').html("");
      $('#sekolah_id').html(response);
      
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    },
    dataType: "html",
  });
}


function sekolah()
{
  var controller_name = $('#controller_name').val();
  
 var id = $('#sekolah_id').val();
  $.ajax({
    url : base_url+"front/get_kab_prop/"+id,
    success : function(response){
   var duce = jQuery.parseJSON(response);
   var prop = duce.propinsi_id;
   var propname = duce.propinsi_name;
   var kab = duce.kabupaten_id;
   document.getElementById("kabupatendiv").innerHTML = kab;
    var target = document.getElementById("s2id_propinsi_id").getElementsByClassName("select2-chosen")[0];
    target.innerHTML = propname;
     $("#propinsi_id option[value="+prop+"]").attr('selected', 'selected');
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    },
    dataType: "html",
  });
}

function sekolahclear()
{
  $('#sekolah_id_help').html("");
}
if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}