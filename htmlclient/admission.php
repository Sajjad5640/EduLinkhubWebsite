



<?php
// Database connection
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get filter values
$location = $_GET['location'] ?? '';
$programType = $_GET['programType'] ?? '';
$unit = $_GET['unit'] ?? '';

// Get search term
$search = $_GET['search'] ?? '';

// Build base query
$sql = "SELECT u.*, 
        GROUP_CONCAT(e.unit SEPARATOR '|') as exam_units,
        GROUP_CONCAT(e.date SEPARATOR '|') as exam_dates
        FROM universities u
        LEFT JOIN exam_units e ON u.id = e.university_id";
$where = [];
$params = [];
$types = '';

// Add search filter if provided
if (!empty($search)) {
    $where[] = "(u.name LIKE ? OR u.location LIKE ? OR u.programType LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= 'sss';
}

// Add filters if provided
if (!empty($location)) {
    $where[] = "u.location = ?";
    $params[] = $location;
    $types .= 's';
}

if (!empty($programType)) {
    $where[] = "u.programType = ?";
    $params[] = $programType;
    $types .= 's';
}

if (!empty($unit)) {
    $where[] = "e.unit = ?";
    $params[] = $unit;
    $types .= 's';
}

// Complete the query
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " GROUP BY u.id ORDER BY u.applicationDeadline ASC";

// Prepare and execute
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Get filter options
// Get filter options - we'll modify this part
$locations = $conn->query("SELECT DISTINCT location FROM universities WHERE location IS NOT NULL ORDER BY location");
if (!empty($location)) {
    $programTypes = $conn->prepare("SELECT DISTINCT programType FROM universities WHERE location = ? ORDER BY programType");
    $programTypes->bind_param('s', $location);
    $programTypes->execute();
    $programTypes = $programTypes->get_result();
} else {
    $programTypes = $conn->query("SELECT DISTINCT programType FROM universities WHERE programType IS NOT NULL ORDER BY programType");
}

$units = $conn->query("SELECT DISTINCT unit FROM exam_units ORDER BY unit");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>University Admissions</title>
  <link rel="stylesheet" href="../CSS/admission.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php require 'header.php'; ?>
<section class="admission-hero">
    <div class="admission-content">
      <h1>Bangladesh University Admission</h1>
      <p>Explore public universities, stay updated with admission dates, and find the perfect fit for your future.</p>
      <div class="admission-buttons">
       
      </div>
    </div>
  </section>
  <!-- University Cards -->
<!-- Filter Section -->
<section class="filter-section">
    <form method="get" action="">
        <div class="filter-row">
            <!-- Search Box -->
            <div class="filter-group search-filter-group">
                <label for="search">Search Universities</label>
                <i class="fas fa-search"></i>
                <input type="text" id="search" name="search" placeholder="Name, location or program type..." 
                       value="<?= htmlspecialchars($search) ?>">
            </div>
            
            <div class="filter-group">
                <label for="location">Location</label>
                <select id="location" name="location">
                    <option value="">All Locations</option>
                    <?php while ($row = $locations->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['location']) ?>" 
                            <?= $row['location'] === $location ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['location']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="programType">Program Type</label>
                <select id="programType" name="programType">
                    <option value="">All Program Types</option>
                    <?php while ($row = $programTypes->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['programType']) ?>" 
                            <?= $row['programType'] === $programType ? 'selected' : '' ?>>
                            <?= ucfirst(htmlspecialchars($row['programType'])) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="unit">Exam Unit</label>
                <select id="unit" name="unit">
                    <option value="">All Exam Units</option>
                    <?php while ($row = $units->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['unit']) ?>" 
                            <?= $row['unit'] === $unit ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['unit']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        
        <div class="filter-actions">
            <button type="submit" class="filter-btn">
                <i class="fas fa-filter"></i>Filters
            </button>
            <a href="?" class="filter-btn reset-btn">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </form>
