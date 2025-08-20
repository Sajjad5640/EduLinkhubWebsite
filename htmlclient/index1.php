<?php

if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) {
    echo "
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          title: 'Login Successful!',
          text: 'Welcome back, " . $_SESSION['full_name'] . " 🎉',
          icon: 'success',
          confirmButtonText: 'Continue',
          showClass: {
            popup: 'animate__animated animate__fadeInDown'
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
          }
        });
      });
    </script>
    ";
    unset($_SESSION['login_success']); // Remove so it only shows once
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EduLinkHub</title>

   <link rel="icon" href="../images/logo.png" type="image/png">
  <link rel="stylesheet" href="style.css" />
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
</head>

<body>
 <?php require 'header.php'; ?>

    <section class="hero">
        <?php
        // Database connection
        $conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
       // Function to get count from a table
function getCount($conn, $table) {
    $sql = "SELECT COUNT(*) as count FROM $table";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    }
    return 0;
}

// Get counts from different tables
$userCount = getCount($conn, "users");
$professorCount = getCount($conn, "professors");
$scholarshipCount = getCount($conn, "fundings");
$bookCount = getCount($conn, "books");
        $conn->close();
        ?>

        <div class="hero-container">
            <!-- Floating education-themed vector elements -->
<div class="floating-vector atom"></div>
<div class="floating-vector book"></div>
<div class="floating-vector calculator"></div>
<div class="floating-vector brain"></div>
<div class="floating-vector pencil"></div>
            
            <div class="hero-content">
                <h1 data-aos="fade-down">Transform Your Learning Journey</h1>
                <p data-aos="fade-down" data-aos-delay="150">Where Bangladeshi students meet expert guidance and premium resources</p>
                
           <div class="hero-cta" data-aos="fade-up" data-aos-delay="300">
                    
                </div>     
                
               <div class="stats-grid" data-aos="fade-up" data-aos-delay="450">
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="stat-card-front">
                <div class="stat-icon-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 4a4 4 0 014 4 4 4 0 01-4 4 4 4 0 01-4-4 4 4 0 014-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4z"/>
                    </svg>
                </div>
                <div class="stat-number" data-count="<?= $userCount ?>">0</div>
                <div class="stat-label">Bright Minds</div>
            </div>
            <div class="stat-card-back">
                <p>Join our community of passionate learners and innovators</p>
                <div class="stat-icon-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 4a4 4 0 014 4 4 4 0 01-4 4 4 4 0 01-4-4 4 4 0 014-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="stat-card-front">
                <div class="stat-icon-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 3L1 9l11 6 9-4.91V17h2V9M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
                    </svg>
                </div>
                <div class="stat-number" data-count="<?= $professorCount ?>">0</div>
                <div class="stat-label">Professors</div>
            </div>
            <div class="stat-card-back">
                <p>Learn from industry leaders and academic Professors</p>
                <div class="stat-icon-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 3L1 9l11 6 9-4.91V17h2V9M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="stat-card-front">
                <div class="stat-icon-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM5 8V7h2v3.82C5.84 10.4 5 9.3 5 8zm14 0c0 1.3-.84 2.4-2 2.82V7h2v1z"/>
                    </svg>
                </div>
                <div class="stat-number" data-count="<?= $scholarshipCount ?>">0</div>
                <div class="stat-label">Opportunities</div>
            </div>
            <div class="stat-card-back">
                <p>Discover scholarships and funding opportunities</p>
                <div class="stat-icon-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM5 8V7h2v3.82C5.84 10.4 5 9.3 5 8zm14 0c0 1.3-.84 2.4-2 2.82V7h2v1z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="stat-card-front">
                <div class="stat-icon-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 22H6c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h1v7l2.5-1.5L12 9V2h6c1.1 0 2 .9 2 2v16c0 1.1-.9 2-2 2z"/>
                    </svg>
                </div>
                <div class="stat-number" data-count="<?= $bookCount ?>">0</div>
                <div class="stat-label">Resources</div>
            </div>
            <div class="stat-card-back">
                <p>Access our extensive library of learning materials</p>
                <div class="stat-icon-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 22H6c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h1v7l2.5-1.5L12 9V2h6c1.1 0 2 .9 2 2v16c0 1.1-.9 2-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

        <style>
            :root {
                --primary: #6C63FF;
                --secondary: #4D44DB;
                --accent: #FF6584;
                --light: #F9F9FF;
                --dark: #2E2E3A;
                --transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            }
            
            .hero {
                position: relative;
                overflow: hidden;
                background-color: var(--light);
                min-height: 100vh;
                display: flex;
                align-items: center;
            }
            
            .hero-container {
                position: relative;
                width: 100%;
                max-width: 1400px;
                margin: 0 auto;
                padding: 2rem;
                z-index: 2;
            }
            
