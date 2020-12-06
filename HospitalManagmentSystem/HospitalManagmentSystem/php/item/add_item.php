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
	$stmt = $conn->prepare("insert into item(id,itemname,description,sellprice,buyprice,qty) VALUES(?,?,?,?,?,?)");
	$stmt->bind_param("ssssss",$id,$itemname,$description,$sellprice,$buyprice,$qty);
	
	$id=$_POST['ino'];
	$itemname=$_POST['iname'];
	$description=$_POST['des'];
	$sellprice=$_POST['sprice'];
	$buyprice=$_POST['bprice'];
	$qty=$_POST['qty'];
	
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