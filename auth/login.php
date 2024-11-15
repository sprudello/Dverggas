<?php
session_start();

include '../db/connection.php';
include_once '../include/head.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']); 
    $password = trim($_POST['password']);

    // Check for empty fields
    if (empty($login) || empty($password)) {
        $error_message = "Please fill all required fields!";
    } else {
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        } elseif (preg_match('/^\d{12}$/', $login)) { 
            $stmt = $conn->prepare("SELECT * FROM users WHERE phone_number = ?");
        } else {
            $error_message = "Invalid email or phone number format!";
        }

        if (empty($error_message)) {
            $stmt->bind_param('s', $login);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                echo "<script>window.location.href = '../index.php';</script>";
                exit;
            } else {
                $error_message = "Invalid login credentials!";
            }
            $stmt->close();
        }
    }
}
?>

<div class="login-box">
    <h2 class="login-title">Login</h2>
    <?php if (!empty($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <div class="input-group">
            <label for="login">Email or Phone Number</label>
            <input type="text" name="login" id="login" placeholder="Enter Email or Phone Number" required>
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter Password" required>
        </div>
        <button type="submit" class="login-button">Login</button>
    </form>
</div>