/* Floating vector elements with education theme - Ultra Fast Flow */
.floating-vector {
    position: absolute;
    opacity: 0.5;
    z-index: 1;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    filter: blur(0.5px);
    transition: all 0.3s ease;
    will-change: transform;
}

/* Hover effects for all elements */
.floating-vector:hover {
    opacity: 1;
    filter: blur(0px) drop-shadow(0 0 10px rgba(0,0,0,0.3));
    transform: scale(1.2) !important;
    animation-play-state: paused;
    z-index: 10;
}

/* Left-to-right video flow animations - 3x FASTER */
@keyframes videoFlow {
    0% { transform: translateX(-30vw) translateY(0) rotate(0deg); }
    100% { transform: translateX(130vw) translateY(20vh) rotate(360deg); }
}

@keyframes videoFlowReverse {
    0% { transform: translateX(130vw) translateY(20vh) rotate(0deg); }
    100% { transform: translateX(-30vw) translateY(0) rotate(360deg); }
}

/* Individual elements with video flow - SPEED BOOST */
.atom {
    width: 300px;
    height: 300px;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="6" fill="%233A86FF"/><path d="M50,50 a20,20 0 1,1 0,1 z" stroke="%233A86FF" stroke-width="2" fill="none"/><path d="M50,50 a30,30 0 1,0 0,1 z" stroke="%233A86FF" stroke-width="2" fill="none"/><path d="M50,50 a40,15 0 1,1 0,1 z" stroke="%233A86FF" stroke-width="2" fill="none" transform="rotate(45 50 50)"/></svg>');
    top: -15%;
    left: 0;
    animation: videoFlow 8s infinite linear, rotate 8s infinite linear;
}

.book {
    width: 250px;
    height: 200px;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M10,20 L10,80 C30,75 40,85 50,80 C60,85 70,75 90,80 L90,20 C70,25 60,15 50,20 C40,15 30,25 10,20 Z" fill="%23FF6B6B"/></svg>');
    bottom: 50%;
    left: 0;
    animation: videoFlowReverse 10s infinite linear, tilt 4s infinite ease-in-out;
}

.calculator {
    width: 180px;
    height: 220px;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect x="10" y="10" width="80" height="80" rx="5" fill="%2380ED99" stroke="%2380ED99" stroke-width="2"/><rect x="20" y="25" width="60" height="15" rx="2" fill="%23fff"/><rect x="25" y="50" width="15" height="15" rx="2" fill="%23fff"/><rect x="50" y="50" width="15" height="15" rx="2" fill="%23fff"/><rect x="75" y="50" width="15" height="15" rx="2" fill="%23fff"/><rect x="25" y="75" width="15" height="15" rx="2" fill="%23fff"/><rect x="50" y="75" width="15" height="15" rx="2" fill="%23fff"/><rect x="75" y="75" width="15" height="15" rx="2" fill="%23fff"/></svg>');
    top: -5%;
    left: 0;
    animation: videoFlow 12s infinite linear, pulse 3s infinite ease-in-out;
    animation-delay: 2s;
}

.brain {
    width: 280px;
    height: 220px;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M30,40 Q40,20 50,40 Q60,20 70,40 Q80,30 80,50 Q80,70 70,60 Q60,80 50,60 Q40,80 30,60 Q20,70 20,50 Q20,30 30,40 Z" fill="%23FFD166"/></svg>');
    bottom: 30%;
    left: 0;
    animation: videoFlowReverse 14s infinite linear, wobble 3s infinite ease-in-out;
    animation-delay: 1s;
}

