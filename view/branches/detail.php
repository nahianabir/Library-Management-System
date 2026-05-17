<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../view/login.php");
    exit;
}
include '../../db/db.php';

if (!isset($_GET['id'])) {
    die("Branch not found");
}

$branch_id = (int)$_GET['id'];
$branch_query = "SELECT * FROM branches WHERE id = $branch_id";
$branch_result = mysqli_query($conn, $branch_query);
$branch = mysqli_fetch_assoc($branch_result);

if (!$branch) {
    die("Branch not found");
}

$message = '';

// Handle manager assignment
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'assign_manager') {
            $manager_id = (int)$_POST['manager_id'];
            $update_query = "UPDATE branches SET manager_id = $manager_id WHERE id = $branch_id";
            if (mysqli_query($conn, $update_query)) {
                $admin_id = $_SESSION['user_id'];
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $audit_query = "INSERT INTO audit_logs (user_id, action, entity_type, entity_id, ip_address, created_at) 
                                VALUES ($admin_id, 'manager_assigned', 'branches', $branch_id, '$ip_address', NOW())";
                mysqli_query($conn, $audit_query);
                
                $message = '<div class="alert alert-success">Manager assigned successfully!</div>';
                $branch_result = mysqli_query($conn, $branch_query);
                $branch = mysqli_fetch_assoc($branch_result);
            } else {
                $message = '<div class="alert alert-danger">Error assigning manager</div>';
            }
        }

        if ($action == 'remove_manager') {
            $update_query = "UPDATE branches SET manager_id = NULL WHERE id = $branch_id";
            if (mysqli_query($conn, $update_query)) {
                $admin_id = $_SESSION['user_id'];
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $audit_query = "INSERT INTO audit_logs (user_id, action, entity_type, entity_id, ip_address, created_at) 
                                VALUES ($admin_id, 'manager_removed', 'branches', $branch_id, '$ip_address', NOW())";
                mysqli_query($conn, $audit_query);
                
                $message = '<div class="alert alert-success">Manager removed successfully!</div>';
                $branch_result = mysqli_query($conn, $branch_query);
                $branch = mysqli_fetch_assoc($branch_result);
            } else {
                $message = '<div class="alert alert-danger">Error removing manager</div>';
            }
        }

        if ($action == 'assign_librarian') {
            $librarian_id = (int)$_POST['librarian_id'];
            $update_query = "UPDATE users SET branch_id = $branch_id WHERE id = $librarian_id AND role = 'librarian'";
            if (mysqli_query($conn, $update_query)) {
                $admin_id = $_SESSION['user_id'];
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $audit_query = "INSERT INTO audit_logs (user_id, action, entity_type, entity_id, ip_address, created_at) 
                                VALUES ($admin_id, 'librarian_assigned', 'users', $librarian_id, '$ip_address', NOW())";
                mysqli_query($conn, $audit_query);
                
                $message = '<div class="alert alert-success">Librarian assigned to branch!</div>';
            } else {
                $message = '<div class="alert alert-danger">Error assigning librarian</div>';
            }
        }

        if ($action == 'remove_librarian') {
            $librarian_id = (int)$_POST['librarian_id'];
            $update_query = "UPDATE users SET branch_id = NULL WHERE id = $librarian_id AND role = 'librarian'";
            if (mysqli_query($conn, $update_query)) {
                $admin_id = $_SESSION['user_id'];
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $audit_query = "INSERT INTO audit_logs (user_id, action, entity_type, entity_id, ip_address, created_at) 
                                VALUES ($admin_id, 'librarian_removed', 'users', $librarian_id, '$ip_address', NOW())";
                mysqli_query($conn, $audit_query);
                
                $message = '<div class="alert alert-success">Librarian removed from branch!</div>';
            } else {
                $message = '<div class="alert alert-danger">Error removing librarian</div>';
            }
        }
    }
}

// Get current manager
$manager_query = "SELECT id, name, email FROM users WHERE id = " . ($branch['manager_id'] ?? 0);
$manager_result = mysqli_query($conn, $manager_query);
$current_manager = mysqli_fetch_assoc($manager_result);

// Get available managers
$available_managers_query = "SELECT id, name, email FROM users WHERE role = 'branch_manager' AND (branch_id IS NULL OR branch_id = $branch_id)";
$available_managers = mysqli_query($conn, $available_managers_query);

// Get current librarians
$librarians_query = "SELECT id, name, email FROM users WHERE branch_id = $branch_id AND role = 'librarian'";
$librarians_result = mysqli_query($conn, $librarians_query);

