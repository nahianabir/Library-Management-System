<?php

session_start();

include_once '../controller/user/ProfileController.php';

if(!isset($_SESSION['user_id'])) {

    header("Location: login.php");
}

$controller =
new ProfileController();

$user =
$controller->profile(
    $_SESSION['user_id']
);

$data =
mysqli_fetch_assoc($user);

$branches =
$controller->branches();

?>

<!DOCTYPE html>
<html>
<head>

<title>Manage Profile</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>

body{
    margin:0;
    font-family:Arial;
    background:#f1f5f9;
    
}

.container{
    max-width:950px;
    margin:auto;
}

.card{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    margin-bottom:25px;
}

.profile-image{
    text-align:center;
    margin-bottom:20px;
}

.profile-image img{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #2563eb;
}

h2{
    margin-bottom:20px;
}

input{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:1px solid #cbd5e1;
    border-radius:6px;
}

button{
    width:100%;
    padding:12px;
    margin-top:15px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:6px;
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

<div class="card">

<h2>Manage Profile</h2>

<div class="profile-image">

<?php

if($data['profile_pic'] != "") {

?>

<img

src="../assets/profile/<?php echo $data['profile_pic']; ?>"

>

<?php

}
else {

?>

<img

src="../assets/profile/default.png"

>

<?php } ?>

</div>

<form action="../controller/user/ProfileController.php"
method="POST"
enctype="multipart/form-data">

<input type="hidden"
name="user_id"
value="<?php echo $data['id']; ?>">

<input type="hidden"
name="old_image"
value="<?php echo $data['profile_pic']; ?>">

<input type="text"
name="name"
value="<?php echo $data['name']; ?>"
required>

<input type="email"
name="email"
value="<?php echo $data['email']; ?>"
required>

<input type="text"
name="phone"
value="<?php echo $data['phone']; ?>"
required>

<input type="file"
name="profile_pic">

<button type="submit"
name="update_profile">

Update Profile

</button>

</form>

</div>





</div>


</div>
</body>
</html>