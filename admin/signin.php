<?php
require '../config/database.php';
$active_page = 'signin';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../admin/styles/signin.css">
</head>

<body>
    <div class="app-bar">
        <h1>Admin Sign In</h1>
    </div>

    <div class="container">
        <div class="logo-container">
            <img src="./Edulink Hub logo.jpg" alt="EduLink Logo" class="logo">
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message" id="errorMessage">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form id="signInForm" action="../admin/logic/signin-logic.php" method="POST">

            <div class="form-group">
                <label for="email">Admin Email</label>
                <div class="input-container">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" id="email" name="email" required placeholder="Enter your admin email">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Admin Password</label>
                <div class="input-container">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                <div class="btn-content">
                    <span>Admin Sign In</span>
                </div>
            </button>
        </form>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>