	<?php $user = $this->session->userdata('user'); ?>
	
	<!-- Success message -->
	<?php if($this->session->flashdata('flashSuccess')) { ?>	
		<div class="valid_box">
			<b><?php echo $this->session->flashdata('flashSuccess'); ?></b>
		</div>
	<?php } ?>
 
	<!-- Failed message -->
	<?php if($this->session->flashdata('flashError')) { ?>
		<div class="error_box">
			<b><?php echo $this->session->flashdata('flashError'); ?></b>
		</div>	
	<?php } ?>	

	<?php if(!empty($message) && ($success=="1")) { ?>
		<!-- Success message -->
		<div class="valid_box">
			<b><?php echo $message; ?></b>
		</div>
	<?php } else if(!empty($message) && ($success=="0")) { ?>
		<!-- Failed message -->
		<div class="error_box">
			<b><?php echo $message; ?></b>
		</div>
	<?php } ?>
	

	<h2>Reserved Patients</h2>
	<form action="<?php echo base_url('dashboard/search_reservation/'); ?>" method="post" class="smart-green" style="padding:5px 10px">
		<p>
			Search by Date: <input type="text" name="date_reserved" id="datepicker" size="5" style="width:220px !important" /> <input type="image" name="search_btn" src="<?php echo base_url('assets/themes/default/images/search2.png'); ?>" style="vertical-align:middle; margin-top:-5px;" title="Search Reserved Patients" />
		</p>	
	</form>
	
	<script>	
	$(document).ready(function() {
		$("#content").tooltip({ content: '<img src="'+baseurl+'/uploads/images/default_profile_male.jpg" />' }); 
	});	
	</script>
		
	<a href="" class="bt_green" id="add_new_reservations_btn" title="Add New Reservations" style="margin-left:0 margin-top:10px;"><span class="bt_green_lft"></span><strong>Add New Reservations</strong><span class="bt_green_r"></span></a><a href="<?php echo base_url('dashboard'); ?>"> <button type="button" style="padding:3px; margin-left:20px; cursor:pointer; color:blue;" title="Reload Reservations"><b>REFRESH Reservation Data</b></button> </a><div style="clear:both;">&nbsp;</div>

	<?php /*$this->view('add-reservations');*/ ?>
	<div id="add_reservations_form" title="Add New Reservation">					
		<form action="<?php echo base_url('dashboard/search_patient_res/'); ?>" method="post" id="form_add_reservations" class="smart-green">  
			<label for="name">Search First or Last Name</label>
			<input type="text" id="search_keyword" name="search_keyword" placeholder="Search First OR Last Name..." style="width:220px !important" />
			<input type="image" class="search_btn" name="search_btn" src="<?php echo base_url('assets/themes/default/images/search2.png'); ?>" style="vertical-align:middle; margin-top:-5px;" title="Search Reserved Patients" />
		</form>					

		<table id="rounded-corner" class="fluid resultTable"></table>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('.search_btn').click(function(){
					if ($('input#search_keyword').val()=='') {
						alert("Please enter First or Last Name");
						return false;
					} else {	
						makeAjaxRequest();
					}	
				});

				$('form#form_add_reservations').submit(function(e){
					e.preventDefault();
					makeAjaxRequest();
					return false;
				});

				function makeAjaxRequest() {
					var request = $.ajax({
						url: 'dashboard/search_patient_res/',
						type: 'post',
						data: {search_keyword: $('input#search_keyword').val()},
						dataType: 'html',
						success: function(response) {
							$('table.resultTable').html($(response).filter('.search_patients').html());
							// $('#search_results').html(''+$(response).filter('.search_patients').html());
							console.log($(response).filter('.tr_patients').html());
						},
						/*
						success: function (data) {
							//response = jQuery.parseJSON(data);
							console.log(data);
						},
						*/
						error: function () {
							alert("error");
						}						
					});
				}
			});
		</script>
	</div>	
	
	<p style="font:bold 14px Arial"><br/ > Patients for <span style="color:red"><?= (!empty($filter_date))?date("F d, Y", strtotime($filter_date)):date("F d, Y"); ?></span></p>	
	<table id="rounded-corner" class="fluid">
		<thead>
			<tr>
				<th scope="col" class="rounded">Priority</th>
				<th scope="col" class="rounded">First Name</th>
				<th scope="col" class="rounded">Middle Name</th>
				<th scope="col" class="rounded">Last Name</th>
				<th scope="col" class="rounded">Status</th>
				<th scope="col" class="rounded">Charge</th>
				<th scope="col" class="rounded">Insurance</th>
				<th scope="col" class="rounded-q4" align="center">Delete</th>
			</tr>
		</thead>
		<?php if(!empty($reservations)) { ?>
		<tbody>
			<?php $cntr=1; $row_cntr=0; ?>
			<?php foreach($reservations as $r) { ?>
			
			<?= ($cntr%2 == 0) ? "<tr style='background-color:#f5f5f5;'>" : "<tr style='background-color:#ffffff;'>"; ?>
				<td><?php echo $r['priority']; ?></td>
				<td><a href="<?php echo base_url('dashboard/get_personal_info/').'/'.$r['patient_id']; ?>"><?php echo $r['first_name']; ?></a></td>
				<td><a href="<?php echo base_url('dashboard/get_personal_info/').'/'.$r['patient_id']; ?>"><?php echo $r['middle_name']; ?></a></td>				
				<td><a href="<?php echo base_url('dashboard/get_personal_info/').'/'.$r['patient_id']; ?>"><?php echo $r['last_name']; ?></a></td>
				<td>
					<a href="<?php echo base_url('dashboard/update_reservation_status/').'/'.$r['reservation_id'].'/'.$r['status'].'/'.$r['date_reserved']; ?>" style="font-weight:bold; <?=($r['status'] == 'Waiting')?'color:orange':'color:green'; ?>" title="Change Reservation Status"><?php echo $r['status']; ?></a>
				</td>
				<td><b style="color:red"><?php echo $r['charge']; ?></b></td>
				<td><b style="color:red"><?php echo $r['insurance']; ?></b></td>
				<td align="center"><a href="<?php echo base_url('dashboard/delete_reservation/').'/'.$r['reservation_id']; ?>" class="ask"><img src="<?php echo base_url('assets/themes/default/images/trash.png'); ?>" alt="" title="Delete Reservation" border="0" /></a></td>
			</tr>  	
			<?php $cntr++; $row_cntr++; ?>		
			<?php } ?>	
			<tr style="background-color:#F7F8E0">
				<td colspan='5'><b style="color:green; font-size:18px;">TOTAL</b></td>
				<td colspan='2'><b style="color:green; font-size:18px;"><?=(!empty($r['total']))?$r['total']:''; ?></b></td>
				<td class="rounded-foot-right">&nbsp;</td>
			</tr>			
		</tbody>	
		<tfoot>
			<tr>
				<td colspan='7' class="rounded-foot-left"><em><b>Showing <?php echo $reservations_count; ?>&nbsp;record(s)</b></em></td>
				<td class="rounded-foot-right">&nbsp;</td>
			</tr>
		</tfoot>			
		<?php } else { ?>
		<tfoot>
			<tr>
				<td colspan='7' class="rounded-foot-left"><em>No record(s) found.</em></td>
				<td class="rounded-foot-right">&nbsp;</td>
			</tr>
		</tfoot>		
		<?php } ?>
	</table>