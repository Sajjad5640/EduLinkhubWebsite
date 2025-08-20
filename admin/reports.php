<?php
require '../config/database.php';
require __DIR__ . '/auth-check.php';

$active_page = 'reports';

$from = isset($_GET['from']) ? trim($_GET['from']) : '';
$to   = isset($_GET['to'])   ? trim($_GET['to'])   : '';
$module = isset($_GET['module']) ? trim(strtolower($_GET['module'])) : '';

$validDate = function ($d) {
    if ($d === '') return true;
    $dt = DateTime::createFromFormat('Y-m-d', $d);
    return $dt && $dt->format('Y-m-d') === $d;
};
if (!$validDate($from)) $from = '';
if (!$validDate($to))   $to   = '';

$modulesAllowed = ['', 'books', 'professors', 'scholarships', 'universities'];
if (!in_array($module, $modulesAllowed, true)) $module = '';

function fetch_one($conn, $sql, $types = '', $params = [])
{
    $val = 0;
    if ($stmt = mysqli_prepare($conn, $sql)) {
        if ($types !== '') mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $val);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    return (int)$val;
}
function fetch_rows($conn, $sql, $types = '', $params = [])
{
    $rows = [];
    if ($stmt = mysqli_prepare($conn, $sql)) {
        if ($types !== '') mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res) while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
        mysqli_stmt_close($stmt);
    }
    return $rows;
}

$totalBooks = fetch_one($conn, "SELECT COUNT(*) FROM books");
$paidBooks  = fetch_one($conn, "SELECT COUNT(*) FROM books WHERE isPaid=1");

$totalProfessors = fetch_one($conn, "SELECT COUNT(*) FROM professors");

$totalScholarships = fetch_one($conn, "SELECT COUNT(*) FROM fundings");

$totalUniversities = fetch_one($conn, "SELECT COUNT(*) FROM universities");

$deadlinesNext30 = fetch_one(
    $conn,
    "SELECT COUNT(*) FROM fundings WHERE applicationDeadline IS NOT NULL AND applicationDeadline BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)"
) + fetch_one(
    $conn,
    "SELECT COUNT(*) FROM universities WHERE applicationDeadline IS NOT NULL AND applicationDeadline BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)"
);


$bookCats = ['Admission' => 0, 'Job Exam' => 0, 'Skill-Based' => 0];
$rows = fetch_rows($conn, "SELECT category, COUNT(*) AS c FROM books GROUP BY category");
foreach ($rows as $r) {
    $k = $r['category'] ?? '';
    if (isset($bookCats[$k])) $bookCats[$k] = (int)$r['c'];
}

$schTypes = ['scholarship' => 0, 'professor' => 0];
$rows = fetch_rows($conn, "SELECT LOWER(type) AS t, COUNT(*) AS c FROM fundings GROUP BY t");
foreach ($rows as $r) {
    $t = $r['t'] ?? '';
    if (isset($schTypes[$t])) $schTypes[$t] = (int)$r['c'];
}

$deadlineWhere = [];
$types = '';
$params = [];
if ($from !== '') {
    $deadlineWhere[] = 'd >= ?';
    $types .= 's';
    $params[] = $from;
}
if ($to   !== '') {
    $deadlineWhere[] = 'd <= ?';
    $types .= 's';
    $params[] = $to;
}
$whereSql = $deadlineWhere ? ('WHERE ' . implode(' AND ', $deadlineWhere)) : '';

$sqlUnifiedDeadlines = "
    SELECT * FROM (
        SELECT
            'Scholarship' AS kind,
            f.title        AS title,
            COALESCE(NULLIF(f.university,''),'—') AS organization,
            COALESCE(NULLIF(f.department,''),'—') AS department,
            f.applicationDeadline AS d,
            f.link         AS link
        FROM fundings f
        WHERE f.applicationDeadline IS NOT NULL
        UNION ALL
        SELECT
            'Admission' AS kind,
            u.name      AS title,
            u.name      AS organization,
            COALESCE(NULLIF(u.discipline,''),'—') AS department,
            u.applicationDeadline AS d,
            u.admissionLink AS link
        FROM universities u
        WHERE u.applicationDeadline IS NOT NULL
    ) unified
    $whereSql
    ORDER BY d ASC
    LIMIT 100
