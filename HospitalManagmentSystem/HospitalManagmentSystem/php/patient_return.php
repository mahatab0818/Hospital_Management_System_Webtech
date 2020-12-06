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

$stmt = $conn->prepare("select patientno,name,phone,address from patient where patientno = ? ");
$stmt->bind_param("s",$patientno); 
$patientno = $_POST['patient_id'];
$stmt->bind_result($patientno,$name,$phone,$address);

if($stmt->execute())
{
	while($stmt->fetch())
	{
		$output = array("patientno"=>$patientno,"name"=>$name,"phone"=>$phone,"address"=>$address);
	}
	
	echo json_encode($output);
}
$stmt->close();

?>