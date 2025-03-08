<?php
session_start();
include 'db_connect.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database for the user with the provided username
    $stmt = $conn->prepare("SELECT id, username, password, team_name FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password, $team_name);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        // Set session variables
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['team_name'] = $team_name;

        // Redirect to user interface
        header("Location: dashboard.php");
    } else {
        echo "Invalid username or password!";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
