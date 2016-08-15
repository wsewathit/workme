<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $title; ?></title>

<meta charset="utf-8">
<!--  SCRIPT JS -->
    <script type="text/javascript" src="<?php echo base_url('assets/template/js/jquery-2.1.1.min.js');?>"></script>
<!--  end -->
	
	<link href="<?php echo base_url('assets/template/css/bootstrap.css');?>" rel='stylesheet' type='text/css' />
	<script src="<?php echo base_url('assets/template/')?>/js/bootstrap.min.js"></script>
	
	<!-- animate -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>


	<script src="<?php echo base_url('assets/template/js/wow.min.js'); ?>"></script>
	<link href="<?php echo base_url('assets/template/css/animate.css'); ?>" rel='stylesheet' type='text/css' />
	
	
	<script>
		new WOW().init();
	</script>
	<!-- end animate -->
</head>
<body>
<?php echo $head;?>

<?php echo $content;?>

<?php echo $footer;?>
</body>
</html>		