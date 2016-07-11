<?php

class database{

var $host;
var $username;
var $password;

var $con;
var $db_name;
var $sqlstr;
var $db_result;
var $data;
var $status;
var $no_rec;


//set host server
function set_host($path){
	$this->host = $path;
}

//set host server
function set_con($con){
	$this->con = $con;
}

//set host user parameters
function set_user($n, $p){
	$this->username = $n;
	$this->password = $p;
}

//set host database
function set_db($db){
	$this->db_name = $db;
}

//set slq string
function set_sqlstr($str){
	$this->sqlstr = $str;
}

//set slq result
function set_result($str){

	$this->db_result = $str;
}

//initialise database
function database(){
	$this->host = 'localhost';
	$this->username = 'root';
	$this->password = '';
	$this->con = '';
	$this->db_name = 'schoolportal_data';
	$this->sqlstr = '';
	$this->status = '';

}

//initialise database
function reset(){
	$this->host = 'localhost';
	$this->username = 'root';
	$this->password = '';
	$this->con = '';
	$this->db_name = 'schoolportal_data';
	$this->sqlstr = '';
	$this->status = '';

}

//function to connect to the database
function connect(){
    $conn = mysql_connect($this->host,$this->username,$this->password) or die("couldn't connect");
	$this->set_con($conn);
} 

//function to  close connection to the database
function close_connection(){
    $conn= $this->con;
	mysql_close($conn);
}

//method to create and connect to a DB
 function create_db($dummy_db_name){
 	$this->connect();
	$this->sqlstr = "CREATE DATABASE ". $dummy_db_name ; 
 	$query = mysql_query($this->sqlstr) or die("create database error");
	$this->set_db($dummy_db_name);
	$this->close_connection();
 	//mysql_select_db($dummy_db_name) or die("Couldn't select DB");
 
 }
 

 //method to perform scalar operation
 function ex_scalar(){
    $this->status = 0;
 	$this->connect();
 	mysql_select_db($this->db_name) or die("Couldn't select DB") ;
//	echo $this->sqlstr;
	$query = mysql_query($this->sqlstr) or die("scalar error".mysql_error()) ;
	$this->status = 1;
	$this->close_connection();
	
 } 

 
// method to query the DB
function querydata(){
	$this->status = 0;
	$this->connect();
	mysql_select_db($this->db_name) or die("Couldn't select DB".mysql_error());
	$db_resultset = mysql_query($this->sqlstr) or die("query error".mysql_error());
	$this->no_rec = mysql_num_rows($db_resultset);
	$this->set_result( $db_resultset);
	$this->fetchdata();
	$this->status = 1;
	$this->close_connection();
}

// method to query the DB
function fetchdata(){
	if ($this->data = mysql_fetch_array($this->db_result))  return true;
	else return false;
	
	}
}

?>