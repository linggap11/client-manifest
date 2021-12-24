<?php 
    include('config/connection.php');
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND password = '$password' ");
    if (mysqli_num_rows($user) > 0) {
        while ($row = mysqli_fetch_assoc($user)) {
            $_SESSION['client_id'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['role'] = $row['role'];
        }
        
        if ($_SESSION['role'] == "superadmin") {
            header("Location: administrator");
        } else {
            header("Location: index.php");
        }
        
    } else {
        header("Location: login.php");
    }
?>