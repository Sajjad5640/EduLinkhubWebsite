<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");

// Check connection
if ($conn->connect_error) {
    die(json_encode([]));
}

$university = $_GET['university'] ?? '';

if (!empty($university)) {
    $stmt = $conn->prepare("SELECT DISTINCT department FROM fundings WHERE university = ? AND department IS NOT NULL ORDER BY department");
    $stmt->bind_param('s', $university);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $departments = [];
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row['department'];
    }
    
    echo json_encode($departments);
} else {
    echo json_encode([]);
}

$conn->close();
?>