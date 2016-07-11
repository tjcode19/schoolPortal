<?php
$lnk = basename($_SERVER['REQUEST_URI']);
$k = substr($lnk, 0, 13);
require_once ('../includes/login.inc.php');
$log = new login;
?>
<ul>
    <li class="block">                            
        <div class="widget-block">
            <h4>Hi, <?php echo $_SESSION['name']; ?>(<?php echo strtoupper($_SESSION['user_id']); ?>)</h4>
            <ul id="sd">
                <li <?php if ($lnk=='index.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="index.php" >Account Home</a></li>
                <!--<li <?php if ($lnk=='emp_det.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="emp_det.php" >Employment Details</a></li>-->
				<li <?php if ($lnk=='status.php' || $lnk=='status_edit.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="status.php" >Status & Eligibility</a></li>
                <li <?php if ($lnk=='scheme.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="scheme.php" >Scheme of Work</a></li> 
                <li <?php if ($lnk=='scheme_edit.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="scheme_edit.php" >Edit Scheme of Work</a></li>
                <li <?php if ($lnk=='classlist.php') {echo 'id="active"'; } ?>class="cat-item"><a class="sd" href="classlist.php" >Class List</a></li>
                <li <?php if ($lnk=='calendar.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="calendar.php" >School Calendar</a></li>
                <li <?php if ($lnk=='result.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="result.php" >View Result</a></li>
                <li <?php if ($lnk=='lob.php') {echo 'id="active"'; } ?>class="cat-item"><a class="sd" href="lob.php" >List Of Books</a></li>                
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
