<?php
include("../includes/login.inc.php");
$log = new login();
$log->database();

$id = $_POST['id'];
$cl = $_POST['cl'];
$sub = $_POST['sub'];
$bk = $_POST['book'];
$auth = $_POST['author'];

for($i=0; $i < count($id); $i++)
if($id[$i] == "ins"){
    if($sub[$i] != ""){
    $log->set_sqlstr("INSERT INTO listofbooks(Class, subject, Book, Author) VALUES " .
                "('" . $cl . "', '" . $sub[$i] . "', '" . $bk[$i]. "','" . $auth[$i] . "')");
        $log->ex_scalar();
    }
}
else{

    $log->set_sqlstr("UPDATE listofbooks SET subject='" . $sub[$i] . "',book='" . $bk[$i] . "',author='" . $auth[$i] . "' WHERE ID = '" . $id[$i]. "'");
    $log->ex_scalar();
    
}
 $arr = array('c'=>$_POST['cl']);
            echo json_encode($arr,JSON_FORCE_OBJECT);
  /*
echo "hi"; */
?>