<?php
require '../config/database.php';
require __DIR__ . '/auth-check.php';

$active_page = 'index';

function one($conn, $sql, $types = '', $params = [])
{
    $v = 0;
    if ($stmt = mysqli_prepare($conn, $sql)) {
        if ($types !== '') mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $v);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    return (int)$v;
}
function rows($conn, $sql, $types = '', $params = [])
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

$totalBooks       = one($conn, "SELECT COUNT(*) FROM books");
$paidBooks        = one($conn, "SELECT COUNT(*) FROM books WHERE isPaid=1");
$totalProfessors  = one($conn, "SELECT COUNT(*) FROM professors");
$availableProfs   = one($conn, "SELECT COUNT(*) FROM professors WHERE availability='available'");
$totalFundings    = one($conn, "SELECT COUNT(*) FROM fundings");
$fundingScholar   = one($conn, "SELECT COUNT(*) FROM fundings WHERE LOWER(type)='scholarship'");
$fundingProfessor = one($conn, "SELECT COUNT(*) FROM fundings WHERE LOWER(type)='professor'");
$totalUniversities = one($conn, "SELECT COUNT(*) FROM universities");
$deadlinesNext30  = one($conn, "SELECT COUNT(*) FROM fundings WHERE applicationDeadline BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)")
    + one($conn, "SELECT COUNT(*) FROM universities WHERE applicationDeadline BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)");

$catCounts = ['Admission' => 0, 'Job Exam' => 0, 'Skill-Based' => 0];
foreach (rows($conn, "SELECT category, COUNT(*) c FROM books GROUP BY category") as $r) {
    $k = $r['category'] ?? '';
    if (isset($catCounts[$k])) $catCounts[$k] = (int)$r['c'];
}

