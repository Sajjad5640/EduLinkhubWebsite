<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLinkHub - Transform Your Learning Journey</title>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
  <link rel="stylesheet" href="../CSS/style_home_index1.css">
       
</head>
<body>
<!-- Header -->
<header>
    <div class="top-bar">
        <div class="container top-bar-container">
            <div class="logo">
                <img src="../images/image1.png" alt="Logo">
            </div>
            <div class="nav">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="user-profile">
                        <i class="fas fa-user-circle"></i>
                        <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </div>
                <?php else: ?>
                    <div class="login-options">
                        <div class="login-box" onclick="toggleLoginOptions()">
                            <i class="fas fa-user"></i>
                            <span>Login</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </div>
                        
                        <div class="login-dropdown" id="loginDropdown">
                            <a href="login.php?type=user" class="login-option">
                                <i class="fas fa-user"></i>
                                Login as User
                            </a>
                            <a href="../admin/signin.php" class="login-option">
                                <i class="fas fa-user-shield"></i>
                                Login as Admin
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="menu-box" id="menuBox">
                    <i class="fas fa-bars"></i>
                    <a href="#">Menu</a>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Add this to your existing JavaScript
    function toggleLoginOptions() {
        document.querySelector('.login-options').classList.toggle('active');
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const loginOptions = document.querySelector('.login-options');
        if (!loginOptions.contains(event.target)) {
            loginOptions.classList.remove('active');
        }
    });
</script>

    <!-- Fullscreen Menu Overlay -->
    <div class="menu-overlay" id="menuOverlay">
        <span class="close-btn" id="closeBtn"><i class="fas fa-times"></i></span>

        <div class="menu-content">
            <!-- Left Vertical Nav -->
            <div class="menu-nav">
                <a href="#" data-section="home" class="menu-link active">Home</a>
                <a href="#" data-section="book" class="menu-link">Book</a>
                <a href="#" data-section="study-abroad" class="menu-link">Study Abroad</a>
                <a href="#" data-section="admission" class="menu-link">Admission</a>
                <a href="#" data-section="about-contact" class="menu-link">About & Contact</a>
            </div>

            <!-- Right Dynamic Content -->
            <div class="menu-main">
                <!-- Home -->
                <div id="home" class="menu-section active">
                    <h1>Welcome to EduLinkHub</h1>
                    <p>Discover the best resources for your academic journey.</p>
                </div>

                <!-- Book -->
                <div id="book" class="menu-section">
                    <h1>Book Resources</h1>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="menu-links">
                            <a href="books.php">All Books</a>
                            <a href="study-guides.php">Study Guides</a>
                            <a href="recommendations.php">Recommended Books</a>
                        </div>
                    <?php else: ?>
                        <div class="login-required">
                            <i class="fas fa-lock"></i>
                            <p>Please <a href="login.php">login</a> to access our book resources.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Study Abroad -->
                <div id="study-abroad" class="menu-section">
                    <h1>Study Abroad Options</h1>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="menu-links">
                            <a href="professors.php">Professors</a>
                            <a href="scholarships.php">Scholarship Opportunities</a>
                            <a href="application-process.php">Application Process</a>
                            <a href="testimonials.php">Student Testimonials</a>
                        </div>
                    <?php else: ?>
                        <div class="login-required">
                            <i class="fas fa-lock"></i>
                            <p>Please <a href="login.php">login</a> to view study abroad options.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Admission -->
                <div id="admission" class="menu-section">
                    <h1>Admission Process</h1>
                    <p>Comprehensive guidance for university admissions worldwide.</p>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="menu-links">
                            <a href="universities.php">Universities</a>
                            <a href="deadlines.php">Deadlines</a>
                            <a href="documentation.php">Documentation</a>
                        </div>
                    <?php else: ?>
                        <div class="login-required">
                            <i class="fas fa-lock"></i>
                            <p>Please <a href="login.php">login</a> to access admission resources.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- About & Contact -->
                <div id="about-contact" class="menu-section">
                    <h1>About Us & Contact</h1>
                    <p>We are dedicated to helping students achieve their academic goals.</p>
                    <div class="menu-links">
                        <a href="mailto:contact@edulinkhub.com">Email: contact@edulinkhub.com</a>
                        <a href="tel:+1234567890">Phone: +1 (234) 567-890</a>
                        <a href="team.php">Our Team</a>
                        <a href="faq.php">FAQ</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Quick Links -->
        <div class="quick-links">
            <a href="app.php">Download App</a>
            <a href="privacy.php">Privacy Policy</a>
            <a href="terms.php">Terms of Service</a>
            <a href="careers.php">Careers</a>
            <a href="feedback.php">Feedback</a>
        </div>
    </div>
