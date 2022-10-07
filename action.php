<?php

//action.php

include('database_connection.php');

session_start();

if(isset($_POST['action']))
{
	$output = '';
	if($_POST['action'] == 'insert')
	{
		$data = array(
			':user_id'			=>	$_SESSION["user_id"],
			':post_content'		=>	$_POST["post_content"],
			':post_datetime'	=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
		);
		$query = "
		INSERT INTO tbl_samples_post 
		(user_id, post_content, post_datetime) 
		VALUES (:user_id, :post_content, :post_datetime)
		";

		$statement = $connect->prepare($query);
		$statement->execute($data);



		
	}

	if($_POST['action'] == 'fetch_post')
	{
		$query = "
		SELECT * FROM tbl_samples_post 
		INNER JOIN tbl_twitter_user ON tbl_twitter_user.user_id = tbl_samples_post.user_id 
		LEFT JOIN tbl_follow ON tbl_follow.sender_id = tbl_samples_post.user_id 
		WHERE tbl_follow.receiver_id = '".$_SESSION["user_id"]."' OR tbl_samples_post.user_id = '".$_SESSION["user_id"]."' 
		GROUP BY tbl_samples_post.post_id 
		ORDER BY tbl_samples_post.post_id DESC
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$total_row = $statement->rowCount();
		if($total_row > 0)
		{
			foreach($result as $row)
			{
				$profile_image = '';
				if($row['profile_image'] != '')
				{
					$profile_image = '<img src="images/'.$row["profile_image"].'" class="img-thumbnail img-responsive" />';
				}
				else
				{
					$profile_image = '<img src="images/user.jpg" class="img-thumbnail img-responsive" />';
				}

				$output .= '
				<div class="jumbotron" style="padding:24px 30px 24px 30px">
					<div class="row">
						<div class="col-md-2">
							'.$profile_image.'
						</div>
						<div class="col-md-8">
							<strong><p><h4><b>@'.$row["username"].'</b></h4>
							<p></strong></p>'.$row["post_content"].'<br /><br />
							


							</p>
							<div id="comment_form'.$row["post_id"].'" style="display:none;">
								<span id="old_comment'.$row["post_id"].'"></span>
								<div class="form-group">
									<textarea name="comment" class="form-control" id="comment'.$row["post_id"].'"></textarea>
								</div>
								<div class="form-group" align="right">
									<button type="button" name="submit_comment" class="btn btn-primary btn-xs submit_comment">Comment</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				';
			}
		}
		else
		{
			$output = '<h4>No Post Found</h4>';
		}
		echo $output;
	}
	if($_POST['action'] == 'fetch_user')
	{
		$query = "
		SELECT * FROM tbl_twitter_user 
		WHERE user_id != '".$_SESSION["user_id"]."' 
		ORDER BY user_id DESC 
		LIMIT 15
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$profile_image = '';
			if($row['profile_image'] != '')
			{
				$profile_image = '<img src="images/'.$row["profile_image"].'" class="img-thumbnail img-responsive" />';
			}
			else
			{
				$profile_image = '<img src="images/user.jpg" class="img-thumbnail img-responsive" />';
			}
			$output .= '
			<div class="row">
				<div class="col-md-4">
					'.$profile_image.'
				</div>
				<div class="col-md-8">
					<h4><b>@'.$row["username"].'</b></h4>
					'.make_follow_button($connect, $row["user_id"], $_SESSION["user_id"]).'
					<span class="label label-success"> '.$row["follower_number"].' Followers</span>
				</div>
			</div>
			<hr />
			';
		}
		echo $output;
	}

	if($_POST['action'] == 'follow')
	{
		$query = "
		INSERT INTO tbl_follow 
		(sender_id, receiver_id) 
		VALUES ('".$_POST["sender_id"]."', '".$_SESSION["user_id"]."')
		";
		$statement = $connect->prepare($query);
		if($statement->execute())
		{
			$sub_query = "
			UPDATE tbl_twitter_user SET follower_number = follower_number + 1 WHERE user_id = '".$_POST["sender_id"]."'
			";
			$statement = $connect->prepare($sub_query);
			$statement->execute();

		}

	}

	if($_POST['action'] == 'unfollow')
	{
		$query = "
		DELETE FROM tbl_follow 
		WHERE sender_id = '".$_POST["sender_id"]."' 
		AND receiver_id = '".$_SESSION["user_id"]."'
		";
		$statement = $connect->prepare($query);
		if($statement->execute())
		{
			$sub_query = "
			UPDATE tbl_twitter_user 
			SET follower_number = follower_number - 1 
			WHERE user_id = '".$_POST["sender_id"]."'
			";
			$statement = $connect->prepare($sub_query);
			$statement->execute();

			
			$statement = $connect->prepare($insert_query);

			$statement->execute();
		}
	}

	if($_POST["action"] == 'submit_comment')
	{
		$data = array(
			':post_id'		=>	$_POST["post_id"],
			':user_id'		=>	$_SESSION["user_id"],
			':comment'		=>	$_POST["comment"],
			':timestamp'	=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
		);
		$query = "
		INSERT INTO tbl_comment 
		(post_id, user_id, comment, timestamp) 
		VALUES (:post_id, :user_id, :comment, :timestamp)
		";
		$statement = $connect->prepare($query);
		$statement->execute($data);




	}
	if($_POST["action"] == "fetch_comment")
	{
		$query = "
		SELECT * FROM tbl_comment 
		INNER JOIN tbl_twitter_user 
		ON tbl_twitter_user.user_id = tbl_comment.user_id 
		WHERE post_id = '".$_POST["post_id"]."' 
		ORDER BY comment_id ASC
		";
		$statement = $connect->prepare($query);
		$output = '';
		if($statement->execute())
		{
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				$profile_image = '';
				if($row['profile_image'] != '')
				{
					$profile_image = '<img src="images/'.$row["profile_image"].'" class="img-thumbnail img-responsive img-circle" />';
				}
				else
				{
					$profile_image = '<img src="images/user.jpg" class="img-thumbnail img-responsive img-circle" />';
				}
				$output .= '
				<div class="row">
					<div class="col-md-2">
					'.$profile_image.'	
					</div>
					<div class="col-md-10" style="margin-top:16px; padding-left:0">
						<small><b>@'.$row["username"].'</b><br />
						'.$row["comment"].'
						</small>
					</div>
				</div>
				<br />
				';
			}
		}
		echo $output;
	}






	if($_POST["action"] == "fetch_link_content")
	{
		echo file_get_contents($_POST["url"][0]);
	}

	
}

?>