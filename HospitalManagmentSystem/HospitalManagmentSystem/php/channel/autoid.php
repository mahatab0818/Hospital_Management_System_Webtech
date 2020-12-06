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

$query = "select MAX(cast(chno as decimal)) id from channel";

if($result = mysqli_query($conn,$query))
{
	
	$row = mysqli_fetch_assoc($result);
	$count = $row['id'];
	$count = $count + 1;
	$codeno = str_pad($count,4,"0",STR_PAD_LEFT);
	echo json_encode($codeno);
}




?>