<!DOCTYPE html>
<html>
<head>
    <title>Branch Manager Login</title>

<style>

body{
    margin:0;
    padding:0;
    font-family:Arial;
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.login-box{
    width:350px;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.2);
}

h2{
    text-align:center;
    margin-bottom:20px;
}

input{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    width:100%;
    padding:12px;
    background:#007bff;
    color:white;
    border:none;
    border-radius:5px;
    margin-top:15px;
    cursor:pointer;
}

button:hover{
    background:#0056b3;
}

</style>

</head>
<body>

<div class="login-box">

<h2>Branch Manager Login</h2>

<form action="../controller/user/AuthController.php"
method="POST">

<input type="email"
name="email"
placeholder="Enter Email"
required>

<input type="password"
name="password"
placeholder="Enter Password"
required>

<button type="submit" name="login">
Login
</button>

</form>

</div>

</body>
</html>