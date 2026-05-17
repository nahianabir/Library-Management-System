<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../view/login.php");
    exit;
}
include '../../db/db.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$role_filter = isset($_GET['role']) ? mysqli_real_escape_string($conn, $_GET['role']) : '';
$status_filter = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';

$query = "SELECT * FROM users WHERE 1=1";
if ($search) {
    $query .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
}
if ($role_filter) {
    $query .= " AND role = '$role_filter'";
}
if ($status_filter === 'active' || $status_filter === 'inactive') {
    $is_active = $status_filter === 'active' ? 1 : 0;
    $query .= " AND (is_active = $is_active OR is_active IS NULL)";
}
$query .= " ORDER BY role, created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="nav-bar">
        <div class="container" style="background: transparent; box-shadow: none; padding: 0;">
            <a href="../../index.php">Dashboard</a>
            <a href="../../view/users/list.php" class="active">Users</a>
            <a href="../../view/branches/list.php">Branches</a>
            <a href="../../view/catalog/list.php">Catalog</a>
            <a href="../../view/reports/dashboard.php">Reports</a>
            <a href="../../view/announcements/list.php">Announcements</a>
            <a href="../../view/export/export.php">Export</a>
            <a href="../../controller/AuthController.php?action=logout" class="logout">Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>All Users Management</h1>
        <p style="color: #666; font-size: 14px; margin: 10px 0;">Manage all users across the system</p>
        <a href="create.php"><button class="btn-success">+ Add New User</button></a>
        
        <div style="margin: 20px 0; padding: 15px; background: #f9f9f9; border-radius: 5px;">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; align-items: end;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Search by Name/Email:</label>
                    <input type="text" name="search" placeholder="Enter name or email" value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Filter by Role:</label>
                    <select name="role">
                        <option value="">All Roles</option>
                        <option value="member" <?php echo $role_filter === 'member' ? 'selected' : ''; ?>>Member</option>
                        <option value="librarian" <?php echo $role_filter === 'librarian' ? 'selected' : ''; ?>>Librarian</option>
                        <option value="branch_manager" <?php echo $role_filter === 'branch_manager' ? 'selected' : ''; ?>>Branch Manager</option>
                        <option value="admin" <?php echo $role_filter === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Filter by Status:</label>
                    <select name="status">
                        <option value="">All Status</option>
                        <option value="active" <?php echo $status_filter === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $status_filter === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <button type="submit" style="background: #3498db;">Search & Filter</button>
                <a href="list.php"><button type="button" style="background: #95a5a6;">Clear</button></a>
            </form>
        </div>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { 
                $is_active = isset($row['is_active']) ? $row['is_active'] : 1;
                $status_class = $is_active ? 'status-active' : 'status-inactive';
                $status_text = $is_active ? 'Active' : 'Inactive';
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo ucfirst(str_replace('_', ' ', $row['role'])); ?></td>
                <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                <td class="action-buttons">
                    <a href="detail.php?id=<?php echo $row['id']; ?>"><button>View</button></a>
                    <a href="edit.php?id=<?php echo $row['id']; ?>"><button>Edit</button></a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
