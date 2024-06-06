    <style>
        body {
      background-color: #f8f9fa; 
    }

    .container {
      margin-top: 50px;
    }

    .card {
      margin-bottom: 20px;
      
    }

    #productSalesChart {
      width: 100%; 
      height: 600px; 
      margin: auto;

    }
      </style>
    </head>
    <body>

      <div class="card">
        <div class="card-body">
          <canvas id="productSalesChart"></canvas>
        </div>
      </div>
      
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

      
      <?php
        
        $mysqli = new mysqli('localhost','root','','cafe_billing_db');

        
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Function to get data for all products
        function getAllProductData($mysqli) {
          $sql = "SELECT p.name AS name, DATE_FORMAT(o.date_created, '%Y-%m') AS order_date, COUNT(*) AS order_count
                  FROM orders o
                  JOIN order_items oi ON o.id = oi.order_id
                  JOIN products p ON oi.product_id = p.id
                  WHERE DATE_FORMAT(o.date_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')
                  GROUP BY name, DATE_FORMAT(o.date_created, '%Y-%m')
                  ORDER BY order_date, order_count DESC;";

          $result = $mysqli->query($sql);

          // Process 
          $productsData = [];
          $dates = [];
          while ($row = $result->fetch_assoc()) {
              $productName = $row['name'];
              $orderDate = $row['order_date'];
              $orderCount = $row['order_count'];
              
              // Add data 
              if (!isset($productsData[$productName])) {
                  $productsData[$productName] = [];
              }
              $productsData[$productName][$orderDate] = $orderCount;

              // Collect
              if (!in_array($orderDate, $dates)) {
                  $dates[] = $orderDate;
              }
          }

          return ['productsData' => $productsData, 'dates' => $dates];
        }

        // Get data for all products
        $allProductsData = getAllProductData($mysqli);
      ?>

      
      <script>
        Chart.register({
          id: 'labelBelowChartPlugin',
          afterDatasetsDraw: function(chart) {
            var ctx = chart.ctx;
            var datasets = chart.data.datasets;
            var labels = chart.data.labels;

            datasets.sort(function(a, b) {
              var aLastValue = a.data[a.data.length - 1];
              var bLastValue = b.data[b.data.length - 1];
              return bLastValue - aLastValue;
            });
            ctx.font = '12px Arial';
            ctx.textAlign = 'center';
            ctx.fillStyle = 'black';
            datasets.forEach(function(dataset, i) {
              var meta = chart.getDatasetMeta(i);
              var lastIndex = meta.data.length - 1;
              var lastValue = dataset.data[lastIndex];
              var label = (i + 1) + (i === 0 ? 'st' : (i === 1 ? 'nd' : (i === 2 ? 'rd' : 'th')));
              var offset = meta.data[lastIndex].x;
              ctx.fillText(label, offset, chart.height - 10);
            });
          }
        });

       
        var ctx = document.getElementById('productSalesChart').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: <?php echo json_encode(array_fill(0, count($allProductsData['dates']), '')); ?>,
            datasets: [
              <?php foreach ($allProductsData['productsData'] as $productName => $productData) { ?>
                {
                  label: '<?php echo $productName ?>',
                  data: <?php echo json_encode(array_values($productData)); ?>,
                  backgroundColor: 'rgba(<?php echo rand(0, 255) ?>, <?php echo rand(0, 255) ?>, <?php echo rand(0, 255) ?>, 0.5)', /* Random color */
                  borderColor: 'rgba(<?php echo rand(0, 255) ?>, <?php echo rand(0, 255) ?>, <?php echo rand(0, 255) ?>, 1)',
                  borderWidth: 1
                },
              <?php } ?>
            ]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  display: false 
                }
              }
            },
            plugins: {
              labelBelowChartPlugin: {
                
              }
            }
          }
        });
        
      </script>