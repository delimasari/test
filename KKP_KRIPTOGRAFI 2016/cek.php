<?php
	include "index.php";
	include "koneksi.php";
	session_start();
	$_SESSION['tampilnama'] = $_POST['username'];
	if($_POST['username']!="" || $_POST['password']!=""  ){
		$username = $_POST['username'];
		$password = $_POST['password'];
 		$sql	  = "SELECT * FROM users WHERE username='$username'"; 		
		$query	  = mysql_query($sql); 
		$data	  = mysql_fetch_array($query);
		
		$level 	  = $data['level'];
		
		if($password == $data['password'])
		{
			$_SESSION['level'] = $data['level'];
			header('location:home.php');
		}
		else
		{
			echo "<script>alert('Username tidak terdaftar di Database')</script>";
		}		
	}
?>