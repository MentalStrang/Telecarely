<?php
require_once __DIR__ . "/connection.php";

function database_get_last_patient()
{
	$connection = database_connection();
	$quirey = "select patient_id from patient ORDER BY patient_id DESC LIMIT 1";
	$result = mysqli_query($connection, $quirey);
	$last_patient = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $last_patient;
}

function database_get_all_patients()
{
	$connection = database_connection();
	$result = mysqli_query($connection, "select * from patient");
	$patients = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $patients;
}

function database_get_last_doctor()
{
	$connection = database_connection();
	$quiery = "select doctor_id from doctor ORDER BY doctor_id DESC LIMIT 1 ";
	$resutl = mysqli_query($connection, $quiery);
	$last_doctor = mysqli_fetch_all($resutl, MYSQLI_ASSOC);
	return $last_doctor;
}
