<?php 
    include('../config/connection.php');
    
    $id = $_GET['id'];

    $sql = "DELETE FROM log_client WHERE id=".$id."";
    mysqli_query($conn, $sql);
    $clientTrans = "DELETE FROM client_transaction WHERE investment_id=".$id."";
    mysqli_query($conn, $clientTrans);
    $investmen = "DELETE FROM investment WHERE id=".$id."";
    mysqli_query($conn, $investmen);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>