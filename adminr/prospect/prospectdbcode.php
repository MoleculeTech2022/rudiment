<?php

include "../dbcon.php";


if (isset($_POST['submit'])) {

    $sname = mysqli_real_escape_string($con, $_POST['sname']);
    $dov = mysqli_real_escape_string($con, $_POST['dov']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $enrollclass = mysqli_real_escape_string($con, $_POST['enrollclass']);
    $region = mysqli_real_escape_string($con, $_POST['region']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $local = mysqli_real_escape_string($con, $_POST['local']);
    $faname = mysqli_real_escape_string($con, $_POST['faname']);
    $foccup = mysqli_real_escape_string($con, $_POST['foccup']);
    $fcontact = mysqli_real_escape_string($con, $_POST['fcontact']);
    $moname = mysqli_real_escape_string($con, $_POST['moname']);
    $moccup = mysqli_real_escape_string($con, $_POST['moccup']);
    $mcontact = mysqli_real_escape_string($con, $_POST['mcontact']);
    $fsalary = mysqli_real_escape_string($con, $_POST['fsalary']);
    $house = mysqli_real_escape_string($con, $_POST['house']);
    $admchance = mysqli_real_escape_string($con, $_POST['admchance']);
    $remarks = mysqli_real_escape_string($con, $_POST['remarks']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $ref = mysqli_real_escape_string($con, $_POST['ref']);
    $identifier = mysqli_real_escape_string($con, $_POST['identifier']);
    $age = mysqli_real_escape_string($con, $_POST['age']);

    $query = "INSERT INTO prospect (sname, dov, gender, enrollclass, region, local, faname, foccup, fcontact, moname, moccup, mcontact, fsalary, house, admchance, remarks, `state`, ref,identifier,age,status) 
    VALUES ('$sname','$dov', '$gender', '$enrollclass', '$region', '$local', '$faname', '$foccup', '$fcontact', '$moname', '$moccup', '$mcontact', '$fsalary', '$house', '$admchance', '$remarks', '$state', '$ref', '$identifier','$age','$status')";

    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Prospect admission successfully";
        header("Location: prospect.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($con);
        header("Location: addProspect.php");
        exit(0);
    }

}

if (isset($_POST['commentaddbtn'])) {

    $pros_id_tv = mysqli_real_escape_string($con, $_POST['pros_id_tv']);
    $followby = mysqli_real_escape_string($con, $_POST['followby']);
    $followmode = mysqli_real_escape_string($con, $_POST['followmode']);
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $dof = mysqli_real_escape_string($con, $_POST['dof']);
    $nextstep = mysqli_real_escape_string($con, $_POST['nextstep']);
    // this one field insert into prospect table
    $nfd = mysqli_real_escape_string($con, $_POST['nfd']);


    $query = "INSERT INTO followup (pros_id, followby, followmode, comment, dof,nextstep) 
    VALUES ('$pros_id_tv', '$followby', '$followmode', '$comment', '$dof', '$nextstep')";

    $query_nfd = "UPDATE prospect SET nfd='$nfd' WHERE prospect.pros_id = '$pros_id_tv'";

    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Prospect admission successfully";
        header("Location: prospectview.php?pros_id=$pros_id_tv");
        exit(0);
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($con);
        header("Location: prospectview.php?pros_id=$pros_id_tv");
        exit(0);
    }

}


if (isset($_POST['prospecteditbtn'])) {

    $pros_id = mysqli_real_escape_string($con, $_POST['pros_id']);
    $sname = mysqli_real_escape_string($con, $_POST['sname']);
    $dov = mysqli_real_escape_string($con, $_POST['dov']);
    $enrollclass = mysqli_real_escape_string($con, $_POST['enrollclass']);
    $ref = mysqli_real_escape_string($con, $_POST['ref']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $region = mysqli_real_escape_string($con, $_POST['region']);
    $local = mysqli_real_escape_string($con, $_POST['local']);
    $faname = mysqli_real_escape_string($con, $_POST['faname']);
    $foccup = mysqli_real_escape_string($con, $_POST['foccup']);
    $fcontact = mysqli_real_escape_string($con, $_POST['fcontact']);
    $moname = mysqli_real_escape_string($con, $_POST['moname']);
    $moccup = mysqli_real_escape_string($con, $_POST['moccup']);
    $mcontact = mysqli_real_escape_string($con, $_POST['mcontact']);
    $fsalary = mysqli_real_escape_string($con, $_POST['fsalary']);
    $msalary = mysqli_real_escape_string($con, $_POST['msalary']);
    $house = mysqli_real_escape_string($con, $_POST['house']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $remarks = mysqli_real_escape_string($con, $_POST['remarks']);
    $admchance = mysqli_real_escape_string($con, $_POST['admchance']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    $query = "UPDATE prospect SET sname='$sname', dov='$dov', ref='$ref', gender='$gender', enrollclass='$enrollclass', region='$region', local='$local', faname='$faname', foccup='$foccup', fcontact='$fcontact', moname='$moname', moccup='$moccup', mcontact='$mcontact', fsalary='$fsalary', msalary='$msalary', house='$house', state='$state', remarks='$remarks', admchance='$admchance', `status`='$status' WHERE prospect.pros_id = '$pros_id'";

    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Prospect updated successfully";
        header("Location: prospect.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($con);
        header("Location: prospect.php");
        exit(0);
    }

}

?>