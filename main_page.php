<?php

session_start();
	
	if(!isset($_SESSION['loggedin']))
	{
		header ('Location: index.php');
		exit();
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
	
	<?php
	
	echo "<p>Hello " .$_SESSION['username'].'! [ <a href="logout.php" class="link">Log out!</a>]</p>';
	
	?>
		
			<a href="add_income.php" class="main_page">Add new income </a>
			<br /><br /> 

			<a href="add_expense.php" class="main_page">Add new expense</a>
			<br /><br /> 
	
			<a href="show_balance.php" class="main_page">Show the balance</a>
			<br /><br /> 
	
</body>
</html>