<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "mini";


$conn = new mysqli($servername, $username, $password, $database,330);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$name = $email = $password = "";
$name_err = $email_err = $password_err = "";
$success_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

  
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
       
        $sql = "SELECT id FROM admin WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
           
            $stmt->bind_param("s", $param_email);

            
            $param_email = trim($_POST["email"]);

            if ($stmt->execute()) {
               
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

     
            $stmt->close();
        }
    }

  
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

   
    if (empty($name_err) && empty($email_err) && empty($password_err)) {
       
        $sql = "INSERT INTO admin (name, email, password) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
         
            $stmt->bind_param("sss", $param_name, $param_email, $param_password);

            
            $param_name = $name;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
           
            if ($stmt->execute()) {
          
                $success_message = "Registration successful. Your ID is: " . $stmt->insert_id;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            $stmt->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <style>
       
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 3px;
            background-color: #4caf50;
            color: white;
            cursor: pointer;
            font-size: 16px;
            box-sizing: border-box;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .success-message {
            color: green;
            font-size: 16px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Registration</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>">
                <span class="error-message"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                <span class="error-message"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <span class="error-message"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Register">
            </div>
            <div class="success-message"><?php echo $success_message; ?></div>
            <div class="form-group">
                <a href="admin_login.php">Admin Login</a>
            </div>
        </form>
    </div>
</body>
</html>
