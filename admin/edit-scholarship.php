<?php
require '../config/database.php';
require __DIR__ . '/auth-check.php';

$active_page = 'scholarship-list';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    $_SESSION['funding-error'] = 'Invalid scholarship ID.';
    header('Location: scholarship-list.php');
    exit;
}

$funding = null;
if ($stmt = mysqli_prepare($conn, "SELECT id, type, title, description, link, eligibilityCriteria, applyDate, applicationDeadline, university, department, professor_id FROM fundings WHERE id = ?")) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $funding = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);
}
if (!$funding) {
    $_SESSION['funding-error'] = 'Scholarship not found.';
    header('Location: scholarship-list.php');
    exit;
}

$professors = [];
$res = mysqli_query($conn, "SELECT id, name, contact_email FROM professors ORDER BY name ASC");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) $professors[] = $row;
}

$old = $_SESSION['edit-scholarship-data'] ?? [];
unset($_SESSION['edit-scholarship-data']);

$val = function ($key) use ($old, $funding) {
    return isset($old[$key]) ? $old[$key] : ($funding[$key] ?? '');
};

$ot = strtolower($val('type'));
$showUni  = ($ot === 'university');
$showProf = ($ot === 'professor');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Scholarship - EduLink Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="styles/add-scholarship.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include __DIR__ . '/common/sidebar.php'; ?>

    <main class="main-content">
        <?php include __DIR__ . '/common/navbar.php'; ?>

        <div class="content">
            <h1 class="page-title"><i class="fa-solid fa-pen-to-square"></i> Edit Scholarship</h1>

            <?php if (!empty($_SESSION['edit-scholarship-error'])): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['edit-scholarship-error']) ?></span>
                </div>
                <?php unset($_SESSION['edit-scholarship-error']); ?>
            <?php endif; ?>

            <form class="sch-form" action="logic/edit-scholarship-logic.php" method="post" novalidate>
                <input type="hidden" name="id" value="<?= (int)$funding['id'] ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="title">Scholarship Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            required
                            placeholder="e.g., Full Tuition Merit Scholarship"
                            value="<?= htmlspecialchars($val('title')) ?>">
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <select id="type" name="type" required>
                            <option value="" <?= $ot === '' ? 'selected' : '' ?>>Select type</option>
                            <option value="university" <?= $ot === 'university' ? 'selected' : '' ?>>University</option>
                            <option value="professor" <?= $ot === 'professor'  ? 'selected' : '' ?>>Professor</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="link">Official Link</label>
                    <input
                        type="url"
                        id="link"
                        name="link"
                        required
                        placeholder="https://example.edu/scholarships/merit-2025"
                        value="<?= htmlspecialchars($val('link')) ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="applyDate">Application Start Date</label>
                        <input type="date" id="applyDate" name="applyDate" value="<?= htmlspecialchars($val('applyDate')) ?>">
                    </div>

                    <div class="form-group">
                        <label for="applicationDeadline">Application Deadline</label>
                        <input type="date" id="applicationDeadline" name="applicationDeadline" value="<?= htmlspecialchars($val('applicationDeadline')) ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Brief description of the scholarship, benefits, duration, etc."><?= htmlspecialchars($val('description')) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="eligibilityCriteria">Eligibility Criteria</label>
                    <textarea id="eligibilityCriteria" name="eligibilityCriteria" placeholder="Eligibility requirements (e.g., GPA, nationality, discipline)"><?= htmlspecialchars($val('eligibilityCriteria')) ?></textarea>
                </div>

                <div id="universitySection" class="section" style="<?= $showUni ? '' : 'display:none;' ?>">
                    <div class="section-title"><i class="fa-solid fa-building-columns"></i> University Details</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="university">University</label>
                            <input type="text" id="university" name="university"
                                placeholder="e.g., University of XYZ"
                                <?= $showUni ? 'required' : '' ?>
                                value="<?= htmlspecialchars($val('university')) ?>">
                        </div>
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input type="text" id="department" name="department"
                                placeholder="e.g., Computer Science"
                                <?= $showUni ? 'required' : '' ?>
                                value="<?= htmlspecialchars($val('department')) ?>">
                        </div>
                    </div>
                    <div class="hint">This section is required for university-type scholarships.</div>
                </div>

                <div id="professorSection" class="section" style="<?= $showProf ? '' : 'display:none;' ?>">
                    <div class="section-title"><i class="fa-solid fa-user-tie"></i> Select Professor</div>
                    <div class="form-group">
                        <label for="professor_id">Professor</label>
                        <select id="professor_id" name="professor_id" <?= $showProf ? 'required' : '' ?>>
                            <option value="">Select a professor</option>
                            <?php
                            $selProf = $val('professor_id');
                            foreach ($professors as $p):
                                $label = $p['name'] . (!empty($p['contact_email']) ? ' — ' . $p['contact_email'] : '');
                            ?>
                                <option value="<?= (int)$p['id'] ?>" <?= ((int)$selProf === (int)$p['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($label) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="hint">Pick the supervising/awarding professor for this scholarship.</div>
                    </div>
                </div>

                <button type="submit" name="submit" class="submit-btn">
                    <i class="fa-solid fa-check-circle"></i> Update
                </button>
            </form>
        </div>
    </main>

    <script>
        (function() {
            const typeSel = document.getElementById('type');
            const uniSec = document.getElementById('universitySection');
            const profSec = document.getElementById('professorSection');
            const uni = document.getElementById('university');
            const dept = document.getElementById('department');
            const prof = document.getElementById('professor_id');

            function updateVisibility() {
                const v = (typeSel.value || '').toLowerCase();
                if (v === 'university') {
                    uniSec.style.display = '';
                    profSec.style.display = 'none';
                    uni.required = true;
                    dept.required = true;
                    prof.required = false;
                } else if (v === 'professor') {
                    uniSec.style.display = 'none';
                    profSec.style.display = '';
                    uni.required = false;
                    dept.required = false;
                    prof.required = true;
                } else {
                    uniSec.style.display = 'none';
                    profSec.style.display = 'none';
                    uni.required = false;
                    dept.required = false;
                    prof.required = false;
                }
            }
            typeSel.addEventListener('change', updateVisibility);
            updateVisibility();
        })();
    </script>
</body>

</html>