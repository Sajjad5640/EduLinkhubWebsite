<?php
require '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get book ID from URL
$book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

// Verify book exists
$book = null;
if ($book_id > 0) {
    $stmt = $conn->prepare("SELECT id, title FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    $stmt->close();
    
    if (!$book) {
        $_SESSION['error'] = "Book not found";
        header('Location: web-development.php');
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid book ID";
    header('Location: web-development.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    
    // Validate input
    if (empty($message)) {
        $_SESSION['error'] = "Please enter your review message";
    } else {
        // Insert review
        $conn->begin_transaction();
        
        try {
            // Insert into reviews table
            $stmt = $conn->prepare("INSERT INTO reviews (userId, message) VALUES (?, ?)");
            $stmt->bind_param("is", $_SESSION['user_id'], $message);
            $stmt->execute();
            $review_id = $stmt->insert_id;
            $stmt->close();
            
            // Insert into book_reviews table
            $stmt = $conn->prepare("INSERT INTO book_reviews (bookId, reviewId) VALUES (?, ?)");
            $stmt->bind_param("ii", $book_id, $review_id);
            $stmt->execute();
            $stmt->close();
            
            $conn->commit();
            
            $_SESSION['success'] = "Review submitted successfully!";
            header("Location: review_book.php?id=$book_id");
            exit;
        } catch (Exception $e) {
            $conn->rollback();
            $_SESSION['error'] = "Failed to submit review: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review - <?= htmlspecialchars($book['title']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --dark: #2b2d42;
            --light: #f8f9fa;
            --danger: #ef233c;
            --success: #4cc9f0;
            --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7ff;
            color: var(--dark);
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
        }
        
        /* Floating Back Button */
        .floating-back {
            position: fixed;
            top: 100px;
            left: 55px;
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--box-shadow);
            z-index: 1000;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            color: var(--primary);
        }

        .floating-back:hover {
            transform: translateX(-5px);
            color: var(--secondary);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }
        
        .review-form {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-top: 30px;
        }
        
        .form-header {
            margin-bottom: 2rem;
        }
        
        .form-header h1 {
            margin: 0 0 0.5rem;
            color: var(--dark);
        }
        
        .form-header p {
            margin: 0;
            color: #64748b;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .form-group textarea {
            width: 100%;
            min-height: 200px;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            resize: vertical;
            transition: all 0.3s ease;
        }
        
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        .submit-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .submit-btn:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }
        
        .message {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .error {
            background-color: rgba(239, 35, 60, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }
        
        .success {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }
        
        .char-count {
            font-size: 0.8rem;
            color: #64748b;
            text-align: right;
            margin-top: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .floating-back {
                top: 15px;
                left: 15px;
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <?php require 'header.php'; ?>
    
    <button class="floating-back" aria-label="Go back">
        <i class="fas fa-arrow-left"></i>
    </button>
    
    <div class="container">
        <div class="review-form">
            <div class="form-header">
                <h1>Add Your Review</h1>
                <p>Share your thoughts about "<?= htmlspecialchars($book['title']) ?>"</p>
            </div>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="message error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="message">Your Review</label>
                    <textarea id="message" name="message" placeholder="Write your review here..." required><?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?></textarea>
                    <div class="char-count"><span id="char-counter">0</span> characters</div>
                </div>
                
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Submit Review
                </button>
            </form>
        </div>
    </div>
    
    <?php require 'footer.php'; ?>
    
    <script>
        // Character counter for the review text
        const textarea = document.getElementById('message');
        const charCounter = document.getElementById('char-counter');
        
        textarea.addEventListener('input', function() {
            charCounter.textContent = this.value.length;
        });
        
        // Initialize counter on page load
        charCounter.textContent = textarea.value.length;
        
        // Back button functionality
        document.querySelector('.floating-back').addEventListener('click', function() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = 'review_book.php?id=<?= $book_id ?>';
            }
        });
    </script>
</body>
</html>