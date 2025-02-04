<?php
// Local Server
//$conn = mysqli_connect("localhost","root","","rudiment");

// ONLINER Server
 $conn = mysqli_connect("192.168.0.100", "rudiment", "73mVp6ru6Y", "rudiment_db") or die("Connection Failed");
// $hostname = "192.168.0.100/rudimentD";

if(!$conn){
    die('Connection Failed'. mysqli_connect_error());
}

?>