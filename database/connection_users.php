<?php
require_once __DIR__ . "/connection.php";

// get the coutn of patient in whole clinic
function database_get_count_patient()
{
	$connection = database_connection();
	$query = "SELECT COUNT(*) AS num_patients FROM users WHERE role = 'patient'";
	$result = mysqli_query($connection, $query);
	$last_patient = mysqli_fetch_assoc($result);
	return $last_patient;
}

// get the count of doctors 
function database_get_count_doctor()
{
	$connection = database_connection();
	$quiery = "SELECT COUNT(*) AS num_doctors FROM users WHERE role = 'doctor'";
	$resutl = mysqli_query($connection, $quiery);
	$last_doctor = mysqli_fetch_assoc($resutl);
	return $last_doctor;
}

function search_doctors($search_for)
{
	$connection = database_connection();
	$stmt = mysqli_prepare($connection, "select * from users where name like ? 
	and role like 'doctor'");
	mysqli_stmt_bind_param($stmt, 's', $search_for);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
	mysqli_stmt_close($stmt);
	mysqli_close($connection);
	return $doctors;
}

// get users
function database_get_all_user($id)
{
	$connection = database_connection();
	$stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE `id` = ?");
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$patients = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $patients;
}

// registeratin and checks
function database_register_user($name, $email, $password, $user_role, $age, $phone, $profile_pic, $specialty)
{
	$connection = database_connection();
	$roles = ["doctor", "nurse", "patient"];

	// Check if all supplied items are empty or null
	if (
		empty($name) ||
		empty($password) ||
		empty($age) ||
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
	if ($stmt = $connection->prepare('SELECT name FROM users WHERE email = ?')) {
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
			if ($stmt = $connection->prepare('INSERT INTO users (name, email, password, role, age, phone, image, specialty) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
				// Apply a hash function to the passwords so that in the event of a data breach, the passwords are not exposed in plain text.
				$password = password_hash($password, PASSWORD_DEFAULT);
				$stmt->bind_param(
					'ssssiiss',
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
