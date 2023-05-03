<?php
require __DIR__ . "/../config/constants.php";
function database_connection()
{
	// this for if any error happen in the database connect view in the browser and stop any codition'll happen
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	// this fro connect to the database
	$connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);

	// $sql = "
	// CREATE TABLE IF NOT EXISTS `users` (
	// 	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	// 	`name` TEXT NOT NULL,
	// 	`email` TEXT NOT NULL,
	// 	`password` TEXT NOT NULL,
	// 	`role` TEXT NOT NULL,
	// 	`age` INT NOT NULL,
	// 	`phone` INT NOT NULL,
	// 	`image` BLOB NOT NULL,
	// 	`specialty` TEXT
	// );

	// CREATE TABLE IF NOT EXISTS `inquiries` (
	// 	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	// 	`patient_id` INT UNSIGNED NOT NULL,
	// 	`doctor_id` INT UNSIGNED NOT NULL,
	// 	`drug_name` TEXT,
	// 	`drug_amount` INT,
	// 	FOREIGN KEY(patient_id) REFERENCES users(id),
	// 	FOREIGN KEY(doctor_id) REFERENCES users(id)
	// );
	// ";

	// if ($connection->multi_query($sql) === FALSE) {
	// 	echo "Error creating table: " . $connection->error;
	// }

	// $connection->next_result();

	return $connection;
}
