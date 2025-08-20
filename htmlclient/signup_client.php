<?php
$db = mysqli_connect('localhost', 'kabir', 'admin', 'edulinkhub');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

// Start HTML output with SweetAlert2 dependencies
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Status</title>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Animate.css for additional animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .swal2-popup {
            border-radius: 16px !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2) !important;
        }
        .swal2-success {
            position: relative;
        }
        .swal2-success::before {
            content: "";
            position: absolute;
            width: 80px;
            height: 80px;
            background: rgba(72, 219, 113, 0.2);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.8); opacity: 0.5; }
            70% { transform: scale(1.1); opacity: 0.1; }
            100% { transform: scale(0.8); opacity: 0; }
        }
    </style>
</head>
<body>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name     = trim(mysqli_real_escape_string($db, $_POST['full_name']));
    $gender        = trim(mysqli_real_escape_string($db, $_POST['gender']));
    $qualification = trim(mysqli_real_escape_string($db, $_POST['qualification']));
    $institute     = trim(mysqli_real_escape_string($db, $_POST['institute']));
    $email         = strtolower(trim(mysqli_real_escape_string($db, $_POST['email'])));
    $password      = mysqli_real_escape_string($db, $_POST['password']);
    $confirm_pass  = mysqli_real_escape_string($db, $_POST['confirm_password']);

    $errors = [];

    // Validation (same as before)
    if ($full_name === '' || $gender === '' || $qualification === '' || $institute === '' || $email === '' || $password === '' || $confirm_pass === '') {
        $errors[] = "All fields are required";
    }

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address";
    }

    if ($password !== $confirm_pass) {
        $errors[] = "Passwords do not match";
    }

    if (!empty($password)) {
        if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters long";
        if (!preg_match("#[A-Z]+#", $password)) $errors[] = "Password must contain at least one uppercase letter";
        if (!preg_match("#[0-9]+#", $password)) $errors[] = "Password must contain at least one number";
        if (!preg_match("#[^A-Za-z0-9]+#", $password)) $errors[] = "Password must contain at least one special character";
    }

    // Check if email exists (without closing the statement too early)
    $email_exists = false;
    if ($email !== '' && empty($errors)) {
        $check_stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        if ($check_stmt) {
            $check_stmt->bind_param("s", $email);
            if ($check_stmt->execute()) {
                $check_stmt->store_result();
                if ($check_stmt->num_rows > 0) {
                    $errors[] = "Email already registered";
                    $email_exists = true;
                }
            }
            $check_stmt->close();
        }
    }

    if (!empty($errors)) {
        $error_message = implode("\\n", $errors);
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  Swal.fire({
                      title: 'Registration Error',
                      text: '".addslashes($error_message)."',
                      icon: 'error',
                      showClass: {
                          popup: 'animate__animated animate__headShake'
                      },
                      background: '#ffebee',
                      confirmButtonColor: '#f44336'
                  }).then(() => {
                      window.location.href = 'login.php';
                  });
              </script>";
    } else {
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_stmt = $db->prepare("INSERT INTO users (name, gender, qualification, institute, email, password) VALUES (?, ?, ?, ?, ?, ?)");
        
        if ($insert_stmt) {
            $insert_stmt->bind_param("ssssss", $full_name, $gender, $qualification, $institute, $email, $password);
            
            if ($insert_stmt->execute()) {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                      <script>
                          Swal.fire({
                              title: 'Success!',
                              text: 'Registration completed successfully',
                              icon: 'success',
                              showClass: {
                                  popup: 'animate__animated animate__bounceIn'
                              },
                              background: 'linear-gradient(to right, #a1ffce, #faffd1)',
                              timer: 3000,
                              timerProgressBar: true,
                              willClose: () => {
                                  window.location.href = 'login.php';
                              }
                          });
                      </script>";
            } else {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                      <script>
                          Swal.fire({
                              title: 'Database Error',
                              text: 'Registration failed: ".addslashes($insert_stmt->error)."',
                              icon: 'error',
                              showClass: {
                                  popup: 'animate__animated animate__wobble'
                              }
                          }).then(() => {
                              window.location.href = 'login.php';
                          });
                      </script>";
            }
            $insert_stmt->close();
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                  <script>
                      Swal.fire({
                          title: 'Database Error',
                          text: 'Failed to prepare statement',
                          icon: 'error'
                      }).then(() => {
                          window.location.href = 'login.php';
                      });
                  </script>";
        }
    }
}

echo '</body></html>';
?>