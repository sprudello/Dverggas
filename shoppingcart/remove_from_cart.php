<?php
session_start();
include_once '../db/connection.php';

if (isset($_POST['cart_id']) && isset($_SESSION['user_id'])) {
    $cart_id = intval($_POST['cart_id']);
    $user_id = intval($_SESSION['user_id']);

    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit;
    }
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: shoppingcart.php");
    exit();
} else {
    echo "Error: Cart ID or User ID is missing.";
}
?>
