<?php
require '../config/database.php';
require __DIR__ . '/auth-check.php';

$active_page = 'scholarship-list';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'], $_POST['id'])) {
    $id = (int)$_POST['id'];

    if ($stmt = mysqli_prepare($conn, "DELETE FROM fundings WHERE id = ?")) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['funding-success'] = 'Scholarship deleted successfully.';
        } else {
            $_SESSION['funding-error'] = 'Failed to delete scholarship. (' . mysqli_error($conn) . ')';
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['funding-error'] = 'Delete failed (prepare error).';
    }

    $qs = $_SERVER['QUERY_STRING'] ?? '';
    header('Location: scholarship-list.php' . ($qs ? ('?' . $qs) : ''));
    exit;
}

$q        = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$type     = isset($_GET['type']) ? strtolower(trim((string)$_GET['type'])) : '';
$per_page = isset($_GET['per_page']) ? max(1, (int)$_GET['per_page']) : 10;
$page     = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

if (!in_array($type, ['', 'university', 'professor'], true)) {
    $type = '';
}

$where  = [];
$params = [];
$types  = '';

if ($q !== '') {
    $where[] = "(f.title LIKE ? OR f.description LIKE ? OR f.university LIKE ? OR f.department LIKE ?)";
    $like = '%' . $q . '%';
    array_push($params, $like, $like, $like, $like);
    $types .= 'ssss';
}

if ($type !== '') {
    $where[] = "LOWER(f.type) = ?";
    $params[] = $type;
    $types   .= 's';
}

$whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';


