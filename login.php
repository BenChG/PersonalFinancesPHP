<?php

session_start();
	
require_once "connect.php";

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		$login= $_POST['login'];
		$password = $_POST['password'];
		
		$sql = "SELECT * FROM users WHERE username = '$login' AND password = '$password'";
		
		if ($result =@$connection->query($sql))
		{
			$how_many_users = $result->num_rows;
			if ($how_many_users>0)
			{
				$row = $result->fetch_assoc();
				$_SESSION['id']  = $row['id'];
				$_SESSION['username']  = $row['username'];
				$_SESSION['password']  = $row['password'];
				$_SESSION['email']  = $row['email'];
				
				$result->free_result();
				header('Location: main_page.php');
				
			} else {
				
				
				
			}
	
		echo "It works";
		
		$connection->close();
	}
	}

?>