<script type='text/javascript'>
$(document).ready(function() {
	var irDialog = $('#update_immunization_record');
	
	irDialog.dialog({
		resizable: true,	
		autoOpen: true,
		width:"auto",
		modal: true,
		buttons: {
			Close: function() {
				irDialog.dialog( "close" );
			}
		},
		close: function () {
			location.href=baseurl+'dashboard/get_personal_info/'+<?php echo $immunization_record[0]->patient_patient_id; ?>+'/tab3';
		}		
	});	
});
</script>

<div id="update_immunization_record" title="View / Update Immunization Record">
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
	
	<form action="<?php echo base_url('dashboard/update_immunization_record/'); ?>" method="post" class="smart-green">
	<input type="hidden" name="immunization_record_id" value="<?php echo $immunization_record[0]->immunization_record_id; ?>" />
	<input type="hidden" name="patient_patient_id" value="<?php echo $immunization_record[0]->patient_patient_id; ?>" />
	<input type="hidden" name="page" value="<?php echo $page[0]; ?>" />	
		<table cellpadding="2">
			<tr>
				<td style="background:#d2e7f0">Vaccines:</td>
				<td>
					<select id="vaccine_ids" name="vaccine_ids[]" multiple="multiple">
						<?php
							$vacc = array();
							$vacc_arr = explode(",", $immunization_record[0]->vaccines);							
							foreach($vaccines as $vacc) { 							
						?>
						<?php 
								//foreach ($vacc_arr as $key=>$val) {
									// if ($vacc->vaccine_id == $val) {
										if (in_array($vacc->vaccine_id, $vacc_arr)) {
						?>
									<option value="<?php echo $vacc->vaccine_id ?>" selected="selected"><?php echo $vacc->vaccine_description ?></option>
								<?php } else { ?>	
									<option value="<?php echo $vacc->vaccine_id ?>"><?php echo $vacc->vaccine_description ?></option>	
								<?php } ?>
						<?php //} ?>	
						<?php } ?>	
					</select>
				</td>	
			</tr>		
			<tr>
				<td style="background:#d2e7f0">1st:</td>
				<td><input type="text" name="first" id="datepicker" size="10" value="<?=($immunization_record[0]->first=='0000-00-00')?'':$immunization_record[0]->first; ?>" /></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">2nd:</td>
				<td><input type="text" name="second" id="datepicker2" size="10" value="<?=($immunization_record[0]->second=='0000-00-00')?'':$immunization_record[0]->second; ?>" /></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">3rd:</td>
				<td><input type="text" name="third" id="datepicker3" size="10" value="<?=($immunization_record[0]->third=='0000-00-00')?'':$immunization_record[0]->third; ?>" /></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Booster 1:</td>
				<td><input type="text" name="booster_one" id="datepicker4" size="10" value="<?=($immunization_record[0]->booster_one=='0000-00-00')?'':$immunization_record[0]->booster_one; ?>" /></td>
			</tr>		
			<tr>
				<td style="background:#d2e7f0">Booster 2:</td>
				<td><input type="text" name="booster_two" id="datepicker5" size="10" value="<?=($immunization_record[0]->booster_two=='0000-00-00')?'':$immunization_record[0]->booster_two; ?>" /></td>
			</tr>		
			<tr>
				<td style="background:#d2e7f0">Booster 3:</td>
				<td><input type="text" name="booster_three" id="datepicker6" size="10" value="<?=($immunization_record[0]->booster_three=='0000-00-00')?'':$immunization_record[0]->booster_three; ?>" /></td>
			</tr>
			<tr>
				<td style="background:#d2e7f0">Other Vaccine:</td>
				<td><textarea name="other_vaccine" id="other_vaccine" rows="3" cols="36"></textarea></td>
			</tr>					
			<tr>
				<td style="background:#d2e7f0">Reaction:</td>
				<td><textarea name="reaction" id="reaction" rows="5" cols="36"><?php echo $immunization_record[0]->reaction; ?></textarea></td>
			</tr>			
			<tr>
				<td></td>
				<td>
					<input type="submit" name="submit_updated_immunization_record" id="submit" class="button" value="Update" />
				</td>
			</tr>						
		</table>
	</form>
</div>