<?php 
    include ('../config/connection.php');
    $fullname = $_POST['fullname'];
    $company = $_POST['company'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['new_password'];

    if (mysqli_query($conn, "INSERT INTO user(fullname, company, address, username, password) VALUES('$fullname', '$company', '".mysqli_escape_string($conn, $address)."', '$username', '$password')")) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        echo "Error ".mysqli_error($conn);
        die();
    }

    
?>