<?php

session_start();
require_once("database.inc.php");
$myPrefixList[] = "12";
$myPrefixList[] = "22";
$myPrefixList[] = "32";
$myPrefixList[] = "42";
$myPrefixList[] = "52";

class login extends database {

    var $logusername;
    var $logpassword;
    var $logsuccess;
    var $cpass;
    var $n;
    var $p;
    var $myPrefixList = "12";


    function login() {
        $this->logusername = '';
        $this->logpassword = '';
        $this->logsuccess = 0;
    }

    function do_login($n, $p) {
        $this->logusername = $n;
        $this->logpassword = $p;
        $this->logsuccess = 0;

        $this->database();
        //$this->logpassword = md5($this->logpassword);
        $this->set_sqlstr("SELECT COUNT(*) AS STATUS FROM authentication  WHERE username = '" . $this->logusername . "' AND password = '" . $this->logpassword . "'");
        $this->querydata();
        if ($this->data[0] > 0) {
            $this->set_sqlstr("SELECT priority, status FROM authentication WHERE username = '" . $this->logusername . "' AND password = '" . $this->logpassword . "'");
            $this->querydata();
            if ($this->data[1] == 2) {
                if ($this->data[0] == 1) {
                    $this->reg_sess();
                    $this->logsuccess = 1; //Logon to student Module	
                } else if ($this->data[0] == 2) {
                    $this->reg_sess();
                    $this->logsuccess = 2; //Logon to staff Module	
                } else if ($this->data[0] == 3) {
                    $this->reg_sess();
                    $this->logsuccess = 3; //Logon to admin Module	
                } else if ($this->data[0] == 5) {
                    $this->reg_sess();
                    $this->logsuccess = 4; //Logon to control panel Module	
                }else if ($this->data[0] == 4) {
                    $this->reg_sess();
                    $this->logsuccess = 99; //Logon to account Module	
                }
            } else if($this->data[1] == "Raw") {
                $this->logsuccess = 5; //Account has been deactivated
            }
            else{
                $this->logsuccess = 6; //Account has been deactivated
            }
        }
        else
            $this->logsuccess = 0; //User does not exist
    }

    function verify_login() {
        $this->logsuccess = 0;
        if (isset($_SESSION['s_portal_id']) && isset($_SESSION['id']))
            if ($_SESSION['s_portal_id'] != '' && $_SESSION['id'] != '') {
                $this->database();
                $this->set_sqlstr("SELECT COUNT(*) AS STATUS FROM authentication  WHERE id = '" . $_SESSION['s_portal_id'] . "' AND hash_code = '" . $_SESSION['id'] . "'");
                $this->querydata();
                if ($this->data[0] > 0) {
                    $currdate = date("Y") . "/" . date("n") . "/" . date("j") . "/" . date("G") . "/" . date("i");
                    $id = md5($_SESSION['s_portal_id'] . $currdate);
                    $this->database();
                    $this->set_sqlstr("Update authentication SET hash_code='" . $id . "' WHERE id = '" . $_SESSION['s_portal_id'] . "' AND hash_code = '" . $_SESSION['id'] . "'");
                    $this->ex_scalar();
                    $_SESSION['id'] = $id;
                    $this->set_sqlstr("SELECT priority FROM authentication  WHERE id = '" . $_SESSION['s_portal_id'] . "' AND hash_code = '" . $_SESSION['id'] . "'");
                    $this->querydata();
                    if ($this->data[0] == 1) {
                        $this->logsuccess = 1; //Logon to student Module	
                    } else if ($this->data[0] == 2) {
                        $this->logsuccess = 2; //Logon to staff Module	
                    } else if ($this->data[0] == 3) {
                        $this->logsuccess = 3; //Logon to admin level one Module	
                    } else if ($this->data[0] == 5) {
                        $this->logsuccess = 4; //Logon to control panel Module	
					} else if ($this->data[0] == 4) {
                        $this->logsuccess = 99; //Logon to bursar panel Module	
                    }
                } else {
                    $this->logout();
                    $this->logsuccess = 0;
                }
            }
            else
                return;
    }

    function logout() {
        $this->database();
        if (!isset($_SESSION['s_portal_id']))
            return;
        $this->set_sqlstr("UPDATE authentication SET hash_code='" . "0" . "' WHERE username = '" . $_SESSION['s_portal_id'] . "'");
        $this->ex_scalar();
        $_SESSION['s_portal_id'] = "";
        $_SESSION['id'] = "";
        $_SESSION['permit'] = "";
        $_SESSION['bal'] = "";
    }

