<?php 
session_start();

$login_successful = false;

if ($login_successful) {
    $_SESSION['email'] = $email;
    header("Location: admin_dashboard.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "mini";

$conn = new mysqli($servername, $username, $password, $database, 330);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['delete']) && isset($_POST['feedback_id'])) {
    $feedback_id = $_POST['feedback_id'];
    $sql_delete = "DELETE FROM feedback WHERE feedback_id = $feedback_id";

    if ($conn->query($sql_delete) === TRUE) {
        echo "<script>alert('Record deleted successfully');</script>";
      
        echo "<script>window.location.reload();</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);


if (isset($_POST['update']) && isset($_POST['feedback_id'])) {
    $feedback_id = $_POST['feedback_id'];
    $faculty_id = $_POST['faculty_id'];
    $faculty_name = $_POST['faculty_name'];
    $feedback_rating = $_POST['feedback_rating'];
    $feedback_comment = $_POST['feedback_comment'];
    
    $sql_update = "UPDATE feedback SET faculty_id='$faculty_id', faculty_name='$faculty_name', feedback_rating='$feedback_rating', feedback_comment='$feedback_comment' WHERE feedback_id=$feedback_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Record updated successfully');</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #4caf50;
        }
        a:hover {
            text-decoration: underline;
        }
        button {
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
        }
        .update-button {
            background-color: #4caf50;
            color: white;
            border: none;
        }
    </style>
    <script>
        function confirmDelete(feedbackId) {
            if(confirm('Are you sure you want to delete this record?')) {
               
                var formData = new FormData();
                formData.append('delete', 'delete');
                formData.append('feedback_id', feedbackId);
                
               
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                           
                            alert('Record deleted successfully');
                            
                            window.location.reload();
                        } else {
                            
                            alert('Error deleting record');
                        }
                    }
                };
                xhr.open('POST', 'admin_dashboard.php', true);
                xhr.send(formData);
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Welcome, Admin!</h1>
        <h2>All Feedback</h2>
        <table>
            <tr>
                <th>Faculty ID</th>
                <th>Faculty Name</th>
                <th>Feedback ID</th>
                <th>Feedback Rating</th>
                <th>Feedback Comment</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["faculty_id"] . "</td>";
                    echo "<td>" . $row["faculty_name"] . "</td>"; 
                    echo "<td>" . $row["feedback_id"] . "</td>";
                    echo "<td>" . $row["feedback_rating"] . "</td>";
                    echo "<td>" . $row["feedback_comment"] . "</td>";
                    echo "<td>";
                    echo "<form id='form_$row[feedback_id]' method='post' action='admin_dashboard.php'>";
                    echo "<input type='hidden' name='feedback_id' value='" . $row["feedback_id"] . "'>";
                    echo "<input type='text' name='faculty_id' value='" . $row["faculty_id"] . "'><br>";
                    echo "<input type='text' name='faculty_name' value='" . $row["faculty_name"] . "'><br>";
                    echo "<input type='number' name='feedback_rating' value='" . $row["feedback_rating"] . "' min='1' max='5'><br>";
                    echo "<input type='text' name='feedback_comment' value='" . $row["feedback_comment"] . "'><br>";
                    echo "<button type='submit' name='update' class='update-button'>Update</button>";
                    echo "<button type='button' onclick='confirmDelete(" . $row["feedback_id"] . ")' class='delete-button'>Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No feedback available</td></tr>";
            }
            ?>
        </table>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
