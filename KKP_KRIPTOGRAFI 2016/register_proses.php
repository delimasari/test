<?php
include "koneksi.php";

$query = mysql_connect($host,$user,$pass);

if(!$query){
	echo "Failed";
}else{
	mysql_select_db($db);
	echo "<script>alert('Data berhasil di simpan ke Database')</script>";
	//echo "sukses";
}
	$username = $_POST['username'];
	$password = $_POST['password'];
	$level	  = $_POST['level'];
	
	$query = "INSERT INTO users(username,password,level)VALUES('$username','$password','$level')";
	$sql = mysql_query($query);

	if ($sql){
		echo "<script>alert('Data berhasil di simpan ke Database')</script>";
		header('location:index.php');
	}else{
		echo "<script>alert('Data gagal di simpan ke Database')</script>";
		//echo "gagal";
	}
	
	


?>