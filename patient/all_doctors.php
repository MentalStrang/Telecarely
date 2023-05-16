<?php
session_start();
require __DIR__ . "/../database/connection_all_doctors.php";
require __DIR__ . "/../database/connection_users.php";
$doctors = database_get_doctors();
if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
	$patients = database_get_all_user($user_id);
} else {
	// redirect to the login page if user made logout
	header('location: ../login.php');
}
// print_r($doctors);
// exit();

?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Doctor Information</title>
	<link rel="stylesheet" type="text/css" href="../css/all_doctor.css">
	<link rel="stylesheet" type="text/css" href="../css/patient_profile.css">
</head>

<body>
	<div class="menu">
		<div class="doctor-profile">
			<?php foreach ($patients as $patient) : ?>
				<img src="<?= $patient['image'] ?> " alt="Doctor Image">
				<h2>
					<h2><?= $patient['name'] ?></h2>
				</h2>
			<?php endforeach; ?>
		</div>
		<ul>
			<li><a href="patient_index.php">Home</a></li>
			<li><a href="all_doctors.php">All Doctors</a></li>
			<li><a href="pre_index.php">Your Prescriptions</a></li>
			<li><a href="../logout.php">logout</a></li>
		</ul>
	</div>
	<h1>Doctor Information</h1>
	<table>
		<thead>
			<tr>
				<th>Name</th>
				<th>Specialty</th>
				<th>Contact Information</th>
				<th>Send Inquiry</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($doctors as $doctor) : ?>
				<a href="cardiology.html">
					<tr>
						<td>DR. <?php echo $doctor['name'] ?></td>
						<td><?php echo $doctor['specialty'] ?></td>
						<td>Email: <?php echo $doctor['email'] ?><br>Phone: <?php echo $doctor['phone'] ?></td>

						<!--"note here" i made here a new button to access the patient to send the inquiry for the doctor but note that the update of css not reflect here in php code and i don't know where the error -->
						<td>
							<button class="inquiry" style="width:200px;">
								<a style="text-decoration:none; color:white" href="../inquiry.php?id=<?php echo $doctor['id']; ?>">
									Send Now
								</a>
							</button>
						</td>

					</tr>
				</a>
			<?php endforeach ?>
		</tbody>
	</table>
</body>

</html>
