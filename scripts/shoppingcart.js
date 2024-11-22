function toggleCartMenu() {
    var cartMenu = document.getElementById('cart-menu');
    var userMenu = document.getElementById('user-menu');
    
    if (userMenu.style.display === 'block') {
        userMenu.style.display = 'none';
    }
    
    cartMenu.style.display = cartMenu.style.display === 'none' ? 'block' : 'none';
}

function toggleUserMenu() {
    var userMenu = document.getElementById('user-menu');
    var cartMenu = document.getElementById('cart-menu');
    
    if (cartMenu.style.display === 'block') {
        cartMenu.style.display = 'none';
    }
    
    userMenu.style.display = userMenu.style.display === 'none' ? 'block' : 'none';
}

function updateCartPreview() {
    fetch('get_cart.php')
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
