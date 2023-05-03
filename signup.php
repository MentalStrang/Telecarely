<?php
require __DIR__ . "/database/connection.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$connection = database_connection();
	$roles = ["doctor", "nurse", "patient"];

	// Check if all supplied items are empty or null
	if (
		empty($_POST['name']) ||
		empty($_POST['email']) ||
		empty($_POST['password']) ||
		empty($_POST['user-role']) ||
		empty($_POST['age']) ||
		empty($_POST['phone']) ||
		empty($_POST['profile_pic'])
	) {
		exit('Please complete the registration form.');
	}

	/*
	* 	Check if email is valid or not.
	* 	eg. hellothere is not a valid email
	* 	eg. hellothere@gmail.com is a valid one
	*/
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		exit('The email address you have entered is invalid. Please enter a valid email address and try again.');
	}

	// Make user role lowercase, eg. PATIENT -> patient
	$_POST['user-role'] = strtolower($_POST['user-role']);

	// Check if the supplied role exists in the system
	if (!in_array($_POST['user-role'], $roles)) {
		exit('Please complete the registration form.');
	}

	if ($_POST['user-role'] != "patient") {
		if (empty($_POST['specialty'])) {
			exit('Invalid Specialty.');
		}
	} else {
		$_POST['specialty'] = "NULL";
	}

	/*
	*	Check if user exists in DB or not
	*	We use prepared statement to have all input automaticlly escaped
	*/
	if ($stmt = $connection->prepare('SELECT `name` FROM `users` WHERE `email` = ?')) {
		$stmt->bind_param('s', $_POST['email']);
		$stmt->execute();
		$stmt->store_result();
		// Check if the query returned any rows
		if ($stmt->num_rows > 0) {
			$stmt->close();
			echo 'This email address is already registered. Please sign in with your existing account.';
		} else {
			$stmt->close();
			// Insert the email/password into the database
			if ($stmt = $connection->prepare('INSERT INTO users (`name`, `email`, `password`, `role`, `age`, `phone`, `image`, `specialty`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
				// Apply a hash function to the passwords so that in the event of a data breach, the passwords are not exposed in plain text.
				$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$stmt->bind_param(
					'ssssiibs',
					$_POST['name'],
					$_POST['email'],
					$password,
					$_POST['user-role'],
					$_POST['age'],
					$_POST['phone'],
					$_POST['profile_pic'],
					$_POST['specialty']
				);

				$stmt->execute();
				$stmt->close();

				echo 'Your registration has been completed successfully. You may now proceed to login.';
			} else {
				echo 'We apologize for the inconvenience, but we were unable to prepare your statement at this time. Please try again later.';
			}
		}
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Sign Up Page</title>
	<link rel="stylesheet" href="css/signup.css" />
</head>

<body>
	<div class="signup-container">
		<h1>Sign Up</h1>
		<form action="signup.php" method="post" autocomplete="on">
			<label for="name">Name</label>
			<input type="text" id="name" name="name" required />

			<label for="email">Email</label>
			<input type="text" id="email" name="email" required />

			<label for="password">Password</label>
			<input type="password" id="password" name="password" required />

			<label for="confirm-password">Confirm Password</label>
			<input type="password" id="confirm-password" name="confirm-password" required />

			<label for="user-role">User role</label>
			<select id="user-role" name="user-role" required>
				<option value="patient" selected>Patient</option>
				<option value="doctor">Doctor</option>
				<option value="nurse">Nurse</option>
			</select>

			<div id="doctor-nurse" hidden disabled>
				<label for="specialty">Specialization</label>
				<input type="text" id="specialty" name="specialty" />
			</div>

			<label for="age">Age</label>
			<input type="number" id="age" name="age" required />

			<label for="phone">Phone</label>
			<input type="tel" id="phone" name="phone" required />

			<label for="profile_pic">Profile Picture</label>
			<input type="file" id="profile_pic" name="profile_pic" accept="image/*" required>

			<button type="submit" name="signup">Sign Up</button>
			<button type="reset">Reset</button>

		</form>
		<p>Already have an account? <a href="login.html">Login</a></p>
	</div>
</body>

</html>

<script>
	let select = document.querySelector('#user-role');

	function user_role_change() {
		let value = select.value.toLowerCase()
		if (value == "patient") {
			let div = document.querySelector("#doctor-nurse")
			div.setAttribute("hidden", "")
			div.setAttribute("disabled", "")
			document.querySelector("#specialty").removeAttribute("required")
		} else {
			let div = document.querySelector("#doctor-nurse")
			div.removeAttribute("hidden")
			div.removeAttribute("disabled")
			document.querySelector("#specialty").setAttribute("required", "")
		}
	}
	user_role_change()
	select.addEventListener("change", user_role_change);
</script>
