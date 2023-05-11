<?php
session_start();
require __DIR__ . "/database/patient_inquiry.php";

$user_id = $_SESSION['user_id'];
if (!isset($_GET['id'])) {
    // handle error when id parameter is not set
}
$patient_id = $_GET['id'];

$errors = array();
$drug_name = "";
$drug_amount = "";
if (isset($_POST['submit'])) {
    $drug_name = trim($_POST['drug_name']);
    $drug_amount = trim($_POST['drug_amount']);
    if (empty($drug_name) || empty($drug_amount)) {
        $errors[] = "Name or amount cannot be empty.";
    } else {
        database_insert_prescription($patient_id, $user_id, $drug_name, $drug_amount);
        echo "your data is inserted";
        // exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Send Prescription</title>
    <link rel="stylesheet" type="text/css" href="css/inquiry.css">
</head>

<body>
    <div class="container">
        <h1>Send Prescription</h1>
        <?php if (!empty($errors)) { ?>
            <div class="errors">
                <?php foreach ($errors as $error) { ?>
                    <p><?php echo $error; ?></p>
                <?php } ?>
            </div>
        <?php } ?>
        <form action="prescription.php?id=<?php echo $patient_id; ?>" method="post">
            <label for="drug_name">Drug Name:</label>
            <textarea id="drug_name" name="drug_name" rows="5" required><?php echo $drug_name; ?></textarea>
            <label for="drug_amount">Drug Amount:</label>
            <input class="drug_amount" type="number" id="drug_amount" name="drug_amount" rows="1" required value="<?php echo $drug_amount; ?>">
            <input type="submit" value="Send Prescription" name="submit">
        </form>
    </div>
</body>

</html>
<script>
    // Prevent resubmission the from everytime
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
