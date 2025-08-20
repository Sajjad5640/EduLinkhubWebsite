<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");

if ($conn->connect_error) {
    die(json_encode([]));
}

$country = $_GET['country'] ?? '';
$universities = [];

if (!empty($country)) {
    $stmt = $conn->prepare("SELECT DISTINCT university_name FROM professors WHERE country = ? ORDER BY university_name");
    $stmt->bind_param('s', $country);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $universities[] = $row['university_name'];
    }
}

echo json_encode($universities);
$conn->close();
?>