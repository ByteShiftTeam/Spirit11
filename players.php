<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database Connection
$servername = "localhost";
$username = "root";  // Change if necessary
$password = "";      // Change if necessary
$database = "users"; // Change to your actual database name

$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Table Query
$createTableQuery = "CREATE TABLE IF NOT EXISTS players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    University VARCHAR(255) NOT NULL,
    Category VARCHAR(50) NOT NULL,
    Total_Runs INT NOT NULL,
    Balls_Faced INT NOT NULL,
    Innings_Played INT NOT NULL,
    Wickets INT NOT NULL,
    Overs_Bowled INT NOT NULL,
    Runs_Conceded INT NOT NULL
)";

// Execute Table Creation
$conn->query($createTableQuery);

// Insert Data Query
$insertDataQuery = "INSERT INTO players (Name, University, Category, Total_Runs, Balls_Faced, Innings_Played, Wickets, Overs_Bowled, Runs_Conceded) VALUES
    ('Chamika Chandimal', 'University of the Visual & Performing Arts', 'Batsman', 530, 588, 10, 0, 3, 21),
    ('Dimuth Dhananjaya', 'University of the Visual & Performing Arts', 'All-Rounder', 250, 208, 10, 8, 40, 240),
    ('Avishka Mendis', 'Eastern University', 'All-Rounder', 210, 175, 7, 7, 35, 210),
    ('Danushka Kumara', 'University of the Visual & Performing Arts', 'Batsman', 780, 866, 15, 0, 5, 35),
    ('Praveen Vandersay', 'Eastern University', 'Batsman', 329, 365, 7, 0, 3, 24)";

$conn->query($insertDataQuery);

// Fetch Players from `players` Table
$sql = "SELECT * FROM players";
$result = $conn->query($sql);

// Convert result to JSON
$players = [];
while ($row = $result->fetch_assoc()) {
    $players[] = $row;
}

// Close Connection
$conn->close();

// Return JSON data
header('Content-Type: application/json');
echo json_encode($players);
?>
