<?php

session_start();

include_once '../model/update_inventory.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$inventory = new Inventory();

$result = $inventory->allInventory();

$books = $inventory->allBooks();

$branches = $inventory->allBranches();

?>

<!DOCTYPE html>
<html>
<head>

<title>Update Inventory</title>
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

.form-box select,
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

<h1>Update Inventory</h1>

<p>
Manage inventory copies and availability
</p>

</div>

<div class="form-box">

<h2>Update Book Inventory</h2>

<form action="../controller/user/InventoryController.php"
method="POST">

<select name="book_id" required>

<option value="">
Select Book
</option>

<?php while($book = mysqli_fetch_assoc($books)) { ?>

<option value="<?php echo $book['id']; ?>">

<?php echo $book['title']; ?>

</option>

<?php } ?>

</select>



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
name="total"
placeholder="Total Copies"
required>

<input type="number"
name="available"
placeholder="Available Copies"
required>

<button type="submit"
name="update_inventory">

Update Inventory

</button>

</form>

</div>

<div class="table-box">

<h2>Current Inventory</h2>

<table>

<tr>

<th>ID</th>
<th>Book</th>
<th>Branch</th>
<th>Total Copies</th>
<th>Available Copies</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['title']; ?>
</td>

<td>
<?php echo $row['branch_name']; ?>
</td>

<td>
<?php echo $row['total_copies']; ?>
</td>

<td>
<?php echo $row['available_copies']; ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>


</div>
</body>
</html>