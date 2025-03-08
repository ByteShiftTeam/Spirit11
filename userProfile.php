<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login if not authenticated
    exit();
}

// Include database connection
include 'db_connect.php';

// Get user details from the session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$team_name = $_SESSION['team_name'];

// Here, you can query additional data if needed
// For example, fetch user-specific team statistics or other information
// $stmt = $conn->prepare("SELECT * FROM team_stats WHERE user_id = ?");
// $stmt->bind_param("i", $user_id);
// $stmt->execute();
// $result = $stmt->get_result();
// $team_stats = $result->fetch_assoc();

// Prepare the data to send as JSON
$response = [
    'username' => $username,
    'team_name' => $team_name,
    // 'team_stats' => $team_stats, // Add more fields as needed
];

// Send the data as a JSON response
echo json_encode($response);

// Close the database connection
$conn->close();
?>
