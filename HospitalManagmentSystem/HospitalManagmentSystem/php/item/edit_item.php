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
	$stmt = $conn->prepare("update item set itemname = ?,description= ?,sellprice= ?,buyprice= ?,qty= ? where id= ? ");
	$stmt->bind_param("ssssss",$itemname,$description,$sellprice,$buyprice,$qty,$id);
	
	
	$itemname=$_POST['iname'];
	$description=$_POST['des'];
	$sellprice=$_POST['sprice'];
	$buyprice=$_POST['bprice'];
	$qty=$_POST['qty'];
	$id=$_POST['item_id'];
	
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