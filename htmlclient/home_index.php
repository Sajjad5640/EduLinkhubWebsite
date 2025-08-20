
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpStudy - Transform Your Learning Journey</title>
    <link rel="stylesheet" href="../CSS/style_home_index.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                    <div class="login-box">
                        <i class="fas fa-user"></i>
                        <a href="login.php">Login</a>
                    </div>
                    <div class="menu-box" id="menuBox">
                        <i class="fas fa-bars"></i>
                        <a href="#">Menu</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fullscreen Portfolio Overlay -->
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
                <h1>Home</h1>
                <p>Welcome to our educational platform. Discover the best resources and guidance for your academic journey.</p>
            </div>

            <!-- Book -->
            <div id="book" class="menu-section">
                <h1>Book Resources</h1>
                <div class="menu-links">
                    <a href="#">ALL Books</a>
                    <!-- <a href="#"></a>
                    <a href="#">Study Guides</a> -->
                </div>
            </div>

            <!-- Study Abroad -->
            <div id="study-abroad" class="menu-section">
                <h1>Study Abroad Options</h1>
                <div class="menu-links">
                    <a href="#">Professor</a>
                    <a href="#">Scholarship Opportunities</a>
                    <a href="#">Application Process</a>
                    <a href="#">Student Testimonials</a>
                </div>
            </div>

            <!-- Admission -->
            <div id="admission" class="menu-section">
                <h1>Admission Process</h1>
                <p>Comprehensive guidance for university admissions worldwide. We cover everything from application preparation to visa assistance.</p>
                <div class="menu-links">
                    <a href="#">Universities</a>
                    <a href="#">Deadlines</a>
                    <a href="#">Documentation</a>
                </div>
            </div>

            <!-- About & Contact -->
            <div id="about-contact" class="menu-section">
                <h1>About Us & Contact</h1>
                <p>We are dedicated to helping students achieve their academic goals through personalized guidance and resources.</p>
                <div class="menu-links">
                    <a href="mailto:contact@edulinkhub.com">Email: contact@edulink.com</a>
                    <a href="tel:+1234567890">Phone: +1 (234) 567-890</a>
                    <a href="#">Our Team</a>
                    <a href="#">FAQ</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Quick Links -->
    <div class="quick-links">
        <a href="#">Download App</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
        <a href="#">Careers</a>
        <a href="#">Feedback</a>
    </div>
