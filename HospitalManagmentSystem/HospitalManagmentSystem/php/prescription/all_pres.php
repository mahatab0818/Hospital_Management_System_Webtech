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

$stmt = $conn->prepare("select p.pid,pa.name,p.dtype,p.des from prescription p JOIN patient pa ON p.pname = pa.patientno");
$stmt->bind_result($pid,$pname,$dtype,$des);

if($stmt->execute())
{
	while($stmt->fetch())
	{
		$output[] = array("pid"=>$pid,"pname"=>$pname,"dtype"=>$dtype,"des"=>$des);
	}
	
	echo json_encode($output);
}
$stmt->close();

?>