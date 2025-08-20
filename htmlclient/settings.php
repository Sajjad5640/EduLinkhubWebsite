<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Settings</title>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <link rel="stylesheet" href="../CSS/settings.css" />
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
          <li><a href="#">Public & Private Job (100+ Books)</a></li>
          <li><a href="#">BCS (100+ Books)</a></li>
          <li><a href="#">IT & Software (100+ Books)</a></li>
          <li><a href="#">Academic (100+ Books)</a></li>
          <li><a href="#">Language (100+ Books)</a></li>
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

  <!-- Settings Section -->
  <section class="settings-container">
    <h2>Account Settings</h2>

    <form class="settings-form">
      <label for="username">Username:</label>
      <input type="text" id="username" placeholder="Enter your name" value="John Doe">

      <label for="email">Email:</label>
      <input type="email" id="email" placeholder="Enter your email" value="johndoe@example.com">

      <label for="password">New Password:</label>
      <input type="password" id="password" placeholder="Enter new password">

      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" placeholder="Confirm new password">

      <label for="country">Country:</label>
      <input type="text" id="country" placeholder="Enter your country" value="Bangladesh">

      <label for="interests">Interests:</label>
      <input type="text" id="interests" placeholder="Your interests" value="AI, Software Engineering, Scholarships">

      <button type="submit" class="save-btn">Save Changes</button>
    </form>
  </section>

  <footer class="footer">
    <p>&copy; 2025 EdUHub. All rights reserved.</p>
  </footer>

</body>
</html>
