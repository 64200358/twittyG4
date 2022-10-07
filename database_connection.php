<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");





function Get_user_name($connect, $user_id)
{
	$query = "
	SELECT username FROM tbl_twitter_user 
	WHERE user_id = '".$user_id."'
	";

	$statement = $connect->prepare($query);

	$statement->execute();

	$result = $statement->fetchAll();

	foreach($result as $row)
	{
		return $row["username"];
	}
}


function make_follow_button($connect, $sender_id, $receiver_id)
{
	$query = "
	SELECT * FROM tbl_follow 
	WHERE sender_id = '".$sender_id."' 
	AND receiver_id = '".$receiver_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		$output = '<button type="button" name="follow_button" class="btn btn-warning action_button" data-action="unfollow" data-sender_id="'.$sender_id.'"> Following</button>';
	}
	else
	{
		$output = '<button type="button" name="follow_button" class="btn btn-info action_button" data-action="follow" data-sender_id="'.$sender_id.'"><i class="glyphicon glyphicon-plus"></i> Follow</button>';
	}
	return $output;
}



function Get_user_id($connect, $username)
{
	$query = "
	SELECT user_id FROM tbl_twitter_user 
	WHERE username = '".$username."'
	";	
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row["user_id"];
	}
}


?>