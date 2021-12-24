<?php 
    include('../config/connection.php');

    $userId = $_POST['id'];
    $fullname = $_POST['fullname'];
    $company = $_POST['company'];
    $address = trim($_POST['address']);
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
   
    if (empty($newPassword)) {
        $user = mysqli_query($conn, "UPDATE user SET `fullname`='$fullname', `company`='$company', `address`='$address'  WHERE id='$userId' ");
        if (!$user) {
            echo "test ".mysqli_error($conn); 
        }
    } else {
        $user = mysqli_query($conn, "UPDATE user SET `fullname`='$fullname', `company`='$company', `address`='$address', `password`='$newPassword' WHERE id='$userId' ");
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);

?>