<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php if($this->router->fetch_method()!='index'){echo $this->router->fetch_method().' - '; }  echo $title;?> | Erlangga </title>
    <base href="<?php echo base_url(); ?>"></base>
    <link href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/front/css/styles.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/front/css/media.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/front/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" />
    <?php echo $css; ?>
</head>

<body>
    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
    <?php echo $body; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
 <script src="<?php echo base_url(); ?>assets/front/js/owl.carousel.min.js" type="text/javascript" charset="utf-8"></script>
     <script src="<?php echo base_url(); ?>assets/front/js/owl.carousel.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo base_url(); ?>assets/front/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
<?php echo $js; ?>
</body>
</html>