<?php

if (empty($_SESSION['admin_id']) || empty($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: " . ROOT_URL . "admin/signin.php");
    exit();
}
