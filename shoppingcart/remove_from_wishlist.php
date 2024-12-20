<?php
session_start();
include_once '../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'User not logged in']));
}

if (!isset($_POST['wishlist_id'])) {
    die(json_encode(['success' => false, 'message' => 'Wishlist ID is missing']));
}

$user_id = intval($_SESSION['user_id']);
$wishlist_id = intval($_POST['wishlist_id']);

$stmt = $conn->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $wishlist_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to remove from wishlist']);
}

$stmt->close();
$conn->close();
