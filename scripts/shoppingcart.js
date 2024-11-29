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

function markAsRead(element) {
    element.classList.remove('unread');
    updateUnreadCount();
}

function markAllAsRead() {
    const notifications = document.querySelectorAll('.notification-item.unread');
    notifications.forEach(notification => {
        notification.classList.remove('unread');
    });
    updateUnreadCount();
}

function updateUnreadCount() {
    const unreadCount = document.querySelectorAll('.notification-item.unread').length;
    const bellIcon = document.querySelector('.fa-bell');
    
    if (unreadCount > 0) {
        bellIcon.style.color = '#6600cc';
    } else {
        bellIcon.style.color = 'inherit';
    }
}

// Initialize unread count when page loads
document.addEventListener('DOMContentLoaded', function() {
    updateUnreadCount();
});

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
    var notificationMenu = document.getElementById('notification-menu');
    
    // Close other menus if they're open
    if (cartMenu.style.display === 'block') {
        cartMenu.style.display = 'none';
    }
    if (notificationMenu.style.display === 'block') {
        notificationMenu.style.display = 'none';
    }
    
    // Toggle user menu
    userMenu.style.display = userMenu.style.display === 'none' ? 'block' : 'none';
}

function addToCart(event, form) {
    event.preventDefault();
    
    const formData = new FormData(form);
    
    fetch('../shoppingcart/add_to_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart menu
            const cartMenu = document.getElementById('cart-menu');
            const cartItemsDiv = cartMenu.querySelector('.cart-items');
            const cartTotalSpan = cartMenu.querySelector('.cart-total span:last-child');

            if (data.cartItems.length > 0) {
                cartItemsDiv.innerHTML = '';
                data.cartItems.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.classList.add('cart-item');
                    itemDiv.innerHTML = `
                        <p>${item.title}</p>
                        <p>Price: ${item.price} CHF</p>
                        <p>Quantity: ${item.quantity}</p>
                    `;
                    cartItemsDiv.appendChild(itemDiv);
                });
                cartTotalSpan.textContent = `${data.total} CHF`;
            }
            
            // Show cart menu
            cartMenu.style.display = 'block';
        } else {
            console.error('Failed to add item to cart:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateCartPreview() {
    fetch('../shoppingcart/get_cart.php')
        .then(response => response.json())
        .then(data => {
            const cartMenu = document.getElementById('cart-menu');
            const cartItemsDiv = cartMenu.querySelector('.cart-items');
            const cartTotalSpan = cartMenu.querySelector('.cart-total span:last-child');

            if (data.status === 'success' && data.cartItems.length > 0) {
                cartItemsDiv.innerHTML = ''; // Clear existing items
                let total = 0;

                data.cartItems.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.classList.add('cart-item');
                    itemDiv.innerHTML = `
                        <p>${item.title}</p>
                        <p>Price: ${item.price} CHF</p>
                        <p>Quantity: ${item.quantity}</p>
                    `;
                    cartItemsDiv.appendChild(itemDiv);
                    total += item.price * item.quantity;
                });

                cartTotalSpan.textContent = `${total.toFixed(2)} CHF`;
            } else {
                cartItemsDiv.innerHTML = '<p class="empty-cart">Your cart is empty</p>';
                cartTotalSpan.textContent = '0.00 CHF';
            }
        })
        .catch(error => console.error('Error fetching cart data:', error));
}

document.addEventListener('DOMContentLoaded', updateCartPreview);
