<?php
// variables used 
$error = "";

// required pages
require __DIR__ . "/database/connection.php";
require_once __DIR__ . "/database/connection_users.php";


session_start();
// to prevent user to back to the login page if he is login
if (isset($_SESSION['user_id'])) {
    // Check the user's role
    $user_id = $_SESSION['user_id'];
    $user_role = get_user_role($user_id); // Replace this with your own function to get the user's role
    if ($user_role === 'doctor') {
        header('location: doctors/doctor_index.php');
    } elseif ($user_role === 'patient') {
        header('location: patient/patient_Index.php');
    } else {
        // Handle the case where the user's role is unknown
        // For example, you could redirect them to an error page or log them out
        // header('location: login.php');
    }
    exit();
}

$connection = database_connection();
if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($stmt = $connection->prepare('SELECT `id`, `password`, `role` FROM `users` WHERE `email` = ?')) {
        // Pass email to the query
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        // Check if the query returned any rows
        if ($stmt->num_rows > 0) {
            // Bind the password and role returned from the database to variables
            $stmt->bind_result($id, $hashed_password, $role);
            $stmt->fetch();
            // Verify the password entered by the user matches the hashed password from the database
            if (password_verify($password, $hashed_password)) {
                // Password is correct, set session variables and redirect the user to the dashboard
                $_SESSION['user_id'] = $id;
                $_SESSION['user_role'] = $role;
                // Redirect the user to the appropriate dashboard
                if ($role === 'doctor') {
                    header('location: doctors/doctor_index.php');
                } elseif ($role === 'patient') {
                    header('location: patient/patient_Index.php');
                } else {
                    // Handle the case where the user's role is unknown
                    // For example, you could redirect them to an error page or log them out
                    // header('location: login.php');
                }
                exit();
            } else {
                // Password is incorrect
                $error= 'The password you have entered is incorrect.';
            }
        } else {
            // User does not exist in the database
            $error = 'The email address you have entered does not exist in our records.';
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
