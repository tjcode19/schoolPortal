<?php 

    require_once ('../includes/linker.php');
    require_once ('../includes/login.inc.php');
     $log = new login;
     $log->database();
  
        $log->set_sqlstr("SELECT * FROM school_profile"); 
        $log->querydata();
		$t = $log->data[1];
		$s = $log->data[2];
		
		$log->set_sqlstr("SELECT * FROM calender WHERE term ='".$t."' AND session='".$s."'"); 
        $log->querydata();
		
		function getSes($ss){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM session WHERE id ='". $ss."'"); 
			$log->querydata();
			return $log->data[0];
		}
		function getTerm($t){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM term WHERE id ='". $t."'"); 
			$log->querydata();
			return $log->data[0];
		}
		function getEvent($t){
			$log = new login;
			$log->database();
			$log->set_sqlstr("SELECT name FROM event WHERE id ='". $t."'"); 
			$log->querydata();
			return $log->data[0];
		}
?>
<table width="100%" cellpadding="10" cellspacing="0" id="mai">
	<tr>
		<th><h4>Session:</h4></th>
		<th><?php echo getSes($s); ?></th>
		<th ><h4>Term:</h4></th>
		<th><?php echo getTerm($t); ?></th>
	</tr>
</table>
<table width="100%" cellpadding="10" cellspacing="0" id="mai">
	<tr>
		<th width="2%">ID</th>
		<th width="18%">Event</th>
		<th width="20%">Description</th>
		<th width="20%">Start Date</th>
		<th width="20%">End Date</th>
		<th width="20%">Time</th>
	</tr>
	<?php  for($i=0; $i < $log->no_rec; $i++){ ?>                            
							
	<tr>
		<td><?php echo ($i+1); ?></td>
		<td><?php echo getEvent($log->data[1]); ?></td>
		<td><?php echo $log->data[2]; ?></td>
		<td><?php echo $log->data[3]; ?></td>
		<td><?php echo $log->data[5]; ?></td>
		<td><?php echo $log->data[4]; ?> - <?php echo $log->data[6]; ?></td>
	</tr>
	<?php $log->fetchdata(); } ?>
</table>