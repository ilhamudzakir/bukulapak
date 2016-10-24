<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php if($this->router->fetch_method()!='index'){echo $this->router->fetch_method().' - '; }  echo $name;?> | Erlangga </title>
    <base href="<?php echo base_url(); ?>"></base>
    <link href="assets/front/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/front/css/styles.css" rel="stylesheet">
    <link href="assets/front/css/media.css" rel="stylesheet">
</head>

<body>
<header <?php if(!$this->uri->segment(1) or $this->uri->segment(3)=='home' ){ ?> class="b-none" <?php } ?>>
    <div class="container">
     <div class="col-md-8 pull-left" style="padding-top:15px;"><a href="<?php echo base_url() ?>"><img src="assets/front/images/logo.png"></a></div>
     <a href="front/cart">
     <div class="col-md-2 pull-right checkout">
     <div class="count-checkout">
            <div class="text-checkout">0</div>
        <img src="assets/front/images/cart.png"  width="100%" />
     </div>
     <div class="check-text">
        <b>CHECK OUT</b>
     </div>
     <div class="clear-fix"></div>
     </div>
     </a>   
    </div>
</header>
    
    <?php echo $page; ?>
    
    <footer >
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