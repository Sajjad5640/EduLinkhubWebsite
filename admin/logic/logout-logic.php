<?php
require '../../config/database.php';
session_start();

$_SESSION = array();


session_destroy();

header("Location: " . ROOT_URL . "admin/signin.php");
exit();
