<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kkp";

$query = mysql_connect($host,$user,$pass);

if(!$query){
	echo "Failed";
}else{
	mysql_select_db($db);
	//echo "sukses";
}

?>