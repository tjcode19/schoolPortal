<?php 

    require_once ('../includes/login.inc.php');
    
    $myPrefixList[] = "12";
    $myPrefixList[] = "22";
    $myPrefixList[] = "32";
    $myPrefixList[] = "42";
    $myPrefixList[] = "52";
    
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

        while ($pos < $length - 1){

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
        return $ccnumber;
    }

    function pin_number($prefixList, $length, $howMany) { 
        for ($i = 0; $i < $howMany; $i++) { 
            $ccnumber = $prefixList[rand(0, 4)];
            $result[] = completed_number($ccnumber, $length);
        }

        return $result;
    }

    function generate($Qty) {
        if ($Qty == "")
            return 0;
       
        $log = new login;
        $log->database();
        $i = 0;
        
        while ($i < $Qty) {
            $mypin = pin_number(14, 12, 1);
            $mysn = pin_number(12, 18, 1);
            $dateCreated = date('Y-n-d');
            $timeCreated = date('H:i:s');
 
            $log->set_sqlstr("SELECT * FROM pin_log WHERE PIN='" . $mypin[0] . "'");
            $log->querydata(); 
            if ($log->no_rec > 0)continue;

            $status = "Raw";
            $val = "Raw";

            $sql = "INSERT INTO pin_log (PIN, Serial, Status, Validity, Date_Created, Time_Created) VALUES ('" . $mypin[0] . "', '" . $mysn[0] . "', '" . $status . "', '" . $val . "', '" . $dateCreated . "', '" . $timeCreated . "')";
            $log->set_sqlstr($sql);
            $log->ex_scalar();
            ++$i;
            //echo $mypin[0]."<br/>";
        }
        
        echo $Qty . " pin generated";
    }
    
    generate($_POST['Qty']);
?>