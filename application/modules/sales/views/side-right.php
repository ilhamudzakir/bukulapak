    <div class="col-md-3">
     <div class="side-right grey">
     	<h2 class="">Rangkuman</h2>
     	<h4 class="martop">Total Penjualan</h4>
     	<h3>3.000.000</h3>
     	<div class="martop">
     		<div class="bortom grey"><h5>Lapak</h5></div>
     		<div class="bortom "><a href="sales/lapak"><h5 class="green">5 Aktif</h5></a></div>
     		<div class="bortom "><h5 class="yellow">5 Menunggu Persetujuan</h5></div>
     		<div class="bortom "><h5 class="red">1 Aproved</h5></div>
     		<div class="bortom "><h5 class="grey">10 Tidak aktif</h5></div>
     	</div>
     	<a data-toggle="modal" data-target="#myModal"  href=""><div class="martop marbot">+ Tambah agen baru</div></a>
     	<div><a href="sales/add"><button class="form btn2 large2" name="submit" type="submit">+ Buat Lapak Baru</button></a></div>
     </div>
    </div>

    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog grey">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title">Tambah Agen Baru</h3>
        </div>
        <div class="modal-body">
          <form>
          	<div class="form-group">
          		<div class="row">
          			<div class="col-md-12">
          				<label>User ID</label>
						<input class="form border" type="text" name="name">
          			</div>
          		</div>
          	</div>
          	<div class="form-group">
          		<div class="row">
          			<div class="col-md-6">
          				<label>Nama</label>
						<input class="form border" type="text" name="name">
          			</div>
          			<div class="col-md-6">
          				<label>Email</label>
						<input class="form border" type="email" name="name">
          			</div>

          		</div>
          	</div>
          	<div class="form-group">
          		<div class="row">
          			<div class="col-md-6">
          				<label>Password</label>
						<input class="form border" type="Password" name="name">
          			</div>
          			<div class="col-md-6">
          				<label>Ketik Ulang Password</label>
						<input class="form border" type="Password" name="name">
          			</div>

          		</div>
          	</div>
          	<div class="form-group text-center">
          		<button type="submit" name="submit" class="form btn2 large2">Buat Sekarang</button>
          	</div>
          </form>
        </div>
        
      </div>
      
    </div>
  </div>
  <!--End Modal -->