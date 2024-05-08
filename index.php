<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 50%;
            max-width: 400px;
            text-align: center;
        }
        .btn-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to feedback</h2>
        <div class="btn-container">
            <button class="btn" onclick="window.location.href='user_register.php'">User Register</button>
            <button class="btn" onclick="window.location.href='user_login.php'">User Login</button>
            <button class="btn" onclick="window.location.href='admin_register.php'">Admin Register</button>
            <button class="btn" onclick="window.location.href='admin_login.php'">Admin Login</button>
        </div>
    </div>
</body>
</html>
