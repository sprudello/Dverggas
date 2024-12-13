<?php
session_start();
include_once '../db/connection.php';

if (isset($_POST['product_id']) && isset($_SESSION['user_id']) && isset($_POST['category_id'])) {
    $product_id = intval($_POST['product_id']);
    $user_id = intval($_SESSION['user_id']);
    $category_id = intval($_POST['category_id']);
    $quantity = 1;

    // Check if item already exists in cart
    $check_stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $check_stmt->bind_param("ii", $user_id, $product_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Update existing item quantity
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
    } else {
        // Insert new item
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    }
    if ($stmt->execute()) {
        // Get updated cart data
        $cart_query = "SELECT products.title, products.price, cart.quantity 
                      FROM cart 
                      JOIN products ON cart.product_id = products.id 
                      WHERE cart.user_id = ?";
        $cart_stmt = $conn->prepare($cart_query);
        $cart_stmt->bind_param("i", $user_id);
        $cart_stmt->execute();
        $result = $cart_stmt->get_result();
        
        $cartItems = [];
        $total = 0;
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
            $total += $row['price'] * $row['quantity'];
        }
        
        echo json_encode([
            'success' => true,
            'cartItems' => $cartItems,
            'total' => number_format($total, 2)
        ]);
        
        $cart_stmt->close();
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add item to cart'
        ]);
    }
    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error: Product ID, User ID, or Category ID is missing.'
    ]);
}
?>
