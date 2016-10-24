<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $description; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Extra metadata -->
        <?php echo $metadata; ?>
        <!-- / -->

        <!-- BEGIN PLUGIN CSS -->
        <link href="<?php echo base_url()?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo base_url()?>assets/plugins/bootstrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/plugins/bootstrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/plugins/animate.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" />
        <!-- <link href="<?php //echo base_url('assets/css/bootstrap-modal-bs3patch.css')?>" rel="stylesheet"> -->
        
        <!-- END PLUGIN CSS -->
        <!-- BEGIN CORE CSS FRAMEWORK -->
        <link href="<?php echo base_url()?>webarch/css/webarch.css" rel="stylesheet" type="text/css" />
        <!-- END CORE CSS FRAMEWORK --> 

        <!-- BEGIN DATATABLES 
        <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
        END DATATABLES -->

        <?php echo $css; ?>
        <!-- / -->
    </head>
    <?php $hidesidebar = ($hide_sidebar) ? $hide_sidebar : '' ; ?>
    <body class="<?php echo $hidesidebar; ?>">
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
        <?php echo $body; ?>
        <!-- / -->

        <!-- BEGIN CORE JS FRAMEWORK-->
        <!--<script src="<?php echo base_url()?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>-->
        <!-- BEGIN JS DEPENDECENCIES-->
        <script src="<?php echo base_url()?>assets/plugins/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/plugins/jquery-block-ui/jqueryblockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
        <!-- END CORE JS DEPENDECENCIES-->
        <!-- BEGIN CORE TEMPLATE JS -->
        <script src="<?php echo base_url()?>webarch/js/webarch.js" type="text/javascript"></script>
        <!--<script src="<?php echo base_url()?>assets/js/chat.js" type="text/javascript"></script>-->
        <!-- END CORE TEMPLATE JS -->
        <!-- BEGIN DATATABLES 
        <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
        END DATATABLES -->
        <!-- Extra javascript -->
        <?php echo $js; ?>

        <!-- / -->

        <?php if ( ! empty($ga_id)): ?><!-- Google Analytics -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','<?php echo $ga_id; ?>');ga('send','pageview');
        </script>
        <?php endif; ?><!-- / -->
    </body>
</html>