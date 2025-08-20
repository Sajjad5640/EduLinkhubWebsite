<?php
session_start();

// Database connection
$db = mysqli_connect('localhost', 'kabir', 'admin', 'edulinkhub');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Status</title>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Compare plain text passwords (replace with password_verify later for security)
        if ($password === $user['password']) {
            
            // Check role
            if ($user['role'] === 'user') {
                // ✅ Allow login
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['email']     = $user['email'];
                $_SESSION['full_name'] = $user['name'];
                $_SESSION['role']      = $user['role'];
                
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                      <script>
                          Swal.fire({
                              title: 'Login Successful!',
                              text: 'Welcome back, " . addslashes($user['name']) . "',
                              icon: 'success',
                              showClass: { popup: 'animate__animated animate__bounceInDown' },
                              timer: 2000,
                              timerProgressBar: true,
                              willClose: () => {
                                  window.location.href = 'index1.php';
                              }
                          });
                      </script>";
                exit();
            } else {
                // ❌ Deny if role = admin
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                      <script>
                          Swal.fire({
                              title: 'Access Denied',
                              text: 'Admin accounts are not allowed to log in here',
                              icon: 'warning',
                              showClass: { popup: 'animate__animated animate__shakeX' },
                              background: 'linear-gradient(135deg, #f7971e 0%, #ffd200 100%)',
                              confirmButtonColor: '#e67e22'
                          }).then(() => {
                              window.location.href = 'login.php';
                          });
                      </script>";
                exit();
            }
        }
    }

    // Invalid email/password
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
              Swal.fire({
                  title: 'Login Failed',
                  text: 'Invalid email or password',
                  icon: 'error',
                  showClass: { popup: 'animate__animated animate__headShake' },
                  background: 'linear-gradient(135deg, #f85032 0%, #e73827 100%)',
                  confirmButtonColor: '#e74c3c'
              }).then(() => {
                  window.location.href = 'login.php';
              });
          </script>";
    exit();
}

echo '</body></html>';
?>
