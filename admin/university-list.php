<?php
require '../config/database.php';
require __DIR__ . '/auth-check.php';

$active_page = 'university-list';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'], $_POST['id'])) {
    $id = (int)$_POST['id'];

    $img = '';
    if ($stmt = mysqli_prepare($conn, "SELECT image FROM universities WHERE id = ?")) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $img);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    if ($stmt = mysqli_prepare($conn, "DELETE FROM universities WHERE id = ?")) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            if ($img) {
                $abs = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . ltrim($img, '/\\');
                if (is_file($abs)) {
                    @unlink($abs);
                }
            }
            $_SESSION['university-success'] = 'University deleted successfully.';
        } else {
            $_SESSION['university-error'] = 'Failed to delete university. (' . mysqli_error($conn) . ')';
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['university-error'] = 'Delete failed (prepare error).';
    }

    $qs = $_SERVER['QUERY_STRING'] ?? '';
    header('Location: university-list.php' . ($qs ? ('?' . $qs) : ''));
    exit;
}

$q          = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$program    = isset($_GET['program']) ? trim((string)$_GET['program']) : '';
$per_page   = isset($_GET['per_page']) ? max(1, (int)$_GET['per_page']) : 10;
$page       = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

if (!in_array($program, ['', 'undergraduate', 'postgraduate', 'Ph.D.'], true)) {
    $program = '';
}

$where   = [];
$params  = [];
$types   = '';

if ($q !== '') {
    $where[] = "(name LIKE ? OR location LIKE ? OR discipline LIKE ? OR admissionLink LIKE ?)";
    $like = '%' . $q . '%';
    array_push($params, $like, $like, $like, $like);
    $types .= 'ssss';
}

if ($program !== '') {
    $where[] = "programType = ?";
    $params[] = $program;
    $types   .= 's';
}

$whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';


$total = 0;
$sqlCount = "SELECT COUNT(*) FROM universities $whereSql";
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


$universities = [];
$sql = "SELECT id, name, location, programType, discipline, admissionLink,
               applicationDate, applicationDeadline, admitCardDownloadDate, image,
               createdAt, updatedAt
        FROM universities
        $whereSql
        ORDER BY id DESC
        LIMIT $per_page OFFSET $offset";

