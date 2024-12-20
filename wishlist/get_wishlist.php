<?php
session_start();
include_once '../db/connection.php';

$response = ['status' => 'error', 'wishlistItems' => []];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT products.title, products.price FROM wishlist JOIN products ON wishlist.product_id = products.id WHERE wishlist.user_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $response['wishlistItems'][] = $row;
        }

        $stmt->close();
        $response['status'] = 'success';
    } else {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
