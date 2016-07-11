<?php
include("../includes/login.inc.php");

$log = new login();
$log->database();

function getSub($po){
	$log = new login;	
	$log->database();
	$log->set_sqlstr("SELECT name FROM subject WHERE id ='". $po."'"); 
	$log->querydata();
	return $log->data[0];
}

if(isset($_REQUEST['st']) && ($_REQUEST['st'] == "pd")){
    $log->set_sqlstr("UPDATE schemeofwork SET Status='Pending' WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}
elseif(isset($_REQUEST['st']) && ($_REQUEST['st'] == "done")){
    $log->set_sqlstr("UPDATE schemeofwork SET Status='Done' WHERE ID = '" . $_REQUEST['n'] . "'");
        $log->ex_scalar();    
}

$sub = ""; 
$subb = ""; 
$log->set_sqlstr("SELECT * FROM subject ORDER BY name DESC"); 
$log->querydata();  
for($i=0; $i < $log->no_rec; $i++){ 
  $sub .= $log->data[0]."###"; 
  $subb .= $log->data[1]."###"; 
  $log->fetchdata();
}
$sub = explode("###",$sub);
$subb = explode("###",$subb); 

$c = isset($_REQUEST['c']) ? $_REQUEST['c'] : "";
$log->set_sqlstr("select * from listofbooks WHERE Class='". $c ."' order by subject ASC");
$log->querydata(); 
//$rsd = mysql_query($sql);
if($log->no_rec == 0 && (!isset($_REQUEST['edit'])))    $m = "<div class=\"row\"><div style=\"text-align:center; width:100% \">No Record Found</div></div>"; 
?>
             
                 
<div id="container">
    <div id="rowth">
        <div class="leftth">S/N</div>
        <div class="middleth">Subject
        <input type="hidden" value="<?php echo $c; ?>" name="cl" id="cl"/></div>
        <div class="middleth">Book Title</div>
        <div class="middleth">Author</div>
        <div class="rightth">
            <?php echo ((isset($_REQUEST['edit']))?"<input type=\"submit\" name=\"update\" id=\"update\" value=\"Save Data\"/>":
                        (($c!="")?"<a href=\"../bin_admin/lob_view.php?page=1&c=". $c ."&edit=edit\" class=\"link-button\">Edit</a>":""));
            ?>            
        </div>
    </div> 
<?php
 echo ((isset($m))? $m :"");
 $norow = 15;
for($i = 0; $i < $norow; $i++)
{
   if(isset($_REQUEST['edit'])){
       
?>
       <div class="row">
        <div class="left"><?php echo ($i+1); ?></div>
        <div class="middle"><select name="sub[]" id="sub[]">
            <option value="">Select Subject</option>
            <?php 
                for($k=0; $k<count($sub); $k++){
                    echo (($log->data['subject']==$sub[$k]) ? "<option value=\"".$sub[$k]."\" selected>".$subb[$k]."</option>"
                                                         : "<option value=\"".$sub[$k]."\">".$subb[$k]."</option>"); 
                } 
            ?>
        </select></div>
        <div class="middle"><input type="text" value="<?php echo $log->data['book']; ?>" name="book[]" id="book[]" size="25"/></div>
        <div class="middle"><input type="text" value="<?php echo $log->data['author']; ?>" name="author[]" id="author[]" size="10"/>
        <input type="hidden" name="id[]" id="id[]" value="<?php echo (($log->data[0] == "")?"ins":$log->data[0]); ?>"/></div>
        <div class="right"></div>
    </div> 
       <?php   } 
    else{
     if($log->no_rec > 0){  
?>
     <div class="row">
        <div class="left"><?php echo ($i+1); ?></div>
        <div class="middle"><?php echo getSub($log->data['subject']); ?></div>
        <div class="middle"><?php echo $log->data['book']; ?></div>
        <div class="middle"><span style="color: #cb5432"><?php echo $log->data['author']; ?></span></div>
        <div class="right"></div>
    </div>
           
        <?php 
     }
     else{}
        } 
    $log->fetchdata();
} ?>
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
        
         $('#container .row a').click(function(e){
             showLoader();
             var link = this.href;
             var d = link.replace(" ", "%20");
             
               $("#content").load(d, hideLoader());
               //$("#paging_button").hide();               
               e.preventDefault();
	});
        
        $('#container #rowth a').click(function(e){
             showLoader();
             var link = this.href;
             var d = link.replace(" ", "%20");
             
               $("#content").load(d, hideLoader());
               //$("#paging_button").hide();               
               e.preventDefault();
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