if ($stmt = mysqli_prepare($conn, $sql)) {
    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $img = trim((string)$row['image']);
            $row['_image_url'] = $img !== '' ? "../uploads/" . $img : '';
            $universities[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['university-error'] = 'Failed to load universities. (' . mysqli_error($conn) . ')';
}

function uni_link_with_params($overrides = [])
{
    $params = [
        'q'        => $_GET['q'] ?? '',
        'program'  => $_GET['program'] ?? '',
        'per_page' => $_GET['per_page'] ?? 10,
        'page'     => $_GET['page'] ?? 1,
    ];
    foreach ($overrides as $k => $v) $params[$k] = $v;
    $qs = http_build_query(array_filter($params, fn($v) => $v !== '' && $v !== null));
    return 'university-list.php' . ($qs ? ('?' . $qs) : '');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>University List - EduLink Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="styles/university-list.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <?php include __DIR__ . '/common/sidebar.php'; ?>

    <main class="main-content">
        <?php include __DIR__ . '/common/navbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <h1 class="page-title"><i class="fa-solid fa-building-columns"></i> University List</h1>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a href="add-university.php" class="btn" style="text-decoration: none;"><i class="fa-solid fa-plus"></i> Add University</a>
                </div>
            </div>

            <?php if (!empty($_SESSION['university-success'])): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= htmlspecialchars($_SESSION['university-success']) ?></span>
                </div>
                <?php unset($_SESSION['university-success']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['add-university-success'])): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= htmlspecialchars($_SESSION['add-university-success']) ?></span>
                </div>
                <?php unset($_SESSION['add-university-success']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['university-error'])): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['university-error']) ?></span>
                </div>
                <?php unset($_SESSION['university-error']); ?>
            <?php endif; ?>

            <form class="toolbar" method="get" action="university-list.php" style="display:grid; grid-template-columns:1fr 200px 160px auto; gap:10px;">
                <input class="input" type="search" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search by university, location, discipline, or link…" />
                <select class="select" name="program">
                    <option value="" <?= $program === '' ? 'selected' : ''; ?>>All Program Types</option>
                    <option value="undergraduate" <?= $program === 'undergraduate' ? 'selected' : ''; ?>>Undergraduate</option>
                    <option value="postgraduate" <?= $program === 'postgraduate' ? 'selected' : ''; ?>>Postgraduate</option>
                    <option value="Ph.D." <?= $program === 'Ph.D.'        ? 'selected' : ''; ?>>Ph.D.</option>
                </select>
                <select class="select" name="per_page">
                    <?php foreach ([10, 20, 50, 100] as $opt): ?>
                        <option value="<?= $opt ?>" <?= $per_page === $opt ? 'selected' : ''; ?>><?= $opt ?> / page</option>
                    <?php endforeach; ?>
                </select>
                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <a class="btn secondary" href="university-list.php" style="text-decoration: none;"><i class="fa-regular fa-circle-xmark"></i> Clear</a>
                    <button class="btn" type="submit"><i class="fa-solid fa-sliders"></i> Apply</button>
                </div>
            </form>

            <div class="card">
                <div class="table-wrap">
                    <table id="uniTable">
                        <thead>
                            <tr>
                                <th style="width:72px;">ID</th>
                                <th style="width:80px;">Image</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th style="width:150px;">Program Type</th>
                                <th>Discipline</th>
                                <th style="width:160px;">Application Start</th>
                                <th style="width:160px;">Application Deadline</th>
                                <th style="width:180px;">Admit Card Date</th>
                                <th>Admission Link</th>
                                <th style="width:160px;">Created At</th>
                                <th style="width:160px;">Updated At</th>
                                <th style="width:180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="uniTbody">
                            <?php if (count($universities) > 0): ?>
                                <?php foreach ($universities as $u): ?>
                                    <tr>
                                        <td><?= (int)$u['id'] ?></td>
                                        <td>
                                            <?php if ($u['_image_url'] !== ''): ?>
                                                <img class="banner" src="<?= htmlspecialchars($u['_image_url']) ?>" alt="<?= htmlspecialchars($u['name']) ?>">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($u['name'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($u['location'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($u['programType'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($u['discipline'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($u['applicationDate'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($u['applicationDeadline'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($u['admitCardDownloadDate'] ?? '') ?></td>
                                        <td>
                                            <?php if (!empty($u['admissionLink'])): ?>
                                                <a class="link" href="<?= htmlspecialchars($u['admissionLink']) ?>" target="_blank" rel="noopener">Open</a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($u['createdAt'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($u['updatedAt'] ?? '') ?></td>
                                        <td>
                                            <a class="btn small" href="edit-university.php?id=<?= (int)$u['id'] ?>" style="text-decoration: none;">
                                                <i class="fa-regular fa-pen-to-square"></i> Edit
                                            </a>
                                            <form action="university-list.php?<?= htmlspecialchars($_SERVER['QUERY_STRING'] ?? '') ?>" method="post" style="display:inline-block;" onsubmit="return confirm('Delete this university?');">
                                                <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                                                <button class="btn small danger" type="submit" name="delete">
                                                    <i class="fa-regular fa-trash-can"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr class="empty-row">
                                    <td colspan="13" style="text-align:center; color:#64748b; padding:24px;">
                                        No universities found for the selected filters.
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
                        <a class="page-btn <?= $page <= 1 ? 'disabled' : '' ?>" href="<?= $page <= 1 ? 'javascript:void(0)' : uni_link_with_params(['page' => 1]) ?>" style="text-decoration: none;">First</a>
                        <a class="page-btn <?= $page <= 1 ? 'disabled' : '' ?>" href="<?= $page <= 1 ? 'javascript:void(0)' : uni_link_with_params(['page' => $page - 1]) ?>" style="text-decoration: none;">Prev</a>
                        <?php
                        $window = 5;
                        $start = max(1, $page - intdiv($window, 2));
                        $end = min($total_pages, $start + $window - 1);
                        $start = max(1, $end - $window + 1);
                        for ($p = $start; $p <= $end; $p++):
                        ?>
                            <a class="page-btn <?= $p === $page ? 'active' : '' ?>" href="<?= uni_link_with_params(['page' => $p]) ?>" style="text-decoration: none;"><?= $p ?></a>
                        <?php endfor; ?>
                        <a class="page-btn <?= $page >= $total_pages ? 'disabled' : '' ?>" href="<?= $page >= $total_pages ? 'javascript:void(0)' : uni_link_with_params(['page' => $page + 1]) ?>" style="text-decoration: none;">Next</a>
                        <a class="page-btn <?= $page >= $total_pages ? 'disabled' : '' ?>" href="<?= $page >= $total_pages ? 'javascript:void(0)' : uni_link_with_params(['page' => $total_pages]) ?>" style="text-decoration: none;">Last</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>