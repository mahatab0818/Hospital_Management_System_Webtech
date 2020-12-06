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

$stmt = $conn->prepare("select chno,docno,pno,rno,date from channel where chno = ? ");
$stmt->bind_param("s",$chno); 
$chno=$_POST['channel_id'];
$stmt->bind_result($chno,$docno,$pno,$rno,$date);

if($stmt->execute())
{
	while($stmt->fetch())
	{
		$output = array("chno"=>$chno,"docno"=>$docno,"pno"=>$pno,"rno"=>$rno,"date"=>$date);
	}
	
	echo json_encode($output);
}
$stmt->close();

?>