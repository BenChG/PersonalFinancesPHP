<?php
	
	session_start();
	
	if (isset($_POST['email']))
	{
		//Success validation
		$all_right=true;
		
		$login = $_POST['login'];
		
		if ((strlen($login)<3) || (strlen($login)>20))
		{
			$all_right=false;
			$_SESSION['e_login']="login must have from 3 until 20 signs!";
		}
		
		if (ctype_alnum($login)==false)
		{
			$all_right=false;
			$_SESSION['e_login']="Login can include only letters and digits (without diacritic  letters)";
		}
		
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$all_right=false;
			$_SESSION['e_email']="Provide appropriate e-mail address!";
		}
		
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		if ((strlen($password1)<8) || (strlen($password1)>20))
		{
			$all_right=false;
			$_SESSION['e_password']="Password must have from 8 until 20 signs!";
		}
		
		if ($password1!=$password2)
		{
			$all_right=false;
			$_SESSION['e_password']="Provided passwords are not equal!";
		}
		
		$password_hash = password_hash($password1, PASSWORD_DEFAULT);
		
		if (!isset($_POST['terms']))
		{
			$all_right=false;
			$_SESSION['e_terms']="Confirm acceptance of terms!";
		}
		
		$secret = "6Leun-kZAAAAAB2LhQtNHPuEM3LcZpwrpmUQEeLL";
		
		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		
		$answer = json_decode($check);
		
		if ($answer->success==false)
		{
			$all_right=false;
			$_SESSION['e_robot']="Confirm, that you are not a robot!";
		}
		
		//Remember privided data
		$_SESSION['fr_login'] = $login;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_password1'] = $password1;
		$_SESSION['fr_password2'] = $password2;
		if (isset($_POST['terms'])) $_SESSION['fr_terms'] = true;
		
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
				$result = $connection->query("SELECT id FROM users WHERE email='$email'");
				
				if (!$result) throw new Exception($connection->error);
				
				$how_many_emails = $result->num_rows;
				if($how_many_emails>0)
				{
					$all_right=false;
					$_SESSION['e_email']="There is existing account for this e-mail addres in our database!";
				}
				
				$result = $connection->query("SELECT id FROM users WHERE username='$login'");
				
				if (!$result) throw new Exception($connection->error);
				
				$how_many_logins = $result->num_rows;
				if($how_many_logins>0)
				{
					$all_right=false;
					$_SESSION['e_login']="There is already user with privided login, please choose another one!";
				}
				
				if ($all_right==true)
				{
					//Great, all tests passed, we are adding now new user to our database!
					
					if ($connection->query("INSERT INTO users VALUES (NULL, '$login', '$password_hash', '$email')"))
					{	 
						$_SESSION['successful_registration']=true;
						header('Location: hello.php');
						$success=true;
						
						if($result = $connection->query("SELECT * FROM users WHERE username='$login'"))
						{
							$row = $result->fetch_assoc();
							$id = $row["id"];
							
							if ($connection->query("INSERT INTO payment_methods_assigned_to_users VALUES
							(NULL, '$id', 'Cash'), (NULL,'$id', 'Debit Card'), (NULL,'$id', 'Credit Card')"))
							{
								$_SESSION['successfully_added_defalut_incomes']=true;
							}
							
							else
							{ 
								$success=false; throw new Exception($connection->error);
							}
							
							if ($connection->query("INSERT INTO incomes_category_assigned_to_users VALUES
							(NULL, '$id', 'Salary'), (NULL,'$id', 'Interest'), (NULL,'$id', 'Allegro'), (NULL,'$id', 'Another')"))
							{
								$_SESSION['successfully_added_defalut_incomes']=true;
							}
							
							else
							{ 
								$success=false; throw new Exception($connection->error);
							}
							
							if ($connection->query("INSERT INTO expenses_category_assigned_to_users VALUES (NULL, '$id', 'Transport'), (NULL,'$id', 'Books'), (NULL,'$id', 'Food'), 
							(NULL,'$id', 'Apartments'),(NULL, '$id', 'Telecommunication'), (NULL,'$id', 'Health'), (NULL,'$id', 'Clothes'), (NULL,'$id', 'Hygiene'),(NULL, '$id', 'Kids'), (NULL,'$id', 'Recreation'), (NULL,'$id', 'Trip'), (NULL,'$id', 'Savings'),(NULL, '$id', 'For Retirement'), (NULL,'$id', 'Debt Repayment'), (NULL,'$id', 'Gift'), (NULL,'$id', 'Another')"))					
							{
								$_SESSION['successfully_added_defalut_expenses']=true;					
							}
							
							else
							{
								$success=false; throw new Exception($connection->error);
							}
						}
					}
					
					else
					{ 
						$success=false; throw new Exception($connection->error);
					}
					
				}
				
				else
				{
					throw new Exception($connection->error);
					$success=false;
				}
				
			}				
			
			$connection->close();	
		}
		
		catch(Exception $e)
		{
			echo '<span style="color:red;"> Server error! We appologize for the inconvenience and ask you to register another day!</span>';
			echo '<br />Developer information: '.$e;
		}
	}
	
?>

<!DOCTYPE HTML>
<html lang="pl">
	<head>
		<meta chatset="utf-8"/>
		<title>Personal finanses - create your own account!</title>
		<meta name="description" content="Personal Finances - the best way to manage and save your money" />
		<meta name="keywords" content="finances, personal, budget, money, wallet, save, incomes, expenses, manage" />
		<meta name="author" content="BCG">
		
		<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
		
		<link rel="stylesheet" href="main.css">
		
		<link href "https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Lato&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="css/fontello.css" type="text/css" />
		
		<script src="https://www.google.com/recaptcha/api.js"></script>
		
		
		
		
		<style>
			.error
			{
			color:red;
			margin-top: 10px;
			margin-robottom: 10px;
			}
		</style>
		
	</head>
	
	<body>
		
		<div id="container"style="margin-top:120px;">
			
			<div class="header">
				Personal Finances
			</div>	
			
			<form method="post">
				<div class="tile_left">
					
					
					<input type="text" placeholder="login" 
					onfocus="this.placeholder=''" onblur="this.placeholder='login'" 
					value="<?php 
						if (isset($_SESSION['fr_login'])) 
						{ 
							echo $_SESSION['fr_login'];
							unset($_SESSION['fr_login']);
						}
					?>"name="login" /> <br />
					
					<?php
						if (isset($_SESSION['e_login']))
						{
							echo '<div class="error">'.$_SESSION['e_login'].'</div>';
							unset($_SESSION['e_login']);
						}
					?>
					
					<input type="password" placeholder="password" 
					onfocus="this.placeholder=''" onblur="this.placeholder='password'"
					value="<?php 
						if (isset($_SESSION['fr_password1'])) 
						{ 
							echo $_SESSION['fr_password1'];
							unset($_SESSION['fr_password1']);
						}
					?>"name="password1" /> <br />
					
					<?php
						if (isset($_SESSION['e_password']))
						{
							echo '<div class="error">'.$_SESSION['e_password'].'</div>';
							unset($_SESSION['e_password']);
						}		
					?>
					
					<input type="password" placeholder="password" 
					onfocus="this.placeholder=''" onblur="this.placeholder='password'"
					value="<?php
						if (isset($_SESSION['fr_password2']))
						{
							echo $_SESSION['fr_password2'];
							unset($_SESSION['fr_password2']);
						}
					?>"name="password2" /><br />
					
					<input type="submit" value="Sign up"/>
					
					
				</div>
				
				<div class="tile_right">
					<div class="tile_icon">
						<a href="index.html" target="_blank" class="link">
							<i class="icon-home"></br>Home</i>
						</a>	
					</div>
					
					<div style="margin-top:10px;">
						
						<input type="text" placeholder="e-mail" 
						onfocus="this.placeholder=''" onblur="this.placeholder='e-mail'"
						value="<?php 
							if (isset($_SESSION['fr_email'])) 
							{ 
								echo $_SESSION['fr_email'];
								unset($_SESSION['fr_email']);
							}
						?>"name="email" /> <br />
						
						<?php
							if (isset($_SESSION['e_email']))
							{
								echo '<div class="error">'.$_SESSION['e_email'].'</div>';
								unset($_SESSION['e_email']);
							}
						?>
					</div>
					
					
				</div>
				
				<div style="clear:both;"></div>
				
				<div class="long_tile">	
					
					</br>
					
					<label style="font-size: 16px;border: 2px solid white; padding: 10px;">
						<input type="checkbox" name="terms" <?php
							if (isset($_SESSION['fr_terms']))
							{
								echo "checked";
								unset($_SESSION['fr_terms']);
							}
						?>/> Acceptance of terms
					</label>
					
					<?php
						if (isset($_SESSION['e_terms']))
						{
							echo '<div class="error">'.$_SESSION['e_terms'].'</div>';
							unset($_SESSION['e_terms']);
						}
					?>
					<br/><br>
					
					<div style="text-align: center;">
						
						<div class="g-recaptcha" data-theme="light" data-sitekey="6Leun-kZAAAAABcq3o2JqENw68xhnw5WAet3Y42d" style="transform:scale(1.00);-webkit-transform:scale(1.00);transform-origin:0 0;-webkit-transform-origin:0 0;display: inline-block;"></div>
						
						<?php
							if (isset($_SESSION['e_robot']))
							{
								echo '<div class="error">'.$_SESSION['e_robot'].'</div>';
								unset($_SESSION['e_robot']);
							}
						?>  
					</div>
					
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