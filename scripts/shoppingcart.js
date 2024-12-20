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
    if (cartMenu.style.display === 'block') {
        updateCartPreview();
    }
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

function updateCartPreview() {
    fetch('shoppingcart/get_cart.php')
        .then(response => {
            console.log('Response:', response);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Data:', data);
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