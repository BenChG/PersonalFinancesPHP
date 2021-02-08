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
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" href="main.css" type="text/css" />
		
		<title>Main page</title>
		
		<meta name="description" content="Personal Finances - the best way to manage and save your money" />
		<meta name="keywords" content="finances, personal, budget, money, wallet, save, expenses, expenses, manage" />
		
	</head>
	
	<body>
		
		<b> Personal finances </b> - your money will not be wasted anymore!!! <br />  <br />
		
		<form action="add_expense.php" method="post">
			Select expense category:</br>
			<input type="radio" name="expenseCategory" value="Transport"> Transport </br>
			<input type="radio" name="expenseCategory" value="Books"> Books </br>
			<input type="radio" name="expenseCategory" value="Food"> Food </br>
			<input type="radio" name="expenseCategory" value="Apartments"> Apartments </br>
			<input type="radio" name="expenseCategory" value="Telecommunication"> Telecommunication </br>
			<input type="radio" name="expenseCategory" value="Health"> Health </br>
			<input type="radio" name="expenseCategory" value="Clothes"> Clothes </br>
			<input type="radio" name="expenseCategory" value="Hygiene"> Hygiene </br>
			<input type="radio" name="expenseCategory" value="Kids"> Kids </br>
			<input type="radio" name="expenseCategory" value="Recreation"> Recreation </br>	
			<input type="radio" name="expenseCategory" value="Trip"> Trip </br>
			<input type="radio" name="expenseCategory" value="Savings"> Savings </br>
			<input type="radio" name="expenseCategory" value="For Retirement"> For Retirement </br>
			<input type="radio" name="expenseCategory" value="Debt Repayment"> Debt Repayment </br>
			<input type="radio" name="expenseCategory" value="Gift"> Gift </br>
			<input type="radio" name="expenseCategory" value="Another"> Another </br> </br>
			
			Select payment method:</br>
			<input type="radio" name="paymentMethod" value="Cash"> Cash </br>
			<input type="radio" name="paymentMethod" value="Debit Card"> Debit Card </br>
			<input type="radio" name="paymentMethod" value="Credit Card"> Credit Card </br></br>
			
			<label> Transaction date <input type="date" name="expenseDate"></label></br></br>
			
			<label> Amount <input type="number" name="expenseAmount" step="any"/></label></br></br>
			
			<label> Comments <input type="text" name="expenseComments"></label></br></br>
			
			<input type="submit" value="Add new expense">
		</form>
		
	</body>
</html>