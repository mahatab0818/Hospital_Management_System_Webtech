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
	$stmt = $conn->prepare("insert into patient(patientno,name,phone,address) VALUES(?,?,?,?)");
	$stmt->bind_param("ssss",$patientno,$name,$phone,$address);
	
	$patientno=$_POST['pno'];
	$name=$_POST['pname'];
	$phone=$_POST['phone'];
	$address=$_POST['address'];
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