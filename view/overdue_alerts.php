<?php

include_once '../db/database.php';

$sql = "SELECT *
        FROM borrow_records
        WHERE due_date < CURDATE()
        AND status='active'";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Overdue Alerts</title>
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
    border:1px solid #ccc;
    padding:12px;
    text-align:center;
}

th{
    background:#991b1b;
    color:white;
}

.overdue{
    color:red;
    font-weight:bold;
}

</style>

</head>
<body>
<?php include_once 'sidebar.php'; ?>
<div class="main-content">


<div class="container">

<h2>Overdue Loan Alerts</h2>

<table>

<tr>
<th>Member ID</th>
<th>Book ID</th>
<th>Due Date</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td><?php echo $row['member_id']; ?></td>

<td><?php echo $row['book_id']; ?></td>

<td><?php echo $row['due_date']; ?></td>

<td class="overdue">
Overdue
</td>

</tr>

<?php } ?>

</table>

</div>

</div>
</div>
</body>
</html>