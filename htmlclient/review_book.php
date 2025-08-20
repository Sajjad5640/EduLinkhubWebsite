<?php
session_start();
// Database connection
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get book ID from URL parameter
$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch book details
$book = null;
$reviews = [];

if ($book_id > 0) {
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        
        // Fetch reviews for this book from the joined tables
        $review_query = "SELECT r.*, u.name as user_name 
                        FROM book_reviews br
                        JOIN reviews r ON br.reviewId = r.id
                        JOIN users u ON r.userId = u.id
                        WHERE br.bookId = ?
                        ORDER BY r.createdAt DESC";
        
        $review_stmt = $conn->prepare($review_query);
        $review_stmt->bind_param("i", $book_id);
        $review_stmt->execute();
        $review_result = $review_stmt->get_result();
        
        if ($review_result->num_rows > 0) {
            $reviews = $review_result->fetch_all(MYSQLI_ASSOC);
        }
        $review_stmt->close();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($book['title']) ? htmlspecialchars($book['title']) : 'Book Not Found' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .back-btn {
            display: inline-block;
            margin: 20px;
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .back-btn:hover {
            background-color: #2980b9;
        }
        .book-header {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .book-cover {
            width: 300px;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .book-info {
            flex: 1;
        }
        .book-title {
            font-size: 2.2rem;
            margin: 0 0 10px;
            color: #2c3e50;
        }
        .book-author {
            font-size: 1.2rem;
            color: #7f8c8d;
            margin: 0 0 20px;
        }
        .book-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #34495e;
        }
        .book-description, .suggested-for {
            margin-bottom: 25px;
        }
        .book-description h3, .suggested-for h3 {
            margin: 0 0 10px;
            color: #2c3e50;
            font-size: 1.3rem;
        }
        .book-description p, .suggested-for p {
            margin: 0;
            color: #34495e;
        }
        .reviews-section {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .reviews-section h2 {
            margin: 0 0 20px;
            color: #2c3e50;
            font-size: 1.8rem;
        }
.review-card {
    border-bottom: 1px solid #eee;
    padding: 20px;
    margin-bottom: 15px;
    background: #f9f9f9;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.review-card:hover {
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.review-user {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #3498db;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-weight: bold;
}

.user-name {
    font-weight: 600;
    color: #2c3e50;
}

.review-date {
    font-size: 0.85rem;
    color: #7f8c8d;
    margin-left: auto;
}

.review-content {
    padding: 10px 0;
    color: #34495e;
    line-height: 1.6;
}

.review-actions {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

.review-action {
    color: #7f8c8d;
    font-size: 0.9rem;
    cursor: pointer;
    transition: color 0.2s;
}

.review-action:hover {
    color: #3498db;
}

.review-action i {
    margin-right: 5px;
}

.add-review-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    margin-bottom: 20px;
    transition: background-color 0.3s;
}

.add-review-btn:hover {
    background-color: #2980b9;
}
        .review-card:last-child {
            border-bottom: none;
        }
        .review-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #7f8c8d;
        }
        .review-content {
            margin-bottom: 10px;
            color: #34495e;
        }
        .review-rating {
            color: #f39c12;
            font-size: 1.2rem;
        }
        .no-reviews {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }
        .error-message {
            text-align: center;
            padding: 50px;
            color: #e74c3c;
        }
        .book-details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        .detail-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .detail-item strong {
            display: block;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        .detail-item span {
            color: #34495e;
        }
        @media (max-width: 768px) {
            .book-header {
                flex-direction: column;
            }
            .book-cover {
                width: 100%;
                max-width: 300px;
                margin: 0 auto;
            }
            .book-details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php require 'header.php'; ?>
    <div class="container">
        <a href="javascript:history.back()" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Books
        </a>

        <?php if ($book): ?>
            <div class="book-header">
                <?php if ($book['image'] !== ''): ?>
    <img class="book-cover" src="../uploads/<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
<?php endif; ?>
                <div class="book-info">
                    <h1 class="book-title"><?= htmlspecialchars($book['title']) ?></h1>
                    <p class="book-author">by <?= htmlspecialchars($book['author']) ?></p>
                    
                    <div class="book-details-grid">
                        <div class="detail-item">
                            <strong>ID</strong>
                            <span><?= htmlspecialchars($book['id']) ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Category</strong>
                            <span><?= htmlspecialchars($book['category']) ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Upload Date</strong>
                            <span><?= date('M d, Y', strtotime($book['uploadDate'])) ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Status</strong>
                            <span><?= $book['isPaid'] ? 'Paid' : 'Free' ?></span>
                        </div>
                        <?php if ($book['isPaid']): ?>
                            <div class="detail-item">
                                <strong>Price</strong>
                                <span><?= number_format($book['price'], 2) ?> Taka</span>
                            </div>
                        <?php endif; ?>
                        <div class="detail-item">
                            <strong>Created At</strong>
                            <span><?= date('M d, Y H:i', strtotime($book['createdAt'])) ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Updated At</strong>
                            <span><?= date('M d, Y H:i', strtotime($book['updatedAt'])) ?></span>
                        </div>
                    </div>
                    
                    <div class="book-description">
                        <h3>Description</h3>
                        <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
                    </div>
                    
                    <div class="suggested-for">
                        <h3>Suggested For</h3>
                        <p><?= htmlspecialchars($book['suggestedFor']) ?></p>
                    </div>
                    
                    <?php if (!empty($book['pdf'])): ?>
                        <div class="pdf-download">
                            <a href="<?= htmlspecialchars($book['pdf']) ?>" class="download-btn" download>
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="reviews-section">
    <h2>Reviews</h2>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="add_review.php?book_id=<?= $book_id ?>" class="add-review-btn">
            <i class="fas fa-plus"></i> Add Your Review
        </a>
    <?php endif; ?>
    
    <?php if (count($reviews) > 0): ?>
        <?php foreach ($reviews as $review): ?>
            <div class="review-card">
                <div class="review-user">
                    <div class="user-avatar">
                        <?= strtoupper(substr($review['user_name'], 0, 1)) ?>
                    </div>
                    <div class="user-name"><?= htmlspecialchars($review['user_name']) ?></div>
                    <div class="review-date">
                        <?= date('M j, Y \a\t g:i a', strtotime($review['createdAt'])) ?>
                        <?php if ($review['createdAt'] != $review['updatedAt']): ?>
                            <br><small>(edited)</small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="review-content">
                    <?= nl2br(htmlspecialchars($review['message'])) ?>
                </div>
                
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['userId']): ?>
                    <div class="review-actions">
                        <a href="edit_review.php?id=<?= $review['id'] ?>" class="review-action">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="delete_review.php?id=<?= $review['id'] ?>" class="review-action">
    <i class="fas fa-trash"></i> Delete
</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-reviews">
            <i class="fas fa-comment-slash" style="font-size: 2rem; margin-bottom: 10px;"></i>
            <p>No reviews yet for this book. Be the first to review!</p>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="add_review.php?book_id=<?= $book_id ?>" class="add-review-btn">
                    <i class="fas fa-plus"></i> Add Your Review
                </a>
            <?php else: ?>
                <p><a href="login.php">Login</a> to leave a review</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
        <?php else: ?>
            <div class="error-message">
                <h2>Book not found</h2>
                <p>The requested book could not be found.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php $conn->close(); ?>
    <?php require 'footer.php'; ?>
</body>
</html>