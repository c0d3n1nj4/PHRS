	<h2>Add New Patient</h2>
	<?php if(!empty($error)) { ?>
		<!-- Failed message -->
		<div class="error_box">
			<b><?php echo $error; ?></b>
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
	<div class="form">
		<form action="<?php echo base_url('dashboard/add_new_patient/'); ?>" method="post" class="smart-green" enctype="multipart/form-data" id="add-patient-form">
			<fieldset>
				<!-- First Name -->
				<dl>
					<dt><label for="first_name">First Name:</label></dt>
					<dd><input type="text" name="first_name" class="name_textbox" size="54" /></dd>
				</dl>
				<!-- Middle Name -->
				<dl>
					<dt><label for="last_name">Middle Name:</label></dt>
					<dd><input type="text" name="middle_name" class="name_textbox" size="54" /></dd>
				</dl>				
				<!-- Last Name -->
				<dl>
					<dt><label for="last_name">Last Name:</label></dt>
					<dd><input type="text" name="last_name" class="name_textbox" size="54" /></dd>
				</dl>	
				<!-- Gender -->				
				<dl>
					<dt><label for="sex">Gender:</label></dt>
					<dd>
						<input type="radio" name="sex" id="" value="M" checked="checked" />Male
						&nbsp;&nbsp;&nbsp;<input type="radio" name="sex" id="" value="F" />Female 
					</dd>
				</dl>
				<!-- Birth Date -->
				<dl>
					<dt><label for="birth_date">Birth Date:</label></dt>
					<dd><input type="text" name="birth_date" id="datepicker" size="15" /></dd>
				</dl>					
				<!-- Address -->
				<dl>
					<dt><label for="address">Address:</label></dt>
					<dd><textarea name="address" id="comments" rows="5" cols="36"></textarea></dd>
				</dl>		
				<!-- School -->
				<dl>
					<dt><label for="school">School:</label></dt>
					<dd><input type="text" name="school" id="" size="54" /></dd>
				</dl>		
				<!-- Father Name -->
				<dl>
					<dt><label for="father_name">Father Name:</label></dt>
					<dd><input type="text" name="father_name" class="name_textbox" size="54" /></dd>
				</dl>
				<!-- Father Age -->
				<dl>
					<dt><label for="father_age">Father Age:</label></dt>
					<dd><input type="text" name="father_age" class="age_textbox" size="7" /></dd>
				</dl>
				<!-- Father Contact No. -->
				<dl>
					<dt><label for="father_contact_no">Father Contact No.:</label></dt>
					<dd><input type="text" name="father_contact_no" class="contact_no_textbox" size="15" /></dd>
				</dl>	
				<!-- Mother Name -->
				<dl>
					<dt><label for="mother_name">Mother Name:</label></dt>
					<dd><input type="text" name="mother_name" class="name_textbox" size="54" /></dd>
				</dl>
				<!-- Mother Age -->
				<dl>
					<dt><label for="mother_age">Mother Age:</label></dt>
					<dd><input type="text" name="mother_age" class="age_textbox" size="7" /></dd>
				</dl>
				<!-- Mother Contact No. -->
				<dl>
					<dt><label for="mother_contact_no">Mother Contact No.:</label></dt>
					<dd><input type="text" name="mother_contact_no" class="contact_no_textbox" size="15" /></dd>
				</dl>	
				<dl>
					<dt><label for="upload">Upload a Picture:</label></dt>
					<dd><input type="file" name="picture" id="upload" /> <br /><em>(Picture must be width="150px" and height="150px" OR Less)</em></dd>
				</dl>

				<dl class="submit">			
					<input type="submit" name="submit_new_patient" id="submit" class="button" value="Add" />
					<input type="submit" name="cancel_add" id="cancel_add" class="button" value="Cancel" />					
				</dl>
			</fieldset>
		</form>
		
	</div>  
	