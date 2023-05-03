<?php
require __DIR__ . "/connection.php";
$connection = database_connection();

$roles = ["doctor", "nurse", "patient"];

$user_name = $_POST['name'];
$user_email = $_POST['email'];
$user_password = $_POST['password'];
$user_role = $_POST['role'];
$user_age = $_POST['age'];
$user_phone = $_POST['phone'];
$user_image = $_POST['profile_pic'];
$user_specialty = $_POST['specialty'];

// Check if all supplied items are empty or null
if (
	empty($user_name) ||
	empty($user_email) ||
	empty($user_password) ||
	empty($user_role) ||
	empty($user_age) ||
	empty($user_phone) ||
	empty($user_image)
) {
	exit('Please complete the registration form.');
}

/*
* 	Check if email is valid or not.
* 	eg. hellothere is not a valid email
* 	eg. hellothere@gmail.com is a valid one
*/
if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
	exit('The email address you have entered is invalid. Please enter a valid email address and try again.');
}

// Make user role lowercase, eg. PATIENT -> patient
$user_role = strtolower($user_role);

// Check if the supplied role exists in the system
if (in_array($user_role, $roles)) {
	exit('Please complete the registration form.');
}

if ($user_role != "patient" && empty($user_specialty)) {
	exit('Invalid Specialty.');
}

/*
*	Check if user exists in DB or not
*	We use prepared statement to have all input automaticlly escaped
*/
if ($stmt = $con->prepare('SELECT COUNT(*) FROM users WHERE email = ?')) {
	$stmt->bind_param('s', $user_email);
	$stmt->execute();
	$stmt->store_result();
	// Check if the query returned any rows
	if ($stmt->num_rows > 0) {
		echo 'This email address is already registered. Please sign in with your existing account.';
	} else {
		// Insert the email/password into the database
		if ($stmt = $con->prepare('INSERT INTO users (`email`, `password`) VALUES (?, ?, ?)')) {
			// Apply a hash function to the passwords so that in the event of a data breach, the passwords are not exposed in plain text.
			$password = password_hash($user_password, PASSWORD_DEFAULT);
			$stmt->bind_param('s', $user_name);
			$stmt->bind_param('s', $user_email);
			$stmt->bind_param('s', $password);
			$stmt->bind_param('s', $user_role);
			$stmt->bind_param('i', $user_age);
			$stmt->bind_param('i', $user_phone);
			$stmt->bind_param('b', $user_image);

			if ($user_role != "patient") {
				$stmt->bind_param('s', $user_specialty);
			}
			$stmt->execute();
			echo 'Your registration has been completed successfully. You may now proceed to login.';
		} else {
			echo 'We apologize for the inconvenience, but we were unable to prepare your statement at this time. Please try again later.';
		}
	}
	$stmt->close();
} else {
	echo 'We apologize for the inconvenience, but we were unable to prepare your statement at this time. Please try again later.';
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
		<form action="signup.php" method="post" autocomplete="off">
			<label for="name">Name</label>
			<input type="text" id="name" name="name" required />

			<label for="email">Email</label>
			<input type="text" id="email" name="email" required />

			<label for="password">Password</label>
			<input type="password" id="password" name="password" required />

			<label for="confirm-password">Confirm Password</label>
			<input type="password" id="confirm-password" name="confirm-password" required />

			<label for="role">User role</label>
			<select id="user-role" name="user-role" required>
				<option value="patient" selected>Patient</option>
				<option value="nurse">Nurse</option>
				<option value="doctor">Doctor</option>
			</select>

			<label for="age">Age</label>
			<input type="number" id="age" name="age" required />

			<label for="phone">Phone</label>
			<input type="tel" id="phone" name="phone" required />

			<label for="profile_pic">Profile Picture</label>
			<input type="file" id="profile_pic" name="profile_pic" accept="image/*">

			<div id="doctor-nurse" hidden>
				<label for="specialty">Specialization</label>
				<input type="text" id="specialty" name="specialty" required />
			</div>

			<a href="" class="next_btn">Submit</a>
			<button type="reset">Reset</button>

		</form>
		<p>Already have an account? <a href="login.html">Login</a></p>
	</div>
</body>

</html>

<script>
	let select = document.querySelector('#user-role');
	select.addEventListener("change", function() {
		let value = select.value.toLowerCase()
		if (value == "patient") {
			document.querySelector("#doctor-nurse").setAttribute("hidden", "")
		} else {
			document.querySelector("#doctor-nurse").removeAttribute("hidden")
		}
	});
</script>
