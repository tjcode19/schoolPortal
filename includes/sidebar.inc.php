<?php
$lnk = basename($_SERVER['REQUEST_URI']);
require_once ('../includes/login.inc.php');
$log = new login;
?>
<ul>
    <li class="block">                            
        <div class="widget-block">
            <h4>Hi, <?php echo $_SESSION['name']; ?>(<?php echo strtoupper($_SESSION['user_id']); ?>) </h4>
            <ul id="sd">
                <li <?php if ($lnk=='index.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="index.php" >Account Home</a></li>
                <li <?php if ($lnk=='Adm_det.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="Adm_det.php" >Class Teacher Details</a></li>
                <li <?php if ($lnk=='status.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="status.php" >Status & Eligibility</a></li>
                <li <?php if ($lnk=='scheme.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="scheme.php" >Scheme of Work</a></li>
                <li <?php if ($lnk=='calendar.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="calendar.php" >School Calendar</a></li>
                <li <?php if ($lnk=='lob.php') {echo 'id="active"'; } ?>class="cat-item"><a class="sd" href="lob.php" >List Of Books</a></li>
                <li <?php if ($lnk=='payRec.php') {echo 'id="active"'; } ?>class="cat-item"><a class="sd" href="payRec.php" >Payment Record</a></li>
                <li <?php if ($lnk=='onlinepay.php') {echo 'id="active"'; } ?>class="cat-item"><a class="sd" href="onlinepay.php" >Online Payment</a></li>
                <li <?php if ($lnk=='changePass.php') {echo 'id="active"'; } ?>class="cat-item"><a class="sd" href="changePass.php" >Change Password</a></li>
            </ul>
        </div>
    </li>
    <li class="block">
        <h4>Daily Quote</h4>
        <?php 
            $log->database();
            $log->set_sqlstr("SELECT * FROM publications WHERE Type=3 AND Status=1 ORDER BY RAND() LIMIT 1");
            $log->querydata();
            
            echo "\"".$log->data[2]."\"</br>--<span style=\"font-size:10px;\">".$log->data[3]."</span>";                
        ?>
    </li>
</ul>
