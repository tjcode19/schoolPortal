<!doctype html> 
<?php

include("../../includes/login.inc.php");
    $log = new login();
    $log->database();
    $log1 = new login();
    $log1->database();
    
 if(isset($_POST['id']) && isset($_POST['cl'])) {  
    $id = $_POST['id'];
    $cl = $_POST['cl'];
    $sub = $_POST['sub'];
    $term = $_POST['term'];
    $sess = $_POST['session'];
    $c1 = $_POST['c1'];
    $c2 = $_POST['c2'];
    $c3 = $_POST['c3'];
    $nost = count($_POST['stud_id']);
    $nos = $_POST['noofsub'];
    $st_id = $_POST['stud_id'];

    $f = 0;
    $Sub ="";
    for ($stu=0; $stu < $nost; $stu++) {
      for($i=0; $i < $nos; $i++){ 
          $Sub .= $sub[$i];
          do{
            if($id[$f] != "ins"){
                $log->set_sqlstr("UPDATE result SET ca1='".$c1[$f]."', ca2='".$c2[$f]."', exam='".$c3[$f]."' WHERE ID =".$id[$f]."");
                $log->ex_scalar(); 
            }
            else{
                $log->set_sqlstr("select COUNT(*) as num FROM result WHERE student_id='".$st_id[$stu]."' AND term='".$term.
                        "' AND session='".$sess."' AND subject='".$sub[$i]."' AND class='".$cl."' ");
                $log->querydata();

                if($log->data['num'] < 1){
                    if($c1[$f] != "" || $c2[$f] != "" || $c3[$f] != ""){
                    $log->set_sqlstr("INSERT INTO result(student_id, term, session, subject, ca1, ca2, exam, class) VALUES " .
                    "('".$st_id[$stu]."','".$term."','".$sess."','".$sub[$i]."','".$c1[$f]."','".$c2[$f]."','".$c3[$f]."','" . $cl . "')");
                    $log->ex_scalar();
                    }
                }
                else{
                    $log->set_sqlstr("UPDATE result SET ca1='".$c1[$f]."', ca2='".$c2[$f]."', exam='".$c3[$f].
                            "' WHERE student_id='".$st_id[$stu]."' AND term='".$term."' AND session='".$sess.
                            "' AND subject='".$sub[$i]."' AND class='".$cl."'");
                    $log->ex_scalar();
                }
            }

            $f++; 
         }while($f <= $i); 
      }
    }    
function getSub($id){
    $log = new login();
    $log->database();
    $log->set_sqlstr("SELECT Name FROM subject WHERE id='".$id."'");
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
function getCla($po){
        $log = new login;	
        $log->database();
        $log->set_sqlstr("SELECT name FROM class WHERE id ='". $po."'"); 
        $log->querydata();
        return $log->data[0];
}
 function getTerm($po){
        $log = new login;	
        $log->database();
        $log->set_sqlstr("SELECT name FROM term WHERE id ='". $po."'"); 
        $log->querydata();
        return $log->data[0];
}
 function getSe($po){
        $log = new login;	
        $log->database();
        $log->set_sqlstr("SELECT name FROM session WHERE id ='". $po."'"); 
        $log->querydata();
        return $log->data[0];
}

$subj = unserialize($_POST['subject']);
$nochecked = count($subj);
$no_subject = $nochecked;
$no_col = $no_subject *3;
$class= getCla($_POST['cl']);
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
		</style>
    </head>
    <body id="resultpage"> 
        <div id="mainp">
            <header>
                <div id="logo_res">
                    <a href="index.html"><img  src="images/banner.png" alt="Simpler"></a>
                </div>
                <div id="row1">
                    <div> 
                        <?php echo $class.", ".getTerm($term)." of ". getSe($sess); ?> 
                    </div>
                </div>
                
            </header>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-primary" href='index.php?c=<?php echo $_POST['cl']; ?>'>Back to Beginning</a>
                    </div>
                </div>
                
            <table width="100%" cellpadding="10" cellspacing="10" border="1">
                <tr>
                    <th></th>
                    <th colspan="<?php echo $no_col; ?>">Subject</th>
                </tr>
                <tr>
                    <th>Name</th>
                    <?php for($a=0; $a< $no_subject; $a++){
                    ?>
                     <th colspan="3"><?php echo getSub($subj[$a]); ?></th>
                        
                    <?php } ?>
                </tr>
                <tr>
                    <td></td>
                    <?php 
                    for($b=0; $b<$no_subject; $b++){
                    ?>
                     <td >CA 1</td>
                     <td >CA 2</td>
                     <td >Exam</td>
                    <?php } ?>
                </tr>
                <?php 
                    $log->set_sqlstr("SELECT DISTINCT id FROM student_data WHERE class='".$_POST['cl']."'");
                    $log->querydata();
                    for($stv = 0; $stv < $log->no_rec; $stv++){ 
                ?>
                <tr>
                    <td>
                        <?php echo getUser($log->data[0]); ?>                        
                        <input type="hidden" value="<?php echo $log->no_rec; ?>" name="noofstu">
                        <input type="hidden" value="<?php echo $no_subject; ?>" name="noofsub">                        
                        <input type="hidden" value="<?php echo $log->data[0]; ?>" name="stud_id[]">
                    </td>
                    <?php 
                        for($b=0; $b<$no_subject; $b++){
                        $log1->set_sqlstr("SELECT * FROM result WHERE term=".$term." AND session=".$sess." AND subject=".$subj[$b]." AND student_id='".$log->data[0]."' AND class=".$_POST['cl']."");
                        $log1->querydata();
                    ?>
                        <td>
                            <input type="hidden" value="<?php echo $id = ($log1->data['id'] != "")?$log1->data['id']:"ins"; ?>" name="id[]">
                            <input type="hidden" value="<?php echo $subj[$b]; ?>" name="sub[]">
                             <input type="hidden" value="load" name="loadresult">
                            <?php echo $log1->data['ca1']; ?>
                        </td>
                        <td>
                            <?php echo $log1->data['ca2']; ?>
                        </td>
                        <td>   
                            <?php echo $log1->data['exam']; ?>
                        </td>
                    <?php } ?>
                </tr>
                <?php  
                    $log->fetchdata(); 
                    } 
                ?>
            </table>
            </form>
        </div> 
        
        <footer>
           SMS Version 2.0 &copy; <?php echo date("Y"); ?>
        </footer>
    </body>
</html>
<?php }
else{ 
?>
<html>
    <head>
        <title>Result Page</title>
        <link rel="stylesheet" media="all" href="css/style1.css"/>
        <link rel="stylesheet" media="all" href="css/style.css"/>
        <link rel="stylesheet" media="all" href="css/widgets.css"/>
		<style>
			#logo_res{
				background-image:url('../img/cms.jpg');
			}
		</style>
    </head>
    <body id="resultpage"> 
        <div id="mainp">
            <header>
                <div id="logo_res">
                    <a href="index.html"><img  src="images/banner.png" alt="Simpler"></a>
                </div>
                <div id="row1">
                    <div> 
                        Please do not reload this page.
                    </div>
                </div>
                
            </header>
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-primary" href='index.php?c=<?php echo $_POST['cl']; ?>'>Back to Beginning</a>
                    </div>
                </div>  
        </div> 
        
        <footer>
           SMS Version 2.0 &copy; <?php echo date("Y"); ?>
        </footer>
    </body>
</html>
<?php } ?>