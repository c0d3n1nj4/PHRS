<script type='text/javascript'>
$(document).ready(function() {
	var rpDialog = $('#reserve_patient_form');
	
	rpDialog.dialog({
		resizable: true,	
		autoOpen: true,
		width:"auto",
		modal: true,
		open: function () {
			
		},		
		buttons: {
			Close: function() {
				rpDialog.dialog( "close" );
			}
		},
		close: function () {
			location.href=baseurl+'dashboard';
		}		
	});	
});
</script>

<div id="reserve_patient_form" title="Reserve Patient">					
	<form action="<?php echo base_url('dashboard/add_new_reservation/'); ?>" method="post" class="smart-green">
	<input type="hidden" name="patient_patient_id" value="<?php echo $patient_patient_id; ?>" />
	<input type="hidden" id="status" name="status" value="Waiting">	
		<table cellpadding="2">		
			<tr>
				<td style="background:#d2e7f0">Name:</td>
				<td><b><?php echo $first_name."&nbsp;".$middle_name."&nbsp;".$last_name; ?></b></td>
			</tr>		
			<tr>
				<td style="background:#d2e7f0">Priority:</td>
				<td><input type="text" name="priority" id="priority" size="5" /></td>
			</tr>			
			<tr>
				<td style="background:#d2e7f0">Reservation Date:</td>
				<td><input type="text" name="date_reserved" id="date_reserved" size="10" value="" /></td>
			</tr>			
			<tr>
				<td></td>
				<td>
					<input type="submit" name="submit_new_reservation" id="submit" class="button" value="Reserve" />
				</td>
			</tr>						
		</table>
	</form>
</div>	