<?php
include('db_connect.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];


    $order = $conn->query("SELECT * FROM orders WHERE id = $id")->fetch_assoc();

    $conn->query("DELETE FROM orders WHERE id = $id");

    $conn->query("INSERT INTO deleted_orders (date_deleted, ref_no, order_number, total_amount) 
                  VALUES (NOW(), '{$order['ref_no']}', '{$order['order_number']}', '{$order['total_amount']}')");
    
    echo 1; 
} else {
    echo 0;
}
?>
