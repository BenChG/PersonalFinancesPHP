<?php
	
	session_start();
	
	if (isset($_SESSION['success_registration']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['success_registration']);
	}
	
?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" href="main.css" type="text/css" />
		
		<title>Main page</title>
		
		<meta name="description" content="Personal Finances - the best way to manage and save your money" />
		<meta name="keywords" content="finances, personal, budget, money, wallet, save, incomes, expenses, manage" />
		
	</head>
	
	<body>
		
		Thank you for registration on out website! Now you can log in on your account!<br />  
		<a href="index.php" class="link">Log in on your account!</a>
		<br /> <br />
		
		<h5> Additional information: </br> 
	    We have added default categories of payment, incomes, expenses to your account!</h5><br />
		
		
	</body>
</html>