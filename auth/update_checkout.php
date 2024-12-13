<?php
session_start();
include_once '../db/connection.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Not logged in']));
}

$user_id = $_SESSION['user_id'];

// Debugging: Check if user_id exists in users table
$stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die(json_encode(['success' => false, 'message' => 'User ID does not exist']));
}

$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $card_number = $_POST['card-number'];
    $expiry_date = $_POST['expiry-date'];
    $card_name = $_POST['card-name'];

    // Insert payment method
    $stmt = $conn->prepare("INSERT INTO payment_methods (user_id, card_number, expiry_date, card_name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('isss', $user_id, $card_number, $expiry_date, $card_name);

    if ($stmt->execute()) {
        header("Location: thank_you.php");
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to place order']);
    }

    $stmt->close();
    $conn->close();
}
?>