<?php

session_start();

include_once '../model/Branch.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$branchModel = new Branch();

$branches = $branchModel->getBranches();

?>

<!DOCTYPE html>
<html>
<head>

<title>Branches</title>
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

.form-box{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    margin-bottom:25px;
}

.form-box input{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:1px solid #cbd5e1;
    border-radius:6px;
}

.form-box button{
    width:100%;
    padding:12px;
    margin-top:15px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.form-box button:hover{
    background:#1d4ed8;
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

</style>

</head>

<body>
<?php include_once 'sidebar.php'; ?>
<div class="main-content">


<div class="container">

<div class="topbar">

<h1>Branch Management</h1>

<p>
Manage all library branches
</p>

</div>

<div class="form-box">

<h2>Add New Branch</h2>

<form action="../controller/user/BranchController.php"
method="POST">

<input type="text"
name="name"
placeholder="Branch Name"
required>

<input type="text"
name="address"
placeholder="Branch Address"
required>

<input type="text"
name="city"
placeholder="City"
required>

<input type="text"
name="phone"
placeholder="Phone Number"
required>

<button type="submit"
name="add_branch">

Add Branch

</button>

</form>

</div>

<div class="table-box">

<h2>All Branches</h2>

<table>

<tr>

<th>ID</th>
<th>Branch Name</th>
<th>City</th>
<th>Phone</th>
<th>Manager</th>

</tr>

<?php while($row = mysqli_fetch_assoc($branches)) { ?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['name']; ?>
</td>

<td>
<?php echo $row['city']; ?>
</td>

<td>
<?php echo $row['phone']; ?>
</td>

<td>

<?php

if($row['manager_name']) {

    echo $row['manager_name'];
}
else {

    echo "Not Assigned";
}

?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>


</div>
</body>
</html>