<div id="add_visit_form" title="Add New Visit Data">
	<form action="<?php echo base_url('dashboard/add_new_visit/'); ?>" method="post" class="smart-green" enctype="multipart/form-data" id="add-patient-form">
	<input type="hidden" name="patient_patient_id" value="<?php echo $patients[0]->patient_id; ?>" />
		<table cellpadding="2">
			<tr>
				<td style="background:#d2e7f0">Age:</td>
				<td><input type="text" name="age" id="age" size="5" /></td>
			</tr>
			<tr>
				<td style="background:#d2e7f0">Temperature:</td>
				<td><input type="text" name="temperature" id="temperature" size="5" /></td>
			</tr>			
			<tr>
				<td style="background:#d2e7f0">Weight:</td>
				<td>
					<input type="text" name="weight" id="weight" size="5" />&nbsp;
					<input type="radio" name="weight_label" id="" value="kg" checked="checked" />kg&nbsp;
					<input type="radio" name="weight_label" id="" value="lbs" />lbs
				</td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Height:</td>
				<td>
					<input type="text" name="height" id="height" size="5" />&nbsp;
					<input type="radio" name="height_label" id="" value="inches" checked="checked" />inches&nbsp;
					<input type="radio" name="height_label" id="" value="cm" />cm
				</td>
			</tr>
			<tr>
				<td style="background:#d2e7f0">Complaints:</td>
				<td><textarea name="complaints" id="comments" rows="5" cols="36"></textarea></td>
			</tr>		
			<tr>
				<td style="background:#d2e7f0">Physician Findings:</td>
				<td><textarea name="physician_findings" id="comments" rows="5" cols="36"></textarea></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Treatment:</td>
				<td><textarea name="treatment" id="comments" rows="5" cols="36"></textarea></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Visit Date:</td>
				<td><input type="text" name="date_of_visit" id="datepicker" size="10" value="" /></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Charge / Fee:&nbsp;<img src="<?php echo base_url('assets/themes/default/images/peso_24x24.ico'); ?>" style="float:right;" /></td>
				<td><input type="text" name="charge" class="charge_textbox" size="10" value="" /></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Insurance:</td>
				<td>
					<select name="insurance">
						<option value="">None</option>
						<option value="FEMCO">FEMCO</option>
						<option value="PLDT">PLDT</option>
						<option value="Intellicare">Intellicare</option>
						<option value="Philcare">Philcare</option>
						<option value="MAXICARE">MAXICARE</option>
						<option value="NC/COURTESY">NC/COURTESY</option>
						<option value="ADMITTED">ADMITTED</option>
						<option value="ADMITTED">Medicard</option>
						<option value="ADMITTED">Value Care</option>
						<option value="ADMITTED">Cocolife</option>
						<option value="ADMITTED">Caritas</option>
					</select>	
				</td>
			</tr>				
			<tr>
				<td></td>
				<td>
					<input type="submit" name="submit_new_visit" id="submit" class="button" value="Add" />
				</td>
			</tr>						
		</table>
	</form>
</div>