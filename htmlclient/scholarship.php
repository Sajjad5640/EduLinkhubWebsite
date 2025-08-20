<?php
// Database connection
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current tab (default to scholarship)
$current_tab = $_GET['tab'] ?? 'scholarship';

// Get filter values
$university = $_GET['university'] ?? '';
$department = $_GET['department'] ?? '';
$search = $_GET['search'] ?? '';
$professor_name = $_GET['professor_name'] ?? ''; // New professor name filter

// Build base query
if ($current_tab === 'professor') {
    // For professor grants, join with professors table
    $sql = "SELECT f.*, p.name as professor_name FROM fundings f 
            LEFT JOIN professors p ON f.professor_id = p.id";
} else {
    // For scholarships
    $sql = "SELECT f.* FROM fundings f";
}

$where = ["f.type = ?"];
$params = [$current_tab];
$types = 's';

// Add filters if provided
if (!empty($university)) {
    $where[] = "f.university = ?";
    $params[] = $university;
    $types .= 's';
}

if (!empty($department)) {
    $where[] = "f.department = ?";
    $params[] = $department;
    $types .= 's';
}

// Handle search differently for professor vs scholarship tabs
if (!empty($search)) {
    if ($current_tab === 'professor') {
        // For professor grants, search professor name, university, or department
        $where[] = "(p.name LIKE ? OR f.university LIKE ? OR f.department LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $types .= 'sss';
    } else {
        // For scholarships, search title, university, or department
        $where[] = "(f.title LIKE ? OR f.university LIKE ? OR f.department LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $types .= 'sss';
    }
}

// Add professor name filter if provided (only for professor tab)
if ($current_tab === 'professor' && !empty($professor_name)) {
    $where[] = "p.name LIKE ?";
    $params[] = "%$professor_name%";
    $types .= 's';
}

// Complete the query
$sql .= " WHERE " . implode(" AND ", $where) . " ORDER BY f.applicationDeadline ASC";

// Prepare and execute
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Get filter options
$universities = $conn->query("SELECT DISTINCT university FROM fundings WHERE type = '$current_tab' AND university IS NOT NULL ORDER BY university");
$departments = [];

