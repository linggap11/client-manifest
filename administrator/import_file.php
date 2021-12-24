<?php 
    include("../config/connection.php");

    require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
    require('spreadsheet-reader-master/SpreadsheetReader.php');
    session_start();

    $fileName = time().basename($_FILES['file']['name']);
    $target_dir = "uploads/".$fileName;
    $investmentDate = $_POST['date'];
    $client_id = $_POST['client'];
    $investmentDate = date('Y-m-d', strtotime($investmentDate));
   ;
    move_uploaded_file($_FILES['file']['tmp_name'],$target_dir);
    
    $reader = new SpreadsheetReader($target_dir);
    

    foreach ($reader as $key => $row) {
        if ($key == 1) {
            $inversment = str_replace('$', '', $row[5]);
           
            $saveInvers = mysqli_query($conn, "INSERT INTO investment (`client_id`, `cost`, `date`) VALUES('".$client_id."', '".$inversment."', '".$investmentDate."') " );
            $investId =  mysqli_insert_id($conn);
        }
        if ($key < 3) {
            continue;    
        } else {
            if (!empty($row[0])) {
                $retail = str_replace('$', '', $row[4]);
                $original = str_replace('$', '', $row[5]);
                $cost = str_replace('$', '', $row[6]);
                $query = mysqli_query($conn,"INSERT INTO `client_transaction` (`sku`, `item_description`, `cond`, `qty`, `retail_value`, `original_value`, `cost`, `vendor`, `client_id`, `investment_id`) 
                VALUES ('".$row[0]."', '".mysqli_real_escape_string($conn, $row[1])."','".$row[2]."','".$row[3]."','".$retail."','".$original."','".$cost."','".$row[7]."','".$client_id."', '".$investId."')" );
                if (!$query) {
                    echo "ERROR: ".mysqli_error($conn);
                }
                
            } elseif (!empty($row[1]))  {
                $shipping = mysqli_query($conn, "INSERT INTO `shipping` (`transaction_id`, `date`, `shipping_code`) VALUES ('1', '".date('Y-m-d', strtotime($row[7]))."', '".mysqli_real_escape_string($conn, $row[1])."')");
            } else {
                break;
            }
        }        
        
    }

    if (mysqli_query($conn, "INSERT INTO log_client(date, file, client_id, investment_id) VALUES(NOW(), '$fileName', '$client_id', '$investId')")) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        echo "Error : ".mysqli_error($conn);
    }

    
    
?>  