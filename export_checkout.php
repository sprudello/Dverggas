<?php
session_start();
include_once '../db/connection.php';


if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $stmt->close();
}


$cartItems = [];
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
    $stmt->close();
}


$data = [
    ['First Name', 'Last Name', 'Address', 'Product', 'Price', 'Quantity'],
    [$user_data['firstname'], $user_data['lastname'], $user_data['address'], '', '', '']
];

foreach ($cartItems as $item) {
    $data[] = ['', '', '', $item['title'], $item['price'], $item['quantity']];
}


header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="checkout_data.csv"');

$output = fopen('php://output', 'w');
foreach ($data as $row) {
    fputcsv($output, $row);
}
fclose($output);
exit;
?>