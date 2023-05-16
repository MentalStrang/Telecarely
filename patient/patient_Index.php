<?php

require __DIR__ . "/../database/connection_users.php";
$last_patient = database_get_count_patient();
$last_doctor = database_get_count_doctor();
$last_nurse = database_get_count_nurse();
session_start();
// this code for sessions

if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
	$patients = database_get_all_user($user_id);
} else {
	// redirect to the login page if user made logout
	header('location: ../login.php');
}


// for search tag " search for a doctor in the clinic using name
// $search_for = '';
$doctors = array();
if (isset($_GET['submit'])) {
	$search_for = $_GET['search_for'];
	$doctors = search_doctors($search_for);
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
			<h2><?php foreach ($patients as $patient) : ?>
					<img <?= $patient['image'] ?> alt="Doctor Image">
					<h2><?= $patient['name'] ?></h2>
				<?php endforeach; ?>
			</h2>
		</div>
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="all_doctors.php">All Doctors</a></li>
			<li><a href="pre_index.php">Your Prescriptions</a></li>
			<li><a href="../logout.php">logout</a></li>

		</ul>
	</div>
	<div class="main-section">
		<h1>Welcome to <a href="../index.php" class="logo">TELE<span>Carely.</span></a>
			<div class="center-container">
				<h3>Welcome!</h3>
				<h1>
					<?php foreach ($patients as $patient) : ?>
						<h2><?= $patient['name'] ?></h2>
					<?php endforeach; ?>
				</h1>
				<h3>Channel a Doctor Here</h3>
				<form class="search-form" action="patient_Index.php" method="get">
					<input style="margin-bottom: 15px;" type="search" name="search_for" class="input-text" placeholder="Search Doctor">
					<input type="Submit" name="submit" id="submit" value="Search" class="btn-primary btn">
				</form>
				<table>
					<?php foreach ($doctors as $doctor) : ?>
						<tr><?= $doctor['name'] ?></tr> <br>
					<?php endforeach ?>
				</table>
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
				<div class="dashboard-item-number"><?php echo $last_nurse['num_nurses'] ?></div>
				<div class="dashboard-item-label">All Nurses</div>
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
