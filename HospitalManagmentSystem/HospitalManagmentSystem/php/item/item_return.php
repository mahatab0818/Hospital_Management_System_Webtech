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

$stmt = $conn->prepare("select id,itemname,description,sellprice,buyprice,qty from item where id = ? ");
$stmt->bind_param("s",$id); 
$id=$_POST['item_id'];
$stmt->bind_result($id,$itemname,$description,$sellprice,$buyprice,$qty);

if($stmt->execute())
{
	while($stmt->fetch())
	{
		$output = array("id"=>$id,"itemname"=>$itemname,"description"=>$description,"sellprice"=>$sellprice,"buyprice"=>$buyprice,"qty"=>$qty);
	}
	
	echo json_encode($output);
}
$stmt->close();

?>