var base_url = $('#base_url').val();

$(document).ready(function() {

})

function updatecart(rowid)
{
  var rowid = rowid;
  var id = $('#id_'+rowid).val();
  var name = $('#name_'+rowid).val();
  var qty = $('#qty_'+rowid).val();
  var price = $('#price_'+rowid).val();
  var berat = $('#berat_'+rowid).val();

  $.ajax({
    url : base_url+"front/updatecart/"+rowid,
    type: 'POST',
    data: {
      rowid: rowid,
      qty: qty,
      berat: berat,
    },
    success : function(response){
      if(!response.status)
      {
        alert('Failed');
      }else{
        $(".text-checkout").html(response.total_item);
        window.location.reload();
      }
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      alert('Error get data from ajax');
    },
    dataType: "json",
  });

}

function getkabupaten()
{
  var propinsi_id = $('#propinsi_id').val();
  var controller_name = $('#controller_name').val();
  $("#loading_kabupaten").show();
  $("#kabupaten_id").hide();
  $.ajax({
    url : base_url+"front/getkabupaten/"+propinsi_id,
    success : function(response){
      $("#loading_kabupaten").hide();
      $('#kabupaten_id').show();
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
  $("#loading_kecamatan").show();
  $("#kecamatan_id").hide();
  $.ajax({
    url : base_url+"front/getkecamatan/"+kabupaten_id,
    success : function(response){
      $("#loading_kecamatan").hide();
      $('#kecamatan_id').show();
      $('#kecamatan_id').html(response);
      
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    },
    dataType: "html",
  });
}

function getongkir(area_id)
{
  var area_id = area_id;
  var propinsi_id = $('#propinsi_id').val();
  var kabupaten_id = $('#kabupaten_id').val();
  var kecamatan_id = $('#kecamatan_id').val();
  var paket = $('#paket').val();

  if(paket==null){
    paket='reguler';
  }
  if(paket=='reguler'){
     paket='reguler';
   }
   if(paket=='ok'){
     paket='ok';
  }

  var controller_name = $('#controller_name').val();
  $.ajax({
    url : base_url+"front/getongkir/"+area_id+"/"+propinsi_id+"/"+kabupaten_id+"/"+kecamatan_id+"/"+paket,
    success : function(response){
      $('#ongkir').html(response.ongkir);
      $('#totalongkir').html(response.totalongkir);
      $('#price_total').html(response.price_total);
     $("#paket option[value="+paket+"]").attr('selected', 'selected');
      
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
    },
    dataType: "json",
  });
}
