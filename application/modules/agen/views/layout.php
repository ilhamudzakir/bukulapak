<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php if($this->router->fetch_method()!='index'){echo $function.' - '; }  echo $name;?> | Erlangga </title>
    <base href="<?php echo base_url(); ?>"></base>
    <link href="assets/front/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/front/css/styles.css" rel="stylesheet">
    <link href="assets/front/css/media.css" rel="stylesheet">
</head>

<body>
<header>
	<div class="container">
      <div class="col-md-8 pull-left" style="padding-top:15px;"><a href="<?php echo base_url() ?>"><img src="assets/front/images/logo.png"></a></div>
    </div>
</header>
    
    <?php echo $page; ?>
    
    <footer <?php if(!$this->uri->segment(2) and $this->uri->segment(1)=='agen'){ ?> class="foot-bottom" <?php } ?> >
    <div class="container">
    	
    		<div class="col-md-6 pull-left">
    		<div class="row">
    			<span>Copyright</span><a href="<?php echo base_url() ?>front/contact">Contact Us</a><a href="<?php echo base_url() ?>front/terms">Syarat & Ketentuan</a>
    		</div>
    		</div>
    		<div class="col-md-6 pull-right text-right">
    		<div class="row">
    			<a href="<?php echo base_url() ?>front/confirmation">Konfirmasi Pembayaran</a><a href="<?php echo base_url() ?>front/status">Status Transaksi</a>
    		</div>
    		</div>
    		<div class="col-md-6 pull-right"></div>
    	
    </div>
    </footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="assets/front/js/bootstrap.min.js"></script>
</body>
</html>