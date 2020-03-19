	<h2>Update Patient Personal Information</h2>
	<?php if(!empty($error)) { ?>
		<!-- Failed message -->
		<div class="error_box">
			<b><?php echo $error; ?></b>
		</div>
	<?php } ?>	
	<?php if(!empty($patients)) { ?>
	<div class="form">
		<?php foreach($patients as $patient) { ?>
		<form action="<?php echo base_url('dashboard/update_personal_info_db'); ?>" method="post" class="smart-green" enctype="multipart/form-data" id="add-patient-form">
			<input type="hidden" name="patient_id" value="<?php echo $patient->patient_id; ?>" />
			<fieldset>
				<!-- First Name -->
				<dl>
					<dt><label for="first_name">First Name:</label></dt>
					<dd><input type="text" name="first_name" class="name_textbox" size="54" value="<?php echo $patient->first_name; ?>" /></dd>
				</dl>
				<!-- Middle Name -->
				<dl>
					<dt><label for="last_name">Middle Name:</label></dt>
					<dd><input type="text" name="middle_name" class="name_textbox" size="54" value="<?php echo $patient->middle_name; ?>" /></dd>
				</dl>					
				<!-- Last Name -->
				<dl>
					<dt><label for="last_name">Last Name:</label></dt>
					<dd><input type="text" name="last_name" class="name_textbox" size="54" value="<?php echo $patient->last_name; ?>" /></dd>
				</dl>	
				<!-- Gender -->				
				<dl>
					<dt><label for="sex">Gender:</label></dt>
					<dd>
						<input type="radio" name="sex" id="" value="M" <?php echo ($patient->sex=='M') ? "checked='checked'" : ''; ?> />Male
						&nbsp;&nbsp;&nbsp;<input type="radio" name="sex" id="" value="F" <?php echo ($patient->sex=='F') ? "checked='checked'" : ''; ?> />Female
					</dd>
				</dl>
				<!-- Birth Date -->
				<dl>
					<dt><label for="birth_date">Birth Date:</label></dt>
					<dd><input type="text" name="birth_date" id="datepicker" size="15" value="<?=($patient->birth_date=='0000-00-00')?'':$patient->birth_date; ?>" /></dd>
				</dl>					
				<!-- Address -->
				<dl>
					<dt><label for="address">Address:</label></dt>
					<dd><textarea name="address" id="comments" rows="5" cols="36"><?php echo $patient->address; ?></textarea></dd>
				</dl>		
				<!-- School -->
				<dl>
					<dt><label for="school">School:</label></dt>
					<dd><input type="text" name="school" id="" size="54" value="<?php echo $patient->school; ?>" /></dd>
				</dl>		
				<!-- Father Name -->
				<dl>
					<dt><label for="father_name">Father Name:</label></dt>
					<dd><input type="text" name="father_name" class="name_textbox" size="54" value="<?php echo $patient->father_name; ?>" /></dd>
				</dl>
				<!-- Father Age -->
				<dl>
					<dt><label for="father_age">Father Age:</label></dt>
					<dd><input type="text" name="father_age" class="age_textbox" size="7" value="<?php echo $patient->father_age; ?>" /></dd>
				</dl>
				<!-- Father Contact No. -->
				<dl>
					<dt><label for="father_contact_no">Father Contact No.:</label></dt>
					<dd><input type="text" name="father_contact_no" class="contact_no_textbox" size="15" value="<?php echo $patient->father_contact_no; ?>" /></dd>
				</dl>	
				<!-- Mother Name -->
				<dl>
					<dt><label for="mother_name">Mother Name:</label></dt>
					<dd><input type="text" name="mother_name" class="name_textbox" size="54" value="<?php echo $patient->mother_name; ?>" /></dd>
				</dl>
				<!-- Mother Age -->
				<dl>
					<dt><label for="mother_age">Mother Age:</label></dt>
					<dd><input type="text" name="mother_age" class="age_textbox" size="7" value="<?php echo $patient->mother_age; ?>" /></dd>
				</dl>
				<!-- Mother Contact No. -->
				<dl>
					<dt><label for="mother_contact_no">Mother Contact No.:</label></dt>
					<dd><input type="text" name="mother_contact_no" class="contact_no_textbox" size="15" value="<?php echo $patient->mother_contact_no; ?>" /></dd>
				</dl>	
				<dl>
					<dt><label for="upload">Upload a Picture:</label></dt>
					<dd><input type="file" name="picture" id="upload" /> <br /><em>(Picture must be width="150px" and height="150px" OR Less)</em></dd>
				</dl>

				<dl class="submit">
					<input type="submit" name="submit_updated_info" id="submit" class="button" value="Update" />
					<input type="submit" name="cancel_update" id="cancel_update" class="button" value="Cancel" />	
				</dl>
			</fieldset>
		</form>
		<?php } ?>
	</div>  
	<?php } else { ?>
		<?php redirect('/dashboard/', 'location'); ?>
	<?php } ?>