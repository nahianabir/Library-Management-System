<?php

session_start();

include_once '../db/database.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$sql = "SELECT * FROM announcements";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Platform Announcements</title>
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

.notice{
    background:#eff6ff;
    padding:15px;
    border-left:5px solid #2563eb;
    margin-top:15px;
    border-radius:5px;
}

</style>

</head>
<body>
<?php include_once 'sidebar.php'; ?>
<div class="main-content">


<div class="container">

<h2>Platform Announcements</h2>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<div class="notice">

<h3><?php echo $row['title']; ?></h3>

<p><?php echo $row['body']; ?></p>

</div>

<?php } ?>

</div>


</div>
</body>
</html>