<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout | BookStore</title>
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
        .checkout-header {
            text-align: center;
            margin-bottom: 3rem;
            animation: fadeInDown 0.6s ease-out;
        }

        .checkout-header h1 {
            font-size: 2.5rem;
            color: var(--dark-color);
            margin-bottom: 1rem;
        }

        .checkout-header .progress-steps {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .progress-step {
            position: relative;
            padding: 0.5rem 2rem;
            color: var(--text-light);
            font-weight: 600;
        }

        .progress-step.active {
            color: var(--primary-color);
        }

        .progress-step.completed {
            color: var(--success-color);
        }

        .progress-step:not(:last-child):after {
            content: '';
            position: absolute;
            right: -10px;
            top: 50%;
            width: 20px;
            height: 1px;
            background: #ddd;
        }

        /* Main Layout */
        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Payment Form */
        .payment-form {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--box-shadow);
            animation: fadeInLeft 0.6s ease-out;
        }

        .payment-form h2 {
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 212, 170, 0.2);
            outline: none;
        }

        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-row .form-group {
            flex: 1;
        }

        /* Payment Methods */
        .payment-methods {
            margin-top: 2rem;
        }

        .payment-method {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .payment-method:hover {
            border-color: var(--primary-color);
        }

        .payment-method.active {
            border-color: var(--primary-color);
            background-color: rgba(0, 212, 170, 0.05);
        }

        .payment-method input {
            margin-right: 1rem;
        }

        .payment-method-icon {
            margin-right: 1rem;
            font-size: 1.5rem;
            color: var(--text-light);
        }

        .payment-method.active .payment-method-icon {
            color: var(--primary-color);
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
        }

        .order-items {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 1.5rem;
        }

        .order-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f5f5f5;
        }

        .order-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .order-item-img {
            width: 60px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 1rem;
        }

        .order-item-details {
            flex: 1;
        }

        .order-item-title {
            font-weight: 600;
            margin-bottom: 0.3rem;
        }

        .order-item-price {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .order-item-quantity {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .order-totals {
            margin-top: 1.5rem;
        }

        .order-total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
        }

        .order-total-row.total {
            font-weight: 700;
            font-size: 1.1rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        /* Secure Checkout Button */
        .btn-checkout {
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

        .btn-checkout:hover {
            background: #00b894;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 212, 170, 0.3);
        }

        .btn-checkout:active {
            transform: translateY(0);
        }

        /* Payment Security */
        .payment-security {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
            color: var(--text-light);
            font-size: 0.9rem;
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

        /* Credit Card Preview */
        .card-preview {
            background: linear-gradient(135deg, #3a4a6b, #1a237e);
            color: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(26, 35, 126, 0.2);
            transition: var(--transition);
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-preview:before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .card-preview:after {
            content: '';
            position: absolute;
            bottom: -30%;
            right: -20%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .card-chip {
            width: 50px;
            height: 40px;
            background: #ffc107;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            font-weight: bold;
        }

        .card-number {
            font-size: 1.5rem;
            letter-spacing: 2px;
            margin: 1rem 0;
            font-family: 'Courier New', monospace;
        }

        .card-details {
            display: flex;
            justify-content: space-between;
        }

        .card-name, .card-expiry {
            font-size: 0.9rem;
            opacity: 0.8;
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

        /* Success Animation */
        .success-animation {
            width: 100px;
            height: 100px;
            margin: 0 auto 2rem;
            position: relative;
        }

        .checkmark {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: block;
            stroke-width: 5;
            stroke: var(--success-color);
            stroke-miterlimit: 10;
            box-shadow: inset 0 0 0 rgba(76, 175, 80, 0.5);
            animation: fill 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
        }

        .checkmark-circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 5;
            stroke-miterlimit: 10;
            stroke: var(--success-color);
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .checkmark-check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }

        @keyframes stroke {
            100% { stroke-dashoffset: 0; }
        }

        @keyframes scale {
            0%, 100% { transform: none; }
            50% { transform: scale3d(1.1, 1.1, 1); }
        }

        @keyframes fill {
            100% { box-shadow: inset 0 0 0 100px rgba(76, 175, 80, 0); }
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .card-number {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="checkout-header">
            <h1>Secure Checkout</h1>
            <p>Complete your purchase with confidence</p>
            
            <div class="progress-steps">
                <div class="progress-step completed">
                    <i class="fas fa-shopping-cart"></i> Cart
                </div>
                <div class="progress-step active">
                    <i class="fas fa-credit-card"></i> Payment
                </div>
                <div class="progress-step">
                    <i class="fas fa-check-circle"></i> Confirmation
                </div>
            </div>
        </header>

        <main class="checkout-grid">
            <section class="payment-form">
                <h2><i class="fas fa-credit-card"></i> Payment Information</h2>
                
                <div class="card-preview" id="cardPreview">
                    <div class="card-chip">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <div class="card-number" id="cardNumberDisplay">•••• •••• •••• ••••</div>
                    <div class="card-details">
                        <div class="card-name" id="cardNameDisplay">YOUR NAME</div>
                        <div class="card-expiry" id="cardExpiryDisplay">••/••</div>
                    </div>
                </div>
                
                <form id="paymentForm">
                    <div class="form-group">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" id="cardNumber" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                    </div>
                    
                    <div class="form-group">
                        <label for="cardName">Name on Card</label>
                        <input type="text" id="cardName" class="form-control" placeholder="John Doe">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cardExpiry">Expiration Date</label>
                            <input type="text" id="cardExpiry" class="form-control" placeholder="MM/YY" maxlength="5">
                        </div>
                        <div class="form-group">
                            <label for="cardCvc">Security Code</label>
                            <input type="text" id="cardCvc" class="form-control" placeholder="CVC" maxlength="4">
                        </div>
                    </div>
                    
                    <div class="payment-methods">
                        <h3>Payment Method</h3>
                        
                        <div class="payment-method active" data-method="credit">
                            <input type="radio" name="paymentMethod" id="creditCard" checked>
                            <div class="payment-method-icon">
                                <i class="far fa-credit-card"></i>
                            </div>
                            <label for="creditCard">Credit/Debit Card</label>
                        </div>
                        
                        <div class="payment-method" data-method="paypal">
                            <input type="radio" name="paymentMethod" id="paypal">
                            <div class="payment-method-icon">
                                <i class="fab fa-cc-paypal"></i>
                            </div>
                            <label for="paypal">PayPal</label>
                        </div>
                        
                        <div class="payment-method" data-method="bkash">
                            <input type="radio" name="paymentMethod" id="bkash">
                            <div class="payment-method-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <label for="bkash">bKash</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-checkout">
                        <i class="fas fa-lock"></i> Complete Secure Payment
                    </button>
                </form>
                
                <div class="payment-security">
                    <i class="fas fa-shield-alt"></i>
                    <span>Your payment is secured with 256-bit SSL encryption</span>
                </div>
            </section>
            
            <aside class="order-summary">
                <h2><i class="fas fa-receipt"></i> Order Summary</h2>
                
                <div class="order-items" id="orderItems">
                    <!-- Items will be dynamically inserted here -->
                </div>
                
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
                        <span>Tax</span>
                        <span id="tax">৳0.00</span>
                    </div>
                    <div class="order-total-row total">
                        <span>Total</span>
                        <span id="total">৳0.00</span>
                    </div>
                </div>
                
                <div class="payment-security">
                    <i class="fas fa-undo"></i>
                    <span>30-day money back guarantee</span>
                </div>
            </aside>
        </main>
    </div>
    
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <p>Processing your payment...</p>
    </div>
    
    <!-- Success Modal (hidden by default) -->
    <div class="loading-overlay" id="successOverlay">
        <div class="success-animation">
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>
        <h2>Payment Successful!</h2>
        <p>Your order has been placed successfully.</p>
        <button class="btn-checkout" id="continueShopping" style="width: auto; padding: 0.8rem 2rem;">
            <i class="fas fa-shopping-bag"></i> Continue Shopping
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get cart from localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // DOM Elements
            const orderItemsContainer = document.getElementById('orderItems');
            const subtotalElement = document.getElementById('subtotal');
            const taxElement = document.getElementById('tax');
            const totalElement = document.getElementById('total');
            const paymentForm = document.getElementById('paymentForm');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const successOverlay = document.getElementById('successOverlay');
            const continueShoppingBtn = document.getElementById('continueShopping');
            
            // Card Preview Elements
            const cardNumberDisplay = document.getElementById('cardNumberDisplay');
            const cardNameDisplay = document.getElementById('cardNameDisplay');
            const cardExpiryDisplay = document.getElementById('cardExpiryDisplay');
            const cardPreview = document.getElementById('cardPreview');
            
            // Payment Method Elements
            const paymentMethods = document.querySelectorAll('.payment-method');
            
            // Initialize order summary
            updateOrderSummary();
            
            // Format card number input
            document.getElementById('cardNumber').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                let formatted = '';
                
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) formatted += ' ';
                    formatted += value[i];
                }
                
                e.target.value = formatted;
                
                // Update card preview
                if (value.length > 0) {
                    cardNumberDisplay.textContent = formatted + '•••• •••• ••••'.substring(formatted.length);
                } else {
                    cardNumberDisplay.textContent = '•••• •••• •••• ••••';
                }
                
                // Change card color based on first digit (simplified card detection)
                if (/^4/.test(value)) {
                    cardPreview.style.background = 'linear-gradient(135deg, #3a4a6b, #1a237e)'; // Visa
                } else if (/^5[1-5]/.test(value)) {
                    cardPreview.style.background = 'linear-gradient(135deg, #1a3a6e, #004a8f)'; // Mastercard
                } else if (/^3[47]/.test(value)) {
                    cardPreview.style.background = 'linear-gradient(135deg, #2c2c2c, #5c5c5c)'; // Amex
                } else {
                    cardPreview.style.background = 'linear-gradient(135deg, #3a4a6b, #1a237e)'; // Default
                }
            });
            
            // Format expiry date input
            document.getElementById('cardExpiry').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                
                if (value.length > 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                
                e.target.value = value;
                
                // Update card preview
                if (value.length > 0) {
                    cardExpiryDisplay.textContent = value + '••/••'.substring(value.length);
                } else {
                    cardExpiryDisplay.textContent = '••/••';
                }
            });
            
            // Update card name preview
            document.getElementById('cardName').addEventListener('input', function(e) {
                cardNameDisplay.textContent = e.target.value.toUpperCase() || 'YOUR NAME';
            });
            
            // Payment method selection
            paymentMethods.forEach(method => {
                method.addEventListener('click', function() {
                    paymentMethods.forEach(m => m.classList.remove('active'));
                    this.classList.add('active');
                    document.querySelector(`#${this.querySelector('input').id}`).checked = true;
                });
            });
            
            // Form submission
            paymentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate form
                if (!validateForm()) return;
                
                // Show loading overlay
                loadingOverlay.classList.add('active');
                
                // Simulate payment processing
                setTimeout(() => {
                    loadingOverlay.classList.remove('active');
                    successOverlay.classList.add('active');
                    
                    // Clear cart on successful payment
                    localStorage.setItem('cart', JSON.stringify([]));
                    
                    // Send order data to server (simulated)
                    sendOrderData();
                }, 3000);
            });
            
            // Continue shopping button
            continueShoppingBtn.addEventListener('click', function() {
                window.location.href = 'web-development.php';
            });
            
            // Helper functions
            function updateOrderSummary() {
                let subtotal = 0;
                let html = '';
                
                if (cart.length === 0) {
                    html = '<div class="empty-cart"><p>Your cart is empty</p></div>';
                } else {
                    cart.forEach(item => {
                        const itemTotal = item.price * item.quantity;
                        subtotal += itemTotal;
                        
                        html += `
                            <div class="order-item">
                                <img src="https://via.placeholder.com/60x80?text=Book" alt="${item.name}" class="order-item-img">
                                <div class="order-item-details">
                                    <div class="order-item-title">${item.name}</div>
                                    <div class="order-item-price">৳${item.price.toFixed(2)}</div>
                                    <div class="order-item-quantity">Qty: ${item.quantity}</div>
                                </div>
                            </div>
                        `;
                    });
                }
                
                orderItemsContainer.innerHTML = html;
                
                // Calculate totals
                const shipping = 60;
                const tax = subtotal * 0.05; // 5% tax
                const total = subtotal + shipping + tax;
                
                subtotalElement.textContent = `৳${subtotal.toFixed(2)}`;
                taxElement.textContent = `৳${tax.toFixed(2)}`;
                totalElement.textContent = `৳${total.toFixed(2)}`;
            }
            
            function validateForm() {
                const cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
                const cardName = document.getElementById('cardName').value.trim();
                const cardExpiry = document.getElementById('cardExpiry').value;
                const cardCvc = document.getElementById('cardCvc').value.trim();
                
                // Simple validation
                if (cardNumber.length !== 16 || !/^\d+$/.test(cardNumber)) {
                    alert('Please enter a valid 16-digit card number');
                    return false;
                }
                
                if (cardName.length < 3) {
                    alert('Please enter the name on your card');
                    return false;
                }
                
                if (!/^\d{2}\/\d{2}$/.test(cardExpiry)) {
                    alert('Please enter a valid expiry date in MM/YY format');
                    return false;
                }
                
                if (cardCvc.length < 3 || !/^\d+$/.test(cardCvc)) {
                    alert('Please enter a valid CVC code');
                    return false;
                }
                
                return true;
            }
            
            function sendOrderData() {
                // In a real application, you would send this data to your server
                const orderData = {
                    items: cart,
                    total: parseFloat(totalElement.textContent.replace('৳', '')),
                    paymentMethod: document.querySelector('input[name="paymentMethod"]:checked').nextElementSibling.nextElementSibling.textContent,
                    timestamp: new Date().toISOString()
                };
                
                console.log('Order data:', orderData);
                
                // Save order to localStorage for demo purposes
                const orders = JSON.parse(localStorage.getItem('orders') || []);
                orders.push(orderData);
                localStorage.setItem('orders', JSON.stringify(orders));
            }
        });
    </script>
</body>
</html>