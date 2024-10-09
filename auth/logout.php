<?php
session_start();
session_destroy();
include_once '../include/head.php';
?>

<div class="login-box">
    <h2 class="login-title">Goodbye!</h2>
    <p>We wish you a happy day and hope to see you soon!</p>
    <a href="../index.php" class="back-home">Go to Homepage</a>
</div>

<?php include_once '../include/footer.php'; ?>