</header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <div class="hero-badge animate__animated animate__fadeIn">
                    <i class="fas fa-bolt"></i>
                    <span >Most Powerful</span>
                </div>
                <h1 class="hero-title animate__animated animate__fadeInUp">
                    Transform Your <br>
                    <span class="gradient-text">Learning Journey</span>
                </h1>
                <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
                    Experience the most comprehensive education platform designed for modern learners.
                    Join thousands of students already transforming their careers.
                </p>
<div class="hero-stats animate__animated animate__fadeInUp animate__delay-1s">
    <?php
    // Database connection
    $conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Get counts from database
    $countryCount = 0;
    $scholarshipCount = 0;
    
    // Count distinct countries from professors table
    $countriesQuery = "SELECT COUNT(country) AS total FROM professors";
    $result = $conn->query($countriesQuery);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $countryCount = $row['total'];
    }
    
    // Count scholarships from fundings table
    $scholarshipsQuery = "SELECT COUNT(id) AS total FROM fundings";
    $result = $conn->query($scholarshipsQuery);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $scholarshipCount = $row['total'];
    }
    
    $conn->close();
    ?>
    
    <div class="stat-item">
        <h3 id="country-counter">0</h3>
        <p>Professors</p>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
        <h3 id="scholarship-counter">0</h3>
        <p>Scholarship Opportunities</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate counting for countries (slower - 3 seconds)
    animateCount('country-counter', <?php echo $countryCount; ?>, 3000);
    
    // Animate counting for scholarships (slower - 3 seconds)
    animateCount('scholarship-counter', <?php echo $scholarshipCount; ?>, 3000);
    
    function animateCount(elementId, target, duration) {
        const element = document.getElementById(elementId);
        const start = 0;
        const increment = target / (duration / 16); // 60fps
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                clearInterval(timer);
                current = target;
                element.textContent = Math.floor(target); // Removed the + sign
            } else {
                element.textContent = Math.floor(current);
            }
        }, 16);
    }
});
</script>

<style>
/* Add smooth transition for the counting effect */
.stat-item h3 {
    transition: all 0.3s ease;
}
</style>
                <div class="hero-cta animate__animated animate__fadeInUp animate__delay-2s">
                    <button class="btn-primary btn-large"><a href="login.php">Start Learning Today</a></button>
                    <a href="https://www.canva.com/design/DAGwHu9H0Jg/0xHpCawzJjuellEY-MwzkA/watch?utm_content=DAGwHu9H0Jg&utm_campaign=designshare&utm_medium=link2&utm_source=uniquelinks&utlId=hf1136c72f2" target="_blank">
                    <button class="btn-secondary">Watch Demo</button>
                    </a>
                </div>
            </div>
           <div class="hero-visual">
                <!-- Center Image -->
                <div class="hero-image">
                    <img src="https://img.freepik.com/free-vector/student-with-laptop-studying-online-course_74855-5293.jpg" alt="Students Learning">
                </div>

                <!-- Orbiting Cards -->
                <div class="floating-elements">
                    <div class="floating-card card-1">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Learn from Experts</span>
                    </div>
                    <div class="floating-card card-2">
                        <i class="fas fa-certificate"></i>
                        <span>Get Certified</span>
                    </div>
                    <div class="floating-card card-3">
                        <i class="fas fa-users"></i>
                        <span>Join Community</span>
                    </div>
                </div>
                </div>
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-header">
                <h2>Why Choose Edulinkhub?</h2>
                <p></p>
            </div>
            <div class="features-grid">
                <div class="feature-card animate__animated animate__fadeInUp">
                    <div class="feature-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3>Learning</h3>
                    <p>Access courses anytime, anywhere with our flexible online platform designed for modern learners.</p>
                </div>
                <div class="feature-card animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="feature-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>Professors</h3>
                    <p>Learn from industry professionals with years of experience in their respective fields.</p>
                </div>
                <div class="feature-card animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Flexible Schedule</h3>
                    <p>Study at your own pace with lifetime access to course materials and resources.</p>
                </div>
                <div class="feature-card animate__animated animate__fadeInUp">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Certification</h3>
                    <p>Earn recognized certificates upon course completion to boost your career prospects.</p>
                </div>
                <div class="feature-card animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="feature-icon">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <h3>Interactive Content</h3>
                    <p>Engage with multimedia content, quizzes, and hands-on projects for better learning.</p>
                </div>
                <div class="feature-card animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Community Support</h3>
                    <p>Connect with fellow learners and get support from our active community.</p>
                </div>
            </div>
        </div>
    </section>

