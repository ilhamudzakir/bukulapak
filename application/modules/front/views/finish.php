<section>
<div class="title2">
     <div class="container">
          <div class="col-md-6 pull-left padding-botop"><h3></h3> </div>
          <div class="col-md-3 pull-right text-right">
            <a href="<?php echo site_url() ?>"><button class="form btn1" name="submit" type="submit">
<span id="search">Cari</span>
</button>
</a>
          </div>
         
         
     </div>
</div>
</section>
<section class="matobot">
	<div class="container text-center">
  <?php
  $staticc=str_replace('*order_code', $order_code, $static->content);
        $message=str_replace('*order_total', number_format($order_total), $staticc);
        echo $message;
  ?>
	</div><!----end container-------------->
</section>