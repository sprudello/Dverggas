<header>
<<<<<<< Updated upstream
    <h1>This is the ECommerce Platform of the future</h1>
</header>
=======
    <button>
        <h1>Dverggas</h1>
    </button>
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
                <p>Willkommen, <?= htmlspecialchars($_SESSION['username']); ?></p>
                <a href="auth/logout.php">Logout</a>
            <?php else: ?>
                <p>Willkommen, Gast</p>
                <a href="auth/login.php">Login</a> 
                <a href="auth/register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>
>>>>>>> Stashed changes
