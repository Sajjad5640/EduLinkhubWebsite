<?php
require '../config/database.php';
require __DIR__ . '/auth-check.php';

$active_page = 'add-university';

$old = $_SESSION['add-university-data'] ?? [];
unset($_SESSION['add-university-data']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add University - EduLink Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="styles/add-university.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include __DIR__ . '/common/sidebar.php'; ?>

    <main class="main-content">
        <?php include __DIR__ . '/common/navbar.php'; ?>

        <div class="content">
            <h1 class="page-title"><i class="fa-solid fa-building-columns"></i> Add University</h1>

            <?php if (!empty($_SESSION['add-university-error'])): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['add-university-error']) ?></span>
                </div>
                <?php unset($_SESSION['add-university-error']); ?>
            <?php endif; ?>

            <form class="uni-form" action="logic/add-university-logic.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">University Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="e.g., Oxford University"
                            required
                            value="<?= isset($old['name']) ? htmlspecialchars($old['name']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <input
                            type="text"
                            id="location"
                            name="location"
                            placeholder="City, Country"
                            required
                            value="<?= isset($old['location']) ? htmlspecialchars($old['location']) : '' ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="programType">Program Type</label>
                        <?php $pt = $old['programType'] ?? ''; ?>
                        <select id="programType" name="programType" required>
                            <option value="" <?= $pt === '' ? 'selected' : '' ?>>Select program type</option>
                            <option value="undergraduate" <?= $pt === 'undergraduate' ? 'selected' : '' ?>>Undergraduate</option>
                            <option value="postgraduate" <?= $pt === 'postgraduate' ? 'selected' : '' ?>>Postgraduate</option>
                            <option value="Ph.D." <?= $pt === 'Ph.D.'        ? 'selected' : '' ?>>Ph.D.</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="discipline">Discipline</label>
                        <input
                            type="text"
                            id="discipline"
                            name="discipline"
                            placeholder="e.g., Computer Science, Economics"
                            required
                            value="<?= isset($old['discipline']) ? htmlspecialchars($old['discipline']) : '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="admissionLink">Admission Link</label>
                    <input
                        type="url"
                        id="admissionLink"
                        name="admissionLink"
                        placeholder="https://example.edu/admissions"
                        required
                        value="<?= isset($old['admissionLink']) ? htmlspecialchars($old['admissionLink']) : '' ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="applicationDate">Application Start Date</label>
                        <input
                            type="date"
                            id="applicationDate"
                            name="applicationDate"
                            value="<?= isset($old['applicationDate']) ? htmlspecialchars($old['applicationDate']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="applicationDeadline">Application Deadline</label>
                        <input
                            type="date"
                            id="applicationDeadline"
                            name="applicationDeadline"
                            value="<?= isset($old['applicationDeadline']) ? htmlspecialchars($old['applicationDeadline']) : '' ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="admitCardDownloadDate">Admit Card Download Date</label>
                        <input
                            type="date"
                            id="admitCardDownloadDate"
                            name="admitCardDownloadDate"
                            value="<?= isset($old['admitCardDownloadDate']) ? htmlspecialchars($old['admitCardDownloadDate']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="image">University/Image Banner (optional)</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <span class="hint">Recommended: JPG/PNG/WEBP, ≤ 2MB.</span>
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