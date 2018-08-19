<?php
$lnk = basename($_SERVER['REQUEST_URI']);
require_once ('../includes/login.inc.php');
$log = new login;
//$k = substr($lnk, 0, 13);
?>
<ul>
    <li class="block">                            
        <div class="widget-block">
            <h4>Hi, Super User</h4>
            <ul id="sd">
                <li <?php if ($lnk=='index.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="index.php" >Account Home</a></li>
                <li <?php if ($lnk=='student_log.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="student_log.php" >Student Log</a></li>
                <li <?php if ($lnk=='staff_log.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="staff_log.php" >Staff Log</a></li>
                <li <?php if ($lnk=='admin_log.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="admin_log.php" >Admin Log</a></li>
                <li <?php if ($lnk=='gallery.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="gallery.php" >Photo Gallery</a></li>
                <li <?php if ($lnk=='classlist.php') {echo 'id="active"'; } ?>class="cat-item"><a class="sd" href="classlist.php" >Class List</a></li>
                <li <?php if ($lnk=='calendar.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="calendar.php" >School Calendar</a></li>              
                <li <?php if ($lnk=='smsapp.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="smsapp.php" >SMS APP</a></li>
                <li <?php if ($lnk=='manage_sub.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="manage_sub.php" >Manage Subject</a></li>
                <li <?php if ($lnk=='qow.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="qow.php" >Set Question</a></li>
                <li <?php if ($lnk=='qow_list.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="qow_list.php" >Question Bank</a></li>
                <li <?php if ($lnk=='idcard.php') {echo 'id="active"'; } ?> class="cat-item"><a class="sd" href="idcard.php" >Produce ID Card</a></li>
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
