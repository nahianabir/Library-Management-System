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

$id = (int)$_GET['id'];
$query = "SELECT * FROM branches WHERE id = $id";
$result = mysqli_query($conn, $query);
$branch = mysqli_fetch_assoc($result);

if (!$branch) {
    die("Branch not found");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $query = "UPDATE branches SET name = '$name', address = '$address', city = '$city', phone = '$phone' WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: detail.php?id=$id&success=Branch updated successfully");
        exit;
    } else {
        $error = "Error updating branch";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Branch</title>
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
        <h1>Edit Branch</h1>

        <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($branch['name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Address:</label>
                <textarea name="address"><?php echo htmlspecialchars($branch['address'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>City:</label>
                <input type="text" name="city" value="<?php echo htmlspecialchars($branch['city'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($branch['phone'] ?? ''); ?>">
            </div>

            <button type="submit">Update Branch</button>
            <a href="detail.php?id=<?php echo $id; ?>"><button type="button">Cancel</button></a>
        </form>
    </div>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
