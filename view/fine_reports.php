<?php

session_start();

include_once '../db/database.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$sql = "SELECT users.name,
fines.amount,
fines.reason,
fines.is_paid

FROM fines

JOIN users
ON users.id = fines.member_id";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Fine Reports</title>
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
    background:#7c2d12;
    color:white;
}

.paid{
    color:green;
    font-weight:bold;
}

.unpaid{
    color:red;
    font-weight:bold;
}


</style>

</head>
<body>
<?php include_once 'sidebar.php'; ?>
<div class="main-content">

    

<div class="container">

<h2>Fine Reports</h2>

<table>

<tr>
<th>Member</th>
<th>Amount</th>
<th>Reason</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['amount']; ?></td>

<td><?php echo $row['reason']; ?></td>

<td>

<?php
if($row['is_paid'] == 1) {
    echo "<span class='paid'>Paid</span>";
}
else {
    echo "<span class='unpaid'>Unpaid</span>";
}
?>

</td>

</tr>

<?php } ?>

</table>

</div>


</div>
</body>
</html>