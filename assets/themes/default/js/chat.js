    var time = 0;
    
    var sendChat = function (user, message) {
		// $.getJSON(baseurl+"/chat/insert_chat/"+user+"/"+message, function (){
		post_data = {'user':user, 'message':message};
		$.post(baseurl+"/chat/insert_chat/", post_data, function() {

		});
    }
    
    var addDataToReceived = function (arrayOfData) {
		var cntr = 1;
		$("#received").html('');
		// $("#received").html('<img src="'+baseurl+'/assets/themes/default/images/ajax-loader.gif'+'" />');
		arrayOfData.forEach(function (data) {
			// console.log(data);
			// $("#received").val($("#received").val() + "\n" + data[0] + " [" + data[2] + "]" + ": " + data[1]);
			// $("#received").val($("#received").val() + "\n" + data[0] + ": " + data[1]);
			if (cntr % 2 == 0) {
				$("#received").html($("#received").html() + "<p style='background-color:#f5f5f5; font-size:13px;'><span style='font-weight:bold;'>" + data[0] + ":</span> " + data[1] + "</p>").fadeIn().delay(2000);
			} else {
				$("#received").html($("#received").html() + "<p style='background-color:#ffffff; font-size:13px;'><span style='font-weight:bold;'>" + data[0] + ":</span> " + data[1] + "</p>").fadeIn().delay(2000);
			}	
			cntr++;
		});
    }
    
    var getNewChats = function () {
		$.getJSON(baseurl+"/chat/get_chats/" + time, function (data){
			addDataToReceived(data);
			// reset scroll height
			setTimeout(function(){
				$('#received').scrollTop($('#received')[0].scrollHeight);
			}, 0);	
			time = data[data.length-1][2];
      });      
    }
  
    // using JQUERY's ready method to know when all dom elements are rendered
    $( document ).ready ( function () {
		$("#received").html('<img src="'+baseurl+'/assets/themes/default/images/ajax-loader.gif'+'" />');
		// set an on click on the button
		$("#chat_form").submit(function (e) {
			e.preventDefault();
			var user = $("#chat_user").val();
			var message = $("#chat_box_text").val();
			$("#chat_box_text").val('');
			
			// get the time if clicked via ajax get query
			sendChat(user, message, function (){
				alert("Jobel choi");
			});
		});
		setInterval(function (){
			getNewChats();
		}, 3000); // 3 seconds
    });