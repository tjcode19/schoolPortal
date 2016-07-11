<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();


 $log->set_sqlstr("SELECT * FROM student_data WHERE Username ='". $_REQUEST['n'] ."'"); 
        $log->querydata();
        $name = $log->data['Surname']." ".$log->data['Firstname']." ".$log->data['Other'];
        $class = $log->data['Class'];
        $log->set_sqlstr("SELECT * FROM school_calendar "); 
        $log->querydata();
         function addcomma($amt){
                    $l = strlen($amt);
                    //$g = $l/3;
                    $nstr = "";
                    for($i = 0; $i < $l; $i++){
                        $nstr .=  substr( $amt,$i, 1);
                     if( ((($l-($i+1))%3) == 0) 
                          && (($i+ 1) != $l) ){
                         $nstr .= ", ";
                     }
                    }
                    return $nstr; 
                }       
       
?>
     <div id="mai" style="margin-bottom: 10px;">
         <form action="" method="post" id="paylog">
             
            <table width="100%" cellpadding="10" cellspacing="0" border="1">
                <tr><th>S/N</th><th>Amount</th><th>Date</th><th>Time</th><th>Details</th><th></th></tr>
                <?php 
                     $log->set_sqlstr("SELECT * FROM payment_log WHERE Term ='". $_REQUEST['t'] ."' AND Session ='". $_REQUEST['s'] ."' ORDER BY ID DESC"); 
                            $log->querydata();
                            for($r = 0; $r < $log->no_rec; $r++){
                    ?>
                <tr align='center'>
                    <td><?php echo ($r + 1); ?></td>
                    <td>NGN <?php echo addcomma($log->data['Amount']); ?></td><td><?php echo $log->data['Date']; ?></td>
                    <td><?php echo $log->data['Time']; ?></td><td><?php echo $log->data['Detail']; ?></td>
                    <td></td>
                </tr>
               <?php $log->fetchdata(); }?>
                <tr align='center'>
                    <td colspan="2"><span style="font-size: 26px">Total</span></td>
                    <td colspan="2"><span style="font-size: 24px">
                        <?php 
                            $log->set_sqlstr("SELECT Amount FROM payment_log WHERE Term ='". $_REQUEST['t'] ."' AND Session ='". $_REQUEST['s'] ."'"); 
                            $log->querydata();
                            for($r = 0; $r < $log->no_rec; $r++){
                                $amtT += $log->data[0];
                                $log->fetchdata();
                            }
                            echo "NGN ". addcomma($amtT);
                    ?></span>
                    </td> 
                    <td colspan="2"></td>
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
	
	bring(selecter);
        
         $('#det tr td a').click(function(e){
             showLoader();
             var link = this.href; 
               $("#content").load(link, hideLoader());              
               e.preventDefault();
	});
        
        
        
        $('#det tr td a#back').click(function(e){
             showLoader();
             var link = this.href; 
               $("#content").load(link, hideLoader());
               $("#paging_button").show();               
               e.preventDefault();
	});
        
        //callback handler for select change of option for state
      $('#paylog').submit(function(e) {
      showLoader();
        var postData = $(this).serializeArray();
        //var formURL = $(this).attr("action");
        $.ajax(
        {
            url : "../bin_admin/paylogen.php",
            type: "POST",
            data : postData,
            dataType: 'html',
            success:function(d)
            {
                var resp = d;
                var res = resp.split("/");
                //data: return data from server
                if(res[0] == 0){
                    alert("Please enter amount"); 
                    $('.success').html("Please enter amount").show();
                    hideLoader();
                }
                else if(res[0] == 2){
                    alert("Select Payment Type and Payment Purpose");
                    $('.success').html("Select Payment Type and Payment Purpose").show();
                    hideLoader();
                }
                else if(res[0] == 4){
                    
                    window.open('receipt.php?user='+res[1]+'&time='+res[2],'_blank');
                      hideLoader();
                }
                else{
                    alert("Payment Record Inserted"); 
                    $('.success').html("Payment Record Inserted").show();
                    $( '#paylog' ).each(function(){
                        this.reset();
                    });
                    hideLoader();
                }               
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