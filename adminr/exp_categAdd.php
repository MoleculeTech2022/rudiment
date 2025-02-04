<?php

include "checklogin.php";
include "dbcon.php";

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Inswert Expense Category 
// Initialize variables
$expCatgid = "";
$expCatgTitle = "";
$expCatgDetail = "";

// Handle form submission
if (isset($_POST['submit'])) {
    // Handle Insert or Update
    // $expCatgid = $_POST['expCatgid'];
    $expCatgTitle = $_POST['expCatgTitle'];
    $expCatgDetail = $_POST['expCatgDetail'];

    // $user = $_POST['user'];

    if (empty($expCatgid)) {
        // Insert a new record
        $sql = "INSERT INTO expensecategory (expCatgTitle, expCatgDetail) VALUES ('$expCatgTitle', '$expCatgDetail')";
    } else {
        // Update an existing record
        // $sql = "UPDATE expensecategory SET expCatgTitle='$expCatgTitle', expCatgDetail='$expCatgDetail', dt='$dt', user='$user' WHERE expCatgid=$expCatgid";
    }

    if (mysqli_query($con, $sql)) {
        echo "Record saved successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

// Handle record deletion
if (isset($_GET['delete'])) {
    $expCatgid = $_GET['delete'];
    $sql = "DELETE FROM expensecategory WHERE expCatgid=$expCatgid";

    if (mysqli_query($con, $sql)) {
        echo "Record deleted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

// Retrieve existing records
$query = "SELECT * FROM expensecategory";
$result = mysqli_query($con, $query);
?>


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUDIMENT - Admin</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
    <style>
        /* Google Fonts - Poppins */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            min-height: 100%;
            background: #fdfeff;
        }

        nav {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 260px;
            padding: 20px 0;
            background-color: #fff;
            box-shadow: 0 5px 1px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            margin: 0 24px;
        }

        .logo .menu-icon {
            color: #333;
            font-size: 24px;
            margin-right: 14px;
        }

        .logo .logo-name {
            color: #333;
            font-size: 22px;
            font-weight: 500;
        }

        .sidebar-content {
            display: flex;
            height: 100%;
            flex-direction: column;
            justify-content: space-between;
            padding: 30px 16px;
        }

        .list {
            list-style: none;
        }

        .nav-link {
            display: flex;
            align-items: center;
            margin: 8px 0;
            padding: 14px 12px;
            border-radius: 8px;
            text-decoration: none;
        }

        .nav-link:hover {
            background-color: #4070f4;
        }

        .icon {
            margin-right: 14px;
            font-size: 20px;
            color: #707070;
        }

        .link {
            font-size: 16px;
            color: #707070;
            font-weight: 400;
        }

        .nav-link:hover .icon,
        .nav-link:hover .link {
            color: #fff;
        }
    </style>
</head>

<body>
    <!-- BEGIN OF : Side Navbar  -->
    <nav>
        <div class="logo" style="display: flex; align-items: center; margin: 0 24px;">
            <i class="bx bx-menu menu-icon" style="color: #00CED1; font-size: 24px; margin-right: 14px;"></i>
            <a href="index.php" style="text-decoration: none;">
                <span class="logo-name" style="color: #00CED1; font-size: 28px; font-weight: bold;">RUDIMENT</span>
            </a>
        </div>

        <!-- BEGIN OF Sidebar - with all button  -->
        <div class="sidebar-content" style="margin-top:-20px;">
            <ul class="lists">
                <li class="list">
                    <a href="index.php" class="nav-link" style="background-color: #4070f4; border: 1px solid #ddd;">
                        <i class="bx bx-home-alt icon" style="color:#fff;"></i>
                        <span class="link" style="color:#fff;">Dashboard</span>
                    </a>
                </li>
                <li class="list">
                    <a href="students.php" class="nav-link" style="border: 1px solid #ddd;">
                        <i class="bx bx-bar-chart-alt-2 icon"></i>
                        <span class="link">Students</span>
                    </a>
                </li>
                <li class="list">
                    <a href="teachers.php" class="nav-link" style="border: 1px solid #ddd;">
                        <i class="bx bx-bell icon"></i>
                        <span class="link">Teachers</span>
                    </a>
                </li>
                <li class="list">
                    <a href="payments.php" class="nav-link" style="border: 1px solid #ddd;">
                        <i class="bx bx-message-rounded icon"></i>
                        <span class="link">Payments</span>
                    </a>
                </li>
                <li class="list">
                    <a href="due.html" class="nav-link" style="border: 1px solid #ddd;">
                        <i class="bx bx-pie-chart-alt-2 icon"></i>
                        <span class="link">Due EMI</span>
                    </a>
                </li>
                <li class="list">
                    <a href="expense.php" class="nav-link" style="border: 1px solid #ddd;">
                        <i class="bx bx-heart icon"></i>
                        <span class="link">Expense</span>
                    </a>
                </li>
                <li class="list">
                    <a href="#" class="nav-link" style="border: 1px solid #ddd;">
                        <i class="bx bx-folder-open icon"></i>
                        <span class="link">Files</span>
                    </a>
                </li>
            </ul>

            <div class="bottom-content">
                <li class="list">
                    <a href="#" class="nav-link" style="border: 1px solid #ddd;">
                        <i class="bx bx-cog icon"></i>
                        <span class="link">Settings</span>
                    </a>
                </li>
            </div>
        </div>
        <!-- END OF : Sidebar - with all button  -->

    </nav>
    <!-- END OF : Side Navbar  -->



    <!-- BEGIN OF : TOP Navbar  -->

    <div class="navbar"
        style="margin-left:261px;width:80%;height: 70px;position: absolute;background-color: rgb(241, 246, 251);display: flex;">
        <div class="title" style="margin-top: 22px;margin-left: 30px;">
            <span>Dashboard</span>
        </div>
        <div class="search-bar">
            <input type="search" placeholder="Search AnyThing..."
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
                    style="width: 130px; height: 30px; background-color: #4CAF50; border-width: 1px; border-radius: 20px; color: #fff;">LOG-OUT</button>
            </a>
        </div>

    </div>
    <!-- END OF : Top Navbar  -->


    <!-- BEGIN of Main Page Content  -->
    <!-- style="margin-left:261px;width:500px;height:400px; -->

    <div class="dashboard-contents"
        style="margin-left: 261px; background-color: #ffffff; position: absolute; margin-top: 71px; padding: 20px;">

        <!-- BEGIN of INSERT / UPDATE EXPENSE CATEGORY FORM -->
        <h2>Expense Category Management</h2>

        <!-- Form for inserting and updating records -->
        <form method="post" action="" style="text-align: center;">
            <div style="text-align: left;">
                <label for="expCatgTitle" style="display: inline-block; width: 150px; margin-right: 10px;">Category
                    Title:</label>
                <input type="text" name="expCatgTitle" id="expCatgTitle" value="<?php echo $expCatgTitle; ?>"
                    style="width: 200px;"><br>
                <label for="expCatgDetail" style="display: inline-block; width: 150px; margin-right: 10px;">Category
                    Detail:</label>
                <input type="text" name="expCatgDetail" id="expCatgDetail" value="<?php echo $expCatgDetail; ?>"
                    style="width: 200px;"><br>
            </div>
            <br>
            <button type="submit" name="submit">Save</button>
        </form>
        <!-- END of INSERT / UPDATE EXPENSE CATEGORY FORM -->

        <!-- BEGIN of DISPLAY EXPENSE CATEGORY TABLE -->
        <!-- Display existing records -->
        <h3>Expense Categories</h3>
        <table border="1">
            <tr>
                <th>Category Title</th>
                <th>Category Detail</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['expCatgTitle']}</td>";
                echo "<td>{$row['expCatgDetail']}</td>";
                echo "<td><a href='javascript:void(0);' onclick='confirmDelete({$row['expCatgid']})'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <!-- END of DISPLAY EXPENSE CATEGORY TABLE -->

        <!-- JavaScript for confirmation dialog -->
        <script>
            function confirmDelete(expid) {
                if (confirm("Are you sure you want to delete this record?")) {
                    window.location.href = "?delete=" + expid;
                }
            }
        </script>

        <!-- Close the database connection -->
        <?php
        mysqli_close($con);
        ?>

    </div>




    <!-- END of Main Page Content  -->
</body>

</html>