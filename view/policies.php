<?php

session_start();

include_once '../model/Policy.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$policyModel = new Policy();

$branches = $policyModel->getBranches();

$policies = $policyModel->getPolicies();

?>

<!DOCTYPE html>
<html>
<head>

<title>Branch Policies</title>
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

.form-box input,
.form-box select{
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
    background:#0f766e;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.form-box button:hover{
    background:#115e59;
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

<h1>Branch Policy Management</h1>

<p>
Manage borrowing policies for branches
</p>

</div>

<div class="form-box">

<h2>Add Branch Policy</h2>

<form action="../controller/user/PolicyController.php"
method="POST">

<select name="branch_id" required>

<option value="">
Select Branch
</option>

<?php while($branch = mysqli_fetch_assoc($branches)) { ?>

<option value="<?php echo $branch['id']; ?>">

<?php echo $branch['name']; ?>

</option>

<?php } ?>

</select>

<input type="number"
name="days"
placeholder="Maximum Borrow Days"
required>

<input type="number"
name="books"
placeholder="Maximum Books Per Member"
required>

<input type="text"
name="fine"
placeholder="Fine Rate Per Day"
required>

<input type="number"
name="renewals"
placeholder="Maximum Renewals"
required>

<button type="submit"
name="add_policy">

Save Policy

</button>

</form>

</div>

<div class="table-box">

<h2>All Policies</h2>

<table>

<tr>

<th>ID</th>
<th>Branch</th>
<th>Borrow Days</th>
<th>Max Books</th>
<th>Fine Rate</th>
<th>Renewals</th>

</tr>

<?php while($row = mysqli_fetch_assoc($policies)) { ?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['branch_name']; ?>
</td>

<td>
<?php echo $row['max_borrow_days']; ?>
</td>

<td>
<?php echo $row['max_books_per_member']; ?>
</td>

<td>
<?php echo $row['fine_rate_per_day']; ?>
</td>

<td>
<?php echo $row['max_renewals']; ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>


</div>
</body>
</html>