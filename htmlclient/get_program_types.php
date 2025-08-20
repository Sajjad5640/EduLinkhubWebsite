<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");

// Check connection
if ($conn->connect_error) {
    die(json_encode([]));
}

$location = $_GET['location'] ?? '';

if (!empty($location)) {
    $stmt = $conn->prepare("SELECT DISTINCT programType FROM universities WHERE location = ? ORDER BY programType");
    $stmt->bind_param('s', $location);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $programTypes = [];
    while ($row = $result->fetch_assoc()) {
        $programTypes[] = $row['programType'];
    }
    
    echo json_encode($programTypes);
} else {
    echo json_encode([]);
}

$conn->close();
?>