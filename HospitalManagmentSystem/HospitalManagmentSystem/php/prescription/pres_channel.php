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
	$stmt = $conn->prepare("update channel set docno= ?,pno= ?,rno= ?,date= ? where chno= ? ");
	$stmt->bind_param("sssss",$docno,$pno,$rno,$date,$chno);
	
	
	$docno=$_POST['dname'];
	$pno=$_POST['pname'];
	$rno=$_POST['rno'];
	$date=$_POST['date'];
	$chno=$_POST['channel_id'];
	
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