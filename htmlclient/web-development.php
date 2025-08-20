<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Web Development Books - EdUHub</title>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <link rel="stylesheet" href="../CSS/web-development.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
  /* Search and Filter Section */
.search-filter-section {
  background: #f8f9fa;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
    margin-left: 300px;
    margin-right: 300px;
}

.search-filter-section form {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  align-items: center;
}

.search-container_book {
  flex: 2;
  min-width: 250px;
  position: relative;
  display: flex;
  align-items: center;
}

.search-container_book i {
  position: absolute;
  left: 15px;
  color: #6c757d;
}

.search-container_book input {
  width: 100%;
  padding: 12px 15px 12px 45px;
  border: 1px solid #ddd;
  border-radius: 10px;
  font-size: 1rem;
  transition: all 0.3s;
}

.search-container_book input:focus {
  outline: none;
  border-color: #00d4aa;
  box-shadow: 0 0 0 3px rgba(0, 212, 170, 0.2);
}

.category-filter {
  flex: 1;
  min-width: 200px;
}

.category-filter select {
  width: 100%;
  padding: 12px 15px;
  border: 1px solid #ddd;
  border-radius: 10px;
  font-size: 1rem;
  appearance: none;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 15px center;
  background-size: 15px;
  transition: all 0.3s;
}

.category-filter select:focus {
  outline: none;
  border-color: #00d4aa;
  box-shadow: 0 0 0 3px rgba(0, 212, 170, 0.2);
}

.filter-btn, .clear-btn {
  padding: 12px 20px;
  border: none;
  border-radius: 10px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s;
}

.filter-btn {
  background: #032b56;
  color: white;
}

.filter-btn:hover {
  background: #021a36;
  transform: translateY(-2px);
}

.clear-btn {
  background: #6c757d;
  color: white;
  text-decoration: none;
}

.clear-btn:hover {
  background: #5a6268;
  transform: translateY(-2px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .search-filter-section form {
    flex-direction: column;
    align-items: stretch;
  }
  
  .search-container_book, 
  .category-filter {
    min-width: 100%;
  }
  
  .filter-btn, .clear-btn {
    width: 100%;
    justify-content: center;
  }
}

  
  /* Book Card Buttons - Unified Style */
  .book-card button, 
  .book-card .review-btn,
  .book-card .download-btn {
    margin: 12px 5px 0;
    padding: 10px 18px;
    background: #515180;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-width: 120px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  /* Hover States */
  .book-card button:hover, 
  .book-card .review-btn:hover,
  .book-card .download-btn:hover {
    background: #3f3f7d;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  }

  /* Specific Button Styles */
  .book-card .review-btn {
    background-color: #0077df;
  }

  .book-card .review-btn:hover {
    background-color: #0066c0;
  }

  .book-card .download-btn {
    background-color: #28a745;
  }

  .book-card .download-btn:hover {
    background-color: #218838;
  }

  /* Button Container */
  .book-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
    flex-wrap: wrap;
    justify-content: center;
  }

  /* No Results */
  .no-results {
    text-align: center;
    padding: 40px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }
  
  .no-results i {
    font-size: 3rem;
    color: #adb5bd;
    margin-bottom: 15px;
  }
  
  .no-results h3 {
    color: #495057;
    margin-bottom: 10px;
  }
  
  .no-results p {
    color: #6c757d;
  }
  
  @media (max-width: 768px) {
    .search-filter-section {
      flex-direction: column;
      align-items: stretch;
    }
    
    .search-container_book,
    .category-filter {
      width: 100%;
    }
    
    .filter-btn,
    .clear-btn {
      width: 100%;
      justify-content: center;
    }
  }
</style>
<body>

<?php require 'header.php'; ?>

<!-- Hero Section -->
<section class="hero book-hero-web">
  <div class="hero-content">
    <h1>From Average to Extraordinary</h1>
    <p>Your Development Journey Starts Here</p>
  </div>
</section>

<!-- Search and Filter Section -->
<div class="search-filter-section">
  <form method="GET" action="">
    <div class="search-container_book">
      <i class="fas fa-search"></i>
      <input type="text" name="search" placeholder="Search books..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    </div>
    
    <div class="category-filter">
      <select name="category">
        <option value="">All Categories</option>
        <?php 
        $conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");
        $category_result = $conn->query("SELECT DISTINCT category FROM books ORDER BY category");
        while ($cat = $category_result->fetch_assoc()): 
        ?>
          <option value="<?= htmlspecialchars($cat['category']) ?>" 
            <?= (isset($_GET['category']) && $_GET['category'] == $cat['category'] ? 'selected' : '') ?>>
            <?= htmlspecialchars($cat['category']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    
    <button type="submit" class="filter-btn">
      <i class="fas fa-filter"></i> Filter
    </button>
    
    <?php if (isset($_GET['search']) || isset($_GET['category'])): ?>
      <a href="?" class="clear-btn">
        <i class="fas fa-times"></i> Clear
      </a>
    <?php endif; ?>
  </form>
</div>

<!-- Book Section -->
<section class="book-section">
  <div class="container">
    <?php
    $sql = "SELECT id, title, image, author, price, category FROM books WHERE 1=1";
    $params = [];
    $types = '';
    
    if (!empty($_GET['search'])) {
        $sql .= " AND (title LIKE ? OR author LIKE ?)";
        $search = "%" . $_GET['search'] . "%";
        $params[] = $search;
        $params[] = $search;
        $types .= 'ss';
    }
    
    if (!empty($_GET['category'])) {
        $sql .= " AND category = ?";
        $params[] = $_GET['category'];
        $types .= 's';
    }
    
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '
            <div class="book-card">
                <img src="../uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '" />
                <h3>' . htmlspecialchars($row['title']) . '</h3>
                <p>Author: ' . htmlspecialchars($row['author']) . '</p>
                <p>Category: ' . htmlspecialchars($row['category']) . '</p>';
            
            if ($row['price'] !== null) {
                echo '<p>Price: ' . number_format($row['price'], 2) . ' Taka</p>
                      <div class="book-actions">
                        <button onclick="addToCart(\'' . addslashes($row['title']) . '\', ' . $row['price'] . ')" class="add-to-cart-btn">
                          <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                        <a href="review_book.php?id=' . $row['id'] . '" class="review-btn">
                          <i class="fas fa-book-open"></i> Reviews
                        </a>
                      </div>';
            } else {
                echo '<p>Free Download</p>
                      <div class="book-actions">
                        <a href="download.php?id=' . $row['id'] . '" class="download-btn">
                          <i class="fas fa-download"></i> Download
                        </a>
                        <a href="review_book.php?id=' . $row['id'] . '" class="review-btn">
                          <i class="fas fa-book-open"></i> Reviews
                        </a>
                      </div>';
            }
            
            echo '</div>';
        }
    } else {
        echo '
        <div class="no-results">
            <i class="fas fa-book-open"></i>
            <h3>No books found</h3>
            <p>Try adjusting your search or filter criteria</p>
        </div>';
    }
    
    $conn->close();
    ?>
  </div>
</section>

<script>
// Use the cartManager from header.php
function addToCart(bookName, price) {
    if (typeof cartManager !== 'undefined') {
        cartManager.addToCart(bookName, price);
    } else {
        // Fallback in case header.php didn't load properly
        alert('Cart system is not available. Please refresh the page.');
    }
}
</script>

<?php require 'footer.php'; ?>
</body>
</html>