<?php
session_start();
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
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Function to get animated count from a table
    function getAnimatedCount($conn, $table, $prefix = '', $suffix = '') {
        $sql = "SELECT COUNT(*) as count FROM $table";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return '<span class="counter" data-target="'.$row['count'].'">0</span>';
        }
        return '<span class="counter">0</span>';
    }
    
    // Get counts from different tables
    $userCount = getAnimatedCount($conn, "users");
    $professorCount = getAnimatedCount($conn, "professors");
    $scholarshipCount = getAnimatedCount($conn, "fundings");
    $bookCount = getAnimatedCount($conn, "books");
    
    // Close connection
    $conn->close();
    ?>

    <div class="hero-section" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 data-aos="fade-down" data-aos-duration="800">Unlock Your Academic Potential</h1>
            <p data-aos="fade-down" data-aos-duration="800" data-aos-delay="200">Get instant solutions to study problems, connect with expert tutors, and access affordable learning resources tailored for Bangladeshi students.</p>
            <div class="hero-cta" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                <a href="#" class="btn primary-btn" onclick="showLoginPrompt(event)">Get Study Help Now</a>
                <a href="#" class="btn secondary-btn" onclick="showLoginPrompt(event)">Meet Our Tutors</a>
            </div>
            <div class="hero-stats" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-number"><?php echo $userCount; ?></div>
                    <span class="stat-label">Registered Students</span>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="stat-number"><?php echo $professorCount; ?></div>
                    <span class="stat-label">Expert Tutors</span>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-award"></i></div>
                    <div class="stat-number"><?php echo $scholarshipCount; ?></div>
                    <span class="stat-label">Scholarships</span>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-book"></i></div>
                    <div class="stat-number"><?php echo $bookCount; ?></div>
                    <span class="stat-label">Book Collection</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        
        
        .hero-section {
            position: relative;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 90vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.9) 0%, rgba(63, 55, 201, 0.9) 100%);
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            text-align: center;
            color: white;
        }
        
        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            font-weight: 800;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .hero-content p {
            font-size: 1.25rem;
            max-width: 800px;
            margin: 0 auto 2rem;
            opacity: 0.9;
        }
        
        .hero-cta {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .primary-btn {
            background-color: var(--accent-color);
            color: var(--dark-color);
        }
        
        .primary-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(76, 201, 240, 0.3);
        }
        
        .secondary-btn {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .secondary-btn:hover {
            background-color: white;
            color: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .hero-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            max-width: 1000px;
            margin: 3rem auto 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 2rem 1rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        
        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: var(--transition);
        }
        
        .stat-item:hover {
            transform: translateY(-15px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.2);
        }
        
        .stat-item:hover::before {
            transform: translateX(100%);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--accent-color);
            transition: var(--transition);
        }
        
        .stat-item:hover .stat-icon {
            transform: scale(1.1);
            color: white;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            font-family: 'Inter', sans-serif;
        }
        
        .stat-label {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            display: block;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        /* Counter animation */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .counter {
            display: inline-block;
            animation: pulse 2s infinite;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-content p {
                font-size: 1rem;
            }
            
            .hero-cta {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .hero-stats {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS animation
        AOS.init({
            once: true,
            easing: 'ease-out-quart'
        });
        
        // Enhanced counter animation with slower speed
        function animateCounters() {
            const counters = document.querySelectorAll('.counter');
            const duration = 3000; // 3 seconds
            const startTime = Date.now();
            
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const start = 0;
                const easeOutQuad = t => t * (2 - t); // Easing function
                
                const updateCounter = () => {
                    const elapsed = Date.now() - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const easedProgress = easeOutQuad(progress);
                    const current = Math.floor(easedProgress * target);
                    
                    counter.innerText = current.toLocaleString();
                    
                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.innerText = target.toLocaleString();
                        // Final celebration animation
                        counter.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            counter.style.transform = 'scale(1)';
                        }, 300);
                    }
                };
                
                updateCounter();
            });
        }
        
        // Start animation when hero section is in view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, {threshold: 0.5});
        
        observer.observe(document.querySelector('.hero-stats'));
    </script>
</section>
  <section class="course-category">
  <div class="category-header">
    <p class="subtitle">START LEARNING TODAY</p>
    <h2>Academic & Job Oriented Books</h2>
  </div>

  <div class="category-circles">
    <div class="category-item">
      <img src="images/admission.jpg" alt="Admission">
      <div class="category-label"> Admission <br><span>100+ Books</span></div>
    </div>
    <div class="category-item">
      <img src="images/job.jpg" alt="Public & Private Job">
      <div class="category-label">Public & Private Job<br><span>100+ Books</span></div>
    </div>
    <div class="category-item">
      <img src="images/BCS.avif" alt="BCS">
      <div class="category-label">BCS<br><span>100+ Books</span></div>
    </div>
    <div class="category-item">
      <img src="images/software.avif" alt="IT & Software">
      <div class="category-label">IT & Software<br><span>100+ Books</span></div>
    </div>
    <div class="category-item">
      <img src="images/academic.jpg" alt="Academic">
      <div class="category-label">Academic<br><span>100+ Books</span></div>
    </div>
    <div class="category-item">
      <img src="images/language.png" alt="Language">
      <div class="category-label">Language<br><span>100+ Books</span></div>
    </div>
  </div>

  <div class="see-all-btn">
    <a href="#" class="btn-pink" onclick="handleLoginRedirect(event)">See All Books</a>
  </div>
