<?php
require __DIR__ . "/connection.php";
$connection = database_connection();

$user_email = $_POST['email'];
$user_password = $_POST['password'];

// Check if email/password is empty or null
if (empty($user_email) || empty($user_password)) {
	exit('Please fill email and password.');
}

/*
* Check if email is valid or not.
* eg. hellothere is not a valid email
* eg. hellothere@gmail.com is a valid one
*/
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('The email address you have entered is invalid. Please enter a valid email address and try again.');
}

// Check if user exists in DB or not
if ($stmt = $con->prepare('SELECT `password` FROM `users` WHERE `email` = ?')) {
	// Pass username to the query
	$stmt->bind_param('s', $user_email);
	$stmt->execute();
	$stmt->store_result();
	// Check if the query returned any rows
	if ($stmt->num_rows > 0) {
		echo 'Username exists, please choose another!';
	} else {
		echo 'The provided username and/or password is invalid. Please revise your credentials and try again.';
	}
	$stmt->close();
} else {
	echo 'We apologize for the inconvenience, but we were unable to prepare your statement at this time. Please try again later.';
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
		<form>
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
