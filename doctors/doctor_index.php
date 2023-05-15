<?php
// $doctors = database_get_all_doctor();
require __DIR__ . "/../database/connection_users.php";
$last_patient = database_get_count_patient();
$last_doctor = database_get_count_doctor();

session_start();
// this code for sessions

if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
	$doctors = database_get_all_user($user_id);
} else {
	// redirect to the login page if user made logout
	header('location: ../login.php');
}


?>

<!DOCTYPE html>
<html>

<head>
	<title>Patient</title>
	<link rel="stylesheet" href="../css/patient_profile.css"> <!-- Link to the CSS file -->

</head>

<body>
	<div class="menu">
		<div class="doctor-profile">
			<?php foreach ($doctors as $doctor) : ?>
				<img src="<?= $doctor['image'] ?>" alt="Doctor Image">
				<h2><?= $doctor['name'] ?></h2>
			<?php endforeach; ?>
		</div>

		<ul>
			<li><a href="doctor_index.php">Home</a></li>
			<li><a href="all_patients.php">My Patients</a></li>
			<!-- <li><a href="../prescription/pre_index.html">Your Prescriptions</a></li> -->
			<li class="logout_doctor"><a href="../logout.php">logout</a></li>
		</ul>
	</div>
	<div class="main-section">
		<h1>Welcome to <a href="../index.html" class="logo">TELE<span>Carely.</span></a>
			<div class="center-container">
				<h3>Welcome!</h3>
				<h1>
					<h2><?php foreach ($doctors as $doctor) : ?>
							<h2><?= $doctor['name'] ?></h2>
						<?php endforeach; ?>
				</h1>
				<h3>Channel a Doctor Here</h3>
				<form class="search-form">
					<input type="search" name="search" class="input-text" placeholder="Search Doctor and We will Find The Session Available">
					<input type="Submit" value="Search" class="btn-primary btn">
				</form>
			</div>
	</div>

	<!-- ********************************* -->
	<!-- start the dashbord of the patient -->
	<!-- ********************************* -->
	<div class="dashboard">
		<div class="dashboard-filter">
			<p class="dashboard-filter-label">Status</p>
		</div>
		<div class="dashboard-items">
			<div class="dashboard-item">
				<div class="dashboard-item-number"><?php echo $last_doctor['num_doctors'] ?></div>
				<div class="dashboard-item-label">All Doctors</div>
			</div>
			<div class="dashboard-item">
				<div class="dashboard-item-number"><?php echo $last_patient['num_patients'] ?></div>
				<div class="dashboard-item-label">All Patients</div>
			</div>
			<div class="dashboard-item">
				<div class="dashboard-item-number">0</div>
				<div class="dashboard-item-label">All Nurse</div>
			</div>
			<div class="dashboard-item">
				<div class="dashboard-item-number">0</div>
				<div class="dashboard-item-label">Today Sessions</div>
			</div>
		</div>
	</div>
	<!-- ********************************* -->
	<!-- end the dashbord of the patient -->
	<!-- ********************************* -->


</body>

</html>
