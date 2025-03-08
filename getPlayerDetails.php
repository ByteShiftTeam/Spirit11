<?php
include 'db_connect.php';

$id = $_GET['id'];

// Get player details
$stmt = $conn->prepare("SELECT id, name, university, budget FROM players WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$player = $result->fetch_assoc();

echo json_encode($player);

$stmt->close();
$conn->close();
?>