.pencil {
    width: 150px;
    height: 300px;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><polygon points="30,10 70,10 80,20 80,80 50,100 20,80 20,20" fill="%239B5DE5"/><rect x="30" y="20" width="40" height="60" fill="%23F15BB5"/><polygon points="30,10 50,0 70,10" fill="%2372EFDD"/></svg>');
    top: -10%;
    left: 0;
    animation: videoFlow 16s infinite linear, spin 10s infinite linear;
    animation-delay: 3s;
}

/* Responsive adjustments - FASTER MOBILE */
@media (max-width: 768px) {
    .floating-vector {
        opacity: 0.7;
        animation-duration: 8s !important;
    }
    
    .atom { width: 150px; height: 150px; }
    .book { width: 120px; height: 100px; }
    .calculator { width: 90px; height: 110px; }
    .brain { width: 140px; height: 110px; }
    .pencil { width: 75px; height: 150px; }
    
    /* Ultra-fast animation on mobile */
    @keyframes videoFlow {
        0% { transform: translateX(-30vw) translateY(0) rotate(0deg); }
        100% { transform: translateX(130vw) translateY(10vh) rotate(180deg); }
    }
    @keyframes videoFlowReverse {
        0% { transform: translateX(130vw) translateY(10vh) rotate(0deg); }
        100% { transform: translateX(-30vw) translateY(0) rotate(180deg); }
    }
}

            
            .hero-content {
                position: relative;
                z-index: 3;
                text-align: center;
                color: var(--dark);
            }
            
            .hero-content h1 {
                font-size: 4rem;
                font-weight: 800;
                line-height: 1.1;
                margin-bottom: 1.5rem;
                background: linear-gradient(90deg, var(--primary), var(--secondary));
                -webkit-background-clip: text;
                 background-clip: text; 
                -webkit-text-fill-color: transparent;
            }
            
            .hero-content p {
                font-size: 1.5rem;
                max-width: 700px;
                margin: 0 auto 3rem;
                color: var(--dark);
                opacity: 0.8;
            }
            
            .highlight {
                position: relative;
                display: inline-block;
            }
            
            .highlight::after {
                content: '';
                position: absolute;
                bottom: 5px;
                left: 0;
                width: 100%;
                height: 12px;
                background-color: rgba(255, 101, 132, 0.3);
                z-index: -1;
                transform: skewX(-15deg);
            }
            
            .hero-cta {
                display: flex;
                justify-content: center;
                gap: 1.5rem;
                margin-bottom: 4rem;
            }
            
            .btn {
                display: inline-flex;
                align-items: center;
                padding: 1rem 2.5rem;
                border-radius: 50px;
                font-weight: 600;
                text-decoration: none;
                transition: var(--transition);
                position: relative;
                overflow: hidden;
            }
            
            .primary-btn {
                background-color: var(--primary);
                color: white;
                box-shadow: 0 4px 20px rgba(30, 26, 103, 0.3);
            }
            
            .primary-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(108, 99, 255, 0.4);
            }
            
            .primary-btn svg {
                margin-left: 10px;
                stroke: white;
                transition: var(--transition);
            }
            
            .primary-btn:hover svg {
                transform: translateX(5px);
            }
            
            .secondary-btn {
                background-color: transparent;
                color: var(--primary);
                border: 2px solid var(--primary);
            }
            
            .secondary-btn:hover {
                background-color: rgba(108, 99, 255, 0.1);
                transform: translateY(-3px);
            }
            
            .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 2rem;
    max-width: 1000px;
    margin: 0 auto;
    perspective: 1000px;
}

.stat-card {
    background: transparent;
    border-radius: 16px;
    height: 220px;
    perspective: 1000px;
}

.stat-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform 0.8s;
    transform-style: preserve-3d;
    border-radius: 16px;
}

.stat-card:hover .stat-card-inner {
    transform: rotateY(180deg);
}

.stat-card-front, .stat-card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    border-radius: 16px;
    padding: 2rem 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: white;
}

