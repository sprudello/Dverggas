<?php
session_start();
include_once 'db/connection.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Not logged in']));
}

if (!isset($_POST['current_password']) || !isset($_POST['new_password'])) {
    die(json_encode(['success' => false, 'message' => 'Missing required fields']));
}

// Get current user's password hash
$stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Verify current password
if (!password_verify($_POST['current_password'], $user['password_hash'])) {
    die(json_encode(['success' => false, 'message' => 'Current password is incorrect']));
}

// Validate new password
if (strlen($_POST['new_password']) < 8) {
    die(json_encode(['success' => false, 'message' => 'New password must be at least 8 characters long']));
}

// Hash new password and update
$new_password_hash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
$stmt->bind_param('si', $new_password_hash, $_SESSION['user_id']);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update password']);
}

$stmt->close();
$conn->close();
