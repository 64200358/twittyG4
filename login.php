<!--
//login.php
!-->


<?php

include('database_connection.php');

session_start();

$message = '';

if(isset($_SESSION['user_id']))
{
	header('location:index.php');
}

if(isset($_POST["login"]))
{
	$query = "
	SELECT * FROM tbl_twitter_user 
  		WHERE username = :username
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
	    	':username' => $_POST["username"]
	   	)
	);
	$count = $statement->rowCount();
	if($count > 0)
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			if(password_verify($_POST['password'], $row['password']))
			{
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['username'] = $row['username'];
				header('location:index.php');
			}
			else
			{
				$message = '<label>Wrong Password</label>';
			}
		}
	}
	else
	{
		$message = '<label>Wrong Username</labe>';
	}
}


?>

<html>  
    <head>  
        <title>Twitty </title>  
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>  <body style="background-color:DarkSlateGrey;">
        <div class="container">
			<br />
			
			<p><strong><h1 class="mt-4"  align="center"><font color="GhostWhite">Twitty  </font></a></h1><br /></strong></p>
			<br />
			<div class="panel panel-default">
		
			<p><strong><div class="panel-heading">เข้าสู่ระบบ</div></strong></p>
				<div class="panel-body">
					<form method="post">
						<p class="text-danger"><?php echo $message; ?></p>
						<div class="form-group">
							<label>Enter Username</label>
							<input type="text" name="username" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Enter Password</label>
							<input type="password" name="password" class="form-control" required />
						</div>
						<div class="form-group">
							<input type="submit" name="login" class="btn btn-info" value="Login" />
						</div>
						
						<p>ยังไม่เป็นสมาชิกใช่ไหม คลิ๊กที่นี่เพื่อ	<a href="register.php">สมัครสมาชิก</a></p>
						
					</form>
				</div>
			</div>
		</div>
    </body>  
</html>
