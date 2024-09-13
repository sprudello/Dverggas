<?php
session_start();
include_once 'include/head.php';
?>

<?php if (isset($_SESSION['username'])): ?>
    <div style="color:red; position: absolute; top: 10px; right: 10px;">
        Logged in as <?= htmlspecialchars($_SESSION['username']); ?>
        <a href="auth/logout.php">Logout</a>
    </div>
<?php else: ?>
    <div style="position: absolute; top: 10px; right: 10px;">
        <a href="auth/login.php">Login</a> |
        <a href="auth/register.php">Register</a>
    </div>
<?php endif; ?>

<h1>Welcome to Dverggas!</h1>

<?php include_once 'include/footer.php'; ?>
