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
	$stmt = $conn->prepare("delete from patient where patientno = ? ");
	$stmt->bind_param("s",$patientno);
	
	$patientno=$_POST['patient_id'];
	
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