<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rudiment Admin Panel Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-image: url(images/login-background.jpg);
            background-repeat: no-repeat;
        }

        .login-form {
            width: 350px;
            height: 380px;
            background-color: aliceblue;
            background-image: url(images/loginbg.jpg);
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 10px;
            margin-left: 20px;
            margin-top: 20px;
            position: absolute;
        }

        h4 {
            margin-left: 40px;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            margin-top: 30px;
            color: whitesmoke;
        }

        h5 {
            color: whitesmoke;
            font-size: small;
            margin-left: 75px;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div>

        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="login-form">
                <h4>RUDIMENT ADMIN PANEL</h4>
                <hr>
                <h5>LOGIN To Proceed To DashBoard</h5>
                <div class="username mb-3 form-group" style="margin-left:10px;margin-top:25px;">
                    <lable>Username</lable>
                    <input type="text" name="username" class="form-control" id="username">
                    </select>
                </div>
                <div class="username mb-3 form-group" style="margin-left:10px;margin-top:15px;">
                    <lable>Password</lable>
                    <input type="password" name="password" placeholder="Password" id="password" class="form-control"
                        style="width:300px;margin-top: 5px;">
                </div>

                <div class="login-btn">
                    <button class="btn btn-primary" name="login" style=" margin-left:75px;margin-top:15px;"
                        onclick="login()">Proceed To DashBoard</button>
                </div>

        </form>
    </div>


    <?php
    if (isset($_POST['login'])) {
        include "dbcon.php";
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = '{$username}' AND `password` = '{$password}'";
        $login_result = mysqli_query($con, $sql) or die("Querry of Login Failed ");
        // AFTERLOGIN - UPDATE GLOBALSESSION VARIABLE
        if (mysqli_num_rows($login_result) > 0) {
            while ($rows = mysqli_fetch_assoc($login_result)) {
                session_start();
                $_SESSION["username"] = $rows['username'];
                // $_SESSION["password"] = $rows['password'];
                $_SESSION["role"] = $rows['role'];

                // header("Location: {$hostname}/admin/index.php");
                header("Location: splash.html");
                // header("Location: {$hostname}/admin/index.php");
            }
        } else {
            echo "<h6> Username & Password not matched. </h6>";
        }
    }
    ?>



    <script>
        document.getElementById("todaydate").value = new Date().toLocaleDateString();
        document.getElementById("current-time").value = new Date().toLocaleTimeString();

        function login() {
            var password = document.getElementById('password').value
            if (password == "rudiment") {
                window.location.assign("home.php");
            } else {
                alert("Incorrect Password");
                return;
            }
        }
    </script>
</body>

</html>