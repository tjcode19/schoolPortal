<!doctype html> 
<?php

include("../../includes/login.inc.php");
    $log = new login();
    $log->database();
    $log1 = new login();
    $log1->database();
 
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

$sub = htmlspecialchars(serialize($_POST['subject']));

if(isset($_POST['subject'])){
    $nochecked = count($_POST['subject']);
}
$no_subject = $nochecked;
$no_col = $no_subject *3;
$term = $_POST['term'];
$sess = $_POST['session'];
$class = getCla($_REQUEST['c']);
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
                        <?php echo $class.", ".getTerm($term)." of ". getSe($sess); ?> 
                    </div>
                </div>
                
            </header>
            <form action="display.php" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <input class="btn btn-primary" type="submit" value="Save Result">
                        <input type="hidden" value="<?php echo $term; ?>" name="term">
                        <input type="hidden" value="<?php echo $sess; ?>" name="session">
                          <input type="hidden" value="<?php echo $sub; ?>" name="subject">
                        <input type="hidden" value="<?php echo $_REQUEST['c']; ?>" name="cl">
                    </div>
                </div>
                
            <table width="100%" cellpadding="5" cellspacing="0" border="1">
                <tr>
                    <th></th>
                    <th colspan="<?php echo $no_col; ?>">Subject</th>
                </tr>
                <tr>
                    <th>Name</th>
                    <?php for($a=0; $a< $no_subject; $a++){
                    ?>
                     <th colspan="3"><?php echo getSub($_POST['subject'][$a]); ?></th>
                        
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
                    $log->set_sqlstr("SELECT DISTINCT id FROM student_data WHERE class='".$_REQUEST['c']."'");
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
                        $log1->set_sqlstr("SELECT * FROM result WHERE term=".$term." AND session=".$sess." AND subject=".$_POST['subject'][$b]." AND student_id='".$log->data[0]."' AND class=".$_REQUEST['c']."");
                        $log1->querydata();
                    ?>
                        <td>
                            <input type="hidden" value="<?php echo $id = ($log1->data['id'] != "")?$log1->data['id']:"ins"; ?>" name="id[]">
                            <input type="hidden" value="<?php echo $_POST['subject'][$b]; ?>" name="sub[]">
                             <input type="hidden" value="load" name="loadresult">
                            <?php 
                                if(isset($_POST['loadR'])){
                            ?>
                                <?php echo $log1->data['ca1']; } else{ ?>
                            <input type="text" name="c1[]" size="1" value="<?php echo $log1->data['ca1']; ?>">
                            <?php } ?>
                        </td>
                        <td>
                            <input type="text" name="c2[]" size="1" value="<?php echo $log1->data['ca2']; ?>">
                        </td>
                        <td>   
                            <input type="text" name="c3[]" size="1" value="<?php echo $log1->data['exam']; ?>">
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