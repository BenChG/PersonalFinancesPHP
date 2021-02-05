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
		
		<b> Personal finances </b> - your money will not be wasted anymore!!! <br />  <br />
		
		<?php
			
			global $SumOfIncomes;
			global $SumOfExpenses;
			
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
					
					if($result = $connection->query("SELECT * FROM incomes WHERE user_id='$id'"))
					{
						echo "List of incomes:"."<br/>"; 
						echo "<table border='1', bordercolor='green'>
						<tr>
						<th>Id</th>
						<th>Date</th>	
						<th>Amount</th>			
						<th>Category</th>
						<th>Comments</th>
						</tr>";
						
						while ($row = mysqli_fetch_array($result))
						{
							echo "<tr>";
							echo "<td>" . $row['id'] . "</td>";
							echo "<td>" . $row['date_of_income'] . "</td>";		
							echo "<td>" . $row['amount'] . " $</td>";				
							echo "<td>" . $row['income_category_assigned_to_user_id'] . "</td>";
							echo "<td>" . $row['income_comment'] . "</td>";
							echo "</tr>";		
							$SumOfIncomes = $SumOfIncomes + $row['amount'];
						}
							
						echo "<tr>".'<td colspan="5">Sum of incomes: '.number_format($SumOfIncomes,2)." $</td></tr>";
						echo "</table></br>";	
					}	
					else
					{ 
						throw new Exception($connection->error);
					}
					
					if($result = $connection->query("SELECT * FROM expenses WHERE user_id='$id'"))
					{
						echo "List of expenses:"."<br/>"; 
						echo "<table border='1', bordercolor='red'>
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
							echo "<tr>";
							echo "<td>" . $row['id'] . "</td>";
							echo "<td>" . $row['date_of_expense'] . "</td>";		
							echo "<td>" . $row['amount'] . " $</td>";				
							echo "<td>" . $row['expense_category_assigned_to_user_id'] . "</td>";
							echo "<td>" . $row['payment_method_assigned_to_user_id'] . "</td>";				  
							echo "<td>" . $row['expense_comment'] . "</td>";
							echo "</tr>";	
							$SumOfExpenses = $SumOfExpenses + $row['amount'];
						}
					    echo "<tr>".'<td colspan="6">Sum of expenses: '.number_format($SumOfExpenses,2)." $</td></tr>";
						echo "</table></br>";	
						
					
						$Balance = $SumOfIncomes-$SumOfExpenses;
					
						
						echo "<b> Total balance: ".number_format($Balance,2)." $ </b>";
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
		
	</body>
</html>