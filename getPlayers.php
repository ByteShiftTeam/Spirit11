<?php
header('Content-Type: application/json');
$servername = "localhost"; // Change if needed
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "game_website"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// SQL query to get players
$sql = "SELECT name, university, category, totalRuns, ballsFaced, inningsPlayed, wickets, oversBowled, runsConceded FROM players";
$result = $conn->query($sql);

$players = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $players[] = $row;
    }
}

// Close the connection
$conn->close();

// Output players as JSON
echo json_encode($players);
?>
