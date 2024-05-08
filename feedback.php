<?php
$message = ""; 

if(isset($_POST['submit'])){
    $faculty_id = $_POST['faculty_id'];
    $faculty_name = $_POST['faculty_name'];
    $feedback_id = $_POST['feedback_id'];
    $feedback_rating = $_POST['feedback_rating'];
    $feedback_comment = $_POST['feedback_comment'];

    $host='localhost';
    $user= 'root';
    $pass= '';
    $dbname='mini';

    $conn = mysqli_connect($host, $user, $pass, $dbname, 330);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the feedback_id already exists
    $check_query = "SELECT * FROM feedback WHERE feedback_id = '$feedback_id'";
    $result = mysqli_query($conn, $check_query);

    if(mysqli_num_rows($result) > 0) {
        $message = "Feedback ID already exists. Please enter a unique ID."; 
    } else {
        // Insert the new feedback record
        $sql = "INSERT INTO feedback (faculty_id, faculty_name, feedback_id, feedback_rating, feedback_comment) VALUES ('$faculty_id', '$faculty_name', '$feedback_id', '$feedback_rating', '$feedback_comment')";

        try {
            if (mysqli_query($conn, $sql)) {
                $message = "Thank you for the feedback"; 
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback Form</title>
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
        .form-group input[type="number"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-group textarea {
            resize: vertical;
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
        .message {
            text-align: center;
            color: #4caf50;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Feedback Form</h2>
        <?php if(!empty($message)) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="faculty_id">Faculty ID:</label>
                <input type="text" id="faculty_id" name="faculty_id" required>
            </div>
            <div class="form-group">
                <label for="faculty_name">Faculty Name:</label>
                <input type="text" id="faculty_name" name="faculty_name" required>
            </div>
            <div class="form-group">
                <label for="feedback_id">Feedback ID:</label>
                <input type="number" id="feedback_id" name="feedback_id" required>
            </div>
            <div class="form-group">
                <label for="feedback_rating">Feedback Rating:</label>
                <input type="number" id="feedback_rating" name="feedback_rating" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="feedback_comment">Feedback Comment:</label>
                <textarea id="feedback_comment" name="feedback_comment" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="SUBMIT">
            </div>
        </form>
    </div>
</body>
</html>
