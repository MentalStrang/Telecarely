<?php
require __DIR__ . "/../database/patient_inquiry.php";
require __DIR__ . "/../database/connection_users.php";
session_start();
// Initialize session and check if user is logged in

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $patients = database_get_all_user($user_id);
    $prescriptions = database_get_prescription($user_id);
    // print_r($prescriptions);
} else {
    // redirect to the login page if user made logout
    header('location: ../login.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Prescriptions</title>
    <link rel="stylesheet" href="../css/prescription.css" />
    <link rel="stylesheet" type="text/css" href="../css/patient_profile.css">


</head>

<body>
    <h1 style="text-align:center; margin-bottom: 70px;margin-top: 50px;">Your Prescriptions</h1>
    <div class="menu">
        <div class="doctor-profile">
            <img src="../images/pic-1.png" alt="Doctor Image">
            <h2><?php foreach ($patients as $patient) : ?>
                    <h2 style="color:white" ;><?= $patient['name'] ?></h2>
                <?php endforeach; ?>
            </h2>
        </div>
        <ul>
            <li><a href="../patient/patient_Index.php">Home</a></li>
            <li><a href="../patient/all_doctors.php">All Doctors</a></li>
            <li><a href="#">Your Prescriptions</a></li>
            <li><a href="../logout.php">logout</a></li>
        </ul>
    </div>
    <main>
        <?php foreach ($prescriptions as $prescription) : ?>
            <section>
                <h2>Prescription</h2>
                <p><strong>Doctor:</strong> <?= $prescription['doctor_id'] ?></p>
                <p><strong>Drug Name:</strong> <?= $prescription['drug_name'] ?> </p>
                <ul>
                    <li>Drug Amount: <?= $prescription["drug_amount"] ?> </li>
                </ul>
            </section>
        <?php endforeach; ?>
    </main>
</body>

</html>
