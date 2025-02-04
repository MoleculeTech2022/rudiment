<?php
include 'dbcon.php';
include 'sidebar.html';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUDIMENT Template</title>
</head>

<body>
    <!-- Begin of Top Navbar -->
    <div class="navbar"
        style="margin-left:261px;width:80%;height: 70px;position: absolute;background-color: rgb(241, 246, 251);display: flex;">
        <div class="title" style="margin-top: 22px;margin-left: 30px;">
            <span>Page Header </span>
        </div>
        <div class="search-bar"> <!-- Search bar code -->
            <input type="search" placeholder="Search Anything..."
                style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:200px;">
        </div>
        <div class="icons" style="margin-left:25px;margin-top:25px;">
            <i class="bx bx-bell icon notification"></i>
            <i class="bx bx-heart icon"></i>
            <i class="bx bx-mail-send icon"></i>
            <i class="bx bx-map icon"></i>
            <i class="bx bx-user icon"></i>
        </div>
        <!-- Logout Button  -->
        <div class="log-out-btn" style="margin-left: 20px; margin-top: 20px;">
            <a href="logout.php">
                <button
                    style="width: 130px; height: 30px; background-color: #ff0000; border-width: 1px; border-radius: 20px; color: #fff;">LOG-OUT</button>
            </a>
        </div>
    </div>
    <!-- End of Top Navbar -->



</body>

</html>