</div>

    </header>


    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-bolt"></i>
                    <span>Most Powerful</span>
                </div>
                <h1 class="hero-title">
                    Transform Your <br>
                    <span class="gradient-text">Learning Journey</span>
                </h1>
                <p class="hero-subtitle">
                    Experience the most comprehensive education platform designed for modern learners.
                    Join thousands of students already transforming their careers.
                </p>
                <div class="hero-stats">
                    <div class="stat-item">
                        <h3>20+</h3>
                        <p>Course Categories</p>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <h3>6+</h3>
                        <p>Learning Formats</p>
                    </div>
                </div>
                <div class="hero-cta">
                    <button class="btn-primary btn-large">Start Learning Today</button>
                    <button class="btn-secondary">Watch Demo</button>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-image">
                    <img src="images/hero/hero-main.jpg" alt="Students Learning">
                </div>
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
                <h2>Why Choose UpStudy?</h2>
                <p>Discover the features that make learning effective and enjoyable</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3>Online Learning</h3>
                    <p>Access courses anytime, anywhere with our flexible online platform designed for modern learners.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>Expert Instructors</h3>
                    <p>Learn from industry professionals with years of experience in their respective fields.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Flexible Schedule</h3>
                    <p>Study at your own pace with lifetime access to course materials and resources.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Certification</h3>
                    <p>Earn recognized certificates upon course completion to boost your career prospects.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <h3>Interactive Content</h3>
                    <p>Engage with multimedia content, quizzes, and hands-on projects for better learning.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Community Support</h3>
                    <p>Connect with fellow learners and get support from our active community.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section id="courses" class="courses">
        <div class="container">
            <div class="section-header">
                <h2>Popular Courses</h2>
                <p>Explore our most popular courses designed by industry experts</p>
            </div>
            <div class="courses-grid">
                <div class="course-card">
                    <div class="course-image">
                        <img src="images/features/online-learning.jpg" alt="Web Development">
                        <div class="course-badge">Bestseller</div>
                    </div>
                    <div class="course-content">
                        <div class="course-meta">
                            <span class="course-category">Development</span>
                            <span class="course-rating">
                                <i class="fas fa-star"></i> 4.8
                            </span>
                        </div>
                        <h3>Complete Web Development Bootcamp</h3>
                        <p>Master modern web development with HTML, CSS, JavaScript, React, and Node.js</p>
                        <div class="course-footer">
                            <div class="course-price">
                                <span class="price-current">$89</span>
                                <span class="price-original">$199</span>
                            </div>
                            <button class="btn-course">Enroll Now</button>
                        </div>
                    </div>
                </div>
                <div class="course-card">
                    <div class="course-image">
                        <img src="images/features/student-learning.jpg" alt="Data Science">
                        <div class="course-badge">New</div>
                    </div>
                    <div class="course-content">
                        <div class="course-meta">
                            <span class="course-category">Data Science</span>
                            <span class="course-rating">
                                <i class="fas fa-star"></i> 4.9
                            </span>
                        </div>
                        <h3>Data Science & Machine Learning</h3>
                        <p>Learn Python, statistics, and machine learning to become a data scientist</p>
                        <div class="course-footer">
                            <div class="course-price">
                                <span class="price-current">$129</span>
                                <span class="price-original">$249</span>
                            </div>
                            <button class="btn-course">Enroll Now</button>
                        </div>
                    </div>
                </div>
                <div class="course-card">
                    <div class="course-image">
                        <img src="images/features/group-study.jpg" alt="Digital Marketing">
                        <div class="course-badge">Popular</div>
                    </div>
                    <div class="course-content">
                        <div class="course-meta">
                            <span class="course-category">Marketing</span>
                            <span class="course-rating">
                                <i class="fas fa-star"></i> 4.7
                            </span>
                        </div>
                        <h3>Digital Marketing Mastery</h3>
                        <p>Master SEO, social media marketing, and digital advertising strategies</p>
                        <div class="course-footer">
                            <div class="course-price">
                                <span class="price-current">$79</span>
                                <span class="price-original">$159</span>
                            </div>
                            <button class="btn-course">Enroll Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Empowering Learners Worldwide</h2>
                    <p>At UpStudy, we believe that quality education should be accessible to everyone. Our platform
                        combines cutting-edge technology with expert instruction to deliver an unparalleled learning
                        experience.</p>
                    <div class="about-stats">
                        <div class="about-stat">
                            <h3>50,000+</h3>
                            <p>Active Students</p>
                        </div>
                        <div class="about-stat">
                            <h3>500+</h3>
                            <p>Expert Instructors</p>
                        </div>
                        <div class="about-stat">
                            <h3>95%</h3>
                            <p>Success Rate</p>
                        </div>
                    </div>
                    <button class="btn-primary">Learn More About Us</button>
                </div>
                <div class="about-visual">
                    <div class="about-image">
                        <img src="images/features/online-learning.jpg" alt="About UpStudy">
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
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p>"UpStudy completely changed my career trajectory. The courses are well-structured and the
                            instructors are amazing!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=60&h=60&fit=crop&crop=face"
                                alt="Sarah Johnson">
                        </div>
                        <div class="author-info">
                            <h4>Sarah Johnson</h4>
                            <p>Software Developer</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p>"The flexibility of online learning allowed me to study while working full-time. Highly
                            recommend!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=60&h=60&fit=crop&crop=face"
                                alt="Michael Chen">
                        </div>
                        <div class="author-info">
                            <h4>Michael Chen</h4>
                            <p>Data Analyst</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
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
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=60&h=60&fit=crop&crop=face"
                                alt="Emily Rodriguez">
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
                <div class="contact-info">
                    <h2>Get In Touch</h2>
                    <p>Ready to start your learning journey? Contact us today and let's discuss how we can help you
                        achieve your goals.</p>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>hello@upstudy.com</span>
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
                <div class="contact-form">
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

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>UPSTUDY</h3>
                    <p>Transforming education through innovative online learning experiences.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#courses">Courses</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Categories</h4>
                    <ul>
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Data Science</a></li>
                        <li><a href="#">Digital Marketing</a></li>
                        <li><a href="#">Design</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 UpStudy. All rights reserved.</p>
            </div>
        </div>
    </footer>

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
</body>

</html>