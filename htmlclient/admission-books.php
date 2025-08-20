<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../images/logo.png" type="image/png">
  <title>Admission Book | EdUHub</title>
  <link rel="stylesheet" href="../CSS/admission-books.css" />
</head>
<body>

 <!-- Navbar -->
  <nav class="navbar">
    <div class="logo">
      <img src="../images/logo.png" alt="EdUHub Logo" class="logo-img">
    </div>
    <ul class="nav-links">
      <li><a href="../index.html">Home</a></li>

      <li class="dropdown">
        <a href="#">Books ▾</a>
        <ul class="dropdown-content">
          <li><a href="../HTML/web-development.html">Web Development</a></li>
          <li><a href="../HTML/design-books.html">Design</a></li>
          <li><a href="../HTML/ai-ml-books.html">AI & ML</a></li>
          <li><a href="../HTML/admission.html">Admission (100+ Books)</a></li>
          <li><a href="../HTML/public-private-job.html">Public & Private Job (100+ Books)</a></li>
          <li><a href="../HTML/bcs-books.html">BCS (100+ Books)</a></li>
          <li><a href="../HTML/it-software-books.html">IT & Software (100+ Books)</a></li>
          <li><a href="../HTML/academic-books.html">Academic (100+ Books)</a></li>
          <li><a href="../HTML/language-books.html">Language (100+ Books)</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#">Study Abroad ▾</a>
        <ul class="dropdown-content">
          <li><a href="../HTML/professors.html">Professors</a></li>
          <li><a href="../HTML/scholarship.html">Scholarship</a></li>
        </ul>
      </li>

      <li><a href="../HTML/admission.html" class="btn">Admission</a></li>
      <li><a href="../HTML/about-contact.html">About & Contact</a></li>
    </ul>

    <div class="user-profile" id="userProfile">
      <img src="../images/Profile.jpg" alt="User" class="profile-pic" />
      <div class="user-dropdown">
        <a href="../HTML/profile.html">Profile</a>
        <a href="../HTML/settings.html">Settings</a>
        <a href="../HTML/login.html">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="job-hero">
    <div class="hero-content">
      <h1>Admission Preparation Books</h1>
    <p>Get top resources for University, Medical & Engineering admission tests.</p>
  </div>
  </section>

  <!-- Job Listings Section -->
  <section class="job-section">
    <div class="job-grid">
      <div class="job-card">
          <img src="images/university-book.jpg" alt="University Admission Book" />
      <h3>University Admission Book</h3>
      <p>Includes English, Math, GK and previous year question banks.</p>
      <a class="view-btn" href="#">Download PDF</a>
      </div>

      <div class="job-card">
         <img src="images/university-book.jpg" alt="University Admission Book" />
      <h3>University Admission Book</h3>
      <p>Includes English, Math, GK and previous year question banks.</p>
      <a class="view-btn" href="#">Download PDF</a>
      </div>

      <div class="job-card">
         <img src="images/engineering-book.jpg" alt="Engineering Admission Book" />
      <h3>Engineering Admission Book</h3>
      <p>Specialized for BUET & CUET with solved papers and practice sets.</p>
      <a class="view-btn" href="#">Download PDF</a>
      </div>
      <div class="job-card">
      <img src="images/bangla-guide.jpg" alt="University Bangla Guide" />
      <h3>University Bangla Guide</h3>
      <p>Complete preparation for Humanities and Arts group.</p>
      <a class="view-btn" href="#">Download PDF</a>
      </div>
    </div>
  </section>

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

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; 2025 EdUHub. All rights reserved.</p>
  </footer>

</body>
</html>