if (!empty($university)) {
    $dept_stmt = $conn->prepare("SELECT DISTINCT department FROM fundings WHERE type = ? AND university = ? AND department IS NOT NULL ORDER BY department");
    $dept_stmt->bind_param('ss', $current_tab, $university);
    $dept_stmt->execute();
    $departments = $dept_stmt->get_result();
} else {
    $departments = $conn->query("SELECT DISTINCT department FROM fundings WHERE type = '$current_tab' AND department IS NOT NULL ORDER BY department");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= ucfirst($current_tab) ?> Opportunities</title>
  <link rel="stylesheet" href="../CSS/scholarship.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php require 'header.php'; ?>

  <!-- Hero Section -->
  <section class="scholarship-hero">
    <div class="hero-content">
      <h1><?= ucfirst($current_tab) ?> Opportunities</h1>
      <p>Discover <?= $current_tab === 'scholarship' ? 'fully funded and merit-based scholarships' : 'research grants and funding opportunities' ?> from top global institutions.</p>
    </div>
  </section>

  <!-- Tab Navigation -->
  <div class="opportunity-tabs">
    <a href="?tab=scholarship" class="tab-btn <?= $current_tab === 'scholarship' ? 'active' : '' ?>">
      <i class="fas fa-graduation-cap"></i> Scholarships
    </a>
    <a href="?tab=professor" class="tab-btn <?= $current_tab === 'professor' ? 'active' : '' ?>">
      <i class="fas fa-user-tie"></i> Professor Grants
    </a>
  </div>

<!-- Filter Section -->
<section class="filter-section">
    <form method="get" action="">
        <input type="hidden" name="tab" value="<?= $current_tab ?>">
        
        <div class="filter-row">
            <?php if ($current_tab === 'professor'): ?>
                <!-- Single search box for professor grants -->
                <div class="filter-group search-filter-group">
                    <label for="search">Search Professors</label>
                    <i class="fas fa-search"></i>
                    <input type="text" id="search" name="search" 
                           placeholder="Professor name, university or department..." 
                           value="<?= htmlspecialchars($search) ?>">
                </div>
            <?php else: ?>
                <!-- Regular search box for scholarships -->
                <div class="filter-group search-filter-group">
                    <label for="search">Search Scholarships</label>
                    <i class="fas fa-search"></i>
                    <input type="text" id="search" name="search" 
                           placeholder="Title, university or department..." 
                           value="<?= htmlspecialchars($search) ?>">
                </div>
            <?php endif; ?>
            
            <div class="filter-group">
                <label for="university">University</label>
                <select id="university" name="university">
                    <option value="">All Universities</option>
                    <?php while ($row = $universities->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['university']) ?>" 
                            <?= $row['university'] === $university ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['university']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="department">Department</label>
                <select id="department" name="department">
                    <option value="">All Departments</option>
                    <?php while ($row = $departments->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['department']) ?>" 
                            <?= $row['department'] === $department ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['department']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        
        <div class="filter-actions">
            <button type="submit" class="filter-btn">
                <i class="fas fa-filter"></i> Apply Filters
            </button>
            <a href="?tab=<?= $current_tab ?>" class="filter-btn reset-btn">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </form>
</section>

  <!-- Opportunities Section -->
<section class="scholarship-section">
    <div class="scholarship-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($opportunity = $result->fetch_assoc()): ?>
                <div class="scholarship-card">
                    <!-- <div class="card-image">
                        <img src="<?= !empty($opportunity['image']) ? htmlspecialchars($opportunity['image']) : '../images/default-' . $current_tab . '.jpg' ?>" 
                             alt="<?= htmlspecialchars($opportunity['title']) ?>">
                    </div> -->
                    <div class="card-content">
                        <h3><?= htmlspecialchars($opportunity['title']) ?></h3>
                        
                        <?php if ($current_tab === 'professor' && !empty($opportunity['professor_id'])): 
                            // Fetch professor details
                            $prof_stmt = $conn->prepare("SELECT name, id FROM professors WHERE id = ?");
                            $prof_stmt->bind_param('i', $opportunity['professor_id']);
                            $prof_stmt->execute();
                            $professor = $prof_stmt->get_result()->fetch_assoc();
                            ?>
                            <div class="professor-highlight">
                                <a href="professor_details.php?id=<?= $professor['id'] ?>" class="professor-link">
                                    <i class="fas fa-user-tie"></i> 
                                    <strong><?= htmlspecialchars($professor['name'] ?? '') ?></strong>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($opportunity['university'])): ?>
                            <p class="institution">
                                <i class="fas fa-university"></i> <?= htmlspecialchars($opportunity['university']) ?>
                                <?php if (!empty($opportunity['department'])): ?>
                                    <span class="department">(<?= htmlspecialchars($opportunity['department']) ?>)</span>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                        
                        <p class="description"><?= htmlspecialchars(substr($opportunity['description'], 0, 100)) ?>...</p>
                        
                        <div class="dates">
                            <p><strong>Apply From:</strong> <?= date('F j, Y', strtotime($opportunity['applyDate'])) ?></p>
                            <p class="deadline"><strong>Deadline:</strong> <?= date('F j, Y', strtotime($opportunity['applicationDeadline'])) ?></p>
                        </div>
                        
                        <div class="card-actions">
                            <a href="funding_details.php?id=<?= $opportunity['id'] ?>" class="details-btn">
                                <i class="fas fa-info-circle"></i> Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-results">
                <i class="fas fa-<?= $current_tab === 'scholarship' ? 'graduation-cap' : 'user-tie' ?>"></i>
                <p>No <?= $current_tab ?> opportunities found matching your criteria.</p>
                <a href="?tab=<?= $current_tab ?>" class="reset-btn">Reset filters</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require 'footer.php'; ?>

<script>
// Dynamic department dropdown loading based on university
document.getElementById('university').addEventListener('change', function() {
    const university = this.value;
    const departmentSelect = document.getElementById('department');
    const currentTab = "<?= $current_tab ?>";
    
    // Clear existing options except the first one
    departmentSelect.innerHTML = '<option value="">All Departments</option>';
    
    if (university) {
        // Show loading state
        departmentSelect.disabled = true;
        departmentSelect.innerHTML = '<option value="">Loading departments...</option>';
        
        // Fetch departments for selected university
        fetch(`get_departments.php?university=${encodeURIComponent(university)}&tab=${currentTab}`)
            .then(response => response.json())
            .then(departments => {
                departmentSelect.innerHTML = '<option value="">All Departments</option>';
                departments.forEach(dept => {
                    const option = document.createElement('option');
                    option.value = dept;
                    option.textContent = dept;
                    departmentSelect.appendChild(option);
                });
                departmentSelect.disabled = false;
            })
            .catch(error => {
                departmentSelect.innerHTML = '<option value="">Error loading departments</option>';
                console.error('Error:', error);
            });
    }
});

// Submit form when department is selected to apply filters immediately
document.getElementById('department').addEventListener('change', function() {
    this.form.submit();
});
</script>
</body>
</html>
<?php $conn->close(); ?>