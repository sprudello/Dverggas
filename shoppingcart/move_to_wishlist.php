<?php
session_start();
include_once '../db/connection.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['product_id']) || !isset($_POST['cart_id'])) {
    die(json_encode(['success' => false, 'message' => 'Invalid request']));
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);
$cart_id = intval($_POST['cart_id']);

// Start transaction
$conn->begin_transaction();

try {
    // Add to wishlist
    $stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE added_at = CURRENT_TIMESTAMP");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $stmt->close();

    // Remove from cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
