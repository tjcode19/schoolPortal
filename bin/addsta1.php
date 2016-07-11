<?php 
include '../includes/login.inc.php'; 
$log = new login;
$log->database();
?>
<a href="#" id="close"><img class="alignright" alt="View" title="Close" src="../img/mono-icons/stop32.png" /></a>
<h4>Upload Picture for <?php echo $_REQUEST['name'] ?></h4><hr>
<form id="mai" action="" method="post" enctype="multipart/form-data">
    <fieldset>
            <p><img id="pp" src="../img/mono-icons/user32.png" alt="<?php echo $_REQUEST['user'] ?>" /></p>
            <p>
                    <input type="file" name="ppa" id="ppa"/>
                    <input type="hidden" value="2" name="page" id="page" />
            </p>
           
            <p><input type="submit" value="Upload Picture" name="addstaff" id="addstaff" /></p>
    </fieldset>					
</form>
<script type="text/javascript">
$(document).ready(function(){
    
    function showLoader(){
	
		$('.search-background').fadeIn(200);
	}
	
	function hideLoader(){
	
		$('.search-background').fadeOut(200);
	};
        hideLoader;
	
	var Timer  = '';
	var selecter = 0;
	var Main =0;
	
	bring(selecter);
        
        $('#close').click(function(e){
             $('#mwindow').hide();               
               e.preventDefault();
	});
               
    //callback handler for select change of option for state
       $('#mai').submit(function(e) {
           showLoader();
           $('input#addstaff').val('Loading...');
        var postData = $(this).serializeArray();
        //var formURL = $(this).attr("action");
        $.ajax(
        {
            url : "../bin/add_info.php",
            type: "POST",
            data : postData,
            dataType: 'json',
            success:function(d)
            {
                //data: return data from server
                //$('#succ').fadeIn(3000);
                alert(d.msg);
                $('input#addstaff').val('Data Updated!');
                $("#content").load("../bin/staff_list.php?page=1", hideLoader());
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails  
                alert(textStatus);
            }
        });
        e.preventDefault(); //STOP default action
    });
});

function bring ( selecter )
{	
	$('div.shopp:eq(' + selecter + ')').stop().animate({
		opacity  : '1.0',
		height: '60px'
		
	},300,function(){
		
		if(selecter < 6)
		{
			clearTimeout(Timer); 
		}
	});
	
	selecter++;
	var Func = function(){ bring(selecter); };
	Timer = setTimeout(Func, 20);
}


</script>