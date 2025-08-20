<?php
$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Administrator';
?>
<header style="
  height:60px;background:#fff;box-shadow:0 2px 10px rgba(0,0,0,.06);
  display:flex;align-items:center;justify-content:space-between;
  padding:0 18px;position:sticky;top:0;z-index:90;">
    <div>
        <h2 style="color:#ef5350;font-size:1.25rem;font-weight:700;margin:0;">Admin Dashboard</h2>
    </div>
    <div style="display:flex;align-items:center;">
        <div style="display:flex;align-items:center;">
            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($admin_name); ?>&background=ef5350&color=fff"
                alt="User Avatar" style="width:40px;height:40px;border-radius:50%;margin-right:10px;">
            <div>
                <h4 style="font-size:.95rem;margin:0 0 2px 0;font-weight:700;"><?php echo htmlspecialchars($admin_name); ?></h4>
                <p style="font-size:.75rem;color:#7f8c8d;margin:0;">Online</p>
            </div>
        </div>
    </div>
</header>