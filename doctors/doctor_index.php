<?php
require __DIR__. "/../database/connection_all_doctors.php";
$doctors = database_get_all_doctor();

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
            <img src="../images/pic-1.png" alt="Doctor Image">
            <h2><?php echo $doctors['name']?></h2>
        </div>
        <ul>
            <li><a href="doctor_index.php">Home</a></li>
            <li><a href="all_patients.php">My Patients</a></li>
            <!-- <li><a href="../prescription/pre_index.html">Your Prescriptions</a></li> -->
            <li><a href="../index.html" class="logout">Log Out</a></li>
        </ul>
    </div>
	<div class="main-section">
		<h1>Welcome to <a href="../index.html" class="logo">TELE<span>Carely.</span></a>
		<div class="center-container">
			<h3>Welcome!</h3>
			<h1><?php echo $doctors['name']?></h1>
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
					<div class="dashboard-item-number"><?php  echo $last_doctor['doctor_id'] ?></div>
					<div class="dashboard-item-label">All Doctors</div>
				</div>
				<div class="dashboard-item">
					<div class="dashboard-item-number"><?php echo $last_patient['patient_id']; ?></div>
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
