<header <?php if(!$this->uri->segment(1) or $this->uri->segment(3)=='home' ){ ?> class="b-none" <?php } ?>>
    <div class="container">
     <div class="col-md-8 pull-left" style="padding-top:15px;"><a href="<?php echo base_url() ?>"><img src="assets/front/images/logo.png"></a></div>
     <a href="<?php echo site_url('front/carts')?>">
     <div class="col-md-2 pull-right checkout">
     <div class="count-checkout">
            <div class="text-checkout"><?php echo $this->cart->total_items()?></div>
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