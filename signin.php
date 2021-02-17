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
		
		<meta charset="utf-8">
		<title>Personal Finances</title>
		<meta name="description" content="Personal Finances - the best way to manage and save your money" />
		<meta name="keywords" content="finances, personal, budget, money, wallet, save, incomes, expenses, manage" />
		<meta name="author" content="BCG">
		<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
		<link rel="stylesheet" href="main.css">
		<link href "https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Lato&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="css/fontello.css" type="text/css" />
		
	</head>
	
	<body>
		
		<div id="container">
			
			<div class="header">
				Personal Budget
			</div>	
			
			<div class="tile_left">
				<form action="login.php" method="post">	
					<input type="text" name="login" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'">
					</br>
					<input type="password" name="password" placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'">
					</br>
					<input type="submit" value="Sign in">		
				</form>
			</div>
			
			<div class="tile_right">
				<div class="tile_icon">
					<a href="index.php" target="_blank" class="link">
						<i class="icon-home"></br>Home</i>
					</a>	
				</div>
			</div>	
			
			<div style="clear:both;"></div>
			
			<?php
				if(isset($_SESSION['error'])) echo $_SESSION['error'];
			?>
			
		</body>
		
		<footer>
			
			<div class="long_tile">	
				<div id="email"> Contact me via mail:  
					<a href="mailto:ben.chalubinski@gmail.com target="_blank" class="link">
						<i class="icon-mail"></i> 
					</a>			
				</div>
			</div>
			
			<div class="long_tile">	
				<div id="rights">
					2021 &copy; Personal Finances  
					</br> by Benedykt Chałubiński-Gonerko	
				</div>
			</div>
			
		</div>		
		
	</footer>  
	
</html>