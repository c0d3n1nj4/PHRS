	<?php $user = $this->session->userdata('user'); ?>
	
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
	
	<h2>Existing Patients</h2> 
	<script>	
	$(document).ready(function() {
		$("#content").tooltip({ content: '<img src="'+baseurl+'/uploads/images/default_profile_male.jpg" />' }); 
	});	
	</script>
	
	<a href="<?php echo base_url('dashboard/add_patient'); ?>" class="bt_green"><span class="bt_green_lft"></span><strong>Add New Patient</strong><span class="bt_green_r"></span></a><div style="clear:both; margin-bottom:20px !important;"></div>
		
	<table id="rounded-corner" class="fluid">
		<thead>
			<tr>
				<!--jc <th scope="col" class="rounded-company">#</th> -->
				<th scope="col" class="rounded">Name</th>
				<th scope="col" class="rounded">Sex</th>
				<th scope="col" class="rounded">Birth Date</th>
				<th scope="col" class="rounded">Address</th>
				<th scope="col" class="rounded">School</th>
				<th scope="col" class="rounded">Father's Name</th>
				<th scope="col" class="rounded">Father's Contact #</th>
				<th scope="col" class="rounded">Mother's Name</th>
				<th scope="col" class="rounded">Mother's Contact #</th>
				<th scope="col" class="rounded">View /<br />Update</th>
				<?php if ($user[0]->admin == 'Y') { ?>
				<th scope="col" class="rounded-q4">Delete</th>
				<?php } ?>
			</tr>
		</thead>
		<?php if(!empty($patients)) { ?>
		<tbody>
			<?php $cntr=1; $row_cntr=0; ?>
			<?php foreach($patients as $patient) { ?>
			<script>	
				$(document).ready(function() {
					$("#tr_<?php echo $patient->patient_id; ?>").tooltip({ content: '<img src="<?php echo base_url('uploads/images/').'/'.$patient->picture; ?>" id="tooltip_img" />', show: { effect: "slideDown"}, hide: { effect: "explode"} }); 
				});	
			</script>			
			<?= ($cntr%2 == 0) ? "<tr style='background-color:#f5f5f5;'>" : "<tr style='background-color:#ffffff;'>"; ?>
				<!--jc <td><input type="checkbox" name="pids[]" value="<?php echo $patient->patient_id; ?>" /></td> -->
				<td id="tr_<?php echo $patient->patient_id; ?>" title=""><?php echo $patient->first_name." ".$patient->middle_name." ".$patient->last_name; ?></td>
				<td><?php echo $patient->sex; ?></td>			
				<td><?=($patient->birth_date=='0000-00-00')?'':$patient->birth_date; ?></td>
				<td><?php echo $patient->address; ?></td>
				<td><?php echo $patient->school; ?></td>
				<td><?php echo $patient->father_name; ?></td>
				<td><?php echo $patient->father_contact_no; ?></td>
				<td><?php echo $patient->mother_name; ?></td>
				<td><?php echo $patient->mother_contact_no; ?></td>

				<td align="center"><a href="<?php echo base_url('dashboard/get_personal_info/').'/'.$patient->patient_id; ?>"><img src="<?php echo base_url('assets/themes/default/images/user_edit.png'); ?>" alt="" title="View/Update Patient Information" border="0" /></a></td>
				<?php if ($user[0]->admin == 'Y') { ?>
				<td align="center"><a href="<?php echo base_url('dashboard/delete_patient/').'/'.$patient->patient_id; ?>" class="ask"><img src="<?php echo base_url('assets/themes/default/images/trash.png'); ?>" alt="" title="Delete Patient" border="0" /></a></td>
				<?php } ?>
			</tr>  	
			<?php $cntr++; $row_cntr++; ?>		
			<?php } ?>			
		</tbody>
		<tfoot>
			<tr>
				<td <?=($user[0]->admin=='Y')?"colspan='10'":"colspan='9'"?> class="rounded-foot-left"><em><b>Showing <?php echo ($page+1) . " - " . ($page+$row_cntr); ?> of <?php echo $patients_count; ?>&nbsp;records</b></em></td>
				<td class="rounded-foot-right">&nbsp;</td>
			</tr>
		</tfoot>			
		<?php } else { ?>
		<tfoot>
			<tr>
				<td <?=($user[0]->admin=='Y')?"colspan='10'":"colspan='9'"?> class="rounded-foot-left"><em>No record(s) found.</em></td>
				<td class="rounded-foot-right">&nbsp;</td>
			</tr>
		</tfoot>		
		<?php } ?>
	</table>

	<div class="pagination">
		<!--jc <span class="disabled"><< prev</span><span class="current">1</span><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a>…<a href="">10</a><a href="">11</a><a href="">12</a>...<a href="">100</a><a href="">101</a><a href="">next >></a> -->
		<?php echo $links; ?>
	</div> 