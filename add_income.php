<?php
	
	session_start();
	
	if (isset($_POST['incomeCategory']))
	{
		
		$incomeCategory = $_POST['incomeCategory'];
		$incomeDate = $_POST['incomeDate'];
		$incomeAmount = $_POST['incomeAmount'];
		$incomeComments = $_POST['incomeComments'];
		$id = 	$_SESSION['id'];
		
 		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}		
			
			else
			{
				if($result = $connection->query("SELECT id FROM incomes_category_assigned_to_users WHERE user_id='$id' AND name='$incomeCategory'"))
				{
					$row = $result->fetch_assoc();
					$incomeCategoryId = $row["id"];	
					
					if ($connection->query("INSERT INTO incomes VALUES 
					(NULL, '$id', '$incomeCategoryId', '$incomeAmount', '$incomeDate', '$incomeComments')"))
					{	
						$_SESSION['type']="income";
						header('Location: add.php');
					}
					
					else
					{ 
						throw new Exception($connection->error);
					}
					
				}	
				$connection->close();	
			}
		}
		
		
		catch(Exception $e)
		{
			echo '<span style="color:red;"> Server error! We appologize for the inconvenience and ask you to register another day!</span>';
			echo '<br />Developer information: '.$e;
		}
		
		
	}
?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		
		<meta charset="utf-8">
		<title>Add income</title>
		<meta name="description" content="Personal Finanes">
		<meta name="keywords" content="finances, personal finances, budget, personal budget, income, outcome">
		<meta name="author" content="BCG">
		<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
		<link rel="stylesheet" href="main.css">
		<link href "https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Lato&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="css/fontello.css" type="text/css" />
		
	</head>
	
	
	<body>
		
		
		<div id="container"style="margin-top:120px;">
			
			<div class="tile_icon_balance">
				<a href="main_page.php" class="link"><i class="icon-undo2"></i></a>	
			</div>
			
			<div class="header_main_menu">
				Personal Finances 
			</div>
			
			<div style="clear:both;"></div>	
			
			<div class="transaction" style="background-color: #33CC33;"> 
				Add new income.
			</div>
			
			<div class="long_tile">	
				<div id="additional"> <i> Fill in all below information </i> </div>		
			</div>		
			
			<form action="add_income.php" method="post">	
				<div class="radio">	
					
					Select income category:</br>
					<div style="margin-top:10px;">
						<input type="radio" name="incomeCategory" value="Salary"> Salary
						<input type="radio" name="incomeCategory" value="Intrest"> Intrest
						<input type="radio" name="incomeCategory" value="Allegro"> Allegro
						<input type="radio" name="incomeCategory" value="Another"> Another
						</br>
					</div>
					
				</div>
				
				
				<div class="tile_left" style="margin-bottom: 0px;">
					
					
					<input type="number" name="incomeAmount" placeholder="Amount" step="any">
					</br>
					<input type="submit" value="Add new income">
					
				</div>
				
				<div class="tile_right" style="margin-bottom: 0px;">
					
					<input type="date" name="incomeDate" placeholder="Transaction date">
					</br>
					<input type="text" name="incomeComments" placeholder="Comments">
					
				</div>
				<div style="clear:both;"></div>
				
			</form>
			
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
					2020 &copy; Personal Finances  
					</br> 
					by Benedykt Chałubiński-Gonerko	
				</div>
			</div>
			
		</div>		
		
	</footer>  
	
</html>