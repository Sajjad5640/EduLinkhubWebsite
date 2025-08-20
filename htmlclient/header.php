
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");
// your code to fetch user data from database

?>

<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpStudy Navbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Modern Navbar CSS with Footer Color Scheme */
        :root {
          --primary-color: #032b56;       /* Dark blue from footer */
          --secondary-color: #021a36;     /* Darker blue from footer gradient */
          --accent-color: #00d4aa;        /* Teal accent from footer */
          --text-light: #ffffff;
          --text-muted: #c0c9d1;          /* Light gray from footer */
          --text-dark: #2c3e50;
          --shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
          --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Navbar Container - Matching footer gradient */
        .navbar {
          position: sticky;
          top: 0;
          background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
          color: var(--text-light);
          box-shadow: var(--shadow);
          z-index: 1000;
          padding: 0;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Add the same top border as footer */
        .navbar::before {
          content: "";
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          height: 4px;
          background: linear-gradient(90deg, var(--accent-color), #0066ff);
          z-index: 1001;
        }

        .navbar-container {
          display: flex;
          justify-content: space-between;
          align-items: center;
          max-width: 1400px;
          margin: 0 auto;
          padding: 0.8rem 2rem;
          position: relative;
        }

        /* Logo Styles */
        .logo {
          display: flex;
          align-items: center;
          transition: var(--transition);
        }

        .logo a {
          display: flex;
          align-items: center;
          text-decoration: none;
        }

        .logo-img {
          height: 50px;
          margin-right: 10px;
          transition: transform 0.3s ease;
        }

        .logo-text {
          font-size: 1.5rem;
          font-weight: 700;
          color: var(--text-light);
          letter-spacing: 0.5px;
        }

        /* Navigation Links */
        .nav-links {
          display: flex;
          gap: 1.5rem;
          align-items: center;
          margin: 0;
          padding: 0;
          list-style: none;
        }

        .nav-link {
          display: flex;
          align-items: center;
          gap: 0.5rem;
          color: var(--text-muted); /* Matching footer link color */
          text-decoration: none;
          font-weight: 500;
          font-size: 1rem;
          padding: 0.5rem 1rem;
          border-radius: 4px;
          transition: var(--transition);
          position: relative;
        }

        .nav-link i {
          font-size: 1.1rem;
        }

        .hover-underline::after {
          content: '';
          position: absolute;
          bottom: 0;
          left: 50%;
          transform: translateX(-50%);
          width: 0;
          height: 2px;
          background: var(--accent-color);
          transition: var(--transition);
        }

        .hover-underline:hover::after {
          width: 80%;
        }

        .nav-link:hover {
          color: var(--accent-color);
          transform: translateY(-2px);
        }

        .nav-btn {
          display: flex;
          align-items: center;
          gap: 0.5rem;
          background: var(--accent-color);
          color: var(--text-dark);
          padding: 0.6rem 1.2rem;
          border-radius: 30px;
          font-weight: 600;
          text-decoration: none;
          transition: var(--transition);
          box-shadow: 0 2px 10px rgba(0, 212, 170, 0.3);
        }

        .nav-btn:hover {
          transform: translateY(-3px);
          box-shadow: 0 4px 15px rgba(0, 212, 170, 0.4);
        }

        /* Dropdown Menus */
        .dropdown {
          position: relative;
        }

        .dropdown-arrow {
          margin-left: 0.3rem;
          font-size: 0.8rem;
          transition: transform 0.3s ease;
        }

        .dropdown:hover .dropdown-arrow {
          transform: rotate(180deg);
        }

        .mega-dropdown {
          position: absolute;
          left: 0;
          top: 100%;
          width: 600px;
          background: white;
          border-radius: 8px;
          padding: 1.5rem;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
          z-index: 100;
          opacity: 0;
          visibility: hidden;
          transform: translateY(10px);
          transition: all 0.3s ease;
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          gap: 1.5rem;
        }

        .dropdown:hover .mega-dropdown {
          opacity: 1;
          visibility: visible;
          transform: translateY(0);
        }

        .mega-dropdown-column h4 {
          color: var(--primary-color);
          margin-bottom: 1rem;
          padding-bottom: 0.5rem;
          border-bottom: 1px solid #eee;
        }

        .mega-dropdown-column ul {
          list-style: none;
          padding: 0;
          margin: 0;
        }

        .mega-dropdown-column li a {
          display: flex;
          align-items: center;
          gap: 0.7rem;
          padding: 0.6rem 0;
          color: var(--text-dark);
          text-decoration: none;
          transition: var(--transition);
          border-radius: 4px;
        }

        .mega-dropdown-column li a:hover {
          color: var(--primary-color);
          padding-left: 0.5rem;
        }

        .mega-dropdown-column li a i {
          color: var(--secondary-color);
          width: 20px;
          text-align: center;
        }

        .dropdown-content {
          position: absolute;
          left: 0;
          top: 100%;
          min-width: 200px;
          background: white;
          border-radius: 8px;
          padding: 1rem 0;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
          z-index: 100;
          opacity: 0;
          visibility: hidden;
          transform: translateY(10px);
          transition: all 0.3s ease;
          list-style: none;
        }

        .dropdown:hover .dropdown-content {
          opacity: 1;
          visibility: visible;
          transform: translateY(0);
        }

        .dropdown-content li a {
          display: flex;
          align-items: center;
          gap: 0.7rem;
          padding: 0.6rem 1.5rem;
          color: var(--text-dark);
          text-decoration: none;
          transition: var(--transition);
        }

        .dropdown-content li a:hover {
          background: #f5f7fa;
          color: var(--primary-color);
        }

        /* Right Side Navigation */
        .nav-right {
          display: flex;
          align-items: center;
          gap: 1.5rem;
        }

        /* Search Styles */
.search-container {
  position: relative;
  display: flex;
  align-items: center;
}

.search-btn {
  background: transparent;
  border: none;
  color: var(--text-muted);
  font-size: 1.3rem;
  cursor: pointer;
  transition: var(--transition);
  padding: 0.6rem;
  z-index: 2;
}

.search-btn:hover {
  color: var(--accent-color);
  transform: scale(1.1);
}


.search-container.active .search-box {
  transform: translateY(-50%) scaleX(1);
  opacity: 1;
}

.search-box {
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%) scaleX(0);
  transform-origin: right;
  width: 100%;
  max-width: 300px; /* Adjusted width */
  background: white;
  border-radius: 30px;
  padding: 0.7rem 0.7rem 0.7rem 1.5rem;
  display: flex;
  align-items: center;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  opacity: 0;
  transition: all 0.3s ease;
  z-index: 1;
}

.search-box input {
  border: none;
  outline: none;
  width: 100%;
  padding: 0.7rem 0; /* Taller input */
  font-size: 1rem; /* Larger text */
}

.search-submit {
  background: var(--accent-color);
  color: white;
  border: none;
  width: 36px; /* Larger button */
  height: 36px; /* Larger button */
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: var(--transition);
  flex-shrink: 0;
  font-size: 1rem; /* Larger icon */
}

.search-submit:hover {
  transform: scale(1.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .search-box {
    position: fixed;
    top: 60px; /* Adjust based on your header height */
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: 90%;
    max-width: 400px;
  }
  
  .search-container.active .search-box {
    transform: translateX(-50%) scaleX(1);
  }
  
  .search-container {
    margin-left: auto; /* Push to the right on mobile */
  }
}

@media (max-width: 480px) {
  .search-box {
    padding: 0.2rem 0.2rem 0.2rem 0.8rem;
  }
  
  .search-box input {
    font-size: 0.8rem;
  }
  
  .search-submit {
    width: 26px;
    height: 26px;
    font-size: 0.8rem;
  }
}
/* Mobile adjustments */
@media (max-width: 768px) {
  .search-container {
    margin-right: 10px;
    order: 0; /* Change order for mobile */
  }
  
  .search-box {
    position: fixed;
    top: 70px;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: calc(100% - 40px);
    max-width: 100%;
  }
  
  .nav-right {
    gap: 0.5rem;
  }
}

        /* Cart Icon Container */
.cart-icon-container {
  position: relative;
  cursor: pointer;
  transition: transform 0.3s ease;
  z-index: 100;
}

.cart-icon-container:hover {
  transform: translateY(-3px);
}

.cart-icon-wrapper {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Cart Icon */
.cart-icon {
  font-size: 1.5rem;
  color: var(--text-light);
  transition: all 0.3s ease;
  padding: 8px;
  border-radius: 50%;
}

.cart-icon:hover {
  color: var(--accent-color);
  background: rgba(255, 255, 255, 0.1);
}

/* Cart Count Badge */
.cart-count {
  position: absolute;
  top: -5px;
  right: -5px;
  background: var(--accent-color);
  color: var(--text-dark);
  width: 22px;
  height: 22px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  font-weight: 700;
  transition: all 0.3s ease;
  transform-origin: center;
}

.pulse {
  animation: pulse 1.5s infinite;
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.1); }
  100% { transform: scale(1); }
}

/* Cart Dropdown */
.cart-dropdown {
  position: absolute;
  right: 0;
  top: calc(100% + 10px);
  width: 350px;
  max-height: 70vh;
  background: white;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
  z-index: 99;
  opacity: 0;
  visibility: hidden;
  transform: translateY(20px);
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  display: flex;
  flex-direction: column;
}

.cart-icon-container.active .cart-dropdown {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

/* Cart Header */
.cart-dropdown h3 {
  color: var(--primary-color);
  margin-bottom: 15px;
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 1.25rem;
  padding-bottom: 10px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

/* Cart Items Container */
.cart-items {
  flex: 1;
  overflow-y: auto;
  padding-right: 5px;
  margin-bottom: 15px;
}

/* Empty Cart State */
.empty-cart {
  text-align: center;
  padding: 30px 0;
  color: var(--text-muted);
}

.empty-cart i {
  font-size: 2.5rem;
  color: #e0e0e0;
  margin-bottom: 15px;
  display: block;
}

.empty-cart p {
  font-size: 1rem;
}

/* Cart Item */
.cart-item {
  padding: 15px 0;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  animation: fadeIn 0.3s ease-out;
}

.cart-item:last-child {
  border-bottom: none;
}

.cart-item p {
  margin: 5px 0;
}

.cart-item strong {
  color: var(--text-dark);
  font-size: 0.95rem;
}

/* Quantity Controls */
.quantity-controls {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 8px 0;
}

.quantity-controls button {
  background: var(--accent-color);
  color: white;
  border: none;
  width: 25px;
  height: 25px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
}

.quantity-controls button:hover {
  background: var(--primary-color);
  transform: scale(1.1);
}

/* Remove Button */
.remove-btn {
  background: none;
  border: none;
  color: #e74c3c;
  cursor: pointer;
  font-size: 0.85rem;
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 5px 0;
  transition: all 0.2s ease;
}

.remove-btn:hover {
  color: #c0392b;
  transform: translateX(3px);
}

/* Cart Total */
.cart-total {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 15px;
  padding-top: 15px;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  font-weight: 600;
  color: var(--text-dark)  ;
}

.total-amount {
  color: var(--primary-color);
  font-weight: 700;
  font-size: 1.1rem;
}

/* Checkout Button */
.checkout-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  width: 100%;
  background: var(--primary-color);
  color: white;
  padding: 12px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  margin-top: 15px;
  transition: all 0.3s ease;
}

.checkout-btn:hover {
  background: var(--secondary-color);
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

/* Animations */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Scrollbar Styling */
.cart-items::-webkit-scrollbar {
  width: 6px;
}

.cart-items::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0.05);
  border-radius: 10px;
}

.cart-items::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}

.cart-items::-webkit-scrollbar-thumb:hover {
  background: rgba(0, 0, 0, 0.2);
}
        /* User Profile Styles */
        .user-profile {
          position: relative;
        }

        .profile-pic-container {
          position: relative;
          width: 40px;
          height: 40px;
          border-radius: 50%;
          overflow: hidden;
          cursor: pointer;
          transition: var(--transition);
        }

        .profile-pic {
          width: 100%;
          height: 100%;
          object-fit: cover;
        }

        .active-indicator {
          position: absolute;
          bottom: 0;
          right: 0;
          width: 10px;
          height: 10px;
          background: var(--accent-color);
          border-radius: 50%;
          border: 2px solid white;
        }

        .user-dropdown {
          position: absolute;
          right: 0;
          top: 100%;
          min-width: 200px;
          background: white;
          border-radius: 8px;
          padding: 1rem 0;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
          z-index: 100;
          opacity: 0;
          visibility: hidden;
          transform: translateY(10px);
          transition: all 0.3s ease;
          margin-top: 1rem;
        }

        .user-profile:hover .user-dropdown {
          opacity: 1;
          visibility: visible;
          transform: translateY(0);
        }

        .user-dropdown a {
          display: flex;
          align-items: center;
          gap: 0.7rem;
          padding: 0.6rem 1.5rem;
          color: var(--text-dark);
          text-decoration: none;
          transition: var(--transition);
        }

        .user-dropdown a:hover {
          background: #f5f7fa;
          color: var(--primary-color);
        }

        .user-dropdown a i {
          width: 20px;
          text-align: center;
        }

        /* Mobile Menu Toggle */
        .hamburger {
          display: none;
          cursor: pointer;
          z-index: 101;
        }

        .hamburger .bar {
          display: block;
          width: 25px;
          height: 3px;
          margin: 5px auto;
          background: var(--text-muted);
          transition: all 0.3s ease;
        }

        /* Animations */
        @keyframes pulse {
          0% { transform: scale(1); }
          50% { transform: scale(1.05); }
          100% { transform: scale(1); }
        }

        .pulse {
          animation: pulse 2s infinite;
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
          .navbar-container {
            padding: 0.8rem 1.5rem;
          }
          
          .mega-dropdown {
            width: 500px;
            grid-template-columns: repeat(2, 1fr);
          }
        }

        @media (max-width: 768px) {
          .hamburger {
            display: block;
          }
          
          .hamburger.active .bar:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
          }
          
          .hamburger.active .bar:nth-child(2) {
            opacity: 0;
          }
          
          .hamburger.active .bar:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
          }
          
          .nav-links {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 300px;
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            flex-direction: column;
            align-items: flex-start;
            padding: 5rem 2rem;
            transition: right 0.5s ease;
            z-index: 100;
          }
          
          .nav-links.active {
            right: 0;
          }
          
          .nav-right {
  display: flex;
  align-items: center;
  gap: 1rem; /* Consistent spacing */
  margin-left: auto; /* Push to far right */
}
          
          .mega-dropdown, .dropdown-content {
            position: static;
            width: 100%;
            opacity: 1;
            visibility: visible;
            transform: none;
            box-shadow: none;
            background: rgba(255, 255, 255, 0.1);
            margin-top: 0.5rem;
          }
          
          .mega-dropdown {
            display: block;
            padding: 0.5rem;
          }
          
          .mega-dropdown-column h4 {
            color: var(--text-light);
            border-bottom-color: rgba(255, 255, 255, 0.2);
          }
          
          .mega-dropdown-column li a, .dropdown-content li a {
            color: var(--text-light);
          }
          
          .mega-dropdown-column li a:hover, .dropdown-content li a:hover {
            background: rgba(255, 255, 255, 0.1);
          }
          
          .search-box {
            right: auto;
            left: 0;
            transform-origin: left;
          }
          
          .cart-dropdown, .user-dropdown {
            right: auto;
            left: 0;
          }
        }

        @media (max-width: 480px) {
          .navbar-container {
            padding: 0.8rem 1rem;
          }
          
          .logo-text {
            display: none;
          }
          
          .search-box {
            width: 200px;
          }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
      <div class="navbar-container">
        <!-- Logo with animation -->
        <div class="logo">
          <a href="index1.php">
            <img src="../images/image1.png" alt="EdUHub Logo" class="logo-img">
            <span class="logo-text pulse">EduLinkHub</span>
          </a>
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="hamburger" id="mobileMenuToggle">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>

        <!-- Main Navigation -->
        <ul class="nav-links">
          <li>
            <a href="index1.php" class="nav-link hover-underline">
              <i class="fas fa-home"></i>
              <span>Home</span>
            </a>
          </li>

          <!-- Enhanced Mega Dropdown -->
          <li class="">
            <a href="web-development.php" class="nav-link hover-underline">
              <i class="fas fa-book"></i>
              <span>Book</span>
              
            </a>
            
          </li>

          <!-- Study Abroad Dropdown -->
          <li class="dropdown">
            <a href="#" class="nav-link hover-underline">
              <i class="fas fa-globe-americas"></i>
              <span>Study Abroad</span>
              <i class="fas fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="dropdown-content">
              <li><a href="professors.php"><i class="fas fa-chalkboard-teacher"></i> Professors</a></li>
              <li><a href="scholarship.php"><i class="fas fa-award"></i> Scholarship</a></li>
            </ul>
          </li>

          <li>
            <a href="admission.php" class="nav-btn">
              <i class="fas fa-user-graduate"></i>
              <span>Admission</span>
            </a>
          </li>
          <li>
            <a href="about-contact.php" class="nav-link hover-underline">
              <i class="fas fa-info-circle"></i>
              <span>About & Contact</span>
            </a>
          </li>
        </ul>

        <!-- Right Side Icons -->
        <div class="nav-right">
          

          <!-- Enhanced Cart with Animation -->
          <div class="cart-icon-container" id="cartIconContainer">
            <div class="cart-icon-wrapper">
              <i class="fas fa-shopping-cart cart-icon"></i>
              <div class="cart-count pulse" id="cartCount">0</div>
            </div>
            <div class="cart-dropdown" id="cartDropdown">
              <h3><i class="fas fa-shopping-bag"></i> Your Cart</h3>
              <div class="cart-items" id="cartItems">
                <div class="empty-cart">
                  <i class="fas fa-box-open"></i>
                  <p>Your cart is empty</p>
                </div>
              </div>
              <div class="cart-total">
                <span>Total:</span>
                <span class="total-amount">৳<span id="cartTotal">0.00</span></span>
              </div>
              <a href="product_cart.php" class="checkout-btn" id="checkoutBtn">
  <i class="fas fa-credit-card"></i>
  <span>Proceed to Checkout</span>
</a>
            </div>
          </div>

          <?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize variables
$profilePicture = '../images/default-profile.jpg'; // Default fallback image
$debugInfo = ''; // For debugging purposes

try {
    // Check if user is logged in
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $userId = (int)$_SESSION['user_id'];
        
        // Prepare and execute database query
        $stmt = mysqli_prepare($conn, "SELECT profilePicture FROM users WHERE id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $userId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $dbProfilePicture);
            
            if (mysqli_stmt_fetch($stmt)) {
                // Validate and sanitize the image path
                if (!empty($dbProfilePicture) && is_string($dbProfilePicture)) {
                    $sanitizedPath = '../uploads/' . basename($dbProfilePicture);
                    
                    // Verify file exists and is readable
                    if (file_exists($sanitizedPath) && is_readable($sanitizedPath)) {
                        $profilePicture = $sanitizedPath;
                    } else {
                        $debugInfo = "File not found or not readable: " . htmlspecialchars($sanitizedPath);
                        error_log($debugInfo);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            $debugInfo = "Database query preparation failed: " . mysqli_error($conn);
            error_log($debugInfo);
        }
    }
} catch (Exception $e) {
    error_log("Profile picture error: " . $e->getMessage());
    $profilePicture = '../images/default-profile.jpg'; // Ensure fallback on error
}

// For debugging - remove in production
// echo "<!-- Debug: $debugInfo -->";
?>
<!-- User Profile with Animation -->
<div class="user-profile" id="userProfile">
    <div class="profile-pic-container">
        <img src="<?php echo htmlspecialchars($profilePicture); ?>" 
             alt="User Profile" 
             class="profile-pic" 
             onerror="this.src='../images/default-profile.jpg';this.onerror=null;" />
        <div class="active-indicator"></div>
    </div>
    <div class="user-dropdown">
        <a href="profile1.php"><i class="fas fa-user-circle"></i> Profile</a>
        
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
        </div>
      </div>
    </nav>

    <script>
        // Add this JavaScript for interactive functionality
        document.addEventListener('DOMContentLoaded', function() {
          // Mobile menu toggle
          const hamburger = document.getElementById('mobileMenuToggle');
          const navLinks = document.querySelector('.nav-links');
          
          hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
          });

          

          // Cart toggle
          const cartIcon = document.getElementById('cartIconContainer');
          
          cartIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('active');
          });

          // Close dropdowns when clicking outside
          document.addEventListener('click', function() {
            document.querySelectorAll('.dropdown').forEach(dropdown => {
              dropdown.classList.remove('active');
            });
            cartIcon.classList.remove('active');
          });

          // Prevent dropdown from closing when clicking inside
          document.querySelectorAll('.dropdown-content, .mega-dropdown, .cart-dropdown, .user-dropdown').forEach(element => {
            element.addEventListener('click', function(e) {
              e.stopPropagation();
            });
          });

          // Smooth scroll for anchor links
          document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
              e.preventDefault();
              document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
              });
            });
          });
        });
    </script>
    <script>
