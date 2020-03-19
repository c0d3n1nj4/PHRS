	<?php $user = $this->session->userdata('user'); ?>
	<h2>Your Messages&nbsp;<a href="<?php echo base_url('/dashboard/get_user_messages/'); ?>" class="messages"><img src="<?php echo base_url('assets/themes/default/images/refresh.png'); ?>" id="refresh_img" /></a></h2>	
	<div id="personal_info_container">
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
		<table id="rounded-corner" summary="2007 Major IT Companies' Profit">
			<thead>
				<tr>
					<th scope="col" class="rounded">Date Sent</th>
					<th scope="col" class="rounded">From</th>
					<th scope="col" class="rounded">Messages</th>
					<th scope="col" class="rounded">Delete</th>
				</tr>
			</thead>
			<?php if(!empty($user_messages)) { ?>
			<tbody>
				<?php foreach($user_messages as $message) { ?>		
				<tr>
					<td><?php echo $message->date_sent; ?></td>
					<td><?php echo $message->from; ?></td>
					<td title="<?php echo $message->message; ?>"><?php echo $message->message; ?></td>
					<td><a href="<?php echo base_url('dashboard/delete_message/').'/'.$message->users_user_id.'/'.$message->message_id; ?>" class="ask"><img src="<?php echo base_url('assets/themes/default/images/trash.png'); ?>" alt="" title="Delete Message" border="0" /></a></td>
				</tr>      
				<?php } ?>			
			</tbody>
			<?php } ?>
			<tfoot>
				<tr>
					<td colspan="3" class="rounded-foot-left"><em><b><?php echo count($user_messages); ?> record(s) found.</b></em></td>
					<td class="rounded-foot-right">&nbsp;</td>
				</tr>
			</tfoot>			
		</table>
		<table>
				<tr>
					<td colspan="9"><a href="<?php echo base_url('dashboard/show_compose_message_form/').'/'.$user[0]->user_id.'/'.$user[0]->username; ?>" class="bt_green"><span class="bt_green_lft"></span><strong>Compose</strong><span class="bt_green_r"></span></a></td>
				</tr>		
		</table>		
	</div>
