<?php
session_start();
include_once '../db/connection.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['field']) || !isset($_POST['value'])) {
    die(json_encode(['success' => false, 'message' => 'Invalid request']));
}

$allowed_fields = [
    'username', 'firstname', 'lastname', 'display_name', 
    'email', 'phone_number', 'street', 'street2', 
    'house_number', 'plz', 'city', 'country'
];

$field = $_POST['field'];
$value = trim($_POST['value']);

if (!in_array($field, $allowed_fields)) {
    die(json_encode(['success' => false, 'message' => 'Invalid field']));
}

// Validation
switch ($field) {
    case 'email':
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            die(json_encode(['success' => false, 'message' => 'Invalid email format']));
        }
        break;
    case 'plz':
        if (!preg_match('/^\d{5}$/', $value)) {
            die(json_encode(['success' => false, 'message' => 'PLZ must be 5 digits']));
        }
        break;
    case 'username':
    case 'display_name':
        if (!preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $value)) {
            die(json_encode(['success' => false, 'message' => 'Invalid format']));
        }
        break;
}

$stmt = $conn->prepare("UPDATE users SET $field = ? WHERE id = ?");
$stmt->bind_param('si', $value, $_SESSION['user_id']);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Update failed']);
}

$stmt->close();
$conn->close();
?>