</section>

  <!-- University Cards -->
  <section class="container_admission" id="universityList">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($university = $result->fetch_assoc()): 
        $exam_units = !empty($university['exam_units']) ? explode('|', $university['exam_units']) : [];
        $exam_dates = !empty($university['exam_dates']) ? explode('|', $university['exam_dates']) : [];
        ?>
        <div class="university-card">
          <?php if ($university['image'] !== ''): ?>
    <img class="university-img" src="../uploads/<?= htmlspecialchars($university['image']) ?>" alt="<?= htmlspecialchars($university['name']) ?>">
<?php endif; ?>
          <div class="card-content">
            <h2><?= htmlspecialchars($university['name']) ?></h2>
            <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($university['location']) ?></p>
            <p><strong>Program:</strong> <?= ucfirst(htmlspecialchars($university['programType'])) ?></p>
            <p><strong>Discipline:</strong> <?= htmlspecialchars($university['discipline']) ?></p>
            
            <?php if (!empty($exam_units)): ?>
              <div class="exam-units-preview">
                <strong>Exam Units:</strong>
                <?php foreach (array_slice($exam_units, 0, 3) as $index => $unit): ?>
                  <span class="unit-tag"><?= htmlspecialchars($unit) ?></span>
                <?php endforeach; ?>
                <?php if (count($exam_units) > 3): ?>
                  <span class="more-units">+<?= count($exam_units) - 3 ?> more</span>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            
            <p class="deadline"><strong>Deadline:</strong> <?= date('M j, Y', strtotime($university['applicationDeadline'])) ?></p>
            
            <div class="card-actions">
              <a href="view_details_admission.php?id=<?= $university['id'] ?>" class="details-btn">
                <i class="fas fa-info-circle"></i> Details
              </a>
              <a href="<?= htmlspecialchars($university['admissionLink']) ?>" target="_blank" class="apply-btn">
                <i class="fas fa-paper-plane"></i> Apply
              </a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="no-results">
        <i class="fas fa-university"></i>
        <p>No universities found matching your criteria.</p>
        <a href="?" class="reset-btn">Reset filters</a>
      </div>
    <?php endif; ?>
  </section>

<?php require 'footer.php'; ?>

<script>
// Dynamic program type dropdown loading based on location
document.getElementById('location').addEventListener('change', function() {
    const location = this.value;
    const programTypeSelect = document.getElementById('programType');
    
    // Clear existing options except the first one
    programTypeSelect.innerHTML = '<option value="">All Program Types</option>';
    
    if (location) {
        // Show loading state
        programTypeSelect.disabled = true;
        programTypeSelect.innerHTML = '<option value="">Loading program types...</option>';
        
        // Fetch program types for selected location
        fetch(`get_program_types.php?location=${encodeURIComponent(location)}`)
            .then(response => response.json())
            .then(programTypes => {
                programTypeSelect.innerHTML = '<option value="">All Program Types</option>';
                programTypes.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type;
                    option.textContent = type.charAt(0).toUpperCase() + type.slice(1);
                    programTypeSelect.appendChild(option);
                });
                programTypeSelect.disabled = false;
            })
            .catch(error => {
                programTypeSelect.innerHTML = '<option value="">Error loading program types</option>';
                console.error('Error:', error);
            });
    }
});

// Submit form when program type is selected to apply filters immediately
document.getElementById('programType').addEventListener('change', function() {
    this.form.submit();
});
</script>

  <!-- JavaScript -->
  <script>
    const profile = document.getElementById('userProfile');

    profile.addEventListener('click', function (e) {
      e.stopPropagation(); // Prevent bubbling
      profile.classList.toggle('active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function () {
      profile.classList.remove('active');
    });
  </script>

  <script>
// Search functionality
const searchInput = document.getElementById("search");
const universityCards = document.querySelectorAll(".university-card");

function performSearch() {
  const query = searchInput.value.toLowerCase().trim();
  
  universityCards.forEach(card => {
    const title = card.querySelector("h2").textContent.toLowerCase();
    const location = card.querySelector(".fa-map-marker-alt").parentNode.textContent.toLowerCase();
    const programType = card.querySelector("strong:contains('Program')").nextSibling.textContent.toLowerCase().trim();
    
    const matches = title.includes(query) || location.includes(query) || programType.includes(query);
    card.style.display = matches ? "block" : "none";
  });
}

searchInput.addEventListener("input", performSearch);
</script>
</body>
</html>

