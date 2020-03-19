$(function() {
	$("a#add_birth_history_btn").click(function(e) {
		e.preventDefault();
		$("#add_birth_history_form").dialog('open');
	});
	
	dialog = $("#add_birth_history_form").dialog({
		resizable: true,	
		autoOpen: false,
		width:"auto",
		modal: true,
		buttons: {
			Cancel: function() {
				$("#add_birth_history_form").dialog( "close" );
			}
		}
	});
});
	