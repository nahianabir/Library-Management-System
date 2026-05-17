<?php

session_start();

include_once '../model/Report.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$report = new Report();

$data = $report->overdueLoans();

?>

<!DOCTYPE html>
<html>
<head>

<title>Reports</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>

body{
    margin:0;
    font-family:Arial;
    background:#f1f5f9;
    
}

.cards{
    display:flex;
    gap:20px;
    margin-bottom:25px;
}

.card{
    flex:1;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    text-align:center;
}

.card h3{
    margin:0;
}

.card p{
    font-size:28px;
    font-weight:bold;
}

.container{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
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
    background:#1e293b;
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

<h2>Overdue Loan Reports</h2>

<table>

<tr>

<th>Member Name</th>
<th>Book Name</th>
<th>Branch</th>
<th>Due Date</th>
<th>Status</th>

</tr>

<?php while($row = mysqli_fetch_assoc($data)) { ?>

<tr>

<td>

<?php echo $row['member_name']; ?>

</td>

<td>

<?php echo $row['book_name']; ?>

</td>

<td>

<?php echo $row['branch_name']; ?>

</td>

<td>

<?php echo $row['due_date']; ?>

</td>

<td class="overdue">

Overdue

</td>

</tr>

<?php } ?>

</table>

</div>


</div>
</body>
</html>