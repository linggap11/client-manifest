<?php 
    include('../config/connection.php');
    
    $id = $_GET['id'];

    $sql = "DELETE FROM user WHERE id=".$id."";
    mysqli_query($conn, $sql);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>