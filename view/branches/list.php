<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../view/login.php");
    exit;
}
include '../../db/db.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$query = "SELECT b.*, 
    (SELECT COUNT(*) FROM users WHERE role = 'branch_manager' AND id = b.manager_id) as has_manager,
    (SELECT name FROM users WHERE id = b.manager_id LIMIT 1) as manager_name,
    (SELECT COUNT(*) FROM users WHERE branch_id = b.id AND role = 'librarian') as librarian_count
    FROM branches b WHERE 1=1";

if ($search) {
    $query .= " AND (b.name LIKE '%$search%' OR b.city LIKE '%$search%')";
}
$query .= " ORDER BY b.created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Branches List</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="nav-bar">
        <div class="container" style="background: transparent; box-shadow: none; padding: 0;">
            <a href="../../index.php">Dashboard</a>
            <a href="../../view/users/list.php">Users</a>
            <a href="../../view/branches/list.php" class="active">Branches</a>
            <a href="../../view/catalog/list.php">Catalog</a>
            <a href="../../view/reports/dashboard.php">Reports</a>
            <a href="../../view/announcements/list.php">Announcements</a>
            <a href="../../view/export/export.php">Export</a>
            <a href="../../controller/AuthController.php?action=logout" class="logout">Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>Branches Management</h1>
        <p style="color: #666; font-size: 14px; margin: 10px 0;">View and manage all library branches across the platform</p>
        
        <div style="margin: 15px 0; padding: 15px; background: #f9f9f9; border-radius: 5px;">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; align-items: end;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Search Branch:</label>
                    <input type="text" name="search" placeholder="Branch name or city" value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <button type="submit" style="background: #3498db;">Search</button>
                <a href="list.php"><button type="button" style="background: #95a5a6;">Clear</button></a>
            </form>
        </div>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Branch Name</th>
                <th>City</th>
                <th>Phone</th>
                <th>Manager</th>
                <th>Librarians</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['city']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td>
                    <?php if ($row['manager_name']) { ?>
                        <?php echo htmlspecialchars($row['manager_name']); ?>
                    <?php } else { ?>
                        <span style="color: #e74c3c; font-size: 12px;">Not Assigned</span>
                    <?php } ?>
                </td>
                <td>
                    <span class="status-badge status-active"><?php echo $row['librarian_count']; ?> Librarian(s)</span>
                </td>
                <td class="action-buttons">
                    <a href="detail.php?id=<?php echo $row['id']; ?>"><button>Manage</button></a>
                    <a href="edit.php?id=<?php echo $row['id']; ?>"><button>Edit</button></a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