<?php
// Database connection
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch professors with their research interests
$sql = "SELECT p.*, GROUP_CONCAT(pri.interest SEPARATOR ' • ') AS research_interests 
        FROM professors p
        LEFT JOIN professor_research_interests pri ON p.id = pri.professor_id
        GROUP BY p.id"; // Show 12 random professors
$result = $conn->query($sql);
$professors = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<section class="professors-showcase">
  <div class="section-header">
    <h2 class="section-title">Renowned International Professors</h2>
    <p class="section-subtitle">Meet our distinguished faculty members</p>
  </div>

  <div class="professors-carousel-container">
    <div class="professors-carousel-track" id="professorsCarousel">
      <?php if (!empty($professors)): ?>
        <?php foreach ($professors as $professor): ?>
          <div class="professor-card" data-professor-id="<?= $professor['id'] ?>">
            <div class="card-inner">
              <div class="card-front">
                <div class="professor-image">
                  <img src="<?= htmlspecialchars($professor['image'] ?: 'https://randomuser.me/api/portraits/lego/'.rand(1,9).'.jpg') ?>" 
                    alt="Portrait of <?= htmlspecialchars($professor['name']) ?>, professor at <?= htmlspecialchars($professor['university_name']) ?>, shown in a professional academic setting. The environment suggests a welcoming and knowledgeable atmosphere.">
                  <div class="country-flag" data-country="<?= strtolower(explode(' ', $professor['country'])[0]) ?>"></div>
                </div>
                <div class="professor-meta">
                  <h3 class="professor-name"><?= htmlspecialchars($professor['name']) ?></h3>
                  <p class="professor-university"><?= htmlspecialchars($professor['university_name']) ?></p>
                  <div class="expertise-tags">
                    <?php foreach (explode(' • ', $professor['research_interests']) as $interest): ?>
                      <span class="tag"><?= htmlspecialchars($interest) ?></span>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
              <div class="card-back">
                <div class="back-content">
                  <h3>About Professor</h3>
                  <div class="contact-info">
                    <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($professor['contact_email']) ?></p>
                    <p><i class="fas fa-phone"></i> <?= htmlspecialchars($professor['contact_phone']) ?></p>
                    <p><i class="fas fa-calendar-check"></i> <?= htmlspecialchars($professor['availability']) ?></p>
                  </div>
                  <a href="professor_details.php?id=<?= $professor['id'] ?>" class="profile-btn">
                    View Full Profile <i class="fas fa-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="no-professors">No professors found in database</div>
      <?php endif; ?>
    </div>
  </div>

  <div class="carousel-controls">
    <button class="control-btn prev-btn" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
    <button class="control-btn next-btn" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
  </div>

  <div class="see-all-container">
    <a href="login.php" class="see-all-btn">Browse All Professors</a>
  </div>
