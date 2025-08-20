<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Academic Books - EdUHub</title>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <link rel="stylesheet" href="../CSS/academic-books.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="logo">
    <img src="../images/logo.png" alt="EdUHub Logo" class="logo-img">
  </div>
  <ul class="nav-links">
    <li><a href="../index.html">Home</a></li>
    <li class="dropdown">
      <a href="#">Book ▾</a>
      <ul class="dropdown-content">
        <li><a href="../HTML/web-development.html">Web Development</a></li>
        <li><a href="../HTML/design-books.html">Design</a></li>
        <li><a href="../HTML/ai-ml-books.html">AI & ML</a></li>
        <li><a href="../HTML/admission-books.html">Admission (100+ Books)</a></li>
        <li><a href="../HTML/public-private-job.html">Public & Private Job (100+ Books)</a></li>
        <li><a href="../HTML/bcs-books.html">BCS (100+ Books)</a></li>
        <li><a href="../HTML/it-software-books.html">IT & Software (100+ Books)</a></li>
        <li><a href="../HTML/academic-books.html">Academic (100+ Books)</a></li>
        <li><a href="../HTML/language-books.html">Language (100+ Books)</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="">Study Abroad ▾</a>
      <ul class="dropdown-content">
        <li><a href="../HTML/professors.html">Professors</a></li>
        <li><a href="../HTML/scholarship.html">Scholarship</a></li>
      </ul>
    </li>
    <li><a href="../HTML/admission.html" class="btn">Admission</a></li>
    <li><a href="../HTML/about-contact.html">About & Contact</a></li>
  </ul>

  <div class="cart-icon-container" id="cartIconContainer">
    <i class="fas fa-shopping-cart cart-icon"></i>
    <div class="cart-count" id="cartCount">0</div>
    <div class="cart-dropdown" id="cartDropdown">
      <h3>Your Cart</h3>
      <div class="cart-items" id="cartItems">
        <p>Your cart is empty</p>
      </div>
      <div class="cart-total">Total: ৳<span id="cartTotal">0.00</span></div>
      <a href="../HTML/payment.html" class="checkout-btn">Payment Place</a>
    </div>
  </div>

  <div class="user-profile" id="userProfile">
    <img src="../images/Profile.jpg" alt="User" class="profile-pic" />
    <div class="user-dropdown">
      <a href="../HTML/profile.html">Profile</a>
      <a href="../HTML/settings.html">Settings</a>
      <a href="../HTML/login.html">Logout</a>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero book-hero-academic">
  <div class="hero-content">
    <h1>Academic Books</h1>
    <p>Explore top academic books across disciplines to support your study and growth.</p>
  </div>
</section>

<!-- Book Section -->
<section class="book-section">
  <div class="container">
    <div class="book-card">
      <img src="../images/academic1.jpg" alt="Introduction to Psychology" />
      <h3>Introduction to Psychology</h3>
      <p>Author: James W. Kalat</p>
      <p>Price: 45 Taka</p>
      <button onclick="addToCart('Introduction to Psychology')">Add to Cart</button>
    </div>
    <div class="book-card">
      <img src="../images/academic2.jpg" alt="Fundamentals of Physics" />
      <h3>Fundamentals of Physics</h3>
      <p>Author: Halliday & Resnick</p>
      <p>Price: 50 Taka</p>
      <button onclick="addToCart('Fundamentals of Physics')">Add to Cart</button>
    </div>
    <div class="book-card">
      <img src="../images/academic3.jpg" alt="Biology: Concepts & Connections" />
      <h3>Biology: Concepts & Connections</h3>
      <p>Author: Neil A. Campbell</p>
      <p>Price: 48 Taka</p>
      <button onclick="addToCart('Biology: Concepts & Connections')">Add to Cart</button>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <p>&copy; 2025 EdUHub. All rights reserved.</p>
</footer>

 <script>
    const profile = document.getElementById('userProfile');
    profile.addEventListener('click', e => {
      e.stopPropagation();
      profile.classList.toggle('active');
    });
    document.addEventListener('click', () => profile.classList.remove('active'));

    const cartItemsContainer = document.getElementById("cartItems");
    const cartCount = document.getElementById("cartCount");
    const cartTotal = document.getElementById("cartTotal");

    let cart = [];

    const bookData = {
      "Artificial Intelligence: A Modern Approach": 50,
      "Pattern Recognition and Machine Learning": 45,
      "Deep Learning": 60,
      "Machine Learning Yearning": 35
    };

    function addToCart(bookName) {
      const existingItem = cart.find(item => item.name === bookName);
      if (existingItem) {
        existingItem.quantity++;
      } else {
        cart.push({ name: bookName, quantity: 1, price: bookData[bookName] });
      }
      updateCartDisplay();
    }

    function updateQuantity(bookName, change) {
      const item = cart.find(i => i.name === bookName);
      if (!item) return;
      item.quantity += change;
      if (item.quantity < 1) {
        removeFromCart(bookName);
      } else {
        updateCartDisplay();
      }
    }

    function removeFromCart(bookName) {
      cart = cart.filter(item => item.name !== bookName);
      updateCartDisplay();
    }

    function updateCartDisplay() {
      cartItemsContainer.innerHTML = "";
      let total = 0;
      let count = 0;

      cart.forEach(item => {
        const itemTotal = item.quantity * item.price;
        total += itemTotal;
        count += item.quantity;

        cartItemsContainer.innerHTML += `
          <div class="cart-item">
            <p><strong>${item.name}</strong></p>
            <p>
              Quantity:
              <button onclick="updateQuantity('${item.name}', -1)">-</button>
              ${item.quantity}
              <button onclick="updateQuantity('${item.name}', 1)">+</button>
            </p>
            <p>Subtotal: ৳${itemTotal.toFixed(2)}</p>
            <button onclick="removeFromCart('${item.name}')">Remove</button>
          </div>
        `;
      });

      if (cart.length === 0) {
        cartItemsContainer.innerHTML = "<p>Your cart is empty</p>";
      }

      cartTotal.textContent = total.toFixed(2);
      cartCount.textContent = count;
    }

    const cartIconContainer = document.getElementById("cartIconContainer");
    const cartDropdown = document.getElementById("cartDropdown");

    cartIconContainer.addEventListener("click", e => {
      e.stopPropagation();
      cartDropdown.classList.toggle("show");
    });

    document.addEventListener("click", () => {
      cartDropdown.classList.remove("show");
    });
  </script>
</body>
</html>
