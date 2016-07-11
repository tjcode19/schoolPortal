jQuery(document).ready(function($){

	// hide messages 
	$("#error").hide();
	$("#sent-form-msg").hide();
	
	// on submit...
	$("#contactForm #submit").click(function() {
		$("#error").hide();
		
		//required:
		
		//Current Password
		var cp = $("input#cp").val();
		if(cp == ""){
			$("#error").fadeIn().text("Current Password required.");
			$("input#cp").focus();
			return false;
		}
		
		//New Password
		var np = $("input#np").val();
		if(np == ""){
			$("#error").fadeIn().text("New Password required");
			$("input#np").focus();
			return false;
		}
		
		//Confirm New Password
		var cnp = $("input#cnp").val();
		if(cnp == np){
			$("#error").fadeIn().text("Confirm New Password");
			$("input#cnp").focus();
			return false;
		}
		
		// comments
		//var comments = $("#comments").val();
		
		// send mail php
		var sendMailUrl = $("#sendMailUrl").val();
		
		//to, from & subject
		var to = $("#to").val();
		var from = $("#from").val();
		var subject = $("#subject").val();
		
		// data string
		var dataString = 'cp='+ cp
                                        + '&np=' + np        
                                        + '&cnp=' + cnp;						         
		// ajax
		$.ajax({
			type:"POST",
			url: sendMailUrl,
			data: dataString,
			success: success()
		});
	});  
		
		
	// on success...
	 function success(){
	 	$("#sent-form-msg").fadeIn();
	 	$("#contactForm").fadeOut();
	 }
	
    return false;
});

