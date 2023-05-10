<?php
// require __DIR__ . "/../database/patient_inquiry.php";
$patient_message = $_POST['message'];


?>
<!DOCTYPE html>
<html>

<head>
	<title>Send Inquiry to Doctor</title>
	<link rel="stylesheet" type="text/css" href="css/inquiry.css">
</head>

<body>
	<div class="container">
		<h1>Send Inquiry to Doctor</h1>
		<form action="inquiry.php" method="post">
			<label for="message">Message:</label>
			<textarea id="message" name="message" rows="5" required></textarea>

			<input type="submit" value="Send Inquiry" name="submit">
		</form>
	</div>
</body>

</html>
