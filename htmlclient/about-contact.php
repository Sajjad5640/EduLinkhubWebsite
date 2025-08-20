<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About & Contact</title>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <link rel="stylesheet" href="../CSS/about-contact.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <?php require 'header.php'; ?>
  <section class="about">
    <h2>About EduLink Hub</h2>
    <p>EduLink Hub is an innovative educational platform offering students access to admission links, learning resources, programming tutorials, and funding support. We empower learners to make informed decisions and connect with educators globally.</p>
    <p>Our vision is to simplify the education journey and promote equal access to academic opportunities through technology.</p>
  </section>

  <section class="contact">
    <h2>Contact Us</h2>
    <div class="contact-info">
      <p><i class="fas fa-envelope"></i> Email: <a href="mailto:support@edulinkhub.com">support@edulinkhub.com</a></p>
      <p><i class="fas fa-phone"></i> Phone: +880 123-456-7890</p>
      <p><i class="fas fa-map-marker-alt"></i> Address: Dhaka, Bangladesh</p>
    </div>

    <!-- Updated Formspree contact form -->
    <form class="contact-form" action="https://formspree.io/f/your-form-id" method="POST">
      <input type="text" name="name" placeholder="Your Name" required />
      <input type="email" name="email" placeholder="Your Email" required />
      <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
      <button type="submit">Send Message</button>
    </form>

    <!-- Social Media Section -->
    <div class="social-icons">
      <h3>Follow Us</h3>
      <a href="https://facebook.com" target="_blank" class="social"><i class="fab fa-facebook-f"></i></a>
      <a href="https://twitter.com" target="_blank" class="social"><i class="fab fa-twitter"></i></a>
      <a href="https://linkedin.com" target="_blank" class="social"><i class="fab fa-linkedin-in"></i></a>
      <a href="https://instagram.com" target="_blank" class="social"><i class="fab fa-instagram"></i></a>
    </div>

    <!-- Google Maps -->
    <div class="map-container">
      <h3>Find Us on Google Maps</h3>
      <iframe src="https://www.google.com/maps?q=dhaka,+bangladesh&output=embed" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </section>

  <?php require 'footer.php'; ?>

  <script>
    const profile = document.getElementById('userProfile');
    profile.addEventListener('click', function (e) {
      e.stopPropagation();
      profile.classList.toggle('active');
    });

    document.addEventListener('click', function () {
      profile.classList.remove('active');
    });
  </script>
</body>
</html>
