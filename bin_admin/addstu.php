<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();
?>
<a href="#" id="close"><img class="alignright" alt="View" title="Close" src="../img/mono-icons/stop32.png" /></a>
<h4>Enroll New Student</h4><hr>
<form id="mai" action="" method="post" enctype="multipart/form-data">
    <fieldset>
            <p>
                    <input type="text" value="" name="sname" id="sname" placeholder="Surname" required/>
                    <input type="hidden" value="Student" name="pr" id="pr" />
            </p>
            <p>
                    <input type="text" value="" name="fname" id="fname" placeholder="First Name" required/>
            </p>
            <p>
                    <input type="text" value="" name="oname" id="oname" placeholder="Last Name" required/>
            </p>
            <p>
                    <select name="age">
                        <option value="">Select Age</option>
                         <?php 
                        for($i=2; $i <= 28; $i++){
                           echo "<option value=".$i.">".$i."</option>";  
                        }
                        ?>
                    </select>
                    <select name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <select name="cl" >
                        <option>Select Class</option>
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
            <p>
                    <input type="text" value="" name="ex" id="ex" placeholder="Extra Curriculum Activity"/>
            </p>           
            <p>
                    <input type="text" value="" name="bg" id="bg" placeholder="Blood Group"/>
            </p>
            <p>
                    <input type="text" value="" name="ht" id="ht" placeholder="Height"/>
            </p>
            <p>
                    <select name="amd" required>
                        <option>Select Year Of Admission</option>
                        <?php 
                        $presentYear = date('Y');
                        $sY = $presentYear-20;
                        for($i=$presentYear; $i >= $sY; $i--){
                           echo "<option value=".$i.">".$i."</option>";  
                        }
                        ?>
                    </select>                   
            </p>
            <p>
                    <input type="text" value="" name="p_n" id="p_n" placeholder="Parent Name (O. O. Adedayo)" required/>
            </p>
            <p>
                    <input type="text" value="" name="p_ph" id="p_ph" placeholder="Contact Phone Number"/>
            </p>
            <p>
                    <input type="text" value="" name="email" id="email" placeholder="Contact Email"/>
            </p>
            <p>
                    <textarea  name="addr"  id="addr" rows="5" cols="10" placeholder="Contact Address" required></textarea>
            </p>

            <p><input type="submit" value="Add Student" name="submit" id="addst" /></p>
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
           $('input#addst').val('Loading...');
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
                alert(name);
				  alert(user);
                //data: return data from server
                   $("#content").load("../bin_admin/student_list.php?page=1"); 
                   $("#show").load("../bin_admin/uploadpic_stu.php?name=" + name +"&user=" + user);
                   $("#content").load("../bin_admin/student_list.php?page=1", hideLoader());
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