<?php
require '../../config/database.php';

if (!isset($_POST['submit'])) {
    header('location: ' . ROOT_URL . 'admin/scholarship-list.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    $_SESSION['edit-scholarship-error'] = 'Invalid scholarship ID.';
    header('location: ' . ROOT_URL . 'admin/scholarship-list.php');
    exit;
}

$type         = strtolower(trim((string)($_POST['type'] ?? '')));
$title        = trim(filter_var($_POST['title'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$description  = trim(filter_var($_POST['description'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$link         = trim((string)($_POST['link'] ?? ''));
$eligibility  = trim(filter_var($_POST['eligibilityCriteria'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$applyDate    = trim((string)($_POST['applyDate'] ?? ''));
$deadline     = trim((string)($_POST['applicationDeadline'] ?? ''));

$university   = trim(filter_var($_POST['university'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$department   = trim(filter_var($_POST['department'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$professor_id = isset($_POST['professor_id']) && $_POST['professor_id'] !== '' ? (int)$_POST['professor_id'] : null;

$_SESSION['edit-scholarship-data'] = [
    'type' => $type,
    'title' => $title,
    'description' => $description,
    'link' => $link,
    'eligibilityCriteria' => $eligibility,
    'applyDate' => $applyDate,
    'applicationDeadline' => $deadline,
    'university' => $university,
    'department' => $department,
    'professor_id' => $professor_id
];

if (!in_array($type, ['university', 'professor'], true)) {
    $_SESSION['edit-scholarship-error'] = 'Please select a valid type (University or Professor).';
} elseif ($title === '') {
    $_SESSION['edit-scholarship-error'] = 'Please enter a title.';
} elseif ($link === '' || !filter_var($link, FILTER_VALIDATE_URL)) {
    $_SESSION['edit-scholarship-error'] = 'Please provide a valid official link (URL).';
} else {
    if ($type === 'university') {
        if ($university === '' || $department === '') {
            $_SESSION['edit-scholarship-error'] = 'University and Department are required for University-type scholarships.';
        }
        $professor_id = null;
    } else {
        if (!$professor_id || $professor_id <= 0) {
            $_SESSION['edit-scholarship-error'] = 'Please select a valid professor.';
        }
        $university = '';
        $department = '';
    }
}

$validDate = function ($d) {
    if ($d === '') return true;
    $dt = DateTime::createFromFormat('Y-m-d', $d);
    return $dt && $dt->format('Y-m-d') === $d;
};
if (empty($_SESSION['edit-scholarship-error'])) {
    if (!$validDate($applyDate) || !$validDate($deadline)) {
        $_SESSION['edit-scholarship-error'] = 'Dates must be valid in YYYY-MM-DD format.';
    }
}

if (!empty($_SESSION['edit-scholarship-error'])) {
    header('location: ' . ROOT_URL . 'admin/edit-scholarship.php?id=' . $id);
    exit;
}

$sets   = [];
$typesS = '';
$params = [];

$sets[] = "type = ?";
$typesS .= 's';
$params[] = $type;

$sets[] = "title = ?";
$typesS .= 's';
$params[] = $title;

$sets[] = "description = ?";
$typesS .= 's';
$params[] = $description;

$sets[] = "link = ?";
$typesS .= 's';
$params[] = $link;

$sets[] = "eligibilityCriteria = ?";
$typesS .= 's';
$params[] = $eligibility;

if ($applyDate === '') {
    $sets[] = "applyDate = NULL";
} else {
    $sets[] = "applyDate = ?";
    $typesS .= 's';
    $params[] = $applyDate;
}

if ($deadline === '') {
    $sets[] = "applicationDeadline = NULL";
} else {
    $sets[] = "applicationDeadline = ?";
    $typesS .= 's';
    $params[] = $deadline;
}

if ($university === '') {
    $sets[] = "university = NULL";
} else {
    $sets[] = "university = ?";
    $typesS .= 's';
    $params[] = $university;
}

if ($department === '') {
    $sets[] = "department = NULL";
} else {
    $sets[] = "department = ?";
    $typesS .= 's';
    $params[] = $department;
}

if (empty($professor_id)) {
    $sets[] = "professor_id = NULL";
} else {
    $sets[] = "professor_id = ?";
    $typesS .= 'i';
    $params[] = $professor_id;
}

$sql = "UPDATE fundings SET " . implode(', ', $sets) . " WHERE id = ?";
$typesS .= 'i';
$params[] = $id;

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    $_SESSION['edit-scholarship-error'] = 'Database error (prepare failed).';
    header('location: ' . ROOT_URL . 'admin/edit-scholarship.php?id=' . $id);
    exit;
}

mysqli_stmt_bind_param($stmt, $typesS, ...$params);

$ok = mysqli_stmt_execute($stmt);
if (!$ok) {
    $_SESSION['edit-scholarship-error'] = 'Failed to update scholarship. (' . mysqli_error($conn) . ')';
    mysqli_stmt_close($stmt);
    header('location: ' . ROOT_URL . 'admin/edit-scholarship.php?id=' . $id);
    exit;
}

mysqli_stmt_close($stmt);

unset($_SESSION['edit-scholarship-data']);
$_SESSION['funding-success'] = 'Scholarship updated successfully.';
header('location: ' . ROOT_URL . 'admin/scholarship-list.php');
exit;
