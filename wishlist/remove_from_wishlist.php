<?php
session_start();
include_once '../db/connection.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['wishlist_id'])) {
    die(json_encode(['success' => false, 'message' => 'Invalid request']));
}

$wishlist_id = intval($_POST['wishlist_id']);
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $wishlist_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to remove item']);
}

$stmt->close();
$conn->close();
