<?php

include "../dbcon.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porspect Admission</title>

    <!-- // boxicons icon link cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/boxicons/2.0.7/boxicons.min.css">


    <!-- // fontawesome css link -->
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <style>
        table {
            border-collapse: collapse;
            width: 850px;
            margin-left: 30px;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: none;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #ffffff;
            color: rgb(0, 0, 0);
        }

        .menu {
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .menu li {
            padding: 10px;
            cursor: pointer;
        }

        .menu li:hover {
            background-color: #f2f2f2;
        }

        .active-status {
            color: rgb(4, 218, 32);
        }

        .pending-status {
            color: #eea435;
        }

        .suspended-status {
            color: rgb(255, 0, 0);
        }
    </style>

</head>

<body>

    <?php
    include "sidebar.html";
    ?>

    <div class="students-page-contents" style="margin-top:-20px;">
        <span style="margin-left:290px;font-size:12px;">Rudiment / <i class="fa fa-home"></i> / Prospect</span><br>
        <span style="font-size:35px;margin-left:290px;margin-top:20px;">Prospect List</span><br>
        <span style="margin-left:290px;margin-top:20px;font-size: 12px;">Manage all the new prospect.</span>

    </div>
    <div class="buttons" style="margin-left:990px;margin-top:-90px;">
        <a href="addProspect.php" style="text-decoration:none;">
            <button
                style="height:40px;width:100px;margin-top:20px;margin-left:-10px;background-color:rgb(50, 61, 77);color:#fff;border:none;border-radius: 5px;">Add
                Prospect</button>
        </a>
        <!-- <a href="payments.php"> -->
        <button
            style="height:40px;width:130px;margin-top:20px;margin-left:10px;background-color:rgb(100, 193, 255);color:#fff;border:none;border-radius: 5px;">Target
            Admission</button>
        <!-- </a> -->
    </div>

    <div class="search" style="margin-top: 53px;margin-left:290px;">
        <input type="text" placeholder="search..." name="search" id="searchInput"
            style="width: 250px; height: 35px; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
    </div>

    <div class="filter-select-box" style="margin-top: -36px; margin-left: 560px;">
        <select name="targetfilter" id="targetfilter" onchange="filterTableByTarget(this.value)"
            style="width: 130px; height: 35px; padding: 5px; border: 1px solid #edeaea; border-radius: 5px;">
            <option value="All">Target Filter</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>
    </div>


    <div class="student-list-table"
        style="width:1030px;margin-left: 290px;background-color: #fff;border-radius: 10px;height: 600px;margin-top:10px;">
        <div class="filter-select-box" style="margin-top: 6px; margin-left: 0px;">
            <select name="regionfilter" id="regionfilter" onchange="filterTableByRegion(this.value)"
                style="width:130px;height:35px;margin-left:0px;margin-top:20px;padding: 5px;border-color: #edeaea;border-radius: 5px;">
                <?php
                // Fetch regions from the database
                $regions = array("Bodkewadi", "Boherwadi", "Chande Phata", "Gawarewadi", "Joshi Wadewala", "Joyville Side", "Maan Gaon", "Mulani Basti", "Ozarkarwadi", "Pandav Nagar", "Power House", "Others");

                // Output options for the select box
                echo '<option value="All">All Regions</option>';
                foreach ($regions as $region) {
                    echo '<option value="' . $region . '">' . $region . '</option>';
                }
                ?>
            </select>

            <button
                style="height:30px;width:70px;margin-top:20px;margin-left:10px;background-color:rgb(250, 174, 93);color:#fff;border:none;border-radius: 5px;">Apply</button>

            <!-- <a href="prospectreport.php" style="text-decoration:none;"> -->
            <button
                style="height:30px;width:150px;margin-top:20px;margin-left:530px;background-color:rgb(250, 93, 93);color:#fff;border:none;border-radius: 3px;">Prospect
                Report</button>
            <!-- </a> -->


            <hr style="margin-top: 15px;color: #ffffff;margin-left:0px;width:930px;">
        </div>
        <div class="table" id="student-table" style="margin-left: 7px;">

            <table style="width:1080px;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Region</th>
                        <th>Gender</th>
                        <th>Chance</th>
                        <th>Status</th>
                        <th>State</th>
                        <th>Identifier</th>
                        <th>Next Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    $sqlFetchStudents = "SELECT * FROM prospect
                        ORDER BY prospect.pros_id DESC";
                    $resultFetchStudents = mysqli_query($con, $sqlFetchStudents);
                    $count = 0;

                    if (mysqli_num_rows($resultFetchStudents) > 0) {
                        while ($rows = mysqli_fetch_assoc($resultFetchStudents)) {

                            $email = "";

                            $status = "";
                            $rowClass = '';

                            if ($status == 'Active') {
                                $rowClass = 'active-status';
                            } elseif ($status == 'Pending') {
                                $rowClass = 'pending-status';
                            } elseif ($status == 'Suspended') {
                                $rowClass = 'suspended-status';
                            }


                            ?>
                            <tr>

                                <td style="color:#000;">
                                    <?php
                                    echo $count + 1;
                                    ?>
                                </td>
                                <td>
                                    <a href="prospectview.php?pros_id=<?php echo $rows['pros_id']; ?>"
                                        style="text-decoration: none;color:#000;">
                                        <span style="font-size:15px;">
                                            <?php echo $rows['sname']; ?>
                                        </span>
                                    </a>
                                    <br>
                                    <span style="font-size:10px;">
                                        <?php
                                        echo $rows['identifier'];
                                        ?>
                                    </span>

                                </td>
                                <td>
                                    <?php echo "M : " . $rows['mcontact']; ?><br>
                                    <?php echo "F : " . $rows['fcontact']; ?>
                                </td>
                                <td>
                                    <?php echo $rows['region']; ?>
                                </td>
                                <td>
                                    <?php echo $rows['gender']; ?>
                                </td>
                                <td>
                                    <?php echo $rows['admchance']; ?>
                                </td>

                             
                                <td>
                                    <?php echo $rows['status']; ?>
                                </td>

                                <td>
                                    <?php echo $rows['state']; ?>
                                </td>
                                <td>
                                    <?php echo $rows['identifier']; ?>
                                </td>
                                <td>
                                    <?php echo $rows['nfd']; ?>
                                </td>

                                <td>
                                    <a href="prospectview.php?pros_id=<?php echo $rows['pros_id']; ?>"
                                        style="text-decoration: none;">
                                        <i class="bx bx-id-card" style="margin-left:15px;"></i>
                                    </a>
                                    <a href="prospectedit.php?pros_id=<?php echo $rows['pros_id']; ?>">
                                        <i class="fa fa-edit" style="margin-left:15px;"></i>
                                    </a>
                                </td>
                            </tr>

                            <?php
                            $count++;
                        }
                    }

                    ?>
                </tbody>
            </table>

        </div>

    </div>

    <!-- target filter -->
    <script>
        function filterTableByTarget(selectedTarget) {
            const tableRows = document.querySelectorAll('#student-table tbody tr');

            tableRows.forEach(row => {
                const targetCell = row.querySelector('td:nth-child(7)'); // Assuming target is in the 7th column
                const target = targetCell.textContent.trim();

                if (selectedTarget === 'All' || target === selectedTarget) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>


    <!-- region filter -->
    <script>
        function filterTableByRegion(selectedRegion) {
            const tableRows = document.querySelectorAll('#student-table tbody tr');

            tableRows.forEach(row => {
                const regionCell = row.querySelector('td:nth-child(4)'); // Assuming region is in the 4th column
                const region = regionCell.textContent.trim();

                if (selectedRegion === 'All' || region === selectedRegion) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>


    <script>
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody');
        const rows = tableBody.getElementsByTagName('tr');

        searchInput.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();

            console.log('Search text:', searchText);

            for (let i = 0; i < rows.length; i++) {
                let rowMatch = false;

                for (let j = 0; j < rows[i].cells.length; j++) {
                    const cell = rows[i].cells[j];
                    const cellText = cell.textContent || cell.innerText;

                    console.log('Cell text:', cellText);

                    if (cellText.toLowerCase().indexOf(searchText) > -1) {
                        rowMatch = true;
                        break;
                    }
                }

                console.log('Row match:', rowMatch);

                rows[i].style.display = rowMatch ? '' : 'none';
            }
        });
    </script>

    <script>

        // status filter hai chance filter
        function updateStudentTable(selectedStatus) {
            $.ajax({
                url: "statusFilter.php",
                method: "POST",
                data: { status: selectedStatus },
                success: function (data) {
                    $("#student-table tbody").html(data);
                },
                error: function () {
                    $("#student-table tbody").html('<tr><td colspan="6">Error loading data.</td></tr>');
                }
            });
        }


        $("#chance").change(function () {
            var selectedStatus = $(this).val();
            updateStudentTable(selectedStatus);
        });


    </script>


</body>

</html>