.stat-card-back {
    transform: rotateY(180deg);
    background: linear-gradient(135deg, var(--primary) 0%, #4540b5ff 100%);
    color: white;
    text-align: center;
}

.stat-card-back p {
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
    line-height: 1.5;
    color: white;
    font-family: 'Inter', sans-serif;
    opacity: 0.9;
    transition: all 0.3s ease;
}

.stat-card-back .stat-icon-wrapper {
    background: rgba(255, 255, 255, 0.2);
}

.stat-card-back .stat-icon-wrapper svg {
    fill: white;
}

.stat-icon-wrapper {
    width: 60px;
    height: 60px;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(108, 99, 255, 0.1);
    border-radius: 50%;
    transition: all 0.3s ease;
}

.stat-card:hover .stat-icon-wrapper {
    transform: scale(1.1);
    background: rgba(108, 99, 255, 0.2);
}

.stat-icon-wrapper svg {
    width: 30px;
    height: 30px;
    fill: var(--primary);
    transition: all 0.3s ease;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
    font-family: 'Inter', sans-serif;
    transition: all 0.3s ease;
}

.stat-label {
    font-size: 1.1rem;
    color: var(--dark);
    opacity: 0.7;
    font-weight: 500;
    transition: all 0.3s ease;
}

.stat-card:hover .stat-number,
.stat-card:hover .stat-label {
    color: var(--primary);
}

/* Animation for counter */
@keyframes countUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Responsive design */
@media (max-width: 992px) {
    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
        max-width: 400px;
    }
    
    .stat-card {
        height: 200px;
    }
}
            
            /* Responsive design */
            @media (max-width: 992px) {
                .hero-content h1 {
                    font-size: 3rem;
                }
                
                .hero-content p {
                    font-size: 1.2rem;
                }
                
                .stats-grid {
                    grid-template-columns: 1fr 1fr;
                }
            }
            
            @media (max-width: 768px) {
                .hero-content h1 {
                    font-size: 2.5rem;
                }
                
                .hero-cta {
                    flex-direction: column;
                    gap: 1rem;
                }
                
                .stats-grid {
                    grid-template-columns: 1fr;
                    max-width: 400px;
                }
                
                .floating-vector {
                    display: none;
                }
            }
        </style>

        <!-- Load AOS CSS -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
    // Enhanced counter animation with smooth easing
    function animateCounters() {
        const counters = document.querySelectorAll('.stat-number');
        const duration = 2000; // 2 seconds for counting animation
        const startTime = performance.now();
        
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-count');
            const start = 0;
            
            const animate = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                // Custom easing function for smooth acceleration/deceleration
                const ease = progress < 0.5 
                    ? 2 * progress * progress 
                    : 1 - Math.pow(-2 * progress + 2, 2) / 2;
                
                const current = Math.floor(ease * target);
                counter.innerText = current.toLocaleString();
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    // Ensure we land exactly on the target number
                    counter.innerText = target.toLocaleString();
                    // Optional: Add a little celebration effect
                    counter.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        counter.style.transform = 'scale(1)';
                    }, 300);
                }
            };
            
            requestAnimationFrame(animate);
        });
    }
    
    // Start animation when stats are in view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    }, {threshold: 0.5});
    
    const statsGrid = document.querySelector('.stats-grid');
    if (statsGrid) {
        observer.observe(statsGrid);
    }
    
    // Flip effect for cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('click', function() {
            this.classList.toggle('flipped');
        });
        
        // For better mobile experience
        card.addEventListener('touchstart', function(e) {
            e.preventDefault();
            this.classList.toggle('flipped');
        }, {passive: false});
    });
});

// Initialize AOS animation
document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            once: true,
            duration: 800,
            easing: 'ease-out-quart'
        });
    }
});
            // Add this JavaScript to animate the counters and handle the flip effect
