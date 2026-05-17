<?php

session_start();

include_once '../controller/user/MemberController.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$memberController =
new MemberController();

$result =
$memberController->members();

?>

<!DOCTYPE html>
<html>
<head>

<title>Member Reports</title>
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

<h2>Most Active Members</h2>

<table>

<tr>

<th>Member Name</th>
<th>Branch Name</th>
<th>Total Borrowed Books</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td>

<?php echo $row['member_name']; ?>

</td>

<td>

<?php echo $row['branch_name']; ?>

</td>

<td>

<?php echo $row['total_books']; ?>

</td>

</tr>

<?php } ?>

</table>

</div>


</div>
</body>
</html>