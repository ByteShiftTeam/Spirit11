<?php
include 'db_connect.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $full_name = $_POST['full_name'];
    $team_name = $_POST['team_name'];

    // Prepare and execute the query to insert the user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, password, full_name, team_name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $full_name, $team_name);

    if ($stmt->execute()) {
        echo "Registration successful! <a href='login.html'>Login here</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
