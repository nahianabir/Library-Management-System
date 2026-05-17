<?php

session_start();

include_once '../db/database.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}



$branchQuery =
"SELECT COUNT(*) AS total
FROM branches";

$branchResult =
mysqli_query($conn, $branchQuery);

$branchData =
mysqli_fetch_assoc($branchResult);



$requestQuery =
"SELECT COUNT(*) AS total
FROM inter_branch_requests
WHERE status='pending'";

$requestResult =
mysqli_query($conn, $requestQuery);

$requestData =
mysqli_fetch_assoc($requestResult);



$overdueQuery =
"SELECT COUNT(*) AS total
FROM borrow_records
WHERE due_date < CURDATE()
AND status='active'";

$overdueResult =
mysqli_query($conn, $overdueQuery);

$overdueData =
mysqli_fetch_assoc($overdueResult);



$fineQuery =
"SELECT SUM(amount) AS total
FROM fines
WHERE is_paid=0";

$fineResult =
mysqli_query($conn, $fineQuery);

$fineData =
mysqli_fetch_assoc($fineResult);



$librarianQuery =
"SELECT COUNT(*) AS total
FROM users
WHERE role='librarian'";

$librarianResult =
mysqli_query($conn, $librarianQuery);

$librarianData =
mysqli_fetch_assoc($librarianResult);



$memberQuery =
"SELECT COUNT(*) AS total
FROM users
WHERE role='member'";

$memberResult =
mysqli_query($conn, $memberQuery);

$memberData =
mysqli_fetch_assoc($memberResult);

?>

<!DOCTYPE html>
<html>
<head>

<title>Branch Manager Dashboard</title>

<link rel="stylesheet"
href="../assets/css/style.css">

<style>

body{
    margin:0;
    font-family:Arial;
    background:#f1f5f9;
}



.main{
    margin-left:260px;
    padding:20px;
}

.topbar{
    background:white;
    padding:15px 20px;
    border-radius:10px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.cards{
    display:grid;
    grid-template-columns:
    repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-top:25px;
}

.card{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card h3{
    margin:0;
    color:#475569;
}

.card p{
    font-size:28px;
    font-weight:bold;
    margin-top:15px;
    color:#0f172a;
}

.quick-links{
    margin-top:30px;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.quick-links h2{
    margin-bottom:20px;
}

.quick-links a{
    display:inline-block;
    text-decoration:none;
    background:#2563eb;
    color:white;
    padding:12px 18px;
    margin:8px;
    border-radius:6px;
}

.quick-links a:hover{
    background:#1d4ed8;
}


</style>

</head>

<body>
    

<?php include_once 'sidebar.php'; ?>
<div class="main">
 

<div class="topbar">

<h1>
Welcome,
<?php echo $_SESSION['name']; ?>
</h1>

<h3>
Branch Manager Dashboard
</h3>

</div>

<div class="cards">

<div class="card">

<h3>Total Branches</h3>

<p>

<?php
echo $branchData['total'];
?>

</p>

</div>

<div class="card">

<h3>Pending Requests</h3>

<p>

<?php
echo $requestData['total'];
?>

</p>

</div>

<div class="card">

<h3>Overdue Books</h3>

<p>

<?php
echo $overdueData['total'];
?>

</p>

</div>

<div class="card">

<h3>Total Fine</h3>

<p>

<?php
echo $fineData['total'];
?>

BDT

</p>

</div>

<div class="card">

<h3>Total Librarians</h3>

<p>

<?php
echo $librarianData['total'];
?>

</p>

</div>

<div class="card">

<h3>Total Members</h3>

<p>

<?php
echo $memberData['total'];
?>

</p>

</div>

</div>

<div class="quick-links">

<h2>Quick Actions</h2>

<a href="branches.php">
Add Branch
</a>

<a href="policies.php">
Add Policy
</a>

<a href="announcements.php">
Post Announcement
</a>

<a href="inventory_report.php">
View Inventory
</a>

<a href="reports.php">
View Reports
</a>

</div>

</div>

</body>
</html>