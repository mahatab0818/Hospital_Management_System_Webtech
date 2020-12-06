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
	$stmt = $conn->prepare("insert into channel(chno,docno,pno,rno,date) VALUES(?,?,?,?,?)");
	$stmt->bind_param("sssss",$chno,$docno,$pno,$rno,$date);
	
	$chno=$_POST['cno'];
	$docno=$_POST['dname'];
	$pno=$_POST['pname'];
	$rno=$_POST['rno'];
	$date=$_POST['date'];
	
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