<section>
	<div class="container">
		<div class="title1"><h3>Cara Mudah Beli Buku</h3></div>

		<!-----------------tab pan---------------------->
		<div class="col-md-8 center">
		<div class="row">
	<div id="exTab1">	
<ul  class="nav nav-pills">
		<li class="active tabs" id="tabsekolah">
        	<a  href="#sekolah" data-toggle="tab">Cari berdasarkan sekolah</a>
		</li>
		<li class="tabs" id="tablapak">
			<a href="#lapak" data-toggle="tab">Cari kode lapak</a>
		</li>
</ul>

<div class="tab-content clearfix">
		<div class="tab-pane active" id="sekolah">
          <form action="front/book/sekolah">
          	<div class="form-group">
          		<div class="row">
          		<div class="col-md-10">
          			<div class="row">
          				<div class="col-md-6">
          				<select class="form">
          					<option value="">Propinsi</option>
          				</select>
          			</div>
          			<div class="col-md-6">
          				<select class="form">
          					<option value="">Kota</option>
          				</select>
          			</div>

          			<div class="col-md-12">
          				<input type="text" class="form" name="sekolah" placeholder="Tuliskan nama sekolah">
          			</div>
          			</div>
          		</div>
          			<div class="col-md-2">
          			<div class="row">
          			<div class="col-md-12">
          			<input type="submit" name="submit" class="form btn1" value="cari">
          			</div>
          			</div>
          			</div>
          		</div>
          	</div>
          </form>
		</div>
		<div class="tab-pane" id="lapak">
         <form action="front/book/lapak">
          	<div class="form-group">
          		<div class="row">
          		<div class="col-md-10">
          		<div class="row">
          		<div class="col-md-12">
          				<input type="text" class="form" name="sekolah" placeholder="Tuliskan nama sekolah">
          			</div>
          			</div>
          			</div>
          			<div class="col-md-2">
          			<div class="row">
          			<div class="col-md-12">
          			<input type="submit" name="submit" class="form btn2" value="cari">
          			</div>
          			</div>
          			</div>
          		</div>
          	</div>
          </form>
		</div>
	</div>
  </div>
  </div>
  </div>
<!-----------------tab pan---------------------->

	</div><!----end container-------------->
</section>