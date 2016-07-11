<?php include '../includes/login.inc.php'; 
$log = new login;
$log->database();


 $log->set_sqlstr("SELECT * FROM schoolfeetype"); 
        $log->querydata();
        
?>  
<table width="100%" cellpadding="10" cellspacing="0" id="det">
<tr>
    <td colspan="3">
       <a class="link-button" href="" id="addfeetype">Add Fee</a>
    </td>
</tr>
<tr>
    <th colspan="3">School Fee Types</th>
</tr>
<tr>
    <th align="right">ID</th><th align="left">Type</th><th></th>
</tr>
<?php 
  
   
for($i=0; $i < $log->no_rec; $i++){
  
    ?>
 <tr >
    <td align="right"><?php echo ($i+1) ?>: </td>
	<td> <?php echo $log->data[1]; ?></td>
	<td> <a href="" id="edit">Edit</a><a class="link-button" href="" style="margin-bottom: 10px;" id="adds">Delete Fee</a>	</td>
</tr>
<?php $log->fetchdata(); } ?>

</table>
<script type="text/javascript">
$(document).ready(function(){
	function showLoader(){
	
		$('.search-background').fadeIn(200);
	}
	
	function hideLoader(){
	
		$('.search-background').fadeOut(200);
	};
        hideLoader;
        
         $('#det tr td a#addfeetype').click(function(e){
             showLoader();
               $("#content").load("../bin_bursar/addfeetype.php", hideLoader());              
             e.preventDefault();
	});
        
});
</script>
