<?php
require __DIR__ . "/../database/patient_inquiry.php";
require __DIR__ . "/../database/connection_users.php";


session_start();
// this code for sessions

if (isset($_SESSION['user_id'])) {
	$doctort_id = $_SESSION['user_id'];
	$doctors = database_get_all_user($doctort_id);
} else {
	// redirect to the login page if user made logout
	header('location: ../login.php');
}


$patinet_inquiry = database_get_all_patient_inquiries($doctort_id);
// exit();

// $patinet_name = database_get_name_patietn_from_inquiry($patinet_inquiry['patient_id']);
// print_r($patinet_name);



?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Patient Information</title>
	<link rel="stylesheet" type="text/css" href="../css/all_doctor.css">
	<link rel="stylesheet" type="text/css" href="../css/patient_profile.css">
</head>

<body>
	<div class="menu">
		<div class="doctor-profile">
			<img src="../images/pic-1.png" alt="Doctor Image">
			<h2> <?php foreach ($doctors as $doctor) : ?>
					<h2> Dr. <?= $doctor['name'] ?></h2>
				<?php endforeach; ?>
			</h2>
		</div>
		<ul>
			<li><a href="doctor_index.php">Home</a></li>
			<li><a href="all_patients.php">My Patients</a></li>
			<li class="logout_doctor"><a href="../logout.php">logout</a></li>
		</ul>
	</div>
	<h1>Patient Information</h1>
	<table>
		<thead>
			<tr>
				<th>Patient Name</th>
				<th>Message</th>
				<th>Send prescription</th>
			</tr>
		</thead>
		<tbody>

			<?php foreach ($patinet_inquiry as $inquiry) : ?>
				<tr>
					<?php $patient_name = database_get_name_patient_from_inquiry($inquiry['patient_id']); ?>
					<td><?= $patient_name ?></td>
					<td> <?= $inquiry['message'] ?></td>
					<td>
						<button class="inquiry" style="width:200px;">
							<a style="text-decoration:none; color:white" href="../prescription.php?id=<?php echo $inquiry['patient_id']; ?>">
								Send Now
							</a>
						</button>
					</td>
				</tr>

			<?php endforeach ?>




		</tbody>
	</table>
</body>

</html>
