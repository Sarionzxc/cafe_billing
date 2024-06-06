<?php
include './header.php';
include 'db_connect.php';

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query_order = "SELECT * FROM orders WHERE id = $order_id";
$result_order = mysqli_query($conn, $query_order);
$order = mysqli_fetch_assoc($result_order);



$query_items = "SELECT * FROM order_items WHERE order_id = $order_id";
$result_items = mysqli_query($conn, $query_items);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TLC Coffee Billing System</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
   body {
      background-image: url('assets/css/coffee.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 80vh; 
      margin: 0;
      color: white;
    }
    .content {
      text-align: center;
    }
    h1 {
      font-size: 48px; 
      margin-bottom: 20px;
    }
    h2 {
      font-size: 60px; 
    }
    .order-table {
      border-collapse: collapse;
      width: 100%;
      max-width: 600px;
      margin-top: 40px;
    }
    .order-table th, .order-table td {
      border: 1px solid white;
      padding: 12px; 
      text-align: center;
      font-size: 24px;
    }
    .order-table th {
      background-color: rgba(255, 255, 255, 0.3);
    }
    .action-button {
      margin-top: 50px;
      background-color: #6f4e37;
      color: white;
      border: none;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 20px;
      cursor: pointer;
      border-radius: 5px;
    }
    .action-button:hover {
      background-color: #C08B5C;
    }
    .loading-bar {
      width: 100%;
      height: 7px;
      background-color: #ccc;
      position: relative;
      display: none; 
      margin-top: 10px;
    }
    .progress-bar {
      width: 0;
      height: 100%;
      background-color: #6f4e37;
      position: absolute;
      top: 0;
      left: 0;
    }
  </style>
</head>
<body>
  <div class="content">
    <h2>Welcome to Kitchen</h2>
    <?php
    echo "<table class='order-table'>";
    echo "<tr><th colspan='2'>Order# " . $order['order_number'] . "</th></tr>";
    echo "<tr><th>Product</th><th>Quantity</th></tr>";
    while ($item = mysqli_fetch_assoc($result_items)) {
      echo "<tr>";
      // Product name
      $product_id = $item['product_id'];
      $query_product_name = "SELECT name FROM products WHERE id = $product_id";
      $result_product_name = mysqli_query($conn, $query_product_name);
      $product_name = mysqli_fetch_assoc($result_product_name)['name'];
      echo "<td>$product_name</td>";
      // Quantity column
      echo "<td>" . $item['qty'] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
    ?>
    <div class="loading-bar">
      <div class="progress-bar"></div>
    </div>
    <button class="action-button">Preparing Order</button>

  </div>
  
  <script>
    $(document).ready(function() {
      $(".action-button").click(function() {
        // Show the loading bar
        $(".loading-bar").show();
        
        // loading process from 1% to 120%
        var progress = 1;
        var interval = setInterval(function() {
          $(".progress-bar").css("width", progress + "%");
          if (progress >= 120) {
            clearInterval(interval);
            
            $(".loading-bar").hide();
             Swal.fire({
              icon: 'success',
              title: 'Sucess preparing order!',
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function() {
              window.location.href = 'index.php?page=orders';
            }, 1000);
          } else {
            progress++;
          }
        }, 40);
      });
    });
  </script>
</body>
</html>
