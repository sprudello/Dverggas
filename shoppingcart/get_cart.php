<?php
session_start();
include_once '../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "SELECT products.title, products.price, cart.quantity FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

echo json_encode(['status' => 'success', 'cartItems' => $cartItems]);
$conn->close();
?>
