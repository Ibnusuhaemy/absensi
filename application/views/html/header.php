<!DOCTYPE html>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700i]talic" rel="stylesheet" type="text/css"> -->

<link rel="stylesheet" href="<?php echo base_url()?>assets/css/theme.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/prism.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/chosen.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/clockpicker.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/dataTables.bootstrap.min.css">

<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.js"></script>

<script type="text/javascript" src="<?php echo base_url()?>assets/js/jQuery.print.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo base_url()?>assets/js/highcharts.src.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/exporting.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/clockpicker/highlight.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/clockpicker/bootstrap-clockpicker.min.js"></script>
 



<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title" id="myModalLabel">Login Bos</h4>
          	</div>
        	<form class="form-horizontal" action="<?php echo site_url('Home_C/login/') ?>" method="POST" role="form">
          		<div class="modal-body ">
              		<div class="form-group">
                		<div class="col-sm-12">
                  			<input type="text" class="form-control" placeholder="Username" name="l_username" value="<?php echo set_value('l_username'); ?>">
                		</div>
              		</div>
              		<div class="form-group">
                		<div class="col-sm-12">
                  			<input type="password" class="form-control" placeholder="Password" name="l_password" value="<?php echo set_value('l_password'); ?>">
                		</div>
              		</div>
	          	</div>
	          	<div class="modal-footer">
	            	<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
	            	<button type="submit" class="btn btn-primary">Masuk</button>
	          	</div>
        	</form>
        </div>
    </div>
</div>

<script type='text/javascript'>
//<![CDATA[
jQuery(function($) { 'use strict';
    
    $('button#print_btn').on('click', function(e) {
      $(".absen_print").print({
        //Use Global styles
        globalStyles : false,
        //Add link with attrbute media=print
        mediaPrint : false,
        //Custom stylesheet
        stylesheet : "<?php echo base_url("assets/css/bootstrap.css") ?>",
        //Print in a hidden iframe
        iframe : false,
        //Don't print this
        //noPrintSelector : ".avoid-this",
        //Add this at top
        //prepend : "Hello World!!!<br/>",
        //Add this on bottom
        //append : "<br/>Buh Bye!",
        //Log to console when printing is done via a deffered callback
        deferred: $.Deferred().done(function() { console.log('Printing done', arguments); })
      });
    });
    // Fork https://github.com/sathvikp/jQuery.print for the full list of options
});
//]]>
</script>

<style type="text/css">
  .a{
    width: 90px;
    overflow: hidden;
    display: inline-block;
    white-space: nowrap;
}
</style>