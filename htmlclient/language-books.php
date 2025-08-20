<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Language Learning Books - EdUHub</title>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <link rel="stylesheet" href="../CSS/language-books.css" />
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
        <li><a href="../HTML/admission.html">Admission (100+ Books)</a></li>
        <li><a href="../HTML/public-private-job.html">Public & Private Job (100+ Books)</a></li>
        <li><a href="../HTML/bcs-books.html">BCS (100+ Books)</a></li>
        <li><a href="../HTML/it-software-books.html">IT & Software (100+ Books)</a></li>
        <li><a href="../HTML/academic-books.html">Academic (100+ Books)</a></li>
        <li><a href="../HTML/language-books.html">Language (100+ Books)</a></li>
      </ul>
    </li>

    <li class="dropdown">
      <a href="#">Study Abroad ▾</a>
      <ul class="dropdown-content">
        <li><a href="../HTML/professors.html">Professors</a></li>
        <li><a href="../HTML/scholarship.html">Scholarship</a></li>
      </ul>
    </li>
    <li><a href="../HTML/admission.html" class="btn">Admission</a></li>
    <li><a href="../HTML/about-contact.html">About & Contact</a></li>
  </ul>
       <!-- Cart Icon -->
        <div class="cart-icon-container" id="cartIconContainer">
          <i class="fas fa-shopping-cart cart-icon"></i>
          <div class="cart-count" id="cartCount">0</div>
          <div class="cart-dropdown" id="cartDropdown">
            <h3>Your Cart</h3>
            <div class="cart-items" id="cartItems">
              <!-- Cart items will be added here dynamically -->
              <p>Your cart is empty</p>
            </div>
            <div class="cart-total">
              Total: ৳<span id="cartTotal">0.00</span>
            </div>
            <a href="../HTML/payment.html" class="checkout-btn" id="checkoutBtn">Payment Place</a>
          </div>
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

<!-- Hero -->
<section class="hero book-hero-language">
  <div class="hero-content">
    <h1>Language Learning Books</h1>
    <p>Master Korean and other languages with hand-picked beginner-friendly resources.</p>
  </div>
</section>

<!-- Books Section -->
<section class="book-section">
  <div class="book-grid">
    <div class="book-card">
      <img src="../images/korean1.jpg" alt="Korean Made Simple">
      <h3>Korean Made Simple</h3>
      <p>Author: Billy Go</p>
      <p>Price: ৳30</p>
      <button onclick="addToCart('Korean Made Simple')">Add to Cart</button>
    </div>
    <div class="book-card">
      <img src="../images/korean2.jpg" alt="Talk To Me In Korean">
      <h3>Talk To Me In Korean (Level 1)</h3>
      <p>Author: TTMIK</p>
      <p>Price: ৳35</p>
      <button onclick="addToCart('Talk To Me In Korean')">Add to Cart</button>
    </div>
    <div class="book-card">
      <img src="../images/korean3.jpg" alt="Integrated Korean">
      <h3>Integrated Korean</h3>
      <p>Author: KLEAR</p>
      <p>Price: ৳40</p>
      <button onclick="addToCart('Integrated Korean')">Add to Cart</button>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <p>&copy; 2025 EdUHub. All rights reserved.</p>
</footer>

<script>
// Profile dropdown
const profile = document.getElementById('userProfile');
profile.addEventListener('click', e => {
  e.stopPropagation();
  profile.classList.toggle('active');
});
document.addEventListener('click', () => profile.classList.remove('active'));

// Cart
const cartItemsContainer = document.getElementById("cartItems");
const cartCount = document.getElementById("cartCount");
const cartTotal = document.getElementById("cartTotal");
let cart = [];

const bookData = {
  "Korean Made Simple": 30,
    "Talk To Me In Korean": 35,
    "Integrated Korean": 40,
}

function addToCart(bookName) {
  const existing = cart.find(item => item.name === bookName);
  if (existing) {
    existing.quantity++;
  } else {
    cart.push({ name: bookName, quantity: 1, price: bookData[bookName] });
  }
  updateCartDisplay();
}

function updateCartDisplay() {
  cartItemsContainer.innerHTML = "";
  let total = 0, count = 0;
  cart.forEach((item, index) => {
    const subtotal = item.quantity * item.price;
    total += subtotal;
    count += item.quantity;
    cartItemsContainer.innerHTML += `
      <div class="cart-item">
        <p><strong>${item.name}</strong></p>
        <p>Qty: 
          <button onclick="updateQty(${index}, -1)">-</button>
          ${item.quantity}
          <button onclick="updateQty(${index}, 1)">+</button>
        </p>
        <p>৳${subtotal.toFixed(2)}</p>
        <button onclick="removeItem(${index})">Remove</button>
      </div>`;
  });
  if (cart.length === 0) {
    cartItemsContainer.innerHTML = "<p>Your cart is empty</p>";
  }
  cartCount.textContent = count;
  cartTotal.textContent = total.toFixed(2);
}

function updateQty(index, delta) {
  cart[index].quantity += delta;
  if (cart[index].quantity <= 0) {
    cart.splice(index, 1);
  }
  updateCartDisplay();
}

function removeItem(index) {
  cart.splice(index, 1);
  updateCartDisplay();
}

// Cart toggle
const cartIconContainer = document.getElementById("cartIconContainer");
const cartDropdown = document.getElementById("cartDropdown");
cartIconContainer.addEventListener("click", e => {
  e.stopPropagation();
  cartDropdown.classList.toggle("show");
});
document.addEventListener("click", () => cartDropdown.classList.remove("show"));
</script>


</body>
</html>
