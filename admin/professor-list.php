<?php
require '../config/database.php';
require __DIR__ . '/auth-check.php';

$active_page = 'professors';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'], $_POST['id'])) {
    $id = (int)$_POST['id'];

    $img = '';
    if ($stmt = mysqli_prepare($conn, "SELECT image FROM professors WHERE id = ?")) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $img);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    if ($stmt = mysqli_prepare($conn, "DELETE FROM professor_research_interests WHERE professor_id = ?")) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    if ($stmt = mysqli_prepare($conn, "DELETE FROM professors WHERE id = ?")) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            if ($img) {
                $abs = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . ltrim($img, '/\\');
                if (is_file($abs)) {
                    @unlink($abs);
                }
            }
            $_SESSION['professor-success'] = 'Professor deleted successfully.';
        } else {
            $_SESSION['professor-error'] = 'Failed to delete professor. (' . mysqli_error($conn) . ')';
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['professor-error'] = 'Delete failed (prepare error).';
    }

    $qs = $_SERVER['QUERY_STRING'] ?? '';
    header('Location: professor-list.php' . ($qs ? ('?' . $qs) : ''));
    exit;
}

$q            = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$availability = isset($_GET['availability']) ? trim((string)$_GET['availability']) : '';
$per_page     = isset($_GET['per_page']) ? max(1, (int)$_GET['per_page']) : 10;
$page         = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

if (!in_array($availability, ['', 'available', 'not available'], true)) {
    $availability = '';
}

$where   = [];
$params  = [];
$types   = '';
$joinForSearch = false;

if ($q !== '') {
    $where[] = "(p.name LIKE ? OR p.contact_email LIKE ? OR p.contact_phone LIKE ? OR p.country LIKE ? OR p.university_name LIKE ? OR pri.interest LIKE ?)";
    $like = '%' . $q . '%';
    array_push($params, $like, $like, $like, $like, $like, $like);
    $types .= 'ssssss';
    $joinForSearch = true;
}

if ($availability !== '') {
    $where[] = "p.availability = ?";
    $params[] = $availability;
    $types   .= 's';
}

$whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

$total = 0;
$sqlCount = "SELECT COUNT(DISTINCT p.id)
             FROM professors p
             " . ($joinForSearch ? "LEFT JOIN professor_research_interests pri ON pri.professor_id = p.id" : "") . "
             $whereSql";

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

$professors = [];
$sql = "SELECT
            p.id,
            p.name,
            p.country,
            p.university_name,
            p.image,
            p.contact_email,
            p.contact_phone,
            p.availability,
            p.profileLink,
            GROUP_CONCAT(DISTINCT pri.interest ORDER BY pri.interest SEPARATOR ', ') AS interests_str
        FROM professors p
        LEFT JOIN professor_research_interests pri ON pri.professor_id = p.id
        $whereSql
        GROUP BY p.id
        ORDER BY p.id DESC
        LIMIT $per_page OFFSET $offset";

