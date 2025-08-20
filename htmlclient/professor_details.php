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

$professor_id = $_GET['id'] ?? 0;

// Fetch professor details
$prof_sql = "SELECT * FROM professors WHERE id = ?";
$stmt = $conn->prepare($prof_sql);
$stmt->bind_param('i', $professor_id);
$stmt->execute();
$professor = $stmt->get_result()->fetch_assoc();

// Fetch research interests
$interests_sql = "SELECT interest FROM professor_research_interests WHERE professor_id = ?";
$interests_stmt = $conn->prepare($interests_sql);
$interests_stmt->bind_param('i', $professor_id);
$interests_stmt->execute();
$interests_result = $interests_stmt->get_result();
$research_interests = [];
while ($row = $interests_result->fetch_assoc()) {
    $research_interests[] = $row['interest'];
}

// Fetch funding opportunities associated with this professor
$fundings_sql = "SELECT * FROM fundings WHERE professor_id = ? ORDER BY applicationDeadline ASC";
$fundings_stmt = $conn->prepare($fundings_sql);
$fundings_stmt->bind_param('i', $professor_id);
$fundings_stmt->execute();
$fundings = $fundings_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($professor['name'] ?? 'Professor Details') ?></title>
    <link rel="stylesheet" href="../CSS/scholarship.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Professor Details Styles */
        .professor-details {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .professor-header {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
            align-items: center;
        }
        
        .professor-image img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #f0f0f0;
        }
        
        .professor-info {
            flex: 1;
        }
        
        .professor-info h1 {
            color: #032b56;
            margin-bottom: 10px;
        }
        
        .university {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 15px;
        }
        
        .department {
            color: #777;
        }
        
        .profile-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .profile-section h2 {
            color: #032b56;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .info-item {
            margin-bottom: 15px;
        }
        
        .info-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }
        
        .info-value {
            color: #333;
        }
        
        .availability-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 600;
            margin-top: 5px;
        }
        
        .available {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        .not-available {
            background: #ffebee;
            color: #c62828;
        }
        
        .contact-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #555;
        }
        
        .contact-item i {
            color: #032b56;
        }
        
        .funding-opportunities {
            margin-top: 40px;
        }
        
        .fundings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .funding-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .funding-card:hover {
            transform: translateY(-5px);
        }
        
        .funding-card h3 {
            margin-bottom: 10px;
            color: #032b56;
        }
        
        .funding-card .deadline {
            color: #666;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }
        
        .details-btn {
            display: inline-block;
            padding: 8px 15px;
            background: #032b56;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background 0.3s;
        }
        
        .details-btn:hover {
            background: #021a36;
        }
        
        .interests-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 5px;
        }
        
        .interest-tag {
            background: #e0e0e0;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            color: #333;
        }
        
        @media (max-width: 768px) {
            .professor-header {
                flex-direction: column;
                text-align: center;
            }
            
            .professor-image img {
                width: 150px;
                height: 150px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<?php require 'header.php'; ?>

<section class="professor-details">
    <?php if ($professor): ?>
        <div class="professor-header">
            <div class="professor-image">
                <img src="<?= !empty($professor['image']) ? htmlspecialchars($professor['image']) : '../images/default-professor.jpg' ?>" 
                     alt="<?= htmlspecialchars($professor['name']) ?>">
            </div>
            <div class="professor-info">
                <h1><?= htmlspecialchars($professor['name']) ?></h1>
                <p class="university">
                    <i class="fas fa-university"></i> <?= htmlspecialchars($professor['university_name']) ?>
                    <?php if (!empty($professor['department'])): ?>
                        <span class="department">(<?= htmlspecialchars($professor['department']) ?>)</span>
                    <?php endif; ?>
                </p>
                
                <div class="availability-badge <?= $professor['availability'] === 'available' ? 'available' : 'not-available' ?>">
                    <?= ucfirst($professor['availability']) ?>
                </div>
                
                <div class="contact-info">
                    <?php if (!empty($professor['contact_email'])): ?>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span><?= htmlspecialchars($professor['contact_email']) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($professor['contact_phone'])): ?>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span><?= htmlspecialchars($professor['contact_phone']) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($professor['country'])): ?>
                        <div class="contact-item">
                            <i class="fas fa-globe"></i>
                            <span><?= htmlspecialchars($professor['country']) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($professor['profileLink'])): ?>
                        <div class="contact-item">
                            <i class="fas fa-link"></i>
                            <a href="<?= htmlspecialchars($professor['profileLink']) ?>" target="_blank">View University Profile</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="profile-section">
            <h2>Professional Information</h2>
            <div class="info-grid">
                <?php if (!empty($research_interests)): ?>
                    <div class="info-item">
                        <div class="info-label">Research Interests</div>
                        <div class="info-value">
                            <div class="interests-list">
                                <?php foreach ($research_interests as $interest): ?>
                                    <span class="interest-tag"><?= htmlspecialchars($interest) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($professor['bio'])): ?>
                    <div class="info-item">
                        <div class="info-label">Biography</div>
                        <div class="info-value"><?= nl2br(htmlspecialchars($professor['bio'])) ?></div>
                    </div>
                <?php endif; ?>
                
                <div class="info-item">
                    <div class="info-label">Member Since</div>
                    <div class="info-value"><?= date('F j, Y', strtotime($professor['createdAt'])) ?></div>
                </div>
                
                <?php if (!empty($professor['updatedAt']) && $professor['updatedAt'] != $professor['createdAt']): ?>
                    <div class="info-item">
                        <div class="info-label">Last Updated</div>
                        <div class="info-value"><?= date('F j, Y', strtotime($professor['updatedAt'])) ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if ($fundings->num_rows > 0): ?>
            <div class="profile-section funding-opportunities">
                <h2>Current Funding Opportunities</h2>
                <div class="fundings-grid">
                    <?php while ($funding = $fundings->fetch_assoc()): ?>
                        <div class="funding-card">
                            <h3><?= htmlspecialchars($funding['title']) ?></h3>
                            <?php if (!empty($funding['university'])): ?>
                                <p><i class="fas fa-university"></i> <?= htmlspecialchars($funding['university']) ?></p>
                            <?php endif; ?>
                            <p class="deadline">
                                <i class="fas fa-clock"></i> Deadline: <?= date('F j, Y', strtotime($funding['applicationDeadline'])) ?>
                            </p>
                            <a href="funding_details.php?id=<?= $funding['id'] ?>" class="details-btn">
                                View Details
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="profile-section">
            <h2>Contact Professor</h2>
            <p>For more information about research opportunities or collaborations, please contact the professor directly.</p>
            
            <div class="contact-info">
                <?php if (!empty($professor['contact_email'])): ?>
                    <a href="mailto:<?= htmlspecialchars($professor['contact_email']) ?>" class="details-btn">
                        <i class="fas fa-envelope"></i> Send Email
                    </a>
                <?php endif; ?>
                
                <?php if (!empty($professor['profileLink'])): ?>
                    <a href="<?= htmlspecialchars($professor['profileLink']) ?>" target="_blank" class="details-btn">
                        <i class="fas fa-external-link-alt"></i> University Profile
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="no-results">
            <p>Professor not found.</p>
            <a href="scholarship.php" class="back-btn">Back to Opportunities</a>
        </div>
    <?php endif; ?>
</section>

<?php require 'footer.php'; ?>
</body>
</html>
<?php $conn->close(); ?>