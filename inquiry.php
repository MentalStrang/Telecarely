<?php
session_start();
require __DIR__ . "/database/patient_inquiry.php";
// get user id from sessions
$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
	// handle error when id parameter is not set
}
$doctor_id = $_GET['id'];

$errors = array();
$patient_message = "";
if (isset($_POST['submit'])) {
	$patient_message = trim($_POST['message']);
	if (empty($patient_message)) {
		$errors[] = "Message cannot be empty.";
	} else if (strlen($patient_message) > 1000) {
		$errors[] = "Message is too long.";
	} else {
		database_insert_inquiry($user_id, $doctor_id, $patient_message);
		// add confirmation message or redirect to a different page
		// header("Location: inquiry_confirmation.php");
		exit();
	}
}
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
		<?php if (!empty($errors)) { ?>
			<div class="errors" style="color:red">
				<?php foreach ($errors as $error) { ?>
					<p><?php echo $error; ?></p>
				<?php } ?>
			</div>
		<?php } ?>
		<form action="inquiry.php?id=<?php echo $doctor_id; ?>" method="post">
			<label for="message">Message:</label>
			<textarea id="message" name="message" rows="5" required><?php echo $patient_message; ?></textarea>
			<input type="submit" value="Send Inquiry" name="submit">
		</form>
	</div>
</body>

</html>
