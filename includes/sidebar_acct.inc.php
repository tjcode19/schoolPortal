<?php
$lnk = basename($_SERVER['REQUEST_URI']);
require_once ('../includes/login.inc.php');
$log = new login;
//$k = substr($lnk, 0, 13);
?>
<ul>
    <li class="block">                            
        <div class="widget-block">
            <h4>Hi, <?php echo $_SESSION['name']; ?></h4>
            <ul id="sd">
                <li <?php if ($lnk=='index.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="index.php" >Account Home</a></li>
                <li <?php if ($lnk=='emp_det.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="emp_det.php" >Employment Details</a></li>                
				<li <?php if ($lnk=='enterpay.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="enterpay.php" >Enter Payment</a></li> 
				<li <?php if ($lnk=='paylog.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="paylog.php" >Payment Log</a></li> 
                <li <?php if ($lnk=='sch_fee_type.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="sch_fee_type.php" >School Fee Type</a></li> 
                <li <?php if ($lnk=='sch_fee_settings.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="sch_fee_settings.php" >School Fee Settings</a></li>                
				<li <?php if ($lnk=='invoice.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="invoice.php" >Invoice</a></li>                
                <li <?php if ($lnk=='smsapp.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="smsapp.php" >SMS APP</a></li>
                <li <?php if ($lnk=='changePass.php') {echo 'id="active"'; } ?>class="cat-item"><a class="sd" href="changePass.php" >Change Password</a></li>
            </ul>
        </div>
    </li>
    <li class="block">
        <h4>Daily Quote</h4>
         <?php 
            $log->database();
            $log->set_sqlstr("SELECT * FROM publications WHERE Type='Quote' AND Status=1 ORDER BY RAND() LIMIT 1");
            $log->querydata();
            
            echo "\"".$log->data[2]."\"</br>--<span style=\"font-size:10px;\">".$log->data[3]."</span>";                
        ?>
    </li>
</ul>
