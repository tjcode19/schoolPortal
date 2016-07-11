<?php

include("../../includes/login.inc.php");
$log = new login();
$log->database();

$id = $_POST['id'];
//$sid = $_POST['sid'];
$cl = $_POST['cl'];
$sub = $_POST['sub'];
$term = $_POST['term'];
$sess = $_POST['sess'];
$c1 = $_POST['c1'];
$c2 = $_POST['c2'];
$c3 = $_POST['c3'];

//$exam = $_POST['exam'];

$nost = count($_POST['stud_id']);
$nos = $_POST['noofsub'];
$st_id = $_POST['stud_id'];

$f = 0;
$Sub ="";
for ($stu=0; $stu < $nost; $stu++) {
  echo "$st_id[$stu] <br>";
  for($i=0; $i < $nos; $i++){ 
      $Sub .= $sub[$i];
      do{
        if($id[$f] != "ins"){
            $log->set_sqlstr("UPDATE result SET ca1='".$c1[$f]."', ca2='".$c2[$f]."', exam='".$c3[$f]."' WHERE ID =".$id[$f]."");
            $log->ex_scalar(); 
            echo "CA1= $c1[$f], CA2= $c2[$f], Exam= $c3[$f]";
            echo "<br>";
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
                echo "CA1= $c1[$f], CA2= $c2[$f], Exam= $c3[$f]";
                echo "<br>";
                }
            }
            else{
                $log->set_sqlstr("UPDATE result SET ca1='".$c1[$f]."', ca2='".$c2[$f]."', exam='".$c3[$f].
                        "' WHERE student_id='".$st_id[$stu]."' AND term='".$term."' AND session='".$sess.
                        "' AND subject='".$sub[$i]."' AND class='".$cl."'");
                $log->ex_scalar();
                echo "CA1= $c1[$f], CA2= $c2[$f], Exam= $c3[$f]";
                echo "<br>";
            }
        }
        
        $f++; 
     }while($f <= $i); 
  }
}
?>