<?php
require '../../config/database.php';

if (!isset($_POST['submit'])) {
    header('location: ' . ROOT_URL . 'admin/add-university.php');
    exit;
}

$name        = trim(filter_var($_POST['name']        ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$location    = trim(filter_var($_POST['location']    ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$programType = trim((string)($_POST['programType']   ?? ''));
$discipline  = trim(filter_var($_POST['discipline']  ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$admissionLink = trim((string)($_POST['admissionLink'] ?? ''));

$applicationDate        = trim((string)($_POST['applicationDate']        ?? ''));
$applicationDeadline    = trim((string)($_POST['applicationDeadline']    ?? ''));
$admitCardDownloadDate  = trim((string)($_POST['admitCardDownloadDate']  ?? ''));

$image = $_FILES['image'] ?? null;

$_SESSION['add-university-data'] = [
    'name'                   => $name,
    'location'               => $location,
    'programType'            => $programType,
    'discipline'             => $discipline,
    'admissionLink'          => $admissionLink,
    'applicationDate'        => $applicationDate,
    'applicationDeadline'    => $applicationDeadline,
    'admitCardDownloadDate'  => $admitCardDownloadDate,
];

if ($name === '') {
    $_SESSION['add-university-error'] = 'Please enter university name.';
} elseif ($location === '') {
    $_SESSION['add-university-error'] = 'Please enter location.';
} elseif (!in_array($programType, ['undergraduate', 'postgraduate', 'Ph.D.'], true)) {
    $_SESSION['add-university-error'] = 'Please select a valid program type.';
} elseif ($discipline === '') {
    $_SESSION['add-university-error'] = 'Please enter discipline.';
} elseif ($admissionLink === '' || !filter_var($admissionLink, FILTER_VALIDATE_URL)) {
    $_SESSION['add-university-error'] = 'Please provide a valid admission link (URL).';
}

$validDate = function ($d) {
    if ($d === '') return true;
    $dt = DateTime::createFromFormat('Y-m-d', $d);
    return $dt && $dt->format('Y-m-d') === $d;
};
if (empty($_SESSION['add-university-error'])) {
    if (!$validDate($applicationDate) || !$validDate($applicationDeadline) || !$validDate($admitCardDownloadDate)) {
        $_SESSION['add-university-error'] = 'Dates must be valid in YYYY-MM-DD format.';
    }
}

$imageFileName = '';
$uploadsDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;

if (empty($_SESSION['add-university-error']) && $image && !empty($image['name'])) {
    $allowedImg = ['png', 'jpg', 'jpeg', 'webp'];
    $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedImg, true)) {
        $_SESSION['add-university-error'] = 'Image must be PNG, JPG, JPEG, or WEBP.';
    } elseif (!is_uploaded_file($image['tmp_name'])) {
        $_SESSION['add-university-error'] = 'Invalid image upload.';
    } elseif ($image['size'] > 2_000_000) {
        $_SESSION['add-university-error'] = 'Image too large. Max size is 2MB.';
    } else {
        if (!is_dir($uploadsDir)) {
            @mkdir($uploadsDir, 0775, true);
        }
        $time = time();
        $safe = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($image['name']));
        $imageFileName = $time . '_' . $safe;
        if (!move_uploaded_file($image['tmp_name'], $uploadsDir . $imageFileName)) {
            $_SESSION['add-university-error'] = 'Failed to save uploaded image.';
            $imageFileName = '';
        }
    }
}

if (!empty($_SESSION['add-university-error'])) {
    if ($imageFileName && is_file($uploadsDir . $imageFileName)) @unlink($uploadsDir . $imageFileName);
    header('location: ' . ROOT_URL . 'admin/add-university.php');
    exit;
}

$cols   = ['name', 'location', 'programType', 'discipline', 'admissionLink'];
$place  = ['?', '?', '?', '?', '?'];
$types  = 'sssss';
$params = [$name, $location, $programType, $discipline, $admissionLink];

$cols[] = 'applicationDate';
if ($applicationDate === '') {
    $place[] = 'NULL';
} else {
    $place[] = '?';
    $types  .= 's';
    $params[] = $applicationDate;
}

$cols[] = 'applicationDeadline';
if ($applicationDeadline === '') {
    $place[] = 'NULL';
} else {
    $place[] = '?';
    $types  .= 's';
    $params[] = $applicationDeadline;
}

$cols[] = 'admitCardDownloadDate';
if ($admitCardDownloadDate === '') {
    $place[] = 'NULL';
} else {
    $place[] = '?';
    $types  .= 's';
    $params[] = $admitCardDownloadDate;
}

$cols[] = 'image';
if ($imageFileName === '') {
    $place[] = 'NULL';
} else {
    $place[]  = '?';
    $types   .= 's';
    $params[] = $imageFileName;
}

$sql = "INSERT INTO universities (" . implode(',', $cols) . ") VALUES (" . implode(',', $place) . ")";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    if ($imageFileName && is_file($uploadsDir . $imageFileName)) @unlink($uploadsDir . $imageFileName);
    $_SESSION['add-university-error'] = 'Database error (prepare failed).';
    header('location: ' . ROOT_URL . 'admin/add-university.php');
    exit;
}

if ($types !== '') {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

$ok = mysqli_stmt_execute($stmt);
if (!$ok) {
    if ($imageFileName && is_file($uploadsDir . $imageFileName)) @unlink($uploadsDir . $imageFileName);
    $_SESSION['add-university-error'] = 'Failed to add university. (' . mysqli_error($conn) . ')';
    mysqli_stmt_close($stmt);
    header('location: ' . ROOT_URL . 'admin/add-university.php');
    exit;
}

mysqli_stmt_close($stmt);

unset($_SESSION['add-university-data']);
$_SESSION['add-university-success'] = 'University added successfully.';
header('location: ' . ROOT_URL . 'admin/university-list.php');
exit;
