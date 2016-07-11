<?php


include("../includes/login.inc.php");
$log = new login();
$log->database();

$id = $_POST['id'];
$sid = $_POST['sid'];
$cl = $_POST['cl'];
$sub = $_POST['sub'];
$term = $_POST['term'];
$sess = $_POST['sess'];
$ca1 = $_POST['ca1'];
$ca2 = $_POST['ca2'];
$ca3 = $_POST['ca3'];
$exam = $_POST['exam'];

for($i=0; $i < count($id); $i++)
if($id[$i] == "ins"){
    if($ca1[$i] != "" || $ca2[$i] != "" || $exam[$i] != ""){
		$log->set_sqlstr("select COUNT(*) as num FROM result WHERE student_id='" . $id[$i] . "'");
		$log->querydata();
		
		if($log->data[0] < 1){
	
		$log->set_sqlstr("INSERT INTO result(student_id, term, session, subject, ca1, ca2, ca3, exam, class) VALUES " .
					"('".$sid[$i]."','".$term."','".$sess."','".$sub."','".$ca1[$i]."','".$ca2[$i]."','".$ca3[$i]."','".$exam[$i]."','" . $cl . "')");
			$log->ex_scalar();
		}
		else{

			$log->set_sqlstr("UPDATE result SET ca1='".$ca1[$i]."', ca2='".$ca2[$i]."', ca3='".$ca3[$i]."', exam='".$exam[$i]."' WHERE ID =".$id[$i]."");
			$log->ex_scalar();
			
		}
    }
}
else{

    $log->set_sqlstr("UPDATE result SET ca1='".$ca1[$i]."', ca2='".$ca2[$i]."', ca3='".$ca3[$i]."', exam='".$exam[$i]."' WHERE ID =".$id[$i]."");
    $log->ex_scalar();
    
}
  $arr = array('c'=>$cl,'sub'=>$sub,'t'=>$term,'se'=>$sess);
            echo json_encode($arr,JSON_FORCE_OBJECT);
?>