<?php
require '../config/database.php';
require __DIR__ . '/auth-check.php';

$active_page = 'book-list';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'], $_POST['id'])) {
    $id = (int)$_POST['id'];

    $img = '';
    if ($stmt = mysqli_prepare($conn, "SELECT image FROM books WHERE id = ?")) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $img);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    if ($stmt = mysqli_prepare($conn, "DELETE FROM books WHERE id = ?")) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            if ($img) {
                $abs = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . ltrim($img, '/\\');
                if (is_file($abs)) {
                    @unlink($abs);
                }
            }
            $_SESSION['book-success'] = 'Book deleted successfully.';
        } else {
            $_SESSION['book-error'] = 'Failed to delete book. (' . mysqli_error($conn) . ')';
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['book-error'] = 'Delete failed (prepare error).';
    }

    $qs = $_SERVER['QUERY_STRING'] ?? '';
    header('Location: book-list.php' . ($qs ? ('?' . $qs) : ''));
    exit;
}

$q        = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$category = isset($_GET['category']) ? trim((string)$_GET['category']) : '';
$paid     = isset($_GET['paid']) ? trim((string)$_GET['paid']) : '';
$per_page = isset($_GET['per_page']) ? max(1, (int)$_GET['per_page']) : 10;
$page     = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

if (!in_array($category, ['', 'Admission', 'Job Exam', 'Skill-Based'], true)) {
    $category = '';
}
if (!in_array($paid, ['', 'paid', 'free'], true)) {
    $paid = '';
}

$where   = [];
$params  = [];
$types   = '';

if ($q !== '') {
    $where[] = "(title LIKE ? OR author LIKE ? OR category LIKE ? OR description LIKE ? OR suggestedFor LIKE ?)";
    $like = '%' . $q . '%';
    array_push($params, $like, $like, $like, $like, $like);
    $types .= 'sssss';
}

if ($category !== '') {
    $where[] = "category = ?";
    $params[] = $category;
    $types   .= 's';
}

if ($paid === 'paid') {
    $where[] = "isPaid = 1";
} elseif ($paid === 'free') {
    $where[] = "isPaid = 0";
}

$whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';


$total = 0;
$sqlCount = "SELECT COUNT(*) FROM books $whereSql";
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

$books = [];
$sql = "SELECT id, title, image, author, category, price, isPaid, pdf
        FROM books
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
            $row['_paid_text'] = ((int)$row['isPaid'] === 1) ? 'Paid' : 'Free';
            $row['_paid_badge'] = ((int)$row['isPaid'] === 1) ? 'paid' : 'free';
            $books[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['book-error'] = 'Failed to load books. (' . mysqli_error($conn) . ')';
}

