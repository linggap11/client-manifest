<?php 
    include('config/connection.php');
    
    $trans = $_GET['trans'];

    $sql = "DELETE FROM transactions WHERE id=".$trans."";
    mysqli_query($conn, $sql);
    header("Location: data-master.php");
?>