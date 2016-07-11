<!doctype html> 
<html>
    <head>
        <title>Receipt Generation</title>
        <link rel="stylesheet" media="all" href="../css/style2.css"/>
        <link rel="stylesheet" media="all" href="../css/style.css"/>
        <link rel="stylesheet" media="all" href="../css/widgets.css"/>
    </head>
    <body id="receipt"> 
        <div id="mainp1">
        <header>
            <div id="logo_receipt">
                <a href="index.html"><img  src="../img/receipt.png" alt="School Logo"></a>
            </div>
        </header>       
            <?php
                //include("../includes/login.inc.php");
                include("../bin/getpos.php");
                $log = new login();
                $log->database();
                
                
                $log->set_sqlstr("SELECT * FROM student_data WHERE Username ='". $_REQUEST['user'] ."'"); 
                $log->querydata();
                $name = $log->data['Surname'] . " " . $log->data['Firstname'] . " " . $log->data['Other'];
                $log->set_sqlstr("SELECT * FROM payment_log WHERE Username='" . $_REQUEST['user'] . "' AND Time='". $_REQUEST['time']  ."'");
                $log->querydata();
                $ptype = explode("/", $log->data['Detail']);
                 function addcomma($amt){
                    $l = strlen($amt);
                    //$g = $l/3;
                    $nstr = "";
                    for($i = 0; $i < $l; $i++){
                        $nstr .=  substr( $amt,$i, 1);
                     if( ((($l-($i+1))%3) == 0) 
                          && (($i+ 1) != $l) ){
                         $nstr .= ", ";
                     }
                    }
                    return $nstr; 
                }
            ?>
            <table width="100%" cellpadding="10" cellspacing="0">
                <tr>
                    <td>Date: <?php echo  $log->data['Date']; ?> </td><td> Time: <?php echo  $log->data['Time']; ?> </td>
                </tr>
                <tr>
                    <td colspan='2'>Name: <?php echo  $name; ?></td>
                </tr>
                <tr>
                    <td colspan='2'>Amount: NGN <?php echo  addcomma($log->data['Amount']) ?></td>
                </tr>
                <tr>
                    <td colspan='2'>Being <?php echo $ptype[0]; ?> for <?php echo $ptype[1]; ?>, 
                        <?php echo $log->data['Term']; ?> of <?php echo $log->data['Session']; ?> Session</td>
                </tr>
            </table>
            
        
        <footer>
           School Portal Payment system, Powered by Sat Concepts ICT
        </footer></div>
    </body>
</html>