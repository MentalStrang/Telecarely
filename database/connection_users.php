<?php
require_once __DIR__ . "/connection.php";

function database_get_count_patient()
{
	$connection = database_connection();
	$query = "SELECT COUNT(*) AS num_patients FROM users WHERE role = 'patient'";
	$result = mysqli_query($connection, $query);
	$last_patient = mysqli_fetch_assoc($result);
	return $last_patient;
}

function database_get_all_patients()
{
	$connection = database_connection();
	$result = mysqli_query($connection, "SELECT SUM(`id`) FROM users WHERE `role` = 'patient'");
	$patients = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $patients;
}

function database_get_last_doctor()
{
	$connection = database_connection();
	$query = "SELECT id FROM users WHERE `role` = 'doctor'";
	$result = mysqli_query($connection, $query);
	$last_doctor = mysqli_fetch_assoc($result);
	return $last_doctor;
}


function database_register_user($name, $email, $password, $user_role, $age, $phone, $profile_pic, $specialty)
{
	$connection = database_connection();
	$roles = ["doctor", "nurse", "patient"];

	// Check if all supplied items are empty or null
	if (
		empty($name) ||
		empty($email) ||
		empty($password) ||
		empty($user_role) ||
		empty($age) ||
		empty($phone) ||
		empty($profile_pic)
	) {
		return 'Please complete the registration form.';
	}

	/*
    *   Check if email is valid or not.
    *   eg. hellothere is not a valid email
    *   eg. hellothere@gmail.com is a valid one
    */
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return 'The email address you have entered is invalid. Please enter a valid email address and try again.';
	}

	// Make user role lowercase, eg. PATIENT -> patient
	$user_role = strtolower($user_role);

	// Check if the supplied role exists in the system
	if (!in_array($user_role, $roles)) {
		return 'Please complete the registration form.';
	}

	if ($user_role != "patient") {
		if (empty($specialty)) {
			return 'Invalid Specialty.';
		}
	} else {
		$specialty = NULL;
	}

	/*
    *   Check if user exists in DB or not
    *   We use prepared statement to have all input automatically escaped
    */
	if ($stmt = $connection->prepare('SELECT `name` FROM `users` WHERE `email` = ?')) {
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		// Check if the query returned any rows
		if ($stmt->num_rows > 0) {
			$stmt->close();
			return 'This email address is already registered. Please sign in with your existing account.';
		} else {
			$stmt->close();
			// Insert the email/password into the database
			if ($stmt = $connection->prepare('INSERT INTO users (`name`, `email`, `password`, `role`, `age`, `phone`, `image`, `specialty`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
				// Apply a hash function to the passwords so that in the event of a data breach, the passwords are not exposed in plain text.
				$password = password_hash($password, PASSWORD_DEFAULT);
				$stmt->bind_param(
					'sssssiib',
					$name,
					$email,
					$password,
					$user_role,
					$age,
					$phone,
					$profile_pic,
					$specialty
				);

				$stmt->execute();
				$stmt->close();

				return 'Your registration has been completed successfully. You may now proceed to login.';
			} else {
				return 'We apologize for the inconvenience, but we were unable to prepare your statement at this time. Please try again later.';
			}
		}
	}
}


// this function to login the user

// function database_login_user($email, $password){

// 	$hashed_password = password_hash($password,PASSWORD_DEFAULT); 
// 	$conn = database_connection();
// 	$quiery = "SELECT * from users WHERE email= ?" ;
// 	$stmt = mysqli_prepare($conn, $quiery); 
// 	mysqli_stmt_bind_param($stmt, 's', $)
// }
