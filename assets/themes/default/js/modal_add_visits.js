$(function() {
	$("a#add_new_visit_btn").click(function(e) {
		e.preventDefault();
		$("#add_visit_form").dialog('open');
	});
	
	dialog = $("#add_visit_form" ).dialog({
		resizable: true,	
		autoOpen: false,
		width:"auto",
		modal: true,
		buttons: {
			Cancel: function() {
				$("#add_visit_form").dialog( "close" );
			}
		}
	});
});
	