</section>

<style>
  /* Base Styles */
  .professors-showcase {
    padding: 4rem 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    position: relative;
    overflow: hidden;
  }

  .section-header {
    text-align: center;
    margin-bottom: 3rem;
  }

  .section-title {
    font-size: 2.5rem;
    color: #2b2d42;
    margin-bottom: 0.5rem;
    position: relative;
    display: inline-block;
  }

  .section-title:after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: #ef233c;
    border-radius: 2px;
  }

  .section-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
    max-width: 700px;
    margin: 0 auto;
  }

  /* Carousel Container */
  .professors-carousel-container {
    position: relative;
    padding: 1rem 0;
    margin: 0 auto;
    max-width: 1400px;
  }

  .professors-carousel-track {
    display: flex;
    gap: 1.5rem;
    padding: 1rem;
    overflow-x: auto;
    scroll-behavior: smooth;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
  }

  .professors-carousel-track::-webkit-scrollbar {
    display: none;
  }

  /* Professor Card */
  .professor-card {
    flex: 0 0 320px;
    scroll-snap-align: start;
    perspective: 1000px;
    height: 420px;
  }

  .card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform 0.8s;
    transform-style: preserve-3d;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  }

  .professor-card:hover .card-inner {
    transform: rotateY(180deg);
  }

  .card-front, .card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    border-radius: 15px;
    overflow: hidden;
  }

  .card-front {
    background: white;
    display: flex;
    flex-direction: column;
  }

  .card-back {
    background: linear-gradient(135deg, #2b2d42 0%, #1a1a2e 100%);
    color: white;
    transform: rotateY(180deg);
    padding: 1.5rem;
  }

  /* Front Card Styles */
  .professor-image {
    position: relative;
    height: 200px;
    overflow: hidden;
  }

  .professor-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
  }

  .professor-card:hover .professor-image img {
    transform: scale(1.05);
  }

  .country-flag {
    position: absolute;
    bottom: -10px;
    right: 20px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 3px solid white;
    background-size: cover;
    background-position: center;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
  }

  .country-flag[data-country="usa"] { background-image: url('https://flagcdn.com/w40/us.png'); }
  .country-flag[data-country="uk"] { background-image: url('https://flagcdn.com/w40/gb.png'); }
  .country-flag[data-country="canada"] { background-image: url('https://flagcdn.com/w40/ca.png'); }
  /* Add more country flags as needed */

  .professor-meta {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .professor-name {
    font-size: 1.4rem;
    margin-bottom: 0.5rem;
    color: #2b2d42;
  }

  .professor-university {
    color: #ef233c;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 0.95rem;
  }

  .expertise-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: auto;
  }

  .tag {
    background: #edf2f4;
    color: #2b2d42;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
  }

  /* Back Card Styles */
  .back-content {
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .back-content h3 {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    position: relative;
    padding-bottom: 0.5rem;
  }

  .back-content h3:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: #ef233c;
  }

  .contact-info {
    margin-bottom: 1.5rem;
  }

  .contact-info p {
    margin-bottom: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    font-size: 0.95rem;
    color: white;
  }

  .contact-info i {
    color: #ef233c;
    width: 20px;
    text-align: center;
  }

  .profile-btn {
    margin-top: auto;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.8rem 1.5rem;
    background: #ef233c;
    color: white;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
  }

  .profile-btn:hover {
    background: #d90429;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(239, 35, 60, 0.4);
  }

  /* Controls */
  .carousel-controls {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 2rem;
  }

  .control-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: white;
    border: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    cursor: pointer;
    color: #2b2d42;
    font-size: 1.2rem;
    transition: all 0.3s;
  }

  .control-btn:hover {
    background: #2b2d42;
    color: white;
    transform: translateY(-3px);
  }

  .see-all-container {
    text-align: center;
    margin-top: 3rem;
  }

  .see-all-btn {
    display: inline-block;
    padding: 0.8rem 2rem;
    background: transparent;
    color: #2b2d42;
    border: 2px solid #2b2d42;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
  }

  .see-all-btn:hover {
    background: #2b2d42;
    color: white;
    transform: translateY(-3px);
  }

  /* Responsive */
  @media (max-width: 768px) {
    .professor-card {
      flex: 0 0 280px;
      height: 380px;
    }
    
    .professor-image {
      height: 160px;
    }
    
    .section-title {
      font-size: 2rem;
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const carousel = document.getElementById('professorsCarousel');
  const prevBtn = document.querySelector('.prev-btn');
  const nextBtn = document.querySelector('.next-btn');
  const professorCards = document.querySelectorAll('.professor-card');
  
  // Auto-scroll functionality
  let autoScrollInterval;
  const startAutoScroll = () => {
    autoScrollInterval = setInterval(() => {
      carousel.scrollBy({ left: 330, behavior: 'smooth' });
      
      // Reset to start if near end
      if (carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth - 100) {
        setTimeout(() => {
          carousel.scrollTo({ left: 0, behavior: 'smooth' });
        }, 1000);
      }
    }, 3000); // Scroll every 3 seconds
  };
  
  // Pause auto-scroll on hover
  carousel.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
  carousel.addEventListener('mouseleave', startAutoScroll);
  
  // Manual controls
  prevBtn.addEventListener('click', () => {
    carousel.scrollBy({ left: -330, behavior: 'smooth' });
    clearInterval(autoScrollInterval);
    setTimeout(startAutoScroll, 10000); // Resume after 10 seconds
  });
  
  nextBtn.addEventListener('click', () => {
    carousel.scrollBy({ left: 330, behavior: 'smooth' });
    clearInterval(autoScrollInterval);
    setTimeout(startAutoScroll, 5000); // Resume after 10 seconds
  });
  
  // Start auto-scroll
  startAutoScroll();
  
  // Add click effect to cards
  professorCards.forEach(card => {
    card.addEventListener('click', function(e) {
      if (!e.target.closest('.profile-btn')) {
        this.querySelector('.card-inner').style.transform = 'rotateY(180deg)';
      }
    });
  });
});
</script>
<!--News-->
<section>
 <div class="container">
    <div class="section-header">
        <h2>Latest News</h2>
    </div>

    <div class="news-grid">
        <!-- Card 1 -->
        <div class="news-card">
            <img src="https://admissionindia.net/blog/wp-content/uploads/2025/06/College-Application-Process-1024x576-1.webp" alt="News">
            <div class="news-meta">
                <span>LEARNING</span>
                <span class="dot"></span>
                <span>OCTOBER 23, 2024</span>
            </div>
            <div class="news-title">How to Avoid the Biggest College Admission Mistakes</div>
            <a href="#" class="read-more">READ MORE</a>
        </div>

        <!-- Card 2 -->
        <div class="news-card">
            <img src="https://webflow-amber-prod.gumlet.io/620e4101b2ce12a1a6bff0e8/651ea1c1de34c0f689051144_pexels-gerzon-pi%C3%B1ata-9512007.jpg" alt="News">
            <div class="news-meta">
                <span>LEARNING</span>
                <span class="dot"></span>
                <span>OCTOBER 23, 2024</span>
            </div>
            <div class="news-title">How Digital Platforms Are Shaping Business Schools</div>
            <a href="#" class="read-more">READ MORE</a>
        </div>

        <!-- Card 3 -->
        <div class="news-card">
            <img src="https://www.theroom.com/wp-content/uploads/2022/10/Tech-That-Will-Make-Running-Your-Business-A-Breeze.jpeg" alt="News">
            <div class="news-meta">
                <span>LEARNING</span>
                <span class="dot"></span>
                <span>OCTOBER 23, 2024</span>
            </div>
            <div class="news-title">Why Business Students Need Tech Skills for the Future</div>
            <a href="#" class="read-more">READ MORE</a>
        </div>
    </div>
