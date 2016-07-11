<!doctype html> 
<?php
    include("../../includes/login.inc.php");
    include("../../includes/linker.php");
    $log = new login;	
    $log->database();
    
    $sed = new login;	
    $sed->database();
    
    $l = new login;	
    $l->database();
    
    function getCla($po){
        $log = new login;	
        $log->database();
        $log->set_sqlstr("SELECT name FROM class WHERE id ='". $po."'"); 
        $log->querydata();
        return $log->data[0];
    }
    function getStat($po){
        $log = new login;	
        $log->database();
        $log->set_sqlstr("SELECT name FROM status WHERE id ='". $po."'"); 
        $log->querydata();
        return $log->data[0];
    }
    function getUser($po){
        $log = new login;	
        $log->database();
        $log->set_sqlstr("SELECT username FROM authentication WHERE id ='". $po."'"); 
        $log->querydata();
        return $log->data[0];
    }
    
    if(isset($_REQUEST['action']) && $_REQUEST['action'] =="setClass"){
        $log->set_sqlstr("SELECT id FROM student_data WHERE class ='". $_POST['classM'] ."'"); 
        $log->querydata();
        for($i = 0; $i < $log->no_rec; $i++){
            $log->set_sqlstr("UPDATE authentication SET status='".$_POST['statusM']."' WHERE id =".$log->data[0]." AND status != 5");
            $log->ex_scalar();
            
            $log->fetchdata();
        }
        
    }
