<?php
require '../config/database.php';
require __DIR__ . '/auth-check.php';
$active_page = 'add-book';

$old = $_SESSION['add-book-data'] ?? [];
unset($_SESSION['add-book-data']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Book - EduLink Hub</title>

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
            <h1 class="page-title"><i class="fa-solid fa-book"></i> Add Book</h1>

            <?php if (!empty($_SESSION['add-book-error'])): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['add-book-error']) ?></span>
                </div>
                <?php unset($_SESSION['add-book-error']); ?>
            <?php endif; ?>

            <form class="book-form" action="logic/add-book-logic.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label for="title">Book Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            required
                            placeholder="Enter book title"
                            value="<?= isset($old['title']) ? htmlspecialchars($old['title']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="author">Author</label>
                        <input
                            type="text"
                            id="author"
                            name="author"
                            required
                            placeholder="Enter author name"
                            value="<?= isset($old['author']) ? htmlspecialchars($old['author']) : '' ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" required>
                            <?php
                            $cat = $old['category'] ?? '';
                            $opts = ['Admission', 'Job Exam', 'Skill-Based'];
                            ?>
                            <option value="" <?= $cat === '' ? 'selected' : ''; ?>>Select category</option>
                            <?php foreach ($opts as $o): ?>
                                <option value="<?= $o ?>" <?= $cat === $o ? 'selected' : ''; ?>><?= $o ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="image">Cover Image (optional)</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <span class="hint">Recommended: JPG/PNG/WEBP, ≤ 2MB.</span>
                    </div>

                    <div class="form-group">
                        <label for="pdfLink">PDF Link (URL)</label>
                        <input
                            type="url"
                            id="pdfLink"
                            name="pdfLink"
                            placeholder="https://example.com/book.pdf"
                            value="<?= isset($old['pdfLink']) ? htmlspecialchars($old['pdfLink']) : '' ?>">
                        <span class="hint">Provide a direct or shared link to the PDF.</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Short summary or key details about the book"><?= isset($old['description']) ? htmlspecialchars($old['description']) : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label for="suggestedFor">Suggested For</label>
                    <textarea id="suggestedFor" name="suggestedFor" placeholder="Who is this book most useful for? (e.g., SSC candidates, beginners)"><?= isset($old['suggestedFor']) ? htmlspecialchars($old['suggestedFor']) : '' ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group checkbox-group">
                        <?php $paid = isset($old['isPaid']) ? (int)$old['isPaid'] : 0; ?>
                        <input type="checkbox" id="isPaid" name="isPaid" <?= $paid ? 'checked' : '' ?>>
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
                            value="<?= isset($old['price']) ? htmlspecialchars($old['price']) : '' ?>">
                        <span class="hint">If unchecked (free), leave blank.</span>
                    </div>
                </div>

                <button type="submit" name="submit" class="submit-btn">
                    <i class="fa-solid fa-check-circle"></i> Submit
                </button>
            </form>
        </div>
    </main>
</body>

</html>