$total = 0;
$sqlCount = "SELECT COUNT(*) FROM fundings f $whereSql";
if ($stmt = mysqli_prepare($conn, $sqlCount)) {
    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

$total_pages = max(1, (int)ceil($total / $per_page));
$page = min($page, $total_pages);
$offset = ($page - 1) * $per_page;

$data = [];
$sql = "SELECT
            f.id, f.type, f.title, f.description, f.link,
            f.applyDate, f.applicationDeadline,
            f.university, f.department, f.professor_id,
            f.createdAt, f.updatedAt,
            p.name AS professor_name, p.contact_email AS professor_email
        FROM fundings f
        LEFT JOIN professors p ON p.id = f.professor_id
        $whereSql
        ORDER BY f.id DESC
        LIMIT $per_page OFFSET $offset";

if ($stmt = mysqli_prepare($conn, $sql)) {
    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['funding-error'] = 'Failed to load scholarships. (' . mysqli_error($conn) . ')';
}

function link_with_params_s($overrides = [])
{
    $params = [
        'q' => $_GET['q'] ?? '',
        'type' => $_GET['type'] ?? '',
        'per_page' => $_GET['per_page'] ?? 10,
        'page' => $_GET['page'] ?? 1,
    ];
    foreach ($overrides as $k => $v) $params[$k] = $v;
    $qs = http_build_query(array_filter($params, fn($v) => $v !== '' && $v !== null));
    return 'scholarship-list.php' . ($qs ? ('?' . $qs) : '');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Scholarship List - EduLink Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="styles/scholarship-list.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include __DIR__ . '/common/sidebar.php'; ?>

    <main class="main-content">
        <?php include __DIR__ . '/common/navbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <h1 class="page-title"><i class="fa-solid fa-graduation-cap"></i> Scholarship List</h1>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a href="add-scholarship.php" class="btn" style="text-decoration: none;">
                        <i class="fa-solid fa-plus"></i> Add Scholarship
                    </a>
                </div>
            </div>

            <?php if (!empty($_SESSION['funding-success'])): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= htmlspecialchars($_SESSION['funding-success']) ?></span>
                </div>
                <?php unset($_SESSION['funding-success']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['add-scholarship-success'])): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= htmlspecialchars($_SESSION['add-scholarship-success']) ?></span>
                </div>
                <?php unset($_SESSION['add-scholarship-success']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['funding-error'])): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['funding-error']) ?></span>
                </div>
                <?php unset($_SESSION['funding-error']); ?>
            <?php endif; ?>

            <form class="toolbar" method="get" action="scholarship-list.php"
                style="display:grid; grid-template-columns:1fr 200px 160px auto; gap:10px;">
                <input class="input" type="search" name="q" value="<?= htmlspecialchars($q) ?>"
                    placeholder="Search by title, description, university, or department…" />
                <select class="select" name="type">
                    <option value="" <?= $type === '' ? 'selected' : ''; ?>>All Types</option>
                    <option value="university" <?= $type === 'university' ? 'selected' : ''; ?>>University</option>
                    <option value="professor" <?= $type === 'professor'  ? 'selected' : ''; ?>>Professor</option>
                </select>
                <select class="select" name="per_page">
                    <?php foreach ([10, 20, 50, 100] as $opt): ?>
                        <option value="<?= $opt ?>" <?= $per_page === $opt ? 'selected' : ''; ?>><?= $opt ?> / page</option>
                    <?php endforeach; ?>
                </select>
                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <a class="btn secondary" href="scholarship-list.php" style="text-decoration: none;">
                        <i class="fa-regular fa-circle-xmark"></i> Clear
                    </a>
                    <button class="btn" type="submit"><i class="fa-solid fa-sliders"></i> Apply</button>
                </div>
            </form>

            <div class="card">
                <div class="table-wrap">
                    <table id="schTable">
                        <thead>
                            <tr>
                                <th style="width:72px;">ID</th>
                                <th style="width:120px;">Type</th>
                                <th>Title</th>
                                <th style="width:420px;">Description</th>
                                <th style="width:120px;">Apply From</th>
                                <th style="width:140px;">Deadline</th>
                                <th>University</th>
                                <th>Department</th>
                                <th style="width:180px;">Professor</th>
                                <th style="width:120px;">Link</th>
                                <th style="width:150px;">Created At</th>
                                <th style="width:180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="schTbody">
                            <?php if (count($data) > 0): ?>
                                <?php foreach ($data as $s): ?>
                                    <?php
                                    $tval = strtolower(trim((string)$s['type']));
                                    $badgeClass = ($tval === 'professor') ? 'prof' : 'uni';
                                    $profLabel = '';
                                    if (!empty($s['professor_name'])) {
                                        $profLabel = $s['professor_name'] . (!empty($s['professor_email']) ? ' — ' . $s['professor_email'] : '');
                                    } elseif (!empty($s['professor_id'])) {
                                        $profLabel = '#' . (int)$s['professor_id'];
                                    }
                                    ?>
                                    <tr>
                                        <td><?= (int)$s['id'] ?></td>
                                        <td><span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($s['type'] ?? '') ?></span></td>
                                        <td><?= htmlspecialchars($s['title'] ?? '') ?></td>
                                        <td class="ellipsis" title="<?= htmlspecialchars($s['description'] ?? '') ?>">
                                            <?= htmlspecialchars($s['description'] ?? '') ?>
                                        </td>
                                        <td><?= htmlspecialchars($s['applyDate'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($s['applicationDeadline'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($s['university'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($s['department'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($profLabel) ?></td>
                                        <td>
                                            <?php if (!empty($s['link'])): ?>
                                                <a class="link" href="<?= htmlspecialchars($s['link']) ?>" target="_blank" rel="noopener">Open</a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($s['createdAt'] ?? '') ?></td>
                                        <td>
                                            <a class="btn small" href="edit-scholarship.php?id=<?= (int)$s['id'] ?>" style="text-decoration:none;">
                                                <i class="fa-regular fa-pen-to-square"></i> Edit
                                            </a>
                                            <form action="scholarship-list.php?<?= htmlspecialchars($_SERVER['QUERY_STRING'] ?? '') ?>"
                                                method="post" style="display:inline-block;"
                                                onsubmit="return confirm('Delete this scholarship?');">
                                                <input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
                                                <button class="btn small danger" type="submit" name="delete">
                                                    <i class="fa-regular fa-trash-can"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr class="empty-row">
                                    <td colspan="12" style="text-align:center; color:#64748b; padding:24px;">
                                        No scholarships found for the selected filters.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <div class="rows-meta" id="rowsMeta">
                        <?php
                        $from = $total ? ($offset + 1) : 0;
                        $to   = min($offset + $per_page, $total);
                        echo htmlspecialchars($from . '–' . $to . ' of ' . $total, ENT_QUOTES, 'UTF-8');
                        ?>
                    </div>
                    <div class="pagination" id="pagination">
                        <a class="page-btn <?= $page <= 1 ? 'disabled' : '' ?>"
                            href="<?= $page <= 1 ? 'javascript:void(0)' : link_with_params_s(['page' => 1]) ?>"
                            style="text-decoration: none;">First</a>

                        <a class="page-btn <?= $page <= 1 ? 'disabled' : '' ?>"
                            href="<?= $page <= 1 ? 'javascript:void(0)' : link_with_params_s(['page' => $page - 1]) ?>"
                            style="text-decoration: none;">Prev</a>

                        <?php
                        $window = 5;
                        $start = max(1, $page - intdiv($window, 2));
                        $end = min($total_pages, $start + $window - 1);
                        $start = max(1, $end - $window + 1);
                        for ($p = $start; $p <= $end; $p++):
                        ?>
                            <a class="page-btn <?= $p === $page ? 'active' : '' ?>"
                                href="<?= link_with_params_s(['page' => $p]) ?>"
                                style="text-decoration: none;"><?= $p ?></a>
                        <?php endfor; ?>

                        <a class="page-btn <?= $page >= $total_pages ? 'disabled' : '' ?>"
                            href="<?= $page >= $total_pages ? 'javascript:void(0)' : link_with_params_s(['page' => $page + 1]) ?>"
                            style="text-decoration: none;">Next</a>

                        <a class="page-btn <?= $page >= $total_pages ? 'disabled' : '' ?>"
                            href="<?= $page >= $total_pages ? 'javascript:void(0)' : link_with_params_s(['page' => $total_pages]) ?>"
                            style="text-decoration: none;">Last</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>