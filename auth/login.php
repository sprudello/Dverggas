<?php
session_start();
include '../db/connection.php';
include_once '../include/head.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login']; 
    $password = $_POST['password'];

    if (empty($login) || empty($password)) {
        echo "Please fill all required fields!";
        exit;
    }
    
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE phone_number = ?");
    }
    
    $stmt->bind_param('s', $login);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo "Login successful!";
    } else {
        echo "Invalid login credentials!";
    }

    $stmt->close();
}
?>

<div class="login-box">
    <h2 class="login-title">Login</h2>
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

<?php include_once '../include/footer.php'; ?>