// Get available librarians
$available_librarians_query = "SELECT id, name, email FROM users WHERE role = 'librarian' AND branch_id IS NULL";
$available_librarians = mysqli_query($conn, $available_librarians_query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Branch Management</title>
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
        <h1><?php echo htmlspecialchars($branch['name']); ?> - Management</h1>
        
        <?php echo $message; ?>

        <div style="margin: 20px 0; padding: 15px; background: #ecf0f1; border-left: 4px solid #3498db; border-radius: 4px;">
            <h3 style="margin-top: 0;">Branch Information</h3>
            <p><strong>City:</strong> <?php echo htmlspecialchars($branch['city']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($branch['phone']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($branch['address'] ?? 'N/A'); ?></p>
            <p><strong>Status:</strong> <span class="status-badge <?php echo $branch['is_active'] ? 'status-active' : 'status-inactive'; ?>"><?php echo $branch['is_active'] ? 'Active' : 'Inactive'; ?></span></p>
        </div>

        <!-- Manager Management -->
        <div style="margin: 30px 0;">
            <h2 style="color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px;">Branch Manager</h2>
            
            <?php if ($current_manager) { ?>
                <div style="margin: 15px 0; padding: 15px; background: #d5f4e6; border-radius: 5px;">
                    <h3 style="margin-top: 0; color: #27ae60;">✓ Current Manager</h3>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($current_manager['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($current_manager['email']); ?></p>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="remove_manager">
                        <button type="submit" class="btn-danger" onclick="return confirm('Remove this manager from the branch?')">Remove Manager</button>
                    </form>
                </div>
            <?php } else { ?>
                <div style="margin: 15px 0; padding: 15px; background: #fdeef4; border-radius: 5px;">
                    <p style="color: #e74c3c; font-weight: bold;">No manager assigned yet</p>
                </div>
            <?php } ?>

            <!-- Assign Manager -->
            <div style="margin: 20px 0; padding: 15px; background: #f9f9f9; border: 1px solid #bdc3c7; border-radius: 5px;">
                <h4>Assign Branch Manager</h4>
                <form method="POST">
                    <div class="form-group">
                        <label>Select Manager:</label>
                        <select name="manager_id" required>
                            <option value="">-- Choose a manager --</option>
                            <?php while ($manager = mysqli_fetch_assoc($available_managers)) { ?>
                                <option value="<?php echo $manager['id']; ?>"><?php echo htmlspecialchars($manager['name']); ?> (<?php echo htmlspecialchars($manager['email']); ?>)</option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="action" value="assign_manager">
                    <button type="submit" class="btn-success">Assign Manager</button>
                </form>
            </div>
        </div>

        <!-- Librarians Management -->
        <div style="margin: 30px 0;">
            <h2 style="color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px;">Librarians</h2>
            
            <div style="margin: 15px 0; padding: 15px; background: #f9f9f9; border-radius: 5px;">
                <h4>Current Librarians in this Branch</h4>
                <?php 
                $librarian_count = 0;
                $current_librarians = [];
                while ($lib = mysqli_fetch_assoc($librarians_result)) {
                    $librarian_count++;
                    $current_librarians[] = $lib;
                }
                
                if ($librarian_count > 0) { 
                ?>
                    <table style="width: 100%; margin-top: 10px;">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($current_librarians as $lib) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($lib['name']); ?></td>
                                <td><?php echo htmlspecialchars($lib['email']); ?></td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="remove_librarian">
                                        <input type="hidden" name="librarian_id" value="<?php echo $lib['id']; ?>">
                                        <button type="submit" class="btn-danger" onclick="return confirm('Remove this librarian?')">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <p style="color: #7f8c8d;">No librarians assigned yet</p>
                <?php } ?>
            </div>

            <!-- Assign Librarian -->
            <div style="margin: 20px 0; padding: 15px; background: #f9f9f9; border: 1px solid #bdc3c7; border-radius: 5px;">
                <h4>Assign Librarian to Branch</h4>
                <?php 
                $available_count = 0;
                while (mysqli_fetch_assoc($available_librarians)) {
                    $available_count++;
                }
                mysqli_data_seek($available_librarians, 0);
                
                if ($available_count > 0) { 
                ?>
                    <form method="POST">
                        <div class="form-group">
                            <label>Select Librarian:</label>
                            <select name="librarian_id" required>
                                <option value="">-- Choose a librarian --</option>
                                <?php while ($lib = mysqli_fetch_assoc($available_librarians)) { ?>
                                    <option value="<?php echo $lib['id']; ?>"><?php echo htmlspecialchars($lib['name']); ?> (<?php echo htmlspecialchars($lib['email']); ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                        <input type="hidden" name="action" value="assign_librarian">
                        <button type="submit" class="btn-success">Assign Librarian</button>
                    </form>
                <?php } else { ?>
                    <p style="color: #7f8c8d;">No unassigned librarians available</p>
                <?php } ?>
            </div>
        </div>

        <div style="margin: 20px 0;">
            <a href="list.php"><button class="btn-secondary">Back to Branches</button></a>
            <a href="edit.php?id=<?php echo $branch['id']; ?>"><button class="btn-warning">Edit Branch</button></a>
        </div>
    </div>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
