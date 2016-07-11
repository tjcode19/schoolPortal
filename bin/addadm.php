<?php 
include '../includes/login.inc.php'; 
$log = new login;
$log->database();
?>
<a href="#" id="close"><img class="alignright" alt="View" title="Close" src="../img/mono-icons/stop32.png" /></a>
<h4>Enroll New Admin</h4><hr>
<form id="mai" action="" method="post" enctype="multipart/form-data">
    <fieldset>
            <p>
                    <select name="title">
                        <option value="">Select Title</option>
                        <option value="Dr.">Dr.</option>
                        <option value="Mr.">Mr.</option>
                        <option value="Mrs.">Mrs.</option>
                        <option value="Miss">Miss</option>
                    </select>
                    <input type="text" value="" name="fname" id="fname" placeholder="Fullname (O. O. Adedayo)" required/>
                    <input type="hidden" value="Staff" name="pr" id="pr" />
            </p>
            <p>
                    <select name="age" >
                        <option value="">Select Age</option>
                         <?php 
                        for($i=15; $i <= 60; $i++){
                           echo "<option value=".$i.">".$i."</option>";  
                        }
                        ?>
                    </select>
                    <input type="text" value="" name="phone" id="phone" placeholder="Phone Number" required/>
            </p>
            <p>
                    <textarea  name="addr"  id="addr" rows="5" cols="10" placeholder="Address" required></textarea>
            </p>
            <p>
                    <input type="text" value="" name="qua" id="qua" placeholder="Qualification" required/>
            </p>
           
            <p>
                    <select name="sub" id="sub">
                        <option>Select Subject</option>                        
                        <?php 
                        $log->set_sqlstr("SELECT Name FROM subject"); 
                        $log->querydata();                        
                        for($i=0; $i < $log->no_rec; $i++){
                           echo "<option value=\"".$log->data[0]."\">".$log->data[0]."</option>"; 
                           $log->fetchdata();
                        }
                        ?>
                    </select>
            </p>
           <p>
                    <select name="emp" id="emp">
                        <option>Select Year Of Employment</option>
                        <?php 
                        $presentYear = date('Y');
                        $sY = $presentYear-20;
                        for($i=$presentYear; $i >= $sY; $i--){
                           echo "<option value=".$i.">".$i."</option>";  
                        }
                        ?>
                    </select>
                    <select name="exp" id="exp">
                        <option>Select Year Of Experience</option>
                         <?php 
                        for($i=1; $i <= 50; $i++){
                           echo "<option value=".$i.">".$i."</option>";  
                        }
                        ?>
                    </select>
                    
            </p>
             <p>
                    <select name="class" id="class">
                        <option>Select Class</option>
                        <option value="All">All</option>
                        <?php 
                        $log->set_sqlstr("SELECT Name FROM class"); 
                        $log->querydata();                        
                        for($i=0; $i < $log->no_rec; $i++){
                           echo "<option value=\"".$log->data[0]."\">".$log->data[0]."</option>"; 
                           $log->fetchdata();
                        }
                        ?>
                    </select>
            </p>

            <p><input type="submit" value="Add Admin" name="addadm" id="addadm" /></p>
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
                var name = $.trim(d.mn);
                var user = $.trim(d.n);
                //alert(name);
                //data: return data from server
                   $("#content").load("../bin/admin_list.php?page=1"); 
                   $("#show").load("../bin/uploadpic.php?name=" + name +"&user=" + user);
                $("#content").load("../bin/admin_list.php?page=1", hideLoader());
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