</section>
<section class="professors-section">
    <h2>Renowned International Professors</h2>
    <div class="professors-grid">
        <div class="professor-card">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Professor John Smith" class="professor-img">
            <div class="professor-details">
                <h3>Prof. John Smith</h3>
                <p class="university">Massachusetts Institute of Technology (MIT), USA</p>
                <p class="department">Department of Computer Science</p>
                <p class="research">Research Focus: Artificial Intelligence, Machine Learning</p>
                <p class="contact">jsmith@mit.edu | +1 (617) 253-1000</p>
            </div>
        </div>
        
        <div class="professor-card">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Professor Sarah Johnson" class="professor-img">
            <div class="professor-details">
                <h3>Prof. Sarah Johnson</h3>
                <p class="university">University of Oxford, UK</p>
                <p class="department">Department of Data Science</p>
                <p class="research">Research Focus: Big Data Analytics, Computational Statistics</p>
                <p class="contact">sjohnson@ox.ac.uk | +44 1865 270000</p>
            </div>
        </div>
        
        <div class="professor-card">
            <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Professor David Lee" class="professor-img">
            <div class="professor-details">
                <h3>Prof. David Lee</h3>
                <p class="university">ETH Zurich, Switzerland</p>
                <p class="department">Department of Engineering</p>
                <p class="research">Research Focus: Human-Computer Interaction, UX Design</p>
                <p class="contact">dlee@ethz.ch | +41 44 632 1111</p>
            </div>
        </div>
        
        <div class="professor-card">
            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Professor Maria Garcia" class="professor-img">
            <div class="professor-details">
                <h3>Prof. Maria Garcia</h3>
                <p class="university">University of Toronto, Canada</p>
                <p class="department">Department of Computer Science</p>
                <p class="research">Research Focus: Distributed Systems, Cloud Computing</p>
                <p class="contact">mgarcia@utoronto.ca | +1 (416) 978-2011</p>
            </div>
        </div>
    </div>
     <div class="see-all-btn">
   <a href="#" class="btn-pink" onclick="handleLoginRedirect(event)">See More</a>

  </div>
</section>
  <section class="scholarships-section">
  <h2>International Government Scholarships</h2>
  
  <div class="scholarships-container">
    <div class="scholarships-scroller">
      <!-- Scholarship Card 1 -->
      <div class="scholarship-card">
        <div class="scholarship-image" style="background-image: url('https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');">
          <div class="country-flag" style="background-image: url('https://flagcdn.com/w80/gb.png');"></div>
        </div>
        <div class="scholarship-details">
          <h3>Chevening Scholarship</h3>
          <p class="country">United Kingdom</p>
          <p class="amount">Full tuition + £18,000 stipend</p>
          <p class="deadline">Deadline: November 7, 2023</p>
          <a href="#" class="apply-btn">Apply Now</a>
        </div>
      </div>
      
      <!-- Scholarship Card 2 -->
       <div class="scholarship-card">

        <div class="scholarship-image" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');">
          <div class="country-flag" style="background-image: url('https://flagcdn.com/w80/us.png');"></div>
        </div>
        <div class="scholarship-details">
          <h3>Fulbright Program</h3>
          <p class="country">United States</p>
          <p class="amount">Full funding + living allowance</p>
          <p class="deadline">Deadline: October 10, 2023</p>
          <a href="#" class="apply-btn">Apply Now</a>
        </div>
      </div>
      
      <!-- Scholarship Card 3 -->
      <div class="scholarship-card">
        <div class="scholarship-image" style="background-image: url('https://images.unsplash.com/photo-1526779259212-939e64788e3c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');">
          <div class="country-flag" style="background-image: url('https://flagcdn.com/w80/au.png');"></div>
        </div>
        <div class="scholarship-details">
          <h3>Australia Awards</h3>
          <p class="country">Australia</p>
          <p class="amount">Full tuition + travel allowance</p>
          <p class="deadline">Deadline: April 30, 2024</p>
          <a href="#" class="apply-btn">Apply Now</a>
        </div>
      </div>
      
      <!-- Scholarship Card 4 -->
      <div class="scholarship-card">
        <div class="scholarship-image" style="background-image: url('https://images.unsplash.com/photo-1499209974431-9dddcece7f88?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');">
          <div class="country-flag" style="background-image: url('https://flagcdn.com/w80/ca.png');"></div>
        </div>
        <div class="scholarship-details">
          <h3>Vanier Canada</h3>
          <p class="country">Canada</p>
          <p class="amount">$50,000 per year</p>
          <p class="deadline">Deadline: November 1, 2023</p>
          <a href="#" class="apply-btn">Apply Now</a>
        </div>
      </div>
      
      <!-- Scholarship Card 5 -->
      <div class="scholarship-card">
        <div class="scholarship-image" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');">
          <div class="country-flag" style="background-image: url('https://flagcdn.com/w80/de.png');"></div>
        </div>
        <div class="scholarship-details">
          <h3>DAAD Scholarship</h3>
          <p class="country">Germany</p>
          <p class="amount">€850-1,200 monthly</p>
          <p class="deadline">Deadline: Varies by program</p>
          <a href="#" class="apply-btn">Apply Now</a>
        </div>
      </div>
    </div>
  </div><br><br>
   <div class="see-all-btn">
   <a href="#" class="btn-pink" onclick="redirectToLogin(event)">See More</a>

  </div>
</section>


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
    </div>
    
    <div class="cta-container">
      <p class="cta-text">Start solving your study problems today - no expensive commitments!</p>
      <a href="#" class="cta-button">Get Help Now</a>
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
    alert("Please login first.");
    window.location.href = "../HTML/login.html"; // Update path if needed
  }
</script>




<!-- Font Awesome (for icons) -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</html>