<?php $user = $this->session->userdata('user'); ?>
<?php error_reporting(0); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Pediatric Health Record System</title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/themes/default/images/favicon.ico'); ?>" />
	<link href="<?php echo base_url('assets/themes/default/css/style.css'); ?>" rel="stylesheet" media="screen" type="text/css" />
	<link href="<?php echo base_url('assets/themes/default/css/my-style.css'); ?>" rel="stylesheet" media="screen" type="text/css" />
	<link href="<?php echo base_url('assets/themes/default/css/my-form.css'); ?>" rel="stylesheet" media="screen" type="text/css" />
	<link href="<?php echo base_url('assets/themes/default/css/start/jquery-ui.min.css'); ?>" rel="stylesheet" media="screen" type="text/css" />
	<link href="<?php echo base_url('assets/themes/default/css/start/jquery.multiselect.css'); ?>" rel="stylesheet" media="screen" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/jquery-1.10.2.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/jquery-ui.js'); ?>"></script>	
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/jquery.multiselect.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/ddaccordion.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/modal_logout_confirmation.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/modal_add_visits.js'); ?>"></script>	
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/modal_add_reservations.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/modal_add_birth_history.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/modal_update_birth_history.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/alert.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/chat.js'); ?>"></script>
	<script type="text/javascript">
	ddaccordion.init({
		headerclass: "submenuheader", //Shared CSS class name of headers group
		contentclass: "submenu", //Shared CSS class name of contents group
		revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
		mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
		collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
		defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
		onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
		animatedefault: false, //Should contents open by default be animated into view?
		persiststate: true, //persist state of opened contents within browser session?
		toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
		togglehtml: ["suffix", "<img src='<?php echo base_url("assets/themes/default/images/plus.gif"); ?>' class='statusicon' />", "<img src='<?php echo base_url("assets/themes/default/images/minus.gif"); ?>' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
		animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
		oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
			//do nothing
		},
		onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
			//do nothing
		}
	})
	</script>

	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/jquery.jclock-1.2.0.js.txt'); ?>" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/jconfirmaction.jquery.js'); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.ask').jConfirmAction();
		});
	</script>

	<script type="text/javascript">
	$(function($) {
		$('.jclock').jclock();
	});
	
	$(function() {
		$("#calendar").datepicker();
		$("#vaccine_ids").multiselect();
	});	
	</script>	
	<script>
		$(function() {
			$("#datepicker, #datepicker2, #datepicker3, #datepicker4, #datepicker5, #datepicker6, #date_reserved").datepicker({
			yearRange:"1990:2020",
			dateFormat:"yy-mm-dd",
			changeMonth: true,
			changeYear: true
			});
		});
	</script>
	<script type="text/javascript">
		var baseurl = "<?php echo base_url(); ?>";
		var logout_user = "<?php echo base_url('/user/logout').'/'.$user[0]->user_id; ?>";
	</script>
	<script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/niceforms.js'); ?>"></script>
	<link href="<?php echo base_url('assets/themes/default/css/niceforms-default.css'); ?>" rel="stylesheet" media="screen" type="text/css" />
</head>

