	$(function() {
	    $("a#logout").click(function(e) {
		    e.preventDefault();
		    $("#confirm_logout").dialog('open');
	    });
		
		$("#confirm_logout").dialog({
			resizable: false,
			modal: true,
			autoOpen: false,
			buttons: {
				"Ok": function() {
					window.location = logout_user;
				},
				"Cancel": function() {
					$(this).dialog( "close" );
				}				
			}
		});
	});