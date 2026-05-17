<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../view/login.php");
    exit;
}
include '../../db/db.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$action_filter = isset($_GET['action']) ? mysqli_real_escape_string($conn, $_GET['action']) : '';

$query = "SELECT 
    al.id, al.user_id, al.action, al.entity_type, al.entity_id, 
    al.ip_address, al.created_at,
    u.name as user_name, u.email as user_email, u.role
FROM audit_logs al
JOIN users u ON al.user_id = u.id
WHERE 1=1";

if ($search) {
    $query .= " AND (al.action LIKE '%$search%' OR u.name LIKE '%$search%' OR u.email LIKE '%$search%')";
}

if ($action_filter) {
    $query .= " AND al.action LIKE '%$action_filter%'";
}

$query .= " ORDER BY al.created_at DESC LIMIT 500";
$result = mysqli_query($conn, $query);

// Get unique actions for filter
$actions_query = "SELECT DISTINCT action FROM audit_logs ORDER BY action";
$actions_result = mysqli_query($conn, $actions_query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Audit Logs</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="nav-bar">
        <div class="container" style="background: transparent; box-shadow: none; padding: 0;">
            <a href="../../index.php">Dashboard</a>
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
        <h1>Audit Logs</h1>
        <p style="color: #666; font-size: 14px; margin: 10px 0;">View all platform-wide actions performed by users (last 500 entries)</p>

        <div style="margin: 15px 0; padding: 15px; background: #f9f9f9; border-radius: 5px;">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; align-items: end;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Search:</label>
                    <input type="text" name="search" placeholder="User name, email, or action" value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Filter by Action:</label>
                    <select name="action">
                        <option value="">All Actions</option>
                        <?php while ($action = mysqli_fetch_assoc($actions_result)) { ?>
                            <option value="<?php echo htmlspecialchars($action['action']); ?>" <?php echo $action_filter == $action['action'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($action['action']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" style="background: #3498db;">Search</button>
                <a href="logs.php"><button type="button" style="background: #95a5a6;">Clear</button></a>
            </form>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Timestamp</th>
                <th>User</th>
                <th>Role</th>
                <th>Action</th>
                <th>Entity Type</th>
                <th>Entity ID</th>
                <th>IP Address</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo date('M d, Y H:i:s', strtotime($row['created_at'])); ?></td>
                <td>
                    <strong><?php echo htmlspecialchars($row['user_name']); ?></strong>
                    <br><small><?php echo htmlspecialchars($row['user_email']); ?></small>
                </td>
                <td>
                    <span class="status-badge status-info"><?php echo ucfirst($row['role']); ?></span>
                </td>
                <td>
                    <span style="background: #e8f4f8; padding: 5px 8px; border-radius: 3px; font-size: 12px; font-weight: bold;">
                        <?php echo htmlspecialchars($row['action']); ?>
                    </span>
                </td>
                <td><?php echo $row['entity_type'] ? htmlspecialchars($row['entity_type']) : '<span style="color: #95a5a6;">-</span>'; ?></td>
                <td><?php echo $row['entity_id'] ? $row['entity_id'] : '<span style="color: #95a5a6;">-</span>'; ?></td>
                <td><small><?php echo htmlspecialchars($row['ip_address'] ?? 'N/A'); ?></small></td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
