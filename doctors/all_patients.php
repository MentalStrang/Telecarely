<?php
require __DIR__ . "/../database/connection_all_doctors.php"; 
$doctors = database_get_all_doctors(); 

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
            <img src="../images/pic-1.png" alt="Doctor Image">
            <h2>Mohamed Ramadan</h2>
        </div>
        <ul>
            <li><a href="doctor_index.php">Home</a></li>
            <li><a href="all_patients.php">My Patients</a></li>
            <li><a href="../index.html" class="logout">Log Out</a></li>
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
			<?php foreach($doctors as $doctor): ?>
				<a href="cardiology.html">
					<tr>
						<td><?php echo $doctor['name'] ?></td>
						<td><?php echo $doctor['Specialization'] ?></td>
						<td>Email: <?php echo $doctor['email'] ?><br>Phone: <?php echo $doctor['phone'] ?></td>

						<!--"note here" i made here a new button to access the patient to send the inquiry for the doctor but note that the update of css not reflect here in php code and i don't know where the error -->
						<td><button class="inquiry" style="width:200px; "><a style="text-decoration:none; color:white" href="../prescription/inquiry.php?id=<?php echo $doctor['doctor_id']?>" >Send Now</a></button></td>

					</tr>
				</a>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>
