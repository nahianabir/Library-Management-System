<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../view/login.php");
    exit;
}
include '../../db/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $query = "INSERT INTO users (name, email, phone, password_hash, role, is_active) VALUES ('$name', '$email', '$phone', '$password', '$role', $is_active)";

    if (mysqli_query($conn, $query)) {
        $user_id = mysqli_insert_id($conn);
        $admin_id = $_SESSION['user_id'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        
        // Log to audit_logs
        $audit_query = "INSERT INTO audit_logs (user_id, action, entity_type, entity_id, ip_address, created_at) 
                        VALUES ($admin_id, 'user_created', 'users', $user_id, '$ip_address', NOW())";
        mysqli_query($conn, $audit_query);
        
        header("Location: list.php?success=User created successfully");
        exit;
    } else {
        $error = mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New User</title>
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
        <h1>Add New User</h1>

        <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone">
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Role:</label>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="member">Member</option>
                    <option value="librarian">Librarian</option>
                    <option value="branch_manager">Branch Manager</option>
                    <option value="admin">Admin</option>
                    <option value="branch_manager">Branch Manager</option>
                </select>
            </div>

            <div class="form-group" style="display: flex; align-items: center;">
                <input type="checkbox" name="is_active" id="is_active" checked style="width: auto; margin: 0; margin-right: 10px;">
                <label for="is_active" style="margin: 0; display: inline;">Active Account</label>
            </div>

            <button type="submit" class="btn-success">Create User</button>
            <a href="list.php"><button type="button" class="btn-secondary">Cancel</button></a>
        </form>
    </div>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
