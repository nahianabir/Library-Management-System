<?php

if(isset($_SESSION['user_id'])) {
    include_once __DIR__ . '/../db/database.php';
    $sid = $_SESSION['user_id'];
    $sres = mysqli_query($conn, "SELECT name, profile_pic FROM users WHERE id='$sid'");
    $sdata = mysqli_fetch_assoc($sres);
    $sidebar_name = $sdata['name'] ?? $_SESSION['name'] ?? 'Manager';
    $sidebar_pic  = $sdata['profile_pic'] ?? '';
} else {
    $sidebar_name = 'Manager';
    $sidebar_pic  = '';
}
?>
<style>
body{
    margin:0;
    font-family:Arial;
    background:#f1f5f9;
}

.sidebar{
    width:260px;
    height:100vh;
    background:#0f172a;
    position:fixed;
    top:0;
    left:0;
    overflow-y:auto;
    z-index:1000;
}

/* ── Profile section ── */
.sidebar-profile{
    display:flex;
    flex-direction:column;
    align-items:center;
    padding:22px 16px 16px;
    border-bottom:1px solid #334155;
    gap:10px;
}

.sidebar-profile img{
    width:72px;
    height:72px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #2563eb;
}

.sidebar-profile .profile-avatar{
    width:72px;
    height:72px;
    border-radius:50%;
    background:#2563eb;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    font-weight:bold;
    color:white;
    border:3px solid #3b82f6;
}

.sidebar-profile .profile-name{
    color:white;
    font-weight:600;
    font-size:15px;
    text-align:center;
    line-height:1.3;
}

.sidebar-profile .profile-role{
    color:#94a3b8;
    font-size:12px;
}

.sidebar-profile-actions{
    display:flex;
    gap:8px;
    margin-top:4px;
}

.sidebar-profile-actions a{
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:6px 12px !important;
    border-radius:6px;
    font-size:12px;
    text-decoration:none;
    transition:0.2s;
    color:#e2e8f0 !important;
}

.sidebar-profile-actions a.btn-profile{
    background:#1e3a5f;
}

.sidebar-profile-actions a.btn-profile:hover{
    background:#2563eb !important;
    padding-left:12px !important;
}

.sidebar-profile-actions a.btn-logout{
    background:#3b1f1f;
    color:#fca5a5 !important;
}

.sidebar-profile-actions a.btn-logout:hover{
    background:#7f1d1d !important;
    padding-left:12px !important;
}

/* ── Title ── */
.sidebar h2{
    color:white;
    text-align:center;
    padding:16px 0;
    border-bottom:1px solid #334155;
    margin:0;
    font-size:16px;
    letter-spacing:0.5px;
    text-transform:uppercase;
}

.sidebar a{
    display:block;
    color:#e2e8f0;
    text-decoration:none;
    padding:14px 20px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#1e293b;
    padding-left:25px;
}

.sidebar a.active{
    background:#2563eb;
    border-left:4px solid #60a5fa;
}

.main-content{
    margin-left:260px;
    padding:20px;
    min-height:100vh;
}
</style>

<div class="sidebar">

<!-- ── Profile Section ── -->
<div class="sidebar-profile">

<?php if($sidebar_pic != ''): ?>
    <img src="../assets/profile/<?php echo htmlspecialchars($sidebar_pic); ?>" alt="Profile">
<?php else: ?>
    <div class="profile-avatar">
        <?php echo strtoupper(substr($sidebar_name, 0, 1)); ?>
    </div>
<?php endif; ?>

    <div class="profile-name"><?php echo htmlspecialchars($sidebar_name); ?></div>
    <div class="profile-role">Branch Manager</div>

    <div class="sidebar-profile-actions">
        <a href="profile.php" class="btn-profile">&#128100; Profile</a>
        <a href="login.php" class="btn-logout">&#128274; Logout</a>
    </div>

</div>

<h2>Manager Panel</h2>

<a href="dashboard.php" <?php if(basename($_SERVER['PHP_SELF'])=='dashboard.php') echo 'class="active"'; ?>>
Dashboard
</a>

<a href="branches.php" <?php if(basename($_SERVER['PHP_SELF'])=='branches.php') echo 'class="active"'; ?>>
Manage Branches
</a>

<a href="policies.php" <?php if(basename($_SERVER['PHP_SELF'])=='policies.php') echo 'class="active"'; ?>>
Policies
</a>

<a href="requests.php" <?php if(basename($_SERVER['PHP_SELF'])=='requests.php') echo 'class="active"'; ?>>
Transfer Requests
</a>

<a href="reports.php" <?php if(basename($_SERVER['PHP_SELF'])=='reports.php') echo 'class="active"'; ?>>
Reports
</a>

<a href="librarian.php" <?php if(basename($_SERVER['PHP_SELF'])=='librarian.php') echo 'class="active"'; ?>>
Assign Librarians
</a>

<a href="inventory_report.php" <?php if(basename($_SERVER['PHP_SELF'])=='inventory_report.php') echo 'class="active"'; ?>>
Inventory Report
</a>

<a href="update_inventory.php" <?php if(basename($_SERVER['PHP_SELF'])=='update_inventory.php') echo 'class="active"'; ?>>
Update Inventory
</a>

<a href="announcements.php" <?php if(basename($_SERVER['PHP_SELF'])=='announcements.php') echo 'class="active"'; ?>>
Announcements
</a>

<a href="platform_announcements.php" <?php if(basename($_SERVER['PHP_SELF'])=='platform_announcements.php') echo 'class="active"'; ?>>
Platform Announcements
</a>

<a href="profile.php" <?php if(basename($_SERVER['PHP_SELF'])=='profile.php') echo 'class="active"'; ?>>
Manage Profile
</a>

<a href="overdue_alerts.php" <?php if(basename($_SERVER['PHP_SELF'])=='overdue_alerts.php') echo 'class="active"'; ?>>
Overdue Alerts
</a>

<a href="monthly_branch_reports.php" <?php if(basename($_SERVER['PHP_SELF'])=='monthly_branch_reports.php') echo 'class="active"'; ?>>
Monthly Reports
</a>

<a href="member_reports.php" <?php if(basename($_SERVER['PHP_SELF'])=='member_reports.php') echo 'class="active"'; ?>>
Member Reports
</a>

<a href="most_borrowed_books.php" <?php if(basename($_SERVER['PHP_SELF'])=='most_borrowed_books.php') echo 'class="active"'; ?>>
Most Borrowed Books
</a>

<a href="branch_statistics.php" <?php if(basename($_SERVER['PHP_SELF'])=='branch_statistics.php') echo 'class="active"'; ?>>
Branch Statistics
</a>

<a href="fine_reports.php" <?php if(basename($_SERVER['PHP_SELF'])=='fine_reports.php') echo 'class="active"'; ?>>
Fine Reports
</a>

<a href="librarian_activity.php" <?php if(basename($_SERVER['PHP_SELF'])=='librarian_activity.php') echo 'class="active"'; ?>>
Librarian Activity
</a>


</div>
