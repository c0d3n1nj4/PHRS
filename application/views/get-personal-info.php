	<?php $user = $this->session->userdata('user'); ?>
	<?php $patient_patient_id = ''; ?>

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
 
	<!-- Personal Information -->
	<script>
		$(document).ready(function() {    
			$('.personal_info_show').click(function(){
				if($(this).hasClass('personal_info_show')) {
					$(this).removeClass('personal_info_show');
					$(this).addClass('personal_info_hide');      
					if($('#personal_info_container').is(":visible")) { 	
						$('#personal_info_container').hide('slow');
					}	
				}
				else if($(this).hasClass('personal_info_hide')) {
					$(this).removeClass('personal_info_hide');
					$(this).addClass('personal_info_show');    
					if(!$('#personal_info_container').is(":visible")) { 					
						$('#personal_info_container').show('slow');
					}	
				}				
			});	
		});
	</script>		
	<h2><div class="personal_info_show" title="Hide Patient Personal Data"></div>&nbsp;Patient Data</h2>	
	<div id="personal_info_container">
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
		<?php if(!empty($patients)) { ?>
		<table id="get-personal-info" cellpadding="5" cellspacing="5">
			<?php foreach($patients as $patient) { ?>
			<?php $patient_patient_id = $patient->patient_id; ?>
			<tr>
				<td colspan="3"><img src="<?php echo base_url('uploads/images/').'/'.$patient->picture; ?>" style="border:solid 2px #256c89;" /></td>
			</tr>
			<tr>	
				<td><b>Name:</b>&nbsp;<?php echo $patient->first_name." ".$patient->middle_name." ".$patient->last_name; ?></td>
				<td><b>Gender:</b>&nbsp;<?php echo $patient->sex; ?></td>
				<td><b>Birth Date:</b>&nbsp;<?=($patient->birth_date=='0000-00-00')?'':$patient->birth_date; ?></td>
			</tr>
			<tr>					
				<td colspan="3"><b>Address:</b>&nbsp;<?php echo $patient->address; ?></td>
			</tr>
			<tr>					
				<td colspan="3"><b>School:</b>&nbsp;<?php echo $patient->school; ?></td>
			</tr>
			<tr>					
				<td><b>Father's Name:</b>&nbsp;<?php echo $patient->father_name; ?></td>
				<td><b>Age:</b>&nbsp;<?php echo $patient->father_age; ?></td>
				<td><b>Contact Number:</b>&nbsp;<?php echo $patient->father_contact_no; ?></td>
			</tr>
			<tr>				
				<td><b>Mother's Name:</b>&nbsp;<?php echo $patient->mother_name; ?></td>
				<td><b>Age:</b>&nbsp;<?php echo $patient->mother_age; ?></td>
				<td><b>Contact Number:</b>&nbsp;<?php echo $patient->mother_contact_no; ?></td>
			</tr>     
			<tr>
				<td colspan="3"><b>Date Entered:</b>&nbsp;<?php echo $patient->date_entered; ?></td>
			</tr>		
			<tr>
				<td colspan="3"><b>Date Updated:</b>&nbsp;<?php echo $patient->date_updated; ?></td>
			</tr>		
			<?php } ?>					
		</table>
		
		<a href="<?php echo base_url('dashboard/update_personal_info').'/'.$patient->patient_id; ?>" class="bt_blue"><span class="bt_blue_lft"></span><strong>Update Information</strong><span class="bt_blue_r"></span></a>
		<a class="bt_red" href="<?php echo base_url('dashboard/get_existing_patients'); ?>"><span class="bt_red_lft"></span><strong>Back to Existing Patients</strong><span class="bt_red_r"></span></a>
		<?php } else { ?>
			<?php redirect('/dashboard/', 'location'); ?>
		<?php } ?>
	</div>
	<!-- /Personal Information -->
	
	<!-- Tab Contents -->
	<script>
		$(document).ready(function() {    
			$('.container').hide();
			<?php if($tab=='tab1') { ?>
				$('#tab1C').fadeIn('slow');
			<?php } else if($tab=='tab2') {  ?>	
				$('#tab2C').fadeIn('slow');
			<?php } else { ?>	
				$('#tab3C').fadeIn('slow');
			<?php } ?>	
			
			$('#tabs li a').click(function(){
				var t = $(this).attr('id');
				location.href = baseurl+"dashboard/get_personal_info/"+<?=$patients[0]->patient_id;?>+"/"+t
			});			
		});
	</script>	
	<ul id="tabs">
		<li><a id="tab1" <?=((isset($tab) && ($tab=='tab1'))?'':"class='inactive'"); ?>>Visits</a></li>
		<li><a id="tab2" <?=((isset($tab) && ($tab=='tab2'))?'':"class='inactive'"); ?>>Birth History</a></li>
		<li><a id="tab3" <?=((isset($tab) && ($tab=='tab3'))?'':"class='inactive'"); ?>>Immunization Records</a></li>
	</ul>

	<!-------------------------------------------- VISITS -------------------------------------------->
	<div class="container" id="tab1C">
		<table id="rounded-corner" class="fluid">
			<thead>
				<tr>
					<!--jc <th scope="col" class="rounded-company">#</th> -->
					<th scope="col" class="rounded">Date</th>
					<th scope="col" class="rounded">Age</th>
					<th scope="col" class="rounded">Temperature</th>
					<th scope="col" class="rounded">Weight</th>
					<th scope="col" class="rounded">Height</th>
					<th scope="col" class="rounded">Complaints</th>
					<th scope="col" class="rounded">Physician's Findings</th>
					<th scope="col" class="rounded">Treatment</th>
					<th scope="col" class="rounded">Charge/Fee</th>
					<th scope="col" class="rounded">Insurance</th>
					<th scope="col" class="rounded" align="center">View /<br />Update</th>
					<?php if ($user[0]->admin == 'Y') { ?>
					<th scope="col" class="rounded-q4" align="center">Delete</th>
					<?php } ?>
				</tr>
			</thead>
			<?php if(!empty($visits)) { ?>
			<tbody>
				<?php 
					// Get the last value from the URL
					$parts = explode('/', $_SERVER['REQUEST_URI']);
					$page = end($parts);
				?>
				<?php $cntr=1; ?>
				<?php foreach($visits as $visit) { ?>			
				<?= ($cntr%2 == 0) ? "<tr style='background-color:#f5f5f5;'>" : "<tr style='background-color:#ffffff;'>"; ?>
					<td><?=($visit->date_of_visit=='0000-00-00')?'':$visit->date_of_visit; ?></td>
					<td><?php echo $visit->age; ?></td>
					<td><?php echo $visit->temperature; ?></td>
					<td><?php echo $visit->weight; ?></td>
					<td><?php echo $visit->height; ?></td>
					<td title="<?php echo $visit->complaints; ?>"><?php echo $visit->complaints; ?></td>
					<td title="<?php echo $visit->physician_findings; ?>"><?php echo $visit->physician_findings; ?></td>
					<td title="<?php echo $visit->treatment; ?>"><?php echo $visit->treatment; ?></td>
					<td title="<?php echo $visit->charge; ?>"><?php echo $visit->charge; ?></td>
					<td title="<?php echo $visit->insurance; ?>"><?php echo $visit->insurance; ?></td>

					<td align="center"><a href="<?php echo base_url('dashboard/view_visit/').'/'.$visit->visit_id.'/'.$visit->patient_patient_id.'/'.$page; ?>"><img src="<?php echo base_url('assets/themes/default/images/user_edit.png'); ?>" alt="" title="View/Update Visit Information" border="0" /></a></td>
					<?php if ($user[0]->admin == 'Y') { ?>
					<td align="center"><a href="<?php echo base_url('dashboard/delete_visit/').'/'.$visit->visit_id.'/'.$visit->patient_patient_id; ?>" class="ask"><img src="<?php echo base_url('assets/themes/default/images/trash.png'); ?>" alt="" title="Delete Patient's Visit" border="0" /></a></td>
					<?php } ?>
				</tr>  
				<?php $cntr++; ?>
				<?php } ?>			
			</tbody>
			<tfoot>
				<tr>
					<td <?=($user[0]->admin=='Y')?"colspan='11'":"colspan='10'"?> class="rounded-foot-left"><em><b><?php echo count($visits); ?> record(s) found</b></em></td>
					<td class="rounded-foot-right">&nbsp;</td>
				</tr>
			</tfoot>			
			<?php } else { ?>
			<tfoot>
				<tr>
					<td <?=($user[0]->admin=='Y')?"colspan='11'":"colspan='10'"?> class="rounded-foot-left"><em>No record(s) found</em></td>
					<td class="rounded-foot-right">&nbsp;</td>
				</tr>
			</tfoot>	
			<?php } ?>
		</table>

		<table>
			<tr>
				<td colspan="11"><a href="" class="bt_green" id="add_new_visit_btn"><span class="bt_green_lft"></span><strong>Add New Visit</strong><span class="bt_green_r"></span></a></td>
			</tr>			
		</table>
		
		<div class="pagination">
			<?=(!empty($v_links))?$v_links:''; ?>
		</div> 
						
		<?php $this->view('add-visits'); ?>
	</div>
	<!-------------------------------------------- /VISITS -------------------------------------------->
	
	<!-------------------------------------------- BIRTH HISTORY -------------------------------------------->
	<div class="container" id="tab2C">
		<div id="birth_history_container">
			<?php if(!empty($birth_history)) { ?>
			<table id="get-personal-info" class="fluid" cellpadding="5" cellspacing="10" >
				<?php foreach($birth_history as $bh) { ?>
				<tr>	
					<td><input type="checkbox" name="preterm" id="" value="" <?=($bh->preterm=='Y')?'checked':'';?> onclick="return false" />&nbsp;<b>Preterm:</b></td>
					<td colspan="3"><input type="checkbox" name="full_term" id="" value="" <?=($bh->full_term=='Y')?'checked':'';?> onclick="return false" />&nbsp;<b>Full Term:</b></td>
				</tr>
				<tr>					
					<td><b>Type of Delivery:</b></td>
					<td><input type="checkbox" name="nsd" id="" value="" <?=($bh->nsd=='Y')?'checked':'';?> onclick="return false" />&nbsp;<b>NSD:</b></td>
					<td colspan="2"><input type="checkbox" name="cs" id="" value="" <?=($bh->cs=='Y')?'checked':'';?> onclick="return false" />&nbsp;<b>CS:</b></td>
				</tr>
				<tr>					
					<td><b>Birth Weight:</b>&nbsp;<?php echo $bh->birth_weight; ?></td>
					<td><b>Percentile:</b>&nbsp;<?php echo $bh->bw_percentile; ?>&nbsp;%</td>
					<td><b>Birth Head Circumference:</b>&nbsp;<?php echo $bh->birth_head_circumference; ?></td>
					<td><b>Percentile:</b>&nbsp;<?php echo $bh->bhc_percentile; ?>&nbsp;%</td>
				</tr>
				<tr>					
					<td><b>Birth Length:</b>&nbsp;<?php echo $bh->birth_length; ?></td>
					<td><b>Percentile:</b>&nbsp;<?php echo $bh->bl_percentile; ?>&nbsp;%</td>
					<td><b>Birth Chest Circumference:</b>&nbsp;<?php echo $bh->birth_chest_circumference; ?></td>
					<td><b>Percentile:</b>&nbsp;<?php echo $bh->bcc_percentile; ?>&nbsp;%</td>
				</tr>
				<tr>				
					<td><b>Blood Type:</b>&nbsp;<?php echo $bh->blood_type; ?></td>
					<td colspan="3"><b>Birth Abdominal Circumference:</b>&nbsp;<?php echo $bh->birth_abdominal_circumference; ?></td>
				</tr>     
				<?php } ?>			
				<tr>				
					<td colspan="4">
						<a href="<?php echo base_url('dashboard/view_birth_history_data/').'/'.$bh->birth_history_id.'/'.$bh->patient_patient_id; ?>" class="bt_green"><span class="bt_green_lft"></span><strong>View / Update Birth History Data</strong><span class="bt_green_r"></span></a></td>
					</td>
				</tr>  				
			</table>
			
			<?php } else { ?>
				<p><em>No record(s) found.</em></p>

				<table>
					<tr>
						<td colspan="9"><a href="" class="bt_green" id="add_birth_history_btn"><span class="bt_green_lft"></span><strong>Add Birth History Data</strong><span class="bt_green_l"></span></a></td>
					</tr>			
				</table>				
			<?php } ?>
		</div>	
			
		<?php $this->view('add-birth-history'); ?>		
	</div>
	<!-------------------------------------------- /BIRTH HISTORY -------------------------------------------->
	
	<!-- Immunization Records -->
	<!-------------------------------------------- IMMUNIZATION RECORDS -------------------------------------------->
	<div class="container" id="tab3C">
		<table id="rounded-corner" class="fluid" border="1">
			<thead>
				<tr>
					<th scope="col" class="rounded" rowspan="2"><center><b>VACCINE</b></center></th>
					<th scope="col" class="rounded" colspan="10"><center><b>DATE</b></center></th>
				</tr>
				<tr>
					<th scope="col" class="rounded">1st</th>
					<th scope="col" class="rounded">2nd</th>
					<th scope="col" class="rounded">3rd</th>
					<th scope="col" class="rounded">Booster 1</th>
					<th scope="col" class="rounded">Booster 2</th>
					<th scope="col" class="rounded">Booster 3</th>
					<th scope="col" class="rounded">Other <br /> Vaccine</th>
					<th scope="col" class="rounded">Reaction</th>
					<th scope="col" class="rounded" align="center">View / <br /> Update</th>
					<?php if ($user[0]->admin == 'Y') { ?>
					<th scope="col" class="rounded" align="center">Delete</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>	
			
			<?php if(!empty($immunization_records)) { ?>
			<?php 
				// Get the last value from the URL
				$parts = explode('/', $_SERVER['REQUEST_URI']);
				$page = end($parts);
				$cntr=1;
			?>			
				<?php foreach($immunization_records as $ir) { ?>	
				<input type="hidden" name="immunization_record_id" value="<?php echo $ir->immunization_record_id; ?>" />
				<input type="hidden" name="patient_patient_id" value="<?php echo $ir->patient_patient_id; ?>" />	
				<?= ($cntr%2 == 0) ? "<tr style='background-color:#f5f5f5;'>" : "<tr style='background-color:#ffffff;'>"; ?>
					<td>
						<?php 
						
					
/*
						foreach ($ir->vaccines as $key=>$val) {
							foreach ($vaccines as $v) {
								if ($v->vaccine_id == $ir->vaccines_vaccine_id) {
									echo $v->vaccine_description; 
								}
							}
						}	
*/	
							$vacc = array();
							$vacc_arr = explode(",", $ir->vaccines);
							foreach ($vacc_arr as $key=>$val) {
								foreach ($vaccines as $v) {
									if ($v->vaccine_id == $val) {
										$vacc[] = $v->vaccine_description; 
									}
								}
							}	
							echo implode(", ", $vacc);
						?>
					</td>
					<td><?=($ir->first=='0000-00-00')?'':$ir->first; ?></td>
					<td><?=($ir->second=='0000-00-00')?'':$ir->second; ?></td>
					<td><?=($ir->third=='0000-00-00')?'':$ir->third; ?></td>
					<td><?=($ir->booster_one=='0000-00-00')?'':$ir->booster_one; ?></td>
					<td><?=($ir->booster_two=='0000-00-00')?'':$ir->booster_two; ?></td>
					<td><?=($ir->booster_three=='0000-00-00')?'':$ir->booster_three; ?></td>
					<td><?php echo $ir->other_vaccine; ?></td>
					<td><?php echo $ir->reaction; ?></td>

					<td align="center"><a href="<?php echo base_url('dashboard/view_immunization_record/').'/'.$ir->immunization_record_id.'/'.$ir->patient_patient_id.'/'.$page; ?>"><img src="<?php echo base_url('assets/themes/default/images/user_edit.png'); ?>" alt="" title="View/Update Immunization Record" border="0" /></a></td>
					<?php if ($user[0]->admin == 'Y') { ?>
					<td align="center"><a href="<?php echo base_url('dashboard/delete_immunization_record/').'/'.$ir->immunization_record_id.'/'.$ir->patient_patient_id; ?>" class="ask"><img src="<?php echo base_url('assets/themes/default/images/trash.png'); ?>" alt="" title="Delete Immunization Record" border="0" /></a></td>					
					<?php } ?>
				</tr>      
				<?php $cntr++; ?>
				<?php } ?>			
			</tbody>
			<tfoot>
				<tr>
					<td <?=($user[0]->admin=='Y')?"colspan='10'":"colspan='9'"?> class="rounded-foot-left"><em><b><?php echo count($immunization_records); ?> record(s) found</b></em></td>
					<td class="rounded-foot-right">&nbsp;</td>
				</tr>
			</tfoot>	
			<?php } else { ?>
			<tfoot>
				<tr>
					<td <?=($user[0]->admin=='Y')?"colspan='10'":"colspan='9'"?>><p><em>No record(s) found</em></p></td>
					<td class="rounded-foot-right">&nbsp;</td>
				</tr>
			</tfoot>	
			<?php } ?>			
		</table>
		<table>
				<tr>
					<td colspan="10"><a href="<?php echo base_url('dashboard/show_add_immunization_record_form/').'/'.$patient->patient_id; ?>" class="bt_green"><span class="bt_green_lft"></span><strong>Add New Immunization Record</strong><span class="bt_green_r"></span></a></td>
				</tr>		
		</table>	
		<div class="pagination">
			<?=(!empty($ir_links))?$ir_links:''; ?>
		</div> 		
	</div>
	<!-------------------------------------------- IMMUNIZATION RECORDS -------------------------------------------->
	
	<!-- /Tab Contents -->        