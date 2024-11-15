<?php
session_start();
include_once 'include/head.php';
include_once 'include/header.php';
include_once 'db/connection.php';

// Debugging: Check if user_id is set
if (!isset($_SESSION['user_id'])) {
    echo "User ID is not set in the session.";
    exit;
}

// Define function to get cart items
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

// Debugging: Output cart items
echo "<pre>";
print_r($cartItems);
echo "</pre>";

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
            <a href="checkout.php" class="checkout-button-large">Proceed to Checkout</a>
        </div>
    </div>
</div>

<style>
.shopping-cart-page {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.shopping-cart-page h1 {
    margin-bottom: 30px;
}

.cart-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

.cart-items-container {
    background-color: var(--card-bg-color);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px var(--shadow-color);
}

.cart-summary {
    background-color: var(--card-bg-color);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px var(--shadow-color);
    height: fit-content;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin: 10px 0;
    padding: 10px 0;
    border-bottom: 1px solid var(--shadow-color);
}

.summary-row.total {
    font-weight: bold;
    font-size: 1.2em;
    border-bottom: none;
}

.checkout-button-large {
    width: 100%;
    padding: 15px;
    background-color: #6600cc;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 1.1em;
    margin-top: 20px;
    display: inline-block;
    text-align: center;
    text-decoration: none;
}

.checkout-button-large:hover {
    background-color: #5800af;
    box-shadow: 0 0 20px rgba(102, 0, 204, 0.5);
}
</style>

<?php include_once 'include/footer.php'; ?>