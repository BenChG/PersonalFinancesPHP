<!DOCTYPE HTML>
<html lang="en">
	<head>
		
		<meta charset="utf-8">
		<title>Show the balance</title>
		<meta name="description" content="Personal Finances - the best way to manage and save your money" />
		<meta name="keywords" content="finances, personal, budget, money, wallet, save, incomes, expenses, manage" />
		<meta name="author" content="BCG">
		<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
		<link rel="stylesheet" href="main.css" type="text/css" />
		<link href "https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Lato&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="css/fontello.css" type="text/css" />
		
	</head>
	
	<body>
		
		<div id="container_balance">
			
			<div class="tile_icon_balance">
				<a href="logout.php" class="link" title="Log out"><i class="icon-logout"></i></a>	
			</div>
			
			<div class="tile_icon_balance">
				<a href="main_page.php" class="link" title="Go back to Main Page"><i class="icon-home2"></i></a>	
			</div>
			
			<div class="header">
				Personal budget
			</div>
			
			<?php
				
				global $SumOfIncomes;
				global $SumOfExpenses;				
				$start= date("Y-m-01");
				$end = date("Y-m-t");
				
				session_start();
				
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
						
						if($result = $connection->query("SELECT * FROM incomes WHERE user_id='$id' AND date_of_income BETWEEN '$start' AND '$end'"))
						{
							echo "<div class='header_income' style='margin-bottom:5px;'> List of incomes:"."</div>"; 
							echo "<table>
							<tr>
							<th>Id</th>
							<th>Date</th>	
							<th>Amount</th>			
							<th>Category</th>
							<th>Comments</th>
							</tr>";
							
							while ($row = mysqli_fetch_array($result))
							{
								$categoryId = $row['income_category_assigned_to_user_id'];
								
								if ($resultCategoryName = $connection->query("SELECT name FROM incomes_category_assigned_to_users WHERE id='$categoryId'"))
								{
									$rowCategoryName = $resultCategoryName->fetch_assoc();
									$incomeCategory = $rowCategoryName ["name"];	
								}
								
								else
								{ 
									throw new Exception($connection->error);
								}	
								
								echo "<tr>";
								echo "<td>" . $row['id'] . "</td>";
								echo "<td>" . $row['date_of_income'] . "</td>";		
								echo "<td>" . $row['amount'] . " $</td>";				
								echo "<td>" . "$incomeCategory". "</td>";
								echo "<td>" . $row['income_comment'] . "</td>";
								echo "</tr>";		
								$SumOfIncomes = $SumOfIncomes + $row['amount'];
							}
							
							echo "<tr>".'<td colspan="5"><div class="sumOf">Sum of incomes: '.number_format($SumOfIncomes,2)." $</div></td></tr>";
							echo "</table><div style='margin-top: 10px;'</div>";	
						}	
						else
						{ 
							throw new Exception($connection->error);
						}
						
						if($result = $connection->query("SELECT * FROM expenses WHERE user_id='$id' AND date_of_expense BETWEEN '$start' AND '$end'"))
						{
							echo "<div class='header_expense' style='margin-bottom:5px;'>List of expenses:"."</div>"; 
							echo "<table>
							<tr>
							<th>Id</th>
							<th>Date</th>	
							<th>Amount</th>			
							<th>Category</th>
							<th>Payment Method</th>
							<th>Comments</th>
							</tr>";
							
							while ($row = mysqli_fetch_array($result))
							{
								$categoryId = $row['expense_category_assigned_to_user_id'];
								
								if ($resultCategoryName = $connection->query("SELECT name FROM expenses_category_assigned_to_users WHERE id='$categoryId'"))
								{
									$rowCategoryName = $resultCategoryName->fetch_assoc();
									$expenseCategory = $rowCategoryName ["name"];	
								}
								
								else
								{ 
									throw new Exception($connection->error);
								}	
								
								$paymentId = $row['payment_method_assigned_to_user_id'];
								
								if ($resultPaymentMethod = $connection->query("SELECT name FROM payment_methods_assigned_to_users WHERE id='$paymentId'"))
								{
									$rowPaymentMethod = $resultPaymentMethod->fetch_assoc();
									$paymentMethod = $rowPaymentMethod ["name"];	
								}
								
								else
								{ 
									throw new Exception($connection->error);
								}	
								
								echo "<tr>";
								echo "<td>" . $row['id'] . "</td>";
								echo "<td>" . $row['date_of_expense'] . "</td>";		
								echo "<td>" . $row['amount'] . " $</td>";				
								echo "<td>" . "$expenseCategory" . "</td>";
								echo "<td>" .  "$paymentMethod". "</td>";				  
								echo "<td>" . $row['expense_comment'] . "</td>";
								echo "</tr>";	
								$SumOfExpenses = $SumOfExpenses + $row['amount'];
							}
							echo "<tr>".'<td colspan="6"><div class="sumOf">Sum of expenses: '.number_format($SumOfExpenses,2)." $</div></td></tr>";
							echo "</table>";	
												
							$Balance = $SumOfIncomes-$SumOfExpenses;
														
							echo "<div class='total_balance'>Total balance: ".number_format($Balance,2)." $ </div>";
						}
											
						else
						{ 
							throw new Exception($connection->error);
						}				
						
					}
					
					$connection->close();	
				}
				
				catch(Exception $e)
				{
					echo '<span style="color:red;"> Server error! We appologize for the inconvenience and ask you to register another day!</span>';
					echo '<br />Developer information: '.$e;
				}
				
			?>
			
		</div>
		
	</body>
</html>