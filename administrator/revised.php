<?php
session_start();
include '../functions/conn.php';
if(isset($_POST['savedatafaculty'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $batch = mysqli_real_escape_string($conn, $_POST['batch']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $speech = mysqli_real_escape_string($conn, $_POST['speech']);
    $image = $_FILES['image']['name'];

    //check if there is an image
    if($image != ""){
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $extensions_arr = array("jpg","jpeg","png","gif");

        if( in_array($imageFileType,$extensions_arr) ){
            move_uploaded_file($_FILES['image']['tmp_name'],$target_dir.$image);
        }

        $imgfile = $image;
    }else{
        $imgfile = "";
    }
    $sql = "INSERT INTO `facultymember`(`FULLNAME`, `COURSE`, `BATCH`, `ROLE`, `SPEECH`, `IMG`) VALUES ('$name', '$course', '$batch', '$role', '$speech', '$imgfile')";
    if(mysqli_query($conn, $sql)){
        $_SESSION['stat']="success";
        $_SESSION['message']="Faculty member added successfully!";

        header('location: faculty.php?batch='.$batch);
    }else{
        $_SESSION['stat']="failed";
        $_SESSION['message']="Failed to add faculty member!";
        header('location: faculty.php?batch='.$batch);
    }
}
if(isset($_POST['savedatafacultyupdate'])){
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $batch = mysqli_real_escape_string($conn, $_POST['batch']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $speech = mysqli_real_escape_string($conn, $_POST['speech']);
    $sql = "UPDATE `facultymember` SET `FULLNAME` = '$name', `COURSE` = '$course', `BATCH` = '$batch', `ROLE` = '$role', `SPEECH` = '$speech' WHERE `ID` = '$id'";
    if(mysqli_query($conn, $sql)){
        $_SESSION['stat']="success";
        $_SESSION['message']="Faculty member updated successfully!";
        header('location: faculty.php?batch='.$batch);
    }else{
        $_SESSION['stat']="failed";
        $_SESSION['message']="Failed to update faculty member!";
        header('location: faculty.php?batch='.$batch);
    }
}

if(isset($_POST['deletefaculty'])){
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $batch = mysqli_real_escape_string($conn, $_POST['batch']);
    $sql = "DELETE FROM `facultymember` WHERE `ID` = '$id'";
    if(mysqli_query($conn, $sql)){
        $_SESSION['stat']="success";
        $_SESSION['message']="Faculty member deleted successfully!";
        header('location: faculty.php?batch='.$batch);
    }else{
        $_SESSION['stat']="failed";
        $_SESSION['message']="Failed to delete faculty member!";
        header('location: faculty.php?batch='.$batch);
    }
}
if(isset($_POST['savedoutstanding'])){
    $alumniid = mysqli_real_escape_string($conn, $_POST['alumniid']);
    $awards = mysqli_real_escape_string($conn, $_POST['awards']);
    $batch = mysqli_real_escape_string($conn, $_POST['batch']);
    $special = mysqli_real_escape_string($conn, $_POST['special']);
    $sql = "INSERT INTO `outstandingalumni`(`alumniid`, `achievementid`, `specialawards`, `batch`) VALUES ('$alumniid', '$awards', '$special', '$batch')";
    if(mysqli_query($conn, $sql)){
        $_SESSION['stat']="success";
        $_SESSION['message']="Outstanding Alumni added successfully!";
        header('location: outstanding.php?batch='.$batch);
    }else{
        $_SESSION['stat']="failed";
        $_SESSION['message']="Failed to add Outstanding Alumni!";
        header('location: outstanding.php?batch='.$batch);
    }
}
if(isset($_POST['deleteoutstanding'])){
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $batch = mysqli_real_escape_string($conn, $_POST['batch']);
    $sql = "DELETE FROM `outstandingalumni` WHERE `ID` = '$id'";
    if(mysqli_query($conn, $sql)){
        $_SESSION['stat']="success";
        $_SESSION['message']="Outstanding Alumni deleted successfully!";
        header('location: outstanding.php?batch='.$batch);
    }else{
        $_SESSION['stat']="failed";
        $_SESSION['message']="Failed to delete Outstanding Alumni!";
        header('location: outstanding.php?batch='.$batch);
    }
}
?>