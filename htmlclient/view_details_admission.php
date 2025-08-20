<?php
// Database connection
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get university ID from URL
$university_id = $_GET['id'] ?? 0;

// Fetch university details
$university_sql = "SELECT * FROM universities WHERE id = ?";
$stmt = $conn->prepare($university_sql);
$stmt->bind_param("i", $university_id);
$stmt->execute();
$university_result = $stmt->get_result();
$university = $university_result->fetch_assoc();

// Fetch exam units
$units_sql = "SELECT * FROM exam_units WHERE university_id = ? ORDER BY date ASC";
$stmt = $conn->prepare($units_sql);
$stmt->bind_param("i", $university_id);
$stmt->execute();
$units_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($university['name'] ?? 'University Details') ?></title>
  <link rel="stylesheet" href="../CSS/admission.css" />
  <link rel="stylesheet" href="../CSS/view_details.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php require 'header.php'; ?>

  <?php if ($university): ?>
    <section class="university-detail-container">
      <div class="university-header">
        <?php if ($university['image'] !== ''): ?>
    <img class="detail-img" src="../uploads/<?= htmlspecialchars($university['image']) ?>" alt="<?= htmlspecialchars($university['name']) ?>">
<?php endif; ?>
        <div class="header-content">
          <h1><?= htmlspecialchars($university['name']) ?></h1>
          <p class="location"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($university['location']) ?></p>
          
          <div class="program-info">
            <span class="program-type <?= htmlspecialchars($university['programType']) ?>">
              <?= ucfirst(htmlspecialchars($university['programType'])) ?>
            </span>
            <span class="discipline"><?= htmlspecialchars($university['discipline']) ?></span>
          </div>
          
          <a href="<?= htmlspecialchars($university['admissionLink']) ?>" 
             target="_blank" 
             class="apply-btn">
            <i class="fas fa-paper-plane"></i> Apply Now
          </a>
        </div>
      </div>
      
      <div class="detail-content">
        <div class="dates-section">
          <h2><i class="fas fa-calendar-alt"></i> Important Dates</h2>
          <div class="date-item">
            <span>Application Opens:</span>
            <span><?= date('F j, Y', strtotime($university['applicationDate'])) ?></span>
          </div>
          <div class="date-item deadline">
            <span>Application Deadline:</span>
            <span><?= date('F j, Y', strtotime($university['applicationDeadline'])) ?></span>
          </div>
          <?php if (!empty($university['admitCardDownloadDate'])): ?>
            <div class="date-item">
              <span>Admit Card Download:</span>
              <span><?= date('F j, Y', strtotime($university['admitCardDownloadDate'])) ?></span>
            </div>
          <?php endif; ?>
        </div>
        
        <?php if ($units_result->num_rows > 0): ?>
          <div class="exam-section">
            <h2><i class="fas fa-book-open"></i> Exam Information</h2>
            <div class="exam-table">
              <table>
                <thead>
                  <tr>
                    <th>Unit Name</th>
                    <th>Exam Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($unit = $units_result->fetch_assoc()): ?>
                    <tr>
                      <td><?= htmlspecialchars($unit['unit']) ?></td>
                      <td><?= date('F j, Y', strtotime($unit['date'])) ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </section>
  <?php else: ?>
    <div class="no-results">
      <p>University not found.</p>
      <a href="admission.php" class="back-btn">Back to Universities</a>
    </div>
  <?php endif; ?>

<?php require 'footer.php'; ?>
</body>
</html>
<?php $conn->close(); ?>