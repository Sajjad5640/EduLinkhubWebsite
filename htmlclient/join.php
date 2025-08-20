<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Join Us - EdUHub</title>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <link rel="stylesheet" href="../CSS/join.css" />
</head>
<body>
<?php require 'header.php'; ?>
  <header class="hero">
  

    <section class="join-container">
      <div class="join-header">
        <h1>Join Our Community</h1>
        <p>Connect with learners and educators from across the country.</p>
      </div>

      <div class="join-buttons">
        <a href="https://facebook.com/yourpage" target="_blank" class="btn fb-page">📘 Facebook Page</a>
        <a href="https://facebook.com/groups/yourgroup" target="_blank" class="btn fb-group">👥 Facebook Group</a>
        <a href="https://chat.whatsapp.com/yourgroup" target="_blank" class="btn whatsapp">💬 WhatsApp Group</a>
        <a href="https://t.me/yourgroup" target="_blank" class="btn telegram">✈️ Telegram Group</a>
      </div>

      <div class="chat-section">
        <h2>Connect with Other Beneficiaries</h2>
        <p>Those who benefited from EdUHub are here to chat with you. Ask your questions!</p>
        <div class="chat-box">
          <p><strong>👤 Rafi:</strong> EdUHub helped me get university admission info. Feel free to ask me anything!</p>
          <p><strong>👤 Mitu:</strong> I found my IELTS resources here! Happy to help 😊</p>
          <a href="#" class="btn chat-btn" onclick="Tawk_API.maximize(); return false;">💬 Start Chat</a>
        </div>
      </div>
    </section>
  </header>
<?php require 'footer.php'; ?>
  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function(){
      var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
      s1.async = true;
      s1.src = 'https://embed.tawk.to/683b13a13702a7190afc2d14/1isjc9clg'; // ✅ Replace if your Tawk.to ID is different
      s1.charset = 'UTF-8';
      s1.setAttribute('crossorigin', '*');
      s0.parentNode.insertBefore(s1, s0);
    })();
  </script>
  <!--End of Tawk.to Script-->

</body>
</html>
