<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
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
        .form-group input[type="password"],
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-group input[type="submit"],
        .form-group input[type="button"] {
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
        }
        .lg{
            width: 50%;
            padding: 10px;
            border: none;
            border-radius: 3px;
            background-color: #4caf50;
            color: white;
            cursor: pointer;
            font-size: 16px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration Form</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="rollNumber">Roll Number:</label>
                <input type="text" id="rollNumber" name="roll" required>
            </div>
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="course">Course:</label>
                <select id="course" name="course">
                    <option value="Btech">Btech</option>
                </select>
            </div>
            <div class="form-group">
                <label for="class">Class:</label>
                <select id="class" name="class">
                    <option value="SY">SY</option>
                    <option value="TY">TY</option>
                </select>
            </div>
            <div class="form-group">
                <label for="division">Division:</label>
                <select id="division" name="division">
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Register">
            </div>
            <div class="form-group">
                <input type="button" class="lg" value="Already have an account? Login" onclick="window.location.href='user_login.php'">
            </div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                $servername = "localhost";
                $username = "root"; 
                $password = ""; 
                $database = "mini"; 
            
                // Create connection
                $conn = new mysqli($servername, $username, $password, $database,330);
            
                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
            
                
                $rollNumber = $_POST['roll'];
                $firstName = $_POST['first_name'];
                $lastName = $_POST['last_name'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
                $course = $_POST['course'];
                $class = $_POST['class'];
                $division = $_POST['division'];
            
                
                $sql = "INSERT INTO users (roll, first_name, last_name, email, password, course, class, division) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssss", $rollNumber, $firstName, $lastName, $email, $password, $course, $class, $division);
            
                
                try {
                    $stmt->execute();
                    echo "Registration successful!";
                } catch (mysqli_sql_exception $e) {
                    
                    if ($e->getCode() == 1062) {
                        echo "<div class='error-message'>Error: You are already registered with this Roll Number.</div>";
                    } else {
                        echo "Error: " . $e->getMessage();
                    }
                }
            
                
                $stmt->close();
                $conn->close();
            }
            ?>
        </form>
    </div>
</body>
</html>
