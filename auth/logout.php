<?php
session_start();
session_destroy();
include_once '../include/head.php';
?>

<div class="login-box">
    <h2 class="login-title">Goodbye!</h2>
    <p>We wish you a happy day and hope to see you soon!</p>
    <a href="../index.php" class="back-home">Go to Homepage</a>
    <script>
    setTimeout(function() {
        window.location.href = '../index.php';
    }, 5000);
    </script>
</div>
