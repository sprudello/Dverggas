<?php
session_start();
include_once '../db/connection.php';

if (isset($_POST['product_id']) && isset($_SESSION['user_id']) && isset($_POST['category_id'])) {
    $product_id = intval($_POST['product_id']);
    $user_id = intval($_SESSION['user_id']);
    $category_id = intval($_POST['category_id']);
    $quantity = 1;
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    $stmt->execute();
    $stmt->close();

    header("Location: ../category.php?id=" . $category_id);
    exit();
} else {
    echo "Error: Product ID, User ID, or Category ID is missing.";
}
?>