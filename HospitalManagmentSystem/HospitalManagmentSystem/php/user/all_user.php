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

$stmt = $conn->prepare("select id,fullname,uname,utype from user order by id DESC");
$stmt->bind_result($id,$fullname,$uname,$utype);

if($stmt->execute())
{
	while($stmt->fetch())
	{
		$output[] = array("id"=>$id,"fullname"=>$fullname,"uname"=>$uname,"utype"=>$utype);
	}
	
	echo json_encode($output);
}
$stmt->close();

?>