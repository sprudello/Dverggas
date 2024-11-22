<?php
session_start();
include_once '../include/head.php';
include_once '../include/header.php';
include_once '../db/connection.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

function getCartItems($conn, $userId) {
    $sql = "
    SELECT 
        cart.id AS cart_id, 
        products.id AS product_id, 
        products.title, 
        products.price, 
        cart.quantity 
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = ?
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        return [];
    }
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $cartItems = [];
    while($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }

    $stmt->close();
    return $cartItems;
}

// Retrieve cart items for the logged-in user
$cartItems = [];
$userId = $_SESSION['user_id'];
$cartItems = getCartItems($conn, $userId);

$conn->close();
?>

<div class="shopping-cart-page">
    <h1>Shopping Cart</h1>
    
    <div class="cart-container">
        <div class="cart-items-container">
            <div id="cart-items-full" class="cart-items">
                <?php if (!empty($cartItems)): ?>
                    <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item">
                            <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p>Price: <?php echo htmlspecialchars($item['price']); ?> CHF</p>
                            <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                            <form method="POST" action="remove_from_cart.php">
                                <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($item['cart_id']); ?>">
                                <button type="submit">Remove</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="empty-cart">Your cart is empty</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="cart-summary">
            <h2>Order Summary</h2>
            <div class="summary-row">
                <span>Subtotal:</span>
                <span id="subtotal">
                    <?php 
                    $subtotal = array_reduce($cartItems, function($sum, $item) {
                        return $sum + ($item['price'] * $item['quantity']);
                    }, 0);
                    echo number_format($subtotal, 2) . ' CHF';
                    ?>
                </span>
            </div>
            <div class="summary-row">
                <span>Shipping:</span>
                <span id="shipping">0.00 CHF</span>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <span id="total"><?php echo number_format($subtotal, 2); ?> CHF</span>
            </div>
            <a href="../checkout.php" class="checkout-button-large">Proceed to Checkout</a>
        </div>
    </div>
</div>

<?php include_once '../include/footer.php'; ?>
