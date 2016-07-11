<?php
include("../includes/login.inc.php");
$log = new login();
$log->database();
        $d = $_POST['sid']; 
		
		$log->set_sqlstr("SELECT * FROM behaviouralattitude WHERE student_id ='". $d  ."' AND term='".$_POST['term']."' AND session='".$_POST['sess']."' "); 
        $log->querydata();
		
		if($_POST['term'] != 0 && $_POST['sess'] != 0){
			if($log->no_rec > 0){
			$tr = htmlspecialchars($_POST['col12'], ENT_QUOTES);
			$htr = htmlspecialchars($_POST['col13'], ENT_QUOTES);
				$log->set_sqlstr("UPDATE behaviouralattitude SET politeness ='" . $_POST['col'] . "', puctuality='" . $_POST['col2'] . "', neatness='" . 
				$_POST['col3'] ."', rel_with_student='" . $_POST['col4'] . "', rel_with_staff='" . $_POST['col5'] . 
				"', initiative='" . $_POST['col6'] . "', emotional_stability='" . $_POST['col7'] . 
				"', sociality='" . $_POST['col8'] . "', attentiveness='" . $_POST['col9'] . "', attendance='" . $_POST['col10'] . "', others='" . 
				$_POST['col11'] . "', teachers_remark='" . $tr . "', head_teacher_remark='" . $htr . "' WHERE student_id = '" . $_POST['sid'] . "'");
			$log->ex_scalar();
			$msg = "Data Updated Successfully";
			}
			else{
				$sql = "INSERT INTO behaviouralattitude (student_id, term, session, class, politeness, puctuality, neatness, rel_with_student, rel_with_staff, initiative, ".
				"emotional_stability, sociality, attentiveness, attendance, others, teachers_remark, head_teacher_remark) VALUES ('" . $d . "', '" . $_POST['term'] . 
				"', '" . $_POST['sess'] . "', '". $_POST['cl'] ."', '" . $_POST['col'] . "', '" . $_POST['col2'] . "', '" . $_POST['col3']. "', '" . $_POST['col4']. "', '" . 
				$_POST['col5']. "', '" . $_POST['col6']. "', '" . $_POST['col7']. "', '" . $_POST['col8']. "', '" . $_POST['col9']. "', '" . $_POST['col10']. 
				"', '" . $_POST['col11']. "', '" . $_POST['col12']. "', '" . $_POST['col13']. "')";
				$log->set_sqlstr($sql);
				$log->ex_scalar();
				$msg = "Data Inserted Successfully";
			}			
		}
		else{
			$msg = "Sorry, term and session is not set";
		}
		
		$m = $_POST['cl']."##".$d."##".$msg;
		echo $m;
		//$arr = array('d'=>$d, 'c'=>$cl,'m'=>$msg);
        //echo json_encode($arr,JSON_FORCE_OBJECT);
		
?>