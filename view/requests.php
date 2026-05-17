<?php

session_start();

include_once '../model/TransferRequest.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$request = new TransferRequest();

$requests = $request->allRequests();

?>

<!DOCTYPE html>
<html>
<head>

<title>Transfer Requests</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>

body{
    margin:0;
    font-family:Arial;
    background:#f1f5f9;
}

.container{
    padding:30px;
}

.topbar{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    margin-bottom:25px;
}

.table-box{
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
    border:1px solid #e2e8f0;
    padding:14px;
    text-align:center;
}

th{
    background:#0f172a;
    color:white;
}

button{
    padding:8px 15px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.approve{
    background:#16a34a;
    color:white;
}

.reject{
    background:#dc2626;
    color:white;
}

.approve:hover{
    background:#15803d;
}

.reject:hover{
    background:#b91c1c;
}

</style>



</head>

<body>
<?php include_once 'sidebar.php'; ?>
<div class="main-content">


<div class="container">

<div class="topbar">

<h1>Transfer Requests</h1>

<p>
Manage inter-branch transfer requests
</p>

</div>

<div class="table-box">

<table>

<tr>

<th>ID</th>
<th>Book</th>
<th>Librarian</th>
<th>From Branch</th>
<th>To Branch</th>
<th>Status</th>
<th>Actions</th>

</tr>

<?php while($row = mysqli_fetch_assoc($requests)) { ?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['book_name']; ?>
</td>

<td>
<?php echo $row['librarian_name']; ?>
</td>

<td>
<?php echo $row['from_branch']; ?>
</td>

<td>
<?php echo $row['to_branch']; ?>
</td>

<td id="status_<?php echo $row['id']; ?>">

<?php echo $row['status']; ?>

</td>

<td>

<button class="approve" onclick="updateRequest(<?php echo $row['id']; ?>,'approved')">Approve</button>

<button class="reject" onclick="updateRequest(<?php echo $row['id']; ?>,'rejected')">Reject</button>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>


</div>
<script src="../ajax/update_request.js"></script>
</body>
</html>