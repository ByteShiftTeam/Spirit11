<?php
include 'db_connect.php';

$category = isset($_GET['category']) ? $_GET['category'] : ''; // Get category from query parameter

// If category is provided, filter players by category
if ($category) {
    $stmt = $conn->prepare("SELECT id, name, university, budget FROM players WHERE category = ?");
    $stmt->bind_param("s", $category);
} else {
    // If no category is provided, fetch all players
    $stmt = $conn->prepare("SELECT id, name, university, budget FROM players");
}

$stmt->execute();
$result = $stmt->get_result();

$players = [];
while ($row = $result->fetch_assoc()) {
    $players[] = $row;
}

echo json_encode($players);

$stmt->close();
$conn->close();
?>
