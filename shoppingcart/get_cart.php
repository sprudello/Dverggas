<?php
session_start();
include_once '../include/head.php';
include_once '../include/header.php';
include_once '../db/connection.php';

$response = ['status' => 'error', 'cartItems' => []];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT products.title, products.price, cart.quantity FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $response['cartItems'][] = $row;
    }

    $stmt->close();
    $response['status'] = 'success';
}

$conn->close();
echo json_encode($response);
?>