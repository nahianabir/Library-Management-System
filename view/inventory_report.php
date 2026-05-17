<?php

session_start();

include_once '../db/database.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$sql = "SELECT books.title,
        branches.name AS branch_name,
        branch_inventory.total_copies,
        branch_inventory.available_copies

        FROM branch_inventory

        JOIN books
        ON branch_inventory.book_id = books.id

        JOIN branches
        ON branch_inventory.branch_id = branches.id";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Report</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>

body{
    font-family:Arial;
    background:#f4f6f9;
    
}

.container{
    background:white;
    padding:20px;
    border-radius:10px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    border:1px solid #ddd;
    padding:12px;
    text-align:center;
}

th{
    background:#0f172a;
    color:white;
}

</style>

</head>
<body>
<?php include_once 'sidebar.php'; ?>
<div class="main-content">

    

<div class="container">

<h2>Cross Branch Inventory Report</h2>

<table>

<tr>
<th>Book</th>
<th>Branch</th>
<th>Total Copies</th>
<th>Available Copies</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['branch_name']; ?></td>

<td><?php echo $row['total_copies']; ?></td>

<td><?php echo $row['available_copies']; ?></td>

</tr>

<?php } ?>

</table>

</div>


</div>
</body>
</html>