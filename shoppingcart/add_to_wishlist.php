<?php
session_start();
include_once '../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'User not logged in']));
}

if (!isset($_POST['product_id'])) {
    die(json_encode(['success' => false, 'message' => 'Product ID is missing']));
}

$user_id = intval($_SESSION['user_id']);
$product_id = intval($_POST['product_id']);

// Try to insert into wishlist
$stmt = $conn->prepare("INSERT IGNORE INTO wishlist (user_id, product_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $product_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Added to wishlist']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Already in wishlist']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add to wishlist']);
}

$stmt->close();
$conn->close();
