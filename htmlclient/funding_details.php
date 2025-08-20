<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Database connection
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$funding_id = $_GET['id'] ?? 0;

// Fetch funding opportunity details
$funding_sql = "SELECT * FROM fundings WHERE id = ?";
$stmt = $conn->prepare($funding_sql);
$stmt->bind_param('i', $funding_id);
$stmt->execute();
$funding = $stmt->get_result()->fetch_assoc();

// If this is a professor grant, fetch professor details
if ($funding && $funding['type'] === 'professor' && !empty($funding['professor_id'])) {
    $prof_sql = "SELECT * FROM professors WHERE id = ?";
    $prof_stmt = $conn->prepare($prof_sql);
    $prof_stmt->bind_param('i', $funding['professor_id']);
    $prof_stmt->execute();
    $professor = $prof_stmt->get_result()->fetch_assoc();
    
    // Fetch professor's research interests
    $interests_sql = "SELECT interest FROM professor_research_interests WHERE professor_id = ?";
    $interests_stmt = $conn->prepare($interests_sql);
    $interests_stmt->bind_param('i', $funding['professor_id']);
    $interests_stmt->execute();
    $interests_result = $interests_stmt->get_result();
    $research_interests = [];
    while ($row = $interests_result->fetch_assoc()) {
        $research_interests[] = $row['interest'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($funding['title'] ?? 'Funding Details') ?></title>
    <link rel="stylesheet" href="../CSS/scholarship.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Enhanced Funding Details Styles */
        .funding-details {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .funding-header {
            background: linear-gradient(135deg, #032b56 0%, #0d68c3ff 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        
        .funding-header h1 {
            margin: 0 0 15px 0;
            font-size: 2.2rem;
        }
        
        .professor-link {
            margin-bottom: 15px;
        }
        
        .professor-link a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.3s;
        }
        
        .professor-link a:hover {
            opacity: 0.9;
        }
        
        .funding-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 15px;
        }
        
        .funding-meta span {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            opacity: 0.9;
        }
        
        .funding-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        @media (max-width: 768px) {
            .funding-content {
                grid-template-columns: 1fr;
            }
        }
        
        .funding-description, .eligibility {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }
        
        .funding-description h2, .eligibility h2 {
            color: #032b56;
            margin-top: 0;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .funding-sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .funding-dates {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }
        
        .date-item {
            margin-bottom: 15px;
        }
        
        .date-label {
            font-weight: 600;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }
        
        .date-value {
            color: #333;
            font-size: 1.05rem;
        }
        
        .deadline .date-value {
            color: #d32f2f;
            font-weight: 600;
        }
        
        .action-buttons {
            margin-top: 30px;
            text-align: center;
        }
        
        .apply-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            background: #032b56;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background 0.3s, transform 0.2s;
        }
        
        .apply-btn:hover {
            background: #0658a8;
            transform: translateY(-2px);
        }
        
        .professor-details {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }
        
        .professor-details h3 {
            margin-top: 0;
            color: #032b56;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .professor-info {
            display: grid;
            grid-template-columns: 80px 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .professor-image img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f0f0f0;
        }
        
        .professor-name {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .professor-university {
            color: #555;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        
        .view-profile {
            display: inline-block;
            padding: 5px 10px;
            background: #f0f0f0;
            color: #032b56;
            border-radius: 4px;
            font-size: 0.85rem;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .view-profile:hover {
            background: #e0e0e0;
        }
        
        .research-interests {
            margin-top: 15px;
        }
        
        .interests-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }
        
        .interest-tag {
            background: #e0e0e0;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.85rem;
            color: #333;
        }
        
        .no-results {
            text-align: center;
            padding: 50px 20px;
        }
        
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #032b56;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .back-btn:hover {
            background: #0658a8;
        }
    </style>
</head>
<body>
<?php require 'header.php'; ?>

<section class="funding-details">
    <?php if ($funding): ?>
        <div class="funding-header">
            <h1><?= htmlspecialchars($funding['title']) ?></h1>
            
            <?php if ($funding['type'] === 'professor' && !empty($professor)): ?>
                <div class="professor-link">
                    <a href="professor_details.php?id=<?= $professor['id'] ?>">
                        <i class="fas fa-user-tie"></i> Professor: <?= htmlspecialchars($professor['name']) ?>
                    </a>
                </div>
            <?php endif; ?>
            
            <div class="funding-meta">
                <?php if (!empty($funding['university'])): ?>
                    <span><i class="fas fa-university"></i> <?= htmlspecialchars($funding['university']) ?></span>
                <?php endif; ?>
                
                <?php if (!empty($funding['department'])): ?>
                    <span><i class="fas fa-building"></i> <?= htmlspecialchars($funding['department']) ?></span>
                <?php endif; ?>
                
                <?php if (!empty($funding['createdAt'])): ?>
                    <span><i class="fas fa-calendar-plus"></i> Posted: <?= date('F j, Y', strtotime($funding['createdAt'])) ?></span>
                <?php endif; ?>
                
                <?php if (!empty($funding['updatedAt']) && $funding['updatedAt'] != $funding['createdAt']): ?>
                    <span><i class="fas fa-calendar-check"></i> Updated: <?= date('F j, Y', strtotime($funding['updatedAt'])) ?></span>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="funding-content">
            <div class="main-content">
                <div class="funding-description">
                    <h2>Opportunity Details</h2>
                    <p><?= nl2br(htmlspecialchars($funding['description'])) ?></p>
                </div>
                
                <?php if (!empty($funding['eligibilityCriteria'])): ?>
                    <div class="eligibility">
                        <h2>Eligibility Criteria</h2>
                        <p><?= nl2br(htmlspecialchars($funding['eligibilityCriteria'])) ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="funding-sidebar">
                <div class="funding-dates">
                    <h3>Important Dates</h3>
                    <div class="date-item">
                        <span class="date-label">Application Opens:</span>
                        <span class="date-value"><?= date('F j, Y', strtotime($funding['applyDate'])) ?></span>
                    </div>
                    <div class="date-item deadline">
                        <span class="date-label">Application Deadline:</span>
                        <span class="date-value"><?= date('F j, Y', strtotime($funding['applicationDeadline'])) ?></span>
                    </div>
                </div>
                
                <?php if ($funding['type'] === 'professor' && !empty($professor)): ?>
                    <div class="professor-details">
                        <h3>Professor Information</h3>
                        <div class="professor-info">
                            <div class="professor-image">
                                <img src="<?= !empty($professor['image']) ? htmlspecialchars($professor['image']) : '../images/default-professor.jpg' ?>" 
                                     alt="<?= htmlspecialchars($professor['name']) ?>">
                            </div>
                            <div>
                                <div class="professor-name"><?= htmlspecialchars($professor['name']) ?></div>
                                <div class="professor-university">
                                    <?= htmlspecialchars($professor['university_name']) ?>
                                    <?php if (!empty($professor['country'])): ?>
                                        <span>(<?= htmlspecialchars($professor['country']) ?>)</span>
                                    <?php endif; ?>
                                </div>
                                <a href="professor_details.php?id=<?= $professor['id'] ?>" class="view-profile">
                                    View Full Profile
                                </a>
                            </div>
                        </div>
                        
                        <?php if (!empty($research_interests)): ?>
                            <div class="research-interests">
                                <h4>Research Interests:</h4>
                                <div class="interests-list">
                                    <?php foreach ($research_interests as $interest): ?>
                                        <span class="interest-tag"><?= htmlspecialchars($interest) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <div class="action-buttons">
                    <a href="<?= htmlspecialchars($funding['link']) ?>" target="_blank" class="apply-btn">
                        <?= $funding['type'] === 'scholarship' ? '<i class="fas fa-paper-plane"></i> Apply Now' : '<i class="fas fa-file-signature"></i> Submit Proposal' ?>
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="no-results">
            <p>Funding opportunity not found.</p>
            <a href="opportunities.php" class="back-btn">Back to Opportunities</a>
        </div>
    <?php endif; ?>
</section>

<?php require 'footer.php'; ?>
</body>
</html>
<?php $conn->close(); ?>