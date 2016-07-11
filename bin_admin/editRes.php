<?php 

require_once ('../includes/linker.php'); 
require_once ('../includes/login.inc.php');

function getCla($po){
        $log = new login;	
        $log->database();
        $log->set_sqlstr("SELECT name FROM class WHERE id ='". $po."'"); 
        $log->querydata();
        return $log->data[0];
}
?>
<a class="btn btn-primary" target="_blank" href='<?php echo Admin_Module; ?>enterResult?c=<?php echo $_REQUEST['c']; ?>'>
    Edit result for <?php echo getCla($_REQUEST['c']); ?>
</a>
        
