<?php
require '../config/database.php';
require __DIR__ . '/auth-check.php';

$active_page = 'book-list';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    $_SESSION['book-error'] = 'Invalid book id.';
    header('Location: book-list.php');
    exit;
}

$book = null;
if ($stmt = mysqli_prepare($conn, "SELECT id, title, image, author, category, description, pdf, suggestedFor, isPaid, price FROM books WHERE id = ?")) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $book = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);
}

if (!$book) {
    $_SESSION['book-error'] = 'Book not found.';
    header('Location: book-list.php');
    exit;
}

$old = $_SESSION['edit-book-data'] ?? [];
unset($_SESSION['edit-book-data']);

function old_or($key, $fallback)
{
    return isset($_SESSION['__old'][$key]) ? $_SESSION['__old'][$key] : $fallback;
}

$_SESSION['__old'] = $old;

$title        = isset($old['title'])        ? $old['title']        : ($book['title'] ?? '');
$author       = isset($old['author'])       ? $old['author']       : ($book['author'] ?? '');
$category     = isset($old['category'])     ? $old['category']     : ($book['category'] ?? '');
$description  = isset($old['description'])  ? $old['description']  : ($book['description'] ?? '');
$pdf      = isset($old['pdf'])      ? $old['pdf']      : ($book['pdf'] ?? '');
$isPaidOld    = isset($old['isPaid'])       ? (int)$old['isPaid']  : (int)($book['isPaid'] ?? 0);
$price        = isset($old['price'])        ? $old['price']        : ($book['price'] ?? '');
$imageName    = $book['image'] ?? '';

$suggestedForRaw = '';
if (isset($old['suggestedFor'])) {
    $suggestedForRaw = $old['suggestedFor'];
} else {
    $sf = $book['suggestedFor'];
    if ($sf !== null && $sf !== '') {
        $arr = json_decode($sf, true);
        if (is_array($arr)) {
            $clean = array_values(array_filter(array_map(function ($s) {
                return is_string($s) ? trim($s) : '';
            }, $arr), fn($v) => $v !== ''));
            $suggestedForRaw = implode(', ', $clean);
        } else {
            $suggestedForRaw = (string)$sf;
        }
    }
}

unset($_SESSION['__old']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Book - EduLink Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="styles/add-book.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include __DIR__ . '/common/sidebar.php'; ?>

    <main class="main-content">
        <?php include __DIR__ . '/common/navbar.php'; ?>

        <div class="content">
            <h1 class="page-title"><i class="fa-solid fa-book-pen"></i> Edit Book</h1>

            <?php if (!empty($_SESSION['edit-book-error'])): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['edit-book-error']) ?></span>
                </div>
                <?php unset($_SESSION['edit-book-error']); ?>
            <?php endif; ?>

            <form class="book-form" action="logic/edit-book-logic.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= (int)$book['id'] ?>">
                <input type="hidden" name="existing_image" value="<?= htmlspecialchars($imageName) ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="title">Book Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            required
                            placeholder="Enter book title"
                            value="<?= htmlspecialchars($title) ?>">
                    </div>

                    <div class="form-group">
                        <label for="author">Author</label>
                        <input
                            type="text"
                            id="author"
                            name="author"
                            required
                            placeholder="Enter author name"
                            value="<?= htmlspecialchars($author) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <?php $cat = $category; ?>
                        <select id="category" name="category" required>
                            <option value="" <?= $cat === '' ? 'selected' : '' ?>>Select category</option>
                            <option value="Admission" <?= $cat === 'Admission'   ? 'selected' : '' ?>>Admission</option>
                            <option value="Job Exam" <?= $cat === 'Job Exam'    ? 'selected' : '' ?>>Job Exam</option>
                            <option value="Skill-Based" <?= $cat === 'Skill-Based' ? 'selected' : '' ?>>Skill-Based</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="image">Cover Image (optional)</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <span class="hint">Recommended: JPG/PNG/WEBP, ≤ 2MB.</span>
                        <?php if (!empty($imageName)): ?>
                            <div class="hint" style="margin-top:6px;">
                                Current:
                                <img src="<?= '../uploads/' . htmlspecialchars($imageName) ?>"
                                    alt="<?= htmlspecialchars($imageName) ?>"
                                    style="max-width: 150px; height: auto; display: block; margin-top: 4px; border: 1px solid #ccc; padding: 2px;">
                            </div>
                        <?php endif; ?>

                    </div>

                    <div class="form-group">
                        <label for="pdf">PDF Link (URL)</label>
                        <input
                            type="url"
                            id="pdf"
                            name="pdf"
                            placeholder="https://example.com/book.pdf"
                            value="<?= htmlspecialchars($pdf) ?>">
                        <span class="hint">Provide a direct or shared link to the PDF.</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Short summary or key details about the book"><?= htmlspecialchars($description) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="suggestedFor">Suggested For <small>(required)</small></label>
                    <textarea
                        id="suggestedFor"
                        name="suggestedFor"
                        required
                        placeholder='Comma-separated or JSON array, e.g. ["SSC candidates","Beginners"]'><?= htmlspecialchars($suggestedForRaw) ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="isPaid" name="isPaid" <?= $isPaidOld ? 'checked' : '' ?>>
                        <label for="isPaid">This is a paid book</label>
                    </div>

                    <div class="form-group">
                        <label for="price">Price (USD)</label>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            placeholder="0.00"
                            step="0.01"
                            min="0"
                            value="<?= htmlspecialchars($price) ?>">
                        <span class="hint">If unchecked (free), leave blank.</span>
                    </div>
                </div>

                <button type="submit" name="submit" class="submit-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save Changes
                </button>
            </form>
        </div>
    </main>
</body>

</html>