</div>
</section>


    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2 class="animate__animated animate__fadeInLeft">Empowering Learners Worldwide</h2>
                    <p class="animate__animated animate__fadeInLeft animate__delay-1s">At EduLinkHub, we believe that quality education should be accessible to everyone. Our platform combines cutting-edge technology with expert instruction to deliver an unparalleled learning experience.</p>

                    <div class="about-stats animate__animated animate__fadeInUp animate__delay-2s">
    <?php
    // Database connection
    $conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Get counts from database
    $studentCount = 0;
    $instructorCount = 0;
    $fundingCount = 0;
    
    // Count students from users table
    $studentsQuery = "SELECT COUNT(id) AS total FROM users";
    $result = $conn->query($studentsQuery);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $studentCount = $row['total'];
    }
    
    // Count instructors from professors table
    $instructorsQuery = "SELECT COUNT(id) AS total FROM professors";
    $result = $conn->query($instructorsQuery);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $instructorCount = $row['total'];
    }
    
    // Count fundings from fundings table
    $fundingsQuery = "SELECT COUNT(id) AS total FROM fundings";
    $result = $conn->query($fundingsQuery);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fundingCount = $row['total'];
    }
    
    $conn->close();
    ?>
    
    <div class="about-stat">
        <h3 class="counter" data-target="<?php echo $studentCount; ?>">0</h3>
        <p>Active Students</p>
    </div>
    <div class="about-stat">
        <h3 class="counter" data-target="<?php echo $instructorCount; ?>">0</h3>
        <p>Professors</p>
    </div>
    <div class="about-stat">
        <h3 class="counter" data-target="<?php echo $fundingCount; ?>">0</h3>
        <p>Funding Opportunities</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all counter elements
    const counters = document.querySelectorAll('.counter');
    const duration = 4000; // 4 seconds for slower counting
    const frameRate = 30; // frames per second
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const start = 0;
        const increment = target / (duration / (1000 / frameRate));
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                clearInterval(timer);
                current = target;
                counter.textContent = target.toLocaleString(); // Format number
            } else {
                counter.textContent = Math.floor(current).toLocaleString();
            }
        }, 1000 / frameRate);
    });
});
</script>
                </div>
                <div class="about-visual animate__animated animate__fadeInRight animate__delay-1s">
                    <div class="about-image">
                        <video autoplay muted loop playsinline>
                            <source src="../images/Video.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>What Our Students Say</h2>
                <p>Real stories from real students who transformed their careers</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card animate__animated animate__fadeInLeft">
                    <div class="testimonial-content">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p>"EduLinkHub completely changed my career trajectory. The courses are well-structured and the instructors are amazing!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="../images/admission.jpg" alt="Sarah Johnson">
                        </div>
                        <div class="author-info">
                            <h4>Sarah Johnson</h4>
                            <p>Software Developer</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card animate__animated animate__fadeInUp">
                    <div class="testimonial-content">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p>"The flexibility of online learning allowed me to study while working full-time. Highly recommend!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=60&h=60&fit=crop&crop=face" alt="Michael Chen">
                        </div>
                        <div class="author-info">
                            <h4>Michael Chen</h4>
                            <p>Data Analyst</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card animate__animated animate__fadeInRight">
                    <div class="testimonial-content">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p>"Excellent platform with top-notch content. The community support is incredible!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=60&h=60&fit=crop&crop=face" alt="Emily Rodriguez">
                        </div>
                        <div class="author-info">
                            <h4>Emily Rodriguez</h4>
                            <p>Marketing Manager</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info animate__animated animate__fadeInLeft">
                    <h2>Get In Touch</h2>
                    <p>Ready to start your learning journey? Contact us today and let's discuss how we can help you achieve your goals.</p>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>hello@edulinkhub.com</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>+1 (555) 123-4567</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 Education St, Learning City, LC 12345</span>
                        </div>
                    </div>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="contact-form animate__animated animate__fadeInRight">
                    <form>
                        <div class="form-group">
                            <input type="text" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Subject" required>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Your Message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn-primary btn-full">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
