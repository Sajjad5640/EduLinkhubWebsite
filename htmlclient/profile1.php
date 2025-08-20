<?php
session_start();

 $conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");
// Initialize variables with default values
$userData = [
    'name' => 'Guest',
    'email' => '',
    'profilePicture' => '../images/default-profile.jpg',
    'gender' => '',
    'qualification' => '',
    'institute' => '',
    'address' => '',
    'phoneNumber' => '',
    'country' => 'Bangladesh',
    'interests' => 'AI, Software Engineering, Scholarships'
];

// Fetch user data if logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    $query = "SELECT name, email, profilePicture, gender, qualification, institute, address, phoneNumber 
              FROM users 
              WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $userData = array_merge($userData, $result->fetch_assoc());
        
        // Handle profile picture path
        if (!empty($userData['profilePicture'])) {
            $imagePath = '../uploads/' . basename($userData['profilePicture']);
            if (file_exists($imagePath)) {
                $userData['profilePicture'] = $imagePath;
            }
        }
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | EdulinkHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --dark: #2b2d42;
            --light: #f8f9fa;
            --danger: #ef233c;
            --success: #4cc9f0;
            --border-radius: 12px;
            --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f5f7ff;
            color: var(--dark);
            line-height: 1.6;
        }

        /* Floating Back Button */
        .floating-back {
            position: fixed;
            top: 25px;
            left: 25px;
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--box-shadow);
            z-index: 1000;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            color: var(--primary);
        }

        .floating-back:hover {
            transform: translateX(-5px);
            color: var(--secondary);
        }

        /* Profile Container */
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Profile Card */
        .profile-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            position: sticky;
            top: 30px;
            height: fit-content;
            transition: var(--transition);
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }

        .profile-pic-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid #f0f2ff;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .profile-pic {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .profile-pic-container:hover .profile-pic {
            transform: scale(1.05);
        }

        .profile-name {
            text-align: center;
            font-size: 24px;
            margin-bottom: 5px;
            color: var(--dark);
        }

        .profile-title {
            text-align: center;
            color: var(--accent);
            font-weight: 500;
            margin-bottom: 25px;
        }

        .profile-details {
            margin-bottom: 25px;
        }

        .detail-item {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        .detail-icon {
            margin-right: 12px;
            color: var(--accent);
            font-size: 18px;
            margin-top: 2px;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-weight: 600;
            color: var(--dark);
            display: block;
            margin-bottom: 3px;
        }

        .detail-value {
            color: #666;
        }

        .profile-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .action-btn {
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .action-btn i {
            font-size: 16px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: rgba(67, 97, 238, 0.1);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #d90429;
        }

        /* Content Section */
        .content-section {
            display: grid;
            gap: 25px;
        }

        .section-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            animation: slideUp 0.5s ease-out;
        }

        .section-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f2ff;
        }

        .section-title {
            font-size: 20px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--accent);
        }

        .item-list {
            list-style: none;
        }

        .list-item {
            padding: 15px 0;
            border-bottom: 1px solid #f0f2ff;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: var(--transition);
        }

        .list-item:last-child {
            border-bottom: none;
        }

        .item-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(67, 97, 238, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            flex-shrink: 0;
        }

        .item-content {
            flex: 1;
        }

        .item-title {
            font-weight: 600;
            margin-bottom: 3px;
        }

        .item-meta {
            font-size: 14px;
            color: #888;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: var(--success);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .profile-container {
                grid-template-columns: 1fr;
            }
            
            .profile-card {
                position: static;
            }
            
            .floating-back {
                top: 15px;
                left: 15px;
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 576px) {
            .profile-container {
                padding: 15px;
            }
            
            .profile-card, .section-card {
                padding: 20px;
            }
            
            .list-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        /* Animation Classes */
        .animate-delay-1 {
            animation-delay: 0.1s;
        }
        
        .animate-delay-2 {
            animation-delay: 0.2s;
        }
        
        .animate-delay-3 {
            animation-delay: 0.3s;
        }
    </style>
</head>
<body>
    <button class="floating-back" aria-label="Go back">
        <i class="fas fa-arrow-left"></i>
    </button>

    <div class="profile-container">
        <!-- Profile Card -->
        <aside class="profile-card">
            <div class="profile-pic-container">
                <img src="<?php echo htmlspecialchars($userData['profilePicture']); ?>" 
                     alt="Profile Picture" 
                     class="profile-pic"
                     onerror="this.src='../images/default-profile.jpg'">
            </div>
            
            <h1 class="profile-name"><?php echo htmlspecialchars($userData['name']); ?></h1>
            <p class="profile-title">Web Developer</p>
            
            <div class="profile-details">
                <div class="detail-item">
                    <i class="fas fa-envelope detail-icon"></i>
                    <div class="detail-content">
                        <span class="detail-label">Email</span>
                        <span class="detail-value"><?php echo htmlspecialchars($userData['email']); ?></span>
                    </div>
                </div>
                
                <?php if (!empty($userData['gender'])): ?>
                <div class="detail-item">
                    <i class="fas fa-venus-mars detail-icon"></i>
                    <div class="detail-content">
                        <span class="detail-label">Gender</span>
                        <span class="detail-value"><?php echo htmlspecialchars($userData['gender']); ?></span>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="detail-item">
                    <i class="fas fa-map-marker-alt detail-icon"></i>
                    <div class="detail-content">
                        <span class="detail-label">Location</span>
                        <span class="detail-value"><?php echo htmlspecialchars($userData['country']); ?></span>
                    </div>
                </div>
                
                <?php if (!empty($userData['qualification'])): ?>
                <div class="detail-item">
                    <i class="fas fa-graduation-cap detail-icon"></i>
                    <div class="detail-content">
                        <span class="detail-label">Qualification</span>
                        <span class="detail-value"><?php echo htmlspecialchars($userData['qualification']); ?></span>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($userData['phoneNumber'])): ?>
                <div class="detail-item">
                    <i class="fas fa-phone detail-icon"></i>
                    <div class="detail-content">
                        <span class="detail-label">Phone</span>
                        <span class="detail-value"><?php echo htmlspecialchars($userData['phoneNumber']); ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="profile-actions">
                <button class="action-btn btn-primary">
                    <i class="fas fa-pencil-alt"></i> Edit Profile
                </button>
               
                <button class="action-btn btn-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="content-section">
            <!-- Saved Scholarships -->
            <section class="section-card animate-delay-1">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-bookmark"></i> Saved Scholarships</h2>
                    <span class="badge">3 items</span>
                </div>
                
                <ul class="item-list">
                    <li class="list-item">
                        <div class="item-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="item-content">
                            <h3 class="item-title">Chevening Scholarship</h3>
                            <p class="item-meta">UK Government | Deadline: 15 Nov 2023</p>
                        </div>
                    </li>
                    
                    <li class="list-item">
                        <div class="item-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="item-content">
                            <h3 class="item-title">Fulbright Foreign Student Program</h3>
                            <p class="item-meta">USA | Deadline: 1 Feb 2024</p>
                        </div>
                    </li>
                    
                    <li class="list-item">
                        <div class="item-icon">
                            <i class="fas fa-globe-europe"></i>
                        </div>
                        <div class="item-content">
                            <h3 class="item-title">Erasmus Mundus Joint Masters</h3>
                            <p class="item-meta">European Union | Deadline: 31 Jan 2024</p>
                        </div>
                    </li>
                </ul>
            </section>

            <!-- Recent Activity -->
            <section class="section-card animate-delay-2">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-bolt"></i> Recent Activity</h2>
                    <span class="badge">New</span>
                </div>
                
                <ul class="item-list">
                    <li class="list-item">
                        <div class="item-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="item-content">
                            <h3 class="item-title">Enrolled in "AI for Beginners"</h3>
                            <p class="item-meta">2 hours ago | Course</p>
                        </div>
                    </li>
                    
                    <li class="list-item">
                        <div class="item-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="item-content">
                            <h3 class="item-title">Contacted Prof. Emma Wilson</h3>
                            <p class="item-meta">1 day ago | Message</p>
                        </div>
                    </li>
                    
                    <li class="list-item">
                        <div class="item-icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <div class="item-content">
                            <h3 class="item-title">Downloaded Web Dev Book Pack</h3>
                            <p class="item-meta">3 days ago | Resource</p>
                        </div>
                    </li>
                </ul>
            </section>

            <!-- Contact Information -->
            <?php if (!empty($userData['address'])): ?>
            <section class="section-card animate-delay-3">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-address-card"></i> Contact Information</h2>
                </div>
                
                <div class="detail-item">
                    <i class="fas fa-home detail-icon"></i>
                    <div class="detail-content">
                        <span class="detail-label">Address</span>
                        <span class="detail-value"><?php echo htmlspecialchars($userData['address']); ?></span>
                    </div>
                </div>
            </section>
            <?php endif; ?>
        </main>
    </div>

    <script>
        // Back button functionality
        document.querySelector('.floating-back').addEventListener('click', function() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '../htmlclient/index1.php';
            }
        });

        // Logout button functionality
        document.querySelector('.btn-danger').addEventListener('click', function() {
            window.location.href = '../htmlclient/login.php';
        });

        // Settings button functionality
        document.querySelector('.btn-primary').addEventListener('click', function() {
            window.location.href = '../htmlclient/settings1.php';
        });

        // Animation on scroll
        const animateOnScroll = () => {
            const cards = document.querySelectorAll('.section-card');
            cards.forEach(card => {
                const cardPosition = card.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (cardPosition < screenPosition) {
                    card.style.animationPlayState = 'running';
                }
            });
        };

        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll(); // Run once on load
    </script>
</body>
</html>