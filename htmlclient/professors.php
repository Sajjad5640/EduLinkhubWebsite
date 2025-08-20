 <?php
// Database connection
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get filter values
$country = $_GET['country'] ?? '';
$university = $_GET['university'] ?? '';
$interest = $_GET['interest'] ?? '';

// Get search term
$search = $_GET['search'] ?? '';

// Build base query
// Build base query
$sql = "SELECT p.*, GROUP_CONCAT(ri.interest SEPARATOR ', ') as research_interests 
        FROM professors p
        LEFT JOIN professor_research_interests ri ON p.id = ri.professor_id";
$where = [];
$params = [];
$types = '';

// Add search filter if provided
if (!empty($search)) {
    $where[] = "(p.name LIKE ? OR ri.interest LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= 'ss';
}

// Add filters if provided
if (!empty($country)) {
    $where[] = "p.country = ?";
    $params[] = $country;
    $types .= 's';
}

if (!empty($university)) {
    $where[] = "p.university_name = ?";
    $params[] = $university;
    $types .= 's';
}

if (!empty($interest)) {
    $where[] = "ri.interest = ?";
    $params[] = $interest;
    $types .= 's';
}

// Complete the query
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " GROUP BY p.id ORDER BY p.name ASC";

// Prepare and execute
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Get filter options
$countries = $conn->query("SELECT DISTINCT country FROM professors WHERE country IS NOT NULL ORDER BY country");
$interests = $conn->query("SELECT DISTINCT interest FROM professor_research_interests ORDER BY interest");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Professors</title>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <link rel="stylesheet" href="../Css/professors.css" /> <!-- Reuse same style -->
</head>
<body>
<?php require 'header.php'; ?>

<!-- Professors Hero Section -->
    <section class="admission-hero">
        <!-- Floating professor icons -->
        <img src="https://cdn-icons-png.flaticon.com/512/2784/2784487.png" class="professor-icon" style="top: 20%; left: 10%; width: 60px;">
        <img src="https://cdn-icons-png.flaticon.com/512/2784/2784487.png" class="professor-icon" style="top: 70%; right: 15%; width: 80px;">
        <img src="https://cdn-icons-png.flaticon.com/512/2784/2784487.png" class="professor-icon" style="bottom: 10%; left: 20%; width: 50px;">
        
        <div class="admission-content">
            <h1>Global Professors Network</h1>
            <p>Connect with renowned professors around the world to guide your academic journey.</p>
           
        </div>
    </section>



   <!-- Filter Section -->
<section class="filter-section">
    <form method="get" action="">
        <div class="filter-row">
            <!-- Search Box -->
            <div class="filter-group">
                <label for="search">Search Professors</label>
                <input type="text" id="search" name="search" placeholder="Name or research interest..." 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            
            <div class="filter-group">
                <label for="country">Country</label>
                <select id="country" name="country">
                    <option value="">All Countries</option>
                    <?php while ($row = $countries->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['country']) ?>" 
                            <?= $row['country'] === $country ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['country']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="university">University</label>
                <select id="university" name="university">
                    <option value="">All Universities</option>
                    <?php if (!empty($country)): 
                        $universities = $conn->prepare("SELECT DISTINCT university_name FROM professors WHERE country = ? ORDER BY university_name");
                        $universities->bind_param('s', $country);
                        $universities->execute();
                        $uniResult = $universities->get_result();
                        while ($uni = $uniResult->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($uni['university_name']) ?>" 
                                <?= $uni['university_name'] === $university ? 'selected' : '' ?>>
                                <?= htmlspecialchars($uni['university_name']) ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="interest">Research Interest</label>
                <select id="interest" name="interest">
                    <option value="">All Interests</option>
                    <?php while ($row = $interests->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['interest']) ?>" 
                            <?= $row['interest'] === $interest ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['interest']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        
        <div class="filter-actions">
            <button type="submit" class="filter-btn">
              <i class="fas fa-filter"></i>Filters</button>
            <a href="?" class="filter-btn reset-btn">
              <i class="fas fa-times"></i>Reset</a>
        </div>
    </form>
</section>

<script>
// Dynamic university dropdown loading
document.getElementById('country').addEventListener('change', function() {
    const country = this.value;
    const universitySelect = document.getElementById('university');
    
    // Clear existing options except the first one
    universitySelect.innerHTML = '<option value="">All Universities</option>';
    
    if (country) {
        // Show loading state
        universitySelect.disabled = true;
        universitySelect.innerHTML = '<option value="">Loading universities...</option>';
        
        // Fetch universities for selected country
        fetch(`get_universities.php?country=${encodeURIComponent(country)}`)
            .then(response => response.json())
            .then(universities => {
                universitySelect.innerHTML = '<option value="">All Universities</option>';
                universities.forEach(uni => {
                    const option = document.createElement('option');
                    option.value = uni;
                    option.textContent = uni;
                    universitySelect.appendChild(option);
                });
                universitySelect.disabled = false;
            })
            .catch(error => {
                universitySelect.innerHTML = '<option value="">Error loading universities</option>';
                console.error('Error:', error);
            });
    }
});
</script>

    <!-- Professors List -->
<section class="container_professor" id="professorsList">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($prof = $result->fetch_assoc()): 
            $interests = json_decode($prof['research_interests'], true) ?: [];
            ?>
            <div class="university-card">
    <?php if ($prof['image'] !== ''): ?>
    <img class="prof-pic" src="../uploads/<?= htmlspecialchars($prof['image']) ?>" alt="<?= htmlspecialchars($prof['name']) ?>">
<?php endif; ?>
    <div class="professor-info">
        <h2><?= htmlspecialchars($prof['name']) ?></h2>
        <p><strong><?= htmlspecialchars($prof['university_name']) ?></strong>, <?= htmlspecialchars($prof['country']) ?></p>
        
        <div class="availability <?= $prof['availability'] === 'available' ? 'available' : 'not-available' ?>">
            <?= ucfirst($prof['availability']) ?>
        </div>
        
        <?php 
// Get interests as array
$interests = !empty($prof['research_interests']) ? 
    explode(', ', $prof['research_interests']) : 
    [];
?>

<?php if (!empty($interests)): ?>
    <div class="research-interests">
        <strong>Research Interests: </strong>
        <div class="interests-list">
            <?php foreach ($interests as $interest): ?>
                <span class="interest-tag"><?= htmlspecialchars(trim($interest)) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
        
        <div class="contact-info">
            <p><strong>Email:</strong> <?= htmlspecialchars($prof['contact_email']) ?></p>
            <?php if (!empty($prof['contact_phone'])): ?>
                <p><strong>Phone:</strong> <?= htmlspecialchars($prof['contact_phone']) ?></p>
            <?php endif; ?>
        </div>
        
        <a href="professor_details.php?id=<?= $prof['id'] ?>" class="profile-link">
    View Full Profile →
</a>
    </div>
</div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-results">
            <p>No professors found matching your criteria.</p>
            <p><a href="?" class="profile-link">Reset filters</a> to see all professors.</p>
        </div>
    <?php endif; ?>
</section>

    <script>
        // Auto-submit university dropdown when country changes
        document.getElementById('country').addEventListener('change', function() {
            document.getElementById('university').value = '';
        });
    </script>


 <?php require 'footer.php'; ?>

  <!-- JavaScript -->
  <script>
    const profile = document.getElementById('userProfile');
    profile.addEventListener('click', function (e) {
      e.stopPropagation();
      profile.classList.toggle('active');
    });
    document.addEventListener('click', function () {
      profile.classList.remove('active');
    });
  </script>
  

</body>
</html>
