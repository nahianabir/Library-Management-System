<?php

session_start();

include_once '../model/LibrarianAssign.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$librarianModel = new LibrarianAssign();

$result =
$librarianModel->allLibrarians();

$branches =
$librarianModel->allBranches();

?>

<!DOCTYPE html>
<html>
<head>

<title>Assign Librarians</title>
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

select{
    padding:8px;
    width:180px;
}

button{
    padding:8px 15px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#1d4ed8;
}

</style>

</head>

<body>
<?php include_once 'sidebar.php'; ?>
<div class="main-content">


<div class="container">

<h2>Assign Librarians</h2>

<table>

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Current Branch</th>
<th>Assign Branch</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>

<td>

<?php echo $row['name']; ?>

</td>

<td>

<?php echo $row['email']; ?>

</td>

<td>

<?php

if($row['branch_name']) {

    echo $row['branch_name'];
}
else {

    echo "Not Assigned";
}

?>

</td>

<td>

<form action="../controller/user/LibrarianAssignController.php"
method="POST">

<input type="hidden"
name="user_id"
value="<?php echo $row['id']; ?>">

<select name="branch_id" required>

<option value="">
Select Branch
</option>

<?php

mysqli_data_seek($branches, 0);

while($branch =
mysqli_fetch_assoc($branches)) {

?>

<option value="<?php echo $branch['id']; ?>">

<?php echo $branch['name']; ?>

</option>

<?php } ?>

</select>

<button type="submit"
name="assign_branch">

Assign

</button>

</form>

</td>

</tr>

<?php } ?>

</table>

</div>


</div>
</body>
</html>