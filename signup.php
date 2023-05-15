<?php
require __DIR__ . "/database/connection.php";
require __DIR__ . "/database/connection_users.php";

// redirect if the patient/doctor  login 
session_start();
// to prevent user to back to the sign page if he is login
if (isset($_SESSION['user_id'])) {
	header('location: patient/patient_index.php');
	exit();
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$error = ''; // Initialize error variable with an empty string
$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name =
		$error = database_register_user(
			$_POST['name'],
			$_POST['email'],
			$_POST['password'],
			$_POST['user-role'],
			$_POST['age'],
			$_POST['phone'],
			$_POST['profile_pic'],
			$_POST['specialty']
		);
	if ($error === '') {
		// redirect after successful signup
		header('Location: login.php');
		exit;
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

			<label for="user-role">Who Are you</label>
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
			<?php if ($error !== "") : ?>
				<p style="color: red; margin-top:-12px"> <?= $error ?> </p>
			<?php endif; ?>
			<button type="submit" name="signup">Sign Up</button>
			<button type="reset">Reset</button>

		</form>
		<p>Already have an account? <a href="login.php">Login</a></p>
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

	// Prevent resubmission the from everytime
	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>
