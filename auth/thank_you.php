<?php
session_start();
include_once '../include/head.php';
include_once '../include/header.php';
?>

<div class="thank-you-container">
    <h1>Thank You for Your Purchase!</h1>
    <p>Your order has been placed successfully. We appreciate your business.</p>
    <a href="../index.php" class="button">Continue Shopping</a>
</div>

<script>
setTimeout(function() {
    window.location.href = '../index.php';
}, 5000);
</script>

<?php include_once '../include/footer.php'; ?>