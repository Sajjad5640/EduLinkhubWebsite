<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart | BookStore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #00d4aa;
            --secondary-color: #0091ea;
            --dark-color: #1a237e;
            --light-color: #f5f7fa;
            --danger-color: #ff5252;
            --success-color: #4caf50;
            --text-dark: #333;
            --text-light: #666;
            --transition: all 0.3s ease;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f9fafc;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header Styles */
        .cart-header {
            text-align: center;
            margin-bottom: 3rem;
            animation: fadeInDown 0.6s ease-out;
        }

        .cart-header h1 {
            font-size: 2.5rem;
            color: var(--dark-color);
            margin-bottom: 1rem;
        }

        .cart-header .breadcrumb {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            color: var(--text-light);
        }

        .breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Main Layout */
        .cart-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .cart-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Cart Items */
        .cart-items {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--box-shadow);
            animation: fadeInLeft 0.6s ease-out;
        }

        .cart-items h2 {
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 100px 1fr 150px;
            gap: 1.5rem;
            padding: 1.5rem 0;
            border-bottom: 1px solid #eee;
            transition: var(--transition);
        }

        @media (max-width: 576px) {
            .cart-item {
                grid-template-columns: 80px 1fr;
                grid-template-rows: auto auto;
            }
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item:hover {
            background-color: rgba(0, 212, 170, 0.03);
        }

        .cart-item-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .cart-item-img:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .cart-item-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .cart-item-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .cart-item-author {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .cart-item-actions {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .action-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
            font-size: 0.9rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .action-btn:hover {
            color: var(--dark-color);
            text-decoration: underline;
        }

        .action-btn i {
            font-size: 0.8rem;
        }

        .cart-item-price {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
        }

        @media (max-width: 576px) {
            .cart-item-price {
                grid-column: 1 / -1;
                flex-direction: row;
                align-items: center;
                margin-top: 1rem;
            }
        }

        .price-amount {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .original-price {
            text-decoration: line-through;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .discount-badge {
            background-color: var(--danger-color);
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-left: 0.5rem;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #ddd;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .quantity-btn:hover {
            background: var(--light-color);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .quantity-value {
            min-width: 30px;
            text-align: center;
            font-weight: 600;
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 3rem 0;
            animation: fadeIn 0.6s ease-out;
        }

        .empty-cart i {
            font-size: 3rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .empty-cart h3 {
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .empty-cart p {
            color: var(--text-light);
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            padding: 0.8rem 1.5rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: #00b894;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 212, 170, 0.3);
        }

        /* Order Summary */
        .order-summary {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--box-shadow);
            position: sticky;
            top: 2rem;
            animation: fadeInRight 0.6s ease-out;
        }

        .order-summary h2 {
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .order-totals {
            margin-top: 1.5rem;
        }

        .order-total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid #f5f5f5;
        }

        .order-total-row.total {
            font-weight: 700;
            font-size: 1.1rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
            border-bottom: none;
        }

        .coupon-form {
    position: relative;
    margin: 20px 0;
}

.coupon-message {
    font-size: 0.9rem;
    margin-top: 8px;
    padding: 5px;
    border-radius: 4px;
    display: none;
}

.coupon-message.success {
    display: block;
    background-color: #e6f7ee;
    color: #00a65a;
}

.coupon-message.error {
    display: block;
    background-color: #fdecea;
    color: #f44336;
}
        .btn-apply {
            padding: 0 1.5rem;
            background: var(--dark-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-apply:hover {
            background: #0d47a1;
        }

        .checkout-btn {
            width: 100%;
            padding: 1rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .checkout-btn:hover {
            background: #00b894;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 212, 170, 0.3);
        }

        .checkout-btn:active {
            transform: translateY(0);
        }

        .payment-security {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
            color: var(--text-light);
            font-size: 0.9rem;
        }

       
/* Updated Recommendations CSS */
.recommendations {
    margin-top: 3rem;
    animation: fadeIn 0.6s ease-out;
    overflow: hidden; /* Hide the horizontal scrollbar */
    position: relative;
}

.recommendations h2 {
    margin-bottom: 1.5rem;
    color: var(--dark-color);
    font-size: 1.5rem;
}

.recommendation-container {
    width: 100%;
    overflow: hidden;
}

.recommendation-grid {
    display: flex;
    gap: 1.5rem;
    padding-bottom: 20px; /* Space for scrollbar if needed */
    animation: scroll 30s linear infinite;
}

.recommendation-item {
    min-width: 200px; /* Fixed width for each item */
    flex-shrink: 0;
    background: white;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.recommendation-item:hover {
    transform: translateY(-5px);
}

@keyframes scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(calc(-100% + 100vw)); /* Scroll all the way left */
    }
}


        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Pulse Animation */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .pulse {
            animation: pulse 1.5s infinite;
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .loading-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(0, 212, 170, 0.2);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 1rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="cart-header">
            <h1><i class="fas fa-shopping-cart"></i> Your Shopping Cart</h1>
            <div class="breadcrumb">
                <span><a href="index1.php">Home</a></span>
                <span>/</span>
                <span>Shopping Cart</span>
            </div>
        </header>

        <main class="cart-grid">
            <section class="cart-items" id="cartItemsContainer">
                <!-- Cart items will be dynamically inserted here -->
            </section>
            
            <aside class="order-summary">
                <h2><i class="fas fa-receipt"></i> Order Summary</h2>
                
                <div class="order-totals">
                    <div class="order-total-row">
                        <span>Subtotal</span>
                        <span id="subtotal">৳0.00</span>
                    </div>
                    <div class="order-total-row">
                        <span>Shipping</span>
                        <span>৳60.00</span>
                    </div>
                    <div class="order-total-row">
                        <span>Discount</span>
                        <span id="discount">-৳0.00</span>
                    </div>
                    <div class="order-total-row total">
                        <span>Total</span>
                        <span id="total">৳0.00</span>
                    </div>
                </div>
                
                <div class="coupon-form">
    <input type="text" class="coupon-input" id="couponCode" placeholder="Coupon code">
    <button class="btn-apply" id="applyCouponBtn">Apply</button>
    <div class="coupon-message" id="couponMessage"></div>
</div>
                
                <button class="checkout-btn pulse" id="checkoutBtn">
                    <i class="fas fa-lock"></i> Proceed to Checkout
                </button>
                
                <div class="payment-security">
                    <i class="fas fa-shield-alt"></i>
                    <span>Secure checkout</span>
                </div>
            </aside>
        </main>
        
        <section class="recommendations">
            <h2><i class="fas fa-star"></i> You Might Also Like</h2>
            <div class="recommendation-grid" id="recommendations">
                <!-- Recommendations will be dynamically inserted here -->
            </div>
        </section>
    </div>
    
    <!-- Enhanced Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-content">
        <div class="book-loader">
            <div class="book">
                <div class="page"></div>
                <div class="page"></div>
                <div class="page"></div>
                <div class="page"></div>
            </div>
        </div>
        <div class="loading-text">
            <p class="loading-message">Preparing your books</p>
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Loading Overlay Styles */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.95);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    
    .loading-overlay.active {
        opacity: 1;
        pointer-events: all;
    }
    
    .loading-content {
        text-align: center;
        max-width: 300px;
        padding: 30px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        transform: translateY(20px);
        animation: floatIn 0.5s ease-out forwards;
    }
    
    /* Book Loading Animation */
    .book-loader {
        margin: 0 auto 25px;
        perspective: 1000px;
    }
    
    .book {
        width: 80px;
        height: 60px;
        position: relative;
        transform-style: preserve-3d;
        animation: bookTilt 4s infinite ease-in-out;
    }
    
    .page {
        position: absolute;
        width: 40px;
        height: 60px;
        background: #f5f7fa;
        border-radius: 0 5px 5px 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transform-origin: left center;
    }
    
    .page:nth-child(1) {
        animation: pageFlip 4s infinite 4s ease-in-out;
    }
    
    .page:nth-child(2) {
        animation: pageFlip 4s infinite 5s ease-in-out;
    }
    
    .page:nth-child(3) {
        animation: pageFlip 4s infinite 6s ease-in-out;
    }
    
    .page:nth-child(4) {
        animation: pageFlip 4s infinite 5s ease-in-out;
    }
    
    /* Loading Text */
    .loading-text {
        margin-top: 20px;
    }
    
    .loading-message {
        font-size: 1.1rem;
        color: #032b56;
        margin-bottom: 15px;
        font-weight: 500;
        animation: textPulse 2s infinite;
    }
    
    /* Progress Bar */
    .progress-bar {
        height: 6px;
        background: #e0e5ec;
        border-radius: 3px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        width: 0;
        background: linear-gradient(90deg, #00d4aa, #0091ea);
        border-radius: 3px;
        animation: progressLoad 2.5s infinite ease-in-out;
    }
    
    /* Animations */
    @keyframes bookTilt {
        0%, 100% { transform: rotateY(-10deg); }
        50% { transform: rotateY(10deg); }
    }
    
    @keyframes pageFlip {
        0%, 30% { transform: rotateY(0); }
        70%, 100% { transform: rotateY(-160deg); }
    }
    
    @keyframes floatIn {
        to { transform: translateY(0); }
    }
    
    @keyframes textPulse {
        0%, 100% { opacity: 0.8; }
        50% { opacity: 1; }
    }
    
    @keyframes progressLoad {
        0% { width: 0; left: 0; }
        50% { width: 100%; left: 0; }
        100% { width: 0; left: 100%; }
    }
</style>

<script>
    // Example usage in your cart manager
    window.cartManager = {
        showLoading: function(message = '') {
            const overlay = document.getElementById('loadingOverlay');
            if (message) {
                const messageEl = overlay.querySelector('.loading-message');
                if (messageEl) messageEl.textContent = message;
            }
            overlay.classList.add('active');
        },
        
        hideLoading: function() {
            document.getElementById('loadingOverlay').classList.remove('active');
        }
    };
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Get cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // DOM Elements
    const elements = {
        cartContainer: document.getElementById('cartItemsContainer'),
        subtotal: document.getElementById('subtotal'),
        discount: document.getElementById('discount'),
        total: document.getElementById('total'),
        checkoutBtn: document.getElementById('checkoutBtn'),
        loadingOverlay: document.getElementById('loadingOverlay'),
        recommendations: document.getElementById('recommendations'),
        couponInput: document.querySelector('.coupon-input'),
        applyCouponBtn: document.querySelector('.btn-apply'),
        couponMessage: document.getElementById('couponMessage') || createCouponMessageElement()
    };
    
    // Coupon codes database
    const couponCodes = {
        'WELCOME10': { type: 'percentage', value: 10, minPurchase: 0, name: '10% Welcome Discount' },
        'FREESHIP': { type: 'fixed', value: 60, minPurchase: 500, name: 'Free Shipping' },
        'BOOKLOVER': { type: 'percentage', value: 15, minPurchase: 1000, name: '15% Book Lover Discount' },
        'READMORE': { type: 'fixed', value: 100, minPurchase: 800, name: '৳100 Off' }
    };
    
    let appliedCoupon = null;

    // Initialize
    updateCartDisplay();
    loadRecommendationsFromDatabase();
    
    // Create coupon message element if it doesn't exist
    function createCouponMessageElement() {
        const couponForm = document.querySelector('.coupon-form');
        const messageEl = document.createElement('div');
        messageEl.id = 'couponMessage';
        messageEl.className = 'coupon-message';
        couponForm.appendChild(messageEl);
        return messageEl;
    }

    // Enhanced cart manager with coupon support
    window.cartManager = {
        addToCart: function(bookName, price, imageUrl = '') {
            showLoading();
            const existingItem = cart.find(item => item.name === bookName);
            
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    name: bookName,
                    price: parseFloat(price),
                    quantity: 1,
                    image: imageUrl || 'https://via.placeholder.com/100x120?text=Book'
                });
            }
            
            this.clearCoupon();
            updateCartDisplay();
            this.showNotification(`${bookName} added to cart!`, 'success');
        },
        
        updateQuantity: function(bookName, action) {
            showLoading();
            const item = cart.find(i => i.name === bookName);
            if (!item) return;
            
            if (action === 'increase') {
                item.quantity++;
            } else if (action === 'decrease' && item.quantity > 1) {
                item.quantity--;
            } else if (action === 'decrease' && item.quantity === 1) {
                this.removeFromCart(bookName);
                return;
            }
            
            this.clearCoupon();
            updateCartDisplay();
            this.showNotification(`Quantity updated for ${bookName}`, 'info');
        },
        
        removeFromCart: function(bookName) {
            showLoading();
            cart = cart.filter(item => item.name !== bookName);
            this.clearCoupon();
            updateCartDisplay();
            this.showNotification(`${bookName} removed from cart`, 'warning');
        },
        
        clearCoupon: function() {
            if (appliedCoupon) {
                appliedCoupon = null;
                elements.couponInput.value = '';
                elements.couponMessage.className = 'coupon-message';
                elements.couponMessage.textContent = '';
                updateCartDisplay();
            }
        },
        
        showNotification: function(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `cart-notification ${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
                <span>${message}</span>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('fade-out');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    };
    
    // Event listeners
    elements.checkoutBtn.addEventListener('click', function() {
        if (cart.length > 0) {
            // Save applied coupon to localStorage for use in checkout
            if (appliedCoupon) {
                localStorage.setItem('appliedCoupon', JSON.stringify(appliedCoupon));
            }
            window.location.href = 'product_payment.php';
        } else {
            cartManager.showNotification('Your cart is empty! Add items to proceed.', 'warning');
        }
    });
    
    elements.applyCouponBtn.addEventListener('click', applyCoupon);
    elements.couponInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyCoupon();
        }
    });

    // Helper functions
    function escapeString(str) {
        return str.replace(/'/g, "\\'").replace(/"/g, '&quot;');
    }
    
    function showLoading() {
        elements.loadingOverlay.classList.add('active');
        setTimeout(() => {
            elements.loadingOverlay.classList.remove('active');
        }, 500);
    }
    
    function calculateSubtotal() {
        return cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }
    
    function applyCoupon() {
        const couponCode = elements.couponInput.value.trim().toUpperCase();
        const subtotal = calculateSubtotal();
        
        // Reset message
        elements.couponMessage.className = 'coupon-message';
        elements.couponMessage.textContent = '';
        
        if (!couponCode) {
            elements.couponMessage.className = 'coupon-message error';
            elements.couponMessage.textContent = 'Please enter a coupon code';
            return;
        }
        
        if (appliedCoupon) {
            elements.couponMessage.className = 'coupon-message error';
            elements.couponMessage.textContent = 'A coupon is already applied';
            return;
        }
        
        if (!couponCodes[couponCode]) {
            elements.couponMessage.className = 'coupon-message error';
            elements.couponMessage.textContent = 'Invalid coupon code';
            return;
        }
        
        const coupon = couponCodes[couponCode];
        
        if (subtotal < coupon.minPurchase) {
            elements.couponMessage.className = 'coupon-message error';
            elements.couponMessage.textContent = `Minimum purchase of ৳${coupon.minPurchase} required for this coupon`;
            return;
        }
        
        // Apply the coupon
        appliedCoupon = {
            code: couponCode,
            ...coupon
        };
        
        elements.couponMessage.className = 'coupon-message success';
        elements.couponMessage.innerHTML = `
            <i class="fas fa-check-circle"></i> 
            <strong>${coupon.name}</strong> applied successfully!
            <button class="btn-remove-coupon" onclick="cartManager.clearCoupon()">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        updateCartDisplay();
    }
    
    function updateCartDisplay() {
        showLoading();
        let subtotal = calculateSubtotal();
        let shipping = 60;
        let discount = 0;
        
        // Apply coupon discount if available
        if (appliedCoupon) {
            if (appliedCoupon.type === 'percentage') {
                discount = subtotal * (appliedCoupon.value / 100);
            } else if (appliedCoupon.type === 'fixed') {
                discount = Math.min(appliedCoupon.value, subtotal);
            }
            
            // Special case for free shipping coupon
            if (appliedCoupon.code === 'FREESHIP') {
                shipping = 0;
            }
        }
        
        let total = subtotal + shipping - discount;
        
        // Update totals display
        elements.subtotal.textContent = `৳${subtotal.toFixed(2)}`;
        elements.discount.textContent = `-৳${discount.toFixed(2)}`;
        elements.total.textContent = `৳${total.toFixed(2)}`;
        
        // Update cart items
        let html = '';
        if (cart.length === 0) {
            html = `
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added any items to your cart yet.</p>
                    <a href="web-development.php" class="btn-primary">
                        <i class="fas fa-book-open"></i> Browse Books
                    </a>
                </div>
            `;
            elements.checkoutBtn.style.display = 'none';
        } else {
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                html += `
                    <div class="cart-item" data-id="${escapeString(item.name)}">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-img">
                        <div class="cart-item-details">
                            <div>
                                <h3 class="cart-item-title">${item.name}</h3>
                                <p class="cart-item-price">৳${item.price.toFixed(2)} each</p>
                            </div>
                            <div class="cart-item-actions">
                                <button class="action-btn" onclick="cartManager.removeFromCart('${escapeString(item.name)}')">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                                <button class="action-btn" onclick="cartManager.saveForLater('${escapeString(item.name)}')">
                                    <i class="fas fa-heart"></i> Save for later
                                </button>
                            </div>
                        </div>
                        <div class="quantity-section">
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="cartManager.updateQuantity('${escapeString(item.name)}', 'decrease')">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="quantity-value">${item.quantity}</span>
                                <button class="quantity-btn" onclick="cartManager.updateQuantity('${escapeString(item.name)}', 'increase')">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="item-total">৳${itemTotal.toFixed(2)}</div>
                        </div>
                    </div>
                `;
            });
            elements.checkoutBtn.style.display = 'flex';
        }
        
        elements.cartContainer.innerHTML = html;
        
        // Update cart count in header if exists
        const cartCount = document.getElementById('cartCount');
        if (cartCount) {
            cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
        }
        
        // Save to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    

// Updated loadRecommendationsFromDatabase function
function loadRecommendationsFromDatabase() {
    showLoading();
    
    fetch('get_recommendations.php')
        .then(response => response.json())
        .then(books => {
            let html = '';
            
            if (books.length > 0) {
                // Duplicate items to create infinite loop effect
                const duplicatedBooks = [...books, ...books];
                
                duplicatedBooks.forEach(book => {
                    const discountPercent = book.originalPrice ? 
                        Math.round(((book.originalPrice - book.price) / book.originalPrice) * 100) : 0;
                    
                    html += `
                        <div class="recommendation-item">
                            <img src="${book.image || 'https://via.placeholder.com/200x300?text=Book'}" 
                                 alt="${book.title}" class="recommendation-img">
                            <h3>${book.title}</h3>
                            <p>by ${book.author || 'Unknown Author'}</p>
                            <div class="price">
                                <span class="current-price">৳${book.price.toFixed(2)}</span>
                                ${book.originalPrice ? `
                                    <span class="original-price">৳${book.originalPrice.toFixed(2)}</span>
                                    <span class="discount-badge">${discountPercent}% OFF</span>
                                ` : ''}
                            </div>
                            <button class="btn-primary" 
                                    onclick="cartManager.addToCart('${escapeString(book.title)}', 
                                    ${book.price}, 
                                    '${book.image || ''}')">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    `;
                });
            } else {
                html = '<p>No recommendations available at the moment.</p>';
            }
            
            document.getElementById('recommendations').innerHTML = html;
            
            // Pause animation on hover
            const grid = document.querySelector('.recommendation-grid');
            grid.addEventListener('mouseenter', () => {
                grid.style.animationPlayState = 'paused';
            });
            grid.addEventListener('mouseleave', () => {
                grid.style.animationPlayState = 'running';
            });
        })
        .catch(error => {
            console.error('Error loading recommendations:', error);
            document.getElementById('recommendations').innerHTML = 
                '<p>Could not load recommendations. Please try again later.</p>';
        })
        .finally(() => {
            document.querySelector('.loading-overlay').classList.remove('active');
        });
}

    // Add dynamic styles
    document.head.insertAdjacentHTML('beforeend', `
        <style>
            .coupon-message {
                font-size: 0.9rem;
                margin-top: 8px;
                padding: 8px 12px;
                border-radius: 4px;
                display: none;
                width: 100%;
                position: relative;
            }
            
            .coupon-message.success {
                display: block;
                background-color: #e6f7ee;
                color: #00a65a;
            }
            
            .coupon-message.error {
                display: block;
                background-color: #fdecea;
                color: #f44336;
            }
            
            .btn-remove-coupon {
                background: none;
                border: none;
                color: inherit;
                position: absolute;
                right: 8px;
                cursor: pointer;
                padding: 0 4px;
            }
            
            .coupon-form {
                position: relative;
                margin: 20px 0;
            }
            
            .coupon-input {
                flex: 1;
                min-width: 150px;
                padding: 10px 15px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 0.9rem;
            }
            
            .btn-apply {
                background-color: #032b56;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 0.9rem;
                transition: background-color 0.3s;
            }
            
            .btn-apply:hover {
                background-color: #021d3a;
            }
            
            .recommendations-scroll {
                display: flex;
                overflow-x: auto;
                gap: 1.5rem;
                padding-bottom: 1rem;
                scrollbar-width: thin;
                scrollbar-color: var(--primary-color) #f1f1f1;
            }
            
            .recommendations-scroll::-webkit-scrollbar {
                height: 8px;
            }
            
            .recommendations-scroll::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }
            
            .recommendations-scroll::-webkit-scrollbar-thumb {
                background-color: var(--primary-color);
                border-radius: 10px;
            }
            
            .recommendation-item {
                flex: 0 0 auto;
                width: 200px;
            }
            
            .quantity-section {
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                gap: 0.5rem;
            }
            
            .item-total {
                font-weight: bold;
                color: var(--dark-color);
            }
        </style>
    `);
});
</script>
</body>
</html>