<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../view/login.php");
    exit;
}
include '../../db/db.php';

$defaults = array(
    'default_borrow_days' => 7,
    'default_max_books' => 5,
    'default_fine_per_day' => 5.00
);

// Try to get settings from database
$settings_query = "SELECT * FROM branch_defaults LIMIT 1";
$settings_result = mysqli_query($conn, $settings_query);
if ($settings_result && mysqli_num_rows($settings_result) > 0) {
    $db_defaults = mysqli_fetch_assoc($settings_result);
    $defaults = array_merge($defaults, $db_defaults);
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $default_borrow_days = (int)$_POST['default_borrow_days'];
    $default_max_books = (int)$_POST['default_max_books'];
    $default_fine_per_day = (float)$_POST['default_fine_per_day'];
    
    $check_query = "SELECT COUNT(*) as count FROM branch_defaults";
    $check_result = mysqli_query($conn, $check_query);
    $check_count = $check_result ? mysqli_fetch_assoc($check_result)['count'] : 0;
    
    if ($check_count > 0) {
        $query = "UPDATE branch_defaults SET default_borrow_days = $default_borrow_days, 
                  default_max_books = $default_max_books, default_fine_per_day = $default_fine_per_day";
    } else {
        $query = "INSERT INTO branch_defaults (default_borrow_days, default_max_books, default_fine_per_day) 
                  VALUES ($default_borrow_days, $default_max_books, $default_fine_per_day)";
    }
    
    if (mysqli_query($conn, $query)) {
        $message = '<div class="alert alert-success">Default policies updated successfully!</div>';
        $defaults['default_borrow_days'] = $default_borrow_days;
        $defaults['default_max_books'] = $default_max_books;
        $defaults['default_fine_per_day'] = $default_fine_per_day;
    } else {
        $message = '<div class="alert alert-danger">Error updating defaults: ' . mysqli_error($conn) . '</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Default Settings</title>
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
        <h1>Default Branch Policies</h1>
        <p style="color: #666; font-size: 14px; margin: 10px 0;">Set default borrowing policies used as fallback when a branch has no custom policy</p>
        
        <?php echo $message; ?>
        
        <form method="POST">
            <h2>Default Borrowing Policies</h2>
            
            <div class="form-group">
                <label>Default Maximum Borrow Days:</label>
                <input type="number" name="default_borrow_days" value="<?php echo $defaults['default_borrow_days'] ?? 7; ?>" min="1" required>
                <small style="display: block; color: #7f8c8d; margin-top: 5px;">Used when branch doesn't have custom policy</small>
            </div>

            <div class="form-group">
                <label>Default Maximum Books Per Member:</label>
                <input type="number" name="default_max_books" value="<?php echo $defaults['default_max_books'] ?? 5; ?>" min="1" required>
                <small style="display: block; color: #7f8c8d; margin-top: 5px;">Maximum number of books a member can borrow at once</small>
            </div>

            <div class="form-group">
                <label>Default Fine Amount Per Day (₹):</label>
                <input type="number" name="default_fine_per_day" value="<?php echo $defaults['default_fine_per_day'] ?? 5.00; ?>" step="0.01" min="0" required>
                <small style="display: block; color: #7f8c8d; margin-top: 5px;">Fine charged per day for overdue books</small>
            </div>

            <h2 style="margin-top: 30px; color: #e74c3c;">⚠️ Note</h2>
            <p style="color: #7f8c8d; font-size: 14px;">These defaults apply only to branches that don't have custom policies configured. Individual branches can override these settings.</p>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn-success">Save Default Policies</button>
                <a href="../../index.php"><button type="button" class="btn-secondary">Cancel</button></a>
            </div>
        </form>
    </div>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
