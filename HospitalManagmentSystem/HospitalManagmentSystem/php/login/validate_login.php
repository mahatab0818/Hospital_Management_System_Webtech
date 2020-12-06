<?php

    $servername ="localhost";
    $username ="root";
    $password="";
    $dbname ="amrhospital";
    $conn= new mysqli($servername,$username,$password,$dbname);

    

    if($conn->connect_error)
    {
        die("connection failed -validate_login.php". $conn->connect_error);
    }

    if($_SERVER['REQUEST_METHOD']=='POST')
    {

        session_start();
        $username= $_POST['username'];
        $password= md5($_POST['password']);
        $usertype= $_POST['utype'];
        $id;
        $stmt = $conn->prepare("select id,uname,password,utype from user where uname= ? and password = ? and utype=?");
        $stmt->bind_param("sss",$username,$password,$usertype);
        $stmt->execute();
		$stmt->store_result();
        $stmt->bind_result($id,$uname,$password,$utype);
        $stmt->fetch();

    if($stmt->num_rows ==1)
    {
        $_SESSION["isLogin"] = true;
        $_SESSION["utype"] = $utype;
        $_SESSION["id"] = $id;
        $_SESSION["uname"] = $uname;
        echo 1;



    }
    else{
        echo 3;

    }
    $stmt->close();



    }

?>