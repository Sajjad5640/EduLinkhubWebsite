<?php
require '../../config/database.php';

if (!isset($_POST['submit'])) {
    header('location: ' . ROOT_URL . 'admin/add-professor.php');
    exit;
}

$name             = trim(filter_var($_POST['name'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$country          = trim(filter_var($_POST['country'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$university_name  = trim(filter_var($_POST['university_name'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$researchInput    = trim((string)($_POST['researchInterests'] ?? ''));
$emailRaw         = trim((string)($_POST['contact_email'] ?? ''));
$contact_phone    = trim(filter_var($_POST['contact_phone'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$profileLinkRaw   = trim((string)($_POST['profileLink'] ?? ''));
$availability     = isset($_POST['availability']) ? 'available' : 'not available';
$image            = $_FILES['image'] ?? null;

$_SESSION['add-professor-data'] = [
    'name'              => $name,
    'country'           => $country,
    'university_name'   => $university_name,
    'researchInterests' => $researchInput,
    'contact_email'     => $emailRaw,
    'contact_phone'     => $contact_phone,
    'profileLink'       => $profileLinkRaw,
    'availability'      => $availability
];

if ($name === '') {
    $_SESSION['add-professor-error'] = 'Please enter professor name.';
} elseif (!filter_var($emailRaw, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['add-professor-error'] = 'Please enter a valid email address.';
} elseif ($profileLinkRaw !== '' && !filter_var($profileLinkRaw, FILTER_VALIDATE_URL)) {
    $_SESSION['add-professor-error'] = 'Profile link must be a valid URL.';
}

$interests = [];
if ($researchInput !== '') {
    if (preg_match('/^\s*\[.*\]\s*$/s', $researchInput)) {
        $decoded = json_decode($researchInput, true);
        if (is_array($decoded)) {
            foreach ($decoded as $it) {
                if (is_string($it)) {
                    $t = trim($it, " \t\n\r\0\x0B\"'");
                    if ($t !== '') $interests[] = $t;
                }
            }
        } else {
            $_SESSION['add-professor-error'] = 'Invalid JSON format for research interests.';
        }
    } else {
        $parts = preg_split('/,/', $researchInput);
        if (is_array($parts)) {
            foreach ($parts as $p) {
                $t = trim($p, " \t\n\r\0\x0B\"'");
                if ($t !== '') $interests[] = $t;
            }
        }
    }
    $interests = array_values(array_unique($interests, SORT_STRING));
    if (count($interests) > 50) $interests = array_slice($interests, 0, 50);
}

$imageRelPath = '';
$imageAbsPath = '';

if (empty($_SESSION['add-professor-error']) && $image && !empty($image['name'])) {
    if (!is_array($image) || !isset($image['name'], $image['tmp_name'])) {
        $_SESSION['add-professor-error'] = 'Invalid image upload.';
    } else {
        $allowed = ['png', 'jpg', 'jpeg', 'webp'];
        $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed, true)) {
            $_SESSION['add-professor-error'] = 'Image must be PNG, JPG, JPEG, or WEBP.';
        } elseif (!is_uploaded_file($image['tmp_name'])) {
            $_SESSION['add-professor-error'] = 'Invalid image upload.';
        } elseif ($image['size'] > 2_000_000) {
            $_SESSION['add-professor-error'] = 'Image too large. Max size is 2MB.';
        } else {
            $uploadDirAbs = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
            if (!is_dir($uploadDirAbs)) {
                @mkdir($uploadDirAbs, 0775, true);
            }

            $time     = time();
            $safeBase = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($image['name']));
            $fileName = $time . '_' . $safeBase;

            $imageAbsPath = $uploadDirAbs . $fileName;
            $imageRelPath = $fileName;

            if (!move_uploaded_file($image['tmp_name'], $imageAbsPath)) {
                $_SESSION['add-professor-error'] = 'Failed to save uploaded image.';
                $imageRelPath = '';
                $imageAbsPath = '';
            }
        }
    }
}

if (!empty($_SESSION['add-professor-error'])) {
    header('location: ' . ROOT_URL . 'admin/add-professor.php');
    exit;
}

$email       = $emailRaw;
$profileLink = $profileLinkRaw === '' ? '' : $profileLinkRaw;

$sql = "INSERT INTO professors
        (name, country, university_name, image, contact_email, contact_phone, availability, profileLink)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    if ($imageAbsPath && file_exists($imageAbsPath)) @unlink($imageAbsPath);
    $_SESSION['add-professor-error'] = 'Database error (prepare failed).';
    header('location: ' . ROOT_URL . 'admin/add-professor.php');
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    'ssssssss',
    $name,
    $country,
    $university_name,
    $imageRelPath,
    $email,
    $contact_phone,
    $availability,
    $profileLink
);

$ok = mysqli_stmt_execute($stmt);
if (!$ok) {
    if ($imageAbsPath && file_exists($imageAbsPath)) @unlink($imageAbsPath);
    $_SESSION['add-professor-error'] = 'Failed to add professor. (' . mysqli_error($conn) . ')';
    mysqli_stmt_close($stmt);
    header('location: ' . ROOT_URL . 'admin/add-professor.php');
    exit;
}
$professor_id = mysqli_insert_id($conn);
mysqli_stmt_close($stmt);

if ($professor_id && count($interests) > 0) {
    $sqlI = "INSERT INTO professor_research_interests (professor_id, interest) VALUES (?, ?)";
    if ($stmtI = mysqli_prepare($conn, $sqlI)) {
        foreach ($interests as $interest) {
            $interest = mb_substr($interest, 0, 255);
            mysqli_stmt_bind_param($stmtI, 'is', $professor_id, $interest);
            if (!mysqli_stmt_execute($stmtI)) {
                $_SESSION['add-professor-error'] = 'Professor added, but one or more interests could not be saved.';
            }
        }
        mysqli_stmt_close($stmtI);
    } else {
        $_SESSION['add-professor-error'] = 'Professor added, but interests insert failed (prepare error).';
    }
}

unset($_SESSION['add-professor-data']);
if (empty($_SESSION['add-professor-error'])) {
    $_SESSION['add-professor-success'] = 'Professor added successfully.';
}
header('location: ' . ROOT_URL . 'admin/professor-list.php');
exit;