";
$deadlines = fetch_rows($conn, $sqlUnifiedDeadlines, $types, $params);

function deadline_status($dateStr)
{
    if (!$dateStr) return ['label' => '—', 'cls' => ''];
    $today = new DateTime('today');
    $d = DateTime::createFromFormat('Y-m-d', $dateStr);
    if (!$d) return ['label' => '—', 'cls' => ''];
    $diff = (int)$today->diff($d)->format('%r%a');
    if ($diff < 0)  return ['label' => 'Past',     'cls' => 'past'];
    if ($diff <= 7) return ['label' => 'Due soon', 'cls' => 'warn'];
    return ['label' => 'Upcoming', 'cls' => 'ok'];
}

$activity = [];
$actFilters = [];
$actTypes = '';
$actParams = [];

if ($from !== '') {
    $actFilters[] = "last_ts >= ?";
    $actTypes .= 's';
    $actParams[] = $from . ' 00:00:00';
}
if ($to   !== '') {
    $actFilters[] = "last_ts <= ?";
    $actTypes .= 's';
    $actParams[] = $to   . ' 23:59:59';
}
$actWhere = $actFilters ? ('WHERE ' . implode(' AND ', $actFilters)) : '';

$unionParts = [];
if ($module === '' || $module === 'books') {
    $unionParts[] = "
        SELECT last_ts, 'Book' AS module, action, title_or_name AS title, actor
        FROM (
            SELECT
                GREATEST(IFNULL(createdAt,'0000-00-00 00:00:00'), IFNULL(updatedAt,'0000-00-00 00:00:00')) AS last_ts,
                IF(IFNULL(updatedAt,'0000-00-00 00:00:00') > IFNULL(createdAt,'0000-00-00 00:00:00'), 'Updated','Created') AS action,
                b.title AS title_or_name,
                '—' AS actor
            FROM books b
        ) x
        $actWhere
    ";
}
if ($module === '' || $module === 'professors') {
    $unionParts[] = "
        SELECT last_ts, 'Professor' AS module, action, title_or_name AS title, actor
        FROM (
            SELECT
                GREATEST(IFNULL(createdAt,'0000-00-00 00:00:00'), IFNULL(updatedAt,'0000-00-00 00:00:00')) AS last_ts,
                IF(IFNULL(updatedAt,'0000-00-00 00:00:00') > IFNULL(createdAt,'0000-00-00 00:00:00'), 'Updated','Created') AS action,
                p.name AS title_or_name,
                '—' AS actor
            FROM professors p
        ) x
        $actWhere
    ";
}
if ($module === '' || $module === 'scholarships') {
    $unionParts[] = "
        SELECT last_ts, 'Scholarship' AS module, action, title_or_name AS title, actor
        FROM (
            SELECT
                GREATEST(IFNULL(createdAt,'0000-00-00 00:00:00'), IFNULL(updatedAt,'0000-00-00 00:00:00')) AS last_ts,
                IF(IFNULL(updatedAt,'0000-00-00 00:00:00') > IFNULL(createdAt,'0000-00-00 00:00:00'), 'Updated','Created') AS action,
                f.title AS title_or_name,
                '—' AS actor
            FROM fundings f
        ) x
        $actWhere
    ";
}
if ($module === '' || $module === 'universities') {
    $unionParts[] = "
        SELECT last_ts, 'University' AS module, action, title_or_name AS title, actor
        FROM (
            SELECT
                GREATEST(IFNULL(createdAt,'0000-00-00 00:00:00'), IFNULL(updatedAt,'0000-00-00 00:00:00')) AS last_ts,
                IF(IFNULL(updatedAt,'0000-00-00 00:00:00') > IFNULL(createdAt,'0000-00-00 00:00:00'), 'Updated','Created') AS action,
                u.name AS title_or_name,
                '—' AS actor
            FROM universities u
        ) x
        $actWhere
    ";
}
if ($unionParts) {
    $sqlActivity = implode(" UNION ALL ", $unionParts) . " ORDER BY last_ts DESC LIMIT 50";
    $activity = fetch_rows($conn, $sqlActivity, $actTypes, $actParams);
}

