function toggleWishlistMenu() {
    var wishlistMenu = document.getElementById('wishlist-menu');
    var cartMenu = document.getElementById('cart-menu');
    var userMenu = document.getElementById('user-menu');
    var notificationMenu = document.getElementById('notification-menu');

    // Close other menus
    if (cartMenu.style.display === 'block') cartMenu.style.display = 'none';
    if (userMenu.style.display === 'block') userMenu.style.display = 'none';
    if (notificationMenu.style.display === 'block') notificationMenu.style.display = 'none';

    // Toggle wishlist menu
    wishlistMenu.style.display = wishlistMenu.style.display === 'none' ? 'block' : 'none';
    if (wishlistMenu.style.display === 'block') {
        updateWishlistPreview();
    }
}

function updateWishlistPreview() {
    const basePath = window.location.pathname.includes('/auth/') ? '../' : '';
    fetch(basePath + 'wishlist/get_wishlist.php')
        .then(response => response.json())
        .then(data => {
            const wishlistMenu = document.getElementById('wishlist-menu');
            const wishlistItemsDiv = wishlistMenu.querySelector('.wishlist-items');

            if (data.status === 'success' && data.wishlistItems.length > 0) {
                wishlistItemsDiv.innerHTML = '';
                data.wishlistItems.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.classList.add('wishlist-item');
                    itemDiv.innerHTML = `
                        <p>${item.title}</p>
                        <p>Price: ${item.price} CHF</p>
                    `;
                    wishlistItemsDiv.appendChild(itemDiv);
                });
            } else {
                wishlistItemsDiv.innerHTML = '<p class="empty-wishlist">Your wishlist is empty</p>';
            }
        })
        .catch(error => console.error('Error fetching wishlist data:', error));
}

function addToCart(event, form) {
    event.preventDefault();
    
    const formData = new FormData(form);
    const basePath = window.location.pathname.includes('/auth/') ? '../' : '';
    
    fetch(basePath + 'shoppingcart/add_to_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartPreview();
        } else {
            throw new Error(data.message || 'Failed to add product to cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function addToWishlist(event, form) {
    event.preventDefault();
    
    const formData = new FormData(form);
    const basePath = window.location.pathname.includes('/auth/') ? '../' : '';
    
    fetch(basePath + 'wishlist/add_to_wishlist.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateWishlistPreview();
        } else {
            throw new Error(data.message || 'Failed to add product to wishlist');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function removeFromWishlist(event, form) {
    event.preventDefault();
    
    const formData = new FormData(form);
    const basePath = window.location.pathname.includes('/auth/') ? '../' : '';
    
    fetch(basePath + 'wishlist/remove_from_wishlist.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            form.closest('.wishlist-item').remove();
            updateWishlistPreview();
        } else {
            throw new Error(data.message || 'Failed to remove item from wishlist');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function moveToWishlist(event, form) {
    event.preventDefault();
    
    const formData = new FormData(form);
    const basePath = window.location.pathname.includes('/auth/') ? '../' : '';
    const cartItem = form.closest('.cart-item');
    
    fetch(basePath + 'shoppingcart/move_to_wishlist.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove item from cart display
            if (cartItem) {
                cartItem.style.opacity = '0';
                setTimeout(() => {
                    cartItem.remove();
                    
                    // Check if cart is empty and show message if needed
                    const cartItems = document.querySelector('.cart-items');
                    if (cartItems && cartItems.children.length === 0) {
                        cartItems.innerHTML = '<p>Your cart is empty</p>';
                    }
                }, 300);
            }
            
            // Refresh both cart and wishlist displays
            updateCartPreview();
            updateWishlistPreview();
            
            // If we're on the profile page, refresh the wishlist section
            const wishlistItems = document.querySelector('.wishlist-items');
            if (wishlistItems) {
                location.reload();
            }
        } else {
            throw new Error(data.message || 'Failed to move item to wishlist');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to move item to wishlist');
    });
}

function removeFromCart(event, form) {
    event.preventDefault();
    
    const formData = new FormData(form);
    const basePath = window.location.pathname.includes('/auth/') ? '../' : '';
    
    fetch(basePath + 'shoppingcart/remove_from_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            form.closest('.cart-item').remove();
            updateCartPreview();
        } else {
            throw new Error(data.message || 'Failed to remove item from cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
