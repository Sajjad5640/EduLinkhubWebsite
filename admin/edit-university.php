<?php
require '../config/database.php';
require __DIR__ . '/auth-check.php';

$active_page = 'university-list';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    $_SESSION['university-error'] = 'Invalid university id.';
    header('Location: university-list.php');
    exit;
}

$uni = null;
if ($stmt = mysqli_prepare($conn, "SELECT id, name, location, programType, discipline, admissionLink, applicationDate, applicationDeadline, admitCardDownloadDate, image FROM universities WHERE id = ?")) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $uni = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);
}
if (!$uni) {
    $_SESSION['university-error'] = 'University not found.';
    header('Location: university-list.php');
    exit;
}

$old = $_SESSION['edit-university-data'] ?? [];
unset($_SESSION['edit-university-data']);

$name        = $old['name']        ?? ($uni['name'] ?? '');
$location    = $old['location']    ?? ($uni['location'] ?? '');
$programType = $old['programType'] ?? ($uni['programType'] ?? '');
$discipline  = $old['discipline']  ?? ($uni['discipline'] ?? '');
$admissionLink = $old['admissionLink'] ?? ($uni['admissionLink'] ?? '');
$applicationDate       = $old['applicationDate']       ?? ($uni['applicationDate'] ?? '');
$applicationDeadline   = $old['applicationDeadline']   ?? ($uni['applicationDeadline'] ?? '');
$admitCardDownloadDate = $old['admitCardDownloadDate'] ?? ($uni['admitCardDownloadDate'] ?? '');
$imageName   = $uni['image'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit University - EduLink Hub</title>

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
            <h1 class="page-title"><i class="fa-solid fa-building-columns"></i> Edit University</h1>

            <?php if (!empty($_SESSION['edit-university-error'])): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['edit-university-error']) ?></span>
                </div>
                <?php unset($_SESSION['edit-university-error']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['edit-university-success'])): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= htmlspecialchars($_SESSION['edit-university-success']) ?></span>
                </div>
                <?php unset($_SESSION['edit-university-success']); ?>
            <?php endif; ?>

            <form class="uni-form" action="logic/edit-university-logic.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= (int)$uni['id'] ?>">
                <input type="hidden" name="existing_image" value="<?= htmlspecialchars($imageName) ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">University Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            required
                            placeholder="e.g., Oxford University"
                            value="<?= htmlspecialchars($name) ?>">
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <input
                            type="text"
                            id="location"
                            name="location"
                            required
                            placeholder="City, Country"
                            value="<?= htmlspecialchars($location) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="programType">Program Type</label>
                        <?php $pt = $programType; ?>
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
                            required
                            placeholder="e.g., Computer Science, Economics"
                            value="<?= htmlspecialchars($discipline) ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="admissionLink">Admission Link</label>
                    <input
                        type="url"
                        id="admissionLink"
                        name="admissionLink"
                        required
                        placeholder="https://example.edu/admissions"
                        value="<?= htmlspecialchars($admissionLink) ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="applicationDate">Application Start Date</label>
                        <input type="date" id="applicationDate" name="applicationDate" value="<?= htmlspecialchars($applicationDate) ?>">
                    </div>

                    <div class="form-group">
                        <label for="applicationDeadline">Application Deadline</label>
                        <input type="date" id="applicationDeadline" name="applicationDeadline" value="<?= htmlspecialchars($applicationDeadline) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="admitCardDownloadDate">Admit Card Download Date</label>
                        <input type="date" id="admitCardDownloadDate" name="admitCardDownloadDate" value="<?= htmlspecialchars($admitCardDownloadDate) ?>">
                    </div>

                    <div class="form-group">
                        <label for="image">University/Image Banner (optional)</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <span class="hint">Recommended: JPG/PNG/WEBP, ≤ 2MB.</span>
                        <?php if (!empty($imageName)): ?>
                            <div class="hint" style="margin-top:6px;">
                                Current:<br>
                                <img
                                    src="<?= '../uploads/' . htmlspecialchars($imageName) ?>"
                                    alt="<?= htmlspecialchars($imageName) ?>"
                                    style="max-width:150px; height:auto; margin-top:4px;">
                            </div>
                        <?php endif; ?>

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