<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not authenticated
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Welcome, <span id="username"></span>!</h2>
        <p class="text-center">Team: <span id="teamName"></span></p>

        <h3 class="mt-4">Your Team Details</h3>
        <p>Team statistics, performance, and other details will be shown here.</p>

        <!-- Logout Button -->
        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- Optional: JavaScript to fetch and display data -->
    <script>
        // Fetch user data from PHP and display it
        fetch('dashboard.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('username').textContent = data.username;
                document.getElementById('teamName').textContent = data.team_name;
            })
            .catch(error => console.error('Error fetching dashboard data:', error));
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
