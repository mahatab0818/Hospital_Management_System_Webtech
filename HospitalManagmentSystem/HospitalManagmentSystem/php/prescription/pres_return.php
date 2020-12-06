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

$stmt = $conn->prepare("select pid,pname,dtype,des from prescription where pid = ? ");
$stmt->bind_param("s",$pid); 
$pid=$_POST['pres_id'];
$stmt->bind_result($pid,$pname,$dtype,$des);

if($stmt->execute())
{
	while($stmt->fetch())
	{
		$output = array("pid"=>$pid,"pname"=>$pname,"dtype"=>$dtype,"des"=>$des);
	}
	
	echo json_encode($output);
}
$stmt->close();

?>