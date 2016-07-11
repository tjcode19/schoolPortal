<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.form.min.js"></script>

<script type="text/javascript">
$(document).ready(function() { 
    $('#ad').hide(); //hide submit button
	var options = { 
			target:   '#output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			success:       afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		});
                
                 $('#close').click(function(e){
             $('#mwindow').hide();               
               e.preventDefault();
	});
         
}); 

function afterSuccess()
{
	$('#submit-btn').hide(); //hide submit button
	$('#loading-img').hide(); //hide submit button
        $('#imageInput').hide(); //hide submit button        
        $('#ad').show(); //hide submit button 
        $("#content_emp").load("../bin_staff/emp_det_sta.php"); 
        $("#content_home").load("../bin_staff/staff_home.php"); 
}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#imageInput').val()) //check empty input filed
		{
			$("#output").html("Are you kidding me?/n This is empty");
			return false
		}
		
		var fsize = $('#imageInput')[0].files[0].size; //get file size
		var ftype = $('#imageInput')[0].files[0].type; // get file type
		

		//allow only valid image file types 
		switch(ftype)
        {
            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 1 MB (1048576)
		if(fsize>1048576) 
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
			return false
		}
				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

</script>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
</head>
<body>
<a href="#" id="close"><img class="alignright" alt="View" title="Close" src="../img/mono-icons/stop32.png" /></a>
<div id="upload-wrapper">
<div align="center">
<h3> Edit Profile Picture</h3>
<form action="../bin_staff/processupload1.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
<input name="ImageFile" id="imageInput" type="file" />
<input name="user" id="user" type="hidden" value="<?php echo $_REQUEST['user']; ?>"/>
<?php 
include '../includes/login.inc.php'; 
$log = new login;
$log->database();

$log->set_sqlstr("SELECT Priority FROM auth_tab WHERE Username ='". $_REQUEST['user'] ."'"); 
$log->querydata();
    
    if($log->data[0] == 'admin'){
      echo "<input name=\"link\" id=\"link\" type=\"hidden\" value=\"../passport/admin/\"/>" ;
      echo "<input name=\"table\" id=\"table\" type=\"hidden\" value=\"admin_data\"/>" ;
    }
    elseif($log->data[0] == 'staff'){
      echo "<input name=\"link\" id=\"link\" type=\"hidden\" value=\"../passport/staff/\"/>" ;
      echo "<input name=\"table\" id=\"table\" type=\"hidden\" value=\"staff_data\"/>" ;
    }
    elseif($log->data[0] == 'student'){
      echo "<input name=\"link\" id=\"link\" type=\"hidden\" value=\"../passport/student/\"/>" ;
      echo "<input name=\"table\" id=\"table\" type=\"hidden\" value=\"student_data\"/>" ;
    }
?>
<input type="submit"  id="submit-btn" value="Upload" />
<img src="../img/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
</form>
<div id="output"></div>
</div>
</div>

</body>
</html>