<section class="subscription-section">
    <div class="student-img">
        <img src="https://www.vhv.rs/dpng/d/436-4364483_student-school-cartoon-cartoon-girl-student-hd-png.png" alt="Student 1">
    </div>
    <div class="content">
        <h2>A subscription that's<br>more than just classes</h2>
        <a href="payment.php" class="btn">Get Subscription</a>
    </div>
    <div class="student-img right">
        <img src="https://static.vecteezy.com/system/resources/thumbnails/031/610/037/small_2x/a-of-a-3d-cartoon-little-boy-in-class-world-students-day-images-ai-generative-photo.jpg" alt="Student 2">
    </div>
</section>

<section>
    <div class="section-header">
        <h2><span>Premium</span> Widget</h2>
    </div>

    <div class="widgets-container">
        <div class="widget"><i class="fas fa-book-open"></i> Course Library</div>
        <div class="widget"><i class="fas fa-video"></i> Live Classes</div>
        <div class="widget"><i class="fas fa-chalkboard-teacher"></i> Expert Instructors</div>
        <div class="widget"><i class="fas fa-laptop-code"></i> Coding Practice</div>
        <div class="widget"><i class="fas fa-language"></i> Language Learning</div>
        <div class="widget"><i class="fas fa-shield-alt"></i> Cyber Security Courses</div>
        <div class="widget"><i class="fas fa-users"></i> Student Community</div>
        <div class="widget"><i class="fas fa-certificate"></i> Certificates</div>
        <div class="widget"><i class="fas fa-graduation-cap"></i> Career Guidance</div>
        <div class="widget"><i class="fas fa-lightbulb"></i> Skill Assessments</div>
        <div class="widget"><i class="fas fa-tasks"></i> Quizzes & Assignments</div>
        <div class="widget"><i class="fas fa-headset"></i> 24/7 Support</div>
        <div class="widget"><i class="fas fa-search"></i> Course Search</div>
        <div class="widget"><i class="fas fa-chart-line"></i> Progress Tracking</div>
        <div class="widget"><i class="fas fa-comments"></i> Discussion Forums</div>
        <div class="widget"><i class="fas fa-mobile-alt"></i> Mobile Learning</div>
        <div class="widget"><i class="fas fa-book"></i> E-Books</div>
        <div class="widget"><i class="fas fa-podcast"></i> Podcasts & Webinars</div>
    </div>
