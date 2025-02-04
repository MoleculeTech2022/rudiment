<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .signup-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .signup-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="file"] {
            padding: 3px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "your_database";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $student_fname = $_POST['student_fname'];
            $student_mname = $_POST['student_mname'];
            $student_lname = $_POST['student_lname'];
            $student_phone = $_POST['student_phone'];
            $student_email = $_POST['student_email'];
            $hab_student_password = password_hash($_POST['hab_student_password'], PASSWORD_BCRYPT);

            // Handling file upload
            if (isset($_FILES['student_img']) && $_FILES['student_img']['error'] == 0) {
                $student_img = addslashes(file_get_contents($_FILES['student_img']['tmp_name']));
            } else {
                $student_img = null;
            }

            $sql = "INSERT INTO hab_students (student_img, student_fname, student_mname, student_lname, student_phone, student_email, hab_student_password) VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("bssssss", $student_img, $student_fname, $student_mname, $student_lname, $student_phone, $student_email, $hab_student_password);

            if ($stmt->execute()) {
                echo "<script>window.location.href='habitude_login_page.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="student_img">Profile Image</label>
                <input type="file" id="student_img" name="student_img" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="student_fname">First Name</label>
                <input type="text" id="student_fname" name="student_fname" required>
            </div>
            <div class="form-group">
                <label for="student_mname">Middle Name</label>
                <input type="text" id="student_mname" name="student_mname">
            </div>
            <div class="form-group">
                <label for="student_lname">Last Name</label>
                <input type="text" id="student_lname" name="student_lname" required>
            </div>
            <div class="form-group">
                <label for="student_phone">Phone</label>
                <input type="tel" id="student_phone" name="student_phone" pattern="[0-9]{10}" required>
            </div>
            <div class="form-group">
                <label for="student_email">Email</label>
                <input type="email" id="student_email" name="student_email" required>
            </div>
            <div class="form-group">
                <label for="hab_student_password">Password</label>
                <input type="password" id="hab_student_password" name="hab_student_password" required>
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
    </div>
</body>
</html>
