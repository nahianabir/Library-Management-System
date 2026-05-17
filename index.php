<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: view/login.php");
    exit;
}

include 'db/db.php';

$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Management System - Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="nav-bar">
        <div class="container" style="background: transparent; box-shadow: none; padding: 0;">
            <a href="index.php" class="active">Dashboard</a>
            <a href="view/users/list.php">Users</a>
            <a href="view/branches/list.php">Branches</a>
            <a href="view/catalog/list.php">Catalog</a>
            <a href="view/reports/dashboard.php">Reports</a>
            <a href="view/announcements/list.php">Announcements</a>
            <a href="view/export/export.php">Export</a>
            <a href="controller/AuthController.php?action=logout" class="logout">Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>Admin Dashboard - <?php echo htmlspecialchars($user['name']); ?></h1>
        <p style="color: #7f8c8d; margin-bottom: 30px;">Platform-wide overview and key metrics</p>
        
        <div class="dashboard-stats">
            <div class="stat-card info">
                <h3>Total Members</h3>
                <div class="number">
                    <?php
                    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role = 'member'"));
                    echo $count['count'];
                    ?>
                </div>
                <p style="font-size: 12px; color: #7f8c8d; margin-top: 10px;">Active library members</p>
            </div>

            <div class="stat-card success">
                <h3>Total Books</h3>
                <div class="number">
                    <?php
                    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM books"));
                    echo $count['count'];
                    ?>
                </div>
                <p style="font-size: 12px; color: #7f8c8d; margin-top: 10px;">In catalog</p>
            </div>

            <div class="stat-card info">
                <h3>Active Loans</h3>
                <div class="number">
                    <?php
                    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM borrow_records WHERE status = 'active'"));
                    echo $count['count'];
                    ?>
                </div>
                <p style="font-size: 12px; color: #7f8c8d; margin-top: 10px;">Currently borrowed</p>
            </div>

            <div class="stat-card warning">
                <h3>Overdue Loans</h3>
                <div class="number">
                    <?php
                    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM borrow_records WHERE status = 'active' AND due_date < NOW()"));
                    echo $count['count'];
                    ?>
                </div>
                <p style="font-size: 12px; color: #7f8c8d; margin-top: 10px;">Past due date</p>
            </div>

            <div class="stat-card danger">
                <h3>Outstanding Fines</h3>
                <div class="number">
                    <?php
                    $fines = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) as total FROM fines WHERE is_paid = 0"));
                    echo number_format($fines['total'] ?? 0, 2);
                    ?>
                </div>
                <p style="font-size: 12px; color: #7f8c8d; margin-top: 10px;">Pending collection</p>
            </div>

            <div class="stat-card info">
                <h3>Library Branches</h3>
                <div class="number">
                    <?php
                    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM branches"));
                    echo $count['count'];
                    ?>
                </div>
                <p style="font-size: 12px; color: #7f8c8d; margin-top: 10px;">Active branches</p>
            </div>
        </div>

        <h2>Quick Management Actions</h2>
        <div class="dashboard-actions">
            <a href="view/users/list.php">
                <button style="background: #3498db;">Manage Users & Roles</button>
            </a>
            <a href="view/users/create.php">
                <button style="background: #27ae60;">Add Librarian/Manager</button>
            </a>
            <a href="view/branches/list.php">
                <button style="background: #f39c12;">Manage Branches</button>
            </a>
            <a href="view/catalog/list.php">
                <button style="background: #9b59b6;">Global Catalog</button>
            </a>
            <a href="view/transfers/list.php">
                <button style="background: #e74c3c;">Transfer Requests</button>
            </a>
            <a href="view/complaints/list.php">
                <button style="background: #c0392b;">Complaints</button>
            </a>
            <a href="view/audit/logs.php">
                <button style="background: #34495e;">Audit Logs</button>
            </a>
            <a href="view/settings/system.php">
                <button style="background: #2c3e50;">System Settings</button>
            </a>
            <a href="view/reports/dashboard.php">
                <button style="background: #1abc9c;">View Reports</button>
            </a>
        </div>

        <!-- Announcements Section -->
        <h2 style="margin-top: 40px; color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px;">Recent Announcements</h2>
        <div style="margin: 15px 0; display: flex; gap: 10px;">
            <a href="view/announcements/list.php"><button style="background: #3498db;">View All</button></a>
            <a href="view/announcements/create.php"><button style="background: #27ae60;">+ New Announcement</button></a>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin: 20px 0;">
            <?php 
            $announcements_query = "SELECT a.id, a.title, a.body, a.published_at, u.name as author_name 
                                   FROM announcements a 
                                   JOIN users u ON a.author_id = u.id 
                                   ORDER BY a.published_at DESC 
                                   LIMIT 6";
            $announcements_result = mysqli_query($conn, $announcements_query);
            
            $announcement_count = 0;
            while ($ann = mysqli_fetch_assoc($announcements_result)) {
                $announcement_count++;
            ?>
            <div style="background: white; border: 1px solid #bdc3c7; border-radius: 5px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.2s;">
                <h4 style="margin: 0 0 10px 0; color: #2c3e50;">
                    <a href="view/announcements/detail.php?id=<?php echo $ann['id']; ?>" style="text-decoration: none; color: #3498db;">
                        <?php echo htmlspecialchars($ann['title']); ?>
                    </a>
                </h4>
                <p style="color: #7f8c8d; font-size: 12px; margin: 5px 0;">By <?php echo htmlspecialchars($ann['author_name']); ?> • <?php echo date('M d, Y', strtotime($ann['published_at'])); ?></p>
                <p style="color: #555; margin: 10px 0; line-height: 1.5;">
                    <?php echo htmlspecialchars(substr($ann['body'], 0, 100)) . (strlen($ann['body']) > 100 ? '...' : ''); ?>
                </p>
                <a href="view/announcements/detail.php?id=<?php echo $ann['id']; ?>" style="color: #3498db; text-decoration: none; font-size: 12px; font-weight: bold;">Read More →</a>
            </div>
            <?php } 
            
            if ($announcement_count == 0) {
                echo '<p style="color: #7f8c8d; grid-column: 1 / -1;">No announcements yet. <a href="view/announcements/create.php" style="color: #3498db;">Create one</a></p>';
            }
            ?>
        </div>

        <h2 style="margin-top: 40px;">System Information</h2>
        <table>
            <tr>
                <td><strong>Admin Name:</strong></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
            </tr>
            <tr>
                <td><strong>Role:</strong></td>
                <td><span class="status-badge status-active"><?php echo htmlspecialchars($user['role']); ?></span></td>
            </tr>
            <tr>
                <td><strong>Member Since:</strong></td>
                <td><?php echo htmlspecialchars($user['created_at']); ?></td>
            </tr>
        </table>
    </div>

    <script src="assets/js/admin.js"></script>
</body>
</html>
