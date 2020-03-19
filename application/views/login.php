<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Pediatric Health Record System</title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/themes/default/images/favicon.ico'); ?>" />
	<link href="<?php echo base_url('assets/themes/default/css/style.css'); ?>" rel="stylesheet" media="screen" type="text/css" />
	<link href="<?php echo base_url('assets/themes/default/css/niceforms-default.css'); ?>" rel="stylesheet" media="screen" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/jquery-1.10.2.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/niceforms.js'); ?>"></script>	
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/jquery.jclock-1.2.0.js.txt'); ?>" type="text/javascript"></script>
	<script type="text/javascript">
	$(function($) {
		$('.jclock').jclock();
	});
	</script>
</head>

<body>
	<div id="main_container">
		<div class="jclock" id="jclock_login"></div>
		<?php if(!empty($message) && ($success=="0")) { ?>
			<!-- Authentication Failed message -->
			<div class="error_box" id="login_error_box">
				<b><?php echo $message; ?></b>
			</div>
		<?php } ?>	
		<div class="header_login">
			<div class="logo"><a href="#"><img src="<?php echo base_url('assets/themes/default/images/phrs-logo.png'); ?>" alt="" title="" border="0" /></a></div>
		</div>
		<div class="login_form">
			<h3>Admin Panel Login</h3>
			<!--jc <a href="#" class="forgot_pass">Forgot password</a> -->
		 
			<form action="<?php echo base_url('user/authenticate'); ?>" method="POST" class="niceform">
				<fieldset>
					<dl>
						<dt><label for="username">Username:</label></dt>
						<dd><input type="text" name="username" id="" size="40" title="Please enter your Username here." /></dd>
					</dl>
					<dl>
						<dt><label for="password">Password:</label></dt>
						<dd><input type="password" name="password" id="" size="40" title="Please enter your Password here." /></dd>
					</dl>
					<!--jc
					<dl>
						<dt><label></label></dt>
						<dd>
						<input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Remember me</label>
						</dd>
					</dl>
					-->
					
					<dl class="submit">
						<input type="image" name="login_btn" id="login_btn" src="<?php echo base_url('assets/themes/default/images/login_btn.png'); ?>" alt="Login" title="Please Click to Login." />
					</dl>
				</fieldset>
			</form>
		</div>  

		<div class="footer_login">
				<div class="left_footer_login">Pediatric Health Record System</div>
				<div class="right_footer_login">Programmed By:<a href="http://jobelclarabal.com">Jobel Clarabal</a></div>

		</div>
	</div>		
</body>
</html>	