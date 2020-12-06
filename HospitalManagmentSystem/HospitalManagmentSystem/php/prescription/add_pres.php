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
	$stmt = $conn->prepare("insert into prescription(pid,pname,dtype,des) VALUES(?,?,?,?)");
	$stmt->bind_param("ssss",$pid,$pname,$dtype,$des);
	
	$pid=$_POST['presno'];
	$pname=$_POST['pname'];
	$dtype=$_POST['dtype'];
	$des=$_POST['des'];
	
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