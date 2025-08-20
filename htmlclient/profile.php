<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Profile</title>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <link rel="stylesheet" href="../CSS/profile.css" />
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
          <li><a href="#">Design</a></li>
          <li><a href="../HTML/ai-ml-books.html">AI & ML</a></li>
          <li><a href="#">Admission (100+ Books)</a></li>
          <li><a href="#">Public & Private Job</a></li>
          <li><a href="#">BCS</a></li>
          <li><a href="#">IT & Software</a></li>
          <li><a href="#">Academic</a></li>
          <li><a href="#">Language</a></li>
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
      <li><a href="#">About & Contact</a></li>
    </ul>
  </nav>

  <!-- Profile Section -->
  <div class="profile-page">
    <!-- Sidebar -->
    <aside class="profile-sidebar">
      <img src="../images/Profile.jpg" alt="User Profile" class="sidebar-profile-pic">
      <h2>John Doe</h2>
      <p><strong>Email:</strong><br> johndoe@example.com</p>
      <p><strong>Country:</strong><br> Bangladesh</p>
      <p><strong>Interests:</strong><br> AI, Software Engineering, Scholarships</p>

      <div class="sidebar-links">
        <a href="../HTML/settings.html" class="sidebar-btn">⚙️ Settings</a>
        <a href="../HTML/login.html" class="sidebar-btn logout">🚪 Logout</a>
      </div>
    </aside>

    <!-- Main Profile Content -->
    <section class="profile-main">
      <div class="card">
        <h3>Saved Scholarships</h3>
        <ul class="saved-list">
          <li>✅ Chevening Scholarship</li>
          <li>✅ Fulbright Foreign Student Program</li>
          <li>✅ Erasmus Mundus Joint Masters</li>
        </ul>
      </div>

      <div class="card">
        <h3>Recent Activity</h3>
        <ul class="activity-list">
          <li>📘 Enrolled in “AI for Beginners”</li>
          <li>✉️ Contacted Prof. Emma Wilson</li>
          <li>📥 Downloaded Web Dev Book Pack</li>
        </ul>
      </div>
    </section>
  </div>

  <footer class="footer">
    <p>&copy; 2025 EdUHub. All rights reserved.</p>
  </footer>

</body>
</html>
