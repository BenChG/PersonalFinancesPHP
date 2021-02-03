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
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Main page</title>
	
	<meta name="description" content="Personal Finances - the best way to manage and save your money" />
	<meta name="keywords" content="finances, personal, budget, money, wallet, save, incomes, expenses, manage" />
	
</head>

<body>

	 <b> Personal finances </b> - your money will not be wasted anymore!!! <br />  <br />

	<form action="add_income.php" method="post">
		 Select income category:</br>
		 <input type="radio" name="incomeCategory" value="Salary">
		 <label for="Salary">Salary</label></br>
	     <input type="radio" name="incomeCategory" value="Intrest">
	     <label for="Intrest"> Intrest</label></br>		
		 <input type="radio" name="incomeCategory" value="Allegro">
		 <label for="Allegro">Allegro</label></br>
		 <input type="radio" name="incomeCategory" value="Another">
		 <label for="Another"> Another</label></br>
		 
		 <label> Transaction date <input type="date" name="incomeDate"></label></br></br>
		 
		 <label> Amount <input type="number" name="incomeAmount" step="any"/></label></br></br>
		 
		 <label> Comments <input type="text" name="incomeComments"></label></br></br>
		 
		<input type="submit" value="Add new income">
	</form>
	
</body>
</html>