$deadlines = rows($conn, "
    SELECT * FROM (
        SELECT 'Scholarship' AS kind, title, COALESCE(NULLIF(university,''),'—') AS org,
               COALESCE(NULLIF(department,''),'—') AS dept, applicationDeadline AS d, link
        FROM fundings WHERE applicationDeadline IS NOT NULL
        UNION ALL
        SELECT 'Admission' AS kind, name AS title, name AS org,
               COALESCE(NULLIF(discipline,''),'—') AS dept, applicationDeadline AS d, admissionLink AS link
        FROM universities WHERE applicationDeadline IS NOT NULL
    ) u
    WHERE d >= CURDATE()
    ORDER BY d ASC
    LIMIT 6
");

$activity = rows($conn, "
    SELECT * FROM (
        SELECT GREATEST(IFNULL(createdAt,'0000-00-00 00:00:00'), IFNULL(updatedAt,'0000-00-00 00:00:00')) AS ts,
               'Book' AS module, IF(IFNULL(updatedAt,'0000')>IFNULL(createdAt,'0000'),'Updated','Created') AS act,
               title AS label
        FROM books
        UNION ALL
        SELECT GREATEST(IFNULL(createdAt,'0000-00-00 00:00:00'), IFNULL(updatedAt,'0000-00-00 00:00:00')) AS ts,
               'Professor' AS module, IF(IFNULL(updatedAt,'0000')>IFNULL(createdAt,'0000'),'Updated','Created') AS act,
               name AS label
        FROM professors
        UNION ALL
        SELECT GREATEST(IFNULL(createdAt,'0000-00-00 00:00:00'), IFNULL(updatedAt,'0000-00-00 00:00:00')) AS ts,
               'Scholarship' AS module, IF(IFNULL(updatedAt,'0000')>IFNULL(createdAt,'0000'),'Updated','Created') AS act,
               title AS label
        FROM fundings
        UNION ALL
        SELECT GREATEST(IFNULL(createdAt,'0000-00-00 00:00:00'), IFNULL(updatedAt,'0000-00-00 00:00:00')) AS ts,
               'University' AS module, IF(IFNULL(updatedAt,'0000')>IFNULL(createdAt,'0000'),'Updated','Created') AS act,
               name AS label
        FROM universities
    ) x
    ORDER BY ts DESC
    LIMIT 8
");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - EduLink Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="./index.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <?php include __DIR__ . '/common/sidebar.php'; ?>

    <main class="main-content">
        <?php include __DIR__ . '/common/navbar.php'; ?>

        <div class="content">
            <div class="welcome">
                <h1>Welcome back, Admin</h1>
                <div class="quick-actions">
                    <a class="btn" href="add-university.php"><i class="fa-solid fa-building-columns"></i>Add University</a>
                    <a class="btn secondary" href="add-scholarship.php"><i class="fa-solid fa-graduation-cap"></i>Add Scholarship</a>
                    <a class="btn" href="add-professor.php"><i class="fa-solid fa-user-plus"></i>Add Professor</a>
                    <a class="btn warn" href="add-book.php"><i class="fa-solid fa-book"></i>Add Book</a>
                </div>
            </div>

            <section class="kpis">
                <div class="kpi accent1">
                    <i class="fa-solid fa-book icon"></i>
                    <div class="label">Total Books</div>
                    <div class="value"><?= number_format($totalBooks) ?></div>
                    <div class="sub"><?= number_format($paidBooks) ?> paid</div>
                </div>
                <div class="kpi accent2">
                    <i class="fa-solid fa-user-graduate icon"></i>
                    <div class="label">Professors</div>
                    <div class="value"><?= number_format($totalProfessors) ?></div>
                    <div class="sub"><?= number_format($availableProfs) ?> available</div>
                </div>
                <div class="kpi accent3">
                    <i class="fa-solid fa-award icon"></i>
                    <div class="label">Scholarships (All)</div>
                    <div class="value"><?= number_format($totalFundings) ?></div>
                    <div class="sub"><?= number_format($fundingScholar) ?> scholarship • <?= number_format($fundingProfessor) ?> professor</div>
                </div>
                <div class="kpi accent4">
                    <i class="fa-solid fa-school icon"></i>
                    <div class="label">Universities</div>
                    <div class="value"><?= number_format($totalUniversities) ?></div>
                    <div class="sub">Tracked entries</div>
                </div>
                <div class="kpi accent5">
                    <i class="fa-solid fa-hourglass-half icon"></i>
                    <div class="label">Upcoming Deadlines</div>
                    <div class="value"><?= number_format($deadlinesNext30) ?></div>
                    <div class="sub">Next 30 days</div>
                </div>
                <div class="kpi accent6">
                    <i class="fa-solid fa-chart-line icon"></i>
                    <div class="label">Reports</div>
                    <div class="value"><a class="link" href="reports.php">Open</a></div>
                    <div class="sub">Insights & trends</div>
                </div>
            </section>

            <section class="grid-2" style="margin-bottom:14px;">
                <div class="card">
                    <div class="card-head">
                        <div class="card-title">Books by Category</div>
                        <a class="link" href="book-list.php">Manage</a>
                    </div>
                    <div class="card-body">
                        <div class="chart-wrap"><canvas id="chartBooks"></canvas></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <div class="card-title">Upcoming Deadlines</div>
                        <a class="link" href="scholarship-list.php">View All</a>
                    </div>
                    <div class="card-body table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Org</th>
                                    <th>Dept</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!$deadlines): ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center; color:#64748b;">No upcoming deadlines.</td>
                                    </tr>
                                    <?php else: foreach ($deadlines as $d):
                                        $st = 'Upcoming';
                                        $cls = 'ok';
                                        $today = new DateTime('today');
                                        $dt = DateTime::createFromFormat('Y-m-d', $d['d']);
                                        if ($dt) {
                                            $diff = (int)$today->diff($dt)->format('%r%a');
                                            if ($diff < 0) {
                                                $st = 'Past';
                                                $cls = 'past';
                                            } elseif ($diff <= 7) {
                                                $st = 'Due soon';
                                                $cls = 'warn';
                                            }
                                        }
                                    ?>
                                        <tr>
                                            <td><?= htmlspecialchars($d['kind']) ?></td>
                                            <td><?= htmlspecialchars($d['title']) ?></td>
                                            <td><?= htmlspecialchars($d['org']) ?></td>
                                            <td><?= htmlspecialchars($d['dept']) ?></td>
                                            <td><?= htmlspecialchars($d['d']) ?></td>
                                            <td><span class="badge <?= $cls ?>"><?= $st ?></span></td>
                                            <td>
                                                <?php if (!empty($d['link'])): ?>
                                                    <a class="link" href="<?= htmlspecialchars($d['link']) ?>" target="_blank" rel="noopener">Open</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="card">
                <div class="card-head">
                    <div class="card-title">Recent Activity</div>
                    <a class="link" href="reports.php">Go to Reports</a>
                </div>
                <div class="card-body table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>When</th>
                                <th>Module</th>
                                <th>Action</th>
                                <th>Title / Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$activity): ?>
                                <tr>
                                    <td colspan="4" style="text-align:center; color:#64748b;">No recent activity.</td>
                                </tr>
                                <?php else: foreach ($activity as $a): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($a['ts']) ?></td>
                                        <td><?= htmlspecialchars($a['module']) ?></td>
                                        <td><?= htmlspecialchars($a['act']) ?></td>
                                        <td><?= htmlspecialchars($a['label']) ?></td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <script>
        const catLabels = <?= json_encode(array_keys($catCounts), JSON_UNESCAPED_UNICODE) ?>;
        const catData = <?= json_encode(array_values($catCounts), JSON_UNESCAPED_UNICODE) ?>;

        const brand = getComputedStyle(document.documentElement).getPropertyValue('--primary-color').trim();
        const ok = getComputedStyle(document.documentElement).getPropertyValue('--ok').trim();
        const warn = getComputedStyle(document.documentElement).getPropertyValue('--warning-color').trim();

        new Chart(document.getElementById('chartBooks').getContext('2d'), {
            type: 'bar',
            data: {
                labels: catLabels,
                datasets: [{
                    label: 'Books',
                    data: catData,
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
    </script>
</body>

</html>