if ($stmt = mysqli_prepare($conn, $sql)) {
    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $row['_availability'] = (strtolower(trim((string)$row['availability'])) === 'available') ? 'available' : 'not available';
            $img = trim((string)$row['image']);
            $row['_image_url'] = $img;
            $professors[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['professor-error'] = 'Failed to load professors. (' . mysqli_error($conn) . ')';
}

function link_with_params($overrides = [])
{
    $params = [
        'q' => $_GET['q'] ?? '',
        'availability' => $_GET['availability'] ?? '',
        'per_page' => $_GET['per_page'] ?? 10,
        'page' => $_GET['page'] ?? 1,
    ];
    foreach ($overrides as $k => $v) $params[$k] = $v;
    $qs = http_build_query(array_filter($params, fn($v) => $v !== '' && $v !== null));
    return 'professor-list.php' . ($qs ? ('?' . $qs) : '');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Professor List - EduLink Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="styles/professor-list.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <?php include __DIR__ . '/common/sidebar.php'; ?>

    <main class="main-content">
        <?php include __DIR__ . '/common/navbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <h1 class="page-title"><i class="fa-solid fa-user-graduate"></i> Professor List</h1>
                <div class="header-actions" style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a href="add-professor.php" class="btn" style="text-decoration: none;"><i class="fa-solid fa-plus"></i> Add Professor</a>
                </div>
            </div>

            <?php if (!empty($_SESSION['professor-success'])): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= htmlspecialchars($_SESSION['professor-success']) ?></span>
                </div>
                <?php unset($_SESSION['professor-success']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['professor-error'])): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['professor-error']) ?></span>
                </div>
                <?php unset($_SESSION['professor-error']); ?>
            <?php endif; ?>

            <form class="toolbar" method="get" action="professor-list.php" style="display:grid; grid-template-columns:1fr 200px 160px auto; gap:10px;">
                <input class="input" type="search" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search by name, email, phone, country, university or interests…" />
                <select class="select" name="availability">
                    <option value="" <?= $availability === '' ? 'selected' : ''; ?>>All Availability</option>
                    <option value="available" <?= $availability === 'available' ? 'selected' : ''; ?>>Available</option>
                    <option value="not available" <?= $availability === 'not available' ? 'selected' : ''; ?>>Not Available</option>
                </select>
                <select class="select" name="per_page">
                    <?php foreach ([10, 20, 50, 100] as $opt): ?>
                        <option value="<?= $opt ?>" <?= $per_page === $opt ? 'selected' : ''; ?>><?= $opt ?> / page</option>
                    <?php endforeach; ?>
                </select>
                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <a class="btn secondary" href="professor-list.php" style="text-decoration: none;"><i class="fa-regular fa-circle-xmark"></i> Clear</a>
                    <button class="btn" type="submit"><i class="fa-solid fa-sliders"></i> Apply</button>
                </div>
            </form>

            <div class="card">
                <div class="table-wrap">
                    <table id="profTable">
                        <thead>
                            <tr>
                                <th style="width:72px;">ID</th>
                                <th style="width:72px;">Image</th>
                                <th>Name</th>
                                <th style="width:140px;">Country</th>
                                <th>University</th>
                                <th>Research Interests</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th style="width:140px;">Availability</th>
                                <th>Profile Link</th>
                                <th style="width:180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="profTbody">
                            <?php if (count($professors) > 0): ?>
                                <?php foreach ($professors as $prof): ?>
                                    <tr>
                                        <td><?= (int)$prof['id'] ?></td>
                                        <td>
                                            <?php if ($prof['_image_url'] !== ''): ?>
                                                <img class="avatar" src="../uploads/<?= htmlspecialchars($prof['_image_url']) ?>" alt="<?= htmlspecialchars($prof['name']) ?>">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($prof['name'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($prof['country'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($prof['university_name'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($prof['interests_str'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($prof['contact_email'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($prof['contact_phone'] ?? '') ?></td>
                                        <td>
                                            <?php $avail = $prof['_availability']; ?>
                                            <span class="badge <?= $avail === 'available' ? 'available' : 'not' ?>">
                                                <?= htmlspecialchars($avail) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!empty($prof['profileLink'])): ?>
                                                <a class="link" href="<?= htmlspecialchars($prof['profileLink']) ?>" target="_blank" rel="noopener">Open Profile</a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a class="btn small" href="edit-professor.php?id=<?= (int)$prof['id'] ?>" style="text-decoration: none;">
                                                <i class="fa-regular fa-pen-to-square"></i> Edit
                                            </a>
                                            <form action="professor-list.php?<?= htmlspecialchars($_SERVER['QUERY_STRING'] ?? '') ?>" method="post" style="display:inline-block;" onsubmit="return confirm('Delete this professor?');">
                                                <input type="hidden" name="id" value="<?= (int)$prof['id'] ?>">
                                                <button class="btn small danger" type="submit" name="delete">
                                                    <i class="fa-regular fa-trash-can"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr class="empty-row">
                                    <td colspan="11" style="text-align:center; color:#64748b; padding:24px;">
                                        No professors found for the selected filters.
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
                        <a class="page-btn <?= $page <= 1 ? 'disabled' : '' ?>" href="<?= $page <= 1 ? 'javascript:void(0)' : link_with_params(['page' => 1]) ?>" style="text-decoration: none;">First</a>
                        <a class="page-btn <?= $page <= 1 ? 'disabled' : '' ?>" href="<?= $page <= 1 ? 'javascript:void(0)' : link_with_params(['page' => $page - 1]) ?>" style="text-decoration: none;">Prev</a>
                        <?php
                        $window = 5;
                        $start = max(1, $page - intdiv($window, 2));
                        $end = min($total_pages, $start + $window - 1);
                        $start = max(1, $end - $window + 1);
                        for ($p = $start; $p <= $end; $p++):
                        ?>
                            <a class="page-btn <?= $p === $page ? 'active' : '' ?>" href="<?= link_with_params(['page' => $p]) ?>" style="text-decoration: none;"><?= $p ?></a>
                        <?php endfor; ?>
                        <a class="page-btn <?= $page >= $total_pages ? 'disabled' : '' ?>" href="<?= $page >= $total_pages ? 'javascript:void(0)' : link_with_params(['page' => $page + 1]) ?>" style="text-decoration: none;">Next</a>
                        <a class="page-btn <?= $page >= $total_pages ? 'disabled' : '' ?>" href="<?= $page >= $total_pages ? 'javascript:void(0)' : link_with_params(['page' => $total_pages]) ?>" style="text-decoration: none;">Last</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>