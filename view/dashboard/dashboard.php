<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../view/login.php");
    exit;
}
include '../../db/db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="nav-bar">
        <div class="container" style="background: transparent; box-shadow: none; padding: 0;">
            <a href="../../index.php" class="active">Dashboard</a>
            <a href="../../view/users/list.php">Users</a>
            <a href="../../view/branches/list.php">Branches</a>
            <a href="../../view/catalog/list.php">Catalog</a>
            <a href="../../view/reports/dashboard.php">Reports</a>
            <a href="../../controller/AuthController.php?action=logout" style="float: right;">Logout</a>
        </div>
    </div>

    <div class="nav-bar">
        <div class="container" style="background: transparent; box-shadow: none; padding: 0;">
            <a href="../../index.php" class="active">Dashboard</a>
            <a href="../../view/users/list.php">Users</a>
            <a href="../../view/branches/list.php">Branches</a>
            <a href="../../view/catalog/list.php">Catalog</a>
            <a href="../../view/reports/dashboard.php">Reports</a>
            <a href="../../view/announcements/list.php">Announcements</a>
            <a href="../../view/export/export.php">Export</a>
            <a href="../../controller/AuthController.php?action=logout" class="logout">Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>Dashboard Overview</h1>
        
        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <div class="number">
                    <?php
                    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"));
                    echo $count['count'] ?? 0;
                    ?>
                </div>
            </div>

            <div class="stat-card">
                <h3>Total Books</h3>
                <div class="number">
                    <?php
                    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM books"));
                    echo $count['count'] ?? 0;
                    ?>
                </div>
            </div>

            <div class="stat-card">
                <h3>Active Borrows</h3>
                <div class="number">
                    <?php
                    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM borrow_records WHERE status = 'active'"));
                    echo $count['count'] ?? 0;
                    ?>
                </div>
            </div>

            <div class="stat-card">
                <h3>Branches</h3>
                <div class="number">
                    <?php
                    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM branches"));
                    echo $count['count'] ?? 0;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
