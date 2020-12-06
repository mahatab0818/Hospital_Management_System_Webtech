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
	$stmt = $conn->prepare("update prescription set pname= ?,dtype= ?,des= ? where pid= ? ");
	$stmt->bind_param("ssss",$pname,$dtype,$des,$pid);
	
	
	$pname=$_POST['pname'];
	$dtype=$_POST['dtype'];
	$des=$_POST['des'];

	$pid=$_POST['pres_id'];
	
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