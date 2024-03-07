// validate the username before logging in

    	$(document).ready(function() {
		    //alert("hello world");
    		var x_timer;
            // $('#editpartnerresponsive').on('show.bs.modal', function(e) {    
    		$("#username").keyup(function (e){
        	 clearTimeout(x_timer);
        	var user_name = $(this).val();
        	x_timer = setTimeout(function(){
            	check_username_ajax(user_name);
        	}, 1000);
    	}); 

	function check_username_ajax(username){
    	$("#user-result").html('<img src="images/ajax-loader.gif" />');
    	$.post('field-checker.php', {'username':username}, function(data) {
      	$("#user-result").html(data);
    	});
	}
	});

    // validate the email when you try to create an account
    $(document).ready(function() {
            //alert("hello world");
            var x_timer;
            // $('#editpartnerresponsive').on('show.bs.modal', function(e) {    
            $("#email").keyup(function (e){
             clearTimeout(x_timer);
            var email_address = $(this).val();
            x_timer = setTimeout(function(){
                check_email_ajax(email_address);
            }, 1000);
        }); 

    function check_email_ajax(email){
        $("#email-result").html('<img src="images/ajax-loader.gif" />');
        $.post('field-checker.php', {'email':email}, function(data) {
        $("#email-result").html(data);
        });
    }
    });

  // validate the email when trying to reset your password. 
    $(document).ready(function() {
            //alert("hello world");
            var x_timer;
            // $('#editpartnerresponsive').on('show.bs.modal', function(e) {    
            $("#email_address").keyup(function (e){
             clearTimeout(x_timer);
            var email_address = $(this).val();
            x_timer = setTimeout(function(){
                check_email_ajax(email_address);
            }, 1000);
        });

    function check_email_ajax(email_address){
        $("#email-result").html('<img src="images/ajax-loader.gif" />');
        $.post('field-checker.php', {'email_address':email_address}, function(data) {
        $("#email-result").html(data);
        });
    }
    });

    // check if list exists in the system and return a response.
    // validate the email when trying to reset your password. 
    

