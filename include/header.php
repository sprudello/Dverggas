<!-- Header -->
<header>
<a class="title-button" href="../index.php">Dverggas</a>
    <!-- Search Bar -->
    <form method="GET" action="search.php">
        <div class="searchbar">
            <input type="text" name="search_term" placeholder="Suche nach Produkten oder Kategorien">
            <button type="submit" title="Search for products">
                <i class="fa-solid fa-magnifying-glass"></i> Suche
            </button>
        </div>
    </form>
    <div class="header-icons">
        <div class="icon-container">
            <i class="fa-solid fa-bell" style="font-size: 24px; cursor: pointer;" onclick="toggleNotificationMenu()" title="Notifications"></i>
            <div id="notification-menu" style="display: none;">
                <h3>Notifications</h3>
                <div class="notification-items">
                    <p class="empty-notification">No new notifications</p>
                </div>
            </div>
        </div>
        <div class="icon-container">
            <i class="fa-solid fa-cart-shopping" style="font-size: 24px; cursor: pointer;" onclick="toggleCartMenu()" title="Shopping Cart"></i>
            <div id="cart-menu" style="display: none;">
                <h3>Shopping Cart</h3>
                <div class="cart-items">
                    <p class="empty-cart">Your cart is empty</p>
                </div>
                <hr class="cart-divider">
                <div class="cart-footer">
                    <div class="cart-total">
                        <span>Total:</span>
                        <span>0.00 CHF</span>
                    </div>
                    <div class="cart-buttons">
                        <a href="<?= $base_path; ?>checkout.php" class="checkout-button" title="Proceed to checkout">Checkout</a>
                        <a href="<?= $base_path; ?>shoppingcart/shoppingcart.php" class="view-cart-button" title="View shopping cart details">View Full Cart</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="icon-container">
            <i class="fa-solid fa-user" style="font-size: 24px; cursor: pointer;" onclick="toggleUserMenu()" title="User Menu"></i>
            <div id="user-menu" style="display: none;">
                <?php if (isset($_SESSION['username'])): ?>
                    <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?></p>
                    <a href="profile.php">My Profile</a>
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
                    <a href="auth/login.php" title="Sign in to your account">Login</a>
                    <a href="auth/register.php" title="Create a new account">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
