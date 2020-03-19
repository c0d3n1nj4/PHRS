<script type='text/javascript'>
$(document).ready(function() {
	var cmDialog = $('#compose_message');
	
	cmDialog.dialog({
		resizable: true,	
		autoOpen: true,
		width:"auto",
		modal: true,
		open: function () {
		
		},		
		buttons: {
			Close: function() {
				cmDialog.dialog( "close" );
			}
		},
		close: function () {
			location.href=baseurl+'dashboard/get_user_messages/'+<?php echo $user_id[0]; ?>;
		}		
	});	
});
</script>

<div id="compose_message" title="Compose New Message">
	<form action="<?php echo base_url('dashboard/add_user_message/'); ?>" method="post" class="smart-green">
	<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
	<input type="hidden" name="from" value="<?php echo $from; ?>" />
		<table cellpadding="2">
			<tr>
				<td style="background:#d2e7f0">Send To:</td>
				<td>
					<select name="users_user_id">
						<?php foreach($users as $usr) { ?>
							<?php if ($usr->user_id != $user_id) { ?>
								<option value="<?php echo $usr->user_id ?>" style="text-transform:capitalize !important;"><?php echo $usr->username ?></option>
							<?php } ?>
						<?php } ?>	
					</select>
				</td>	
			</tr>
			<tr>
				<td style="background:#d2e7f0">Your Message:</td>
				<td><textarea name="message" id="message" rows="5" cols="36"></textarea></td>
			</tr>			
			<tr>
				<td></td>
				<td>
					<input type="submit" name="submit_new_message" id="submit" class="button" value="Send Message" />
				</td>
			</tr>						
		</table>
	</form>
</div>