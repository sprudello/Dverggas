<!-- Header -->
<header>
    <button>
        <h1>Dverggas</h1>
    </button>
    <div>
        <i class="fa-solid fa-user" style="font-size: 24px; cursor: pointer;" onclick="toggleUserMenu()"></i>
        <div id="user-menu" style="display: none;">
            <?php if (isset($_SESSION['username'])): ?>
                <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?></p>
                <a href="auth/logout.php">Logout</a>
            <?php else: ?>
                <p>Welcome, Guest</p>
                <a href="auth/login.php">Login</a> 
                <a href="auth/register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>