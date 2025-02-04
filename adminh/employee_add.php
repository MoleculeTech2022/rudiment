<?php
include "checklogin.php";
include "sidebar.html";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Employee</title>
</head>

<body>
    <!-- Begin of Top Navbar -->
    <div class="navbar"
        style="position: fixed; top: 0; left: 261px; width: 80%; height: 70px; background-color: rgb(241, 246, 251); display: flex;">
        <div class="title" style="margin-top: 22px; margin-left: 30px;">
            <span>Employee</span>
        </div>
        <div class="search-bar"> <!-- Search bar code -->
            <input type="search" id="employee-search" placeholder="Search Anything..."
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

    <div style="margin-left:310px; margin-top:70px;">
        <h1>Add a New Employee</h1>
        <form action="code.php" method="POST">

            <label for="fname">Employee Type:</label>
            <select name="emptype" required>
                <option value="Teacher">Teacher</option>
                <option value="House Keeping">House Keeping</option>
                <option value="Admin">Admin</option>
                <option value="Intans">Intans</option>
            </select><br><br>

            <label for="fname">First Name:</label>
            <input type="text" name="fname" required><br><br>

            <label for="mname">Middle Name:</label>
            <input type="text" name="mname"><br><br>

            <label for="lname">Last Name:</label>
            <input type="text" name="lname" required><br><br>

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" required><br><br>

            <label for="contact">Contact:</label>
            <input type="text" name="contact" required><br><br>

            <label for="email">Email:</label>
            <input type="email" name="email" required><br><br>

            <label for="address">Address:</label>
            <textarea name="address" required></textarea><br><br>

            <label for="doj">Date of Joining:</label>
            <input type="date" name="doj" required><br><br>

            <label for="dol">Date of Leaving:</label>
            <input type="date" name="dol"><br><br>

            <label for="dol">salamt:</label>
            <input type="text" name="salamt"><br><br>

            <label for="dol">from date:</label>
            <input type="date" name="fromdate"><br><br>

            <input type="submit" value="Add Employee">
        </form>
    </div>


</body>

</html>