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
	
	<title>Main page</title>
	
	<meta name="description" content="Personal Finances - the best way to manage and save your money" />
	<meta name="keywords" content="finances, personal, budget, money, wallet, save, incomes, expenses, manage" />
	
</head>

<body>

	Thank you for registration on out website! Now you can log in on your account!<br />  <br />
	 
	<a href="index.php">Log in on your account!</a>
	<br /> <br />
	
</body>
</html>