<?php
require '../config/database.php';
require __DIR__ . '/auth-check.php';

$active_page = 'professors';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    $_SESSION['professor-error'] = 'Invalid professor id.';
    header('Location: professor-list.php');
    exit;
}

$prof = null;
if ($stmt = mysqli_prepare($conn, "SELECT id, name, country, university_name, image, contact_email, contact_phone, availability, profileLink FROM professors WHERE id = ?")) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $prof = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);
}
if (!$prof) {
    $_SESSION['professor-error'] = 'Professor not found.';
    header('Location: professor-list.php');
    exit;
}

$interests = [];
if ($stmt = mysqli_prepare($conn, "SELECT interest FROM professor_research_interests WHERE professor_id = ? ORDER BY interest")) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($res)) {
        if (!empty($row['interest'])) $interests[] = $row['interest'];
    }
    mysqli_stmt_close($stmt);
}

$old = $_SESSION['edit-professor-data'] ?? [];
unset($_SESSION['edit-professor-data']);

function v($key, $fallback)
{
    global $old;
    return isset($old[$key]) ? $old[$key] : $fallback;
}

$availabilityChecked = (!isset($old['availability']) && strtolower($prof['availability']) === 'available')
    || (isset($old['availability']) && ($old['availability'] === 'available' || $old['availability'] === 'on'));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Professor - EduLink Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="styles/add-professor.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include __DIR__ . '/common/sidebar.php'; ?>

    <main class="main-content">
        <?php include __DIR__ . '/common/navbar.php'; ?>

        <div class="content">
            <h1 class="page-title"><i class="fa-solid fa-user-pen"></i> Edit Professor</h1>

            <?php if (!empty($_SESSION['edit-professor-error'])): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['edit-professor-error']) ?></span>
                </div>
                <?php unset($_SESSION['edit-professor-error']); ?>
            <?php endif; ?>

            <form class="professor-form" action="logic/edit-professor-logic.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= (int)$prof['id'] ?>">

                <div class="form-group">
                    <label for="name">Professor Name</label>
                    <input type="text" id="name" name="name" required
                        placeholder="Enter professor's name"
                        value="<?= htmlspecialchars(v('name', $prof['name'])) ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" id="country" name="country"
                            placeholder="e.g., Bangladesh"
                            value="<?= htmlspecialchars(v('country', $prof['country'])) ?>">
                    </div>
                    <div class="form-group">
                        <label for="university_name">University</label>
                        <input type="text" id="university_name" name="university_name"
                            placeholder="e.g., University of Dhaka"
                            value="<?= htmlspecialchars(v('university_name', $prof['university_name'])) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_email">Email</label>
                        <input type="email" id="contact_email" name="contact_email" required
                            placeholder="Enter email address"
                            value="<?= htmlspecialchars(v('contact_email', $prof['contact_email'])) ?>">
                    </div>
                    <div class="form-group">
                        <label for="contact_phone">Phone</label>
                        <input type="text" id="contact_phone" name="contact_phone"
                            placeholder="Enter phone number"
                            value="<?= htmlspecialchars(v('contact_phone', $prof['contact_phone'])) ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="profileLink">Profile Link</label>
                    <input type="url" id="profileLink" name="profileLink"
                        placeholder="Enter profile URL"
                        value="<?= htmlspecialchars(v('profileLink', $prof['profileLink'])) ?>">
                </div>

                <div class="form-group">
                    <label for="researchInterests">Research Interests</label>
                    <input type="text" id="researchInterests" name="researchInterests"
                        placeholder="Comma separated, e.g. AI, Machine Learning"
                        value="<?= htmlspecialchars(v('researchInterests', implode(', ', $interests))) ?>">
                    <span class="hint">Separate with commas. Each item ≤ 255 chars.</span>
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" id="availability" name="availability" <?= $availabilityChecked ? 'checked' : '' ?>>
                    <label for="availability">Available</label>
                </div>

                <div class="form-group">
                    <label>Current Image</label>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <?php if (!empty($prof['image'])): ?>
                            <img src="../uploads/<?= htmlspecialchars($prof['image']) ?>" alt="Current" style="width:72px;height:72px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;">
                            <span class="hint"><?= htmlspecialchars($prof['image']) ?></span>
                        <?php else: ?>
                            <span class="hint">No image uploaded.</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Replace Image (optional)</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <span class="hint">JPG/PNG/WEBP, ≤ 2MB. Leave blank to keep current image.</span>
                </div>

                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    <button type="submit" name="submit" class="submit-btn">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>