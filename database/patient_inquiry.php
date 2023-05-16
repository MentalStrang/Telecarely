<?php
require __DIR__ . "/connection.php";

function database_insert_inquiry($patient_id, $doctor_id, $patient_message)
{
    $connection = database_connection();
    // to prevent sql injection
    $query = "INSERT INTO inquiries(patient_id, doctor_id, `message`) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "iis", $patient_id, $doctor_id, $patient_message);
    $success = mysqli_stmt_execute($stmt);
    // check if the message inserted succefully in the database or not
    if ($success) {
        mysqli_stmt_close($stmt);
        mysqli_close($connection);
        return true;
    } else {
        $error_message = mysqli_error($connection);
        mysqli_stmt_close($stmt);
        mysqli_close($connection);
        return false;
    }
}


function database_insert_prescription($patient_id, $doctor_id, $drug_name, $drug_amount)
{
    $connection = database_connection();
    $query = "INSERT INTO `prescriptions` (`patient_id`, `doctor_id`, `drug_name`, `drug_amount`) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "iisi", $patient_id, $doctor_id, $drug_name, $drug_amount);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        mysqli_stmt_close($stmt);
        mysqli_close($connection);
        return true;
    } else {
        $error_message = mysqli_error($connection);
        mysqli_stmt_close($stmt);
        mysqli_close($connection);
        return false;
    }
}
// `patient_id` IN (SELECT `id` FROM `users` WHERE `role` = 'patient') and
function database_get_all_patient_inquiries($doctor_id)
{
    $connection = database_connection();
    $query = "SELECT * FROM `inquiries` WHERE  `doctor_id` = $doctor_id ";
    $stmt = mysqli_query($connection, $query);
    $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
    return $result;
}

function database_get_name_patient_from_inquiry($patient_id)
{
    $connection = database_connection();
    $query = "SELECT `name` FROM `users` WHERE `id` = $patient_id";
    $stmt = mysqli_query($connection, $query);
    $result = mysqli_fetch_assoc($stmt);
    mysqli_close($connection);
    return $result['name'];
}



// get the prescription 

function database_get_prescription($patient_id)
{
    $connection = database_connection();
    $stmt = mysqli_prepare($connection, "SELECT `drug_name`, `drug_amount`, `doctor_id` FROM `prescriptions` WHERE `patient_id` = ?");
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $prescriptions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
    return $prescriptions;
}
