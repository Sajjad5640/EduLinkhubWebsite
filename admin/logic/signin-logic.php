<?php

require '../../config/database.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required.";
        header("Location: " . ROOT_URL . "admin/signin.php");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: " . ROOT_URL . "admin/signin.php");
        exit();
    }

    try {
        $sql = "SELECT id, name, email, password, role FROM users WHERE email = ? AND role = 'admin'";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if ($password == $user['password']) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_name'] = $user['name'];
                $_SESSION['admin_email'] = $user['email'];
                $_SESSION['admin_role'] = $user['role'];
                $_SESSION['logged_in'] = true;

                session_regenerate_id(true);

                $_SESSION['success'] = "Login successful! Welcome back, " . $user['name'] . ".";
                header("Location: " . ROOT_URL . "admin/index.php");
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password.";
                header("Location: " . ROOT_URL . "admin/signin.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: " . ROOT_URL . "admin/signin.php");
            exit();
        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: " . ROOT_URL . "admin/signin.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: " . ROOT_URL . "admin/signin.php");
    exit();
}
