<?php

session_start();

include_once '../db/database.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$sql = "SELECT books.title,
COUNT(borrow_records.book_id) AS total

FROM borrow_records

JOIN books
ON books.id = borrow_records.book_id

GROUP BY borrow_records.book_id

ORDER BY total DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Most Borrowed Books</title>
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
    background:#0f172a;
    color:white;
}

</style>

</head>
<body>
<?php include_once 'sidebar.php'; ?>
<div class="main-content">


<div class="container">

<h2>Most Borrowed Books</h2>

<table>

<tr>
<th>Book Name</th>
<th>Total Borrow</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['total']; ?></td>

</tr>

<?php } ?>

</table>

</div>


</div>
</body>
</html>