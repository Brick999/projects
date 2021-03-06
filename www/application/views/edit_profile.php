<?php include "application/views/header.php"; ?>
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="navbar-header">
				<a href="/test" class="navbar-brand">Test App</a>
			</div>
			<ul class="nav navbar-nav">
<?php		if($user_session["user_level_id"] == ADMIN)
			{
?>
				<li><a href="/users/dashboard/admin">Dashboard</a></li>
<?php		}	
			else
			{
?>
				<li><a href="/users/dashboard">Dashboard</a></li>
<?php		}	?>
			</ul>
			<ul class="nav navbar-nav">
				<li><a href="/users/edit">Profile</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="/users/logout">Log Off</a></li>
			</ul>
			</div>
		</div>
		<div id="main_contents">
<?php		if(isset($edit_other))
			{
?>
				<h3>Edit user #<?= $user_data["id"] ?></h3>
<?php		}
			else
			{
?>
				<h3>Edit Profile</h3>
<?php		}	?>
			<h4>Edit Information</h4>
			
<?php		if(isset($info_errors))
			{
				echo "<p class='text-danger'>" . $info_errors . "</p>";
			}
			else if(isset($info_success))
			{
				echo "<p class='text-success'>" . $info_success . "</p>";
			}

			if($user_data["id"] != $user_session["id"])
			{
?>
				<form id="edit_profile_form" action="/users/process_edit_profile/<?= $user_data['id'] ?>" method="post" class="pull-left">
<?php		}
			else
			{
?>
				<form id="edit_profile_form" action="/users/process_edit_profile" method="post" class="pull-left">
<?php		}	?>
				
				<div class="form-group">
					<label for="first_name">First Name:</label>
					<input type="text" name="first_name" class="form-control" value="<?= $user_data["first_name"] ?>">
					</input>
				</div>
				<div class="form-group">
					<label for="last_name">Last Name:</label>
					<input type="text" name="last_name" class="form-control" value="<?= $user_data["last_name"] ?>">
					</input>
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="text" name="email" class="form-control" value="<?= $user_data["email"] ?>">
					</input>
				</div>
<?php			if(isset($edit_other))
				{
?>
					<label for="user_level">User Level:</label>
					<select name="user_level" id="user_level" class="form-control">
						<option value="1">Admin</option>
						<option value="2">Normal</option>
					</select>
<?php			}	?>
				<input type="submit" value="Save" class="btn btn-success" />
			</form>
			<h4>Change Password</h4>
			
<?php		if(isset($password_errors))
			{
				echo "<p class='text-danger'>" . $password_errors . "</p>";
			}
			else if(isset($password_success))
			{
				echo "<p class='text-success'>" . $password_success . "</p>";
			}
?>			
<?php		if($user_data["id"] != $user_session["id"])
			{
?>
				<form id="change_password_form" action="/users/process_change_password/<?= $user_data['id'] ?>" 
				method="post" class="pull-right">
<?php		}
			else
			{
?>
				<form id="change_password_form" action="/users/process_change_password" method="post" class="pull-right">
<?php		}	?>

				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" name="password" class="form-control" />
				</div>
				<div class="form-group">
					<label for="confirm_password">Password Confirmation:</label>
					<input type="password" name="confirm_password" class="form-control" />
				</div>
				<input type="submit" value="Update Password" class="btn btn-success" />
			</form>
			<div class="clearfix"></div>
<?php		if(!isset($edit_other))
			{
?>
				<h4>Edit Description</h4>
			
<?php			if(isset($description_success))
				{
					echo "<p class='text-success'>" . $description_success . "</p>";
				}
			
				if($user_data["id"] != $user_session["id"])
				{
?>
					<form id="edit_description_form" action="/users/process_edit_description/<?= $user_data['id'] ?>" method="post">
<?php			}
				else
				{
?>
					<form id="edit_description_form" action="/users/process_edit_description" method="post">
<?php			}	?>
						<textarea name="description" cols="150" rows="5"><?= $user_data["description"] ?></textarea>
						<input type="submit" value="Save" class="btn btn-success" />
					</form>
<?php		}	?>
		</div>
	</div>
</body>
</html>