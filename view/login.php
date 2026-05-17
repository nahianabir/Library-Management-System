<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Library Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            width: 100%;
            max-width: 350px;
            background: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #bdc3c7;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #2c3e50;
            font-size: 24px;
        }

        h3 {
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
            margin: 0 0 20px 0;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            margin-top: 15px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        button:hover {
            background: #2980b9;
        }

        button:active {
            transform: scale(0.98);
        }

        .error {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Library Management System</h2>
        <h3 style="text-align: center; color: #666; font-size: 14px; margin: 0 0 20px 0;">Admin Login</h3>
        <form action="../controller/AuthController.php" method="POST">
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
