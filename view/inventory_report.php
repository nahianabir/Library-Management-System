<?php

session_start();

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

include_once
'../controller/user/InventoryReportController.php';

$inventoryController =
new InventoryReportController();

$result =
$inventoryController->reports();

?>

<!DOCTYPE html>
<html>

<head>

<title>Inventory Report</title>

<link rel="stylesheet"
href="../assets/css/style.css">

</head>

<body>

<?php include_once 'sidebar.php'; ?>

<div class="main-content">

<div class="topbar">

<div>

<h1>📦 Inventory Reports</h1>

<p>
Cross branch inventory and stock management
</p>

</div>

</div>

<div class="table-box">

<h2>Cross Branch Inventory Report</h2>

<table>

<thead>

<tr>

<th>Book Name</th>
<th>Branch Name</th>
<th>Total Copies</th>
<th>Available Copies</th>

</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td>

<?php echo $row['title']; ?>

</td>

<td>

<?php echo $row['branch_name']; ?>

</td>

<td>

<?php echo $row['total_copies']; ?>

</td>

<td>

<?php echo $row['available_copies']; ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>
</html>