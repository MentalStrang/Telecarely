<?php
// require __DIR__ . "/connection.php";

function database_get_doctors()
{
	$connection = database_connection();
	$resutl = mysqli_query($connection, "SELECT * FROM `users` WHERE `role`='doctor'");
	return mysqli_fetch_all($resutl, MYSQLI_ASSOC);
}


function database_get_doctors_id()
{
	$connection = database_connection();
	$resutl = mysqli_query($connection, "SELECT id FROM `users` WHERE `role`='doctor'");
	return mysqli_fetch_all($resutl, MYSQLI_ASSOC);
}

function get_doctor_name($id)
{
	$connection = database_connection();
	$stmt = mysqli_prepare($connection, 'SELECT `name`  FROM `users` WHERE id = ?');
	mysqli_stmt_bind_param($stmt, 'i', $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);

	return $row['name'];
}
