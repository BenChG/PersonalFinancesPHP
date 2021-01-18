<?php

session_start();

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
	
	<?php
	
	echo "<p>ID  ".$_SESSION['id']."!";
	echo "<p>Witaj  ".$_SESSION['username']."!";
	echo "<p>Hasło  ".$_SESSION['password']."!";
	echo "<p>e-mail  ".$_SESSION['email']."!";
	
	?>
	
</body>
</html>