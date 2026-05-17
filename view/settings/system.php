<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../view/login.php");
    exit;
}
include '../../db/db.php';

$settings = array(
    'site_name' => 'Library Management System',
    'admin_email' => 'admin@library.com',
    'max_borrow_days' => 7,
    'fine_per_day' => 5.00,
    'allow_self_register' => 0,
    'platform_closed' => 0
);

// Try to get settings from database
$settings_query = "SELECT * FROM settings LIMIT 1";
$settings_result = mysqli_query($conn, $settings_query);
if ($settings_result && mysqli_num_rows($settings_result) > 0) {
    $db_settings = mysqli_fetch_assoc($settings_result);
    $settings = array_merge($settings, $db_settings);
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $site_name = mysqli_real_escape_string($conn, $_POST['site_name']);
    $admin_email = mysqli_real_escape_string($conn, $_POST['admin_email']);
    $max_borrow_days = (int)$_POST['max_borrow_days'];
    $fine_per_day = (float)$_POST['fine_per_day'];
    $allow_self_register = isset($_POST['allow_self_register']) ? 1 : 0;
    $platform_closed = isset($_POST['platform_closed']) ? 1 : 0;
    
    $check_query = "SELECT COUNT(*) as count FROM settings";
    $check_result = mysqli_query($conn, $check_query);
    $check_count = mysqli_fetch_assoc($check_result)['count'];
    
    if ($check_count > 0) {
        $query = "UPDATE settings SET site_name = '$site_name', admin_email = '$admin_email', 
                  max_borrow_days = $max_borrow_days, fine_per_day = $fine_per_day, 
                  allow_self_register = $allow_self_register, platform_closed = $platform_closed";
    } else {
        $query = "INSERT INTO settings (site_name, admin_email, max_borrow_days, fine_per_day, allow_self_register, platform_closed) 
                  VALUES ('$site_name', '$admin_email', $max_borrow_days, $fine_per_day, $allow_self_register, $platform_closed)";
    }
    
    if (mysqli_query($conn, $query)) {
        $message = '<div class="alert alert-success">Settings updated successfully!</div>';
        $settings['site_name'] = $site_name;
        $settings['admin_email'] = $admin_email;
        $settings['max_borrow_days'] = $max_borrow_days;
        $settings['fine_per_day'] = $fine_per_day;
        $settings['allow_self_register'] = $allow_self_register;
        $settings['platform_closed'] = $platform_closed;
    } else {
        $message = '<div class="alert alert-danger">Error updating settings: ' . mysqli_error($conn) . '</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>System Settings</title>
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
        <h1>System Settings</h1>
        <p style="color: #666; font-size: 14px; margin: 10px 0;">Configure platform-wide settings and defaults</p>
        
        <?php echo $message; ?>
        
        <form method="POST">
            <h2>General Settings</h2>
            <div class="form-group">
                <label>Site Name:</label>
                <input type="text" name="site_name" value="<?php echo htmlspecialchars($settings['site_name'] ?? 'Library Management System'); ?>" required>
            </div>

            <div class="form-group">
                <label>Admin Email:</label>
                <input type="email" name="admin_email" value="<?php echo htmlspecialchars($settings['admin_email'] ?? 'admin@library.com'); ?>" required>
            </div>

            <h2 style="margin-top: 30px;">Borrowing Policies</h2>
            <div class="form-group">
                <label>Default Maximum Borrow Days:</label>
                <input type="number" name="max_borrow_days" value="<?php echo $settings['max_borrow_days'] ?? 7; ?>" min="1" required>
                <small style="display: block; color: #7f8c8d; margin-top: 5px;">Default number of days a member can borrow a book</small>
            </div>

            <div class="form-group">
                <label>Fine Amount Per Day (₹):</label>
                <input type="number" name="fine_per_day" value="<?php echo $settings['fine_per_day'] ?? 5.00; ?>" step="0.01" min="0" required>
                <small style="display: block; color: #7f8c8d; margin-top: 5px;">Fine amount charged per day for overdue books</small>
            </div>

            <h2 style="margin-top: 30px;">Access Control</h2>
            <div class="form-group" style="display: flex; align-items: center;">
                <input type="checkbox" name="allow_self_register" id="allow_self_register" <?php echo isset($settings['allow_self_register']) && $settings['allow_self_register'] ? 'checked' : ''; ?> style="width: auto; margin: 0; margin-right: 10px;">
                <label for="allow_self_register" style="margin: 0; display: inline;">Allow members to self-register</label>
            </div>
            <small style="display: block; color: #7f8c8d; margin-top: 5px; margin-left: 25px;">If unchecked, members must be invited or created by admin/librarian</small>

            <div class="form-group" style="display: flex; align-items: center; margin-top: 15px;">
                <input type="checkbox" name="platform_closed" id="platform_closed" <?php echo isset($settings['platform_closed']) && $settings['platform_closed'] ? 'checked' : ''; ?> style="width: auto; margin: 0; margin-right: 10px;">
                <label for="platform_closed" style="margin: 0; display: inline;">Close platform for maintenance</label>
            </div>
            <small style="display: block; color: #7f8c8d; margin-top: 5px; margin-left: 25px;">When enabled, only admins can access the system</small>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn-success">Save Settings</button>
                <a href="../../index.php"><button type="button" class="btn-secondary">Cancel</button></a>
            </div>
        </form>
    </div>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
