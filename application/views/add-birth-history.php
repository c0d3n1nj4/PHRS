<div id="add_birth_history_form" title="Add Birth History Data">
	<form action="<?php echo base_url('dashboard/add_birth_history_data/'); ?>" method="post" class="smart-green" enctype="multipart/form-data" id="add-birth-history-form">
		<input type="hidden" name="patient_patient_id" value="<?php echo $patients[0]->patient_id; ?>" />
		<table class="fluid" cellpadding="5" cellspacing="10">
			<tr>	
				<td colspan="2"><input type="checkbox" name="preterm" id="" value="Y" />&nbsp;<b>Preterm:</b></td>
				<td colspan="2"><input type="checkbox" name="full_term" id="" value="Y" />&nbsp;<b>Full Term:</b></td>
			</tr>
			<tr>					
				<td colspan="2"><b>Type of Delivery:</b></td>
				<td><input type="checkbox" name="nsd" id="" value="Y" />&nbsp;<b>NSD:</b></td>
				<td><input type="checkbox" name="cs" id="" value="Y" />&nbsp;<b>CS:</b></td>
			</tr>
			<tr>					
				<td>
					<b>Birth Weight:</b>&nbsp;
					<input type="text" name="birth_weight" id="bh_textbox" size="5" />&nbsp;
					<input type="radio" name="weight_label" id="" value="kg" checked="checked" />kg&nbsp;
					<input type="radio" name="weight_label" id="" value="lbs" />lbs					
				</td>
				<td><b>Percentile:</b>&nbsp;<input type="text" name="bw_percentile" id="bh_textbox" size="5" />&nbsp;%</td>
				<td><b>Birth Head Circumference:</b>&nbsp;<input type="text" name="birth_head_circumference" id="bh_textbox" size="5" />&nbsp;cm</td>
				<td><b>Percentile:</b>&nbsp;<input type="text" name="bhc_percentile" id="bh_textbox" size="5" />&nbsp;%</td>
			</tr>
			<tr>					
				<td>
					<b>Birth Length:</b>&nbsp;
					<input type="text" name="birth_length" id="bh_textbox" size="5" />&nbsp;
					<input type="radio" name="length_label" id="" value="inches" checked="checked" />inches&nbsp;
					<input type="radio" name="length_label" id="" value="cm" />cm								
				</td>
				<td><b>Percentile:</b>&nbsp;<input type="text" name="bl_percentile" id="bh_textbox" size="5" />&nbsp;%</td>
				<td><b>Birth Chest Circumference:</b>&nbsp;<input type="text" name="birth_chest_circumference" id="bh_textbox" size="5" />&nbsp;cm</td>
				<td><b>Percentile:</b>&nbsp;<input type="text" name="bcc_percentile" id="bh_textbox" size="5" />&nbsp;%</td>
			</tr>
			<tr>				
				<td colspan="2">
					<b>Blood Type:</b>&nbsp;
						<select name="blood_type">
							<?php foreach($blood_types as $bt) { ?>
								<option value="<?php echo $bt->blood_type ?>"><?php echo $bt->blood_type ?></option>
							<?php } ?>	
						</select>
				</td>
				<td colspan="2"><b>Birth Abdominal Circumference:</b>&nbsp;<input type="text" name="birth_abdominal_circumference" id="bh_textbox" size="5" />&nbsp;cm</td>
			</tr>    	
			<tr>
				<td colspan="4">
					<input type="submit" name="submit_birth_history_data" id="submit" class="button" value="Add" />&nbsp;
				</td>
			</tr>				
		</table>
	</form>
</div>