<?php 

    require_once ('../includes/login.inc.php');
	
    $log = new login;
	$log->database();

	$fn= $_POST['firstname'];
	$ls  = $_POST['surname'];
	$on = $_POST['othername'];
	$gen = $_POST['gender'];
	$dob = $_POST['dob'];
	$nat = ""; //$_POST['nationality'];
	$soo = $_POST['soo'];
	$lgo = $_POST['lgo'];
	$pt = $_POST['ptitle'];
	$pn = $pt." ".$_POST['pname'];
	$pad = $_POST['paddress']; //Parent Address
	$pem = $_POST['pemail'];
	$pph = $_POST['pphone'];
	$apph = $_POST['apphone'];
	$bg = $_POST['bgroup'];
	$rel = ""; //$_POST['religion'];
	$he = $_POST['height'];
	$cl = $_POST['class'];
	$rt = $_POST['rtype'];
	if($_POST['rpin'] != ""){
		$pin = $_POST['rpin'];	
		$st = 1;
	}
	else{
		$pin = "";
		$st = 0;
	}	
	
	$log->set_sqlstr("SELECT COUNT(*) as num FROM authentication WHERE priority = 1");
    $log->querydata();
    $id = ($log->data['num']=="")?0:$log->data['num'];
    $id +=1;
    $len = strlen($id);	   

	function user($ln,$new_id){
		 switch($ln){
            case 0:
                $id = "000".$new_id;
                break;
            case 1:
                $id = "000".$new_id;
                break;
            case 2:
                $id = "00".$new_id;
                break;
            case 3:
                $id = "0".$new_id;
                break;
            default:
                $id = $new_id;
                break;
		}
		$pr = "SD";
		$year = date("Y");
		$username = $pr.substr($year,1,3).$id;
		
		return $username;		
	}
		
	$pass = md5('student'); //Default Password
	$c_d = date("l, d F Y"); //Creation Date
	$prio = 1;
	$user = user($len,$id);
	
	//Insert into Authentication Table
	$log->set_sqlstr("INSERT INTO authentication(username, password, email, phone_number, activation_key, date_created,".
	" priority, status) VALUES('". $user ."','".$pass."','".$pem."','".$pph."','".$pin."','".$c_d."','".$prio."','".$st."')");
	$log->ex_scalar();
	
	$log->set_sqlstr("SELECT id FROM authentication WHERE priority = 1 AND username='".$user."'");
    $log->querydata();
	$id = $log->data[0];
	
	//Insert into Student Data
	$pad = htmlspecialchars($pad, ENT_QUOTES);
	$log->set_sqlstr("INSERT INTO student_data(id, first_name, last_name, other_name, date_of_birth, residential_address, gender, religion, parent_name".
	" , parent_address, parent_phone, parent_phone_alt, parent_email, local_government, state_of_origin, nationality, blood_group, height".
	" , class) VALUES('".$id."','".$fn."','".$ls."','".$on."','".$dob."','".$pad."','".$gen."','".$rel."','".$pn."','".$pad."','".$pph."','".$apph.
	"','".$pem."','".$lgo."','".$soo."','".$nat."','".$bg."','".$he."','".$cl."')");
	$log->ex_scalar(); 
		
	//Send message to the new staff
		require_once ("sms_api.php");
		$log->set_sqlstr("SELECT * FROM gateway WHERE Status=1 ");
		$log->querydata(); 
		$cre = $log->data[5];
		$rec = $pph;
		$used_units = 1;
		if($cre > 1 && $rec!= ""){			
			$s_id = "AFNPSAkure";
			$msg = "Welcome to Apostolic Faith n/p sch, Akure. \n Visit www.apostolicfaithnpsakure.com to login. \n Username: ".$user." \n Password: student \n Contact 08100770757 for help";

			$usern = trim($log->data['Username']);
			$pass = trim($log->data['Password']);
			$url = trim($log->data['URL']);   

			$mysms = new sms($usern, $pass, $url);
			$done = $mysms->send($rec, $s_id, $msg);
			
			$new_u = $cre - $used_units;
			$log->set_sqlstr("UPDATE gateway SET unit = '".$new_u."' WHERE Status=1");
			$log->ex_scalar();
		}
	//End
	
	$arr = array('mn'=>$fn, 'us'=>$user, 'id'=>$id);
    echo json_encode($arr,JSON_FORCE_OBJECT);






/*
if($_POST['email'] != "" && $_POST['name'] != "" && $_POST['message'] != ""){
    //vars
    $subject = "Feedback(SMS)";
    $to = $_POST['to_email'];

    $from = $_POST['email'];

    //data
    $msg = "NAME: "  .$_POST['name']    ."<br>\n";
    $msg .= "EMAIL: "  .$_POST['email']    ."<br>\n";
    $msg .= "COMMENTS: "  .$_POST['message']    ."<br>\n";

    //Headers
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: <".$from. ">" ;

    if(!mail($to, $subject, $msg, $headers)){	
		$msg = "Error sending message, please try again";
	}
	else{
		$msg = "OK";
	}
}
else{
	$msg = "Please fill all fields";
	}

echo $msg;
*/

?>