$booksByCategory = [
    'labels' => array_keys($bookCats),
    'data'   => array_values($bookCats),
];
$schByType = [
    'labels' => ['Scholarship', 'Professor'],
    'data'   => [$schTypes['scholarship'], $schTypes['professor']],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reports - EduLink Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="styles/reports.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <?php include __DIR__ . '/common/sidebar.php'; ?>

    <main class="main-content">
        <?php include __DIR__ . '/common/navbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <h1 class="page-title"><i class="fa-solid fa-chart-line"></i> Reports</h1>
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    <a class="btn" href="reports.php" style="text-decoration:none;">
                        <i class="fa-solid fa-arrows-rotate"></i> Refresh
                    </a>
                </div>
            </div>

            <form class="toolbar" method="get" action="reports.php" style="display:grid; grid-template-columns: 1fr 1fr 240px auto; gap:10px;">
                <input type="date" class="input" id="fromDate" name="from" value="<?= htmlspecialchars($from) ?>" />
                <input type="date" class="input" id="toDate" name="to" value="<?= htmlspecialchars($to) ?>" />
                <select id="moduleFilter" name="module" class="select">
                    <option value="" <?= $module === '' ? 'selected' : ''; ?>>All Modules</option>
                    <option value="books" <?= $module === 'books' ? 'selected' : ''; ?>>Books</option>
                    <option value="professors" <?= $module === 'professors' ? 'selected' : ''; ?>>Professors</option>
                    <option value="scholarships" <?= $module === 'scholarships' ? 'selected' : ''; ?>>Scholarships</option>
                    <option value="universities" <?= $module === 'universities' ? 'selected' : ''; ?>>Universities</option>
                </select>
                <div style="display:flex;gap:10px;justify-content:flex-end;">
                    <a class="btn secondary" href="reports.php" style="text-decoration:none;">
                        <i class="fa-regular fa-circle-xmark"></i> Clear
                    </a>
                    <button class="btn" type="submit"><i class="fa-solid fa-sliders"></i> Apply</button>
                </div>
            </form>

            <div class="kpi-grid">
                <div class="kpi accent-1">
                    <i class="fa-solid fa-book icon"></i>
                    <h3>Total Books</h3>
                    <div class="value" id="kpiBooks"><?= number_format($totalBooks) ?></div>
                    <div class="sub">All categories</div>
                </div>
                <div class="kpi accent-2">
                    <i class="fa-solid fa-sack-dollar icon"></i>
                    <h3>Paid Books</h3>
                    <div class="value" id="kpiPaidBooks"><?= number_format($paidBooks) ?></div>
                    <div class="sub">Count of paid titles</div>
                </div>
                <div class="kpi accent-3">
                    <i class="fa-solid fa-user-graduate icon"></i>
                    <h3>Professors</h3>
                    <div class="value" id="kpiProfessors"><?= number_format($totalProfessors) ?></div>
                    <div class="sub">Active profiles</div>
                </div>
                <div class="kpi accent-4">
                    <i class="fa-solid fa-graduation-cap icon"></i>
                    <h3>Scholarships</h3>
                    <div class="value" id="kpiScholarships"><?= number_format($totalScholarships) ?></div>
                    <div class="sub">University + Professor</div>
                </div>
                <div class="kpi accent-5">
                    <i class="fa-solid fa-building-columns icon"></i>
                    <h3>Universities</h3>
                    <div class="value" id="kpiUniversities"><?= number_format($totalUniversities) ?></div>
                    <div class="sub">Tracked entries</div>
                </div>
                <div class="kpi accent-6">
                    <i class="fa-solid fa-hourglass-half icon"></i>
                    <h3>Upcoming Deadlines</h3>
                    <div class="value" id="kpiDeadlines"><?= number_format($deadlinesNext30) ?></div>
                    <div class="sub">Next 30 days</div>
                </div>
            </div>

            <div class="grid-2">
                <div class="card">
                    <div class="card-head">
                        <div class="card-title">Books by Category</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-wrap"><canvas id="booksByCategory"></canvas></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <div class="card-title">Scholarships by Type</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-wrap"><canvas id="scholarshipsByType"></canvas></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <div class="card-title">Upcoming Deadlines (Scholarships & Admissions)</div>
                </div>
                <div class="card-body table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Organization</th>
                                <th>Department</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody id="deadlineTbody">
                            <?php if (count($deadlines) === 0): ?>
                                <tr class="empty-row">
                                    <td colspan="7" style="text-align:center;color:#64748b;padding:18px;">
                                        No deadlines found for the selected range.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($deadlines as $d): ?>
                                    <?php $st = deadline_status($d['d']); ?>
                                    <tr>
                                        <td><?= htmlspecialchars($d['kind']) ?></td>
                                        <td><?= htmlspecialchars($d['title']) ?></td>
                                        <td><?= htmlspecialchars($d['organization']) ?></td>
                                        <td><?= htmlspecialchars($d['department']) ?></td>
                                        <td><?= htmlspecialchars($d['d']) ?></td>
                                        <td><span class="badge <?= $st['cls'] ?>"><?= htmlspecialchars($st['label']) ?></span></td>
                                        <td>
                                            <?php if (!empty($d['link'])): ?>
                                                <a class="btn small secondary" href="<?= htmlspecialchars($d['link']) ?>" target="_blank" rel="noopener" style="text-decoration: none;">Open</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <div class="card-title">Recent Activity</div>
                </div>
                <div class="card-body table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>When</th>
                                <th>Module</th>
                                <th>Action</th>
                                <th>Title/Name</th>
                                <th>Actor</th>
                            </tr>
                        </thead>
                        <tbody id="activityTbody">
                            <?php if (count($activity) === 0): ?>
                                <tr class="empty-row">
                                    <td colspan="5" style="text-align:center;color:#64748b;padding:18px;">
                                        No recent activity to show.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($activity as $a): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($a['last_ts']) ?></td>
                                        <td><?= htmlspecialchars($a['module']) ?></td>
                                        <td><?= htmlspecialchars($a['action']) ?></td>
                                        <td><?= htmlspecialchars($a['title']) ?></td>
                                        <td><?= htmlspecialchars($a['actor']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <script>
        const booksByCategory = <?= json_encode([
                                    'labels' => array_keys($bookCats),
                                    'data'   => array_values($bookCats),
                                ], JSON_UNESCAPED_UNICODE) ?>;

        const scholarshipsByType = <?= json_encode([
                                        'labels' => $schByType['labels'],
                                        'data'   => $schByType['data'],
                                    ], JSON_UNESCAPED_UNICODE) ?>;

        const brand = getComputedStyle(document.documentElement).getPropertyValue('--primary-color').trim();
        const accent = getComputedStyle(document.documentElement).getPropertyValue('--accent-color').trim();
        const warn = getComputedStyle(document.documentElement).getPropertyValue('--warning-color').trim();
        const ok = getComputedStyle(document.documentElement).getPropertyValue('--success-color').trim();

        new Chart(document.getElementById('booksByCategory').getContext('2d'), {
            type: 'bar',
            data: {
                labels: booksByCategory.labels,
                datasets: [{
                    label: 'Books',
                    data: booksByCategory.data,
                    backgroundColor: [brand, ok, warn]
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(document.getElementById('scholarshipsByType').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: scholarshipsByType.labels,
                datasets: [{
                    data: scholarshipsByType.data,
                    backgroundColor: [accent, brand]
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>

</html>