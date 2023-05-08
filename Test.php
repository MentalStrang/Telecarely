// Assume that the database connection is already established
// using mysqli_connect() or PDO
<?php
$user_id = 1; // the ID of the user whose name we want to retrieve

// Query the database to retrieve the name of the user
$query = "SELECT name FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user was found in the database
if ($user) {
    // Output the name of the user
    echo "The name of the user with ID $user_id is " . $user['name'];
} else {
    // Handle the case where the user was not found
    echo "User with ID $user_id was not found in the database";
}

?>
