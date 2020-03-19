<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Pediatric Health Record System</title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/themes/default/images/favicon.ico'); ?>" />
	<link href="<?php echo base_url('assets/themes/default/css/style.css'); ?>" rel="stylesheet" media="screen" type="text/css" />
	<link href="<?php echo base_url('assets/themes/default/css/my-style.css'); ?>" rel="stylesheet" media="screen" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/jquery-1.10.2.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/jquery.jclock-1.2.0.js.txt'); ?>" type="text/javascript"></script>
	<script type="text/javascript">
	$(function($) {
		$('.jclock').jclock();
	});
	</script>	
</head>

<body>
	<div id="main_container">
		<div class="header">
			<div class="logo"><a href="<?php echo base_url('/dashboard'); ?>"><img src="<?php echo base_url('assets/themes/default/images/phrs-logo.png'); ?>" alt="" title="" border="0" /></a></div>
			<div class="jclock"></div>
		</div>
		
		<div class="main_content">
			<div class="menu">&nbsp;</div> 
				   
			<div class="center_content">  
				<div id="custom404">
					<img src="<?php echo base_url('assets/themes/default/images/exclamation.png'); ?>" />
					<img src="<?php echo base_url('assets/themes/default/images/page-not-found-404.png'); ?>" />
					<p style="text-align:center;"><a href="<?php echo base_url('/dashboard'); ?>"> Back to Dashboard </a></p>
				</div>	
			</div>   <!--end of center content -->               

			<div class="clear"></div>
		</div> <!--end of main content-->
		
		<div class="footer">
			<div class="left_footer">Pediatric Health Record System</div>
			<div class="right_footer">Programmed By:<a href="http://jobelclarabal.com">Jobel Clarabal</a></div>
		</div>
	</div>		
</body>
</html>