<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Educational Portal</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #ff9966, #ff5e62);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .header {
            position: absolute;
            top: 0;
            width: 100%;
            padding: 20px 0;
            background: rgba(0, 0, 0, 0.5);
            text-align: center;
            font-size: 24px;
            color: #fff;
            font-weight: bold;
        }

        .signup-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
            padding: 40px;
            box-sizing: border-box;
            text-align: center;
        }

        .signup-container h2 {
            color: #333;
            margin-bottom: 24px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            color: #333;
        }

        .form-group input:focus {
            outline: none;
            border-color: #6a11cb;
            box-shadow: 0 0 4px rgba(106, 17, 203, 0.5);
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-group button:hover {
            background: linear-gradient(to right, #2575fc, #6a11cb);
        }

        @media (max-width: 480px) {
            .signup-container {
                padding: 20px;
            }

            .signup-container h2 {
                font-size: 20px;
            }

            .form-group button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="header">HABITUDE CSE ACADEMY</div>
    <div class="signup-container">
        <h2>Create Your Account</h2>
        <form action="signup.php" method="POST">
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" id="fname" name="student_fname" placeholder="Enter your first name" required>
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="student_lname" placeholder="Enter your last name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="student_email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="student_phone" placeholder="Enter your phone number" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="hab_student_password" placeholder="Create a password" required>
            </div>
        
            <div class="form-group">
                <button type="submit">Sign Up</button>
            </div>
        </form>
    </div>
</body>
</html>