?>
<html>
    <head>
        <title>Result Page</title>
        <link rel="stylesheet" media="all" href="css/style1.css"/>
        <link rel="stylesheet" media="all" href="css/bootstrap.css"/>
        <link rel="stylesheet" media="all" href="css/bootstrap-theme.css"/>
        <link rel="stylesheet" media="all" href="css/bootstrap-theme.min.css"/>
        <link rel="stylesheet" media="all" href="css/bootstrap.min.css"/>
        <script src="js/jquery.1.9.1.js"></script>
		<style>
			#logo_res{
				background-image:url('../img/cms.jpg');
			}
                        th, td{
                            padding:10px;
                        }
		</style>
    </head>
    <body id="resultload"> 
        <div id="mainp">
            <header>
                <div id="logo_res">
                    <a href="index.html"><img  src="images/banner.png" alt="Colony Model School"></a>
                </div>
            </header>
            
            
                <div class="row">
                <div class="col-md-12">
                    <div class="row">&nbsp;</div>
                     <div class="row">
                        <div class="col-md-12">
                            <form action="?action=setClass" method="post" role="form" id="formR" class="form-inline">
                            <div class="form-group">
                            <label for="classM">Set all:</label>
                             <select name="classM" class="form-control" >
                                <option value="">Select Class</option>
                                <?php 

                                    $log->set_sqlstr("SELECT * FROM class"); 
                                    $log->querydata();
                                    for($a=0; $a< $log->no_rec; $a++){
                                ?> 

                                     <option value="<?php echo $log->data[0]; ?>"><?php echo $log->data[1]; ?></option>

                                <?php $log->fetchdata(); } ?>
                            </select>
                            <select name="statusM" id="statusM" class="form-control" >
                               <option value="">Set Action</option>
                                <option value="2">Active</option>
                                <option value="3">Inactive</option>
                                <option value="5">Left</option>
                            </select>                           
                            <input class="btn btn-primary" type="submit" value="Go!">
                            </div> 
                            </form>
                         </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    <form action="" method="post" role="form" id="formR" class="form-inline">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="class" value="1">
                            <a class="btn btn-success" href="<?php echo Admin_Module; ?>setStatus">Show All Students </a>
                            <a class="btn btn-primary" href="?stat=2">Show Active Students Only </a>
                            <a class="btn btn-danger" href="?stat=3">Show Deactivated Students Only </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 form-group">
                    <table width="100%" cellpadding="10" cellspacing="10" border="1">
                        <?php 

                            $log->set_sqlstr("SELECT DISTINCT class FROM student_data ORDER BY class ASC"); 
                            $log->querydata(); 
                            for($a=0; $a< $log->no_rec; $a++){

                        ?>	
                            <tr align="left">
                                <th colspan="4"><?php echo getCla($log->data[0]); ?></th>
                            </tr>
                            <tr align="left">
                                <th >S/N</th>
                                <th >Student ID</th>
                                <th >Full name</th>
                                <th >Status</th>
                            </tr>
                        <?php 
                                if(isset($_REQUEST['stat'])){
                                    $sql = "Select authentication.username, authentication.status,".
                                    "  student_data.* From authentication Inner Join student_data On". 
                                    " authentication.id = student_data.id WHERE class=".$log->data[0].
                                    " AND status=".$_REQUEST['stat']." ";                                            
                                }
                                else{
                                    $sql = "Select authentication.username, authentication.status,".
                                    "  student_data.* From authentication Inner Join student_data On". 
                                    " authentication.id = student_data.id WHERE class=".$log->data[0].
                                    " ";
                                }
                                $sed->set_sqlstr($sql); 
                                $sed->querydata(); 
                                for($b=0; $b< $sed->no_rec; $b++){ 
                                if($sed->no_rec > 0){
                        ?>
                            
                             <tr align="left">
                                <td><?php echo ($b + 1); ?></td>
                                <td><?php echo $sed->data[0]; ?></td>
                                <td><?php echo $sed->data[4].", ".$sed->data[3]." ".$sed->data[5]; ?></td>
                                <td>
                                    <div class="col-md-2">
                                        <img class="loader" id="loader_<?php echo ($b+1); ?>" src="ajax-loader.gif" >
                                    </div>
                                    <div class="col-md-10">
                                    <?php if($log->data[0] < 16){ ?>
									<?php if($sed->data[1] != 5){ ?>
										<select name="status" onchange="updated(<?php echo $sed->data[2]; ?>, <?php echo ($b+1); ?>)" class="form-control col-md-6" id="statusH_<?php echo ($b+1); ?>">
											<option value="">Set Status</option>

											<option value="2" <?php echo $s = ($sed->data[1]==2)?"selected":"" ?>>
												Active
											</option>
											<option value="3" <?php echo $s = ($sed->data[1]==3)?"selected":"" ?>>
												Inactive
											</option>
											<option value="5" <?php echo $s = ($sed->data[1]==5)?"selected":"" ?>>
												Left
											</option>
										</select>
                                    <?php }
									else{
										echo "Left";
									}
									}
                                    else{
                                     echo "Portal Closed";
                                     }
                                     ?>
                                    </div>
                                </td>
                            </tr>                            
                            
                        <?php }
                                else{
                                    echo "<tr><td colspan=\"4\">No record found for this class</td></tr>";
                                }
                                $sed->fetchdata();    
                                } 
                            $log->fetchdata();
                            }
                        ?>
                    </table>
                </div>
            </div>

            </form>
            <div></div>
           
        </div> 
        
        <footer>
           SMS Version 2.0 &copy; <?php echo date("Y"); ?>
        </footer>  
        
        
<script type="text/javascript">
$(document).ready(function(){
    $('.loader').hide();
      /*  var cl = $("input#class").val();
        var sub = $("input#sub").val();
        var t = $("input#term").val();
        var s = $("input#sess").val();
        window.location.href = 'enter.php?class='+cl+'&subject='+sub+'&term='+t+'&session='+s;
         
        e.preventDefault();
    }); */   
});

function updated(us, id){
    $('#loader_'+id).show();
    var ids = "#statusH_"+id;
    var f = $(ids).val();
    $.post("processUpdate.php",
    {
        user:us,
        status:f
    },
    function(){
      $('#loader_'+id).hide();
    });
}
</script>
    </body> 
</html>

