<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();
         
?> 
     <div id="mai" style="margin-bottom: 10px;">
         <form action="" method="post" id="addfee">

            <table width="100%" cellpadding="10" cellspacing="0" id="det">
                <tr>
                    <td colspan="2">
                        <a href="../bin_bursar/feetype_show.php" id="back">Back to List</a>
                    </td>
                </tr>
                <tr>

                    <td align="right">Name of Fee:</td><td><input type="text" name="amt" id="amt" value="" placeholder="e.g lesson fee" /></td>
                </tr>
                <tr align="center">

                    <td colspan="2"> <input type="submit" value="Add Type"/></td>
                </tr>

            </table>   
       </form>
 </div>
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
	
	//bring(selecter);
        
         $('#det tr td a').click(function(e){
             showLoader();
             var link = this.href; 
               $("#content").load(link, hideLoader());              
               e.preventDefault();
	});
        
        
        //callback handler for select change of option for state
      $('#addfee').submit(function(e) {
      showLoader();
        var postData = $(this).serializeArray();
        //var formURL = $(this).attr("action");
        $.ajax(
        {
            url : "../bin_bursar/process_addfeetype.php",
            type: "POST",
            data : postData,
            dataType: 'html',
            success:function(d)
            {
                alert("Fee type added");              
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails  
                alert(textStatus);
            }
        });
       //$("#sid").hide();
        e.preventDefault(); //STOP default action
    }); 
	
});

function editpix(us){
             //showLoader();
             //var link = this.href; 
               $("#show").load("../bin_admin/uploadpic_stu.php?user=" + us +"&name=" + us);
               $("#mwindow").show();
               $("#paging_button").show();
               //hideLoader();
	};
</script>