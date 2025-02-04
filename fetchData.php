    <?php
    // Local Server
    //$con = mysqli_connect("localhost","root","","rudiment");

    // ONLINER Server
    $con = mysqli_connect("192.168.0.100", "rudiment_db", "73mVp6ru6Y", "rudiment_db") or die("Connection Failed");
    // $hostname = "192.168.0.100/rudimentD";

    if(!$con){
        die('Connection Failed'. mysqli_connect_error());
    }

    $result = array();
    $result['data'] = array();
    $select = "SELECT * from android";
    $responce = mysqli_query($con, $select);

   while($row = mysqli_fetch_array($responce))
{
    $index['id'] = $row['0'];
    $index['name'] = $row['1'];

    array_push($result['data'],$index);

}
    $result["success"]="1";
    echo json_encode($result);
    mysqli_close($con);

    ?>