<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e0f7fa; /* Light turquoise background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 1.5rem;
            color: #40e0d0;
        }

        .login-container input {
            width: 90%;
            padding: 0.75rem;
            margin-bottom: 1.5rem;
            border: 1px solid #40e0d0;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
        }

        .login-container input:focus {
            outline: none;
            border-color: #20b2aa;
            box-shadow: 0 0 8px rgba(32, 178, 170, 0.5);
        }

        .login-container button {
            width: 97%;
            padding: 0.75rem;
            background-color: #40e0d0;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background-color: #20b2aa;
        }

        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 1.5rem;
            z-index: 1000;
        }

        .loading-overlay.active {
            display: flex;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Student Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <input type="email" id="email" placeholder="Email" name="student_email" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" placeholder="Password" name="student_password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
