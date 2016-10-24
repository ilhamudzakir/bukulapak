var base_url = $('#base_url').val();

$(document).ready(function() {
  $(".select2").select2();
	$("#bstudy").select2();
})


$(document).ready(function() 
{ 
  $('select[name=bstudy]').change(function(v)
  {
    alert('dasdas');
  });
});

function addcart(lapak_id,kode_buku,sales_id,area_id)
{
  var lapak_id = lapak_id;
  var kode_buku = kode_buku;
  var sales_id = sales_id;
  var area_id = area_id;
  var current_url = $('#current_url').val();
  var cty = $('#cty_'+lapak_id+'_'+kode_buku).val();
  var berat = $('#berat_'+lapak_id+'_'+kode_buku).val();
  var harga = $('#harga_'+lapak_id+'_'+kode_buku).val();
  var judul = $('#judul_'+lapak_id+'_'+kode_buku).val();

  $.ajax({
    url : base_url+"front/addcart/"+lapak_id+"/"+kode_buku+"/"+sales_id+"/"+area_id,
    type: 'POST',
    data: {
      lapak_id: lapak_id,
      kode_buku: kode_buku,
      cty: cty,
      berat: berat,
      harga: harga,
      judul: judul,
      sales_id: sales_id,
      area_id: area_id,
      current_url: current_url
    },
    success : function(response){
      if(!response.status)
      {
        alert('Failed');
      }else{
        $(".text-checkout").html(response.total_item);
        
        window.location.replace(base_url+'front/carts');
      }
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Maaf Anda hanya dapat berbelanja pada area yang sama dengan daftar belanjaan anda sekarang');
    },
    dataType: "json",
  });
}