document.addEventListener('DOMContentLoaded', function() {
    // Animate counters
    const counters = document.querySelectorAll('.stat-number');
    const speed = 200;
    
    function animateCounters() {
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-count');
            const count = +counter.innerText;
            const increment = target / speed;
            
            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(animateCounters, 1);
            } else {
                counter.innerText = target;
            }
        });
    }
    
    // Start counting when stats come into view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    observer.observe(document.querySelector('.stats-grid'));
    
    // Enhanced hover effect for touch devices
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('click', function() {
            this.classList.toggle('flipped');
        });
    });
});
        </script>
        
    </section>


  <?php
// Database connection
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch books from database
$sql = "SELECT id, title, image, author FROM books ORDER BY title";
$result = $conn->query($sql);

$books = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
$conn->close();
?>

<section class="course-category">
  <div class="category-header">
    <p class="subtitle">START LEARNING TODAY</p>
    <h2>Academic & Job Oriented Books</h2>
  </div>

  <div class="category-circles-container">
    <div class="category-circles">
      <?php if (!empty($books)): ?>
        <?php foreach ($books as $book): ?>
          <div class="category-item">
            <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
            <div class="category-label">
              <?php echo htmlspecialchars($book['title']); ?><br>
              <span>by <?php echo htmlspecialchars($book['author']); ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No books found in the database</p>
      <?php endif; ?>
    </div>
  </div>
   <div >
    <a href="web-development.php" class="see-all-btn" onclick="redirectToLogin(event)">See All Books</a>
  </div>
</section>


<style>
  .course-category {
    padding: 40px 0;
    max-width: 1200px;
    margin: 0 auto;
  }
  
  .category-header {
    text-align: center;
    margin-bottom: 30px;
  }
  
  .category-circles-container {
    overflow-x: auto;
    padding: 20px 0;
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
  }
  
  .category-circles {
    display: flex;
    gap: 20px;
    padding: 0 20px;
    width: max-content; /* Allow horizontal scrolling */
  }
  
  .category-item {
    flex: 0 0 160px;
    text-align: center;
    position: relative;
    cursor: pointer;
    transition: transform 0.3s ease;
  }
  
  .category-item:hover {
    transform: translateY(-5px);
  }
  
  .category-item img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  
  .category-label {
    margin-top: 10px;
    font-weight: 600;
    color: #333;
  }
  
  .category-label span {
    font-size: 0.9em;
    color: #666;
  }
  
  .see-all-btn {
    text-align: center;
    margin-top: 30px;
  }
  
  /* Hide scrollbar but keep functionality */
  .category-circles-container::-webkit-scrollbar {
    display: none;
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .category-item {
      flex: 0 0 120px;
    }
    
    .category-item img {
      width: 100px;
      height: 100px;
    }
  }
</style>

<script>
  // Optional: Add smooth horizontal scrolling with mouse drag
  document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.category-circles-container');
    const circles = document.querySelector('.category-circles');
    let isDown = false;
    let startX;
    let scrollLeft;

    container.addEventListener('mousedown', (e) => {
      isDown = true;
      startX = e.pageX - container.offsetLeft;
      scrollLeft = container.scrollLeft;
    });

    container.addEventListener('mouseleave', () => {
      isDown = false;
    });

    container.addEventListener('mouseup', () => {
      isDown = false;
    });

    container.addEventListener('mousemove', (e) => {
      if(!isDown) return;
      e.preventDefault();
      const x = e.pageX - container.offsetLeft;
      const walk = (x - startX) * 2; // Adjust scroll speed
      container.scrollLeft = scrollLeft - walk;
    });

    // Touch support for mobile devices
    container.addEventListener('touchstart', (e) => {
      isDown = true;
      startX = e.touches[0].pageX - container.offsetLeft;
      scrollLeft = container.scrollLeft;
    }, {passive: true});

    container.addEventListener('touchend', () => {
      isDown = false;
    }, {passive: true});

    container.addEventListener('touchmove', (e) => {
      if(!isDown) return;
      e.preventDefault();
      const x = e.touches[0].pageX - container.offsetLeft;
      const walk = (x - startX) * 2;
      container.scrollLeft = scrollLeft - walk;
    }, {passive: false});
  });
</script>
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
    <a href="professors.php" class="see-all-btn">Browse All Professors</a>
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
  <?php
