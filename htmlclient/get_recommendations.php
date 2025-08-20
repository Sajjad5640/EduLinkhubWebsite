<?php
// get_recommendations.php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

try {
    // Fetch recommended books - removed the WHERE featured=1 condition
    $query = "
        SELECT 
            id,
            title,
            image,
            author,
            category,
            description,
            pdf,
            uploadDate,
            suggestedFor,
            price
        FROM books 
        ORDER BY RAND() 
        LIMIT 10
    ";
    
    $result = $conn->query($query);
    
    if ($result === false) {
        throw new Exception($conn->error);
    }
    
    $books = [];
    while ($row = $result->fetch_assoc()) {
        // Format the data as needed
        $books[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'author' => $row['author'],
            'price' => (float)$row['price'],
            'image' => $row['image'] ?: 'https://via.placeholder.com/200x300?text=Book',
            'category' => $row['category'],
            'description' => $row['description'],
            'pdf' => $row['pdf'],
            'uploadDate' => $row['uploadDate'],
            'suggestedFor' => $row['suggestedFor']
        ];
    }
    
    // Free result set
    $result->free();
    
    // Close connection
    $conn->close();
    
    // Return as JSON
    echo json_encode($books);
    
} catch (Exception $e) {
    // Close connection if still open
    if (isset($conn) && $conn) {
        $conn->close();
    }
    
    // Return error response
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}