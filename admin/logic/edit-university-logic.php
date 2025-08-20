<?php
require '../../config/database.php';

if (!isset($_POST['submit'])) {
    header('location: ' . ROOT_URL . 'admin/university-list.php');
    exit;
}

$id            = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name          = trim(filter_var($_POST['name'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$location      = trim(filter_var($_POST['location'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$programType   = trim((string)($_POST['programType'] ?? ''));
$discipline    = trim(filter_var($_POST['discipline'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$admissionLink = trim((string)($_POST['admissionLink'] ?? ''));
$applicationDate       = trim((string)($_POST['applicationDate'] ?? ''));
$applicationDeadline   = trim((string)($_POST['applicationDeadline'] ?? ''));
$admitCardDownloadDate = trim((string)($_POST['admitCardDownloadDate'] ?? ''));
$existingImage = trim((string)($_POST['existing_image'] ?? ''));
$image         = $_FILES['image'] ?? null;

if ($id <= 0) {
    $_SESSION['university-error'] = 'Invalid university id.';
    header('location: ' . ROOT_URL . 'admin/university-list.php');
    exit;
}

$_SESSION['edit-university-data'] = [
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
    $_SESSION['edit-university-error'] = 'Please enter university name.';
} elseif ($location === '') {
    $_SESSION['edit-university-error'] = 'Please enter location.';
} elseif (!in_array($programType, ['undergraduate', 'postgraduate', 'Ph.D.'], true)) {
    $_SESSION['edit-university-error'] = 'Please select a valid program type.';
} elseif ($discipline === '') {
    $_SESSION['edit-university-error'] = 'Please enter discipline.';
} elseif ($admissionLink === '' || !filter_var($admissionLink, FILTER_VALIDATE_URL)) {
    $_SESSION['edit-university-error'] = 'Please provide a valid admission link (URL).';
}

$validDate = function ($d) {
    if ($d === '') return true;
    $dt = DateTime::createFromFormat('Y-m-d', $d);
    return $dt && $dt->format('Y-m-d') === $d;
};
if (empty($_SESSION['edit-university-error'])) {
    if (!$validDate($applicationDate) || !$validDate($applicationDeadline) || !$validDate($admitCardDownloadDate)) {
        $_SESSION['edit-university-error'] = 'Dates must be valid in YYYY-MM-DD format.';
    }
}

$uploadsDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
$newImageFile = '';

if (empty($_SESSION['edit-university-error']) && $image && !empty($image['name'])) {
    $allowedImg = ['png', 'jpg', 'jpeg', 'webp'];
    $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedImg, true)) {
        $_SESSION['edit-university-error'] = 'Image must be PNG, JPG, JPEG, or WEBP.';
    } elseif (!is_uploaded_file($image['tmp_name'])) {
        $_SESSION['edit-university-error'] = 'Invalid image upload.';
    } elseif ($image['size'] > 2_000_000) {
        $_SESSION['edit-university-error'] = 'Image too large. Max size is 2MB.';
    } else {
        if (!is_dir($uploadsDir)) {
            @mkdir($uploadsDir, 0775, true);
        }
        $time = time();
        $safe = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($image['name']));
        $newImageFile = $time . '_' . $safe;
        if (!move_uploaded_file($image['tmp_name'], $uploadsDir . $newImageFile)) {
            $_SESSION['edit-university-error'] = 'Failed to save new image.';
            $newImageFile = '';
        }
    }
}

if (!empty($_SESSION['edit-university-error'])) {
    if ($newImageFile && is_file($uploadsDir . $newImageFile)) @unlink($uploadsDir . $newImageFile);
    header('location: ' . ROOT_URL . 'admin/edit-university.php?id=' . $id);
    exit;
}

$cols   = [
    'name = ?',
    'location = ?',
    'programType = ?',
    'discipline = ?',
    'admissionLink = ?'
];
$types  = 'sssss';
$params = [$name, $location, $programType, $discipline, $admissionLink];

$cols[] = 'applicationDate = '      . ($applicationDate       === '' ? 'NULL' : '?');
if ($applicationDate !== '') {
    $types .= 's';
    $params[] = $applicationDate;
}

$cols[] = 'applicationDeadline = '  . ($applicationDeadline   === '' ? 'NULL' : '?');
if ($applicationDeadline !== '') {
    $types .= 's';
    $params[] = $applicationDeadline;
}

$cols[] = 'admitCardDownloadDate = ' . ($admitCardDownloadDate === '' ? 'NULL' : '?');
if ($admitCardDownloadDate !== '') {
    $types .= 's';
    $params[] = $admitCardDownloadDate;
}

if ($newImageFile !== '') {
    $cols[]  = 'image = ?';
    $types  .= 's';
    $params[] = $newImageFile;
}

$types  .= 'i';
$params[] = $id;

$sql = "UPDATE universities SET " . implode(', ', $cols) . " WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    if ($newImageFile && is_file($uploadsDir . $newImageFile)) @unlink($uploadsDir . $newImageFile);
    $_SESSION['edit-university-error'] = 'Database error (prepare failed).';
    header('location: ' . ROOT_URL . 'admin/edit-university.php?id=' . $id);
    exit;
}

mysqli_stmt_bind_param($stmt, $types, ...$params);
$ok = mysqli_stmt_execute($stmt);
if (!$ok) {
    if ($newImageFile && is_file($uploadsDir . $newImageFile)) @unlink($uploadsDir . $newImageFile);
    $_SESSION['edit-university-error'] = 'Failed to update university. (' . mysqli_error($conn) . ')';
    mysqli_stmt_close($stmt);
    header('location: ' . ROOT_URL . 'admin/edit-university.php?id=' . $id);
    exit;
}
mysqli_stmt_close($stmt);

if ($newImageFile !== '' && $existingImage !== '') {
    $oldAbs = $uploadsDir . ltrim($existingImage, '/\\');
    if (is_file($oldAbs)) {
        @unlink($oldAbs);
    }
}

unset($_SESSION['edit-university-data']);
$_SESSION['edit-university-success'] = 'University updated successfully.';
header('location: ' . ROOT_URL . 'admin/university-list.php');
exit;
