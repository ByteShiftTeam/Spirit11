<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Include database connection
include 'db_connect.php';

// Get user details from the session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$team_name = $_SESSION['team_name'];

// Query to fetch user team details
$stmt = $conn->prepare("SELECT team_name FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <p>Team: <?php echo htmlspecialchars($team_name); ?></p>

    <!-- You can add additional team-related information here -->
    <p>Team details and statistics would be displayed here.</p>

    <a href="logout.php">Logout</a>
</body>
</html>
