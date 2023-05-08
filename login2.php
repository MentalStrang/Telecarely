<?php
require __DIR__ . "/database/connection.php";
$connection = database_connection();

// Check if email/password is empty or nullF

/*
* Check if email is valid or not.
* eg. hellothere is not a valid email
* eg. hellothere@gmail.com is a valid one
*/
if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('The email address you have entered is invalid. Please enter a valid email address and try again.');
}

// Check if user exists in DB or not
if ($stmt = $connection->prepare('SELECT `id`, `password` FROM `users` WHERE `email` = ?')) {
	// Pass email to the query
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	$stmt->store_result();
	// Check if the query returned any rows
	if ($stmt->num_rows > 0) {
		// Bind the password returned from the database to the $hashed_password variable
		$stmt->bind_result($user_id, $hashed_password);
		$stmt->fetch();
		// Verify the password entered by the user matches the hashed password from the database
		if (password_verify($_POST['password'], $hashed_password)) {
			// Password is correct, set session variables and redirect the user to the dashboard
			session_start();
			$_SESSION['user_id'] = $user_id;
			header('Location: patient/patient_Index.php');
			exit();
		} else {
			// Password is incorrect
			exit('The password you have entered is incorrect. Please revise your credentials and try again.');
		}
	} else {
		// User does not exist in the database
		exit('The email address you have entered does not exist in our records. Please register to create an account.');
	}
	$stmt->close();
} else {
	exit('We apologize for the inconvenience, but we were unable to prepare your statement at this time. Please try again later.');
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Login Page</title>
	<link rel="stylesheet" href="css/login.css" />
</head>

<body>
	<div class="login-container">
		<h1>Login</h1>
		<form method="post" action="login.php">
			<label for="username">Username</label>
			<input type="text" id="username" name="username" required />

			<label for="password">Password</label>
			<input type="password" id="password" name="password" required />

			<button type="submit">Login</button>
		</form>
		<p>Don't have an account? <a href="signup.html">Sign up</a></p>
	</div>

</body>

</html>
