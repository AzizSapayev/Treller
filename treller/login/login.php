<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);
	// admin ismi va paroli
	$adminname='azizbek';
	$adminpass=9024;

	if (empty($uname)) {
		header("Location: index.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: index.php?error=Password is required");
	    exit();
	}else{
        
		$sql = "SELECT * FROM users WHERE user_name='$uname' AND password='$pass'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			if ($uname==$adminname && $pass==$adminpass) 
			{
				header("Location: ../websayt.html");
				die();
			}else{
			$row = mysqli_fetch_assoc($result);
            if ($row['user_name'] === $uname && $row['password'] === $pass) {
            	$_SESSION['user_name'] = $row['user_name'];
            	$_SESSION['name'] = $row['name'];
            	$_SESSION['id'] = $row['id'];
            	header("Location: ../websayt.php");
		        exit();
            }else{
				header("Location: websayt.html?error=Incorect User name or password");
		        exit();
			}
		}
		}else{
			header("Location: websayt.html?error=Incorect User name or password");
	        exit();
		}
	}
	
}else{
	header("Location: ../websayt.php");
	exit();
}