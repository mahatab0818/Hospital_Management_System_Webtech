<?php

$servername ="localhost";
$username ="root";
$password="";
$dbname ="amrhospital";

$conn = new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error)
{
	die("Connection failed" . $conn->connect_error);
}

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$stmt = $conn->prepare("update user set fullname = ?,uname= ?,utype =? where id= ?");
	$stmt->bind_param("ssss",$fullname,$uname,$utype,$userid);
	
	
	$fullname=$_POST['fullname'];
	$uname=$_POST['uname'];
	$utype=$_POST['utype'];
	$userid=$_POST['user_id'];
	
	if($stmt->execute())
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
	$stmt->close();
}





?>