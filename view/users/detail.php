<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../view/login.php");
    exit;
}
include '../../db/db.php';

if (!isset($_GET['id'])) {
    die("User not found");
}

$id = (int)$_GET['id'];
$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
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
        <h1>User Details</h1>
        
        <div class="form-group">
            <label>Name:</label>
            <p><?php echo htmlspecialchars($user['name']); ?></p>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <p><?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <div class="form-group">
            <label>Role:</label>
            <p><?php echo ucfirst($user['role']); ?></p>
        </div>

        <div class="form-group">
            <label>Phone:</label>
            <p><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></p>
        </div>

        <div class="form-group">
            <label>Status:</label>
            <p><?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?></p>
        </div>

        <a href="list.php"><button>Back</button></a>
        <a href="edit.php?id=<?php echo $user['id']; ?>"><button class="btn-warning">Edit</button></a>
    </div>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
