<?php
require '../../config/database.php';

if (!isset($_POST['submit'])) {
    header('location: ' . ROOT_URL . 'admin/book-list.php');
    exit;
}

$id            = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$title         = trim(filter_var($_POST['title']  ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$author        = trim(filter_var($_POST['author'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$category      = trim((string)($_POST['category'] ?? ''));
$description   = trim((string)($_POST['description'] ?? ''));
$suggestedRaw  = trim((string)($_POST['suggestedFor'] ?? ''));
$pdf       = trim((string)($_POST['pdfLink'] ?? ''));
$isPaid        = isset($_POST['isPaid']) ? 1 : 0;
$priceInput    = trim((string)($_POST['price'] ?? ''));
$existingImage = trim((string)($_POST['existing_image'] ?? ''));
$image         = $_FILES['image'] ?? null;

if ($id <= 0) {
    $_SESSION['book-error'] = 'Invalid book id.';
    header('location: ' . ROOT_URL . 'admin/book-list.php');
    exit;
}

$_SESSION['edit-book-data'] = [
    'title'        => $title,
    'author'       => $author,
    'category'     => $category,
    'description'  => $description,
    'suggestedFor' => $suggestedRaw,
    'pdf'      => $pdf,
    'isPaid'       => $isPaid,
    'price'        => $priceInput,
];

if ($title === '') {
    $_SESSION['edit-book-error'] = 'Please enter the book title.';
} elseif ($author === '') {
    $_SESSION['edit-book-error'] = 'Please enter the author name.';
} elseif (!in_array($category, ['Admission', 'Job Exam', 'Skill-Based'], true)) {
    $_SESSION['edit-book-error'] = 'Please select a valid category.';
} elseif ($pdf !== '' && !filter_var($pdf, FILTER_VALIDATE_URL)) {
    $_SESSION['edit-book-error'] = 'Please provide a valid PDF link (URL).';
} elseif ($isPaid && ($priceInput === '' || !is_numeric($priceInput) || (float)$priceInput <= 0)) {
    $_SESSION['edit-book-error'] = 'Please provide a valid price for paid books.';
}

$suggestedForJson = null;
if (empty($_SESSION['edit-book-error'])) {
    if ($suggestedRaw === '') {
        $_SESSION['edit-book-error'] = '“Suggested For” is required. Enter a comma-separated list or a JSON array.';
    } else {
        $list = [];

        if (preg_match('/^\s*\[.*\]\s*$/s', $suggestedRaw)) {
            $decoded = json_decode($suggestedRaw, true);
            if (is_array($decoded)) {
                foreach ($decoded as $it) {
                    if (is_string($it)) {
                        $t = trim($it);
                        if ($t !== '') $list[] = $t;
                    }
                }
            } else {
                $_SESSION['edit-book-error'] = 'Invalid JSON in “Suggested For”. Use an array of strings.';
            }
        } else {
            $parts = preg_split('/[\r\n,]+/', $suggestedRaw);
            foreach ($parts as $p) {
                $t = trim($p, " \t\n\r\0\x0B\"'");
                if ($t !== '') $list[] = $t;
            }
        }

        if (empty($_SESSION['edit-book-error'])) {
            $list = array_values(array_unique($list, SORT_STRING));
            if (count($list) === 0) {
                $_SESSION['edit-book-error'] = '“Suggested For” must include at least one item.';
            } else {
                $suggestedForJson = json_encode($list, JSON_UNESCAPED_UNICODE);
                if ($suggestedForJson === false) {
                    $_SESSION['edit-book-error'] = 'Failed to encode “Suggested For”.';
                }
            }
        }
    }
}

$uploadsDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
$newImageFile = '';

if (empty($_SESSION['edit-book-error']) && $image && !empty($image['name'])) {
    $allowedImg = ['png', 'jpg', 'jpeg', 'webp'];
    $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedImg, true)) {
        $_SESSION['edit-book-error'] = 'Image must be PNG, JPG, JPEG, or WEBP.';
    } elseif (!is_uploaded_file($image['tmp_name'])) {
        $_SESSION['edit-book-error'] = 'Invalid image upload.';
    } elseif ($image['size'] > 2_000_000) {
        $_SESSION['edit-book-error'] = 'Image too large. Max size is 2MB.';
    } else {
        if (!is_dir($uploadsDir)) {
            @mkdir($uploadsDir, 0775, true);
        }
        $time = time();
        $safe = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($image['name']));
        $newImageFile = $time . '_' . $safe;
        if (!move_uploaded_file($image['tmp_name'], $uploadsDir . $newImageFile)) {
            $_SESSION['edit-book-error'] = 'Failed to save new cover image.';
            $newImageFile = '';
        }
    }
}

if (!empty($_SESSION['edit-book-error'])) {
    if ($newImageFile && is_file($uploadsDir . $newImageFile)) @unlink($uploadsDir . $newImageFile);
    header('location: ' . ROOT_URL . 'admin/edit-book.php?id=' . $id);
    exit;
}

$price = null;
if ($isPaid) {
    $price = (float)$priceInput;
} else {
    $isPaid = 0;
}

$pdfForDb = ($pdf === '') ? null : $pdf;

$cols   = [
    'title = ?',
    'author = ?',
    'category = ?',
    'description = ?',
    'pdf = ' . ($pdfForDb === null ? 'NULL' : '?'),
    'suggestedFor = ?',
    'isPaid = ?',
    'price = ' . ($price === null ? 'NULL' : '?'),
];

$types  = 'ssss';
$params = [$title, $author, $category, $description];

if ($pdfForDb !== null) {
    $types  .= 's';
    $params[] = $pdfForDb;
}
$types  .= 's';
$params[] = $suggestedForJson;

$types  .= 'i';
$params[] = $isPaid;

if ($price !== null) {
    $types  .= 'd';
    $params[] = $price;
}

if ($newImageFile !== '') {
    $cols[]  = 'image = ?';
    $types  .= 's';
    $params[] = $newImageFile;
}

$types  .= 'i';
$params[] = $id;

$sql = "UPDATE books SET " . implode(', ', $cols) . " WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    if ($newImageFile && is_file($uploadsDir . $newImageFile)) @unlink($uploadsDir . $newImageFile);
    $_SESSION['edit-book-error'] = 'Database error (prepare failed).';
    header('location: ' . ROOT_URL . 'admin/edit-book.php?id=' . $id);
    exit;
}

mysqli_stmt_bind_param($stmt, $types, ...$params);
$ok = mysqli_stmt_execute($stmt);
if (!$ok) {
    if ($newImageFile && is_file($uploadsDir . $newImageFile)) @unlink($uploadsDir . $newImageFile);
    $_SESSION['edit-book-error'] = 'Failed to update book. (' . mysqli_error($conn) . ')';
    mysqli_stmt_close($stmt);
    header('location: ' . ROOT_URL . 'admin/edit-book.php?id=' . $id);
    exit;
}

mysqli_stmt_close($stmt);

if ($newImageFile !== '' && $existingImage !== '') {
    $oldAbs = $uploadsDir . ltrim($existingImage, '/\\');
    if (is_file($oldAbs)) {
        @unlink($oldAbs);
    }
}

unset($_SESSION['edit-book-data']);
$_SESSION['edit-book-success'] = 'Book updated successfully.';
header('location: ' . ROOT_URL . 'admin/book-list.php');
exit;
