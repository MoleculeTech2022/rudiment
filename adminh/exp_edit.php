<?php

include "dbcon.php";
include "checklogin.php";

if (isset($_GET['expid'])) {
    $expid = mysqli_real_escape_string($con, $_GET['expid']);
    $query = "SELECT * FROM hexpense JOIN hexpensecategory ON hexpense.expCatgid = hexpensecategory.expCatgid WHERE hexpense.expid = $expid";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        while ($rows = mysqli_fetch_assoc($query_run)) {
            // php code 
            $expid = $rows['expid'];
            $expAmt = $rows['expAmt'];
            $expDate = $rows['expDate'];
            $expMode = $rows['expMode'];
            $expCatgid = $rows['expCatgid'];
            $acdyear = $rows['acdyear'];
        }
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>HABITUDE - Expense Edit</title>
        </head>

        <body>
            <?php
            include "sidebar.html";
            ?>
            <div class="navbar"
                style="margin-left:261px;width:80%;height: 70px;position: absolute;background-color: rgb(241, 246, 251);display: flex;">
                <div class="title" style="margin-top: 22px;margin-left: 30px;">
                    <span>Expense Edit</span>

                </div>
                <div class="search-bar">
                    <input type="search" placeholder="Search Your Student..." id="search" name="search"
                        style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:110px;">
                </div>
                <div class="icons" style="margin-left:25px;margin-top:25px;">

                    <a href="admission.php"><i class='bx bx-message-square-add icon'></i></a>
                    <i class="bx bx-heart icon"></i>
                    <i class="bx bx-mail-send icon"></i>
                    <i class="bx bx-map icon"></i>
                    <i class="bx bx-user icon"></i>
                </div>
                <div class="log-out-btn" style="margin-left:20px;margin-top:20px;">
                    <button
                        style="width:130px;height: 30px;background-color:#ff0000;border-width: 1px;border-radius: 20px;">LOG-OUT</button>
                </div>
            </div>
            <div class="dashboard-contents"
                style="margin-left:261px;width:900px;height:700px;background-color: #ffffff ;position: absolute;margin-top: 71px;">

                <div class="title" style="margin-top:30px;">
                    <span style="margin-left:30px;">Edit Expense Form</span>
                </div>
                <!-- // form starting -->
                <form action="expcode.php" method="POST" style="margin-top:5px;">

                    <input type="hidden" name="expid" value="<?php echo $expid; ?>">
                    <input type="hidden" name="expCatgid" value="<?php echo $expCatgid; ?>">

                    <input type="number" name="expAmt" value="<?php echo $expAmt; ?>" placeholder="Your Amount"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                    <input type="date" name="expDate" value="<?php echo $expDate; ?>" id="paydate"
                        placeholder="Your Amount Date"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                    <select name="expMode" placeholder="Your Amount Date"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                        <option>
                            <?php echo $expMode; ?>
                        </option>
                        <option value="Not Selected">Select Payment Mode</option>
                        <option value="Cash">Cash</option>
                        <option value="Account">Account</option>
                    </select>

                    <select name="acdyear" placeholder="Your Amount Date"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                        <option>
                            <?php echo $acdyear; ?>
                        </option>
                        <option value="2023-24">2023-24</option>
                        <option value="2022-23">2022-23</option>
                        <option value="2024-25">2024-25</option>
                    </select>

                    <select name="expCatgid" placeholder="Select Fees Titile"
                        style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                        <?php
                        $sql = "SELECT * FROM expensecategory";
                        $result = mysqli_query($con, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($rows = mysqli_fetch_assoc($result)) {
                                echo "mfdjkdvghgfrfctrcrcrecerxcredcreerrnfdn" . $rows['expCatgTitle'];
                                ?>
                                <option value="<?= $rows['expCatgid']; ?>">
                                    <?= $rows['expCatgid']; ?>
                                    <?= $rows['expCatgTitle']; ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>

                    <div class="expense-update-btn" style="margin-left:30px;margin-top:25px;margin-bottom:20px;height:300px;">

                        <button class="expense-update-btn" id="refreshButton" value="submit" name="edit_expense"
                            style="width:280px;height:35px;border-radius:5px;background-color:#63ffb4;border-width:1px;"
                            id="refreshButton">Edit Expense</button>
                    </div>
                </form>
            </div>








            <script>

                const dateInput = document.getElementById('paydate');

                // Add an event listener to format the date when the user changes it
                dateInput.addEventListener('change', function () {
                    // Get the selected date from the input
                    const selectedDate = dateInput.value;

                    // Format the date as desired (e.g., YYYY-MM-DD)
                    const formattedDate = formatDate(selectedDate);

                    // Update the input field with the formatted date
                    dateInput.value = formattedDate;
                });

                // Function to format the date as YYYY-MM-DD
                function formatDate(dateString) {
                    const date = new Date(dateString);
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                }
            </script>

        </body>

        </html>
        <?php



    } else {
        echo "<h4>No Such ID Found</h4>";
    }
} else {
    echo "Error: " . mysqli_error($con);
}

?>