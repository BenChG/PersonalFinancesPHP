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
		
		<meta charset="utf-8">
		<title>Main Page</title>
		<meta name="description" content="Personal Finances - the best way to manage and save your money" />
		<meta name="keywords" content="finances, personal, budget, money, wallet, save, incomes, expenses, manage" />
		<meta name="author" content="BCG">
		<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
		<link rel="stylesheet" href="main.css" type="text/css" />
		<link href "https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Lato&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="css/fontello.css" type="text/css" />
		
	</head>
	
	<body>
	
		<?php
	
	echo "<p>Hello " .$_SESSION['username'].'! [ <a href="logout.php" class="link">Log out!</a>]</p>';
	
	?>
		
		<div id="container">
			
			<div class="tile_icon_balance">
				<a href="index.html" class="link"><i class="icon-home2"></i></a>	
			</div>
			
			<div class="header_main_menu">
				Personal Finances 
			</div>
			
			<div style="margin-left:-6px;">	
				<div class="tile_menu">	
					
					<div class="tile_icon_menu" style="background-color: #33CC33;">	
						<a href="add_income.php" class="link"><i class="icon-list-add"></br><h1>Add new income</h1></i></a>	
					</div>	
					
				</div>	
			</div>
			
			<div class="tile_menu">
				<div class="tile_icon_menu" style="background-color: #FF3333;">	
					<a href="add_expense.php" class="link"><i class="icon-list-add"></br><h1>Add new expense</h1></i></a>
				</div>
			</div>		
			
			<div class="tile_menu">
				<div class="tile_icon_menu"style="background-color: #7D3C98;" >	
					<a href="password.php" class="link"><i class="icon-key"></br><h1>Change Password</h1></i></a>
				</div>
			</div>		
			
			<div style="margin-left:-6px;">
				<div class="tile_menu">	
					<div class="tile_icon_menu" style="background-color:#D35400;">	
						<a href="show_balance.php" class="link"><i class="icon-balance-scale"></br><h1>Current month</h1></i></a>	
					</div>	
				</div>	
			</div>	
			
			<div class="tile_menu">
				<div class="tile_icon_menu" style="background-color:#707B7C">
					<a href="show_balance.php" class="link"><i class="icon-balance-scale"></br><h1>Previous month</h1></i></a>
				</div>
			</div>		
			
			<div class="tile_menu">
				<div class="tile_icon_menu" style="background-color:#2E86C1;">	
					<a href="show_balance.php" class="link"><i class="icon-balance-scale"></br><h1>Selected period</h1></i></a>
				</div>
			</div>		
			
			<div style="clear:both;"></div>		
			
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
					2020 &copy;  Personal Finances  
					</br> 
					by Benedykt Chałubiński-Gonerko	
				</div>
			</div>
			
		</div>		
		
	</footer>  
	
</html>