</section>


        <?php require 'footer.php'; ?>
        <script >const menuBox = document.getElementById('menuBox');
  const menuOverlay = document.getElementById('menuOverlay');
  const closeBtn = document.getElementById('closeBtn');
  const menuLinks = document.querySelectorAll('.menu-link');
  const sections = document.querySelectorAll('.menu-section');

  // Toggle menu
  menuBox.addEventListener('click', () => {
    menuOverlay.classList.add('active');
  });

  closeBtn.addEventListener('click', () => {
    menuOverlay.classList.remove('active');
  });

  // Submenu switching
  menuLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();

      // Remove previous active
      menuLinks.forEach(l => l.classList.remove('active'));
      sections.forEach(s => s.classList.remove('active'));

      // Add new active
      const sectionId = link.getAttribute('data-section');
      document.getElementById(sectionId).classList.add('active');
      link.classList.add('active');
    });
  });
  </script>

    <script>
        

        // Counter Animation
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.counter');
            const speed = 200; 

            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = target / speed;

                const updateCount = () => {
                    const currentCount = +counter.innerText;
                    
                    if (currentCount < target) {
                        counter.innerText = Math.ceil(currentCount + increment);
                        setTimeout(updateCount, 10); 
                    } else {
                        counter.innerText = target;
                    }
                };

                updateCount();
            });
        });

        // Scroll Animations
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate__animated');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const animation = entry.target.getAttribute('class').split('animate__')[1].split(' ')[0];
                        entry.target.classList.add('animate__' + animation);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            animateElements.forEach(element => {
                observer.observe(element);
            });
        });
    </script>
</body>
</html>