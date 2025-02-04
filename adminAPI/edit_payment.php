<?php

include 'dbcon.php';


$response = array();

if (isset($_POST['payid'])) {

    $payid = $_POST['payid'];
    $payamt = $_POST['payamt'];
    $paydate = $_POST['paydate'];
    $paymode = $_POST['paymode'];

    $query = "UPDATE payment SET payamt='$payamt', paydate='$paydate', paymode='$paymode' WHERE payid='$payid' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        //echo "Payment Updated Successfully from new API";
        $response['message'] = "Payment Updated Successfull from NEW API ".$paymode . " Pay id ". $payid;
    }
    else {
        // echo "Payment Update Failed";
        $response['message'] = "FAILED from NEW API";
    }
    

echo json_encode($response);
}

?>
