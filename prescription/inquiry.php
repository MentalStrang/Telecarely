<?php
require __DIR__. "/../database/patient_inquiry.php"; 
if(isset($_POST['submit'])){
    $doctor_id = $_GET['id'];
    $patient_id = $_GET['patient_id'];
    $patient_name = $_POST['patient_name']; 
    $patient_email = $_POST['email']; 
    $patient_message = $_POST['message'];
    database_insert_patient_inquiry($doctor_id,$patient_id, $patient_message ); 

    echo "the inquiry inserted "; 
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Send Inquiry to Doctor</title>
	<link rel="stylesheet" type="text/css" href="../css/inquiry.css">
</head>
<body>
	<div class="container">
		<h1>Send Inquiry to Doctor</h1>
		<form action="inquiry.php" method="post">
			<label for="patient_name">Patient Name: </label>
			<input type="text" id="patient_name" name="patient_name" required>

			<label for="doctor_name">Email:</label>
			<input type="text" id="email" name="email" required>

			<label for="message">Message:</label>
			<textarea id="message" name="message" rows="5" required></textarea>

			<input type="submit" value="Send Inquiry" name="submit">
		</form>
	</div>
</body>
</html>