// Database connection
$conn = new mysqli("localhost", "kabir", "admin", "edulinkhub");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch scholarships from database
$sql = "SELECT * FROM fundings WHERE type = 'scholarship' ORDER BY applicationDeadline ASC LIMIT 8";
$result = $conn->query($sql);
$scholarships = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();

// Function to get country flag from university country
function getCountryFlag($university) {
    $countryFlags = [
        'united kingdom' => 'gb',
        'usa' => 'us',
        'australia' => 'au',
        'canada' => 'ca',
        'germany' => 'de',
        'france' => 'fr',
        'japan' => 'jp',
        'china' => 'cn'
    ];
    
    foreach ($countryFlags as $country => $code) {
        if (stripos($university, $country) !== false) {
            return $code;
        }
    }
    return 'un'; // Default to UN flag if no match
}

// Function to format scholarship amount
function formatAmount($description) {
    if (preg_match('/\$(\d+[\d,.]*)/', $description, $matches)) {
        return '$' . number_format(str_replace(',', '', $matches[1]));
    }
    if (preg_match('/€(\d+[\d,.]*)/', $description, $matches)) {
        return '€' . number_format(str_replace(',', '', $matches[1]));
    }
    if (preg_match('/£(\d+[\d,.]*)/', $description, $matches)) {
        return '£' . number_format(str_replace(',', '', $matches[1]));
    }
    return 'Full funding'; // Default
}
?>

<section class="scholarships-section">
  <div class="section-header">
    <h2>International Government Scholarships</h2>
    <p class="section-subtitle">Find funding opportunities for your studies</p>
  </div>
  
  <div class="scholarships-container">
    <div class="scholarships-scroller" id="scholarshipsScroller">
      <?php if (!empty($scholarships)): ?>
        <?php foreach ($scholarships as $scholarship): ?>
          <?php 
          $flagCode = getCountryFlag($scholarship['university']);
          $amount = formatAmount($scholarship['description']);
          ?>
          <div class="scholarship-card">
            <div class="scholarship-image" style="background-image: url('https://source.unsplash.com/random/500x300/?university,<?= urlencode($flagCode) ?>');">
              <div class="country-flag" style="background-image: url('https://flagcdn.com/w80/<?= $flagCode ?>.png');"></div>
            </div>
            <div class="scholarship-details">
              <h3><?= htmlspecialchars($scholarship['title']) ?></h3>
              <p class="country"><?= htmlspecialchars($scholarship['university']) ?></p>
              <p class="amount"><?= $amount ?></p>
              <p class="deadline">Deadline: <?= date('F j, Y', strtotime($scholarship['applicationDeadline'])) ?></p>
              <a href="<?= htmlspecialchars($scholarship['link']) ?>" class="apply-btn" target="_blank">Apply Now</a>
              <div class="more-details" onclick="window.location.href='funding_details.php?id=<?= $scholarship['id'] ?>'">
  <i class="fas fa-info-circle"></i> Details
</div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="no-scholarships">No scholarships currently available</div>
      <?php endif; ?>
    </div>
  </div>
  
  <div class="carousel-controls">
    <button class="control-btn prev-btn" onclick="scrollScholarships(-1)"><i class="fas fa-chevron-left"></i></button>
    <button class="control-btn next-btn" onclick="scrollScholarships(1)"><i class="fas fa-chevron-right"></i></button>
  </div>
  
  <div class="see-all-container">
    <a href="scholarship.php" class="see-all-btn">Browse All Scholarships</a>
  </div>
</section>

