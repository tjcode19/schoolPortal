<?php
include("../includes/login.inc.php");
$log = new login();
$log->database();

$id = $_POST['id'];
$cl = $_POST['cl'];
$sub = $_POST['sub'];
$bk = $_POST['book'];
$au = $_POST['author'];

for($i=0; $i < count($id); $i++)
if($id[$i] == "ins"){
    if($sub[$i] != ""){
    $log->set_sqlstr("INSERT INTO listofbook(Class, Course, Book, Author) VALUES " .
                "('" . $cl . "', '" . $sub[$i] . "', '" . $bk[$i] . "','" . $au[$i] . "')");
        $log->ex_scalar();
    }
}
else{

    $log->set_sqlstr("UPDATE listofbook SET Course='" . $sub[$i] . "',Book='" . $bk[$i] . "',author='" . $au[$i] . "' WHERE ID = '" . $id[$i]. "'");
    $log->ex_scalar();
    
}
 $arr = array('c'=>$cl);
            echo json_encode($arr,JSON_FORCE_OBJECT);
  /*
echo "hi"; */
?>