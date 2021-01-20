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
		
		echo $emailB;
		
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
				
				$ile_takich_maili = $result->num_rows;
				if($ile_takich_maili>0)
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
<html lang="pl">
<head>
	 <meta chatset="utf-8"/>
	 <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	 <title>Personal finanses - create your own account!</title>
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

	<form method="post">
	
		Login: <br /> <input type="text" value="<?php 
		if (isset($_SESSION['fr_login'])) 
		{ 
		  echo $_SESSION['fr_login'];
		  unset($_SESSION['fr_login']);
		}
		?>"
		name="login" /> <br />
		
		<?php
			if (isset($_SESSION['e_login']))
			{
				echo '<div class="error">'.$_SESSION['e_login'].'</div>';
				unset($_SESSION['e_login']);
			}
		?>
		
		E-mail: <br /> <input type="text" value="<?php 
		if (isset($_SESSION['fr_email'])) 
		{ 
		  echo $_SESSION['fr_email'];
		  unset($_SESSION['fr_email']);
		}
		?>
		"name="email" /> <br />
		
		 <?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
		
		Your password: <br /> <input type="password" value="<?php 
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
		
			Repeat password: <br /> <input type="password" value="<?php
			if (isset($_SESSION['fr_password2']))
			{
				echo $_SESSION['fr_password2'];
				unset($_SESSION['fr_password2']);
			}
		?>"name="password2" /><br />
		
		<label>
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
		
		  <div class="g-recaptcha" data-sitekey="6Leun-kZAAAAABcq3o2JqENw68xhnw5WAet3Y42d"></div>
		  
		 <?php
			if (isset($_SESSION['e_robot']))
			{
				echo '<div class="error">'.$_SESSION['e_robot'].'</div>';
				unset($_SESSION['e_robot']);
			}
		?>  <br />
		  
		  <input type="submit" value="SIgn Up" />
		  
	</form>

</body>
</html>