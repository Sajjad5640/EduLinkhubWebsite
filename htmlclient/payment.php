<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EduHub - Payment</title>
  <link rel="stylesheet" href="../CSS/payment.css" />
  <link rel="icon" href="../images/logo.png" type="image/png" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>


  <!-- Success Message Overlay (hidden by default) -->
  <div class="success-overlay" id="successOverlay">
    <div class="success-message">
      <i class="fas fa-check-circle"></i>
      <h2>Premium Subscription Completed!</h2>
      <p>Your payment was successful. Redirecting to cart payment...</p>
    </div>
  </div>
  <div class="container">
    <div class="payment-wrapper">

      <!-- Header -->
      <header class="payment-header">
        <div class="logo">
          <i class="fas fa-shield-alt"></i>
          <span>EduHub Checkout</span>
        </div>
        <div class="security-badge">
          <i class="fas fa-lock"></i>
          <span>Secure Payment</span>
        </div>
      </header>

      <!-- Payment Section -->
      <div class="payment-container">

        <!-- Left: Payment Form -->
        <div class="payment-form-section">
          <h1>Complete Your Payment</h1>
          <p class="subtitle">Enter your payment details below</p>

          <!-- Order Summary -->
          <div class="order-summary">
            <h3>Order Summary</h3>
            <div class="order-item">
              <span>Premium Access</span>
              <span>800 Taka</span>
            </div>
            <div class="order-item">
              <span>Tax</span>
              <span>200 Taka</span>
            </div>
            <div class="order-total">
              <span>Total</span>
              <span>1000 Taka</span>
            </div>
          </div>

         <!-- Payment Method -->
            <div class="form-section">
              <h3>Payment Method</h3>
              <div class="payment-methods">

                <label class="payment-method">
                  <input type="radio" name="method" />
                  <div class="method-content">
                    <img src="../images/bkash.png" alt="Bkash" class="method-icon" />
                    <span>Bkash</span>
                  </div>
                </label>

                <label class="payment-method">
                  <input type="radio" name="method" />
                  <div class="method-content">
                    <img src="../images/nagad.png" alt="Nagad" class="method-icon" />
                    <span>Nagad</span>
                  </div>
                </label>

                <label class="payment-method">
                  <input type="radio" name="method" />
                  <div class="method-content">
                    <img src="../images/rocket.png" alt="Rocket" class="method-icon" />
                    <span>Rocket</span>
                  </div>
                </label>

                <label class="payment-method">
                  <input type="radio" name="method" />
                  <div class="method-content">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Cash ON Delivery</span>
                  </div>
                </label>

              </div>
            </div>

          <!-- Card Info -->
          <div class="form-section card-details">
            <h3>Card Details</h3>
            <div class="form-group">
              <label>Card Number</label>
              <div class="input-wrapper">
                <input type="text" placeholder="1234 5678 9012 3456" />
                <div class="card-icons">
                  <i class="fab fa-cc-visa"></i>
                  <i class="fab fa-cc-mastercard"></i>
                  <i class="fab fa-cc-amex"></i>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Expiry Date</label>
                <input type="text" placeholder="MM/YY" />
              </div>
              <div class="form-group">
                <label>CVV</label>
                <div class="input-wrapper">
                  <input type="text" placeholder="123" />
                  <i class="fas fa-question-circle cvv-help"></i>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Cardholder Name</label>
              <input type="text" placeholder="John Doe" />
            </div>
          </div>

          <!-- Billing -->
          <div class="form-section">
            <h3>Billing Address</h3>
            <div class="form-group">
              <label>Email</label>
              <input type="email" placeholder="john@example.com" />
            </div>
            <div class="form-group">
              <label>Street Address</label>
              <input type="text" placeholder="123 Main St" />
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>City</label>
                <input type="text" placeholder="New York" />
              </div>
              <div class="form-group">
                <label>State</label>
                <select>
                  <option value="">Select</option>
                  <option>NY</option>
                  <option>CA</option>
                  <option>TX</option>
                </select>
              </div>
              <div class="form-group">
                <label>ZIP</label>
                <input type="text" placeholder="10001" />
              </div>
            </div>
          </div>

          <!-- Terms -->
          <div class="form-section">
            <label class="checkbox-wrapper">
              <input type="checkbox" required />
              <span class="checkmark"></span>
              <span>I agree to <a href="#">Terms</a> and <a href="#">Privacy</a></span>
            </label>
          </div>

          <!-- Pay Button -->
          <button class="pay-button">
            <i class="fas fa-lock"></i>
            <span>Pay 1000 Taka</span>
          </button>

          <!-- Security Info -->
          <div class="security-info">
            <div class="security-item"><i class="fas fa-shield-alt"></i> SSL Encrypted</div>
            <div class="security-item"><i class="fas fa-credit-card"></i> PCI Compliant</div>
            <div class="security-item"><i class="fas fa-undo"></i> 30-day Refund</div>
          </div>
        </div>

        <!-- Right: Info & Testimonial -->
        <div class="side-panel">
          <div class="product-info">
            <div class="product-image"><i class="fas fa-crown"></i></div>
            <h3>Premium Subscription</h3>
            <p>Get unlimited access to books, professors, and resources.</p>
            <div class="features">
              <div class="feature"><i class="fas fa-check"></i> Unlimited downloads</div>
              <div class="feature"><i class="fas fa-check"></i> Priority support</div>
              <div class="feature"><i class="fas fa-check"></i> Weekly updates</div>
            </div>
          </div>

          <div class="testimonial">
            <p>"EduHub made my learning 10x faster. Worth every cent!"</p>
            <div class="testimonial-author">
              <div class="author-avatar"><i class="fas fa-user"></i></div>
              <div class="author-info">
                <span class="author-name">Zerin A.</span>
                <span class="author-title">Student, BSc CSE</span>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
