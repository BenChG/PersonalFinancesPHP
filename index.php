<?php

	session_start();
	
	if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true))
	{
		header('Location: main_page.php');
		exit();
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
	
	 <form action="login.php" method="post">
			Login:
			 <br/>
			<input type="text" name="login"/>
			<br/>
			Password:
			<br/>
			<input type="password" name="password"/>
		    <br/>
		
			</br>
		    <button type="submit">log in</button>
	 </form>
	 
	<?php
		if(isset($_SESSION['error'])) echo $_SESSION['error'];
	?>


	
</body>
</html>