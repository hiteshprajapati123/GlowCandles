// Wait for Ziggy to be available
function initializeCart() {
    // Check if route helper is available
    if (typeof route === 'undefined') {
        console.warn('Route helper not loaded yet, retrying...');
        setTimeout(initializeCart, 100);
        return;
    }

    // Cart functionality
    class Cart {
        constructor() {
            this.bindEvents();
            this.updateCartCount();
        }

        // Update cart count in the UI
        updateCartCount() {
            fetch(route('cart.count'))
                .then(response => response.json())
                .then(data => {
                    const count = data.cart_count || data.count || 0;
                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.textContent = count;
                        el.classList.toggle('hidden', count === 0);
                    });
                    
                    // Dispatch custom event for Alpine.js components
                    const event = new CustomEvent('cart-updated', {
                        detail: { count: count }
                    });
                    window.dispatchEvent(event);
                })
                .catch(error => {
                    console.error('Error updating cart count:', error);
                });
        }

        // Add item to cart
        addItem(productId, quantity = 1, variant = 'Default') {
            const addButton = document.querySelector(`[data-product-id="${productId}"]`);
            const originalText = addButton ? addButton.innerHTML : '';
            
            if (addButton) {
                addButton.disabled = true;
                addButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            }

            return new Promise((resolve, reject) => {
                fetch(route('cart.add'), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity,
                        variant: variant
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Network response was not ok');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        this.updateCartCount();
                        this.showNotification('Item added to cart!', 'success');
                        
                        // Update button state on success
                        if (addButton) {
                            addButton.innerHTML = '<i class="fas fa-check"></i> Added to Cart';
                            setTimeout(() => {
                                if (addButton) {
                                    addButton.disabled = false;
                                    addButton.innerHTML = originalText;
                                }
                            }, 2000);
                        }
                        
                        // Redirect to cart after a short delay
                        setTimeout(() => {
                            window.location.href = route('cart.index');
                        }, 1000);
                        
                        resolve(data);
                    } else {
                        throw new Error(data.message || 'Failed to add item to cart');
                    }
                })
                .catch(error => {
                    console.error('Error adding to cart:', error);
                    this.showNotification(error.message || 'An error occurred', 'error');
                    
                    // Reset button state on error
                    if (addButton) {
                        addButton.disabled = false;
                        addButton.innerHTML = originalText;
                    }
                    
                    reject(error);
                });
            });
        }

        // Remove item from cart
        removeItem(rowId) {
            return new Promise((resolve, reject) => {
                fetch(`/cart/remove/${rowId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.updateCartCount(); // Update cart count
                        this.showNotification('Item removed from cart', 'success');
                        if (typeof this.loadCart === 'function') {
                            this.loadCart(); // Reload cart from server if method exists
                        }
                        resolve(data);
                    } else {
                        this.showNotification('Failed to remove item', 'error');
                        reject(data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.showNotification('An error occurred', 'error');
                    reject(error);
                });
            });
        }

        // Update item quantity
        updateQuantity(rowId, quantity) {
            return new Promise((resolve, reject) => {
                fetch(`/cart/update/${rowId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ quantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.updateCartCount(); // Update cart count
                        if (typeof this.loadCart === 'function') {
                            this.loadCart(); // Reload cart from server if method exists
                        }
                        resolve(data);
                    } else {
                        this.showNotification('Failed to update quantity', 'error');
                        reject(data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.showNotification('An error occurred', 'error');
                    reject(error);
                });
            });
        }

        // Clear the cart
        clearCart() {
            return new Promise((resolve, reject) => {
                fetch('/cart/clear', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.cart = [];
                        if (typeof this.saveCart === 'function') {
                            this.saveCart();
                        }
                        this.updateCartCount();
                        this.showNotification('Cart cleared', 'success');
                        resolve(data);
                    } else {
                        this.showNotification('Failed to clear cart', 'error');
                        reject(data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.showNotification('An error occurred', 'error');
                    reject(error);
                });
            });
        }

        // Show notification
        showNotification(message, type = 'success') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            notification.textContent = message;
            
            // Add to DOM
            document.body.appendChild(notification);
            
            // Remove after delay
            setTimeout(() => {
                notification.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Bind events
        bindEvents() {
            // Add to cart buttons
            document.addEventListener('click', (e) => {
                const addToCartBtn = e.target.closest('.add-to-cart');
                if (addToCartBtn) {
                    e.preventDefault();
                    const productId = addToCartBtn.dataset.productId;
                    const quantity = parseInt(addToCartBtn.dataset.quantity) || 1;
                    this.addItem(productId, quantity);
                }

                // Remove item buttons
                const removeFromCartBtn = e.target.closest('.remove-from-cart');
                if (removeFromCartBtn) {
                    e.preventDefault();
                    const rowId = removeFromCartBtn.dataset.rowId;
                    if (confirm('Are you sure you want to remove this item?')) {
                        this.removeItem(rowId);
                    }
                }

                // Update quantity inputs
                const quantityInput = e.target.closest('.update-quantity');
                if (quantityInput) {
                    const rowId = quantityInput.dataset.rowId;
                    const quantity = parseInt(quantityInput.value);
                    
                    if (quantity > 0) {
                        this.updateQuantity(rowId, quantity);
                    } else {
                        quantityInput.value = 1; // Reset to minimum quantity
                    }
                }
            });
        }
}

    // Initialize cart when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        window.cart = new Cart();
    });
}

// Start initialization
initializeCart();
