<?php


include("../includes/login.inc.php");
$log = new login();
$log->database();
$amt = str_replace(",", "", $_POST['amt']);
$amt = str_replace(" ", "", $amt);
$details = $_POST['ptype']."/".$_POST['purpose'];
$date = date("d-m-Y");
$time = date("H:i:s");


if($_POST['purpose'] != "" && $_POST['ptype']!=""){
    if($amt != ""){
    $sql = "INSERT INTO payment_log(Username, Amount, Session, Term, Class, Date, Time, Detail) VALUES " .
                "('" . $_POST['user'] . "', '" . $amt . "', '" . $_POST['session'] . "','" . $_POST['term'] . "', '" . $_POST['class'] . 
                "', '" . $date . "','" . $time . "', '" . $details . "')";
    $log->set_sqlstr($sql);
        $log->ex_scalar();
        $d = 1;
        $d = (isset($_POST['rec']))? 4 ."/". $_POST['user']."/".$time: 1; 
    }
    else $d = 0;
}
else $d = 2;

echo $d;

?>