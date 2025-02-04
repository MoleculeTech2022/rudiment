<?php

include "dbcon.php";

$name = $_GET['t1'];
$desig = $_GET['t2'];

$sql = "INSERT INTO android(`name`,desig) VALUES ('$name','$desig')";
$result = mysqli_query($con, $sql);

if($result) {
echo "Data Inserted Successfully";
 }

?>