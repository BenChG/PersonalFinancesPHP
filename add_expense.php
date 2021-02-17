<?php
	session_start();
	
	if (isset($_POST['expenseCategory']))
	{
		
		$expenseCategory = $_POST['expenseCategory'];
		$paymentMethod = $_POST['paymentMethod'];
		$expenseDate = $_POST['expenseDate'];
		$expenseAmount = $_POST['expenseAmount'];
		$expenseComments = $_POST['expenseComments'];
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
				if($result = $connection->query("SELECT id FROM expenses_category_assigned_to_users WHERE user_id='$id' AND name='$expenseCategory'"))
				{
					$row = $result->fetch_assoc();
					$expenseCategoryId = $row["id"];	
					
					if($result = $connection->query("SELECT id FROM payment_methods_assigned_to_users WHERE user_id='$id' AND name='$paymentMethod'"))
					{
						$row = $result->fetch_assoc();
						$paymentMethodId = $row["id"];
						
						
						if ($connection->query("INSERT INTO expenses VALUES 
						(NULL, '$id', '$expenseCategoryId', '$paymentMethodId' ,'$expenseAmount', '$expenseDate','$expenseComments')"))
						{	
							$_SESSION['type']="expense";
							header('Location: add.php');
						}
						
						else
						{ 
							throw new Exception($connection->error);
						}
						
						
					}
					
					else
					{ 
						throw new Exception($connection->error);
					}
					
				}
				
				else
				{ 
					throw new Exception($connection->error);
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
		<title>Add expense</title>
		<meta name="description" content="Personal Finanes">
		<meta name="keywords" content="finances, personal finances, budget, personal budget, income, outcome">
		<meta name="author" content="BCG">
		<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
		<link rel="stylesheet" href="main.css">
		<link href "https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Lato&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="css/fontello.css" type="text/css" />
		
	</head>
	
	<body>
		<body>
			
			
			<div id="container"style="margin-top:120px;">
				
				<div>
					
					<div class="tile_icon_balance">
						<a href="main_page.php" class="link"><i class="icon-undo2"></i></a>	
					</div>
					
					<div class="header_main_menu">
						Personal Finances 
					</div>
					
					<div style="clear:both;"></div>		
					
				</div>
				
				<div class="transaction" style="background-color: #33CC33;"> 
					Add new income.
				</div>
				
				<div class="long_tile">	
					<div id="additional"> <i> Select expense category: </i> </div>		
				</div>		
				
				<form action="add_expense.php" method="post">	
					
					<div class="radio_category"style="border-left:2px solid #C0C0C0;">							
						<input type="radio" name="expenseCategory" value="Transport"> Transport 
						</br>
						<input type="radio" name="expenseCategory" value="Book"> Book
						</br>
						<input type="radio" name="expenseCategory" value="Food"> Food
						</br>
						<input type="radio" name="expenseCategory" value="Apartments"> Apartments 
						</br>
						<input type="radio" name="expenseCategory" value="Telecommunication"> Telecommunication
						</br>
						<input type="radio" name="expenseCategory" value="Health"> Health
						</br>
						<input type="radio" name="expenseCategory" value="Cothes"> Cothes
						</br>
						<input type="radio" name="expenseCategory" value="Hygiene"> Hygiene
					</div>
					
					<div class="radio_category" style="border-right:2px solid #C0C0C0;">	
						<input type="radio" name="expenseCategory" value="Kids"> Kids 
						</br>
						<input type="radio" name="expenseCategory" value="Recreation"> Recreation 
						</br>
						<input type="radio" name="expenseCategory" value="Trip"> Trip 
						</br>
						<input type="radio" name="expenseCategory" value="Savings"> Savings 
						</br>
						<input type="radio" name="expenseCategory" value="For Retirement"> For Retirement 
						</br>
						<input type="radio" name="expenseCategory" value="Debt Repayment"> Debt Repayment 
						</br>
						<input type="radio" name="expenseCategory" value="Gift"> Gift 
						</br>
						<input type="radio" name="expenseCategory" value="Another"> Another  
					</div>
					
							<div style="clear:both;"></div>
					
							<div class="radio">	
							Select payment method: </br>
							<div style="margin-top:10px;">	
								<input type="radio" name="paymentMethod" value="Cash"> Cash 
								<input type="radio" name="paymentMethod" value="Debit Card"> Debit Card 
								<input type="radio" name="paymentMethod" value="Credit Card"> Credit Card 
								</br>
							</div>
						</div>
					
					<div class="tile_left" style="margin-bottom: 0px;">
					
						<input type="number" name="expenseAmount" placeholder="Amount" step="any">
						</br>
						<input type="submit" value="Add new expense">
						
					</div>
					
					<div class="tile_right" style="margin-bottom: 0px;">
		
						<input type="date" name="expenseDate" placeholder="Transaction date">
						</br>
						<input type="text" name="expenseComments" placeholder="Comments">
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
						2021 &copy; Personal Finances  
						</br>
						by Benedykt Chałubiński-Gonerko	
					</div>
				</div>
				
			</div>		
			
		</footer>  
		
	</html>				