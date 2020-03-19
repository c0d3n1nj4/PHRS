<script type='text/javascript'>
$(document).ready(function() {
	var irDialog = $('#add_immunization_record');
	
	irDialog.dialog({
		resizable: true,	
		autoOpen: true,
		width:"auto",
		modal: true,
		open: function () {
			/* $(".center_content").hide(); */
		},		
		buttons: {
			Close: function() {
				irDialog.dialog( "close" );
			}
		},
		close: function () {
			location.href=baseurl+'dashboard/get_personal_info/'+<?php echo $patient_patient_id[0]; ?>+'/tab3';
		}		
	});	
});
</script>

<div id="add_immunization_record" title="Add Immunization Record">
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
	
	<form action="<?php echo base_url('dashboard/add_immunization_record/'); ?>" method="post" class="smart-green">
	<input type="hidden" name="patient_patient_id" value="<?php echo $patient_patient_id; ?>" />
		<table cellpadding="2">
			<tr>
				<td style="background:#d2e7f0">Vaccine:</td>
				<td>
					<select id="vaccine_ids" name="vaccine_ids[]" multiple="multiple">
						<?php foreach($vaccines as $vacc) { ?>
							<option value="<?php echo $vacc->vaccine_id ?>"><?php echo $vacc->vaccine_description ?></option>
						<?php } ?>	
					</select>
				</td>	
			</tr>		
			<tr>
				<td style="background:#d2e7f0">1st:</td>
				<td><input type="text" name="first" id="datepicker" size="10" value="" /></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">2nd:</td>
				<td><input type="text" name="second" id="datepicker2" size="10" value="" /></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">3rd:</td>
				<td><input type="text" name="third" id="datepicker3" size="10" value="" /></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Booster 1:</td>
				<td><input type="text" name="booster_one" id="datepicker4" size="10" value="" /></td>
			</tr>		
			<tr>
				<td style="background:#d2e7f0">Booster 2:</td>
				<td><input type="text" name="booster_two" id="datepicker5" size="10" value="" /></td>
			</tr>		
			<tr>
				<td style="background:#d2e7f0">Booster 3:</td>
				<td><input type="text" name="booster_three" id="datepicker6" size="10" value="" /></td>
			</tr>
			<tr>
				<td style="background:#d2e7f0">Other Vaccine:</td>
				<td><textarea name="other_vaccine" id="other_vaccine" rows="3" cols="36"></textarea></td>
			</tr>				
			<tr>
				<td style="background:#d2e7f0">Reaction:</td>
				<td><textarea name="reaction" id="reaction" rows="5" cols="36"></textarea></td>
			</tr>			
			<tr>
				<td></td>
				<td>
					<input type="submit" name="submit_new_immunization_record" id="submit" class="button" value="Add" />
				</td>
			</tr>						
		</table>
	</form>
</div>