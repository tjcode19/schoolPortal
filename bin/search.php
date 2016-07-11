<?php 
  $c = str_replace("%20"," ",$_POST['cl']);
  $s = str_replace("%20"," ",$_POST['sub']);
  $t = str_replace("%20"," ",$_POST['term']);
    $arr = array('cl'=>$c, 'sub'=>$s, 'te'=>$t);
            echo json_encode($arr,JSON_FORCE_OBJECT);
?>