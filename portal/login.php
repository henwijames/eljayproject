<?php 
session_start(); 
include "../functions/conn.php";

if (isset($_POST['username'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$username = validate($_POST['username']);


	if (empty($username)) {
		header("Location: index.php?error=QR CODE is required");
	    exit();
	}else{
		$sql = "SELECT * FROM users WHERE username='$username'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['username'] === $username) {
            	$_SESSION['username'] = $row['username'];
            	$_SESSION['id'] = $row['id'];
            	header("Location: ../student/yearbook.php");
		        exit();
            }else{
				header("Location: index.php?error=INCORRECT QR CODE");
		        exit();
			}
		}else{
			header("Location: index.php?error=INCORRECT QR CODE");
	        exit();
		}
	}
	
}else{
	header("Location: index.php");
	exit();
}