<style>
  /* Base Styles */
  .scholarships-section {
    padding: 4rem 2rem;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
    position: relative;
  }
  
  .section-header {
    text-align: center;
    margin-bottom: 3rem;
  }
  
  .section-header h2 {
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    position: relative;
    display: inline-block;
  }
  
  .section-header h2:after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: #3498db;
    border-radius: 2px;
  }
  
  .section-subtitle {
    color: #7f8c8d;
    font-size: 1.1rem;
    max-width: 700px;
    margin: 0 auto;
  }
  
  /* Scholarships Container */
  .scholarships-container {
    position: relative;
    max-width: 1400px;
    margin: 0 auto;
    padding: 1rem 0;
  }
  
  .scholarships-scroller {
    display: flex;
    gap: 1.5rem;
    padding: 1rem;
    overflow-x: auto;
    scroll-behavior: smooth;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
  }
  
  .scholarships-scroller::-webkit-scrollbar {
    display: none;
  }
  
  /* Scholarship Card */
  .scholarship-card {
    flex: 0 0 300px;
    scroll-snap-align: start;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
  }
  
  .scholarship-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
  }
  
  .scholarship-image {
    height: 160px;
    background-size: cover;
    background-position: center;
    position: relative;
  }
  
  .country-flag {
    position: absolute;
    bottom: -15px;
    right: 20px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 3px solid white;
    background-size: cover;
    background-position: center;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
  }
  
  .scholarship-details {
    padding: 1.5rem;
  }
  
  .scholarship-details h3 {
    font-size: 1.3rem;
    color: #2c3e50;
    margin-bottom: 0.5rem;
  }
  
  .country, .amount, .deadline {
    margin: 0.3rem 0;
    font-size: 0.95rem;
  }
  
  .country {
    color: #3498db;
    font-weight: 600;
  }
  
  .amount {
    color: #27ae60;
    font-weight: 600;
  }
  
  .deadline {
    color: #e74c3c;
    font-weight: 500;
  }
  
  .apply-btn {
    display: block;
    margin-top: 1.5rem;
    padding: 0.7rem 1rem;
    background: #3498db;
    color: white;
    text-align: center;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    transition: background 0.3s;
  }
  
  .apply-btn:hover {
    background: #2980b9;
  }
  
  .more-details {
    margin-top: 0.8rem;
    color: #7f8c8d;
    font-size: 0.9rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .more-details:hover {
    color: #3498db;
  }
  
  .more-details i {
    font-size: 1rem;
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
    color: #2c3e50;
    font-size: 1.2rem;
    transition: all 0.3s;
  }
  
  .control-btn:hover {
    background: #2c3e50;
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
    color: #2c3e50;
    border: 2px solid #2c3e50;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
  }
  
  .see-all-btn:hover {
    background: #2c3e50;
    color: white;
    transform: translateY(-3px);
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .scholarship-card {
      flex: 0 0 280px;
    }
    
    .section-header h2 {
      font-size: 2rem;
    }
  }
</style>

<script>
// Auto-scroll functionality
let autoScrollInterval;
const startAutoScroll = () => {
  const scroller = document.getElementById('scholarshipsScroller');
  autoScrollInterval = setInterval(() => {
    scroller.scrollBy({ left: 320, behavior: 'smooth' });
    
    // Reset to start if near end
    if (scroller.scrollLeft + scroller.clientWidth >= scroller.scrollWidth - 100) {
      setTimeout(() => {
        scroller.scrollTo({ left: 0, behavior: 'smooth' });
      }, 1000);
    }
  }, 3000);
};

// Manual scroll control
function scrollScholarships(direction) {
  const scroller = document.getElementById('scholarshipsScroller');
  scroller.scrollBy({ left: direction * 320, behavior: 'smooth' });
  clearInterval(autoScrollInterval);
  setTimeout(startAutoScroll, 10000); // Resume after 10 seconds
}

// Pause auto-scroll on hover
document.getElementById('scholarshipsScroller').addEventListener('mouseenter', () => {
  clearInterval(autoScrollInterval);
});

document.getElementById('scholarshipsScroller').addEventListener('mouseleave', startAutoScroll);

// Show scholarship details (would need to implement modal or details page)
function showScholarshipDetails(id) {
  // Implement this function to show more details
  window.location.href = `scholarship_details.php?id=${id}`;
}

// Start auto-scroll
document.addEventListener('DOMContentLoaded', startAutoScroll);
</script>


<section class="value-section">
  <div class="value-container">
    <h2>How EduLinkHub Empowers Your Learning Journey</h2>
    <p class="subtitle">Affordable solutions for everyday study challenges</p>
    
    <div class="value-grid">
      <!-- Feature 1 -->
      <div class="value-card">
        <div class="value-icon">
          <img src="https://cdn-icons-png.flaticon.com/512/3163/3163458.png" alt="Instant Solutions" width="64" height="64">
        </div>
        <div class="value-content">
          <h3>Instant Study Solutions</h3>
          <p>Get step-by-step explanations for problems you're stuck on, available 24/7 at a fraction of tutoring costs.</p>
          <span class="price-badge">From ৳59/solution</span>
        </div>
      </div>
      
      <!-- Feature 2 -->
      <div class="value-card">
        <div class="value-icon">
          <img src="https://cdn-icons-png.flaticon.com/512/1067/1067566.png" alt="Peer Network" width="64" height="64">
        </div>
        <div class="value-content">
          <h3>Peer Learning Network</h3>
          <p>Connect with students who've solved similar problems and share affordable study resources.</p>
          <span class="price-badge">Free access</span>
        </div>
      </div>
      
      <!-- Feature 3 -->
      <div class="value-card">
        <div class="value-icon">
          <img src="https://cdn-icons-png.flaticon.com/512/10334/10334245.png" alt="Study Tools" width="64" height="64">
        </div>
        <div class="value-content">
          <h3>Essential Study Tools</h3>
          <p>Access our budget-friendly toolkit: citation generators, plagiarism checkers, and formula libraries.</p>
          <span class="price-badge">Just ৳149/month</span>
        </div>
      </div>
      
      <!-- Feature 4 -->
      <div class="value-card">
        <div class="value-icon">
          <img src="https://cdn-icons-png.flaticon.com/512/3135/3135789.png" alt="Expert Help" width="64" height="64">
        </div>
        <div class="value-content">
          <h3>On-Demand Expert Help</h3>
          <p>Get affordable 1:1 sessions with subject specialists when you need deeper explanations.</p>
          <span class="price-badge">From ৳299/hour</span>
        </div>
      </div>
       <div class="value-card">
  <div class="value-icon">
    <img src="https://cdn-icons-png.flaticon.com/512/2210/2210153.png" alt="AI Assistant" width="64" height="64">
  </div>
  <div class="value-content">
    <h3>AI-Powered Study Assistant</h3>
    <p>24/7 personalized learning support with instant answers to your academic questions.</p>
    <span class="price-badge">Only ৳199/month</span>
  </div>
</div>
<div class="value-card">
  <div class="value-icon">
    <img src="https://cdn-icons-png.flaticon.com/512/3652/3652191.png" alt="Exam Prep" width="64" height="64">
  </div>
  <div class="value-content">
    <h3>Exam Preparation Packages</h3>
    <p>Comprehensive study materials, practice tests, and revision guides for all major exams.</p>
    <span class="price-badge">From ৳399/package</span>
  </div>
</div>
    </div>
   
    
    <div class="cta-container">
      <p class="cta-text">Start solving your study problems today - no expensive commitments!</p>
      <a href="join.php" class="see-all-btn">Get Help Now</a>
    </div>
    
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init();
</script>

 
</body>
<?php require 'footer.php'; ?>
<!-- JavaScript -->

<script>
  function showLoginPrompt(event) {
    event.preventDefault(); // Prevent the default link behavior
    alert("Please login first.");
    window.location.href = "../HTML/login.html"; // Redirect to login page
  }
  function showLoginPrompt(event) {
  event.preventDefault();
  if (confirm("You need to login to continue. Go to login page?")) {
    window.location.href = "../HTML/login.html";
  }
}

</script>
<script>
  function handleLoginRedirect(event) {
    event.preventDefault(); // Prevent default link behavior
    alert("Please login first.");
    window.location.href = "../HTML/login.html"; // Redirect to login page
  }
</script>

<script>
  function handleLoginRedirect(event) {
    event.preventDefault(); // Stop the default anchor link behavior
    alert("Please login first.");
    window.location.href = "../HTML/login.html"; // Change path as needed
  }
</script>
<script>
  function redirectToLogin(event) {
    event.preventDefault(); // Prevent the link from jumping to "#"
  
    window.location.href = "web-development.php"; // Update path if needed
  }
</script>




<!-- Font Awesome (for icons) -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</html>