    //If the user is idle for 5mins, auto logout will be activated
    function autologout($n) {
        $this->logusername = $n;
        $this->database();
        $date = date('Y-n-d');
        $time = date('H:i:s');
        $logout_DnT = date('d-n-Y') . "/" . date('H:i:s');
        $this->set_sqlstr("UPDATE authentication SET Hash_code='" . "0" . "', Time=" . "0" . " WHERE Username = '" . $this->logusername . "'");
        $this->ex_scalar();
        $_SESSION['s_portal_id'] = "";
        $_SESSION['id'] = "";
        $_SESSION['permit'] = "";
        return header("Location:" . account);
    }
	

    function reg_sess() {
        $currdate = date("Y") . "/" . date("n") . "/" . date("j") . "/" . date("G") . "/" . date("i");
        $logint = date('H:i:s');
		$c_d = date("l, d F Y"); //Creation Date
        $id = md5($this->username . $currdate);
        $this->database();
        //$password = md5($this->logpassword);
        $this->set_sqlstr("UPDATE authentication SET hash_code='" . $id . "', last_login='".$c_d."' WHERE username = '" . $this->logusername . "' AND password = '" . $this->logpassword . "'");
        $this->ex_scalar();
        //$_SESSION['s_portal_id'] = $this->logusername;
        $_SESSION['id'] = $id;
        $this->set_sqlstr("SELECT priority FROM authentication  WHERE username = '" . $this->logusername . "'");
        $this->querydata();
        if($this->data[0] == 1){
			$this->set_sqlstr("SELECT id FROM authentication  WHERE username = '" . $this->logusername . "'");
            $this->querydata();
			$id = $this->data[0];
			$_SESSION['s_portal_id'] = $id;
			
            $this->set_sqlstr("SELECT first_name FROM student_data WHERE id = '" . $id . "'");
            $this->querydata();
            $_SESSION['name'] = $this->data[0];
			$_SESSION['s_portal_id'] = $id;
			$_SESSION['user_id'] = $this->logusername;
        }
        else if($this->data[0] > 1){
			$this->set_sqlstr("SELECT id FROM authentication  WHERE username = '" . $this->logusername . "'");
            $this->querydata();
			$id = $this->data[0];
			$_SESSION['s_portal_id'] = $id;
			$_SESSION['user_id'] = $this->logusername;
			
            $this->set_sqlstr("SELECT first_name FROM staff_data WHERE id = '" . $id . "'");
            $this->querydata();
            $_SESSION['name'] = $this->data[0];
        }
    }

    function completed_number($prefix, $length) {

        $ccnumber = $prefix;

        # generate digits

        while (strlen($ccnumber) < ($length - 1)) {
            $ccnumber .= rand(0, 9);
        }

        # Calculate sum

        $sum = 0;
        $pos = 0;

        $reversedCCnumber = strrev($ccnumber);

        while ($pos < $length - 1) {

            $odd = $reversedCCnumber[$pos] * 2;
            if ($odd > 9) {
                $odd -= 9;
            }

            $sum += $odd;

            if ($pos != ($length - 2)) {

                $sum += $reversedCCnumber[$pos + 1];
            }
            $pos += 2;
        }

        # Calculate check digit

        $checkdigit = (( floor($sum / 10) + 1) * 10 - $sum) % 10;
        $ccnumber .= $checkdigit;

        //return $ccnumber;
    }

    function pin_number($prefixList, $length, $howMany) {
        echo $prefixList;
        for ($i = 0; $i < $howMany; $i++) {

            echo $ccnumber = $prefixList[rand(0, 4)];
            $result[] = completed_number($ccnumber, $length);
        }

        echo $result;
    }

    function generate($Qty, $Val) {

        if ($Qty == "" || $Val == '')
            return 0;
        $this->database();
        $i = 0;
        echo $Qty . "h";
        while ($i < $Qty) {
            $mypin = $this->pin_number(14, 12, 1);
            $mysn = $this->pin_number(12, 18, 1);
            $dateCreated = date('Y-n-d');
            $timeCreated = date('H:i:s');

            $sql = "SELECT COUNT(*) as num FROM pin_log WHERE PIN='" . $mypin[0] . "'";
            $this->set_sqlstr($sql);
            $this->querydata();

            if ($this->data[0] < 1)
                continue;

            $status = 0;

            $sql = "INSERT INTO pin_log (PIN, Serial, Status, Validity, Date_Created, Time_Created) VALUES ('" . $mypin[0] . "', '" . $mysn[0] . "', " . $status . ", '" . $Val . "', '" . $dateCreated . "', '" . $timeCreated . "')";
            $this->set_sqlstr($sql);
            $this->ex_scalar();
            ++$i;
            echo $mypin[0];
        }
        //return 1;
    }

}

?>