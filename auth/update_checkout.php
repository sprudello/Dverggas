<?php
session_start();
include_once '../db/connection.php';

// Prüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Not logged in']));
}

$user_id = $_SESSION['user_id'];

// Überprüfen, ob user_id in der Benutzertabelle existiert
$stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die(json_encode(['success' => false, 'message' => 'User ID does not exist']));
}

$stmt->close();

// Überprüfen, ob es sich um eine POST-Anfrage handelt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validierung der Eingaben
    $card_number = $_POST['card-number'] ?? null;
    $expiry_date = $_POST['expiry-date'] ?? null;
    $card_name = $_POST['card-name'] ?? null;

    if (empty($card_number) || empty($expiry_date) || empty($card_name)) {
        die(json_encode(['success' => false, 'message' => 'Missing required fields']));
    }

    // Insert in die Tabelle payment_details
    $stmt = $conn->prepare("
        INSERT INTO payment_details (user_id, payment_type, card_number, card_holder_name, expiry_date)
        VALUES (?, 'credit_card', ?, ?, ?)
    ");

    if (!$stmt) {
        die(json_encode(['success' => false, 'message' => 'SQL preparation failed: ' . $conn->error]));
    }

    $stmt->bind_param('isss', $user_id, $card_number, $card_name, $expiry_date);

    if ($stmt->execute()) {
        // Erfolgreiche Weiterleitung
        header("Location: thank_you.php");
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to place order: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
