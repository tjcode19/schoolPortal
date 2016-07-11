<?php
  include '../includes/login.inc.php';

$log = new login();
$log->database();
    
    if($_POST['pr'] == 'Staff'){
    $log->set_sqlstr("SELECT MAX(ID) as num FROM auth_tab WHERE Priority = 'staff' AND Year='".$_POST['emp']."'");
    $log->querydata();
    $id = $log->data[0];
    $id +=1;
    $len = strlen($id);	
    switch($len){
            case 0:
                $id = "000".$id;
                break;
            case 1:
                $id = "000".$id;
                break;
            case 2:
                $id = "00".$id;
                break;
            case 3:
                $id = "0".$id;
                break;
            default:
                $id = $id;
                break;
    }
    $us = "SF".$_POST['emp'].$id;   
        
        $pass = md5('staff');
        $log->set_sqlstr("INSERT INTO auth_tab(Username, Password, Priority, Status, ID, Year) VALUES " .
                "('" . $us . "', '" . $pass . "','staff','Active','" . $id . "','" . $_POST['emp'] . "')");
        $log->ex_scalar();
        $log->set_sqlstr("INSERT INTO emp_details(Username, ClassInCharge, EmpStatus, YearOfEmp," .
                "YearOfExp, Qualification) VALUES('" . $us . "', '" . $_POST['class'] . "','Active','" . $_POST['emp'] . "','" . $_POST['exp'] . 
                "','" . $_POST['qua'] . "')");
        $log->ex_scalar();
        
         $ad = htmlspecialchars($_POST['addr'], ENT_QUOTES);
        $log->set_sqlstr("INSERT INTO staff_data(Username, Fullname, Title, Age, Phone, Address, Subjects," .
                "ClassInCharge) VALUES('" . $us . "', '" . $_POST['fname'] . "','" . $_POST['title'] . "','" . $_POST['age'] . 
                "','" . $_POST['phone']. "','" . $ad . "','" . $_POST['sub'] . "','" . $_POST['class'] . "')");
        $log->ex_scalar();  
        $na=  explode(" ",$_POST['fname']);
        $name = $na[0];
    }
    elseif($_POST['pr'] == 'Student'){
    $log->set_sqlstr("SELECT MAX(ID) as num FROM auth_tab WHERE Priority = 'student' AND Year='".$_POST['amd']."'");

    $log->querydata();
    $id = $log->data[0];
    $id +=1;
    $len = strlen($id);	
    switch($len){
            case 0:
                $id = "000".$id;
                break;
            case 1:
                $id = "000".$id;
                break;
            case 2:
                $id = "00".$id;
                break;
            case 3:
                $id = "0".$id;
                break;
            default:
                $id = $id;
                break;
    }
    $us = "SD".$_POST['amd'].$id;
       
        
        $pass = md5('student');
        $log->set_sqlstr("INSERT INTO auth_tab(Username, Password, Priority, Status, ID, Year) VALUES " .
                "('" . $us . "', '" . $pass . "','student','Active','" . $id . "','" . $_POST['amd'] . "')");
        $log->ex_scalar();
        $log->set_sqlstr("INSERT INTO status(Username, Status, Class) VALUES ('" . $us . "','Active','" . $_POST['cl'] . "')");
        $log->ex_scalar();
        $log->set_sqlstr("INSERT INTO admission_details(Username, PresentClass, AdmissionStatus, YearOfAdmission," .
                "YearOfGraduation, ExtraActivity) VALUES('" . $us . "', '" . $_POST['cl'] . "','Active','" . $_POST['amd'] . "','0','" . $_POST['ex'] . "')");
        $log->ex_scalar();
        
         $ad = htmlspecialchars($_POST['addr'], ENT_QUOTES);
        $log->set_sqlstr("INSERT INTO student_data(Username, Surname, Firstname, Other, Age, ParentPhone, Address, ParentName," .
                "Class, BloodG, Height, Email, Gender) VALUES('" . $us . "', '" . $_POST['sname'] . "','" . $_POST['fname'] . 
                "','" . $_POST['oname'] . "','" . $_POST['age'] . "','" . $_POST['p_ph'] . "','" . $ad . "','" . $_POST['p_n'] . 
                "','" . $_POST['cl']. "','" . $_POST['bg'] . "','" . $_POST['ht'] . "','" . $_POST['email'] . "','" . $_POST['gender'] . "')");
        $log->ex_scalar(); 
        
        $name =  $_POST['fname'];
    }
    //$msg = 1;    
    $arr = array('mn'=>$name, 'n'=>$us);
            echo json_encode($arr,JSON_FORCE_OBJECT);
?>