<html>
<head>
  <title> Chat Exmaples! </title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/chat.js'); ?>"></script>
  <!--jc
  <script> 
    var time = 0;
    
    var sendChat = function (user, message) {
		$.getJSON("chat/insert_chat/"+user+"/"+message, function (){

		});
    }
    
    var addDataToReceived = function (arrayOfData) {
		arrayOfData.forEach(function (data) {
			$("#received").val($("#received").val() + "\n" + data[0]);
		});
    }
    
    var getNewChats = function () {
		$.getJSON("chat/get_chats/" + time, function (data){
			addDataToReceived(data);
			// reset scroll height
			setTimeout(function(){
			   $('#received').scrollTop($('#received')[0].scrollHeight);
			}, 0);
			time = data[data.length-1][1];
      });      
    }
  
    // using JQUERY's ready method to know when all dom elements are rendered
    $( document ).ready ( function () {
		// set an on click on the button
		$("form").submit(function (e) {
			e.preventDefault();
			var user = $("#chat_user").val();
			var message = $("#chat_box_text").val();
			$("#chat_box_text").val('');
			// get the time if clicked via a ajax get queury
			sendChat(user, message, function (){
				alert("Jobel choi");
			});
		});
		setInterval(function (){
			getNewChats();
		},1500);
    });
    
  </script>
  -->
</head>
<body>
  <h1> Chat Example on Codeigniter </h1>
  
							<p>
								<textarea id="received" rows="10" cols="18"></textarea>
							</p>   
							<p>
								<form id="chat_form">
									<input type="hidden" id="chat_user" value="admin" />
									<input type="text" id="chat_box_text" size="25" />
									<input type="submit" value="Send">
								</form>
							</p>
</body>
</html>
