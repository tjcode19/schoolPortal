<?php
include("../includes/login.inc.php");
$log = new login();
$log->database();

$id = $_POST['id'];
$cl = $_POST['cl'];
$sub = $_POST['sub'];
$term = $_POST['term'];
$wk = $_POST['wk'];
$tp = $_POST['topic'];

for($i=0; $i < count($id); $i++)
if($id[$i] == "ins"){
    if($tp[$i] != ""){
    $log->set_sqlstr("INSERT INTO schemeofwork(Class, Subject, Term, Week, Topic, Status) VALUES " .
                "('" . $cl . "', '" . $sub . "', '" . $term . "','" . $wk[$i] . "','" . $tp[$i] . "',0)");
        $log->ex_scalar();
    }
}
else{

    $log->set_sqlstr("UPDATE schemeofwork SET Week='" . $wk[$i] . "',Topic='" . $tp[$i] . "' WHERE ID = '" . $id[$i]. "'");
    $log->ex_scalar();
    
}
 $arr = array('c'=>$_POST['cl'], 's'=>$_POST['sub'], 't'=>$_POST['term']);
            echo json_encode($arr,JSON_FORCE_OBJECT);
  /*
echo "hi"; */
?>