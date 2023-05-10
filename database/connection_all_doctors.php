<?php
require __DIR__ . "/connection.php";

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
