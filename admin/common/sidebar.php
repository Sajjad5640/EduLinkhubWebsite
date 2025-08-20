<?php
if (!isset($active_page)) {
    $active_page = '';
}

function sidebar_item(string $href, string $iconClass, string $label, string $key): void
{
    $active = ($GLOBALS['active_page'] === $key);

    $borderColor = $active ? '#ef5350' : 'transparent';
    $bg          = $active ? 'rgba(255,255,255,0.12)' : 'transparent';
    $color       = $active ? '#ffffff' : '#ecf0f1';
    $hoverBg     = 'rgba(255,255,255,0.08)';

    $style = "display:block;padding:14px 22px;color:$color;text-decoration:none;"
        . "border-left:4px solid $borderColor;background:$bg;";

    $onOver  = "this.style.background='$hoverBg';this.style.color='#fff';";
    $onOut   = "this.style.background='$bg';this.style.color='$color';";

    echo '<a href="' . htmlspecialchars($href) . '" style="' . $style . '" '
        . 'onmouseover="' . $onOver . '" onmouseout="' . $onOut . '">'
        . '<i class="' . htmlspecialchars($iconClass) . '" style="margin-right:10px;width:18px;text-align:center;"></i> '
        . htmlspecialchars($label)
        . '</a>';
}
?>

<aside class="sidebar" style="
  width:250px;background:#2c3e50;color:#ecf0f1;position:fixed;top:0;left:0;bottom:0;
  z-index:100;box-shadow:2px 0 10px rgba(0,0,0,.08);">
    <div class="sidebar-header" style="
      padding:20px;background:rgba(0,0,0,.15);display:flex;align-items:center;justify-content:center;">
        <h3 style="font-size:1.2rem;font-weight:700;color:#fff;margin:0;">EduLink Hub</h3>
    </div>

    <nav class="sidebar-menu" style="padding:10px 0;">

        <?php
        sidebar_item('index.php',              'fa-solid fa-gauge-high',        'Dashboard',           'index');

        sidebar_item('add-professor.php',      'fas fa-user-graduate',          'Add Professors',      'add-professor');
        sidebar_item('professor-list.php',     'fas fa-chalkboard-teacher',     'Professors',          'professors');


        sidebar_item('add-book.php',           'fas fa-book',                   'Add Book',            'add-book');
        sidebar_item('book-list.php',          'fas fa-book-open',              'Book List',           'book-list');

        sidebar_item('add-university.php',     'fa-solid fa-building-columns',  'Add University',      'add-university');
        sidebar_item('university-list.php',    'fa-solid fa-building-columns',  'Universities',        'university-list');


        sidebar_item('add-Scholarship.php',    'fas fa-money-bill-wave',        'Add Scholarships',    'add-scholarship');
        sidebar_item('scholarship-list.php',   'fas fa-money-bill-wave',        'Scholarships',        'scholarship-list');

        sidebar_item('reports.php',            'fas fa-chart-bar',              'Reports',             'reports');

        sidebar_item('logic/logout-logic.php', 'fa-solid fa-arrow-right-from-bracket', 'Logout', 'logout');
        ?>
    </nav>
</aside>