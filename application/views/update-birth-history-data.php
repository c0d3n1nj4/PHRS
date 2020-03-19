<script type='text/javascript'>
$(document).ready(function() {
	var bhDialog = $('#update_birth_history_form');
	
	bhDialog.dialog({
		resizable: true,	
		autoOpen: true,
		width:"auto",
		modal: true,	
		buttons: {
			Close: function() {
				bhDialog.dialog( "close" );
			}
		},	
		close: function () {
			location.href=baseurl+'dashboard/get_personal_info/'+<?php echo $birth_history[0]->patient_patient_id; ?>;
		}		
	});	
});
</script>

<div id="update_birth_history_form" title="View / Update Birth History Data">
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
	<form action="<?php echo base_url('dashboard/update_birth_history_data/'); ?>" method="post" class="smart-green">
	<input type="hidden" name="birth_history_id" value="<?php echo $birth_history[0]->birth_history_id; ?>" />
	<input type="hidden" name="patient_patient_id" value="<?php echo $birth_history[0]->patient_patient_id; ?>" />
		<table class="fluid" cellpadding="5" cellspacing="10">
			<tr>	
				<td colspan="2"><input type="checkbox" name="preterm" id="" value="Y" <?=($birth_history[0]->preterm=='Y')?'checked':'';?> />&nbsp;<b>Preterm:</b></td>
				<td colspan="2"><input type="checkbox" name="full_term" id="" value="Y" <?=($birth_history[0]->full_term=='Y')?'checked':'';?> />&nbsp;<b>Full Term:</b></td>
			</tr>
			<tr>					
				<td colspan="2"><b>Type of Delivery:</b></td>
				<td><input type="checkbox" name="nsd" id="" value="Y" <?=($birth_history[0]->nsd=='Y')?'checked':'';?> />&nbsp;<b>NSD:</b></td>
				<td><input type="checkbox" name="cs" id="" value="Y" <?=($birth_history[0]->cs=='Y')?'checked':'';?> />&nbsp;<b>CS:</b></td>
			</tr>
			<tr>					
				<td>
					<b>Birth Weight:</b>&nbsp;
					<input type="text" name="birth_weight" id="bh_textbox" size="5" value="<?php echo $birth_history[0]->birth_weight; ?>" />
					<!--jc
					&nbsp;
					<input type="radio" name="weight_label" id="" value="kg" checked="checked" />kg&nbsp;
					<input type="radio" name="weight_label" id="" value="lbs" />lbs		
					-->
				</td>
				<td><b>Percentile:</b>&nbsp;<input type="text" name="bw_percentile" id="bh_textbox" size="5" value="<?php echo $birth_history[0]->bw_percentile; ?>" />&nbsp;%</td>
				<td><b>Birth Head Circumference:</b>&nbsp;<input type="text" name="birth_head_circumference" id="bh_textbox" size="5" value="<?php echo $birth_history[0]->birth_head_circumference; ?>" /></td>
				<td><b>Percentile:</b>&nbsp;<input type="text" name="bhc_percentile" id="bh_textbox" size="5" value="<?php echo $birth_history[0]->bhc_percentile; ?>" />&nbsp;%</td>
			</tr>
			<tr>					
				<td>
					<b>Birth Length:</b>&nbsp;
					<input type="text" name="birth_length" id="bh_textbox" size="5" value="<?php echo $birth_history[0]->birth_length; ?>" />
					<!--jc
					&nbsp;
					<input type="radio" name="length_label" id="" value="inches" checked="checked" />inches&nbsp;
					<input type="radio" name="length_label" id="" value="cm" />cm	
					-->	
				</td>
				<td><b>Percentile:</b>&nbsp;<input type="text" name="bl_percentile" id="bh_textbox" size="5" value="<?php echo $birth_history[0]->bl_percentile; ?>" />&nbsp;%</td>
				<td><b>Birth Chest Circumference:</b>&nbsp;<input type="text" name="birth_chest_circumference" id="bh_textbox" size="5" value="<?php echo $birth_history[0]->birth_chest_circumference; ?>" /></td>
				<td><b>Percentile:</b>&nbsp;<input type="text" name="bcc_percentile" id="bh_textbox" size="5" value="<?php echo $birth_history[0]->bcc_percentile; ?>" />&nbsp;%</td>
			</tr>
			<tr>				
				<td colspan="2">
					<b>Blood Type:</b>&nbsp;<input type="text" name="blood_type" id="bh_textbox" size="5" value="<?php echo $birth_history[0]->blood_type; ?>" />
						<!--jc
						&nbsp;
						<select name="blood_type">
							<?php foreach($blood_types as $bt) { ?>
								<option value="<?php echo $bt->blood_type ?>"><?php echo $bt->blood_type ?></option>
							<?php } ?>	
						</select>
						-->
				</td>
				<td colspan="2"><b>Birth Abdominal Circumference:</b>&nbsp;<input type="text" name="birth_abdominal_circumference" id="bh_textbox" size="5" value="<?php echo $birth_history[0]->birth_abdominal_circumference; ?>" /></td>
			</tr>    	
			<tr>
				<td colspan="4">
					<input type="submit" name="submit_updated_birth_history_data" id="submit" class="button" value="Update" />&nbsp;
				</td>
			</tr>				
		</table>
	</form>
</div>