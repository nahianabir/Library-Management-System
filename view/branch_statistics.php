<?php

session_start();

include_once '../controller/user/BranchStatisticsController.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$controller =
new BranchStatisticsController();

$result =
$controller->statistics();

?>

<!DOCTYPE html>
<html>
<head>

<title>Branch Statistics</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>

body{
    margin:0;
    font-family:Arial;
    background:#f1f5f9;
    
}

.container{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

h2{
    margin-bottom:20px;
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
    background:#0f172a;
    color:white;
}

tr:hover{
    background:#f8fafc;
}

.active{
    color:green;
    font-weight:bold;
}

.overdue{
    color:red;
    font-weight:bold;
}

.fine{
    color:#b45309;
    font-weight:bold;
}

</style>

</head>

<body>
<?php include_once 'sidebar.php'; ?>
<div class="main-content">


<div class="container">

<h2>Cross Branch Borrowing Statistics</h2>

<table>

<tr>

<th>Branch Name</th>
<th>Total Active Loans</th>
<th>Overdue Loans</th>
<th>Outstanding Fines</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td>

<?php echo $row['branch_name']; ?>

</td>

<td class="active">

<?php echo $row['active_loans']; ?>

</td>

<td class="overdue">

<?php echo $row['overdue_loans']; ?>

</td>

<td class="fine">

<?php echo $row['outstanding_fines']; ?> BDT

</td>

</tr>

<?php } ?>

</table>

</div>


</div>
</body>
</html>