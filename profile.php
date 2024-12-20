<?php
session_start();
include_once 'include/head.php';
include_once 'include/header.php';
include_once 'db/connection.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<div class="profile-container" style="width: 1200px;">
    <!-- Sidebar -->
    <div class="profile-sidebar">
        <div class="sidebar-user">
            <div class="user-avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="user-info">
                <div class="sidebar-display-name" data-field="display_name">
                    <h3><?php echo htmlspecialchars($user['display_name'] ?: $user['username']); ?></h3>
                    <i class="fa-solid fa-pen edit-icon" title="Edit display name"></i>
                </div>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="#profile" class="active" onclick="showSection('profile')">
                <i class="fa-solid fa-user"></i> Profile
            </a>
            <a href="#settings" onclick="showSection('settings')">
                <i class="fa-solid fa-gear"></i> Settings
            </a>
            <a href="#notifications" onclick="showSection('notifications')">
                <i class="fa-solid fa-bell"></i> Notifications
            </a>
            <a href="#orders" onclick="showSection('orders')">
                <i class="fa-solid fa-box"></i> Orders
            </a>
            <a href="#lists" onclick="showSection('lists')">
                <i class="fa-solid fa-list"></i> Lists
            </a>
            <a href="#billing" onclick="showSection('billing')">
                <i class="fa-solid fa-credit-card"></i> Billing Information
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="profile-content">
        <!-- Profile Section -->
        <section id="profile" class="content-section active">
            <div class="section-header">
                <h2>Profile Information</h2>
                <div class="button-group">
                    <button id="done-button" class="done-button" style="display: none;">
                        <i class="fa-solid fa-check"></i> Done
                    </button>
                    <button class="edit-button">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <button class="change-password-button" onclick="showPasswordModal()">
                        <i class="fa-solid fa-key"></i> Change Password
                    </button>
                </div>
            </div>
            <div class="profile-details">
                <div class="detail-group" data-field="username">
                    <div class="detail-header">
                        <label>Username:</label>
                        <i class="fa-solid fa-pen edit-icon" style="display: none;"></i>
                    </div>
                    <div class="detail-content">
                        <p><?php echo htmlspecialchars($user['username']); ?></p>
                    </div>
                </div>
                <div class="detail-group" data-field="firstname">
                    <div class="detail-header">
                        <label>First Name:</label>
                        <i class="fa-solid fa-pen edit-icon" style="display: none;"></i>
                    </div>
                    <div class="detail-content">
                        <p><?php echo htmlspecialchars($user['firstname']); ?></p>
                    </div>
                </div>
                <div class="detail-group" data-field="lastname">
                    <div class="detail-header">
                        <label>Last Name:</label>
                        <i class="fa-solid fa-pen edit-icon" style="display: none;"></i>
                    </div>
                    <div class="detail-content">
                        <p><?php echo htmlspecialchars($user['lastname']); ?></p>
                    </div>
                </div>
                <div class="detail-group">
                    <div class="detail-header">
                        <label>Email:</label>
                        <i class="fa-solid fa-pen edit-icon" style="display: none;"></i>
                    </div>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
                <div class="detail-group">
                    <div class="detail-header">
                        <label>Phone:</label>
                        <i class="fa-solid fa-pen edit-icon" style="display: none;"></i>
                    </div>
                    <p><?php echo htmlspecialchars($user['phone_number'] ?: 'Not provided'); ?></p>
                </div>
                <div class="detail-group">
                    <div class="detail-header">
                        <label>Address:</label>
                        <i class="fa-solid fa-pen edit-icon" style="display: none;"></i>
                    </div>
                    <p>
                        <?php 
                        $address = htmlspecialchars($user['street']) . ' ' . htmlspecialchars($user['house_number']);
                        if (!empty($user['street2'])) {
                            $address .= "\n" . htmlspecialchars($user['street2']);
                        }
                        $address .= "\n" . htmlspecialchars($user['plz']) . ' ' . htmlspecialchars($user['city']);
                        $address .= "\n" . htmlspecialchars($user['country']);
                        echo nl2br($address);
                        ?>
                    </p>
                </div>
            </div>
        </section>

        <!-- Settings Section -->
        <section id="settings" class="content-section">
            <h2>Account Settings</h2>
            <div class="settings-options">
                <div class="setting-group">
                    <h3>Theme Settings</h3>
                    <div class="theme-switch-wrapper">
                        <span class="mode-text">Dark</span>
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="setting-group">
                    <h3>Language Preferences</h3>
                    <div class="setting-item">
                        <label for="language">Interface Language:</label>
                        <select id="language" class="settings-select">
                            <option value="en">English</option>
                            <option value="de">Deutsch</option>
                            <option value="fr">Français</option>
                            <option value="it">Italiano</option>
                        </select>
                    </div>
                    <div class="setting-item">
                        <label for="currency">Preferred Currency:</label>
                        <select id="currency" class="settings-select">
                            <option value="chf">CHF</option>
                            <option value="eur">EUR</option>
                            <option value="usd">USD</option>
                        </select>
                    </div>
                </div>

                <div class="setting-group">
                    <h3>Privacy Options</h3>
                    <div class="setting-item">
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider round"></span>
                        </label>
                        <span>Show Online Status</span>
                    </div>
                    <div class="setting-item">
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                        <span>Share Purchase History</span>
                    </div>
                    <div class="setting-item">
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider round"></span>
                        </label>
                        <span>Allow Product Recommendations</span>
                    </div>
                </div>

                <div class="setting-group">
                    <h3>Accessibility</h3>
                    <div class="setting-item">
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                        <span>High Contrast Mode</span>
                    </div>
                    <div class="setting-item">
                        <label for="font-size">Font Size:</label>
                        <select id="font-size" class="settings-select">
                            <option value="small">Small</option>
                            <option value="medium" selected>Medium</option>
                            <option value="large">Large</option>
                        </select>
                    </div>
                    <div class="setting-item">
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                        <span>Reduce Animations</span>
                    </div>
                </div>

                <div class="setting-group">
                    <h3>Advanced Settings</h3>
                    <div class="setting-item">
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                        <span>Enable Beta Features</span>
                    </div>
                    <div class="setting-item">
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider round"></span>
                        </label>
                        <span>Automatic Updates</span>
                    </div>
                    <button class="settings-button">Clear Cache</button>
                    <button class="settings-button">Export Data</button>
                </div>
            </div>
        </section>

        <!-- Notifications Section -->
        <section id="notifications" class="content-section">
            <h2>Notifications</h2>
            <div class="notification-settings">
                <h3>Notification Preferences</h3>
                <div class="settings-group">
                    <div class="setting-item">
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider round"></span>
                        </label>
                        <span>Email Notifications</span>
                    </div>
                    <p class="setting-description">Receive notifications about orders and updates via email</p>
                </div>
                
                <div class="settings-group">
                    <div class="setting-item">
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider round"></span>
                        </label>
                        <span>Order Updates</span>
                    </div>
                    <p class="setting-description">Get notified about order status changes</p>
                </div>
                
                <div class="settings-group">
                    <div class="setting-item">
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                        <span>Promotional Emails</span>
                    </div>
                    <p class="setting-description">Receive special offers and promotions</p>
                </div>
                
                <div class="settings-group">
                    <div class="setting-item">
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider round"></span>
                        </label>
                        <span>Security Alerts</span>
                    </div>
                    <p class="setting-description">Get notified about account security events</p>
                </div>
            </div>
            
            <div class="notifications-list">
                <h3>Recent Notifications</h3>
                <p>No new notifications</p>
            </div>
        </section>

        <!-- Orders Section -->
        <section id="orders" class="content-section">
            <h2>Order History</h2>
            <div class="orders-list">
                <?php
                // Fetch orders with their items
                $orders_query = "SELECT o.*, 
                               oi.quantity, 
                               oi.price_at_time,
                               p.title as product_title,
                               p.prod_desc as product_description
                               FROM orders o
                               LEFT JOIN order_items oi ON o.id = oi.order_id
                               LEFT JOIN products p ON oi.product_id = p.id
                               WHERE o.user_id = ?
                               ORDER BY o.order_date DESC";
                
                $stmt = $conn->prepare($orders_query);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $current_order_id = null;
                    while ($row = $result->fetch_assoc()) {
                        if ($current_order_id !== $row['id']) {
                            // Close previous order div if exists
                            if ($current_order_id !== null) {
                                echo "</div></div>";
                            }
                            // Start new order
                            $current_order_id = $row['id'];
                            ?>
                            <div class="order-item">
                                <div class="order-header">
                                    <h3>Order #<?php echo $row['id']; ?></h3>
                                    <p>Date: <?php echo date('F j, Y', strtotime($row['order_date'])); ?></p>
                                    <p>Status: <span class="order-status <?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></span></p>
                                    <p>Total: <?php echo number_format($row['total_amount'], 2); ?> CHF</p>
                                </div>
                                <div class="order-products">
                            <?php
                        }
                        // Display product info
                        if ($row['product_title']) {
                            ?>
                            <div class="order-product">
                                <h4><?php echo htmlspecialchars($row['product_title']); ?></h4>
                                <p><?php echo htmlspecialchars($row['product_description']); ?></p>
                                <p>Quantity: <?php echo $row['quantity']; ?></p>
                                <p>Price: <?php echo number_format($row['price_at_time'], 2); ?> CHF</p>
                            </div>
                            <?php
                        }
                    }
                    // Close last order div
                    if ($current_order_id !== null) {
                        echo "</div></div>";
                    }
                } else {
                    echo "<p>No orders found</p>";
                }
                $stmt->close();
                ?>
            </div>
        </section>

        <!-- Lists Section -->
        <section id="lists" class="content-section">
            <h2>My Lists</h2>
            <div class="lists-container">
                <div class="wishlist-section">
                    <h3>Wishlist</h3>
                    <div class="wishlist-items">
                <?php
                // Fetch wishlist items
                $wishlist_query = "SELECT w.id as wishlist_id, p.* FROM wishlist w 
                                 JOIN products p ON w.product_id = p.id 
                                 WHERE w.user_id = ?";
                $stmt = $conn->prepare($wishlist_query);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $wishlist_items = $stmt->get_result();

                if ($wishlist_items->num_rows > 0):
                    while ($item = $wishlist_items->fetch_assoc()):
                ?>
                    <div class="wishlist-item">
                        <div class="item-details">
                            <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p><?php echo htmlspecialchars($item['prod_desc']); ?></p>
                            <p class="price"><?php echo number_format($item['price'], 2); ?> CHF</p>
                        </div>
                        <div class="item-actions">
                            <form class="add-to-cart-form" onsubmit="addToCart(event, this)">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="category_id" value="<?php echo $item['category_id']; ?>">
                                <button type="submit" class="add-to-cart-btn" title="Add to Cart">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </form>
                            <form class="remove-from-wishlist-form" onsubmit="removeFromWishlist(event, this)">
                                <input type="hidden" name="wishlist_id" value="<?php echo $item['wishlist_id']; ?>">
                                <button type="submit" class="remove-from-wishlist-btn" title="Remove from Wishlist">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php 
                    endwhile;
                else:
                ?>
                    <p>Your wishlist is empty</p>
                <?php
                endif;
                $stmt->close();
                ?>
                    </div>
                </div>

                <div class="cart-section">
                    <h3>Shopping Cart</h3>
                    <div class="cart-items">
                    <?php
                    // Fetch cart items
                    $cart_query = "SELECT c.id as cart_id, p.* FROM cart c 
                                 JOIN products p ON c.product_id = p.id 
                                 WHERE c.user_id = ?";
                    $stmt = $conn->prepare($cart_query);
                    $stmt->bind_param("i", $_SESSION['user_id']);
                    $stmt->execute();
                    $cart_items = $stmt->get_result();

                    if ($cart_items->num_rows > 0):
                        while ($item = $cart_items->fetch_assoc()):
                    ?>
                        <div class="cart-item">
                            <div class="item-details">
                                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                <p><?php echo htmlspecialchars($item['prod_desc']); ?></p>
                                <p class="price"><?php echo number_format($item['price'], 2); ?> CHF</p>
                            </div>
                            <div class="item-actions">
                                <form class="move-to-wishlist-form" onsubmit="moveToWishlist(event, this)">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                    <button type="submit" class="move-to-wishlist-btn" title="Move to Wishlist">
                                        <i class="fa-solid fa-heart"></i>
                                    </button>
                                </form>
                                <form class="remove-from-cart-form" onsubmit="removeFromCart(event, this)">
                                    <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                    <button type="submit" class="remove-from-cart-btn" title="Remove from Cart">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php 
                        endwhile;
                    else:
                    ?>
                        <p>Your cart is empty</p>
                    <?php
                    endif;
                    $stmt->close();
                    ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Billing Information Section -->
        <section id="billing" class="content-section">
            <div class="section-header">
                <h2>Billing Information</h2>
            </div>
            <div class="profile-details">
                <div class="detail-group">
                    <label>Billing Address:</label>
                    <p>
                        <?php 
                        // Use same address as profile for now
                        $billing_address = htmlspecialchars($user['street']) . ' ' . htmlspecialchars($user['house_number']);
                        if (!empty($user['street2'])) {
                            $billing_address .= "\n" . htmlspecialchars($user['street2']);
                        }
                        $billing_address .= "\n" . htmlspecialchars($user['plz']) . ' ' . htmlspecialchars($user['city']);
                        $billing_address .= "\n" . htmlspecialchars($user['country']);
                        echo nl2br($billing_address);
                        ?>
                    </p>
                </div>
                <div class="detail-group">
                    <label>Payment Methods:</label>
                    <p>No payment methods saved</p>
                </div>
                <div class="detail-group">
                    <label>Billing History:</label>
                    <p>No billing history available</p>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Password Change Modal -->
<div id="password-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePasswordModal()">&times;</span>
        <h2>Change Password</h2>
        <form id="password-form" class="password-form">
            <div class="input-group">
                <label>Current Password</label>
                <input type="password" name="current_password" required>
            </div>
            <div class="input-group">
                <label>New Password</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="input-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" class="save-button">Update Password</button>
        </form>
    </div>
</div>

<script src="scripts/profile.js"></script>

<?php include_once 'include/footer.php'; ?>
