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
                <h3><?php echo htmlspecialchars($user['display_name'] ?: $user['username']); ?></h3>
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
            <a href="#wishlist" onclick="showSection('wishlist')">
                <i class="fa-solid fa-heart"></i> Wishlist
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
            </div>
            <div class="profile-details">
                <div class="detail-group">
                    <label>Username:</label>
                    <p><?php echo htmlspecialchars($user['username']); ?></p>
                </div>
                <div class="detail-group">
                    <label>Name:</label>
                    <p><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></p>
                </div>
                <div class="detail-group">
                    <label>Email:</label>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
                <div class="detail-group">
                    <label>Phone:</label>
                    <p><?php echo htmlspecialchars($user['phone_number'] ?: 'Not provided'); ?></p>
                </div>
                <div class="detail-group">
                    <label>Address:</label>
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
                        <span>Dark Mode</span>
                        <label class="switch">
                            <input type="checkbox" id="theme-switch">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="setting-group">
                    <h3>Change Password</h3>
                    <form class="settings-form">
                        <div class="input-group">
                            <label>Current Password</label>
                            <input type="password" name="current_password">
                        </div>
                        <div class="input-group">
                            <label>New Password</label>
                            <input type="password" name="new_password">
                        </div>
                        <div class="input-group">
                            <label>Confirm New Password</label>
                            <input type="password" name="confirm_password">
                        </div>
                        <button type="submit" class="save-button">Update Password</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Notifications Section -->
        <section id="notifications" class="content-section">
            <h2>Notifications</h2>
            <div class="notifications-list">
                <p>No new notifications</p>
            </div>
        </section>

        <!-- Orders Section -->
        <section id="orders" class="content-section">
            <h2>Order History</h2>
            <div class="orders-list">
                <p>No orders found</p>
            </div>
        </section>

        <!-- Wishlist Section -->
        <section id="wishlist" class="content-section">
            <h2>My Wishlist</h2>
            <div class="wishlist-items">
                <p>Your wishlist is empty</p>
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

<script src="scripts/profile.js"></script>
<script>
function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Show selected section
    document.getElementById(sectionId).classList.add('active');
    
    // Update sidebar active state
    document.querySelectorAll('.sidebar-nav a').forEach(link => {
        link.classList.remove('active');
    });
    document.querySelector(`a[href="#${sectionId}"]`).classList.add('active');
}
</script>

<?php include_once 'include/footer.php'; ?>
