<?php


include("../includes/login.inc.php");
$log = new login();
$log->database();
$ty = $_POST['type'];
$au = $_POST['author']!="" ? htmlspecialchars($_POST['author'],ENT_QUOTES) : "Anonymous";
$ti = htmlspecialchars($_POST['title'],ENT_QUOTES);
$con = $_POST['content1'];
$date = date("d-m-Y");
$time = date("H:i:s");


if($ty != ""){
    if($con != ""){
    $log->set_sqlstr("INSERT INTO publications(Title, Author, Content, Status, Date, Time, Type, Username) VALUES " .
                "('" . $ti . "', '" . $au . "', '" . $con . "','1', '" . $date . "', '" . $time . "', '" . $ty . "', '".$_SESSION['s_portal_id']."')");
        $log->ex_scalar();
        $d = 1;
    }
    else $d = 0;
}
else $d = 2;

echo $d;

?>