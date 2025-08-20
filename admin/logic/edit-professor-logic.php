<?php
require '../../config/database.php';

if (!isset($_POST['submit'])) {
    header('Location: ' . ROOT_URL . 'admin/professor-list.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    $_SESSION['edit-professor-error'] = 'Invalid professor id.';
    header('Location: ' . ROOT_URL . 'admin/professor-list.php');
    exit;
}

$name            = trim(filter_var($_POST['name'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$country         = trim(filter_var($_POST['country'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$university_name = trim(filter_var($_POST['university_name'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$emailRaw        = trim((string)($_POST['contact_email'] ?? ''));
$contact_phone   = trim(filter_var($_POST['contact_phone'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$profileLinkRaw  = trim((string)($_POST['profileLink'] ?? ''));
$availability    = isset($_POST['availability']) ? 'available' : 'not available';
$riInput         = trim((string)($_POST['researchInterests'] ?? ''));
$image           = $_FILES['image'] ?? null;

$_SESSION['edit-professor-data'] = [
    'name'              => $name,
    'country'           => $country,
    'university_name'   => $university_name,
    'contact_email'     => $emailRaw,
    'contact_phone'     => $contact_phone,
    'profileLink'       => $profileLinkRaw,
    'availability'      => $availability,
    'researchInterests' => $riInput
];

if ($name === '') {
    $_SESSION['edit-professor-error'] = 'Please enter professor name.';
} elseif (!filter_var($emailRaw, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['edit-professor-error'] = 'Please enter a valid email address.';
} elseif ($profileLinkRaw !== '' && !filter_var($profileLinkRaw, FILTER_VALIDATE_URL)) {
    $_SESSION['edit-professor-error'] = 'Profile link must be a valid URL.';
}

$terms = [];
if (empty($_SESSION['edit-professor-error'])) {
    if ($riInput !== '' && preg_match('/^\s*\[.*\]\s*$/s', $riInput)) {
        $decoded = json_decode($riInput, true);
        if (is_array($decoded)) {
            foreach ($decoded as $it) {
                if (!is_string($it)) continue;
                $t = trim($it);
                if ($t !== '') $terms[] = $t;
            }
        } else {
            $_SESSION['edit-professor-error'] = 'Invalid JSON format for research interests.';
        }
    } else {
        $parts = preg_split('/,/', $riInput);
        foreach ($parts as $p) {
            $t = trim($p, " \t\n\r\0\x0B\"'");
            if ($t !== '') $terms[] = $t;
        }
    }
    $terms = array_values(array_unique(array_map(function ($s) {
        $s = trim($s);
        if (mb_strlen($s) > 255) $s = mb_substr($s, 0, 255);
        return $s;
    }, $terms), SORT_STRING));
}

if (empty($_SESSION['edit-professor-error']) && count($terms) === 0) {
    $_SESSION['edit-professor-error'] = 'Please provide at least one research interest.';
}

$current = null;
if (empty($_SESSION['edit-professor-error'])) {
    if ($stmt = mysqli_prepare($conn, "SELECT image FROM professors WHERE id = ?")) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $current = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);
    }
    if (!$current) {
        $_SESSION['edit-professor-error'] = 'Professor not found.';
    }
}

$imageRelName = $current ? (string)$current['image'] : '';
$imageAbsNew  = '';

if (empty($_SESSION['edit-professor-error']) && $image && !empty($image['name'])) {
    if (!is_array($image) || !isset($image['name'], $image['tmp_name'])) {
        $_SESSION['edit-professor-error'] = 'Invalid image upload.';
    } else {
        $allowed = ['png', 'jpg', 'jpeg', 'webp'];
        $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true)) {
            $_SESSION['edit-professor-error'] = 'Image must be PNG, JPG, JPEG, or WEBP.';
        } elseif (!is_uploaded_file($image['tmp_name'])) {
            $_SESSION['edit-professor-error'] = 'Invalid image upload.';
        } elseif ($image['size'] > 2_000_000) {
            $_SESSION['edit-professor-error'] = 'Image too large. Max size is 2MB.';
        } else {
            $uploadDirAbs = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
            if (!is_dir($uploadDirAbs)) {
                @mkdir($uploadDirAbs, 0775, true);
            }
            $time     = time();
            $safeBase = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($image['name']));
            $fileName = $time . '_' . $safeBase;

            $imageAbsNew  = $uploadDirAbs . $fileName;
            $imageRelName = $fileName;

            if (!move_uploaded_file($image['tmp_name'], $imageAbsNew)) {
                $_SESSION['edit-professor-error'] = 'Failed to save uploaded image.';
                $imageRelName = $current['image']; // revert to old
                $imageAbsNew  = '';
            }
        }
    }
}

if (!empty($_SESSION['edit-professor-error'])) {
    header('Location: ' . ROOT_URL . 'admin/edit-professor.php?id=' . $id);
    exit;
}

$email       = $emailRaw;
$profileLink = $profileLinkRaw === '' ? '' : $profileLinkRaw;

$sql = "UPDATE professors
        SET name = ?, country = ?, university_name = ?, contact_email = ?, contact_phone = ?, availability = ?, profileLink = ?, image = ?
        WHERE id = ?";

if (!($stmt = mysqli_prepare($conn, $sql))) {
    if ($imageAbsNew && file_exists($imageAbsNew)) @unlink($imageAbsNew);
    $_SESSION['edit-professor-error'] = 'Database error (prepare failed).';
    header('Location: ' . ROOT_URL . 'admin/edit-professor.php?id=' . $id);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    'ssssssssi',
    $name,
    $country,
    $university_name,
    $email,
    $contact_phone,
    $availability,
    $profileLink,
    $imageRelName,
    $id
);

$ok = mysqli_stmt_execute($stmt);
if (!$ok) {
    if ($imageAbsNew && file_exists($imageAbsNew)) @unlink($imageAbsNew);
    $_SESSION['edit-professor-error'] = 'Failed to update professor. (' . mysqli_error($conn) . ')';
    mysqli_stmt_close($stmt);
    header('Location: ' . ROOT_URL . 'admin/edit-professor.php?id=' . $id);
    exit;
}
mysqli_stmt_close($stmt);

if ($imageAbsNew && !empty($current['image'])) {
    $oldAbs = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . ltrim($current['image'], '/\\');
    if (is_file($oldAbs)) @unlink($oldAbs);
}

if ($stmt = mysqli_prepare($conn, "DELETE FROM professor_research_interests WHERE professor_id = ?")) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if (count($terms) > 0) {
    if ($stmt = mysqli_prepare($conn, "INSERT INTO professor_research_interests (professor_id, interest) VALUES (?, ?)")) {
        foreach ($terms as $t) {
            mysqli_stmt_bind_param($stmt, 'is', $id, $t);
        }
        mysqli_stmt_close($stmt);
    }
}

unset($_SESSION['edit-professor-data']);
$_SESSION['professor-success'] = 'Professor updated successfully.';
header('Location: ' . ROOT_URL . 'admin/professor-list.php');
exit;
