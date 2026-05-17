<?php

session_start();

include_once '../controller/user/LibrarianActivityController.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$activityController =
new LibrarianActivityController();

$result =
$activityController->reports();

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/style.css">
<title>Librarian Activity</title>

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
    background:#1e293b;
    color:white;
}

tr:hover{
    background:#f8fafc;
}

</style>

</head>

<body>
<?php include_once 'sidebar.php'; ?>
<div class="main-content">


<div class="container">

<h2>Librarian Activity Reports</h2>

<table>

<tr>

<th>Librarian Name</th>
<th>Branch Name</th>
<th>Total Processed Books</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td>

<?php echo $row['librarian_name']; ?>

</td>

<td>

<?php echo $row['branch_name']; ?>

</td>

<td>

<?php echo $row['total_processed']; ?>

</td>

</tr>

<?php } ?>

</table>

</div>


</div>
</body>
</html>