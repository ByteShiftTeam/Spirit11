<?php
session_start();
include 'db_connect.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database for the user with the provided username
    $stmt = $conn->prepare("SELECT id, username, password, team_name FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $db_username, $hashed_password, $team_name);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        // Set session variables
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $db_username;
        $_SESSION['team_name'] = $team_name;

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Redirect back to login page with an error message
        header("Location: login.html?error=Invalid username or password!");
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
