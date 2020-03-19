<script type='text/javascript'>
// http://saigework.blogspot.com/2011/08/how-to-pass-data-to-jquery-dialog.html
$(function() {
	var myDialog = $('#update_visit_form');
	
	myDialog.dialog({
		resizable: true,	
		autoOpen: true,
		width:"auto",
		modal: true,
		buttons: {
			Close: function() {
				myDialog.dialog( "close" );
			}
		},		
		open: function () {
			
		},		
		close: function () {
			location.href=baseurl+'dashboard/get_personal_info/'+<?php echo $visit[0]->patient_patient_id; ?>+'/'+<?php echo $page[0];?>;
		}		
	});	
});
</script>

<div id="update_visit_form" title="View / Update Visit Data">
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
	<form action="<?php echo base_url('dashboard/update_visit_data/'); ?>" method="post" class="smart-green">
	<input type="hidden" name="visit_id" value="<?php echo $visit[0]->visit_id; ?>" />
	<input type="hidden" name="patient_patient_id" value="<?php echo $visit[0]->patient_patient_id; ?>" />
	<input type="hidden" name="page" value="<?php echo $page[0]; ?>" />
		<table cellpadding="2">
			<tr>
				<td style="background:#d2e7f0">Age:</td>
				<td><input type="text" name="age" id="age" size="5" value="<?php echo $visit[0]->age; ?>" /></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Temperature:</td>
				<td><input type="text" name="temperature" id="temperature" size="5" value="<?php echo $visit[0]->temperature; ?>" /></td>
			</tr>				
			<tr>
				<td style="background:#d2e7f0">Weight:</td>
				<td>
					<input type="text" name="weight" id="weight" size="5" value="<?=(substr(trim($visit[0]->weight), -2) == "kg")?substr(trim($visit[0]->weight), 0, -2):substr(trim($visit[0]->weight), 0, -3);?>" />&nbsp;
					<!--jc <em><b>(kg / lbs)</b></em> -->
					<input type="radio" name="weight_label" id="" value="kg" <?=(substr(trim($visit[0]->weight), -2) == "kg")?"checked='checked'":"";?> />kg&nbsp;
					<input type="radio" name="weight_label" id="" value="lbs" <?=(substr(trim($visit[0]->weight), -3) == "lbs")?"checked='checked'":"";?> />lbs					
				</td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Height:</td>
				<td>
					<input type="text" name="height" id="height" size="5" value="<?=(substr(trim($visit[0]->height), -2) == "cm")?substr(trim($visit[0]->height), 0, -2):substr(trim($visit[0]->height), 0, -6);?>" />&nbsp;
					<input type="radio" name="height_label" id="" value="inches" <?=(substr(trim($visit[0]->height), -6) == "inches")?"checked='checked'":"";?> />inches&nbsp;
					<input type="radio" name="height_label" id="" value="cm" <?=(substr(trim($visit[0]->height), -2) == "cm")?"checked='checked'":"";?> />cm
				</td>
			</tr>
			<tr>
				<td style="background:#d2e7f0">Complaints:</td>
				<td><textarea name="complaints" id="comments" rows="5" cols="36"><?php echo $visit[0]->complaints; ?></textarea></td>
			</tr>		
			<tr>
				<td style="background:#d2e7f0">Physician Findings:</td>
				<td><textarea name="physician_findings" id="comments" rows="5" cols="36"><?php echo $visit[0]->physician_findings; ?></textarea></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Treatment:</td>
				<td><textarea name="treatment" id="comments" rows="5" cols="36"><?php echo $visit[0]->treatment; ?></textarea></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Visit Date:</td>
				<td><input type="text" name="date_of_visit" id="datepicker" size="10" value="<?php echo $visit[0]->date_of_visit; ?>" /></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Charge / Fee:&nbsp;<img src="<?php echo base_url('assets/themes/default/images/peso_24x24.ico'); ?>" style="float:right;" /></td>
				<td><input type="text" name="charge" class="charge_textbox" size="10" value="<?php echo $visit[0]->charge; ?>" /></td>
			</tr>	
			<tr>
				<td style="background:#d2e7f0">Insurance:</td>
				<td>
					<select name="insurance">
						<option value="">None</option>
						<option value="FEMCO" <?=($visit[0]->insurance=='FEMCO')?"selected='selected'":''; ?>>FEMCO</option>
						<option value="PLDT" <?=($visit[0]->insurance=='PLDT')?"selected='selected'":''; ?>>PLDT</option>
						<option value="Intellicare" <?=($visit[0]->insurance=='Intellicare')?"selected='selected'":''; ?>>Intellicare</option>
						<option value="Philcare" <?=($visit[0]->insurance=='Philcare')?"selected='selected'":''; ?>>Philcare</option>
						<option value="MAXICARE" <?=($visit[0]->insurance=='MAXICARE')?"selected='selected'":''; ?>>MAXICARE</option>
						<option value="NC/COURTESY" <?=($visit[0]->insurance=='NC/COURTESY')?"selected='selected'":''; ?>>NC/COURTESY</option>
						<option value="ADMITTED" <?=($visit[0]->insurance=='ADMITTED')?"selected='selected'":''; ?>>ADMITTED</option>
						<option value="Medicard" <?=($visit[0]->insurance=='Medicard')?"selected='selected'":''; ?>>Medicard</option>
						<option value="Value Care" <?=($visit[0]->insurance=='Value Care')?"selected='selected'":''; ?>>Value Care</option>
						<option value="Cocolife" <?=($visit[0]->insurance=='Cocolife')?"selected='selected'":''; ?>>Cocolife</option>
						<option value="Caritas" <?=($visit[0]->insurance=='Cocolife')?"selected='selected'":''; ?>>Caritas</option>
					</select>	
				</td>
			</tr>			
			<tr>
				<td></td>
				<td>
					<input type="submit" name="submit_updated_visit_data" id="submit" class="button" value="Update" />&nbsp;
				</td>
			</tr>						
		</table>
	</form>
</div>