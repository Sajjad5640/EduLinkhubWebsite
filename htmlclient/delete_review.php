<?php

require '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get review ID from URL
$review_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($review_id > 0) {
    // Verify review exists and belongs to the user
    $stmt = $conn->prepare("SELECT r.id, br.bookId, b.title 
                           FROM reviews r
                           JOIN book_reviews br ON r.id = br.reviewId
                           JOIN books b ON br.bookId = b.id
                           WHERE r.id = ? AND r.userId = ?");
    $stmt->bind_param("ii", $review_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $review = $result->fetch_assoc();
    $stmt->close();
    
    if ($review) {
        // Check if confirmation was received via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
            $conn->begin_transaction();
            
            try {
                // Delete from book_reviews first (foreign key constraint)
                $stmt = $conn->prepare("DELETE FROM book_reviews WHERE reviewId = ?");
                $stmt->bind_param("i", $review_id);
                $stmt->execute();
                $stmt->close();
                
                // Then delete from reviews
                $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
                $stmt->bind_param("i", $review_id);
                $stmt->execute();
                $stmt->close();
                
                $conn->commit();
                
                $_SESSION['success'] = "Review deleted successfully!";
                header("Location: review_book.php?id=" . $review['bookId']);
                exit;
            } catch (Exception $e) {
                $conn->rollback();
                $_SESSION['error'] = "Failed to delete review: " . $e->getMessage();
                header("Location: review_book.php?id=" . $review['bookId']);
                exit;
            }
        }
        
        // Show confirmation page if not a POST request
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Delete Review</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --danger: #ef233c;
            --danger-dark: #d90429;
            --dark: #2b2d42;
            --light: #f8f9fa;
            --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        
        .confirmation-modal {
            background: white;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: scale(0.9);
            animation: modalAppear 0.3s forwards;
        }
        
        @keyframes modalAppear {
            to { transform: scale(1); }
        }
        
        .modal-header {
            background: var(--danger);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }
        
        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
        }
        
        .modal-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            color: white;
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .modal-body {
            padding: 30px;
            text-align: center;
        }
        
        .modal-message {
            font-size: 1.1rem;
            color: var(--dark);
            margin-bottom: 25px;
            line-height: 1.6;
        }
        
        .book-title {
            font-weight: 600;
            color: var(--primary);
        }
        
        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-danger {
            background: var(--danger);
            color: white;
        }
        
        .btn-danger:hover {
            background: var(--danger-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 35, 60, 0.3);
        }
        
        .btn-cancel {
            background: #e2e8f0;
            color: var(--dark);
        }
        
        .btn-cancel:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }
        
       
    </style>
</head>
<body>
 
    
    <div class="confirmation-modal">
        <div class="modal-header">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h2>Confirm Deletion</h2>
        </div>
        <div class="modal-body">
            <p class="modal-message">
                Are you sure you want to delete your review for 
                <span class="book-title">"<?= htmlspecialchars($review['title']) ?>"</span>?
                <br><br>
                This action cannot be undone.
            </p>
            
            <form method="POST" class="modal-actions">
                <button type="button" class="btn btn-cancel" onclick="window.history.back()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" name="confirm_delete" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Review
                </button>
            </form>
        </div>
    </div>

    <script>
        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>
<?php
    } else {
        $_SESSION['error'] = "Review not found or you don't have permission to delete it";
        header('Location: web-development.php');
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid review ID";
    header('Location: web-development.php');
    exit;
}
?>