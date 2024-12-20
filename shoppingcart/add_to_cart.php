<?php
session_start();
include_once '../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Not logged in']));
}

if (!isset($_POST['product_id'])) {
    die(json_encode(['success' => false, 'message' => 'No product specified']));
}

$product_id = intval($_POST['product_id']);
$user_id = intval($_SESSION['user_id']);
$quantity = 1;

try {
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product added to cart']);
    } else {
        throw new Exception($stmt->error);
    }
    
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>