// Cart management system
document.addEventListener('DOMContentLoaded', function() {
  // Initialize cart from localStorage
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  
  // Get DOM elements
  const cartItemsContainer = document.getElementById("cartItems");
  const cartCount = document.getElementById("cartCount");
  const cartTotal = document.getElementById("cartTotal");
  const cartDropdown = document.getElementById("cartDropdown");
  const cartIconContainer = document.getElementById("cartIconContainer");
  const checkoutBtn = document.getElementById("checkoutBtn"); // Added checkout button reference

  // Update cart display function
  function updateCartDisplay() {
    let total = 0;
    let itemCount = 0;
    let itemsHTML = '';
    
    cart.forEach(item => {
      const itemTotal = item.quantity * item.price;
      total += itemTotal;
      itemCount += item.quantity;
      
      itemsHTML += `
        <div class="cart-item">
          <p><strong>${escapeHtml(item.name)}</strong></p>
          <div class="quantity-controls">
            <button onclick="cartManager.updateQuantity('${escapeString(item.name)}', 'decrease')">-</button>
            <span style="color: black">${item.quantity}</span>
            <button onclick="cartManager.updateQuantity('${escapeString(item.name)}', 'increase')">+</button>
          </div>
          <p style="color: black">৳${itemTotal.toFixed(2)}</p>
          <button onclick="cartManager.removeFromCart('${escapeString(item.name)}')" class="remove-btn">
            <i class="fas fa-trash"></i> Remove
          </button>
        </div>`;
    });
    
    if (cart.length === 0) {
      itemsHTML = '<div class="empty-cart"><i class="fas fa-box-open"></i><p>Your cart is empty</p></div>';
      if (checkoutBtn) checkoutBtn.style.display = 'none'; // Hide checkout button if cart is empty
    } else {
      if (checkoutBtn) checkoutBtn.style.display = 'flex'; // Show checkout button if cart has items
    }
    
    cartItemsContainer.innerHTML = itemsHTML;
    cartCount.textContent = itemCount;
    cartTotal.textContent = total.toFixed(2);
    
    // Save to localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
  }
  
  // Helper functions
  function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }
  
  function escapeString(str) {
    return str.replace(/'/g, "\\'").replace(/"/g, '&quot;');
  }
  
  // Create cart manager object
  window.cartManager = {
    addToCart: function(bookName, price) {
      const existingItem = cart.find(item => item.name === bookName);
      if (existingItem) {
        existingItem.quantity++;
      } else {
        cart.push({
          name: bookName,
          price: parseFloat(price),
          quantity: 1
        });
      }
      updateCartDisplay();
      this.showNotification(`${bookName} added to cart!`);
      cartIconContainer.classList.add('active'); // Open cart dropdown when adding items
      cartDropdown.classList.add('show');
    },
    
    updateQuantity: function(bookName, action) {
      const item = cart.find(i => i.name === bookName);
      if (item) {
        if (action === 'increase') item.quantity++;
        else if (action === 'decrease' && item.quantity > 1) item.quantity--;
        else if (action === 'decrease' && item.quantity === 1) this.removeFromCart(bookName);
        updateCartDisplay();
      }
    },
    
    removeFromCart: function(bookName) {
      cart = cart.filter(item => item.name !== bookName);
      updateCartDisplay();
      this.showNotification(`${bookName} removed from cart`, 'warning');
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
  
  // Initialize cart display
  updateCartDisplay();
  
  // Cart toggle functionality
  cartIconContainer.addEventListener('click', function(e) {
    e.stopPropagation();
    cartDropdown.classList.toggle('show');
    this.classList.toggle('active');
  });
  
  // Close when clicking outside
  document.addEventListener('click', function() {
    cartDropdown.classList.remove('show');
    cartIconContainer.classList.remove('active');
  });
  
  // Prevent dropdown from closing when clicking inside
  cartDropdown.addEventListener('click', function(e) {
    e.stopPropagation();
  });
  
  // Handle checkout button
  if (checkoutBtn) {
    checkoutBtn.addEventListener('click', function(e) {
      if (cart.length === 0) {
        e.preventDefault();
        cartManager.showNotification('Your cart is empty! Add items to proceed.', 'warning');
      }
    });
  }
  
  // Listen for storage events (updates from other tabs/pages)
  window.addEventListener('storage', function(e) {
    if (e.key === 'cart') {
      cart = JSON.parse(e.newValue || '[]');
      updateCartDisplay();
    }
  });
});

// Add notification styles
document.head.insertAdjacentHTML('beforeend', `
  <style>
    .cart-notification {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #00d4aa;
      color: white;
      padding: 12px 20px;
      border-radius: 4px;
      display: flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      z-index: 1000;
      animation: slideIn 0.3s ease-out;
    }
    
    .cart-notification.warning {
      background: #ff9800;
    }
    
    .cart-notification i {
      font-size: 18px;
    }
    
    .fade-out {
      animation: fadeOut 0.3s ease-out forwards;
    }
    
    @keyframes slideIn {
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
    
    @keyframes fadeOut {
      to { opacity: 0; }
    }
    
    /* Ensure cart dropdown is visible when active */
    .cart-dropdown.show {
      display: block !important;
      opacity: 1 !important;
      visibility: visible !important;
      transform: translateY(0) !important;
    }
    
    .cart-icon-container.active .cart-icon {
      color: var(--accent-color);
    }
  </style>
`);
</script>
</script>

</body>
</php>