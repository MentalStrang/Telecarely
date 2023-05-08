<?php
// variables used 
$error = "";

require __DIR__ . "/database/connection.php";
$connection = database_connection();
if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // if ($query = $connection->query("SELECT `password` FROM `users` WHERE `email` = '$email' ")) {
    //     if ($query->num_rows > 0) {
    //         $result = $query->fetch_array();
    //         if (password_verify($password, $result[0])) {
    //             echo "password is correct";
    //         } else {
    //             $error = "Invalid Email or Password";
    //         }
    //     }
    // }

    // start sessions

    if ($stmt = $connection->prepare('SELECT `id`, `password` FROM `users` WHERE `email` = ?')) {
        // Pass email to the query
        $stmt->bind_param('s', $_POST['email']);
        $stmt->execute();
        $stmt->store_result();
        // Check if the query returned any rows
        if ($stmt->num_rows > 0) {
            // Bind the password returned from the database to the $hashed_password variable
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();
            // Verify the password entered by the user matches the hashed password from the database
            if (password_verify($_POST['password'], $hashed_password)) {
                // Password is correct, set session variables and redirect the user to the dashboard
                session_start();
                $_SESSION['user_id'] = $user_id;
                header('Location: patient/patient_Index.php');
                exit();
                $_SESSION['login'];
                $_SESSION['login'] = true;
                $_SESSION['patient_uid'] = $patientId;
            } else {
                // Password is incorrect
                $error = 'The password you have entered is incorrect.';
            }
        } else {
            // User does not exist in the database
            $error = 'The email address you have entered does not exist in our records';
        }
        $stmt->close();
    }
    // Check if the email/password is empty or null
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            exit('Please fill in both email and password fields.');
        }
    }
}

/*
* Check if email is valid or not.
* eg. hellothere is not a valid email
* eg. hellothere@gmail.com is a valid one
*/
// if ($_SERVER['REQUEST_METHOD'] == "POST") {
//     if (filter_var($_POST["email"])) {
//         $RequiredMail = "De email dient ingevult te worden";
//     } else {
//         exit('The email address you have entered is invalid. Please enter a valid email address and try again.');
//     }
// }


?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css" />
</head>

<body>
    <div class="login-container">
        <h1>Login</h1>
        <form method="post" action="login.php">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" required />

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />
            <? if ($error = "") : ?>
                <p style="color: red; margin-top:-12px"> <?= $error ?> </p>
            <? endif; ?>
            <button type="submit" name="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>

</body>

</html>
<script>
    // Prevent resubmission the from everytime
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
