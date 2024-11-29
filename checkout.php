<?php
session_start();
include_once '../include/head.php';
include_once '../include/header.php';
include_once '../db/connection.php';

// Initialize variables
$user_data = null;

// Fetch user data if logged in
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $stmt->close();
}
?>

<div class="checkout-container">
    <div class="progress-container">
        <div class="progress-bar"></div>
        <div class="progress-steps">
            <div class="progress-step active">1</div>
            <div class="progress-step">2</div>
            <div class="progress-step">3</div>
            <div class="progress-step">4</div>
        </div>
    </div>

    <form id="checkout-form" method="post" action="">
        <div class="steps-container">
            <!-- Step 1: Review Cart -->
            <div class="step active">
                <h2>Review Your Cart</h2>
                <!-- Add your cart review content here -->
            </div>
            <!-- Add other steps here -->
        </div>
    </form>
</div>

<?php include_once '../include/footer.php'; ?>