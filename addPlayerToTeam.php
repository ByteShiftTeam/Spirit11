<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$player_id = $_POST['player_id'];

// Check if player is already in the user's team
$stmt = $conn->prepare("SELECT * FROM user_teams WHERE user_id = ? AND player_id = ?");
$stmt->bind_param("ii", $user_id, $player_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['error' => 'Player already in your team']);
} else {
    // Add player to team
    $stmt = $conn->prepare("INSERT INTO user_teams (user_id, player_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $player_id);
    $stmt->execute();

    echo json_encode(['success' => 'Player added to your team']);
}

$stmt->close();
$conn->close();
?>
