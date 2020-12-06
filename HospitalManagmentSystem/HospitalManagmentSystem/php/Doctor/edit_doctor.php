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
	$stmt = $conn->prepare("update doctor set dname= ?,special= ?,qual= ?,fee= ?,phone= ?,room= ?  where doctorno= ? ");
	$stmt->bind_param("sssssss",$dname,$special,$qual,$fee,$phone,$room,$doctorno);
	
	
	$dname=$_POST['dname'];
	$special=$_POST['Special'];
	$qual=$_POST['quali'];
	$fee=$_POST['fee'];
	$phone=$_POST['phone'];
	$room=$_POST['rno'];
	$doctorno=$_POST['doctor_id'];
	
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