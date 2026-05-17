<?php

session_start();



if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Announcements</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>

body{
    font-family:Arial;
    background:#f4f6f9;
    
}

.container{
    width:700px;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:10px;
}

input, textarea{
    width:100%;
    padding:12px;
    margin-top:10px;
}

button{
    width:100%;
    padding:12px;
    background:#2563eb;
    color:white;
    border:none;
    margin-top:10px;
}

</style>

</head>
<body>
<?php include_once 'sidebar.php'; ?>
<div class="main-content">

    

<div class="container">

<h2>Post Announcement</h2>

<form action="../controller/user/AnnouncementController.php"
method="POST">

<input type="text"
name="title"
placeholder="Announcement Title">

<textarea name="body"
placeholder="Write announcement"
rows="6"></textarea>

<button type="submit"
name="post_announcement">

Post Announcement

</button>

</form>

</div>


</div>
</body>
</html>