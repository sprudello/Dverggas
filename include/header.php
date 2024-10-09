<!-- Header -->
<header>
    <a class="title-button" href="index.php">Dverggas</a>
    <!-- Search Bar -->
    <form method="GET" action="search.php">
        <div class="searchbar">
            <input type="text" name="search_term" placeholder="Suche nach Produkten oder Kategorien">
            <button type="submit">
                <i class="fa-solid fa-magnifying-glass"></i> Suche
            </button>
        </div>
    </form>
    <div>
        <i class="fa-solid fa-user" style="font-size: 24px; cursor: pointer;" onclick="toggleUserMenu()"></i>
        <div id="user-menu" style="display: none;">
            <?php if (isset($_SESSION['username'])): ?>
                <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?></p>
                <a href="auth/logout.php">Logout</a>
            <?php else: ?>
                <p>Welcome, Guest</p>
                <div class="switch-container">
                <p class="mode-text">Dark</p>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </div>
                <a href="auth/login.php">Login</a>
                <a href="auth/register.php">Register</a>
            <?php endif; ?>
        </div>

    </div>
</header>