<body>
	<div id="main_container">
		<div class="header">
			<div class="logo"><a href="<?php echo base_url('dashboard'); ?>"><img src="<?php echo base_url('assets/themes/default/images/phrs-logo.png'); ?>" alt="" title="" border="0" /></a></div>
			<div class="right_header">Welcome <span id="user_logged"><?php echo $user[0]->username;?></span>&nbsp;<img src="<?php echo base_url('assets/themes/default/images/online.png'); ?>" id="on_off_line_img" /> | <a href="<?php echo base_url('/dashboard/get_user_messages/').'/'.$user[0]->user_id; ?>" class="messages"><span id="no_of_messages">(<?php echo count($user_messages); ?>)</span> Messages</a> | <a href="" class="logout" id="logout">Logout</a></div>
			<div class="jclock"></div>
		</div>
		
		<div class="main_content">
			<div class="menu">
				<ul>
					<li><a <?=(isset($current) && $current=='home')?"class='current'":'';?> href="<?php echo base_url('dashboard'); ?>"><img src="<?php echo base_url('assets/themes/default/images/home_nav.png'); ?>" id="home_img" />&nbsp;Dashboard</a></li>
					<li><a <?=(isset($current) && $current=='existing_patients')?"class='current'":'';?> href="<?php echo base_url('dashboard/get_existing_patients'); ?>"><img src="<?php echo base_url('assets/themes/default/images/list_nav.png'); ?>" id="home_img" />&nbsp;Existing Patients</a></li>
					<li><a <?=(isset($current) && $current=='help')?"class='current'":'';?>href="<?php echo base_url('dashboard/help'); ?>"><img src="<?php echo base_url('assets/themes/default/images/help_nav.png'); ?>" id="help_img" />&nbsp;Help</a></li>
				</ul>
			</div> 
				   
			<div class="center_content">  
				<div class="left_content">
					<div class="sidebar_search">
						<form method="POST" action="<?php echo base_url('/dashboard/search_patient'); ?>">
							<input type="text" name="search_keyword" class="search_input" placeholder="Search First OR Last Name..." />
							<input type="image" name="search_btn" class="search_submit" src="<?php echo base_url('assets/themes/default/images/search.png'); ?>" />
						</form>            
					</div>
					
					<!-- Recent Patients -->
					<div class="sidebar_box">
						<div class="sidebar_box_top"></div>
						<div class="sidebar_box_content">
							<h3>New Patients</h3>
							<img src="<?php echo base_url('assets/themes/default/images/contact_new.png'); ?>" id="contact_new" alt="" title="" class="sidebar_icon_right" />
							<p>
								<?php 
									$recent_patients = $this->session->userdata('recent_patients');
									if(!empty($recent_patients)) { 
										echo "<ul id='new_patients'>";
										foreach($recent_patients as $patient) {
											$href = base_url("dashboard/get_personal_info")."/".$patient->patient_id;
											echo "<li><a href=".$href.">".$patient->first_name." ".$patient->last_name."</a></li>";
										}	
										echo "</ul>";
									}	
								?>
							</p>                
						</div>
						<div class="sidebar_box_bottom"></div>
					</div>  
					<!-- /Recent Patients -->

					<!-- Users -->	
					<div class="sidebar_box">
						<div class="sidebar_box_top"></div>
						<div class="sidebar_box_content">
							<h3>Users</h3>
							<img src="<?php echo base_url('assets/themes/default/images/user_group.png'); ?>" id="user_group" alt="" title="" class="sidebar_icon_right" />
							<p>
								<?php 
									$all_users = $this->session->userdata('all_users');
									if(!empty($all_users)) { 
										echo "<ul id='users'>";
										foreach($all_users as $users) {
											echo "<li>";
											
											if ($users->logged == 'Y') {
												echo "<img src='".base_url('assets/themes/default/images/online.png')."' id='on_off_line_img' />";
											} else {
												echo "<img src='".base_url('assets/themes/default/images/offline.png')."' id='on_off_line_img' />";
											}
											echo " ".$users->username."</li>";
										}	
										echo "</ul>";
									}	
								?>							
							</p>						
						</div>
						<div class="sidebar_box_bottom"></div>
					</div>
					<!-- /Users -->						
					
					<!-- Chat -->
					<div class="sidebar_box">
						<div class="sidebar_box_top"></div>
						<div class="sidebar_box_content">
							<h4>Chat Box</h4>
							<img src="<?php echo base_url('assets/themes/default/images/chat.png'); ?>" alt="" title="" class="sidebar_icon_right" />	
							<div class="clr"> </div>
							<div id="received"> </div>		
							
							<form id="chat_form">
								<input type="hidden" id="chat_user" value="<?php echo $user[0]->username;?>" />
								<input type="text" id="chat_box_text" />
							</form>
						</div>
						<div class="sidebar_box_bottom"></div>
					</div>
					<!-- /Chat -->		

					<!-- Calendar -->
					<div class="sidebar_box">
						<div class="sidebar_box_top"></div>
						<div class="sidebar_box_content">
							<h4>Calendar</h4>
							<img src="<?php echo base_url('assets/themes/default/images/calendar_blank.png'); ?>" alt="" title="" id="calendar_icon" class="sidebar_icon_right" />	
							<div class="clr"> </div>
							
							<div id="calendar"></div>
						</div>
						<div class="sidebar_box_bottom"></div>
					</div>
					<!-- /Calendar -->						
				</div>  
	
			
				<div class="right_content">      
					<?php echo $output; ?>
				</div><!-- end of right content-->
			</div>   <!--end of center content -->               

			<div class="clear"></div>
		</div> <!--end of main content-->

		<!-- Logout Confirmation Dialog -->
		<div id="confirm_logout" title="Confirm Logout">
			<p> Are you sure?</p>
		</div>		
		<!-- /Logout -->
		
		<div class="footer">
			<div class="left_footer">Pediatric Health Record System</div>
			<div class="right_footer">Programmed By:<a href="http://jobelclarabal.com">Jobel Clarabal</a></div>
		</div>
	</div>		
</body>
</html>