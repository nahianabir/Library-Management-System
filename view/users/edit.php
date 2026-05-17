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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $query = "UPDATE users SET name = '$name', email = '$email', phone = '$phone', role = '$role', is_active = $is_active WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $admin_id = $_SESSION['user_id'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        
        // Log to audit_logs
        $audit_query = "INSERT INTO audit_logs (user_id, action, entity_type, entity_id, ip_address, created_at) 
                        VALUES ($admin_id, 'user_updated', 'users', $id, '$ip_address', NOW())";
        mysqli_query($conn, $audit_query);
        
        header("Location: detail.php?id=$id&success=User updated successfully");
        exit;
    } else {
        $error = "Error updating user";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
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
        <h1>Edit User</h1>

        <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Role:</label>
                <select name="role" required>
                    <option value="member" <?php echo $user['role'] == 'member' ? 'selected' : ''; ?>>Member</option>
                    <option value="librarian" <?php echo $user['role'] == 'librarian' ? 'selected' : ''; ?>>Librarian</option>
                    <option value="branch_manager" <?php echo $user['role'] == 'branch_manager' ? 'selected' : ''; ?>>Branch Manager</option>
                    <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <div class="form-group" style="display: flex; align-items: center;">
                <input type="checkbox" name="is_active" id="is_active" <?php echo (isset($user['is_active']) && $user['is_active']) ? 'checked' : (isset($user['is_active']) ? '' : 'checked'); ?> style="width: auto; margin: 0; margin-right: 10px;">
                <label for="is_active" style="margin: 0; display: inline;">Active Account</label>
            </div>

            <button type="submit" class="btn-success">Update User</button>
            <a href="detail.php?id=<?php echo $id; ?>"><button type="button">Cancel</button></a>
        </form>
    </div>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
