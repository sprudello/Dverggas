<?php
session_start();
include_once 'include/head.php';
include_once 'include/header.php';
?>

<div class="shopping-cart-page">
    <h1>Shopping Cart</h1>
    
    <div class="cart-container">
        <div class="cart-items-container">
            <!-- This will be populated by JavaScript -->
            <div id="cart-items-full" class="cart-items">
                <p class="empty-cart">Your cart is empty</p>
            </div>
        </div>
        
        <div class="cart-summary">
            <h2>Order Summary</h2>
            <div class="summary-row">
                <span>Subtotal:</span>
                <span id="subtotal">0.00 CHF</span>
            </div>
            <div class="summary-row">
                <span>Shipping:</span>
                <span id="shipping">0.00 CHF</span>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <span id="total">0.00 CHF</span>
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
