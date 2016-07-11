<?php 

    require_once ('../includes/login.inc.php');
	
    $log = new login;
	$log->database();

	$fn= $_POST['firstname'];
	$ls  = $_POST['surname'];
	$on = $_POST['othername'];
	$gen = $_POST['gender'];
	$dob = $_POST['dob'];
	$pt = $_POST['title'];
	$pad = $_POST['address']; //Parent Address
	$pem = $_POST['email'];
	$ph = $_POST['phone'];
	$apph = $_POST['aphone'];
	$bg = $_POST['bgroup'];
	$rel = $_POST['religion'];
	$he = $_POST['height'];
	$cl = $_POST['class'];
	$po = $_POST['position'];
		
	$st = 1;
	$pin = "";
	$log->set_sqlstr("SELECT COUNT(*) as num FROM authentication WHERE priority = 2");
    $log->querydata();
    $id = ($log->data[0]=="")?0:$log->data[0];
    $id +=1;
    $len = strlen($id);	   

	function user($ln, $new_id){
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
		$pr = "SF";
		$year = date("Y");
		$username = $pr.substr($year,1,3).$id;
		
		return $username;		
	}
		
	$pass = md5('staff'); //Default Password
	$c_d = date("l, d F Y"); //Creation Date
	$prio = 2;
	$user = user($len, $id);
	
	//Insert into Authentication Table
	$log->set_sqlstr("INSERT INTO authentication(username, password, email, phone_number, activation_key, date_created,".
	" priority, status) VALUES('".$user ."','".$pass."','".$pem."','".$ph."','".$pin."','".$c_d."','".$prio."','".$st."')");
	$log->ex_scalar();
	
	$log->set_sqlstr("SELECT id FROM authentication WHERE priority = 2 AND username='".$user."'");
    $log->querydata();
	$id = $log->data[0];
	
	//Insert into Student Data
	$pad = htmlspecialchars($pad, ENT_QUOTES);
	$log->set_sqlstr("INSERT INTO staff_data(id, first_name, last_name, other_name, date_of_birth, residential_address, gender, religion, ".
	" phone, alt_phone, email, blood_group, height, class_in_charge, position) VALUES('".$id."','".$fn."','".$ls."','".$on."','".$dob."','".$pad."','".$gen.
	"','".$rel."','".$ph."','".$apph."','".$pem."','".$bg."','".$he."','".$cl."','".$po."')");
	$log->ex_scalar(); 
	
	//Send message to the new staff
		require_once ("sms_api.php");
		$log->set_sqlstr("SELECT * FROM gateway WHERE Status=1");
		$log->querydata(); 
		$cre = $log->data[5];		
		$rec = $ph;
		$used_units = 1;
		if($cre > 1 && $rec!= ""){	
			$s_id = "AFNPSAkure";
			$msg = "Welcome to Apostolic Faith n/p sch, Akure. \n Visit www.apostolicfaithnpsakure.com to login. \n Username: ".$user." \n Password: staff \n Contact 08100770757 for help";

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