<script>document.addEventListener('DOMContentLoaded', function() {
const form = document.querySelector('.payment-form-section');
  const payButton = document.querySelector('.pay-button');
  const paymentMethods = document.querySelectorAll('input[name="method"]');
  const cardDetailsSection = document.querySelector('.card-details');
  const successOverlay = document.getElementById('successOverlay');
  
  // Input fields
  const cardNumber = document.querySelector('input[placeholder="1234 5678 9012 3456"]');
  const expiryDate = document.querySelector('input[placeholder="MM/YY"]');
  const cvv = document.querySelector('input[placeholder="123"]');
  const cardholderName = document.querySelector('input[placeholder="John Doe"]');
  const email = document.querySelector('input[type="email"]');
  const streetAddress = document.querySelector('input[placeholder="123 Main St"]');
  const city = document.querySelector('input[placeholder="New York"]');
  const state = document.querySelector('select');
  const zip = document.querySelector('input[placeholder="10001"]');
  const termsCheckbox = document.querySelector('input[type="checkbox"]');
  // Payment method tracking
  let selectedPaymentMethod = null;

  // Validate on form submit
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (validateForm()) {
      // Show loading state
      payButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing Payment...';
      payButton.disabled = true;
      
      // Simulate payment processing (2 seconds delay)
      setTimeout(() => {
        // Show success message
        successOverlay.classList.add('active');
        
        // After showing success message for 3 seconds, redirect
        setTimeout(() => {
          window.location.href = 'product_payment.php';
        }, 3000);
      }, 2000);
    }
  });

  // Payment method selection
  paymentMethods.forEach(method => {
    method.addEventListener('change', function() {
      selectedPaymentMethod = this.nextElementSibling.querySelector('span').textContent;
      
      // Show/hide card details based on selection
      if (selectedPaymentMethod === 'Cash ON Delivery') {
        cardDetailsSection.style.display = 'none';
      } else {
        cardDetailsSection.style.display = 'block';
      }
    });
  });

  // Real-time validation
  cardNumber?.addEventListener('input', formatCardNumber);
  expiryDate?.addEventListener('input', formatExpiryDate);
  cvv?.addEventListener('input', validateCVV);
  email?.addEventListener('blur', validateEmail);

  // Validation functions
  function validateForm() {
    let isValid = true;

    // Check payment method selected
    if (!selectedPaymentMethod) {
      isValid = false;
      showError('Please select a payment method');
    }

    // Validate card details if not cash on delivery
    if (selectedPaymentMethod !== 'Cash ON Delivery') {
      if (!validateCardNumber()) isValid = false;
      if (!validateExpiryDate()) isValid = false;
      if (!validateCVV()) isValid = false;
      if (!validateCardholderName()) isValid = false;
    }

    // Validate billing info
    if (!validateEmail()) isValid = false;
    if (!validateStreetAddress()) isValid = false;
    if (!validateCity()) isValid = false;
    if (!validateState()) isValid = false;
    if (!validateZip()) isValid = false;

    // Validate terms
    if (!termsCheckbox.checked) {
      isValid = false;
      showError('You must agree to the terms and conditions');
    }

    return isValid;
  }

  function formatCardNumber() {
    // Remove all non-digits
    let value = cardNumber.value.replace(/\D/g, '');
    
    // Add space after every 4 digits
    value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
    
    cardNumber.value = value;
    validateCardNumber();
  }

  function validateCardNumber() {
    const value = cardNumber.value.replace(/\s/g, '');
    const isValid = /^\d{16}$/.test(value);
    
    toggleError(cardNumber, isValid, 'Please enter a valid 16-digit card number');
    return isValid;
  }

  function formatExpiryDate() {
    let value = expiryDate.value.replace(/\D/g, '');
    
    if (value.length > 2) {
      value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    
    expiryDate.value = value;
    validateExpiryDate();
  }

  function validateExpiryDate() {
    const [month, year] = expiryDate.value.split('/');
    const currentYear = new Date().getFullYear().toString().slice(-2);
    const currentMonth = new Date().getMonth() + 1;
    
    let isValid = true;
    let errorMessage = '';
    
    if (!/^\d{2}\/\d{2}$/.test(expiryDate.value)) {
      isValid = false;
      errorMessage = 'Please enter a valid expiry date (MM/YY)';
    } else if (month < 1 || month > 12) {
      isValid = false;
      errorMessage = 'Please enter a valid month (01-12)';
    } else if (year < currentYear || (year == currentYear && month < currentMonth)) {
      isValid = false;
      errorMessage = 'Card has expired';
    }
    
    toggleError(expiryDate, isValid, errorMessage);
    return isValid;
  }

  function validateCVV() {
    const value = cvv.value;
    const isValid = /^\d{3,4}$/.test(value);
    
    toggleError(cvv, isValid, 'Please enter a valid 3 or 4-digit CVV');
    return isValid;
  }

  function validateCardholderName() {
    const isValid = cardholderName.value.trim().length > 0;
    
    toggleError(cardholderName, isValid, 'Please enter cardholder name');
    return isValid;
  }

  function validateEmail() {
    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);
    
    toggleError(email, isValid, 'Please enter a valid email address');
    return isValid;
  }

  function validateStreetAddress() {
    const isValid = streetAddress.value.trim().length > 5;
    
    toggleError(streetAddress, isValid, 'Please enter a valid address');
    return isValid;
  }

  function validateCity() {
    const isValid = city.value.trim().length > 0;
    
    toggleError(city, isValid, 'Please enter your city');
    return isValid;
  }

  function validateState() {
    const isValid = state.value !== '';
    
    toggleError(state, isValid, 'Please select your state');
    return isValid;
  }

  function validateZip() {
    const isValid = /^\d{5}(-\d{4})?$/.test(zip.value);
    
    toggleError(zip, isValid, 'Please enter a valid ZIP code');
    return isValid;
  }

  // Helper functions
  function toggleError(input, isValid, errorMessage) {
    const formGroup = input.closest('.form-group') || input.closest('.form-row');
    
    if (!isValid) {
      formGroup.classList.add('error');
      
      let errorElement = formGroup.querySelector('.error-message');
      if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        formGroup.appendChild(errorElement);
      }
      errorElement.textContent = errorMessage;
    } else {
      formGroup.classList.remove('error');
      const errorElement = formGroup.querySelector('.error-message');
      if (errorElement) errorElement.remove();
    }
  }

  function showError(message) {
    const errorElement = document.createElement('div');
    errorElement.className = 'global-error-message';
    errorElement.textContent = message;
    
    const existingError = document.querySelector('.global-error-message');
    if (existingError) existingError.remove();
    
    form.insertBefore(errorElement, form.firstChild);
    
    setTimeout(() => {
      errorElement.classList.add('fade-out');
      setTimeout(() => errorElement.remove(), 300);
    }, 5000);
  }
});

// Add this CSS for error styling
const style = document.createElement('style');
style.textContent = `
  .form-group.error input,
  .form-group.error select {
    border-color: #ff4444;
    background-color: #fff9f9;
  }
  
  .error-message {
    color: #ff4444;
    font-size: 0.8rem;
    margin-top: 5px;
  }
  
  .global-error-message {
    background-color: #ff4444;
    color: white;
    padding: 12px 15px;
    border-radius: 4px;
    margin-bottom: 20px;
    animation: fadeIn 0.3s ease;
  }
  
  .global-error-message.fade-out {
    animation: fadeOut 0.3s ease;
    opacity: 0;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  @keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
  }
`;
document.head.appendChild(style);</script>
</body>
</html>
