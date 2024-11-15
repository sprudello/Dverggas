function toggleNotificationMenu() {
    var notificationMenu = document.getElementById('notification-menu');
    var userMenu = document.getElementById('user-menu');
    var cartMenu = document.getElementById('cart-menu');
    
    // Close other menus if they're open
    if (userMenu.style.display === 'block') {
        userMenu.style.display = 'none';
    }
    if (cartMenu.style.display === 'block') {
        cartMenu.style.display = 'none';
    }
    
    // Toggle notification menu
    notificationMenu.style.display = notificationMenu.style.display === 'none' ? 'block' : 'none';
}

function toggleCartMenu() {
    var cartMenu = document.getElementById('cart-menu');
    var userMenu = document.getElementById('user-menu');
    var notificationMenu = document.getElementById('notification-menu');
    
    // Close other menus if they're open
    if (userMenu.style.display === 'block') {
        userMenu.style.display = 'none';
    }
    if (notificationMenu.style.display === 'block') {
        notificationMenu.style.display = 'none';
    }
    
    // Toggle cart menu
    cartMenu.style.display = cartMenu.style.display === 'none' ? 'block' : 'none';
}

function toggleUserMenu() {
    var userMenu = document.getElementById('user-menu');
    var cartMenu = document.getElementById('cart-menu');
    
    // Close cart menu if it's open
    if (cartMenu.style.display === 'block') {
        cartMenu.style.display = 'none';
    }
    
    // Toggle user menu
    userMenu.style.display = userMenu.style.display === 'none' ? 'block' : 'none';
}