function link_with_params($overrides = [])
{
    $params = [
        'q'        => $_GET['q'] ?? '',
        'category' => $_GET['category'] ?? '',
        'paid'     => $_GET['paid'] ?? '',
        'per_page' => $_GET['per_page'] ?? 10,
        'page'     => $_GET['page'] ?? 1,
    ];
    foreach ($overrides as $k => $v) $params[$k] = $v;
    $qs = http_build_query(array_filter($params, fn($v) => $v !== '' && $v !== null));
    return 'book-list.php' . ($qs ? ('?' . $qs) : '');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Book List - EduLink Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="styles/book-list.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <?php include __DIR__ . '/common/sidebar.php'; ?>

    <main class="main-content">
        <?php include __DIR__ . '/common/navbar.php'; ?>

        <div class="content">
            <div class="page-header">
                <h1 class="page-title"><i class="fa-solid fa-book-open"></i> Book List</h1>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a href="add-book.php" class="btn" style="text-decoration: none;"><i class="fa-solid fa-plus"></i> Add Book</a>
                </div>
            </div>

            <?php if (!empty($_SESSION['book-success'])): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= htmlspecialchars($_SESSION['book-success']) ?></span>
                </div>
                <?php unset($_SESSION['book-success']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['book-error'])): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['book-error']) ?></span>
                </div>
                <?php unset($_SESSION['book-error']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['edit-book-success'])): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= htmlspecialchars($_SESSION['edit-book-success']) ?></span>
                </div>
                <?php unset($_SESSION['edit-book-success']); ?>
            <?php endif; ?>

            <form class="toolbar" method="get" action="book-list.php" style="display:grid; grid-template-columns:1fr 200px 160px 160px auto; gap:10px;">
                <input class="input" type="search" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search by title, author, category, or keywords…" />
                <select class="select" name="category">
                    <option value="" <?= $category === '' ? 'selected' : ''; ?>>All Categories</option>
                    <option value="Admission" <?= $category === 'Admission'   ? 'selected' : ''; ?>>Admission</option>
                    <option value="Job Exam" <?= $category === 'Job Exam'    ? 'selected' : ''; ?>>Job Exam</option>
                    <option value="Skill-Based" <?= $category === 'Skill-Based' ? 'selected' : ''; ?>>Skill-Based</option>
                </select>
                <select class="select" name="paid">
                    <option value="" <?= $paid === '' ? 'selected' : ''; ?>>Paid & Free</option>
                    <option value="paid" <?= $paid === 'paid' ? 'selected' : ''; ?>>Paid</option>
                    <option value="free" <?= $paid === 'free' ? 'selected' : ''; ?>>Free</option>
                </select>
                <select class="select" name="per_page">
                    <?php foreach ([10, 20, 50, 100] as $opt): ?>
                        <option value="<?= $opt ?>" <?= $per_page === $opt ? 'selected' : ''; ?>><?= $opt ?> / page</option>
                    <?php endforeach; ?>
                </select>
                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <a class="btn secondary" href="book-list.php" style="text-decoration: none;"><i class="fa-regular fa-circle-xmark"></i> Clear</a>
                    <button class="btn" type="submit"><i class="fa-solid fa-sliders"></i> Apply</button>
                </div>
            </form>

            <div class="card">
                <div class="table-wrap">
                    <table id="bookTable">
                        <thead>
                            <tr>
                                <th style="width:72px;">ID</th>
                                <th style="width:78px;">Cover</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th style="width:150px;">Category</th>
                                <th style="width:110px;">Price</th>
                                <th style="width:110px;">Paid?</th>
                                <th style="width:120px;">PDF</th>
                                <th style="width:180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="bookTbody">
                            <?php if (count($books) > 0): ?>
                                <?php foreach ($books as $b): ?>
                                    <tr>
                                        <td><?= (int)$b['id'] ?></td>
                                        <td>
                                            <?php if ($b['_image_url'] !== ''): ?>
                                                <img class="cover" src="<?= htmlspecialchars($b['_image_url']) ?>" alt="<?= htmlspecialchars($b['title']) ?>">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($b['title'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($b['author'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($b['category'] ?? '') ?></td>
                                        <td><?= is_null($b['price']) ? '-' : number_format((float)$b['price'], 2) ?></td>
                                        <td><span class="badge <?= $b['_paid_badge'] ?>"><?= $b['_paid_text'] ?></span></td>
                                        <td>
                                            <?php if (!empty($b['pdf'])): ?>
                                                <a class="link" href="<?= htmlspecialchars($b['pdf']) ?>" target="_blank" rel="noopener">Open PDF</a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a class="btn small" href="edit-book.php?id=<?= (int)$b['id'] ?>" style="text-decoration: none;">
                                                <i class="fa-regular fa-pen-to-square"></i> Edit
                                            </a>
                                            <form action="book-list.php?<?= htmlspecialchars($_SERVER['QUERY_STRING'] ?? '') ?>" method="post" style="display:inline-block;" onsubmit="return confirm('Delete this book?');">
                                                <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                                                <button class="btn small danger" type="submit" name="delete">
                                                    <i class="fa-regular fa-trash-can"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr class="empty-row">
                                    <td colspan="9" style="text-align:center; color:#64748b; padding:24px;">
                                        No books found for the selected filters.
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